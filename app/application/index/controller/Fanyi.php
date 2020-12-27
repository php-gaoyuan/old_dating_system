<?php
namespace app\index\controller;
use think\Controller;
class Fanyi extends Controller
{
	public function index(){
		$uid = cookie("user_id");
		$pals_id = input("pals_id");
		if(empty($pals_id)){$pals_id=$uid;}
		$txt = input("txt");
		$lang = input("lang");
		$userinfo = model("users")->field("user_id,user_name,user_sex,golds")->find($uid);
		$to_userinfo = model("users")->field("user_id,user_name")->find($pals_id);
		
		
// 		if($userinfo->user_sex == "1"){
// 			if($userinfo->golds < 1){
// 				return json(["code"=>"1","msg"=>"余额不足"]);
// 			}
			
// 			//扣金币
// 			$res = model("users")->where("user_id='$uid'")->setDec("golds",1);
// 			if($res){
// 				$ordernumber="FY".time().mt_rand(100,999);
// 				$insert_data = [
// 					"type"=>"5",
// 					"uid"=>$userinfo->user_id,
// 					"uname"=>$userinfo->user_name,
// 					"touid"=>$to_userinfo->user_id,
// 					"touname"=>$to_userinfo->user_name,
// 					"message"=>$userinfo->user_name.' => '.$to_userinfo->user_name.'翻译花费1',
// 					"state"=>"2",
// 					"addtime"=>date('Y-m-d H:i:s'),
// 					"funds"=>"1",
// 					"ordernumber"=>$ordernumber,
// 					];
// 				//halt($insert_data);
// 				db("balance")->insert($insert_data);
// 			}
// 		}

		require("transapi.php");
		$tr_txt = translate($txt,"auto",$lang);
		$tr_txt = $tr_txt["trans_result"][0]['dst'];

		return json(["code"=>"0","msg"=>$tr_txt]);
	}
}