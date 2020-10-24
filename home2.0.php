<?php
header("content-type:text/html;charset=utf-8");
require("foundation/asession.php");
require("configuration.php");
require("includes.php");
//引入公共方法
require("foundation/fcontent_format.php");
require("foundation/module_mood.php");
require("foundation/module_users.php");
require("foundation/fplugin.php");
require("foundation/fgrade.php");
require("api/base_support.php");
//语言包引入
$u_langpackage = new userslp;
$pu_langpackage = new publiclp;
$s_langpackage = new sharelp;
$mn_langpackage = new menulp;
$hi_langpackage = new hilp;
$mo_langpackage = new moodlp;
$pr_langpackage = new privacylp;
$ah_langpackage = new arrayhomelp;
$im_langpackage = new impressionlp;
//变量获得
$holder_id = intval(get_argg('h')); //主人id
$user_id = get_sess_userid();
$user_id0530 = $user_id;
$dress_name = short_check(get_argg('dress_name')); //装扮名称
//echo $dress_name;
//表声明区
$t_mood = $tablePreStr . "mood";
$t_users = $tablePreStr . "users";
$t_online = $tablePreStr . "online";
//获取并重写url参数
$urlParaStr = getReUrl();
$dbo = new dbex;
dbtarget('r', $dbServs);
//取得主人信息
$user_info = $holder_id ? api_proxy("user_self_by_uid", "*", $holder_id) : array();
$holder_name = empty($user_info) ? '' : $user_info['user_name'];
$is_self = ($holder_id == $user_id) ? 'Y' : 'N';
//取得访客信息
$guest_info = api_proxy("user_self_by_uid", "*", $user_id);
//echo "<pre>";print_r($user_info);exit;
if (empty($user_info)) {
    echo "<script>alert('Without this user（沒有此用戶）!');window.history.back();</script>";
    exit;
}
if ($is_self == 'N') {
    if ($user_info["user_sex"] == 1 && ($guest_info["user_sex"] == 1 || empty($guest_info))) {
        echo "<script>alert('no auth（沒有許可權）!');window.history.back();</script>";
        exit;
    }
}
//记录访客
if ($is_self == 'N' && $user_id) {
    $time = date("Y-m-d H:i:s");
    //$guest_info=api_proxy("user_self_by_uid","*",$user_id);
    if (empty($guest_info['user_ico'])) {
        $guest_info['user_ico'] = "/skin/default/jooyea/images/d_ico_" . $guest_info['user_sex'] . ".gif";
    }
    //查看由此访客没有
    $sql = "select * from wy_guest where guest_user_id='$guest_info[user_id]' and user_id='$holder_id'";
    $res = $dbo->getRow($sql);
    if ($res) {
        $sql = "update from wy_guest set guest_user_name='$guest_info[user_name]', guest_user_ico='$guest_info[user_ico]', add_time='$time' where guest_user_id='$guest_info[user_id]'";
    } else {
        $sql = "insert into wy_guest (`guest_user_id`, `guest_user_name`, `guest_user_ico`, `user_id`, `add_time`) value('$guest_info[user_id]', '$guest_info[user_name]', '$guest_info[user_ico]', '$holder_id', '$time')";
    }
    mysql_query($sql);
    api_proxy("message_set", $holder_id, "{num}位访客", "home2.0.php?h=$holder_id", 0, 21, "remind");
}
//echo "<pre>";print_r($guest_info);exit;
if ($user_info['user_group'] == 'base' || $user_info['user_group'] == '1') {
    $mtype = '<img width="19" height="17" src="skin/' . $skinUrl . '/images/xin/01.gif"/>&nbsp;';
} else {
    $mtype = '<img width="19" height="17" src="skin/' . $skinUrl . '/images/xin/0' . $user_info['user_group'] . '.gif"/>&nbsp;';
}
//隐私显示控制
$show_error = false;
$show_ques = false;
$is_visible = 0;
$show_info = "";
if ($user_info) {
    //最后更新心情
    $last_mood_rs = get_last_mood($dbo, $t_mood, $holder_id);
    $last_mood_txt = '';
    if ($last_mood_rs['mood']) {
        $last_mood_txt = get_face($last_mood_rs['mood']);
        $last_mood_time = format_datetime_short($last_mood_rs['add_time']);
    } else {
        $last_mood_txt = $mo_langpackage->mo_null_txt;
        $last_mood_time = '';
    }
    //主人姓名
    set_session($holder_id . '_holder_name', $user_info['user_name']);
    $user_online = array();
    //登录状态
    $ol_state_ico = "skin/$skinUrl/images/online.gif";
    $ol_state_label = $ah_langpackage->ah_current_online;
    $timer_txt = '';
    $user_online = get_user_online_state($dbo, $t_online, $holder_id);
    if ($is_self == 'N' && (empty($user_online) || $user_online['hidden'] == 1)) {
        $ol_state_ico = "skin/$skinUrl/images/offline.gif";
        $ol_state_label = $ah_langpackage->ah_offline;
        $timer_txt = '(' . format_datetime_short($user_info['lastlogin_datetime']) . ')';
    } else if ($is_self == 'Y' && $user_online['hidden'] == 1) {
        $ol_state_ico = "skin/$skinUrl/images/hiddenline.gif";
        $ol_state_label = $ah_langpackage->ah_stealth;
    }
    $is_admin = get_sess_admin();
    if ($is_admin == '' && $is_self == 'N') {
        if ($user_info['is_pass'] == 0) {
            $show_error = true;
            $show_info = $pu_langpackage->pu_lock;
        } elseif ($user_info['access_limit'] == 1 && $user_id == '') {
            $show_error = true;
            $show_info = $pr_langpackage->pr_acc_false;
        } elseif ($user_info['access_limit'] == 2 && !api_proxy("pals_self_isset", $holder_id)) {
            $show_error = true;
            $show_info = $pr_langpackage->pr_acc_false;
        } elseif ($user_info['access_limit'] == 3 && get_session($holder_id . 'homeAccessPass') != '1') {
            $show_ques = true;
        } else {
            $is_visible = 1;
        }
    } else {
        $is_visible = 1;
    }
} else {
    $show_error = true;
    $show_info = $pu_langpackage->pu_no_user;
}
if ($user_id) {
    $inc_header = "uiparts/homeheader.php";
} else {
    $inc_header = "uiparts/guesttop.php";
}
$user_id = get_sess_userid();
$sqlg = "select * from wy_users where user_id=$user_id";
$sessuserinfo = $dbo->getRow($sqlg);
//圖片 Begin
$response = array();
//photo_num = 当前相册的图片数量，is_pass=1 无密码
$sql = "SELECT album_id,album_name,album_info,photo_num,add_time,privacy FROM `wy_album` WHERE `user_id` = $holder_id";
$result = mysql_query($sql);
$nCount = 0;
while ($rows = mysql_fetch_assoc($result)) {
    $response[$nCount]['album_id'] = $rows['album_id'];
    $response[$nCount]['album_name'] = $rows['album_name'];
    $response[$nCount]['album_info'] = $rows['album_info'];
    $response[$nCount]['photo_num'] = $rows['photo_num'];
    $response[$nCount]['add_time'] = $rows['add_time'];
    $response[$nCount]['privacy'] = $rows['privacy'];
    $nCount++;
}
//頁面頂部只需要4個圖片
//需要新定義一個變量來處理頭部的圖片效果
$topimg = array(); //數量=4
//判断相册有没有被访问的权限
//echo "<pre>";print_r($response);exit;
$all = array(); //所有相册圖片集合
$nCount = 0;
foreach ($response as $key => $value) {
    if ($value["privacy"] == "") {
        $sql = "SELECT photo_id,photo_name,photo_information,add_time,photo_src,album_id FROM `wy_photo` WHERE `album_id` = '$value[album_id]'";
        $result = mysql_query($sql);
        $tmp = array(); //遍历其中的一个
        if ($nCount < 5) {
            while ($rows = mysql_fetch_assoc($result)) {
                $all[] = $rows;
            }
            $nCount++;
        }
    }
}
//圖片END
//心情Begin
$ah_langpackage = new arrayhomelp;
$sql = "select * from wy_mood where user_id=$holder_id";
$result = mysql_query($sql);
$mood = array();
while ($rows = mysql_fetch_assoc($result)) {
    $mood[] = $rows;
}
//echo "<pre>";print_r($mood);exit;
//查出心情评论
//如果是男号不能看男评论
//echo "<pre>";print_r($sessuserinfo);exit;
// if($sessuserinfo["user_sex"] == 1){//男号
//  $sql = "select c.* from wy_mood_comment as c,wy_users as u where u.user_id=c.visitor_id and u.user_sex<>1";
// }else{
//  $sql="select * from wy_mood_comment";
// }
$sql = "select * from wy_mood_comment";
$result = mysql_query($sql);
$mood_comment = array();
while ($rows = mysql_fetch_assoc($result)) {
    $mood_comment[] = $rows;
}
//echo "<pre>";print_r($mood_comment);exit;
$mo_langpackage = new moodlp;
//心情End

?>


<!DOCTYPE html>
<html>

<head id="Head1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
    <meta http-equiv="Content-Language" content="zh-cn">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="Description" content="<?php echo $metaDesc; ?>,<?php echo $holder_name; ?>"/>
    <meta name="Keywords" content="<?php echo $metaKeys; ?>,<?php echo $holder_name; ?>"/>
    <meta name="author" content="<?php echo $holder_name; ?>"/>
    <meta name="robots" content="all"/>
    <title>
        <?php echo $holder_name; ?>的个人主页-<?php echo $siteName; ?>
    </title>
    <link rel="shortcut icon" href="favicon.ico">
    <link href="./template/her/base_icon-min.css" rel="stylesheet" type="text/css">
    <link href="./template/her/jqzysns-min.css" rel="stylesheet" type="text/css">
    <link href="./template/her/email_gift_recharge_lq-min.css" rel="stylesheet"
          type="text/css">
    <link href="./template/her/photo_user_vote_sun-min.css" rel="stylesheet"
          type="text/css">
    <link href="./template/her/blog_group_invit_lf-min.css" rel="stylesheet"
          type="text/css">
    <link href="./template/her/friends_visit_other_lf-min.css" rel="stylesheet"
          type="text/css">
    <link href="./template/her/user_center-min.css" rel="stylesheet" type="text/css">
    <link href="./template/her/flower.css" rel="stylesheet" type="text/css">
    <link href="./template/her/base.css" rel="stylesheet" type="text/css">
    <link href="./template/her/im.css" rel="stylesheet" type="text/css">
    <link href="./template/her/themes.css" rel="stylesheet" type="text/css">
    <link href="./template/her/optimization-icon.css" rel="stylesheet" type="text/css">
    <link href="./template/her/widgets.css" rel="stylesheet" type="text/css">
    <link href="./template/her/private-letter.css" rel="stylesheet" type="text/css">
    <link href="./template/her/giftone.css" rel="stylesheet" type="text/css">
    <link href="./template/her/online-member.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="./template/her/headUpload.css" type="text/css">
    <script src="skin/default/js/jy.js"></script>
    <script src="servtools/imgfix.js"></script>
    <script src="skin/default/js/jooyea.js"></script>
    <script src="servtools/ajax_client/ajax.js"></script>
    <script src="servtools/dialog/zDrag.js"></script>
    <script src="servtools/dialog/zDialog.js"></script>
    <script src="servtools/calendar.js"></script>
    <link href="./template/her/christmas2014.css" rel="stylesheet" type="text/css">
    <script src="./template/her/jquery-1.7.min.js"></script>
    <script src="./template/layer/layer.js"></script>
    <script>
        $(function () {
            layer.photos({
                photos: '.top_content_lf'
            });
            //layer.alert('asdf');
        });

        //取得评论内容
        function get_mod_com(type_id, mod_id, start_num, end_num) {
            if (frame_content.$("max_" + type_id + "_" + mod_id)) {
                var max_num = parseInt(frame_content.$("max_" + type_id + "_" + mod_id).innerHTML);
                start_num = max_num;
            }
            var ajax_get_com = new Ajax();
            ajax_get_com.getInfo("modules.php", "GET", "app", "app=restore&mod_id=" + mod_id + "&type_id=" + type_id + "&start_num=" + start_num + "&end_num=" + end_num,
                function (c) {
                    get_com_callback(c, type_id, mod_id);
                });
        }

        //回复评论
        function restore_com(holder_id, type_id, mod_id) {
            var r_content = frame_content.$('reply_' + type_id + '_' + mod_id + '_input').value;
            var user_id = '';
            if ($('restore').value != '') {
                var user_id = $('restore').value;
            }
            //var is_hidden=frame_content.document.getElementById('hidden_'+type_id+'_'+mod_id).value;
            var is_hidden = 0;
            if (trim(r_content) == '') {
                Dialog.alert('<?php echo $pu_langpackage->pu_data_empty;?>');
            } else {
                var ajax_comment = new Ajax();
                ajax_comment.getInfo("do.php?act=restore_add&holder_id=" + holder_id + "&type_id=" + type_id + "&mod_id=" + mod_id + "&is_hidden=" + is_hidden + "&to_userid=" + user_id, "post", "app", "CONTENT=" + r_content,
                    function (c) {
                        restore_com_callback(c, type_id, mod_id)
                    });
            }
        }

        //删除评论
        function del_com(holder_id, type_id, parent_id, com_id, sendor_id) {
            var ajax_del_com = new Ajax();
            ajax_del_com.getInfo("do.php", "GET", "app", "act=restore_del&holder_id=" + holder_id + "&type_id=" + type_id + "&com_id=" + com_id + "&sendor_id=" + sendor_id + "&parent_id=" + parent_id,
                function (c) {
                    del_com_callback(c, type_id, parent_id, com_id)
                });
        }
    </script>
    <script>
        $(function () {
            $('#js_member_a a').on('click',
                function () {
                    $(this).siblings().removeClass('active1_tab_lf');
                    $(this).addClass('active1_tab_lf');
                });

            $(window).bind('scroll',
                function () {
                    var w_scrollTop = $(window).scrollTop();
                    if (w_scrollTop > 150) {
                        $("#gotop").fadeIn(600);
                    } else if (w_scrollTop < 200) {
                        $("#gotop").fadeOut(600);
                    }
                });
            $("#gotop").click(function () {
                $("html,body").animate({
                        scrollTop: 0
                    },
                    400);
                return false;
            });
        });
    </script>
    <style type='text/css'>
        #nav_lq .nav_charge_lq, #nav_lq a.nav_charge_lq:hover {
            line-height: 26px;
            padding: 0 10px;
            display: inline-block;
            background: rgb(200, 0, 0);
            border-radius: 5px;
        }

        #gotop {
            width: 28px;
            height: 28px;
            cursor: pointer;
            position: fixed;
            right: 60px;
            bottom: 0px;
            z-index: 9999;
            background: url(skin/default/jooyea/images/back_top.gif) no-repeat;
            _background: url(skin/default/jooyea/images/back_top.gif) no-repeat;
            top: auto;
        }
    </style>
</head>

<body style=" height:auto">
<!--头部-->
<?php require("uiparts2.0/mainheader.php"); ?>
<!--头部-->


<div id="container_lf" style=" background:url(skin/default/jooyea/images/banner.png) no-repeat  ">
    <div class="topside_info1_lf">
        <a class="name_box1_lf">
            <?php echo $user_info['user_name']; ?>
        </a>
        <input type="hidden" id="MemberName_cyw" name="MemberName_cyw" value="buckly427">
        <span class="vip_icon1_lq" style="vertical-align:center; width:100px ; background:none">
                    <?php echo grade($user_info['integral']); ?>
                </span>
        <!--<span class="online_icon1_lq ver-bottom"></span>-->
        <!--<span class="online_text1_lq">在线</span>-->
        <!--<a status="1" class="set_status hidden1_lq"> 设为隐身</a>-->
    </div>
    <div class="tabs_box1_lf">
        <div id="js_member_a" class="tabs_lf">
            <a class="first_child_lf active1_tab_lf" href="/home2.0.php?h=<?php echo $holder_id; ?>">
                <?php echo $ah_langpackage->ah_personal_homepage; ?>
            </a>
            <a class="nav01" href="javascript:void(0);"
               onclick="frame_index.style.display='block';frame_content.location.href='/modules.php?app=blog_list&user_id=<?php echo $holder_id; ?>';content_index_lf.style.display='none';return false;"
            >
                <?php echo $ah_langpackage->ah_log; ?>
            </a>
            <a class="nav02" href="javascript:void(0);"
               onclick="frame_index.style.display='block';frame_content.location.href='/modules.php?app=album&user_id=<?php echo $holder_id; ?>';content_index_lf.style.display='none';return false;"
            >
                <?php echo $ah_langpackage->ah_album; ?>
            </a>
            <a class="nav03" href="javascript:void(0);"
               onclick="frame_index.style.display='block';frame_content.location.href='/modules.php?app=share_list&user_id=<?php echo $holder_id; ?>';content_index_lf.style.display='none';return false;"
            >
                <?php echo $ah_langpackage->ah_share; ?>
            </a>
            <a class="nav04" href="javascript:void(0);"
               onclick="frame_index.style.display='block';frame_content.location.href='/modules.php?app=mood_more&user_id=<?php echo $holder_id; ?>';content_index_lf.style.display='none';return false;"
            >
                <?php echo $mn_langpackage->mn_mood; ?>
            </a>
        </div>
    </div>
    <div id="maincontent_lf">
        <!--左-->
        <?php require("uiparts2.0/homeleft.php"); ?>
        <!--左-->


        <!--右-->
        <div id="content_box1_lf">
            <link href="./template/her/mood-change.css" rel="stylesheet" type="text/css">
            <div id="iframe_div_lf">
                <div class="right_l" id='frame_index' style='display:none'>
                    <iframe onload="this.height=frame_content.document.body.scrollHeight" id="frame_content"
                            name="frame_content" scrolling="no" frameborder="0" width="100%" allowTransparency="true">
                    </iframe>
                </div>

                <div id="content_index_lf" style="margin-top: 0;">
                    <!--最新照片-->
                    <div class="top_content_lf" style="margin-top: -5px;">
                        <p>
                                    <span class="title_lf">
                                        <?php echo $ah_langpackage->ah_latest_photos; ?>
                                    </span>
                        </p>
                        <ul class="photos_boxs_lf" style="margin-bottom: 20px;">
                            <?php foreach ($all as $key => $value) {
                                if ($key < 5) { ?>
                                    <li>
                                        <img layer-src="<?php echo $value[photo_src]; ?>" layer-pid
                                             layer-index="<?php echo $key; ?>"
                                             src="<?php echo $value[photo_src]; ?>" class="cursor_zoom"
                                             style="width:115px;"
                                             rel="#user_photo_preview_sun">
                                    </li>
                                <?php }
                            } ?>
                        </ul>
                        <!-- <div id="user_photo_preview_sun"><a class="close"></a> <img src="" id="preview_photo_sun"> </div>-->
                    </div>
                    <!--最新照片-->
                    <link href="./template/her/something.css" rel="stylesheet" type="text/css">
                    <div id="home_list_box1_lf" class="w730">
                        <?php if (!empty($mood)) {
                            foreach ($mood as $key => $value) {
                                $add_time = substr($value['add_time'], 0, 10); ?>
                                <!--循环项-->
                                <dl class="mood">
                                    <dt>
                                        <a target="_blank" href="home2.0.php?h=<?php echo $value[user_id]; ?>">
                                            <img src="<?php echo $user_info[user_ico]; ?>" width="52" height="52"
                                                 alt="<?php echo $value[user_name]; ?>">
                                        </a>
                                        <i class="christmas-adornments  ">
                                        </i>
                                    </dt>
                                    <dd class="share_title_sun somethingnew_tr">
                                        <a target="_blank" class="name_box1_lf"
                                           href="home2.0.php?h=<?php echo $value[user_id]; ?>">
                                            <?php echo $value[user_name]; ?>
                                        </a>
                                        <?php echo $mo_langpackage->mo_mood_update; ?>
                                    </dd>
                                    <dd class="comment_cont_lf comment_tree1_parent_lq">
                                        <div class="content" style=" text-align:center">
                                            <?php
                                            if (strtotime($value['add_time']) < strtotime('2015-07-12 14:49:42'))
                                                echo get_face($value['mood']);
                                            else
                                                echo get_face2($value['mood']);
                                            if (!empty($value["mood_pic"])) {
                                                echo "<div>";
                                                echo "<img src='{$value['mood_pic']}' style='max-width:150px;'>";
                                                echo "</div>";
                                            } ?>
                                        </div>
                                        <p class="info_box1_lf">
                                                <span class="send_time translate_op1_lf">
                                                    <?php echo $add_time; ?>
                                                </span>
                                            <input type="hidden" class="sendTime" value="2015/5/8 4:48:56">
                                            <!-- <a class="translate_op1_lf trans" datamember="buckly427" id="trans_c01075547af94961ac1b05e79ba3efbe"
                                                target="_blank">翻译</a>
                                                <a class="recomment_op1_lf" data_wsf="type:mood" target="_blank">评论（<span><?php echo $value['comments'] ?></span>）</a> -->
                                            <?php
                                            foreach ($mood_comment

                                            as $k => $v) {
                                            if ($value['mood_id'] == $v['mood_id']){
                                            //echo "<pre>";print_r($sessuserinfo);exit;
                                            //男号不看男号的评论
                                            if ($sessuserinfo["user_sex"] == 1) {
                                                $sql = "select user_sex from wy_users where user_id='{$v['visitor_id']}'";
                                                $res = $dbo->getRow($sql);
                                                if ($res["user_sex"] == 1) {
                                                    if ($v["visitor_id"] != $sessuserinfo["user_id"]) {
                                                        break;
                                                    }
                                                }
                                            }
                                            ?>
                                        <dl class="child_box1_lf">
                                            <dt>
                                                <a target="_blank" class="name_box1_lf"
                                                   href="home2.0.php?h=<?php echo $v["visitor_id "]; ?>">
                                                    <img src="<?php if ($v['visitor_ico']) {
                                                        echo str_replace(" _small ", "", $v['visitor_ico']);
                                                    } else {
                                                        echo "/skin/default/jooyea/images/d_ico_1.gif ";
                                                    } ?>" width="38" height="38"
                                                         alt="<?php echo filt_word($v[" visitor_name "]); ?>">
                                                </a>
                                            </dt>
                                            <dd style="width:410px;">
                                                <div class="somethingnew_tr"
                                                     id='sub_com_<?php echo $v['comment_id']; ?>'>
                                                    <a class="name_box1_lq"
                                                       href="home2.0.php?h=<?php echo $v["visitor_id"]; ?>">
                                                        <?php echo filt_word($v["visitor_name"]); ?>&nbsp;&nbsp;
                                                    </a>
                                                    <?php if (strtotime($v['add_time']) < strtotime('2015-07-10 17:46:42')) echo filt_word(get_face($v["content"])); else echo(get_face2($v["content"])); ?>
                                                    <br>
                                                    <span class="send_time">
                                                                <?php echo $v["add_time"]; ?>
                                                            </span>
                                                </div>
                                            </dd>
                                        </dl>
                                        <?php }
                                        }//echo "<pre>";print_r($v);exit;}} ?>
                                        </p>
                                    </dd>
                                    <dd class="comment_box_lf reply_input1_lq comment_tree1_lq hidden1_lq ml75"></dd>
                                    <dd class="root_reply_lq hidden1_lq ml75">
                                        <input class="reply_simple_lq" type="text" value="我也说一句...">
                                    </dd>
                                </dl>
                                <!--循环项-->
                            <?php }
                        } ?>
                        <!-- <div class="promptbox loaded"><strong><var></var>暂无更多数据可以显示！</strong></div>-->
                    </div>
                </div>
            </div>
            <div id="previewBigImg_ly" class="imgShow_ly">
                <a class="close"></a>
                <img src="" id="preview_photo_show">
            </div>
            <div id="right_info_lq">
                <div id="viewers_box1_lq">
                    <h3>
                        <?php echo $mn_langpackage->mn_visi; ?>
                    </h3>
                    <?php
                    $guest_rs = array();
                    if (!($guest_info["user_sex"] == 1)) {
                        $guest_rs = api_proxy("guest_self_by_uid", "*", $user_info['user_id'], 10);
                    }
                    //$sql="select * from wy_guest  where user_id=" .$user_info['user_id']. ' order by guest_id desc limit 10';
                    //echo $sql;
                    //$guest_rs=$ dbo->getRs($sql); if($is_self == "N"){$guest_rs=NULL;}
                    //echo "<pre>";print_r($guest_rs);exit;
                    foreach ($guest_rs as $key => $val) { ?>
                        <!--访客循环-->
                        <dl class="viewer_lq" id="111115">
                            <dt class="img_box1_lq">
                                <a target="_blank" href="home2.0.php?h=<?php echo $val[guest_user_id]; ?>">
                                    <img src="/rootimg.php?src=<?php echo $val[guest_user_ico]; ?>&h=82&w=82&z=1"
                                         width="48" height="48">
                                </a>
                            </dt>
                            <dd class="viewer_info1_lq">
                                <p>
                                        <span class="viewdate_lq send_time"
                                              dateutc="<?php echo substr($val['add_time'], 0, 16); ?>">
                                            <?php echo substr($val['add_time'], 0, 16); ?>
                                        </span>
                                </p>
                                <p>
                                        <span class="viewdate_lq  visitors_name_lf"
                                              title="<?php echo $val[guest_user_name]; ?>">
                                        </span>
                                </p>
                                <p>
                                        <span class="viewdate_lq  visitors_name_lf"
                                              title="<?php echo $val[guest_user_name]; ?>">
                                            <?php echo $val['guest_user_name']; ?>
                                        </span>
                                </p>
                                <!-- <p> <span class="addfriend_icon1_lq" onclick="addFriends(&#39;111115&#39;,$(this))" title="加为好友"> </span> </p>-->
                            </dd>
                        </dl>
                        <!--访客循环-->
                    <?php } ?>
                </div>
            </div>
            <br class="clear_lq">
        </div>
        <!--右-->
    </div>
    <br class="clear_lq">
</div>


<!--底部-->
<?php require("uiparts2.0/footor.php"); ?>
<!--底部-->
<div id="gotop" style="display: block;" onclick="pageScroll();" title="TOP"></div>
<script>
    //获取左边头像宽度以做特殊设置
    var memberHeader = document.getElementById("member_header");
    var memberHeaderimg = memberHeader.getElementsByTagName("img")[0];
    memberHeaderimg.onload = function () {
        imgSize.call(memberHeaderimg);
    }

    function imgSize() {
        var imgObj = new Image();
        imgObj.src = this.src;
        if (imgObj.height > 160) {
            memberHeader.style.lineHeight = 'normal';
        }
    }
</script>

</body>

</html>