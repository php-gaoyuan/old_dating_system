<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/article/article_article2.html
 * 如果您的模型要进行修改，请修改 models/modules/article/article_article2.php
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
if(filemtime("templates/default/modules/article/article_article2.html") > filemtime(__file__) || (file_exists("models/modules/article/article_article2.php") && filemtime("models/modules/article/article_article2.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/article/article_article2.html",1);
	include(__file__);
}else {
/* debug模式运行生成代码 结束 */
?><?php
	//引入模块公共权限过程文件
	require("foundation/fpages_bar.php");
	require("foundation/module_mypals.php");
	require("foundation/auser_mustlogin.php");

  //语言包引入
  $b_langpackage=new bloglp;

  //变量区
	//$url_uid=intval(get_argg('user_id'));
	//$ses_uid=get_sess_userid();


  //数据表定义
  $t_cat=$tablePreStr."cat";
  $t_article=$tablePreStr."article";
    
    $id=$_GET['id'];
	dbtarget('r',$dbServs);
	$dbo=new dbex;


  //引入模块公共权限过程文件
	//$is_self_mode='partLimit';
	//$is_login_mode='';
	//require("foundation/auser_validate.php");

    $sql = "select id,title,cat_name,content from $t_article  left join $t_cat  on $t_article.cat_id=$t_cat.cat_id where id=$id";
   // echo $sql;

    $article_rs=$dbo->getRow($sql);
    //print_r($article_rs);
/*
    print_r($xingzuo_rs);exit;

    */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $user_name;?>-<?php echo $siteName;?></title>

<link href="skin/<?php echo $skinUrl;?>/css/layout.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo $skinUrl;?>/css/jy.css" rel="stylesheet" type="text/css" />
<style>
  #content p{line-height:20px;text-indent:2em;}  
</style>
</head>

<body>
<!--头部开始-->
<?php require("uiparts/mainheader2.php");?>
<div class="hymenu">
<table width="1000" height="44" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="132"><img src="skin/<?php echo $skinUrl;?>/images/hy_menu_bgl.jpg" width="132" height="44" /></td>
    <td width="600">
	<div class="hymenu2">
	<ul>
	<li ><a href="modules.php?app=mypals_list" ><?php echo $mp_langpackage->mp_all_members;?></a></li>
	<li ><a href="modules.php?app=mypals_online" ><?php echo $mp_langpackage->mp_online_members;?></a></li>
	<li><a href="modules.php?app=mypals_search_new"><?php echo $mp_langpackage->mp_new_members;?></a></li>
	<li><a href="modules.php?app=mypals_search2"><?php echo $mp_langpackage->mp_search_members;?></a></li>
	<li class="hydqbj"><a href="#" style="color:#FFFFFF;"><?php echo $article_rs["cat_name"];?></a></li>
	</ul>
	</div>
	</td>
    <td width="267"><img src="skin/<?php echo $skinUrl;?>/images/hy_menu_bgr.jpg" width="267" height="44" /></td>
  </tr>
</table>

</div>
<!--搜索行结束-->
<!--广告图开始-->
<!--广告图结束-->
<!--主体开始-->
<div class="xzind">
<!--会员搜索部分开始-->
<!--会员搜索部分结束-->
<div class="xzhytex">
<div class="xzhytexul" style="min-height:370px;">
<ul>
<h2 style="font-size:16px;margin:15px;border-bottom:1px dashed #ccc;height:30px;line-height:30px;"><?php echo $article_rs["title"];?></h2>
<div id="content" style="text-align:left;"><?php echo $article_rs["content"];?></div>
</ul>
</div><div class="clear"></div>
</div>
</div>
<!--主体结束-->

<!--底部开始-->
<div class="clear"></div>
<?php require("uiparts/mainfooter.php");?>
<!--底部结束-->

</body>
</html>
<?php } ?>