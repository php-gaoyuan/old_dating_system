<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:70:"/www/wwwroot/www.pauzzz.com/app/application/index/view/user/index.html";i:1546612494;s:73:"/www/wwwroot/www.pauzzz.com/app/application/index/view/public/footer.html";i:1546609312;s:71:"/www/wwwroot/www.pauzzz.com/app/application/index/view/public/chat.html";i:1536164042;}*/ ?>
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
		            			<?php if($userinfo['user_group'] == '3'): ?>
		            			<span class="mui-icon iconfont icon-vip" style="color:#fead11;    font-size: 1.2em;"></span>
		            			<?php elseif($userinfo['user_group'] == '4'): ?>
								<span class="mui-icon iconfont icon-diamond" style="color:#007aff;    font-size: 1.1em;"></span>
		            			<?php endif; ?>
		            			<?php echo $userinfo['user_name']; ?>
		            		</span><br>
		            		<span style="display: inline-block;">$<?php echo number_format($userinfo['golds'],2); ?></span>
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
		                <span class="cell_desc"><?php if($userinfo['user_group'] == '3'): ?><?php echo lang('vip_member'); elseif($userinfo['user_group'] == '4'): ?><?php echo lang('vip_yj_member'); else: ?><?php echo lang('upgrade_sub_btn'); endif; ?></span>
		            </a>
		        </li>
		        <li class="mui-table-view-cell">
		            <a class="mui-navigate-right" href="<?php echo url('mall/index'); ?>">
		            	<span class="mui-icon iconfont icon-liwu" style="background:#f94d51"></span>
		            	<?php echo lang("gift"); ?>
		            </a>
		        </li>
		        <li class="mui-table-view-cell">
		            <a class="mui-navigate-right" href="<?php echo url('wallet/index'); ?>">
		            	<span class="mui-icon iconfont icon-qianbao" style="background:#ead36f;"></span>
		            	<?php echo lang("wallet"); ?>
		            </a>
		        </li>
		        <li class="mui-table-view-cell">
		            <a class="mui-navigate-right" href="<?php echo url('Cash/index'); ?>">
		            	<span class="mui-icon iconfont icon-tixian1" style="background:#f94d51;"></span>
		            	<?php echo lang("user_cash"); ?>
		            </a>
		        </li>
		    </ul>
		
		<div class="line"></div>
		
		
		<ul class="mui-table-view list">
		        <li class="mui-table-view-cell">
		            <a class="mui-navigate-right">
		            	<span class="mui-icon mui-icon-compose" style="background:#3ab5fb;padding:6px;"></span>
		            	 <?php echo lang("help"); ?>
		            </a>
		        </li>
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
</body>
</html>