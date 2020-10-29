<?php
require("includet.php");
require("../foundation/fpages_bar.php");

function gettypes($state)
{
	switch ($state)
	{
	case 1:
	//充值
	  return "充值";
	  break;
	case 2:
	//升级
	  return "充值";
	  break;
	case 3:
	//站内信
	  return "消费";
	  break;
	case 4:
	//礼物
	  return "消费";
	  break;
	default:
	  return "其他";
	}
}

$page_num=trim(get_argg('page'));

$dbo=new dbex;
dbplugin('r');

$sql="select user_id from wy_users where tuid='".get_session('wz_userid')."'";

$uid=$dbo->getRs($sql);

$uids=array();
foreach($uid as $u)
{
	$uids[]=$u['user_id'];
}
$uids=implode(",",$uids);

if(!empty($uids))
{
	//$sql="select * from wy_balance where touid in($uids) and type!='1' and funds !=0 order by id desc";
	$sql="select * from wy_balance where touid in($uids) and state='2' and funds !=0 order by id desc";
}

$dbo->setPages(18,$page_num);//设置分页
$mp_list_rs=$dbo->getRs($sql);
$page_total=$dbo->totalPage;//分页总数
?>
<html>
<head>
<title>网站管理系统</title>
<link href="css/Guest.css" rel="stylesheet" type="text/css" />
<script src="js/system.js"></script>
<style>
.pages_bar{margin-left: 20px;clear: both;float: left; height: auto;overflow: hidden;padding: 6px 0 7px;}
.pages_bar a {border: 1px solid #DDDDDD;color: #AAAAAA;display: block;float: left;font-family: Arial;font-size: 12px;height: 20px;line-height: 18px;margin: 0 2px;overflow: hidden;padding: 3px 8px 0;text-decoration: none;}
.pages_bar a:hover {background: none repeat scroll 0 0 #EEEEEE;color: #4E4E4E;text-decoration: none;}
</style>
</head>
<body>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_01">
  <tr class="t_Title">
	<td colspan="6">消费记录</td>
  </tr>
  <tr class="t_Haader">
	<td>订单号</td>
	<td>会员ID</td>
    <td>会员昵称</td>
    <td>消费类型</td>
    <td>提成金额</td>
    <td>消费时间</td>
  </tr>
  <?php
  if(empty($uid)){?>
   <tr>
	
	<td colspan="6"><?php echo '暂无数据';?></td>

	</tr>
	<?php }?>
  <?php foreach($mp_list_rs as $rs){?>
  <tr>
	<td><?php echo $rs['ordernumber'];?></td>
    <td><?php echo $rs['touid'];?></td>
    <td><?php echo $rs['touname'];?></td>
    <td><?php echo gettypes($rs['type']);?></td>
    <td><?php 
	if($rs['type']==1||$rs['type']==2){
		echo empty($rs['money'])?($rs['funds']*0.1):($rs['money']*0.1);
	}else if($rs['type']==3 || $rs['type']==4){
		echo empty($rs['money'])?($rs['funds']*0.15):($rs['money']*0.15);
	}
	?></td>
    <td><?php echo $rs['addtime'];?></td>
  </tr>
  <?php }?>
  <tr>
	<td colspan="6"><?php echo page_show($isNull,$page_num,$page_total);?></td>
  </tr>
</table>

</body>
</html>