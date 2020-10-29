<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/uiparts/guestheader.html
 * 如果您的模型要进行修改，请修改 models/uiparts/guestheader.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
require("foundation/fdnurl_aget.php");
if($_SERVER['HTTP_HOST']=='www.loveybible.com' || $_SERVER['HTTP_HOST']=='loveybible.com'||$_SERVER['HTTP_HOST']=='pauzzz.com'){
	echo "<script>window.location.href='http://www.pauzzz.com'</script>";
}
//语言包引入
$l_langpackage=new loginlp;
$re_langpackage=new reglp;
$pu_langpackage=new publiclp;
$u_langpackage=new userslp;
$ah_langpackage=new arrayhomelp;
?>
<script language="javascript">
function addBookMark()
{
    var nome_sito = "<?php echo $siteName;?>";
    var url_sito = "<?php echo get_site_domain();?>";
    if ((navigator.appName == "Microsoft Internet Explorer") && (parseInt
        (navigator.appVersion) >= 4))
        window.external.AddFavorite(url_sito, nome_sito);
    else if (navigator.appName == "Netscape")
        window.sidebar.addPanel(nome_sito, url_sito, '');
    else
        parent.Dialog.alert("<?php echo $pu_langpackage->pu_house_wrong;?>");
}

function setMyHomepage(url){   //  设置首页 
		 if(!!(window.attachEvent && !window.opera)){
				document.body.style.behavior = 'url(#default#homepage)';
				document.body.setHomePage(url);
		}else{
			if(window.clipboardData && clipboardData.setData){
		        clipboardData.setData('text', url);
		    }else{
		         parent.Dialog.alert('<?php echo $ah_langpackage->ah_browser_clipboard;?>');
		    }
		}
}
	
</script>
<script language="javascript">


function getEnts(){
	return false;
		var theEvent = window.event || e;
		var code = theEvent.keyCode || theEvent.which;
		if(code == 13){
			login();
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
function login(){
	u_email=$('login_email').value;
	u_pws=$('login_pws').value;
	u_hidden=0;
	if($('hidden').checked){
		u_hidden=1;
	}
	var ajax_login=new Ajax();
	ajax_login.getInfo("do.php?act=login","post","app","u_email="+u_email+"&u_pws="+u_pws+"&hidden="+u_hidden,function(c){
		login_callback(c);
		
	},function(){
		
		login_unready_callback();}
	);
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
		if(return_array[0] == '' || return_array[0]==1){
			top.location.href="main.php";
		}
		if($(return_array[0])){
			$(return_array[0]).innerHTML = return_array[1];
			if($('login_email').value=='<?php echo $u_langpackage->l_input_email;?>'){
				$('login_email').style.background='#ED6464';
			}
			
			if(return_array[1]=='<?php echo $l_langpackage->l_not_check;?>' || return_array[1]=='<?php echo $l_langpackage->l_lock_u;?>'){
				$('login_email').style.background='#ED6464';
			}
			
			if(return_array[1]=='<?php echo $l_langpackage->l_empty_pass;?>' || return_array[1]=='<?php echo $l_langpackage->l_wrong_pass;?>'){
				$('login_pws').style.background='#ED6464';
			}
		}else if(return_array[0]=='active'){
			//alert(3)
			window.location.href="modules.php?app=user_activation";
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

//取得cookie值
//$('login_email').value=get_cookie('iweb_email');
function get_cookie(cookie_value){
	var	aCookie=document.cookie.split(";");
	for(var i=0;i < aCookie.length;i++){
		var aCrumb=aCookie[i].split("=");
		if(cookie_value==aCrumb[0])
			return unescape(aCrumb[1]);
	}
	return '';
}
</script>
<style>
.main_schbox{width:960px;border:none;float:none;}
.main_schbox span{color:#fff}

.main_schbox .input , .main_schbox .pwd{border:1px solid #000;text-align:center;width:150px;height:23px;line-height:23px;}
</style>

<?php if(basename($_SERVER['SCRIPT_FILENAME'])!='home2.0.php'){?>
<div class="head_w" id="head_navs" style="margin:0;height:70px;background:#b20000;z-index:1000;-webkit-box-shadow: 0px 1px 3px;-moz-box-shadow: 0px 1px 3px;box-shadow: 0px 1px 3px;top:0">
		<div class="search" id="main_search" style="position:relative;">
			<div class="snslogo" style="margin:0">
				<a href="index.php"><img src="skin/<?php echo $skinUrl;?>/images/snslogo.png"/></a>
				
				<div class="lan_ss" style="background:url(skin/default/jooyea/images/lan/<?php if($langPackagePara){echo $langPackagePara;}else{echo 'en';}?>.png) no-repeat;" onclick="if(document.getElementById('lan_bb').style.display=='none'){document.getElementById('lan_bb').style.display='block'}else{document.getElementById('lan_bb').style.display='none'}"></div>
				<div class="lan_ll" onclick="if(document.getElementById('lan_bb').style.display=='none'){document.getElementById('lan_bb').style.display='block'}else{document.getElementById('lan_bb').style.display='none'}"><?php if($langPackagePara=='zh'){echo '切换语言';}elseif($langPackagePara=='fanti'){echo '切換語言';}elseif($langPackagePara=='en'){echo 'Language';}elseif($langPackagePara=='han'){echo '전환 언어';}elseif($langPackagePara=='e'){echo 'язык';}elseif($langPackagePara=='xi'){echo 'Idioma';}elseif($langPackagePara=='de'){echo 'Sprache';}elseif($langPackagePara=='ri'){echo '言語';}else{echo 'Language';}?></div>
				<div id="lan_bb" style="left:324px;padding:2px;z-ndex:10;display:none">
					<img style="<?php if($langPackagePara=='zh'){echo 'display:none';}?>" src="skin/default/jooyea/images/lan/zh.png" title="<?php if($langPackagePara=='en'){echo 'Chinese'; }else{ echo '简体中文'; }?>" onclick="setCookie('lp_name','zh');"/>
					<img style="<?php if($langPackagePara=='fanti'){echo 'display:none';}?>" src="skin/default/jooyea/images/lan/fanti.png" title="繁體中文" onclick="setCookie('lp_name','fanti');"/>
					<img style="<?php if($langPackagePara=='en'){echo 'display:none';}?>" src="skin/default/jooyea/images/lan/en.png" title="English" onclick="setCookie('lp_name','en');"/>
					<img style="<?php if($langPackagePara=='han'){echo 'display:none';}?>" src="skin/default/jooyea/images/lan/han.png" title="한국어" onclick="setCookie('lp_name','han');"/>
					<img style="<?php if($langPackagePara=='e'){echo 'display:none';}?>" src="skin/default/jooyea/images/lan/e.png" title="русский" onclick="setCookie('lp_name','e');"/>
					<img style="<?php if($langPackagePara=='xi'){echo 'display:none';}?>" src="skin/default/jooyea/images/lan/xi.png" title="Español" onclick="setCookie('lp_name','xi');"/>
					<img style="<?php if($langPackagePara=='de'){echo 'display:none';}?>" src="skin/default/jooyea/images/lan/de.png" title="Deutsch" onclick="setCookie('lp_name','de');"/>
					<img style="<?php if($langPackagePara=='ri'){echo 'display:none';}?>" src="skin/default/jooyea/images/lan/ri.png" title="日本語" onclick="setCookie('lp_name','ri');"/>
				</div>
			</div>
			
			<div class="schbox main_schbox " style="position:absolute;top:5px;right:0;z-index:9;width:560px">
				<form action="" method="post" onsubmit="return false;">
				
				<span>
					<input class="input" onKeyDown="getEnts();" name="login_email" id="login_email" value="<?php echo $u_langpackage->l_input_email;?>" type="text" onfocus="if(this.value=='<?php echo $u_langpackage->l_input_email;?>'){this.value=''};this.style.background='#fff';" onblur="if(this.value==''){this.value='<?php echo $u_langpackage->l_input_email;?>'}" />
					<input class="pwd" onKeyDown="getEnts();" name="login_pws" id="login_pws" type="password" onfocus="this.style.background='#fff';" />
					<input type="submit" onclick="login();" class="button"  name="loginsubm" id="loginsubm" hidefocus="true" value="<?php echo $l_langpackage->l_login;?>">
				</span>
				</form>
			</div>
			<div class="label" style="color:#fff;position:absolute;top:28px;right:180px;color:#B5CAEA">
				<label for="tmpiId" style="margin-right:15px;"><input name="tmpiId" class="chk" id="tmpiId" type="checkbox" value="save" onKeyDown="getEnts();" style="position:relative;top:2px"/><?php echo $u_langpackage->l_save_aco;?></label>
				<input name="hidden" class="chk" id="hidden" type="hidden" value="1" onKeyDown="getEnts();">
				<span><a href="modules.php?app=user_forget" class="forget" style='color:#B5CAEA'><?php echo $ah_langpackage->ah_forgot_password;?>?</a></span>
				
			</div>
			<span style="color:#fff;position:absolute;top:-10px;right:100px">
				<span id="loadingmsg"></span>
				<span id="emailmsg"></span>
				<span id="pwdmsg"> </span>
			</span>	
		</div>
	
</div>
	
<div class="clear"></div>
<?php }?>

<!--插件位置!-->
