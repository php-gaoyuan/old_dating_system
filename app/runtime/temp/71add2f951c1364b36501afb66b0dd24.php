<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"/www/wwwroot/www.partyings.com/app/application/index/view/set/index.html";i:1531499024;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<title><?php echo lang("set"); ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo config('skin_path'); ?>/css/mui.min.css"/>
	<style>
		.line{
			height: 10px;
		}
	</style>
</head>
<body>
	<?php if(!$is_h5_plus): ?>
	<header class="mui-bar mui-bar-nav">
	    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <h1 class="mui-title"><?php echo lang("set"); ?></h1>
	</header>
	<?php endif; ?>
	<div class="mui-content">
		<ul class="mui-table-view">
		        <li class="mui-table-view-cell">
		            <a class="mui-navigate-right" href="<?php echo url('set/pass'); ?>">
		                <?php echo lang("set pass"); ?>
		            </a>
		        </li>
		        <li class="mui-table-view-cell">
		            <a class="mui-navigate-right" href="<?php echo url('set/lang'); ?>">
		                <?php echo lang("set lang"); ?>
		            </a>
		        </li>
		    </ul>
		    
		    
		    <div class="line"></div>
		    
		    <ul class="mui-table-view">
		            <li class="mui-table-view-cell">
		                <a class="mui-navigate-right" href="<?php echo url('set/about'); ?>">
		                    <?php echo lang("about"); ?>
		                </a>
		            </li>
		            <li class="mui-table-view-cell">
		                <a class="mui-navigate-right" id="clear_cache">
		                    <?php echo lang("clear cache"); ?>
		                </a>
		            </li>
		        </ul>
		    <div style="padding:10px;">
		    <button class="mui-btn mui-btn-primary" style="display: block;width: 100%;" id="logout"><?php echo lang("logout"); ?></button>
		    </div>
	</div>

	<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/public.js"></script>
	<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/mui.min.js"></script>
	<script>
	$(function(){
		$("#clear_cache").click(function(){
			mui.toast("清除缓存成功！");
		});
		$("#logout").click(function(){
			$.get("<?php echo url('index/logout'); ?>",{},function(res){
				mui.toast(res);
				window.location.href="<?php echo url('index/index'); ?>";
			});
		});
	});
	</script>
</body>
</html>