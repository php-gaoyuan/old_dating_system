<?php
require("session_check.php");
require("../foundation/fpages_bar.php");
require("../foundation/fsqlseletiem_set.php");
require("../foundation/fback_search.php");

//语言包引入
$m_langpackage = new modulelp;
$ad_langpackage = new adminmenulp;
$bp_langpackage = new back_publiclp;
$is_check = check_rights("c01");
if (!$is_check) {
    echo 'no permission';
    exit;
}

//表定义区
$t_users = $tablePreStr . "users";

$dbo = new dbex;
dbtarget('w', $dbServs);

//当前页面参数
$page_num = trim(get_argg('page'));

//变量区
$c_province = short_check(get_argg('province'));
$c_city = short_check(get_argg('city'));
$c_online = intval(get_argg('online'));
$c_txrz = intval(get_argg('txrz_ico'));
$c_is_txrz = intval(get_argg('is_txrz'));
$c_orderby = short_check(get_argg('order_by'));
$c_ordersc = short_check(get_argg('order_sc'));
$c_perpage = get_argg('perpage') ? intval(get_argg('perpage')) : 20;

if ($c_online == 1) {
    $t_online = $tablePreStr . "online";
    $t_table = $t_users . "," . $t_online;
} else {
    $t_table = $t_users;
}

$eq_array = array('user_id', 'is_pass', 'user_sex', 'login_ip');
$like_array = array("user_name");
$date_array = array("user_add_time", "lastlogin_datetime");
$num_array = array("integral");
$join_cond = "user_id";
$sql = spell_sql($t_table, $eq_array, $like_array, $date_array, $num_array, '', '', $join_cond);
if ($c_txrz == 1) {
    $sql .= " and ($t_users.txrz_ico is not null) and ($t_users.is_txrz='$c_is_txrz') ";
}

if (!empty($c_city)) {
    $sql .= " and ($t_users.birth_city = '$c_city' or $t_users.reside_city = '$c_city') ";
}

if (!empty($c_province)) {
    $sql .= " and ($t_users.birth_province = '$c_province' or $t_users.reside_province ='$c_province') ";
}

if (!empty($c_orderby)) {
    $sql .= " order by $t_users.$c_orderby ";
}

$sql .= " $c_ordersc ";

//设置分页
$dbo->setPages($c_perpage, $page_num);

//取得数据
$member_rs = $dbo->getRs($sql);

//分页总数
$page_total = $dbo->totalPage;

//用户状态
$s_no_limit = '';
$s_lock = '';
$s_normal = '';
if (get_argg('is_pass') == '') {
    $s_no_limit = "selected";
}
if (get_argg('is_pass') == '0') {
    $s_lock = "selected";
}
if (get_argg('is_pass') == '1') {
    $s_normal = "selected";
}

//在线状态
if (get_argg('online') == 1) {
    $is_online = 'checked';
}
if (get_argg('online') == '') {
    $is_online = '';
}
//用户性别
$sex_no_limit = '';
$sex_women = '';
$sex_man = '';
if (get_argg('user_sex') == '') {
    $sex_no_limit = "selected";
}
if (get_argg('user_sex') == '0') {
    $sex_women = "selected";
}
if (get_argg('user_sex') == '1') {
    $sex_man = "selected";
}

//按字段排序
$o_def = '';
$o_reg_time = '';
$o_guest_num = '';
$o_integral = '';
$o_lastlogin_datetime = '';
if (get_argg('order_by') == '' || get_argg('order_by') == "user_id") {
    $o_def = "selected";
}
if (get_argg('order_by') == "user_add_time") {
    $o_reg_time = "selected";
}
if (get_argg('order_by') == "guest_num") {
    $o_guest_num = "selected";
}
if (get_argg('order_by') == "integral") {
    $o_integral = "selected";
}
if (get_argg('order_by') == "lastlogin_datetime") {
    $o_lastlogin_datetime = "selected";
}

//显示控制
$isNull = 0;
$isset_data = "";
$none_data = "content_none";
if (empty($member_rs)) {
    $isset_data = "content_none";
    $none_data = "";
    $isNull = 1;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $m_langpackage->m_member_list; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" media="all" href="css/admin.css">
    <script type='text/javascript' src='../servtools/area.js'></script>
    <script type='text/javascript' src='../servtools/calendar.js'></script>
    <script type='text/javascript' src='../servtools/ajax_client/ajax.js'></script>
    <script type='text/javascript'>
        function setAct(URL) {
            window.open(URL, 'newwindow', 'height=500,width=520,top=200,left=280,toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no,status=no');
        }

        function lock_member_callback(user_id, type_value) {
            if (type_value == 0) {
                str = "<font color='red'><?php echo $m_langpackage->m_lock;?></font>";
                document.getElementById("unlock_button_" + user_id).style.display = "";
                document.getElementById("lock_button_" + user_id).style.display = "none";
            } else {
                str = "<?php echo $m_langpackage->m_normal;?>";
                document.getElementById("unlock_button_" + user_id).style.display = "none";
                document.getElementById("lock_button_" + user_id).style.display = "";
            }
            document.getElementById("state_" + user_id).innerHTML = str;
        }

        function lock_member(user_id, type_value) {
            var lock_member = new Ajax();
            lock_member.getInfo("member_lock.action.php", "GET", "app", "user_id=" + user_id + "&type_value=" + type_value, function (c) {
                lock_member_callback(user_id, type_value);
            });
        }

        function is_del(user_id) {
            var lock_member = new Ajax();
            lock_member.getInfo("member_del.action.php", "GET", "app", "user_id=" + user_id, function (c) {
                is_del_callback(c);
            });
        }

        function is_del_callback(mess) {
            alert(mess);
            window.location.reload();
        }

        function recommend(uid, uname, uico, upass, gnum, usex) {
            var lock_member = new Ajax();
            lock_member.getInfo("recommend_add.action.php?uid=" + uid + "&uico=" + uico + "&upass=" + upass + "&gnum=" + gnum + "&usex=" + usex, "post", "app", "uname=" + uname, function (c) {
                document.getElementById("not_recom_" + uid).style.display = "";
                document.getElementById("not_recom_" + uid).innerHTML = c;
            });
        }

        function check_form() {
            var min_reg_time = document.getElementById("user_add_time1").value;
            var max_reg_time = document.getElementById("user_add_time2").value;
            var min_last_login = document.getElementById("lastlogin_datetime1").value;
            var max_last_login = document.getElementById("lastlogin_datetime2").value;
            var time_format = /\d{4}\-\d{2}\-\d{2}/;

            if (min_reg_time) {
                if (!time_format.test(min_reg_time)) {
                    alert("<?php echo $m_langpackage->m_date_wrong;?>");
                    return false;
                }
            }

            if (max_reg_time) {
                if (!time_format.test(max_reg_time)) {
                    alert("<?php echo $m_langpackage->m_date_wrong;?>");
                    return false;
                }
            }

            if (min_last_login) {
                if (!time_format.test(min_last_login)) {
                    alert("<?php echo $m_langpackage->m_date_wrong;?>");
                    return false;
                }
            }

            if (max_last_login) {
                if (!time_format.test(max_last_login)) {
                    alert("<?php echo $m_langpackage->m_date_wrong;?>");
                    return false;
                }
            }
        }

    </script>
</head>
<script language="JavaScript" type="text/JavaScript">
    function checkAll(form, name) {
        for (var i = 0; i < form.elements.length; i++) {
            var e = form.elements[i];
            if (e.name.match(name)) {
                e.checked = form.elements['chkall'].checked;
            }
        }
    }

    function set_service(user_id, type) {

        var lock_member = new Ajax();
        lock_member.getInfo("set_service.action.php", "GET", "app", "user_id=" + user_id + "&type=" + type, function (c) {
            alert(c)
            location.reload();
        });
    }

    function tuijianshouye(id, t) {
        var is_index = new Ajax();
        is_index.getInfo("set_is_index.action.php", "GET", "", "user_id=" + id + "&type=" + t, function (c) {
            if (c == 1) {
                location.reload();
            } else alert('必须设置头像，并且发表大于10字的心情 才能推荐');
        });
    }
</script>
<body>
<div id="maincontent">
    <div class="wrap">
        <div class="crumbs"><?php echo $ad_langpackage->ad_location; ?> &gt;&gt; <a
                    href="javascript:void(0);"><?php echo $ad_langpackage->ad_user_management; ?></a> &gt;&gt; <a
                    href="member_list.php?order_by=user_id&order_sc=desc"><?php echo $ad_langpackage->ad_manage_member; ?></a>
        </div>
        <hr/>
        <div class="infobox">
            <h3><?php echo $m_langpackage->m_check_condition; ?></h3>
            <div class="content">
                <form action="" method="GET" name='form' onsubmit='return check_form();'>
                    <TABLE class="form-table">
                        <TBODY>
                        <TR>
                            <th width="90"><?php echo $m_langpackage->m_userid; ?></th>
                            <TD><input type="text" class="small-text" name='user_id'
                                       value="<?php echo get_argg('user_id'); ?>"></TD>
                            <th><?php echo $m_langpackage->m_uname; ?></th>
                            <TD><INPUT type='text' class="small-text" name='user_name'
                                       value='<?php echo get_argg('user_name'); ?>'>&nbsp;<font color=red>*</font></TD>
                        </TR>
                        <TR>
                            <th><?php echo $m_langpackage->m_state; ?></th>
                            <TD><SELECT name='is_pass'>
                                    <OPTION value="" <?php echo $s_no_limit; ?>><?php echo $m_langpackage->m_astrict_no; ?></OPTION>
                                    <OPTION value="1" <?php echo $s_normal; ?>><?php echo $m_langpackage->m_normal_member; ?></OPTION>
                                    <OPTION value="0" <?php echo $s_lock; ?>><?php echo $m_langpackage->m_lock_member; ?></OPTION>
                                </SELECT>
                            </TD>
                            <th><?php echo $m_langpackage->m_sex; ?></th>
                            <td>
                                <select name="user_sex">
                                    <option value='' <?php echo $sex_no_limit; ?>><?php echo $m_langpackage->m_astrict_no; ?></option>
                                    <option value='0' <?php echo $sex_women; ?>><?php echo $m_langpackage->m_woman; ?></option>
                                    <option value='1' <?php echo $sex_man; ?>><?php echo $m_langpackage->m_man; ?></option>
                                </select>
                            </td>
                        </TR>
                        <tr>
                            <th>
                                <?php echo $m_langpackage->m_ip; ?>
                            </th>
                            <td>
                                <input type='text' class="small-text" name='login_ip'
                                       value='<?php echo get_argg('login_ip'); ?>'/>
                            </td>
                            <th><?php echo $m_langpackage->m_reg_date; ?></th>
                            <td><INPUT type='text' AUTOCOMPLETE=off onclick='calendar(this);' class="small-text"
                                       name='user_add_time1' id='user_add_time1'
                                       value='<?php echo get_argg('user_add_time1'); ?>'> ~ <INPUT class="small-text"
                                                                                                   value='<?php echo get_argg('user_add_time2'); ?>'>
                                (YYYY-MM-DD)
                            </TD>
                            </td>
                        </TR>



                        <tr>
                            <th>
                                <?php echo $m_langpackage->m_online; ?>
                            </th>
                            <td>
                                <input type='checkbox' name='online' value=1 <?php echo $is_online; ?> />
                            </td>
                            <th style='color:red'>
                                照片认证
                            </th>
                            <td>
                                <label> <input type='checkbox' name='txrz_ico' value='1' <?php if ($_GET['txrz_ico']) {
                                        echo 'checked';
                                    } ?>
                                               onchange="if(this.checked){document.getElementById('txrz_id').style.display=''}"/></label>&nbsp;&nbsp;
                                <span id="txrz_id" style="<?php if ($_GET['txrz_ico']) {
                                    echo '';
                                } else {
                                    echo "display:none";
                                } ?>"><label>&nbsp;
			<select name="is_txrz">
				<option value="0" <?php if ($_GET['is_txrz'] == 0) {
                    echo "selected";
                } ?>>未审核</option>
				<option value="1" <?php if ($_GET['is_txrz'] == 1) {
                    echo "selected";
                } ?>>已通过</option>
				<option value="2" <?php if ($_GET['is_txrz'] == 2) {
                    echo "selected";
                } ?>>已驳回</option>
			</select>
		</label></span>
                            </td>

                        </tr>

                        <TR>
                            <th><?php echo $m_langpackage->m_result_order; ?></th>
                            <TD colSpan="3" height="20">
                                <SELECT name='order_by'>
                                    <OPTION value='user_id' <?php echo $o_def; ?>><?php echo $m_langpackage->m_def_order; ?></OPTION>
                                    <OPTION value='user_add_time' <?php echo $o_reg_time; ?>><?php echo $m_langpackage->m_reg_date; ?></OPTION>
                                    <OPTION value='guest_num' <?php echo $o_guest_num; ?>><?php echo $m_langpackage->m_guest; ?></OPTION>
                                    <OPTION value='integral' <?php echo $o_integral; ?>><?php echo $m_langpackage->m_inter; ?></OPTION>
                                    <OPTION value='lastlogin_datetime' <?php echo $o_lastlogin_datetime; ?>><?php echo $m_langpackage->m_last_login; ?></OPTION>
                                </SELECT>
                                <?php echo order_sc(); ?>
                                <?php echo perpage(); ?>
                            </TD>
                        </TR>
                        <tr>
                            <td colspan=2><?php echo $m_langpackage->m_red; ?></td>
                        </tr>
                        <tr>
                            <td colspan=2><INPUT class="regular-button" type="submit"
                                                 value="<?php echo $m_langpackage->m_search; ?>"/></td>
                        </tr>
                        </TBODY>
                    </TABLE>
                </form>
            </div>
        </div>

        <div class="infobox">
            <h3><?php echo $m_langpackage->m_member_list; ?></h3>
            <div class="content">
                <table class="list_table <?php echo $isset_data; ?>">
                    <thead>
                    <tr>
                        <th width="50" style="text-align:center"><?php echo $m_langpackage->m_ico; ?></th>
                        <th width="80" style="text-align:center"><?php echo $m_langpackage->m_uname; ?></th>
                        <th width="60" style="text-align:center"><?php echo $m_langpackage->m_reg_date; ?></th>

                        <th width="60" style="text-align:center"><?php //echo $m_langpackage->m_ip;?>注册IP</th>

                        <th width="60" style="text-align:center"><?php echo $m_langpackage->m_last_login; ?></th>
                        <th width="60" style="text-align:center"><?php //echo $m_langpackage->m_ip;?>最后登陆IP</th>

                        <th width="30" style="text-align:center"><?php echo $m_langpackage->m_inter; ?></th>
                        <th width="50" style="text-align:center"><?php echo $m_langpackage->m_guest; ?></th>
                        <th width="30" style="text-align:center"><?php echo $m_langpackage->m_state; ?></th>
                        <th width="30" style="text-align:center">首页推荐</th>

                        <th width="80" style="text-align:center">操作</th>
                        <?php if ($c_txrz == 1){ ?> <!-- Comment By Root Time:20141022 -->
                        <th width="50" style="text-align:center">头像认证</th>
                        <?php } ?><!-- Comment By Root Time:20141022 -->
                    </tr>
                    </thead>
                    <?php
                    foreach ($member_rs as $rs) {
                        ?>

                        <tr>
                            <td>
                                <a href="../home2.0.php?h=<?php echo $rs['user_id']; ?>"
                                   target="_blank"><span></span><img src="../<?php


                                    if (!$rs['user_ico']) {

                                        $rs['user_ico'] = "skin/default/jooyea/images/d_ico_1.gif";
                                    }

                                    echo $rs['user_ico'];


                                    ?>" height='43' width='43'/></a>
                            </td>
                            <td>
                                <?php echo $rs['user_name']; ?>
                            </td>

                            <td style="text-align:center"><?php echo $rs['user_add_time']; ?></td>

                            <td style="text-align:center"><?php echo $rs['zhuce_ip']; ?></td>

                            <td style="text-align:center"><?php echo $rs['lastlogin_datetime']; ?></td>

                            <td style="text-align:center"><?php echo $rs['login_ip']; ?></td>


                            <td style="text-align:center"><?php echo $rs['integral']; ?></td>

                            <td style="text-align:center"><?php echo $rs['guest_num']; ?></td>

                            <td style="text-align:center"><span
                                        id="state_<?php echo $rs['user_id']; ?>"><?php if ($rs['is_pass'] == 1) echo $m_langpackage->m_normal; else echo "<font color='red'>" . $m_langpackage->m_lock . "</font>"; ?></span>
                            </td>
                            <td align="center">
                                <?php if ($rs['is_index'] == 0) { ?>
                                    <a style="color:green;cursor:pointer"
                                       onclick="tuijianshouye('<?php echo $rs['user_id']; ?>','1');">推荐</a>
                                <?php } elseif ($rs['is_index'] == 1) { ?>
                                    <a style="color:red;cursor:pointer"
                                       onclick="tuijianshouye('<?php echo $rs['user_id']; ?>','0');">取消</a>
                                <?php } ?>
                            </td>

                            <td align="center">
                                <div id="operate_<?php echo $rs['user_id']; ?>">
                                    <a href="javascript:setAct('user_info.php?user_id=<?php echo $rs["user_id"]; ?>');">
                                        查看
                                    </a>
                                    <a href="javascript:setAct('user_edit.php?user_id=<?php echo $rs["user_id"]; ?>');">
                                        <!-- <image src="images/more.gif" title="<?php echo $m_langpackage->m_more; ?>" alt="<?php echo $m_langpackage->m_more; ?>" /> -->
                                        修改
                                    </a>
                                    <?php
                                    $unlock = "display:none";
                                    $lock = "";
                                    if ($rs['is_pass'] == 0) {
                                        $unlock = "";
                                        $lock = "display:none";
                                    }
                                    $is_recom = "";
                                    $not_recom = "display:none";
                                    if ($rs['is_recommend'] == 0) {
                                        $is_recom = "display:none";
                                        $not_recom = "";
                                    }
                                    ?>
                                    <span id="unlock_button_<?php echo $rs['user_id']; ?>"
                                          style="<?php echo $unlock; ?>"><a
                                                href="javascript:lock_member(<?php echo $rs['user_id']; ?>,1);"><img
                                                    title="<?php echo $m_langpackage->m_unlock; ?>"
                                                    alt="<?php echo $m_langpackage->m_unlock; ?>"
                                                    src="images/unlock.gif"/></a></span>
                                    <span id="lock_button_<?php echo $rs['user_id']; ?>" style="<?php echo $lock; ?>"><a
                                                href="javascript:lock_member(<?php echo $rs['user_id']; ?>,0);"
                                                onclick='return confirm("<?php echo $m_langpackage->m_ask_lock; ?>");'><img
                                                    title="<?php echo $m_langpackage->m_lock; ?>"
                                                    alt="<?php echo $m_langpackage->m_lock; ?>" src="images/lock.gif"/></a></span>
                                    <span id="not_recom_<?php echo $rs['user_id']; ?>"
                                          style="<?php echo $not_recom; ?>"><a
                                                href="javascript:recommend(<?php echo $rs['user_id']; ?>,'<?php echo $rs['user_name']; ?>','<?php echo $rs['user_ico']; ?>',<?php echo $rs['is_pass']; ?>,<?php echo $rs['guest_num']; ?>,<?php echo $rs['user_sex']; ?>);"><?php echo $m_langpackage->m_recom; ?></a></span>
                                    <span id="is_recom_<?php echo $rs['user_id']; ?>"
                                          style="<?php echo $is_recom; ?>"><?php echo $m_langpackage->m_recomed; ?></span>
                                    <span id="is_del_<?php echo $rs['user_id']; ?>"><a
                                                href="javascript:is_del(<?php echo $rs['user_id']; ?>);">删除</a></span>
                                </div>

                            </td>

                            <?php if ($c_txrz == 1){ ?><!-- Comment By Root Time:20141022 -->
                            <td>
                                <a onclick="NewWindow(this.href,'cname','500','700','no');return false"
                                   href="../<?php echo $rs['txrz_ico']; ?>">查看</a> |
                                <select id="rzcaozuo"
                                        onchange="change_tz(this.value,<?php echo $rs['user_id']; ?>,'<?php echo $rs['user_email']; ?>');">
                                    <option value="0" <?php if ($rs['is_txrz'] == 0) {
                                        echo 'selected';
                                    } ?>>未审核
                                    </option>
                                    <option value="1" <?php if ($rs['is_txrz'] == 1) {
                                        echo 'selected';
                                    } ?>>通过
                                    </option>
                                    <option value="2" <?php if ($rs['is_txrz'] == 2) {
                                        echo 'selected';
                                    } ?>>驳回
                                    </option>
                                </select>
                            </td>
                            <?php } ?><!-- Comment By Root Time:20141022 -->


                        </tr>
                        <?php
                    }
                    ?>

                </table>

                <?php page_show($isNull, $page_num, $page_total); ?>
                <div class='guide_info <?php echo $none_data; ?>'><?php echo $m_langpackage->m_none_data; ?></div>
            </div>
        </div>
    </div>
    </form>
    <script type="text/javascript">
        function NewWindow(mypage, myname, w, h, scroll) {
            var win = null;
            LeftPosition = (screen.width) ? (screen.width - w) / 2 : 0;
            TopPosition = (screen.height) ? (screen.height - h) / 2 : 0;
            settings = 'height=' + h + ',width=' + w + ',top=' + TopPosition + ',left='
                + LeftPosition + ',scrollbars=' + scroll + ',resizable=no';
            win = window.open(mypage, myname, settings);
            win.focus();
        }

        function change_tz(obj, uid, email) {
            var change_rz = new Ajax();

            change_rz.getInfo("change_rz.action.php?uid=" + uid + "&is_txrz=" + obj + "&email=" + email, "get", "app", "", function (c) {
                alert(c);
                window.location.reload();
            });
        }
    </script>
</body>
</html>