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
			<!-- <blockquote class="layui-elem-quote" style="text-align: left;">
				<div class="layui-form">
					<div class="layui-inline">
						<div class="layui-input-inline">
							<input type="text" name="user_name" id="user_name" class="layui-input" placeholder="聊天对象账号">
						</div>
					</div>

					<div class="layui-inline">
						<div class="layui-input-inline">
							<button class="layui-btn" lay-submit lay-filter="search" id="search">搜索</button>
						</div>
					</div>
				</div>
			</blockquote> -->
			<table id="table" lay-filter="table"></table>
			<!--记录操作工具条-->
			<script type="text/html" id="bar">
				<a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除记录</a>
			</script>

		</div>
	</div>
</div>
<style>
	body .layui-table-cell{height: 50px;}
</style>
<link rel="stylesheet" href="/skin/gaoyuan/layui/css/layui.css">
<script src="/skin/gaoyuan/layui/layui.js"></script>
<script>
	var user_id = "<?php echo intval($_GET['user_id']); ?>";
	layui.use(["jquery", "form", "layer","table","laydate"], function () {
		var $ = layui.jquery;
		var layer = layui.layer;
		var form = layui.form;
		var laydate = layui.laydate;
		var table = layui.table;
		laydate.render({
			elem: "#search_created_start",
			//range: true
		});
		laydate.render({
			elem: "#search_created_end",
			//range: true
		});


		var options = {
			elem: '#table',
			url: "/manage/controller/Chatlog.php",
			where: {user_id:user_id},
			cols: [[
				{field:'id', title: 'ID',width:80},
				{field:'fromname', title: '发送方'},
				{field:'toname', title: '接收方'},
				{title: '聊天类型',templet:function(d){
					if(d.msg_type==1){
						return "文本";
					}else if(d.msg_type==2){
						return "图片";
					}else if(d.msg_type==3){
						return "红包";
					}
				}},
				{field:'content', title: '内容'},
				{field:'timeline', title: '记录时间',width:170},
				{title:"操作",templet:"#bar",width:90,fixed: "right"}
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
			if (layEvent == 'del') {
				layer.confirm('您确定要删除'+data.user_email+'吗？', function (index) {
					$.post("/manage/controller/Chatlog.php?act=delLog", {id: data.id}, function (res) {
						layer.alert(res.msg,function(){
							window.location.reload();
						});
						return false;
					},"json");
					layer.close(index);
				})
			}
		});

		table.on('edit(table)', function(obj){ //注：edit是固定事件名，test是table原始容器的属性 lay-filter="对应的值"
			var gold = obj.value;
			$.post("/manage/controller/User.php?act=changeGold", {user_id: obj.data.user_id,gold:gold}, function (res) {
				layer.alert(res.msg);
				return false;
			},"json");
		});

		//监听状态操作
		form.on('switch(is_pass)', function (obj) {
			var user_id = this.value;
			$.post("/manage/controller/User.php?act=changeIsPass", {user_id: user_id}, function (res) {
				if (res.msg != "") {
					layer.msg(res.msg);
					return false;
				}
			},"json");
		});



		form.on("submit(search)", function (res) {
			var data = res.field;
			options["where"] = data;
			tableIns.reload(options);
			return false;
		});
		
	});
</script>
</body>
</html>