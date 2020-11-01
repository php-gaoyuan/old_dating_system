<?php 
require("../../session_check.php");
//初始化数据库
$dbo = new dbex;
dbtarget('w', $dbServs);

$user_id = intval($_GET["id"]);
$userinfo = $dbo->getRow("select tuid from wy_users where user_id={$user_id}","arr");
$tuid = $userinfo["tuid"];
$sql = "select * from wy_wangzhuan";
$staff_list = $dbo->getALL($sql,'arr');
//halt($staff_list);
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
						<label class="layui-form-label">选择员工：</label>
						<div class="layui-input-inline">
							<select id="tuid" name="tuid">
								<option value="">==请选择==</option>
								<?php foreach($staff_list as $k=>$vo):?>
								<option value="<?php echo $vo['id']; ?>" <?php if($vo['id']==$tuid){echo "selected";}?>><?php echo $vo['name']; ?></option>
								<?php endforeach; ?>
							</select>
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
	layui.use(["jquery", "form", "layer"], function () {
		var $ = layui.jquery;
		var layer = layui.layer;
		var form = layui.form;

		form.on("submit(sub)", function (res) {
			//console.log(res);return;
			$.post("/manage/controller/User.php?act=changeTuid",{user_id:user_id,tuid:res.field.tuid},function(res){
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