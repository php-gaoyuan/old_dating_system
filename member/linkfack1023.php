<?php
require("includet.php");
require("../foundation/fpages_bar.php");

$page_num=trim(get_argg('page'));

$dbo=new dbex;
dbplugin('r');

//$sql="select * from wy_wzmoney where wuid='".get_session('wz_userid')."' order by id desc";
$sql="select tuid,from_tgid,guoji_time,guoji_shuoming from wy_users where from_tgid='".get_session('wz_userid')."' order by guoji_time desc";

echo $sql;
$dbo->setPages(18,$page_num);//设置分页
$mp_list_rs=$dbo->getRs($sql);
foreach($mp_list_rs as $k=>$v){
	$res=$dbo->getRow("select name from wy_wangzhuan where id='$v[tuid]'");
	$mp_list_rs[$k]['name']=$res['name'];
}
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
	<td colspan="3">记录列表</td>
  </tr>
  <tr class="t_Haader">
	<td align="center" width="50">过继给</td>
    <td align="center" width="120">时间</td>
    <td align="center">详情</td>
  </tr>
  <?php foreach($mp_list_rs as $rs){?>
  <tr>
	<td align="center"><?php echo $rs['name'];?></td>
    <td align="center"><?php echo date("Y-m-d H:i:s",$rs['guoji_time']);?></td>
    <td><?php echo $rs['guoji_shuoming'];?></td>
  </tr>
  <?php }?>
  <tr>
	<td colspan="3"><?php echo page_show($isNull,$page_num,$page_total);?></td>
  </tr>
</table>

</body>
</html>