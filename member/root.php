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



//Add By Root Time:20141021 Begin 



//$sql_by_root="select user_email,user_add_time,lastlogin_datetime from wy_users where user_name=uname";
//$mp_list_rs_by_root =$dbo->getRs($sql_by_root);

//var_dump($mp_list_rs_by_root);

//Add By Root Time:20141021 End












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
<!--
<form method="post" action="shoping.php">

					<select name="birth_year">
						<option value="0">年</option>
						<script>for(var i=2014;i<2038;i++){document.write("<option value='"+i+"'>"+i+"</option>");}</script>
					</select>

						<input value="提交" name="submit" type="submit">
					</form> -->
					
<!-- Add By Root End -->
			
<form method="post" action="shoping_del.php">
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_01">
  <tr class="t_Title">
	<!-- <td colspan="6">消费记录 | 业绩：<?php echo $zongji;?></td>-->
  </tr>
  <tr class="">
  <!--
	<td colspan="6">检索：
		<?php for($i=1;$i<=12;$i++){
			if((isset($_COOKIE['rootYear'])) && (!empty($_COOKIE['rootYear'])))
			{
				echo "<a style='background:#ddd;padding:0 5px' href='shoping.php?y=".$i."'>".$_COOKIE['rootYear']."年 - <b><font color=\"red\">".$i."</font></b>月"."</a>|";
			}else{
			echo "<a style='background:#ddd;padding:0 5px' href='shoping.php?y=".$i."'>".date('Y')."年 - <b><font color=\"red\">".$i."</font></b>月"."</a>|";
			}
		}?>
		
					
					
	</td> -->
  </tr>
  <tr class="t_Haader">
	<td>账号</td>
	<td>昵称</td>
    <td>注册时间</td>
    <td>登陆时间</td>
    <td>消费类型</td>
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
	
	
	
	
	
	
	<!--<?php //foreach($mp_list_rs_by_root as $rs_by_root){?>
	<tr>
	<td><?php// echo $rs_by_root['user_email'];?></td>
		<td><?php //echo $rs_by_root['user_name'];?></td>
		
		<td><?php //echo $rs_by_root['user_add_time'];?></td>
    <td><?php// echo $rs_by_root['lastlogin_datetime'];?></td>
	
	 </tr>
	 <?php// }?>-->
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
<?php 



//Add By Root Time:20141021 Begin 


//$link = mysqli_connect("localhost", "root","root","lovelove");

//if($link){
	
//	echo "数据同步成功";

//}
 

//Add By Root Time:20141021 End 


?>
	 
	 
	 
	 
	 
	 
	 
	  <?php foreach($mp_list_rs as $rs){?>
	  
	<tr>
		
		

		<td><?php echo $rs['uname'];?></td><!-- wy_balance -->	<!-- 先获取昵称，然后通过wy_balance里面的uname查找wy_users里面的会员信息-->
		
		
		
		<?php 
		
		//Add By Root Time:20141021 Begin 



		//$sql_by_root="select user_email,user_add_time,lastlogin_datetime from wy_users where user_name=".$rs['uname']."";
		
		

		//var_dump($mysqli);
		

		$link = mysql_connect("127.0.0.1", "root","mima123456");
				if(!mysql_select_db("partyings",$link)){
		
			echo "连接失败";
		
		}

		$rootName = $rs['u_id'];
		echo $rootName;
		$sql_by_root="select user_name,user_email,user_add_time,lastlogin_datetime from wy_users where user_name='".$rs['uname']."'";
		 
		//echo $sql_by_root;

		$result = mysql_query($sql_by_root);
		
		$result = mysql_fetch_array($result);
		
		//var_dump($result);
		
		


		//Add By Root Time:20141021 End

			
		?>
		
		
		
		
		
		
		
		<td><?php echo $result['user_email'];?></td><!-- wy_users -->
		
		<td><?php echo $result['user_add_time'];?></td><!-- wy_users -->
    <td><?php echo $result['lastlogin_datetime'];?></td><!-- wy_users -->
	
	
	
	
		<td><?php echo $rs['message']?></td><!-- wy_balance -->
		
		<td><?php echo $rs['addtime'];?></td><!-- wy_balance -->

	  </tr>
	  <?php }?>
	  

	  
	  
	  
	  
	  
	  
	  
	  
	 <!-- 
	  <tr>
		<td></td>
		<td></td>
		<td></td>
		<!-- <td align='right'>本页小计：</td>-->
		<!-- <td><?php echo $xiaoji;?></td>
		<td></td>
		<td></td>
		<td></td>
	  </tr> -->
  <tr>
	<td colspan="7"><?php echo page_show($isNull,$page_num,$page_total);?></td>
	<!--<td><input type="submit" name="alldel"  onclick="return del();" value="批量删除"></td>-->
  </tr>
  <?php }?>
</table>

</body>
</html>