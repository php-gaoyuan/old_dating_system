<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"/www/wwwroot/www.partyings.com/app/application/index/view/reg/index.html";i:1562821334;}*/ ?>
<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php echo lang("reg_title"); ?></title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link href="<?php echo config('skin_path'); ?>/css/mui.min.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="<?php echo config('skin_path'); ?>/css/reg.css"/>
		<style>
			.up_img{width: 50%;margin:10px auto;text-align: center;}
			.up_img i{font-size: 88px;}
			#user_ico{display: none;}
			.user_ico{border: 1px solid #ccc;border-radius: 100%;max-width: 100px;height: 100px;}
		</style>
	</head>

	<body>
		<?php if(!$is_h5_plus): ?>
		<header class="mui-bar mui-bar-nav">
		    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
		    <h1 class="mui-title"><?php echo lang("reg_title"); ?></h1>
		</header>
		<?php endif; ?>
		
		<div class="container" style="margin-top:54px;">
			<div class="up_img">
				<i class="mui-icon mui-icon-contact"></i>
				
			</div>

			<form class="mui-input-group">
				
			    <div class="mui-input-row">
			    	<label><?php echo lang('reg_user_name'); ?></label>
			    	<input type="text" name="username" class="mui-input-clear" placeholder="<?php echo lang('reg_user_name_place'); ?>">
			    </div>
			    <div class="mui-input-row">
			    	<label><?php echo lang('reg_email'); ?></label>
			    	<input type="text" name="email" class="mui-input-clear" placeholder="<?php echo lang('reg_email_place'); ?>">
			    </div>
			    <div class="mui-input-row">
			    	<label><?php echo lang('reg_pass'); ?></label>
			        <input type="password" name="pass" class="mui-input-password" placeholder="<?php echo lang('reg_pass_place'); ?>">
			    </div>
			    
			    <div class="mui-input-row">
			    	<label><?php echo lang('reg_confirm_pass'); ?></label>
			        <input type="password" name="confirm_pass" class="mui-input-password" placeholder="<?php echo lang('reg_confirm_pass_place'); ?>">
			    </div>
			    <div class="mui-input-row">
		            <label><?php echo lang('reg_user_sex'); ?></label>
		            <div class="user_sex">
		            	<span id="sex_man" class="select_sex active" data-sex="1"><?php echo lang('male'); ?></span>
		            	<span id="sex_woman" class="select_sex" data-sex="0"><?php echo lang('female'); ?></span>
		            </div>
		        </div>
			</form>
			
			
			<div class="xieyi">
				<div class="mui-input-row mui-checkbox mui-left">
				  <label><?php echo lang('reg_xiyi_tip'); ?></label>
				  <input name="checkbox1" type="checkbox" checked >
				</div>
				
			</div>
			<div class="btn-div">
				<input type="hidden" name="user_sex" value="1">
				<input type="hidden" name="user_ico" value="" id="user_ico_org">
		        <button type="button" class="mui-btn mui-btn-primary btn-block" id="sub" ><?php echo lang('reg_sub_btn'); ?></button>
		    </div>
		    
		</div>

		<input type="file" name='touxiang' id="user_ico">
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/public.js"></script>
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/mui.min.js"></script>
		<script>
		$(function(){
			$(".select_sex").click(function(){
				$(".select_sex").removeClass("active");
				$(this).addClass("active");
				var sex_val = $(this).data("sex");
				$("input[name='user_sex']").val(sex_val);
			});


			$(".up_img").click(function(){
				//alert("aaa");
				$("#user_ico").trigger("click");
			});
			$("#user_ico").change(function(){
				var reader = new FileReader();
		        var AllowImgFileSize = 3200000; //上传图片最大值(单位字节)（ 2 M = 2097152 B ）超过2M上传失败
		        var file = $(this)[0].files[0];
		        var imgUrlBase64;
		        if (file) {
		            //将文件以Data URL形式读入页面  
		            imgUrlBase64 = reader.readAsDataURL(file);
		            console.log(imgUrlBase64);
		            reader.onload = function (e) {
		              //var ImgFileSize = reader.result.substring(reader.result.indexOf(",") + 1).length;//截取base64码部分（可选可不选，需要与后台沟通）
		              if (AllowImgFileSize != 0 && AllowImgFileSize < reader.result.length) {
		                    alert( '上传失败，请上传不大于3M的图片！');
		                    return;
		                }else{
		                    //执行上传操作
		                    $("#user_ico_org").val(reader.result);
		                    $(".up_img").html("<img src='"+reader.result+"' class='user_ico'/>");
		                }
		            }
		        }
			});



			//开始提交数据
			$("#sub").click(function(){
				var username = $("input[name='username']").val();
				var email = $("input[name='email']").val();
				var pass = $("input[name='pass']").val();
				var confirm_pass = $("input[name='confirm_pass']").val();
				var user_sex = $("input[name='user_sex']").val();
				var user_ico = $("input[name='user_ico']").val();


				var url="<?php echo url('reg/index'); ?>";
				var data={
					username:username,
					email:email,
					pass:pass,
					confirm_pass:confirm_pass,
					user_sex:user_sex,
					user_ico:user_ico,
				};
				$.post(url,data,function(res){
					if(res.msg){
						mui.toast(res.msg);
					}

					if(typeof(res.url) != "undefined"){
						window.location.href=res.url;
					}
				},"json");
			});
			


						
		});
		</script>
	</body>
</html>