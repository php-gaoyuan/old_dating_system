<?php
	$lang = $_COOKIE['lp_name'];
	$id = intval($_GET['id']);
	$item = 'about';
	switch ($id) {
		case '58'://关于我们
			$item = 'about';
			break;
		case '59'://交友安全
			$item = 'safe';
			break;
		case '60'://隐私条款
			$item = 'privacy';
			break;
		case '61'://帮助中心
			$item = 'help';
			break;
		case '62'://联系我们
			$item = 'contact';
			break;
		case '63'://使用条款
			$item = 'terms';
			break;
	}
	//echo "<pre>";print_r($_COOKIE['lp_name']);exit; 
	include(dirname(__FILE__).'/article_'.$lang.'.html');
?>