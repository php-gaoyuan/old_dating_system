<?php
file_put_contents("ipasspay_return.log",date("Y-m-d H:i:s").PHP_EOL.var_export($_GET,true).PHP_EOL,FILE_APPEND);
$errmsg = $_GET['errmsg'];
echo "<script>alert('{$errmsg}');location.href='/';</script>";