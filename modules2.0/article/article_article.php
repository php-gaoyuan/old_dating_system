<?php


error_reporting(0);


if(!function_exists("tpl_engine")) {
	require("foundation/ftpl_compile.php");
}
if(filemtime("templates/default/modules/article/article_article.html") > filemtime(__file__) || (file_exists("models/modules/article/article_article.php") && filemtime("models/modules/article/article_article.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/article/article_article.html",1);
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
$ef_langpackage=new event_frontlp;
$mn_langpackage=new menulp;
$pu_langpackage=new publiclp;
$mp_langpackage=new mypalslp;
$s_langpackage=new sharelp;
$hi_langpackage=new hilp;
$l_langpackage=new loginlp;
$rp_langpackage=new reportlp;
$ah_langpackage=new arrayhomelp;

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

    $sql = "select id,title,cat_id,thumb,content from $t_article where id=$id";
   // echo $sql;

    $article_rs=$dbo->getRow($sql);
    //print_r($article_rs);
/*
    print_r($xingzuo_rs);exit;

    */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $article_rs["title"];?>-<?php echo $siteName;?>-国际交友网</title>

<link href="skin/<?php echo $skinUrl;?>/css/layout.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo $skinUrl;?>/css/jy.css" rel="stylesheet" type="text/css" />
<style>
  #content p{line-height:20px;text-indent:2em;}  
</style>
</head>

<body>
<!--头部开始-->
<div style="width:1230px;margin:0 auto;margin-left:300px;margin-top:-20px;">
<?php require("uiparts/artfootor.php");?>
</div>
<!--搜索行结束-->
<!--广告图开始-->
<!--广告图结束-->
<!--主体开始-->
<div class="xzind">
<!--会员搜索部分开始-->
<!--会员搜索部分结束-->
<div class="xzhytex" style="width:1000px;margin:0 auto">
<div class="xzhytexul">
<ul>
<h2 style="font-size:16px;margin:15px;border-bottom:1px dashed #ccc;height:30px;text-align:left"><?php echo $article_rs["title"];?></h2>
<p><img src='<?php echo $article_rs["thumb"];?>'/></p>
<div id="content" style="text-align:left;"><?php echo $article_rs["content"];?></div>
</ul>
</div><div class="clear"></div>
</div>
</div>
<!--主体结束-->

<!--底部开始-->
<div class="clear"></div>

<!--底部结束-->

</body>
</html>
<?php } ?>