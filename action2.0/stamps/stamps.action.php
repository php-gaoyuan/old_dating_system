<?php
//引入公共模块
require("api/base_support.php");
$er_langpackage=new rechargelp;

$dbo = new dbex;
//读写分离定义函数
dbtarget('w',$dbServs);

//ajax校验email和验证码
if(get_argg('ajax')==1){
	$user_name=get_argus("user_name");
	if($user_name){
		$sql="select user_group,golds from wy_users where user_name='$user_name'";
		$user_info=$dbo->getRow($sql);
		if($user_info){
			if($user_info['user_group']=='base')
			{
				echo 0;
			}
			else
			{
				echo $user_info['user_group'];
			}
		}
	}
	exit;
}
//echo $user_name;
$touser=get_argp("touser");
$user_id = get_sess_userid();
$user_name = get_sess_username();
$ordernumber='S-P'.time().mt_rand(100,999);
$user_info2=$dbo->getRow("select user_group,golds,stamps_num from wy_users where user_name='$user_name'");
$stamps='';
if(get_argp("sxzibi"))
{
	$stamps=get_argp("sxzibi");
}
else
{
	$stamps=get_argp("zibi");
}
$golds = $user_info2['golds'];
$stamps_num = $user_info2['stamps_num'];
$money=$stamps*2;
if($money > $golds){
	echo "<script>alert('".$er_langpackage->er_slerror."');location.href='/modules.php?app=user_pay';</script>";
	exit();
}
$sql2="insert into wy_balance set type='3',uid='$user_id',uname='$user_name',touid='$user_id',touname='$user_name',message='兑换邮票,花费金币：{$money}',state='2',addtime=now(),funds='{$money}',ordernumber='$ordernumber'";
$dbo->exeUpdate($sql2);
$sql ="update wy_users set stamps_num =$stamps_num+$stamps,golds=$golds-$stamps*2 where user_name='$user_name'";
if($dbo->exeUpdate($sql)){
    echo "<script>alert('".$er_langpackage->er_slsucess."');location.href='/modules.php?app=user_stamps';</script>";
	exit();   
}else{
    echo "<script>alert('".$er_langpackage->er_sler."');location.href='/modules.php?app=user_stamps';</script>";
	exit();    
}


?>