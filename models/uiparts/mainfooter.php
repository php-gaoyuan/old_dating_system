<?php

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
    
?>