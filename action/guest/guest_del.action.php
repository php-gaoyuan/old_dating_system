<?php
//引入语言包
	$mp_langpackage=new mypalslp;
	
	$guest_id=intval(get_argg("guest_id"));

	
//数据表定义区
		$t_guest=$tablePreStr."guest";

//定义读操作
		dbtarget('w',$dbServs);
		$dbo=new dbex();
   		$sql="delete from $t_guest where guest_id=$guest_id"; 
		if($dbo->exeUpdate($sql)){
			action_return(1,$mp_langpackage->mp_success,"modules2.0.php?app=guest_more");
		}
		set_sess_mypals($mypals);
		action_return(0,'',"");
?>
