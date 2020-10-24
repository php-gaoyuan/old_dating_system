<?php
require("session_check.php");
	$is_check=check_rights("c03");
	if(!$is_check){
		echo 'no permission';
		exit;
	}
	//语言包引入
	$m_langpackage=new modulelp;
	
	//变量区
	$user_id=intval(get_argg('user_id'));
	
	$dbo = new dbex;
	dbtarget('w',$dbServs);
	
	//表定义区
	$t_users=$tablePreStr."users";
	$t_online=$tablePreStr."online";
	
	$sql="delete from $t_users where user_id=$user_id";
	$sql2 = "delete from $t_online where user_id=$user_id";
	
	if($dbo->exeUpdate($sql)){
		if($dbo->exeUpdate($sql2)){
			echo $m_langpackage->m_del_suc;
		}else{
			echo '删除失败';
		}
	}else{
		echo '删除失败';
	}
	
	
?>