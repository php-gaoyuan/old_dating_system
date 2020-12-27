<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:77:"/www/wwwroot/www.dsrramtcys.com/app/application/index/view/profile/index.html";i:1609053264;}*/ ?>
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
		<link rel="stylesheet" type="text/css" href="<?php echo config('skin_path'); ?>/layui/css/layui.css">
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
			        <a class="mui-control-item" href="javascript:;"><?php echo lang("news"); ?></a>
			        <a class="mui-control-item" href="<?php echo url('profile/mood'); ?>"><?php echo lang("mood"); ?></a>
			        <a class="mui-control-item" href="<?php echo url('album/index'); ?>"><?php echo lang("photos"); ?></a>
			    </div>
			    <div id="sliderProgressBar" class="mui-slider-progress-bar mui-col-xs-4"></div>
			    <div class="mui-slider-group">
			    	<!-- tab1 -->
			        <div id="item1" class="mui-slider-item mui-control-content mui-active">
			        	<ul class="mui-table-view">
					        <li class="mui-table-view-cell" onclick="location.href='<?php echo url('profile/headimg'); ?>'">
					            <a class="mui-navigate-right">
					                <?php echo lang('headimg'); ?>
					            </a>
					        </li>
					    </ul>
			            <form class="mui-input-group" target="dsrramtcys" method="post" action="<?php echo url('profile/index'); ?>">
			            	
						    <div class="mui-input-row">
						        <label><?php echo lang("gender"); ?></label>
						    	<input type="text" class="mui-input-clear" value="<?php if($userinfo['user_sex'] == 0): ?><?php echo lang("female"); else: ?><?php echo lang("male"); endif; ?>" disabled>
						    </div>
						    <div class="mui-input-row">
						        <label><?php echo lang('birth'); ?></label>
						        <input type="date" name="birth" class="mui-input-clear" value="<?php echo (isset($userinfo['birth_year']) && ($userinfo['birth_year'] !== '')?$userinfo['birth_year']:'1970'); ?>-<?php echo (isset($userinfo['birth_month']) && ($userinfo['birth_month'] !== '')?$userinfo['birth_month']:'01'); ?>-<?php echo (isset($userinfo['birth_day']) && ($userinfo['birth_day'] !== '')?$userinfo['birth_day']:'01'); ?>" />
						    </div>
						    <div class="mui-input-row">
						        <label><?php echo lang('country'); ?></label>
						        <select name="country" class="mui-input-clear" placeholder="">
						        	<option value=""><?php echo lang('select'); ?></option>
						        	<?php if(is_array($country_list) || $country_list instanceof \think\Collection || $country_list instanceof \think\Paginator): $i = 0; $__LIST__ = $country_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
						        	<option value="<?php echo $vo['cname']; ?>" <?php if($userinfo['country'] == $vo['cname']): ?>selected<?php endif; ?>><?php echo $vo['cname']; ?></option>
						        	<?php endforeach; endif; else: echo "" ;endif; ?>
						        </select>
						    </div>
						    <div class="mui-input-row">
						        <label><?php echo lang('waimao'); ?></label>
						        <select name="waimao" class="mui-input-clear" placeholder="">
						        	<option value=""><?php echo lang('select'); ?></option>
						        	<option value="1" <?php if($userinfo['waimao'] == '1'): ?>selected<?php endif; ?>>一般</option>
						        	<option value="2" <?php if($userinfo['waimao'] == '2'): ?>selected<?php endif; ?>>好看</option>
						        	<option value="3" <?php if($userinfo['waimao'] == '3'): ?>selected<?php endif; ?>>出众</option>
						        </select>
						    </div>
						    <div class="mui-input-row">
						        <label><?php echo lang('sexual'); ?></label>
						        <select name="sexual" class="mui-input-clear" placeholder="">
						        	<option value=""><?php echo lang('select'); ?></option>
						        	<option value="1" <?php if($userinfo['sexual'] == '1'): ?>selected<?php endif; ?>>异性</option>
						        	<option value="2" <?php if($userinfo['sexual'] == '2'): ?>selected<?php endif; ?>>同性</option>
						        	<option value="3" <?php if($userinfo['sexual'] == '3'): ?>selected<?php endif; ?>>双性</option>
						        </select>
						    </div>

						    <div class="mui-input-row">
						        <label><?php echo lang('shengao'); ?></label>
						        <select name="height" class="mui-input-clear" placeholder="">
						        	<option value=""><?php echo lang('select'); ?></option>
						        	<script>
						        		var height= "<?php echo $userinfo['height']; ?>";
										for(var i=150;i<200;i++){
											if(height == i){
												document.write("<option value="+i+" selected>"+i+"</option>");
											}else{
												document.write("<option value="+i+" >"+i+"</option>");
											}
											
										}
									</script>
						        </select>
						    </div>
						    <div class="mui-input-row">
						        <label><?php echo lang('weight'); ?></label>
						        <input type="text" name="weight" class="mui-input-clear" value="<?php echo $userinfo['weight']; ?>" placeholder="">kg
						    </div>
						    <div class="mui-input-row">
						        <label><?php echo lang('income'); ?></label>
						        <select name="income" class="mui-input-clear" placeholder="">
						        	<option value=""><?php echo lang('select'); ?></option>
									<option value="$10,000" <?php if($userinfo['income'] == '$10,000'): ?>selected<?php endif; ?>>$10,000</option>
									<option value="$10,000-30,000" <?php if($userinfo['income'] == '$10,000-30,000'): ?>selected<?php endif; ?>>$10,000-30,000</option>
									<option value="$30,000-50,000" <?php if($userinfo['income'] == '$30,000-50,000'): ?>selected<?php endif; ?>>$30,000-50,000</option>
									<option value="$50,000-80,000" <?php if($userinfo['income'] == '$50,000-80,000'): ?>selected<?php endif; ?>>$50,000-80,000</option>
									<option value="$80,000-120,000" <?php if($userinfo['income'] == '$120,000-150,000'): ?>selected<?php endif; ?>>$80,000-120,000</option>
									<option value="$120,000-150,000" <?php if($userinfo['income'] == '$120,000-150,000'): ?>selected<?php endif; ?>>$120,000-150,000</option>
									<option value="$150,000-200,000" <?php if($userinfo['income'] == '$150,000-200,000'): ?>selected<?php endif; ?>>$150,000-200,000</option>
									<option value="$200,000-300,000" <?php if($userinfo['income'] == '$200,000-300,000'): ?>selected<?php endif; ?>>$200,000-300,000</option>
									<option value="$300,000-800,000" <?php if($userinfo['income'] == '$300,000-800,000'): ?>selected<?php endif; ?>>$300,000-800,000</option>
									<option value="$800,000 Above" <?php if($userinfo['income'] == '$800,000 Above'): ?>selected<?php endif; ?>>$800,000 Above</option></select>
						        </select>
						    </div>
						    <div class="mui-input-row" style="height:100px;">
						        <label><?php echo lang('intro'); ?></label>
						        <textarea name="gerenjieshao"><?php echo $userinfo['gerenjieshao']; ?></textarea>
						    </div>
						    <div class="mui-button-row">
						        <button type="submit" class="mui-btn mui-btn-primary" ><?php echo lang('submit'); ?></button>
						    </div>
						</form>
			        </div>
			    </div>
			</div>
			<div style="height:60px;"></div>
			<!-- footer -->
		</div>


		<iframe  name="dsrramtcys" id="dsrramtcys" src="" frameborder="0" style="display:none"></iframe>

		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/layui/layui.js"></script>
		<script type="text/javascript">

			
			layui.use(["jquery","layer"],function(){
				var $=layui.jquery;
				var layer = layui.layer;
				
				//默认返回
				$(".mui-action-back").click(function(){
					window.history.back();
				});
			});

		</script>



		
	</body>
</html>