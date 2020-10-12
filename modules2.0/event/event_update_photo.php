<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/event/event_update_photo.html
 * 如果您的模型要进行修改，请修改 models/modules/event/event_update_photo.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
	require("foundation/auser_mustlogin.php");
	require("api/base_support.php");
	
	//引入语言包
	$ef_langpackage=new event_frontlp;
	
	//变量取得
	$event_id=intval(get_argg('id'));
	$user_id=get_sess_userid();
	$fs = array();
	
	//表定义区
	$t_tmp_file = $tablePreStr."tmp_file";
	
	$dbo = new dbex;
	dbtarget('r',$dbServs);
	$sql="select data_array from $t_tmp_file where mod_id=$event_id";
	$session_data=$dbo->getRow($sql);
	$fs=unserialize($session_data['data_array']);
	$sql="delete from $t_tmp_file where mod_id=$event_id";
	$dbo->exeUpdate($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
</head>
<body id="iframecontent">
	<div class="create_button"><a href="javascript:window.history.go(-1)" hidefocus="true"><?php echo $ef_langpackage->ef_back;?></a></div>
  <h2 class="app_event"><?php echo $ef_langpackage->ef_activity;?></h2>
  <div class="tabs">
      <ul class="menu">
        <li class="active"><a href="modules.php?app=event_upload_photo&event_id=<?php echo $event_id;?>" hidefocus="true"><?php echo $ef_langpackage->ef_upload_photo;?></a></li>
      </ul>
  </div>
  
<?php if($fs){?>
<form action='do.php?act=event_update_photo&id=<?php echo $event_id;?>' method='post'>
<?php foreach($fs as $index=>$realtxt){?>
	<?php $thumb_src=str_replace(dirname(__FILE__),"",$realtxt['dir']).$realtxt['thumb'];?>
	<div class="front_cover"><input type='hidden' name='photo_id[]' value=<?php echo $realtxt['photo_id'];?> /><img src=<?php echo $realtxt['dir'];?><?php echo $realtxt['thumb'];?> onerror="parent.pic_error(this)" /></div>
	<div class="album_remark">
	  <p><?php echo $ef_langpackage->ef_p_name;?></p>
	  <input class="small-text" type='text' name='photo_name[]' value='<?php echo preg_replace("/\.\w*$/","",$realtxt['initname']);?>' style="width:100%" />
	</div>
	<div class="album_remark">
	  <p><?php echo $ef_langpackage->ef_p_inf;?></p>
	  <textarea class="med-textarea" rows='4'  style="width:100%" name='photo_information[]'></textarea>
	</div>
	<div class="blank"></div>
<?php }?>
	<input type='submit' name='action' value='<?php echo $ef_langpackage->ef_b_con;?>' class='regular-btn'  />
</form>
<?php }?>

<?php if(!$fs){?>
<div class="guide_info">
	<?php echo $ef_langpackage->ef_upload_photos_noncompliant;?>
</div>
<?php }?>
</body>
</html>
