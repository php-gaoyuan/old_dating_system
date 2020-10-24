<?php
require("includet.php");
require("../foundation/fpages_bar.php");


if(isset($_POST['alldel'])){
	$array=$_POST['shoping'];
	
	$del_id=implode(',',$array);
	
	$sql="delete from wy_balance where id in ($del_id)";
	
	$dbo=new dbex;
	dbplugin('w');

	if($dbo->exeUpdate($sql)){
		echo "<script type='text/javascript'>alert('批量删除成功！');history.back();</script>";
	}else{
		echo "<script type='text/javascript'>alert('批量删除失败！');history.back();</script>";
	}
}else{
	$id=$_GET['id']+0;
	$dbo=new dbex;
	dbplugin('w');
	if(isset($_GET['id'])){
		$sql="delete from wy_balance where id='$id'";
		if($dbo->exeUpdate($sql)){
			echo "<script type='text/javascript'>alert('删除成功！');history.back();</script>";
		}else{
			echo "<script type='text/javascript'>alert('删除失败！');history.back();</script>";
		}
	}else{
		echo "<script type='text/javascript'>alert('传参错误！');history.back();</script>";
	}	
}


?>