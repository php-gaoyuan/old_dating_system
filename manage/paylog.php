<?php 
	require("session_check.php");
	require("../foundation/fpages_bar.php");
	require("../api/base_support.php");
	$dbo = new dbex;
    dbtarget('r',$dbServs);

    //当前页面参数
	$page_num=trim(get_argg('page'));
	//变量区
	$dbo->setPages(15,$page_num);//设置分页
	//搜索条件设置
	$condition=" where type='1' ";


	//取出数据列表
	$sql="select * from wy_balance ".$condition ."  order by id desc";
	//exit($sql);
	//取得数据
	$info_rs=$dbo->getRs($sql);
	$page_total=$dbo->totalPage; //分页总数
	//显示控制
	$isNull=0;
	$isset_data="";
	$none_data="content_none";
	if(empty($info_rs)){
		$isset_data="content_none";
		$none_data="";
		$isNull=1;
	}


	function getAgoTime($date){
		$time1 = strtotime($date);
		$time2=time();
		$time_cha = $time2-$time1;
		$minus = $time_cha/60;
		
		return ceil($minus);
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>充值记录</title>
	<link rel="stylesheet" type="text/css" media="all" href="css/admin.css">
	<script src="js/layui/layui.js"></script>
	<link rel="stylesheet" href="js/layui/css/layui.css">
</head>
<body>
	<table class="layui-table">
		<thead>
			<tr>
				<th>充值编号</th>
				<th>会员账号</th>
				<th>充值金额</th>
				<th>充值备注</th>
				<th>到账状态</th>
				<th>充值时间</th>
				<th>时间差</th>
			</tr>
		</thead>
		<?php if(!empty($info_rs)){foreach($info_rs as $k=>$vo): ?>

		<?php  ?>
		<tr>
			<td><?php echo $vo['id']; ?></td>
			<td><?php echo $vo['uname']; ?></td>
			<td><?php echo $vo['funds']; ?></td>
			<td><?php echo $vo['message']; ?></td>
			<td><?php if($vo['state']==0){echo "未到账";}elseif($vo["state"] == 2){echo "<font style='color:red'>已到账</font>";} ?></td>
			<td><?php echo $vo['addtime']; ?></td>
			<td><?php echo getAgoTime($vo["addtime"]); ?>分钟以前充值</td>
		</tr>
		<?php endforeach; }else{?>
			<tr>
				<td cols="6">没有查询到与条件相匹配的数据</td>
			</tr>
		<?php } ?>
	</table>
	<?php page_show($isNull,$page_num,$page_total);?>
                    
</body>
</html>