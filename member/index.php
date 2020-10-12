<?php
require("includet.php");

if(get_args("act")=='loginout')
{
	session_unset();
	$act="login";
}

$wz_userid=get_session('wz_userid');
if($wz_userid)
{
	echo "<script>location.href='default.php';</script>";
	exit;
}

if(get_args("act")=="login")
{
	$userpwd=get_args("userpwd");
	$email=get_args("email");

	$dbo=new dbex;
	dbtarget('r',$dbServs);
	$sql="select * from wy_wangzhuan where name='$email'";
	$wangzhuan=$dbo->getRow($sql);
	if(count($wangzhuan)>1&&md5($userpwd)==$wangzhuan['password'])
	{
		if($wangzhuan['loginstate']==1)
		{
			echo "<script>alert('你的帐号正在被审核，请耐心等待。');</script>";
			$act="login";
		}
		else
		{
			$logintime=time();
			set_session('wz_userid',$wangzhuan['id']);
			set_session('wz_uname',$wangzhuan['name']);
			set_session('logintime',$logintime);
			$sql="update wy_wangzhuan set logintime='$logintime',loginip='$_SERVER[REMOTE_ADDR]' where id='$wangzhuan[id]'";
			$dbo->exeUpdate($sql);
			echo "<script>location.href='default.php';</script>";
			exit;
		}
	}
	else
	{
		echo "<script>alert('你的你输入的帐号或密码有误');</script>";
		$act="login";
	}
}
else
{
	$act="login";
}
?>
















<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>会员系统 v1.0</title>
<link href="new/login.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
var jq=$.noConflict();
</script>
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
		alert("请输入登陆密码！");
		document.User_Login.userpwd.focus();
		return false;
	}
}
-->
</script>
<script type="text/javascript">
jq(document).ready(function(){
	jq("#clear").click(function(){
		jq("#input_01").val("");
		jq("#input_02").val("");
	});
});
</script>

<style type="text/css">
#submit:hover{cursor:pointer;}
#clear:hover{cursor:pointer;}
</style>
</head>
<body style="background:url('new/bg.jpg') repeat">
<div id="login-box">
   <div class="login-main">
   	  <form id="User_Login" name="User_Login" method="post" action="" onSubmit="return CheckForm_UserLogin()">
<div style="position:relative;width:130px;height:24px;top:64px;left:157px"><input style='padding-top:0px' name="email" type="text" class="input_01" id="input_01" maxlength="30" /></div>
<div style="position:relative;width:130px;height:24px;top:79px;left:157px"><input style='padding-top:0px' name="userpwd" type="password" class="input_01" id="input_02" maxlength="30" /></div>
<input type="hidden" name="act" value="login" />
<div style="position:relative;width:64px;height:28px;top:113px;left:220px;"><input name="Submit" type="submit" id="submit" class="btn_01" value="" /></div>
<div style="position:relative;width:64px;height:28px;top:185px;left:315px;"><input name="Submit" type="button" id="clear" value="" /></div>
	  </form>
   </div>
   <div class="login-power"></div>
</div>
</body>
</html>

