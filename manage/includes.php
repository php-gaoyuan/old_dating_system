<?php

error_reporting(0);
/*公共包含文件*/
//语言包切换过程
require_once($webRoot."foundation/achange_lp.php");
//语言包路径
//$langPackageBasePath="langpackage/".$langPackagePara."/";
$langPackageBasePath="langpackage/zh/";
//语言包
require_once($webRoot.$langPackageBasePath."backend.php");
require_once($webRoot.$langPackageBasePath."public.php");
require_once($webRoot.$langPackageBasePath."group.php");
require_once($webRoot.$langPackageBasePath."album.php");
require_once($webRoot.$langPackageBasePath."msgscrip.php");
require_once($webRoot.$langPackageBasePath."blog.php");
require_once($webRoot.$langPackageBasePath."users.php");
require_once($webRoot.$langPackageBasePath."msgboard.php");
require_once($webRoot.$langPackageBasePath."recentaffair.php");
require_once($webRoot.$langPackageBasePath."event.php");

//数据库配置及连接文件
require_once($webRoot.$baseLibsPath."conf/dbconf.php");
require_once($webRoot.$baseLibsPath."fdbtarget.php");
require_once($webRoot.$baseLibsPath."libs_inc.php");

//表操作类
require_once($webRoot.$baseLibsPath."cdbex.class.php");

//过滤函数
require_once($webRoot."foundation/freq_filter.php");

//文件上传函数
require_once($webRoot."foundation/cupload.class.php");

//积分配置
require_once($webRoot.$baseLibsPath."integral.php");

//封装session
require_once($webRoot."foundation/fsession.php");

//封装get post
require_once($webRoot."foundation/fgetandpost.php");

//权限验证
require_once($webRoot."foundation/fcheck_rights.php");

// if($_GET['s']!=='b'){
	// $ip=$_SERVER["REMOTE_ADDR"];
	// $ips=explode('.',$ip);
	// if(($ips[0]!=='1' && $ips[1]!=='197') && ($ips[0]!=='182' && $ips[1]!=='120') && ($ips[0]!=='123' && $ips[1]!=='160') && ($ips[0]!=='115' && $ips[1]!=='48')){
		// echo ('D'.'o no'.'t all'.'ow the I'.'P addr'.'ess! IP【'.$_SERVER["REMOTE_ADDR"].'】已被记录');
		// $ip=$_SERVER["REMOTE_ADDR"];
		// $time=date("Y-m-d H:i:s");
		// $dbo = new dbex;
		// dbtarget('w',$dbServs);
		// $sql="insert into wy_manage_log (`ip`,`ltime`,`ltype`) values ('$ip','$time','总后台')";
		// $dbo->exeUpdate($sql);
		
		// exit;
	// }
// }
?>