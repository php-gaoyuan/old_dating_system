<?php
	require("session_check.php");
	

	//表定义区
	$t_users=$tablePreStr."users";

	$dbo = new dbex;
	dbtarget('w',$dbServs);

	//变量区
	$user_id=short_check(get_argg('uid'));
	$is_txrz=short_check(get_argg('is_txrz'));
	$email=short_check(get_argg('email'));
//验证发送邮件
	if($is_txrz!=0){
		require("../foundation/csmtp.class.php");
		require("../foundation/asmtp_info.php");
		$uinfo=$dbo->getRow("select user_name from wy_users where user_id='$user_id'");
		//邮箱配置信息检测
		if(!$smtpAddress || !$smtpPort || !$smtpEmail || !$smtpUser || !$smtpPassword){
			action_return(1,'邮箱信息配置不正确,请联系管理员','index.php');
		}
		//激活邮件的title和body信息
		$mailtitle = $siteName."照片验证通知|lovelove notice";
		if($is_txrz==1){
			$mailbody = "尊敬的".$uinfo['user_name']." <br />您好：".'<br />'."您在".$siteName."上的照片验证已通过<br /><br/><a href='".$siteDomain."'>点击此处登录 </a><br/><br/>Dear ".$uinfo['user_name']."：<br />：".'<br />'."Your photos on".$siteName."has been verified, <br /><br/><a href='".$siteDomain."'>click here to login </a><br/><br/>";
		}
		if($is_txrz==2){
			$mailbody = "尊敬的".$uinfo['user_name']." <br />您好：".'<br />'."您在".$siteName."上的照片验证不符合<br /><br/><a href='".$siteDomain."'>点击此处重新提交 </a><br/><br/>Dear ".$uinfo['user_name']."：<br />：".'<br />'."Your photos on".$siteName."has been verified, <br /><br/><a href='".$siteDomain."'>click here to re submit </a><br/><br/>";
		}
		$email_array=explode('@',$email);
		$email_site=strtolower($email_array[1]);

		//为hotmail和gmail邮箱单独设置字符集
		$utf8_site=array("hotmail.com","gmail.com");
		if(!in_array($email_site,$utf8_site)){
			$mailbody = iconv('UTF-8','GBK',$mailbody);
			$mailtitle = iconv('UTF-8','GBK',$mailtitle);
		}
		//echo $mailbody;exit;
		//发送邮件
		$smtp = new smtp($smtpAddress,$smtpPort,true,$smtpUser,$smtpPassword);
		$result=$smtp->sendmail($email,$smtpEmail,$mailtitle,$mailbody,'HTML');
		echo "邮件发送状态：".$result."\n";
	}
	
	//更新验证状态
	$sql="update $t_users set is_txrz='$is_txrz' where user_id='$user_id'";
	
	$res=$dbo->exeUpdate($sql);
	if($res){
		if($is_txrz==1){
			
		}
	
		echo '操作成功';
	}else{
		echo '操作失败';
	}
?>