<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"/www/wwwroot/jyo.henangaodu.com/app/application/index/view/home/index.html";i:1603037127;}*/ ?>
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



			.mui-slider .mui-slider-group .mui-slider-item img{

				display: block;

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

			<div class="user_ico" style="height:251px;background:url('<?php echo $userinfo['user_ico']; ?>') center center no-repeat;background-size:100% auto;">

				<!-- <img src="<?php echo $userinfo['user_ico']; ?>" width="100%"/> -->

				<div class="pals-btn-group">

					<span class="mui-icon iconfont icon-dazhaohu" onclick="window.location.href='<?php echo url('chat/chat',['pals_id'=>\think\Request::instance()->param('uid')]); ?>'"></span>

					<span class="mui-icon iconfont icon-jiahaoyou" onclick="addFriend('<?php echo $uid; ?>')"></span>

				</div>

			</div>

			<div class="mui-slider">

			    <div class="mui-slider-indicator mui-segmented-control mui-segmented-control-inverted">

			        <a class="mui-control-item" href="#item1"><?php echo lang("news"); ?></a>

			        <a class="mui-control-item" href="#item2"><?php echo lang("mood"); ?></a>

			        <a class="mui-control-item" href="#item3"><?php echo lang("photos"); ?></a>

			    </div>

			    <div id="sliderProgressBar" class="mui-slider-progress-bar mui-col-xs-4"></div>

			    <div class="mui-slider-group">

			    	<!-- tab1 -->

			        <div id="item1" class="mui-slider-item mui-control-content mui-active">

			            <ul class="mui-table-view">

			                <li class="mui-table-view-cell"><?php echo lang("nickname"); ?><span class="mui-pull-right"><?php echo $userinfo['user_name']; ?></span></li>

			                <li class="mui-table-view-cell"><?php echo lang("sex"); ?>

			                	<span class="mui-pull-right">

			                	<?php if($userinfo['user_sex'] == 0): ?><?php echo lang("female"); else: ?><?php echo lang("man"); endif; ?>

			                	</span>

			                </li>

			                <li class="mui-table-view-cell">生日<span class="mui-pull-right"><?php echo $userinfo['birth_year']; ?>-<?php echo $userinfo['birth_month']; ?>-<?php echo $userinfo['birth_day']; ?></span></li>

			                <li class="mui-table-view-cell">国家<span class="mui-pull-right"><?php echo $userinfo['country']; ?></span></li>

			                <li class="mui-table-view-cell">外貌<span class="mui-pull-right"><?php echo $userinfo['waimao']; ?></span></li>

			                <li class="mui-table-view-cell">性取向<span class="mui-pull-right"><?php echo $userinfo['sexual']; ?></span></li>

			                <li class="mui-table-view-cell">身高<span class="mui-pull-right"><?php if($userinfo['height']): ?><?php echo $userinfo['height']; ?>cm<?php endif; ?></span></li>

			                <li class="mui-table-view-cell">体重<span class="mui-pull-right"><?php if($userinfo['weight']): ?><?php echo $userinfo['weight']; ?>kg<?php endif; ?></span></li>

			                <li class="mui-table-view-cell">收入<span class="mui-pull-right"><?php if($userinfo['income']): ?><?php echo $userinfo['income']; endif; ?></span></li>

			                <li class="mui-table-view-cell">简介<span class="mui-pull-right"><?php echo $userinfo['gerenjieshao']; ?></span></li>

			            </ul>

			        </div>







			        <!-- tab2 -->

			        <div id="item2" class="mui-slider-item mui-control-content">

			            <div class="user-news" id="newsList">

							



						</div>

			        </div>



			        <!-- photos -->

			        <div id="item3" class="mui-slider-item mui-control-content">

			        	<div class="mui-row">

			        		<?php if(is_array($album_list) || $album_list instanceof \think\Collection || $album_list instanceof \think\Paginator): $i = 0; $__LIST__ = $album_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>

			        	    <div class="mui-col-sm-6 mui-col-xs-6" onclick="location.href='<?php echo url('home/photos',['album_id'=>$vo['album_id']]); ?>';">

			        	    	<div class="mui-card">

									<!--内容区-->

									<div class="mui-card-content mui-card-media">

										<img src="<?php echo config('webconfig.pc_url'); ?><?php echo $vo['album_skin']; ?>" />

									</div>

									<!--页脚，放置补充信息或支持的操作-->

									<div class="mui-card-footer">

										<?php echo $vo['album_name']; ?>(<?php echo $vo['photo_num']; ?>)

									</div>

								</div>

			        	    </div>

			        	    <?php endforeach; endif; else: echo "" ;endif; ?>

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





		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>

		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/function.js"></script>

		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/mui.min.js"></script>

		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/layui/layui.js"></script>

		<script type="text/javascript">



			

			layui.use(["flow","laytpl","jquery"],function(){

				var flow=layui.flow,

					laytpl=layui.laytpl,

					$=layui.jquery;

				







				var options = {

					elem:"#newsList",

					isAuto:true,

					done:function(page,next){

						$.getJSON("/index/home/mood/uid/<?php echo $userinfo['user_id']; ?>/page/"+page,{},function(res){

							laytpl($("#userNews").html()).render(res,function(html){

								next(html,page<res.pages);

							});



							$(".photo_frame").attr("src","http://jyo.henangaodu.com/"+$(".photo_frame").attr("src"));

						});

					}

				};



				flow.load(options);

				

			});



		</script>







		

	</body>

</html>