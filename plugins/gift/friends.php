<?php
header("Content-Type: text/html;chartset=UTF-8");
$iweb_power=true;
$getpost_power=true;
include_once(dirname(__file__)."/../includes.php");
$friends=array();
if(get_sess_userid())
{
	$friends=Api_Proxy("pals_self_by_paid","pals_name,pals_id,pals_ico");
	foreach($friends as $friend)
	{
	echo "<div style='float:left; text-align:center; width:60px;height:80px;'><img width=30 height=30 style='border:2px solid #EFEFEF;padding:1px;overflow:hidden' src='".self_url(__file__)."../../{$friend['pals_ico']}'/><br /><span id='gift_accept_{$friend['pals_id']}'>{$friend['pals_name']}</span><br /><input type='radio' name='accept_id' onclick='' value='{$friend['pals_id']}'/></div>";
	}
}
?>