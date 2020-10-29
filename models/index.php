<?php
	header("content-type:text/html;charset=utf-8");
	if(!file_exists('docs/install.lock')){
		header("location:install/index.php");
	}
	require("foundation/asession.php");
	require("configuration.php");
	require("includes.php");
	
	//语言包引入
	$pu_langpackage=new publiclp;

	
	if(get_sess_userid()){
		echo '<script type="text/javascript">location.href="main.php";</script>';
	}
	$tg=get_argg('tg');
	if($tg=='invite'){
		$index_ref="modules/invite.php";
	}elseif($tg=='search_pals_list'){
		$index_ref="modules/mypals/search_pals_list.php";
	}else{
		$index_ref="modules/default.php";
  }



?>