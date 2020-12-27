<?php
//礼物用到的语言包
$gf_langpackage=new giftlp;

require ("api/base_support.php");
$t_sign = $tablePreStr . "sign";
$user_id = get_sess_userid();
$userinfo = Api_Proxy("user_self_by_uid", "*", $user_id);
// $mtype = '';
// if ($userinfo['user_group'] == 2) {
//     $mtype = '<img style="width:35px;height:35px;" src="skin/gaoyuan/images/icon/bgold-user-icon.png"/>';
// } else if ($userinfo['user_group'] == 3) {
//     $mtype = '<img style="width:35px;height:35px;" src="skin/gaoyuan/images/icon/zuan-user-icon.png"/>';
// }
//echo "<pre>";print_r($userinfo);exit;
//创建系统对数据库进行操作的对象
$dbo = new dbex();
//对数据进行读写分离，读操作
dbplugin('r');
//查询用户的礼品
$sql = "select count(*) from gift_order where is_see='0' and accept_id=" . get_sess_userid();
$gifts = $dbo->getRow($sql);
if (is_array($gifts)) {
    $gifts = $gifts[0];
} else {
    $gifts = 0;
}
//商城礼物
$gift_list = $dbo->getRs("select id,yuanpatch,patch,giftname from gift_news order by id limit 0,4");
//print_r($gift_list);
$dbo = new dbex();
//定义读操作
dbtarget('r', $dbServs);
//是否签到
$sql = "select user_id,user_name,sign_flag,sign_addtime from $t_sign where user_id=$user_id order by sign_addtime desc";
$flag = $dbo->getRow($sql);
$stime = $flag['sign_addtime'];
//echo $tmp=date('Y-m-d H:i:s',$stime);
//echo $tmp;exit;
$stmp = time() - $stime;
if ($flag['sign_flag'] == 1 && $stmp < 24 * 60 * 60) {
    $sflag = 1;
} else {
    $sflag = 0;
}
//  签到列表
$sql = "select sign_id,user_id,user_name,sign_flag,sign_addtime,user_ico from $t_sign where sign_flag=1 group by user_id order by sign_addtime desc  limit 5";
$flaglist = $dbo->getRs($sql);
//print_r($flaglist);exit;
$sqlg = "select * from wy_users where user_id=$user_id";
$userinfo = $dbo->getRow($sqlg);
$sqlonline = "select * from wy_online where hidden=0 and user_id=$user_id";
$is_online = $dbo->getRow($sqlonline);
if ($is_online) {
    $set_status = 1;
} else {
    $set_status = 0;
}

//未读邮件数量
$email_count = $dbo->getRs("select readed from wy_msg_inbox where user_id='$user_id' and readed=0");
$email_num = count($email_count);
//收到礼物数量
$liwushuliang = $dbo->getRow("select count(id) as s from gift_order where accept_name='" . get_sess_username() . "'");
$liwushuliang = $liwushuliang['s'];
//gaoyuanadd判断用户vip是否到期，若到期更新数据
$groups = $dbo->getRow("select `endtime` from wy_upgrade_log where mid='$user_id' and state='0' order by id desc limit 1");
//print_r($groups);
$startdate = strtotime(date("Y-m-d"));
$enddate = strtotime($groups['endtime']);
$days = round(($enddate - $startdate) / 3600 / 24);
//var_dump($groups);
if ($days <= 0 && !$group) {
    $sql = "update wy_upgrade_log set state='1' where mid='$user_id'";
    $dbo->exeUpdate($sql);
    $sql = "update wy_users set user_group='1'   where  user_id='$user_id'";
    $dbo->exeUpdate($sql);
}
?>








<script>
    function set_status(sta) {
        var sets = new Ajax();
        sets.getInfo("do.php", "GET", "app", "act=set_status&sta=" + sta,
        function(ret) {
            if (sta == 1) {
                $('#state_hover em').html('隐身');
                $('#status_ico').attr('style', "background:url(/skin/<?php echo $skinUrl;?>/images/noonline.png) 10px center no-repeat;")
            } else {
                $('#state_hover em').html('在线');
                $('#status_ico').attr('style', "background:url(/skin/<?php echo $skinUrl;?>/images/online.png) 10px center no-repeat;")
            }
        })
    }
    function report_action(type_id, user_id, mod_id) {
        var diag = new Dialog();
        diag.Width = 300;
        diag.Height = 150;
        diag.Top = "50%";
        diag.Left = "50%";
        diag.Title = "<?php echo $pu_langpackage->pu_report;?>";
        diag.InnerHtml = '<div class="report_notice"><?php echo $pu_langpackage->pu_report_info;?><?php echo $pu_langpackage->pu_report_re;?><textarea id="reason"></textarea></div>';
        diag.OKEvent = function() {
            act_report(type_id, user_id, mod_id);
            diag.close()
        };
        diag.show()
    }
    function hi_action(uid) {
        var diag = new Dialog();
        diag.Width = 330;
        diag.Height = 150;
        diag.Top = "50%";
        diag.Left = "50%";
        diag.Title = "<?php echo $u_langpackage->u_choose_type;?>";
        diag.InnerHtml = '<?php echo hi_window();?>';
        diag.OKEvent = function() {
            send_hi(uid);
            diag.close()
        };
        diag.show()
    }
    function send_hi_callback(content) {
        if (content == "success") {
            Dialog.alert("<?php echo $hi_langpackage->hi_success;?>")
        } else {
            Dialog.alert(content)
        }
    }
    function send_hi(uid) {
        var hi_type = document.getElementsByName("hi_type");
        for (def = 0; def < hi_type.length; def++) {
            if (hi_type[def].checked == true) {
                var hi_t = hi_type[def].value
            }
        }
        var get_album = new Ajax();
        get_album.getInfo("do.php", "get", "app", "act=user_add_hi&to_userid=" + uid + "&hi_t=" + hi_t,
        function(c) {
            send_hi_callback(c)
        })
    }
</script>

<style type="text/css">
    #app_nav1_lq li a{display:inline-block;width:88px;height:25px;line-height:25px;text-overflow: ellipsis;white-space: nowrap;}
    /*打招呼css*/
    .hi_list li{float: left;width: 25%;text-align: left;}
</style>
<div id="left_nav_lq" class="left_nav" >
    <style>
        .left-nav-li a{display: flex;justify-content: space-between;line-height: 30px;}
    </style>
    <dl id="personal_info_lq" class="personal-info">
        <dt class="head_info_lq">
            <a href="main2.0.php?app=user_ico" style="overflow: visible;">
                <img class="head_img1_lq" src="<?php if($userinfo['user_ico']){echo $userinfo['user_ico'];}else{if($userinfo['user_sex']>0){echo '/skin/'.$skinUrl.'/images/d_ico_1.gif';}else{echo '/skin/'.$skinUrl.'/images/d_ico_0.gif';}}?>"  alt="<?php echo $user_name;?>">
                <i class="christmas-adornment "></i>
                <span class="online_icon1_lq line-status-position set_status"></span>
            </a>
        </dt>

        <dd class="left-nav-li">
            <a href="main2.0.php?app=user_info">
                <span><?php echo filt_word(get_sess_username());?></span>
                <span>
                    <?php if($userinfo['user_group']==2 && $days>0){echo "<img style='display:inline;width:20px;' src='skin/gaoyuan/images/icon/bgold-user-icon.png'/>";}?>
                    <?php if($userinfo['user_group']==3 && $days>0){echo "<img style='display:inline;width:20px;' src='skin/gaoyuan/images/icon/zuan-user-icon.png'/>";}?>
                </span>
            </a>
        </dd>
    </dl>


    <ul style="overflow: hidden;margin: 10px 6px 10px 10px;padding-bottom: 8px;border-bottom: solid 1px #eee;">
        <li class="left-nav-li">
            <a href="/main2.0.php?app=user_pay">
                <span><?php echo $userinfo['golds'];?></span>
                <span class="left-nav-icon ln-gold-icon" style="width:20px;background: url('/skin/gaoyuan/images/svg/gold.svg') 0 0 no-repeat;background-size: 100%;"></span>
            </a>
        </li>
    </ul>

    <ul id="app_nav1_lq">
        <li>
            <span class="left-nav-icon ln-recharge-icon"></span>
            <a href="./main2.0.php?app=user_pay"><?php echo $u_langpackage->u_pay;?></a>
        </li>
        <li>
            <span class="left-nav-icon ln-upgrade-icon"></span>
            <a id="letter_notice" href="main2.0.php?app=user_upgrade"><?php echo $u_langpackage->u_update;?></a>
        </li>
        <li>
            <span class="left-nav-icon ln-album-icon"></span>
            <a href="main2.0.php?app=album"><?php echo $mn_langpackage->mn_album;?></a>
        </li>
        <li class="li-title"></li>
        <li id="valentine">
            <span class="left-nav-icon ln-gift-icon"></span>
            <a href="main2.0.php?app=giftshop">
                <?php echo $u_langpackage->u_shop;?>
            </a>
        </li>
        <li>
            <span class="left-nav-icon ln-gift-box-icon"></span>
            <a href="/main2.0.php?app=gift_box"><?php echo $gf_langpackage->gf_putin;?></a>
        </li>
        <li>
            <span class="left-nav-icon ln-card-icon"></span>
            <a href="/main2.0.php?app=gift_outbox"><?php echo $gf_langpackage->gf_putout;?></a>
        </li>
        <li class="li-title"></li>
  </ul>
</div>
<!--左列表-->