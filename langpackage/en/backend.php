<?php
/*
 * Created on 2009-11-20
 */
class back_publiclp{
	var $bp_select_deselect = "Select/Anti-election";
	var $bp_bulk_delete = "Batch Delete";
}

class foundationlp{
	var $f_wel_back="Welcome management background";
	var $f_set="By logging management platform, you can set the parameters of the site, and you can have timely access to the official patch updates and important notices。";
	var $f_data_num="站点数据统计";
	var $f_people_num="注册人数";
	var $f_group_num="群组总数";
	var $f_album_num="相册总数";
	var $f_photo_num="照片总数";
	var $f_blog_num="日志总数";
	var $f_online_num="在线人数";
	var $f_subject_num="话题总数";
	var $f_affair_num="动态总数";
	var $f_mess_num="留言总数";
	var $f_share_num="分享总数";
	var $f_new_official="官方最新动态";
	var $f_wel_web="欢迎访问我们的网站，并且下载最新的iweb sns软件产品，点击{url}iweb产品网";
	var $f_new_edition="官方最新版本";
	var $f_skill_serve="技术支持服务";
	var $f_official_bbs="官方交流论坛";
	var $f_Program_db_edition="程序数据库/版本";
	var $f_OS="操作系统";
	var $f_sever_edition="服务器环境版本";
	var $f_db_edition="数据库版本";
	var $f_sns_edition="当前程序版本";
	var $f_team="开发及测试";
	var $f_copyright="版权所有";
	var $f_ceo="系统设计";
	var $f_art="主题及UI";
	var $f_web="产品网站";
	var $f_sess_pre="session前缀设置";
	var $f_sess_pre_inf="（定义本系统的session前缀，默认：isns_）";
	var $f_site_set="站点设置";
	var $f_site_name="站点名称";
	var $f_domain="站点访问地址";
	var $f_keyword="站点关键字";
	var $f_description="站点描述";
	var $f_author="站点作者";
	var $f_mail="站点邮箱";
	var $f_copyright_inf="版权信息";
	var $f_record="ICP/IP/域名备案";
	var $f_close_say="站点关闭说明";
	var $f_open_err="开启错误报告";
	var $f_close_control="站点关闭控制";
	var $f_display_set="显示设置";
	var $f_main_dynamic_num="首页动态显示好友";
	var $f_home_dynamic_num="主页动态显示条数";
	var $f_cache="缓存功能";
	var $f_cache_update="缓存更新时间";
	var $f_page_num="缓存分页数";
	var $f_birthday="出生年月范围";
	var $f_article="注册服务条款";
	var $f_watering_set="防灌水设置";
	var $f_alternation_time="操作间隔时间";
	var $f_defer_time="延迟时间";
	var $f_filter_set="过滤设置";
	var $f_open_filter="开启过滤";
	var $f_filter_content="要过滤的词语";
	var $f_high_set="高级配置";
	var $f_support_library="使用的支持库";
	var $f_language_pack="站点默认语言包";
	var $f_index_pic="首页幻灯片图片";
	var $f_index_list="的相册列表：";
	var $f_select_pic="从他的相册中选择图片设置为首页幻灯图";
	var $f_now_index="当前幻灯图片：";
	var $f_site_name_annotations="（网站标题，显示在页面的左上角。如：聚易网）";
	var $f_check_domain="程序检测访问地址：";
	var $f_tip_domain="您设置的<站点访问地址>项与程序检测的路径不同，所以推荐好友，flash上传照片，添加收藏等功能会因此而无法找到正确的路径！\\n\\n您确定还要修改么？";
	var $f_keyword_annotations="（便于引擎查找，当输入多个时，用“，”或者“|”分隔。如：sns，聚易，iweb）";
	var $f_description_annotations="（网站的重点描述信息，让访客清楚了解网站概要。如：iweb sns交友网站）";
	var $f_click_set="点击设置完整地址";
	var $f_copyright_inf_annotations="（网站所属的版权。）";
	var $f_record_annotations="（信息产业部所颁发的备案信息。如：京ICP备09092256号 ）";
	var $f_close_say_annotations="（当选择网站关闭时，访客所看到的提示性信息。如：本网站正在进行维护更新。）";
	var $f_open_err_annotations="（是否开启网站的程序错误报告，当程序有错误时会在页面中给予提示，但会暴露出网站的漏洞。默认：关闭）";
	var $f_close_annotations="（关闭网站，此时任何人都无法访问站点内容。默认：打开）";
	var $f_main_dynamic_num_annotations="（首页显示好友动态（新鲜事）的人数。默认：5）";
	var $f_home_dynamic_num_annotations="（主页显示好友动态（新鲜事）的数据量。默认：10）";
	var $f_cache_annotations="（网站启动缓存功能，将大幅提升网站负载能力，增加网站性能，但数据更新会有延迟。默认：关闭）";
	var $f_cache_update_annotations="（更新缓存的间隔时间，当开启缓存时此参数才有效，参数单位为秒。默认：60）";
	var $f_page_num_annotations="（缓存的分页数。默认：10）";
	var $f_birthday_annotations="（网站出生年份的选择范围，格式：YYYY 。如：1940）";
	var $f_article_annotations="（用户注册时所需要同意的服务条款。支持html代码格式:&lt;br /&gt;换行；&lt;b&gt;加粗）";
	var $f_alternation_time_annotations="（每两次操作所间隔的时间，参数单位秒。默认：3秒）";
	var $f_defer_time_annotations="（当操作超过规定的时间，程序将延迟，参数单位秒。默认：5）";
	var $f_open_filter_annotations='（是否开启过滤功能，对于敏感的词语会自动替换为"*"(星号)。默认：关闭）';
	var $f_filter_content_annotations='（每两个词语之间用","(逗号) 或者 "|"(竖线)进行分隔。如：黄色,暴力）';
	var $f_group_admin_annotations="（群组所能设定的管理员数量。默认：3）";
	var $f_my_group_num_annotations="（每个用户所能创建群组数量。默认：3）";
	var $f_support_library_annotations="（可以更换的高级si类库路径地址，以便提升网站吞吐能力。默认：iweb_mini_lib/）";
	var $f_language_pack_annotations="（根据网站的“langpackage/”目录下的语言包文件来更换网站的默认语言。默认：zh）";
	var $f_open="开启";
	var $f_close="关闭";
	var $f_refer="提交";
	var $f_group_sort="群组类别管理";
	var $f_fir_sort="好友默认分类";
	var $f_arrange_num="排列序号";
	var $f_name="名称";
	var $f_handle="操作";
	var $f_del_con="确定删除此类别么？";
	var $f_del="删除";
	var $f_amend="修改";
	var $f_confirm="确定";
	var $f_cancel="取消";
	var $f_add_sort="添加类别";
	var $f_integral="积分规则";
	var $f_add_integral="增加积分操作";
	var $f_add="增加(+)";
	var $f_abatement_integral="减少积分操作";
	var $f_abatement="减少(-)";
	var $f_add_blog="发布日志";
	var $f_del_blog="日志被删除";
	var $f_add_poll="发布投票";
	var $f_del_poll="投票被删除";
	var $f_add_pic="上传图片";
	var $f_del_pic="图片被删除";
	var $f_add_com="发布评论/留言";
	var $f_del_com="评论/留言被删除";
	var $f_add_sub="发起话题";
	var $f_del_sub="话题被删除";
	var $f_add_reply="发布回帖";
	var $f_del_reply="回帖被删除";
	var $f_add_share="发布分享";
	var $f_del_share="分享被删除";
	var $f_request_friend="邀请好友注册成功";
	var $f_login="每天登录";
	var $f_set_head="设置头像";
	var $f_intergral_class="积分等级换算";
	var $f_change_num="图标兑换分数设置";
	var $f_upgrade_num="图标升级个数设置";
	var $f_amend_suc="修改成功！";
	var $f_index_suc="幻灯片添加成功！";
	var $f_img_preview="图像预览";
	var $f_handle_los="操作失败";
	var $f_none_photo="请选择图片";
	var $f_open_cookie="开启cookie";
	var $f_rewrite_info="普通：需要apache开启Rewrite模块，然后把docs目录下的.htaccess文件复制到网站根目录才能启用。<br>高级：不用apache开启设置，通过程序处理url。";
	var $f_rewrite_set="URL重写设置";
	var $f_mail_set="邮件设置";
	var $f_smtp_address="SMTP服务器地址";
	var $f_smtp_port="SMTP服务器端口";
	var $f_smtp_email="SMTP服务器邮箱";
	var $f_smtp_user="SMTP服务器用户名";
	var $f_smtp_password="SMTP服务器密码";
	var $f_general="普通";
	var $f_advanced="高级";
	var $f_site_logo="站点Logo";
	var $f_home_logo="用户主页Logo";
	var $f_site_logo_rule="请在上传前将图片的文件名命名为snslogo.gif，尺寸为(218 * 50)";
	var $f_home_logo_rule="请在上传前将图片的文件名命名为logo.gif，尺寸为(106 * 18)";
	var $f_person="人";
	var $f_item="条";
	var $f_page="页";
	var $f_second="秒";
	var $f_site_logo_upload_error="站点Logo上传错误";
	var $f_home_logo_upload_error="个人主页Logo上传错误";
	var $f_email_set_error="邮件设置修改错误";
	var $f_site_Set_error="站点设置修改错误";
	var $f_update_successful="更新成功";
	
	var $f_open_email_reg = "开启邮箱激活注册";
	var $f_form_yes = "是";
	var $f_form_no = "否";
	var $f_need_goto_email = "（开启后需进入自己的注册邮箱内，点击激活链接方可注册成功）";
	var $f_failure_time_activation= "邮箱激活码有效时间";
	var $f_day = "天";
	var $f_activation_valid_time = "（激活码生成后的有效时间，默认为7天0小时）";
	
	var $f_reg_set = "注册设置";
	var $f_open_new_user_reg = "开启新用户注册";
	var $f_yes = "是";
	var $f_no = "否";
	var $f_whether_allow_reg = "（网站是否允许用户注册）";
	var $f_open_invite_reg = "开启邀请注册";
	var $f_need_invite_reg = "（开启后需要填写邀请码才可以注册）";
	var $f_failure_time_invite= "邀请码失效时限";
	var $f_hour = "小时";
	var $f_invite_valid_time_hour = "（邀请码生成后的有效时间，单位:小时。默认：72）";
	var $f_invite_valid_time_minute = "（邀请码生成后的有效时间，单位:分钟。默认：1）";
	var $f_point = "分";
	var $f_takes_invite_points = "申请邀请码所花费积分";
	
}

class uilp{
	var	$u_get_false="获取最新的远程模板列表失败，请您稍后再试";
	var $u_loading="正在下载，请稍等...";
	var $u_compling="正在编译，请稍等...";
	var $u_user_skin="使用皮肤";
	var $u_choose_skin="选择皮肤";
	var $u_open="启用";
	var $u_comp_type1="模板编译方式：服务模式";
	var $u_comp_type2="调试模式";
	var $u_comp_info="选择了新的模板编译方式后，必须重新编译模板设置才会生效。\\n\\n现在是否开始编译模板？";
	var $u_ctrl="操作";
	var $u_sure="确定";
	var $u_cancel="取消";
	var $u_download="下载";
	var $u_change_dir="更改目录";
	var $u_ask_tpl="您确定要下载此模板么？";
	var $u_ask_skin="您确定要下载此皮肤么？";
	var $u_new_list="可下载的模板列表";
	var $u_tpl_name="模板方案名称";
	var $u_dir_pos="下载到目录";
	var $u_temp_admin="模板管理";
	var $u_temp_list="模板方案";
	var $u_amend_time="修改时间";
	var $u_currently_apply="当前使用";
	var $u_admin_handle="管理操作";
	var $u_app_temp="应用模板";
	var $u_admin_temp="管理模板";
	var $u_admin_con="此功能会改变网站整体风格，对您的网站产生重大影响，确定要整体编译此模板么？";
	var $u_tpl_prompt_1="1，当前列出了从远程服务器上可以下载的模板，点击 \"下载\" 即可把他们下载到模板目录templates目录中，并在 \"模板管理\" 中使用。";
	var $u_tpl_prompt_2="2，下载最新的模板需要产品授权，详情请登陆我们的官方主站：http://www.jooyea.net";
	var $u_skin_prompt_1="1，当前列出了从远程服务器上可以下载的皮肤，点击 \"下载\" 即可把他们下载到皮肤目录skin目录中，并在 \"皮肤管理\" 中使用。";
	var $u_skin_prompt_2="2，下载最新的皮肤需要产品授权，详情请登陆我们的官方主站：http://www.jooyea.net";
	var $u_prompt_inf="提示信息";
	var $u_prompt_1="1、所有模板方案都保存在 /templates/ 目录下；";
	var $u_prompt_2="2、网站当前使用的模板方案为：{default} ，保存路径为： /templates/{default}/ ，对于其他模板方案的变化不会影响网站前台的显示；";
	var $u_prompt_3="3、如果您需要增加网站模板方案，请把新的模板方案根据网站的根目录结构整理复制到 /templates/ 目录中；";
	var $u_prompt_4="4、如果您需要应用新的网站模板方案，请点击应用模板，但是其目录结构一定要与根目录结构像匹配；";
	var $u_prompt_5="5、应用模板操作会把当前的风格样式替换成所选择的方案，替换时要谨慎；";
	var $u_prompt_6="6、如果替换时发生错误可以进入站点UI恢复——>恢复模板，进行恢复；";
	var $u_skin_1="1、当前列出的皮肤方案保存在 /skin/{template}/ 目录下，这是和您选择的模板方案相匹配的，每个模板方案可以对应多个皮肤方案；";
	var $u_skin_2="2、直接点击“应用皮肤”就可以看到效果，不用再进行编译；皮肤方案名不要用中文，以免产生乱码";
	var $u_skin_3="3、如果您需要增加网站皮肤方案，请把新的皮肤方案根据网站的模板目录结构整理复制到 \"/skin/模板方案名\" 目录中 ；";
	var $u_skin_4="4、应用皮肤操作会把当前的风格样式替换成所选择的方案，替换时要谨慎；";
	var $u_skin_5="5、如果替换时发生错误可以进入站点UI恢复——>恢复皮肤，进行恢复；";
	var $u_skin_plan="皮肤方案";
	var $u_app_skin="应用皮肤";
	var $u_tempfile_list="模板文件列表";
	var $u_choice="选择";
	var $u_file_name="文件名";
	var $u_check="全选/反选";
	var $u_compile="批量编译";
	var $u_list_back="返回列表";
	var $u_clew_inf="提示信息";
	var $u_temp_save="当前模板保存在 <font color='red'>/templates/{temp}</font>目录";
	var $u_do_flow="iweb_sns 模板制作与标签设置的基本流程：";
	var $u_flow_1="1、通过Deamweaver、Fireworks、Flash 和 Photoshop 等软件设计好 html 页面；";
	var $u_flow_2="2、根据页面布局插入标签，标签的具体规则请参考手册；";
	var $u_flow_3="3、在 /templates 目录下建立一个新的模板目录，然后把做好的 html 页面按照 iweb_sns 模板命名规则命名并存放到模板目录；";
	var $u_flow_4="4、登录iweb_sns后台，进入“模板管理”，把自己新建的模板方案设置为使用方案；";
	var $u_flow_5="5、编译后即可看到页面效果；";
	var $u_flow_6="6，模板方案的目录结构一定要与网站的根目录结构相同，请参考templates/default下的目录结构；";
	var $u_file_no="没有选择方案！";
	var $u_amend="修改";
	var $u_compile_state="编译状态";
	var $u_skin_admin="皮肤管理";
	var $u_amend_temp="修改模板";
	var $u_belong_temp="所属模板";
	var $u_temp_path="模板路径";
	var $u_last_amend_time="上次修改时间";
	var $u_save="保存";
	var $u_reset="重置";
	var $u_amend_suc="修改成功!";
	var $u_worning="警告：执行当前操作会覆盖您站点当前的相关程序文件！强烈建议您先做好文件备份！\\n提示：当您的网站运行良好的状态下不要使用此操作！\\n您确定还要执行此操作么？";
	var $u_re_worning="您已经做好备份，并且确定要执行此恢复操作么？";
	var $u_UI_cback="UI修复";
	var $u_cback_temp="恢复模板";
	var $u_cback_temp_say="1，当您的网站页面的显示出现问题时，可以使用此功能把前台页面恢复到初始状态；	<br />
		2，恢复缺省的模板文件到templates/default目录下，在此目录下的文件，将会被替换掉；<br />
		3，恢复完毕后，可以到模板管理——>应用模板，选择default模板方案并且进行编译，从而使页面恢复到默认样式；<br />";
	var $u_cback_model="恢复模型";
	var $u_cback_model_say="1，当您的网站功能出现问题，程序发生错误时，可以使用此功能把程序文件恢复到初始状态；<br />
			2，恢复缺省的数据模型文件到models/目录下，在此目录下的文件，将会被替换掉；<br />
			3，恢复完毕后，可以到模板管理——>应用模板，选择相应的模板方案并且进行编译，从而恢复程序功能；<br />";
	var $u_cback_skin="恢复皮肤";
	var $u_cback_skin_say="1，当您的网站样式皮肤出现问题，或者想恢复到初始样式，可以使用此功能；<br />
			2，恢复缺省的样式皮肤文件到skin/default/jooyea目录下，在此目录下的文件将会被覆盖掉；<br />";
	var $u_cback_all="恢复整体编译结果";
	var $u_cback_all_say="1，当您的网站有错误，并且执行了以上恢复操作都无法解决问题，可以使用此功能来对网站系统进行恢复；<br />
		2，此UI恢复功能的使用，会对您的网站系统产生巨大的影响，此操作会把现有的功能，界面等恢复到默认初始化时的状态。<br />
		3，此操作是将网站缺省的编译结果直接覆盖到您的网站内，执行完毕后，网站可以立即使用；<br />";
	var $u_make_suc="创建目录 {dir} /成功!";
	var $u_make_lose="创建目录 {dir} /失败!";
	var $u_cback_suc="恢复 {dir} 成功!";
	var $u_cback_lose="恢复 {dir} 失败!";
	var $u_back="返回上一级";
	var $u_none="没有选择要下载的模板方案";
	var $u_none_url="没有填写存放下载模板的路径";
	var $u_dir_used="目录已经被占用，请重新填写存放目录";
	var $u_down_false="<font color='red'>文件下载失败</font><br />";
	var $u_file_suc="下载{file}成功！<br />";
	var $u_dir_suc="创建目录{dir}成功！<br />";
	var $u_skins_list="可下载的皮肤列表";
}
class modulelp{
	//public
	var $m_check_condition="筛选条件";
	var $m_result_order="结果排序";
	var $m_def_order="默认排序";
	var $m_asc="递增";
	var $m_desc="递减";
	var $m_page_20="每页显示20条";
	var $m_page_50="每页显示50条";
	var $m_page_100="每页显示100条";
	var $m_search="搜索";
	var $m_red="带 ' <font color=red>*</font> ' 的表示支持模糊查询";
	var $m_none_data="没有查询到与条件相匹配的数据";
	var $m_content="内容";
	var $m_time="时间";
	var $m_del="删除";
	var $m_ctrl="操作";
	var $m_lock="锁定";
	var $m_normal="正常";
	var $m_unlock="解锁";
	var $m_ask_lock="确定要锁定?";
	var $m_ask_del="确定要删除?";
	var $m_state="状态";
	var $m_issue_time="发布时间";
	var $m_comments="评论数";
	var $m_type="类型";
	var $m_public_pro="公开性质";
	var $m_public="公开";
	var $m_only="仅好友";
	var $m_only_self="仅自己";
	var $m_preg_link="分享了链接地址";
	var $m_astrict_no="不限";
	var $m_blog="日志";
	var $m_subject="话题";
	var $m_album="相册";
	var $m_photo="图片";
	var $m_group="群组";
	var $m_poll="投票";
	var $m_share="分享";
	var $m_space="空间";
	var $m_mood="心情";
	var $m_date_wrong="日期格式输入不正确,如:2009-01-01";
	var $m_userid="用户UID";
	var $m_author_id="作者UID";
	var $m_author_name="作者名";
	var $m_uname="用户名";
	var $m_ip="用户ip";
	var $m_no_pri="对不起，您所在的用户组没有该权限";
	//group
	var $m_name="名称";
	var $m_group_list="群组列表";
	var $m_greator="创建者";
	var $m_great_date="成立时间";
	var $m_member_num="成员数";
	var $m_sub_num="话题数";
	var $m_free_join="自由加入";
	var $m_check_join="验证加入";
	var $m_check_rejuse="拒绝加入";
	var $m_join_type="加入权限";
	var $m_group_id="指定群组ID";
	//feed
	var $m_feed_list="动态列表";
	var $m_feed_id="动态ID";
	//member
	var $m_member_list="会员列表";
	var $m_ico="头像";
	var $m_normal_member="普通用户";
	var $m_lock_member="锁定用户";
	var $m_recomed="已推荐";
	var $m_recom="推荐";
	var $m_sex="性别";
	var $m_man="男";
	var $m_woman="女";
	var $m_reg_date="注册时间";
	var $m_login_date="登录时间";
	var $m_area="按地域城市";
	var $m_online="在线";
	var $m_guest="访问量";
	var $m_inter="积分";
	var $m_last_login="最后登录时间";
	var $m_more="查看详细";
	var $m_visitor_home="访问主页";
	var $m_email="邮箱";
	//blog
	var $m_blog_list="日志列表";
	var $m_title="标题";
	var $m_blog_id="指定日志ID";
	var $m_scanf_num="查看数";
	var $m_reply_num="回复数";
	var $m_send_date="发布时间";
	//poll
	var $m_poll_num="投票数";
	var $m_poll_list="投票列表";
	var $m_sendor="发布者";
	var $m_award_inter="悬赏积分";
	var $m_over_date="已过期";
	var $m_no_over="未过期";
	var $m_over="过期投票";
	var $m_poll_limit="投票限制";
	var $m_comments_limit="评论限制";
	var $m_poll_id="指定投票ID";
	//recommend
	var $m_recom_value="推荐度";
	var $m_top="置顶";
	var $m_cancel="取消推荐";
	var $m_order="排序";
	var $m_app_order="应用排序";
	var $m_top_recom="置顶推荐";
	var $m_cancel_recom="取消置顶";
	var $m_num_no="排序值为数字";
	var $m_index_pic="置顶幻灯";
	var $m_batch_order="批量排序";
	//report
	var $m_report_type="举报类型";
	var $m_creat_time="创建时间";
	var $m_report_list="举报列表";
	var $m_report_reason="举报理由";
	var $m_informer="举报人";
	var $m_handle="操作";
	var $m_handle_con="本操作不可恢复，确认继续？";
	var $m_del_report="删除举报";
	var $m_lock_type="删除举报及{type}信息";
	var $m_rep_num="举报次数";
	//share
	var $m_share_id="指定分享ID";
	var $m_share_list="分享列表";
	var $m_share_p="分享人";
	var $m_share_type="分享类型";
	//msgboard
	var $m_mess_id="留言ID";
	var $m_mess_uid="留言UID";
	var $m_mess_name="留言者";
	var $m_mess_by_id="被留言UID";
	var $m_mess_time="留言时间";
	var $m_mess_list="留言列表";
	//comment
	var $m_com_type="评论类型";
	var $m_com_uid="评论UID";
	var $m_com_name="评论者";
	var $m_com_by_uid="被评论UID";
	var $m_com_time="评论时间";
	var $m_com_list="评论列表";
	var $m_com_by_id="被评论ID";
	//photo
	var $m_alb_id="所在相册ID";
	var $m_pho_id="指定图片ID";
	var $m_pho_inf="图片说明";
	var $m_upd_time="上传时间";
	var $m_pho_list="照片列表";
	var $m_com_admin="评论管理";
	//album
	var $m_album_name="相册名";
	var $m_album_id="相册ID";
	var $m_pho_num="图片数";
	var $m_alb_list="相册列表";
	var $m_admin_com="管理评论";
	//subject
	var $m_sub_id="话题ID";
	var $m_see_num="查看数";
	var $m_sub_list="话题列表";
	var $m_author="作者";
	var $m_reply="回复";
	var $m_see="查看";
	var $m_see_particular="查看详细";
	var $m_del_suc="删除成功！";
	var $m_del_lose="删除失败！";
	var $m_recomed_lose="推荐失败！";
	//心情
	var $m_mood_list="心情列表";
	
	var $m_information="的资料";
	var $m_names="姓名";
	var $m_marriage_status="婚恋状态";
	var $m_secrecy="保密";
	var $m_single="单身";
	var $m_married="已婚";
	var $m_birthday="生日";
	var $m_years="年";
	var $m_month="月";
	var $m_day="日";
	var $m_not_filled="未填";
	var $m_blood_type="血型";
	var $m_hometown="家乡";
	var $m_location="所在地";
}

class softwarelp{
	var $so_tip_inf="提示信息";
	var $so_list_false="获取程序升级列表失败";
	var $so_last_version="系统当前版本为最新版本，没有可升级的版本";
	var $so_update_list="软件升级列表";
	var $so_soft_version="软件版本";
	var $so_time="时间";
	var $so_ctrl="操作";
	var $so_ask_update="你确定要直接升级到此版本么？";
	var $so_act_update="立即升级到此版本";
	var $so_loction_version="当前软件版本：{version}";
	var $so_pro_1="1，“软件升级列表”列出了系统目前可以升级到的版本，升级模式是在线一键式升级，支持跨版本升级。";
	var $so_pro_2="2，升级成功后系统版本自动更新，且不可以恢复到升级前的版本，所以升级需做好备份工作。";
	var $so_pro_3="3，关于升级方面的任何问题可以登录到jooyea.net寻求帮助。";
	var $so_success="成功";
	var $so_false="<font color=red>失败</font>";
	var $so_update_success="升级完成";
	var $so_update_false="升级失败";
	var $so_sql_result="sql语句执行{result}<br />";
	var $so_dir_result="创建目录{dir}{result}<br />";
	var $so_del_file_result="删除文件{file}{result}<br />";
	var $so_del_dir_result="删除目录{dir}{result}<br />";
	var $so_download_result="下载文件{file}{result}<br />";
}

class pluginslp{
	var $pl_unset="未安装";
	var $pl_install="安装";
	var $pl_isset="已安装";
	var $pl_unload="卸载";
	var $pl_next_step="下一步";
	var $pl_guide="IWebSNS插件向导";
	var $pl_install_info="插件安装说明";
	var $pl_install_worning="插件分为官方插件和第三方插件两种，由第三方开发的插件请确定安全性后再安装，或者下载官方推荐的插件。";
	var $pl_sure="确 定";
	var $pl_unload_info="插件卸载说明";
	var $pl_unload_remind="插件卸载后不会影响系统的运行，请放心卸载！";
	var $pl_update="更 新";
	var $pl_manage_str="IWebSNS插件管理";
	var $pl_manage="插件管理";
	var $pl_set_update="对插件进行设置更新";
	var $pl_worning="警告：插件删除后，不能修复，您确定删除此插件吗？";
	var $pl_unset_state="此插件还未安装";
	var $pl_list="插件列表";
	var $pl_name="插件名称";
	var $pl_state="状态";
	var $pl_ctrl="操作";
	var $pl_select_site="选择安装位置";
	var $pl_update_suc="更新成功！";
	var $pl_update_false="更新失败！";
	var $pl_site_info="说明：安装位置指插件要在系统中显示的位置。";
	var $pl_is_order="是否自由订制";
	var $pl_order_info="自由订制是指，此插件允许用户自己控制插件是否显示。";
	var $pl_inspire="是否启用";
	var $pl_inspire_info="启用是指，插件是否生效。";
	
	var $pl_widget_plugin="Widget插件";
	var $pl_app_application="APP应用";
	var $pl_plug_description="插件描述";
	var $pl_details="详细说明";
	var $pl_version_number="版本号";
	var $pl_author="作者";
	var $pl_developer_home="开发者主页";
	var $pl_placements="展示位置";
	var $pl_import_documents="入口文件";
	var $pl_other_information="其它信息";
	var $pl_database_file="数据库文件";
	var $pl_plugin_not_installed="插件配制信息不全，不具备安装条件！";
	
	var $pl_success="成功";
	var $pl_failure="失败";
	var $pl_database_success="数据库文件已经配制成功!";
	var $pl_database_failure="数据库文件配制失败!";
	var $pl_table="表";
	var $pl_presence="已经存在";
	var $pl_unable_install="致使插件无法安装!";
	var $pl_can_installed="此插件具备强行安装条件,点击下一步将强行安装!";
	var $pl_can_not_installed="此插件不具备强行安装条件,安装终止!";
	
	var $pl_plugin_permissions="插件权限";
	var $pl_plugin_success_install="插件已经成功安装!";
	var $pl_if_ordered="是否自由订制";
	var $pl_enabled="是否启用";
	var $pl_if_ordered_definition="自由订制是指，此插件允许用户自己控制插件是否显示。";
	var $pl_enabled_definition="启用是指，插件是否生效。";
	
	var $pl_back_link_address="后台链接地址";
	var $pl_management_entrance="管理入口";
	var $pl_uninstall_successful="此插件卸载成功!";
	var $pl_delete_successful="已成功删除";
}

class datalp{
	var $d_db_backup="数据库备份";
	var $d_choice="选择";
	var $d_db_id="ID";
	var $d_db_table="数据库表";
	var $d_check_all="全选";
	var $d_refer="提交";
	var $d_boject_no="没有选择操作对象";
	var $d_backup_suc="已全部备份完成,备份文件保存在docs目录下";
	var $d_db_cback="数据库恢复";
	var $d_file_name="文件名";
	var $d_edition="版本";
	var $d_backup_time="备份时间";
	var $d_sub_volume="卷号";
	var $d_lead="导入";
	var $d_del="删除";
	var $d_lead_con="确定要导入么？";
	var $d_del_con="确定删除么？";
	var $d_lead_suc="导入成功！";
	var $d_del_suc="备份文件已删除！";
}

class toollp{
	var $t_total_del_num="发现有{num}个测试用户<br />";
	var $t_del_start="开始清理要删除的用户在各个模块中的数据......<br />";
	var $t_none_test="对不起，未在您的系统中发现测试数据";
	var $t_onclick_act="点击运行";
	var $t_tip_inf="提示信息";
	var $t_none_tool="对不起，您的系统当前还没有添加任何工具";
	var $t_ask_action="你确定要执行{tool}么？";
	var $t_list="工具箱列表";
	var $t_tool_pro_1="1，\"工具箱列表\" 列出了目前系统内所有可用的工具箱组件，其路径在后台目录(sysadmin)->toolsBox目录下。";
	var $t_tool_pro_2="2，您可以通过 \"下载工具箱\" 操作，来获取最新的工具箱组件；您也可以通过 \"工具箱管理\" 来卸载不需要的工具箱组件。";
	var $t_tool_pro_3="3，只要您遵循我们的组件规范，您也可以自己编写工具箱组件，详情请参考我们开发手册。";
	var $t_tool_pro_4="4，下载最新的模板需要产品授权，详情请登陆我们的官方主站：http://www.jooyea.net";
	var $t_download_none="您的系统当前没有可下载的工具箱";
	var $t_get_false="获取最新的远程工具箱列表失败，请您稍后再试";
	var $t_loading="正在下载，请稍等...";
	var $t_id_wrong="工具编号发生错误！";
	var $t_not_stand="您的工具箱列表文件不符合规范，请仔细检查";
	var $t_not_find="没有找到您本地的工具箱列表";
	var $t_false_connect="链接远程服务器失败！";
	var $t_sql_false="sql执行失败";
	var $t_isset_tool="下载失败，该\"工具编号\"已经存在，请检查工具箱列表文件";
	var $t_success="下载工具组件成功";
	var $t_name="名称";
	var $t_code_num="工具编号";
	var $t_time="时间";
	var $t_author="作者";
	var $t_ctrl="操作";
	var $t_ask_download="您确定要下载此工具么？";
	var $t_download="下载";
	var $t_download_pro_1="1，当前列出了您的系统中没有集成的工具组件，点击 \"下载\" 即可把他们下载到后台目录(sysadmin)->toolsBox目录中，并在 \"工具箱列表\" 中使用。";
	var $t_download_pro_2="2，工具组件的编号是唯一的，如果您的系统中没有列表中的某个工具，却又下载不了，请您修改后台目录(sysadmin)->toolsBox目录中的 \"tool.xml\" 文件。";
	var $t_download_pro_3="3，下载最新的模板需要产品授权，详情请登陆我们的官方主站：http://www.jooyea.net";
	var $t_tool_manage="工具箱管理";
	var $t_ask_unset="您确定要卸载此工具么？";
	var $t_unset="卸载";
	var $t_manage_pro_1="1，当前列出您系统中集成的工具箱组件，点击 \"卸载\" 即可把不需要的组件从系统中卸载掉。";
	var $t_manage_pro_2="2，工具箱组件存放在后台目录(sysadmin)->toolsBox目录中，详情请参考开发手册。";
	var $t_manage_pro_3="3，下载最新的模板需要产品授权，详情请登陆我们的官方主站：http://www.jooyea.net";
	var $t_code_wrong="工具编号发生错误！";
	var $t_unload_sucess="卸载成功";
	var $t_unload_false="卸载失败，请检查工具配置文件";
}

class errorlp{
	var $er_error_1="授权码不正确";
	var $er_error_2="链接远程服务器失败";
	var $er_error_3="您的授权码已经到期";
	var $er_error_4="您的授权码已经被封";
	var $er_error_5="获取远程升级列表失败";
	var $er_error_6="没有选择要查看更新模块";
	var $er_error_7="没有授权码或升级模块为空";
	var $er_error_8="没有找到要下载的文件";
	var $er_error_9="对不起，当前没有可下载的资源";
}

class pwlp{
	var $p_null="用户名和密码不能为空！";
	var $p_differ="两次密码输入不一致，请重新输入！";
	var $p_amend_pw="修改用户名密码";
	var $p_name="用户名";
	var $p_formerly_pw="原始密码";
	var $p_new_pw="新密码";
	var $p_new_pw_repeat="重复密码";
	var $p_refer="提交";
	var $p_cancel="取消";
}

class loginlp{
	var $l_manage="后台管理";
	var $l_help="在线帮助";
	var $l_mismatch="用户名或密码不匹配";
	var $l_backend="后台管理";
	var $l_null="登录名与密码不能为空";
	var $l_login_entrance="后台登录入口";
	var $l_login_admin="登录管理面板";
	var $l_name="用户名";
	var $l_pw="密码";
	var $l_forget="忘记您的密码了?";
	var $l_login="登录";
	var $l_title="iwebAx软件产品家族";
	var $l_login_again="请重新登录";
	var $l_wel_login="欢迎登录，今天是";
	var $l_login_name="登录名";
	var $l_login_hello="您好";
	var $l_permissions="权限为";
	var $l_super_admin="超级管理员";
	var $l_amend_pw="修改密码";
	var $l_out="退出";
	var $l_index="首页";
	
	var $l_back_management_sys="后台管理系统";
	var $l_Management_home="管理首页";
	var $l_global_set="全局设置";
	var $l_user_management="用户管理";
	var $l_administration="管理";
	var $l_app_management="应用管理";
	var $l_tool_box="工 具 箱";
	
}

class adminmenulp{
	var $ad_global_set="全局设置";
	var $ad_user_management="用户管理";
	var $ad_manage_skin="皮肤管理";
	var $ad_basic_set="基本设置";
	var $ad_manage_index="管理首页";
	var $ad_site_set="站点设置";
	var $ad_group_sort="群组分类";
	var $ad_pals_sort="好友分类";
	var $ad_inter_rule="积分规则";
	var $ad_ui_set="UI管理";
	var $ad_manage_tpl="模板管理";
	var $ad_ui_restore="站点UI恢复";
	var $ad_manage_mod="应用管理";
	var $ad_manage_msg="留言管理";
	var $ad_manage_feed="动态管理";
	var $ad_manage_com="评论管理";
	var $ad_manage_sub="话题管理";
	var $ad_manage_gro="群组管理";
	var $ad_manage_poll="投票管理";
	var $ad_manage_blog="日志管理";
	var $ad_manage_recom="推荐会员";
	var $ad_manage_member="会员管理";
	var $ad_manage_photo="照片管理";
	var $ad_manage_album="相册管理";
	var $ad_manage_share="分享管理";
	var $ad_manage_report="举报管理";
	var $ad_manage_mood="心情管理";
	var $ad_manage_data="数据管理";
	var $ad_backup_data="备份数据";
	var $ad_restore_data="恢复数据";
	var $ad_manage_plug="插件管理";
	var $ad_download_skin="下载皮肤";
	var $ad_download_tpl="下载模板";
	var $ad_download_plug="下载插件";
	var $ad_manager_plug="管理插件";
	var $ad_update_online="在线升级";
	var $ad_update_main="升级主程序";
	var $ad_tools="工具箱";
	var	$ad_tools_list="工具箱列表";
	var $ad_tools_download="下载工具箱";
	var $ad_tools_manage="工具箱管理";
	var $ad_guest_limit="访问限制";
	var $ad_rights_manage="权限管理";
	var $ad_users_manage="管理员角色分配";
	var $ad_manage_users="管理员角色管理";
	var $ad_front_manage="前台角色管理";
	var $ad_front_users="用户角色分配";
	var $ad_member_role_distribution = "会员角色分配";
	var $ad_member_role_management = "会员角色管理";
	var $ad_modify_admin_password = "修改管理员密码";
	var $ad_invite_code_management = "邀请码管理";
	var $ad_member_recommend_management = "会员推荐管理";
	
	var $ad_location="当前位置";
	var $ad_compile_status="编译状态";
	var $ad_change_password="修改密码";
	var $ad_amend_temp="修改模板";
	var $ad_top_slide="置顶幻灯";
	var $ad_image_cut="图片剪切";
	var $ad_member_details="会员详细信息";
	var $ad_front_role_rights="前台角色分配权限";
	var $ad_back_role_rights="后台角色分配权限";
}

class limitlp{
	var $li_update_suc="更新成功";
	var $li_refuse_ip="禁止访问的ip列表";
	var $li_refuse_ip_info="用户的ip地址如果处于本列表中则禁止访问站点。注：每个 IP 一行，既可输入完整地址，例如：127.0.0.1 也可以输入IP段或者ip头。如192.168.1.* 或 192.168.";
	var $li_refuse_time="禁止访问的时间段";
	var $li_refuse_time_info="每天该时间段内用户不能访问网站，请使用 24 小时时段格式，每个时间段一行，如需要也可跨越零点，留空为不限制。例如:每日晚 11:25 到次日早 5:05 可设置为: 23:25-5:05每日早 9:00 到当日下午 2:30 可设置为: 9:00-14:30";
	var $li_refuse_action="禁止交互的时间段";
	var $li_refuse_action_info="每天该时间段内用户不能与网站进行交互，每个时间段为一行，时间格式同上";
	var $li_submit="提交";
}

class rightlp{
	var $ri_refuse="拒绝访问此页面";
	var $ri_choose="请选择";
	var $ri_isset_user="此用户已经存在！";
	var $ri_add_manager="添加管理员";
	var $ri_users="用户组";
	var $ri_referrer="推荐人";
	var $ri_purple="紫币";
	var $ri_add_users="添加用户";
	var $ri_users_list="用户列表";
	var $ri_add="添加";
	var $ri_empty_wrong="请为此管理员选择用户组";
	var $ri_pass_wrong="密码必须不能少于6个字符";
	var $ri_allot="分配权限";
	var $ri_local_user="当前的用户组";
	var $ri_all_select="全选";
	var $ri_isset_id="此组ID已经存在！";
	var $ri_refuse_id="此组ID已被系统禁用！";
	var $ri_user_wrong="用户组名称不能为空";
	var $ri_empty_info="用户组id和用户组名称不能为空";
	var $ri_user_manage="用户组管理";
	var $ri_user_name="用户组名称";
	var $ri_user_id="用户组ID";
	var $ri_no_pri="对不起，您所在的用户组没有该权限";
}
?>
