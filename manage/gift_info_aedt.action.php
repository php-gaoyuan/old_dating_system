<?php
require("session_check.php");
require("../foundation/fcontent_format.php");
require("../api/base_support.php");
require("../foundation/function.php");

//数据库
$dbo = new dbex;
dbtarget('w',$dbServs);
//接收参数
$info_giftname=short_check(get_argp('info_giftname'));
$sort=get_argp('info_sort')?intval(get_argp('info_sort')): 0;
$type=get_argp('info_type')?intval(get_argp('info_type')): 0;
$money=get_argp('info_money')?intval(get_argp('info_money')): 0;

if(get_argp('motion')=='add')
{
	if(empty($info_giftname)){
		echo "<script type='text/javascript'>alert('礼品名称不能为空');window.history.go(-1);</script>";
	}
	if(empty($_FILES['info_patch']['tmp_name'][0])){
		echo "<script type='text/javascript'>alert('礼品图片不能为空');window.history.go(-1);</script>";
	}
	
	$fileSrcStr="";$s_ico="";
	if(strlen($_FILES['info_patch']['tmp_name'][0])>0)
	{
		$up = new upload();
		$up->field='info_patch';
		$up->set_dir($webRoot.'uploadfiles/gift/','{y}/{m}/{d}');
		$fs=$up->execute();

		$realtxt=$fs[0];

		if($realtxt['flag']==1){
			$fileSrcStr=$realtxt['dir'].$realtxt['name'];
			if(function_exists('imagecopyresampled')){
				//生成70px缩略图
				$img_ext=get_ext($fileSrcStr);
				if($img_ext=='jpg'||$img_ext=='jpeg'){
					$temp_img = imagecreatefromjpeg($fileSrcStr);
				}
				if($img_ext=='gif'){
					$temp_img = imagecreatefromgif($fileSrcStr);
				}
				if($img_ext=='png'){
					$temp_img = imagecreatefrompng($fileSrcStr);
				}
				$s_ico=str_replace('.'.$img_ext, '_small.'.$img_ext, $fileSrcStr);
				resizeImage($temp_img,70,70,$s_ico,'');
			}else{
				$s_ico=$fileSrcStr;
			}
			$fileSrcStr=str_replace($webRoot,"",$fileSrcStr);
			$s_ico=str_replace($webRoot,"",$s_ico);
		}
		else if($realtxt['flag']==-1)
		{
			echo "<script type='text/javascript'>alert('礼品图片类型不正确');window.history.go(-1);</script>";
		}
		else if($realtxt['flag']==-2)
		{
			echo "<script type='text/javascript'>alert('礼品图片过大');window.history.go(-1);</script>";
		}
		else if($realtxt['flag']==-3)
		{
			echo "<script type='text/javascript'>alert('礼品图片大小不匹配');window.history.go(-1);</script>";
		}
	}

	$sql="insert into gift_news (typeid,giftname,money,yuanpatch,patch,ordersum,edittime) values('$type','$info_giftname','$money','$fileSrcStr','$s_ico','$sort',".time().")";
	$is_success=$dbo->exeUpdate($sql);
	if($is_success){
	  echo "<script type='text/javascript'>window.location.href='gift_list.php'</script>";
	}else{
	  echo "<script type='text/javascript'>alert('添加失败');window.history.go(-1);</script>";
	}
}
else if(get_argp('motion')=='edit')
{
	if(empty($info_giftname)){
		echo "<script type='text/javascript'>alert('礼品名称不能为空');window.history.go(-1);</script>";
	}
	
	$fileSrcStr="";$s_ico="";
	if(strlen($_FILES['info_patch']['tmp_name'][0])>0)
	{
		$news=$dbo->getRow("select * from gift_news where id='".get_argp('id')."'");
		$up = new upload();
		$up->field='info_patch';
		if(!empty($news['yuanpatch']))
		{
			unlink($webRoot.$news['yuanpatch']);
			unlink($webRoot.$news['patch']);
		}
		$up->set_dir($webRoot.'uploadfiles/gift/','{y}/{m}/{d}');
		$fs=$up->execute();

		$realtxt=$fs[0];

		if($realtxt['flag']==1){
			$fileSrcStr=$realtxt['dir'].$realtxt['name'];
			if(function_exists('imagecopyresampled')){
				//生成70px缩略图
				$img_ext=get_ext($fileSrcStr);
				if($img_ext=='jpg'||$img_ext=='jpeg'){
					$temp_img = imagecreatefromjpeg($fileSrcStr);
				}
				if($img_ext=='gif'){
					$temp_img = imagecreatefromgif($fileSrcStr);
				}
				if($img_ext=='png'){
					$temp_img = imagecreatefrompng($fileSrcStr);
				}
				$s_ico=str_replace('.'.$img_ext, '_small.'.$img_ext, $fileSrcStr);
				resizeImage($temp_img,70,70,$s_ico,'');
			}else{
				$s_ico=$fileSrcStr;
			}
			$fileSrcStr=str_replace($webRoot,"",$fileSrcStr);
			$s_ico=str_replace($webRoot,"",$s_ico);
		}
		else if($realtxt['flag']==-1)
		{
			echo "<script type='text/javascript'>alert('礼品图片类型不正确');window.history.go(-1);</script>";
		}
		else if($realtxt['flag']==-2)
		{
			echo "<script type='text/javascript'>alert('礼品图片过大');window.history.go(-1);</script>";
		}
		else if($realtxt['flag']==-3)
		{
			echo "<script type='text/javascript'>alert('礼品图片大小不匹配');window.history.go(-1);</script>";
		}
		$consql=",yuanpatch='$fileSrcStr',patch='$s_ico'";
	}

	$sql="update gift_news set typeid='$type',giftname='$info_giftname',money='$money',ordersum='$sort',edittime=".time()."$consql where id='".get_argp('id')."'";
	$is_success=$dbo->exeUpdate($sql);
	if($is_success){
	  echo "<script type='text/javascript'>window.location.href='gift_list.php'</script>";
	}else{
	  echo "<script type='text/javascript'>alert('修改失败');window.history.go(-1);</script>";
	}
}
else if(get_argp('motion')=='del')
{
	$news=$dbo->getRow("select * from gift_news where id='".get_argp('id')."'");
	if(!empty($news['yuanpatch']))
	{
		unlink($webRoot.$news['yuanpatch']);
		unlink($webRoot.$news['patch']);
	}
	$sql="delete from gift_news where id='".get_argp('id')."'";
	$is_sucess=$dbo->exeUpdate($sql);
	if($is_sucess===false){
		echo 'failure';
	}else{
		echo 'success';
	}
}
?>