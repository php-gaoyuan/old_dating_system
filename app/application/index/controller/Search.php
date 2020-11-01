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


			$list = model("Users")->where(["user_name"=>["like","%$keyword%"]])->field("user_id,user_ico,user_sex,user_name")->select();
			foreach ($list as $key => &$value) {
	            $value["user_ico"] = img_path($value["user_ico"]);
	        }
	        return json($list);
		}else{
			return $this->fetch();
		}
	}
}