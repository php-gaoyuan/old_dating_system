<?php 
namespace app\index\controller;
use app\index\controller\Base;
class Gift extends Base
{
	public function index(){
		//读取收到的礼物
		$accept_list = db()->table("gift_order o")->join("wy_users u","o.send_id=u.user_id")->where("o.accept_id",$this->userinfo["user_id"])->order("o.send_time desc,o.is_see desc")->field("o.*,u.user_name,u.user_sex,u.user_ico")->select();
		foreach ($accept_list as $key => &$value) {
			$value["gift"] = config("webconfig.pc_url").($value["gift"]);
			$value["user_ico"] = img_path($value["user_ico"],$value["user_sex"]);
		}
		//halt($accept_list);
		$this->assign("accept_list",$accept_list);
		//读取送出的礼物
		$send_list = db()->table("gift_order o")->join("wy_users u","o.accept_id=u.user_id")->where("o.send_id",$this->userinfo["user_id"])->order("o.send_time desc,o.is_see desc")->field("o.*,u.user_name,u.user_sex,u.user_ico")->select();
		foreach ($send_list as $key => &$value) {
			$value["gift"] = config("webconfig.pc_url").($value["gift"]);
			$value["user_ico"] = img_path($value["user_ico"],$value["user_sex"]);
		}
		$this->assign("send_list",$send_list);
		return $this->fetch();
	}
}