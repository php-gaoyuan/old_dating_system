<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"/www/wwwroot/jyo.henangaodu.com/app/application/index/view/wallet/index.html";i:1602502927;}*/ ?>
<!doctype html>
<html>

	<head>
		<meta charset="UTF-8">
		<title><?php echo lang('wallet'); ?></title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link href="<?php echo config('skin_path'); ?>/css/mui.min.css" rel="stylesheet" />
		<style>
			.top{
				background: #3F79DF;
				text-align: center;
				padding:40px 0;
			}
			.top p{
				font-size: 1.3em;
				color:#fff;
			}
			.top button{
				background: #FD9803;
			}
			#balance{
				font-size: 3em;
				font-weight: 700;
				margin: 1em 0;
			}
			.mui-table-view-cell{
				padding:15px;
			}
		</style>
	</head>

	<body>
		<?php if(!$is_h5_plus): ?>
		<header class="mui-bar mui-bar-nav">
		    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
		    <h1 class="mui-title"><?php echo lang('wallet'); ?></h1>
		</header>
		<?php endif; ?>
		<div class="mui-content">
			<div class="top">
				<p><?php echo lang('balance'); ?></p>
				<p id="balance">$<?php echo number_format($userinfo['golds'],2); ?></p>
				<button type="button" class="mui-btn mui-btn-yellow mui-btn-block" style="width:50%;margin:0 auto;"><?php echo lang('upgrade'); ?></button>
			</div>
			
			
			<ul class="mui-table-view">
			        <li class="mui-table-view-cell">
			            <a class="mui-navigate-right">
			                <?php echo lang('pay_record'); ?>
			            </a>
			        </li>
			        <li class="mui-table-view-cell">
			            <a class="mui-navigate-right">
			                 <?php echo lang('xiaofei_record'); ?>
			            </a>
			        </li>
			    </ul>
		</div>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/public.js"></script>
		<script type="text/javascript">
			$(function(){
				$(".top button").click(function(){
					window.location.href="<?php echo url('recharge/index'); ?>";
				});
			});
		</script>
	</body>

</html>