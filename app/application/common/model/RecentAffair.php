<?php 
namespace app\common\model;
use think\Model;
class RecentAffair extends Model{
	// 定义时间戳字段名
    protected $createTime = 'date_time';
    protected $updateTime = 'update_time';
    protected $autoWriteTimestamp = 'datetime';



    //获取最新动态
    public function get_new_list(){
    	$user_id = cookie("user_id");
    	$user_sex = cookie("user_sex");
    	$page = input("page");
    	$size = 16;

        //计算总页数
    	$count = db()->table("wy_recent_affair")->alias("r")->join("wy_users u","r.user_id = u.user_id")->where(["r.user_id"=>["<>",$user_id],"u.user_sex"=>["<>",$user_sex]])->field("r.id")->fetchSql(0)->count();
    	$pages = ceil($count/$size);
    	//file_put_contents("sql-ce.sql", $limit);

    	$list = db()->table("wy_recent_affair")->alias("r")->join("wy_users u","r.user_id = u.user_id")->where(["r.user_id"=>["<>",$user_id],"u.user_sex"=>["<>",$user_sex]])->field("r.id,r.type_id,r.title,r.content,r.user_id,r.user_name,r.update_time,r.for_content_id,u.user_ico,u.user_sex")->order("r.id desc")->page($page,$size)->fetchSql(0)->select();
		foreach ($list as $key => &$value) {
			if($value["type_id"] == "1"){
				$img = db("mood")->where("mood_id",$value["for_content_id"])->value("mood_pic");
				if(!empty($img)){
					$value["content"] .= "<br><img src='".config("webconfig.pc_url")."{$img}'/>";
				}
			}

            $value["user_ico"] = img_path($value["user_ico"],$value["user_sex"]);
            $value["content"] = img_add_url($value["content"]);
            $value["time_ago"] = time_ago(strtotime($value["update_time"]));
        }

        //在第一页显示的时候，头部加入客服公告
        if($page == 1){
        	$kefu_info = $this->get_one_kefu_new();
	        $list = array_unshift2($list, $kefu_info);
        }
	        
        return ["list"=>$list,"pages"=>$pages];
    }



    //读取一条客服消息
    public function get_one_kefu_new(){
    	$info = db()->table("wy_recent_affair")->alias("r")->join("wy_users u","r.user_id = u.user_id")->where(["r.user_id"=>"704"])->field("r.id,r.type_id,r.title,r.content,r.user_id,r.user_name,r.update_time,r.for_content_id,u.user_ico,u.user_sex")->order("r.id desc")->fetchSql(0)->find();
    	
    	if($info["type_id"] == "1"){
			$img = db("mood")->where("mood_id",$info["for_content_id"])->value("mood_pic");
			if(!empty($img)){
				$info["content"] .= "<br><img src='".config("webconfig.pc_url")."{$img}'/>";
			}
		}

        $info["user_ico"] = img_path($info["user_ico"],$info["user_sex"]);
        $info["content"] = isset($info["content"]) ? img_add_url($info["content"]):"";
        $info["time_ago"] = isset($info["update_time"]) ? time_ago(strtotime($info["update_time"])):"";
        
        return $info;
    }
}