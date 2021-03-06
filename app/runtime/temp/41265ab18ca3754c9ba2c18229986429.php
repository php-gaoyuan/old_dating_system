<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"/www/wwwroot/www.pauzzz.com/app/application/index/view/search/index.html";i:1567989608;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"/>
	<meta name="apple-mobile-web-app-capable" content="no" />
	<meta name="format-detection" content="telephone=no,email=no,adress=no"/>
	<title>www.pauzzz.com</title>
	<link href="<?php echo config('skin_path'); ?>/css/mui.min.css" rel="stylesheet" />
	<style type="text/css">
		.mui-icon-plus{
			position: absolute;
		    right: 15px;
		    top: 20px;
		}
		.mui-search .mui-placeholder{
			line-height: 43px;
		}
		.mui-bar .mui-search:before{
			margin-top: -22px;
		}
		.mui-bar .mui-input-row .mui-input-clear~.mui-icon-clear, .mui-bar .mui-input-row .mui-input-speech~.mui-icon-speech{
			top:11px;
		}
	</style>
</head>
<body>
	<header class="mui-bar mui-bar-nav">
	    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"  href="javascript:;"></a>
	    <h1 class="mui-title">
    		<div class="mui-input-row mui-search">
	    	    <input type="search" class="mui-input-clear" id="keyword" placeholder="<?php echo lang('search_place'); ?>">
	    	</div>
	    </h1>
	    <a class="mui-icon mui-icon-search mui-pull-right" id="search" href="javascript:;"></a>
	</header>

	<div class="mui-content">
		<ul class="mui-table-view">
		    
		</ul>
	</div>
	<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/public.js"></script>
	<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/function.js"></script>
	<script type="text/javascript" src="<?php echo config('skin_path'); ?>/layui/layui.js"></script>
	<script src="<?php echo config('skin_path'); ?>/js/mui.min.js"></script>

	<script type="text/javascript">
		layui.use(['layer','jquery','laytpl'],function(){
			var layer = layui.layer,
				laytpl = layui.laytpl,
				$ = layui.jquery;
			$("#search").click(function(){
				var keyword = $("#keyword").val();
				$.getJSON("<?php echo url('search/index'); ?>",{keyword:keyword},function(res){
					//res = JSON.parse(res);
					if(res){
						laytpl($("#list").html()).render(res,function(html){
							$(".mui-table-view").html(html);
						});
					}
				});
			});

		});

		// function addFriend(uid){
		// 	$.get("<?php echo url('main/addFriend'); ?>",{uid:uid},function(res){
		// 		mui.toast(res);
		// 	});
		// }



	</script>
	<script id="list" type="text/html">
		{{# layui.each(d, function(index,item){ }}
			<li class="mui-table-view-cell mui-media">
		        <a href="javascript:;">
		            <img class="mui-media-object mui-pull-left" src="{{ item.user_ico }}">
		            <div class="mui-media-body">
		            	{{ item.user_name }}<i class="mui-icon iconfont icon-zuanshi"></i>
		                <p class="mui-ellipsis" style="width:90%;">
		                	{{ item.user_name }}
		                </p>
		            </div>
		        </a>
		        <div class="mui-pull-right mui-icon mui-icon-plus plus" onclick="addFriend('{{ item.user_id }}')"></div>
		    </li>
		{{# }); }}
	</script>
</body>
</html>