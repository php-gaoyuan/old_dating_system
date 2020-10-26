<?php 
namespace app\index\controller;
use app\index\controller\Base;
class Pals extends Base
{
	public function index(){
		return $this->fetch();
	}

	public function get_pals_data(){
		if(request()->isAjax()){
			$user_id = cookie("user_id");
			$list = model("PalsMine")->get_pals($user_id);
			return json($list);
		}
	}



	//搜索好友
	public function search(){
		if(request()->isAjax()){
			$user_id = cookie("user_id");
			$keyword = input("keyword");
			$list = model("PalsMine")->where(["pals_name"=>["like","%$keyword%"],"user_id"=>$user_id])->select();
			foreach ($list as $key => &$value) {
	    		$value["pals_ico"] = model("Users")->get_user_info(["user_id"=>$value['pals_id']],"user_ico");
	    	}
			return json($list);
		}
	}
}