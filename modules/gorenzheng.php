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
	
	$sql="select is_txrz,txrz_ico from wy_users where user_id='$user_id'";
	$txrz_res=$dbo->getRow($sql);
	

	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
<script type='text/javascript' src='servtools/ajax_client/ajax.js'></script>
<?php echo $is_self=='Y' ? "<script type='text/javascript' src='servtools/menu_pop/group_user.php'></script>" : "";?>
<script type='text/javascript' src="skin/default/js/jooyea.js"></script>
<script type='text/javascript'>
function txrz_func(){
	var txrz_val=document.getElementById('textfield').value;
	if(!txrz_val || txrz_val==''){top.Dialog.alert('<?php echo $ul->gorz1;?>');return false;}else{
		document.getElementById('txrz_formid').action="modules2.0.php?app=txrz";
	}
}
</script>
<style>

</style>
</head>
<body id="iframecontent">
<h2 class="app_album" style="border:none;background-color:#EEEFF3;line-height:36px;padding:0 30px;background-position:10px -32px"><?php echo $ul->yonghurenzheng;?></h2>
<div class="zprz "><a href="main.php?app=renzheng" target="_top"><?php echo $ul->woderenzheng;?><i></i></a></div>
<div class="zprz active2"><a href="main.php?app=gorenzheng" target="_top"><?php echo $ul->zhaopianrenzheng;?><i></i></a></div>
<div style="border-bottom:1px solid #DEDEDE;background:red;margin-top:40px;"> </div>
<div class="album_holder">
	<div class="rz_con" style="text-align:left;margin-left:20px;">
		<div class="txrz_l">
			<div class="txrz_ico">
			<?php if(!$txrz_res[txrz_ico] || $txrz_res[txrz_ico]==''){?>
			<img src="skin/default/jooyea/images/defimg.jpg"/>
			<?php }else{?>
			<img src="<?php echo $txrz_res[txrz_ico];?>"/>
			<?php }?>
			</div>
			<div class="txrz_form">
			<?php if(!$txrz_res[txrz_ico] && $txrz_res[is_txrz]==0){?>
			<form action='javascript:;' method="post" id="txrz_formid" onsubmit="return txrz_func()" enctype="multipart/form-data">
				<input type='text' name='textfield' readonly id='textfield' /><input type='button' class='txrz_btn' value='<?php echo $ul->gorz2;?>' />
				<div class="txrz_js"><?php echo $ul->gorz3;?></div>
				<input type='file' name='txrz_ico' id="txrz_file" onchange="document.getElementById('textfield').value=this.value" />
				<input type="submit" class='txrz_btn txrz_btn2' value="<?php echo $ul->gorz5;?>"/>
			</form>
			<?php }elseif($txrz_res[txrz_ico] && $txrz_res[is_txrz]==0){?>
				<input type="button" class='txrz_btn txrz_btn2' value="<?php echo $ul->gorz6;?>"/>
			<?php }elseif($txrz_res[txrz_ico] && $txrz_res[is_txrz]==2){?>
				<form action='javascript:;' method="post" id="txrz_formid" onsubmit="return txrz_func()" enctype="multipart/form-data">
				<input type='text' name='textfield' readonly id='textfield' /><input type='button' class='txrz_btn' value='<?php echo $ul->gorz2;?>' />
				<input type="hidden" value="cx" name="cx"/>
				<div class="txrz_js"><?php echo $ul->gorz3;?></div>
				<input type='file' name='txrz_ico' id="txrz_file" onchange="document.getElementById('textfield').value=this.value" />
				<input type="submit" class='txrz_btn txrz_btn2' value="<?php echo $ul->gorz5;?>"/>
				<div class="txrz_js" style="color:#ff0000;text-align:center"><?php echo $ul->gorz4;?></div>
			</form>
			<?php }elseif($txrz_res[txrz_ico] && $txrz_res[is_txrz]==1){?>
				<div class="txrz_js" style="color:#407608"><?php echo $ul->gorz7;?></div>
			<?php }?>
			</div>
		</div>
		<div class="txrz_r">
			<div class="txrz_ico" style="float:right;margin-right:80px;">
				<img src="skin/default/jooyea/images/updemo.jpg" style='width:130px;height:180px;'/>
				
			</div>
			<div style="text-align:center;width:120px;float:right;margin-right:80px;line-height:20px;"><?php echo $ul->gorz8;?></div>
		</div>
	</div>
    <div class="rz_con" style="text-align:left;margin-left:20px;">
		<h3><?php echo $ul->zhaopianrenzheng;?></h3>
		<p><?php echo $ul->gorz9;?></p>
		
		<p><?php echo $ul->gorz10;?></p>
		<p><?php echo $ul->gorz11;?></p>
		<p><?php echo $ul->gorz12;?></p>
		<h3><?php echo $ul->gorz13;?>:</h3>
		<p>1.<?php echo $ul->gorz14;?></p>
		<p>2.<?php echo $ul->gorz15;?></p>
	</div>
	
</div>


</body>
</html>