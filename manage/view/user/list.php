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
			<blockquote class="layui-elem-quote" style="text-align: left;">
				<div class="layui-form">
					<div class="layui-inline">
						<div class="layui-input-inline">
							<input type="text" name="user_name" id="user_name" class="layui-input" placeholder="会员账号">
						</div>
					</div>

					<div class="layui-inline">
						<label class="layui-form-label">状态：</label>
						<div class="layui-input-inline">
							<select id="is_pass" name="is_pass">
								<option value="all">全部</option>
								<option value="1">启用</option>
								<option value="0">禁用</option>
							</select>
						</div>
					</div>

					<div class="layui-inline">
						<label class="layui-form-label">性别：</label>
						<div class="layui-input-inline">
							<select id="user_sex" name="user_sex">
								<option value="all">全部</option>
								<option value="1">男</option>
								<option value="0">女</option>
							</select>
						</div>
					</div>

					<div class="layui-inline">
						<label class="layui-form-label">是否会员：</label>
						<div class="layui-input-inline">
							<select id="user_group" name="user_group">
								<option value="all">全部</option>
								<option value="yes">是</option>
								<option value="no">否</option>
							</select>
						</div>
					</div>

                    <div class="layui-inline">
                        <div class="layui-input-inline">
                            <input type="text" name="reg_date" id="reg_date" class="layui-input" placeholder="注册日期" readonly>
                        </div>
                    </div>

					<div class="layui-inline">
						<div class="layui-input-inline">
							<button class="layui-btn" lay-submit lay-filter="search" id="search">搜索</button>
						</div>
					</div>
				</div>
			</blockquote>
			<table id="table" lay-filter="table"></table>
			<!--记录操作工具条-->
			<script type="text/html" id="bar">
				<a class="layui-btn layui-btn-xs" lay-event="resetPass">重置密码</a>
				<a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
			</script>


			<script type="text/html" id="tuid">
				{{# if(d.tuid == '0'){ }}
				<button type="button" class="layui-btn layui-btn-sm layui-btn-danger" lay-event="tuid">未分配</button>
				{{# }else{ }}
				<button type="button" class="layui-btn layui-btn-sm" lay-event="tuid">{{d.tuname}}</button>
				{{# } }}
			</script>



			<script type="text/html" id="userGroup">
				{{# if(d.user_group > 1){ }}
				<button type="button" class="layui-btn layui-btn-sm" lay-event="userGroup">是</button>
				{{# }else{ }}
				<button type="button" class="layui-btn layui-btn-sm layui-btn-danger" lay-event="userGroup">否</button>
				{{# } }}
			</script>

            <script type="text/html" id="view_gift">
                <input type="checkbox" value="{{d.user_id}}" lay-skin="switch" lay-text="开启|关闭"
                       lay-filter="is_view_gift" {{ d.is_view_gift== 1 ? 'checked' : '' }}>
            </script>
		


			<script type="text/html" id="jinyongTpl">
				<input type="checkbox" value="{{d.user_id}}" lay-skin="switch" lay-text="正常|冻结"
					   lay-filter="is_pass" {{ d.is_pass== 1 ? 'checked' : '' }}>
			</script>

			

			<script type="text/html" id="lookChatRecordTpl">
				<button type="button" class="layui-btn layui-btn-sm" lay-event="lookChatLog">查看聊天记录</button>
			</script>

			<script type="text/html" id="lookImgTpl">
				<button type="button" class="layui-btn layui-btn-sm" lay-event="lookImg">查看照片</button>
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
	layui.use(["jquery", "form", "layer","table","laydate"], function () {
		var $ = layui.jquery;
		var layer = layui.layer;
		var form = layui.form;
		var laydate = layui.laydate;
		var table = layui.table;
		laydate.render({
			elem: "#reg_date",
			range: true
		});


		var options = {
			elem: '#table',
			url: "/manage/controller/User.php",
			where: {},
			cols: [[
				{field:'user_id', title: 'ID',width:80},
				{title: '会员账号/性别/年龄',width:170,templet:function(d){
					//alert("ok");
					var user_sex = '男';
					if(d.user_sex=='0'){
						user_sex= '女';
					}
					var age = (new Date()).getFullYear()-d.birth_year;
					return d.user_name+'/'+user_sex+'/'+age;
					}},
				{title: '头像',width:80,templet:function(d){
						return '<img src="/'+d.user_ico+'" class="layui-circle" style="width:50px;" onerror="this.src=\'/Public/adminnew/images/default_header.png\';">';
					}},
				//{field: 'country', title: '国籍'},
				{title: '绑定员工',templet:"#tuid",width:90},
				//{title: '照片墙',width:100,templet:"#photoWall"},
				{field: 'user_email', title: '邮箱',width:200},
				//{field: 'reg_ip', title: '注册IP',width:150},
				//{field: 'last_ip', title: '最后登录IP',width:150},
				{field: 'is_view_gift', title: '礼物权限',templet:"#view_gift",width:110},
				{field: 'reg_address', title: '注册地址',width:180,templet:function(d){
				    return d.reg_address+'('+d.zhuce_ip+')';
                    }},
				{title: '是否会员',templet:"#userGroup",width:100},
				{title: '会员级别',width:190,templet:function(d){
					if(d.user_group==1){
						return '普通会员';
					}else if(d.user_group==2){
						return '白金会员（'+d.end_date+'）';
					}else if(d.user_group == 3){
						return '钻石会员（'+d.end_date+'）';
					}
					}},
				{field: 'golds', title: '剩余金币数',width:100,edit:'text'},
				//{title: '总是在线',templet:"#alwaysOnlineTpl",width:110},
				//{title: '审核',width:100,templet:"#shenheTpl",width:110},
				{title: '禁用/启用',width:100,templet:"#jinyongTpl",width:110},
				//{title: '禁言',width:100,templet:"#jinyanTpl",width:110},
				{title: '查看聊天记录',width:130,templet:"#lookChatRecordTpl"},
				//{title: '查看照片',width:100,templet:"#lookImgTpl"},
				{field: 'reg_from',title: '终端',width:80},
				{field: 'user_add_time', title: '注册时间',width:170},
				{title:"操作",templet:"#bar",width:160,fixed: "right"}
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
			if (layEvent == 'tuid') {
				layui.layer.open({
					type: 2,
					title: "分配",
					fixed: true,
					maxmin: true,
					area: ["50%", "50%"],
					content: "/manage/view/user/change_tuid.php?id=" + data.user_id
				})
			} else if (layEvent == 'userGroup') {
				layui.layer.open({
					type: 2,
					title: "调整会员级别",
					fixed: true,
					maxmin: true,
					area: ["50%", "50%"],
					content: "/manage/view/user/change_group.php?id=" + data.user_id
				})
			}else if (layEvent == 'lookChatLog') {
				layui.layer.open({
					type: 2,
					title: "查看聊天记录",
					fixed: true,
					maxmin: true,
					area: ["80%", "95%"],
					content: "/manage/view/chat/list_log.php?user_id=" + data.user_id
				})
			} else if (layEvent == 'lookImg') {
				layui.layer.open({
					type: 2,
					title: "查看照片",
					fixed: true,
					maxmin: true,
					area: ["80%", "95%"],
					content: "{:U('Photo/showlist')}?user_id=" + data.id
				})
			} else if (layEvent == 'del') {
				layer.confirm('您确定要删除'+data.user_email+'吗？', function (index) {
					$.post("/manage/controller/User.php?act=delUser", {user_id: data.user_id}, function (res) {
						layer.alert(res.msg,function(){
							window.location.reload();
						});
						return false;
					},"json");
					layer.close(index);
				})
			} else if (layEvent == 'resetPass') {
				layer.confirm('您确定要重置'+data.user_email+'的密码吗？', function (index) {
					$.post("/manage/controller/User.php?act=resetPass", {user_id: data.user_id}, function (res) {
						layer.alert(res.msg);
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
        form.on('switch(is_view_gift)', function (obj) {
            var user_id = this.value;
            $.post("/manage/controller/User.php?act=changeIsViewGift", {user_id: user_id}, function (res) {
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