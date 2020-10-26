<?php
require("session_check.php");	
require("../api/base_support.php");

	//语言包引入
	$f_langpackage=new foundationlp;
	$ad_langpackage=new adminmenulp;
    //表定义区

    $t_article=$tablePreStr."country";
	$t_province=$tablePreStr."province";
	$t_city=$tablePreStr."city";
    //数据库操作初始化
    $dbo = new dbex;
    dbtarget('w',$dbServs);

   
    
	$sql="select $t_article.cname,$t_province.pname,$t_city.id,$t_city.name from $t_city left join $t_province on $t_city.pid=$t_province.id left join $t_article  on $t_article.id=$t_province.cid";

	
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
				<th>国家</th>
	            <th>省份</th>
				<th>城市</th>
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
						<td>
							<div ><?php echo $rs['pname'];?></div>
							
						</td>
						<td>
							<div ><?php echo $rs['name'];?></div>
							
						</td>
						<td  style="text-align:center">
							<div >
								<a href="user_city_edit.php?id=<?php echo $rs['id'];?>"><?php echo $f_langpackage->f_amend?></a> |
								<a href="user_city_del.php?id=<?php echo $rs['id'];?>"><?php echo $f_langpackage->f_del?></a>
							</div>

						</td>
					</tr>
				<?php }?>
					<tr height="40px">
			
						<td colspan="5" style=" text-align:right"><div id="add_button"><a href="user_city_add.php"><input type="button" class="regular-button" value="添加城市" /></a></div>
								
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
</body>
</html>