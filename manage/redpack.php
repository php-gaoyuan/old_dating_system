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
	$sql = "select * from chat_log where content like '%紅包%' order by id desc";
	//exit($sql);
	$list=$dbo->getRs($sql);
	$page_total=$dbo->totalPage;

	foreach ($list as $k => $val) {
		$list[$k]['from_name'] = $val['fromname'];
		$toinfo = $dbo->getRow("select user_name from wy_users where user_id='{$list[$k]['toid']}'");
		$list[$k]['to_name'] = $toinfo['user_name'];

		$arr = explode("：", $val['content']);
		$list[$k]['golds'] = $arr[1];
		if(empty($list[$k]['golds'])){
			$arr = explode(":", $val['content']);
			$list[$k]['golds'] = $arr[1];
		}

		$list[$k]['desc'] = "给".$list[$k]['to_name'].'发送红包'.$list[$k]['golds']."金币";
	}
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
		<div class="crumbs">当前位置 &gt;&gt; <a href="javascript:void(0);">红包列表</a> </div>
		<hr />
		<div class="infobox">
			<h3>红包列表</h3>
			<div class="content">
				<table class="list_table" id="mytable">
					<thead>
						<tr>
				            <th>编号</th>
				            <th>发送方</th>
				            <th>接收方</th>
				            <th>消费描述</th>
				            <th>发送金额</th>
				            <th>发送时间</th>		      
				  		</tr>
				  	</thead>
					<?php 
					foreach($list as $k=>$val){
						//if($val['golds']):
						?>
					<tr>
						<td>
							<?=$val['id'];?>
						</td>
						<td>
							<?=$val['from_name'];?>
						</td>
						<td>
							<?=$val['to_name'];?>
						</td>
						<td>
							<?=$val['desc'];?>
						</td>
						<td>
							<?=$val['golds'];?>
						</td>
						<td>
							<?=date("Y-m-d H:m",$val['timeline']);?>
						</td>
					</tr>
					<?php //endif;
				}?>
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