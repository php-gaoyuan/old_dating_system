<?php
require("includet.php");
$url = "https://dsrramtcys.com?tuid=".get_session("wz_userid");
?>
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
            <div class="layui-form layui-form-pane">
                <div class="layui-form-item">

                    <div class="layui-inline">
                        <div class="layui-input-inline">
                            <input type="text" name="user_name" autocomplete="off" class="layui-input" placeholder="会员账号">
                        </div>
                    </div>

                    <div class="layui-inline">
                        <div class="layui-input-inline">
                            <button class="layui-btn" lay-submit lay-filter="search" id="search">搜索</button>
                        </div>
                    </div>

                </div>
            </div>
            <table id="table" lay-filter="table"></table>
        </div>
    </div>
</div>
<link rel="stylesheet" href="/skin/gaoyuan/layui/css/layui.css">
<script type="text/javascript" src="/skin/gaoyuan/layui/layui.js"></script>
<script>
    layui.use(["jquery","form","table"],function(){
        var $ = layui.jquery;
        var form = layui.form;
        var table = layui.table;
        var options = {
            elem: '#table',
            url: "api/bang.php",
            where: {},
            cols: [[
                {field:'user_id', title: '会员ID'},
                {field:'user_name', title: '会员账号'},
                {title: '操作',templet:function(d){
                        if(d.tuid>'0'){
                            return "该会员已经绑定";
                        }else if(d.tuid=='0'){
                            return "<button class=\"layui-btn layui-btn-danger layui-btn-sm\" lay-event='bang'>绑定会员</butotn>";
                        }
                    }},
            ]],
            page: true,
            limit:10,
            loading: true,
            done: function (res, cur, pages) {

            }
        };
        var tableIns = table.render(options);

        table.on('tool(table)', function (obj) {
            var data = obj.data;
            var layEvent = obj.event;
            var tr = obj.tr;
            if (layEvent == 'bang') {
                layer.confirm('您确定要绑定'+data.user_name+'吗？', function (index) {
                    $.post("api/bang.php?act=act_bang", {user_id: data.user_id}, function (res) {
                        layer.alert(res.msg,function(){
                            window.location.reload();
                        });
                        return false;
                    },"json");
                    layer.close(index);
                })
            }
        })

        form.on("submit(search)", function (res) {
            var data = res.field;
            options["where"] = data;
            tableIns.reload(options);
            return false;
        });
    })
</script>
</body>