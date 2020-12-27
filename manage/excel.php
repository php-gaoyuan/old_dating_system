<?php
	header("Content-type:application/vnd.ms-excel");
	header("Content-Disposition:attachment;filename=email.xls");
	
	/*
	if(isset($_POST['submit'])){
	}*/
		
		require("session_check.php");
		require("../foundation/fpages_bar.php");
		require("../foundation/fsqlseletiem_set.php");
		require("../foundation/fback_search.php");
		
		//表定义区
		$t_users=$tablePreStr."users";

		$dbo = new dbex;
		dbtarget('w',$dbServs);		
			
		
		$sql="select * from wy_users";
		
		//取得数据
		$member_rs=$dbo->getRs($sql);
		
		$i=0;
		foreach($member_rs as $rs){
			 $res=$rs['user_email']."\t\n";
				echo $res;
		//	 echo $res."\r\n";
		//	 echo '\t\n';
		$i++;
		}
		echo $i;
		
		
	
	
	
?>