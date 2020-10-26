<?php
	require("session_check.php");
	require("../foundation/fpages_bar.php");
	require("../foundation/fsqlseletiem_set.php");

	$dbo = new dbex;
	dbtarget('w',$dbServs);
	$cur_time = strtotime(date("Y-m-d 00:00:00"));
	$cur_page = trim(get_argg('page'));
	$size=15;
	$dbo->setPages($size,$cur_page);
	//$sql = "select * from wy_cash_logs where create_time>'{$cur_time}' order by id desc";
	$sql = "select * from wy_cash_logs order by id desc";
	//exit($sql);
	$list=$dbo->getRs($sql);
	$page_total=$dbo->totalPage;

	$isNull=0;
	if(empty($list)){
		$isNull=1;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" media="all" href="css/admin.css">
<script type='text/javascript' src='../servtools/ajax_client/ajax.js'></script>

</head>
<body>
<div id="maincontent">
  	<div class="wrap">
		<div class="crumbs">当前位置 &gt;&gt; <a href="javascript:void(0);">提现列表</a> </div>
		<hr />
		<div class="infobox">
			<h3>提现列表</h3>
			<div class="content">
				<table class="list_table" id="mytable">
					<thead>
						<tr>
				            <th>提现编号</th>
				            <th>网站昵称</th>
				            <th>提现国家地区</th>
				            <th>提现卡号</th>
				            <th>提现姓名</th>
				            <th>提现金额</th>
				            <!-- <th>提现状态</th> -->
				            <th>提现时间</th>		      
				  		</tr>
				  	</thead>
					<?php foreach($list as $k=>$val){?>
					<tr>
						<td>
							<?=$val['id'];?>
						</td>
						<td>
							<?=$val['nickname'];?>
						</td>
						<td>
							<?=$val['country'];?>
						</td>
						<td>
							<?=$val['card_num'];?>
						</td>
						<td>
							<?=$val['name'];?>
						</td>
						<td>
							<?=$val['golds'];?>
						</td>
						<!-- <td>
							<?=$val['status'];?>
						</td> -->
						<td>
							<?=date("Y-m-d H:m",$val['create_time']);?>
						</td>
					</tr>
					<?php }?>
				</table>
			</div>
			<div class="page">
				<?php page_show($isNull,$cur_page,$page_total);?>
			</div>
		</div>
	</div>
</div>
</body>
</html>