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
	$condition=" type in ('1','2') ";


	//取出数据列表
	$sql="select * from wy_balance where ".$condition ."  order by id desc";
	//exit($sql);
	//取得数据
	$info_rs=$dbo->getRs($sql,'arr');
	//halt($info_rs);
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
	<script src="static/plus/layui/layui.js"></script>
	<link rel="stylesheet" href="static/plus/layui/css/layui.css">
</head>
<body style="background: white;padding:20px;">
	<table class="layui-table">
		<thead>
			<tr>
				<th>充值编号</th>
				<th>会员账号</th>
				<th>充值金额</th>
				<th>充值备注</th>
				<th>到账状态</th>
				<th>支付方式</th>
				<th>支付终端</th>
				<th>通道支付结果</th>
				<th>充值时间</th>
				<th>时间差</th>
			</tr>
		</thead>
        <tbody>
		<?php if(!empty($info_rs)){foreach($info_rs as $k=>$vo): ?>
		<tr>
			<td><?php echo $vo['id']; ?></td>
			<td><?php echo $vo['uname']; ?></td>
			<td><?php echo $vo['funds']; ?></td>
			<td><?php echo $vo['message']; ?></td>
			<td><?php if($vo['state']==0){echo "未支付";}elseif($vo["state"] == 2){echo "<font style='color:#00d000'>已支付</font>";}else{echo "<font style='color:red;'>失败</font>";} ?></td>
            <td>
				<?php 
				if($vo['pay_method']=='lianyin'){
				    echo "A支付";
				}elseif($vo["pay_method"] == 'yingfu'){
				    echo "<font style='color:red'>B支付</font>";
				}elseif($vo["pay_method"] == 'gold'){
				    echo "<font style='color:#129ec9;'>金币支付</font>";
				} 
				?>
            </td>
            <td><?php echo $vo['pay_from'];?></td>
            <td><?php echo $vo['pay_msg'];?></td>
			<td><?php echo $vo['addtime']; ?></td>
			<td><?php echo getAgoTime($vo["addtime"]); ?>m以前</td>
		</tr>
		<?php endforeach; }else{?>
			<tr>
				<td colspan="7" style="text-align: center;">没有查询到与条件相匹配的数据</td>
			</tr>
		<?php } ?>
        </tbody>
	</table>
	<?php page_show($isNull,$page_num,$page_total);?>
                    
</body>
</html>