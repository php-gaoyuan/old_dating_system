<?php

namespace app\index\controller;
class Upgrade extends Base
{
    public function index()
    {
        $to_user_id = input("to_user_id");
        if (empty($to_user_id)) {
            $to_user_id = cookie("user_id");
        }
        $this->assign("to_user_id", $to_user_id);
        return $this->fetch();
    }


    public function create_order()
    {
        $money = input("money");
        $this->assign("money", $money);
        $this->assign("upgrade_name", get_upgrader_name($money));
        //获得金币余额
        $uid = cookie("user_id");
        $balance = model("Users")->where(["user_id" => $uid])->value("golds");
        $this->assign("balance", $balance);
        return $this->fetch();

    }


    //创建充值记录
    public function create_pay()
    {

        $money = input("money");
        $to_user = input("to_user");
        $friend = input("friend");
        $pay_type = input("pay_type");

        if ($to_user == "2") {
            $fr_info = model("Users")->where("user_name", $friend)->field("user_id,user_name")->find();//获取朋友信息
            if (empty($to_user_info)) {
                return json(["msg" => lang("no friend"), "url" => url("upgrade/index")]);
            }
        }

        if ($pay_type == 'gold') {
            //检查余额是否够支付
            $is_can_pay = model("Users")->check_money($money);
            if (!$is_can_pay) {
                return json(["msg" => lang("need recharge"), "url" => url("recharge/index")]);
            }
        }

        switch ($money) {
            case '12':
                $day = 30;
                $groups = '2';
                break;
            case '30':
                $day = 90;
                $groups = '2';
                break;
            case '59':
                $day = 180;
                $groups = '2';
                break;
            case '108':
                $day = 360;
                $groups = '2';
                break;
            case '100':
                $day = 30;
                $groups = '3';
                break;
            case '288':
                $day = 90;
                $groups = '3';
                break;
            case '521':
                $day = 180;
                $groups = '3';
                break;
            case '999':
                $day = 360;
                $groups = '3';
                break;
        }


        $uid = cookie("user_id");
        $uname = cookie("user_name");


        //插入消费记录
        $ordernumber = 'S-P' . time() . mt_rand(100, 999);
        $log = [
            "type" => 2,
            "uid" => $uid,
            "uname" => $uname,
            "touid" => $uid,
            "touname" => cookie("user_name"),
            "message" => "会员自己升级消费",
            "funds" => $money,
            "ordernumber" => $ordernumber,
            "money" => $money,
            'pay_method' => $pay_type,
            'pay_from' => 'WAP',
            'day' => $day,
            'user_group' => $groups,
            "addtime" => date("Y-m-d H:i:s")
        ];
        if ($to_user == "1") {
            //给自己充值
            $log['touid'] = $uid;
            $log['touname'] = cookie("user_name");
            $log['message'] = "会员自己升级消费";
        } elseif ($to_user == "2") {
            //给别人充值
            $log['touid'] = $fr_info["user_id"];
            $log['touname'] = $fr_info["user_name"];
            $log['message'] = "{$uname}给{$fr_info['user_name']}升级,消费{$money}";
        }
        $res1 = model("Balance")->save($log);
        if ($pay_type == 'gold') {
            //扣除金币
            $res2 = model("Users")->where(["user_id" => $uid])->setDec("golds", $money);
            model("Balance")->where(['ordernumber' => $ordernumber])->update(['state' => 2]);
            //更新到期时间
            $res3 = model("UpgradeLog")->upgrade_change_date([
                'ordernumber' => $ordernumber,
                'err_msg' => '金条支付成功',
                'out_trade_no' => ""
            ]);
            if ($res1 && $res2 && $res3) {
                return json(["msg" => lang("ok"), "url" => url("index/index")]);
            } else {
                return json(["msg" => lang("fail"), "url" => url("upgrade/index")]);
            }
        }
        return json(["msg" => 'ok', "url" => url("payment/index", ['pay_type' => $pay_type, 'oid' => $ordernumber, 'am' => $money])]);
    }
}