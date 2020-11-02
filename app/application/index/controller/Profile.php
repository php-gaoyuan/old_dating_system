<?php 
namespace app\index\controller;
use app\index\controller\Base;
class Profile extends Base
{
	public function index(){
        $uid = cookie("user_id");

		if(request()->isPost()){
			$data = input("post.");
			@$birth = explode("-", $data["birth"]);
			@$data["birth_year"] = $birth[0];
			@$data["birth_month"] = $birth[1];
			@$data["birth_day"] = $birth[2];
			unset($data["birth"]);
			if(isset($data["user_sex"])){
				unset($data["user_sex"]);
			}

			$res = db("users")->where(["user_id"=>$uid])->update($data);
			if($res){
				echo "<script>parent.layui.layer.msg('ok',function(){location.reload();});</script>";exit;
			}
			//halt($data);
		}else{
            $this->assign("uid",$uid);
            $userinfo = model("Users")->field("user_id,user_name,user_sex,user_ico,birth_year,birth_month,birth_day,country,waimao,sexual,height,weight,income,gerenjieshao")->find($uid);
			$userinfo["user_ico"] = img_path($userinfo["user_ico"]);
			$this->assign("userinfo",$userinfo);


			//获取国家
			$country_list = db("country")->field("id,cname")->select();
			$this->assign("country_list",$country_list);
			return $this->fetch();
		}
			
	}

	//获取心情
	public function mood(){
		$uid = cookie("user_id");
		if(request()->isAjax()){
			
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
		}else{
			$this->assign("uid",$uid);
			$userinfo = model("Users")->field("user_id,user_name,user_sex,user_ico,birth_year,birth_month,birth_day,country,waimao,sexual,height,weight,income,gerenjieshao")->find($uid);
			$userinfo["user_ico"] = img_path($userinfo["user_ico"]);
			$this->assign("userinfo",$userinfo);
			return $this->fetch();
		}
	}


	//上传头像
	public function headimg(){
        $uid = cookie("user_id");
        $userinfo = model("Users")->field("user_id,user_ico")->find($uid);
		if(request()->isAjax()){
			$user_ico = input("user_ico");
            if($user_ico==$userinfo->user_ico || strpos($user_ico,'default')!==false){
                unset($user_ico);
                return json(["code"=>0, "msg"=>"ok"]);
            }elseif(strpos($user_ico,'default')!==false){
                db("avater")->insert([
                    "user_id"=>$uid,
                    "avater"=>$user_ico,
                    "create_time"=>date("Y-m-d H:i:s")
                ]);
            }
			//$res = db("users")->where(["user_id"=>$uid])->update(["user_ico"=>$user_ico]);
			return json(["code"=>0, "msg"=>"ok"]);
		}else{
			$user_ico = img_add_pcUrl($userinfo["user_ico"]);
			$this->assign("user_ico",$user_ico);
			//halt($info);
			return $this->fetch();
		}
	}


	public function upimg(){
        $file = request()->file('file');
        if( $file->getInfo()['size'] > 3145728){
            // 上传失败获取错误信息
            return json( ['code' => -2, 'msg' => '文件超过3M', 'data' => ''] );
        }
        // 移动到框架应用根目录/public/uploads/ 目录下
        //exit(ROOT_PATH . 'public' . DS . 'uploads' . DS . "chat");
        $info = $file->move(ROOT_PATH . '../uploadfiles/avatar');
        if($info){
            $src =  'uploadfiles/avatar/'. date('Ymd') . '/' . $info->getFilename();
            return json( ['code' => 0, 'msg' => '', 'data' => ['src' => $src ] ] );
        }else{
            // 上传失败获取错误信息
            return json( ['code' => -1, 'msg' => $file->getError(), 'data' => ''] );
        }
	}
}