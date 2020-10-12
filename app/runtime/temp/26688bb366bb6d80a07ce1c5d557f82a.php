<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"/www/wwwroot/www.pauzzz.com/app/application/index/view/profile/headimg.html";i:1528700148;}*/ ?>
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
			.up-img{
				width: 50%;
				margin:10px auto;
				text-align: center;
				border: 1px solid #ccc;
				background: #fff;
			}
			.up-img i{
				font-size: 12em;
				color:#ccc;
			}
		</style>
	</head>

	<body>
		<header class="mui-bar mui-bar-nav">
		    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
		    <h1 class="mui-title"><?php echo lang("home_title"); ?></h1>
		    <button class="mui-btn mui-btn-primary mui-pull-right" style="margin-top:-2px;" id="sub">保存</button>
		</header>
		
		<div class="mui-content" style="padding:54px 0 10px;">
		<?php if($user_ico): ?>
		<div class="up-img" id="bindUp">
			<img src="<?php echo $user_ico; ?>" alt="">
		</div>
		<?php else: ?>
		<div class="up-img" id="bindUp">
			<i class="layui-icon">&#xe654;</i>
		</div>
		<?php endif; ?>
		</div>




		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/layui/layui.js"></script>

		<script type="text/javascript">
			layui.use(["upload","jquery"],function(){
				var $=layui.jquery;
				var upload = layui.upload;

				
				
				//执行实例
				 var uploadInst = upload.render({
				    elem: '#bindUp', //绑定元素
				    url: "<?php echo url('profile/upimg'); ?>", //上传接口
				    
				    //multiple:true,
				    done: function(res){
				      //上传完毕回调
				      	var html = '<img src="<?php echo config("webconfig.pc_url"); ?>'+res.data.src+'" alt="">';
				      	$("#bindUp").empty();
				      	$("#bindUp").html(html);
				    },
				    error: function(){
				      //请求异常回调
				    }
				});

				//保存
				$("#sub").click(function(){
					var imgsrc = $("#bindUp").find("img").attr("src");
					$.get("<?php echo url('profile/headimg'); ?>",{user_ico: imgsrc},function(res){
						layer.msg("ok",{time:1000}, function(){window.location.href='<?php echo url('profile/index'); ?>'});
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