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

$res=$dbo->getRow("select horn from wy_users where user_id='$user_id'");
$laba=$res['horn'];

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
	<?php 
		if($laba && $laba>0){ ?>
		<div style="font-size:20px;"><?php echo $u_langpackage->labashuliang;?>:<b style="color:#CE1221"><?php echo $laba;?></b></div>
		<div class="use_laba"><a href="modules.php?app=u_horn_fs"><?php echo $u_langpackage->shiyonglaba;?></a></div>
		
	<?php	}else{
			echo "<span>暂时没有喇叭！<a href='modules.php?app=u_horn_buy&active=2' hidefocus='true'>去购买</a></span>";
		}
	?>
</div>

<script type="text/javascript">
	//KE.show({
	//	id:'CONTENT',
	//	resizeMode:0
	//});


		  // 计算页面的实际高度，iframe自适应会用到
    function calcPageHeight(doc) {
        var cHeight = Math.max(doc.body.clientHeight, doc.documentElement.clientHeight)
        var sHeight = Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight)
        var height  = Math.max(cHeight, sHeight)
        return height
    }

		
    window.onload = function() {

		
	   
        var height = calcPageHeight(document);
        parent.document.getElementById('ifr').style.height = height +500+ 'px'   ;
		
		  
    }
	</script>

</body>
</html>