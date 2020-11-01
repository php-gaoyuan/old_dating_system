<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>
        后台管理系统
    </title>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <form class="layui-form LayerForm" onsubmit="return false;">
                <div class="layui-form-item">
                    <label class="layui-form-label">原始密码：</label>
                    <div class="layui-input-inline">
                        <input type="password" name="oldpass" id="oldpass" placeholder="请输入原始密码" autocomplete="off" class="layui-input" lay-verify="required"/>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">新密码：</label>
                    <div class="layui-input-inline">
                        <input type="password" name="userpass" id="userpass" placeholder="请输入新密码" autocomplete="off" class="layui-input" lay-verify="required"/>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">确认密码：</label>
                    <div class="layui-input-inline">
                        <input type="password" name="userpass2" id="userpass2" placeholder="请再次输入密码" autocomplete="off" class="layui-input" lay-verify="required"/>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block" >
                        <span class="layui-btn" lay-submit lay-filter="sub">修改</span>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<link rel="stylesheet" href="/skin/gaoyuan/layui/css/layui.css">
<script type="text/javascript" src="/skin/gaoyuan/layui/layui.js"></script>
<script>
    layui.use(["jquery", "form", "layer"], function () {
        var $ = layui.jquery,
            layer = layui.layer,
            form = layui.form;

        form.on("submit(sub)", function (data) {
            $.getJSON("api/admin.php?act=editpwd", data.field, function (res) {
                if (res.code > 0) {
                    layer.alert(res.msg,  function () {
                        window.location.reload();
                    });
                    return;
                }else{
                    layer.msg('密码修改成功!',{time:2000},function(){
                        window.location.reload();
                    });
                }
            });
        })
    });
</script>
</body>
</html>