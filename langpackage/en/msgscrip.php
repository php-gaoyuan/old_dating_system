<?php
class msglp{
	var $qingchongzhi="Sorry, please recharge";
	var $geshicuowu="Invalid format";
	var $tupianguoda="Image is too large";
	var $m_fanhuiliebiao="Back to list";
	var $m_qbsc="Remove all";
	var $m_jrgrzy="Enter the personal home page";
	var $m_jinbibuzu="Gold is insufficient, please recharge ";
	var $m_fanyitishi="Whether to continue? Translate messages need gold ";
	var $m_weikong="Content can not be empty";
	var $m_sheqi="Abandon";
	var $m_anquantishi="Safety Tips：Please don't disclose your contact information and lend money to the strangers.。";
	var $m_zixunjilu="Counseling History";
	var $m_uuchat="UUchat Record";
	var $m_fujian="Attachment";
	var $m_title="Compose";
	var $m_in="Inbox";
	var $m_out="Outbox";
	var $m_creat="New email";
	var $m_to_user="Addressee";
	var $m_from_user="Sender";
	var $m_cho="Please select";
	var $m_tit="Topic";
	var $m_tupian="Picture";
	var $m_translation="Translate";
	var $m_transno="NO Translation";
	var $m_transzd="Translate";
	var $m_cont="Content";
	var $m_res = "Reply";
	var $m_del="Delete";
	var $m_time="Date";
	var $m_no_rd = "Unread";
	var $m_rd = "Read";
	var $m_no_sed = "Unsent";
	var $m_sed = "Sent";
	var $m_state="Status";
	var $m_ico="Avatar";
	var $m_all="All";
	var $m_user = "User";
	var $m_none_wrong="Please select the messages you want to delete";
	var $m_b_con = "Send";
	var $m_b_bak = "Return";
	var $m_b_can = "Cancel";
	var $m_b_com = "Reply";
	var $m_b_sed = "Send";
	var $m_del_ask="Are you sure you want to delete it？";
	var $m_each_fri = "Mutually agreed with your friends";
	var $m_agr_app = "Agreed to apply your friends";
	var $m_rej_app = "Rejected the application for your friends";
	var $m_app_fri = "Add you as a friend";
	var $m_sys_send = "System sends";
	var $m_each_friend = "Mutually agreed with your friends, the information will be automatically added to your circle of friends inside.<br />This entry information for the system to send, do not reply <br />You can continue<a href=\"modules.php?app=mypals_search\">Search other friends</a><br>";
	var $m_agree_app = "Agreed to apply your friends。<br />This entry information for the system to send, do not reply <br />您可以继续<a href=\"modules.php?app=mypals_search\">Search other friends</a><br>";
	var $m_reject_app = "Rejected the application for your friends.<br />This entry information for the system to send, do not reply <br />You can<a href=\"modules.php?app=mypals_search\">Search other friends</a><br>";
	var $m_app_friend = "Add you as a friend.<br />This entry information for the system to send, do not reply <br />You can<a href=\"javascript:{send_join_js}\">Add it to friends</a>Or<a href=\"modules.php?app=mypals_search\">Search other friends</a><br>";
	var $m_choose="Select：";
	var $m_no_mys = "Can not give myself mail！";
	var $m_del_suc = "Deleted successfully！";
	var $m_one_err = "You fill in the recipient information is incorrect, please verify before sending！";
	var $m_cread_put = "Your gold is not enough, please recharge and upgrade, you can send more information.";
	var $m_data_err = "Data error, please re-create！";
	var $m_send_err = "Failed to send mail, have been deposited in the Outbox!";
	var $m_add_exc = "Update more than 160 characters！";
	var $m_no_one = "Please select the recipient!";
	var $m_no_tit = "Please enter the e-mail subject!";
	var $m_no_cont = "Please enter a message!";
	var $m_mess_detail = "Mail details";
	var $m_out_none="Sorry, your outbox, no information";
	var $m_in_none="Sorry, your inbox is no information";
	var $m_num_mail="Total{num}seal";
	var $m_remind="{num}Mail";
	
	var $m_notice="System Messages";
	var $m_have_read="Have read";
	var $m_unread="Unread";
	var $m_given="Grant";
	var $m_have_access="Have examined";
	var $m_to_notice="Notice";
	
	var $m_mess_china="Attachment";
	var $m_mess_english="Translate";
	var $m_Dos_notex="Recipients selected does not exist.";
	var $m_stampsmsg="您的新用户体验时间已结束，请充值金币，使用金币兑换邮票，一张邮票与一位异性建立永久联系，如果您有金币，请使用金币直接兑换。";
	
}
class bottlelp{

	var $b_bottle='漂流瓶';
	var $b_find_one='捞一个';
	var $b_send_one='扔一个';
	var $b_find_bottle='收到的漂流瓶';
	var $b_send_bottle='扔出的漂流瓶';
	var $b_reply='回复';
	var $b_back='返回';
	var $b_type='种类';
	var $b_confirm='确定';
	
	var $b_normal='普通瓶';
	var $b_mood='心情瓶';
	var $b_city='同城瓶';
	var $b_ask='提问瓶';
	var $b_contacts='交往瓶';
	var $b_wish='祝愿瓶';
	
	var $b_range='您的漂流瓶漂到了{range}公里的海岸!';
	var $b_range2='您扔的漂流瓶石沉大海了';
	var $b_fail='很遗憾,您的漂流瓶没有扔出去!';
	var $b_nobottle='找不到该漂流瓶';
	var $b_ztbottle1='话题漂流瓶删除成功';
	var $b_ztbottle2='话题漂流瓶删除失败';
	var $b_dbottle1='漂流瓶删除成功';
	var $b_dbottle2='漂流瓶删除失败';
	
	var $b_quanxian='此功能暂不对普通用户开放，请升级高级会员';
	var $b_find='您捞到了一个漂流瓶,请在我的漂流瓶面板查看';
	var $b_nofind='很遗憾,您什么也没有捞到!';
	var $b_nofind2='很遗憾,您捞到了一条小鱼!';
	
	var $b_reply_s='回复成功!';
	var $b_reply_f='回复失败!';
	
	var $b_zhuangban='Normale Benutzer können mit 16, fortgeschrittene Benutzer unbegrenzt.';
	var $b_qunzu='Normale Benutzer können bauen eine mehr als 16 Gruppen, fortgeschrittene Benutzer unbegrenzt.';
	var $b_xianzhi='Normale Benutzer können jeden Tag (40 + Ebene) Nachrichten senden, Sie haben überlaufen, aktualisieren Sie bitte.';
	var $b_rizhi='Normale Benutzer können senden (Pegel) meldet sich jeden Tag, Sie überrannt haben, bitte aktualisieren.';
	
	
	
}
?>
