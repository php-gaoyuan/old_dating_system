<?php
	require("session_check.php");

	$dbo = new dbex;
	dbtarget('w',$dbServs);


	//变量获得
	$user_id = intval($_GET['user_id']);
	$userinfo = $dbo->getRow("select user_id,user_email,user_name,email_passwd from wy_users where user_id='{$user_id}'");
	//echo "<pre>";print_r($userinfo);exit;
	//数据表定义区
	if(get_argp('action')){
		$info = $dbo->getRow("select user_id from wy_users where user_email='{$_POST['user_email']}' and user_id!='{$user_id}'");
		//echo "<pre>";print_r($info);exit;
		if(!empty($info)){
			echo "<script type='text/javascript'>alert('系统已经存在该邮箱，请更换其他邮箱');</script>";
		}else{
			$res = $dbo->exeUpdate("update wy_users set user_email='{$_POST['user_email']}',email_passwd='{$_POST['email_passwd']}' where user_id='{$user_id}'");
			
			if($res){
				echo "<script type='text/javascript'>alert('修改成功');</script>";
			}else{
				echo "<script type='text/javascript'>alert('修改失败');</script>";
			}
		}
	}
	$userinfo = $dbo->getRow("select user_id,user_email,user_name,email_passwd from wy_users where user_id='{$user_id}'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改信息</title>

<link rel="stylesheet" type="text/css" media="all" href="css/admin.css">
</head>
<body>
<div id="maincontent">
    <div class="wrap">
        <div class="crumbs"> &gt;&gt; <a href="admin_pw_change.php">修改资料</a></div>
        <hr />
        <div class="infobox">
            <h3>修改信息</h3>
            <div class="content">
				<form id="form1" name="form1" method="post" action="" >
				<table class='form-table'>
				  <tr>
				    <td><div align="right">账号：</div></td>
				    <td>
				      	<label>
				        	<input type="text" id="user_name" class="regular-text" value="<?php echo $userinfo['user_name'];?>" />
				        </label>
				    </td>
				  </tr>
				  <tr>
				    <td><div align="right">真实邮箱：</div></td>
				    <td>
				      	<label>
				        	<input type="text" name="user_email" id="user_email" class="regular-text" value="<?php echo $userinfo['user_email'];?>" />
				      	</label>
				  	</td>
				  </tr>
				  <tr>
				    <td><div align="right">真实邮箱密码：</div></td>
				    <td>
				    	<label>
				      		<input type="text" name="email_passwd" id="email_passwd" class="regular-text" value="<?php echo $userinfo['email_passwd'];?>" />
				    	</label>
				    </td>
				  </tr>
				  
				  <tr>
				    <td>
						<div align="right">

							<input type="submit" class="regular-button" name="action" value="提交" />
				      	</div>
				    </td>
				    <td></td>
				  </tr>
				</table>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>
