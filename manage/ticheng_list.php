<?php
	require("session_check.php");
	require("../foundation/fpages_bar.php");
	require("../foundation/fsqlseletiem_set.php");
	require("../foundation/fback_search.php");
	
	//语言包引入
	$m_langpackage=new modulelp;
	$ad_langpackage=new adminmenulp;
	$bp_langpackage=new back_publiclp;
	$is_check=check_rights("c01");
	if(!$is_check){
		echo 'no permission';exit;
	}
	function gettypes($state)
	{
		switch ($state)
		{
		case 1:
		//充值
		  return "充值";
		  break;
		case 2:
		//升级
		  return "升级";
		  break;
		case 3:
		//站内信
		  return "消费";
		  break;
		case 4:
		//礼物
		  return "消费";
		  break;
		case 5:
		//翻译
		  return "翻译";
		  break;
		case 6:
		//兑换喇叭
		  return "兑换喇叭";
		  break;
		case 7:
		//客服咨询
		  return "客服咨询";
		  break;
		default:
		  return "其他";
		}
	}

	$dbo = new dbex;
	dbtarget('w',$dbServs);

	$user_id=intval(get_argg('user_id'));
	$uname=get_argg('uname');
	$touname=get_argg('touname');
	$ordernumber=get_argg('ordernumber');
	$addtime=get_argg('addtime');
	$type=get_argg('type');
	
	$condition=" ";
	if($uname){
		$condition.=" and uname like '%".$uname."%'" ;
	}
	if($touname){
		$condition.=" and touname like '%".$touname."%'" ;
	}
	if($ordernumber){
		$condition.=" and ordernumber like '%".$ordernumber."%'" ;
	}
	if($addtime){
		$condition.=" and addtime like '%".$addtime."%'" ;
	}
	if($type){
		$condition.=" and type = '".$type."'" ;
	}
	//当前页面参数
	$page_num=trim(get_argg('page'));

	//变量区
	$c_user_id=short_check(get_argg('user_id'));
	$c_user_name=short_check(get_argg('user_name'));

	$c_perpage=get_argg('perpage') ? intval(get_argg('perpage')):10;
	
	//echo $sql;exit;
	//设置分页
	//$uid=$dbo->setPages($c_perpage,$page_num);
	//取得数据



	$sql="select * from wy_balance where funds !=0 and state='2' " .$condition. " order by addtime desc";


	

	
	$dbo->setPages($c_perpage,$page_num);//设置分页
	$mp_list=$dbo->getRs($sql);
	//print_r($mp_list);
	$page_total=$dbo->totalPage;//分页总数
	//print_r($mp_list);
	//显示控制
	$isNull=0;
	$isset_data="";
	$none_data="content_none";
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
        <div class="crumbs"><?php echo $ad_langpackage->ad_location;?> &gt;&gt; <a href="javascript:void(0);">员工管理</a> &gt;&gt; <a href="javascript:void(0);">会员消费记录</a></div>
        <hr />
        <div class="infobox" style="text-align:left;margin-top:5px">
		<h3><?php echo $m_langpackage->m_check_condition;?></h3>
			<form method="get" action="" style="padding:10px 0">
				会员FROM：<input class="small-text" type="text" name="uname" value="<?php echo $uname;?>" /> 
				会员TO：<input class="small-text" type="text" name="touname" value="<?php echo $touname;?>" /> 
				类型：<select name="type">
							<option value=''>--请选择--</option>
							<option value='1' <?php if($type==1)echo 'selected';?>>充值</option>
							<option value='2' <?php if($type==2)echo 'selected';?>>升级</option>
							<option value='3' <?php if($type==3)echo 'selected';?>>送礼物</option>
							<option value='4' <?php if($type==4)echo 'selected';?>>发消息</option>
							<option value='5' <?php if($type==5)echo 'selected';?>>翻译</option>
							<option value='6' <?php if($type==6)echo 'selected';?>>喇叭</option>
							<option value='7' <?php if($type==7)echo 'selected';?>>咨询聊天</option>
						</select>
				订单号：<input class="small-text" type="text" name="ordernumber" value="<?php echo $ordernumber;?>" /> 
				时间：<input class="small-text" type="text" name="addtime" value="<?php echo $addtime;?>" onclick="calendar(this);" /> 
				
				<input type="submit" value="检索" class="regular-button" style="margin-top:-3px"> 
				<input type="reset" value="重置" class="regular-button" onclick="window.location.href='ticheng_list.php'" style="margin-top:-3px"> 
			</form>
		</div>
		
		
		
		
		<!-- Add By Root Time:20141022 Begin -->
		
		<?php 
		
			$link = mysql_connect("127.0.0.1", "root","mima123456");
				if(!mysql_select_db("partyings",$link)){
				
					echo "连接失败";
				}else{
				
					echo "同步连接成功——获取   礼物图片 处理中.......";
				}
		
		?>
		<!-- Add By Root Time:20141022 End -->
		
		
		
<div class="infobox">
    <h3>员工列表</h3>
    <div class="content">
<table class="list_table">
	<thead><tr>
    <th width="" style="text-align:center">会员FROM：</th>
    <th width="" style="text-align:center">会员TO：</th>
    <th style="text-align:center">订单号</th>
    <th width=""style="text-align:center">消费类型</th>
    <th width=""style="text-align:center">消费说明</th>
    <th style="text-align:center">消费金额</th>
    <th style="text-align:center">消费时间</th>
    <th style="text-align:center">操作</th>
	<th style="text-align:center">礼物图片</th>
    </tr></thead>
		<?php
		foreach($mp_list as $rs){?>
	<tr id="tr">
		<td>
		<?php echo $rs['uname'];?>
		</td>
		<td>
		<?php echo $rs['touname'];?>
		</td>
		

		<td style="text-align:center"><?php echo $rs['ordernumber'];?></td>
		
		<td style="text-align:center"><?php echo gettypes($rs['type']);?></td>

		<td style="text-align:center"><?php echo $rs['message'];?></td>
		
		<td align="center">
			<?php echo $rs['funds'];?>
		</td>

		<td align="center">
			<?php echo $rs['addtime'];?>
		</td>

		
		<td align="center">
			<a href="javascript:del_ticheng_list(<?php echo $rs['id'];?>);">删除</a>
		</td>
		<td align="center">
		<!-- $rs['type'] == 4  为送礼物-->
		
		<?php 
			if($rs['type'] == 4 ){
				//echo "送礼物";
				//$rootName = $rs['u_id'];
				//echo $rootName;
				//$sql_by_root="select user_name,user_email,user_add_time,lastlogin_datetime from wy_users where user_name='".$rs['uname']."'";
				
				$sql_by_root = "SELECT gift FROM `gift_order` WHERE accept_name='".$rs['touname']."' and send_name='".$rs['uname']."' and send_time='".$rs['addtime']."' ";
				//echo $sql_by_root;
				
				
				$result = mysql_query($sql_by_root);
				$result = mysql_fetch_array($result);
				$result['gift'] = explode('|', $result['gift']);
				echo "<img src='http://www.partyings.com/rootimg.php?src=".$result['gift'][0]."&h=43&w=43&zc=1'>";
			}
		
		?>
		
		
		</td>
	</tr>
		<?php
			}
		?>
        
	</table>
<?php page_show($isNull,$page_num,$page_total);?>
<div class='guide_info <?php echo $none_data;?>'><?php echo $m_langpackage->m_none_data;?></div>
</div>
<script>
function del_ticheng_list(id){
	if(!confirm('删除后对应提成也将删除，并且不可恢复！你考虑好了吗？')){
		return false;
	}
	var deltc=new Ajax();
	deltc.getInfo("del_ticheng_list.action.php","GET","app","id="+id,function(c){
		if(c=1){
			window.location.reload();
		}else{
			alert(c);
		}
	}); 
}
</script>
</div>
</div>
</div>
</form>
</body>
</html>