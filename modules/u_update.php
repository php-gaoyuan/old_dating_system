<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/u_update.html
 * 如果您的模型要进行修改，请修改 models/modules/u_update.php
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
if(filemtime("templates/default/modules/u_update.html") > filemtime(__file__) || (file_exists("models/modules/u_update.php") && filemtime("models/modules/u_update.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/u_update.html",1);
	include(__file__);
}else {
/* debug模式运行生成代码 结束 */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<base href='<?php echo $siteDomain;?>' />
<script language=JavaScript src="skin/<?php echo $skinUrl;?>/jquery-1.9.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/custom.css" />
<script language=JavaScript src="skin/<?php echo $skinUrl;?>/custom.js"></script>

<script language=JavaScript src="skin/<?php echo $skinUrl;?>/effect_commonv1.1.js"></script>
<script type='text/javascript'>

</script>
</head>
<?php 
header("content-type:text/html;charset=utf-8");
require("foundation/asession.php");
require("configuration.php");
require("includes.php");
//必须登录才能浏览该页面
require("foundation/auser_mustlogin.php");
require("foundation/module_users.php");
require("foundation/fplugin.php");
//语言包引入
$u_langpackage=new userslp;
$user_id=get_sess_userid();
$user_name=get_sess_username();
?>
<body id="main_iframe">
	<div class="u_pay_top"></div>
	
	<div id="container_center"  class="box">
					
					<ul>
						<li><span><a href="modules.php?app=u_pay"><?php echo $u_langpackage->u_pay;?></a></span></li>
						<li class="one"><span><a href="modules.php?app=u_update"><?php echo $u_langpackage->u_update;?></a></span></li>
						<li><span><a href="#">会员介绍</a></span></li>
						<li><span><a href="#">会员帮助</a></span></li>
						<li><span><a href="#">充值记录</a></span></li>
						<li><span><a href="#">消费明细</a></span></li>
						<li><span><a href="#">积分规则</a></span></li>
					</ul>
					<div class="content">
						<form action="#" method="post">
						<div class="ct">
							<div class="ct_s"><label><input type="radio" name="who" value="self" checked />充给自己</label></div>
							<div class="ct_s" style="border-bottom:1px solid #ddd">
							<label><input type="radio" name="who" id="friden" />充值给好友：</label><input type="text" size="10" name="friden_name" id="friends" readonly style="background:#ccc" />
								<select name="friends" style="width:100px" onchange="$('#friden').click();document.getElementById('friends').value=value;">
									<option>好友1</option>
									<option>好友2</option>
								</select>
							</div>
							<div class="ct_b" style="border-right:1px solid #ddd"> <span id="span_1"></span>高级会员升级：</div><div class="ct_b"> <span id="span_2"></span>星级会员升级：</div>
							<div class="ct_c" style="border-right:1px solid #ddd">
							<ul>
								<li><label><input type="radio" name="vip" value="20"  />一个月高级会员 20 金币</label></li>
								<li><label><input type="radio" name="vip" value="50"  />三个月高级会员 50 金币</label></li>
								<li><label><input type="radio" name="vip" value="90"  />六个月高级会员 90 金币</label></li>
								<li><label><input type="radio" name="vip" value="150"  />一年的高级会员 150 金币</label></li>
								<div class="ct_d"><input type="submit" value="立即升级" /></div>
							</ul>
							</div>
							<div class="ct_c">
							<ul>
								<li><label><input type="radio" name="vip" value="199"  /> 一个月星级会员 199 金币</label></li>
								<li><label><input type="radio" name="vip" value="499"  /> 三个月星级会员 499 金币</label></li>
								<li><label><input type="radio" name="vip" value="899"  /> 六个月星级会员 899 金币</label></li>
								<li><label><input type="radio" name="vip" value="1499"  />一年的星级会员 1499 金币</label></li>
								<div class="ct_d"><input type="submit" value="立即升级" /></div>
							</ul>
							</div>
							
						</div>
						</form>
					</div>
				</div>
</body>
</html><?php } ?>