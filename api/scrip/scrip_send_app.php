<?php
include(dirname(__file__)."/../includes.php");
function scrip_send_app($sender,$title,$content,$to_id,$scrip_id='',$suid='',$userico=''){
	
	//echo time();
	global $tablePreStr;
	$uid=$suid;
	$uico=$userico;
	$t_scrip=$tablePreStr."msg_inbox";
	$dbo=new dbex;
  dbplugin('w');
	$sql="insert into $t_scrip (mess_title,mess_content,from_user,from_user_ico,user_id,add_time,from_user_id,mesinit_id)"
	                    ."value('$title','$content','$sender','$uico',$to_id,'".constant('NOWTIME')."',$uid,'$scrip_id')";
  return $dbo->exeUpdate($sql);
}


?>