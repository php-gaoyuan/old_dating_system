<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"/www/wwwroot/www.partyings.com/app/application/index/view/greetcard/index.html";i:1531498926;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title><?php echo lang('greet card'); ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo config('skin_path'); ?>/css/mui.min.css"/>

    <style>
		body,.mui-content,.mui-slider-indicator{
			background: #fff;
		}
		.mui-card img{width:100%;}
		.liwu_name{
			width: 100%;
		}
		.liwu_price{
			font-weight: 700;
			color:#EFA668;
		}
    </style>
</head>
<body>
	<?php if(!$is_h5_plus): ?>
	<header class="mui-bar mui-bar-nav">
	    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <h1 class="mui-title"><?php echo lang('greet card'); ?></h1>
	</header>
	<?php endif; ?>
	<div class="mui-content">
		<div class="mui-row">
        	<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            	<div class="mui-col-sm-6 mui-col-xs-6">
            		<div class="mui-card">
						<!--内容区-->
						<div class="mui-card-content">
							<a href="<?php echo url('greetcard/detail',array('id'=>$vo['id'])); ?>">
							<img src="<?php echo $vo['yuanpatch']; ?>" alt="">
							</a>
						</div>
						<!--页脚，放置补充信息或支持的操作-->
						<div class="mui-card-footer">
							<p class="liwu_name mui-ellipsis"><?php echo $vo['giftname']; ?></p>
							<p class="liwu_price">$<?php echo $vo['money']; ?></p>
						</div>
					</div>
            	</div>
            	<?php endforeach; endif; else: echo "" ;endif; ?>

        </div>
	</div>
	<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/public.js"></script>
	<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/mui.min.js"></script>
	<script>
	$(function(){
		$(".mui-card img").height($(".mui-card img").width());
	});
	</script>
</body>
</html>