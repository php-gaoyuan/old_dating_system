<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/ask/ask_edit.html
 * 如果您的模型要进行修改，请修改 models/modules/ask/ask_edit.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
	//必须登录才能浏览该页面
	require("foundation/auser_mustlogin.php");
	require("api/base_support.php");

	//限制时间段访问站点
	limit_time($limit_action_time);

	//引入模块公共方法文件
	require("foundation/module_ask.php");
	require("foundation/fplugin.php");

	//语言包引入
	$b_langpackage=new bloglp;

	//变量定义
	$user_id=get_sess_userid();
	$ask_id=intval(get_argg('id'));
	$reward_arr=array(0,5,10,20,30,50,100);

	//数据表定义
	$t_ask=$tablePreStr."ask";
	$t_ask_type=$tablePreStr."ask_type";
	$t_users=$tablePreStr."users";
	
	//读定义
	dbtarget('r',$dbServs);
	$dbo=new dbex;
	
	//获取用户积分,用于js校验
	$sql="select integral from $t_users where user_id=$user_id ";		
	$integral=$dbo->getRow($sql);
	$integral=$integral['integral'];

	$titleStr='新问题';
	$goBackUrl='modules.php?app=ask';
	$form_action="do.php?act=ask_add";
	$ask_row=array(
		'title' => '',
		'detail' => '',
		'replenish' => '',
		'type_id' => '0',
		'type_name' => '',
		'reward' => '0'
	);

	//判断是否编辑问题内容
	if($ask_id!=""){
		$titleStr='修改问题';
		$goBackUrl='modules.php?app=ask_show&id='.$ask_id;
    	$form_action="do.php?act=ask_edit&id=".$ask_id;
		$sql="select * from $t_ask where ask_id=$ask_id ";		
		$ask_row=$dbo->getRow($sql);
	}
	
	$sql="select * from $t_ask_type order by order_num asc";	
	$type_rs = $dbo->getAll($sql);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
<link rel="stylesheet" type="text/css" href="servtools/menu_pop/menu_pop.css">
<script type='text/javascript' src='servtools/ajax_client/ajax.js'></script>
<SCRIPT language=JavaScript src="skin/default/js/jooyea.js"></SCRIPT>
<SCRIPT language=JavaScript src="servtools/kindeditor/kindeditor.js"></SCRIPT>
<script Language="JavaScript">
is_submit=0;

function CheckForm(){
	if(document.myform.title.value==""){
		parent.Dialog.alert("请填写您的问题！");
		document.myform.title.focus();
		return false;
	}
	if(document.myform.type_id.value=='0' || document.myform.type_name.value==''){
		parent.Dialog.alert("请选择问题类别！");
		document.myform.type_id.focus();
		return false;
	}
	//校验悬赏积分是否足够
	var reward=document.myform.reward.value;
	if(<?php echo $ask_id;?>){
		if(reward > <?php echo $ask_row['reward'];?> && <?php echo $integral;?> < (reward-<?php echo $ask_row['reward'];?>)){
			parent.Dialog.alert("您的悬赏积分不足！");
			document.myform.reward.focus();
			return false;
		}
	}
	else if(<?php echo $integral;?> < reward){
		parent.Dialog.alert("您的悬赏积分不足！");
		document.myform.reward.focus();
		return false;
	}
}

parent.hiddenDiv();
</script>
</head>
<body id="iframecontent">
    <div class="create_button"><a href="modules.php?app=ask&mod=mine">我的问题</a></div>
    <h2 class="app_ask">问吧</h2>
    <div class="tabs">
        <ul class="menu">
            <li class="active"><a href="javascript:;"><?php echo $titleStr;?></a></li>
        </ul>
    </div>
   <form action="<?php echo $form_action;?>" method="post"  name="myform" onSubmit="return CheckForm();">
	<table border="0" cellpadding="2" cellspacing="1" class="form_table">
        <tr>
			<th>你的问题：</th>
			<td >
			<?php if(!$ask_id){?>
				<input class="med-text" type="text" autocomplete='off' name="title" value="<?php echo $ask_row['title'];?>" maxlength="30" >
			<?php }?>
			<?php if($ask_id){?>
			<p><?php echo $ask_row['title'];?></p>
			<?php }?>
			</td>
		</tr>
		<tr>
			<th valign="top">详细说明：</th>
			<td style="line-height:1.5">
			<?php if(!$ask_id){?>
				   <textarea name="detail" id="detail" class="textarea" style='width:560px;height:400px;_width:560px;'><?php echo $ask_row['detail'];?></textarea>
			<?php }?>
			<?php if($ask_id){?>
			<p><?php echo $ask_row['detail'];?></p>
			<?php }?>
			</td>
		</tr>
		<tr <?php echo $ask_id?"":"style='display:none'";?>>
			<th valign="top">补充说明：</th>
			<td style="line-height:1.5">
				   <textarea name="replenish" id="replenish" class="textarea" style='width:560px;height:400px;_width:560px;' ><?php echo $ask_row['replenish'];?></textarea>
			</td>
		</tr>
		<tr>
			<th>问题类别：</th>
			<td>
				<input type="hidden" name="type_name" id="type_name" value="<?php echo $ask_row['type_name'];?>" />
				<select name="type_id" id="type_id" onchange="document.getElementById('type_name').value=this.options[selectedIndex].text"; <?php echo $ask_id?'disabled':'';?>>
				<option value="0">请选择问题类别</option>
				<?php foreach($type_rs as $val){?>
				<option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
				<?php }?>
				</select>
				<script language="javascript">document.getElementById('type_id').value="<?php echo $ask_row['type_id'];?>";</script>
			</td>
		</tr>
		<tr>
			<th>悬赏积分：</th>
			<td>
				<select name="reward" id="reward">
				<?php foreach($reward_arr as $val){?>
					<?php if($ask_row['reward'] <= $val){?>
						<option value="<?php echo $val;?>"><?php echo $val;?></option>
					<?php }?>
				<?php }?>
				</select>
				<script language="javascript">document.getElementById('reward').value="<?php echo $ask_row['reward'];?>";</script>
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type=submit class="regular-btn" value="确定" onclick="javascript:is_submit=1;" />
				<input type=button class="regular-btn" value="取消" onclick='location.href="<?php echo $goBackUrl;?>"' />
			</td>
		</tr>
  </table>
  </form>
<script type="text/javascript">
<?php if(!$ask_id){?>
KE.show({
	id:'detail',
	resizeMode:0
});
<?php }?>
<?php if($ask_id){?>
KE.show({
	id:'replenish',
	resizeMode:0
});
<?php }?>
</script>  
  
</body>
</html>