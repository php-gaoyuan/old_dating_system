<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:72:"/www/wwwroot/jyo.henangaodu.com/app/application/index/view/mood/add.html";i:1602502927;s:77:"/www/wwwroot/jyo.henangaodu.com/app/application/index/view/public/footer.html";i:1602502927;s:75:"/www/wwwroot/jyo.henangaodu.com/app/application/index/view/public/chat.html";i:1602502927;}*/ ?>
<!doctype html>
<html>

	<head>
		<meta charset="UTF-8">
		<title><?php echo lang('fabu_xq'); ?></title>
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<link href="<?php echo config('skin_path'); ?>/css/mui.min.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="<?php echo config('skin_path'); ?>/css/user.css">
		<style type="text/css">
			.layui-flow-more{text-align: center;display:none;}
			.item{
				background-color: #fff;
			}
		</style>
	</head>

	<body>
		<?php if(!$is_h5_plus): ?>
		<header class="mui-bar mui-bar-nav">
			<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left" href="<?php echo url('chat/index'); ?>"></a>
		    <h1 class="mui-title"><?php echo lang('fabu_xq'); ?></h1>
		</header>
		<?php endif; ?>
		<div class="mui-content">
			<style>
				.mood-menu{background: #e6e6e6;border-bottom:1px solid #ccc;}
				.mood-menu .fanyi-select{width: 130px;margin: 0;}
				.mood-pic-list{background: #fff;margin-top: -5px;padding:10px;border:1px solid rgba(0,0,0,.2);border-bottom:1px dashed #ccc;border-top:0;}
				.mood-pic-item{border:1px dashed #ccc;float: left;padding:10px 10px;font-size: 2em;}
				input[name='file']{position: absolute;left: -100%;}
			</style>
            <form class="layui-form" action="">
            	<div class="layui-form-item">
            		<div class="layui-form-item layui-form-text">
            			<div class="layui-input-block">
            				<textarea name="mood" placeholder="Please input mood content" class="layui-textarea" style="margin:0;height:100px;border-radius:0;"></textarea>
            			</div>
            			<div class="mood-pic-list">
            				<div class="mood-pic-box">
	            				<div class="mood-pic-item" id="mood-pic">
	            					+
	            				</div>
            				</div>
            				<div class="" style="clear:both;"></div>
            			</div>
            			
            			<div class="mood-menu">
            				<select name="lang" id="lang" class="fanyi-select" lay-ignore>
            					<option value="no"><?php echo lang('no_trans'); ?></option>
            					<option value="zh">中文简体</option>
            					<option value="cht">中文繁体</option>
            					<option value="en">English</option>
            					<option value="jp">日本語</option>
            					<option value="kor">한국어</option>
            				</select>
            				<button class="layui-btn" lay-submit="" lay-filter="sub" style="float:right;margin:5px 10px 0 0;background:#007aff;color:#fff;border:0;"><?php echo lang('submit'); ?></button>
            			</div>
            		</div>
            	</div>
			</form>
		</div>
		<!--footer-->
		<link rel="stylesheet" href="<?php echo config('skin_path'); ?>/css/chat.css">

<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/public.js"></script>
<script type="text/javascript" src="<?php echo config('skin_path'); ?>/layui/layui.js"></script>
<script>
  var userinfo = <?php echo $userinfo; ?>;
    var socket = new WebSocket("<?php echo config('webconfig.ws_url'); ?>");
    //连接成功时触发
      socket.onopen = function() {
        socket.send(JSON.stringify({"type": "init", "id": userinfo.user_id, "username": userinfo.user_name, "avatar": userinfo.user_ico, "sign": "", "from": "app", "is_read":"0"}));
      };

      socket.onclose = function() {
        layer.msg("网络已经断开");
      };
      socket.onerror = function() {
        layer.msg("网络链接错误");
      };

      //监听收到的聊天消息，假设你服务端emit的事件名为：chatMessage
      socket.onmessage = function(res) {
          var data = JSON.parse(res.data);
          switch (data['message_type']) {
            // 检测聊天数据
            case 'chatMessage':
              var info = data.data;
              //console.log(data.data);
              $("#pals_list li").each(function(){
                if($(this).data("fid") == info.id){
                  var num_obj = $(this).find(".mui-badge");
                  var num = num_obj.text();
                  if(num == ""){
                    num = 1;
                  }else{
                    num = parseInt(num)+1;
                  }
                  //alert($(this).data("fid"));
                  num_obj.text(num);
                  num_obj.show();
                  $("#pals_list").prepend($(this));
                }
              });

              //底部菜单追加消息数量
              var nums = $("#msg_nums").text();
              $("#msg_nums").text(parseInt(nums)+1);

              //追加声音
              $("body").append("<audio autoplay='true' src='/public/static/default/default.mp3'></audio>");
              setTimeout(function(){
                $("audio").remove();
              }, 2000);
              break;
          }
      };
</script>
<!-- <link rel="stylesheet" type="text/css" href="//at.alicdn.com/t/font_537983_p50sudb7q2xogvi.css"/> -->
<link rel="stylesheet" type="text/css" href="//at.alicdn.com/t/font_537983_m0uxbgjfqg.css"/>
<style>
	.mui-bar a.mui-tab-item{position: relative;}
</style>
<div style="height:60px;"></div>
<nav class="mui-bar mui-bar-tab">
    <a class="mui-tab-item <?php if($act == 'main'): ?> mui-active <?php endif; ?>" href="<?php echo url('main/index'); ?>">
        <span class="mui-icon iconfont icon-zhinanzhen-copy"></span>
        <span class="mui-tab-label"><?php echo lang("footer_nav1"); ?></span>
    </a>
    <a class="mui-tab-item <?php if($act == 'chat'): ?> mui-active <?php endif; ?>" href="<?php echo url('chat/index'); ?>">
    	<span class="mui-badge mui-badge-danger" style="position: absolute;right: 14px;z-index: 999;" id="msg_nums"><?php echo $log_messages; ?></span>
        <span class="mui-icon iconfont icon-xiaoxi"></span>
        <span class="mui-tab-label"><?php echo lang("footer_nav2"); ?></span>
    </a>
    <a class="mui-tab-item <?php if($act == 'mood'): ?> mui-active <?php endif; ?>" href="<?php echo url('mood/index'); ?>">
        <span class="mui-icon mui-icon-pengyouquan"></span>
        <span class="mui-tab-label"><?php echo lang("footer_nav3"); ?></span>
    </a>
    <a class="mui-tab-item <?php if($act == 'pals'): ?> mui-active <?php endif; ?>" href="<?php echo url('pals/index'); ?>">
        <span class="mui-icon iconfont icon-wodehaoyou"></span>
        <span class="mui-tab-label"><?php echo lang("footer_nav4"); ?></span>
    </a>
    
    <a class="mui-tab-item <?php if($act == 'user'): ?> mui-active <?php endif; ?>" href="<?php echo url('user/index'); ?>">
        <span class="mui-icon mui-icon-contact"></span>
        <span class="mui-tab-label"><?php echo lang("footer_nav5"); ?></span>
    </a>
</nav>

		<!--footer end-->
		<!-- <script src="<?php echo config('skin_path'); ?>/js/mui.min.js"></script> -->
		<script type="text/javascript" src="<?php echo config('skin_path'); ?>/layui/layui.js"></script>
		<script type="text/javascript">
			layui.use(["jquery","layer","upload","form"],function(){
				var upload = layui.upload;
				var	layer = layui.layer;
				var $=layui.jquery;
				var form=layui.form;

				//执行实例
				var uploadInst = upload.render({
					elem: '#mood-pic', //绑定元素
					url: "<?php echo url('Mood/up_mood_pic'); ?>", //上传接口
					accept:"images",
					acceptMime:"image/*",
					done: function(res){
				  		//上传完毕回调
				  		if(res.code == 0){
				  			$(".mood-pic-box").empty();
				  			$(".mood-pic-box").append("<img style='width:40px;height:40px;' src='"+res.data.src+"'><input type='hidden' name='mood_pic' value='"+res.data._src+"'>");
				  		}
					},
					error: function(){
				  		//请求异常回调
					}
				});

				$("#lang").change(function(){
					var _val = $(this).val();
					var mood = $("textarea[name='mood']").val();
					if(_val !== "no" && Trim(mood) != ""){
						layer.open({
							title:"Tips",
							content:"翻译需要扣除一个金币",
							icon:3,
							btn: ['确定', '取消'],
							yes:function(index){
								$.getJSON("<?php echo url('fanyi/index'); ?>",{pals_id:0, txt:mood, lang:_val},  function(res){
									if(res.code == 0){
										$("textarea[name='mood']").val(res.msg);
									}else{
										layer.msg(res.msg);
									}
									layer.closeAll();
								});
							}
						});
					}
				});


				form.on("submit(sub)",function(data){
					//console.log(data.field);
					
					//return false;
					$.post("<?php echo url('mood/add'); ?>",data.field,function(res){
						layer.msg(res.msg);
						if(res.code==0){
							window.location.href="<?php echo url('mood/index'); ?>";
						}else{
							
						}
					});
					return false;		
				});
			});

function Trim(x) {
    return x.replace(/^\s+|\s+$/gm,'');
}
		</script>

	</body>
</html>