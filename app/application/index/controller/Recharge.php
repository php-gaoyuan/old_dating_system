<?php
namespace app\index\controller;
use app\index\controller\Base;
class Recharge extends Base {
    public function index() {
        return $this->fetch();
    }
    //创建充值订单
    public function create_pay() {
        if (request()->isPost()) {
            //halt(input("post.exp_date"));
            $money = input("money"); //用户输入的金额
            $to_user = input("to_user");
            $friend = input("friend");
            $select_money = input("select_money"); //用户选择的金额
            $pay_way = input("pay_way");
            if (empty($money)) {
                $money = $select_money;
            }
            $uid = cookie("user_id");
            $uname = cookie("user_name");
            //insert into wy_balance set type='1',uid='695',uname='chuyang',touid='695',touname='chuyang',message='给自己充值100金币',state='0',addtime='2018-02-12 23:31:51',funds='100',ordernumber='S-P1518449511455',money='100'
            if ($money > 0) {
                $ordernumber = 'S-P' . time() . mt_rand(100, 999);
                if ($to_user == "1") { //给自己充值
                    $data = ["type" => 1, "uid" => $uid, "uname" => $uname, "touid" => $uid, "touname" => $uname, "message" => "给自己充值{$money}金币", "state" => 0, "funds" => $money, "ordernumber" => $ordernumber, "money" => $money, "addtime" => date("Y-m-d H:i:s"),'pay_method'=>$pay_way, 'pay_from'=>'WAP' ];
                } elseif ($to_user == "2") { //给其他人充值
                    $to_user_info = model("Users")->where(["user_name" => $friend])->field("user_id,user_name")->find();
                    if (empty($to_user_info)) {
                        echo "<script>alert('没有找到充值对象');window.history.back();</script>";
                        exit;
                    }
                    $data = ["type" => 1, "uid" => $uid, "uname" => $uname, "touid" => $to_user_info["user_id"], "touname" => $to_user_info["user_name"], "message" => "给{$to_user_info["user_name"]}充值{$money}金币", "state" => 0, "funds" => $money, "ordernumber" => $ordernumber, "money" => $money, "addtime" => date("Y-m-d H:i:s"),'pay_method'=>$pay_way, 'pay_from'=>'WAP' ];
                }

                $res = model("Balance")->save($data);
                if ($pay_way == "paypal") {
                    //开始paypal充值
                    $account = config("webconfig.paypal_account");
                    $base_url = 'http://' . $_SERVER['HTTP_HOST'];
                    $notify_url = urlencode(url("Payment/notityUrl", ["code" => "paypal"], true, true));
                    $return_url = urlencode(url("Payment/returnUrl", ["code" => "paypal"], true, true));
                    $cancel_return = urlencode(url("Main/index", [], true, true));
                    $str = "<script language='javascript'>";
                    $str.= "window.parent.location='https://www.paypal.com/cgi-bin/webscr?cmd=_xclick";
                    $str.= "&business=$account"; //paypal账号
                    $str.= "&amount=$money"; //支付费用
                    $str.= "&item_name=Goldrecharge";
                    $str.= "&currency_code=USD";
                    $str.= "&custom=recharge"; //自定义数据
                    $str.= "&item_number=$ordernumber"; //订单号
                    $str.= "&charset=utf-8";
                    $str.= "&no_note=1";
                    $str.= "&notify_url=$notify_url"; //通知地址
                    $str.= "&return=$return_url"; //返回地址
                    $str.= "&cancel_return=$cancel_return';"; //取消地址
                    $str.= "</script>";
                    //file_put_contents("paypal_str.txt", var_export($str,1)."\n\n",FILE_APPEND);
                    return $str;
                }
                $this->assign("order",["pay_type"=>$pay_way,"oid"=>$ordernumber,"am"=>$money]);
                return $this->fetch("payment/{$pay_way}");
            }
        }
    }
}
