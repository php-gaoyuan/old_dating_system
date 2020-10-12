<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/uiparts/mainfooter.html
 * 如果您的模型要进行修改，请修改 models/uiparts/mainfooter.php
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
if(filemtime("templates/default/uiparts/mainfooter.html") > filemtime(__file__) || (file_exists("models/uiparts/mainfooter.php") && filemtime("models/uiparts/mainfooter.php") > filemtime(__file__)) ) {
	tpl_engine("default","uiparts/mainfooter.html",1);
	include(__file__);
}else {
/* debug模式运行生成代码 结束 */
?><?php

	require("api/base_support.php");
    require("foundation/module_lang.php");
	//require("foundation/module_users.php");
    $ah_langpackage=new arrayhomelp;
    $gu_langpackage=new guestlp;
    $pu_langpackage=new publiclp;
    $f_langpackage=new footerlp;
    
	$dbo=new dbex;
    dbtarget('r',$dbServs);
     
   
    //关于我们
    $list_rs5 = $dbo->getRs("select id,title from wy_article where cat_id=5");
    //print_r($list_rs5);
	$list_rs6 = $dbo->getRs("select id,title from wy_article where cat_id=7");
    
?><div class="dlfoot">
<table width="1001" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="345" style="padding-top:20px;">
	<div class="dlfoot1"><?php echo $f_langpackage->f_lfetad1;?></div>
	<div class="dlfoot1"><?php echo $f_langpackage->f_lfetad2;?></div>
	<div class="dlfoot2"><?php echo $f_langpackage->f_lfetad3;?></div>
	</td>
    <td width="90">&nbsp;</td>
    <td valign="top">
	<div class="dlfoot3">
	<p><b><?php echo $f_langpackage->f_newman;?></b></p>
	<p><a href='main.php?app=user_stamps'><?php echo $f_langpackage->f_stamps;?></a></p>
    <p><a href='main.php?app=user_introduce'><?php echo $f_langpackage->f_hlpe2;?></a></p>


	</div>
	</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">
	<div class="dlfoot3">
	<p><b><?php echo $f_langpackage->f_serve;?></b></p>
    <p><a href='main.php?app=user_pay'><?php echo $f_langpackage->f_pay;?></a></p>
    <p><a href='main.php?app=user_upgrade'><?php echo $f_langpackage->f_payserve;?></a></p>
	</div>
	</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">
	<div class="dlfoot3">
	<p><b><?php echo $f_langpackage->f_help;?></b></p>
	<p><a href='main.php?app=user_help'><?php echo $f_langpackage->f_payhelp;?></a></p>
    <p><a href='main.php?app=user_help'><?php echo $f_langpackage->f_guize;?></a></p>
	</div>
	</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">
	<div class="dlfoot3" style="display:none;">
	<p><b>商务合作</b></p>
	</div>
	</td>
	<td valign="top">&nbsp;</td>
    <td valign="top">
	<div class="dlfoot3">
	<p><b><?php echo $f_langpackage->f_about;?></b></p>
	
	<?php if($_COOKIE['lp_name']=='en'){?>
    <?php foreach($list_rs6 as $rs){?>
	<p><a href='modules.php?app=article_article2&id=<?php echo $rs["id"];?>'><?php echo $rs['title'];?></a></p>
    <?php }?>
	<?php }else{ ?>
    <?php foreach($list_rs5 as $rs){?>
	<p><a href='modules.php?app=article_article2&id=<?php echo $rs["id"];?>'><?php echo $rs['title'];?></a></p>
    <?php }?>
	<?php }?>
	</div>
	</td>
    <td width="80" valign="top">&nbsp;</td>
  </tr>
</table>
</div>
<div class="dlfoot4"><?php echo $f_langpackage->f_copyright;?> <script src="http://s14.cnzz.com/stat.php?id=5358603&web_id=5358603&show=pic" language="JavaScript"></script></div>

<?php } ?>