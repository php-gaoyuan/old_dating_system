<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:74:"/www/wwwroot/www.dsrramtcys.com/app/application/index/view/mood/index.html";i:1609051846;s:77:"/www/wwwroot/www.dsrramtcys.com/app/application/index/view/public/footer.html";i:1609051846;s:75:"/www/wwwroot/www.dsrramtcys.com/app/application/index/view/public/chat.html";i:1609328193;}*/ ?>
<!doctype html>
<html>

	<head>
		<meta charset="UTF-8">
		<title><?php echo lang('mood_title'); ?></title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link href="<?php echo config('skin_path'); ?>/css/mui.min.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="<?php echo config('skin_path'); ?>/css/user.css">
		<style type="text/css">
			.layui-flow-more{text-align: center;display:none;}
			.item{
				background-color: #fff;
			}
			/*body .mui-content{background: url("/public/static/mobile/images/page_bg2.jpg") 0 0 repeat;background-size:100%;background-attachment: fixed;min-height:700px;}*/
			/*body .item{background: rgba(255,255,255,0.75)}*/
		</style>
	</head>

	<body>
		<header class="mui-bar mui-bar-nav">
			<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left" href="<?php echo url('chat/index'); ?>"></a>
		    <h1 class="mui-title"><?php echo lang('mood_title'); ?></h1>
		    <a class="mui-pull-right" style="line-height:44px;font-size:14px;" href="<?php echo url('mood/add'); ?>"><?php echo lang("fabiao"); ?></a>
		</header>
		<div class="mui-content">
            <div class="user-news" id="newsList"></div> 
		</div>
		<!--footer-->
		
<link rel="stylesheet" href="<?php echo config('skin_path'); ?>/css/chat.css">
<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/public.js"></script>
<script type="text/javascript" src="<?php echo config('skin_path'); ?>/layui/layui.js"></script>
<script>

    <?php if(request()->action()!="chat"): ?>
        var ws_url = "<?php echo config('webconfig.ws_url'); ?>";
        var ws = null;
        var userinfo = <?php echo $userinfo; ?>;

        var freshSocket=function(){
            var bindEvent = function () {
                ws.onclose = doClose;
                ws.onopen = doOpen;
                ws.onmessage = doAck;
            };
            if ('WebSocket' in window) {
                ws = new WebSocket(ws_url);
                bindEvent();
            } else if ('MozWebSocket' in window) {
                ws = new window["MozWebSocket"](ws_url);
                bindEvent();
            }
        };
        //连接成功时触发
        var doOpen = function() {
            doHeart();
            doReq("init",{
                "id": userinfo.user_id,
                "username": userinfo.user_name,
                "avatar": userinfo.user_ico,
                "from": "app"
            });
            doReq("logMsg",{user_id:userinfo.user_id});
        };
        var doHeart = function () {
            doReq("ping", {user_id:userinfo.user_id});
            heartTimer = setTimeout(doHeart, 3000);
        };
        //监听收到的聊天消息，假设你服务端emit的事件名为：chatMessage
        var doAck = function(res) {
            var msg = JSON.parse(res.data);
            switch (msg['type']) {
                // 检测聊天数据
                case 'chatMsg':
                    //console.log(msg.data);
                    showBadge(msg.data);
                    break;
                case 'logMsg':
                    //console.log(msg.data);
                    // layui.each(msg.data,function(index,item){
                    //     showBadge(item);
                    // })
                    break;
            }
        };
        var doReq = function(type,msg){
            var msg = msg||{};
            var data = $.extend({type:type},msg);
            ws.send(JSON.stringify(data));
        }
        var doClose = function (event) {
            console.log("通讯已经断开");
            setTimeout(freshSocket, 1000);
            if (heartTimer != null) {
                clearTimeout(heartTimer);
                heartTimer = null;
            }
        };
        freshSocket();
    <?php endif; ?>

    var showBadge = function(msg){
        $("#pals_list li").each(function(){
            if($(this).data("fid") == msg.id){
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
        $("#msg_nums").text(parseInt(nums)+1).css("display","block");
        //追加声音
        var audio = new Audio();
        audio.src="/public/static/default/default.mp3";
        audio.play();
    }
</script>
<!-- <link rel="stylesheet" type="text/css" href="//at.alicdn.com/t/font_537983_p50sudb7q2xogvi.css"/> -->
<link rel="stylesheet" type="text/css" href="//at.alicdn.com/t/font_537983_m0uxbgjfqg.css"/>
<style>
	.mui-bar a.mui-tab-item{position: relative;}
    .tabbar-icon{}
    .tabbar-icon.icon1{background: url("/public/static/mobile/images/icon/nav-icon1.png") no-repeat;background-size:87%;}
    .tabbar-icon.icon2{background: url("/public/static/mobile/images/icon/nav-icon2.png") no-repeat;background-size:100%;}
    .tabbar-icon.icon3{background: url("/public/static/mobile/images/icon/nav-icon3.png") no-repeat;background-size:115%;}
    .tabbar-icon.icon4{background: url("/public/static/mobile/images/icon/nav-icon4.png") no-repeat;background-size:110%;}
    .tabbar-icon.icon5{background: url("/public/static/mobile/images/icon/nav-icon5.png") no-repeat;background-size:100%;}
</style>
<div style="height:60px;"></div>
<nav class="mui-bar mui-bar-tab">
    <a class="mui-tab-item <?php if($act == 'main'): ?> mui-active <?php endif; ?>" href="<?php echo url('main/index'); ?>">
        <span class="mui-icon tabbar-icon icon1"></span>
        <span class="mui-tab-label"><?php echo lang("footer_nav1"); ?></span>
    </a>
    <a class="mui-tab-item <?php if($act == 'chat'): ?> mui-active <?php endif; ?>" href="<?php echo url('chat/index'); ?>">
    	<span class="mui-badge mui-badge-danger" style="position: absolute;right: 14px;z-index: 999;display: none;" id="msg_nums">0</span>
        <span class="mui-icon tabbar-icon icon2"></span>
        <span class="mui-tab-label"><?php echo lang("footer_nav2"); ?></span>
    </a>
    <a class="mui-tab-item <?php if($act == 'mood'): ?> mui-active <?php endif; ?>" href="<?php echo url('mood/index'); ?>">
        <span class="mui-icon tabbar-icon icon3"></span>
        <span class="mui-tab-label"><?php echo lang("footer_nav3"); ?></span>
    </a>
    <a class="mui-tab-item <?php if($act == 'pals'): ?> mui-active <?php endif; ?>" href="<?php echo url('pals/index'); ?>">
        <span class="mui-icon tabbar-icon icon4"></span>
        <span class="mui-tab-label"><?php echo lang("footer_nav4"); ?></span>
    </a>
    
    <a class="mui-tab-item <?php if($act == 'user'): ?> mui-active <?php endif; ?>" href="<?php echo url('user/index'); ?>">
        <span class="mui-icon tabbar-icon icon5"></span>
        <span class="mui-tab-label"><?php echo lang("footer_nav5"); ?></span>
    </a>
</nav>

		<!--footer end-->
		<!-- <script src="<?php echo config('skin_path'); ?>/js/mui.min.js"></script> -->
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/layui/layui.js"></script>
		<script type="text/javascript">
			layui.use(["flow","laytpl","jquery","layer"],function(){
				var flow=layui.flow,
					laytpl=layui.laytpl,
					layer = layui.layer,
					$=layui.jquery;

				var options = {
					elem:"#newsList",
					isAuto:true,
					done:function(page,next){
						$.getJSON("<?php echo url('mood/index'); ?>",{page:page},function(res){
							laytpl($("#userNews").html()).render(res,function(html){
								next(html,page<res.pages);
							});


							$(".user-news-txt img").click(function(){
								layer.open({
									type:1,
									title:false,
									area:"90%",
									content:"<img src="+$(this).attr("src")+" width='100%'/>",
									cancel:function(){
										layer.closeAll();
									}
								});
							});
							$(".user-news-info-txt a").click(function(){
								return false;
							});

							$(".user-news-txt a").click(function(){
								return false;
							});
						});
					}
				};

				flow.load(options);


				
			});
		</script>



		<script type="text/html" id="userNews">
			{{# layui.each(d.list,function(index,item){ }}
			{{# if(item.user_name!="" && item.user_name!="undefined" && item.user_name!=undefined){ }}
				<div class="item">
					<div class="user-news-info">
						<img src="{{ item.user_ico }}" style="width:50px;">
						<div class="user-news-info-txt mui-ellipsis" style="    font-size: 13px;">
							<span class="user-name">{{ item.user_name }}</span>
							{{ item.title }}
							<div class="user-news-time" style="font-weight:400;font-size:12px;">
								<i class="icon iconfont icon-clock" style="font-size:14px;"></i>
								{{ item.update_time }}
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
			{{# } }}
			{{# }); }}
		</script>
	</body>
</html>