<?php 
require("../../session_check.php");
//初始化数据库
$dbo = new dbex;
dbtarget('w', $dbServs);

$user_id = intval($_GET["id"]);
$userinfo = $dbo->getRow("select user_id,tuid,user_group from wy_users where user_id={$user_id}","arr");
$upgrade_log = $dbo->getRow("select endtime from wy_upgrade_log where mid={$user_id} and groups='{$userinfo["user_group"]}' and state='0'","arr");

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
			<blockquote class="layui-elem-quote" style="text-align: left;">
				<div class="layui-form">

					<div class="layui-inline">
						<label class="layui-form-label">选择级别：</label>
						<div class="layui-input-inline">
							<select id="user_group" name="user_group">
								<option value="1" <?php if($userinfo['user_group']==1){echo "selected";}?>>==普通会员==</option>
								<option value="2" <?php if($userinfo['user_group']==2){echo "selected";}?>>==白金会员==</option>
								<option value="3" <?php if($userinfo['user_group']==3){echo "selected";}?>>==钻石会员==</option>
							</select>
						</div>
					</div>
					
					<div class="layui-inline">
						<label class="layui-form-label">到期时间：</label>
						<div class="layui-input-inline">
							<input type="text" name="endtime" id="endtime" class="layui-input" placeholder="到期日期" readonly="true" value="<?php echo $upgrade_log["endtime"];?>">
						</div>
					</div>

					<div class="layui-inline">
						<div class="layui-input-inline">
							<button class="layui-btn" lay-submit lay-filter="sub" id="sub">提交</button>
						</div>
					</div>
				</div>
			</blockquote>
		
		</div>
	</div>
</div>
<style>
	body .layui-table-cell{height: 50px;}
</style>
<link rel="stylesheet" href="/skin/gaoyuan/layui/css/layui.css">
<script src="/skin/gaoyuan/layui/layui.js"></script>
<script>
	var user_id="<?php echo $user_id; ?>";
	layui.use(["jquery", "form", "layer", "laydate"], function () {
		var $ = layui.jquery;
		var layer = layui.layer;
		var laydate = layui.laydate;
		var form = layui.form;
		
		laydate.render({
			elem: "#endtime",
		});

		form.on("submit(sub)", function (res) {
			//console.log(res);return;
			$.post("/manage/controller/User.php?act=changeGroup",{user_id:user_id,user_group:res.field.user_group,endtime:res.field.endtime},function(res){
				layer.alert(res.msg,function(){
					parent.layui.layer.closeAll();
				});
			},"json")
			return false;
		});
	});
</script>
</body>
</html>