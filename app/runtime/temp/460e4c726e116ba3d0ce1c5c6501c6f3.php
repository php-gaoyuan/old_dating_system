<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"/www/wwwroot/www.pauzzz.com/app/application/index/view/upgrade/create_order.html";i:1531497542;}*/ ?>
<!doctype html>
<html>

	<head>
		<meta charset="UTF-8">
		<title><?php echo lang('upgrade_order_title'); ?></title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="<?php echo config('skin_path'); ?>/css/mui.min.css">
		<style>
			.mui-card{
				margin:10px 0;
				border-radius: 0;
			}
			#list{}
			#list .mui-col-sm-4{
				
				
			}
			#list .money{
				display: block;
				text-align: center;
				line-height: 3em;
				margin:10px;
				border: 1px solid #2C6AD8;
				border-radius: 5px;
			}
			#list .money.active{
				background: #2C6AD8;
				color:#fff;
			}
		</style>
	</head>

	<body>
		<?php if(!$is_h5_plus): ?>
		<header class="mui-bar mui-bar-nav">
		    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
		    <h1 class="mui-title"><?php echo lang('upgrade_order_title'); ?></h1>
		</header>
		<?php endif; ?>
		<div class="mui-content">
			<div class="mui-card">
				<div class="mui-card-content">
					<ul class="mui-table-view">
					        <li class="mui-table-view-cell">
					        	<?php echo lang('order_info'); ?>：<?php echo $upgrade_name; ?>
					        </li>
					        <li class="mui-table-view-cell">
					        	<?php echo lang('need_golds'); ?>：
					        	<span style="color:#F89F22;font-weight:700;font-size:1.2em">
					        		$<span id="money"><?php echo $money; ?></span>
					        	</span>
					        </li>
					    </ul>
				</div>
			</div>
			
			<div class="mui-card">
				<div class="mui-card-header">
					<?php echo lang('select_upgrade'); ?>
				</div>
				<div class="mui-card-content">
					<div class="mui-input-row mui-radio mui-left" style="margin: 10px 0;">
						    <label><?php echo lang("upgrade_foy_youself"); ?></label>
						    <input name="to_user" type="radio" value="1" checked>
						</div>
						<div class="mui-input-row mui-radio mui-left" style="    border-top: 1px solid #e4e3e6;">
						    <label style="line-height:40px;">
						    	<?php echo lang("upgrade_foy_others"); ?>
								<input type="text" name="friend" id="friend" placeholder="<?php echo lang('friend_name'); ?>" style="width:40%;font-size:12px;margin: 0px;">
						    </label>
						    <input name="to_user" type="radio" value="2" style="    line-height: 55px;">
						</div>
				</div>
			</div>
			
			<div class="mui-card">
				<div class="mui-card-header">
					<?php echo lang('select_pay_type'); ?>
				</div>
				<div class="mui-card-content">
					<div class="mui-input-row mui-radio mui-left" style="margin:10px 0;">
					    <label><?php echo lang('golds'); ?>($<?php echo $balance; ?>)</label>
					    <input name="pay_type" type="radio" value="1" checked>
					</div>
				</div>
			</div>
			<button type="submit" class="mui-btn mui-btn-blue mui-btn-block" style="width:90%;margin:0 auto;" id="sub"><?php echo lang('upgrade_act_btn'); ?></button>
		</div>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/public.js"></script>
		<script type="text/javascript">
			$(function(){
				$("#sub").click(function(){
					var money = $("#money").text();
					var to_user = $("input[name='to_user']:checked").val();
					var friend = $("input[name='friend']").val();
					var pay_type = $("input[name='pay_type']:checked").val();
					if(to_user == "2" && friend == ""){
						$("input[name='friend']").focus();
						alert("<?php echo lang('friend name no empty'); ?>");
						return false;
					}
					var data = {
						money:money,
						to_user:to_user,
						friend:friend,
						pay_type:pay_type
					};
					$.post("<?php echo url('upgrade/create_pay'); ?>",data,function(res){
						if(res.msg){
							alert(res.msg);
							window.location.href=res.url;
						}
					},"json")
				});
					
			});
		</script>
	</body>

</html>