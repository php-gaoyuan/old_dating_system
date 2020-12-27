<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title></title>
    <script src="/skin/gaoyuan/layui/layui.js"></script>
    <link rel="stylesheet" href="/skin/gaoyuan/layui/css/layui.css">
</head>
<body>
<div class="layui-fluid">
    <div class="layui-card" style="padding:15px;">
        <span class="layui-card-body">
            <div class="layui-form layui-form-pane">
                <div class="layui-form-item">

                    <div class="layui-inline">
                        <div class="layui-input-inline">
                            <input type="text" name="user_name" autocomplete="off" class="layui-input" placeholder="会员账号">
                        </div>
                    </div>


                    <div class="layui-inline">
                        <label class="layui-form-label">用户级别</label>
                        <div class="layui-input-inline">
                            <select name="user_group">
                                <option value="all">全部</option>
                                <option value="1">普通会员</option>
                                <option value="2">白金会员</option>
                                <option value="3">钻石会员</option>
                            </select>
                        </div>
                    </div>



                    <div class="layui-inline">
                        <div class="layui-input-inline">
                            <button class="layui-btn" lay-submit lay-filter="search" id="search">搜索</button>
                        </div>
                    </div>

                </div>
            </>

            <blockquote class="layui-elem-quote">
                总人数：<span id="total_user">0.00</span>
            </blockquote>
            <table id="table" lay-filter="table"></table>
    </div>
</div>
</div>

<script>
    layui.use(['form','table','jquery'],function(){
        var form = layui.form;
        var $ = layui.jquery;
        var table = layui.table;


        var options = {
            elem: '#table',
            url: "api/user.php",
            where: {},
            cols: [[
                {field:'user_id', title: '会员ID'},
                {field:'user_name', title: '会员账号'},
                {field:'user_email', title: '会员邮箱'},
                {field:'message', title: '会员级别(到期时间)',templet:function(d){
                    if(d.user_group == 1){
                        return "普通会员（"+d.end_date+"）";
                    }else if(d.user_group == 2){
                        return "白金会员（"+d.end_date+"）";
                    }else if(d.user_group == 3){
                        return "钻石会员（"+d.end_date+"）";
                    }
                    }},
                {field:'user_add_time', title: '注册时间'},
                {field:'lastlogin_datetime', title: '最后登录时间'},
            ]],
            page: true,
            limit:10,
            loading: true,
            done: function (res, cur, pages) {
                $("#total_user").text(res.count);
            }
        };
        var tableIns = table.render(options);

        form.on("submit(search)", function (res) {
            var data = res.field;
            options["where"] = data;
            tableIns.reload(options);
            return false;
        });

    })
</script>
</body>
</html>