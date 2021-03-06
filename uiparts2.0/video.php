<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="UTF-8">
	<title>video</title>
	<link rel="stylesheet" href="//at.alicdn.com/t/font_603393_shoxgzvfe46rms4i.css">
	<style>
		body{
			margin: 0;
			padding: 0;
			font-size: 12px;
		}
		.video-box{
			background: #323232;
			color: #fff;
		}
		.title{
			/*height: 36px;*/
			padding:10px;
			text-align: right;
		}
		.content{
			background: #6695CB;
			text-align: center;
    		padding: 15% 0;
		}
		.footer{
			padding:10px;
		}
		.f-l{
			float: left;
			vertical-align: middle;
			line-height: 24px;
		}
		.f-r{
			float: right;
			background: #E44A4A;
			color: :#fff;
			border-radius: 3px;
			padding: 5px 15px;
		}
		.cl{
			clear: both;
		}
		.iconfont{
			font-size: 15px;
		}
		@-webkit-keyframes spin{
	        form{
	            -webkit-transform:rotate(0deg)
	        }
	        to{
	            -webkit-transform:rotate(360deg)
	        }
	    }
		.jiazai{
			width: 50%;
			margin: 0 auto;
			font-size:35px;
			display: block;
			animation: spin 3s infinite linear running;
			-webkit-animation:spin 3s infinite linear running;
		}
	</style>
</head>
<body>
	<div class="video-box" id="video-box">
		<div class="title">
			<!-- <span class="iconfont icon-suoxiao close"></span>
			<span class="iconfont icon-xiaoxitixingchuangkoudanchufangshi close"></span> -->
			<span class="iconfont icon-guanbi close"></span>
		</div>
		<div class="content">
			<span class="iconfont icon-jiazai jiazai"></span>
			<br>
			視訊連接中...
		</div>
		<div class="footer">
			<div class="f-l">網絡緩衝...</div>
			<div class="f-r close">掛斷</div>
			<div class="cl"></div>
		</div>
	</div>
	<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
	<script>
		$(function(){
			var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
			console.log(index);
			$(".close").click(function(){
				//$("#video-box").hide();
				parent.layui.layer.close(index);
			});
		});
	</script>
</body>
</html>