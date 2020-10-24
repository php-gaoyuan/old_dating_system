<?php

/*

 * 注意：此文件由tpl_engine编译型模板引擎编译生成。

 * 如果您的模板要进行修改，请修改 templates/default/modules/default2.html

 * 如果您的模型要进行修改，请修改 models/modules/default2.php

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

if(filemtime("templates/default/modules/default2.html") > filemtime(__file__) || (file_exists("models/modules/default2.php") && filemtime("models/modules/default2.php") > filemtime(__file__)) ) {

	tpl_engine("default","modules/default2.html",1);

	include(__file__);

}else {

/* debug模式运行生成代码 结束 */

?><?php

//�������԰�

$ah_langpackage=new arrayhomelp;



//���԰�����

$pu_langpackage=new publiclp;

$u_langpackage=new userslp;

$l_langpackage=new loginlp;



//�������԰�

$reg_langpackage=new reglp;

?><script src="skin/default/js/login.js" language="javascript"></script>

<script language="javascript" src="servtools/ajax_client/ajax.js"></script>

<script language="javascript" src="skin/default/js/jooyea.js"></script>

<script type="text/javascript" language="javascript" src="servtools/dialog/zDialog.js"></script>

<script type="text/javascript" language="javascript" src="servtools/dialog/zDrag.js"></script>

<script language="javascript">

function ser_item(){

	var diag = new Dialog();

	diag.Top="50%";

	diag.Left="50%";

	diag.Title = "用户协议";

	diag.InnerHtml= '<div style="text-align:left"><?php echo $regInfo;?></div>';

	diag.OKEvent = function(){diag.close();};

	diag.show();

}



function goLogin(){

	Dialog.confirm("<?php echo $pu_langpackage->pu_login;?>",function(){top.location="<?php echo $indexFile;?>";});

}



function getVerCode(){

	var rand_value=Math.random();

  $("verCodePic").src="servtools/veriCodes.php?vc="+rand_value;

}



function ajax_check(obj,type_id){

	if(type_id=='email'){

		div_value='user_email_message';

		suc_str='<?php echo $u_langpackage->u_reg_email_available;?>';

	}

	else if(type_id=='user_name')

	{

		div_value='user_name_message';

		suc_str='<?php echo $u_langpackage->u_reg_username_available;?>';

	}

	else{

		div_value='user_veriCode_message';

		suc_str='<?php echo $u_langpackage->u_reg_code_correct;?>';

	}

	var check=new Ajax();

	check.getInfo("do.php","get","app","act=reg&ajax=1&"+$(obj).id+"="+$(obj).value,function(c){if(c){refuse_submit(type_id,c);}else{pass_submit(type_id,suc_str);}});

}



function refuse_submit(type_id,c){

	if(type_id=='email'){

		user_email_message.style.color = 'red';

		user_email_message.innerHTML = c;

		user_email_status = false;

	}

	else if(type_id=='user_name')

	{

		user_name_message.style.color = 'red';

		user_name_message.innerHTML = c;

		user_name_status = false;

	}

	else{

		veriCode_message.style.color = 'red';

		veriCode_message.innerHTML = c;

		user_veriCode_status = false;

	}

}



function pass_submit(type_id,c){

	if(type_id=='email'){

		user_email_message.style.color = 'green';

		user_email_message.innerHTML = c;

		user_email_status = true;

	}

	else if(type_id=='user_name')

	{

		user_name_message.style.color = 'green';

		user_name_message.innerHTML = c;

		user_name_status = true;

	}

	else{

		veriCode_message.style.color = 'green';

		veriCode_message.innerHTML = c;

		user_veriCode_status = true;

	}

}

</script>

<!--left-->

<div class="main_03">

	<div style="width:502px; height:70px;"></div>

	<table width="502" border="0" cellspacing="0" cellpadding="0">

	<?php $i=1;foreach($user_rs as $val){?>

	<?php if($i%7==1){?>

	<tr>

	<?php }?>

	<td width="70" height="72"><?php if(empty($val['user_ico'])){?>&nbsp;<?php }?><?php if(!empty($val['user_ico'])){?><img src="<?php echo $val['user_ico'];?>" alt="<?php echo $val['user_name'];?>" width="72" height="72" /><?php }?></td>

	  <?php if($i%7==0){?>

	  </tr>

	  <?php }?>

	  <?php $i++;}?>

	</table>

</div>

<!--left end-->

<!--right-->

<div class="main_04">

<form name="login_form" method="post" onsubmit="return login();">

	<table width="380" border="0" cellspacing="0" cellpadding="0">

			  <tr>

				<td width="76" height="25" align="right" class="font_01"><?php echo $l_langpackage->l_email;?>：</td>

			    <td width="176"><input name="login_email" id="login_email" type="text" style="width:180px; height:20px; color:#666666; padding:0px; margin:0px;" /></td>

			    <td width="128" rowspan="2" style="padding-left:5px;"><input type='image' src="skin/<?php echo $skinUrl;?>/images/xin/denglu.jpg" width="72" height="55"/></td>

			  </tr>

			  <tr>

			    <td height="25" align="right" class="font_01"><?php echo $l_langpackage->l_pass;?>：</td>

			    <td><input name="login_pws" id="login_pws" type="password" style="width:180px; height:20px; color:#666666; padding:0px; margin:0px;"/></td>

		      </tr>

			</table>

			<table width="380" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td width="39" height="30" align="right">&nbsp;</td>

                <td width="107" class="font_02"><input name="hidden" id="hidden" type="checkbox" value="1" onKeyDown="getEnt();" style="display:none;" /><input name="tmpiId" id="tmpiId" type="checkbox" value="save" checked="checked" onKeyDown="getEnt();" /><?php echo $l_langpackage->l_save_aco;?></td>

                <td width="149" class="font_02"><a href="modules2.0.php?app=user_forget" class="link_02"><?php echo $ah_langpackage->ah_forgot_password;?>？</a></td>

              </tr>

              <tr>

                <td height="22" colspan="3" align="center" class="font_03"><span id="loadingmsg"></span><span id="emailmsg"></span><span id="pwdmsg"></span></td>

              </tr>

            </table>

</form>

<form action="javascript:void(0);" id="reg_form" name="reg_form" method="post" onSubmit="return checkForm();">

<input type='hidden' name='invite_code' value='<?php echo $invite_code;?>' />

<input type='hidden' name='uid' value="<?php echo get_argg('uid');?>" />

<input type='hidden' name='tuid' value="<?php echo get_argg('tuid');?>" />

<input type='hidden' name='veriCode' value='best' />

		<table width="380" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td height="70">&nbsp;</td>

              </tr>

        </table>

	  <table width="380" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td width="77" height="30" align="right" class="font_01"><?php echo $u_langpackage->u_uname;?>：</td> 

            <td width="155"><input type="text" name="user_name" id="user_name" style="width:150px; height:20px; color:#666666; padding:0px; margin:0px;" value="" /></td>

            <td width="148" class="font_03" id="user_name_message"></td>

          </tr>

          <tr>

            <td height="30" align="right" class="font_01"><?php echo $u_langpackage->u_reg_password;?>：</td>

            <td><input type="password" id="user_password" name="user_password" style="width:150px; height:20px; color:#666666; padding:0px; margin:0px;" value="" /></td>

            <td class="font_03" id="user_password_message"></td>



          </tr>

          <tr>

            <td height="30" align="right" class="font_01"><?php echo $u_langpackage->u_reg_repassword;?>：</td>

            <td><input type="password" name="user_repassword" id="user_repassword" style="width:150px; height:20px; color:#666666; padding:0px; margin:0px;" value="" /></td>

            <td class="font_03" id="user_repassword_message"></td>

          </tr>

          <tr>

            <td height="30" align="right" class="font_01"><?php echo $u_langpackage->u_reg_mailbox;?>：</td>

            <td><input name="user_email" id="user_email" type="text" style="width:150px; height:20px; color:#666666; padding:0px; margin:0px;" value="" /></td>

            <td class="font_03" id="user_email_message"></td>

          </tr>

          <tr>

            <td height="30" align="right" class="font_01"><?php echo $u_langpackage->u_reg_sex;?>：</td>

            <td>

				<input type='radio' value='1' style="vertical-align:middle" name='user_sex' checked=checked /><font color="#797979"><?php echo $u_langpackage->u_man;?></font>

                <input type='radio' value='0' style="vertical-align:middle" name='user_sex' /><font color="#797979"><?php echo $u_langpackage->u_wen;?></font>

			</td>

            <td class="font_03" id="user_repassword_message"></td>

          </tr>

        </table>

	  <table width="380" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">

        <tr>

          <td width="165" height="27" align="right"><input type="submit" name="button" id="button" style="background-image:url(/skin/<?php echo $skinUrl;?>/images/xin/ind_03.jpg);width:86px;height:27px;border:0px;font-weight:bold;color:#FFF;cursor:pointer;" value="<?php echo $u_langpackage->u_goregit;?>" /></td>

          <td width="10">&nbsp;</td>

          <td width="205"><input type="reset" name="button" id="button" style="background-image:url(/skin/<?php echo $skinUrl;?>/images/xin/ind_03.jpg);width:86px;height:27px;border:0px;font-weight:bold;color:#FFF;cursor:pointer;" value="<?php echo $u_langpackage->u_gorests;?>" /></td>

        </tr>

      </table>

</form>

</div>

<!--right end-->

<script language="javascript">

function goLogin(){

	Dialog.confirm("<?php echo $pu_langpackage->pu_login;?>",function(){top.location="<?php echo $indexFile;?>";});

}

function getEnt(){

	document.onkeydown = function (e){

		var theEvent = window.event || e;

		var code = theEvent.keyCode || theEvent.which;

		if(code == 13){

			  login();

		}

	}

}

function inputTxt(obj,act)

{

  var str="<?php echo $ah_langpackage->ah_enter_name;?>";

  if(obj.value==''&&act=='set')

  {

     obj.value=str;

     obj.style.color='#cccccc';

  }

  if(obj.value==str&&act=='clean')

  {

     obj.value='';

     obj.style.color='gray';

  }

}

//ajax

function login_callback(content)

{

	var check=/\.php/;

	if(check.test(content)){

		 if($("tmpiId").checked){

			saveTmpEmail(1);

		 }else{

			  saveTmpEmail(0);

		 }

		 window.location.href=content;

	}else{

		$("emailmsg").innerHTML = '';

		$("pwdmsg").innerHTML = '';

		$("loadingmsg").innerHTML = '';

		var return_array=content.split("|");

		if($(return_array[0])){

			$(return_array[0]).innerHTML = return_array[1];

		}else if(return_array[0]=='active'){

			window.location.href="modules2.0.php?app=user_activation";

		}

	}

}

function login_unready_callback(){

	var argb_div = $("loadingmsg");

	if($("emailmsg").innerHTML == '' || $("pwdmsg").innerHTML == ''){

		argb_div.innerHTML='';

	}else{

		argb_div.innerHTML="<img src='skin/<?php echo $skinUrl;?>/images/login_loading.gif' align='top' ><?php echo $l_langpackage->l_loading;?>";

	}

}

function saveTmpEmail(para){

	var email_time=new Date();

	var login_time=new Date();

	email_time.setTime(email_time.getTime() +3600*1000*24*300 );

	login_time.setTime(login_time.getTime() +3600*250 );

	if(para==1){

		var uemailStr=$("login_email").value;

		document.cookie='iweb_email='+uemailStr+';expires='+ email_time.toGMTString();

	}

	document.cookie="IsReged=Y;expires="+ login_time.toGMTString();

}

function login(){

	u_email=$('login_email').value;

	u_pws=$('login_pws').value;

	u_hidden=0;

	if($('hidden').checked){

		u_hidden=1;

	}

	var ajax_login=new Ajax();

	ajax_login.getInfo("do.php?act=login","post","app","u_email="+u_email+"&u_pws="+u_pws+"&hidden="+u_hidden,function(c){login_callback(c);},function(){login_unready_callback();});

	return false;

}

//取得cookie值

$('login_email').value=get_cookie('iweb_email');

</script>

<script language="JavaScript">

// 检测会员用户名

var user_name = document.getElementsByName('user_name')[0];

var user_name_message = $('user_name_message');

var user_name_status = false;

var user_name_reg = /^[A-Za-z0-9]+$/;	//用正则表达式/[\u4E00-\u9FA5]/表示中文

user_name.onblur = function(){

	var user_name_size=check_code_size(user_name.value);

	if(user_name.value=='') {

		user_name_message.style.color = 'red';

		user_name_message.innerHTML = '* <?php echo $u_langpackage->u_reg_fill_username;?>';

		user_name_status = false;

	}else if(user_name_size < 4 || user_name_size > 14) {

		user_name_message.style.color = 'red';

		user_name_message.innerHTML = '* <?php echo $u_langpackage->u_reg_username_format_error;?>';

		user_name_status = false;

	} else if(!user_name_reg.test(user_name.value)){

		user_name_message.style.color = 'red';

		user_name_message.innerHTML = '*<?php echo $u_langpackage->u_special_characters_disable;?>';

		user_name_status = false;

	}else {

		ajax_check(user_name,'user_name');

	}

};



// 检测邮箱

var user_email = document.getElementsByName('user_email')[0];

var user_email_message = $('user_email_message');

var user_email_status = false;

var user_email_reg = /^[0-9a-zA-Z_\-\.]+@[0-9a-zA-Z_\-]+(\.[0-9a-zA-Z_\-]+)*$/;

user_email.onblur = function(){

	if(user_email.value=='') {

		user_email_message.style.color = 'red';

		user_email_message.innerHTML = '* <?php echo $u_langpackage->u_reg_fill_email;?>';

		user_email_status = false;

	} else if(!user_email.value.match(user_email_reg)) {

		user_email_message.style.color = 'red';

		user_email_message.innerHTML = '* <?php echo $u_langpackage->u_reg_email_format_error;?>';

		user_email_status = false;

	} else {

		ajax_check(user_email,'email');

	}

};





// 检测密码

var user_password = document.getElementsByName('user_password')[0];

var user_password_message = $('user_password_message');

var user_password_status = false;

user_password.onblur = function(){

	if(user_password.value=='') {

		user_password_message.style.color = 'red';

		user_password_message.innerHTML = '* <?php echo $u_langpackage->u_reg_fill_password;?>';

		user_password_status = false;

	} else if(user_password.value.length<6 || user_password.value.length>16) {

		user_password_message.style.color = 'red';

		user_password_message.innerHTML = '* <?php echo $u_langpackage->u_reg_password_format_error;?>';

		user_password_status = false;

	} else {

		user_password_message.style.color = 'green';

		user_password_message.innerHTML = '<?php echo $u_langpackage->u_reg_password_format_correct;?>';

		user_password_status = true;

	}

};





// 检测确认密码

var user_repassword = document.getElementsByName('user_repassword')[0];

var user_repassword_message = $('user_repassword_message');

var user_repassword_status = false;

user_repassword.onblur = function(){

	if(user_repassword.value=='') {

		user_repassword_message.style.color = 'red';

		user_repassword_message.innerHTML = '* <?php echo $u_langpackage->u_reg_confirm_password;?>';

		user_repassword_status = false;

	} else if(user_repassword.value!=user_password.value) {

		user_repassword_message.style.color = 'red';

		user_repassword_message.innerHTML = '* <?php echo $u_langpackage->u_reg_password_inconsistent;?>';

		user_repassword_status = false;

	} else if(user_repassword.value.length<6 || user_repassword.value.length>16) {

		user_repassword_message.style.color = 'red';

		user_repassword_message.innerHTML = '* <?php echo $u_langpackage->u_reg_password_format_error;?>';

		user_repassword_status = false;

	} else {

		user_repassword_message.style.color = 'green';

		user_repassword_message.innerHTML = '<?php echo $u_langpackage->u_reg_cpassword_format_correct;?>';

		user_repassword_status = true;

	}

};



function checkForm(){

	user_name.onblur();

	user_email.onblur();

	user_password.onblur();

	user_repassword.onblur();

	if(user_name_status && user_email_status && user_password_status && user_repassword_status) {

		$("reg_form").action="do.php?act=reg";

		return true;

	} else {

		return false;

	}

}

</script><?php } ?>