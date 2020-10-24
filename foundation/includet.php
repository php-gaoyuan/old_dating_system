<?php
error_reporting(E_ALL &~E_NOTICE);
require(dirname(__file__)."/../foundation/asession.php");
require(dirname(__file__)."/../configuration.php");
require(dirname(__file__)."/../includes.php");
require(dirname(__file__)."/../function.php");

$wz_userid=get_session('wz_userid');
if(!$wz_userid&&$_SERVER['SCRIPT_NAME']!='/background/index.php'&&$_SERVER['SCRIPT_NAME']!='/background/Guest_Reg.php')
{
	echo "<script>location.href='index.php';</script>";
	exit;
}
?>