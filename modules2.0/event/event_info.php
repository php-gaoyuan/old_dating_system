<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/event/event_info.html
 * 如果您的模型要进行修改，请修改 models/modules/event/event_info.php
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
	
	//必须登录才能浏览该页面
	require("foundation/auser_mustlogin.php");

	//限制时间段访问站点
	limit_time($limit_action_time);
	
	$user_id=get_sess_userid();
	$event_id=intval(get_argg('event_id'));
	$event_info = array('event_id'=>'','user_id'=>'','user_name'=>'','title'=>'','type_id'=>'','province'=>'','city'=>'','location'=>'','deadline'=>'','start_time'=>'','end_time'=>'','public'=>'2','detail'=>'','template'=>'','limit_num'=>'0','verify'=>'','allow_pic'=>'1','allow_post'=>'1','allow_invite'=>'1','allow_fellow'=>'');
	
	$action='do.php?act=event_add';
	
	if($event_id){
		//权限判断
		$status=api_proxy("event_member_by_uid","status",$event_id,$user_id);
		$status=intval($status['status']);
		if($status < 3){
			echo "<script type='text/javascript'>alert('".$ef_langpackage->ef_no_permission."');window.history.go(-1);</script>";exit();
		}
		$field = implode(',', array_keys($event_info));
		$event_info = api_proxy("event_self_by_eid",$field,$event_id);
		$event_info['start_time'] = date('Y-m-d H:i', $event_info['start_time']);
		$event_info['end_time'] = date('Y-m-d H:i', $event_info['end_time']);
		$event_info['deadline'] = date('Y-m-d H:i', $event_info['deadline']);
		$action='do.php?act=event_edit&event_id='.$event_id;
	}

	//缓存功能区
	$event_sort_rs = api_proxy("event_sort_by_self");
	$event_type = event_sort_list($event_sort_rs, $event_info['type_id']);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
<link type="text/css" rel="stylesheet" href="servtools/calendar/css/calendar.css" />
<SCRIPT language=JavaScript src="skin/default/js/jooyea.js"></SCRIPT>
<script src="servtools/area.js" type="text/javascript"></script>
<SCRIPT language=JavaScript src="servtools/kindeditor/kindeditor.js"></SCRIPT>
<script type='text/javascript'>parent.hiddenDiv();</script>
</head>
<body id="iframecontent">
	<div class="create_button"><a href="javascript:history.go(-1)"><?php echo $ef_langpackage->ef_back;?></a></div>
  <h2 class="app_event"><?php echo $ef_langpackage->ef_activity;?></h2>
  <div class="tabs">
    <ul class="menu">
    	<?php if($event_id){?>
      <li class="active"><a href="modules.php?app=event_info&event_id=<?php echo $event_id;?>" hidefocus="true"><?php echo $ef_langpackage->ef_update_activity;?></a></li>
      <li><a href="modules.php?app=event_member_manager&event_id=<?php echo $event_id;?>" hidefocus="true"><?php echo $ef_langpackage->ef_member_management;?></a></li>
			<li><a href="modules.php?app=event_upload_photo&event_id=<?php echo $event_id;?>" hidefocus="true"><?php echo $ef_langpackage->ef_upload_photo;?></a></li>
    	<?php }?>
    	<?php if(!$event_id){?>
    	<li class="active"><a href="modules.php?app=event_info" hidefocus="true"><?php echo $ef_langpackage->ef_launch_activity;?></a></li>
    	<?php }?>
    </ul>
  </div>
	<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data" onsubmit="return validate(this);">
	    <table class="form_table">
	    	<tr>
	        	<th><?php echo $ef_langpackage->ef_activity_name;?>：</th>
	          <td><input name="title" type="text" class="med-text" value="<?php echo $event_info['title'];?>" /></td>
	      </tr>
        <tr>
        	<th><?php echo $ef_langpackage->ef_activity_city;?>：</th>
          <td>
              <select name='province' id="s1"><option><?php echo $ef_langpackage->ef_please_select;?>...</option></select>
              <select name='city' id="s2"><option><?php echo $ef_langpackage->ef_please_select;?>...</option></select>
              <script type="text/javascript">
				setup();
				document.getElementById('s1').value='<?php echo $event_info["province"];?>';
				change(1);
				document.getElementById('s2').value='<?php echo $event_info["city"];?>';
              </script>
          </td>
        </tr>
        <tr>
        	<th><?php echo $ef_langpackage->ef_activity_location;?>：</th>
            <td><input type="text" name="location" class="med-text" value="<?php echo $event_info['location'];?>" /></td>
        </tr>
        <tr>
        	<th><?php echo $ef_langpackage->ef_activity_time;?>：</th>
            <td>
	            <input type="text" id="start_time" name="start_time" readonly="readonly" class="small-text" value="<?php echo $event_info['start_time'];?>" />
	             <?php echo $ef_langpackage->ef_to;?>
	            <input type="text" id="end_time" name="end_time" readonly="readonly" class="small-text" value="<?php echo $event_info['end_time'];?>" />
            </td>
        </tr>
        <tr>
        	<th><?php echo $ef_langpackage->ef_closing;?>：</th>
            <td><input type="text" id="deadline" name="deadline" readonly="readonly" class="small-text" value="<?php echo $event_info['deadline'];?>" /></td>
        </tr>
        <tr>
        	<th><?php echo $ef_langpackage->ef_activity_sort;?>：</th>
            <td><?php echo $event_type;?></td>
        </tr>
        <tr>
        	<th></th>
            <td style="line-height:1.5">
            	<textarea name="detail" style='width:560px;height:400px;_width:560px;' id="detail" class="textarea" ><?php echo $event_info['detail'];?></textarea>
            </td>
        </tr>
        <tr>
        	<th><?php echo $ef_langpackage->ef_posters;?>：</th>
            <td><input type="file" name='attach[]' class="med-text" /></td>
        </tr>
        <tr>
        	<th><?php echo $ef_langpackage->ef_activity_number;?>：</th>
            <td><input type="text" name="limit_num" class="small-text" value="<?php echo $event_info['limit_num'];?>" /> <?php echo $ef_langpackage->ef_activity_number_ef_limit;?> </td>
        </tr>
        <tr>
        	<th><?php echo $ef_langpackage->ef_activity_privacy;?>：</th>
            <td>
                <select name="public" id="public">
	                <option value="2"><?php echo $ef_langpackage->ef_privacy_publicity;?></option>
	                <option value="1"><?php echo $ef_langpackage->ef_half_publicity_activity;?></option>
	                <option value="0"><?php echo $ef_langpackage->ef_privacy_activity;?></option>
                </select>
				<script type="text/javascript">document.getElementById('public').value='<?php echo $event_info["public"];?>';</script>
            </td>
        </tr>
        <tr>
        	<th><?php echo $ef_langpackage->ef_activity_options;?>：</th>
            <td>
                <input name="allow_invite" id="allow_invite" value="1" type="checkbox" <?php if($event_info['allow_invite']){?> checked="checked" <?php }?>/>
                <label for="allow_invite"><?php echo $ef_langpackage->ef_allowed_invite_friends;?></label><br>
                <input name="allow_pic" id="allow_pic" value="1" type="checkbox" <?php if($event_info['allow_pic']){?> checked="checked" <?php }?>/>
                <label for="allow_pic"><?php echo $ef_langpackage->ef_allows_sharing_photos;?></label><br>
                <input name="allow_post" id="allow_post" value="1" type="checkbox" <?php if($event_info['allow_post']){?> checked="checked" <?php }?>/>
                <label for="allow_post"><?php echo $ef_langpackage->ef_allowed_issue_message;?></label><br>
                <input name="verify" id="verify" value="1" type="checkbox" <?php if($event_info['verify']){?> checked="checked" <?php }?>/>
                <label for="verify"><?php echo $ef_langpackage->ef_participation_requires_approval;?></label><br>
                <input name="allow_fellow" id="allow_fellow" value="1" type="checkbox" <?php if($event_info['allow_fellow']){?> checked="checked" <?php }?>/>
                <label for="allow_fellow"><?php echo $ef_langpackage->ef_allowed_bring_friends;?></label>
            </td>
        </tr>
        <tr>
        	<th valign="top"><?php echo $ef_langpackage->ef_reg_info;?>：</th>
            <td><textarea name="template" class="textarea" ><?php echo $event_info['template'];?></textarea></td>
        </tr>
        <tr>
        	<td></td>
        	<td>
            	<input type="hidden" name="act" value="<?php echo $act;?>" />
              <input type="hidden" name="event_id" value="<?php echo $event_info['event_id'];?>" />
            	<input type="submit" class="regular-btn" value="<?php echo $ef_langpackage->ef_submit;?>" />
            </td>
        </tr>
	    </table>
	</form>

<script src="servtools/calendar/js/calendar.js" type="text/javascript" language="javascript"></script>
<script src="servtools/calendar/js/lang/cn.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" language="javascript">
calendar('start_time');
calendar('end_time');
calendar('deadline');
function calendar(obj)
{
	new Calendar({inputField:obj,trigger:obj,dateFormat:"%Y-%m-%d %H:%M",titleFormat:"%Y %B",showTime: 24,onSelect:function(){var date = Calendar.intToDate(this.selection.get());this.hide();}});
}

function validate(formObj){
	var myDate = new Date();
	var year = myDate.getFullYear();
	var month = myDate.getMonth()+1;	month = month<10 ? "0"+month : month;
	var date = myDate.getDate();	date = date<10 ? "0"+date : date;
	var hours = myDate.getHours();	hours = hours<10 ? "0"+hours : hours;
	var minutes = myDate.getMinutes();	minutes = minutes<10 ? "0"+minutes : minutes;
	var current_time = year+'-'+month+'-'+date+' '+hours+':'+minutes;

	if(!formObj.title.value){
		parent.Dialog.alert("<?php echo $ef_langpackage->ef_fill_in_activity_name;?>");
		return false;
	}
	if(formObj.title.value.length>=80){
		parent.Dialog.alert("<?php echo $ef_langpackage->ef_activity_name_overrun;?>");
		return false;
	}
	if(!formObj.province.value || !formObj.city.value){
		parent.Dialog.alert("<?php echo $ef_langpackage->ef_select_activity_city;?>");
		return false;
	}
	if(!formObj.location.value){
		parent.Dialog.alert("<?php echo $ef_langpackage->ef_fill_in_activity_location;?>");
		return false;
	}
	if(!formObj.location.value.length>=80){
		parent.Dialog.alert("<?php echo $ef_langpackage->ef_activity_location_overrun;?>");
		return false;
	}
	var start_time = formObj.start_time.value;
	var end_time = formObj.end_time.value;
	if(!start_time || !end_time){
		parent.Dialog.alert("<?php echo $ef_langpackage->ef_select_start_end_time;?>");
		return false;
	}

	if(start_time > end_time){
		parent.Dialog.alert("<?php echo $ef_langpackage->ef_end_after_start;?>");
		return false;
	}
	var deadline = formObj.deadline.value;
	if(!deadline){
		parent.Dialog.alert("<?php echo $ef_langpackage->ef_select_reg_deadline;?>");
		return false;
	}
	if(deadline > end_time){
		parent.Dialog.alert("<?php echo $ef_langpackage->ef_end_after_deadline;?>");
		return false;
	}
	if(deadline < start_time){
		parent.Dialog.alert("<?php echo $ef_langpackage->ef_deadline_after_start;?>");
		return false;
	}
	if(!formObj.type_id.value){
		parent.Dialog.alert("<?php echo $ef_langpackage->ef_select_activity_sort;?>");
		return false;
	}
	if(!formObj.template.value.length>=250){
		parent.Dialog.alert("<?php echo $ef_langpackage->ef_reg_info_overrun;?>");
		return false;
	}
}

var event_type_tem = new Array();
<?php foreach($event_sort_rs as $rs){?>
	event_type_tem[<?php echo $rs['type_id'];?>] = "<?php echo $rs['template'];?>";
<?php }?>
var event_type_id = document.getElementById("type_id");

event_type_id.onchange=function(){
	var content = window.frames['KINDEDITORIFRAME'].document.getElementById("KINDEDITORBODY");
	var content_html = content.innerHTML;
	var event_type_value=event_type_id.value;
	if(event_type_value){
		if(content_html){
			if(confirm("<?php echo $ef_langpackage->ef_whether_load;?>")){
				content.innerHTML = event_type_tem[event_type_value]+content_html;
			}
		}else
			content.innerHTML = event_type_tem[event_type_value];
	}
}
</script>

<script type="text/javascript">
	KE.show({
		id:'detail',
		resizeMode:0
	});
</script>

</body>
</html>