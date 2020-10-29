<?php
	require("session_check.php");	
	require("../foundation/fsqlseletiem_set.php");

	$dbo = new dbex;
	dbtarget('w',$dbServs);
	
	$sql="select * from wy_hd order by id desc";
	$list=$dbo->getRs($sql);
	foreach($list as $k=>$v){
		$res=$dbo->getRow("select cat_name,name from wy_hd_cat where cat_id=$v[cat_id]");
		$list[$k]['cat']=$res['cat_name'];
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
function del_hd(id){
	var del_ajax=new Ajax();
	del_ajax.getInfo("del_hd.action.php","GET","app","id="+id,function(c){
		alert(c);window.location.reload();
	}); 
}
</script>
</head>
<body>
<div id="maincontent">
    <div class="wrap">
        <div class="crumbs">当前位置 &gt;&gt; 幻灯管理 &gt;&gt; 幻灯列表</div>
        <hr />
        

<div class="infobox">
    <h3>幻灯列表</h3>
    <div class="content">

<table class='list_table <?php echo $isset_data;?>'>
	<thead><tr>
    
		<th>ID</th>
		<th>标题</th>
		<th>所属栏目</th>
		<th style="width:200px">图片</th>
		<th>排序</th>
		<th  style="width:300px">链接</th>
		<th width='30%'>操作</th>
    
  </tr></thead>
	<?php
	foreach($list as $v){
	?>
	<tr>
		<td><?php echo $v['id'];?></td>
		<td><?php echo $v['title'];?></td>
		<td><?php echo $v['cat'];?></td>
		<td><img src="../<?php echo $v['ad_pic'];?>" style="max-width:180px;max-height:100px;" /></td>
		<td><?php echo $v['ord'];?></td>
		<td><?php echo $v['ad_link'];?></td>
		<td><a href="huandeng_add.php?id=<?php echo $v['id'];?>">编辑</a> | <a href="javascript:del_hd(<?php echo $v['id'];?>);">删除</a></td>
		
		
	</tr>
	<?php
		}
	?>
	
	</table>


</div>
</div>
</div>
</body>
</html>