<?php
header("content-type:text/html;charset=utf-8");
require("foundation/asession.php");
require("foundation/module_remind.php");
require("configuration.php");
require("includes.php");
$user_id=get_sess_userid();
if($user_id){$start='hstart';}else{$start='homestart';}
//当前可访问的应用工具

$appArray=array(
			"horn_iframe" => 'modules2.0/horn_iframe.php',
			"u_chat" => 'modules2.0/u_chat.php',
			"u_chat_info" => 'modules2.0/u_chat_info.php',
			"u_emails" => 'modules2.0/u_emails.php',
			"u_horn" => 'modules2.0/u_horn.php',
			"u_horn_fs" => 'modules2.0/u_horn_fs.php',
			"u_horn_buy" => 'modules2.0/u_horn_buy.php',
			"u_horn_js" => 'modules2.0/u_horn_js.php',
			"renzheng" => 'modules2.0/renzheng.php',
			"gorenzheng" => 'modules2.0/gorenzheng.php',
			"txrz"=> 'modules2.0/txrz.action.php',
		   "start" => 'modules2.0/start.php',
           "error" => 'modules2.0/error.php',
           "search" => 'modules2.0/search.php',
		   "start13" => 'modules2.0/start13.php',
		   "start14" => 'modules2.0/start14.php',
		   "startlx" => 'modules2.0/startlx.php',
		   "hstart" => 'modules2.0/'.$start.'.php',
		   "blog_list" => 'modules2.0/blog/blog_list.php',
		   "blog" => 'modules2.0/blog/blog_show.php',
		   "blog_edit" => 'modules2.0/blog/blog_edit.php',
		   "blog_manager_sort" => 'modules2.0/blog/blog_manager_sort.php',
		   "blog_sort" => 'modules2.0/blog/blog_sort.php',
		   "blog_friend" => 'modules2.0/blog/blog_friend.php',
		   "group" => 'modules2.0/group/group_mine.php',
		   "group_creat" => 'modules2.0/group/group_creat.php',
		   "group_hot" => 'modules2.0/group/group_hot.php',
		   "group_manager" => 'modules2.0/group/group_manager.php',
		   "group_member_manager" => 'modules2.0/group/group_member_manager.php',
		   "group_info_manager" => 'modules2.0/group/group_info_manager.php',
		   "group_select" => 'modules2.0/group/group_select.php',
		   "group_space" => 'modules2.0/group/group_space.php',
		   "group_subject" => 'modules2.0/group/group_subject.php',
		   "search_group" => 'modules2.0/group/search_group.php',
		   "search_subject" => 'modules2.0/group/search_subject.php',
		   "group_sub_show" => 'modules2.0/group/group_sub_show.php',
		   "mypals" => 'modules2.0/mypals/pals_list.php',
		   "mypals_search" => 'modules2.0/mypals/search_pals.php',
           "mypals_search2" => 'modules2.0/mypals/search_pals2.php',
           "mypals_search_new" => 'modules2.0/mypals/search_pals_new.php',
		   "mypals_search_list" => 'modules2.0/mypals/search_pals_list.php',
           "mypals_search_list2" => 'modules2.0/mypals/search_pals_list2.php',
           "mypals_list" => 'modules2.0/mypals/search_list.php',
           "mypals_online" => 'modules2.0/mypals/online_list.php',
		   "mypals_request" => 'modules2.0/mypals/pals_request.php',
		   "mypals_invite" => 'modules2.0/mypals/pals_invite.php',
		   "mypals_sort" => 'modules2.0/mypals/pals_manager_sort.php',
		   "mypals_fribirth" => 'modules2.0/mypals/pals_fribirth.php',
		   "mypals_fribirth_month" => 'modules2.0/mypals/pals_fribirth_month.php',
		   "album" => 'modules2.0/album/album_list.php',
		   "album_friend" => 'modules2.0/album/album_friend.php',
		   "album_edit" => 'modules2.0/album/album_edit.php',
		   "photo_upload" => 'modules2.0/album/photo_upload.php',
		   "photo_list" => 'modules2.0/album/photo_list.php',
		   "photo" => 'modules2.0/album/photo_view.php',
		   "photo_update" => 'modules2.0/album/photo_update.php',
		   "user_forget" => 'modules2.0/users/user_forget.php',
		   //"user_reg" => 'modules2.0/users/user_reg.php',
		   "user_info" => 'modules2.0/users/user_info.php',
		   "user_city" => 'modules2.0/users/user_city.php',
		   "user_pw_change" => 'modules2.0/users/user_pw_change.php',
		   "user_pw_reset" => 'modules2.0/users/user_pw_reset.php',
		   "user_ico" => 'modules2.0/users/user_ico.php',
		   "user_ico_select" => 'modules2.0/album/photo_ico_select.php',
		   "user_ico_cut" => 'modules2.0/users/user_ico_cut.php',
		   "user_archives" => 'modules2.0/users/user_archives.php',
		   "user_integral" => 'modules2.0/users/user_integral.php',
		   "user_hi"=>'modules2.0/users/user_hi.php',
		   "user_dressup"=>'modules2.0/users/user_dressup.php',
		   "user_affair" => 'modules2.0/users/affair_set.php',
		   'user_activate_succ' => 'modules2.0/users/user_activate_succ.php',
		   'user_activation' => 'modules2.0/users/user_activation.php',
		   'user_fri_recommended'=>'modules2.0/users/user_fri_recommended.php',
 		   'user_fri_rec_more'=>'modules2.0/users/user_fri_rec_more.php',
		   "all_app"=>'modules2.0/userapp/all_app.php',
		   "add_app"=>'modules2.0/userapp/add_app.php',
		   "mag_app"=>'modules2.0/userapp/mag_app.php',
		   "msg_notice" => 'modules2.0/msgscrip/notice.php',
		   "msg_creator" => 'modules2.0/msgscrip/creator.php',
		   "msg_minbox" => 'modules2.0/msgscrip/minbox.php',
		   "msg_moutbox" => 'modules2.0/msgscrip/moutbox.php',
		   "msg_rpshow" => 'modules2.0/msgscrip/rpshow.php',
		   "msg_rpshow2" => 'modules2.0/msgscrip/rpshow2.php',
		   "msgboard" => 'modules2.0/msgboard/msgboard.php',
		   "msgboard_more" => 'modules2.0/msgboard/msgboard_more.php',
		   "guest" => 'modules2.0/guest/guest.php',
           "guest2" => 'modules2.0/guest/guest2.php',
           "daren" => 'modules2.0/guest/daren.php',
		   "guest_more" => 'modules2.0/guest/guest_more.php',
		   "friend" => 'modules2.0/friend/friend.php',
		   "friend_all" => 'modules2.0/friend/friend_all.php',
		   "mood_friend" => 'modules2.0/mood/mood_friend.php',
		   "mood_more" => 'modules2.0/mood/mood_more.php',
		   "upload_form" => 'modules2.0/pubtools/upload.form.php',
		   "recent_affair" => 'modules2.0/recentaffair/rec_affair.php',
		   "recent_online" => 'modules2.0/recentaffair/rec_online.php',
		   "recent_affair13" => 'modules2.0/recentaffair/rec_affair13.php',
		   "recent_affair14" => 'modules2.0/recentaffair/rec_affair14.php',
		   "recent_affairlx" => 'modules2.0/recentaffair/rec_affairlx.php',
		   "remind" => 'modules2.0/uiparts/remind.php',
		   "remind_message" => 'modules2.0/uiparts/remind_message.php',
		   "refresh" => 'modules2.0/uiparts/refresh.php',
		   "restore" => 'modules2.0/restore/get_restore.php',
		   "share_list" => 'modules2.0/share/share_list.php',
		   "share_friend" => 'modules2.0/share/share_friend.php',
		   "share_show" => 'modules2.0/share/share_show.php',
		   "privacy" => 'modules2.0/privacy/home_access_set.php',
		   "pr_inputmess" => 'modules2.0/privacy/home_inputmess_set.php',
		   "pr_reqcheck" => 'modules2.0/privacy/request_check_set.php',
		   "poll_mine" => 'modules2.0/poll/poll_mine.php',
		   "poll" => 'modules2.0/poll/poll_show.php',
		   "poll_send" => 'modules2.0/poll/poll_send.php',
		   "poll_list" => 'modules2.0/poll/poll_list.php',
		   "poll_show_config" => 'modules2.0/poll/poll_show_config.php',

           "article_list" => 'modules2.0/article/article_list.php',
           "article_article" => 'modules2.0/article/article_article.php',
           "article_article2" => 'modules2.0/article/article_article2.php',
		   
		   "event_upload_photo" => 'modules2.0/event/event_upload_photo.php',
		   "event_update_photo"=>'modules2.0/event/event_update_photo.php',
		   "event_info" => 'modules2.0/event/event_info.php',
		   "event_space" => 'modules2.0/event/event_space.php',
		   "event_member" => 'modules2.0/event/event_member.php',
		   "event_show_photo" => 'modules2.0/event/event_show_photo.php',
		   "event_list_photo" => 'modules2.0/event/event_list_photo.php',
		   "event_list" => 'modules2.0/event/event_list.php',
		   "event" => 'modules2.0/event/event_mine.php',
		   "event_invite" => 'modules2.0/event/event_invite.php',
		   "event_member_manager" => 'modules2.0/event/event_member_manager.php',
		   "event_search" => 'modules2.0/event/event_search.php',
		   "event_search_list" => 'modules2.0/event/event_search_list.php',
		   
		   "ask" => 'modules2.0/ask/ask.php',
		   "ask_show" => 'modules2.0/ask/ask_show.php',
		   "ask_edit" => 'modules2.0/ask/ask_edit.php',
		   "ask_reply" => 'modules2.0/ask/ask_reply.php',

		   "user_recharge" => 'modules2.0/chongzhi/recharge.php',
		   "user_pay" => 'modules2.0/chongzhi/pay.php',
		   "user_paylog" => 'modules2.0/chongzhi/paylog.php',
		   "user_consumption" => 'modules2.0/chongzhi/consumption.php',
		   "user_upgrade" => 'modules2.0/chongzhi/upgrade.php',
		   "user_introduce" => 'modules2.0/chongzhi/introduce.php',
		   "user_help" => 'modules2.0/chongzhi/help.php',
		   
		   "gift" => 'plugins/gift/gift.php',

           "user_stamps" => 'modules2.0/stamps/stamps.php',
           "stamps_help" => 'modules2.0/stamps/help.php',

            "bott_creator" => 'modules2.0/bottle/creator.php',
            "bott_creator2" => 'modules2.0/bottle/creator2.php',
            "bott_in" => 'modules2.0/bottle/bottlein.php',
            "bott_out" => 'modules2.0/bottle/bottleout.php',
            "bott_reply" => 'modules2.0/bottle/reply.php',

            "bott_rpshow" => 'modules2.0/bottle/rpshow.php',

            "impression" => 'modules2.0/impression/impression.php',
			"email_num" => 'modules2.0/email/email_num.php',
            "gift_num" => 'modules2.0/email/gift_num.php',
            "wish" => 'modules2.0/wish/index.php',



            "cash" => 'modules2.0/chongzhi/cash.php',
			
       );

$appId=getAppId();

dbtarget('r',$dbServs);
$dbo=new dbex;
update_online_time($dbo,$tablePreStr."online");


if(array_key_exists($appId,$appArray)){
	$apptarget=$appArray[$appId];
//print_r($apptarget);exit();
	require($apptarget);exit;
}else{
	echo '<script>top.location.href="'.$siteDomain.$indexFile.'";</script>';
}
?>
