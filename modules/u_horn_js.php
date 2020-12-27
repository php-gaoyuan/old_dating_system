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

	if(!empty($userinfo['user_group'])&&$userinfo['user_group']!='1')
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
function buy_horn(){
	var buy_name=document.getElementsByName('buy_num')[0];
	if(buy_name.value<=0){
		return false;
	}else{
		if(confirm('<?php echo $u_langpackage->laba_xiaohaojinbi;?>'+document.getElementById('jinbi_num').innerHTML)){
			return true;
		}else{return false;}
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
        <li class="<?php if($_GET['active']==1) echo 'active';?>"><a href="modules2.0.php?app=u_horn&active=1" ><?php echo $u_langpackage->wodelaba;?></a></li>
        <li class="<?php if($_GET['active']==2) echo 'active';?>"><a href="modules2.0.php?app=u_horn_buy&active=2" ><?php echo $u_langpackage->goumailaba;?></a></li>
        <li class="<?php if($_GET['active']==4) echo 'active';?>"><a href="modules2.0.php?app=u_horn_js&active=4" ><?php echo $u_langpackage->labajieshao;?></a></li>
    </ul>
</div>
<div style="min-height:100px;border:1px solid #ddd;margin-top:20px;text-align:left;padding:10px;">
	<ul class="laba_jieshao">
		<li><?php echo $u_langpackage->laba_mess1;?></li>
		<li><?php echo $u_langpackage->laba_mess2;?></li>
		<li><?php echo $u_langpackage->laba_mess3;?></li>
		
	</ul>
</div>


</body>
</html>