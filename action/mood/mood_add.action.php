<?php
//引入模块公共方法文件
$RefreshType = 'ajax';
require ("foundation/aanti_refresh.php");
require ("api/base_support.php");
//引入语言包
$mo_langpackage = new moodlp;
$dbo = new dbex;
//读写分离定义函数
dbtarget('w', $dbServs);
//变量取得
$user_id = get_sess_userid();
$sql = "select user_sex,user_group from wy_users where user_id='{$user_id}'";
$user_info = $dbo->getRow($sql);
if ($user_info["user_sex"] == 1 && ($user_info["user_group"] == 1 || $user_info["user_group"] == "base")) {
    $nums = $dbo->getRow("select count(*) as num from wy_mood where user_id='{$user_id}'");
    //echo "<pre>";print_r($nums);exit;
    if ($nums["num"] >= 3) {
        exit(json_encode(array("status" => 0, "info" => "男会员仅能发布三条心情！")));
        //action_return(0,"男会员仅能发布三条心情！","-1");exit;
    }
}


$user_name = get_sess_username(); //用户名
$uico_url = get_sess_userico(); //用户头像
$mood = long_check(get_argp('mood'));
$mood_pic = long_check(get_argp('mood_r_pic'));
//关键词过滤
$guolvs = explode(',', $filtrateStr);
for ($i = 0;$i < count($guolvs);$i++) {
    //$content=str_replace($guolvs[$i],'***',$content);
    $res = stristr($mood, $guolvs[$i]);
    //echo $res;exit;
    if ($res) {
        exit;
    }
}
//echo "<pre>";print_r($mood);exit;
//防止重复提交
antiRePost($mood);
if (strlen($mood) >= 5000) {
    action_return(0, $mo_langpackage->mo_add_exc, -1);
    exit;
} else {
    //数据表定义区
    $t_mood = $tablePreStr . "mood";
    // $dbo = new dbex;
    // //读写分离定义函数
    // dbtarget('w',$dbServs);
    //留言
    $sql = "insert into $t_mood(`user_id`,`mood`,`mood_pic`,`add_time`,`user_ico`,`user_name`) values($user_id,'$mood','$mood_pic','" . constant('NOWTIME') . "','$uico_url','$user_name')";
    if ($dbo->exeUpdate($sql)) {
        $last_id = mysql_insert_id();
        $title = $mo_langpackage->mo_mood_update;
        $content = $mood;
        //添加动态
        $is_suc = api_proxy("message_set", $last_id, $title, $content, 1, 6);
    }
    //回应信息
    if (get_argg('ajax') == '1') {
        get_face($mood);
        exit(json_encode(array("status" => 1)));
    } else {
        action_return(1, "", "-1");
    }
}
?>