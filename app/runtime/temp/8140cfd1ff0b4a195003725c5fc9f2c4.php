<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"D:\phpstudy_pro\WWW\jyo.com\app/application/index\view\upgrade\index.html";i:1562825496;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"/>
	<meta name="apple-mobile-web-app-capable" content="no" />
	<meta name="format-detection" content="telephone=no,email=no,adress=no"/>
	<title><?php echo lang('upgrade_title'); ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo config('skin_path'); ?>/css/mui.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo config('skin_path'); ?>/css/upgrade.css">
	<link rel="stylesheet" type="text/css" href="//at.alicdn.com/t/font_537983_p50sudb7q2xogvi.css"/>
	<style type="text/css">
		.mui-card-header{
			background: #e8e8e8;
			border-top: 1px solid #d6d6db;
		}
		.mui-card{
			margin:0px;
			border-radius: 0px;
		}
	</style>
</head>
<body>
	<?php if(!$is_h5_plus): ?>
	<header class="mui-bar mui-bar-nav">
	    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <h1 class="mui-title"><?php echo lang('upgrade_title'); ?></h1>
	</header>
	<?php endif; ?>
	<div class="mui-content">

		<div class="mui-card" style="margin-top:0">
			<!--页眉，放置标题-->
			<div class="mui-card-header">
				<div>
					<span class="mui-icon iconfont icon-vip" style="color:#fead11;    font-size: 1.3em;"></span>
					<span class="div"><?php echo lang('vip_member'); ?></span>
				</div>
			</div>
			<!--内容区-->
			<div class="mui-card-content">
				<ul class="mui-table-view">
			        <li class="mui-table-view-cell">
			        	<div class="mui-input-row mui-radio mui-left mui-pull-left">
			        	    <label>1<?php echo lang('month2'); ?></label>
			        	    <input name="vip" type="radio" value="30">
			        	</div>
		                <div class="mui-pull-left li-center" >USD30.00</div>
		                <div class="mui-pull-right li-right">USD30.00/<?php echo lang('month'); ?></div>
			        </li>

			        <li class="mui-table-view-cell">
			        	<div class="mui-input-row mui-radio mui-left mui-pull-left">
			        	    <label>3<?php echo lang('month2'); ?></label>
			        	    <input name="vip" type="radio" value="70" checked>
			        	</div>
		                <div class="mui-pull-left li-center" >USD70.00</div>
		                <div class="mui-pull-right li-right">USD70.00/<?php echo lang('month'); ?></div>
			        </li>

			        <li class="mui-table-view-cell">
			        	<div class="mui-input-row mui-radio mui-left mui-pull-left">
			        	    <label>6<?php echo lang('month2'); ?></label>
			        	    <input name="vip" type="radio" value="110">
			        	</div>
		                <div class="mui-pull-left li-center" >USD110.00</div>
		                <div class="mui-pull-right li-right">USD110.00/<?php echo lang('month'); ?></div>
			        </li>

			        <li class="mui-table-view-cell">
			        	<div class="mui-input-row mui-radio mui-left mui-pull-left">
			        	    <label>12<?php echo lang('month2'); ?></label>
			        	    <input name="vip" type="radio" value="180" >
			        	</div>
		                <div class="mui-pull-left li-center" >USD180.00</div>
		                <div class="mui-pull-right li-right">USD180.00/<?php echo lang('month'); ?></div>
			        </li>
			    </ul>
			</div>





			<!--页眉，放置标题-->
			<div class="mui-card-header">
				<div>
					<span class="mui-icon iconfont icon-diamond" style="color:#007aff;    font-size: 1.2em;"></span>
					<span class="vip"><?php echo lang('vip_yj_member'); ?></span>
				</div>
			</div>
			<!--内容区-->
			<div class="mui-card-content">
				<ul class="mui-table-view">
			        <li class="mui-table-view-cell">
			        	<div class="mui-input-row mui-radio mui-left mui-pull-left">
			        	    <label><?php echo lang('yongjiu'); ?></label>
			        	    <input name="vip" type="radio" value="199">
			        	</div>
		                <div class="mui-pull-left li-center" >USD199.00</div>
		                <div class="mui-pull-right li-right">USD199.00/<?php echo lang('yongjiu'); ?></div>
			        </li>

			    </ul>
			</div>

			<div class="mui-card-footer">
				<button class="mui-btn mui-btn-primary" style="display: block;width:100%;" id="sub"><?php echo lang('upgrade_sub_btn'); ?></button>
			</div>
		</div>






		<div class="mui-card" style="margin-top:10px;">
			<!--页眉，放置标题-->
			<div class="mui-card-header">
				<div>
					<span class="mui-icon iconfont icon-vip" style="color:#fead11;    font-size: 1.3em;"></span>
					<?php echo lang('vip_member'); ?>
				</div>
			</div>
			<!--内容区-->
			<div class="mui-card-content">
				<ul class="mui-table-view">
				        <li class="mui-table-view-cell">
				            <?php echo lang('upgrade_desc1'); ?>
				        </li>
				        <li class="mui-table-view-cell">
				            <?php echo lang('upgrade_desc2'); ?>
				        </li>
				    </ul>
			</div>


			<!--页眉，放置标题-->
			<div class="mui-card-header">
				<div>
					<span class="mui-icon iconfont icon-diamond" style="color:#007aff;    font-size: 1.2em;"></span>
					<?php echo lang('vip_yj_member'); ?>
				</div>
			</div>
			<!--内容区-->
			<div class="mui-card-content">
				<ul class="mui-table-view">
				        <li class="mui-table-view-cell">
				            <?php echo lang('upgrade_desc3'); ?>
				        </li>
				        <li class="mui-table-view-cell">
				            <?php echo lang('upgrade_desc2'); ?>
				        </li>
				    </ul>
			</div>
		</div>



	</div>
	<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/public.js"></script>

	<script>
	$(function(){
		var to_user_id="<?php echo $to_user_id; ?>";
		$("#sub").click(function(){
			var money = 190;
			money = $("input[type='radio']:checked").val();
			var upgrade_name = "";
			var dengji = $("input[type='radio']:checked").parent(".vip").html();
			var date = $("input[type='radio']:checked").parent("label").html();
			var upgrade_name = dengji+date;
			
			window.location.href="<?php echo url('upgrade/create_order','',false); ?>/money/"+money;
			
		});
	});
	</script>
</body>
</html>