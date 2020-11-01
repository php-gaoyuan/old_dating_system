<?php
require("../../foundation/asession.php");
require("../../configuration.php");
require("../../includes.php");
require("../../function.php");
require("../../foundation/common.php");




$act = isset($_REQUEST["act"]) && !empty($_REQUEST["act"]) ? $_REQUEST["act"] : 'login';

//初始化数据库
$dbo = new dbex;
dbtarget('w', $dbServs);

if ($act == "login") {
    $userpwd = get_argp("userpwd");
    $email = get_argp("email");

    $sql = "select * from wy_wangzhuan where name='$email'";
    $wangzhuan = $dbo->getRow($sql,"arr");

    if (count($wangzhuan) > 1 && md5($userpwd) == $wangzhuan['password']) {
        if ($wangzhuan['loginstate'] == 1) {
            exit(json(["code"=>1,"msg"=>"你的帐号正在被审核，请耐心等待。","url"=>""]));
        } else {
            $logintime = time();
            set_session('wz_userid', $wangzhuan['id']);
            set_session('wz_uname', $wangzhuan['name']);
            set_session('logintime', $logintime);
            $sql = "update wy_wangzhuan set logintime='$logintime',loginip='$_SERVER[REMOTE_ADDR]' where id='$wangzhuan[id]'";
            $dbo->exeUpdate($sql);
            exit(json(["code"=>1,"msg"=>"登录成功","url"=>"index.php"]));
        }
    } else {
        exit(json(["code"=>1,"msg"=>"你的你输入的帐号或密码有误","url"=>""]));
    }
} elseif ($act == "loginout") {
    session_unset();
    echo "<script>location.href='../login.php';</script>";
    exit;
}