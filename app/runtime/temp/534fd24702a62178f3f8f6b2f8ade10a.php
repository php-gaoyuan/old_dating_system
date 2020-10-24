<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"D:\phpstudy_pro\WWW\jyo.com\app/application/index\view\index\index.html";i:1562821237;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Login</title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link href="<?php echo config('skin_path'); ?>/css/mui.min.css" rel="stylesheet" />
		<link href="<?php echo config('skin_path'); ?>/css/login.css" rel="stylesheet" />
		<link href="<?php echo config('skin_path'); ?>/css/common.css" rel="stylesheet" />
		<style>
		.mui-input-group{background: none;}
		</style>

	</head>
	<body class="login-body">
		<div class="change-lang">
			<?php echo $lang; ?>
			<span class="mui-icon mui-icon-arrowdown"></span>
			<div class="select-lang">
				<a href="<?php echo url('index/lang',array('lang'=>'zh')); ?>"><?php echo lang("zh-cn"); ?></a>
				<a href="<?php echo url('index/lang',array('lang'=>'tw')); ?>"><?php echo lang("zh-tw"); ?></a>
				<a href="<?php echo url('index/lang',array('lang'=>'en')); ?>"><?php echo lang("en-us"); ?></a>
				<a href="<?php echo url('index/lang',array('lang'=>'kor')); ?>"><?php echo lang("kor"); ?></a>
				<a href="<?php echo url('index/lang',array('lang'=>'jp')); ?>"><?php echo lang("jp"); ?></a>
			</div>
		</div>
		<!-- <div class="logo"></div> -->
		<form class="mui-input-group">
		    <div class="mui-input-row ">
		    	<label for="">
		    		<i class="mui-icon mui-icon-contact"></i> 
		    	</label>
		    	<input type="text" class="mui-input-clear" id="username" name="username" placeholder="<?php echo lang('login_username_placeholder'); ?>">
		    </div>
		    
		    <div class="mui-input-row">
		    	<label for="">
		    		<i class="mui-icon mui-icon-locked"></i>
		    	</label>
		    	<input type="password" class="mui-input-clear" id="pass" name="pass" placeholder="<?php echo lang('login_pass_placeholder'); ?>">
		    </div>
		</form>
		<div class="sub-div">
			<div class="fl" onclick="window.location.href='<?php echo url('reg/forget_pass'); ?>'"><?php echo lang('login_forget_pass'); ?></div>
			<div class="fr" onclick="window.location.href='<?php echo url('reg/index'); ?>'"><?php echo lang('login_reg_account'); ?></div>
			<div class="cl"></div>
		</div>
		<div class="sub-div">
			<button type="button" class="mui-btn mui-btn-primary"  id="sub"><?php echo lang('login_sub_btn'); ?></button>
		</div>

		<div class="login-footer"><?php echo lang("login_footer"); ?>&copy;</div>
			<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
			<script>
			$(function(){
				$(".change-lang").click(function(){
					$(this).css("backgroundColor","#fff");
					$(".select-lang").show();
				});
			});
			</script>
			<script>
				$(function(){
					
					$("#username").blur(function(){
						logincheck();
					});
					
					$("#pass").blur(function(){
						logincheck();
					});
					
					//提交表单
					$("#sub").click(function(){
						var username = $("#username").val();
						var pass = $("#pass").val();
						var url = '<?php echo url("index/login"); ?>';
						$.post(url,{username:username,pass:pass},function(res){
							if(res.msg){
								alert(res.msg);
							}

							if(res.url){
								window.location.href=res.url;
							}
						});
						
					});


					$(".login-body").css("height",$(window).height());
				});
				
				//检查是否解除禁用的提交按钮
				function logincheck(){
					var username = $("#username").val();
					var pass = $("#pass").val();
					
					if(username != "" && pass != ""){
						$("#sub").removeAttr("disabled");
						return true;
					}else{
						//$("#sub").attr("disabled","disabled");
						return false;
					}
				}
				
				function create_url(contro,param){
					var str = config.site_url+"/index.php/"+contro;
					$.each(param,function(index,item){
						str += "/"+index+"/"+item;
					});
					return str;
				}

			</script>
	</body>
</html>
