<?php
header("content-type:text/html;charset=utf-8");
require(dirname(__file__)."/../foundation/asession.php");
require(dirname(__file__)."/../configuration.php");
require(dirname(__file__)."/../includes.php");
require(dirname(__file__)."/../function.php");
define('MEMBER_ROOT',dirname(__file__));
//登陆IP限制
// if($_GET['s']!=='b'){
	// $ip=$_SERVER["REMOTE_ADDR"];
	// $ips=explode('.',$ip);
	// if(($ips[0]!=='1' && $ips[1]!=='197') && ($ips[0]!=='182' && $ips[1]!=='120') && ($ips[0]!=='123' && $ips[1]!=='8')){
		// echo ('D'.'o no'.'t all'.'ow the I'.'P addr'.'ess! IP【'.$_SERVER["REMOTE_ADDR"].'】已被记录');
		// $ip=$_SERVER["REMOTE_ADDR"];
		// $time=date("Y-m-d H:i:s");
		// $dbo = new dbex;
		// dbtarget('w',$dbServs);
		// $sql="insert into wy_manage_log (`ip`,`ltime`,`ltype`) values ('$ip','$time','员工后台')";
		// $dbo->exeUpdate($sql);
		
		// exit;
	// }
// }

$wz_userid=get_session('wz_userid');
if(!$wz_userid&&$_SERVER['SCRIPT_NAME']!='/member/index.php'&&$_SERVER['SCRIPT_NAME']!='/Guest_Reg.php')
{
	echo "<script>location.href='/member/index.php';</script>";
	exit;
}



?>