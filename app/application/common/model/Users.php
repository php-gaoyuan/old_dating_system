<?php 
namespace app\common\model;
use think\Model;
class Users extends Model{

	public function get_user_info($where,$field="all"){
		$info = $this->where($where)->find();
		if(empty($info)){
			return false;
		}


        if(empty($info["user_ico"])){
            $info["user_ico"] = "/public/static/default/imgs/d_ico_{$info['user_sex']}.gif";
        }else{
            if(strpos($info["user_ico"], "http") === false){
                $info["user_ico"] = config("webconfig.pc_url").$info["user_ico"];
            }
        }


		if($field == "all"){
			return $info;
		}elseif(is_array($field)){
            $data=array();
            foreach ($field as $key => $value) {
                $data[$value] = $info[$value];
            }
            return $data;
        }else{
			return $info->$field;
		}
	}



	//获取器 返回男女数据
	// public function getUserSexAttr($value){
    //     $sex = [1=>'男',0=>'女'];
    //     return $sex[$value];
    // }

    //检查用户余额
    public function check_money($money){
    	$uid = session("userinfo.user_id");
        if(empty($uid)){
            $uid = cookie("user_id");
        }
    	$info = $this->field("golds")->find($uid);
        //p($uid);
    	if($info["golds"]>=$money){
    		return true;
    	}else{
    		return false;
    	}
    }



    //用户登录成功，更新上线
    public function update_online(){
    	$uid = session("user_id");
    	$userinfo = $this->get_user_info(["user_id"=>$uid]);
    	$info = db("online")->where("user_id",$uid)->find();

    	if(empty($info)){
    		db("online")->insert([
				"user_id"=>$userinfo["user_id"],
				"user_name"=>$userinfo["user_name"],
				"user_sex"=>$userinfo["user_sex"],
				"user_ico"=>$userinfo["user_ico"],
				"active_time"=>time()
    		]);
    	}

    	db()->table("chat_users")->where("uid",$uid)->update(["line_status"=>1,"app_online"=>1]);
    }



}