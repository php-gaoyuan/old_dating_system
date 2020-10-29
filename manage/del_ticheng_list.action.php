<?php
require("session_check.php");	
require("../api/base_support.php");

//表定义区
$t_balance=$tablePreStr."balance";
//数据库操作初始化
$dbo = new dbex;
dbtarget('w',$dbServs);
//变量区
$id=$_GET['id'];

$sql = "delete from $t_balance where id=$id";

    if($dbo->exeUpdate($sql)){
       echo 1;
    }else{
       echo "删除失败";
    }

?>