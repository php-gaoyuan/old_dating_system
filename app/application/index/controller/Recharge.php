<?php
namespace app\index\controller;
use app\index\controller\Base;
class Recharge extends Base {
    public function index() {
    	//查询上次支付的用户信息
    	$uid = cookie("user_id");
    	$pay_userinfo = model("Balance")->where(['uid'=>$uid,'pay_userinfo'=>['neq','']])->order("addtime desc")->value('pay_userinfo');
    	$pay_userinfo = unserialize($pay_userinfo);
    	if(!empty($pay_userinfo)){
    		unset($pay_userinfo['card_number']);
	    	unset($pay_userinfo['exp_year']);
	    	unset($pay_userinfo['exp_month']);
	    	unset($pay_userinfo['cvv']);
    	}else{
    		$pay_userinfo=[
    			'country'=>'',
    			'province'=>'',
    			'city'=>'',
    			'address'=>'',
    			'email'=>'',
    			'telephone'=>'',
    			'post'=>'',
    			'name'=>''
    		];
    	}
    	$this->assign("pay_userinfo", $pay_userinfo);
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
            if (empty($money)) {
                $money = $select_money;
            }
            $uid = cookie("user_id");
            $uname = cookie("user_name");
            //insert into wy_balance set type='1',uid='695',uname='chuyang',touid='695',touname='chuyang',message='给自己充值100金币',state='0',addtime='2018-02-12 23:31:51',funds='100',ordernumber='S-P1518449511455',money='100'
            if ($money > 0) {
                $ordernumber = 'S-P' . time() . mt_rand(100, 999);
                if ($to_user == "1") { //给自己充值
                    $data = ["type" => 1, "uid" => $uid, "uname" => $uname, "touid" => $uid, "touname" => $uname, "message" => "给自己充值{$money}金币", "state" => 0, "funds" => $money, "ordernumber" => $ordernumber, "money" => $money, "addtime" => date("Y-m-d H:i:s") ];
                } elseif ($to_user == "2") { //给其他人充值
                    $to_user_info = model("Users")->where(["user_name" => $friend])->field("user_id,user_name")->find();
                    if (empty($to_user_info)) {
                        echo "<script>alert('没有找到充值对象');window.history.back();</script>";
                        exit;
                    }
                    $data = ["type" => 1, "uid" => $uid, "uname" => $uname, "touid" => $to_user_info["user_id"], "touname" => $to_user_info["user_name"], "message" => "给{$to_user_info["user_name"]}充值{$money}金币", "state" => 0, "funds" => $money, "ordernumber" => $ordernumber, "money" => $money, "addtime" => date("Y-m-d H:i:s") ];
                }
                $pay_way = input("pay_way");
                if ($pay_way == "cropay") {
                    $data["card_number"] = input("card_number");
                    $data["cvv"] = input("cvv");
                    $data["exp_date"] = input("exp_year") . input("exp_month");

                    //存入用户上次支付信息
                    $cropay_data['card_number']=input('post.card_number','','htmlspecialchars,trim');
                    $cropay_data['cvv']=input('post.cvv','','htmlspecialchars,trim');
                    $cropay_data['exp_year']=input('post.exp_year','','htmlspecialchars,trim');
                    $cropay_data['exp_month']=input('post.exp_month','','htmlspecialchars,trim');
                    $cropay_data['name']=input('post.name','','htmlspecialchars,trim');
                    $cropay_data['country']=input('post.country','','htmlspecialchars,trim');
                    $cropay_data['province']=input('post.province','','htmlspecialchars,trim');
                    $cropay_data['city']=input('post.city','','htmlspecialchars,trim');
                    $cropay_data['address']=input('post.address','','htmlspecialchars,trim');
                    $cropay_data['email']=input('post.email','','htmlspecialchars,trim');
                    $cropay_data['telephone']=input('post.telephone','','htmlspecialchars,trim');
                    $cropay_data['post']=input('post.post','','htmlspecialchars,trim');
                    foreach ($cropay_data as $k => $val) {
                    	if(empty($val)){
                    		echo "<script>alert('".$k."必须');history.back();</script>";exit;
                    	}
                    }
                    $data['pay_userinfo'] = serialize($cropay_data);
                }
                $res = model("Balance")->save($data);
                if ($res) {
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
                        echo $str;
                    } elseif ($pay_way == "cropay") {
                        $cropay = new \payment\Cropay;
                        $order = $cropay_data;
                        $order['order_sn'] = $ordernumber;
                        $order['user_id'] = $uid;
                        $order['amount'] = $data['money'];
                        //halt($order);
                        $pay_res = $cropay->pay($order);
                        //halt($pay_res);
                        if ($pay_res["errno"]==1) {
                            echo "<script>alert('" . lang("pay_error") . "：" . $pay_res["msg"] . "');window.history.back();</script>";
                            exit;
                        }elseif ($pay_res["errno"]==2) {
                        	if(!empty($pay_res["payment_url"])){
                        		header("location:".$pay_res["payment_url"]);exit;
							}else{
								echo "<script>alert('" . $pay_res["Payment Url is Null"] . "');window.history.back();</script>";
								exit;
							}
						} else {
                            //更改订单状态
                            $row = model("Balance")->where(["ordernumber" => $pay_res['orderNo']])->find();
                            if ($row['state'] == '2' || $row['state'] == 2) {
                                echo "<script>alert('" . lang("pay_success") . "');window.history.back();</script>";
                                exit;
                            }
                            if ($pay_res['amount'] != $row['funds']) {
                                echo "<script>alert('" . lang("pay_error") . "');window.history.back();</script>";
                                exit;
                            }
                            if ($row['state'] != '2') {
                                //先更新状态
                                $res = model("Balance")->where(["ordernumber" => $pay_res['orderNo']])->update(["state" => 2]);
                                if ($res) {
                                    //添加金币
                                    if (empty($row['touid'])) {
                                        model("Users")->where(["user_id" => $row["uid"]])->setInc("golds", $row["funds"]);
                                        //$sql = "UPDATE wy_users SET golds=golds+{$row['funds']} WHERE user_id='{$row[uid]}'";
                                        
                                    } else {
                                        model("Users")->where(["user_id" => $row["touid"]])->setInc("golds", $row["funds"]);
                                        //$sql = "UPDATE wy_users SET golds=golds+{$row['funds']} WHERE user_id='{$row[touid]}'";
                                        
                                    }
                                    echo "<script>alert('" . lang("pay_success") . "');window.location.href='/'</script>";
                                    exit;
                                } else {
                                    echo "<script>alert('" . lang("pay_error") . "');window.history.go(-1);</script>";
                                    exit;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
