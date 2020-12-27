<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"/www/wwwroot/www.dsrramtcys.com/app/application/index/view/album/edit.html";i:1609051846;}*/ ?>
<!doctype html>
<html>

	<head>
		<meta charset="UTF-8">
		<title><?php echo lang("edit_album"); ?></title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link href="<?php echo config('skin_path'); ?>/css/mui.min.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="//at.alicdn.com/t/font_537983_p50sudb7q2xogvi.css"/>
		
	</head>

	<body>
		<?php if(!$is_h5_plus): ?>
		<header class="mui-bar mui-bar-nav">
		    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
		    <h1 class="mui-title"><?php echo lang("edit_album"); ?></h1>
		</header>
		<?php endif; ?>
		<div class="mui-content">
			<form class="mui-input-group">
			    <div class="mui-input-row">
			       <label><?php echo lang('album_name'); ?></label>
			        <input type="text" name="album_name" id="album_name" class="mui-input-clear" value="<?php echo $album_info['album_name']; ?>">
			    </div>

			    <div class="mui-input-row" style="height:80px;">
			        <label><?php echo lang('album_desc'); ?></label>
			        <textarea class="mui-textarea" name="album_info" id="album_info"><?php echo $album_info['album_info']; ?></textarea>
			    </div>
			    <!-- <div class="mui-input-row">
			        <label>隐私设置</label>
			    </div>

			    <div class="mui-input-row mui-radio mui-left">
					<label>自己可以见</label>
					<input name="is_pass" type="radio" checked value="0">
				</div> 
				<div class="mui-input-row mui-radio mui-left">
					<label>好友可见</label>
					<input name="is_pass" type="radio" value="1">
				</div>  -->
				

				<div class="mui-button-row">
					<input type="hidden" name="album_id" id="album_id" value="<?php echo $album_info['album_id']; ?>">
			        <button type="button" class="mui-btn mui-btn-primary" id="sub"><?php echo lang('submit'); ?></button>
			    </div>

			</form>
		</div>




		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/layui/layui.js"></script>
		<script type="text/javascript">

			
			layui.use(["jquery","layer"],function(){
				var $=layui.jquery;
				var layer = layui.layer;

				//tijiao
				$("#sub").click(function(){
					var album_name = $("#album_name").val();
					var album_info = $("#album_info").val();
					var album_id = $("#album_id").val();
					if(album_name == ""){
						return false;
					}
					$.post("<?php echo url('album/edit'); ?>",{album_name:album_name,album_info:album_info,album_id:album_id},function(res){
						layer.msg(res.msg,{time:1000}, function(){
							window.location.href=res.url;
						});
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