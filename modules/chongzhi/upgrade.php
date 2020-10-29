<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/chongzhi/upgrade.html
 * 如果您的模型要进行修改，请修改 models/modules/chongzhi/upgrade.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
	//引入公共模块
	require("foundation/module_event.php");
	require("api/base_support.php");
	
	//引入语言包
	$er_langpackage=new rechargelp;
	$dopost="savesend";
	
	//必须登录才能浏览该页面
	require("foundation/auser_mustlogin.php");
	
	$user_id=get_sess_userid();
	//限制时间段访问站点
	limit_time($limit_action_time);

	$friends=Api_Proxy("pals_self_by_paid","pals_name,pals_id,pals_ico");

	$userinfo=Api_Proxy("user_self_by_uid","*",$user_id);

	$info="<font color='#ce1221' style='font-weight:bold;'>".$er_langpackage->er_currency."</font>：".$userinfo['golds'];

	if($userinfo['user_group'] >1 && $userinfo['user_group']!='base')

	{

		$groups=$dbo->getRow("select endtime from wy_upgrade_log where mid='$user_id' and state='0' order by id desc limit 1");

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
		
		
		$groups=$dbo->getRow("select name from wy_frontgroup where gid='$userinfo[user_group]'");


		if($langPackagePara!='zh')

		{

			$groups['name']=str_replace('普通会员','',$groups['name']);

			$groups['name']=str_replace('高级会员',$er_langpackage->js_8,$groups['name']);

			$groups['name']=str_replace('星级会员',$er_langpackage->js_10,$groups['name']);

		}
		if($days>0){
			$userinfo=Api_Proxy("user_self_by_uid","*",$user_id);
			$info.="&nbsp;&nbsp;&nbsp;&nbsp;".$er_langpackage->er_nowtype."：".$groups['name'];
		}
	}
	$uid=get_argg('user_id');
	if($uid){
		$u=$dbo->getRow("select user_name from wy_users where user_id='$uid'");
	}
?><link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css" />
<script language=JavaScript src="skin/default/js/jooyea.js"></script>
<SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDrag.js"></script>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDialog.js"></script>
<script type="text/javascript" language="javascript" src="skin/default/jooyea/jquery-1.9.1.min.js"></script>
<script>
function check(obj)
{
	var check=new Ajax();
	check.getInfo("do.php","get","app","act=reg&ajax=1&user_name="+obj,function(c){if(!c){Dialog.alert('<?php echo $er_langpackage->er_Dos_notex;?>');}});
}

function supert(obj)
{
	if(obj><?php echo $userinfo['golds'];?>)
	{
		Dialog.confirm('<?php echo $er_langpackage->er_mess;?>'+<?php echo $userinfo['golds'];?>+'<?php echo $er_langpackage->er_mess2;?>',function (){location='modules.php?app=user_pay';});
	}
}
</script>
<body>
<div class="tabs" style="border:1px solid #ce1221;text-align:left;background:#F5F5B9;padding-left:15px;line-height:25px;">
    <?php echo $info;?>
</div>
<div class="tabs">
    <ul class="menu">
        <li><a href="modules.php?app=user_pay" hidefocus="true"><?php echo $er_langpackage->er_recharge;?></a></li>
        <li><a href="modules.php?app=user_paylog" hidefocus="true"><?php echo $er_langpackage->er_recharge_log;?></a></li>
        <li><a href="modules.php?app=user_consumption" hidefocus="true"><?php echo $er_langpackage->er_consumption_log;?></a></li>
        <li class="active"><a href="modules.php?app=user_upgrade" hidefocus="true"><?php echo $er_langpackage->er_upgrade;?></a></li>
        <li><a href="modules.php?app=user_introduce" hidefocus="true"><?php echo $er_langpackage->er_introduce;?></a></li>
        <li><a href="modules.php?app=user_help" hidefocus="true"><?php echo $er_langpackage->er_help;?></a></li>
    </ul>
</div>
<div class="feedcontainer gold_list">
	<div id="sec_Content">
	<form id="pay" name="pay" method="post" action="do.php">
		<input name="act" type="hidden" value="upgrade" />
		<div style="font-weight:700;font-size:18px;line-height:40px;text-align:left">&nbsp;</div>
		<div class="pay_content">
			<label>
				<input type="radio" name="touser" value="1" <?php if(!$uid){echo 'checked';}?> onclick="$('#friends_text').css('display','none');$('#friends').val('')" />
				<?php echo $er_langpackage->er_oneself;?>
			</label>
			<label>
				<input type="radio" name="touser" value="2" <?php if($uid){echo 'checked';}?> onclick="$('#friends_text').css('display','')"/>
				<?php echo $er_langpackage->er_friends;?>
				<span id="friends_text" style="<?php if($uid){echo 'display:';}else{echo 'display:none';}?>">
					<input type="text" name="friends" id="friends" value="<?php echo $u['user_name'];?>" style="width:80px;height:25px;" onchange="check(value)" />
					<select name="selfriend" id="selfriend" onchange="document.getElementById('friends').value=value;">
						<option value=""><?php echo $er_langpackage->er_choose_fr;?></option>
						<?php foreach($friends as $friend){?>
						<option value="<?php echo $friend['pals_name'];?>"><?php echo $friend['pals_name'];?></option>
						<?php }?>
					</select>
				</span>
			</label>
		</div>
   <div class="feedcontainer_ul" style="border-right:1px solid #ccc">
		<div style="height:auto;padding: 19px 15px;text-align:left;font-weight:bold;">
			<img  src="skin/<?php echo $skinUrl;?>/images/xin/gaoji.png" style="vertical-align:middle;"/>&nbsp;<?php echo $er_langpackage->er_vip;?>：
		</div>
		<div style="height:auto;padding: 10px 15px;text-align:left;border-bottom:0px;">
			<label><input name="zibi" type="radio" value="vip1" onclick="supert(30)" />&nbsp;<?php echo $er_langpackage->er_vip_1y;?></label>
		</div>
		<div style="height:auto;padding: 10px 15px;text-align:left;border-bottom:0px;">
			<label><input name="zibi" type="radio" value="vip2" onclick="supert(50)" />&nbsp;<?php echo $er_langpackage->er_vip_3y;?></label>
		</div>
		<div style="height:auto;padding: 10px 15px;text-align:left;border-bottom:0px;">
			<label><input name="zibi" type="radio" value="vip3" onclick="supert(90)" />&nbsp;<?php echo $er_langpackage->er_vip_6y;?></label>
		</div>
		<div style="height:auto;padding: 10px 15px;text-align:left;border-bottom:0px;">
			<label><input name="zibi" type="radio" value="vip4" onclick="supert(150)" />&nbsp;<?php echo $er_langpackage->er_vip_1n;?></label>
			<input style="cursor:pointer;box-shadow:1px 1px 0 0 #343434;" type="submit" name="button" id="button"  value="<?php echo $er_langpackage->er_goupgrade;?>" />
		</div>
	</div>
	<div class="feedcontainer_ul">
	
		<div style="height:auto;padding: 19px 15px;text-align:left;font-weight:bold;">
			<img  src="skin/<?php echo $skinUrl;?>/images/xin/vip.gif" style="vertical-align:middle;"/>&nbsp;<?php echo $er_langpackage->er_zvip;?>：
		</div>
		<div style="height:auto;padding: 10px 15px;text-align:left;border-bottom:0px;">
			<label><input name="zibi" type="radio" value="zvip1" onclick="supert(199)" />&nbsp;<?php echo $er_langpackage->er_zvip_1y;?></label>
		</div>
		<div style="height:auto;padding: 10px 15px;text-align:left;border-bottom:0px;">
			<label><input name="zibi" type="radio" value="zvip2" onclick="supert(499)" />&nbsp;<?php echo $er_langpackage->er_zvip_3y;?></label>
		</div>
		<div style="height:auto;padding: 10px 15px;text-align:left;border-bottom:0px;">
			<label><input name="zibi" type="radio" value="zvip3" onclick="supert(899)" />&nbsp;<?php echo $er_langpackage->er_zvip_6y;?></label>
		</div>
		<div style="height:auto;padding: 10px 15px;text-align:left;border-bottom:0px;">
			<label><input name="zibi" type="radio" value="zvip4" onclick="supert(1499)" />&nbsp;<?php echo $er_langpackage->er_zvip_1n;?></label>
			<input style="cursor:pointer;box-shadow:1px 1px 0 0 #343434;" type="submit" name="button" id="button" value="<?php echo $er_langpackage->er_goupgrade;?>" />	
		</div>
	</div>
</form>
</div>
</div>
</body>