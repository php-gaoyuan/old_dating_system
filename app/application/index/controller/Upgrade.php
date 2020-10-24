<?php 
namespace app\index\controller;
use app\index\controller\Base;
class Upgrade extends Base
{
	public function index(){
		$to_user_id = input("to_user_id");
		if(empty($to_user_id)){
			$to_user_id = cookie("user_id");
		}
		$this->assign("to_user_id",$to_user_id);
		return $this->fetch();
	}


	public function create_order(){
		$money = input("money");
		$this->assign("money",$money);
		$this->assign("upgrade_name",get_upgrader_name($money));
		//获得金币余额
		$uid = cookie("user_id");
		$balance = model("Users")->where(["user_id"=>$uid])->value("golds");
		$this->assign("balance",$balance);
		return $this->fetch();
		
	}



	//创建充值记录病支付
	public function create_pay(){
		
		$money=input("money");
		$to_user=input("to_user");
		$friend=input("friend");
		$pay_type=input("pay_type");

		//检查余额是否够支付
		$is_can_pay = model("Users")->check_money($money);
		if(!$is_can_pay){
			return json(["msg"=>lang("need recharge"),"url"=>url("recharge/index")]);
		}

		if($to_user == "2"){
			$fr_info = model("Users")->where("user_name",$friend)->field("user_id,user_name")->find();//获取朋友信息
			if(empty($to_user_info)){
				return json(["msg"=>lang("no friend"),"url"=>url("upgrade/index")]);
			}
		}

		switch ($money) {
			case '30':
				$day = 30;
				$groups = '3';
				break;
			case '70':
				$day = 90;
				$groups = '3';
				break;
			case '110':
				$day = 180;
				$groups = '3';
				break;
			case '180':
				$day = 360;
				$groups = '3';
				break;
			case '199':
				$day = 3650;
				$groups = '4';
				break;
		}


		$uid = cookie("user_id");
		$uname = cookie("user_name");
		//扣除金币
		$res1 = model("Users")->where(["user_id"=>$uid])->setDec("golds",$money);

		//插入消费记录
		$to_user_id = input("to_user_id");
		if($res1){
			$ordernumber='S-P'.time().mt_rand(100,999);
			if($to_user == "1"){
				$touid = $uid;
				//给自己充值
				$log = [
					"type"=>2,
					"uid"=>$uid,
					"uname"=>$uname,
					"touid"=>$uid,
					"touname"=>cookie("user_name"),
					"message"=>"会员自己升级消费",
					"state"=>"2",
					"funds"=>$money,
					"ordernumber"=>$ordernumber,
					"money"=>$money,
					"addtime"=>date("Y-m-d H:i:s")
					];
			}elseif($to_user == "2"){
				//给别人充值
				$log = [
					"type"=>2,
					"uid"=>$uid,
					"uname"=>$uname,
					"touid"=>$fr_info["user_id"],
					"touname"=>$fr_info["user_name"],
					"message"=>"{$uname}给{$fr_info['user_name']}升级,消费{$money}",
					"state"=>"2",
					"funds"=>$money,
					"ordernumber"=>$ordernumber,
					"money"=>$money,
					"addtime"=>date("Y-m-d H:i:s")
					];
				$touid = $fr_info["user_id"];
			}
			$res2 = model("Balance")->save($log);
		}


		if($res2){
			//更新到期时间
			$res3 = model("UpgradeLog")->upgrade_change_date($touid, $day,$groups);
		}
			
		if($res1 && $res2 && $res3){
			return json(["msg"=>lang("ok"),"url"=>url("index/index")]);
		}else{
			return json(["msg"=>lang("fail"),"url"=>url("upgrade/index")]);
		}
		
	}
}