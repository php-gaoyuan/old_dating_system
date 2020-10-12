<?php
header("content-type:text/html;charset=utf-8");
require("api/base_support.php");
//语言包引入
$u_langpackage=new userslp;
$er_langpackage=new rechargelp;
//必须登录才能浏览该页面
require("foundation/auser_mustlogin.php");

$user_id=get_sess_userid();
	
$userinfo=Api_Proxy("user_self_by_uid","*",$user_id);

$info="<font color='#ce1221' style='font-weight:bold;'>".$er_langpackage->er_currency."</font>：".$userinfo['golds'];

	if(!empty($userinfo['user_group'])&&$userinfo['user_group']!='base')
	{
		$groups=$dbo->getRow("select * from wy_frontgroup where gid='$userinfo[user_group]'");

		if($langPackagePara=='en')
		{
			$groups['name']=str_replace('普通会员','VIP member',$groups['name']);
			$groups['name']=str_replace('高级会员','Silver member',$groups['name']);
			$groups['name']=str_replace('星级会员','Star Member',$groups['name']);
		}
		$info.="&nbsp;&nbsp;&nbsp;&nbsp;".$er_langpackage->er_nowtype."：".$groups['name'];

		$groups=$dbo->getRow("select * from wy_upgrade_log where mid='$user_id' and state='0' order by id desc limit 1");
		//print_r($groups);
		$startdate=strtotime(date("Y-m-d"));
		$enddate=strtotime($groups['endtime']);
		$days=round(($enddate-$startdate)/3600/24);
		if($days>0){
			$info.="&nbsp;&nbsp;&nbsp;&nbsp;".$er_langpackage->er_howtime."：".$days.$er_langpackage->er_day;
		}else{
			$sql="update wy_upgrade_log set state='1' where mid='$user_id'";
			$dbo->exeUpdate($sql);
			$sql="update wy_users set  user_group='1'   where  user_id='$user_id'";
			$dbo->exeUpdate($sql);
		}
		
	}
if($_POST){
	$userinfo=$dbo->getRow("select horn,user_name from wy_users where user_id='$user_id'");
	if($userinfo['horn']<1){
		echo "<script>parent.Dialog.alert('".$u_langpackage->laba_send_fail."');history.back();</script>";
		exit;
	}
	
	
	$content=$_POST['content'];
	if($content=='' || $content==$u_langpackage->fasongneirong){
		$tishiyu=$u_langpackage->laba_send_empty;
		echo "<script>parent.Dialog.alert('$tishiyu');history.back();</script>";
		exit;
	}
	//关键词过滤
	$guolvs=explode(',',$filtrateStr);
	for($i=0;$i<count($guolvs);$i++){
		//$content=str_replace($guolvs[$i],'***',$content);
		$res=strstr($content,$guolvs[$i]);
		//var_dump($guolvs[$i]);var_dump($content);exit;
		if($res){
			echo "<script>top.Dialog.alert('$u_langpackage->feifazifu');history.go(-1)</script>";
			exit;
		}
	}
	$sql="update wy_users set horn=horn-1 where user_id='$user_id'";
	if($dbo->exeUpdate($sql)){
		$tishiyu=$u_langpackage->u_sent_successfully;
	}else{
		$tishiyu=$u_langpackage->laba_send_fail;exit;
	}
	
	$start_time=time();
	$end_time=time()+3600*24;
	$user_name=$userinfo['user_name'];
	$sql="insert into wy_horn(user_id,user_name,horn_content,start_time,end_time) values('$user_id','$user_name','$content','$start_time','$end_time')";
	$dbo->exeUpdate($sql);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css" />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/base.css" />
<script language=JavaScript src="skin/default/js/jooyea.js"></script>
<SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>

<script type='text/javascript'>
function changeStyle(obj){
	var tagList = obj.parentNode;
	var tagOptions = tagList.getElementsByTagName("li");
	for(i=0;i<tagOptions.length;i++){
		if(tagOptions[i].className.indexOf('active')>=0){
			tagOptions[i].className = '';
		}
	}
	obj.className = 'active';
}
window.onload = function(){
	document.getElementById('laba_content').onkeydown = function(){
		this.style.color='#000';
		if(this.value.length >= 30) 
		event.returnValue = false; 
	} 
} 
function maxlengths(){
	if(document.getElementById('laba_content').value.length>29){
		top.Dialog.alert('Too lang!');return false;
	}
}
</script>
</head>
<body id="main_iframe">
<div class="tabs" style="border:1px solid #ce1221;text-align:left;background:#F5F5B9;padding-left:15px;line-height:25px;">
<?php echo $info;?>
</div>
<div class="tabs">
    <ul class="menu">
        <li class="<?php if($_GET['active']==1) echo 'active';?>"><a href="modules.php?app=u_horn&active=1" ><?php echo $u_langpackage->wodelaba;?></a></li>
        <li class="<?php if($_GET['active']==2) echo 'active';?>"><a href="modules.php?app=u_horn_buy&active=2" ><?php echo $u_langpackage->goumailaba;?></a></li>
        <li class="<?php if($_GET['active']==4) echo 'active';?>"><a href="modules.php?app=u_horn_js&active=4" ><?php echo $u_langpackage->labajieshao;?></a></li>
    </ul>
</div>
<div style="min-height:100px;border:1px solid #ddd;margin-top:20px;text-align:left;padding:10px;">
	<?php if(!$_POST){ ?>
	<form action="" method="post" onsubmit="return maxlengths();">
	<textarea id="laba_content" name="content" maxlength="29"  onfocus="if(this.value=='<?php echo $u_langpackage->fasongneirong;?>'){this.value='';}" onblur="if(this.value==''){this.value='<?php echo $u_langpackage->fasongneirong;?>';this.style.color='#A9A9A9'}" ><?php echo $u_langpackage->fasongneirong;?></textarea>
	<input class="send_laba" type="submit"  value="<?php echo $u_langpackage->laba_send;?>" />
	</form>
	<?php }else{
		echo "<div style='font-size:20px;color:#ff0000'>$tishiyu</div>";
		echo "<a style='font-size:16px;color:#ff000;' href='modules.php?app=u_horn&active=1'>".$u_langpackage->u_bak."</a>";
	}?>
</div>


</body>
</html>