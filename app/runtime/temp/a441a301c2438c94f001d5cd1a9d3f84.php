<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:77:"/www/wwwroot/www.dsrramtcys.com/app/application/index/view/giftbox/index.html";i:1609051846;}*/ ?>
<!doctype html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>礼物</title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link href="<?php echo config('skin_path'); ?>/css/mui.min.css" rel="stylesheet" />
		<style>
		.mui-control-content{background: #fff;}
		</style>
	</head>

	<body>
		<header class="mui-bar mui-bar-nav">
		    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
		    <h1 class="mui-title">礼物</h1>
		</header>
		<div class="mui-content">
			<div class="mui-slider">
			    <div class="mui-slider-indicator mui-segmented-control mui-segmented-control-inverted">
			        <a class="mui-control-item" href="#item1">收到礼物</a>
			        <a class="mui-control-item" href="#item2">送出礼物</a>
			    </div>
			    <div id="sliderProgressBar" class="mui-slider-progress-bar mui-col-xs-6"></div>
			    <div class="mui-slider-group">
			        <div id="item1" class="mui-slider-item mui-control-content mui-active">
			           	<div class="mui-row">
			            <?php if(is_array($accept_list) || $accept_list instanceof \think\Collection || $accept_list instanceof \think\Paginator): $i = 0; $__LIST__ = $accept_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
		            	<div class="mui-col-sm-6  mui-col-xs-6">
		            		<div class="mui-card">
		            			<div class="mui-card-header mui-card-media">
									<img src="<?php echo $vo['user_ico']; ?>" style="width:34px;"/>
									<div class="mui-media-body">
										<?php echo $vo['user_name']; ?>
										<p><?php echo $vo['send_time']; ?></p>
									</div>
								</div>
								<!--内容区-->
								<div class="mui-card-content">
									<a href="<?php echo url('gift/detail',array('id'=>$vo['id'])); ?>">
									<img src="<?php echo $vo['gift']; ?>" alt="">
									</a>
								</div>
								<!--页脚，放置补充信息或支持的操作-->
								<div class="mui-card-footer">
									<p><?php echo $vo['gift_name']; ?></p>
									<p>X<?php echo $vo['gift_num']; ?></p>
								</div>
							</div>
		            	</div>
		            	<?php endforeach; endif; else: echo "" ;endif; ?>
		            	</div>
			        </div>
			        <div id="item2" class="mui-slider-item mui-control-content">
			            <div class="mui-row">
			            <?php if(is_array($send_list) || $send_list instanceof \think\Collection || $send_list instanceof \think\Paginator): $i = 0; $__LIST__ = $send_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
		            	<div class="mui-col-sm-6  mui-col-xs-6">
		            		<div class="mui-card">
		            			<div class="mui-card-header mui-card-media">
									<img src="<?php echo $vo['user_ico']; ?>" style="width:34px;"/>
									<div class="mui-media-body">
										<?php echo $vo['user_name']; ?>
										<p><?php echo $vo['send_time']; ?></p>
									</div>
								</div>
								<!--内容区-->
								<div class="mui-card-content">
									<a href="<?php echo url('gift/detail',array('id'=>$vo['id'])); ?>">
									<img src="<?php echo $vo['gift']; ?>" alt="">
									</a>
								</div>
								<!--页脚，放置补充信息或支持的操作-->
								<div class="mui-card-footer">
									<p><?php echo $vo['gift_name']; ?></p>
									<p>X<?php echo $vo['gift_num']; ?></p>
								</div>
							</div>
		            	</div>
		            	<?php endforeach; endif; else: echo "" ;endif; ?>
		            	</div>
			        </div>
			    </div>
			</div>
		</div>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/public.js"></script>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/mui.min.js"></script>
		<script>
		$(function(){
			$(".mui-card-content img").height($(".mui-card-content img").width());
		});
		</script>
	</body>

</html>