<?php
	require("session_check.php");
	require("../foundation/fpages_bar.php");

	//语言包引入
	$f_langpackage=new foundationlp;
	$ad_langpackage=new adminmenulp;
	$m_langpackage=new modulelp;
	$bp_langpackage=new back_publiclp;
	
    //表定义区

    $t_msg_inbox=$tablePreStr."msg_inbox";
	$t_users=$tablePreStr."users";
    //数据库操作初始化
    $dbo = new dbex;
    dbtarget('w',$dbServs);
	
   //当前页面参数
	$page_num=trim(get_argg('page'));
	$from_user=trim(get_argg('from_user'));
	$user_name=trim(get_argg('user_name'));
   //echo $page_num;
   $c_perpage=get_argg('perpage')? intval(get_argg('perpage')) : 10;
   // echo $c_perpage;
	$sql="select * from $t_msg_inbox left join $t_users on $t_msg_inbox.user_id=$t_users.user_id where $t_msg_inbox.from_user!='系统发送' ";
	if(!empty($from_user)){
		$sql.=" and from_user like '%{$from_user}%' ";
	}
	if(!empty($user_name)){
		$sql.=" and user_name like '%{$user_name}%' ";
	}
	$sql.=" order by add_time desc";
	$dbo->setPages($c_perpage,$page_num);

	$inbox_rs=$dbo->getRs($sql);
	//$page_total=$dbo->totalPage;
	//分页总数
	//print_r($inbox_rs);exit;
	$page_total=$dbo->totalPage;
	//print_r($page_total);
	//print_r($dbo);
	//page_show_parameter($mod,$page_num,$page_total,'page');exit;
	//page_show($isNull,$page_num,$page_total);exit;
	//显示控制
	$isNull=0;
	$isset_data="";
	$none_data="content_none";
	if(empty($inbox_rs)){
		$isset_data="content_none";
		$none_data="";
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
		<div class="crumbs"><?php echo $ad_langpackage->ad_location;?> &gt;&gt; <a href="javascript:void(0);">邮件列表</a></div>
		<hr />
				<div class="infobox">
					<h3><?php echo $m_langpackage->m_check_condition;?></h3>
					<div class="content">
		<form action="" method="GET" name='form' onsubmit='return check_form();'>
		<TABLE class="form-table">
		  <TBODY>
		  <TR>
			<th width="90">发件人</th>
			<TD><input type="text" class="small-text" name='from_user' value="<?php echo get_argg('from_user');?>"></TD>
			<th>收件人</th>
			<TD><INPUT type='text' class="small-text" name='user_name' value='<?php echo get_argg('user_name');?>'></TD>
		  </TR>
			<tr><td colspan=2><INPUT class="regular-button" type="submit" value="<?php echo $m_langpackage->m_search;?>" /></td></tr>
		  </TBODY>
		  </TABLE>
		</form>
			</div>
		</div>
		<div class="infobox">
			<h3><?php echo $str;?></h3>
			<div class="content">
				<table class="list_table" id="mytable">
					<thead><tr>
	            <th width="130"><?php echo $f_langpackage->f_arrange_num;?></th>
				<th style="text-align:center">发件人</th>
	            <th style="text-align:center">收件人</th>
				<th style="text-align:center">邮件主题</th>
				<th style="text-align:center">邮件内容</th>
				<th style="text-align:center">发件时间</th>
	            	      
				  </tr></thead>
				<?php foreach($inbox_rs as $rs){?>
					<tr>
						<td>
							
							<div ><input type="checkbox" class="e_check" name="id[]" value="<?php echo $rs['mess_id'];?>"><?php echo $rs['mess_id'];?></div>
				
						</td>
						<td style="text-align:center">
							<div ><?php echo $rs['from_user'];?></div>
							
						</td>
						<td style="text-align:center">
							<div ><?php echo $rs['user_name'];?></div>
							
						</td>
						<td style="text-align:center">
							<div ><a href="translate_edit.php?mess_id=<?php echo $rs['mess_id'];?>"><?php echo $rs['mess_title'];?></a></div>
							
						</td>
						<td style="text-align:left">
							<div class="mes_con"><a href="translate_edit.php?mess_id=<?php echo $rs['mess_id'];?>"><?php echo $rs['mess_content'];?></a></div>
							
						</td>
						<td style="text-align:center">
							<div ><?php echo $rs['add_time'];?></div>
							
						</td>
						
					</tr>
				<?php }?>
	
				</table>
				<?php page_show($isNull,$page_num,$page_total);?>
	<div class='guide_info <?php echo $none_data;?>'><?php echo $m_langpackage->m_none_data;?></div>
			</div>
		</div>
	</div>
</div>
</body>
</html>