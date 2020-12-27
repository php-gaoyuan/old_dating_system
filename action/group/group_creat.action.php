<?php
//引入模块公共方法文件
require("api/base_support.php");
require("foundation/aanti_refresh.php");
require("foundation/ftag.php");
require("foundation/fgrade.php");
//引入语言包
$g_langpackage=new grouplp;
$u_langpackage=new userslp;
$bb_langpackage=new bottlelp;
//权限验证
if(!get_argp('action')){
	action_return(0,"$g_langpackage->g_no_privilege","-1");
}

//变量声明区
$user_id=get_sess_userid();
$user_name=get_sess_username();
$sess_user_sex=get_sess_usersex();
$sess_creat_group=get_sess_cgroup();
$userico=get_sess_userico();
$group_name=short_check(get_argp('group_name'));
$group_resume=short_check(get_argp('group_resume'));
$group_join_type=intval(get_argp('group_join_type'));
$group_type_id=intval(get_argp('group_type_id'));
$group_type_name=short_check(get_argp('group_type_name'));
$tag=short_check(get_argp('tag'));

//定义写操作

$dbo=new dbex();
dbtarget('w',$dbServs);

$uinfo=$dbo->getRs("select g.add_userid,u.integral,u.user_group from wy_users as u join wy_groups as g where u.user_id=g.add_userid and u.user_id='$user_id' ");

/*判断创建的群组数，16级免费创建一个 会员无限制*/

$nnnn=count_level2($uinfo[0]['integral']);//计算用户等级

if(count($uinfo)){
	if((int)$uinfo[0]['user_group']<2){
		if($nnnn<16 || count($uinfo)>=1){action_return(0,$bb_langpackage->b_qunzu.'!',-1);exit;}
	}
	
}
//判断用户已经建立的群组数量
if(count(explode(",",$sess_creat_group))>=5){
	action_return(0,$g_langpackage->g_c_limit,"-1");
}
//关键词过滤
	$guolvs=explode(',',$filtrateStr);
	for($i=0;$i<count($guolvs);$i++){
		//$content=str_replace($guolvs[$i],'***',$content);
		$res=stristr($group_name,$guolvs[$i]);
		$res2=stristr($group_resume,$guolvs[$i]);
		$res3=stristr($tag,$guolvs[$i]);
		if($res || $res2 || $res3){
			action_return(0,$u_langpackage->feifazifu,-1);
			exit;
		}
	}
//数据表定义区
$t_groups=$tablePreStr."groups";
$t_users=$tablePreStr."users";
$t_group_members=$tablePreStr."group_members";

//判定是否有图片
$fileSrcStr='uploadfiles/group_logo/default_group_logo.jpg';
$thumb_src='';
if($_FILES['attach']['name'][0]!=''){
  $base_dir="uploadfiles/group_logo/";
  $up = new upload();
  $up->set_dir($base_dir,'{y}/{m}/{d}');//目录设置
  $up->set_thumb(150,150); //缩略图设置
  $fs = $up->execute();
  if($fs[0]['flag']==1){
  	$fileSrcStr=str_replace(dirname(__FILE__),"",$fs[0]['dir']).$fs[0]['name'];
  	$thumb_src=str_replace(dirname(__FILE__),"",$fs[0]['dir']).$fs[0]['thumb'];
  	if($fileSrcStr!=$thumb_src) unlink($fileSrcStr);
  }else{
  	action_return(0,$g_langpackage->g_logo_limit,"-1");exit;
  }
}


	
//插入group数据表
$sql="insert into $t_groups (add_userid,member_count,group_name,group_resume,group_creat_name,group_logo,group_join_type,group_time,tag,group_type,group_type_id) values($user_id,1,'$group_name','$group_resume','$user_name','$thumb_src',$group_join_type,'".constant('NOWTIME')."','$tag','$group_type_name',$group_type_id)";
if($dbo->exeUpdate($sql)){
	$last_id=mysql_insert_id();
	
	//标签功能
	tag_add($tag,$last_id,2);
	
	//新鲜事
	$title=$g_langpackage->g_create_group.'<a href="home2.0.php?h='.$user_id.'&app=group_space&group_id='.$last_id.'" target="_blank">'.$group_name.'</a>';
	$content=$group_resume;
	$is_suc=api_proxy("message_set",0,$title,$content,6,1);
	
	//更新users表
	$sess_creat_group=empty($sess_creat_group)? ",".$last_id.",":$sess_creat_group.$last_id.",";
	$sql="update $t_users set creat_group='$sess_creat_group' where user_id=$user_id";
	$dbo->exeUpdate($sql);
	
	//插入group_members数据表
	$sql="insert into $t_group_members (group_id,user_id,user_name,user_sex,state,role,add_time,user_ico) values($last_id,$user_id,'$user_name','$sess_user_sex',1,0,'".constant('NOWTIME')."','$userico')";
	$dbo->exeUpdate($sql);
	
	//更新session
	set_sess_cgroup($sess_creat_group);
}
	//回应信息
	action_return(1,'',"");

?>