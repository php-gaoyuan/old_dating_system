<?php 
namespace app\index\controller;
use app\index\controller\Base;
class Search extends Base
{
	public function index(){
		if(request()->isAjax()){
			$keyword = input("keyword");
			if(empty($keyword)){
				return false;
			}
			$user_sex = $this->userinfo['user_sex']==1?0:1;
			$list = model("Users")->where([
			    "user_name"=>["like","%$keyword%"],
			    "user_name"=>$user_sex
			    ])->field("user_id,user_ico,user_sex,user_name")->select();
			foreach ($list as $key => &$value) {
	            $value["user_ico"] = img_path($value["user_ico"]);
	        }
	        return json($list);
		}else{
			return $this->fetch();
		}
	}
}