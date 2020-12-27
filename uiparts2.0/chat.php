<?php
//引入语言包
require_once($webRoot . $langPackageBasePath . "chat.php");
$chatlp = new chatlp;

/******************查询出用户信息*****************************/
if (empty($userinfo)) {
    $user_id = $_SESSION["user_id"];
    $userinfo = $dbo->getRow("select user_id,user_name,user_sex,user_group,golds from wy_users where user_id='{$user_id}'","arr");
}
//如果是普通会员查询出已经发送信息条数
if($userinfo['user_group']<2){
    $msg_num = $dbo->getAll("select count(id) as msg_num from chat_log where fromid='{$user_id}'","arr");
    $msg_num = $msg_num[0]['msg_num']?$msg_num[0]['msg_num']:0;
}
if (empty($userinfo["user_ico"])) {
    $userinfo["user_ico"] = "/skin/default/jooyea/images/d_ico_{$userinfo['user_sex']}.gif";
}

//查询出签名
//$sign = $dbo->getRow("select u_intro from chat_users where uid='{$chat_user_id}'");
//$userinfo["sign"] = $sign["u_intro"];
/***********************查询出用户信息 end************************/
?>


<link rel="stylesheet" type="text/css" href="/skin/gaoyuan/layui/css/layui.css">
<script type="text/javascript" src="/skin/gaoyuan/layui/layui.js"></script>
<style type="text/css">
    body{text-align: left;}
    .layim-chat-send .layim-menu-box{width: 265px;}
    .layim-tab-content{height: 519px;}
    .tr{padding: 10px;float: left;margin: 0;}
    body .layim-chat-tool span.layim-tool-redpacket{background: url(/skin/gaoyuan/images/redpacket.png) center center no-repeat;background-size: 32px 28px;width: 32px;height: 38px;}
    body .layui-layim-status,body .layui-layim-remark{display:none;}
    body .layui-layim-info{height: 26px;}
    .layim-chat-mine .layim-chat-text{min-height:22px;}
</style>
<script type="text/javascript">
    var ws_url = "<?php echo $ws_url;?>";
    var ws=null;
    var heartTimer=null;
    var limit_msg_num=5;
    var open_chat=null;
    //初始化配置
    var userinfo = {
        user_id: "<?= $userinfo['user_id']?>",
        user_name: "<?= $userinfo['user_name']?>",
        user_ico: "<?= $userinfo['user_ico']?>",
        user_sex: "<?= $userinfo['user_sex']?>",
        user_group: "<?= $userinfo['user_group']?>",
        golds: "<?= $userinfo['golds']?>",
        msg_num:"<?php echo $msg_num;?>"
    };

    layui.use(["layim", "layer", "form"], function () {
        var layim = layui.layim, form = layui.form, layer = layui.layer;
        //初始化聊天窗口基础配置
        layim.config({
            title: "<?= $userinfo['user_name']?>",
            isgroup: false,
            copyright: true,
            //isAudio:true,
            //isVideo:true,
            notice:true,
            maxLength: 6000,
            chatLog: '/uiparts2.0/chat_log.php', //聊天记录页面地址，若不开启，剔除该项即可
            init: {
                url: "/chat.php?act=init",
            },
            //上传图片接口（返回的数据格式见下文），若不开启图片上传，剔除该项即可
            uploadImage: {
                url: '/app/index.php/index/Api/upload_img.html', //接口地址
                type: 'post' //默认post
            },
            tool: [{
                alias: 'redpacket', //工具别名
                title: 'redpacket', //工具名称
                icon: '' //工具图标，参考图标文档
            }],
        });
        //打开一个临时会话窗口
        open_chat = function (id, name, user_ico) {
            //判断权限
            if (userinfo.user_group <2 && userinfo.msg_num>=limit_msg_num) {
                layer.msg("<?php echo $chatlp->nomianfeichat;?>",{time:2000},function(){
                    window.location.href = "/main2.0.php?app=user_upgrade";
                });
                return false;
            }
            //获取个人信息
            $.getJSON("chat.php?act=get_userinfo", {user_id: id}, function (res) {
                layim.chat({
                    id: id, //好友id
                    name: res.username, //名称
                    avatar: res.avatar, //头像
                    type: 'friend', //聊天类型
                    status: "online",
                    sign: res.sign,
                    username: res.username
                });
            });
        }
        //阻止发送并撤回消息
        var refundMsg = function(fid){
            var thatChat = layim.thisChat();
            thatChat.elem.find(".layim-chat-main>ul li:last-child").remove();
            //清除本地缓存的消息
            var cache =  layui.layim.cache();
            var local = layui.data('layim')[cache.mine.id]; //获取当前用户本地数据
            var logs = local.chatlog["friend"+fid];
            var newLogs = [];
            for(var x in logs){
                if(x<logs.length-1){
                    newLogs[x] = logs[x];
                }
            }
            //这里以删除本地聊天记录为例
            local.chatlog["friend"+fid]=newLogs;
            //向localStorage同步数据
            layui.data('layim', {
                key: cache.mine.id
                ,value: local
            });
        }
        //监听发送消息
        layim.on('sendMessage', function (res) {
            if (userinfo.user_group <2 && userinfo.msg_num>=limit_msg_num) {
                //阻止发送并撤回消息
                refundMsg(res.to.id);
                layer.msg("<?php echo $chatlp->nomianfeichat;?>",{time:2000},function(){
                    window.location.href = "/main2.0.php?app=user_upgrade";
                });
                return;
            }else if (userinfo.user_group <2){
                userinfo.msg_num++;
            }
            doReq("chatMsg",res);
        });
        //监听点击红包按钮
        layim.on('tool(redpacket)', function (insert, send, obj) {
            layer.prompt({
                title: '<?php echo $chatlp->hongbao;?>',
                //formType: 2,
                shade: 0,
                btn: ['<?php echo $chatlp->send;?>', '<?php echo $chatlp->cancle;?>']
            }, function (text, index) {
                var regPos = /^\d+(\.\d+)?$/; //非负浮点数
                if(!regPos.test(text) || parseFloat(text)<=0){
                    layer.msg("<?php echo $chatlp->money_error;?>");
                    return false;
                }
                if (parseFloat(userinfo.golds) < parseFloat(text)) {
                    layer.msg("<?php echo $chatlp->money_buzu;?>");
                    return false;
                } else {
                    layer.close(index);
                    insert('紅包金額(金幣)：' + text); //将内容插入到编辑器，主要由insert完成
                    send(); //自动发送
                }

            });
        });
        //每次窗口打开或切换，即更新对方的状态
        layim.on('chatChange', function (thatChat) {
            //console.log(thatChat);
            //打开窗口后更新消息状态为已读
            doReq("readMsg",{user_id:userinfo.user_id,fid:thatChat.data.id});
            //判断权限
            if (userinfo.user_group <2 && userinfo.msg_num>=limit_msg_num) {
                thatChat.textarea.attr("disabled", true);
                thatChat.elem.find(".layim-chat-send").remove();
                layer.msg("<?php echo $chatlp->nomianfeichat;?>",{time:2000},function(){
                    window.location.href = "/main2.0.php?app=user_upgrade";
                });
                return false;
            }
            //更新当前会话状态
            if (thatChat.data.status == "online") {
                layim.setChatStatus('<span style="color:#FF5722;">online</span>');
            } else if (thatChat.data.status == "offline") {
                layim.setChatStatus('<span style="color:#ccc;">offline</span>');
            }
            //更新最近聊天数据
            $.get("chat.php?act=chatChange", {pals_id: thatChat.data.id}, function (res) {});
        });



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
        var doOpen = function(e){
            console.log('链接成功');
            doReq("init",{
                id: userinfo.user_id, //我的ID
                username: userinfo.user_name, //我的昵称
                avatar: userinfo.user_ico, //我的头像
                from: "pc",
            });
            doReq("logMsg",{user_id:userinfo.user_id});
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
                    doReq("ping",{user_id:userinfo.user_id});
                    break;
                // 登录 更新用户列表
                case 'init':
                    layim.setFriendStatus(msg.id, 'online');
                    break;
                // 检测聊天数据
                case 'chatMsg':
                    //如果聊天窗口一直打开，那么更新为已读
                    thatChat = layim.thisChat();
                    if (thatChat != undefined) {
                        doReq("readMsg", {user_id:userinfo.user_id,fid: thatChat.data.id});
                    }
                    layim.getMessage(msg.data);
                    break;
                // 离线消息推送
                case 'logMsg':
                    layui.each(msg.data,function(index,item){
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
        var doReq = function(type,msg){
            var msg = msg||{};
            switch (type) {
                case "init":
                    break;
                case "chatMsg":
                    break;
                case "readMsg":
                    break;
            }
            var data = $.extend({type:type},msg);
            //console.log(data);
            ws.send(JSON.stringify(data));
        }
        //初始化websocket链接
        freshSocket();
    });
</script>