<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:68:"/www/wwwroot/www.pauzzz.com/app/application/index/view/set/lang.html";i:1531499038;}*/ ?>
<!doctype html>
<html>

	<head>
		<meta charset="UTF-8">
		<title></title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link href="<?php echo config('skin_path'); ?>/css/mui.min.css" rel="stylesheet" />
	</head>

	<body>
		<?php if(!$is_h5_plus): ?>
		<header class="mui-bar mui-bar-nav">
		    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
		    <h1 class="mui-title"><?php echo lang('set lang'); ?></h1>
		</header>
		<?php endif; ?>
		<div class="mui-content">
			<ul class="mui-table-view">
			        <li class="mui-table-view-cell">
			            <div class="mui-input-row mui-radio">
							<label><?php echo lang('zh-cn'); ?></label>
							<input name="lang" value="zh-cn" type="radio" <?php if($lang == "zh-cn"): ?>checked<?php endif; ?> >
						</div>
			        </li>
			        <li class="mui-table-view-cell">
			            <div class="mui-input-row mui-radio">
							<label><?php echo lang('zh-tw'); ?></label>
							<input name="lang" value="zh-tw" type="radio" <?php if($lang == "zh-tw"): ?>checked<?php endif; ?> >
						</div>
			        </li>
			        <li class="mui-table-view-cell">
			            <div class="mui-input-row mui-radio">
							<label><?php echo lang('en-us'); ?></label>
							<input name="lang" value="en-us" type="radio" <?php if($lang == "en-us"): ?>checked<?php endif; ?> >
						</div>
			        </li>
			        <li class="mui-table-view-cell">
			            <div class="mui-input-row mui-radio">
							<label><?php echo lang('kor'); ?></label>
							<input name="lang" value="kor" type="radio" <?php if($lang == "kor"): ?>checked<?php endif; ?> >
						</div>
			        </li>
			        <li class="mui-table-view-cell">
			            <div class="mui-input-row mui-radio">
							<label><?php echo lang('jp'); ?></label>
							<input name="lang" value="jp" type="radio" <?php if($lang == "jp"): ?>checked<?php endif; ?> >
						</div>
			        </li>
			    </ul>
			    <div style="margin:15px;">
			    <button class="mui-btn mui-btn-primary mui-btn-block" id="sub"><?php echo lang('submit'); ?></button></div>
		</div>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/public.js"></script>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/function.js"></script>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/mui.min.js"></script>
		<script>
		$(function(){
			$("#sub").click(function(){
				var lang = $("input[type='radio']:checked").val();
				setCookie("think_var",lang,"365");
				mui.toast("<?php echo lang('ok'); ?>");
				setTimeout(function(){
					window.location.href="/";
				},"2000");
			});
		});
		</script>
	</body>

</html>