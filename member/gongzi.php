<?php
require("includet.php");
require("../foundation/fpages_bar.php");
//echo "<pre>";print_r($_SESSION);exit

$user_id=get_session('wz_userid');

$page_num=trim(get_argg('page'));

$dbo=new dbex;
$dbo1=new dbex;
dbplugin('r');

$sql="select * from wy_wzmoney where wuid='$user_id'";


//echo "<pre>";print_r($mp_list);exit;

//Add By Root Begin

$rootYear = '';

if ($_POST['submit']){  
  echo "<b><font color=\"red\">注意：选择的年份为：".$_POST['y']."年</font></b>";    // 下拉框的值
  
  $rootYear = $_POST['y'];
  $rootMonth = $_POST['m'];
  $sql.=" and gotime like '%".$rootYear."-".$rootMonth."%'";
  
  setcookie("rootYear", $rootYear);
  setcookie("rootMonth", $rootMonth);
}
$mp_list=$dbo->getRs($sql);

//$dbo->setPages(15,$page_num);//设置分页


//$page_total=$dbo->totalPage;//分页总数

?>
<html>
<head>
<title>网站管理系统</title>
<link href="css/Guest.css" rel="stylesheet" type="text/css" />
<script src="js/system.js"></script>
<script src="js/jquery.min.js"></script>

<style>
.pages_bar{margin-left: 20px;clear: both;float: left; height: auto;overflow: hidden;padding: 6px 0 7px;}
.pages_bar a {border: 1px solid #DDDDDD;color: #AAAAAA;display: block;float: left;font-family: Arial;font-size: 12px;height: 20px;line-height: 18px;margin: 0 2px;overflow: hidden;padding: 3px 8px 0;text-decoration: none;}
.pages_bar a:hover {background: none repeat scroll 0 0 #EEEEEE;color: #4E4E4E;text-decoration: none;}
.pages_bar .current_page{font-weight: bold;color: #333;}
</style>
</head>
<body>

<!-- Add By Root Begin -->
<form method="get" action="gongzi.php" style="display: block;padding:15px;">

					<select name="y">
						<option value="0">年</option>
						<script>for(var i=2014;i<2038;i++){document.write("<option value='"+i+"'>"+i+"</option>");}</script>
					</select>
					
					<select name="m">
						<option value="0">月</option>
						<script>for(var i=1;i<13;i++){document.write("<option value='"+i+"'>"+i+"</option>");}</script>
					</select>
					

						<input value="搜索" name="submit" type="submit">
</form>
					
<!-- Add By Root End -->
			
<form method="post" action="shoping_del.php">
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_01">
  
  
  <tr class="t_Haader">
	<td>类型</td>
	<td>金额</td>
    <td>详情</td>
    <td>时间</td>
  </tr>
  <?php
  if(empty($mp_list)){?>
   <tr>
	
	<td colspan="4">暂无数据</td>

	</tr>
	<?php }else{?>
	  <?php foreach($mp_list as $rs){?>
	  <tr>
		<td>
		<?php 
		if($rs['type'] == 0){echo "其他";} 
		if($rs['type'] == 1){echo "工资";} 
		if($rs['type'] == 2){echo "拒付";} 
		
		?>
		</td>

		<td><?php echo $rs['money'];?></td>
		<td><?php echo $rs['reason'];?></td>
		
		<td><?php echo $rs['gotime'];?></td>
		
		
	  </tr>
	  <?php }?>
	
  <tr>
	<td colspan="7"><?php //echo page_show($isNull,$page_num,$page_total);?></td>
  </tr>
  <?php }?>
</table>

</body>
</html>