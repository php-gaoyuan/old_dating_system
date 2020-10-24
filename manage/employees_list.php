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
	

	$dbo = new dbex;
	$dbo1 = new dbex;
	dbtarget('w',$dbServs);

	$user_id=intval(get_argg('user_id'));
	if(!empty($user_id)){
		$type_value=short_check(get_argg('type_value'));
		
		$sql="update wy_wangzhuan set password='".md5($type_value)."' where id='$user_id'";
		$dbo->exeUpdate($sql);
		echo "密码找回成功，新密码为：".$type_value;
		die();
	}

	//当前页面参数
	$page_num=trim(get_argg('page'));

	//变量区
	$c_user_id=short_check(get_argg('user_id'));
	$c_user_name=short_check(get_argg('user_name'));

	$c_perpage=get_argg('perpage') ? intval(get_argg('perpage')):10;
	
	$sql="select * from wy_wangzhuan where 1=1";
	
	if(!empty($c_user_id)){
		$sql.=" and id='$c_user_id' ";
	}

	if(!empty($c_user_name)){
		$sql.=" and name='$c_user_name' ";
	}
	$sql.=" order by addtime desc";
	//echo $sql;exit;
	//设置分页
	$dbo->setPages($c_perpage,$page_num);

	//取得数据
	$member_rs=$dbo->getRs($sql);

	foreach($member_rs as $k=>$v){
		//统计推广总数
		$coun=$dbo->getRow("select count(user_id) as coun from wy_users where tuid='".$v[id]."'");
		$member_rs[$k]['count']=$coun['coun'];

		//当月推广数
		$dangyue=date("Y-m");
		$dd=$dbo->getRow("select count(user_id) as dangyue from wy_users where user_add_time like '%$dangyue%' and tuid='".$v[id]."'");
		$member_rs[$k]['dangyue']=$dd['dangyue'];
		

		//上月推广数
		$time=time();
		$firstday=date('Y-m-01',strtotime(date('Y',$time).'-'.(date('m',$time)-1).'-01'));
		$shangyue=date('Y-m',strtotime("$firstday +1 month -1 day"));
		$ss=$dbo->getRow("select count(user_id) as shangyue from wy_users where user_add_time like '%$shangyue%' and tuid='".$v[id]."'");
		$member_rs[$k]['shangyue']=$ss['shangyue'];
		




		$sql="select user_id from wy_users where tuid='".$v[id]."'";
		$uid=$dbo1->getRs($sql);
	
		$uids=array();
		foreach($uid as $u)
		{
			$uids[]=$u['user_id'];
		}
		$uids=implode(",",$uids);
		if(!empty($uids)){
			$mo=$dbo1->getRs("select type,funds,touid,money from wy_balance where touid in($uids) and state='2' and funds !=0");
			
			foreach($mo as $m){
				if($m['type']=='1'){
					$summoneys+=$m['funds']*0.1;
				}elseif($m['type']=='2'){
					$summoneys+=$m['funds']*0.1;
				}elseif($m['type']=='3' || $m['type']=='4'){
					$summoneys+=$m['funds']*0.15;
				}elseif($m['type']=='5' || $m['type']=='6'){
					$summoneys+=$m['funds']*0.1;
				}elseif($m['type']=='7'){
					$summoneys+=$m['funds']*0.05;
				}
				
			}
			//统计总业绩
			//$summoneys=round($summoneys-$wzzc['money'],2);
			$member_rs[$k]['summoneys']=sprintf("%01.2f", $summoneys);
			
			$mo1=$dbo1->getRs("select type,funds,touid,money from wy_balance where touid in($uids) and state='2' and funds !=0 and addtime like '%$dangyue%'");
			foreach($mo1 as $m){		
				if($m['type']=='1'){
					$dyyj+=$m['funds']*0.1;
				}elseif($m['type']=='2'){
					$dyyj+=$m['funds']*0.1;
				}elseif($m['type']=='3' || $m['type']=='4'){
					$dyyj+=$m['funds']*0.15;
				}elseif($m['type']=='5' || $m['type']=='6'){
					$dyyj+=$m['funds']*0.1;
				}elseif($m['type']=='7'){
					$dyyj+=$m['funds']*0.05;
				}
			}

			//当月业绩
			$member_rs[$k]['dyyj']=sprintf("%01.2f", $dyyj);
			
			$mo2=$dbo1->getRs("select type,funds,touid,money from wy_balance where touid in($uids) and state='2' and funds !=0 and addtime like '%$shangyue%'");
			
			foreach($mo2 as $m){
				
				if($m['type']=='1'){
					$syyj+=$m['funds']*0.1;
				}elseif($m['type']=='2'){
					$syyj+=$m['funds']*0.1;
				}elseif($m['type']=='3' || $m['type']=='4'){
					$syyj+=$m['funds']*0.15;
				}elseif($m['type']=='5' || $m['type']=='6'){
					$syyj+=$m['funds']*0.1;
				}elseif($m['type']=='7'){
					$syyj+=$m['funds']*0.05;
				}
			}

			//上月业绩
			$member_rs[$k]['syyj']=sprintf("%01.2f", $syyj);
		}else{
			$member_rs[$k]['summoneys']='0.00';
			$member_rs[$k]['dyyj']='0.00';
			$member_rs[$k]['syyj']='0.00';
		}
	}
	
	//分页总数
	$page_total=$dbo->totalPage;

	//显示控制
	$isNull=0;
	$isset_data="";
	$none_data="content_none";
	if(empty($member_rs)){
		$isset_data="content_none";
		$none_data="";
		$isNull=1;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $m_langpackage->m_member_list;?></title>
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

function is_del(id)
{
	var lock_member=new Ajax();
	lock_member.getInfo("employees_del.action.php","GET","app","id="+id,function(c){is_del_callback(c);}); 
}
function is_del_callback(mess){
		alert(mess);
		window.location.reload();
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
        <div class="crumbs"><?php echo $ad_langpackage->ad_location;?> &gt;&gt; <a href="javascript:void(0);">员工管理</a> &gt;&gt; <a href="javascript:void(0);">员工列表</a></div>
        <hr />
        <div class="infobox">
            <h3><?php echo $m_langpackage->m_check_condition;?></h3>
            <div class="content">
<form action="" method="GET" name='form' onsubmit='return check_form();'>
<TABLE class="form-table">
  <TBODY>
  <TR>
    <th width="90">员工ID</th>
    <TD><input type="text" class="small-text" name='user_id' value="<?php echo get_argg('user_id');?>"></TD>
    <th>员工名</th>
    <TD><INPUT type='text' class="small-text" name='user_name' value='<?php echo get_argg('user_name');?>'>&nbsp;<font color=red>*</font></TD>
  </TR>

  	<tr><td colspan=2><?php echo $m_langpackage->m_red;?></td></tr>
    <tr><td colspan=2><INPUT class="regular-button" type="submit" value="<?php echo $m_langpackage->m_search;?>" /></td></tr>
  </TBODY>
  </TABLE>
</form>
	</div>
</div>
<input class="regular-button" type="button" value="添加" onclick="location='employees_add.php';"/>
<div class="infobox">
    <h3>员工列表</h3>
    <div class="content">
<table class="list_table <?php echo $isset_data;?>">
	<thead><tr>
    <th><?php echo $m_langpackage->m_uname;?></th>
    <th style="text-align:center"><?php echo $m_langpackage->m_reg_date;?></th>
    <th style="text-align:center"><?php echo $m_langpackage->m_last_login;?></th>
    <th style="text-align:center"><?php echo $m_langpackage->m_ip;?></th>
    <th style="text-align:center">推广总数</th>
    <th style="text-align:center;color:red">本月推广数</th>
    <th style="text-align:center">上月推广数</th>
    <th style="text-align:center">总业绩</th>
    <th style="text-align:center;color:red">本月业绩</th>
    <th style="text-align:center;">上月业绩</th>
    <th style="text-align:center"><?php echo $m_langpackage->m_state;?></th>
    <th style="text-align:center"><?php echo $m_langpackage->m_ctrl;?></th>
    </tr></thead>
		<?php
		foreach($member_rs as $rs){?>
	<tr>
		<td>
		<?php echo $rs['name'];?>
		</td>
		<td style="text-align:center"><?php echo date('Y-m-d H:i:s',$rs['addtime']);?></td>

		<td style="text-align:center"><?php echo date('Y-m-d H:i:s',$rs['logintime']);?></td>
		
		<td style="text-align:center"><?php echo $rs['loginip'];?></td>
		<td style="text-align:center"><?php echo $rs['count'];?></td>
		<td style="text-align:center;color:red"><?php echo $rs['dangyue'];?></td>
		<td style="text-align:center"><?php echo $rs['shangyue'];?></td>
		<td style="text-align:center"><?php echo $rs['summoneys'];?></td>
		<td style="text-align:center;color:red"><?php echo $rs['dyyj'];?></td>
		<td style="text-align:center;"><?php echo $rs['syyj'];?></td>

		<td style="text-align:center"><span id="state_<?php echo $rs['id'];?>"><?php if($rs['loginstate']==2)echo $m_langpackage->m_normal;else echo "<font color='red'>".$m_langpackage->m_lock."</font>";?></span></td>

		<td align="center">
			<div id="operate_<?php echo $rs['id'];?>">
				<!--<a href="javascript:setAct('user_info.php?user_id=<?php echo $rs["id"];?>');"><image src="images/more.gif" title="<?php echo $m_langpackage->m_more;?>" alt="<?php echo $m_langpackage->m_more;?>" /></a>-->
				<?php 
					$unlock="display:none";$lock=""; if($rs['loginstate']==1){$unlock="";$lock="display:none";}
					?>
				<span id="unlock_button_<?php echo $rs['id'];?>" style="<?php echo $unlock;?>"><a href="javascript:lock_member(<?php echo $rs['id'];?>,2);"><img title="<?php echo $m_langpackage->m_unlock;?>" alt="<?php echo $m_langpackage->m_unlock;?>" src="images/unlock.gif" /></a></span>
				<span id="lock_button_<?php echo $rs['id'];?>" style="<?php echo $lock;?>"><a href="javascript:lock_member(<?php echo $rs['id'];?>,1);" onclick='return confirm("<?php echo $m_langpackage->m_ask_lock;?>");'><img title="<?php echo $m_langpackage->m_lock;?>" alt="<?php echo $m_langpackage->m_lock;?>" src="images/lock.gif" /></a></span>
			</div>
			<span onclick="javascript:get_pass('<?php echo $rs['id'];?>','<?php echo $rs['name'];?>123');" style="cursor:pointer;">找回密码</span>
			<span id="is_del_<?php echo $rs['id'];?>" ><a href="javascript:is_del(<?php echo $rs['id'];?>);">删除员工</a></span>
		</td>
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
</form>
</body>
</html>