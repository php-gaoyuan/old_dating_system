<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>充值记录</title>
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
                        <div class="layui-input-inline">
                            <input type="text" name="ordernumber" autocomplete="off" class="layui-input" placeholder="商户单号">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">支付方式</label>
                        <div class="layui-input-inline">
                            <select name="pay_method">
                                <option value="all">全部</option>
                                <option value="lianyin">A支付</option>
                                <option value="yingfu">B支付</option>
                            </select>
                        </div>
                    </div>

                    <div class="layui-inline">
                        <div class="layui-input-inline">
                            <input type="text" name="pay_date" id="pay_date" autocomplete="off" class="layui-input" readonly placeholder="选择支付日期">
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
                总充值金额：$<span id="total_money">0.00</span>
            </blockquote>
            <table id="table" lay-filter="table"></table>
    </div>
</div>
</div>

<script>
    layui.use(['form','table','laydate','jquery'],function(){
        var form = layui.form;
        var $ = layui.jquery;
        var table = layui.table;
        var laydate = layui.laydate;
        laydate.render({
            elem: '#pay_date', //指定元素
            range:true
        })

        var options = {
            elem: '#table',
            url: "/manage/controller/Paylog.php",
            where: {},
            cols: [[
                {field:'ordernumber', title: '商户单号',width:160},
                {field:'out_trade_no', title: '通道单号',width:180},
                {field:'uname', title: '会员账号',width:150},
                {field:'funds', title: '交易金额',width:150},
                {field:'message', title: '交易备注',width:200},
                {field:'state', title: '到账状态',width:100,templet:function(d){
                        if(d.state=='0'){
                            return "未支付";
                        }else if(d.state=='1'){
                            return "<button class=\"layui-btn layui-btn-danger layui-btn-sm\">失败</butotn>";
                        }else if(d.state=='2'){
                            return "<button class=\"layui-btn layui-btn-normal layui-btn-sm\">已支付</butotn>";
                        }
                    }},
                {field:'pay_method', title: '支付方式',width:100,templet:function(d){
                        if(d.pay_method=='lianyin'){
                            return "A支付";
                        }else if(d.pay_method=='yingfu'){
                            return "B支付";
                        }else{
                            return "金币支付";
                        }
                    }},
                {field:'pay_from', title: '支付终端',width:100},
                {field:'pay_msg', title: '通道支付结果',width:350},
                {field:'addtime', title: '充值时间',width:170},
            ]],
            page: true,
            limit:10,
            loading: true,
            done: function (res, cur, pages) {
                $("#total_money").text(res.total_money);
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