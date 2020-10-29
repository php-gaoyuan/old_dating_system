<?php

/*

 * 注意：此文件由tpl_engine编译型模板引擎编译生成。

 * 如果您的模板要进行修改，请修改 templates/default/modules/u_pay.html

 * 如果您的模型要进行修改，请修改 models/modules/u_pay.php

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
exit();
if(!function_exists("tpl_engine")) {

	require("foundation/ftpl_compile.php");

}

if(filemtime("templates/default/modules/u_pay.html") > filemtime(__file__) || (file_exists("models/modules/u_pay.php") && filemtime("models/modules/u_pay.php") > filemtime(__file__)) ) {

	tpl_engine("default","modules/u_pay.html",1);

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

						<li class="one"><span><a href="modules.php?app=u_pay"><?php echo $u_langpackage->u_pay;?></a></span></li>

						<li><span><a href="modules.php?app=u_update"><?php echo $u_langpackage->u_update;?></a></span></li>

						<li><span><a href="#">会员介绍</a></span></li>

						<li><span><a href="#">会员帮助</a></span></li>

						<li><span><a href="#">充值记录</a></span></li>

						<li><span><a href="#">消费明细</a></span></li>

						<li><span><a href="#">积分规则</a></span></li>

					</ul>

					<div class="content">

						<div class="ct" id="chongzhi_container_center">

							<strong>购买金币，一金币只需两美分</strong><br />

							<font size="4" color="#080808"> 选择充值金额</font>

							<form>

								<label><input type="radio" value="20" name="money"/><span>20  金币</span>  需要美分</label><br/>

								<label><input type="radio" value="50" name="money"/><span>50  金币</span>  需要美分</label><br/>

								<label><input type="radio" value="100" name="money"/><span>100  金币</span>  需要美分</label><br/>

								<label><input type="radio" value="200" name="money" checked /><span>200  金币</span>  需要美分</label><br/>

								<label><input type="radio" value="500" name="money"/><span>500  金币</span>  需要美分</label><br/>

								<label><input type="radio" value="1000" name="money"/><span>1000  金币</span>  需要美分</label><br/>

								<label onclick="$('#in_text').focus();"><input type="radio" value="" id="in_radio" name="money"/>

								<span><input id="in_text" type="text" size="10" onfocus="$('#in_radio').attr('checked','checked')" name="money" /> 金币</span>  需要美分</label><br/><br />

								<font size="4" color="#080808">选择充值金额</font><br />

								<table>

									<tr>

										<td><input type="radio" id="moneyway1" value="moneyway1"  name="moneyway" />

										</td>

										<td><img src="skin/<?php echo $skinUrl;?>/images/3_C2.jpg" onclick="check('moneyway1')"/>

										</td>

										<td><input type="radio" id="moneyway2" value="moneyway2" checked name="moneyway" />

										</td>

										<td><img src="skin/<?php echo $skinUrl;?>/images/3_C3.jpg" onclick="check('moneyway2')" />	

										</td>

										<td><input type="radio" id="moneyway3" value="moneyway3"  name="moneyway" />

										</td>

										<td><img src="skin/<?php echo $skinUrl;?>/images/3_C4.jpg" onclick="check('moneyway3')" />

										</td>

									</tr>

								</table>

								

								<br />

								<button style="border:0px"><img src="skin/<?php echo $skinUrl;?>/images/3_C5.gif" /></button>

							</form>

							

							

						</div>

					

					</div>

				</div>

</body>

</html><?php } ?>