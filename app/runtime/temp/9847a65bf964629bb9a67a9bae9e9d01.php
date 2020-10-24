<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"/www/wwwroot/www.partyings.com/app/application/index/view/set/pass.html";i:1602502927;}*/ ?>
<!doctype html>
<html>

	<head>
		<meta charset="UTF-8">
		<title><?php echo lang("set pass"); ?></title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link href="<?php echo config('skin_path'); ?>/css/mui.min.css" rel="stylesheet" />
		<style>
			body,.mui-content{background: #fff;}
		</style>
	</head>

	<body>
		<?php if(!$is_h5_plus): ?>
		<header class="mui-bar mui-bar-nav">
		    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
		    <h1 class="mui-title"><?php echo lang("set pass"); ?></h1>
		</header>
		<?php endif; ?>
		<div class="mui-content">
			<form class="mui-input-group">
			    <div class="mui-input-row">
			        <label><?php echo lang("old pass"); ?></label>
			        <input type="text" class="mui-input-clear" placeholder="<?php echo lang("old pass"); ?>" name="old_pass">
			    </div>
			    <div class="mui-input-row">
			        <label><?php echo lang("new pass"); ?></label>
			        <input type="password" class="mui-input-clear" placeholder="<?php echo lang("new pass"); ?>" name="new_pass">
			    </div>
			    <div class="mui-input-row">
			        <label><?php echo lang("new pass2"); ?></label>
			        <input type="password" class="mui-input-clear" placeholder="<?php echo lang('new pass2'); ?>" name="new_pass_confirm">
			    </div>
			    
			</form>
			<div style="margin:15px;">
			    <button class="mui-btn mui-btn-block mui-btn-blue" id="sub"><?php echo lang('submit'); ?></button>
			</div>
		</div>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/public.js"></script>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/mui.min.js"></script>
		<script>
			$(function(){
				$("#sub").click(function(){
					var old_pass = $("input[name='old_pass']").val();
					var new_pass = $("input[name='new_pass']").val();
					var new_pass_confirm = $("input[name='new_pass_confirm']").val();
					if(old_pass == "" || new_pass == "" || new_pass_confirm == ""){
						mui.toast("<?php echo lang('no empty'); ?>");return;
					}

					if(new_pass != new_pass_confirm){
						mui.toast("<?php echo lang('error_pass2'); ?>");
						return;
					}
					var url="<?php echo url('set/pass'); ?>";
					var data = {
						old_pass:old_pass,
						new_pass:new_pass,
						new_pass_confirm:new_pass_confirm,
					};

					
					$.post(url,data,function(res){
						mui.toast(res.msg);
					},"json");
				});
					
			});
		</script>
	</body>

</html>