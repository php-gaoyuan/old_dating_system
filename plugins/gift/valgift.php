<?php
//打开get和post的封装
$getpost_power=true;
//打开系统库的支持
$iweb_power=true;
//打开session
$session_power=true;
//引入系统文件的支持文件
include_once("../includes.php");
//引入自己的配制文件
include_once("config.php");
include_once("../../includes.php");
//引入语言包
$gf_langpackage=new giftlp;
//取得变量区
$uname=get_args("uname");
$accept_name=get_args("accept");
//$accept_id=get_args("accept_id");
//$accept_id=empty($accept_id)?get_args("uid"):$accept_id;
$gift=get_args("gift_img");
if(empty($uname))
{
	$friends=Api_Proxy("pals_self_by_paid","pals_name,pals_id,pals_ico");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" language="javascript" src="/plugins/gift/Common.js"></script>
<script type="text/javascript" language="javascript" src="/servtools/dialog/zDrag.js"></script>
<script type="text/javascript" language="javascript" src="/servtools/dialog/zDialog.js"></script>
<title>礼品</title>
<style type="text/css">
*{
font-size:12px;
}
#zishu li{ float:left; margin-left:5px; list-style:none;}
#zishu .nav_a a{text-decoration:none; display:block; padding-right:8px; background:url(/plugins/gift/right.gif) no-repeat right bottom;margin-top:3px; color:#000; float:left;}
#zishu .nav_a span{font-size:12px;background: url(/plugins/gift/left.gif)  no-repeat  left bottom; display:block; line-height:23px; cursor:hand;padding-left:8px; float:left;}
#zishu li.active a{text-decoration:none; display:block; padding-right:8px; background:url(/plugins/gift/right.gif) no-repeat right top;margin-top:3px; color:#fff; float:left;}
#zishu li.active span{cursor:hand; font-size:12px;background:url(/plugins/gift/left.gif) 0 0 no-repeat; display:block; line-height:23px; padding-left:8px; cursor:hand; float:left;}
#gift_list{ float:left; border:#C2D9F2 solid 1px;margin-bottom:10px;padding:5px;width:500px;height:370px;}
#gift_friends{
	clear:both;
	border:1px solid #C2D9F2;
	position:absolute;
	display:none;
	left: 68px;*left: 70px;
	top: 45px;
	width: 86%;
	background:#FFFFFF;
}
#gift_info
{
background:none repeat scroll 0 0 #ce1221;
border:1px solid #EBDBA5;
margin-bottom:10px;
display:none;
padding:9px 100px;
width:62%;
color:#fff;
}
#gift_list .giftbox
{
	width:72px;float:left;text-align:center;font-size:12px;margin-left:7px;
}
#gift_list span
{
	display:block;
}
#gift_page_list
{
	float:right;text-align:center;margin:10px 0 5px 0;;
}
#gift_page_list a
{
	display:block;width:20px;height:20px;line-height:20px;float:left; border:1px #0096c6 solid;text-decoration:none;margin:0 5px;background-color:#dee7f7;color:#000;
}
#gift_page_list a.active{background-color:#0096c6;color:#fff;}
.tabs
{
	border-bottom: 1px solid #ce1221;
    height: 26px;
    margin-top: 20px;
    position: relative;
	outline: medium none;
}
.tabs li.active {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background-color: #FFFFFF;
    border-color: #ce1221 #ce1221 -moz-use-text-color;
    border-image: none;
    border-style: solid solid none;
    border-width: 1px 1px 0;
    color: #ce1221;
    font-weight: bold;
    text-decoration: none;
    word-break: keep-all;
}
.tabs li {
}
.tabs li {
    background-color: #ce1221;
    color: #FFFFFF;
    float: left;
    height: 26px;
    margin-right: 8px;
}
.tabs li.active a {
    color: #ce1221;
    text-decoration: none;
}
.tabs li a {
    color: #FFFFFF;
    display: block;
    height: 18px;
    padding: 6px 19px 0;
    text-decoration: none;
}
.menu{list-style: none outside none;margin:0px;padding:0px;}
</style>
</head>
<body onload="getGifts(2)">
<div class="tabs" style="padding-left:87px;">
    <ul class="menu">
        <li class="active"><a href="/plugins/gift/gift.php" hidefocus="true"><?php echo $gf_langpackage->gf_put;?></a></li>
        <li><a href="/plugins/gift/gift_box.php" hidefocus="true"><?php echo $gf_langpackage->gf_putin;?></a></li>
        <li><a href="/plugins/gift/gift_outbox.php" hidefocus="true"><?php echo $gf_langpackage->gf_putout;?></a></li>
    </ul>
</div>
<div id="gift_info" ></div>
<form  name="gift" method="post" onsubmit="return check()">
<input type="hidden" name="uid" id="uid" value="<?php echo $uid;?>" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#333333;">
  <tr>
	<td width="60px" height="35px" align="right"><?php echo $gf_langpackage->gf_forto;?>：</td>
	<td><input id="accept" name="accept" style="border:1px #ccc solid;width:80px;" value="<?php echo $uname;?>" onchange="checkname(value)"/>
	<span>
		<!--<a href="#" style="margin-left:5px;color:#005EAC;" id="gift_friends_button"  onclick="showFriends()">选择好友</a>-->
		<select name="selfriend" id="selfriend" onchange="document.getElementById('accept').value=value;">
		  <option value=""><?php echo $gf_langpackage->gf_selfriend;?></option>
		  <?php foreach($friends as $friend){?>
		  <option value="<?php echo $friend['pals_name'];?>"><?php echo $friend['pals_name'];?></option>
		  <?php }?>
		</select>
	</span>
	</td>
  </tr>
  <tr height="100%">
	<td align="right" valign="top"><?php echo $gf_langpackage->gf_gift;?>：</td>
	<td>
		<ul id="zishu">
		  
		  
		  <li class="nav_a" style="float:right;"><input type="submit" name="button" id="button" style="width:50px;" value="<?php echo $gf_langpackage->gf_giveto;?>" /></li>
		</ul>
        <div style="clear:both;"></div>
		<div id="gift_list"></div>
        <div style="clear:both;"></div>
	</td>
  </tr>
  <tr>
	<td align="right" valign="middle"><?php echo $gf_langpackage->gf_zengyan;?>：</td>
	<td height="140"><textarea name="msg" style="border:1px #ccc solid;" cols="36" rows="5" id="textfield"></textarea></td>
  </tr>
</table>
<!--<div id="gift_friends">
	<div style="background:#f7fbff; height:25px; line-height:25px;padding-left:8px;border-bottom:1px solid #C2D9F2;">我的好友</div>
	<div id="friend_list" style="overflow-y:scroll; height:220px;padding:8px;"></div>
	<div style="height:25px;text-align:center;background:#f7fbff;border-top:1px solid #C2D9F2;padding-top:3px;"><input type="button" value="确定"  onclick="hiddenFriends()"/></div>
</div>-->
</form>
<script>

function checkname(obj)
{
	check=new Ajax();
	check.getInfo("/do.php","get","app","act=reg&ajax=1&user_name="+obj,function(c){if(!c){Dialog.alert('<?php echo $gf_langpackage->gf_mess_0;?>');}});
}

//得到对应类型的礼品
function getGifts(type,index)
{
	//调用系统的Ajax类
	ajax=new Ajax(); 
	ajax.getInfo("/plugins/gift/gift_list.php","post","get","type="+type+"&index="+index,"gift_list"); 
}
/*//得到好友列表
function getFriends()
{
	friends=new Ajax(); 
	friends.getInfo("/plugins/gift/friends.php","get","app","","friend_list"); 
}
//显示好友列表
function showFriends()
{
	document.getElementById('gift_friends').style.display='block';
	getFriends();
}
//隐藏好友列表
function hiddenFriends()
{
	var accept_ids=document.getElementsByName('accept_id');
	for(i=0;i<accept_ids.length;i++)
	{
		if(document.getElementsByName('accept_id')[i].checked)document.forms['gift'].accept.value=document.getElementById("gift_accept_"+document.getElementsByName('accept_id')[i].value).innerHTML;
	}
	document.getElementById('gift_friends').style.display='none';
}*/
//检测表单填写的正确性
function check()
{
	var select_flag=false;
	if(document.forms['gift'].accept.value=="")
	{
		document.getElementById('gift_info').style.display='block';
		document.getElementById("gift_info").innerHTML="<?php echo $gf_langpackage->gf_mess_1;?>";
		return false;
	}
	for(i=0;i<document.forms['gift'].gift_img.length;i++)
	{
		if(document.forms['gift'].gift_img[i].checked)select_flag=true;
	}
	if(!select_flag)
	{
		document.getElementById('gift_info').style.display='block';
		document.getElementById("gift_info").innerHTML="<?php echo $gf_langpackage->gf_mess_2;?>";
		return false;
	}
	
}

function changeStyle_gift(obj){
	var tabList = document.getElementById('zishu').getElementsByTagName('li');
	for(i=0;i<tabList.length;i++){
		tabList[i].className = 'nav_a';
	}
	obj.parentNode.className += ' active';
}
</script>
<?php
//判断表单是否正常提交
//if($accept_name!="" && $accept_id!="" && $gift!="")
if($accept_name!="" && $gift!="")
{
	$msg=get_args("msg");
	//通过session得到用户ID
	$send_id=get_sess_userid();
	//通过session得到用户名
	$send_name=get_sess_username();
	date_default_timezone_set("Asia/Shanghai");
	$send_time=date('Y-m-d H:i:s');
	//通过表前缀得到表名
	$order=$table_prefix."order";
	//创建系统对数据库进行操作的对象
	$dbo=new dbex();
	//读写分离，进行读操作
	dbplugin('r');
	$sql="select * from wy_users where user_id=$send_id";
	//得到用户积分
	$user_info=$dbo->getRow($sql);
    $golds = $user_info['golds'];

	$sql="select * from wy_users where user_name='$accept_name'";
	//得到用户积分
	$accept_id=$dbo->getRow($sql);
	$accept_id=$accept_id['user_id'];

	//$score=0;

	//判定礼品的类型，从而处理积分的变化
	$sql="select * from gift_news where id=$gift";
	//得到用户积分
	$gift=$dbo->getRow($sql);
	//print_r($gift);exit;
	 $score=$gift['money'];
	/*
	if($gift['typeid']==1)
	{
		$score=0.00;
	}
	else if($gift['typeid']==2)
	{
		$sql="select count(*) as c from $order where send_id='$send_id' and gifttype='{$gift[typeid]}' and TO_DAYS(send_time)=TO_DAYS(now())";
		$count=$dbo->getRow($sql);
		if(intval($user_info['user_group'])==2)
		{
			if($count['c']<1)
			{
				$score=0.00;
			}
		}
		else if(intval($user_info['user_group'])==3)
		{
			if($count['c']<5)
			{
				$score=0.00;
			}
		}
	}
		*/
	dbplugin('w');
	//判定剩下的积分是否还能发送礼品
	if(($user_info['golds']-$score)>=0)
	{	
		
		//写数据
		
		$ordernumber='S-P'.time().mt_rand(100,999);
		$addtime=time();
		$addtime=date('Y-m-d H:i:s',$addtime);
		$sql="insert into wy_balance set type='4',uid='$send_id',uname='$send_name',touid='$accept_id',touname='$accept_name',message='送礼物，价格：$score',state='2',addtime='$addtime',funds='$score',ordernumber='$ordernumber'";
	
		if(!$dbo->exeUpdate($sql)){
			exit('送礼物失败');
		}

		
		//发送的礼品记录到数据库
		$sql="insert into $order(send_id,accept_id,send_name,accept_name,msg,gift,send_time,gifttype) values('$send_id','$accept_id','$send_name','$accept_name','$msg','{$gift[patch]}','$send_time','{$gift[typeid]}')";
		if($dbo->exeUpdate($sql));
		{
			//显示发送成功
			echo"<script>document.getElementById('gift_info').style.display='block';document.getElementById('gift_info').innerHTML='".$gf_langpackage->gf_mess_4."';</script>";
			//更新用户的积分
			$sql="update wy_users set golds=$golds-$score where user_id=$send_id";
			$dbo->exeUpdate($sql);
		}
	}
	else
	{
		//当积分不够时提醒用户
		echo"<script>document.getElementById('gift_info').style.display='block';document.getElementById('gift_info').innerHTML='".$gf_langpackage->gf_mess_5."';</script>";
	}	
}
?>
</body>
</html>
