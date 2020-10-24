<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"/www/wwwroot/www.partyings.com/app/application/index/view/album/index.html";i:1531498830;}*/ ?>
<!doctype html>
<html>

	<head>
		<meta charset="UTF-8">
		<title><?php echo lang("home_title"); ?></title>
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
			
			.mui-card-media{
				width: 100%;
			}
			.mui-slider .mui-slider-group .mui-slider-item img{
				display: block;
				min-width:187px;
				min-height:240px;
			}
			.mui-card-content.mui-card-media span{
				display: block;
				font-size: 170px;
				line-height: 1.2em;
			}


			.album_name{
				display: block;
    position: absolute;
    bottom: -10px;
    line-height: 2em;
    background: rgba(0, 0, 0, 0.7);
    color: #fff;
    width: 100%;
    padding-left: 10px;
			}
		</style>
	</head>

	<body>
		<?php if(!$is_h5_plus): ?>
		<header class="mui-bar mui-bar-nav">
		    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
		    <h1 class="mui-title"><?php echo lang("home_title"); ?></h1>
		</header>
		<?php endif; ?>
		<div class="mui-content">
			<div class="user_ico" style="height:251px;">
				<img src="<?php echo $userinfo['user_ico']; ?>" width="100%"/>
			</div>
			<div class="mui-slider">
			    <div class="mui-slider-indicator mui-segmented-control mui-segmented-control-inverted">
			        <a class="mui-control-item" href="<?php echo url('profile/index'); ?>"><?php echo lang("news"); ?></a>
			        <a class="mui-control-item" href="<?php echo url('profile/mood'); ?>"><?php echo lang("mood"); ?></a>
			        <a class="mui-control-item" href="javascript:;"><?php echo lang("photos"); ?></a>
			    </div>
			    <div id="sliderProgressBar" class="mui-slider-progress-bar mui-col-xs-4" style="transform: translate3d(200%, 0px, 0px) translateZ(0px);"></div>
			    <div class="mui-slider-group">
			    	

			        <!-- photos -->
			        <div id="item3" class="mui-slider-item mui-control-content">
			        	<div class="mui-row">
			        		<div class="mui-col-sm-6 mui-col-xs-6">
			        	    	<div class="mui-card" onclick="location.href='<?php echo url('album/add'); ?>'">
									<!--内容区-->
									<div class="mui-card-content mui-card-media" style="min-width:187px;background:#f1f1f1;text-align:center;">
										<img src="/public/static/default/add_pic.png" alt="" >
										<!-- <span>+</span> -->
									</div>
									<!--页脚，放置补充信息或支持的操作-->
									<div class="mui-card-footer">
										<?php echo lang('create_album'); ?>
										<button class="mui-btn mui-btn-primary" style="float:right;" onclick="location.href='<?php echo url('album/add'); ?>'"><?php echo lang('create_btn'); ?></button>
									</div>
								</div>
			        	    </div>
			        		<?php if(is_array($album_list) || $album_list instanceof \think\Collection || $album_list instanceof \think\Paginator): $i = 0; $__LIST__ = $album_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			        	    <div class="mui-col-sm-6 mui-col-xs-6">
			        	    	<div class="mui-card" >
									<!--内容区-->
									<div class="mui-card-content mui-card-media" onclick="location.href='<?php echo url('photo/index',['album_id'=>$vo['album_id']]); ?>'">
										<img src="<?php echo config('webconfig.pc_url'); ?><?php echo $vo['album_skin']; ?>" />
										<p class="album_name"><?php echo $vo['album_name']; ?>(<?php echo $vo['photo_num']; ?>)</p>
									</div>
									<!--页脚，放置补充信息或支持的操作-->
									<div class="mui-card-footer">
										
										<button class="mui-btn mui-btn-primary" style="float:right;" onclick="location.href='<?php echo url('album/edit',['album_id'=>$vo['album_id']]); ?>'"><?php echo lang('edit_btn'); ?></button>
										<button class="mui-btn mui-btn-danger del" style="float:right;" data-id="<?php echo $vo['album_id']; ?>"><?php echo lang('delete_btn'); ?></button>
									</div>
								</div>
			        	    </div>
			        	    <?php endforeach; endif; else: echo "" ;endif; ?>
			        	</div>
			        	
					</div>
			    </div>
			</div>
			<div style="height:60px;"></div>
			<!-- <nav class="mui-bar mui-bar-tab">
			    <a class="mui-tab-item1" href="<?php echo url('upgrade/index'); ?>">
			        <span class="mui-icon iconfont icon-crown"></span>
			    </a>
			    <a class="mui-tab-item1" href="<?php echo url('mall/index'); ?>">
			        <span class="mui-icon iconfont icon-liwu"></span>
			    </a>
			</nav> -->
		</div>




		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/layui/layui.js"></script>

		<script type="text/javascript">
			layui.use(["flow","laytpl","jquery"],function(){
				var $=layui.jquery;
				
				$(".del").click(function(){
					var id = $(this).data("id");
					$.get("<?php echo url('album/del'); ?>",{id:id},function(res){
						window.location.reload();
					});
				});
				//默认返回
				$(".mui-action-back").click(function(){
					window.history.back();
				});


			});

		</script>



		
	</body>
</html>