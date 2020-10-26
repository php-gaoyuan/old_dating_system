<?php 
namespace app\index\controller;
use app\index\controller\Base;
class Mall extends Base
{
	public function index(){
		//获取普通礼物
		$model = model("Gift");
		$putong_list = $model->get_list(2);
		$this->assign("putong_list",$putong_list);
		$gaoji_list = $model->get_list(3);
		$this->assign("gaoji_list",$gaoji_list);
		$zhenshi_list = $model->get_list(4);
		$this->assign("zhenshi_list",$zhenshi_list);
		return $this->fetch();
	}



	public function detail($id){
		$model = model("Gift");
		$info = $model->get_info($id);
		$this->assign("info",$info);
		return $this->fetch();
	}


	public function pay($id){
		$model = model("Gift");
		$info = $model->get_info($id);
		$this->assign("info",$info);
		return $this->fetch();
	}

	public function sub_pay($id){
		$to_user = input("to_user");
		$friend_name = addslashes(input("friend_name"));
		$note = input("note");
		$pay_type = input("pay_type");

		$model = model("Gift");
		$info = $model->find($id);
		$imgs = explode("|", $info["yuanpatch"]);
		$gift_img = $imgs[0];
		$userinfo = db("users")->field("user_id,user_name,golds")->find($this->userinfo["user_id"]);
		//halt($userinfo);
		if($info["money"] > $userinfo["golds"]){
			return json(["msg"=>lang("need recharge"),"url"=>url("recharge/index")]);
		}

		//获取接受者信息
		$accept_id = "";
		$accept_name = "";
		if($to_user == "1"){
			$accept_id = $this->userinfo["user_id"];
			$accept_name = $this->userinfo["user_name"];
		}else if($to_user == "2"){
			$accept_info = model("Users")->where("user_name",$friend_name)->find();
			if(empty($accept_info)){
				return json(["msg"=>lang("no friend")]);
			}else{
				$accept_id = $accept_info["user_id"];
				$accept_name = $accept_info["user_name"];
			}

		}

		//开始入库
		$insert_data = [
			"send_id"=>$userinfo["user_id"],
			"send_name"=>$userinfo["user_name"],
			"accept_id"=>$accept_id,
			"accept_name"=>$accept_name,
			"msg"=>$note,
			"gift"=>$gift_img,
			"gifttype"=>$info["typeid"],
			"is_see"=>"0",
			"send_time"=>date('Y-m-d H:i:s',time()),
			"accept_address"=>"",
		];
		//halt($insert_data);
		$res = db()->table("gift_order")->insert($insert_data);
		if($res){
			//扣款添加消费记录
			$koukuan_res = model("Users")->where("user_id",$userinfo["user_id"])->setDec("golds",$info["money"]);
			//写入消费记录
			$ordernumber='N-P'.time().mt_rand(100,999);
			$log_data = [
				"type"=>"4",
				"uid"=>$userinfo["user_id"],
				"uname"=>$userinfo["user_name"],
				"touid"=>$accept_id,
				"touname"=>$accept_name,
				"message"=>"送禮物，價格：".$info["money"],
				"addtime"=>date('Y-m-d H:i:s',time()),
				"state"=>"2",
				"funds"=>$info["money"],
				"ordernumber"=>$ordernumber,
			];
			db("balance")->insert($log_data);
			return json(["msg"=>lang("ok"),"url"=>url("main/index")]);
		}else{
			return json(["msg"=>lang("fail"),"url"=>url("main/index")]);
		}
	}




	
}