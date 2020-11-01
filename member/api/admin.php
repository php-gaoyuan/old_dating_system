<?php
require("../includet.php");

//初始化数据库
$dbo = new dbex;
dbtarget('w', $dbServs);
$act = isset($_REQUEST["act"]) && !empty($_REQUEST["act"]) ? $_REQUEST["act"] : 'index';
$wz_userid = get_session('wz_userid');

if ($act == "editpwd") {
    $userpass = get_args("userpass");
    $oldpass = get_args("oldpass");

    $dbo = new dbex;
    dbtarget('r', $dbServs);
    $sql = "select * from wy_wangzhuan where name='" . get_session('wz_uname') . "'";
    $wangzhuan = $dbo->getRow($sql);
    if (is_array($wangzhuan)) {
        if (md5($oldpass) == $wangzhuan['password']) {
            $sql = "update wy_wangzhuan set password='" . md5($userpass) . "' where name='" . get_session('wz_uname') . "'";
            if ($dbo->exeUpdate($sql)) {
                echo json(array("code" => 0, "msg" => "密码修改成功", "url" => ""));
                exit;
            }
        } else {
            echo json(array("code" => 1, "msg" => "原始密码不正确", "url" => ""));
            exit;

        }
    } else {
        session_unset();
        echo json(array("code" => 1, "msg" => "该用户信息不存在", "url" => ""));
        exit;
    }
}
?>