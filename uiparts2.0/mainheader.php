<?php
//引入语言包
$ah_langpackage = new arrayhomelp;
$sql = "select `count` from wy_remind where user_id='$user_id' ";
$messs = $dbo->getRs($sql);
$num = 0;
foreach ($messs as $k => $m) {
    $num += $m[count];
}
$sql = "select * from wy_horn order by `end_time` desc limit 5";
$horn_list = $dbo->getRs($sql);
//用户资料
$sql = "select user_sex,is_txrz,is_pass from wy_users where user_id='$user_id' ";
$u_sex_txrz = $dbo->getRow($sql);
?>
<div id="topbar_lq">
    <div class="width980_lq">
        <h1 style="padding-top:0 !important;">
            <?php if ($u_sex_txrz['is_pass'] == 1) { ?>
                <a href="main.php">
                    <img src="skin/<?php echo $skinUrl; ?>/images/snslogo.png" / style=" height:32px;margin-top: 6px;">
                </a>
            <?php } else { ?>
                <a href="javascript:;"
                   onclick="top.Dialog.alert('<?php echo $l_langpackage->l_lock_u; ?>');setTimeout(function(){window.location.href='main2.0.php?app=user_info'},2000)">
                    <img src="skin/<?php echo $skinUrl; ?>/images/snslogo.png" / style=" height:32px;margin-top: 6px;">
                </a>
            <?php } ?>
        </h1>
        <!--顶部消息-->
<!--        <div id="msgbox" class="downmenu msgbox">-->
<!--            <em>-->
<!--                <a href="javascript:;">-->
<!--                    <span class="msg_icon1_lq">-->
<!--                    </span>-->
<!--                </a>-->
<!--            </em>-->
<!--            <div id="msgnum1" class="msgnum" count="--><?php //echo $num; ?><!--" --><?php //if ($num)
//                echo 'style=" visibility:visible"'; ?>
<!--            >-->
<!--                --><?php //echo $num; ?>
<!--            </div>-->
<!--            <div id="msglist" class="downlist">-->
<!--                <i class="triggle-top">-->
<!--                </i>-->
<!--                <iframe sid="remind" name="remind" src="modules2.0.php?app=remind" scrolling="no"-->
<!--                        frameborder="0" allowTransparency="true" style=" height:50px; overflow:hidden; width:200px">-->
<!--                </iframe>-->
<!--            </div>-->
<!--        </div>-->
        <!--顶部消息-->
        <!--顶部导航-->
        <div id="nav_lq" style="right: 10px;">
            <a class="js_tabChange" id="onlineUprate_dp" href="main.php">
                <?php echo $u_langpackage->u_index1; ?>
            </a>
            <a class="js_tabChange" href="main2.0.php?app=user_pay">
                <?php echo $u_langpackage->u_pay; ?>
            </a>
            <a class="js_tabChange" href="main2.0.php?app=user_upgrade">
                <?php echo $u_langpackage->u_update; ?>
            </a>

            <a id="js_onlineUprate_dp" class="js_tabChange" href="home2.0.php?h=<?php echo get_sess_userid(); ?>" target="_blank">
                <?php echo $u_langpackage->u_homepage; ?>
            </a>
            <a class="js_tabChange" href="main2.0.php?app=mypals">
                <?php echo $u_langpackage->u_myfriends; ?>
            </a>
            <a class="expand_a1_lq">
                <span class="white_tarrow1_lq">
                </span>
            </a>
            <div id="expand_nav_lq" class="hidden1_lq">
                <i class="triggle-top">
                </i>
                <a href="main2.0.php?app=user_info">
                    <?php echo $u_langpackage->u_achives; ?>
                </a>
                <a href="main2.0.php?app=user_ico">
                    <?php echo $u_langpackage->u_icon; ?>
                </a>
                <a href="main2.0.php?app=user_pw_change" target="frame_content">
                    <?php echo $u_langpackage->u_pw; ?>
                </a>
                <a href="javascript:;" onclick="parent.open_chat('1');">
                    <?php echo $newpub_lp['onlinekefu'];//$u_langpackage->u_dressup;?>
                </a>


                <!-- <a href="<?php if ($u_sex_txrz['user_sex'] == 0 && $u_sex_txrz['is_pass'] != 1) {
                    echo
                    "javascript:;";
                } else {
                    echo "main2.0.php?app=user_dressup";
                } ?>"><?php echo $newpub_lp['onlinekefu'];//$u_langpackage->u_dressup;?></a> -->


                <a href="<?php if ($u_sex_txrz['user_sex'] == 0 && $u_sex_txrz['is_pass'] != 1) {
                    echo "
                javascript:; ";
                } else {
                    echo "main2.0.php?app=privacy ";
                } ?>" target="frame_content">
                    <?php echo $mn_langpackage->mn_user_pri; ?>
                </a>
                <a href="do.php?act=logout">
                    <?php echo $mn_langpackage->mn_out; ?>
                </a>
            </div>
        </div>
        <!--顶部导航-->
    </div>
</div>
<script type="text/javascript">
    $(function () {
        //**********右侧指定div fixed&&topbar右侧下拉列表
        var jqNav = $('#nav_lq');
        $('.expand_a1_lq,#expand_nav_lq', jqNav).bind('mouseenter mouseleave', toggleNav);
    })


    function insertFace(name, id, target) {
        if (document.getElementById('mood_txt')) {
            var ta_num_status = document.getElementById('mood_txt').value.length;
            if (ta_num_status > 293) {
                Dialog.alert("很抱歉，您的状态剩余可输入字数不足以插入表情了。");
                return false;
            }
        }
        $("#" + target).focus();
        var faceText = '[em_' + id + ']';
        if ($("#" + target) != null) {
            $("#" + target).val($("#" + target).val() + faceText);
        }
    }

    function toggleNav(e) {
        if (e.type == 'mouseenter') {
            $('#nav_lq .expand_a1_lq').addClass('active');
            $('#expand_nav_lq').removeClass('hidden1_lq');
        } else {
            $('#nav_lq .expand_a1_lq').removeClass('active');
            $('#expand_nav_lq').addClass('hidden1_lq');
        }
    }

    function isMaxLen(o) {
        var nMaxLen = 300;
        if (o.getAttribute && o.value.length > nMaxLen) {
            o.value = o.value.substring(0, nMaxLen);
        }
        var less_len = document.getElementById('less_txt');
        $(".js_char_count1_lq").html(300 - o.value.length);
    }

    function pic_error(pic) {
        pic.src = 'skin/default/jooyea/images/error.gif';
    }

    function hide_hd() {
        document.getElementById('hd_m').style.display = 'none';
        document.getElementById('show_face').style.top = '45px';
        document.getElementById('id_txt').style.top = '35px';
    }

    function set_xxs_height(_height) {
        $(".index_xxs").css("height", _height);
    }


    function trim(str) {
        return str.replace(/(^\s*)|(\s*$)|(　*)/g, "");
    }


    function submit_new_mood() {
        var fanyi_tp = $('#fanyifs').val();
        var mood_r_pic = $("input[name='mood_r_pic']").val();
        var last_mood_div = $("the_last_mood");
        var mood_text = trim($("#mood_txt").val());
        var need = 0;
        need = len(mood_text) / 100;
        if (need < 1) need = 1;
        if (mood_text == '<?php echo $rf_langpackage->rf_placeholder_text;?>') {
            return false;
        }
        if (fanyi_tp) {
            if (mood_text == '') {
                return false;
            }
            top.Dialog.confirm('<?php echo $u_langpackage->fy_tishi2;?>' + need, function () {
                $.get("fanyi.php", {lan: mood_text, tos: fanyi_tp, ne: need}, function (ca) {
                    if (ca == 0 || !ca) {
                        parent.Dialog.alert("<?php echo $u_langpackage->fy_tishi1;?>");
                        return false;
                    }
                    $.post("do.php?act=mood_add&ajax=1", {mood: ca, mood_r_pic: mood_r_pic}, function (d) {
                            if (d.status == 0) {
                                parent.Dialog.alert(c.info);
                            } else {
                                parent.Dialog.alert('<?php echo $u_langpackage->u_sent_successfully?>');
                            }
                        },
                        "json")
                })
            })
        } else {
            if (mood_text == '') {
                return false;
            } else {
                last_mood_div.innerHTML = '<?php echo $u_langpackage->u_data_post;?>';
                $.post("do.php?act=mood_add&ajax=1", {mood: mood_text, mood_r_pic: mood_r_pic}, function (c) {
                    $("#mood_txt").val('<?php echo $rf_langpackage->rf_placeholder_text;?>');
                    if (c.status == 0) {
                        parent.Dialog.alert(c.info);
                    } else {
                        parent.Dialog.alert('<?php echo $u_langpackage->u_sent_successfully?>');
                    }
                    document.getElementById('ifr').contentWindow.location.reload(true);
                }, "json")
            }
        }
    }

    //评论翻译
    function len(s) {//按字节计算中英文字符长度
        var l = 0;
        var a = s.split('');
        for (var i = 0; i < a.length; i++) {
            if (a[i].charCodeAt(0) < 299) {
                l++;
            } else {
                l += 2;
            }
        }
        return l;
    }

    function mypals_add(other_id) {
        $.get("do.php", {act: 'add_mypals', other_id: '' + other_id}, function (c) {
            mypals_add_callback(c, other_id);
        })
    }

    function mypals_add_callback(content, other_id) {
        if (content == "success") {
            parent.Dialog.alert("<?php echo $mp_langpackage->mp_suc_add;?>");
            //document.getElementById("operate_" + other_id).innerHTML = "<?php echo $mp_langpackage->mp_suc_add;?>";
        } else {
            parent.Dialog.alert(content);
            //document.getElementById("operate_" + other_id).innerHTML = content;
        }
    }

    //图片放大方法
    function topBigImg(src) {
        layer.open({
            type: 1,
            title: false,
            area: '500px',
            offset: "150px",
            closeBtn: 1,
            skin: 'layui-layer-nobg', //没有背景色
            shadeClose: true,
            content: "<img src=" + src + " width='100%'/>"
        });
    }
</script>