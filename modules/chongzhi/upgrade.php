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
$friends = Api_Proxy("pals_self_by_paid", "pals_name,pals_id,pals_ico");
$userinfo = Api_Proxy("user_self_by_uid", "*", $user_id);
$info = "<font color='#ce1221' style='font-weight:bold;'>" . $er_langpackage->er_currency . "</font>：" . $userinfo['zibis'];
if ($userinfo['user_group'] > 1 && $userinfo['user_group'] != '1') {
    $groups = $dbo->getRow("select endtime from wy_upgrade_log where mid='$user_id' and state='0' order by id desc limit 1");
    //print_r($groups);
    $startdate = strtotime(date("Y-m-d"));
    $enddate = strtotime($groups['endtime']);
    $days = round(($enddate - $startdate) / 3600 / 24);
    if ($days > 0) {
        $info .= "&nbsp;&nbsp;&nbsp;&nbsp;" . $er_langpackage->er_howtime . "：" . $days . $er_langpackage->er_day;
    } else {
        $sql = "update wy_upgrade_log set state='1' where mid='$user_id'";
        $dbo->exeUpdate($sql);
        $sql = "update wy_users set  user_group='1'   where  user_id='$user_id'";
        $dbo->exeUpdate($sql);
    }
    $groups = $dbo->getRow("select name from wy_frontgroup where gid='$userinfo[user_group]'");
    if ($langPackagePara != 'zh') {
        $groups['name'] = str_replace('普通会员', '', $groups['name']);
        $groups['name'] = str_replace('高级会员', $er_langpackage->js_8, $groups['name']);
        $groups['name'] = str_replace('星级会员', $er_langpackage->js_10, $groups['name']);
    }
    if ($days > 0) {
        $userinfo = Api_Proxy("user_self_by_uid", "*", $user_id);
        $info .= "&nbsp;&nbsp;&nbsp;&nbsp;" . $er_langpackage->er_nowtype . "：" . $groups['name'];
    }
}
$uid = get_argg('user_id');
if ($uid) {
    $u = $dbo->getRow("select user_name from wy_users where user_id='$uid'");
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <link href="./template/upgrade/base_icon-min.css" rel="stylesheet" type="text/css">
    <link href="./template/upgrade/index-min.css" rel="stylesheet" type="text/css">
    <link href="./template/upgrade/optimization-icon.css" rel="stylesheet" type="text/css">
    <link href="./template/upgrade/online-updater.css" rel="stylesheet" type="text/css">
    <link href="./template/upgrade/upgrade.css" rel="stylesheet" type="text/css">


    <script src="./template/her/jquery-1.7.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $(".upgrade li").on('click', function () {
                supert($(this).find('.upgrade_zibi').html());

                $(".upgrade li").removeClass('checked');
                $(".upgrade i").removeClass('upgrade_checked');

                var user_group = $("input[name=user_group]");
                user_group.attr("checked", false);
                $(this).addClass('checked');

                $(this).find('i').addClass('upgrade_checked');
                $(this).find('input').attr("checked", "checked");
            })
        })
    </script>

</head>
<body style="background: white;margin:0 10px;">
<style>
    .tabs{height:45px;line-height:45px;border-bottom: 1px solid #d8d8d8;}
    .tabs li{height:45px;line-height:45px;float:left;width:100px;}
    .tabs li a{display:block;height:45px;line-height:45px;color:#333;text-decoration:none;text-align: center;}
    .tabs li.active a{border-bottom: 3px solid #2d57a1;color: #2c589e;font-weight: 700;}
</style>
<div class="tabs" style="margin-bottom: 2px;">
    <ul class="menu">
        <li><a href="modules2.0.php?app=user_pay"><?php echo $er_langpackage->er_recharge; ?></a></li>
        <li class="active"><a href="modules2.0.php?app=user_upgrade"><?php echo $er_langpackage->er_upgrade; ?></a></li>
        <!--<li><a href="modules2.0.php?app=user_consumption" ><?php echo $er_langpackage->er_consumption_log; ?></a></li>-->
        <!--        <li><a href="modules2.0.php?app=user_introduce">--><?php //echo $er_langpackage->er_introduce; ?><!--</a></li>-->
        <!--<li><a href="modules2.0.php?app=user_help"><?php echo $er_langpackage->er_help; ?></a></li>-->
    </ul>
</div>
<!--需要的-->
<div id="content_box1_lq" style="margin-bottom: 60px; background:#fff">
    <div id="iframe_div_lq">
        <div id="recharge_app_cyw">
            <div class="online-updater-main">

                <div class="oum-body" id="js_app_cont">
                    <form action="do.php?act=upgrade" method="post" target="_blank">
                        <!--升级会员页面优化start-->
                        <div class="upgrade">
                            <p class="ob-1-for-other"></p>
                            <!--升级高级会员-->
                            <div class="upgrade_box">
                                <div class="box_left"><i class="upgrade_high"></i></div>
                                <div class="box_right">
                                    <dl>
                                        <dt>&nbsp;&nbsp;<?php echo $er_langpackage->er_gj; ?></dt>
                                        <dd> ·&nbsp;<?php echo $er_langpackage->er_gj_shuoming1; ?></dd>
                                        <dd> ·&nbsp;<?php echo $er_langpackage->er_gj_shuoming2; ?></dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="upgrade_list vip" id="upgradeVip">
                                <ul>
                                    <li>
                                        <div class="price">
                                            <span class="upgrade_font pt5"
                                                  style=" color:#385679; font-size:20px;  font-weight:bold">108</span>
                                        </div>
                                        <div class="price_cont">
                                            <p class="cont_text">
                                                <span class="upgrade_font">
                                                    <?php echo $er_langpackage->er_gj_1n; ?>
                                                </span>
                                            </p>
                                            <input type="radio" value="bj4" name="user_group" style="display: none"></div>
                                        <i class=""></i>
                                    </li>
                                    <li>
                                        <div class="price">
                                            <span class="upgrade_font pt5"
                                                  style=" color:#385679; font-size:20px;  font-weight:bold">59</span>
                                        </div>
                                        <div class="price_cont">
                                            <p class="cont_text">
                            <span class="upgrade_font">
                              <?php echo $er_langpackage->er_gj_6y; ?></span></p>
                                            <input type="radio" value="bj3" name="user_group" style="display: none"></div>
                                        <i class=""></i>
                                    </li>
                                    <li>
                                        <div class="price">
                                            <span class="upgrade_font pt5"
                                                  style=" color:#385679; font-size:20px;  font-weight:bold">30</span>
                                        </div>
                                        <div class="price_cont">
                                            <p class="cont_text">
                            <span class="upgrade_font">
                              <?php echo $er_langpackage->er_gj_3y; ?></span></p>
                                            <input type="radio" value="bj2" name="user_group" style="display: none"></div>
                                        <i class=""></i>
                                    </li>
                                    <li>
                                        <div class="price">
                                            <span class="upgrade_font pt5"
                                                  style=" color:#385679; font-size:20px;  font-weight:bold">12</span>
                                        </div>
                                        <div class="price_cont">
                                            <p class="cont_text">
                            <span class="upgrade_font">
                              <?php echo $er_langpackage->er_gj_1y; ?></span></p>
                                            <input type="radio" value="bj1" name="user_group" style="display: none"></div>
                                        <i class=""></i>
                                    </li>
                                </ul>
                            </div>
                            <!-- 高级会员结束 -->


                            <!-- vip会员 -->
                            <div class="upgrade_box">
                                <div class="box_left"><i class="upgrade_vip"></i></div>
                                <div class="box_right">
                                    <dl>
                                        <dt>&nbsp;&nbsp;<?php echo $er_langpackage->er_vip; ?></dt>
                                        <dd> ·&nbsp;<?php echo $er_langpackage->er_gj_shuoming1; ?> </dd>
                                        <dd> ·&nbsp;<?php echo $er_langpackage->er_gj_shuoming3; ?></dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="upgrade_list vip" id="upgradeVip">
                                <ul>
                                    <li class="checked">
                                        <div class="price"><span class="upgrade_font pt5"
                                                                 style=" color:#385679; font-size:20px;  font-weight:bold">999</span>
                                        </div>
                                        <div class="price_cont">
                                            <p class="cont_text"><span
                                                        class="upgrade_font"><?php echo $er_langpackage->er_vip_1n; ?></span>
                                            </p>
                                            <input type="radio" value="zs4" name="user_group" style="display: none" checked>
                                        </div>
                                        <i class="upgrade_checked"></i>
                                    </li>
                                    <li>
                                        <div class="price"><span class="upgrade_font pt5"
                                                                 style=" color:#385679; font-size:20px;  font-weight:bold">521</span>
                                        </div>
                                        <div class="price_cont">
                                            <p class="cont_text"><span
                                                        class="upgrade_font"><?php echo $er_langpackage->er_vip_6y; ?></span>
                                            </p>
                                            <input type="radio" value="zs3" name="user_group" style="display: none">
                                        </div>
                                        <i class=""></i>
                                    </li>
                                    <li>
                                        <div class="price"><span class="upgrade_font pt5"
                                                                 style=" color:#385679; font-size:20px;  font-weight:bold">288</span>
                                        </div>
                                        <div class="price_cont">
                                            <p class="cont_text"><span
                                                        class="upgrade_font"><?php echo $er_langpackage->er_vip_3y; ?></span>
                                            </p>
                                            <input type="radio" value="zs2" name="user_group" style="display: none">
                                        </div>
                                        <i class=""></i>
                                    </li>
                                    <li>
                                        <div class="price"><span class="upgrade_font pt5"
                                                                 style=" color:#385679; font-size:20px;  font-weight:bold">100</span>
                                        </div>
                                        <div class="price_cont">
                                            <p class="cont_text"><span
                                                        class="upgrade_font"><?php echo $er_langpackage->er_vip_1y; ?></span>
                                            </p>
                                            <input type="radio" value="zs1" name="user_group" style="display: none">
                                        </div>
                                        <i class=""></i>
                                    </li>
                                </ul>
                            </div>
                            <!-- vip会员end -->
                        </div>

                        <!--支付方式-->
                        <style>
                            body .ob-0-selpay li{width:250px;}
                        </style>
                        <div class="ob-0-selpay selpay" id="selplay">
                            <!--支付-->
                            <div>
                              <p class="pay_title">
                                  <?php echo $er_langpackage->er_change;?>
                              </p>
                              <ul>
                                <li>
                                  <label>
                                    <input class="radio" name="pay_method" type="radio" value="lianyin" checked>
                                    <img src="/skin/<?php echo $skinUrl; ?>/images/vml.png" alt="lianyin"></label>
                                </li>

                                <li>
                                  <label>
                                    <input class="radio" name="pay_method" type="radio" value="yingfu" >
                                    <img src="/skin/<?php echo $skinUrl; ?>/images/fuHui.png" alt="yingfu"></label>
                                </li>
                                  <li>
                                      <label>
                                          <input class="radio" name="pay_method" type="radio" value="lianyin2">
                                          <img src="/skin/<?php echo $skinUrl; ?>/images/vm.png" alt="lianyin2"></label>
                                  </li>
                                  <li>
                                      <label>
                                          <input class="radio" name="pay_method" type="radio" value="gold" >
                                          <img src="/template/main/ico/gold-icon.png" alt="gold" style="margin-top:-5px;"></label>
                                  </li>

                              </ul>
                            </div>
                            <!--支付 -->
                            <div class="ob-1-upnow">
                                <p style="position: absolute; top: 12px; left: 18px;">
                                    <label id="dp_lable"></label>
                                </p>
                                <input type="submit" class="blue_submitbtn1_lq" id="Paysenior" value="<?php echo $er_langpackage->js_sj;?>">
                            </div>
                        </div>
                        <!--升级会员页面优化-end-->
                        <input type="hidden" name='touser' value="self"/>
                        <input type="hidden" name='friend_username' value=""/>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br class="clear_lq"></div>
<!--需要的-->
<script type="text/javascript">
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

    function supert(obj) {
        if (obj > <?php echo $userinfo['golds']; ?>) {
            parent.Dialog.confirm('<?php echo $er_langpackage->er_mess; ?>' + <?php echo $userinfo['golds']; ?>+'<?php echo $er_langpackage->er_mess2;?>',
                function () {
                    window.location.href = 'modules2.0.php?app=user_pay';
                });
        }
    }
</script>
</body>
</html>