<?php
require("includet.php");

if(get_args("act")=="reg")
{
	$userpwd=get_args("userpwd");
	$email=get_args("email");

	$dbo=new dbex;
	dbtarget('r',$dbServs);
	$sql="select * from wy_wangzhuan where name='$email'";
	$wangzhuan=$dbo->getRow($sql);
	if(!is_array($wangzhuan))
	{
		$sql="insert into wy_wangzhuan set name='$email',password='".md5($userpwd)."',logintime='".time()."',loginip='$_SERVER[REMOTE_ADDR]',addtime=".time();
		if($dbo->exeUpdate($sql))
		{
			//set_session('wz_userid',mysql_insert_id());
			//set_session('wz_uname',$email);
			//set_session('logintime',time());
			//set_session('money','0.00');
			session_unset();
			echo "<script>alert('恭喜你，账号注册成功，请等待管理员审核。');location.href='index.php';</script>";
			exit;
		}
		else
		{
			session_unset();
			echo "<script>alert('注册信息有问题，请你审核后在进行填写注册。');</script>";
			$act="reg";
		}
	}
	else
	{
		session_unset();
		echo "<script>alert('你的用户名已被使用，请重新填写。');</script>";
		$act="reg";
	}
}
else
{
	$act="reg";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="css/index.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.4.min.js"></script>
<script src="js/tabchange.js"></script>
<script type="text/javascript" src="../servtools/ajax_client/ajax.js"></script>
<script type='text/javascript'>
function find()
{
	var f=document.frm_reg;
	if(f.email.value.length==0)
	  {
		alert("请先填写你的E-mail地址，然后点击找回密码，我们随后会将你新的密码发至你的邮箱中，请注意查收。");
		return false;
	  }
	var ajax_get_com=new Ajax();
	ajax_get_com.getInfo("foundpass.php","GET","","email="+f.email.value,function(c){if(c){alert('新密码已发送至你的邮箱请注意查收。');}else{alert('密码找回失败。');}});
}
</script>
<!------用户登陆------>
<script language="javascript">
<!--
function CheckForm_UserLogin()
{
	if(document.User_Login.email.value == "")
	{
		alert("请输入用户名！");
		document.User_Login.email.focus();
		return false;
	}
	if(document.User_Login.userpwd.value == "")
	{
		alert("请输入密码！");
		document.User_Login.userpwd.focus();
		return false;
	}

	if(document.User_Login.userpwd.value.length < 6)
	{
		alert("输入密码长度不足6位！");
		document.User_Login.userpwd.focus();
		return false;
	}

	if(document.User_Login.userpwd2.value == "")
	{
		alert("请输入确认密码！");
		document.User_Login.userpwd2.focus();
		return false;
	}
	if(document.User_Login.userpwd2.value != document.User_Login.userpwd.value)
	{
		alert("两次密码输入不一样！");
		document.User_Login.userpwd2.focus();
		return false;
	}
}
-->
</script>
</head>
<body>
<div class="Login_Area" style="background: url('images/reg.jpg') no-repeat scroll 0 0 transparent;">
	<div class="Login_Form">
	  <form id="User_Login" name="User_Login" method="post" action="" onSubmit="return CheckForm_UserLogin()">
		<table width="100%" border="0">
		  <tr>
			<td width="45%" height="50" align="right">用户名：</td>
			<td width="55%" height="50"><input name="email" type="text" class="input_01" id="email" onkeyup="value=value.replace(/[\W]/g,'');" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" maxlength="30" /></td>
		  </tr>
		  <tr>
			<td height="50" align="right">密　码：</td>
			<td height="50"><input name="userpwd" type="password" class="input_01" id="userpwd" maxlength="30" /></td>
		  </tr>
		  <tr>
			<td height="50" align="right">确认密码：</td>
			<td height="50"><input name="userpwd2" type="password" class="input_01" id="userpwd2" maxlength="30" /></td>
		  </tr>
		  <tr>
			<td height="50"><input type="hidden" name="act" value="<?php echo $act;?>" /></td>
			<td height="50"><input name="Submit" type="submit" class="btn_zhuce" value=" " /></td>
		  </tr>
		</table>
	  </form>
	</div>
</div>

</body>
</html>
