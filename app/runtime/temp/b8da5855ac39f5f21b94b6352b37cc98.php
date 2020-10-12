<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"/www/wwwroot/www.pauzzz.com/app/application/index/view/profile/mood.html";i:1562814526;}*/ ?>
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
			        <a class="mui-control-item" href="javascript:;"><?php echo lang("mood"); ?></a>
			        <a class="mui-control-item" href="<?php echo url('album/index'); ?>"><?php echo lang("photos"); ?></a>
			    </div>
			    <div id="sliderProgressBar" class="mui-slider-progress-bar mui-col-xs-4" style="transform: translate3d(100%, 0px, 0px) translateZ(0px);"></div>
			    <div class="mui-slider-group">
			    	



			        <!-- tab2 -->
			        <div id="item2" class="mui-slider-item mui-control-content">
			        	<button class="mui-btn mui-btn-block mui-btn-primary" style="margin: 10px auto;width:90%;margin:10px auto;padding:0;padding:7px 0;" id="push"><?php echo lang('fabu_xq'); ?></button>
			            <div class="user-news" id="newsList">
							

						</div>
			        </div>

			    </div>
			</div>
			<div style="height:60px;"></div>
			<nav class="mui-bar mui-bar-tab">
			    <a class="mui-tab-item1" href="<?php echo url('upgrade/index'); ?>">
			        <span class="mui-icon iconfont icon-crown"></span>
			    </a>
			    <a class="mui-tab-item1" href="<?php echo url('mall/index'); ?>">
			        <span class="mui-icon iconfont icon-liwu"></span>
			    </a>
			</nav>
		</div>



		<script type="text/html" id="userNews">
			{{# layui.each(d.list,function(index,item){ }}
				<div class="item">
					<div class="user-news-info">
						<img src="{{ item.user_ico }}" style="width:50px;">
						<div class="user-news-info-txt">
							<span class="user-name">{{ item.user_name }}</span>{{ item.title }}
							<div class="user-news-time">
								<i class="icon iconfont icon-clock"></i>
								{{ item.time_ago }}
							</div>
						</div>
					</div>
					<div class="user-news-cont">
						<div class="user-news-txt">{{ item.content }}</div>
						<!-- <div class="user-news-imgs">
							<img src="<?php echo config('skin_path'); ?>/images/fengmian.png">
						</div> -->
					</div>
				</div>
			{{# }); }}
		</script>


		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/layui/layui.js"></script>

		<script type="text/javascript">

			
			layui.use(["flow","laytpl","jquery"],function(){
				var flow=layui.flow,
					laytpl=layui.laytpl,
					$=layui.jquery;


				$("#push").click(function(){
					window.location.href="/index/mood/add";
				});
				//默认返回
				$(".mui-action-back").click(function(){
					window.history.back();
				});
				



				var options = {
					elem:"#newsList",
					isAuto:true,
					done:function(page,next){
						$.getJSON("/index/home/mood/uid/<?php echo $userinfo['user_id']; ?>/page/"+page,{},function(res){
							laytpl($("#userNews").html()).render(res,function(html){
								next(html,page<res.pages);
							});

							$(".photo_frame").attr("src","http://www.pauzzz.com/"+$(".photo_frame").attr("src"));
						});
					}
				};

				flow.load(options);
				
			});

		</script>



		
	</body>
</html>