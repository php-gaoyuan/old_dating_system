<?php
namespace app\index\controller;
use think\Controller;
class Index extends Controller
{
    public function index()
    {
        $user_id = cookie("user_id");
        if($user_id){
            return redirect("main/index");
        }
        
        $lang = cookie("think_var");
        if(empty($lang)){
            $lang = "zh-tw";
            cookie("think_var",$lang);
            return $this->redirect("index/index");
        }
        $this->assign("lang",lang($lang));
        return $this->fetch();
    }


    //提交登录
    public function login(){
    	if(request()->isAjax()){
    		$username = input("post.username");
    		$pass = input("post.pass");

    		
            $where = "user_name='$username' or user_email='$username'";
            $info = db("users")->where($where)->field("is_pass,user_id,user_email,user_name,user_pws,user_sex,user_ico")->find();
           
            if(empty($info)){
                return return_json_error(lang('error_user_nocunzai'));            
            }
            
            if($info["is_pass"] == "0"){
                return return_json_error(lang("error_user_lock"));
            }
            $user_pws = $info["user_pws"];
            if(md5($pass) != $user_pws){
                return return_json_error(lang('error_pass_error'));
            }

            //登录成功
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

            //更新用户上线信息
            model("Users")->update_online();
            //更新登录信息
			$last_date = date("Y-m-d H:i:s");
			$ip = request()->ip();
			model("Users")->where(array("user_id"=>$info["user_id"]))
				->update(array("lastlogin_datetime"=>$last_date,"login_ip"=>$ip));
            return return_json_success("",[],url("main/index"));
    	}
    }


    //语言侦测
    public function lang() {
    	$lang = input("lang");
    	//halt($lang);
	    switch ($lang) {
	        case 'zh':
	            cookie('think_var', 'zh-cn');
	        	break;
	        case 'en':
	            cookie('think_var', 'en-us');
	        	break;
            case 'tw':
                cookie('think_var', 'zh-tw');
                break;
            case 'kor':
                cookie('think_var', 'kor');
                break;
            case 'jp':
                cookie('think_var', 'jp');
                break;
            default:
                cookie('think_var', 'en-us');
                break;
	        //其它语言
	    }
	    //halt($_COOKIE);
	    //跳转到首页
	    $this->redirect("index/index");
	}


    public function logout(){
        $uid = cookie("user_id");
        db("online")->where("user_id",$uid)->delete();
        //db()->table("chat_users")->where("uid",$uid)->update(["line_status"=>0,"app_online"=>0]);
        session(null);
        cookie(null);
        cookie("user_id",null,-1);
        session("user_id",null,-1);
        return "安全退出";
    }

    public function video(){
        return $this->fetch();
    }


    // public function test(){
    //     $list = file_get_contents("http://jyo.henangaodu.com/im/ajax.php?act=getmessagelist&pals=|");
    //     halt($list);
    // }
}
