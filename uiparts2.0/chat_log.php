<?php 
$pals_id = $_GET["id"];
//echo $pals_id;
?>
 
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>聊天记录</title>

<link rel="stylesheet" href="/skin/gaoyuan/layui/css/layui.css">
<style>
body .layim-chat-main{height: auto;}
</style>
</head>
<body>

<div class="layim-chat-main">
  <ul id="LAY_view"></ul>
</div>

<div id="LAY_page" style="margin: 0 10px;"></div>


<textarea title="消息模版" id="LAY_tpl" style="display:none;">
{{# layui.each(d.data, function(index, item){
  if(item.id == parent.layui.layim.cache().mine.id){ }}
    <li class="layim-chat-mine"><div class="layim-chat-user"><img src="{{ item.avatar }}"><cite><i>{{ layui.data.date(item.timestamp) }}</i>{{ item.username }}</cite></div><div class="layim-chat-text">{{ layui.layim.content(item.content) }}</div></li>
  	{{# } else { }}
    <li><div class="layim-chat-user"><img src="{{ item.avatar }}"><cite>{{ item.username }}<i>{{ layui.data.date(item.timestamp) }}</i></cite></div><div class="layim-chat-text">{{ layui.layim.content(item.content) }}</div></li>
  {{# }
}); }}
</textarea>



<script src="/skin/gaoyuan/layui/layui.js"></script>
<script>
layui.use(['layim', 'laypage'], function(){
	var layim = layui.layim,
	layer = layui.layer,
	laytpl = layui.laytpl,
	$ = layui.jquery,
	laypage = layui.laypage;

	//聊天记录的分页此处不做演示，你可以采用laypage，不了解的同学见文档：http://www.layui.com/doc/modules/laypage.html
 
  
  
	$.getJSON("/chat.php?act=getLog",{pals_id:"<?= $pals_id; ?>"},function(res){
		var html = laytpl(LAY_tpl.value).render({
		  data: res.data
		});
		$('#LAY_view').html(html);
	});
});
</script>
</body>
</html>
