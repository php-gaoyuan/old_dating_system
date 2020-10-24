<?php
include(dirname(__file__)."/../includes.php");

//用户基础api函数
function user_read_base($fields="*",$condition="",$get_type="",$num="",$by_col="user_id",$order="desc",$cache="",$cache_key=""){
	global $allow_cols;
	global $tablePreStr;
	$t_user=$tablePreStr."users";
	$fields_str='';
	$result_rs=array();
	$dbo=new dbex;
  dbplugin('r');
	$allow_cols=array(
		"user_id","user_email","user_name","user_sex",'country',"birth_province","birth_city","reside_province","reside_city","user_ico","user_add_time","birth_year","birth_month","birth_day","creat_group","join_group","guest_num","integral","lastlogin_datetime","hidden_pals_id","hidden_type_id","inputmess_limit","palsreq_limit","is_pass","access_limit","access_questions","access_answers","forget_pass","onlinetimecount","golds","user_group"
	);
  $limit=$num ? " limit $num ":"";
	$by_col = $by_col ? " $by_col " : " user_id ";
	$order = $order ? $order:"desc";
	$get_type = $get_type=='getRow' ? "getRow":"getRs";
	if($fields=="*"){
		$fields=join(",",$allow_cols);
	}elseif(strpos($fields,",")){
		$fields=check_item($fields,$allow_cols);
	}else{
		if(!in_array($fields,$allow_cols)){
			$fields='user_id';
		}
	}
	$sql=" select $fields from $t_user where is_pass=1 $condition order by $by_col $order $limit ";
	if(empty($result_rs)){
		$result_rs=$dbo->{$get_type}($sql);
	}
	return $result_rs;
}

function user_self_by_uid($fields="*",$id){
	$fields=filt_fields($fields);
	$id_str=filt_num_array($id);
	$get_type="";
	if(strpos($id_str,",")){
		$condition=" and user_id in ($id_str) ";
	}else{
		$condition=" and user_id = $id_str ";
		$get_type="getRow";

		$dbo=new dbex;
		dbplugin('w');
		$groups=$dbo->getRow("select * from wy_upgrade_log where state='0' and mid='$id_str' order by id asc limit 1");
		
		if($groups)
		{
			$sql="update wy_users set user_group='{$groups[groups]}' where user_id=$id_str";
			//echo "<pre>";print_r($sql);exit;
			$dbo->exeUpdate($sql);
		}
		else
		{
			$sql="update wy_users set user_group='1' where user_id=$id_str";
			$dbo->exeUpdate($sql);
		}
	}

	return user_read_base($fields,$condition,$get_type);
}

function user_self_by_gnum($fields="*",$num=10){
	$fields=filt_fields($fields);
	return user_read_base($fields,"","",$num,"guest_num","desc",1,"gnum_");
}

function user_self_by_integral($fields="*",$num=10){
	$fields=filt_fields($fields);
	return user_read_base($fields,"","",$num,"integral","desc",1,"int_");
}

function user_self_by_logindate($fields="*",$date,$num=10){
	$fields=filt_fields($fields);
	$condition=str_replace("{date}","lastlogin_datetime",date_filter($date));
	return user_read_base($fields,$condition,"",$num,"lastlogin_datetime");
}

function user_self_by_new($fields="*",$num=4){
	$fields=filt_fields($fields);
	return user_read_base($fields,"","",$num);
}

function user_self_by_total(){
	global $tablePreStr;
	$t_user=$tablePreStr."users";
	$result_rs=array();
	$dbo=new dbex;
  dbplugin('r');
	$sql="select count(*) as total from $t_user";
	$result_rs=$dbo->getRow($sql);
	return $result_rs['total'];
}

function user_self_by_friend($sex,$start,$end,$fields="*"){
	global $tablePreStr;
	$t_user=$tablePreStr."users";
	$result_rs=array();
	$userids=array();
	$dbo=new dbex;
  dbplugin('r');
	$sql="select $fields from $t_user where user_sex!=".$sex." order by lastlogin_datetime desc limit $start,$end";
	$result_rs=$dbo->getRs($sql);
	foreach($result_rs as $r)
	{
		$userids[]=$r;
	}
	return $userids;
}

function user_self_by_lastlogin($fields="*",$num){
	$fields=filt_fields($fields);
	$num=filt_fields($num);
	$condition=" and user_ico !='skin/default/jooyea/images/d_ico_1_small.gif' and user_ico !='skin/default/jooyea/images/d_ico_0_small.gif' ";
	return user_read_base($fields,$condition,$get_type,$num,"lastlogin_datetime");
}
?>