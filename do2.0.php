<?php
header("content-type:text/html;charset=utf-8");
require("foundation/asession.php");
require("configuration.php");
require("includes.php");
//当前可访问的action动作,先列出公共部分,然后按各个模块列出
$actArray=array(
    "jst_xz"=> array('action2.0/jst_xz.action.php'),
    "mood_up_acttion"=> array('action2.0/mood_up_acttion.action.php'),
    "check_name"=> array('action2.0/check_name.action.php'),
    "change_rz"=> array('action2.0/change_rz.action.php'),
    "kaishijifei"=> array('action2.0/chat/kaishijifei.php'),
    "service_chat"=> array('action2.0/chat/service_chat.php'),
    "get_kefu_list"=> array('action2.0/chat/get_kefu_list.php'),
    "login"=> array('action2.0/login_act.php'),
    "logout"=> array('action2.0/logout_act.php',"$indexFile"),
    "reg"=> array('action2.0/reg_act.php','main.php'),
	
    "group_creat"=> array('action2.0/group/group_creat.action.php','modules.php?app=group'),
    "group_join"=> array('action2.0/group/group_join.action.php'),
    "group_del_sub"=> array('action2.0/group/group_del_subject.action.php'),
    "group_exit"=> array('action2.0/group/group_exit.action.php','modules.php?app=group'),
    "group_drop"=> array('action2.0/group/group_drop.action.php','modules.php?app=group'),
    "group_appoint"=> array('action2.0/group/group_appoint.action.php'),
    "group_revoke"=> array('action2.0/group/group_revoke.action.php'),
    "group_del_member"=> array('action2.0/group/group_del_memeber.action.php'),
    "group_del_req"=> array('action2.0/group/group_del_request_member.action.php'),
    "group_info_change"=> array('action2.0/group/group_info_change.action.php'),
    "group_send_sub"=> array('action2.0/group/group_send_subject.action.php'),
    "group_approve"=> array('action2.0/group/group_approve.action.php'),
    "group_change_group_info"=> array('action2.0/group/group_info_change.action.php'),

    "album_creat"=> array('action2.0/album/album_creat.action.php'),
    "album_del"=> array('action2.0/album/album_del.action.php','modules.php?app=album'),
    "album_upd"=> array('action2.0/album/album_upd.action.php','modules.php?app=album'),
    "photo_del"=> array('action2.0/album/photo_del.action.php'),
    "album_skin"=> array('action2.0/album/album_skin.action.php'),
    "photo_im"=> array('action2.0/album/photo_im.action.php'),
    "photo_upd"=> array('action2.0/album/photo_upd.action.php'),
    "photo_upl"=> array('action2.0/album/photo_upl.action.php'),
    "photo_upl_flash"=> array('action2.0/album/photo_upl_flash.action.php'),
    

    "msg_crt_hf"=> array('action2.0/msgscrip/msg_crt_hf.action.php'),
    "msg_crt"=> array('action2.0/msgscrip/msg_crt.action.php'),
    "msg_del"=> array('action2.0/msgscrip/msg_del.action.php'),
    "msg_send"=> array('action2.0/msgscrip/msg_send.action.php'),
    "msgboard_send"=> array('action2.0/msgboard/msgboard_send.action.php'),
    "msgboard_del"=> array('action2.0/msgboard/msgboard_del.action.php'),
	"getmsscount"=> array('action2.0/get_mess_count.action.php'),

    "set_status"=> array('action2.0/users/set_status.action.php'),
    "user_info"=> array('action2.0/users/user_info.action.php'),
    "up_user_ico"=> array('action2.0/users/up_user_ico.action.php'),
    "user_pw_change"=> array('action2.0/users/user_pw_change.action.php'),
    "user_ico_upload"=> array('action2.0/users/user_ico_upload.action.php'),
    "user_ico_save"=> array('action2.0/users/user_ico_cut_save.action.php'),
    "user_ol_reset"=> array('action2.0/users/user_online_reset.action.php'),
    "user_add_hi"=> array('action2.0/users/user_add_hi.action.php'),
    "user_del_hi"=> array('action2.0/users/user_del_hi.action.php'),
    "user_forget"=> array('action2.0/users/user_forget.action.php'),
    "user_dress_change"=> array('action2.0/users/user_dressup.action.php'),
	"user_activation" => array("action2.0/users/user_activation.action.php"),

    "mood_add"=> array('action2.0/mood/mood_add.action.php'),
    "mood_del"=> array('action2.0/mood/mood_del.action.php'),

    "add_mypals"=> array('action2.0/mypals/pals_add.action.php'),
    "pals_sort_add"=> array('action2.0/mypals/pals_sort_add.action.php','modules.php?app=mypals_sort'),
    "pals_change"=> array('action2.0/mypals/pals_change.action.php'),
    "pals_sort_change" => array('action2.0/mypals/pals_sort_change.action.php'),
    "pals_sort_del" => array('action2.0/mypals/pals_sort_del.action.php','modules.php?app=mypals_sort'),
    "del_mypals" => array('action2.0/mypals/pals_del.action.php','modules.php?app=mypals'),
    "refuse_req" => array('action2.0/mypals/refuse_req.action.php','modules.php?app=mypals_request'),
    "del_req" => array('action2.0/mypals/del_req.action.php','modules.php?app=mypals_request'),
    "confirm_both" => array('action2.0/mypals/confirm_both.action.php','modules.php?app=mypals_request'),
    "confirm_other" => array('action2.0/mypals/confirm_other.action.php','modules.php?app=mypals_request'),

    "blog_add" => array('action2.0/blog/blog_add.action.php','modules.php?app=blog_list'),
    "blog_del" => array('action2.0/blog/blog_del.action.php','modules.php?app=blog_list'),
    "blog_edit" => array('action2.0/blog/blog_edit.action.php'),
    "blog_sort_add" => array('action2.0/blog/blog_sort_add.action.php'),
    "blog_sort_del" => array('action2.0/blog/blog_sort_del.action.php','modules.php?app=blog_manager_sort'),
    "blog_sort_change" => array('action2.0/blog/blog_sort_change.action.php'),
	
    "upload_act" => array('action2.0/pubtools/upload.action.php'),

    "pr_access" => array('action2.0/privacy/home_access_set.action.php'),
    "pr_access_login" => array('action2.0/privacy/home_acess_login.action.php'),
    "pr_inputmess" => array('action2.0/privacy/home_inputmess_set.action.php'),
    "pr_reqcheck" => array('action2.0/privacy/home_reqcheck_set.action.php'),
    "pr_affair" => array('action2.0/privacy/hidden_affair.action.php'),

    "poll_add" => array('action2.0/poll/poll_add.action.php','modules.php?app=poll_mine'),
    "poll_submit" => array('action2.0/poll/poll_submit.action.php'),
    "poll_set_config" => array('action2.0/poll/poll_set_config.action.php'),

    "share_action" => array('action2.0/share/share.action.php'),
    "share_del" => array('action2.0/share/share_del.action.php'),
    "share_get_info" => array('action2.0/share/share_outer.action.php'),

    "report_add" => array('action2.0/report/report_add.action.php'),

    "restore_add" => array('action2.0/restore/restore_add.action.php'),
    "restore_del"=> array('action2.0/restore/restore_del.action.php'),

    "message_del" => array('action2.0/message/message_del.action.php'),
    "add_app" => array('action2.0/userapp/add_app.action.php'),
    "del_app" => array('action2.0/userapp/del_app.action.php'),
	
	"event_add" => array('action2.0/event/event_add.action.php','modules.php?app=event'),
    "event_edit" => array('action2.0/event/event_edit.action.php','modules.php?app=event'),
	"event_join" => array('action2.0/event/event_join.action.php','modules.php?app=event_all'),
	"event_del_member" => array('action2.0/event/event_del_member.action.php','modules.php?app=event'),
	"event_appoint" => array('action2.0/event/event_appoint.action.php','modules.php?app=event'),
	"event_revoke" => array('action2.0/event/event_revoke.action.php','modules.php?app=event'),
	"event_approve" => array('action2.0/event/event_approve.action.php','modules.php?app=event'),
	"event_del_req" => array('action2.0/event/event_del_req.action.php','modules.php?app=event'),
	"event_invite" => array('action2.0/event/event_invite.action.php','modules.php?app=event'),
	"event_exit" => array('action2.0/event/event_exit.action.php','modules.php?app=event'),
	"event_drop" => array('action2.0/event/event_drop.action.php','modules.php?app=event'),
	"event_follow" => array('action2.0/event/event_follow.action.php','modules.php?app=event'),
	"event_follow_cancel" => array('action2.0/event/event_follow_cancel.action.php','modules.php?app=event'),
	"event_upload_photo" => array('action2.0/event/event_upload_photo.action.php'),
	"event_update_photo" => array('action2.0/event/event_update_photo.action.php'),
	"event_del_photo" => array('action2.0/event/event_del_photo.action.php'),
	"event_im_photo" => array('action2.0/event/event_im_photo.action.php'),
	"event_edit_apply" => array('action2.0/event/event_edit_apply.action.php','modules.php?app=event'),
	
	"ask_add" => array('action2.0/ask/ask_add.action.php'),
	"ask_edit" => array('action2.0/ask/ask_edit.action.php'),
	"ask_reply_add" => array('action2.0/ask/ask_reply_add.action.php'),
	"ask_reply_del" => array('action2.0/ask/ask_reply_del.action.php'),
	"ask_reply_edit" => array('action2.0/ask/ask_reply_edit.action.php'),
	"ask_set_answer" => array('action2.0/ask/ask_set_answer.action.php'),

	"pay" => array('action2.0/chongzhi/pay.action.php'),
	"paynotify" => array('action2.0/chongzhi/paynotify.action.php'),
	"upgrade"=>array('action2.0/chongzhi/upgrade.action.php'),
    "tenpay_url" => array('action2.0/chongzhi/return_url.php'),
    "tenpay_show" => array('action2.0/chongzhi/show.php'),
    "krecieve" => array('action2.0/chongzhi/kuaipay/recieve.php'),
    "kshow" => array('action2.0/chongzhi/kuaipay/show.php'),

    "stamps" => array('action2.0/stamps/stamps.action.php','modules.php?app=stamps'),

    "bott_del"=> array('action2.0/bottle/bott_del.action.php'),
    "bott_reply"=> array('action2.0/bottle/bott_reply.action.php'),
    "bott_crt"=> array('action2.0/bottle/bott_crt.action.php'),
    "bott_crt2"=> array('action2.0/bottle/bott_crt2.action.php'),
    "bott_pick"=> array('action2.0/bottle/bott_pick.action.php','modules.php?app=bott_in'),
    
    "sign_add"=> array('action2.0/sign/sign_add.action.php'),

    "impression_add"=> array('action2.0/impression/impression_add.action.php'),
	
	"del_guest" => array('action2.0/guest/guest_del.action.php'),

);
$actId=getActId();
$free_act_array=array("login","reg","logout","pr_access_login","photo_upl_flash","user_forget","user_pw_change","user_activation");
//除必须登录才能访问文件
if(!in_array($actId,$free_act_array)){
	limit_time($limit_action_time);
	require("foundation/auser_mustlogin.php");
}

//action动作成功控制函数
function action_return($state=1,$retrun_mess="",$activeUrl=""){
		if($state==2){echo $retrun_mess;exit;}
	  Global $acttarget;
	  echo "<script language='javascript'>";
	  if(trim($retrun_mess)!=''){
	  	 echo "alert('".$retrun_mess."');";
	  }
	  $setUrl='';
	  if($activeUrl!=''){
	    $setUrl=$activeUrl;
	  }else{
	  	$setUrl=$acttarget[1];
	  }
		if($setUrl=='-1'){
			echo "history.go(-1);";
		}else if($setUrl=='0'){
			echo "window.close();";
		}else{
			echo "location.href='".$setUrl."';";
		}
			echo "</script>";exit();
}
if(array_key_exists($actId,$actArray)){
	$acttarget=$actArray[$actId];
	require($acttarget[0]);
}else{
	  echo 'error';
}
?>