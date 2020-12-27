<?php
require("includet.php");
$url = "https://missinglovelove.com?tuid=".get_session("wz_userid");
?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>
        后台管理系统
    </title>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/skin/gaoyuan/layui/css/layui.css">
</head>
<body>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <blockquote class="layui-elem-quote">推广地址：<?php echo $url;?></blockquote>
        </div>
    </div>
</div>
</body>