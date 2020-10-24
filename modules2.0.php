<?php
header("content-type:text/html;charset=utf-8");
require("foundation/asession.php");
require("foundation/module_remind.php");
require("configuration.php");
require("includes.php");


$user_id = get_sess_userid();

if ($user_id) {
    $start = 'hstart';
} else {
    $start = 'homestart';
}
//当前可访问的应用工具
$appArray = array(
    "horn_iframe" => 'modules/horn_iframe.php',
    "u_chat" => 'modules/u_chat.php',
    "u_chat_info" => 'modules/u_chat_info.php',
    "u_emails" => 'modules/u_emails.php',
    "u_horn" => 'modules/u_horn.php',
    "u_horn_fs" => 'modules/u_horn_fs.php',
    "u_horn_buy" => 'modules/u_horn_buy.php',
    "u_horn_js" => 'modules/u_horn_js.php',
    "renzheng" => 'modules/renzheng.php',
    "gorenzheng" => 'modules/gorenzheng.php',
    "txrz" => 'modules/txrz.action.php',
    "start" => 'modules/start.php',
    "error" => 'modules/error.php',
    "search" => 'modules/search.php',
    "start13" => 'modules/start13.php',
    "start14" => 'modules/start14.php',
    "startlx" => 'modules/startlx.php',
    "hstart" => 'modules/' . $start . '.php',
    "blog_list" => 'modules/blog/blog_list.php',
    "blog" => 'modules/blog/blog_show.php',
    "blog_edit" => 'modules/blog/blog_edit.php',
    "blog_manager_sort" => 'modules/blog/blog_manager_sort.php',
    "blog_sort" => 'modules/blog/blog_sort.php',
    "blog_friend" => 'modules/blog/blog_friend.php',
    "group" => 'modules/group/group_mine.php',
    "group_creat" => 'modules/group/group_creat.php',
    "group_hot" => 'modules/group/group_hot.php',
    "group_manager" => 'modules/group/group_manager.php',
    "group_member_manager" => 'modules/group/group_member_manager.php',
    "group_info_manager" => 'modules/group/group_info_manager.php',
    "group_select" => 'modules/group/group_select.php',
    "group_space" => 'modules/group/group_space.php',
    "group_subject" => 'modules/group/group_subject.php',
    "search_group" => 'modules/group/search_group.php',
    "search_subject" => 'modules/group/search_subject.php',
    "group_sub_show" => 'modules/group/group_sub_show.php',
    "mypals" => 'modules/mypals/pals_list.php',
    "mypals_search" => 'modules/mypals/search_pals.php',
    "mypals_search2" => 'modules/mypals/search_pals2.php',
    "mypals_search_new" => 'modules/mypals/search_pals_new.php',
    "mypals_search_list" => 'modules/mypals/search_pals_list.php',
    "mypals_search_list2" => 'modules/mypals/search_pals_list2.php',
    "mypals_list" => 'modules/mypals/search_list.php',
    "mypals_online" => 'modules/mypals/online_list.php',
    "mypals_request" => 'modules/mypals/pals_request.php',
    "mypals_invite" => 'modules/mypals/pals_invite.php',
    "mypals_sort" => 'modules/mypals/pals_manager_sort.php',
    "mypals_fribirth" => 'modules/mypals/pals_fribirth.php',
    "mypals_fribirth_month" => 'modules/mypals/pals_fribirth_month.php',
    "album" => 'modules/album/album_list.php',
    "album_friend" => 'modules/album/album_friend.php',
    "album_edit" => 'modules/album/album_edit.php',
    "photo_upload" => 'modules/album/photo_upload.php',
    "photo_list" => 'modules/album/photo_list.php',
    "photo" => 'modules/album/photo_view.php',
    "photo_update" => 'modules/album/photo_update.php',
    "user_forget" => 'modules/users/user_forget.php',
    //"user_reg" => 'modules/users/user_reg.php',
    "user_info" => 'modules/users/user_info.php',
    "user_city" => 'modules/users/user_city.php',
    "user_pw_change" => 'modules/users/user_pw_change.php',
    "user_pw_reset" => 'modules/users/user_pw_reset.php',
    "user_ico" => 'modules/users/user_ico.php',
    "user_ico_select" => 'modules/album/photo_ico_select.php',
    "user_ico_cut" => 'modules/users/user_ico_cut.php',
    "user_archives" => 'modules/users/user_archives.php',
    "user_integral" => 'modules/users/user_integral.php',
    "user_hi" => 'modules/users/user_hi.php',
    "user_dressup" => 'modules/users/user_dressup.php',
    "user_affair" => 'modules/users/affair_set.php',
    'user_activate_succ' => 'modules/users/user_activate_succ.php',
    'user_activation' => 'modules/users/user_activation.php',
    'user_fri_recommended' => 'modules/users/user_fri_recommended.php',
    'user_fri_rec_more' => 'modules/users/user_fri_rec_more.php',
    "all_app" => 'modules/userapp/all_app.php',
    "add_app" => 'modules/userapp/add_app.php',
    "mag_app" => 'modules/userapp/mag_app.php',
    "msg_notice" => 'modules/msgscrip/notice.php',
    "msg_creator" => 'modules/msgscrip/creator.php',
    "msg_minbox" => 'modules/msgscrip/minbox.php',
    "msg_moutbox" => 'modules/msgscrip/moutbox.php',
    "msg_rpshow" => 'modules/msgscrip/rpshow.php',
    "msg_rpshow2" => 'modules/msgscrip/rpshow2.php',
    "msgboard" => 'modules/msgboard/msgboard.php',
    "msgboard_more" => 'modules/msgboard/msgboard_more.php',
    "guest" => 'modules/guest/guest.php',
    "guest2" => 'modules/guest/guest2.php',
    "daren" => 'modules/guest/daren.php',
    "guest_more" => 'modules/guest/guest_more.php',
    "friend" => 'modules/friend/friend.php',
    "friend_all" => 'modules/friend/friend_all.php',
    "mood_friend" => 'modules/mood/mood_friend.php',
    "mood_more" => 'modules/mood/mood_more.php',
    "upload_form" => 'modules/pubtools/upload.form.php',
    "recent_affair" => 'modules/recentaffair/rec_affair.php',
    "recent_online" => 'modules/recentaffair/rec_online.php',
    "recent_affair13" => 'modules/recentaffair/rec_affair13.php',
    "recent_affair14" => 'modules/recentaffair/rec_affair14.php',
    "recent_affairlx" => 'modules/recentaffair/rec_affairlx.php',
    "remind" => 'modules/uiparts/remind.php',
    "remind_message" => 'modules/uiparts/remind_message.php',
    "refresh" => 'modules/uiparts/refresh.php',
    "restore" => 'modules/restore/get_restore.php',
    "share_list" => 'modules/share/share_list.php',
    "share_friend" => 'modules/share/share_friend.php',
    "share_show" => 'modules/share/share_show.php',
    "privacy" => 'modules/privacy/home_access_set.php',
    "pr_inputmess" => 'modules/privacy/home_inputmess_set.php',
    "pr_reqcheck" => 'modules/privacy/request_check_set.php',
    "poll_mine" => 'modules/poll/poll_mine.php',
    "poll" => 'modules/poll/poll_show.php',
    "poll_send" => 'modules/poll/poll_send.php',
    "poll_list" => 'modules/poll/poll_list.php',
    "poll_show_config" => 'modules/poll/poll_show_config.php',

    "article_list" => 'modules/article/article_list.php',
    "article_article" => 'modules/article/article_article.php',
    "article_article2" => 'modules/article/article_article2.php',

    "event_upload_photo" => 'modules/event/event_upload_photo.php',
    "event_update_photo" => 'modules/event/event_update_photo.php',
    "event_info" => 'modules/event/event_info.php',
    "event_space" => 'modules/event/event_space.php',
    "event_member" => 'modules/event/event_member.php',
    "event_show_photo" => 'modules/event/event_show_photo.php',
    "event_list_photo" => 'modules/event/event_list_photo.php',
    "event_list" => 'modules/event/event_list.php',
    "event" => 'modules/event/event_mine.php',
    "event_invite" => 'modules/event/event_invite.php',
    "event_member_manager" => 'modules/event/event_member_manager.php',
    "event_search" => 'modules/event/event_search.php',
    "event_search_list" => 'modules/event/event_search_list.php',

    "ask" => 'modules/ask/ask.php',
    "ask_show" => 'modules/ask/ask_show.php',
    "ask_edit" => 'modules/ask/ask_edit.php',
    "ask_reply" => 'modules/ask/ask_reply.php',


    "user_pay" => 'modules/chongzhi/pay.php',
    "user_consumption" => 'modules/chongzhi/consumption.php',
    "user_upgrade" => 'modules/chongzhi/upgrade.php',
    "user_introduce" => 'modules/chongzhi/introduce.php',
    "user_help" => 'modules/chongzhi/help.php',

    "gift" => 'plugins/gift/gift.php',

    "user_stamps" => 'modules/stamps/stamps.php',
    "stamps_help" => 'modules/stamps/help.php',

    "bott_creator" => 'modules/bottle/creator.php',
    "bott_creator2" => 'modules/bottle/creator2.php',
    "bott_in" => 'modules/bottle/bottlein.php',
    "bott_out" => 'modules/bottle/bottleout.php',
    "bott_reply" => 'modules/bottle/reply.php',

    "bott_rpshow" => 'modules/bottle/rpshow.php',

    "impression" => 'modules/impression/impression.php',
    "email_num" => 'modules/email/email_num.php',
    "gift_num" => 'modules/email/gift_num.php',
    "wish" => 'modules/wish/index.php',

);

$appId = getAppId();

dbtarget('r', $dbServs);
$dbo = new dbex;

update_online_time($dbo, $tablePreStr . "online");


if (array_key_exists($appId, $appArray)) {
    $apptarget = $appArray[$appId];
    require($apptarget);
} else {
    echo '<script>top.location.href="' . $siteDomain . $indexFile . '";</script>';
}
?>
