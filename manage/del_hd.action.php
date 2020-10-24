<?php
require("session_check.php");	
require("../api/base_support.php");

//数据库操作初始化
$dbo = new dbex;
dbtarget('w',$dbServs);
//变量区
$id=$_GET['id'];

$sql = "delete from wy_hd where id=$id";

    if($dbo->exeUpdate($sql)){
       echo "删除成功";
    }else{
        echo  "删除失败";
    }

?>