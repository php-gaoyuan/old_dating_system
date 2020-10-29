<?php
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

    $sql = "select id,title,cat_id,thumb,content from $t_article where id=$id";
   // echo $sql;

    $article_rs=$dbo->getRow($sql);
    //print_r($article_rs);
/*
    print_r($xingzuo_rs);exit;

    */
?>