<?php
require("includet.php");
?>
<html>
<head>
    <title>网站管理系统</title>
    <link href="css/Guest.css" rel="stylesheet" type="text/css"/>
    <script src="js/system.js"></script>
</head>
<body>

<dl class="menu_area">
    <dt>会员中心</dt>
    <dd style="background:url(images/table_01.gif) repeat-x;">
        <ul>
            <li><a href="right.php" target="right">我的会员</a></li>
            <li><a href="shoping.php" target="right">提成明细</a></li>
            <li><a href="tuiguang.php" target="right">邀请链接</a></li>
            <li><a href="online_member.php" target="right">在线会员</a></li>
<!--            <li><a href="gongzi.php" target="right">变更记录</a></li>-->


            <!-- gaoyuanadd -->
            <li><a href="bang.php" target="right">绑定会员</a></li>

            <!-- Add By Root  Time:201410121 Begin -->
            <li><a href="root.php" target="right">充值消费记录会员名单</a></li>
            <!-- Add By Root  Time:201410121 Begin -->

        </ul>
    </dd>
</dl>


<dl class="menu_area">
    <dt>个人资料</dt>
    <dd style="background:url(images/table_01.gif) repeat-x;">
        <ul>
            <!-- <li><a href="#">信息反馈</a></li> -->
            <li><a href="editm.php" target="right">密码修改</a></li>
        </ul>
    </dd>
</dl>


</body>
</html>