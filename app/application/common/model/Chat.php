<?php 
//chat相关函数
namespace app\common\model;
use think\Model;
use think\Db;
class Chat extends Model{
	protected $table = 'chat_users';

	//获取所有聊过天的人
	public function get_chats($uid){
		$list = db()->table("chat_log")->where("fromid='$uid' or toid='$uid'")->order("timeline desc")->fetchSql(0)->select();
		if(empty($list)){
			return false;
		}


		foreach ($list as $key => $value) {
			
			if($value["fromid"]>0){
				$fromids[]=$value["fromid"];
			}
			
			if($value["fromid"]>0){
				$toids[]=$value["toid"];
			}
		}
		if(!empty($toids)){
			$toids = array_unique($toids);
		}else{
			$toids = [];
		}
		
		if(!empty($fromids)){
			$fromids = array_unique($fromids);
			$pals_ids = array_merge($fromids, $toids);
			$pals_ids = array_unique($pals_ids);
		}else{
			$pals_ids = $toids;
		}
		foreach ($pals_ids as $key => $value) {
			if($value == $uid){
				unset($pals_ids[$key]);
			}
		}
		if(empty($pals_ids)){
			return null;
		}
		
		$list = model("Users")->where(["user_id"=>["in",$pals_ids]])->field("user_id,user_name,user_ico,user_sex")->select();
	    foreach ($list as $key => &$value) {
    		$value["user_ico"] = img_path($value["user_ico"],$value["user_sex"]);
    	}
    	
	    return $list;
	}

	//获取最近联系人
	public function get_zuijin_contact($uid){
	    $info = $this->where(["uid"=>$uid])->find();
	    $pals_ids = explode(",", $info["contacted"]);
	    $list = model("Users")->where(["user_id"=>["in",$pals_ids]])->field("user_id,user_name,user_ico")->select();
	    foreach ($list as $key => &$value) {
    		$value["user_ico"] = img_path($value["user_ico"]);
    	}
	    return $list;
	}
}
