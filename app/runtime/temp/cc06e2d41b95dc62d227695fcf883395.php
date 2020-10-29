<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:68:"/www/wwwroot/www.pauzzz.com/app/application/index/view/mall/pay.html";i:1520094870;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title><?php echo lang('pay'); ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo config('skin_path'); ?>/css/mui.min.css"/>
    <link href="<?php echo config('skin_path'); ?>/css/mall.css" rel="stylesheet"/>
</head>
<body>
	<header class="mui-bar mui-bar-nav">
	    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
	    <h1 class="mui-title"><?php echo lang('pay'); ?></h1>
	</header>
	<div class="mui-content">
		<form class="mui-input-group" method="post" action="">
		    <div class="form-block">
		        <div class="mui-row">
		          <label><?php echo lang('order_info'); ?>:</label>
		          <div class="mui-row-right"><?php echo $info['giftname']; ?></div>	
		        </div>
		        <div class="mui-row">
		          <label><?php echo lang('need_golds'); ?>:</label>
		          <div class="mui-row-right">$<?php echo $info['money']; ?></div>	
		        </div>
		    </div>
		    <div class="form-block">
		    	<div class="form-title"><?php echo lang('select_pay'); ?></div>
		    	<div class="mui-row mui-radio mui-left">
		    	  <label><?php echo lang('upgrade_foy_youself'); ?></label>
		    	  <input name="to_user" type="radio" checked  value="1">	   	
		    	</div>
		    	<div class="mui-row mui-radio mui-left">
		    	  <label><?php echo lang('upgrade_foy_others'); ?></label>
		    	  <input name="to_user" type="radio"  value="2">
		    	  <input type="text" name="friend_name" class="mui-input-clear" placeholder="<?php echo lang('friend_name'); ?>"/>
		    	</div>	    	
		    </div>
		    <div class="form-block">
		    	<div class="form-title"><?php echo lang('zengyan'); ?></div>
		    	<div class="mui-row">
		    		<textarea name="note" rows="5" cols="" class="form-text" id="note"></textarea>
		    	</div>
		    </div>
		    <div class="form-block">
		    	<div class="form-title"><?php echo lang('select_pay_type'); ?></div>
		    	<div class="mui-row mui-checkbox mui-left">
		    		<label style="height: 28px;">
		    			<?php echo lang('golds'); ?>
		    		</label>
		    		<input name="pay_type" type="checkbox" checked value="1">
		    	</div>		    	
		    </div>
		    <div class="form-btn">
		    	<input type="hidden" name="id" value="<?php echo $info['id']; ?>">
		    	<button type="submit" class="mui-btn mui-btn-blue mui-btn-block" id="sub"><?php echo lang('buy'); ?></button>
		    </div>
		    
		</form>
              
	</div>
	<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/public.js"></script>
	<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/mui.min.js"></script>
	<script>
	$(function(){
		$("#sub").click(function(){
			var id = "<?php echo $info['id']; ?>";
			var to_user = $("input[name='to_user']:checked").val();
			var friend_name = $("input[name='friend_name']").val();
			var note = $("#note").val();
			var pay_type = $("input[name='pay_type']:checked").val();
			var data = {
				id:id,
				to_user:to_user,
				friend_name:friend_name,
				note:note,
				pay_type:pay_type
			};
			$.post("<?php echo url('mall/sub_pay'); ?>",data,function(res){
				if(res.msg){
					mui.toast(res.msg);
				}
				if(typeof(res.url) != "undefined"){
					setTimeout(function(){window.location.href=res.url},3000);
				}
			},"json");
			return false;
		});
			
	});
	</script>
</body>
</html>