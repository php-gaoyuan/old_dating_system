<?php
	
	//引入模块公共方法文件
	require("api/base_support.php");

	//引入语言包
	$m_langpackage=new msglp;

  //变量获得
  $user_id=get_sess_userid();

  $dbo = new dbex;
  //读写分离定义函数
  dbtarget('w',$dbServs);

  //数据表定义
  $t_users = $tablePreStr."users";
  
  if (!empty($_FILES["txrz_ico"]["name"])) { //提取文件域内容名称，并判断
		echo "<pre>";
		if($_FILES["txrz_ico"]['size']>512000){
			echo "<script>top.Dialog.alert('".$m_langpackage->tupianguoda."');history.go(-1);</script>";
			exit;
		}
		$path=$webRoot."uploadfiles/txrz/";
		//上传路径
		if(!file_exists($path))
		{
			//检查是否有该文件夹，如果没有就创建，并给予最高权限
			mkdir($path, 0777);
		}
		//允许上传的文件格式
		$tp = array("image/gif","image/pjpeg","image/jpeg","image/png");
		//检查上传文件是否在允许上传的类型
		if(!in_array($_FILES["txrz_ico"]["type"],$tp))
		{
			echo "<script>alert('".$m_langpackage->geshicuowu."');history.go(-1);</script>";
			exit;
		}//END IF
		$filetype = $_FILES['txrz_ico']['type'];
		if($filetype == 'image/jpeg'){
			$type = '.jpg';
		}
		if($filetype == 'image/png'){
			$type = '.png';
		}
		if ($filetype == 'image/jpg') {
			$type = '.jpg';
		}
		if ($filetype == 'image/pjpeg') {
			$type = '.jpg';
		}
		if($filetype == 'image/gif'){
			$type = '.gif';
		}
		if($_FILES["txrz_ico"]["name"])
		{
			$today=date("YmdHis"); //获取时间并赋值给变量
			$file2 = $path.$today.$type; //图片的完整路径+名称
			$img = $today.$type; //图片名称
			$flag=1;
		}
		if($flag)
		{
			$result=move_uploaded_file($_FILES["txrz_ico"]["tmp_name"],$file2);
		}

		$widths=getimagesize($file2);
		
		if($widths[0]>600)
		{
			$width=' width="600"';
		}
		else
		{
			$width='';
		}

		if(empty($width))
		{
			if($widths[1]>600)
			{
				$height=' height="600"';
			}
			else
			{
				$height='';
			}
		}
		if(get_argp('cx')){
			$sql="update $t_users set `txrz_ico`='uploadfiles/txrz/$img' , `is_txrz`=0 where user_id='$user_id' ";
		}else{
			$sql="update $t_users set `txrz_ico`='uploadfiles/txrz/$img' where user_id='$user_id' ";
		}
		$res=$dbo->exeUpdate($sql);
		if($res){
			echo "<script>history.go(-1);</script>";
		}
	}
?>

