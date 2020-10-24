<?php
require("includet.php");

if(get_args("act")=="edit")
{
	$userpass=get_args("userpass");
	$oldpass=get_args("oldpass");

	$dbo=new dbex;
	dbtarget('r',$dbServs);
	$sql="select * from wy_wangzhuan where name='".get_session('wz_uname')."'";
	$wangzhuan=$dbo->getRow($sql);
	if(is_array($wangzhuan))
	{
		if(md5($oldpass)==$wangzhuan['password'])
		{
			$sql="update wy_wangzhuan set password='".md5($userpass)."' where name='".get_session('wz_uname')."'";
			if($dbo->exeUpdate($sql))
			{
				echo "<script>alert('密码修改成功。');location.href='editm.php';</script>";
			}
		}
		else
		{
			echo "<script>alert('原始密码不正确。');</script>";
			$act="edit";
		}
	}
	else
	{
		session_unset();
		echo "<script>alert('该用户信息不存在。');</script>";
		$act="edit";
	}
}
else
{
	$act="edit";
}
?>
<html>
<head>
<title>网站管理系统</title>
<link href="css/Guest.css" rel="stylesheet" type="text/css" />
<script src="js/system.js"></script>
<script language="javascript">
<!--
function CheckForm_UserLogin()
{
	if(document.User_Login.oldpass.value == "")
	{
		alert("请输入原始密码！");
		document.User_Login.oldpass.focus();
		return false;
	}
	if(document.User_Login.userpass.value == "")
	{
		alert("请输入新密码！");
		document.User_Login.userpass.focus();
		return false;
	}

	if(document.User_Login.userpass.value.length < 6)
	{
		alert("输入新密码长度不足6位！");
		document.User_Login.userpass.focus();
		return false;
	}

	if(document.User_Login.userpass2.value == "")
	{
		alert("请输入确认新密码！");
		document.User_Login.userpass2.focus();
		return false;
	}
	if(document.User_Login.userpass2.value != document.User_Login.userpass.value)
	{
		alert("两次密码输入不一样！");
		document.User_Login.userpass2.focus();
		return false;
	}
}
-->
</script>
</head>
<body>
<form id="User_Login" name="User_Login" method="post" action="" onSubmit="return CheckForm_UserLogin()">
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_01">
  <tr class="t_Title">
	<td colspan="2">修改密码</td>
  </tr>
  <tr>
	<td style="width:100px;" align="right">原始密码：</td>
    <td><input type="password" name="oldpass" id="oldpass" /></td>
  </tr>
  <tr>
	<td style="width:100px;" align="right">新密码：</td>
    <td><input type="password" name="userpass" id="userpass" /></td>
  </tr>
  <tr>
	<td style="width:100px;" align="right">确认新密码：</td>
    <td><input type="password" name="userpass2" id="userpass2" /></td>
  </tr>
  <tr>
	<td style="width:100px;" align="right"><input type="hidden" name="act" value="<?php echo $act;?>" /></td>
    <td><input name="Submit" type="submit" class="btn_submit" value=" " /></td>
  </tr>
</table>
</form>
</body>
</html>