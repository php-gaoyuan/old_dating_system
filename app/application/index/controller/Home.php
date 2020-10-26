<?php 
namespace app\index\controller;
use app\index\controller\Base;
class Home extends Base
{
	public function index(){
		$uid = input("uid");
		$this->assign("uid",$uid);
		$userinfo = model("Users")->field("user_id,user_name,user_sex,user_ico,birth_year,birth_month,birth_day,country,waimao,sexual,height,weight,income,gerenjieshao")->find($uid);
		$userinfo["user_ico"] = img_path($userinfo["user_ico"]);
		$this->assign("userinfo",$userinfo);

		//读取相册信息
		$album_list = db("album")->where(["user_id"=>$uid])->order("add_time")->select();
		//halt($album_list);
		$this->assign("album_list", $album_list);
		return $this->fetch();
	}


	//获取心情
	public function mood(){
		$uid = input("uid");
		$page = input("page");
		$size = 5;

		$model = model("RecentAffair");
		$count = $model->where(["user_id"=>$uid])->count();
		$pages = ceil($count/$size);
		$list = $model->where(["user_id"=>$uid])->order("id desc")->page($page,$size)->select();
		foreach ($list as $key => &$value) {
			$userinfo = model("Users")->field("user_ico,user_sex")->find($value["user_id"]);
            $value["user_ico"] = img_path($userinfo["user_ico"], $userinfo["user_sex"]);
            $value["time_ago"] = time_ago(strtotime($value["update_time"]));
        }
		return json(["list"=>$list,"pages"=>$pages]);
	}


	//查看相册
	public function photos(){
		$uid = cookie("user_id");
		$album_id = input("album_id");
		$album_info = db("album")->where(["album_id"=>$album_id])->find();
		if($album_info["privacy"] == "!all"){
			echo "<script>alert('No Auth');history.back();</script>";exit;
		}else{
			if(!empty($album_info["privacy"]) && strpos($album_info["privacy"],",".$uid.",") === false ){
				echo "<script>alert('No Auth');history.back();</script>";exit;
			}
		}
		//查本相册照片
		$photo_list = db("photo")->where(["album_id"=>$album_id])->select();
		//halt($photo_list);
		$this->assign("photo_list", $photo_list);
		return $this->fetch();
	}
}