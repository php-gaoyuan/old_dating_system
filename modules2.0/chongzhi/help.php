<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/chongzhi/help.html
 * 如果您的模型要进行修改，请修改 models/modules/chongzhi/help.php
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

	$userinfo=Api_Proxy("user_self_by_uid","*",$user_id);

	$info="<font color='#ce1221' style='font-weight:bold;'>".$er_langpackage->er_currency."</font>：".$userinfo['golds'];

	if($userinfo['user_group'] >1 &&$userinfo['user_group']!='base')
	{
		$groups=$dbo->getRow("select * from wy_frontgroup where gid='$userinfo[user_group]'");

		if($langPackagePara!='zh')
		{
			$groups['name']=str_replace('普通会员','',$groups['name']);
			$groups['name']=str_replace('高级会员',$er_langpackage->js_8,$groups['name']);
			$groups['name']=str_replace('星级会员',$er_langpackage->js_10,$groups['name']);
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
<div class="tabs" style="border:1px solid #ce1221;text-align:left;background:#F5F5B9;padding-left:15px;line-height:25px;">
    <?php echo $info;?>
</div>
<div class="tabs">
    <ul class="menu">
        <li><a href="modules2.0.php?app=user_pay" hidefocus="true"><?php echo $er_langpackage->er_recharge;?></a></li>
        <li><a href="modules2.0.php?app=user_paylog" hidefocus="true"><?php echo $er_langpackage->er_recharge_log;?></a></li>
        <li><a href="modules2.0.php?app=user_consumption" hidefocus="true"><?php echo $er_langpackage->er_consumption_log;?></a></li>
        <li><a href="modules2.0.php?app=user_upgrade" hidefocus="true"><?php echo $er_langpackage->er_upgrade;?></a></li>
        <li><a href="modules2.0.php?app=user_introduce" hidefocus="true"><?php echo $er_langpackage->er_introduce;?></a></li>
        <li class="active"><a href="modules2.0.php?app=user_help" hidefocus="true"><?php echo $er_langpackage->er_help;?></a></li>
    </ul>
</div>
<div class="feedcontainer">

<table width="550" border="1" cellpadding="0" cellspacing="0" bgcolor="#EECAF0" style="font-size: 12px;color: #666;line-height:20px;">
  <tr>
    <td valign="top" bgcolor="#FFFDFF" style="padding:10px;"><strong>1. <?php echo $er_langpackage->help_1;?></strong><br />
<?php echo $er_langpackage->help_2;?>
<br />
  <strong>2.<?php echo $er_langpackage->help_3;?></strong><br />
      <?php echo $er_langpackage->help_4;?> <br />
      <br />
  <strong>3. <?php echo $er_langpackage->help_5;?></strong><br />
      <?php echo $er_langpackage->help_6;?> <br />
      <br />
  <strong>4.<?php echo $er_langpackage->help_7;?></strong><br /><?php echo $er_langpackage->help_8;?>

<br />
  <strong>5.<?php echo $er_langpackage->help_9;?></strong><br />
    <?php echo $er_langpackage->help_10;?></td>
  </tr>
</table>

</div>

<script>


    // 计算页面的实际高度，iframe自适应会用到
    function calcPageHeight(doc) {
        var cHeight = Math.max(doc.body.clientHeight, doc.documentElement.clientHeight)
        var sHeight = Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight)
        var height  = Math.max(cHeight, sHeight)
        return height
    }
    window.onload = function() {
        var height = calcPageHeight(document);
        parent.document.getElementById('ifr').style.height = height +50+ 'px'   ;
		
		  
    }

</script>
</body>