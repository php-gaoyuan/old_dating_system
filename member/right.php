<?php
require("includet.php");
require("../foundation/fpages_bar.php");


$page_num=trim(get_argg('page'));

$dbo=new dbex;
dbplugin('r');

$sql="select * from wy_frontgroup";
$frontgroups=$dbo->getRs($sql);
$frontgroup=array();
foreach($frontgroups as $f)
{
	$frontgroup[$f['gid']]=$f['name'];
}

$sql="select * from wy_users where tuid='".get_session('wz_userid')."' order by user_id desc";

/*gaoyuan*/
if(isset($_GET)){
	$user_group=$_GET['user_group'];
	$uname=$_GET['uname'];
	if(!empty($user_group) && empty($uname)){
		$sql="select * from wy_users where tuid='".get_session('wz_userid')."' and user_group='$user_group' order by user_id desc";
	}else if(!empty($user_group) && empty($uname)){
		$sql="select * from wy_users where tuid='".get_session('wz_userid')."' and user_name='$uname' order by user_id desc";
	}else if(!empty($user_group) && empty($uname)){
		$sql="select * from wy_users where tuid='".get_session('wz_userid')."' and user_name='$uname' and user_group='$user_group' order by user_id desc";
	}
}





	

/*add end*/
$dbo->setPages(18,$page_num);//设置分页
$mp_list_rs=$dbo->getRs($sql);
$page_total=$dbo->totalPage;//分页总数

if($_GET['isajax']==1){
	$uid=$dbo->getRow("select id from wy_wangzhuan where name='$_GET[name]'");
	$uids=$uid['id'];
	if(!$uids){
		echo "推广员错误";exit;
	}
	$id=$_GET['id'];
	$time=time();
	$shuoming="该会员由".get_session('wz_uname')."个人业绩账号过继到".$_GET['name']."；说明：".$_GET['shuoming'];
	//$shuoming=$_GET['name'].$_GET['shuoming'];
	//echo $shuoming;
	if($dbo->exeUpdate("update wy_users set tuid='$uids',from_tgid='".get_session('wz_userid')."',guoji_time='$time',guoji_shuoming='$shuoming' where user_id='$id'")){
		echo '过继成功';
	}else{
		echo '操作失败'.$uids;
	}
	exit;
}
?>
<html>
<head>
<title>网站管理系统</title>
<link href="css/Guest.css" rel="stylesheet" type="text/css" />
<script src="js/system.js"></script>
<script src="js/jquery.min.js"></script>
<style>
.pages_bar{margin-left: 20px;clear: both;float: left; height: auto;overflow: hidden;padding: 6px 0 7px;}
.pages_bar a {border: 1px solid #DDDDDD;color: #AAAAAA;display: block;float: left;font-family: Arial;font-size: 12px;height: 20px;line-height: 18px;margin: 0 2px;overflow: hidden;padding: 3px 8px 0;text-decoration: none;}
.pages_bar a:hover {background: none repeat scroll 0 0 #EEEEEE;color: #4E4E4E;text-decoration: none;}
.pages_bar .current_page{font-weight: bold;color: #333;}
</style>



</head>
<body>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="table_01">
<tr>
	<td colspan='7' align="right" width='100%'>
	<form action="" method="get" style="display: block;padding:15px;">
				用户组：
					<select name="user_group">
						<option value="">==请选择==</option>
						<option value="1" <?php if($_GET['user_group'] == 1)echo "selected"; ?>>普通会员</option>
						<option value="2" <?php if($_GET['user_group'] == 2)echo "selected"; ?>>白金会员</option>
						<option value="3" <?php if($_GET['user_group'] == 3)echo "selected"; ?>>VIP会员</option>
					</select>
		会员昵称：<input type="text" name="uname" id="uname">
		<input type="submit" value="查询">
	</form>
	</td>
</tr>
  <tr class="t_Title">
	<td colspan="6">会员列表</td>
  </tr>
  <tr class="t_Haader">
	<td>会员ID</td>
    <td>会员帐号</td>
    <td>会员昵称</td>
    <td>会员类别</td>
    <td>注册时间</td>
    <td>登录时间</td>
    <!-- <td>自助变更</td> -->
    
    
  </tr>
  <?php foreach($mp_list_rs as $rs){?>
  <tr>
	<td><?php echo $rs['user_id'];?></td>
    <td><?php echo $rs['user_email'];?></td>
    <td><?php echo $rs['user_name'];?></td>
    <td><?php if($rs['user_group']=='base'){echo '普通会员';}else {echo $frontgroup[$rs['user_group']];}?></td>
    <td><?php echo $rs['user_add_time'];?></td>
    <td><?php echo $rs['lastlogin_datetime'];?></td>

    <!-- <td>  我要将此会员转给<input type=text id="bg_name_<?php echo $rs['user_id'];?>" size=3/><input type=submit value='确定' onclick="if(document.getElementById('bg_name_<?php echo $rs['user_id'];?>').value==''){document.getElementById('bg_name_<?php echo $rs['user_id'];?>').focus();return false};guoji(<?php echo $rs['user_id'];?>,document.getElementById('bg_name_<?php echo $rs['user_id'];?>').value)"/></td> -->
    
  </tr>
  <?php }?>
  <tr>
	<td colspan="6"><?php echo page_show($isNull,$page_num,$page_total);?></td>
  </tr>
</table>
<script>
function guoji(id,name){
	if(!confirm('过继后不可恢复！确定过继给`'+document.getElementById('bg_name_'+id).value+'`? ')){
		return false;
	}else{
		var shuoming=prompt('请输入过继说明');
		if(!shuoming) return false;
	}
	$.get('right.php?isajax=1&id='+id+'&name='+name+'&shuoming='+shuoming,'',function(c){
		alert(c)
		window.location.reload();
	});
	
}
</script>
</body>
</html>