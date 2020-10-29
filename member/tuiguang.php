<?php
require ("includet.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>网站管理系统</title>
<link href="css/Guest.css" rel="stylesheet" type="text/css" />
<script src="js/system.js"></script>
</head>
<body>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_01">
  <tr>
	<td>
		<dl class="invite_info">
			<dt><strong>邀请更多的朋友和同事加入www.puivip.com！</strong></dt>
			<dd>您可以通过QQ、MSN等IM工具，或者发送邮件，把下面的链接告诉你的好友，邀请他们加入进来。</dd>
			<dd>http://www.puivip.comn/?tuid=<?php echo get_session('wz_userid');?></dd>
			<dd>您还可以修改或直接点击“复制”按钮，将下边的简短邀请函通过QQ、MSN或Email发送给更多好友。</dd>
			<dd><strong>简短邀请函:</strong></dd>
			<dd><textarea class="textarea" id="codeTxt" style="height:180px; width:550px; overflow-x:hidden">
Hi，我是<?php echo get_session('wz_uname');?>，

www.puivip.com上建立了个人主页，邀请你也加入并成为我的好友。
加入到我的好友中，你就可以通过我的个人主页了解我的近况，分享我的照片，随时与我保持联系。
邀请附言：
点击以下链接，接受好友邀请:http://www.puivip.com/?tuid=<?php echo get_session('wz_userid');?></textarea>
<input type="button" name="anniu1" onClick='copyToClipBoard()' value="复制内容，传给QQ/MSN上的好友"> 
			</dd>
		</dl>
	</td>
  </tr>
</table>

</body>
</html>

<script language="javascript"> 
function copyToClipBoard(){ 
var Url2=document.getElementById("codeTxt"); 
Url2.select(); // 选择对象 
document.execCommand("Copy"); // 执行浏览器复制命令 
alert("复制成功，请粘贴到你的QQ/MSN上推荐给你的好友"); 
} 
</script>