<?php
	//引入语言包
	$m_langpackage=new msglp;

	//变量获得
	$msg_id=intval(get_argg("id"));
	$user_uid=get_sess_userid();
	$del_array=get_argp("attach");

	//数据表定义区
	$t_msg_inbox = $tablePreStr."msg_inbox";
	$t_msg_outbox = $tablePreStr."msg_outbox";

	$dbo = new dbex;
	//读写分离定义函数
	dbtarget('w',$dbServs);
	if($del_array==NULL){
		$del_array[]=$msg_id;
	}

	foreach($del_array as $rs){
		$rs=short_check($rs);
		if(get_argg("t")=="0" || get_argg("t")=="all"){
			if(get_argg("t")=="all"){
				$hhid=get_argg("hhid");
				$sql="delete from $t_msg_inbox where hh_id='$hhid'";
			}else{
				$sql="delete from $t_msg_inbox where mess_id=$rs and user_id=$user_uid";
		   }
		   $reTurnUrl="modules2.0.php?app=msg_minbox";
		}else if(get_argg("t")=="1"){
		   $sql="delete from $t_msg_outbox where mess_id=$rs and user_id=$user_uid";
		   $reTurnUrl="modules2.0.php?app=msg_moutbox";
		}else if(get_argg("t")=="2"){
		   $sql="delete from $t_msg_inbox where mess_id=$rs and user_id=$user_uid";
		   $reTurnUrl="modules2.0.php?app=msg_notice";
		}else if(get_argg("t")=="3"){
			$sql="delete from $t_msg_inbox where mess_id=$_GET[id]";
		   $reTurnUrl="modules2.0.php?app=msg_rpshow&id=".$_GET['id']."&hhid=".$_GET['hhid']."&t=0";
		}
		$dbo ->exeUpdate($sql);
	}

	if(get_argg("h")==NULL){
		//刷新提醒页面
		echo "<script type='text/javascript'>
		  parent.frames['remind'].location.reload();
		  </script>";
	}

	//回应信息
	action_return(1,"",$reTurnUrl);
?>
