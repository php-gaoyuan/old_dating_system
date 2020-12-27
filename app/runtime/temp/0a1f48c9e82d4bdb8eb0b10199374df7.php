<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"/www/wwwroot/www.dsrramtcys.com/app/application/index/view/chat/chat.html";i:1609053264;}*/ ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>chat</title>
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<link rel="stylesheet" type="text/css" href="<?php echo config('skin_path'); ?>/layui/css/layui.mobile.css"/>
	<link rel="stylesheet" href="<?php echo config('skin_path'); ?>/css/chat.css">
	<style>
		.layim-chat-tool span.layim-tool-phone:active{background: #d4d4d4;padding:0 5px;}
		body .layim-chat-tool span.layim-tool-redpacket{background: url("<?php echo config('skin_path'); ?>/images/redpacket.png") center center no-repeat;background-size: 32px 28px;width:32px;height: 38px;}
	</style>
</head>
<body>
<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo config('skin_path'); ?>/layui/layui.js"></script>
<script>
	var userinfo = <?php echo $userinfo; ?> ;
	userinfo.msg_num = <?php echo $msg_num; ?>;
	var pals_userinfo = <?php echo $pals_userinfo; ?> ;
	var ws_url = "<?php echo config('webconfig.ws_url'); ?>";
	var ws = null;
	var heartTimer = null;
	var limit_msg_num = 5;
	var open_chat = null;


	layui.use(["mobile", "jquery", 'layer'], function () {
		var mobile = layui.mobile, layim = mobile.layim, $ = layui.jquery, layer = mobile.layer, pclayer = layui.layer;

		//初始化聊天
		layim.config({
			title: 'dsrramtcys',
			brief: true,
			notice: true,
			copyright: true,
			init: {
				mine: {
					id: userinfo.user_id,
					username: userinfo.user_name,
					avatar: userinfo.user_ico,
					sign: ""
				}
			},
			//上传图片接口
			uploadImage: {
				url: "<?php echo url('Api/upload_img'); ?>"
			},
			//可同时配置多个
			tool: [{
				alias: 'redpacket',
				title: '紅包',
				iconUnicode: '',
				iconClass: 'tool-redpacket' //图标字体的class类名
			}]
		});
		//监听点击红包按钮
		layim.on('tool(redpacket)', function (insert, send, obj) {
			pclayer.prompt({
				title: '紅包金額(金幣)',
				shade: 0,
				btn: ['發送', '取消']
			}, function (text, index) {
				if (parseFloat(text) <= 0) {
					layer.msg("請填寫大於0的金額！");
					return false;
				}
				if (parseFloat(userinfo.golds) < parseFloat(text)) {
					pclayer.msg("餘額不足，請充值！");
					return false;
				} else {
					pclayer.close(index);
					insert('紅包金額(金幣)：' + text); //将内容插入到编辑器，主要由insert完成
					send(); //自动发送
				}
			});
		});
		//监听发送消息
		layim.on('sendMessage', function(res) {
			if (userinfo.user_group < 2 && userinfo.msg_num>= limit_msg_num) {
				$(".layim-chat-send input").attr("disabled", true);
				layer.msg("<?php echo lang('need upgrade'); ?>");
				setTimeout(function(){
					window.location.href = "<?php echo url('upgrade/index'); ?>";
				},2000);
				return false;
			}else{
				if(userinfo.user_group < 2){
					userinfo.msg_num++;
				}
				doReq("chatMsg",res);
			}
		});



		var freshSocket = function () {
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
		var doOpen = function (e) {
			console.log('链接成功');
			doReq("init", {
				id: userinfo.user_id, //我的ID
				username: userinfo.user_name, //我的昵称
				avatar: userinfo.user_ico, //我的头像
				from: "app",
			});
			doReq("logMsg",{user_id:userinfo.user_id});
			doReq("readMsg", {user_id:userinfo.user_id,fid: pals_userinfo.user_id});
			doHeart();
		};
		var doHeart = function () {
			doReq("ping", {user_id:userinfo.user_id});
			heartTimer = setTimeout(doHeart, 3000);
		};
		var doClose = function (event) {
			console.log("通讯已经断开");
			setTimeout(freshSocket, 1000);
			if (heartTimer != null) {
				clearTimeout(heartTimer);
				heartTimer = null;
			}
		};
		//监听收到的聊天消息，假设你服务端emit的事件名为：chatMessage
		var doAck = function (res) {
			var msg = JSON.parse(res.data);
			switch (msg.type) {
					// 服务端ping客户端
				case "ping":
					doReq("ping", {user_id:userinfo.user_id});
					break;
					// 登录 更新用户列表
				case 'init':
					layim.setFriendStatus(msg.id, 'online');
					break;
					// 检测聊天数据
				case 'chatMsg':
					//如果聊天窗口一直打开，那么更新为已读
					doReq("readMsg", {user_id:userinfo.user_id,fid: pals_userinfo.user_id});
					layim.getMessage(msg.data,msg.type);
					break;
					// 离线消息推送
				case 'logMsg':
					layui.each(msg.data, function (index, item) {
						layim.getMessage(item);
					})
					break;
					// 用户退出 更新用户列表
				case 'logout':
					layim.setFriendStatus(msg.id, 'offline');
					break;
					//动态添加好友
				case 'addlist':
					layim.addList(msg.data);
					break;
			}
		};
		//发送消息
		var doReq = function (type, msg) {
			var msg = msg || {};
			switch (type) {
				case "init":
					break;
				case "chatMsg":
					break;
				case "readMsg":
					break;
			}
			var data = $.extend({type: type}, msg);
			//console.log(data);
			ws.send(JSON.stringify(data));
		}



		//初始化websocket链接
		freshSocket();
		//创建会话
		layim.chat({
			id: pals_userinfo.user_id,
			name: pals_userinfo.user_name,
			avatar: pals_userinfo.user_ico,
			type: "friend"
		});
		//打开页面就开始判断权限
		if (userinfo.user_group < 2 && userinfo.msg_num>= limit_msg_num) {
			$(".layim-chat-send input").attr("disabled", true);
			layer.msg("<?php echo lang('need upgrade'); ?>");
			// setTimeout(function(){
			// 	window.location.href = "<?php echo url('upgrade/index'); ?>";
			// },5000);
			return false;
		}
		$(".layim-chat-send input").focus();



		//判断并添加聊天记录按钮
		if ($(".layim-chat-system>span").attr("layim-event") != "chatLog") {
			$(".layim-chat-main").prepend('<div class="layim-chat-system"><span layim-event="chatLog"><?php echo lang('chatlog'); ?></span></div>');
		}
		//监听查看更多记录
		layim.on('chatlog', function (data, ul) {
			console.log(data); //得到当前会话对象的基本信息
			console.log(ul); //得到当前聊天列表所在的ul容器，比如可以借助他来实现往上插入更多记录
			$.getJSON("<?php echo url('chat/chat_log'); ?>", {pals_id: pals_userinfo.user_id}, function (res) {
				layim.panel({
					//标题
					title: 'Chat with ' + data.name,
					//模版
					tpl: $("#chatlog_tpl").val(),
					//数据
					data: res.data
				});
			});

		});
		//监听返回
		layim.on('back', function () {
			history.back();
			//window.location.href = "<?php echo url('chat/index'); ?>";
		});
	});
</script>

<textarea title="聊天记录" id="chatlog_tpl" style="display:none;">
		<div class="layim-chat layim-chat-friend"><div class="layim-chat-main">
		{{# if(d.data.length>0){ }}
			<ul>
			{{# layui.each(d.data, function(index, item){ }}
				{{# if(item.id == userinfo.user_id){ }}
			    	<li class="layim-chat-li layim-chat-mine"><div class="layim-chat-user"><img src="{{ item.avatar }}"><cite><i>{{ (item.timestamp) }}</i>{{ item.username }}</cite></div><div class="layim-chat-text">{{ layui.mobile.layim.content(item.content) }}</div></li>
			  	{{# } else { }}
			    	<li calss="layim-chat-li"><div class="layim-chat-user"><img src="{{ item.avatar }}"><cite>{{ item.username }}<i>{{ (item.timestamp) }}</i></cite></div><div class="layim-chat-text">{{ layui.mobile.layim.content(item.content) }}</div></li>
			  	{{# } }}
			{{# }); }}
			</ul>
		{{# }else{ }}
			<div class="layim-chat-system"><span >No Data</span></div>
		{{# } }}
		</div></div>
	</textarea>
</body>
</html>