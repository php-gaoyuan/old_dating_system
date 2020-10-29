<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/mypals/search_pals2.html
 * 如果您的模型要进行修改，请修改 models/modules/mypals/search_pals2.php
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
if(filemtime("templates/default/modules/mypals/search_pals2.html") > filemtime(__file__) || (file_exists("models/modules/mypals/search_pals2.php") && filemtime("models/modules/mypals/search_pals2.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/mypals/search_pals2.html",1);
	include(__file__);
}else {
/* debug模式运行生成代码 结束 */
?><?php
	require("api/base_support.php");
	require("foundation/module_users.php");
    require("foundation/auser_mustlogin.php");
	//引入语言包
	$mp_langpackage=new mypalslp;
	$l_langpackage=new loginlp;
	$pu_langpackage=new publiclp;
		
	
	dbtarget('r',$dbServs);
	$dbo=new dbex;
	//获取用户自定义属性列表
	$information_rs=array();
	$information_rs=userInformationGetList($dbo,'*');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $user_name;?>-<?php echo $siteName;?></title>

<link href="skin/<?php echo $skinUrl;?>/css/layout.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo $skinUrl;?>/css/jy.css" rel="stylesheet" type="text/css" />
</head>

<body>
<!--头部开始-->
<?php require("uiparts/mainheader.php");?>
<div class="hymenu">
<table width="1000" height="44" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="132"><img src="skin/<?php echo $skinUrl;?>/images/hy_menu_bgl.jpg" width="132" height="44" /></td>
    <td width="600">
	<div class="hymenu2">
	<ul>
	<li><a href="modules.php?app=mypals_list" ><?php echo $mp_langpackage->mp_all_members;?></a></li>
	<li><a href="modules.php?app=mypals_online" ><?php echo $mp_langpackage->mp_online_members;?></a></li>
	<li><a href="modules.php?app=mypals_search_new"><?php echo $mp_langpackage->mp_new_members;?></a></li>
	<li class="hydqbj"><a href="modules.php?app=mypals_search2" style="color:#FFFFFF;"><?php echo $mp_langpackage->mp_search_members;?></a></li>
	<li><a href="modules.php?app=article_list"><?php echo $mp_langpackage->mp_xingzuo;?></a></li>
	</ul>
	</div>
	</td>
    <td width="267"><img src="skin/<?php echo $skinUrl;?>/images/hy_menu_bgr.jpg" width="267" height="44" /></td>
  </tr>
</table>

</div>
<!--搜索行结束-->
<!--广告图开始-->
<div class="hyad01"><a href=""><img src="skin/<?php echo $skinUrl;?>/images/test28.jpg" /></a></div>
<!--广告图结束-->

<!--主体开始-->
<table width="1000" border="0" cellspacing="0" cellpadding="0" style="margin:5px auto;">
  <tr>
    <td width="784" valign="top">
	<div class="hyzxhy">
	<!--最新会员开始-->


<div class="hyzxul">
    	<div class="search_box">
		<div class="search_box_ct" style="height:900px;">
			<form action='modules.php'>
				<input type='hidden' name='app' value='mypals_search_list2' />
				<table cellpadding="0" cellspacing="0" class="form_table" style="width:50%;margin-top:100px;">
					<tr><th><?php echo $mp_langpackage->mp_name;?>：</th><td><input name="memName" value="" size="12" class="small-text" type="text"></td></tr>
					<tr style="display:none;"><th><?php echo $mp_langpackage->mp_birth;?>：</th><td><select id="s1" name='q_province'></select><select name='q_city' id="s2" ></select><script type="text/javascript">
				setup();
				</script></td></tr>
					<tr style="display:none;"><th><?php echo $mp_langpackage->mp_reside;?>：</th><td><select id="r1" name='s_province'></select><select name='s_city' id="r2"></select><script type="text/javascript">
				setup2();
				</script></td></tr>
					<!--自定义属性开始-->
					<?php foreach($information_rs as $val){?>
						<?php if($val['info_name']=='Country'){?>
						<tr>
							<th><?php echo  $val['info_name'] ;?>：</th>
							<td><?php echo getInformationValue($dbo,$val['input_type'],$val['info_values'],$val['info_id'],0);?></td>
					  </tr>
					  <?php }?>
					<?php }?>
					<!--自定义属性结束-->
					<tr><th><?php echo $mp_langpackage->mp_age;?>：</th><td><select name='age' ><option value=''><?php echo $mp_langpackage->mp_none_limit;?></option><option value='16|22'>16-22<?php echo $mp_langpackage->mp_years;?></option><option value='23|30'>23-30<?php echo $mp_langpackage->mp_years;?></option><option value='31|40'>31-40<?php echo $mp_langpackage->mp_years;?></option><option value='40|100'>40<?php echo $mp_langpackage->mp_years;?><?php echo $mp_langpackage->mp_over;?></option></select></select></td></tr>
					<tr><th><?php echo $mp_langpackage->mp_sex;?>：</th><td><input class="input_radio" type="radio" name='sex' value='' checked /><?php echo $mp_langpackage->mp_none_limit;?> <input class="input_radio" type="radio" name='sex' value='1' /><?php echo $mp_langpackage->mp_man;?> <input class="input_radio" type="radio" name='sex' value='0' /><?php echo $mp_langpackage->mp_woman;?></td></tr>
					<tr style="display:none;"><th><?php echo $mp_langpackage->mp_online;?>：</th><td><input type="checkbox" name='online' value=1 /></td></tr>
					<tr><th></th><td><input value="<?php echo $mp_langpackage->mp_search;?>" class="regular-btn" type="submit"></td></tr>
				</table>
			</form>
		</div>
	</div>
</ul>
</div>
<!--最新会员结束-->
	</div>
<!--分页开始-->
  <div class="dede_pages">

  </div>
<!-- 分页结束 -->
	</td>
    <td width="15">&nbsp;</td>
    <td align="left" valign="top" style="padding-top:10px;">
	<!--本周达人开始-->
 <?php require("uiparts/mainright.php");?>
	<!--浏览记录结束-->
	</td>
  </tr>
</table>

<!--主体结束-->

<!--底部开始-->
<div class="clear"></div>
 <?php require("uiparts/mainfooter.php");?>
<!--底部结束-->

</body>
</html>
<?php } ?>