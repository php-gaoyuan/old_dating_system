<?php

namespace app\index\controller;

use app\index\controller\Base;

class Chat extends Base
{

    //获取最近聊天过的好友
    public function index()
    {
        return $this->fetch();
    }

    public function getData()
    {
        if (request()->isAjax()) {
            $uid = cookie("?user_id") ? cookie("user_id") : session("user_id");
            $list = model("Chat")->get_chats($uid);
            if (!empty($list)) {
                foreach ($list as $k => $vo) {
                    $count = db()->table("chat_log")->where(["fromid" => $vo["user_id"], "toid" => $uid, "is_read" => "0"])->fetchSql(0)->count();
                    //p($count);
                    $list[$k]["logMessageNums"] = $count;
                }
                return json($list);
            } else {
                return json([]);
            }
        }
    }


    //聊天界面
    public function chat()
    {
        $uid = cookie("?user_id") ? cookie("user_id") : session("user_id");
        $pals_id = input("pals_id");
        $pals_info = model("Users")->where("user_id", $pals_id)->field("user_id,user_name,user_ico")->find();
        $pals_info["user_ico"] = img_path($pals_info["user_ico"]);
        $this->assign("pals_userinfo", json_encode($pals_info));
        $msg_num = db()->table("chat_log")->where(['fromid' => $uid])->count();
        $this->assign("msg_num", $msg_num);
        return $this->fetch();
    }


    //聊天记录
    public function chat_log()
    {
        if (request()->isAjax()) {
            $user_id = cookie("user_id");
            $pals_id = input("pals_id");
            $where = " (fromid='$user_id' and toid='$pals_id') or (fromid='$pals_id' and toid='$user_id') ";
            $log_list = db()->table("chat_log")->where($where)->order("timeline desc")->select();

            $list = array();
            if (!empty($log_list)) {
                foreach ($log_list as $k => $vo) {
                    $from_userinfo = model("Users")->get_user_info(array("user_id" => $vo["fromid"]), array("user_name", "user_ico"));

                    $list[$k]["id"] = $vo["fromid"];
                    $list[$k]["username"] = $from_userinfo["user_name"];
                    $list[$k]["avatar"] = $from_userinfo["user_ico"];
                    $list[$k]["content"] = $vo["content"];
                    $list[$k]["timestamp"] = date("m-d H:i:s", $vo["timeline"]);

                }
            }
            return json(array(
                "code" => 0,
                "msg" => "",
                "data" => $list
            ));
        }

    }


    //返回用户信息
    public function userinfo()
    {
        $user_id = $this->userinfo["user_id"];
        $info = db("users")->field("user_id,user_name,user_ico,user_sex")->fetchSql(0)->find($user_id);
        if (empty($info["user_ico"])) {
            $info["user_ico"] = empty_userico($info["user_sex"]);
        }
        return json($info);
    }


}