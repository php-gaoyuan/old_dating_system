<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"/www/wwwroot/www.pauzzz.com/app/application/index/view/home/photos.html";i:1531498064;}*/ ?>
<!doctype html>
<html>

	<head>
		<meta charset="UTF-8">
		<title><?php echo lang("photos"); ?></title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link href="<?php echo config('skin_path'); ?>/css/mui.min.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="//at.alicdn.com/t/font_537983_p50sudb7q2xogvi.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo config('skin_path'); ?>/css/user.css">
		<style type="text/css">
			.user_ico{
				width: 100%;
				overflow: hidden;
				position: relative;
			}
			#item2{
				background:#fff;
			}
			.layui-flow-more{text-align: center;}
			.pals-btn-group{
				position: absolute;
				bottom:10px;
				width:100%;
				text-align: center;
			}
			.pals-btn-group .mui-icon{
				color:#fff;
				font-size: 35px;
				margin:0 18px;
				border:1px solid #fff;
				border-radius: 100%;
				padding:6px;
			}
			.pals-btn-group .icon-jiahaoyou{
				font-size: 30px;
			}


			.mui-tab-item1{
				display: table-cell;
				overflow: hidden;
				width: 1%;
				height: 50px;
				text-align: center;
				vertical-align: middle;
				white-space: nowrap;
				text-overflow:ellipsis;
				color:#929292;
			}
		</style>
	</head>

	<body>
		<?php if(!$is_h5_plus): ?>
		<header class="mui-bar mui-bar-nav">
		    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
		    <h1 class="mui-title"><?php echo lang("photos"); ?></h1>
		</header>
		<?php endif; ?>
		<div class="mui-content">
			

			    

	        <!-- photos -->
        	<div class="mui-row">
        		<?php if(is_array($photo_list) || $photo_list instanceof \think\Collection || $photo_list instanceof \think\Paginator): $i = 0; $__LIST__ = $photo_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        	    <div class="mui-col-sm-6 mui-col-xs-6">
        	    	<div class="mui-card">
						<!--内容区-->
						<div class="mui-card-content mui-card-media" style="height:240px;overflow:hidden;">
							<img lay-src="<?php echo config('webconfig.pc_url'); ?><?php echo $vo['photo_src']; ?>" style="width:100%;" onclick="topBigImg('<?php echo config('webconfig.pc_url'); ?><?php echo $vo['photo_src']; ?>');"/>
						</div>
						<!--页脚，放置补充信息或支持的操作-->
						<div class="mui-card-footer">
							<?php echo (isset($vo['photo_name']) && ($vo['photo_name'] !== '')?$vo['photo_name']:"No Name"); ?>
						</div>
					</div>
        	    </div>
        	    <?php endforeach; endif; else: echo "" ;endif; ?>
        	</div>

			
		</div>




		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/function.js"></script>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/mui.min.js"></script>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/layui/layui.js"></script>
		<script type="text/javascript">

			
			layui.use(["flow","layer","jquery"],function(){
				var flow=layui.flow,
					layer=layui.layer,
					$=layui.jquery;

				
				flow.lazyimg(); 
			});

			var topBigImg = function (src){
                //页面层-佟丽娅
                layui.layer.open({
					type: 1,
					title: false,
					area:'90%',
					offset: "20%",
					closeBtn: 1,
					skin: 'layui-layer-nobg', //没有背景色
					shadeClose: true,
					content: "<img src="+src+" style='width:100%;border:4px solid #fff'/>"
                });
            }

		</script>



		
	</body>
</html>