<?php
//引入公共模块
require("foundation/module_users.php");
require("foundation/aintegral.php");
require("api/base_support.php");
require("foundation/csmtp.class.php");
require("foundation/asmtp_info.php");
require("foundation/fcontent_format.php");

//引入语言包
$re_langpackage=new reglp;
$u_langpackage=new userslp;
//语言包引入
$pu_langpackage=new pubtooslp;
$u_langpackage=new userslp;
$limcount=1;//限制每次上传附件数量



   
//数据表定义区
$t_users=$tablePreStr."users";
$t_online=$tablePreStr."online";
$t_pals_def_sort=$tablePreStr."pals_def_sort";
$t_pals_sort=$tablePreStr."pals_sort";
$t_mypals=$tablePreStr."pals_mine";
$t_invite_code=$tablePreStr."invite_code";
$t_user_activation=$tablePreStr."user_activation";

$dbo=new dbex;
dbtarget('r',$dbServs);

//ajax校验email和验证码
if(get_argg('ajax')==1){
	$user_email=short_check(get_argus("user_email"));
	$user_name=get_argus("user_name");
	//$user_vericode=get_argus("veriCode");
	if($user_email){
		$sql="select user_id from $t_users where user_email='$user_email'";
		$user_info=$dbo->getRow($sql);
		if($user_info){
			echo $re_langpackage->re_rep_mail;exit;
		}
	}

	if($user_name){
		$sql="select user_id from $t_users where user_name='$user_name'";
		$user_info=$dbo->getRow($sql);
		if($user_info){
			echo $re_langpackage->re_rep_username;exit;
		}
	}

	// if($user_vericode){
		// if(strtolower($_SESSION['verifyCode'])!=strtolower($user_vericode)){
			// echo $re_langpackage->re_wrong_val;exit;
		// }
	// }
	exit;
}

function checkmail($user_email){   //验证电子邮件地址
	if(preg_match("/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/",$user_email))
		return true;
	else
		return false;
}

if(strlen(get_argp("user_name"))<4){
   action_return(0,$re_langpackage->re_right_name,"-1");
}

if(!checkmail(get_argp("user_email"))) {
    action_return(0,$re_langpackage->re_right_email,"-1");
}

if(strlen(get_argp("user_repassword"))<6){
	  action_return(0,$re_langpackage->re_pass_limit,"-1");
}

$user_name=short_check(get_argp("user_name"));
$user_pws=md5(get_argp("user_password"));
$user_sex=intval(get_argp("user_sex"));
$user_email=short_check(get_argp("user_email"));if($user_sex==1){	$is_pass=1;	}else{	$is_pass=0;}

$user_vericode=get_argp("veriCode");
$invite_fromuid=0;
if(get_session('InviteFromUid')){
	  $invite_fromuid=get_session('InviteFromUid');
}

// if(strtolower($_SESSION['verifyCode'])!=strtolower($user_vericode)&&strtolower($user_vericode)!='best'){
	// action_return(0,$re_langpackage->re_wrong_val,"-1");
// }

unset($_SESSION['verifyCode']);

//读取数据
$sql="select user_id from $t_users where user_email='$user_email'";
$user_info=$dbo->getRow($sql);
$sort_rs = api_proxy("pals_sort_def");
 
if($user_info){
	action_return(0,$re_langpackage->re_rep_mail,"-1");
}else{
//检测邀请码
	if($inviteCode){
		$is_check=array();
		$invite_code=short_check(get_argp('invite_code'));
		if($invite_code==''){
			action_return(0,'请填写邀请码',"-1");exit;
		}
		$sql="select id from $t_invite_code where code_txt='$invite_code'";
		$is_check=$dbo->getRow($sql);
		if(empty($is_check)){
			action_return(0,'邀请码不正确或已经失效',"-1");exit;
		}
		$sql="delete from $t_invite_code where code_txt='$invite_code'";
		$dbo->exeUpdate($sql);
	}

	//写入数据
	//$user_ico=($user_sex==0)?"skin/$skinUrl/images/d_ico_0_small.gif":"skin/$skinUrl/images/d_ico_1_small.gif";
        if(count($_FILES['attach']['name'])!=$limcount||$_FILES['attach']['name'][0]==''){
         //	action_return(0,$u_langpackage->u_choose_upload_images,'-1');
         //	echo $u_langpackage->u_choose_upload_images;
         //	exit;
        }

        //1、处理直接上传的200X200的头像文件
        $file_is_ico=0;
        /*
		 $ico_size=getimagesize($_FILES['attach']['tmp_name'][0]);
		  	if(get_argp('type')=='ico'){
		  		if(($ico_size[0]>500 && $ico_size[0]<200)||($ico_size[1]>500 && $ico_size[0]<200)){
		  			action_return(0,$u_langpackage->u_upl_size_err,'-1');exit;
		  		}else{
		  			$file_is_ico=1;
		  		}
		  	}
		  	if(get_argp('type')=='photo'){
		  		if($ico_size[0]<200||$ico_size[1]<200){
		  			action_return(0,$u_langpackage->u_up_small,'-1');
		  		}
		  	}
		  	
        $ico_size=getimagesize($_FILES['attach']['tmp_name'][0]);
*/

        //保存图片以及图片信息
        dbtarget('w',$dbServs);
        $dbo=new dbex();

        //$up = new upload('jpg|jpeg',100);
        //$up->set_dir($webRoot.'uploadfiles/photo_store/','{y}/{m}/{d}');
        //$fs=$up->execute();

        $realtxt=$fs[0];

              if($realtxt['flag']==1){
                  $fileSrcStr=str_replace($webRoot,"",$realtxt['dir']).$realtxt['name'];
                  $fileName=$realtxt['initname'];
                }else if($realtxt['flag']==-1){
                  action_return(0,$pu_langpackage->pu_type_err,'-1');
              }else if($realtxt['flag']==-2){
                  action_return(0,$pu_langpackage->pu_capacity_err,'-1');
              }

    //$user_ico = $fileSrcStr;
	
	//判断头像是否上传
	if(!file_exists('avatar/'.$_SERVER["REMOTE_ADDR"].'/log.txt')){
		//action_return(0,$u_langpackage->u_save_false,"-1");		$user_ico = null;		$user_big_ico = null;
	}else{
		//读取文件刚上传的图片名
		$pic_id_content=json_decode(file_get_contents('avatar/'.$_SERVER["REMOTE_ADDR"].'/log.txt'),true);
		$user_ico =$pic_id_content['pic_id']? "/avatar/avatar_small/".$pic_id_content['pic_id'].'_small.jpg' : '';
		$user_big_ico =$pic_id_content['pic_id']? "/avatar/avatar_big/".$pic_id_content['pic_id'].'_big.jpg' : '';				unlink('avatar/'.$_SERVER["REMOTE_ADDR"].'/log.txt');//注册完删除txt文件
	}
	
	
	
	dbtarget('w',$dbServs);
	$birth_day=$_POST['birth_day']?$_POST['birth_day']:'';
	$birth_month=$_POST['birth_month']?$_POST['birth_month']:'';
	$birth_year=$_POST['birth_year']?$_POST['birth_year']:'';
	if(get_argp("tuid"))
	{
		$sql="insert into $t_users (user_name,user_pws,user_sex,user_email,user_add_time,user_ico,user_big_ico,user_group,invite_from_uid,is_pass,lastlogin_datetime,birth_year , birth_month , birth_day ,login_ip,zhuce_ip,tuid ) values('$user_name','$user_pws',$user_sex,'$user_email','".constant('NOWTIME')."','$user_ico','$user_big_ico','1',$invite_fromuid,$is_pass,'".constant('NOWTIME')."','$birth_year','$birth_month','$birth_day','$_SERVER[REMOTE_ADDR]','$_SERVER[REMOTE_ADDR]',".get_argp("tuid").")";
	}
	else if(get_argp("uid"))
	{
		$sql="insert into $t_users (user_name,user_pws,user_sex,user_email,user_add_time,user_ico,user_big_ico,user_group,invite_from_uid,is_pass,lastlogin_datetime,birth_year , birth_month , birth_day ,login_ip,zhuce_ip,uid ) values('$user_name','$user_pws',$user_sex,'$user_email','".constant('NOWTIME')."','$user_ico','$user_big_ico','1',$invite_fromuid,$is_pass,'".constant('NOWTIME')."','$birth_year','$birth_month','$birth_day','$_SERVER[REMOTE_ADDR]','$_SERVER[REMOTE_ADDR]',".get_argp("uid").")";
	}
	else
	{
		$tuid=$_COOKIE['tuid']?$_COOKIE['tuid']:5;
		$sql="insert into $t_users (user_name,user_pws,user_sex,user_email,user_add_time,user_ico,user_big_ico,user_group,invite_from_uid,is_pass,lastlogin_datetime,birth_year , birth_month , birth_day ,login_ip,zhuce_ip,tuid) values('$user_name','$user_pws',$user_sex,'$user_email','".constant('NOWTIME')."','$user_ico','$user_big_ico','1',$invite_fromuid,$is_pass,'".constant('NOWTIME')."','$birth_year','$birth_month','$birth_day','$_SERVER[REMOTE_ADDR]','$_SERVER[REMOTE_ADDR]',$tuid)";
	}
    //echo $sql;exit;
	if(!$dbo->exeUpdate($sql)){
		action_return(0,$re_langpackage->re_reg_false,"-1");
	}

	$user_id=mysql_insert_id();
	//女性锁定
	
	// if($user_sex==0)
	// {
		// $sql="update $t_users set is_pass='0' where user_id='$user_id'";
		// $dbo->exeUpdate($sql);
		// action_return(1,$re_langpackage->re_gock_u,'index.php');//返回锁定提示
		// exit();
	// }


	
	$now_time=time();

	$sql="insert into $t_online (user_id,user_name,user_sex,user_ico,active_time,hidden) values ($user_id,'$user_name',$user_sex,'$user_ico','$now_time',0)";
	$dbo->exeUpdate($sql);

	foreach($sort_rs as $rs){
		$sort_id=$rs['id'];
		$sort_name=$rs['name'];
		$sql="insert into $t_pals_sort ( name , user_id ) values ( '$sort_name' , $user_id )";
		$dbo->exeUpdate($sql);
	}

	if($invite_fromuid){
		increase_integral($dbo,$int_invited,$invite_fromuid);
		//取得介绍人的资料信息
		$user_row = api_proxy("user_self_by_uid","user_id,user_name,user_sex,user_ico,palsreq_limit",$invite_fromuid);
		if($user_row){
			$touser_id=$user_row['user_id'];
			$touser_name=$user_row['user_name'];
			$touser_sex=$user_row['user_sex'];
			$touser_ico=$user_row['user_ico'];
			$touser_pals_limit=$user_row['palsreq_limit'];
		}
		if($touser_pals_limit==0){
			$sql="insert into $t_mypals (user_id,pals_id,pals_name,pals_sex,add_time,pals_ico,accepted) values ($user_id,$invite_fromuid,'$touser_name','$touser_sex','".constant('NOWTIME')."','$touser_ico',1)";
			$dbo->exeUpdate($sql);
			set_sess_mypals($invite_fromuid);
		}
	}



	//不需要激活时直接添加session
	if($mailActivation == 0){
		set_sess_userid($user_id);
		set_sess_usersex($user_sex);
		set_sess_username($user_name);
		set_sess_userico($user_ico);
		set_sess_online('0');
?>
		<script type='text/javascript'>
		var login_time=new Date();
		login_time.setTime(login_time.getTime() +3600*250 );
		document.cookie="IsReged=Y;expires="+ login_time.toGMTString();
		location.href='./main.php';
	  </script>
<?php
	//需要激活时的操作
	}else{
		//邮箱配置信息检测
		if(!$smtpAddress || !$smtpPort || !$smtpEmail || !$smtpUser || !$smtpPassword){
			action_return(1,'邮箱信息配置不正确,请联系管理员','index.php');
		}

		//生成MD5加密后的激活码
		$activation_code = md5($user_email.time());

		//在激活码表中压入新数据
		$sql="insert into $t_user_activation (time,activation_code) values ('".constant('NOWTIME')."','$activation_code')";
		$dbo->exeUpdate($sql);

		//获取激活码的id
		$new_activation_id = mysql_insert_id();

		//查询此注册用户的user_id
		$sql="select user_id from $t_users where user_email='$user_email'";
		$new_user=$dbo->getRow($sql);
		$new_user_id = $new_user['user_id'];

		//将此注册用户的激活码表id关联到用户表 //所有用户注册后即锁定
		$sql="update $t_users set activation_id='$new_activation_id' where user_id=$new_user_id ";
		$dbo->exeUpdate($sql);

		//激活邮件的title和body信息
		$mailtitle = $siteName."新用户激活";
		$mailbody = "尊敬的".$user_name."：<br />您好：".'<br />'."您在".$siteName."上注册了新用户，请点击下面的链接激活您的账户<br /><a href='".$siteDomain."modules.php?app=user_activation&user_email=".$user_email."&activation_code=".$activation_code."'>href='".$siteDomain."modules.php?app=user_activation&user_email=".$user_email."&activation_code=".$activation_code."</a>";
		$email_array=explode('@',$user_email);
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
		$result=$smtp->sendmail($user_email,$smtpEmail,$mailtitle,$mailbody,'HTML');

?>
	<script type='text/javascript'>
		location.href='modules.php?app=user_activate_succ&user_email=<?php echo $user_email ?>';
	</script>
<?php
	}
}
?>