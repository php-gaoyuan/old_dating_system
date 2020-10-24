<?php
	require("session_check.php");
	require("../foundation/fpages_bar.php");
	require("../foundation/fsqlseletiem_set.php");
	require("../foundation/fback_search.php");
	
	//语言包引入 
	$m_langpackage=new modulelp;
	$ad_langpackage=new adminmenulp;
	$bp_langpackage=new back_publiclp;
	
	

	$dbo = new dbex;
	dbtarget('r',$dbServs);

	
	
	
	
if($_POST){
	if($_POST['fromid']!='' && $_POST['toid']!=''){
			$from=get_argp('fromid');
			$to=get_argp('toid');
			$res1=$dbo->getRow("select user_id from wy_users where user_name like '$from' order by user_id desc");
			$fromid=$res1['user_id'];
			$res2=$dbo->getRow("select user_id from wy_users where user_name like '$to' order by user_id desc");
			$toid=$res2['user_id'];
			
			if(!$res1 || !$res2){
				$fromid=$from;
				$toid=$to;
			}
		
		if($fromid && $toid){
			$condition.=" where player_ids=',$fromid,$toid,' and INSTR(txtlog_pageview,',$fromid,') and multi_chat='0' and txt_content!='' " ;
		}
		//当前页面参数
		$page_num=trim(get_argg('page'));

		//变量区
		$c_user_id=short_check(get_argg('user_id'));

		$c_perpage=get_argg('perpage') ? intval(get_argg('perpage')):10;
		
		$sql="select * from chat_txt " .$condition. " order by id desc  ";
		//echo $sql;exit;
		//$dbo->setPages($c_perpage,$page_num);//设置分页
		$mp_list=$dbo->getRs($sql);
		
		
		$ex=explode(',',$mp_list[0]['player_ids']);
		$r1=$dbo->getRow("select user_name from wy_users where user_id='$ex[1]' ");
		$r2=$dbo->getRow("select user_name from wy_users where user_id='$ex[2]' ");

		foreach($mp_list as $k=>$v){
			$mp_list[$k]['user_from']=$r1['user_name'];
			$mp_list[$k]['user_to']=$r2['user_name'];
		}
		//$page_total=$dbo->totalPage;//分页总数
	}else{
		echo "<script>alert('请输入完整');window.location.href='im_list.php'</script>";
	}
}
	
	//显示控制
	$isset_data="";
	$none_data="content_none";
	$isNull=0;
	if(empty($mp_list)){
		$isset_data="content_none";
		$none_data="";
		$isNull=1;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>员工提成</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" media="all" href="css/admin.css">
<script type='text/javascript' src='../servtools/area.js'></script>
<script type='text/javascript' src='../servtools/calendar.js'></script>
<script type='text/javascript' src='../servtools/ajax_client/ajax.js'></script>
<script type='text/javascript'>
	function setAct(URL){
	window.open(URL,'newwindow','height=500,width=520,top=200,left=280,toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no,status=no');
}

function lock_member_callback(user_id,type_value){
	if(type_value==1){
	str="<font color='red'><?php echo $m_langpackage->m_lock;?></font>";document.getElementById("unlock_button_"+user_id).style.display="";document.getElementById("lock_button_"+user_id).style.display="none";;
	}else{
	str="<?php echo $m_langpackage->m_normal;?>";document.getElementById("unlock_button_"+user_id).style.display="none";document.getElementById("lock_button_"+user_id).style.display="";
	}
	document.getElementById("state_"+user_id).innerHTML=str;	
}

function lock_member(user_id,type_value)
{
	var lock_member=new Ajax();
	lock_member.getInfo("employess_lock.action.php","GET","app","user_id="+user_id+"&type_value="+type_value,function(c){lock_member_callback(user_id,type_value);}); 
}

function get_pass(user_id,type_value)
{
	var lock_member=new Ajax();
	lock_member.getInfo("employees_list.php","GET","app","user_id="+user_id+"&type_value="+type_value,function(c){alert(c);}); 
}

function recommend(uid,uname,uico,upass,gnum,usex){
	var lock_member=new Ajax();
	lock_member.getInfo("recommend_add.action.php?uid="+uid+"&uico="+uico+"&upass="+upass+"&gnum="+gnum+"&usex="+usex,"post","app","uname="+uname,function(c){document.getElementById("not_recom_"+uid).style.display="";document.getElementById("not_recom_"+uid).innerHTML=c;}); 
}

function check_form()
{
	var min_reg_time=document.getElementById("user_add_time1").value;
	var max_reg_time=document.getElementById("user_add_time2").value;
	var min_last_login=document.getElementById("lastlogin_datetime1").value;
	var max_last_login=document.getElementById("lastlogin_datetime2").value;
	var time_format=/\d{4}\-\d{2}\-\d{2}/;

	if(min_reg_time){
		if(!time_format.test(min_reg_time)){
			alert("<?php echo $m_langpackage->m_date_wrong;?>");
			return false;
			}
	}

	if(max_reg_time){
		if(!time_format.test(max_reg_time)){
			alert("<?php echo $m_langpackage->m_date_wrong;?>");
			return false;
			}
		}

	if(min_last_login){
		if(!time_format.test(min_last_login)){
			alert("<?php echo $m_langpackage->m_date_wrong;?>");
			return false;
			}
	}

	if(max_last_login){
		if(!time_format.test(max_last_login)){
			alert("<?php echo $m_langpackage->m_date_wrong;?>");
			return false;
			}
	}
}

	</script>
</head>
<script language="JavaScript" type="text/JavaScript"> 
function checkAll(form,name) {
	for(var i = 0; i < form.elements.length; i++) {
		var e = form.elements[i];
		if(e.name.match(name)) {
			e.checked = form.elements['chkall'].checked;
		}
	}
}
</script>
<body>
<div id="maincontent">
	
    <div class="wrap">
        <div class="crumbs"><?php echo $ad_langpackage->ad_location;?> &gt;&gt; <a href="javascript:void(0);">员工管理</a> &gt;&gt; <a href="javascript:void(0);">UUchat聊天记录</a></div>
        <hr />
        <div class="infobox" style="text-align:left;margin-top:5px">
		<h3><?php echo $m_langpackage->m_check_condition;?></h3>
			<form method="post" action="" style="padding:10px 0">
				会员FROM：<input class="small-text" type="text" name="fromid" value="<?php echo $from;?>" /> 
				会员TO：<input class="small-text" type="text" name="toid" value="<?php echo $to;?>" /> 
				
				<input type="submit" value="检索" class="regular-button" style="margin-top:-3px"> 
				<input type="reset" value="重置" class="regular-button" onclick="window.location.href='im_list.php'" style="margin-top:-3px"> 
			</form>
		</div>
		
		
<div class="infobox">
    <h3>聊天记录</h3>
    <?php if($_POST){?>
	<div class="content">
<table class="list_table">
	<thead><tr>
	<th style="text-align:center">SESSION_ID</th>
    <th style="text-align:center">PLAYER_IDS</th>
    <th>会员FROM：</th>
    <th>会员TO：</th>
    
    <th style="text-align:center">聊天记录</th>

    </tr></thead>
		<?php 
		foreach($mp_list as $rs){?>
	<tr>
		<td>
		<?php echo $rs['session_id'];?>
		</td>
		<td>
		<?php echo $rs['player_ids'];?>
		</td>
		<td>
		<?php echo $rs['user_from'];?>
		</td>
		<td>
		<?php echo $rs['user_to'];?>
		</td>
		<td>
			<a href="im_jilu.php?id=<?php echo $rs['id'];?>">查看</a>
		</td>
		

		
	</tr>
		<?php
			}
		?>
        
	</table>
<?php //page_show($isNull,$page_num,$page_total);?>
<div class='guide_info <?php echo $none_data;?>'><?php echo $m_langpackage->m_none_data;?></div>
</div>
<?php }?>
</div>
</div>
</div>
</form>
</body>
</html>