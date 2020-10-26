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
if($_POST){
	$buy_num=(int)$_POST['buy_num'];
	$userinfo=$dbo->getRow("select golds,user_name from wy_users where user_id='$user_id'");
	if($userinfo['golds']<$buy_num){
		echo "<script>parent.Dialog.alert('".$u_langpackage->laba_buy_fail."');history.back();</script>";
		exit;
	}else{
		$uinfo=$dbo->getRow("select horn,golds from wy_users where user_id='$user_id'");
		$new_golds=$uinfo['golds']-$buy_num;
		$new_horn=$uinfo['horn']+$buy_num;
		$sql="update wy_users set golds=$new_golds , horn=$new_horn where user_id='$user_id'";
		if($dbo->exeUpdate($sql)){
			$tishiyu=$u_langpackage->laba_buy_suss.$buy_num;
			
			dbtarget('w',$dbServs);//定义写操作
			//写入消费记录
			$ordernumber="LB".time().mt_rand(100,999);
			$dbo->exeUpdate("insert into wy_balance set type='6',uid='$user_id',uname='$userinfo[user_name]',touid='$user_id',touname='$userinfo[user_name]',message='兑换喇叭消费".$buy_num."',state='2',addtime='".date('Y-m-d H:i:s')."',funds='$buy_num',ordernumber='$ordernumber'");
		}
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
	<?php if(!$_POST){ ?>
	<form action="" method="post" onsubmit="return buy_horn()">
	<div class="buy_txt"><?php echo $u_langpackage->laba_buy_num;?><input name="buy_num"  type="text" size="3" onkeyUp="if(isNaN(this.value)){this.value=0};document.getElementById('jinbi_num').innerHTML=parseInt(this.value)" onblur="document.getElementById('jinbi_num').innerHTML=parseInt(this.value)" style="text-align:center;" maxlength="10"/><?php echo $u_langpackage->laba_buy_num2;?> （<?php echo $u_langpackage->laba_xiaohaojinbi;?><span id="jinbi_num">0</span>）</div>
	<input class="send_laba" type="submit" value="<?php echo $u_langpackage->laba_enter;?>" />
	</form>
	<?php }else{
		echo "<div style='font-size:18px;color:#ff0000;line-height:50px;'>$tishiyu</div>";
	}?>
</div>


</body>
</html>