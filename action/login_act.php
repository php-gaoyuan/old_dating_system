<?php
//引入语言包
$l_langpackage=new loginlp;
$re_langpackage=new reglp;
$l_langpackage=new loginlp;

require("foundation/module_mypals.php");
require("foundation/aintegral.php");
/*小于4位*/
if(strlen(get_argp("u_email"))<4){
    echo 'emailmsg|'.$l_langpackage->l_not_check;
    exit();
}
/*密码空*/
if(get_argp("u_pws")==NULL){
    echo 'pwdmsg|'.$l_langpackage->l_empty_pass;
    exit();
}

$u_email=short_check(get_argp("u_email")); //用户名已经记录了
$user_pws=md5(get_argp("u_pws")); //密码已经记录了
$hidden=intval(get_argp('hidden'));//登录方式

//数据表定义区
$t_users=$tablePreStr."users";
$t_group_members=$tablePreStr."group_members";
$t_online=$tablePreStr."online";
$t_mypals=$tablePreStr."pals_mine";
$t_frontgroup=$tablePreStr."frontgroup";

//定义读操作
dbtarget('r',$dbServs);
$dbo=new dbex;
$sql="select * from $t_users where user_email='$u_email' or user_name='$u_email'";
$user_info=$dbo->getRow($sql);


/*用户为空*/
if(empty($user_info)){
    echo 'emailmsg|'.$l_langpackage->l_not_check;
    exit();
}

$get_pws=$user_info['user_pws'];
/*密码错误*/
if($get_pws!=$user_pws){
    echo 'pwdmsg|'.$l_langpackage->l_wrong_pass;
    exit();
}
/*锁定*/
if($user_info['is_pass']=='0'){
    echo 'emailmsg|'.$l_langpackage->l_lock_u;
    exit();
}
//邮箱激活校验
if($mailActivation == 1){
    if($user_info['activation_id'] != -1){
        set_session('email',$u_email);
        echo 'active|';
        exit;
    }
}

if(empty($user_info["user_ico"])){
    $user_info["user_ico"] = "http://{$_SERVER['HTTP_HOST']}/skin/default/jooyea/images/d_ico_{$user_info['user_sex']}.gif";
}

$mypals=getMypals($dbo,$user_info['user_id'],$t_mypals);
set_sess_mypals($mypals);
set_sess_username($user_info['user_name']);
set_sess_userid($user_info['user_id']);
set_sess_usersex($user_info['user_sex']);
set_sess_cgroup($user_info['creat_group']);
set_sess_jgroup($user_info['join_group']);
set_sess_userico($user_info['user_ico']);
set_session('reside_province',$user_info['reside_province']);
set_session('reside_city',$user_info['reside_city']);
set_session('hidden_pals',$user_info['hidden_pals_id']);
set_session('hidden_type',$user_info['hidden_type_id']);
set_sess_plugins($user_info['use_plugins']);
set_sess_apps($user_info['use_apps']);
set_sess_online($hidden);
set_session($user_info['user_id']."_dressup",$user_info['dressup']);

setcookie("user_id",$user_info["user_id"]);
$_SESSION["user_id"] = $user_info["user_id"];


$sql="select * from $t_frontgroup where gid='$user_info[user_group]'";
$rights=$dbo->getRow($sql);
if($rights)set_sess_rights($rights['rights']);
else  set_sess_rights("");

//定义写操作
dbtarget('w',$dbServs);
$now_time=time();

$last_data=date("Y-m-d",strtotime($user_info['lastlogin_datetime']));
$now_data=date("Y-m-d",$now_time);

if($last_data!=$now_data){
    increase_integral($dbo,$int_login,$user_info['user_id']);
}

$sql="delete from $t_online where user_id=$user_info[user_id]";
$dbo->exeUpdate($sql);

$sql="insert into $t_online (user_id,user_name,user_sex,user_ico,birth_province,birth_city,reside_province,reside_city,active_time,hidden,birth_year) values ".
    "($user_info[user_id],'$user_info[user_name]',$user_info[user_sex],'$user_info[user_ico]','$user_info[birth_province]','$user_info[birth_city]','$user_info[reside_province]','$user_info[reside_city]',$now_time,$hidden,'$user_info[birth_year]')";
$dbo->exeUpdate($sql);


$ip = get_client_ip();
$sql="update $t_users set lastlogin_datetime='".constant('NOWTIME')."',login_ip='$ip' where user_id=$user_info[user_id]";
$dbo->exeUpdate($sql);



//判断chat_users有没有信息
$info = $dbo->getRow("select * from chat_users where uid='{$userinfo['user_id']}'");
if(empty($info)){
    if(empty($userinfo["user_ico"])){
        $userinfo["user_ico"] = "skin/default/jooyea/images/d_ico_".$userinfo["user_sex"].".gif";
    }
    //插入数据
    $sql = "INSERT INTO `chat_users` (`uid`,`u_name`,`u_ico`,`last_time`) VALUES ('{$user_id}','{$userinfo['user_name']}','{$userinfo['user_ico']}','".time()."')";

    //echo "<pre>";print_r($sql);exit;
    $dbo->exeUpdate($sql);
}
unset($info);



if(get_sess_preloginurl()){
    echo get_sess_preloginurl();
}else{
    echo '1|';
    set_sess_preloginurl('');
}



function get_client_ip($type = 0) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {//客户端的ip
        $ip     =   $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {//浏览当前页面的用户计算机的网关
        $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos    =   array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip     =   trim($arr[0]);
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];//浏览当前页面的用户计算机的ip地址
    }else{
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}
?>