<?php 
namespace app\index\controller;
use app\index\controller\Base;
class User extends Base
{
	public function index(){
		if(request()->isAjax()){
			
		}else{
			$userinfo = model("Users")->get_user_info(["user_id"=>$this->userinfo['user_id']]);
			$this->assign("userinfo",$userinfo);
			return $this->fetch();
		}
	}


	
}