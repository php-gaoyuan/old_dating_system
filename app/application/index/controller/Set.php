<?php 
//心情动态
namespace app\index\controller;
use app\index\controller\Base;
use think\Db;
class Set extends Base
{
	public function index(){
		return $this->fetch();
			
	}

	//密码设置
	public function pass(){
		if(request()->isAjax()){
			$old_pass = input("old_pass");
			$new_pass = input("new_pass");
			$new_pass_confirm = input("new_pass_confirm");
			if(empty($old_pass) || empty($new_pass) || empty($new_pass_confirm)){
				return json(["msg"=>"有必填项为空"]);
			}

			if($new_pass != $new_pass_confirm){
				return json(["msg"=>"两次密码不一致"]);
			}

			$userinfo = model("Users")->find($this->userinfo->user_id);
			//halt($userinfo["user_pws"]);
			if(md5($old_pass) != $userinfo["user_pws"]){
				return json(["msg"=>"密码错误"]);
			}

			//开始更新密码
			$res = model("Users")->fetchSql(0)->where("user_id",$this->userinfo->user_id)->update(["user_pws"=>md5($new_pass)]);
			
			if($res){
				return json(["msg"=>"操作成功"]);
			}
			return json(["msg"=>"操作失败"]);
		}else{
			return $this->fetch();
		}
		
	}

	//语言设置
	public function lang(){
		return $this->fetch();
	}

	//关于app
	public function about(){
		return $this->fetch();
	}
}