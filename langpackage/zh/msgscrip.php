<?php
class msglp{
	
	var $qingchongzhi="金条不足，请充值";
	var $geshicuowu="格式错误";
	var $tupianguoda="图片过大";
	var $m_fanhuiliebiao="返回列表";
	var $m_qbsc="全部删除";
	var $m_jrgrzy="进入个人首页";
	var $m_jinbibuzu="金条不足，请充值 ";
	var $m_fanyitishi="是否继续？翻译邮件需要金条 ";
	var $m_weikong="内容不能为空";
	var $m_sheqi="舍弃";
	var $m_anquantishi="安全提示：请不要轻易透露您的联系方式，不要借钱给陌生人。";
	var $m_zixunjilu="咨询记录";
	var $m_uuchat="UUchat记录";
	var $m_fujian="附件";
	var $m_title="写  信";
	var $m_in="收件箱";
	var $m_out="发件箱";
	var $m_creat="新建邮件";
	var $m_to_user="收件人";
	var $m_from_user="发件人";
	var $m_cho="请选择";
	var $m_tit="话题";
	var $m_tupian="图片";
	var $m_translation="翻译";
	var $m_transno="不翻译";
	var $m_transzd="翻译";
	var $m_cont="内容";
	var $m_res = "回复";
	var $m_del="删除";
	var $m_time="日期";
	var $m_no_rd = "未读";
	var $m_rd = "已读";
	var $m_no_sed = "未发送";
	var $m_sed = "已发送";
	var $m_state="状态";
	var $m_ico="头像";
	var $m_all="全部";
	var $m_user = "用户";
	var $m_none_wrong="请选择要删除的邮件";
	var $m_b_con = "发送";
	var $m_b_bak = "返回";
	var $m_b_can = "取消";
	var $m_b_com = "回复";
	var $m_b_sed = "发送";
	var $m_del_ask="您确定要删除么？";
	var $m_each_fri = "同意了与您互为好友";
	var $m_agr_app = "同意了您的好友申请";
	var $m_rej_app = "拒绝了您的好友申请";
	var $m_app_fri = "添加您为好友";
	var $m_sys_send = "系统发送";
	var $m_each_friend = "同意了与您互为好友，其信息将自动添加到您的朋友圈里面。<br />此条信息为系统发送，不必回复 <br />您可以继续<a href=\"modules.php?app=mypals_search\">搜索其他好友</a><br>";
	var $m_agree_app = "同意了您的好友申请。<br />此条信息为系统发送，不必回复 <br />您可以继续<a href=\"modules.php?app=mypals_search\">搜索其他好友</a><br>";
	var $m_reject_app = "拒绝了您的好友申请。<br />此条信息为系统发送，不必回复 <br />您可以<a href=\"modules.php?app=mypals_search\">搜索其他好友</a><br>";
	var $m_app_friend = "添加您为好友。<br />此条信息为系统发送，不必回复 <br />您可以<a href=\"javascript:{send_join_js}\">加其为好友</a>或<a href=\"modules.php?app=mypals_search\">搜索其他好友</a><br>";
	var $m_choose="选择：";
	var $m_no_mys = "不能给自己发邮件！";
	var $m_del_suc = "删除成功！";
	var $m_one_err = "您填写的收件人信息有误,请查证后再发送！";
	var $m_cread_put = "您的金条不足，请充值购买邮票或升级后，可发送更多信息。";
	var $m_data_err = "数据错误，请重新创建！";
	var $m_send_err = "发送邮件失败,已存入发件箱!";
	var $m_add_exc = "更新内容超过160个字符！";
	var $m_no_one = "请选择收件人!";
	var $m_no_tit = "请输入邮件话题!";
	var $m_no_cont = "请输入邮件内容!";
	var $m_mess_detail = "邮件详情";
	var $m_out_none="对不起，您的发件箱内没有信息";
	var $m_in_none="对不起，您的收件箱内没有信息";
	var $m_num_mail="共有{num}封";
	var $m_remind="{num}封邮件";
	
	var $m_notice="公告";
	var $m_have_read="已阅读";
	var $m_unread="未阅读";
	var $m_given="发给";
	var $m_have_access="已查阅";
	var $m_to_notice="到通知";
	
	var $m_mess_china="附件";
	var $m_mess_english="翻译";
	var $m_Dos_notex="选择的收件人不存在。";
	var $m_stampsmsg="您的新用户体验时间已结束，请充值金条，使用金条兑换邮票，一张邮票与一位异性建立永久联系，如果您有金条，请使用金条直接兑换。";
	
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
	
	var $b_zhuangban='普通用户16级可以使用，高级用户无限制。';
	var $b_qunzu='普通用户16级以上可以建一个群组，高级用户无限制。';
	var $b_xianzhi='普通用户每天可发（40+等级）封邮件，您已经超限，请升级。';
	var $b_rizhi='普通用户每天可发（等级）篇日志，您已经超限，请升级。';
	
	
	
}
?>
