<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/bottle/rpshow.html
 * 如果您的模型要进行修改，请修改 models/modules/bottle/rpshow.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
/*
 * 此段代码由debug模式下生成运行，请勿改动！
 * 如果debug模式下出错不能再次自动编译时，请进入后台手动编译！
 */
/* debug模式运行生成代码 开始 */
if(!function_exists("tpl_engine")) {
	require("foundation/ftpl_compile.php");
}
if(filemtime("templates/default/modules/bottle/rpshow.html") > filemtime(__file__) || (file_exists("models/modules/bottle/rpshow.php") && filemtime("models/modules/bottle/rpshow.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/bottle/rpshow.html",1);
	include(__file__);
}else {
/* debug模式运行生成代码 结束 */
?><?php
	//引入模块公共权限过程文件
	require("foundation/fpages_bar.php");
	require("api/base_support.php");
	
	//引入语言包
	$m_langpackage=new msglp;
	$b_langpackage=new bottlelp;
	
	//变量获得
	$user_id=get_sess_userid();
	$bott_id=trim(get_argg('id'));
	
	//当前页面参数
	$page_num=trim(get_argg('page'));
	
	print_r($page_num);

	//数据表定义区
	$t_bottle=$tablePreStr."bottle";

	$dbo=new dbex;
	//读写分离定义方法
	dbtarget('r',$dbServs);
	
	$oneBottle=$dbo->getRow("select * from $t_bottle where (to_user_id=$user_id or from_user_id=$user_id) and bott_id=$bott_id");
	
	//获取主题id下的所有漂流瓶
	$sql="select * from $t_bottle where (to_user_id=$user_id or from_user_id=$user_id) and bott_reid=$bott_id";
	
	$dbo->exeUpdate("update $t_bottle set readed=1 where bott_id=$bott_id and bott_reid=0");
	$dbo->setPages(10,$page_num);
	
	$bottle_re_list=$dbo->getRs($sql);
	
	if($page_num==''){
		array_unshift($bottle_re_list,$oneBottle);
	}
	
	$page_total=$dbo->totalPage;
		
	
	$isNull=0;
	$content_data_none="content_none";
	$show_data="";
	if(empty($bottle_re_list)){
		$isNull=1;
		$show_data="content_none";
		$content_data_none="";
	}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
<script language=JavaScript src="skin/default/js/jooyea.js"></script>
<script type='text/javascript'>
	function check_form(){
		var mail_array=document.getElementsByName('attach[]');
		var num=mail_array.length;
		var check_num=0;
		for(array_length=0;array_length<num;array_length++){
			if(mail_array[array_length].checked==true){
				check_num++;
			}
		}
		if(check_num==0){
			parent.Dialog.alert('<?php echo $m_langpackage->m_none_wrong;?>');
		}else{
			parent.Dialog.confirm('<?php echo $m_langpackage->m_del_ask;?>',function(){document.forms[0].submit();});
		}
	}
	function select_item(type_value){
		var mail_array=document.getElementsByName('attach[]');
		var num=mail_array.length;
		for(array_length=0;array_length<num;array_length++){
				if(document.getElementById('state_'+array_length).value==type_value){
					mail_array[array_length].checked='checked';
				}else{
					mail_array[array_length].checked='';
				}
		}
	}
</script>

</head>
<body id="iframecontent">
    <div class="create_button"><a href="modules.php?app=bott_reply&reid=<?php echo $bott_id;?>"><?php echo $b_langpackage->b_reply;?></a><a href="modules.php?app=bott_in"><?php echo $b_langpackage->b_back;?></a></div>
    <h2 class="app_msgscrip"><?php echo $b_langpackage->b_bottle;?></h2>

<form action='do.php?act=bott_del&t=0' method='post' onsubmit='check_form()'>

<table class="msg_inbox <?php echo $show_data;?>">
<?php foreach($bottle_re_list as $key => $val){?>
        <tr>
            <td width="70" style="padding:15px 0 0 0;"><div class="avatar"><a target="_blank" href='home2.0.php?h=<?php echo $val['from_user_id'];?>'><img src='<?php echo $val["from_user_ico"];?>' /></a></div></td>
            <td width="350">
            	<?php echo $val["bott_content"];?>
            </td>
            <td width=""><label class="gray"><?php echo $val["addtime"];?></label><br/><a href='do.php?act=bott_del&id=<?php echo $val["bott_id"];?>&t=0' onclick='return confirm("<?php echo $m_langpackage->m_del_ask;?>");'><img title="<?php echo $m_langpackage->m_del;?>" src="skin/<?php echo $skinUrl;?>/images/del.png" /></a></td>
		</tr>
<?php }?>
</table>

</form>
<?php echo page_show($isNull,$page_num,$page_total);?>
<div class="guide_info <?php echo $content_data_none;?>">
	<?php echo $m_langpackage->m_in_none;?>
</div>

</body>
</html>
<?php } ?>