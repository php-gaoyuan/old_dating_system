<?php
require("../foundation/asession.php");
require("../configuration.php");
require("../includes.php");
require("../function.php");
require("../foundation/common.php");

if(!is_ajax()){
    $wz_userid = get_session('wz_userid');
    if ($wz_userid) {
        echo "<script>location.href='index.php';</script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>欢迎登陆</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <style>
        .cap_img_div {
            position: absolute;
            right: 1px;
            top: 1px;
            width: 120px;
            height: 40px;
        }

        .cap_img_div img {
            width: 100%;
            height: 36px;
        }
    </style>
</head>
<body>

<div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login">

    <div class="layadmin-user-login-main" style="    background: #fff;border-radius: 10px;">
        <div class="layadmin-user-login-box layadmin-user-login-header">
            <h2>欢迎登陆</h2>
        </div>
        <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
            <div class="layui-form-item">
                <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="email"></label>
                <input type="text" name="email" id="email" lay-verify="required" placeholder="用户名"
                       class="layui-input">
            </div>
            <div class="layui-form-item">
                <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="userpwd"></label>
                <input type="password" name="userpwd" id="userpwd" lay-verify="required" placeholder="密码" class="layui-input">
            </div>

            <div class="layui-form-item">
                <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="sub">登 陆</button>
            </div>

        </div>
    </div>


</div>

<link rel="stylesheet" href="/skin/gaoyuan/layui/css/layui.css" media="all">
<link rel="stylesheet" href="/skin/gaoyuan/layuiadmin/style/admin.css" media="all">
<link rel="stylesheet" href="/skin/gaoyuan/layuiadmin/style/login.css" media="all">
<script type="text/javascript" src="/skin/gaoyuan/layui/layui.js"></script>
<script type="text/javascript">
    layui.use(["form", "layer", "jquery"], function () {
        var $ = layui.jquery,
            form = layui.form,
            layer = layui.layer;

        form.on("submit(sub)", function (data) {
            $.post("api/login.php?act=login", data.field, function (res) {
                layer.msg(res.msg,{time:2000},function(){
                    if(res.url!=''){
                        window.location = res.url;
                    }
                });
            },'json');
            return false;
        });
    });
</script>
</body>
</html>

