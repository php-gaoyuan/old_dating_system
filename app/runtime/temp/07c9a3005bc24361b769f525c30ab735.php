<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"/www/wwwroot/www.partyings.com/app/application/index/view/photo/index.html";i:1567989608;}*/ ?>
<!doctype html>
<html>

	<head>
		<meta charset="UTF-8">
		<title><?php echo lang("home_title"); ?></title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link href="<?php echo config('skin_path'); ?>/css/mui.min.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="//at.alicdn.com/t/font_537983_p50sudb7q2xogvi.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo config('skin_path'); ?>/css/user.css">
		<link rel="stylesheet" type="text/css" href="<?php echo config('skin_path'); ?>/layui/css/layui.css">
		<style>
			img{display: block;width:100%;padding:5px;}
			.img_div{position: relative;border:1px solid #ccc;}
			.img_div span{position: absolute;top:0;right:0;background: #007aff;color:#fff;}
		</style>
	</head>

	<body>
		<?php if(!$is_h5_plus): ?>
		<header class="mui-bar mui-bar-nav">
		    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
		    <h1 class="mui-title"><?php echo lang("home_title"); ?></h1>
		</header>
		<?php endif; ?>
		<div class="mui-content" style="padding:54px 0 10px;">
			<div class="up-box" style="text-align:center">
				<div class="layui-upload-drag" id="bindUp">
					<i class="layui-icon">&#xe67c;</i>
					<p>Upload a picture, one or more</p>
					<input class="layui-upload-file" type="file" accept="image" name="file">
				</div>

				<!-- <div style="padding:10px 10px 0 10px;"><button class="mui-btn mui-btn-block mui-btn-primary" style="line-height:5px;">Submit</button></div> -->
			</div>




			<div class="mui-row" style="margin:10px 0;padding:10px 10px 10px;background:#fff;" id="list">
				<?php if(is_array($photo_list) || $photo_list instanceof \think\Collection || $photo_list instanceof \think\Paginator): $i = 0; $__LIST__ = $photo_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				<div class="mui-col-xs-4 img_div" >
					<img src="http://www.partyings.com/<?php echo (isset($vo['photo_src']) && ($vo['photo_src'] !== '')?$vo['photo_src']:'uploadfiles/album/logo.jpg'); ?>" alt="">
					<span class="mui-icon mui-icon-closeempty del" data-id="<?php echo $vo['photo_id']; ?>"></span>
				</div>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
		</div>




		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/layui/layui.js"></script>

		<script type="text/javascript">
			layui.use(["upload","jquery"],function(){
				var $=layui.jquery;
				var upload = layui.upload;

				var album_id = "<?php echo $album_id; ?>";
				
				//执行实例
				 var uploadInst = upload.render({
				    elem: '#bindUp', //绑定元素
				    url: "<?php echo url('Photo/add'); ?>", //上传接口
				    data:{
				    	album_id:album_id
				    },
				    accept:"images",
					acceptMime:"image/*",
				    //multiple:true,
				    done: function(res){
				      //上传完毕回调
				      	var html = '<div class="mui-col-xs-4 img_div"><img src="'+res.data.src+'" alt=""><span class="mui-icon mui-icon-closeempty del" data-id="'+res.data.photo_id+'"></span></div>';
				      	$("#list").prepend(html);


				      	$(".del").click(function(){
				      		var photo_id = $(this).data("id");
				      		$.get("<?php echo url('photo/del'); ?>", {id:photo_id}, function(res){
				      			window.location.reload();
				      		});
				      	});
				    },
				    error: function(){
				      //请求异常回调
				    }
				});

				$(".del").click(function(){
		      		var photo_id = $(this).data("id");
		      		$.get("<?php echo url('photo/del'); ?>", {id:photo_id}, function(res){
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