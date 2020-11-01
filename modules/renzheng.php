<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/album/album_list.html
 * 如果您的模型要进行修改，请修改 models/modules/album/album_list.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
	//引入语言包
	$ul=new userslp;

	require("foundation/module_users.php");
	require("foundation/fpages_bar.php");
	require("foundation/module_album.php");
	require("api/base_support.php");
	require("servtools/menu_pop/trans_pri.php");
	//变量取得
	$user_id=get_sess_userid();
	$page_num=trim(get_argg('page'));
	//当前用户是否邮箱认证
	$sql="select activation_id from wy_users where user_id='$user_id'";
	$is_rzemail=$dbo->getRow($sql);
	//当前用户是否照片认证
	$sql="select is_txrz,txrz_ico from wy_users where user_id='$user_id'";
	$rztx=$dbo->getRow($sql);
	//随机读取已头像认证用户
	$sql="select user_id,user_name,is_txrz,txrz_ico from wy_users where is_txrz='1' and txrz_ico is not null order by lastlogin_datetime desc ";	$dbo->setPages(12,$page_num);//设置分页
	$txrz_list=$dbo->getRs($sql);	$page_total=$dbo->totalPage;//分页总数
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
<script type='text/javascript' src='servtools/ajax_client/ajax.js'></script>

<script type='text/javascript' src="skin/default/js/jooyea.js"></script>
<script type='text/javascript'>

</script>
<style>

</style>
</head>
<body id="iframecontent">
<h2 class="app_album" style="border:none;background-color:#EEEFF3;line-height:36px;padding:0 30px;background-position:10px -32px"><?php echo $ul->yonghurenzheng;?></h2>
<div class="zprz active2"><a href="main.php?app=renzheng" target="_top"><?php echo $ul->woderenzheng;?><i></i></a></div>
<div class="zprz">

<a href="main.php?app=gorenzheng" target="_top">
<?php echo $ul->zhaopianrenzheng;?><i></i></a></div>
<div style="border-bottom:1px solid #DEDEDE;background:red;margin-top:40px;"> </div>
<div class="album_holder">
	<div class="rz_con">
		<div class="rz_con_l"><?php if($is_rzemail['activation_id'] < 0){echo '<b></b>';}else{echo '<i></i>';}?><?php echo $ul->youxiangrenzheng;?>:</div>
		<div class="rz_con_r" id="rzemail"><?php echo $ul->youxiangrenzheng2;?> 
			<?php if($is_rzemail['activation_id'] < 0){echo '<a class="rz_btn" style="background:#5AA032" href="javascript:;" target="_top">'.$ul->yirenzheng.'</a>';}else{echo '<a class="rz_btn" href="javascript:;" target="_top">'.$ul->lijirenzheng.'</a>';}?>
			
		</div>
	</div>
	<div class="rz_con">
		<div class="rz_con_l"><?php if($rztx['is_txrz']==1 && $rztx['txrz_ico']){echo '<b></b>';}else{echo '<i></i>';}?><?php echo $ul->zhaopianrenzheng;?>:</div>
		<div class="rz_con_r"><?php echo $ul->zhaopianrenzheng2;?>
			<?php if($rztx['is_txrz']==1 && $rztx['txrz_ico']){echo '<a class="rz_btn" style="background:#5AA032" href="javascript:;" target="_top">'.$ul->yirenzheng.'</a>';}else{echo '<a class="rz_btn" href="/main.php?app=gorenzheng" target="_top">'.$ul->lijirenzheng.'</a>';}?>
			
		</div>
	</div>
    <div class="rzdes">
		<h3><?php echo $ul->rz1;?></h3>
		<p><?php echo $ul->rz2;?></p>
		<p><?php echo $ul->rz3;?></p>
		<p><?php echo $ul->rz4;?></p>
		<p><?php echo $ul->rz5;?></p>
		
	</div>
	<!--  <div class="rzyh">
		<h3><?php echo $ul->rz6;?></h3>
		<ul>
			<?php foreach($txrz_list as $rzlist){?>
				<li><a href="home2.0.php?h=<?php echo $rzlist['user_id'];?>" target="_blank"><img src="<?echo $rzlist['txrz_ico'];?>"/>
				<div><i></i><?php echo $rzlist['user_name'];?></div></a></li>
			<?php }?>
		</ul>
	</div>	<li style=""><?php echo page_show($isNull,$page_num,$page_total);?></li>
	-->
</div>


</body>
</html>