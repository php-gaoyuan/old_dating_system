<?php 
//获取用户信息
function get_user_info(&$dbo,$uid){
	$info = $dbo->select()->from("wy_users")->where("user_id='$uid'")->row();
	return $info;
}
//判断用户是否在线
function is_online(&$dbo,$uid){
	$info = $dbo->select()->from("chat_users")->where("uid='$uid'")->row();
	if($info["line_status"]){
		return true;
	}else{
		return false;
	}
}


//更新最近聊过天的好友
function imUpdateContactedUser(&$dbo, $uid, $pals_id){
	if(!$pals_id){return false;}
	$info = $dbo->select()->from("chat_users")->where("uid='$uid'")->row();
	if(empty($info["contacted"])){
		$contacted = $pals_id;
	}else{
		$contact_arr = explode(",", $info["contacted"]);
		if(!in_array($pals_id, $contact_arr)){
			$contacted = $pals_id.",".$info["contacted"];
		}else{
			$contacted = $info["contacted"];
		}	
	}
	return $dbo->update("chat_users")->where("uid='$uid'")->cols(["contacted"=>$contacted])->query();
}



//查询有无需要推送的离线信息
function offline_message(&$dbo, $uid, $from=""){
	$where = " fromid!='0' and toid='$uid' and type='friend' and is_read='0' ";
	$resMsg = $dbo->select('id,fromid,fromname,fromavatar,timeline,content,tr_content,toid')->from('chat_log')
                   ->where($where)
                   ->query();
    return $resMsg;
}




//组装图片的全路径
function check_userico($path,$user_sex=false){
	if(empty($path)){
		if($user_sex === false){
			return "/public/static/default/imgs/d_ico_1.gif";
		}else{
			return "/public/static/default/imgs/d_ico_{$user_sex}.gif";
		}
	}else{
		if(strpos($path, "http") !== false){
	    	return $path;
	    }else{
	    	return "http://jyo.henangaodu.com/".$path;
	    }
	}
}



//正则匹配出图片
function img_add_url($content){
    $content = str_replace("src=\"", "src=\"http://jyo.henangaodu.com/", $content);
    return $content;
}





?>