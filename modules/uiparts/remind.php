<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/uiparts/remind.html
 * 如果您的模型要进行修改，请修改 models/modules/uiparts/remind.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
//引入语言包
$rem_langpackage=new remindlp;

//引入提醒模块公共函数
require("foundation/fdelay.php");
require("api/base_support.php");

//表定义区
$t_online=$tablePreStr."online";
$isset_data="";
$DELAY_ONLINE=4;
$is_action=delay($DELAY_ONLINE);
if($is_action){
	$dbo=new dbex;
	dbtarget('w',$dbServs);
	update_online_time($dbo,$t_online);
	rewrite_delay();
}
$remind_rs=api_proxy("message_get","remind");
//$remind_rs=$dbo->getRs("select * from wy_remind where user_id='$user_id' and is_focus=0");
//echo "<pre>";var_dump($remind_rs);exit;
if($langPackagePara=='zh')
{
	$remind_rs2=array();
	foreach($remind_rs as $r)
	{
		$mess=$r[4];
		$mess=str_replace("hello","个招呼",$mess);
		$mess=str_replace("A notice","个通知",$mess);
		$mess=str_replace("Message","封邮件",$mess);
		$mess=str_replace("Message","张小纸条",$mess);
		$mess=str_replace("Comments","条留言",$mess);
		$mess=str_replace("Comments","条评论",$mess);

		$mess=str_replace("Replied to your mood","回复了您的心情",$mess);
		$mess=str_replace("Replied to your blog","回复了您的日志",$mess);
		$mess=str_replace("Replied to your photo","回复了您的照片",$mess);
		$mess=str_replace("You replied album","回复了相册",$mess);

		$r[4]=$mess;
		$r['content']=$mess;
		$remind_rs2[]=$r;
	}
	if(!empty($remind_rs2)){
		$remind_rs=$remind_rs2;
	}else{
		$remind_rs=array(array('count'=>'0','content'=>'暂时没有消息','link'=>'javascript:;'));
	}
}
else //if($langPackagePara=='en')
{
	$remind_rs2=array();
	foreach($remind_rs as $r)
	{
		$mess=$r[4];
		$mess=str_replace("个招呼"," hello",$mess);
		$mess=str_replace("个通知"," A notice",$mess);
		$mess=str_replace("封邮件"," Message",$mess);
		$mess=str_replace("张小纸条"," Message",$mess);
		$mess=str_replace("条留言"," Comments",$mess);
		$mess=str_replace("条评论","Comments",$mess);

		$mess=str_replace("中回复了您","",$mess);
		$mess=str_replace("问题","",$mess);
		$mess=str_replace("在心情","Replied to your mood",$mess);
		$mess=str_replace("在日志","Replied to your blog",$mess);
		$mess=str_replace("在照片","Replied to your photo",$mess);
		$mess=str_replace("在相册","Replied to your album",$mess);

		$r[4]=$mess;
		$r['content']=$mess;
		$remind_rs2[]=$r;
	}
	if(!empty($remind_rs2)){
		$remind_rs=$remind_rs2;
	}else{
		$remind_rs=array(array('count'=>'0','content'=>'There is no news!','link'=>'javascript:;'));
	}
}

if(empty($remind_rs)){
	$isset_data="content_none";
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="500" />
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/layout.css">
<SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>
<script type='text/javascript'>
	function clear_remind(remind_id){
		var ajax_remind=new Ajax();
		ajax_remind.getInfo("do.php","GET","app","act=message_del&id="+remind_id,function(c){window.location.reload();});
	}
</script>
</head>
<body id="remindbody" style="overflow:hidden;float:left;background:none">
<div class="sideitem <?php echo $isset_data;?>" style="background-color:#fff;margin-top:0;">
    <div class="container" style="margin:4px;">
        <div class="sideitem_head"><h4><?php echo $rem_langpackage->rem_wait_act;?></h4></div>
        <div class="sideitem_body">
            <ul class="textlist">
            	<?php foreach($remind_rs as $rs){?>
                <li class="remind_<?php echo $rs['type_id'];?>"><a href="<?php echo $rs['link'];?>" target='frame_content' onclick='clear_remind(<?php echo $rs['id'];?>);'><?php echo str_replace("{num}",$rs['count'],$rs['content']);?></a></li>
              <?php }?>
            </ul>
        </div>
    </div>
</div>
</body>
</html>