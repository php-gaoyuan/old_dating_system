<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:70:"/www/wwwroot/www.pauzzz.com/app/application/index/view/main/index.html";i:1572265998;s:73:"/www/wwwroot/www.pauzzz.com/app/application/index/view/public/footer.html";i:1546609312;s:71:"/www/wwwroot/www.pauzzz.com/app/application/index/view/public/chat.html";i:1536164042;}*/ ?>
<!doctype html>
<html>

	<head>
		<meta charset="UTF-8">
		<title><?php echo lang('main_title'); ?></title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link href="<?php echo config('skin_path'); ?>/css/mui.min.css" rel="stylesheet" />
		
		<style type="text/css">
			.card-img{
    			overflow: hidden;
			}
			.mui-content{
				padding-bottom:60px;
			}
			.icon-blue{color:#007aff;}
			@media screen and (max-width: 400px) {
				.mui-ellipsis{
					width: 65px;
	    			display: inline-block;
				}
			}
			
		</style>
	</head>

	<body>
		<header class="mui-bar mui-bar-nav">
		    <a class="mui-icon iconfont icon-zuanshi mui-pull-left icon-blue" href="<?php echo url('upgrade/index'); ?>"></a>
		    <h1 class="mui-title"><?php echo lang('main_title2'); ?></h1>
		    <a class="mui-icon mui-icon-search mui-pull-right" href="<?php echo url('search/index'); ?>"></a>
		</header>
		
		<div class="mui-content">
			<div class="mui-row" id="list">
			    
			    
			</div>
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
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/public.js"></script>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/function.js"></script>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/layui/layui.js"></script>
		<script type="text/javascript">
			
			layui.use(["flow","laytpl","layer"],function(){
				var flow=layui.flow,
					laytpl=layui.laytpl,
					layer=layui.layer,
					$=layui.jquery;
				var tpl = $("#tpl-list").html();
				


				var options = {
					elem:"#list",
					isAuto:true,
					done:function(page,next){
						var html = "";
						$.getJSON("/index/main/query/page/"+page+".html",{},function(res){
							if(res.msg){
								layer.msg(res.msg);
								setTimeout(function(){
									window.location.href=res.url;
								},2000);
								return false;
							}
							laytpl(tpl).render(res,function(_html){
								html += _html;
							});
							next(html, page < res.pages);
						});
						
					}
				};
				//加载数据
				flow.load(options);
				//flow.lazyimg();
			});


			function imgResize(obj){
				obj.style.width = "100%";
				var width = obj.clientWidth;
				//alert(width);
				obj.style.height = width+"px";
				obj.style.maxHeight = width+"px";
			}
		</script>
 

		<script id="tpl-list" type="text/html">
			{{# layui.each(d.list,function(index,item){ }}
			<div class="mui-col-sm-6 mui-col-xs-6">
				
		    	<div class="mui-card">
					<!--内容区-->
					<style>
						.headimg a{
							display: block;
						}
						.headimg a img{border-radius: 100%;}
					</style>
					<div class="mui-card-content card-img headimg">
						<a href="/index/home/index/uid/{{ item.user_id }}">
						<img src="{{ item.user_ico }}" onload="imgResize(this);" style="max-height: 168px;width:100%;"/>
						</a>
					</div>
					<!--页脚，放置补充信息或支持的操作-->
					<div class="mui-card-footer">
						<div class="mui-pull-left">
							{{# if(item.user_group == "3"){ }}
							<span class="mui-icon iconfont icon-vip" style="color:#fead11;    font-size: 1.5em;"></span>
							{{# }else if(item.user_group == "4"){ }}
							<span class="mui-icon iconfont icon-diamond" style="color:#007aff;    font-size: 1.2em;"></span>
							{{# } }}
							<span class="mui-ellipsis">{{ item.user_name }}</span>
						</div>
						<div class="mui-pull-right">
							<span class="mui-icon iconfont icon-jiahaoyou" onclick="addFriend('{{ item.user_id }}')" {{# if(item.online_id>0){ }}style="color:#11c111;"{{#  } }}></span>
						</div>
					</div>
				</div>
				
		    </div>
		    {{# }); }}
		</script>
	</body>
</html>