<?php
require("foundation/module_mypals.php");
require("foundation/aintegral.php");
//定义读操作
/*锁定*/
$l_langpackage=new loginlp;
dbtarget('r',$dbServs);
$dbo=new dbex;
$usid=get_sess_userid();
$sql="select is_pass from wy_users where user_id='$usid'";
$user_info=$dbo->getRow($sql);
if($user_info['is_pass']==0){
	echo "<script>".$l_langpackage->l_lock_u."location.href='http://www.puivip.com/main.php'</script>";
	exit();
}
?>