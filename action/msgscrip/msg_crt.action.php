<?php
//引入模块公共方法文件
require ("foundation/aanti_refresh.php");
require ("foundation/goodlefanyi.php");
require ("foundation/fgrade.php");
require ("api/base_support.php");
//引入邮件发送极致
require("iweb_mini_lib/send_email.php");
//引入语言包
$m_langpackage = new msglp;
$u_langpackage = new userslp;
$b_langpackage = new bottlelp;
$dbo = new dbex;
//变量获得
$msgStr = "";
$msg_touser = intval(get_argp("msToId"));
$msg_title = short_check(get_argp("msTitle"));
$msg_txt = stripslashes(get_argp("msContent"));
$transtype = get_argp("hf_fanyi");
$touser_id = ""; //收件人id
$touser = ""; //收件人name
$tousex = "";
$user_id = get_sess_userid(); //发件人id
$user_name = get_sess_username(); //发件人姓名
$user_ico = get_sess_userico();
//读写分离定义函数
dbtarget('w', $dbServs);

//防止重复提交
antiRePost($msg_txt);
$uinfo = $dbo->getRow("select user_email, email_passwd, user_name, golds, user_sex, user_group, integral, email_num, email_time from wy_users where user_id='$user_id'");

/*
	if(empty($uinfo['mail_num'])){
		$uinfo['mail_num']=0;
	}
	//普通会员（免费发三封）
	if(($uinfo['user_group']=='base' || $uinfo['user_group']==1) && $uinfo['user_sex'] == 1){
		if($uinfo['mail_num']>2){
			if ($uinfo['golds'] <1) {
				echo "<script>top.Dialog.alert('".$u_langpackage->fy_tishi1."');</script>";
				echo "<script>top.location.href='http://www.pauzzz.com/main2.0.php?app=user_pay';</script>";exit;
    			//action_return(0,,"main2.0.php?app=user_pay");exit;
    		} 
		}else{
			$new_num=$uinfo['mail_num']+1 ;
			$dbo->exeUpdate("update wy_users set mail_num='$new_num',email_time='".date('Y-m-d')."' where user_id='$user_id'");
		}
	}*/
//判断当天发了多少封，如果已发40封，就不可再发
if ($uinfo['email_time'] == date("Y-m-d")) {
    $new_num = $uinfo['email_num'] + 1;
} else {
    $new_num = 1;
}
//echo "<pre>";print_r($uinfo);exit;
if (($uinfo['user_group'] == 'base' || $uinfo['user_group'] == 1) && $uinfo['user_sex'] == 1) {
    //$nnnn=count_level2($uinfo['integral'])+40;
    $nnnn = 2;
    if ($uinfo['email_num'] > $nnnn && $uinfo['email_time'] == date("Y-m-d")) {
        if ($uinfo['golds'] < 1) {
            echo "<script>alert('" . $u_langpackage->fy_tishi1 . "');</script>";
            echo "<script>top.location.href='http://www.pauzzz.com/main2.0.php?app=user_pay';</script>";
            exit;
        }
        //action_return(0,$b_langpackage->b_xianzhi,-1);exit;
        
    } else {
        $dbo->exeUpdate("update wy_users set email_num='$new_num',email_time='" . date('Y-m-d') . "' where user_id='$user_id'");
    }
}
//数据表定义
$t_users = $tablePreStr . "users";
$t_msg_outbox = $tablePreStr . "msg_outbox";
$t_msg_inbox = $tablePreStr . "msg_inbox";
$user_self = api_proxy("user_self_by_uid", "*", $user_id);
//设置会话ID 、合并会话
if (get_argp("mesid") == "") {
    $hh_id = date("His") . mt_rand(100, 999);
} else {
    $mess_id = intval(get_argp("mesid"));
    $hh = $dbo->getRow("select hh_id from $t_msg_inbox where mess_id='$mess_id' ");
    //print_r($hh);exit;
    $hh_id = $hh['hh_id'];
}

//判断邮件长度
if (mb_strlen($msg_txt) >= 1500) {
    //action_return(0, $m_langpackage->m_add_exc, -1);exit;
}
$toidUrlStr = "";
if (get_argp("2id") != "") {
    $msg_touser = intval(get_argp("2id"));
    $mesid = intval(get_argp("mesid"));
    $sql = "update $t_msg_inbox set readed='2' where mess_id=$mesid";
    $dbo->exeUpdate($sql);
    $toidUrlStr = "&2id=" . $msg_touser;
    if (get_argp("nw") != "") {
        $toidUrlStr = $toidUrlStr . "&nw=1";
    } //判断是否为新窗口
    
}
if (empty($msg_touser) && get_argp("newsType") != "") {
    $users_row = $dbo->getRow("select user_id,user_email,user_name,user_ico from wy_users where user_name='" . get_argp("newsType") . "'");
} else {
    $users_row = api_proxy("user_self_by_uid", "user_id,user_name,user_ico,user_email", $msg_touser);
}

if ($users_row) {
    $touser_id = $users_row[0];
    $touser = $users_row[1];
    $touser_ico = $users_row[2];
    if ($touser_id == $user_id) {
        action_return(0, $m_langpackage->m_no_mys, "modules.php?app=msg_creator");
    }
} else {
    action_return(0, $m_langpackage->m_one_err, "modules.php?app=msg_creator");
}
//关键词过滤
$guolvs = explode(',', $filtrateStr);
for ($i = 0;$i < count($guolvs);$i++) {
    //$content=str_replace($guolvs[$i],'***',$content);
    $res = stristr($msg_title, $guolvs[$i]);
    $res2 = stristr($msg_txt, $guolvs[$i]);
    if ($res || $res2) {
        //action_return(0, $u_langpackage->feifazifu, -1);exit;
    }
}
//翻译
if ($transtype) {
    $msg_title = file_get_contents("$siteDomain/fanyi.php?lan=" . $msg_title . "&tos=" . $transtype);
    $msg_txt = file_get_contents("$siteDomain/fanyi.php?lan=" . $msg_txt . "&tos=" . $transtype);
    //判断金币 扣除
    $need = (int)(strlen($msg_txt) / 100);
    if ($need < 1) $need = 1;
    $jinbi_arr = $dbo->getRow("select golds from wy_users where user_id='$user_id' ");
    if ($need > $jinbi_arr['golds']) {
        action_return(0, $m_langpackage->m_jinbibuzu, -1);
        exit;
    } else {
        $jinbi_yue = $jinbi_arr['golds'] - 1;
        $dbo->exeUpdate("update wy_users set golds='$jinbi_yue' where user_id='$user_id'");
    }
}
$msg_txt = str_replace('\'', '’', $msg_txt);
$msg_title = str_replace('\'', '’', $msg_title);
$score = 1;
if (($user_self['golds'] - $score) >= 0 && $user_self['user_sex'] == 1 && ($user_self['user_group'] == 1 || $user_self['user_group'] == 'base')) {
    $ordernumber = 'S-P' . time() . mt_rand(100, 999);
    $sql = "insert into wy_balance set type='3',uid='$user_id',uname='$user_name',touid='$touser_id',touname='$touser',message='站内信费用:" . $score . "',state='2',addtime=now(),funds='$score',ordernumber='$ordernumber'";
    $dbo->exeUpdate($sql);
    //更新用户的积分
    $sql = "update wy_users set golds=golds-$score where user_id=$user_id";
    $dbo->exeUpdate($sql);
}
/*else
  {
	  action_return(0,$m_langpackage->m_cread_put,"modules.php?app=user_pay");
  }*/
/*$dbo = new dbex;
  //读写分离定义函数
  dbtarget('w',$dbServs);*/
/*
  $img="";
  if (!empty($_FILES["mypictures"]["name"])) { //提取文件域内容名称，并判断
		$path=$webRoot."uploadfiles/myscript/";
		//上传路径
		if(!file_exists($path))
		{
			//检查是否有该文件夹，如果没有就创建，并给予最高权限
			mkdir($path, 0700);
		}
		//允许上传的文件格式
		$tp = array("image/gif","image/pjpeg","image/jpeg");
		//检查上传文件是否在允许上传的类型
		if(!in_array($_FILES["mypictures"]["type"],$tp))
		{
			echo "<script>alert('格式不对');history.go(-1);</script>";
			exit;
		}//END IF
		$filetype = $_FILES['mypictures']['type'];
		if($filetype == 'image/jpeg'){
			$type = '.jpg';
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
		if($_FILES["mypictures"]["name"])
		{
			$today=date("YmdHis"); //获取时间并赋值给变量
			$file2 = $path.$today.$type; //图片的完整路径
			$img = $today.$type; //图片名称
			$flag=1;
		}
		if($flag)
		{
			$result=move_uploaded_file($_FILES["mypictures"]["tmp_name"],$file2);
		}

		$widths=getimagesize($file2);
		if($widths[0]>300)
		{
			$width=' width="300"';
		}
		else
		{
			$width='';
		}

		if(empty($width))
		{
			if($widths[1]>300)
			{
				$height=' height="300"';
			}
			else
			{
				$height='';
			}
		}

		$img='<br/><img src="uploadfiles/myscript/'.$img.'"'.$width.$height.' />';
	}
*/

//print_r($users_row);exit; 
//写入发件箱
$sql = "insert into $t_msg_outbox (mess_title,mess_content,to_user_id,to_user,to_user_ico,user_id,add_time,state,mess_acc) value('$msg_title','$msg_txt',$touser_id,'$touser','$touser_ico',$user_id,'" . constant('NOWTIME') . "','1','$img')";

if (!$dbo->exeUpdate($sql)) {
    action_return(0, $m_langpackage->m_data_err, "-1");
    exit;
}


//写入收件箱sql
$sql = "insert into $t_msg_inbox (mess_title,hh_id,mess_content,from_user_id,from_user,from_user_ico,user_id,add_time,mesinit_id,transtype,transtate,enmess_title,enmess_content,mess_acc) value('$msg_title','$hh_id','$msg_txt',$user_id,'$user_name','$user_ico',$touser_id,'" . constant('NOWTIME') . "',LAST_INSERT_ID(),'0','1','$msg_title','$msg_txt','$img')";
if ($dbo->exeUpdate($sql)) {
    //$sql="update $t_msg_inbox set mess_content=concat(mess_content,'','$img'),enmess_content=concat(enmess_content,'','$img') where mess_id=".mysql_insert_id();
    //$dbo ->exeUpdate($sql);
    api_proxy("message_set", $touser_id, $m_langpackage->m_remind, "modules.php?app=msg_minbox", 0, 5, "remind");
    

    if (get_argp('nw') == "2") {
        action_return(1, '', "modules.php?app=msg_moutbox");
    } else {
        action_return(1, '', "modules.php?app=msg_moutbox");
    }
} else {
    $sql = "update $t_msg_outbox set state='0' where mess_id=LAST_INSERT_ID()";
    $dbo->exeUpdate($sql);
    action_return(0, $m_langpackage->m_send_err, "-1");
}




function jump($url = '', $word = '') {
    if ($url == - 1) {
        $url = $_SERVER["HTTP_REFERER"];
    }
    if ($url == - 2 && $_GET['from_url'] != '') {
        $url = $_GET['from_url'];
    }
    if (is_numeric($url) && $url != - 1) {
        echo script($alert . 'history.go(' . $url . ');');
    } else {
        echo script($alert . 'window.location.href="' . $url . '";');
    }
    exit();
}
?>

