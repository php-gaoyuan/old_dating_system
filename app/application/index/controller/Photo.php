<?php 
namespace app\index\controller;
use app\index\controller\Base;
class Photo extends Base
{
	public function index(){
		$album_id = input('album_id');
		$this->assign("album_id",$album_id);

		$uid = cookie("user_id");
		$photo_list = db("photo")->where(["album_id"=>$album_id,"user_id"=>$uid])->order("add_time desc")->select();
		//halt($photo_list);
		$this->assign("photo_list",$photo_list);

		return $this->fetch();
		
	}


	public function add(){
		$album_id = input("album_id");

		$file = request()->file('file');
        if( $file->getInfo()['size'] > 3145728000){
            // 上传失败获取错误信息
            return json( ['code' => -2, 'msg' => '文件超过3M', 'data' => ''] );
        }
        // 移动到框架应用根目录/public/uploads/ 目录下
        //exit(ROOT_PATH . 'public' . DS . 'uploads' . DS . "chat");
        $info = $file->move(ROOT_PATH . '../uploadfiles/album/app');
        if($info){
            $src =  'uploadfiles/album/app/'. date('Ymd') . '/' . $info->getFilename();
            $data=[];
            $data["user_id"] = cookie("user_id");
            $data["user_name"] = cookie("user_name");
            $data["add_time"] = date("Y-m-d H:i:s");
            $data["photo_src"] = $src;
            $data["photo_thumb_src"] = $src;
            $data["album_id"] = $album_id;
            $photo_id = db("photo")->insertGetId($data);
            //更新相册数目
            db("album")->where(["album_id"=>$album_id])->setInc("photo_num");
            //插入动态
            db("recent_affair")->insert([
					"type_id"=>2,
					"title"=>"上传了新照片",
					"content"=>'<img class="photo_frame" src="'.$src.'">',
					"user_id"=>cookie("user_id"),
					"user_name"=>cookie("user_name"),
					"user_ico"=>cookie("user_ico"),
					"date_time"=>date("Y-m-d H:i:s"),
					"update_time"=>date("Y-m-d H:i:s"),
					"for_content_id"=>$photo_id,
					"mod_type"=>3
					]);
            return json( ['code' => 0, 'msg' => 'ok', 'data' => ['src' => config("webconfig.pc_url").$src, "photo_id"=>$photo_id] ] );
        }else{
            // 上传失败获取错误信息
            return json( ['code' => -1, 'msg' => $file->getError(), 'data' => ''] );
        }
	}


	public function del($id){
		$info = db("photo")->find($id);
		$res = db("photo")->fetchSql(0)->delete($id);
		
		if($res){
			@unlink("../".$info["photo_src"]);
			@unlink("../".$info["photo_thumb_src"]);
			return json(["code"=>"0","msg"=>"OK"]);
		}else{
			return json(["code"=>"1","msg"=>"Fail"]);
		}
	}
}