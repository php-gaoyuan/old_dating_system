<?php
require(dirname(__file__)."/../session_check.php");
require("../../foundation/fpages_bar.php");
require("../../foundation/fsqlseletiem_set.php");
require("../../foundation/fback_search.php");

$ri_langpackage=new rightlp;
$l_langpackage=new loginlp;
$p_langpackage=new pwlp;
$m_langpackage=new modulelp;
$u_langpackage=new uilp;
$ad_langpackage=new adminmenulp;

if(get_session('admin_group')!='superadmin'){
	echo $ri_langpackage->ri_refuse;exit;
}

//数据库读写
$dbo = new dbex;
dbtarget('w',$dbServs);

$user_group=get_argg('user_group');

//数据表定义
$t_frontgroup=$tablePreStr."frontgroup";
$t_users=$tablePreStr."users";
$t_wangzhuan=$tablePreStr."wangzhuan";
//重置密码
if(isset($_GET['cz_uid']) && intval($_GET['cz_uid'])>0){
	$cz_info = $dbo->getRow("select * from $t_users where user_id='$_GET[cz_uid]'");
	if(!empty($cz_info)){
		//print_r("update $t_users set user_pws='e10adc3949ba59abbe56e057f20f883e' where user_id='{$_GET['cz_uid']}'");exit;
		$dbo->exeUpdate("update $t_users set user_pws='e10adc3949ba59abbe56e057f20f883e' where user_id='{$_GET['cz_uid']}'");
		//header('location:./user_manager.php');exit;
		echo "<script>alert('重置【".$cz_info['user_name']."】的密码成功');window.location.href='/manage/rights/user_manager.php'</script>";exit;
	}
}





$sql="select gid,name from $t_frontgroup";
$groups=$dbo->getRs($sql);

$options="<option value='' selected>".$ri_langpackage->ri_choose."</option>";
$group_array=array();

if($groups){
	foreach($groups as $group){
		$selected='';
		if($user_group==$group['gid']){
			$selected='selected';
		}
		$options.='<option value="'.$group['gid'].'" '.$selected.'>'.$group['name'].'</option>';
		$group_array[$group['gid']] = $group['name'];
	}
}
//$options .= "<option value='4'>VIP无限期会员</option>";
//echo "<pre>";print_r($options);exit;

$sql="select id,name from $t_wangzhuan order by id asc";
$wangzhuans=$dbo->getRs($sql);

$options2="<option value=\"\" selected>".$ri_langpackage->ri_choose."</option>";
$wangzhuan_array=array();
if($wangzhuans){
	foreach($wangzhuans as $wangzhuan){
		$options2.='<option value="'.$wangzhuan['id'].'" >'.$wangzhuan['name'].'</option>';
		$wangzhuan_array[$wangzhuan['id']] = $wangzhuan['name'];
	}
}

if(get_args("op")=='upd'){
	$user_id=intval(get_args('user_id'));
	$up="";
	$group=get_args('group');
	//echo "<pre>";print_r($group);exit;
	
	if(!empty($group))
	{
		$up.="user_group='$group'";

		$sql="update wy_upgrade_log set state='1' where mid='$user_id'";
		$dbo->exeUpdate($sql);

		$nowtime=date("Y-m-d");	
		$end=date("Y-m-d",strtotime($nowtime)+30*24*3600);

		$sql="insert into wy_upgrade_log set mid='$user_id',groups='$group',howtime='30',state='0',addtime=now(),endtime='$end'";
		
		//wuxianqi
		if($group == 4){
			$dats="3600";
			$nowtime=date("Y-m-d");	
			$end=date("Y-m-d",strtotime($nowtime)+$dats*24*3600);
			$sql="insert into wy_upgrade_log set mid='$user_id',groups='$group',howtime='$dats',state='0',addtime=now(),endtime='$end'";
		}

		$dbo->exeUpdate($sql);
	}
	//$referrer=get_args('referrer')?get_args('referrer'):'系统推荐';
	$referrer=get_args('referrer');

	if(!empty($referrer))
	{
		if(!empty($up))
			$up.=",tuid='$referrer'";
		else
			$up.="tuid='$referrer'";
	}
	$golds=get_args('golds');
	if(intval($golds)>=0)
	{
		if(!empty($up))
			$up.=",golds='$golds'";
		else
			$up.="golds='$golds'";
	}
	if(!empty($up))
	{
       
		$sql="update $t_users set $up where user_id='$user_id'";

		$dbo->exeUpdate($sql);
	}
	exit();
}

	//当前页面参数
	$page_num=trim(get_argg('page'));
	$sql='';
	$eq_array=array('user_id','user_group');
	$like_array=array("user_name");
	$date_array=array();
	$num_array=array();
	$sql=spell_sql($t_users,$eq_array,$like_array,$date_array,$num_array,'','','');	


    $sql.='  order by user_id desc ';


	//设置分页
	$dbo->setPages(20,$page_num);

	//取得数据
	$member_rs=$dbo->getRs($sql);

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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" media="all" href="../css/admin.css">
<script type='text/javascript' src='../../servtools/ajax_client/ajax.js'></script>
<script type='text/javascript'>
function user_manager(user_id)
{
	var group=document.getElementById("group_"+user_id).value;
	var referrer=document.getElementById("referrer_"+user_id).value;
	var golds=document.getElementById("purple_"+user_id).value;
	var user_manager=new Ajax();
	user_manager.getInfo("user_manager.php?op=upd&user_id="+user_id,"post","app","&group="+group+"&referrer="+referrer+"&golds="+golds,function(c){
		window.location.reload();
	});
}

function cancel_sort(show_1,show_2,hidden_1,hidden_2){
	document.getElementById("add_value").value="";
	document.getElementById(show_1).style.display="";
	document.getElementById(show_2).style.display="none";
	document.getElementById(hidden_1).style.display="none";
	document.getElementById(hidden_2).style.display="none";
	}

function change_sort(show_1,show_2,show_3,show_4,show_5,hidden_1,hidden_2,hidden_3,hidden_4,hidden_5){
	document.getElementById(show_1).style.display="none";
	document.getElementById(show_2).style.display="none";
	document.getElementById(show_3).style.display="none";
	document.getElementById(show_4).style.display="none";
	document.getElementById(show_5).style.display="none";
	document.getElementById(hidden_1).style.display="";
	document.getElementById(hidden_2).style.display="";
	document.getElementById(hidden_3).style.display="";
	document.getElementById(hidden_4).style.display="";
	document.getElementById(hidden_5).style.display="";
	}

function cancel_change(show_1,show_2,show_3,show_4,show_5,hidden_1,hidden_2,hidden_3,hidden_4,hidden_5){
	document.getElementById(show_1).style.display="";
	document.getElementById(show_2).style.display="";
	document.getElementById(show_3).style.display="";
	document.getElementById(show_4).style.display="";
	document.getElementById(show_5).style.display="";
	document.getElementById(hidden_1).style.display="none";
	document.getElementById(hidden_2).style.display="none";
	document.getElementById(hidden_3).style.display="none";
	document.getElementById(hidden_4).style.display="none";
	document.getElementById(hidden_5).style.display="none";
	}
</script>
</head>
<body>
<div id="maincontent">
    <div class="wrap">
        <div class="crumbs"><?php echo $ad_langpackage->ad_location;?> &gt;&gt; <a href="javascript:void(0);"><?php echo $ad_langpackage->ad_user_management;?></a> &gt;&gt; <a href="user_manager.php"><?php echo $ad_langpackage->ad_member_role_management;?></a></div>
        <hr />
        <div class="infobox">
            <h3><?php echo $m_langpackage->m_check_condition;?></h3>
            <div class="content">
							<form action="" method="GET" name='form'>
								<table class="form-table">
								  <tr>
								    <th width="90"><?php echo $m_langpackage->m_userid;?></th>
								    <td><input type="text" class="small-text" name='user_id' value="<?php echo get_argg('user_id');?>"></td>
								    <th><?php echo $m_langpackage->m_uname;?></th>
								    <td><INPUT type='text' class="small-text" name='user_name' value='<?php echo get_argg('user_name');?>'>&nbsp;<font color=red>*</font></td>
								  </tr>
								  <tr>
								    <th><?php echo $ri_langpackage->ri_users;?></th>
								    <td>
								    	<select name='user_group'>
								    		<?php echo $options;?>
								    	</select>
								    </td>
								  </tr>
								  <tr><td colspan=2><?php echo $m_langpackage->m_red;?></td></tr>
								  <tr><td colspan=2><INPUT class="regular-button" type="submit" value="<?php echo $m_langpackage->m_search;?>" /></td></tr>
								</table>
							</form>
            </div>
         </div>
        
<div class="infobox">
    <h3><?php echo $ri_langpackage->ri_users_list;?></h3>
    <div class="content">

<table class='list_table <?php echo $isset_data;?>'>
  <thead><tr>
    <th><?php echo $p_langpackage->p_name;?></th>
    <th><?php echo $ri_langpackage->ri_users;?></th>
    <th><?php echo $ri_langpackage->ri_referrer;?></th>
    <th><?php echo $ri_langpackage->ri_purple;?></th>
    <th width="130" style="text-align:center"><?php echo $m_langpackage->m_ctrl;?></th>
    
  </tr></thead>
<?php
foreach($member_rs as $rs){
?>
	<tr>
		<td>
			<div id="show_num_<?php echo $rs['user_id'];?>"><?php echo $rs['user_name'];?></div>
			<div id="order_by_<?php echo $rs['user_id'];?>" style="display:none">
			<input type="text" class="small-text" id="input_num_<?php echo $rs['user_id'];?>" maxlength="15" value="<?php echo $rs['user_name'];?>" />
			</div>
		</td>
		<td>
		<div id="show_title_<?php echo $rs['user_id'];?>"><?php echo isset($group_array[$rs['user_group']])?$group_array[$rs['user_group']]:$ri_langpackage->ri_choose;?></div>
		<div id="title_<?php echo $rs['user_id'];?>" style="display:none">
			<select name="group" id="group_<?php echo $rs['user_id'];?>"><?php echo $options;?></select>
		</div>
		</td>
		<td>
		<div id="show_referrer_<?php echo $rs['user_id'];?>"><?php echo isset($wangzhuan_array[$rs['tuid']])?$wangzhuan_array[$rs['tuid']]:$ri_langpackage->ri_choose;?></div>
		<div id="referrertitle_<?php echo $rs['user_id'];?>" style="display:none">
			<select name="referrer" id="referrer_<?php echo $rs['user_id'];?>"><?php echo $options2;?></select>
		</div>
		</td>
		<td>
		<div id="show_purple_<?php echo $rs['user_id'];?>"><?php echo isset($rs['golds'])?$rs['golds']:0;?></div>
		<div id="purpletitle_<?php echo $rs['user_id'];?>" style="display:none">
			<input type="text" class="small-text" id="purple_<?php echo $rs['user_id'];?>" maxlength="15"  name="golds" value="<?php echo $rs['golds'];?>" />
		</div>
		</td>
		<td style="text-align:center">
		<div id="button_<?php echo $rs['user_id'];?>">
			<a href="javascript:change_sort('show_num_<?php echo $rs['user_id'];?>','show_title_<?php echo $rs['user_id'];?>','show_referrer_<?php echo $rs['user_id'];?>','show_purple_<?php echo $rs['user_id'];?>','button_<?php echo $rs['user_id'];?>','order_by_<?php echo $rs['user_id'];?>','title_<?php echo $rs['user_id'];?>','referrertitle_<?php echo $rs['user_id'];?>','purpletitle_<?php echo $rs['user_id'];?>','action_<?php echo $rs['user_id'];?>');SelectItem(document.getElementById('group_<?php echo $rs['user_id'];?>'), '<?php echo isset($group_array[$rs['user_group']])?$group_array[$rs['user_group']]:'';?>');SelectItem(document.getElementById('referrer_<?php echo $rs['user_id'];?>'), '<?php echo isset($wangzhuan_array[$rs['tuid']])?$wangzhuan_array[$rs['tuid']]:'';?>');"><?php echo $u_langpackage->u_amend?></a>&nbsp;&nbsp;
			<a href="/main.php?toid=<?php echo $rs['user_id'];  ?>" target="_blank" style="color:#0f9ac8;">[代管该会员]</a>
			<a href="?cz_uid=<?php echo $rs['user_id'];  ?>" target="right" style="color:#0f9ac8;">[重置密码]</a>


		</div>
		<div id="action_<?php echo $rs['user_id'];?>" style="display:none">
			<input type='button' onclick='user_manager("<?php echo $rs['user_id'];?>")' class='regular-button' value='<?php echo $u_langpackage->u_amend?>' />
			<input type='button' onclick="cancel_change('show_num_<?php echo $rs['user_id'];?>','show_title_<?php echo $rs['user_id'];?>','show_referrer_<?php echo $rs['user_id'];?>','show_purple_<?php echo $rs['user_id'];?>','button_<?php echo $rs['user_id'];?>','order_by_<?php echo $rs['user_id'];?>','title_<?php echo $rs['user_id'];?>','referrertitle_<?php echo $rs['user_id'];?>','purpletitle_<?php echo $rs['user_id'];?>','action_<?php echo $rs['user_id'];?>')" class='regular-button' value='<?php echo $u_langpackage->u_cancel?>' />
		</div>
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
</div>
<script type='text/javascript'>
function update(name,group)
{
	document.getElementById('form').innerHTML='<label><?php echo $p_langpackage->p_name;?>：<input type="text" name="name"  readonly="readonly"  id="name" value="'+name+'" /></label><label><?php echo $ri_langpackage->ri_users;?>：<select name="group" id="group"><?php echo $options;?></select></label><input type="submit" name="submit" class="regular-button" id="button" value="<?php echo $u_langpackage->u_amend;?>" />';
	SelectItem(document.getElementById('group'), group);
}
function SelectItem(objSelect, objItemText)
{
	var isExit = false;
	for (var i = 0; i < objSelect.options.length; i++)
	{
		if (objSelect.options[i].value == objItemText || objSelect.options[i].text == objItemText)
		{
			objSelect.options[i].selected = true;
			break;
		}
	}
}
function trim(str){
	return str.replace(/(^\s*)|(\s*$)|(　*)/g , "");
}
function check_form(){
	var p_value=document.getElementById('password').value;
	var rep_value=document.getElementById('repassword').value;
	var group_value=document.getElementById('group').value;
	if(trim(p_value).length<6||trim(rep_value).length<6){
		alert('<?php echo $ri_langpackage->ri_pass_wrong;?>');return false;
	}
	if(group_value==''){
		alert('<?php echo $ri_langpackage->ri_empty_wrong;?>');return false;
	}
}
</script>
</body>
</html>