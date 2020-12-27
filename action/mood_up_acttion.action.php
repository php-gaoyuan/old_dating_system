<?php
  //语言包引入
  $pu_langpackage=new pubtooslp;

  $pic_dir='uploadfiles/mood_pic/';

  $up = new upload();
  
  $up->set_dir($webRoot.$pic_dir,'{y}{m}{d}');

  $fs=$up->single_exe();
  
if($fs['flag']==1){
	$pic=$pic_dir.date('Ymd').'/'.$fs['name'];
	echo "<script>parent.document.getElementById('mood_r_pic').value='".$pic."';alert('success');</script>";
}else{
	echo "<script>parent.document.getElementById('mood_r_pic').value='';alert('fail');</script>";
}
?>

