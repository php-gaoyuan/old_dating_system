<?php

/*

 * 注意：此文件由tpl_engine编译型模板引擎编译生成。

 * 如果您的模板要进行修改，请修改 templates/default/modules/users/user_ico.html

 * 如果您的模型要进行修改，请修改 models/modules/users/user_ico.php

 *

 * 修改完成之后需要您进入后台重新编译，才会重新生成。

 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。

 * 如果您正式运行此程序时，请切换到service模式运行！

 *

 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。

 */

?><?php 

	/*引入模块公共方法文件*/

	require("foundation/module_album.php");

	require("api/base_support.php");

	

	/*语言包引入*/

	$u_langpackage=new userslp;

	

	/*变量获得*/

	$user_id =get_sess_userid();

	$album_id=intval(get_argg('album_id'));

	$uinfo=$dbo->getRow("select user_ico,user_name,user_sex from wy_users where user_id='$user_id'");
	
	$album_rs = api_proxy("album_self_by_uid","album_id,album_name",$user_id);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title></title>

<base href='<?php echo $siteDomain;?>' />

<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">

<SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>
<script charset="utf-8" src="skin/default/jooyea/jquery-1.9.1.min.js"></script>
<script>var jq=jQuery.noConflict();</script>
</head>

<body id="iframecontent">

<h2 class="app_user"><?php echo $u_langpackage->u_icon;?></h2>

<div class="tabs">

	<ul class="menu">

        <li><a href="modules.php?app=user_info" title="<?php echo $u_langpackage->u_info;?>"><?php echo $u_langpackage->u_info;?></a></li>

        <li class="active"><a href="modules.php?app=user_ico" title="<?php echo $u_langpackage->u_icon;?>"><?php echo $u_langpackage->u_icon;?></a></li>

        <li><a href="modules.php?app=user_pw_change" title="<?php echo $u_langpackage->u_pw;?>"><?php echo $u_langpackage->u_pw;?></a></li>

        <li><a href="modules.php?app=user_dressup" title="<?php echo $u_langpackage->u_dressup;?>"><?php echo $u_langpackage->u_dressup;?></a></li>

        <li><a href="modules.php?app=user_affair" title="<?php echo $u_langpackage->u_set_affair;?>"><?php echo $u_langpackage->u_set_affair;?></a></li>

    </ul>

</div>

	<div class="rs_head"><?php echo $u_langpackage->u_set_ico;?></div>
	<table class='form_table' cellpadding="0" cellspacing="0">
		<tr>
			<th valign="top"><?php echo $u_langpackage->u_ico_now;?>：</th>
			<td><img style='border:1px solid #ccc;' width="70" class="photo_frame" src="<?php if($uinfo['user_ico']){echo $uinfo['user_ico'];}else{echo '/skin/default/jooyea/images/d_ico_'.$uinfo[user_sex].'.gif';}?>"></td>
		</tr>
	</table>
<div class="rs_head">

<script type="text/javascript">
   function uploadevent(status,picUrl,callbackdata){
	/* alert(picUrl); */
	/*alert(callbackdata);*/
	
     status += '';
     switch(status){
     case '1':
		var time = new Date().getTime();
		var filename162 = picUrl+'_162.jpg';
		/*var filename48 = picUrl+'_48.jpg';*/
		/*写入表单并提交*/
		jq.post("do.php?act=up_user_ico",{user_ico:filename162},function(c){
			if(c==1){
				window.location.href='modules.php?app=user_ico';
			}
		})
		
	break;
     case '-1':
	  window.location.reload();
     break;
     default:
     window.location.reload();
    } 
   }
  </script>

<div id="altContent">

<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0"
WIDTH="650" HEIGHT="450" id="myMovieName">
<PARAM NAME=movie VALUE="avatar.swf">
<PARAM NAME=quality VALUE=high>
<PARAM NAME=bgcolor VALUE=#FFFFFF>
<param name="flashvars" value="imgUrl=./default.jpg&uploadUrl=./upfile.php&uploadSrc=false" />
<EMBED src="avatar.swf" quality=high bgcolor=#FFFFFF WIDTH="650" HEIGHT="450" wmode="transparent" flashVars="imgUrl=./default.jpg&uploadUrl=./upfile.php&uploadSrc=false"
NAME="myMovieName" ALIGN="" TYPE="application/x-shockwave-flash" allowScriptAccess="always"
PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer">
</EMBED>
</OBJECT>
 

  </div>
</div>
	

	



<script>


    // 计算页面的实际高度，iframe自适应会用到
    function calcPageHeight(doc) {
        var cHeight = Math.max(doc.body.clientHeight, doc.documentElement.clientHeight)
        var sHeight = Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight)
        var height  = Math.max(cHeight, sHeight)
        return height
    }
    window.onload = function() {
        var height = calcPageHeight(document);
        parent.document.getElementById('ifr').style.height = height +50+ 'px'   ;
		
		  
    }

</script>
</body>

</html>