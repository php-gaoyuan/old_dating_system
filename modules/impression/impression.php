<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/impression/impression.html
 * 如果您的模型要进行修改，请修改 models/modules/impression/impression.php
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
if(filemtime("templates/default/modules/impression/impression.html") > filemtime(__file__) || (file_exists("models/modules/impression/impression.php") && filemtime("models/modules/impression/impression.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/impression/impression.html",1);
	include(__file__);
}else {
/* debug模式运行生成代码 结束 */
?><?php
	//引入模块公共权限过程文件
	require("foundation/fpages_bar.php");
	require("api/base_support.php");
	
	//引入语言包
	$m_langpackage=new msglp;
	$im_langpackage=new impressionlp;
	
	//变量获得
	$user_id=get_sess_userid();
	
	//数据表定义区
	$t_impression=$tablePreStr."impression";
    $t_users=$tablePreStr."users";
    $host_id=intval(get_argg('user_id'));
    $user_info=api_proxy("user_self_by_uid","user_ico",$host_id);
    //print_r($user_info);exit;
	$dbo=new dbex;
	//读写分离定义方法
	dbtarget('r',$dbServs);
    
    $sql="select content from $t_impression  where to_user_id=$host_id";
    
    $impression_list=$dbo->getRs($sql);
    
    
	
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
    <div class="create_button"></div>
    <h2 class="app_msgscrip"><?php echo $im_langpackage->im_mypression;?></h2>

<table class="msg_inbox">


        <tr>
            <td width="70" style="padding:15px 0 0 0;"><div class="avatar"><img src='<?php echo $user_info["user_ico"];?>'/></div></td>
            <td width="350">
            <?php if(empty($impression_list)){?>
            	<?php echo $im_langpackage->im_nomypression;?>
            <?php }?>
            <?php foreach($impression_list as $val){?>
            <?php echo $val["content"];?>　　
            <?php }?>
            </td>
		</tr>

</table>




</body>
</html>
<?php } ?>