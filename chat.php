<?php
	//必须登录才能浏览该页面
    //header("content-type:text/html;charset=utf-8");
    require("foundation/asession.php");
    require("configuration.php");
    require("includes.php");

    require("foundation/auser_mustlogin.php");
    require("foundation/module_users.php");
    require("foundation/fplugin.php");
    require("api/base_support.php");
    require("foundation/fdnurl_aget.php");
    require("foundation/fgrade.php");
    error_reporting(0);

    //引入语言包
    require_once($webRoot . $langPackageBasePath . "chat.php");
    $chatlp = new chatlp;
    //p(session("isns_user_sex"));
    $kefu_id = array("704","3752");
    $user_id=get_sess_userid();
    $user_sex = $_SESSION["isns_user_sex"];
    $act = isset($_REQUEST["act"]) ? $_REQUEST["act"] : "init";

    $dbo = new dbex;    //连接数据库执行
    dbtarget('r',$dbServs);

    if($act == "init"){
    	$json = array();
    	if(!$user_id){
    		$json["code"]=1;
    		$json["msg"]="请先登录";
    		$json["data"]="";
    		echo json_encode($json);exit;
    	}else{
    		$user_info=$dbo->getRow("select c.uid,c.u_name,u.user_ico as u_ico,c.u_intro,c.line_status from chat_users as c,wy_users as u where c.uid=u.user_id and uid='$user_id'");
    		if(empty($user_info["u_ico"])){$user_info["u_ico"] = "skin/default/jooyea/images/d_ico_{$user_sex}.gif";}
    		$user_info["line_status"] = get_online_status($dbo, $user_info["uid"]);
    		$mine=array(
    			"id"=>$user_info["uid"],
    			"username"=>$user_info["u_name"],
    			"avatar"=>$user_info["u_ico"],
    			"sign"=>$user_info["u_intro"],
    			"status"=>$user_info["line_status"],
    		);


            //查询客服信息
            $kefu_info = get_kefu_info($dbo, $kefu_id);
            
    		//获取好友
    		$friend_list = array();
            $friend_list = $dbo->getALL("select * from wy_pals_mine where user_id='{$user_id}'");
            $friend_ids = get_friend_ids($dbo,$friend_list);
            $friend_list = get_friend_list($dbo, $friend_list);
            
            
            

            //查找陌生人
            $mosheng_list=array();
            $mosheng_list = get_mosheng_list($dbo, $user_id);
            
                
    		$data=array(
    			array(
	    			"groupname"=>$chatlp->kefu,
	    			"id"=>1,
	    			"list"=>$kefu_info
	    		),
    			array(
	    			"groupname"=>$chatlp->group_friend,
	    			"id"=>2,
	    			"list"=>$friend_list
	    		),
	    		array(
	    			"groupname"=>$chatlp->group_mosheng,
	    			"id"=>3,
	    			"list"=>$mosheng_list
	    		)
    		);

    		$json["code"]=0;
    		$json["msg"]="";
    		$json["data"]=array(
    			"mine"=>$mine,
    			"friend"=>$data
    		);
    		echo json_encode($json);exit;
    	}
    }elseif($act == "getLog"){
        $pals_id = $_GET["pals_id"];
        $log_list = $dbo->getALL("select * from chat_log where (fromid='$user_id' and toid='$pals_id') or (fromid='$pals_id' and toid='$user_id') order by timeline desc");
        foreach ($log_list as $k => $vo) {
            $list[$k]["id"] = $vo["fromid"];
            $list[$k]["username"] = $vo["fromname"];
            //获取头像
            $userinfo = $dbo->getRow("select user_sex,user_ico from wy_users where user_id='{$vo['fromid']}'");
            if(empty($userinfo["user_ico"])){
                $userinfo["user_ico"] = "http://".$_SERVER["HTTP_HOST"]."/skin/default/jooyea/images/d_ico_".$userinfo["user_sex"].".gif";
            }else{
                if(strpos($userinfo["user_ico"], "http") === false){
                    $user_ico = "http://".$_SERVER["HTTP_HOST"]."/".$userinfo["user_ico"];
                }else{
                    $user_ico = $userinfo["user_ico"];
                }
            }
                
            $list[$k]["avatar"] = $user_ico;
            $list[$k]["timestamp"] = date("Y-m-d H:i:s",$vo["timeline"]);
            $list[$k]["content"] = $vo["content"];
        }
        echo json_encode([
            "code"=>0,
            "msg"=>"",
            "data"=>$list
            ]);exit;
    }elseif($act == "change_sign"){
        $sign = $_GET["sign"];
        $dbo->exeUpdate("update chat_users set `u_intro`='$sign' where uid='$user_id'");
    }elseif($act == "change_online"){
        $status = $_GET["status"];
        if($status == "online"){
            $online=1;
        }else{
            $online=0;
        }
        $dbo->exeUpdate("update chat_users set `line_status`='$online' where uid='$user_id'");
    }elseif($act == "chatChange"){
        $pals_id = $_GET["pals_id"];
        if(!$pals_id){return false;}
        $info = $dbo->getRow("select * from chat_users where uid='$user_id'");

        
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

        $dbo->exeUpdate("update chat_users set `contacted`='$contacted' where uid='$user_id'");
    }


    //获取用户信息
    elseif($act == "get_userinfo"){
        $get_uid = $_GET["user_id"];
        $userinfo = $dbo->getRow("select user_id,user_name,user_ico from wy_users where user_id='{$get_uid}'");

        $info = array(
            "id"=>$userinfo["user_id"],
            "username"=>$userinfo["user_name"],
            "avatar"=>get_user_ico($dbo,$get_uid),
            "sign"=>"",
            "status"=>"online"
        );
        echo json_encode($info);exit;
    }


    //获取陌生人列表
    function get_mosheng_list(&$dbo, $user_id){
        $list = array();
        $friend_list = $dbo->getALL("select * from wy_pals_mine where user_id='{$user_id}'");
        $friend_ids = get_friend_ids($dbo,$friend_list);
        //获取所有联系过的会员
        $chat_list = $dbo->getRs("select DISTINCT(`toid`) from chat_log where fromid='{$user_id}'");
        if(empty($chat_list)){
            return array();
        }
        //获取所有联系过的ids
        foreach ($chat_list as $key => $value) {
            $chat_ids[]=$value["toid"];
        }
        //筛选非好友的ids
        foreach ($chat_ids as $key => $value) {
            if(in_array($value, $friend_ids)){
                unset($chat_ids[$key]);
            }
        }
        //print_r($all_ids);exit;
        if(!empty($chat_ids)){
            $mosheng_ids = implode(",", $chat_ids);
            //exit("select * from chat_users where uid in ($mosheng_ids)");
            $mosheng_list = $dbo->getALL("select * from wy_users where user_id in ($mosheng_ids)");
            foreach ($mosheng_list as $k => $vo) {
                $list[$k]["id"] = $vo["user_id"];
                $list[$k]["username"] = $vo["user_name"];
                $list[$k]["avatar"] = get_user_ico($dbo, $vo["user_id"]);
                $list[$k]["sign"] = "";
                $list[$k]["status"] = get_online_status($dbo, $vo["user_id"]);
            }
            return $list;
        }
        return array();
    }


    //获取好友列表
    function get_friend_list(&$dbo, $list){
        $friend_list = array();
        if(empty($list)){
            return array();
        }

        $online_list=array();
        $offline_list=array();
        foreach ($list as $k => $vo) {
            //检查头像
            $vo["pals_ico"] = get_user_ico($dbo, $vo["pals_id"]);
            //查询在线状态、
            $line_status = get_online_status($dbo, $vo["pals_id"]);
            
            if($line_status == "online"){
                $online_list[$k]["id"] = $vo["pals_id"];
                $online_list[$k]["username"] = $vo["pals_name"];
                $online_list[$k]["avatar"] = $vo["pals_ico"];
                $online_list[$k]["sign"] = get_last_chatlog($dbo, $GLOBALS["user_id"],$vo["pals_id"]);
                $online_list[$k]["status"] = "online";
            }elseif($line_status == "offline"){
                $offline_list[$k]["id"] = $vo["pals_id"];
                $offline_list[$k]["username"] = $vo["pals_name"];
                $offline_list[$k]["avatar"] = $vo["pals_ico"];
                $offline_list[$k]["sign"] = "";
                $offline_list[$k]["status"] = "offline";
            }
            if(!empty($online_list)){
                $friend_list = array_merge($online_list, $offline_list);
            }else{
                $friend_list = $offline_list;
            }
        }
        //删除客服
        foreach ($friend_list as $k => $vo) {
            if($vo["id"] == $GLOBALS["kefu_id"]){
                unset($friend_list[$k]);
            }
        }
        $friend_list = array_values($friend_list);
            
        return $friend_list;
    }

    //获得好友ids
    function get_friend_ids(&$dbo, $list){
        $ids = array();
        foreach ($list as $key => $vo) {
           $ids[]=$vo["pals_id"];
        }
        return $ids;
    }
    
    //查询客服信息
    function get_kefu_info(&$dbo, $uid){
        $kefu_info=array();
        //查找客服
        $list = $dbo->getALL("select user_id,user_name from wy_users where is_service='1' order by user_id asc");
        //p($list);
        foreach ($list as $k => $val) {
        	$kefu_info[] = array(
                "id"=>$val["user_id"],
                "username"=>$val["user_name"],
                "avatar"=>get_user_ico($dbo,$val['user_id']),
                "sign"=>'',
                "status"=>"online"
            );
        }
        return $kefu_info;
        // $kefu_info=array();
        // $info = $dbo->getRow("select uid,u_name,u_intro from chat_users where uid='{$uid}'");

        // $kefu_info = array(
        //                 "id"=>$info["uid"],
        //                 "username"=>$info["u_name"],
        //                 "avatar"=>get_user_ico($dbo,$uid),
        //                 "sign"=>$info["u_intro"],
        //                 "status"=>"online"
        //             );
        // return $kefu_info;
    }

    //查询在线状态
    function get_online_status(&$dbo, $uid){
        $online_info = $dbo->getRow("select * from wy_online where user_id='{$uid}'");
        $online_status = !empty($online_info) ? "online" : "offline";
        return $online_status;
    }

    //获取用户头像
    function get_user_ico(&$dbo, $uid){
        $info = $dbo->getRow("select user_ico,user_sex from wy_users where user_id='{$uid}'");
        if(empty($info["user_ico"])){
            $user_ico = "skin/default/jooyea/images/d_ico_{$info['user_sex']}.gif";
        }else{
            $user_ico = $info["user_ico"];
        }
        return $user_ico;
    }

    //查询最后一句聊天内容
    function get_last_chatlog(&$dbo, $uid, $pals_id){
        $info = $dbo->getRow("select content from chat_log where (fromid='{$pals_id}' and toid='{$uid}') or (toid='{$uid}' and fromid='{$pals_id}') order by id desc limit 1");
        return $info["content"];
    }
    function p($data){
    	echo "<pre>";print_r($data);exit;
    }

?>