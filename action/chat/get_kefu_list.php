<?php
$pu_langpackage=new publiclp;
$dbo = new dbex;
dbtarget('r',$dbServs);
$t_online=$tablePreStr."online";
$service_num=$_GET['type'];
if($service_num!=0){
	$where=" is_service =".$service_num;
}else{
	$where=" is_service >0";
}
//$sql="select o.user_name,o.user_ico,o.user_id from wy_online as o left join wy_users as u on o.user_id=u.user_id ".$where." order by o.active_time desc";
$sql="select user_name,user_ico,user_id from wy_users where $where ";

$service_list=$dbo->getRs($sql);
foreach($service_list as $k=>$v){
	$affair=$dbo->getRow("select content from wy_recent_affair where user_id=$v[user_id] and type_id=1 order by update_time desc limit 1");
	$service_list[$k]['content']=$affair['content'];
}
foreach($service_list as $slist){
	$con.="<div class='kefu_lists'>
			<a class='kefu_img' href='modules.php?app=u_chat_info'><img src='$slist[user_ico]' /></a>
			<div class='kefu_jianjie' title='$slist[content]'>$slist[user_name][在线]:\"$slist[content]\"</div>
			<a class='btn_zixun' href='modules.php?app=u_chat_info'>".$pu_langpackage->zixun_chat."</a>
		</div>";
 }
echo $con."<div style='clear:both'></div>";
?>