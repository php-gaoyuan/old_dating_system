<?php
//引入公共模块
require("foundation/module_event.php");
require("api/base_support.php");

//引入语言包
$er_langpackage = new rechargelp;
$dopost = "savesend";

//必须登录才能浏览该页面
require("foundation/auser_mustlogin.php");

$user_id = get_sess_userid();
//限制时间段访问站点
limit_time($limit_action_time);

$userinfo = Api_Proxy("user_self_by_uid", "*", $user_id);

$info = "<font color='#ce1221' style='font-weight:bold;'>" . $er_langpackage->er_currency . "</font>：" . $userinfo['golds'];

if ($userinfo['user_group'] > 1) {
    $groups = $dbo->getRow("select * from wy_frontgroup where gid='$userinfo[user_group]'");

    if ($langPackagePara != 'zh') {
        $groups['name'] = str_replace('普通会员', '', $groups['name']);
        $groups['name'] = str_replace('高级会员', $er_langpackage->js_8, $groups['name']);
        $groups['name'] = str_replace('星级会员', $er_langpackage->js_10, $groups['name']);
    }
    $info .= "&nbsp;&nbsp;&nbsp;&nbsp;" . $er_langpackage->er_nowtype . "：" . $groups['name'];

    $groups = $dbo->getRow("select * from wy_upgrade_log where mid='$user_id' and state='0' order by id desc limit 1");
    $startdate = strtotime(date("Y-m-d"));
    $enddate = strtotime($groups['endtime']);
    $days = round(($enddate - $startdate) / 3600 / 24);
    $info .= "&nbsp;&nbsp;&nbsp;&nbsp;" . $er_langpackage->er_howtime . "：" . $days . $er_langpackage->er_day;
}
?>
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl; ?>/css/iframe.css"/>
<body onload="parent.get_mess_count();">

<div class="tabs">
    <ul class="menu">
        <li><a href="modules2.0.php?app=user_pay"><?php echo $er_langpackage->er_recharge; ?></a></li>
        <li><a href="modules2.0.php?app=user_upgrade"><?php echo $er_langpackage->er_upgrade; ?></a></li>
        <!--<li><a href="modules2.0.php?app=user_consumption"><?php echo $er_langpackage->er_consumption_log; ?></a></li>-->
        <!--        <li  class="active"><a href="modules2.0.php?app=user_introduce">-->
        <?php //echo $er_langpackage->er_introduce; ?><!--</a></li>-->
        <!--<li><a href="modules2.0.php?app=user_help"><?php echo $er_langpackage->er_help; ?></a></li>-->
    </ul>
</div>
<div class="tabs" style="border:1px solid #ce1221;text-align:left;background:#F5F5B9;padding-left:15px;">
    <?php echo $info; ?>
</div>
<div class="feedcontainer">

    <table width="550" border="0" cellspacing="0" cellpadding="0" style="font-size: 12px;color: #666;line-height:20px;">
        <tr>
            <td height="30" style="color:#555; font-weight:bold;"><?php echo $er_langpackage->js_1; ?></td>
        </tr>
    </table>
    <table width="550" border="0" cellpadding="0" cellspacing="1" bgcolor="#EECAF0"
           style="font-size: 12px;color: #666;line-height:20px;">
        <tr>
            <td width="78" height="30" align="center" bgcolor="#FAE4FA"><b><?php echo $er_langpackage->js_2; ?></b></td>
            <td width="51" align="center" bgcolor="#FAE4FA"><b><?php echo $er_langpackage->js_3; ?></b></td>
            <td width="417" align="center" bgcolor="#FAE4FA"><b><?php echo $er_langpackage->js_4; ?></b></td>
            <td width="100" align="center" bgcolor="#FAE4FA"><b><?php echo $er_langpackage->js_5; ?></b></td>
        </tr>
        <tr>
            <td height="30" align="center" bgcolor="#FFFDFF"><?php echo $er_langpackage->js_6; ?></td>
            <td align="center" bgcolor="#FFFDFF">X</td>
            <td bgcolor="#FFFDFF" style="padding:10px;"><?php echo $er_langpackage->js_7; ?></td>
            <td align="center" bgcolor="#FFFDFF"></td>
        </tr>
        <tr>
            <td height="30" align="center" bgcolor="#FFFDFF"><?php echo $er_langpackage->js_8; ?></td>
            <td align="center" bgcolor="#FFFDFF"><img src="skin/default/jooyea/images/xin/gaoji.png"/></td>
            <td bgcolor="#FFFDFF" style="padding:10px;"><?php echo $er_langpackage->js_9; ?>
            </td>
            <td align="center" bgcolor="#FFFDFF"><a style="color:#2C589E"
                                                    href="modules2.0.php?app=user_upgrade"><?php echo $er_langpackage->js_sj; ?></a>
            </td>
        </tr>
        <tr>
            <td height="30" align="center" bgcolor="#FFFDFF"><?php echo $er_langpackage->js_10; ?></td>
            <td align="center" bgcolor="#FFFDFF"><img src="skin/default/jooyea/images/xin/vip.gif"/></td>
            <td bgcolor="#FFFDFF" style="padding:10px;"><?php echo $er_langpackage->js_11; ?></td>
            <td align="center" bgcolor="#FFFDFF"><a style="color:#2C589E"
                                                    href="modules2.0.php?app=user_upgrade"><?php echo $er_langpackage->js_sj; ?></a>
            </td>
        </tr>
    </table>
    <br/>
    <table width="550" border="0" cellspacing="0" cellpadding="0" style="font-size: 12px;color: #666;line-height:20px;">
        <tr>
            <td height="30" style="color:#555; font-weight:bold;"><?php echo $er_langpackage->js_12; ?></td>
        </tr>
    </table>
    <table width="550" border="0" cellpadding="0" cellspacing="1" bgcolor="#EECAF0"
           style="font-size: 12px;color: #666;line-height:20px;">
        <tr>
            <td width="78" height="30" align="center" bgcolor="#FAE4FA"><b><?php echo $er_langpackage->js_13; ?></b>
            </td>
            <td width="80" align="center" bgcolor="#FAE4FA"><b><?php echo $er_langpackage->js_14; ?></b></td>
            <td width="100" align="center" bgcolor="#FAE4FA"><b><?php echo $er_langpackage->js_15; ?></b></td>
            <td width="100" align="center" bgcolor="#FAE4FA"><b><?php echo $er_langpackage->js_16; ?></b></td>
            <td width="100" align="center" bgcolor="#FAE4FA"><b><?php echo $er_langpackage->js_17; ?></b></td>
        </tr>
        <tr>
            <td height="30" align="center" bgcolor="#FFFDFF">1</td>
            <td align="center" bgcolor="#FFFDFF"><img src="skin/default/jooyea/images/xin/t03.jpg"></td>
            <td align="center" bgcolor="#FFFDFF">1</td>
            <td align="center" bgcolor="#FFFDFF">0.7</td>
            <td align="center" bgcolor="#FFFDFF">0.5</td>
        </tr>
        <tr>
            <td height="30" align="center" bgcolor="#FFFDFF">2</td>
            <td align="center" bgcolor="#FFFDFF"><img src="skin/default/jooyea/images/xin/t03.jpg"><img
                        src="skin/default/jooyea/images/xin/t03.jpg"></td>
            <td align="center" bgcolor="#FFFDFF">8</td>
            <td align="center" bgcolor="#FFFDFF">5</td>
            <td align="center" bgcolor="#FFFDFF">4</td>
        </tr>
        <tr>
            <td height="30" align="center" bgcolor="#FFFDFF">3</td>
            <td align="center" bgcolor="#FFFDFF"><img src="skin/default/jooyea/images/xin/t03.jpg"><img
                        src="skin/default/jooyea/images/xin/t03.jpg"><img src="skin/default/jooyea/images/xin/t03.jpg">
            </td>
            <td align="center" bgcolor="#FFFDFF">27</td>
            <td align="center" bgcolor="#FFFDFF">18</td>
            <td align="center" bgcolor="#FFFDFF">13.5</td>
        </tr>
        <tr>
            <td height="30" align="center" bgcolor="#FFFDFF">4</td>
            <td align="center" bgcolor="#FFFDFF"><img src="skin/default/jooyea/images/xin/t02.jpg"></td>
            <td align="center" bgcolor="#FFFDFF">64</td>
            <td align="center" bgcolor="#FFFDFF">43</td>
            <td align="center" bgcolor="#FFFDFF">32</td>
        </tr>
        <tr>
            <td height="30" align="center" bgcolor="#FFFDFF">8</td>
            <td align="center" bgcolor="#FFFDFF"><img src="skin/default/jooyea/images/xin/t02.jpg"><img
                        src="skin/default/jooyea/images/xin/t02.jpg"></td>
            <td align="center" bgcolor="#FFFDFF">512</td>
            <td align="center" bgcolor="#FFFDFF">341</td>
            <td align="center" bgcolor="#FFFDFF">256</td>
        </tr>
        <tr>
            <td height="30" align="center" bgcolor="#FFFDFF">12</td>
            <td align="center" bgcolor="#FFFDFF"><img src="skin/default/jooyea/images/xin/t02.jpg"><img
                        src="skin/default/jooyea/images/xin/t02.jpg"><img src="skin/default/jooyea/images/xin/t02.jpg">
            </td>
            <td align="center" bgcolor="#FFFDFF">1728</td>
            <td align="center" bgcolor="#FFFDFF">1152</td>
            <td align="center" bgcolor="#FFFDFF">864</td>
        </tr>
        <tr>
            <td height="30" align="center" bgcolor="#FFFDFF">16</td>
            <td align="center" bgcolor="#FFFDFF"><img src="skin/default/jooyea/images/xin/t01.jpg"></td>
            <td align="center" bgcolor="#FFFDFF">4096</td>
            <td align="center" bgcolor="#FFFDFF">2731</td>
            <td align="center" bgcolor="#FFFDFF">2048</td>
        </tr>
    </table>
    <br/>
    <table width="550" border="0" cellspacing="0" cellpadding="0" style="font-size: 12px;color: #666;line-height:20px;">
        <tr>
            <td height="30" style="color:#555; font-weight:bold;"><?php echo $er_langpackage->js_18; ?></td>
        </tr>
    </table>
    <table width="550" border="0" cellpadding="0" cellspacing="1" bgcolor="#EECAF0"
           style="font-size: 12px;color: #666;line-height:20px;">
        <tr>
            <td width="85" height="30" align="center" bgcolor="#FAE4FA"><b><?php echo $er_langpackage->js_19; ?></b>
            </td>
            <td width="65" align="center" bgcolor="#FAE4FA"><b><?php echo $er_langpackage->js_20; ?></b></td>
            <td width="65" align="center" bgcolor="#FAE4FA"><b><?php echo $er_langpackage->js_21; ?></b></td>
            <td width="330" align="center" bgcolor="#FAE4FA"><b><?php echo $er_langpackage->js_22; ?></b></td>
        </tr>
        <tr>
            <td height="30" align="center" bgcolor="#FFFDFF"><?php echo $er_langpackage->js_23; ?> </td>
            <td width="65" align="center" bgcolor="#FFFDFF">all</td>
            <td width="65" align="center" bgcolor="#FFFDFF">all</td>
            <td width="330" bgcolor="#FFFDFF" style="padding:10px;"><?php echo $er_langpackage->js_24; ?></td>
        </tr>
        <tr>
            <td height="30" align="center" bgcolor="#FFFDFF"><?php echo $er_langpackage->js_25; ?></td>
            <td width="65" align="center" bgcolor="#FFFDFF">all</td>
            <td width="65" align="center" bgcolor="#FFFDFF">all</td>
            <td width="330" bgcolor="#FFFDFF" style="padding:10px;"><?php echo $er_langpackage->js_26; ?></td>
        </tr>
        <tr>
            <td height="30" align="center" bgcolor="#FFFDFF"><?php echo $er_langpackage->js_27; ?></td>
            <td width="65" align="center" bgcolor="#FFFDFF">all</td>
            <td width="65" align="center" bgcolor="#FFFDFF">all</td>
            <td width="330" bgcolor="#FFFDFF" style="padding:10px;"><?php echo $er_langpackage->js_28; ?></td>
        </tr>
        <tr>
            <td height="30" align="center" bgcolor="#FFFDFF"><?php echo $er_langpackage->js_29; ?></td>
            <td width="65" align="center" bgcolor="#FFFDFF">all</td>
            <td width="65" align="center" bgcolor="#FFFDFF">all</td>
            <td width="330" bgcolor="#FFFDFF" style="padding:10px;"><?php echo $er_langpackage->js_30; ?></td>
        </tr>
        <tr>
            <td height="30" align="center" bgcolor="#FFFDFF"><?php echo $er_langpackage->js_31; ?></td>
            <td width="65" align="center" bgcolor="#FFFDFF"><img src="skin/default/jooyea/images/xin/gaoji.png"/></td>
            <td width="65" align="center" bgcolor="#FFFDFF">all</td>
            <td width="330" bgcolor="#FFFDFF" style="padding:10px;"><?php echo $er_langpackage->js_32; ?></td>
        </tr>
        <tr>
            <td height="30" align="center" bgcolor="#FFFDFF"><?php echo $er_langpackage->js_33; ?></td>
            <td width="65" align="center" bgcolor="#FFFDFF">all</td>
            <td width="65" align="center" bgcolor="#FFFDFF">all</td>
            <td width="330" bgcolor="#FFFDFF" style="padding:10px;"><?php echo $er_langpackage->js_34; ?></td>
        </tr>
        <tr>
            <td height="30" align="center" bgcolor="#FFFDFF"><?php echo $er_langpackage->js_35; ?></td>
            <td width="65" align="center" bgcolor="#FFFDFF">all</td>
            <td width="65" align="center" bgcolor="#FFFDFF">all</td>
            <td width="330" bgcolor="#FFFDFF" style="padding:10px;"><?php echo $er_langpackage->js_36; ?></td>
        </tr>
        <tr>
            <td height="30" align="center" bgcolor="#FFFDFF"><?php echo $er_langpackage->js_37; ?></td>
            <td width="65" align="center" bgcolor="#FFFDFF">all</td>
            <td width="65" align="center" bgcolor="#FFFDFF">all</td>
            <td width="330" bgcolor="#FFFDFF" style="padding:10px;"><?php echo $er_langpackage->js_38; ?></td>
        </tr>
        <tr>
            <td height="30" align="center" bgcolor="#FFFDFF"><?php echo $er_langpackage->js_39; ?></td>
            <td width="65" align="center" bgcolor="#FFFDFF">all</td>
            <td width="65" align="center" bgcolor="#FFFDFF">16</td>
            <td width="330" bgcolor="#FFFDFF" style="padding:10px;"><?php echo $er_langpackage->js_40; ?></td>
        </tr>
        <tr>
            <td height="30" align="center" bgcolor="#FFFDFF"><?php echo $er_langpackage->js_41; ?></td>
            <td width="65" align="center" bgcolor="#FFFDFF"><img src="skin/default/jooyea/images/xin/gaoji.png"/></td>
            <td width="65" align="center" bgcolor="#FFFDFF">all</td>
            <td width="330" bgcolor="#FFFDFF" style="padding:10px;"><?php echo $er_langpackage->js_42; ?></td>
        </tr>

        <tr>
            <td height="30" align="center" bgcolor="#FFFDFF"><?php echo $er_langpackage->js_43; ?></td>
            <td width="65" align="center" bgcolor="#FFFDFF">all</td>
            <td width="65" align="center" bgcolor="#FFFDFF">all</td>
            <td width="330" bgcolor="#FFFDFF" style="padding:10px;"><?php echo $er_langpackage->js_44; ?></td>
        </tr>
    </table>

</div>

<script>


    // 计算页面的实际高度，iframe自适应会用到
    function calcPageHeight(doc) {
        var cHeight = Math.max(doc.body.clientHeight, doc.documentElement.clientHeight)
        var sHeight = Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight)
        var height = Math.max(cHeight, sHeight)
        return height
    }

    window.onload = function () {
        var height = calcPageHeight(document);
        parent.document.getElementById('ifr').style.height = height + 50 + 'px';


    }

</script>
</body>