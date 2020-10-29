<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"/www/wwwroot/www.pauzzz.com/app/application/index/view/reg/forget_pass.html";i:1562821403;}*/ ?>
<!doctype html>
<html>

	<head>
		<meta charset="UTF-8">
		<title><?php echo lang('wj_title'); ?></title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link href="<?php echo config('skin_path'); ?>/css/mui.min.css" rel="stylesheet" />
		<style>
			.sub-btn{
				margin:15px;
			}
			.sub-btn .mui-btn{
				line-height: 5px;
			}
		</style>
	</head>

	<body>
		<?php if(!$is_h5_plus): ?>
		<header class="mui-bar mui-bar-nav">
		    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
		    <h1 class="mui-title"><?php echo lang('wj_title'); ?></h1>
		</header>
		<?php endif; ?>
		<div class="mui-content">
			<form class="mui-input-group">
			    <div class="mui-input-row">
			        <input type="text" class="mui-input-clear" placeholder="<?php echo lang('wj_input_email'); ?>">
			    </div>
			</form>
			<div class="sub-btn">
			<button class="mui-btn mui-btn-block mui-btn-primary"><?php echo lang('submit'); ?></button>
			</div>
		</div>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/public.js"></script>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/mui.min.js"></script>
	</body>

</html>