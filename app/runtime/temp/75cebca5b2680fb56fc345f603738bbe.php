<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"/www/wwwroot/www.pauzzz.com/app/application/index/view/set/about.html";i:1567989608;}*/ ?>
<!doctype html>
<html>

	<head>
		<meta charset="UTF-8">
		<title><?php echo lang('about'); ?></title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link href="<?php echo config('skin_path'); ?>/css/mui.min.css" rel="stylesheet" />
		<style>
			.center{
				text-align: center;
				margin:15px 0;
			}
			.bottom{
				display: block;
				width: 100%;
				position: absolute;
				bottom:10px;
			}
		</style>
	</head>

	<body>
		<?php if(!$is_h5_plus): ?>
		<header class="mui-bar mui-bar-nav">
		    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
		    <h1 class="mui-title"><?php echo lang('about'); ?></h1>
		</header>
		<?php endif; ?>
		<div class="mui-content">
			<img src="<?php echo config('skin_path'); ?>/images/login-log.png" style="margin:0 auto;display:block;width:90%"/>
			<div class="center"><?php echo lang('banben'); ?>：<span>3.1</span></div>
			<ul class="mui-table-view">
			        <li class="mui-table-view-cell">
			            <a class="mui-navigate-right">
			                <?php echo lang('help center'); ?>
			            </a>
			        </li>
			        <li class="mui-table-view-cell">
			            <a class="mui-navigate-right">
			                 <?php echo lang('tiaokuan'); ?>
			            </a>
			        </li>
			        <li class="mui-table-view-cell">
			            <a class="mui-navigate-right">
			                 <?php echo lang('about us'); ?>
			            </a>
			        </li>
			        <li class="mui-table-view-cell">
			            <a class="mui-navigate-right">
			                 <?php echo lang('jiaoyou'); ?>
			            </a>
			        </li>
			        <li class="mui-table-view-cell">
			            <a class="mui-navigate-right">
			                 <?php echo lang('gengxin'); ?>
			            </a>
			        </li>
			    </ul>
			    
			    <div class="center bottom">
			    	<?php echo lang('guanwang'); ?>：www.pauzzz.com <br />
			    </div>
		</div>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/public.js"></script>
	</body>

</html>