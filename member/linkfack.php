<?php
require("includet.php");
require("../foundation/fpages_bar.php");
//echo "<pre>";print_r($_SESSION);exit;
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
$dbo1=new dbex;
dbplugin('r');

$sql="select user_id from wy_users where tuid='".get_session('wz_userid')."'";

$uid=$dbo->getRs($sql);

$uids=array();
foreach($uid as $u)
{
	$uids[]=$u['user_id'];
}
$uids=implode(",",$uids);
//echo $uids;
$tiaojian='';

//Add By Root Begin

$rootYear = '';

if ($_POST['submit']){  
  echo "<b><font color=\"red\">注意：选择的年份为：".$_POST['birth_year']."年</font></b>";    // 下拉框的值
  
  $rootYear = $_POST['birth_year'];
  
  setcookie("rootYear", $rootYear);
  
}


//Add By Root End

if($_GET['y']){
	if((int)$_GET['y']<10){
		$gety='0'.$_GET['y'];
	}else{
		$gety=$_GET['y'];
	}

	echo "<b><font color=\"red\">当前选中年费".$_COOKIE['rootYear']."           月份： ".$gety." 月</font></b>";

	//$tiaojian=" and addtime like '".date('Y-').$gety."%' ";
	//$tiaojian=" and addtime like '%".date('Y').'-'.$gety."%' ";
	//$tiaojian=" and addtime like '%".$_COOKIE['rootYear']."-".$gety."%' ";
	
	
	if((isset($_COOKIE['rootYear'])) && (!empty($_COOKIE['rootYear']))){
	
		$tiaojian=" and addtime like '%".$_COOKIE['rootYear']."-".$gety."%' ";
	}else{
	
		$tiaojian=" and addtime like '".date('Y-').$gety."%' ";
	
	}
	
	//$tiaojian = "and year(OrderDate)=2014 and month(OrderDate)=5";
	if(empty($uids)){
		// $sql="select * from wy_balance where funds !=0 and state='2' ".$tiaojian;
		$sql="select * from wy_balance where touid in(1) and type!='1' and state='2' and funds !=0 ".$tiaojian." order by id desc";
		$one=$dbo->getRs($sql);
		$sql="select * from wy_balance where uid in(1) and type='1' and state='2' and funds !=0 ".$tiaojian." order by id desc";
		$two=$dbo->getRs($sql);
		$zongjis=array_merge($one,$two);
		
	}else{
		//$sql="select * from wy_balance where touid in($uids) and type!='1' and funds !=0 order by id desc";
		$sql="select * from wy_balance where touid in($uids) and type!='1' and state='2' and funds !=0 ".$tiaojian." order by id desc";
		
		$one=$dbo->getRs($sql);
		$sql="select * from wy_balance where uid in($uids) and type='1' and state='2' and funds !=0 ".$tiaojian." order by id desc";
		$two=$dbo->getRs($sql);
		$zongjis=array_merge($one,$two);
	}
}else{	
	if(empty($uids)){		
		// $sql="select * from wy_balance where funds !=0 and state='2'";
		$sql="select * from wy_balance where touid in(1) and type!='1' and state='2' and funds !=0 ".$tiaojian." order by id desc";
		$one=$dbo->getRs($sql);
		$sql="select * from wy_balance where uid in(1) and type='1' and state='2' and funds !=0 ".$tiaojian." order by id desc";
		$two=$dbo->getRs($sql);
		$zongjis=array_merge($one,$two);
	}
	else{
		//$sql="select * from wy_balance where touid in($uids) and type!='1' and funds !=0 order by id desc";
		$sql="select * from wy_balance where touid in($uids) and type!='1' and state='2' and funds !=0  order by id desc";
		$one=$dbo->getRs($sql);

		$sql="select * from wy_balance where uid in($uids) and type='1' and state='2' and funds !=0  order by id desc";
		$two=$dbo->getRs($sql);
		
		$zongjis=array_merge($one,$two);
		//echo "<pre>";print_r($zongjis);exit;
	}
}


//计算总提成
//$zongjis=$dbo->getRs($sql);
foreach($zongjis as $rs){
	if($rs['type']=='1' || $rs['type']=='3'){//给自己充值金币	
		$cc=$rs['funds']*0.1;
	}else if($rs['type']=='2' ){//会员升级提成
		$cc=$rs['funds']*0.2;
	}else if($rs['type']=='4'){//站内信费用3or送礼物提成4
		$cc=$rs['funds']*0.2;
	}else if($rs['type']=='5' || $rs['type']=='6'){//5翻译6喇叭
		$cc=$rs['funds']*0.2;
	}else if($rs['type']=='7' ){
		$cc=$rs['funds']*0.2;
	}
	$zongji+=$cc;
}
//echo $sql;exit;
$dbo->setPages(15,$page_num);//设置分页



/*if($_GET){
	$p_name=$_GET['touname'];
	$user_group=$_GET['user_group'];
	if(!empty($p_name) && empty($user_group)){
		$sql="select * from wy_balance as b left join wy_users as u on b.touid=u.user_id where u.user_name='$p_name' and b.state='2' and b.funds !=0  order by id desc";
	}else if(empty($p_name) && !empty($user_group)){
		$sql="select * from wy_balance as b left join wy_users as u on b.touid=u.user_id where u.user_group='$user_group' and b.state='2' and b.funds !=0  order by id desc";
	}else if(!empty($p_name) && !empty($user_group)){
		$sql="select * from wy_balance as b left join wy_users as u on b.touid=u.user_id where u.user_name='$p_name' and u.user_group='$user_group' and b.state='2' and b.funds !=0  order by id desc";
	}
}*/




//echo $sql;exit;
//$mp_list_rs=$dbo->getRs($sql);
$mp_list_rs=$zongjis;
//print_r($mp_list_rs);exit;
$page_total=$dbo->totalPage;//分页总数

?>
<html>
<head>
<title>网站管理系统</title>
<link href="css/Guest.css" rel="stylesheet" type="text/css" />
<script src="js/system.js"></script>
<script src="js/jquery.min.js"></script>
<script type="text/javascript">
function del(){
	if(confirm("删除之后您会扣掉相应的提成，您确定要删除吗？")){
		return true;
	}else{
		return false;
	}
}
$(function (){
	$("input[name='allcheck']").click(function (){
		if($(this).attr('checked')){
			$(".tables").attr('checked',true);
		}else{
			$(".tables").attr('checked',false);
		}
	});
});
</script>
<style>
.pages_bar{margin-left: 20px;clear: both;float: left; height: auto;overflow: hidden;padding: 6px 0 7px;}
.pages_bar a {border: 1px solid #DDDDDD;color: #AAAAAA;display: block;float: left;font-family: Arial;font-size: 12px;height: 20px;line-height: 18px;margin: 0 2px;overflow: hidden;padding: 3px 8px 0;text-decoration: none;}
.pages_bar a:hover {background: none repeat scroll 0 0 #EEEEEE;color: #4E4E4E;text-decoration: none;}
.pages_bar .current_page{font-weight: bold;color: #333;}
</style>
</head>
<body>

<!-- Add By Root Begin -->
<form method="get" action="shoping.php" style="display: block;padding:15px;">

					<!-- <select name="birth_year">
						<option value="0">年</option>
						<script>for(var i=2014;i<2038;i++){document.write("<option value='"+i+"'>"+i+"</option>");}</script>
					</select> -->
					用户组：
					<select name="user_group">
						<option value="">==请选择==</option>
						<option value="1" <?php if($_GET['user_group'] == 1)echo "selected"; ?>>普通会员</option>
						<option value="2" <?php if($_GET['user_group'] == 2)echo "selected"; ?>>白金会员</option>
						<option value="3" <?php if($_GET['user_group'] == 3)echo "selected"; ?>>VIP会员</option>
					</select>
					会员昵称：
					<input type="text" name="touname" id="touname" value="<?php echo $_GET['touname']; ?>">

						<input value="提交" name="submit" type="submit">
</form>
					
<!-- Add By Root End -->
			
<form method="post" action="shoping_del.php">
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_01">
  <tr class="t_Title">
	<td colspan="6">变更记录 | 业绩：<?php echo $zongji;?></td>
  </tr>
  
  <tr class="t_Haader">
	<td>金额</td>
	  <td>时间</td>
    <td>详情</td>
   
  
   
	<!--<td>操作</td>
	 <td>全选<input type="checkbox" name="allcheck"/></td> -->
  </tr>
  <?php
  if(empty($uid)){?>
   <tr>
	
	<td colspan="7">暂无数据</td>

	</tr>
	<?php }else{?>
	  <?php foreach($mp_list_rs as $rs){?>
	  <tr>
		<td><?php 
		
		if($rs['type']==1 || $rs['type']=='3'){
			echo $rs['funds']*0.1;
			$ff=$rs['funds']*0.1;
		}else if($rs['type']==2){
			echo $rs['funds']*0.2;
			$ff=$rs['funds']*0.2;		
		}else if($rs['type']=='4'){
			echo $rs['funds']*0.2;
			$ff=$rs['funds']*0.2;
		}else if($rs['type']=='5' || $rs['type']=='6'){
			echo $rs['funds']*0.2;
			$ff=$rs['funds']*0.2;
		}else if($rs['type']=='7' ){
			echo $rs['funds']*0.2;
			$ff=$rs['funds']*0.2;
		}
		$xiaoji+=$ff;
		?></td>

		<td><?php echo $rs['addtime'];?></td>
		
		<td><?php echo $rs['touname'];?> <?php echo $rs['message']?></td>
		
		
		<!-- <td><a href="shoping_del.php?id=<?php echo $rs[id]; ?>" onclick="return del();">删除</a></td>
		<td><input type="checkbox" class="tables" name="shoping[]" value="<?php echo $rs[id]; ?>"/></td> -->
	  </tr>
	  <?php }?>
	
  <tr>
	<td colspan="7"><?php echo page_show($isNull,$page_num,$page_total);?></td>
	<!--<td><input type="submit" name="alldel"  onclick="return del();" value="批量删除"></td>-->
  </tr>
  <?php }?>
</table>

</body>
</html>