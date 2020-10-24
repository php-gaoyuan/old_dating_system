<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/bottle/reply.html
 * 如果您的模型要进行修改，请修改 models/modules/bottle/reply.php
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
if(filemtime("templates/default/modules/bottle/reply.html") > filemtime(__file__) || (file_exists("models/modules/bottle/reply.php") && filemtime("models/modules/bottle/reply.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/bottle/reply.html",1);
	include(__file__);
}else {
/* debug模式运行生成代码 结束 */
?><?php

	
	//引入公共模块
	require("foundation/module_mypals.php");
	require("foundation/module_users.php");
	require("api/base_support.php");
	//引入语言包
	$m_langpackage=new msglp;
	$b_langpackage=new bottlelp;
	//变量获得
	$user_id=get_sess_userid();
	
	$bott_reid=trim(get_argg('reid'));
	
	//数据表定义区
	$t_bottle=$tablePreStr."bottle";

	$dbo=new dbex;
	//读写分离定义方法
	dbtarget('r',$dbServs);	
	
	if(!empty($bott_reid)){
		$oneBottle=$dbo->getRow("select * from $t_bottle where bott_id=$bott_reid and (to_user_id=$user_id or from_user_id=$user_id)");
	}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
<SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDrag.js"></script>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDialog.js"></script>
</head>
<script language="JavaScript">

function check(obj)
{
	var check=new Ajax();
	check.getInfo("do.php","get","app","act=reg&ajax=1&user_name="+obj,function(c){if(!c){Dialog.alert('<?php echo $m_langpackage->m_Dos_notex;?>');}});
}

function unitinfocheck()
{
	oldContent = document.getElementById('msContent').value;

	var newsType=trim(document.getElementById("newsType").value);
	if(document.form1.msToId.value==""&&newsType=="")
	{
		parent.Dialog.alert("<?php echo $m_langpackage->m_no_one;?>");
		return (false);
	}
	var msTitle=trim(document.getElementById("msTitle").value);
	if(msTitle==''){
		parent.Dialog.alert("<?php echo $m_langpackage->m_no_tit;?>");
		return (false);
	}
	var msContent=trim(document.getElementById("msContent").value);
	if(msContent==''){
		parent.Dialog.alert("<?php echo $m_langpackage->m_no_cont;?>");
		return (false);
	}
}

function trim(str){
	return str.replace(/(^\s*)|(\s*$)|(　*)/g , "");
}

function isMaxLen(o){
	var nMaxLen=o.getAttribute? parseInt(o.getAttribute("maxlength")):"";  
	if(o.getAttribute && o.value.length>nMaxLen){  
		o.value=o.value.substring(0,nMaxLen)  
	}
}
</script>
<body id="iframecontent">
    <div class="create_button"></div>
    <h2 class="app_msgscrip"><?php echo $b_langpackage->b_bottle;?></h2>
    <div class="tabs">
        <ul class="menu">
            <li class="active"><a href="javascript:void(0)" hidefocus="true"><?php echo $b_langpackage->b_send_bottle;?></a></li>
            <li><a href="do.php?act=bott_pick" ><?php echo $b_langpackage->b_find_one;?></a></li>
        </ul>
    </div>
    <form name="form1" method="post" action="do.php?act=bott_crt2">

	 <table class='form_table pbg'>
			<tr><td colspan="2" height="5"></td></tr>
			<tr>
				<th><?php echo $b_langpackage->b_type;?>：</th>
				<td>
					<select name="kind">
                        
						<option <?php if($king=='1'){?><?php echo 'selected="selected"';?><?php }?> value="1"><?php echo $b_langpackage->b_normal;?></option>
						<option <?php if($king=='2'){?><?php echo 'selected="selected"';?><?php }?> value="2"><?php echo $b_langpackage->b_mood;?></option>
						<option <?php if($king=='3'){?><?php echo 'selected="selected"';?><?php }?> value="3"><?php echo $b_langpackage->b_city;?></option>
						<option <?php if($king=='4'){?><?php echo 'selected="selected"';?><?php }?> value="4"><?php echo $b_langpackage->b_ask;?></option>
						<option <?php if($king=='5'){?><?php echo 'selected="selected"';?><?php }?> value="5"><?php echo $b_langpackage->b_contacts;?></option>
						<option <?php if($king=='6'){?><?php echo 'selected="selected"';?><?php }?> value="6"><?php echo $b_langpackage->b_wish;?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th><?php echo $m_langpackage->m_tit;?>：</th>
				<td><input type="text" class="med-text" name="title" id="msTitle" autocomplete='off' value="<?php if(isset($oneBottle['bott_title'])){?><?php echo '回复：'.$oneBottle['bott_title'];?><?php }?>" maxlength="30" /></td>
			</tr>
			<tr><td colspan="2" height="5"></td></tr>
			<tr>
				<th valign="top"><?php echo $m_langpackage->m_cont;?>：</th>
				 <td style="height:150px;"><textarea class="med-textarea" name="content" id="msContent" onKeyUp="return isMaxLen(this)" style="height:200px;width:95%;"></textarea></td>
			</tr>
			<tr>
				<th>&nbsp;</th>
           		 <td class="content_none">
					&nbsp;
				 </td>
				 <td>
				 	<input class="regular-btn" type="submit" value="<?php echo $b_langpackage->b_confirm;?>" style="cursor:pointer;margin-left:100px;"/>
				 	<input class="regular-btn" type="button" value="<?php echo $b_langpackage->b_back;?>" onclick="history.back();" style="cursor:pointer;margin-left:30px;"/>
				 </td>
		    </tr>
		</table>
       </form>
</body>
</html><?php } ?>