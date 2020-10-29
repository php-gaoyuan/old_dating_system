<?php
require("includet.php");
require("../foundation/fpages_bar.php");








$params = array();
if (isset($_GET['year']) && isset($_GET['month'])) {
    $params = array(
        'year' => $_GET['year'],
        'month' => $_GET['month'],
    );
}
$params['url']  = 'shoping.php';
require_once 'calendar.class.php';















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
if($_GET['y']){
	if((int)$_GET['y']<10){
		$gety='0'.$_GET['y'];
	}else{
		$gety=$_GET['y'];
	}
	$tiaojian=" and addtime like '".date('Y-').$gety."%' ";
	if(empty($uids)){
		// $sql="select * from wy_balance where funds !=0 and state='2' ".$tiaojian;
		$sql="select * from wy_balance where touid in(1) and state='2' and funds !=0 ".$tiaojian." order by id desc";
	}else{
		//$sql="select * from wy_balance where touid in($uids) and type!='1' and funds !=0 order by id desc";
		$sql="select * from wy_balance where touid in($uids) and state='2' and funds !=0 ".$tiaojian." order by id desc";
	}
}else{	
	if(empty($uids)){		
		// $sql="select * from wy_balance where funds !=0 and state='2'";
		$sql="select * from wy_balance where touid in(1) and state='2' and funds !=0 ".$tiaojian." order by id desc";
	}
	else{
		//$sql="select * from wy_balance where touid in($uids) and type!='1' and funds !=0 order by id desc";
		$sql="select * from wy_balance where touid in($uids) and state='2' and funds !=0  order by id desc";
	}
}


//计算总提成
$zongjis=$dbo->getRs($sql);
foreach($zongjis as $rs){
	if($rs['type']=='1'){	
		$cc=$rs['funds']*0.1;
	}else if($rs['type']=='2' ){
		$cc=$rs['funds']*0.1;
	}else if($rs['type']=='3' || $rs['type']=='4'){
		$cc=$rs['funds']*0.15;
	}else if($rs['type']=='5' || $rs['type']=='6'){
		$cc=$rs['funds']*0.1;
	}else if($rs['type']=='7' ){
		$cc=$rs['funds']*0.05;
	}
	$zongji+=$cc;
}
//echo $sql;exit;
$dbo->setPages(15,$page_num);//设置分页
$mp_list_rs=$dbo->getRs($sql);
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














<style type="text/css">
            table.calendar {
                border: 1px solid #050;
            }
            .calendar th, .calendar td {
                width:30px;
                text-align:center;
            }            
            .calendar th {
                background-color:#050;
                color:#fff;
            }
            .today{
		color:#fff;
		background-color:#050;                
            }
        </style>
		
		
		
		
		
		
		
		
		
		
		
		
		
</head>
<body>
<form method="post" action="shoping_del.php">




<?php
                $cal = new Calendar($params);
                $cal->display();
            ?> 
	
	
	
	
	
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_01">
  <tr class="t_Title">
	<td colspan="6">消费记录 | 业绩：<?php echo $zongji;?></td>
  </tr>
  <tr class="">
	<td colspan="6">检索：
		<?php for($i=1;$i<=12;$i++){
			echo "<a style='background:#ddd;padding:0 5px' href='shoping.php?y=".$i."'>".date('Y-').$i."</a>|";
		}?>
		
		 
	</td>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
  </tr>
  <tr class="t_Haader">
	<td>订单号</td>
	<td>会员ID</td>
    <td>会员昵称</td>
    <td>消费类型</td>
    <td>提成金额</td>
    <td>消费时间</td>
	<!--<td>操作</td>
	<td>全选<input type="checkbox" name="allcheck"/></td>-->
  </tr>
  <?php
  if(empty($uid)){?>
   <tr>
	
	<td colspan="7">暂无数据</td>

	</tr>
	<?php }else{?>
	  <?php foreach($mp_list_rs as $rs){?>
	  <tr>
		<td><?php echo $rs['ordernumber'];?></td>
		<td><?php echo $rs['touid'];?></td>
		<td><?php echo $rs['touname'];?></td>
		<td><?php echo $rs['message']?></td>
		<td><?php 
		
		if($rs['type']==1){
			echo $rs['funds']*0.1;
			$ff=$rs['funds']*0.1;
		}else if($rs['type']==2){
			echo $rs['funds']*0.1;
			$ff=$rs['funds']*0.1;		
		}else if($rs['type']=='3' || $rs['type']=='4'){
			echo $rs['funds']*0.15;
			$ff=$rs['funds']*0.15;
		}else if($rs['type']=='5' || $rs['type']=='6'){
			echo $rs['funds']*0.1;
			$ff=$rs['funds']*0.1;
		}else if($rs['type']=='7' ){
			echo $rs['funds']*0.05;
			$ff=$rs['funds']*0.05;
		}
		$xiaoji+=$ff;
		?></td>
		<td><?php echo $rs['addtime'];?></td>
		<!--<td><a href="shoping_del.php?id=<?php echo $rs[id]; ?>" onclick="return del();">删除</a></td>-->
		<!--<td><input type="checkbox" class="tables" name="shoping[]" value="<?php echo $rs[id]; ?>"/></td>-->
	  </tr>
	  <?php }?>
	  <tr>
		<td></td>
		<td></td>
		<td></td>
		<td align='right'>本页小计：</td>
		<td><?php echo $xiaoji;?></td>
		<td></td>
		<td></td>
		<td></td>
	  </tr>
  <tr>
	<td colspan="7"><?php echo page_show($isNull,$page_num,$page_total);?></td>
	<!--<td><input type="submit" name="alldel"  onclick="return del();" value="批量删除"></td>-->
  </tr>
  <?php }?>
</table>

</body>
</html>