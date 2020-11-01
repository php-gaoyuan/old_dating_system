<?php 
namespace app\index\controller;
use think\Controller;
use think\Db;
class Reg extends Controller{
	public function index(){
		$this->assign("is_h5_plus",is_h5_plus());
		if(request()->isAjax()){
			$post_data = request()->param();

			$validate  = validate("Users");
			if(!$validate->check($post_data)){
			    return json(["msg"=>$validate->getError()]);
			}

			//检查用户名和邮箱是否已经被注册
			$info = model("Users")->where("user_name",$post_data["username"])->whereOr("user_email",$post_data["email"])->find();
			if($info){
				return json(["msg"=>lang("error_user_cunzai")]);
			}

			if(!empty($post_data["user_ico"])){
				$user_ico = saveBase64Image($post_data["user_ico"], "../uploadfiles/avatar/");
				$user_ico = $user_ico["url"];
			}else{
				$user_ico = "skin/default/jooyea/images/d_ico_".$post_data["user_sex"]."_small.gif";
			}
			
			
			$regAdd = getAddressByIp(request()->ip());
    		$reg_address = $regAdd['data']["country"]."/".$regAdd['data']["region"]."/".$regAdd['data']["city"];

			//开始数据存入数据库
			$insert_data=[
				"user_email"=>$post_data["email"],
				"user_name"=>$post_data["username"],
				"user_sex"=>$post_data["user_sex"],
				"user_pws"=>md5($post_data["pass"]),
				"is_pass"=>$post_data["user_sex"] == 1 ? 1 : 0,
				"zhuce_ip"=>request()->ip(),
				"user_ico"=>$user_ico,
				"user_add_time"=>date("Y-m-d H:i:s"),
				"reg_address"=>$reg_address,
				"reg_from"=>"WAP"
			];
			//halt($insert_data);

			$res = model("Users")->save($insert_data);
			$info = model("Users")->where(["user_name"=>$post_data["username"]])->find();

			//存入session
            session("user_id",$info["user_id"]);
            session("user_name",$info["user_name"]);
            session("user_sex",$info["user_sex"]);
            session("user_ico",$info["user_ico"]);
            //存入cookie
            cookie("user_id",$info["user_id"],30*24*3600);
            cookie("user_name",$info["user_name"],30*24*3600);
            cookie("user_sex",$info["user_sex"],30*24*3600);
            cookie("user_ico",$info["user_ico"],30*24*3600);

            //插入chat_users数据
            db()->table("chat_users")->insert([
                "uid"=>$info["user_id"],
                "u_name"=>$insert_data['user_name'],
                "u_ico"=>$insert_data['user_ico'],
                "line_status"=>1,
                "contacted"=>"1"
            ]);

            //默认插入客服
            $kefu = db("users")->where(["is_service"=>1])->find();
            model("PalsMine")->save([
                "user_id"=>$info["user_id"],
                "pals_id"=>$kefu['user_id'],
                "pals_name"=>$kefu['user_name'],
                "pals_sex"=>$kefu['user_sex'],
                "pals_ico"=>$kefu['user_ico'],
                "accepted"=>1,
                "is_service"=>1,
                "add_time"=>date("Y-m-d H:i:s"),
                "active_time"=>date("Y-m-d H:i:s"),
            ]);
			if($res){
				return json(["msg"=>lang("ok"),"url"=>url("main/index")]);
			}else{
				return json(["msg"=>lang("fail"),"url"=>url("reg/index")]);
			}
		
		}else{
			return $this->fetch();
		}
	}





	public function forget_pass(){
		$this->assign("is_h5_plus",is_h5_plus());
		if(request()->isAjax()){

		}else{
			return $this->fetch();
		}
	}
}