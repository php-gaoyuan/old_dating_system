<?php

use \GatewayWorker\Lib\Gateway;
use \GatewayWorker\Lib\Db;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{
    public static function onWorkerStart()
    {
        //echo "worker start";
    }

    public static function onConnect($client_id)
    {
        //连接后通知所有用户在线
        //Gateway::sendToCurrentClient("Your client_id is $client_id");
    }

    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param mixed $message 具体消息
     */
    public static function onMessage($client_id, $data)
    {
        require_once(dirname(__FILE__) . "/Chat.php");
        require_once(dirname(__FILE__) . "/lib/transapi.php");
        $message = json_decode($data, true);
        $db1 = Db::instance('db1'); //数据库链接
        switch ($message['type']) {
            case 'init':
                $user_id = $message['id'];
                $from = isset($message["from"]) ? $message["from"] : "";
                // 设置session
                $_SESSION = ['user_id' => $user_id, 'username' => $message['username'], 'avatar' => $message['avatar'],"from"=>$from];
                // 将当前链接与uid绑定
                Gateway::bindUid($client_id, $user_id);
                //通知所有人该用户上线
                Gateway::sendToAll(json_encode([
                    'type' => 'init',
                    'id' => $user_id,
                ]));
                break;
            case "logMsg":
                $user_id = $message['user_id'];
                //查询有无需要推送的离线信息
                $log_msg = offline_message($db1, $user_id);
                //var_dump($log_msg);
                if ($log_msg !== false) {
                    Gateway::sendToUid($user_id, json_encode([
                        "type" => "logMsg",
                        "data" => $log_msg
                    ]));
                }
                break;
            case 'chatMsg':
                // 聊天消息
                $type = $message['to']['type'];
                $content = htmlspecialchars($message['mine']['content']);
                $fid = $message['to']['id'];
                //echo $fid;
                $user_id = $_SESSION["user_id"];
                $userinfo = get_user_info($db1, $user_id);
                //紅包金額
                if (strpos($content, "紅包金額") !== false) {
                    $tempCont = explode("：", $content);
                    $money = (float)$tempCont[1];
                    if (empty($money)) {
                        $tempCont = explode(":", $content);
                        $money = (float)$tempCont[1];
                    }
                    if ($money <= 0) {
                        Gateway::sendToUid($fid, json_encode([
                                'type' => 'chatMsg',
                                'data' => [
                                    'system' => true,
                                    'id' => $user_id,
                                    'type' => $type,
                                    'content' => '发送失败，請填寫大於0的金額！',
                                ]]
                        ));
                        return false;
                    }
                    $new_golds = $userinfo['golds'] - $money;
                    //检查余额
                    if ($new_golds < 0) {
                        Gateway::sendToUid($fid, json_encode([
                                'type' => 'chatMsg',
                                'data' => [
                                    'system' => true,
                                    'id' => $user_id,
                                    'type' => $type,
                                    'content' => '餘額不足，請充值！'
                                ]]
                        ));
                        return false;
                    }
                    //扣除余额
                    $db1->update('wy_users')->where("user_id='{$user_id}'")->cols(['golds' => $new_golds])->query();
                    //增加余额
                    $db1->query("UPDATE `wy_users` SET `golds`=`golds`+{$money} where `user_id`='{$fid}'");
                } else {
                    //判断聊天权限
                    $msg_num = $db1->select('count(*) as msg_num')->from('chat_log')->where("fromid= '{$user_id}' ")->single();
                    if ($userinfo['user_group'] < 2 && $msg_num >= 5) {
                        Gateway::sendToUid($user_id, json_encode([
                                'type' => 'chatMsg',
                                'opt' => 'msg_num',
                                'data' => [
                                    'system' => true,
                                    'id' => $user_id,
                                    'type' => $type,
                                    'content' => '無許可權；請升級！'
                                ]]
                        ));
                        return false;
                    }
                }


                $from = $_SESSION["from"];
                $tr_content = "";
                // if (strpos($content, "http") === false) {
                //     //翻译
                //     $tr_content = translate($content, "auto", "zh");
                //     $tr_content = isset($tr_content["trans_result"][0]["dst"]) ? $tr_content["trans_result"][0]["dst"] : $content;
                // }


                //聊天记录数组
                $param = [
                    'fromid' => $user_id,
                    'fromname' => $_SESSION['username'],
                    'fromavatar' => $_SESSION['avatar'],
                    'toid' => $fid,
                    'content' => $content,
                    'tr_content' => $tr_content,
                    'timeline' => time(),
                    'pcsend' => $from == "pc" ? 1 : 0,
                    'appsend' => $from == "app" ? 1 : 0,
                    'type' => "friend"
                ];
                // 插入
                $insert_id = $db1->insert('chat_log')->cols($param)->query();
                //如果是女号直接翻译成中文
                // $to_userinfo = get_user_info($db1, $to_id);
                // if ($to_userinfo["user_sex"] == "0" && !empty($tr_content)) {
                //     $content = "原文：" . $content . "\n\n译文：" . $tr_content;
                // }
                $chat_message = [
                    'type' => 'chatMsg',
                    'data' => [
                        'id' => $user_id,
                        'username' => $_SESSION['username'],
                        'avatar' => check_userico($_SESSION['avatar']),
                        'type' => $type,
                        'content' => $content,
                        'mine'=> false,
                        'timestamp' => time() * 1000
                    ]];
                Gateway::sendToUid($fid, json_encode($chat_message));

                //检查如果对方不是好友发送列表到陌生人
                $pals_info = $db1->select()->from("wy_pals_mine")->where("user_id='$user_id' and pals_id='$fid'")->row();
                if (empty($pals_info)) {
                    $finfo = $db1->select()->from("wy_users")->where("user_id='$fid'")->row();
                    echo $fid;
                    //推送陌生人到列表
                    $data = [
                        "type" => "addlist",
                        "data" => [
                            "id" => $finfo["uid"],
                            "username" => $finfo["u_name"],
                            "groupid" => 3,
                            "type" => "friend",
                            "avatar" => $finfo["u_ico"],
                            "sign" => ""
                        ]];
                    Gateway::sendToUid($user_id, json_encode($data));
                    return false;
                }
//                else {
//                    $data = [
//                        "type" => "addlist",
//                        "data" => [
//                            "id" => $info["pals_id"],
//                            "username" => $info["pals_name"],
//                            "groupid" => 2, "type" => "friend",
//                            "avatar" => $info["pals_ico"],
//                            "sign" => ""
//                        ]];
//                    //推送好友到列表
//                    Gateway::sendToUid($user_id, json_encode($data));
//                    Gateway::sendToUid($fid, json_encode($data));
//                    return false;
//                }
                break;
            case "readMsg":
                $user_id = $message["user_id"];
                $fid = $message["fid"];
                //更新消息为已读
                $db1->update("chat_log")->cols(["is_read" => "1"])->where("fromid='{$fid}' and toid='{$user_id}'")->query();
                break;
            case 'ping':
                $user_id = $message["user_id"];
                Gateway::sendToUid($user_id, json_encode([
                    "type"=>"heart",
                    "data"=>"ok"
                ]));
                return false;
            default:
                echo "unknown message $data" . PHP_EOL;
        }
    }

    /**
     * 当用户断开连接时触发
     * @param int $client_id 连接id
     */
    public static function onClose($client_id)
    {
//        $db1 = Db::instance('db1'); //数据库链接
//        $user_id = $_SESSION['user_id'];
//        $from = $_SESSION['from'];
//        $update_data = ["line_status" => 0];
//        if ($from) {
//            $update_data[$from . "_online"] = 0;
//        } else {
//            $update_data["pc_online"] = 0;
//            $update_data["app_online"] = 0;
//        }
//        //断开后通知所有用户该用户离线
//        $db1->update("chat_users")->cols($update_data)->where("uid='{$user_id}'")->query();
//        $logout_message = ["type" => "logout", "id" => $user_id];
//        Gateway::sendToAll(json_encode($logout_message));
    }

    public static function onWorkerStop()
    {
        echo "worker stop";
    }
}
