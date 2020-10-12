<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/email/email_num.html
 * 如果您的模型要进行修改，请修改 models/modules/email/email_num.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
/*
 * 此段代码由debug模式下生成运行，请勿改动！
 * 如果debug模式下出错不能再次自动编译时，请进入后台手动编译！
 */
/* debug模式运行生成代码 开始 */
if(!function_exists("tpl_engine")) {
	require("foundation/ftpl_compile.php");
}
if(filemtime("templates/default/modules/email/email_num.html") > filemtime(__file__) || (file_exists("models/modules/email/email_num.php") && filemtime("models/modules/email/email_num.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/email/email_num.html",1);
	include(__file__);
}else {
/* debug模式运行生成代码 结束 */
?><?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/email/email_num.html
 * 如果您的模型要进行修改，请修改 models/modules/email/email_num.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
/*
 * 此段代码由debug模式下生成运行，请勿改动！
 * 如果debug模式下出错不能再次自动编译时，请进入后台手动编译！
 */
/* debug模式运行生成代码 开始 */
if(!function_exists("tpl_engine")) {
	require("foundation/ftpl_compile.php");
}
if(filemtime("templates/default/modules/email/email_num.html") > filemtime(__file__) || (file_exists("models/modules/email/email_num.php") && filemtime("models/modules/email/email_num.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/email/email_num.html",1);
	include(__file__);
}else {
/* debug模式运行生成代码 结束 */
?><?php
	//引入模块公共权限过程文件
require("foundation/auser_mustlogin.php");
require("foundation/module_users.php");
require("foundation/fplugin.php");
require("api/base_support.php");
require("foundation/fdnurl_aget.php");
require("foundation/fgrade.php");
	require("foundation/fpages_bar.php");
	require("api/base_support.php");
	//引入语言包
	$m_langpackage=new msglp;
	$user_id=get_sess_userid();
	$dbo = new dbex;
	dbtarget('r',$dbServs);
    //未读邮件数量
    $sql="select count(*) as num from wy_msg_inbox where readed=0 and user_id=$user_id";
    $email = $dbo->getRow($sql);
	if($email){
		echo $email['num'];
	}else{
		echo 0;
	}
	
?><?php } ?><?php } ?>