<?php
require("session_check.php");	
require("../api/base_support.php");

	//语言包引入
	$f_langpackage=new foundationlp;
	$ad_langpackage=new adminmenulp;
    //表定义区

    $t_article=$tablePreStr."country";
    //数据库操作初始化
    $dbo = new dbex;
    dbtarget('w',$dbServs);

   
    
	$sql="select * from $t_article";

	
	$article_rs=$dbo->getRs($sql);
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
		<div class="crumbs"><?php echo $ad_langpackage->ad_location;?> &gt;&gt; <a href="javascript:void(0);">国家列表</a></div>
		<hr />
		<div class="infobox">
			<h3><?php echo $str;?></h3>
			<div class="content">
				<table class="list_table" id="mytable">
					<thead><tr>
	            <th width="100"><?php echo $f_langpackage->f_arrange_num;?></th>
	            <th><?php echo $f_langpackage->f_name;?></th>
	            <th style="text-align:center"><?php echo $f_langpackage->f_handle;?></th>		      
				  </tr></thead>
				<?php foreach($article_rs as $rs){?>
					<tr>
						<td>
							<div ><?php echo $rs['id'];?></div>
				
						</td>
						<td>
							<div ><?php echo $rs['cname'];?></div>
							
						</td>
						<td  style="text-align:center">
							<div >
								<a href="user_country_edit.php?id=<?php echo $rs['id'];?>"><?php echo $f_langpackage->f_amend?></a> |
								<a href="user_country_del.php?id=<?php echo $rs['id'];?>"><?php echo $f_langpackage->f_del?></a>
							</div>

						</td>
					</tr>
				<?php }?>
					<tr height="40px">
						<td>
							<div id="order_num" style="display:none">
								<input type='text' class="small-text" id='add_order_num' name='add_order_num' maxlength='15' value='' />
							</div>
						</td>
						<td>
							<div id="sort_input" style="display:none">
								<input type='text' class="small-text" id='add_value' name='add_value' maxlength='15' value='' />
							</div>
						</td>
						<td  style=" text-align:center"><div id="add_button"><a href="user_country_add.php"><input type="button" class="regular-button" value="添加国家" /></a></div>
								
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
</body>
</html>