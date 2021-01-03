<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:74:"/www/wwwroot/www.dsrramtcys.com/app/application/index/view/user/index.html";i:1609062678;s:77:"/www/wwwroot/www.dsrramtcys.com/app/application/index/view/public/footer.html";i:1609051846;s:75:"/www/wwwroot/www.dsrramtcys.com/app/application/index/view/public/chat.html";i:1609328193;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<title><?php echo lang("user_title"); ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo config('skin_path'); ?>/css/mui.min.css"/>
	<style>
		.line{height: 10px;}
		.list .mui-icon{
			background: blue;
			color:#fff;
			padding:10px;
			border-radius: 100%;
		}
		.user_img_box{}
		.user_ico{display:block; width:50px;height:50px;border-radius: 100%;vertical-align: middle;margin-right: 10px;float: left;}
		.user_txt{float: left;vertical-align: middle;line-height: 1.5em;}
		.lev_ico{display: inline-block;width: 20px;height: 20px;background: url();}
		.clear{clear: both;}
		.cell_desc{float: right;line-height: 2.5em;margin-right: 20px;font-size: 14px;color: #ccc;}
		/*body .mui-content{background: url("/public/static/mobile/images/page_bg2.jpg") 0 0 repeat;background-size:100%;background-attachment: fixed;min-height:700px;}*/
		/*body .mui-table-view{background: rgba(255,255,255,0.75)}*/
	</style>
</head>
<body>
	<header class="mui-bar mui-bar-nav">
	    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <h1 class="mui-title"><?php echo lang("user_title"); ?></h1>
	</header>
	<div class="mui-content">
		<ul class="mui-table-view">
		        <li class="mui-table-view-cell">
		            <a class="mui-navigate-right user_img_box" href="<?php echo url('profile/index'); ?>">
		                <img src="<?php echo $userinfo['user_ico']; ?>" class="user_ico"/>
		            	<div class="user_txt">
		            		<span style="display: inline-block;">
		            			<?php if($userinfo['user_group'] == '2'): ?>
		            			<span class="mui-icon iconfont icon-vip" style="color:#fead11;    font-size: 1.2em;"></span>
		            			<?php elseif($userinfo['user_group'] == '3'): ?>
								<span class="mui-icon iconfont icon-diamond" style="color:#007aff;    font-size: 1.1em;"></span>
		            			<?php endif; ?>
		            			<?php echo $userinfo['user_name']; ?>
		            		</span><br>
		            		<span style="display: inline-block;"><?php echo number_format($userinfo['golds'],2); ?></span>
		            	</div>
		            	<div class="clear"></div>
		            </a>
		        </li>
		    </ul>
		
		<div class="line"></div>
		<ul class="mui-table-view list">
		        <li class="mui-table-view-cell">
		            <a class="mui-navigate-right" href="<?php echo url('upgrade/index'); ?>">
		                <span class="mui-icon iconfont icon-crown" style="background:#f69b0b"></span>
		                <?php echo lang("vip"); ?>
		                <span class="cell_desc"><?php if($userinfo['user_group'] == '2'): ?><?php echo lang('vip_member'); elseif($userinfo['user_group'] == '3'): ?><?php echo lang('vip_yj_member'); else: ?><?php echo lang('upgrade_sub_btn'); endif; ?></span>
		            </a>
		        </li>
		        <li class="mui-table-view-cell">
		            <a class="mui-navigate-right" href="<?php echo url('mall/index'); ?>">
		            	<span class="mui-icon iconfont icon-liwu" style="background:#f94d51"></span>
		            	<?php echo lang("gift"); ?>
		            </a>
		        </li>
		        <li class="mui-table-view-cell">
		            <a class="mui-navigate-right" href="<?php echo url('giftbox/index'); ?>">
		            	<span class="mui-icon iconfont icon-liwu" style="background:#f94d51"></span>
		            	<?php echo lang("giftbox"); ?>
		            </a>
		        </li>
		        <li class="mui-table-view-cell">
		            <a class="mui-navigate-right" href="<?php echo url('recharge/index'); ?>">
		            	<span class="mui-icon iconfont icon-qianbao" style="background:#ead36f;"></span>
						<?php echo lang('recharge'); ?>
		            </a>
		        </li>
<!--		        <li class="mui-table-view-cell">-->
<!--		            <a class="mui-navigate-right" href="<?php echo url('Cash/index'); ?>">-->
<!--		            	<span class="mui-icon iconfont icon-tixian1" style="background:#f94d51;"></span>-->
<!--		            	<?php echo lang("user_cash"); ?>-->
<!--		            </a>-->
<!--		        </li>-->
		    </ul>
		
		<div class="line"></div>
		
		
		<ul class="mui-table-view list">
<!--		        <li class="mui-table-view-cell">-->
<!--		            <a class="mui-navigate-right">-->
<!--		            	<span class="mui-icon mui-icon-compose" style="background:#3ab5fb;padding:6px;"></span>-->
<!--		            	 <?php echo lang("help"); ?>-->
<!--		            </a>-->
<!--		        </li>-->
		        <li class="mui-table-view-cell">
		            <a class="mui-navigate-right" href="<?php echo url('set/index'); ?>">
		            	<span class="mui-icon mui-icon-gear" style="background:#3ab5fb;padding:6px;"></span>
		            	<?php echo lang("set"); ?>
		            </a>
		        </li>
		    </ul>
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
</body>
</html>