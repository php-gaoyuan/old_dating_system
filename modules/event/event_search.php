<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/event/event_search.html
 * 如果您的模型要进行修改，请修改 models/modules/event/event_search.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
	//引入公共模块
	require("foundation/module_event.php");
	require("api/base_support.php");
	
	//引入语言包
	$ef_langpackage=new event_frontlp;
	
	//缓存功能区
	$event_sort_rs = api_proxy("event_sort_by_self");
	$event_type = event_sort_list($event_sort_rs, '');

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
<link type="text/css" rel="stylesheet" href="servtools/calendar/css/calendar.css" />
<script src="servtools/area.js" type="text/javascript"></script>
</head>
<body id="iframecontent">
    <div class="create_button"><a href="modules.php?app=event_list&mod=all" hidefocus="true"><?php echo $ef_langpackage->ef_all_activity;?></a></div>
    <h2 class="app_event"><?php echo $ef_langpackage->ef_activity;?></h2>
    <div class="tabs">
        <ul class="menu">
            <li class="active"><a href="javascript:;"><?php echo $ef_langpackage->ef_search_activity;?></a></li>
        </ul>
    </div>
</div>
<table class='form_table'>
	<form action="modules.php" name="form1"  method="get">
		<tr>
			<th style="width:180px;">
                <?php echo $ef_langpackage->ef_activity_name;?>：</th>
			<td><input class="small-text2 mr10" type="text" name="event_name" id="event_name"  maxlength="30" autocomplete='off'></td>
		</tr>
		<tr>
			<th style="width:180px;">
                <?php echo $ef_langpackage->ef_activity_city;?>：</th> 
			<td><div class="form_select_div"><select id="s1" name='province'></select><select name='city' id="s2" ></select><script type="text/javascript">setup();</script></div></td>	
		</tr>
		<tr>
			<th style="width:180px;">
                <?php echo $ef_langpackage->ef_start_date;?>：</th>
			<td><input type="text" id="start_time1" name="start_time1" readonly="readonly" class="small-text" maxlength="30" autocomplete='off' />-<input type="text" id="start_time2" name="start_time2" readonly="readonly" class="small-text" maxlength="30" autocomplete='off' /></td>	
		</tr>
		<tr>
			<th style="width:180px;">
                <?php echo $ef_langpackage->ef_reg_deadline;?>：</th>
			<td><input type="text" id="deadline1" name="deadline1" readonly="readonly" class="small-text" maxlength="30" autocomplete='off' />-<input type="text" id="deadline2" name="deadline2" readonly="readonly" class="small-text" maxlength="30" autocomplete='off' /></td>	
		</tr>
		<tr>
			<th style="width:180px;">
                <?php echo $ef_langpackage->ef_activity_sort;?>：</th> 
			<td><div class="form_select_div"><?php echo $event_type;?></div></td>	
		</tr>
		<tr><th></th><td><input type="hidden" name="app" id="app" value="event_search_list">
		<input class="regular-btn" name="submit" type="submit" value="<?php echo $ef_langpackage->ef_search;?>"></td></tr>
	</form>
</table>
<script src="servtools/calendar/js/calendar.js" type="text/javascript" language="javascript"></script>
<script src="servtools/calendar/js/lang/cn.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" language="javascript">
calendar('start_time1');
calendar('start_time2');
calendar('deadline1');
calendar('deadline2');
function calendar(obj)
{
	new Calendar({inputField:obj,trigger:obj,dateFormat:"%Y-%m-%d %H:%M",titleFormat:"%Y %B",showTime: 24,onSelect:function(){var date = Calendar.intToDate(this.selection.get());this.hide();}});
}
</script>
</body>
</html>