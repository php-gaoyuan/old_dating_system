<?php
	require("session_check.php");	
	require("../foundation/fpages_bar.php");
	require("../foundation/fsqlseletiem_set.php");
	$is_check=check_rights("c04");
	if(!$is_check){
		echo 'no permission';
		exit;
	}
	//语言包引入
	$m_langpackage=new modulelp;
	$ad_langpackage=new adminmenulp;
	require("../foundation/fback_search.php");
	
	//表定义区
	$t_table=$tablePreStr."servicers";

	$dbo = new dbex;
	dbtarget('w',$dbServs);

	//当前页面参数
	$page_num=trim(get_argg('page'));

	//变量区
	$c_orderby=short_check(get_argg('order_by'));
	$c_ordersc=short_check(get_argg('order_sc'));
	$c_perpage=get_argg('perpage')? intval(get_argg('perpage')) : 20;

	$eq_array=array('is_pass','user_sex','user_id','rec_class');
	$like_array=array('user_name');
	$date_array=array("add_time");
	$num_array=array('guest_num');
	$sql=spell_sql($t_table,$eq_array,$like_array,$date_array,$num_array,$c_orderby,$c_ordersc);

	//取得数据
	$dbo->setPages($c_perpage,$page_num);
	$recommend_rs=$dbo->getRs($sql);
	$page_total=$dbo->totalPage;

	//用户状态
	$s_no_limit='';$s_lock='';$s_normal='';
	if(get_argg('u_state')==''){$s_no_limit="selected";}
	if(get_argg('u_state')=='0'){$s_lock="selected";}
	if(get_argg('u_state')=='1'){$s_normal="selected";}

	//用户性别
	$sex_no_limit='';$sex_women='';$sex_man='';
	if(get_argg('u_sex')==''){$sex_no_limit="selected";}
	if(get_argg('u_sex')=='0'){$sex_women="selected";}
	if(get_argg('u_sex')=='1'){$sex_man="selected";}

	//按字段排序
	$o_def='';$o_guest_num='';
	if(get_argg('order_by')==''||get_argg('order_by')=="rec_class"){$o_def="selected";}
	if(get_argg('order_by')=="guest_num"){$o_guest_num="selected";}

	//显示控制
	$isset_data="";
	$none_data="content_none";
	$isNull=0;
	if(empty($recommend_rs)){
		$isNull=1;
		$isset_data="content_none";
		$none_data="";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" media="all" href="css/admin.css">
<script type='text/javascript' src='../servtools/ajax_client/ajax.js'></script>
<script type='text/javascript'>

</script>
</head>
<body>
<div id="maincontent">
    <div class="wrap">
        <div class="crumbs"><?php echo $ad_langpackage->ad_location;?> &gt;&gt; <?php echo $ad_langpackage->ad_user_management;?> &gt;&gt; 客服管理</div>
        <hr />
        

<div class="infobox">
    <h3>客服列表</h3>
    <div class="content">

<table class='list_table <?php echo $isset_data;?>'>
	<thead><tr>
    
	<th>用户ID</th>
	  <th>用户名</th>
	  <th>收到礼物</th>
	  <th>满意度</th>
	  <th>评价数</th>
	  <th width='30%'>操作</th>
    
  </tr></thead>
	<?php
	foreach($recommend_rs as $rs){
	?>
	<tr>
		<td><?php echo $rs['user_id'];?></td>
		<td><?php echo $rs['user_name'];?></td>
		<td><?php echo $rs['gift_num'];?></td>
		<td><?php echo $rs['manyidu'];?></td>
		<td><?php echo $rs['pingjiashu'];?></td>
		<td><a href="servicer_info.php?uid=<?php echo $rs['user_id'];?>">编辑</a></td>
		
	</tr>
	<?php
		}
	?>
	
	</table>
<?php page_show($isNull,$page_num,$page_total);?>

<div class='guide_info <?php echo $none_data;?>'><?php echo $m_langpackage->m_none_data;?></div>
</div>
</div>
</div>
</body>
</html>