<?php
require("includet.php");
require("../foundation/fpages_bar.php");

$page_num=trim(get_argg('page'));

$dbo=new dbex;
dbplugin('r');

$sql="select * from wy_frontgroup";
$frontgroups=$dbo->getRs($sql);
$frontgroup=array();
foreach($frontgroups as $f)
{
	$frontgroup[$f['gid']]=$f['name'];
}

$sql="select user_id from wy_online";
$onuserids=$dbo->getRs($sql);
$onuid=array();
foreach($onuserids as $uid)
{
	$onuid[]=$uid['user_id'];
}
$onuid=implode(",",$onuid);

if(empty($onuid))
{
	$sql="select * from wy_users where 1!=1";
}
else
{
	$sql="select * from wy_users where tuid='".get_session('wz_userid')."' and user_id in($onuid) order by user_id desc";
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
	<td colspan="5">会员列表</td>
  </tr>
  <tr class="t_Haader">
	<td>会员ID</td>
	<td>会员昵称</td>
    <td>会员帐号</td>
    
    <td>会员类别</td>
    <td>最后登录时间</td>
  </tr>
  <?php foreach($mp_list_rs as $rs){?>
  <tr>
	<td><?php echo $rs['user_id'];?></td>
	<td><?php echo $rs['user_name'];?></td>
    <td><?php echo $rs['user_email'];?></td>
    
    <td><?php if($rs['user_group']=='base'){echo '普通会员';}else {echo $frontgroup[$rs['user_group']];}?></td>
    <td><?php echo $rs['lastlogin_datetime'];?></td>
  </tr>
  <?php }?>
  <tr>
	<td colspan="5"><?php echo page_show($isNull,$page_num,$page_total);?></td>
  </tr>
</table>

</body>
</html>