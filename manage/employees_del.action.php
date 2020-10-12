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
	$id=intval(get_argg('id'));
	
	$dbo = new dbex;
	dbtarget('w',$dbServs);
	
	
	$sql="delete from wy_wangzhuan where id=$id";
	if($dbo->exeUpdate($sql)){
		echo '删除成功';
	}else{
		echo '删除失败';
	}
?>