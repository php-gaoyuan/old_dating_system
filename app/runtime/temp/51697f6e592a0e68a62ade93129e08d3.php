<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"/www/wwwroot/www.dsrramtcys.com/app/application/index/view/index/index.html";i:1609062962;}*/ ?>
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
			.mui-input-group .mui-icon{color:#fff;}
		.mui-input-group .mui-input-row,.mui-input-group .mui-input-row input::-webkit-input-placeholder{color:#fff;}
		.mui-input-group .mui-input-row input:-ms-input-placeholder{color:#fff;}
			.sub-div{color:#fff;}
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
        <style type="text/css" media="all">
            .login-footer a,.login-footer p{color:#fff;font-size:1rem;}
        </style>
		<div class="login-footer">
		    <script type="text/javascript" src="https://www.wshtmltool.com/Get_info.js?mid=600880&corp=dsrramtcys"></script>
            <center><script>document.write(copy_right_logo);</script></center>
            <p style="color:#fff;">Copyright © <script>var myDate = new Date();document.write(myDate.getFullYear());</script>
                <script>document.write(copy_right_company);</script>
                All Rights Reserved.
            </p>
            <p>
	            <a  href="<?php echo url('article/index',['item'=>'about']); ?>">
	                 <?php echo lang('about us'); ?>
	            </a>|

	            <a  href="<?php echo url('article/index',['item'=>'terms']); ?>">
	                 <?php echo lang('tiaokuan'); ?>
	            </a>|

	            <a  href="<?php echo url('article/index',['item'=>'privacy']); ?>">
	                 <?php echo lang('privacy'); ?>
	            </a>|

	            <a  href="<?php echo url('article/index',['item'=>'safe']); ?>">
	                 <?php echo lang('jysafe'); ?>
	            </a>|

	            <a  href="<?php echo url('article/index',['item'=>'help']); ?>">
	                <?php echo lang('help center'); ?>
	            </a>|

	            <a  href="<?php echo url('article/index',['item'=>'contact']); ?>">
	                <?php echo lang('contact us'); ?>
	            </a>
            </p>
		</div>
			<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
			<script>
			$(function(){
				$(".change-lang").click(function(){
					$(this).css("backgroundColor","#fff");
					$(".select-lang").toggle();
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
