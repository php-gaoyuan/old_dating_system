<?php
//数据库连接控制方法
function dbtarget($rwAction, $dbServs)
{
    //$rwAction参数为SI库处理数据库读写分离时使用参数
    return db_conn($dbServs['host'], $dbServs['user'], $dbServs['pwd'], $dbServs['db']);
}

function dbplugin($rw)
{
    global $dbServs;
    dbtarget($rw, $dbServs);
}

//建立数据库连接
function db_conn($host, $user, $pwd, $db)
{
    $connStr = mysqli_connect($host, $user, $pwd,$db) or die('<script type="text/javascript">location.href="servtools/error.php?error_type=dberr";</script>');
    if ($connStr) {
        mysqli_query($connStr,"set names 'UTF8'");
        return $connStr;
    } else {
        return false;
    }
}

//释放数据库连接
function dbtarget_free()
{
    //mysqli_close();
}

?>