<?php
require("includet.php");
require("../foundation/fpages_bar.php");

$dbo=new dbex;
dbplugin('r');

if($_GET["act"] == "act_bang"){
	$user_id = intval($_GET["id"]);
	$userInfo = $dbo->getRow("select tuid from wy_users where user_id='{$user_id}'");
	//echo "<pre>";print_r($userInfo);exit;
	if(!empty($userInfo["tuid"])){echo "<script>alert('该用户已经绑定过上级！');window.reload();</script>";exit;}


	$sql = "update wy_users set tuid = '".get_session('wz_userid')."' where user_id='{$user_id}'";
	
	$res = mysql_query($sql);
	if($res){
		echo "<script>alert('绑定成功！');window.reload();</script>";exit;
	}else{

	}
}else if($_GET["act"] == "search"){
	$user_name = $_GET["user_name"];
	$sql = "select user_id,user_name,tuid from wy_users where user_name like '{$user_name}%' or user_name = '{$user_name}'";
	//echo $sql;exit;
	$userList = $dbo->getRs($sql);
}else{
	/*$sql="select user_id,user_name,tuid from wy_users";
	$userList=$dbo->getRs($sql);*/
}


//echo "<pre>";print_r($userList);exit;

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>个人业绩管理系统</title>
	<link href="css/Guest.css" rel="stylesheet" type="text/css" />
	<script src="js/system.js"></script>
	<script src="js/jquery.min.js"></script>
	<style>
		table{
			border: 1px solid #ccc;
		}
		table th{
			text-align: center;
			line-height: 36px;
		}
		table td {
			border: 1px solid #ccc;
			line-height: 36px;
			text-align: center;
		}
	</style>
</head>
<body style="padding:10px 20px;">
	<div style="margin:20px 0;">
		<form action="">
			请输入用户名：<input type="text" name="user_name" value="<?php echo $_GET['user_name'];?>">
			<input type="hidden" name="act" value="search">
			<input type="submit" value="搜索">
		</form>
	</div>

	<div>
		<table width="100%"  cellspacing="0" cellpadding="0" class="table_01">
			<tr>
				<th>ID</th>
				<th>用户名</th>
				<th>操作</th>
			</tr>
			<?php foreach ($userList as $k => $v) { ?>
				
			
			<tr>
				<td><?php echo $v["user_id"]; ?></td>
				<td><?php echo $v["user_name"]; ?></td>
				<td>
				<?php if($v["tuid"] > 0){ ?>
					该会员已经绑定
				<?php }else{ ?>
					<a href="bang.php?act=act_bang&id=<?php echo $v['user_id']; ?>">绑定该会员到名下</a>
				<?php } ?>
				</td>
			</tr>
			<?php } ?>
		</table>
	</div>
</body>
</html>