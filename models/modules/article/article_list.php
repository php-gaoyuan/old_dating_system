<?php
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
?>