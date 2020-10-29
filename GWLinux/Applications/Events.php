<?php
use \GatewayWorker\Lib\Gateway;
use \GatewayWorker\Lib\Db;
/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events {
    public static function onWorkerStart() {
        //echo "worker start";
    }
    public static function onConnect() {
        //连接后通知所有用户在线
    }
    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param mixed $message 具体消息
     */
    public static function onMessage($client_id, $data) {
        require_once (dirname(__FILE__) . "/Chat.php");
        require_once (dirname(__FILE__) . "/lib/transapi.php");
        $message = json_decode($data, true);
        $message_type = $message['type'];
        $db1 = Db::instance('db1'); //数据库链接
        switch ($message_type) {
            case 'init':
                $uid = $message['id'];
                $from = isset($message["from"]) ? $message["from"] : "";
                // 设置session
                $_SESSION = ['id' => $uid, 'username' => $message['username'], 'avatar' => $message['avatar'], 'sign' => $message['sign']];
                // 将当前链接与uid绑定
                Gateway::bindUid($client_id, $uid);
                //添加最近聊天记录
                //imUpdateContactedUser($db1,$uid,$pals_id);
                //更新好友在线
                //$update_data=["line_status"=>1,$from."_online"=>1];
                //$db1->update("chat_users")->cols($update_data)->where("uid='$uid'")->query();
                //查询有无需要推送的离线信息
                $resMsg = offline_message($db1, $uid);
                if (!empty($resMsg)) {
                    foreach ($resMsg as $key => $vo) {
                        $content = htmlspecialchars($vo['content']);
                        $to_userinfo = get_user_info($db1, $vo["toid"]);
                        if ($to_userinfo["user_sex"] == "0" && (strpos($content, "http") === false)) {
                            $tr_content = translate($content, "auto", "zh");
                            $tr_content = $tr_content["trans_result"][0]["dst"];
                            $content = "原文：" . $content . "\n\n译文：" . $tr_content;
                        }
                        $log_message = ['message_type' => 'logMessage', 'data' => ['id' => (int)$vo['fromid'], 'logid'=>(string)$vo['id'], 'username' => $vo['fromname'], 'avatar' => check_userico($vo['fromavatar']), 'content' => $content, 'type' => 'friend', 'timestamp' => $vo['timeline'] * 1000, ]];
                        //echo json_encode($log_message),"\n";
                        Gateway::sendToUid($uid, json_encode($log_message));
                    }
                }
                //通知所有人该用户上线
                $init_message = array('message_type' => 'init', 'id' => $uid, 'nums' => count($resMsg));
                unset($resMsg);
                Gateway::sendToAll(json_encode($init_message));
                if ($from == "app") {
                    $pals_id = isset($message["pals_id"]) ? $message["pals_id"] : "";
                    //更新聊天记录为已读
                    if(!empty($pals_id))$db1->update("chat_log")->cols(["is_read" => "1"])->where("fromid='{$pals_id}' and toid='{$uid}'")->query();
                }
            break;
            case 'chatMessage':
                // 聊天消息
                $type = $message['data']['to']['type'];
                $content = htmlspecialchars($message['data']['mine']['content']);
                $to_id = $message['data']['to']['id'];
                $uid = $_SESSION["id"];
                $userinfo = get_user_info($db1, $uid);
                //紅包金額
                if(strpos($content, "紅包金額") !== false){
                    $tempCont = explode("：", $content);
                    $money = (float)$tempCont[1];
                    if(empty($money)){
                        $tempCont = explode(":", $content);
                        $money = (float)$tempCont[1];
                    }
                    if($money<=0){
                        Gateway::sendToUid($to_id, json_encode(
                            ['message_type' => 'chatMessage', 'data' => ['system'=>true, 'id' => (int)$uid, 'username' => $_SESSION['username'], 'avatar' => check_userico($_SESSION['avatar']), 'type' => $type, 'content' => '发送失败，請填寫大於0的金額！', 'timestamp' => time() * 1000]]
                        ));
                        return false;
                    }
                    $new_golds = $userinfo['golds']-$money;
                    //检查余额
                    if($new_golds<0){
                        Gateway::sendToUid($to_id, json_encode(
                            ['message_type' => 'chatMessage', 'data' => ['system'=>true, 'id' => (int)$uid, 'username' => $_SESSION['username'], 'avatar' => check_userico($_SESSION['avatar']), 'type' => $type, 'content' => '餘額不足，請充值！', 'timestamp' => time() * 1000]]
                        ));
                        return false;
                    }
                    
                    //扣除余额
                    $db1->update('wy_users')->where("user_id='{$uid}'")->cols(['golds'=>$new_golds])->query();
                    //增加余额
                    $db1->query("UPDATE `wy_users` SET `golds`=`golds`+{$money} where `user_id`='{$to_id}'");
                }else{
                    //判断聊天权限
                    if($userinfo['user_group']<3){
                        Gateway::sendToUid($to_id, json_encode(
                            ['message_type' => 'chatMessage', 'data' => ['system'=>true, 'id' => (int)$uid, 'username' => $_SESSION['username'], 'avatar' => check_userico($_SESSION['avatar']), 'type' => $type, 'content' => '無許可權；請升級！', 'timestamp' => time() * 1000]]
                        ));
                        return false;
                    }
                }
                




                //$from = $_SESSION["from"];
                $tr_content = "";
                if (strpos($content, "http") === false) {
                    //翻译
                    $tr_content = translate($content, "auto", "zh");
                    $tr_content = isset($tr_content["trans_result"][0]["dst"]) ? $tr_content["trans_result"][0]["dst"] : $content;
                }


                //聊天记录数组
                $param = ['fromid' => $uid, 'toid' => $to_id, 'fromname' => $_SESSION['username'], 'fromavatar' => $_SESSION['avatar'], 'content' => $content, 'tr_content' => $tr_content, 'timeline' => time(), 'pcsend' => 1, 'appsend' => 1, 'type' => "friend", ];
                // 插入
                $insert_id=$db1->insert('chat_log')->cols($param)->query();
                //如果是女号直接翻译成中文
                $to_userinfo = get_user_info($db1, $to_id);
                if ($to_userinfo["user_sex"] == "0" && !empty($tr_content)) {
                    $content = "原文：" . $content . "\n\n译文：" . $tr_content;
                }


                $chat_message = ['message_type' => 'chatMessage', 'data' => ['id' => (int)$uid, 'logid'=>$insert_id, 'username' => $_SESSION['username'], 'avatar' => check_userico($_SESSION['avatar']), 'type' => $type, 'content' => $content, 'timestamp' => time() * 1000, ]];
                Gateway::sendToUid($to_id, json_encode($chat_message));

                //如果对方在线，更新消息为已读
                if (Gateway::isUidOnline($to_id)) {
                    //$db1->update("chat_log")->cols(["is_read" => "1"])->where("fromid='{$to_id}' and toid='{$uid}'")->query();
                    //$db1->update("chat_log")->cols(["is_read" => "1"])->where("id='{$insert_id}'")->query();
                }


                //检查如果对方不是好友发送列表到陌生人
                $info = $db1->select()->from("wy_pals_mine")->where("user_id='$uid' and pals_id='$to_id'")->row();
                if (empty($info)) {
                    $info = $db1->select()->from("chat_users")->where("uid='$to_id'")->row();
                    //推送陌生人到列表
                    $data = ["message_type" => "addlist", "data" => ["id" => $info["uid"], "username" => $info["u_name"], "groupid" => 3, "type" => "friend", "avatar" => $info["u_ico"], "sign" => $info["u_intro"], ]];
                    Gateway::sendToUid($uid, json_encode($data));
                    return false;
                } else {
                    $data = ["message_type" => "addlist", "data" => ["id" => $info["pals_id"], "username" => $info["pals_name"], "groupid" => 2, "type" => "friend", "avatar" => $info["pals_ico"], "sign" => "", ]];
                    //推送好友到列表
                    Gateway::sendToUid($uid, json_encode($data));
                    Gateway::sendToUid($to_id, json_encode($data));
                    return false;
                }
            break;
            case "changeMessage":
                $uid = $_SESSION["id"];
                $pals_id = $message["pals_id"];
                //设置推送状态为已经推送
                $db1->update("chat_log")->cols(["is_read" => "1"])->where("fromid='{$pals_id}' and toid='{$uid}'")->query();
            break;
            case 'ping':
                //!Gateway::isOnline($client_id)//更新用户不在线了
                return;
            default:
                echo "unknown message $data" . PHP_EOL;
        }
    }
    /**
     * 当用户断开连接时触发
     * @param int $client_id 连接id
     */
    public static function onClose($client_id) {
        // $db1 = Db::instance('db1'); //数据库链接
        // $uid = $_SESSION['id'];
        // //$from = $_SESSION['from'];
        // $update_data = ["line_status" => 0];
        // if ($from) {
        //     $update_data[$from . "_online"] = 0;
        // } else {
        //     $update_data["pc_online"] = 0;
        //     $update_data["app_online"] = 0;
        // }
        // //断开后通知所有用户该用户离线
        // $db1->update("chat_users")->cols($update_data)->where("uid='{$uid}'")->query();
        // $logout_message = ["message_type" => "logout", "id" => $uid];
        // Gateway::sendToAll(json_encode($logout_message));
    }
    public static function onWorkerStop() {
        //echo "worker stop";
    }
}
