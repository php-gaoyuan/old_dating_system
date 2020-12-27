<?php
	require("foundation/ftag.php");
	//引入语言包
	$b_langpackage=new bloglp;

	//变量取得
  $ulog_id=intval(get_argg("id"));
  $privacy=short_check(get_argp("privacy"));
  $ulog_title=short_check(get_argp("blog_title"));
  $tag=short_check(get_argp("tag"));
  if(get_argp("blog_sort_list")){
  	$ulog_sort=short_check(get_argp("blog_sort_list"));
  }else{
  	$ulog_sort=0;
  }
  $ulog_txt=big_check(get_argp("CONTENT"));
  $blog_sort_name=short_check(get_argp('blog_sort_name'));
	$user_id=get_sess_userid();
	$user_name=get_sess_username();
	
	//数据表定义区
	$t_blog=$tablePreStr."blog";

	$dbo = new dbex;
	//读写分离定义函数
	dbtarget('w',$dbServs);
	
	//标签自动化
	$old_tag=get_tag($t_blog,'log_id',$ulog_id);
	auto_tag($tag,$old_tag,$ulog_id,0);
	
	$sql= "update $t_blog set log_title='$ulog_title',privacy='$privacy',log_sort='$ulog_sort',log_content='$ulog_txt',edit_time='".constant('NOWTIME')."',log_sort_name='$blog_sort_name',tag='$tag' where user_id=$user_id and log_id=$ulog_id";
 	if($dbo->exeUpdate($sql)){
		action_return(1,'','modules2.0.php?app=blog&id='.$ulog_id);
	}else{
		action_return(0,'error','-1');
	}
?>
