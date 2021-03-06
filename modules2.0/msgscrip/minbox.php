<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/msgscrip/minbox.html
 * 如果您的模型要进行修改，请修改 models/modules/msgscrip/minbox.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
	//引入模块公共权限过程文件
	require("foundation/fpages_bar.php");
	require("api/base_support.php");
	
	//引入语言包
	$m_langpackage=new msglp;
	
	//变量获得
	$user_id=get_sess_userid();
	
	//当前页面参数
	$page_num=trim(get_argg('page'));
	
	$dbo=new dbex();
	$msg_inbox_rs=api_proxy("scrip_inbox_get_mine","*");

	foreach($msg_inbox_rs as &$row2){
		if($row2["from_user_id"]>1){
			//查询头像
		  	$res = $dbo->getRow("select user_sex,user_ico from wy_users where user_id='{$row2['from_user_id']}'");
		  	if(empty($res["user_ico"])){
		  		$res["user_ico"] = "skin/default/jooyea/images/d_ico_".$res["user_sex"].".gif";
		  	}
		  	$row2["from_user_ico"] = $res["user_ico"];
		  	//echo "<pre>";print_r($res);exit;
		}
		  	
	}
	//echo "<pre style='text-align:left'>";
	//print_r($msg_inbox_rs);
	//echo "</pre>";
	// //信息去重
	// $cf=array();
	// foreach($msg_inbox_rs as $k=>$v){
		// $cf[]=$v['from_user_id'];
	// }
	// $cf=array_count_values($cf);
	
	// for($i=0;$i<count($msg_inbox_rs);$i++){
		// if($cf[$msg_inbox_rs[$i]['from_user_id']]>1){
			// unset($msg_inbox_rs[$i]);
		// }
	// }
	// foreach($msg_inbox_rs as $k=>$v){
		// if($v['c']>2){
			// unset($msg_inbox_rs[$k]);
		// }
	// }
	
	$isNull=0;
	$content_data_none="content_none";
	$show_data="";
	if(empty($msg_inbox_rs)){
		$isNull=1;
		$show_data="content_none";
		$content_data_none="";
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
   
    <div class="tabs" style="margin-top:0">
        <ul class="menu">
            <li class=""><a href="modules.php?app=msg_creator" title="<?php echo $m_langpackage->m_title;?>" hidefocus="true"><?php echo $m_langpackage->m_title;?></a></li>
            <li class="active"><a href="modules.php?app=msg_minbox" title="<?php echo $m_langpackage->m_in;?>" hidefocus="true"><?php echo $m_langpackage->m_in;?></a></li>
            <li><a href="modules.php?app=msg_moutbox" title="<?php echo $m_langpackage->m_out;?>" hidefocus="true"><?php echo $m_langpackage->m_out;?></a></li>
            <li><a href="modules.php?app=msg_notice" title="<?php echo $m_langpackage->m_notice;?>" hidefocus="true"><?php echo $m_langpackage->m_notice;?></a></li>
            <!--<li><a href="#" title="<?php echo $m_langpackage->m_uuchat;?>" hidefocus="true"><?php echo $m_langpackage->m_uuchat;?></a></li>
            <li><a href="#" title="<?php echo $m_langpackage->m_zixunjilu;?>" hidefocus="true"><?php echo $m_langpackage->m_zixunjilu;?></a></li>-->
        </ul>
    </div>
<form action='do2.0.php?act=msg_del&t=0' method='post' onsubmit='check_form()'>
<div class="rs_head <?php echo $show_data;?>">
	<span class="right"><?php echo str_replace("{num}",count($msg_inbox_rs),$m_langpackage->m_num_mail);?></span>
    <span><?php echo $m_langpackage->m_choose;?>
    	<a href="javascript:select_attach(1);"><?php echo $m_langpackage->m_all;?></a> -
        <a href="javascript:select_attach(0);"><?php echo $m_langpackage->m_b_can;?></a> -
        <a href="javascript:select_item(1);"><?php echo $m_langpackage->m_rd;?></a> -
        <a href="javascript:select_item(0);"><?php echo $m_langpackage->m_no_rd;?></a>
    </span>
    <span><a href="javascript:document.forms[0].onsubmit();"><?php echo $m_langpackage->m_del;?></a></span>
</div>
<table class="msg_inbox <?php echo $show_data;?>">
<?php foreach($msg_inbox_rs as $key => $val){?>
        <tr>
            <td width="25">
				<input type='hidden' id='state_<?php echo $key;?>' value='<?php echo $val["readed"];?>' />
				<input name="attach[]" type="checkbox" value="<?php echo $val["mess_id"];?>" />
			</td>
            <td width="30"><a href='modules2.0.php?app=msg_rpshow&id=<?php echo $val["mess_id"];?>&hhid=<?php echo $val['hh_id'];?>&t=0'><img title="<?php echo $val["readed"]?$m_langpackage->m_have_read:$m_langpackage->m_unread;?>" src='skin/<?php echo $skinUrl;?>/images/mesread_<?php echo $val["readed"];?>.gif' /></a></td>
            <td width="70"><div class="avatar"><a target="_blank" href='home2.0.php?h=<?php echo $val['from_user_id'];?>'><img title="<?php echo $val["from_user"];?>" src='<?php echo $val["from_user_ico"];?>' /></a></div></td>
            <td width="265"><a class="mess_tit" href='modules2.0.php?app=msg_rpshow&id=<?php echo $val["mess_id"];?>&hhid=<?php echo $val['hh_id'];?>&t=0' ><b><?php echo $val["mess_title"];?></b>
            <br/><em><?php echo strip_tags($val["enmess_content"]);?></em></a></td>
            <td><label class="gray"><?php echo $val["add_time"];?></label></td>
            <td width="20"><a href='do2.0.php?act=msg_del&id=<?php echo $val["mess_id"];?>&t=0' onclick='return confirm("<?php echo $m_langpackage->m_del_ask;?>");'><img title="<?php echo $m_langpackage->m_del;?>" src="skin/<?php echo $skinUrl;?>/images/del.png" /></a></td>
		</tr>
<?php }?>
</table>
<div class="rs_head <?php echo $show_data;?>">
	<span class="right"><?php echo str_replace("{num}",count($msg_inbox_rs),$m_langpackage->m_num_mail);?></span>
    <span><?php echo $m_langpackage->m_choose;?>
    	<a href="javascript:select_attach(1);"><?php echo $m_langpackage->m_all;?></a> -
        <a href="javascript:select_attach(0);"><?php echo $m_langpackage->m_b_can;?></a> -
        <a href="javascript:select_item(1);"><?php echo $m_langpackage->m_rd;?></a> -
        <a href="javascript:select_item(0);"><?php echo $m_langpackage->m_no_rd;?></a>
    </span>
    <span><a href="javascript:document.forms[0].onsubmit();"><?php echo $m_langpackage->m_del;?></a></span>
</div>

</form>
<?php echo page_show($isNull,$page_num,$page_total);?>
<div class="guide_info <?php echo $content_data_none;?>">
	
</div>
</body>
<script type="text/javascript">


    // 计算页面的实际高度，iframe自适应会用到
    function calcPageHeight(doc) {
        var cHeight = Math.max(doc.body.clientHeight, doc.documentElement.clientHeight)
        var sHeight = Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight)
        var height  = Math.max(cHeight, sHeight)
        return height
    }
    window.onload = function() {
        var height = calcPageHeight(document);

		
        parent.document.getElementById('ifr').style.height = height + 'px'   ;
		
		  
    }
</script>
</html>
