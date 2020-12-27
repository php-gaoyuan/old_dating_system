<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/guest/guest2.html
 * 如果您的模型要进行修改，请修改 models/modules/guest/guest2.php
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
if(filemtime("templates/default/modules/guest/guest2.html") > filemtime(__file__) || (file_exists("models/modules/guest/guest2.php") && filemtime("models/modules/guest/guest2.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/guest/guest2.html",1);
	include(__file__);
}else {
/* debug模式运行生成代码 结束 */
?><?php
	//引入语言包
	$gu_langpackage=new guestlp;

	//引入公共模块
	require("foundation/fcontent_format.php");
	require("api/base_support.php");

	//变量取得
	$url_uid= intval(get_argg('user_id'));
	$ses_uid=get_sess_userid();
	$guest_user_name=get_sess_username();
	$guest_user_ico=get_sess_userico();
	$mypals=get_sess_mypals();

	//引入模块公共权限过程文件
	$is_login_mode='';
	$is_self_mode='partLimit';
	require("foundation/auser_validate.php");

	//数据表定义区
	$t_guest = $tablePreStr."guest";
	$t_users = $tablePreStr."users";

	$dbo=new dbex;

	
	//加为好友 打招呼
	$add_friend="mypalsAddInit";
	$send_hi="hi_action";
	if(!$ses_uid){
	  	$add_friend='goLogin';
	  	$send_hi='goLogin';
	}
	
	//读写分离定义方法
	dbtarget('r',$dbServs);
	$guest_rs = api_proxy("guest_self_by_uid","*",$userid,6);
	if($is_self=='N'&&$ses_uid!=''){
		//读写分离定义方法
		dbtarget('w',$dbServs);
		if(empty($guest_rs)&&$ses_uid!=$url_uid){
			$sql = "update $t_users set guest_num=guest_num+1 where user_id=$url_uid";
			$dbo ->exeUpdate($sql);
		}else{
			if($guest_rs[0]['guest_user_id']!=$ses_uid){
				$sql = "update $t_users set guest_num=guest_num+1 where user_id=$url_uid";
				$dbo ->exeUpdate($sql);
			}
		}
		$sql = "delete from $t_guest where guest_user_id=$ses_uid and user_id=$url_uid";
		$dbo ->exeUpdate($sql);
		$sql = "insert into $t_guest (`guest_user_id`,`guest_user_name`,`guest_user_ico`,`user_id`,`add_time`) values($ses_uid,'$guest_user_name','$guest_user_ico',$url_uid,'".constant('NOWTIME')."')";
		$dbo ->exeUpdate($sql);
		if(count($guest_rs)>20){
			$sql = "delete from $t_guest where user_id=$url_uid order by add_time LIMIT 1";
			$dbo ->exeUpdate($sql);
		}
	}
?><?php foreach($guest_rs as $val){?>


    <li>
    <a href="home2.0.php?h=<?php echo $val["guest_user_id"];?>"  target="_blank" title="<?php echo $gu_langpackage->gu_see;?>">
    <img src="<?php echo $val['guest_user_ico'];?>" />
    <p><?php echo sub_str(filt_word($val['guest_user_name']),6,true);?></p>
    </a>
    </li>

<?php }?><?php } ?>