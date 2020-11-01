<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/article/article_list.html
 * 如果您的模型要进行修改，请修改 models/modules/article/article_list.php
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
if(filemtime("templates/default/modules/article/article_list.html") > filemtime(__file__) || (file_exists("models/modules/article/article_list.php") && filemtime("models/modules/article/article_list.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/article/article_list.html",1);
	include(__file__);
}else {
/* debug模式运行生成代码 结束 */
?><?php
	//引入模块公共权限过程文件
	require("foundation/fpages_bar.php");
	require("foundation/module_mypals.php");


  //语言包引入
    $b_langpackage=new bloglp;
    $u_langpackage=new userslp;
    $pu_langpackage=new publiclp;

  //变量区
	//$url_uid=intval(get_argg('user_id'));
	//$ses_uid=get_sess_userid();


  //数据表定义
  $t_cat=$tablePreStr."cat";
  $t_article=$tablePreStr."article";
    
    //$cat_id=6;
	dbtarget('r',$dbServs);
	$dbo=new dbex;


  //引入模块公共权限过程文件
	//$is_self_mode='partLimit';
	//$is_login_mode='';
	//require("foundation/auser_validate.php");

    $sql = "select id,title,cat_id,thumb,content from $t_article where cat_id=6";
    //echo $sql;

    $xingzuo_rs=$dbo->getRs($sql);
   // print_r($xingzuo_rs);
    $sql2 = "select id,title,cat_id,thumb,content from $t_article where cat_id=8";
    //echo $sql;

    $xingzuo_rs2=$dbo->getRs($sql2);
/*
    print_r($xingzuo_rs);exit;
    */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $user_name;?>-<?php echo $siteName;?></title>
<script type='text/javascript' src="skin/default/js/jy.js"></script>
<link href="skin/<?php echo $skinUrl;?>/css/layout.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo $skinUrl;?>/css/jy.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src="servtools/imgfix.js"></script>
<script type='text/javascript' src="skin/default/js/jooyea.js"></script>
<SCRIPT type='text/javascript' src="servtools/ajax_client/ajax.js"></SCRIPT>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDrag.js"></script>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDialog.js"></script>
<script type="text/javascript" language="javascript" src="servtools/calendar.js"></script>
<script type="text/javascript">
	function set_cookie_lp(lp_str){
		document.cookie = "lp_name=" + escape(lp_str);
		window.location.reload();
	}

	function setCookie (name,value) {
		var date=new Date(); 
		var expireDays=1; 
		date.setTime(date.getTime()+expireDays*24*3600*1000);
		document.cookie = name+"="+escape(value)+";expires="+date.toGMTString();
		window.location.reload();
	}
</script>
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
	<li ><a href="modules2.0.php?app=mypals_list" ><?php echo $mp_langpackage->mp_all_members;?></a></li>
	<li ><a href="modules2.0.php?app=mypals_online" ><?php echo $mp_langpackage->mp_online_members;?></a></li>
	<li><a href="modules2.0.php?app=mypals_search_new"><?php echo $mp_langpackage->mp_new_members;?></a></li>
	<li><a href="modules2.0.php?app=mypals_search2"><?php echo $mp_langpackage->mp_search_members;?></a></li>
	<li class="hydqbj"><a style="color:#FFFFFF;" href="modules2.0.php?app=article_list"><?php echo $mp_langpackage->mp_xingzuo;?></a></li>
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
<div class="xzhytexul">
<ul>




<?php if($_COOKIE['lp_name']=='en'){?>
	<?php foreach($xingzuo_rs2 as $rs){?>
	<li>
	<a href='modules2.0.php?app=article_article&id=<?php echo $rs["id"];?>'><img src='<?php echo $rs["thumb"];?>'/></a>
	<h2><?php echo $rs["title"];?></h2>
	<p><?php echo mb_substr(strip_tags($rs["content"]),0,300,'utf-8');?>...</p><p><a href='modules2.0.php?app=article_article&id=<?php echo $rs["id"];?>'>MORE&gt;&gt;</a></p>
	</li>
	<?php }?>
<?php }else{ ?>
	<?php foreach($xingzuo_rs as $rs){?>
	<li>
	<a href='modules2.0.php?app=article_article&id=<?php echo $rs["id"];?>'><img src='<?php echo $rs["thumb"];?>'/></a>
	<h2><?php echo $rs["title"];?></h2>
	<p><?php echo mb_substr(strip_tags($rs["content"]),0,150,'utf-8');?>...</p><p><a href='modules2.0.php?app=article_article&id=<?php echo $rs["id"];?>'>查看详细&gt;&gt;</a></p>
	</li>
	<?php }?>
<?php }?>

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