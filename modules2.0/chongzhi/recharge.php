<?php
	//引入公共模块
	require("foundation/module_event.php");
	require("api/base_support.php");
	
	//引入语言包
	$er_langpackage=new rechargelp;
	
	//必须登录才能浏览该页面
	require("foundation/auser_mustlogin.php");

	$user_id=get_sess_userid();
	//限制时间段访问站点
	limit_time($limit_action_time);
?><link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css" />
<script language=JavaScript src="skin/default/js/jooyea.js"></script>
<SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>
<script>
function list_recent_affair(h_id,ra_type){
	var list_affair=new Ajax();//实例化Ajax
	var recent_affair_div=$("sec_Content");
	list_affair.getInfo("modules.php","get","app","app="+ra_type,function(c){
			recent_affair_div.innerHTML=c;
	});
}
function changeStyle(obj){
	var tagList = obj.parentNode;
	var tagOptions = tagList.getElementsByTagName("li");
	for(i=0;i<tagOptions.length;i++){
		if(tagOptions[i].className.indexOf('active')>=0){
			tagOptions[i].className = '';
		}
	}
	obj.className = 'active';
}

function check(obj)
{
	var check=new Ajax();
	check.getInfo("do.php","get","app","act=reg&ajax=1&user_name="+obj,function(c){if(!c){alert('<?php echo $er_langpackage->er_Dos_notex;?>');}});
}

function getdollar(obj)
{
	if(obj.value=='')
	{
		var dollar="";
		var zibi=document.getElementsByName("zibi");
		for(var i=0;i<zibi.length;i++)
		{
			if(zibi[i].checked==true)
			{
				dollar=zibi[i].value;
			}
		}
		document.getElementById("dollar").innerHTML=dollar;
	}
	else
		document.getElementById("dollar").innerHTML=obj.value;
}
</script>
<div class="tabs">
    <ul class="menu">
        <li onclick="list_recent_affair(<?php echo $user_id;?>,'user_pay');changeStyle(this);" class="active"><a href="javascript:;" hidefocus="true"><?php echo $er_langpackage->er_recharge;?></a></li>
        <li onclick="list_recent_affair(<?php echo $user_id;?>,'user_paylog');changeStyle(this);"><a href="javascript:;" hidefocus="true"><?php echo $er_langpackage->er_recharge_log;?></a></li>
        <li onclick="list_recent_affair(<?php echo $user_id;?>,'user_consumption');changeStyle(this);"><a href="javascript:;" hidefocus="true"><?php echo $er_langpackage->er_consumption_log;?></a></li>
        <li onclick="list_recent_affair(<?php echo $user_id;?>,'user_upgrade');changeStyle(this);"><a href="javascript:;" hidefocus="true"><?php echo $er_langpackage->er_upgrade;?></a></li>
        <li onclick="list_recent_affair(<?php echo $user_id;?>,'user_introduce');changeStyle(this);"><a href="javascript:;" hidefocus="true"><?php echo $er_langpackage->er_introduce;?></a></li>
        <li onclick="list_recent_affair(<?php echo $user_id;?>,'user_help');changeStyle(this);"><a href="javascript:;" hidefocus="true"><?php echo $er_langpackage->er_help;?></a></li>
    </ul>
</div>
<div class="feedcontainer">
	<ul id="sec_Content"></ul>
</div>
<script>
list_recent_affair(<?php echo $user_id;?>,'user_pay');
</script>

<script>


    // 计算页面的实际高度，iframe自适应会用到
    function calcPageHeight(doc) {
        var cHeight = Math.max(doc.body.clientHeight, doc.documentElement.clientHeight)
        var sHeight = Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight)
        var height  = Math.max(cHeight, sHeight)
        return height
    }
    window.onload = function() {
        var height = calcPageHeight(document);
        parent.document.getElementById('ifr').style.height = height +50+ 'px'   ;
		
		  
    }

</script>