<?php
header("content-type:text/html;charset=utf-8");

require("foundation/asession.php");
require("configuration.php");
require("includes.php");
//必须登录才能浏览该页面
require("foundation/auser_mustlogin.php");
require("foundation/module_users.php");
require("foundation/fplugin.php");
require("api/base_support.php");
require("foundation/fdnurl_aget.php");
require("foundation/fgrade.php");
//语言包引入
$u_langpackage=new userslp;
$ef_langpackage=new event_frontlp;
$mn_langpackage=new menulp;
$pu_langpackage=new publiclp;
$mp_langpackage=new mypalslp;
$s_langpackage=new sharelp;
$hi_langpackage=new hilp;
$l_langpackage=new loginlp;
$rp_langpackage=new reportlp;
$ah_langpackage=new arrayhomelp;

$user_id=get_sess_userid();
$user_name=get_sess_username();
$user_info=api_proxy("user_self_by_uid","guest_num,user_ico,integral,onlinetimecount",$user_id);
if(empty($user_info)){
	echo "<script type='text/javascript'>alert('{$pu_langpackage->pu_lockdel}');location.href='do.php?act=logout';</script>";
}


/*
    $user_ico=end(explode('/',$user_info['user_ico']));
   
    if($user_ico=='d_ico_0_small.gif'||$user_ico=='d_ico_1_small.gif'){
        echo "<script type='text/javascript'>alert('请上传头像');window.open('modules.php?app=user_ico','user_ico','left=300,top=120');</script>";
        exit;
    }
*/
	$dbo = new dbex;
	dbtarget('r',$dbServs);
    //照片数量
    $sql="select photo_num from wy_album where user_id=$user_id";

    $p_num=$dbo->getRow($sql);

   $photo_num = $p_num['photo_num'];
   //金币邮票个数
   $sqlg = "select golds,stamps_num from wy_users where user_id=$user_id";

   $golds = $dbo->getRow($sqlg);

   $golds_num = $golds['golds'];
   $stamps_num = $golds['stamps_num'];

   	//获取用户自定义属性列表
	//$information_rs=array();
	//$information_rs=userInformationGetList($dbo,'*');

    //好友速配推荐
	//$friends_list=$dbo->getRs("select user_id,user_name,user_ico from wy_users order by rand() limit 0,12");
    

?>