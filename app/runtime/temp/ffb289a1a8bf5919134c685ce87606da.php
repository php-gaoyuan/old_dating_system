<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"/www/wwwroot/www.partyings.com/app/application/index/view/cash/index.html";i:1602502927;}*/ ?>
<!doctype html>
<html>

	<head>
		<meta charset="UTF-8">
		<title><?php echo lang('user_cash'); ?></title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link href="<?php echo config('skin_path'); ?>/css/mui.min.css" rel="stylesheet" />
		<style type="text/css">
			.mui-input-group .mui-input-row{min-height: 40px;height: auto;}
		</style>
	</head>

	<body>
		<?php if(!$is_h5_plus): ?>
		<header class="mui-bar mui-bar-nav">
		    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
		    <h1 class="mui-title"><?php echo lang('user_cash'); ?></h1> 
		</header>
		<?php endif; ?>
		<div class="mui-content">
			<p style="margin-top:10px;padding:0 10px;"><?php echo $lang['cash_bm']; ?></p>
			<form class="mui-input-group">
			    <div class="mui-input-row">
			        <!-- <label><?php echo $lang['cash_country']; ?></label> -->
			    	<input type="text" class="mui-input-clear" id="city" placeholder="<?php echo $lang['cash_country']; ?>">
			    </div>
			    <div class="mui-input-row">
			        <!-- <label><?php echo $lang['cash_cardnum']; ?></label> -->
			        <input type="text" class="mui-input-password" id="card_code" placeholder="<?php echo $lang['cash_cardnum']; ?>">
			    </div>
			    <div class="mui-input-row">
			        <!-- <label><?php echo $lang['cash_name']; ?></label> -->
			    	<input type="text" class="mui-input-clear" id="name" placeholder="<?php echo $lang['cash_name']; ?>">
			    </div>
			    <div class="mui-input-row">
			        <!-- <label><?php echo $lang['cash_money']; ?></label> -->
			    	<input type="text" class="mui-input-clear" id="money" placeholder="<?php echo $lang['cash_money']; ?>">
			    </div>
			    <div class="mui-button-row">
			        <button type="button" class="mui-btn mui-btn-primary" id="sub" ><?php echo $lang['sub_title']; ?></button>
			        <button type="button" class="mui-btn mui-btn-danger" ><?php echo $lang['cash_cancel']; ?></button>
			    </div>
			</form>
		</div>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/public.js"></script>
		<script type="text/javascript">
			$(function(){
			var tips = "<?php echo $lang['tip_fail']; ?>";
			
			$('#sub').on('click', function (e) {
				var city = $("#city").val();
				var card_code = $("#card_code").val();
				var name = $("#name").val();
				var money = $("#money").val();
				if(city == ""){
					$("#city").css({"border-top":"1px solid red","border-bottom":"1px solid red"});
					return false;
				}else{
					$("#city").css({"border-top":"1px solid #ccc","border-bottom":"1px solid #ccc"});
				}
				if(card_code == ""){
					$("#card_code").css({"border-top":"1px solid red","border-bottom":"1px solid red"});
					return false;
				}else{
					$("#card_code").css({"border-top":"1px solid #ccc","border-bottom":"1px solid #ccc"});
				}
				if(name == ""){
					$("#name").css({"border-top":"1px solid red","border-bottom":"1px solid red"});
					return false;
				}else{
					$("#name").css({"border-top":"1px solid #ccc","border-bottom":"1px solid #ccc"});
				}
				if(money == ""){
					$("#money").css({"border-top":"1px solid red","border-bottom":"1px solid red"});
					return false;
				}else{
					$("#money").css({"border-top":"1px solid #ccc","border-bottom":"1px solid #ccc"});
				}
				tips = tips.replace(/name/,name);
				tips = tips.replace(/money/,money);
				$.post("",{city:city,card_code:card_code,name:name,money:money},function(res){
					alert(tips);
				});
			  	
              	$("input").each(function(){
                	$(this).val("");
                });
			})
		});
		</script>
	</body>

</html>