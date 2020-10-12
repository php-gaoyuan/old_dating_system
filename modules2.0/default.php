<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/default.html
 * 如果您的模型要进行修改，请修改 models/modules/default.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
require("foundation/fcontent_format.php");
if(get_argg('tuid')){
	setcookie('tuid',get_argg('tuid'));
	echo "<script>window.location.href='/'</script>";
}
//引入语言包

$u_langpackage=new userslp;
$ef_langpackage=new event_frontlp;
$mn_langpackage=new menulp;
$pu_langpackage=new publiclp;
$mp_langpackage=new mypalslp;
$s_langpackage=new sharelp;
$hi_langpackage=new hilp;
$l_langpackage=new loginlp;
$rp_langpackage=new reportlp;
$ah_langpackage=new arrayhomelp;
$dbo=new dbex();
dbtarget('r',$dbServs);
//登陆页会员展示

$users=$dbo->getRs("select user_id,user_name,user_ico,user_big_ico from wy_users where is_index=1 order by index_time desc limit 7");
foreach($users as $ku=>$u){
	$res=$dbo->getRow("select mood from wy_mood where user_id='$u[user_id]' order by rand() limit 1");
	$users[$ku]['mood']=$res['mood'];
}

?><script src="skin/default/js/login.js" language="javascript"></script>


        

	<div class="index_right">
		
		<?php echo isset($plugins['index_right'])?show_plugins($plugins['index_right']):'';?>
	</div>
	<!--插件位置!-->

	
	
	
	
