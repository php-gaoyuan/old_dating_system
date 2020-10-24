<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:70:"/www/wwwroot/www.partyings.com/app/application/index/view/pals/index.html";i:1527334120;s:73:"/www/wwwroot/www.partyings.com/app/application/index/view/public/footer.html";i:1546609312;s:71:"/www/wwwroot/www.partyings.com/app/application/index/view/public/chat.html";i:1536164042;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"/>
	<meta name="apple-mobile-web-app-capable" content="no" />
	<meta name="format-detection" content="telephone=no,email=no,adress=no"/>
	<title>我的好友</title>
	<link href="<?php echo config('skin_path'); ?>/css/mui.min.css" rel="stylesheet" />
	<link href="<?php echo config('skin_path'); ?>/css/iconfont.css" rel="stylesheet" />
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

		.mui-table-view img#pals_ico{
			width:42px;
			height:42px;
			border-radius: 100%;
    		vertical-align: middle;
		}
		.layui-flow-more{
			display: none;
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
		<ul class="mui-table-view" id="pals_list">
		    
		</ul>
	</div>
	
	
	<!--footer-->
	<link rel="stylesheet" href="<?php echo config('skin_path'); ?>/css/chat.css">

<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/public.js"></script>
<script type="text/javascript" src="<?php echo config('skin_path'); ?>/layui/layui.js"></script>
<script>
  var userinfo = <?php echo $userinfo; ?>;
    var socket = new WebSocket("<?php echo config('webconfig.ws_url'); ?>");
    //连接成功时触发
      socket.onopen = function() {
        socket.send(JSON.stringify({"type": "init", "id": userinfo.user_id, "username": userinfo.user_name, "avatar": userinfo.user_ico, "sign": "", "from": "app", "is_read":"0"}));
      };

      socket.onclose = function() {
        layer.msg("网络已经断开");
      };
      socket.onerror = function() {
        layer.msg("网络链接错误");
      };

      //监听收到的聊天消息，假设你服务端emit的事件名为：chatMessage
      socket.onmessage = function(res) {
          var data = JSON.parse(res.data);
          switch (data['message_type']) {
            // 检测聊天数据
            case 'chatMessage':
              var info = data.data;
              //console.log(data.data);
              $("#pals_list li").each(function(){
                if($(this).data("fid") == info.id){
                  var num_obj = $(this).find(".mui-badge");
                  var num = num_obj.text();
                  if(num == ""){
                    num = 1;
                  }else{
                    num = parseInt(num)+1;
                  }
                  //alert($(this).data("fid"));
                  num_obj.text(num);
                  num_obj.show();
                  $("#pals_list").prepend($(this));
                }
              });

              //底部菜单追加消息数量
              var nums = $("#msg_nums").text();
              $("#msg_nums").text(parseInt(nums)+1);

              //追加声音
              $("body").append("<audio autoplay='true' src='/public/static/default/default.mp3'></audio>");
              setTimeout(function(){
                $("audio").remove();
              }, 2000);
              break;
          }
      };
</script>
<!-- <link rel="stylesheet" type="text/css" href="//at.alicdn.com/t/font_537983_p50sudb7q2xogvi.css"/> -->
<link rel="stylesheet" type="text/css" href="//at.alicdn.com/t/font_537983_m0uxbgjfqg.css"/>
<style>
	.mui-bar a.mui-tab-item{position: relative;}
</style>
<div style="height:60px;"></div>
<nav class="mui-bar mui-bar-tab">
    <a class="mui-tab-item <?php if($act == 'main'): ?> mui-active <?php endif; ?>" href="<?php echo url('main/index'); ?>">
        <span class="mui-icon iconfont icon-zhinanzhen-copy"></span>
        <span class="mui-tab-label"><?php echo lang("footer_nav1"); ?></span>
    </a>
    <a class="mui-tab-item <?php if($act == 'chat'): ?> mui-active <?php endif; ?>" href="<?php echo url('chat/index'); ?>">
    	<span class="mui-badge mui-badge-danger" style="position: absolute;right: 14px;z-index: 999;" id="msg_nums"><?php echo $log_messages; ?></span>
        <span class="mui-icon iconfont icon-xiaoxi"></span>
        <span class="mui-tab-label"><?php echo lang("footer_nav2"); ?></span>
    </a>
    <a class="mui-tab-item <?php if($act == 'mood'): ?> mui-active <?php endif; ?>" href="<?php echo url('mood/index'); ?>">
        <span class="mui-icon mui-icon-pengyouquan"></span>
        <span class="mui-tab-label"><?php echo lang("footer_nav3"); ?></span>
    </a>
    <a class="mui-tab-item <?php if($act == 'pals'): ?> mui-active <?php endif; ?>" href="<?php echo url('pals/index'); ?>">
        <span class="mui-icon iconfont icon-wodehaoyou"></span>
        <span class="mui-tab-label"><?php echo lang("footer_nav4"); ?></span>
    </a>
    
    <a class="mui-tab-item <?php if($act == 'user'): ?> mui-active <?php endif; ?>" href="<?php echo url('user/index'); ?>">
        <span class="mui-icon mui-icon-contact"></span>
        <span class="mui-tab-label"><?php echo lang("footer_nav5"); ?></span>
    </a>
</nav>

	<!--footer end-->
	<!--<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>-->
	<script type="text/javascript" src="<?php echo config('skin_path'); ?>/layui/layui.js"></script>
	<!--<script src="<?php echo config('skin_path'); ?>/js/mui.min.js"></script>-->

	<script type="text/javascript">
		layui.use(['flow','layer','jquery','laytpl'],function(){
			var layer = layui.layer,
				flow = layui.flow,
				laytpl = layui.laytpl,
				$ = layui.jquery;


			var options = {
				elem:"#pals_list",
				done:function(page,next){
					$.getJSON("<?php echo url('pals/get_pals_data'); ?>",{},function(res){
						laytpl($("#list").html()).render(res,function(html){
							next(html,page<res.pages);
						});
					});
				}
			};

			flow.load(options);




			$("#search").click(function(){
				var keyword = $("#keyword").val();
				$.getJSON("<?php echo url('pals/search'); ?>",{keyword:keyword},function(res){
					//res = JSON.parse(res);
					if(res){
						laytpl($("#list").html()).render(res,function(html){
							$("#pals_list").html(html);
						});
					}
				});
			});

		});



	</script>
	<script id="list" type="text/html">
		{{# layui.each(d, function(index,item){ }}

			<li class="mui-table-view-cell">
	            <a class="mui-navigate-right" href="/index/chat/chat/pals_id/{{ item.pals_id }}">
	                <img class="mui-media-object" id="pals_ico" src="{{ item.pals_ico }}">
	                {{ item.pals_name }}
	            </a>
	        </li>
		{{# }); }}
	</script>
</body>
</html>