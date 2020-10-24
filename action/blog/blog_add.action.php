<?php
  //引入模块公共方法文件
  require("foundation/fcontent_format.php");
  require("api/base_support.php");
  require("foundation/aanti_refresh.php");
  require("foundation/aintegral.php");
  require("foundation/fplugin_form.php");
  require("foundation/ftag.php");
	require("foundation/fgrade.php");
	//引入语言包
	$b_langpackage=new bloglp;
	$u_langpackage=new userslp;
	$bb_langpackage=new bottlelp;
	//变量取得
  $ulog_title=short_check(get_argp("blog_title"));
  $ulog_sort=intval(get_argp("blog_sort_list"));
  $privacy=short_check(get_argp("privacy"));
  $ulog_txt=big_check(get_argp("CONTENT"));
	$user_id=get_sess_userid();
	$user_name=get_sess_username();
	$uico_url=get_sess_userico();//用户头像
	$blog_sort_name=short_check(get_argp('blog_sort_name'));
	$tag=short_check(get_argp('tag'));
	
	
	//关键词过滤
	$guolvs=explode(',',$filtrateStr);
	for($i=0;$i<count($guolvs);$i++){
		//$content=str_replace($guolvs[$i],'***',$content);
		$res=stristr($ulog_title,$guolvs[$i]);
		$res2=stristr($tag,$guolvs[$i]);
		$res3=stristr($ulog_txt,$guolvs[$i]);
		if($res || $res2 || $res3){
			action_return(0,$u_langpackage->feifazifu,-1);exit;
		}
	}
	
	//防止重复提交
	antiRePost($ulog_title);
	
	$dbo = new dbex;
	//读写分离定义函数
	dbtarget('w',$dbServs);
	
	$uinfo=$dbo->getRow("select user_group,integral,blog_num,blog_time from wy_users where user_id='$user_id'");
	/*判断当天发了多少日志，普通用户只可发L篇*/
	if($uinfo['blog_time']==date("Y-m-d")){
		$new_num=$uinfo['blog_num']+1 ;
	}else{
		$new_num=1 ;
	}
	$dbo->exeUpdate("update wy_users set blog_num='$new_num',blog_time='".date('Y-m-d')."' where user_id='$user_id'");
	
	if($uinfo['user_group']=='base' || $uinfo['user_group']==1){
		
		$nnnn=count_level2($uinfo['integral']);
		
		if($uinfo['blog_num']>$nnnn && $uinfo['blog_time']==date("Y-m-d")){
			action_return(0,$bb_langpackage->b_xianzhi,-1);exit;
		}
	}
	
	
	
	if($ulog_title==''){
		action_return(1,'',-1);exit;
	}
	
	//数据表定义区
	$t_blog=$tablePreStr."blog";

	
	increase_integral($dbo,$int_blog,$user_id);
  plugin_submit_form();//plugins表单分发
	$sql="insert into $t_blog (user_id,log_title,log_sort,log_content,add_time,log_sort_name,user_name,user_ico,privacy,`tag`) values ($user_id,'$ulog_title',$ulog_sort,'$ulog_txt','".constant('NOWTIME')."','$blog_sort_name','$user_name','$uico_url','$privacy','$tag')";
	$dbo->exeUpdate($sql);
	$ublog_id=mysql_insert_id();
	if($privacy==''){
		$title=$b_langpackage->b_write_new_log."<a href=\"home2.0.php?h=".$user_id."&app=blog&id=".$ublog_id."\" target='_blank'>".$ulog_title."</a>";
		$content=get_lentxt($ulog_txt);
		$is_suc=api_proxy("message_set",$ublog_id,$title,$content,3,0);
	}
	//标签功能
	tag_add($tag,$ublog_id,0);
	action_return(1,'','');
?>