<?php 
namespace app\index\controller;
use app\index\controller\Base;
class Album extends Base
{
	public function index(){
		if(request()->isAjax()){
			
		}else{
			$uid = cookie("user_id");
			$this->assign("uid",$uid);
			$userinfo = model("Users")->field("user_id,user_name,user_sex,user_ico,birth_year,birth_month,birth_day,country,waimao,sexual,height,weight,income,gerenjieshao")->find($uid);
			$userinfo["user_ico"] = img_path($userinfo["user_ico"]);
			$this->assign("userinfo",$userinfo);

			//读取相册信息
			$album_list = db("album")->where(["user_id"=>$uid])->order("add_time desc")->select();
			foreach ($album_list as $key => &$value) {
				//if(!is_file("../".$value['album_skin']) || ($value["photo_num"]>0 && $value["album_skin"] == "uploadfiles/album/logo.jpg")){
				if(!is_file("../".$value['album_skin'])){
					$photo = db("photo")->where(["album_id"=>$value["album_id"]])->order("add_time asc")->field("photo_src")->find();
					$value["album_skin"] = $photo["photo_src"];
				}else{
					//halt($value["album_skin"]);
				}
			}
			$this->assign("album_list", $album_list);
			return $this->fetch();
		}
	}


	public function add(){
		if(request()->isAjax()){
			$data = input("post.");
			$data["user_id"] = cookie("user_id");
			$data["user_name"] = cookie("user_name");
			$data["add_time"] = date("Y-m-d H:i:s");
			$data["update_time"] = date("Y-m-d H:i:s");
			$data["album_skin"] = "uploadfiles/album/logo.jpg";
			//halt($data);
			$res = db("album")->insert($data);
			$album_id = db("album")->getLastInsID();
			if($res){
				return json(["msg"=>"OK","url"=>url('photo/index',['album_id'=>$album_id])]);
			}else{
				return json(["msg"=>"Fail","url"=>url('album/index')]);
			}
		}else{
			return $this->fetch();
		}
	}

	public function edit(){
		if(request()->isAjax()){
			$data = input("post.");
			$data["user_id"] = cookie("user_id");
			$data["user_name"] = cookie("user_name");
			$data["add_time"] = date("Y-m-d H:i:s");
			$data["update_time"] = date("Y-m-d H:i:s");
			$data["album_skin"] = "uploadfiles/album/logo.jpg";
			//halt($data);
			$res = db("album")->update($data);
			
			if($res){
				return json(["msg"=>"OK","url"=>url('photo/index',['album_id'=>$data["album_id"]])]);
			}else{
				return json(["msg"=>"Fail","url"=>url('album/index')]);
			}
		}else{
			$album_id = input("album_id");
			$uid = cookie("user_id");
			//读取相册信息
			$album_info = db("album")->where(["user_id"=>$uid,"album_id"=>$album_id])->find();
			$this->assign("album_info", $album_info);
			return $this->fetch();
		}
	}


	public function del($id){
		$info = db("album")->find($id);
		$list = db("photo")->where(["album_id"=>$info['album_id']])->select();
		foreach ($list as $key => $value) {
			@unlink("../".$value["photo_src"]);
			@unlink("../".$value["photo_thumb_src"]);
		}
		$res = db("photo")->where(["album_id"=>$info['album_id']])->delete();
		$res = db("album")->delete($id);
		if($res){
			return json(["code"=>"0","msg"=>"OK"]);
		}else{
			return json(["code"=>"1","msg"=>"Fail"]);
		}
	}
}