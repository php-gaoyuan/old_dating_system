<?php
require("session_check.php");	
require("../api/base_support.php");
	//语言包引入
	$f_langpackage=new foundationlp;
	$ad_langpackage=new adminmenulp;
    //表定义区
    $t_users=$tablePreStr."users";
    $t_msg_inbox=$tablePreStr."msg_inbox";
    //数据库操作初始化
    $dbo = new dbex;
    dbtarget('w',$dbServs);


	$sql="select user_id from $t_users";
	
	$t_users=$dbo->getRs($sql);
    $tuid = array();
    foreach ($t_users as $k => $v) {
        array_push($tuid,$v['user_id']);
    }
    //$tuid = implode(",", $tuid);
    $from_user_ico="skin/$skinUrl/images/d_ico_1_small.gif";
    //print_r($tuid);exit;
    if(isset($_POST['send'])){
        $mess_title = trim($_POST['mess_title']);
        $mess_content = $_POST['mess_content'];

        // $sql = "insert into $t_msg_inbox (mess_title,mess_content,from_user_id,from_user,mesinit_id,from_user_ico,user_id) values ";
        /*foreach ($tuid as $k => $v) {
            if(($k+1)==count($tuid)){
               $sql.="('{$mess_title}','{$mess_content}',0,'管理员通知',0,'{$from_user_ico}',$v);"; 
            }else{
              $sql.="('{$mess_title}','{$mess_content}',0,'管理员通知',0,'{$from_user_ico}',$v),";  
            }
            
        }*/
        foreach ($tuid as $k => $v) {
            $sql = "insert into $t_msg_inbox (mess_title,mess_content,from_user_id,from_user,mesinit_id,from_user_ico,user_id) values ('{$mess_title}','{$mess_content}',0,'管理员通知',0,'{$from_user_ico}',$v);";
            $rows = $dbo->exeUpdate($sql);
        }
       // echo $sql;die;
        // $dbo->exeUpdate($sql);die;
        if($rows){
            echo "<script type='text/javascript'>alert('发送成功');history.back();</script>";
        }else{
            echo "<script type='text/javascript'>alert('发送失败');history.back();</script>";
        }
        

    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


</head>
<body>
  

</body>
</html>