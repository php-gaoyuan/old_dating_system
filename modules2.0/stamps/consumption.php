<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/stamps/consumption.html
 * 如果您的模型要进行修改，请修改 models/modules/stamps/consumption.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
/*
 * 此段代码由debug模式下生成运行，请勿改动！
 * 如果debug模式下出错不能再次自动编译时，请进入后台手动编译！
 */
/* debug模式运行生成代码 开始 */
if(!function_exists("tpl_engine")) {
	require("foundation/ftpl_compile.php");
}
if(filemtime("templates/default/modules/stamps/consumption.html") > filemtime(__file__) || (file_exists("models/modules/stamps/consumption.php") && filemtime("models/modules/stamps/consumption.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/stamps/consumption.html",1);
	include(__file__);
}else {
/* debug模式运行生成代码 结束 */
?><?php
	//引入公共模块
	require("foundation/module_event.php");
	require("foundation/fpages_bar.php");
	require("api/base_support.php");
	
	//引入语言包
	$er_langpackage=new rechargelp;
	$dopost="savesend";
	
	//必须登录才能浏览该页面
	require("foundation/auser_mustlogin.php");
	
	$user_id=get_sess_userid();
	$page_num=trim(get_argg('page'));

	$dbo=new dbex;
	dbplugin('r');

	$sql="select * from wy_balance where type!='1' and state='2' and uid='$user_id' order by id desc";

	$dbo->setPages(10,$page_num);//设置分页
	$mp_list_rs=$dbo->getRs($sql);
	$page_total=$dbo->totalPage;//分页总数

	$none_data="content_none";
	$isNull=0;
	if(empty($mp_list_rs)){
		$none_data="";
		$isNull=1;
	}

	function getstate($state)
	{
		global $er_langpackage;
		if($state==2)
			return $er_langpackage->er_good;
	}

	function gettypes($type)
	{
		global $er_langpackage;
		if($type==2)
			return $er_langpackage->er_updage;
		else if($type==3)
			return $er_langpackage->er_putmsg;
		else if($type==4)
			return $er_langpackage->er_gift;
	}

	$userinfo=Api_Proxy("user_self_by_uid","*",$user_id);
	$info="<font color='#ce1221' style='font-weight:bold;'>".$er_langpackage->er_currency."</font>：".$userinfo['golds'];

	if(!empty($userinfo['user_group'])&&$userinfo['user_group']!='base')
	{
		$groups=$dbo->getRow("select * from wy_frontgroup where gid='$userinfo[user_group]'");

		if($langPackagePara=='en')
		{
			$groups['name']=str_replace('VIP会员','VIP member',$groups['name']);
			$groups['name']=str_replace('钻石会员','diamond member',$groups['name']);
			$groups['name']=str_replace('紫钻会员','Purple drill member',$groups['name']);
		}
		$info.="&nbsp;&nbsp;&nbsp;&nbsp;".$er_langpackage->er_nowtype."：".$groups['name'];

		$groups=$dbo->getRow("select * from wy_upgrade_log where mid='$user_id' and state='0' order by id desc limit 1");
		$startdate=strtotime(date("Y-m-d"));
		$enddate=strtotime($groups['endtime']);
		$days=round(($enddate-$startdate)/3600/24);
		$info.="&nbsp;&nbsp;&nbsp;&nbsp;".$er_langpackage->er_howtime."：".$days.$er_langpackage->er_day;
	}
?><link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css" />
<body onload="parent.get_mess_count();">
<div class="tabs" style="border:1px solid #ce1221;text-align:left;padding-left:15px;padding-top:5px;">
    <?php echo $info;?>
</div>
<div class="tabs">
    <ul class="menu">
        <li><a href="modules.php?app=user_pay" hidefocus="true"><?php echo $er_langpackage->er_recharge;?></a></li>
        <li><a href="modules.php?app=user_paylog" hidefocus="true"><?php echo $er_langpackage->er_recharge_log;?></a></li>
        <li class="active"><a href="modules.php?app=user_consumption" hidefocus="true"><?php echo $er_langpackage->er_consumption_log;?></a></li>
        <li><a href="modules.php?app=user_upgrade" hidefocus="true"><?php echo $er_langpackage->er_upgrade;?></a></li>
        <li><a href="modules.php?app=user_introduce" hidefocus="true"><?php echo $er_langpackage->er_introduce;?></a></li>
        <li><a href="modules.php?app=user_help" hidefocus="true"><?php echo $er_langpackage->er_help;?></a></li>
    </ul>
</div>
<div class="feedcontainer">
	<ul id="sec_Content">
	<li style="height:auto;padding: 10px 25px 10px 25px;">
<table width="510" border="1" cellspacing="0" cellpadding="0" style="text-align:center;font-size:12px;">
  <tr>
	<td height="30" style="font-weight:bold;"><?php echo $er_langpackage->er_onumber;?></td>
	<td style="font-weight:bold;"><?php echo $er_langpackage->er_topeo;?></td>
	<td style="font-weight:bold;"><?php echo $er_langpackage->er_ortype;?></td>
	<td style="font-weight:bold;"><?php echo $er_langpackage->er_hapeo;?></td>
	<td style="font-weight:bold;"><?php echo $er_langpackage->er_ostat;?></td>
	<td style="font-weight:bold;"><?php echo $er_langpackage->er_otime;?></td>
  </tr>
<?php foreach($mp_list_rs as $rs){?>
  <tr>
	<td height="30"><?php echo $rs['ordernumber'];?></td>
	<td><?php echo $rs['uname'];?></td>
	<td><?php echo gettypes($rs['type']);?></td>
	<td><?php echo empty($rs['touname'])?$rs['uname']:$rs['touname'];?></td>
	<td><?php echo getstate($rs['state']);?></td>
	<td><?php echo date('Y-m-d',strtotime($rs['addtime']));?></td>
  </tr>
<?php }?>
</table>
</li>
<li style="height:auto;border-bottom:0px;padding: 0px 15px;"><?php echo page_show($isNull,$page_num,$page_total);?></li>
<li class="guide_info <?php echo $none_data;?>"><?php echo $er_langpackage->er_full;?></li>
</ul>
</div>
</body><?php } ?>