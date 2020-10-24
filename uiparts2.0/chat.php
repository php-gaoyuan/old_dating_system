<?php
//引入语言包
require_once($webRoot . $langPackageBasePath . "chat.php");
$chatlp = new chatlp;

/******************查询出用户信息*****************************/
$chat_user_id = $_SESSION["isns_user_id"];
if (empty($userinfo)) {
    $userinfo = $dbo->getRow("select user_id,user_name,user_sex,user_group,golds from wy_users where user_id='$chat_user_id'");
}
if (empty($userinfo["user_ico"])) {
    $userinfo["user_ico"] = "https://{$_SERVER['HTTP_HOST']}/skin/default/jooyea/images/d_ico_{$userinfo['user_sex']}.gif";
}

//查询出签名
$sign = $dbo->getRow("select u_intro from chat_users where uid='{$chat_user_id}'");
$userinfo["sign"] = $sign["u_intro"];
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
</style>
<script type="text/javascript">
    layui.use(["layim", "layer", "form"], function () {
        var layim = layui.layim, form = layui.form, layer = layui.layer;

        //初始化websocket链接
        var socket = new WebSocket("<?=$ws_url; ?>");
        //初始化配置
        var chat = {
            userinfo: {
                user_id: "<?= $userinfo['user_id']?>",
                user_name: "<?= $userinfo['user_name']?>",
                user_ico: "<?= $userinfo['user_ico']?>",
                user_sex: "<?= $userinfo['user_sex']?>",
                user_group: "<?= $userinfo['user_group']?>",
                golds: "<?= $userinfo['golds']?>",
                sign: "<?= $userinfo['sign']?>"
            }
        };

        //初始化聊天窗口基础配置
        layim.config({
            init: {
                url: "/chat.php?act=init",
            },
            //上传图片接口（返回的数据格式见下文），若不开启图片上传，剔除该项即可
            uploadImage: {
                url: '/app/index.php/index/Api/upload_img.html', //接口地址
                type: 'post' //默认post
            },
            title: 'Partying-IM',
            isgroup: false,
            copyright: true,
            //isAudio:true,
            //isVideo:true,
            maxLength: 6000,
            //可同时配置多个
            tool: [
                {
                    alias: 'redpacket', //工具别名
                    title: 'redpacket', //工具名称
                    icon: '' //工具图标，参考图标文档
                }
                // ,{
                //     alias: 'video', //工具别名
                //     title: 'video', //工具名称
                //     icon: '&#xe6ed;' //工具图标，参考图标文档
                // }
            ],
            chatLog: '/uiparts2.0/chat_log.php' //聊天记录页面地址，若不开启，剔除该项即可
        });

        //监听点击红包按钮
        layim.on('tool(redpacket)', function (insert, send, obj) {
            layer.prompt({
                title: '<?php echo $chatlp->hongbao;?>',
                //formType: 2,
                shade: 0,
                btn: ['<?php echo $chatlp->send;?>', '<?php echo $chatlp->cancle;?>']
            }, function (text, index) {
                // console.log(chat.userinfo.golds);
                // console.log(text);
                var regPos = /^\d+(\.\d+)?$/; //非负浮点数
                if(!regPos.test(text) || parseFloat(text)<=0){
                    layer.msg("<?php echo $chatlp->money_error;?>");
                    return false;
                }
                if (parseFloat(chat.userinfo.golds) < parseFloat(text)) {
                    layer.msg("<?php echo $chatlp->money_buzu;?>");
                    return false;
                } else {
                    layer.close(index);
                    insert('紅包金額(金幣)：' + text); //将内容插入到编辑器，主要由insert完成
                    send(); //自动发送
                }

            });
        });
        //监听点击视频按钮
        layim.on('tool(video)', function (insert, send, obj) { //事件中的tool为固定字符，而code则为过滤器，对应的是工具别名（alias）
            //提示男士升级
            if (chat.userinfo.user_sex == '1' && chat.userinfo.user_group < 3) {
                //弹出升级提示
                layer.msg("Your level does not match, Please upgrade.");
                // setTimeout(function(){
                // 	window.location.href="/main2.0.php?app=user_upgrade";
                // },2000);
                return false;
            } else {
                layer.open({
                    type: 2,
                    title: false,
                    area: ['884px', '417px'],
                    skin: 'video-class',
                    closeBtn: false,
                    content: '/uiparts2.0/video.php'
                });
            }
        });


        //监听发送消息
        layim.on('sendMessage', function (res) {
            var sendMsg = JSON.stringify({
                type: 'chatMessage', //随便定义，用于在服务端区分消息类型
                data: res
            });
            $(".layui-show .tr_select option:first").attr('selected', true);
            socket.send(sendMsg);
        });


        //每次窗口打开或切换，即更新对方的状态
        layim.on('chatChange', function (res) {
            //判断权限
            if (chat.userinfo.user_group ==1) {
                $(".layui-show .layim-chat-textarea textarea").attr("disabled", true);
                //layer.msg("您不是VIP用户不能使用即时聊天，请充值升级");
                layer.msg("<?php echo $chatlp->nomianfeichat;?>");
                setTimeout(function () {
                    window.location.href = "/main2.0.php?app=user_upgrade";
                }, 2000);
                return false;
            }

            //*****************************************修正非法用户问题；打开窗口如果是临时会话判断是否在历史会员中********************************************
            // var history_data = JSON.parse(localStorage.getItem("layim"));
            // console.log(history_data["undefined"]);
            // var linshi_user_info=new Array();
            // linshi_user_info["friend"+res.id]={
            // 		avatar:res.avatar,
            // 		historyTime:new Date().getTime(),
            // 		id:res.id,
            // 		name:res.username,
            // 		sign:"",
            // 		status:"online",
            // 		type:"friend",
            // 		username:res.username,
            // 	};

            // if(typeof history_data[chat.userinfo.user_id]["history"]["friend"+res.id] == "undefined"){
            // 	// var new_friend = {
            // 	// 	new_friend_key:linshi_user_info
            // 	// }
            // 	// history_data[chat.userinfo.user_id]["history"].push(new_friend);
            // 	history_data[chat.userinfo.user_id]["history"].push(linshi_user_info);
            // }
            // //插入缓存
            // console.log(history_data);
            // localStorage.setItem("layim",JSON.stringify(history_data));
            //*******************************修正非法用户end***********************************************************

            //输入框自动获取焦点
            $(".layui-show .layim-chat-send input").focus();


            //更新当前会话状态
            if (res.data.status == "online") {
                layim.setChatStatus('<span style="color:#FF5722;">online</span>');
            } else if (res.data.status == "offline") {
                layim.setChatStatus('<span style="color:#ccc;">offline</span>');
            }


            var pals_id = res.data.id;
            //打开窗口后更新消息状态为已读
            socket.send('{"type":"changeMessage","pals_id":' + res.data.id + '}');
            //更新最近聊天数据
            $.get("chat.php?act=chatChange", {pals_id: pals_id}, function (res) {
            });


            //***********************************************加入翻译列表***********************************************
            if ($(".layui-show .tr").length <= 0) {
                $(".layui-show .layim-chat-bottom").prepend("<div class='tr'><select name='tr' class='tr_select'><option value='0'>不翻译</option><option value='en'>English</option><option value='zh'>简体中文</option><option value='cht'>繁体中文</option><option value='kor'>한국어</option><option value='jp'>Japanese</option></select></div>");
            }
            //翻译事件
            $(".layui-show .tr_select").change(function () {
                var val = $(this).val();
                var txt = $(".layui-show .layim-chat-textarea textarea").val();
                if (val == "0") {
                    return;
                } else {
                    if (txt.trim() != "") {
                        $.get("fanyi.php", {fid: chat.userinfo.user_id, lan: txt, tos: val}, function (res) {
                            if (res == 0) {
                                layer.msg("<?php echo $chatlp->money_buzu;?>");
                                return false;
                            }
                            $(".layui-show .layim-chat-textarea textarea").val(trims(res));
                        });
                    }
                }
            });
            function trims(testStr) {
                var resultStr = testStr.replace(/\ +/g, ""); //去掉空格
                resultStr = testStr.replace(/[ ]/g, "");    //去掉空格
                resultStr = testStr.replace(/[\r\n]/g, ""); //去掉回车换行
                return resultStr;
            }
            //***********************************************加入翻译列表end***********************************************

            //判断权限
            if (chat.userinfo.user_group == 1) {
                $(".layui-show .layim-chat-textarea textarea").attr("disabled", true);
                //layer.msg("您不是VIP用户不能使用即时聊天，请充值升级");
                layer.msg("<?php echo $chatlp->nomianfeichat;?>");
                setTimeout(function () {
                    window.location.href = "/main2.0.php?app=user_upgrade";
                }, 2000);
            }
        });


        //监听在线状态切换
        layim.on('online', function (status) {
            //获得online或者hide
            $.get("chat.php?act=change_online", {status: status}, function (res) {
            });
        });

        //监听修改签名
        layim.on('sign', function (value) {
            //获得新的签名
            $.get("chat.php?act=change_sign", {sign: value}, function (res) {
            });
        });


        //连接成功时触发
        socket.onopen = function () {
            socket.send(JSON.stringify({
                "type": "init",
                "from": "pc",
                "is_read": "0",
                "id": chat.userinfo.user_id, //我的ID
                "username": chat.userinfo.user_name, //我的昵称
                "avatar": chat.userinfo.user_ico, //我的头像
                "sign": chat.userinfo.sign,
                "pals_id": 0
            }));
        };


        socket.onclose = function () {
            //layui.layer.msg("通讯已经断开");
            layer.msg("Communication has been closed");
        };
        socket.onerror = function (evt) {
            //layer.msg("通讯错误，已经中断");
            layer.msg("Communication error has been interrupted");
            socket.close();
        };

        //监听收到的聊天消息，假设你服务端emit的事件名为：chatMessage
        socket.onmessage = function (res) {
            var data = JSON.parse(res.data);
            //console.log(data);
            switch (data.message_type) {
                // 服务端ping客户端
                case 'ping':
                    socket.send('{"type":"ping"}');
                    break;
                // 登录 更新用户列表
                case 'init':
                    console.log("----开始初始化");
                    layim.setFriendStatus(data.id, 'online');
                    break;
                // 检测聊天数据
                case 'chatMessage':
                    //console.log("info");
                    //如果聊天窗口一直打开，那么更新为已读
                    if ($(".layim-chat-list .layim-this").length > 0) {
                        thatChat = layim.thisChat();
                        //console.log(thatChat);
                        socket.send('{"type":"changeMessage","pals_id":' + thatChat.data.id + '}');
                    }
                    layim.getMessage(data.data);
                    break;
                // 离线消息推送
                case 'logMessage':
                    console.log("logMessage");
                    //setTimeout(function(){layim.getMessage(data.data);}, 1000);
                    layim.getMessage(data.data);
                    break;
                // 用户退出 更新用户列表
                case 'logout':
                    layim.setFriendStatus(data.id, 'offline');
                    break;
                //动态添加好友
                case 'addlist':
                    layim.addList(data.data);
                    break;
            }
        };
    });


    //打开一个临时会话窗口
    function open_chat(id, name, user_ico) {
        var layim = layui.layim;
        console.log(layui.layim);
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
</script>