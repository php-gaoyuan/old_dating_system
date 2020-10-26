<?php 
namespace app\index\controller;
use think\Db;
class Main extends Base
{

    public function index()
    {
        return $this->fetch();
    }


    public function query(){
    	$model = model("Users");
    	$user_sex = cookie("user_sex");
        $cur_page = input("page");
        $size = 16;

        //检查权限
        require_once "extend/Auth.php";
        $auth = new \Auth;
        $auth->group=$this->userinfo->getData("user_group");
        $auth_res = $auth->look_member();
        if(!$auth_res && $cur_page == "2"){
            return json(["msg"=>"请升级","url"=>url("upgrade/index")]);
        }
        
    	//统计异性会员的数据
    	$count = $model->where(["user_sex"=>["<>",$user_sex],"is_pass"=>["<>",0]])->count();
        $pages = ceil($count/$size);

	    //调用实际数据
	    $list = Db::table("wy_users u")->field("u.user_name,u.user_ico,u.user_sex,u.user_group,u.user_id,o.online_id")
            ->join("wy_online o", "u.user_id=o.user_id","LEFT")
            ->where("u.user_sex != '$user_sex' and u.is_pass!='0'")
            ->order("u.is_service desc, o.active_time desc")
            ->page($cur_page,$size)
            ->fetchSql(false)
            ->select();
        foreach ($list as $key => &$value) {
            $value["user_ico"] = img_path($value["user_ico"],$value["user_sex"]);
        }
        
        return json(["list"=>$list,"pages"=>$pages]);
    }
}