<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"/www/wwwroot/jyo.henangaodu.com/app/application/index/view/mall/detail.html";i:1602502927;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title><?php echo lang("gift detail"); ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo config('skin_path'); ?>/css/mui.min.css"/>
    <link href="<?php echo config('skin_path'); ?>/css/mall.css" rel="stylesheet"/>
    <style>
	.xq-cont img{
		width: 100%;
	}
    </style>
</head>
<body>
	<header class="mui-bar mui-bar-nav">
	    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <h1 class="mui-title"><?php echo lang("gift detail"); ?></h1>
	</header>
	<div class="mui-content">
		<div class="mainimg">
			<div class="mui-slider">
			  <div class="mui-slider-group">
			    <?php if(is_array($info['imgs']) || $info['imgs'] instanceof \think\Collection || $info['imgs'] instanceof \think\Paginator): $i = 0; $__LIST__ = $info['imgs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			    <div class="mui-slider-item">
			      <img src="<?php echo $vo; ?>" alt="">
			    </div>
			    <?php endforeach; endif; else: echo "" ;endif; ?>
			  </div>
			</div>
		</div>
		<div class="white">
			<ul class="xq-sm">
				<li><span><?php echo lang("gift name"); ?>：</span><p><?php echo $info['giftname']; ?></p></li>
				<li><span><?php echo lang("gift price"); ?>：</span><p>$<?php echo $info['money']; ?></p></li>
				<li><span><?php echo lang("member price"); ?>：</span><p class="yh-price">$<?php echo $info['money']; ?></p></li>
				<li><span><?php echo lang("yunfei"); ?>：</span><p><?php echo lang("free"); ?></p></li>
			</ul>
		</div>
		<a href="<?php echo url('mall/pay',array('id'=>$info['id'])); ?>" class="buy-btn"><?php echo lang("buy"); ?></a>
		<div class="white">
			<div class="xq-cont">
				<h5 class="xq-cont-title"><?php echo lang("gift detail"); ?></h5>
				<?php echo $info['desc']; ?>
			</div>
		</div>
		
    
	</div>
	<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/public.js"></script>
	<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/mui.min.js"></script>
</body>
</html>