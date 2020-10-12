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
<div id="topbar_lq" style=" background: #b20000;">
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
        <div id="msgbox" class="downmenu msgbox">
            <em>
                <a href="javascript:;">
                    <span class="msg_icon1_lq"></span>
                </a>
            </em>
            <div id="msgnum1" class="msgnum"
                 count="<?php echo $num; ?>" <?php if ($num) echo 'style=" visibility:visible"'; ?> >
				<?php echo $num; ?>
            </div>
            <div id="msglist" class="downlist">
                <i class="triggle-top"></i>
                <iframe sid="remind" name="remind" src="modules2.0.php?app=remind" scrolling="no" frameborder="0"
                        allowTransparency="true" style=" height:50px; overflow:hidden; width:200px">
                </iframe>
            </div>
        </div>
        <!--顶部消息-->
        <!--顶部导航-->
        <div id="nav_lq" style="right: 10px;">
            <a id="js_index-page" class="nav_charge_lq js_tabChange" href="main2.0.php?app=user_pay">
				<?php echo $u_langpackage->u_pay; ?>
            </a>
            <a href="javascript:void(0);" onclick="location.href='main2.0.php?app=user_upgrade';return false;"
               hidefocus="true" class="js_tabChange">
				<?php echo $u_langpackage->u_update; ?>
            </a>
            <a class="js_tabChange" id="onlineUprate_dp" href="main.php">
				<?php echo $u_langpackage->u_index1; ?>
            </a>
            <a id="js_onlineUprate_dp" class="js_tabChange" href="home2.0.php?h=<?php echo get_sess_userid(); ?>"
               target="_blank">
				<?php echo $u_langpackage->u_homepage; ?>
            </a>
            <a href="javascript:void(0);" onclick="location.href='main2.0.php?app=mypals';return false;"
               hidefocus="true" class="js_tabChange" style="width:120px;">
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
                <a href="javascript:;" onclick="i_im_talkWin('187','imWin');">
					<?php echo "在线客服";//$u_langpackage->u_dressup;?>
                </a>
                <!-- <a href="<?php if ($u_sex_txrz['user_sex'] == 0 && $u_sex_txrz['is_pass'] != 1) {
					echo "javascript:;";
				} else {
					echo "main2.0.php?app=user_dressup";
				} ?>"><?php echo "在线客服";//$u_langpackage->u_dressup;?></a> -->
                <a href="<?php if ($u_sex_txrz['user_sex'] == 0 && $u_sex_txrz['is_pass'] != 1) {
					echo "javascript:; ";
				} else {
					echo "main2.0.php?app=privacy ";
				} ?>" target="frame_content">
					<?php echo $mn_langpackage->mn_user_pri; ?>
                </a>
                <a href="do.php?act=logout">
					<?php echo $mn_langpackage->mn_out; ?>
                </a>
            </div>
            <a href="main2.0.php?app=mypals_search" style="width:15px;">
                <i class="allSearch-icon">
                </i>
            </a>
        </div>
        <!--顶部导航-->
    </div>
</div>
<script type="text/javascript">
    $(function () {
        //**********右侧指定div fixed&&topbar右侧下拉列表
        var jqNav = $('#nav_lq');
        $('.expand_a1_lq,#expand_nav_lq', jqNav).bind('mouseenter mouseleave', toggleNav);

        //展开选项
        function toggleNav(e) {
            if (e.type == 'mouseenter') {
                $('#nav_lq .expand_a1_lq').addClass('active');
                $('#expand_nav_lq').removeClass('hidden1_lq');
            } else {
                $('#nav_lq .expand_a1_lq').removeClass('active');
                $('#expand_nav_lq').addClass('hidden1_lq');
            }
        }

        $("#msgbox").bind("click",
            function (e) {

                //alert('aaa');
                var obj = $(this).closest("#msgbox");
                // $(this).addClass("msgboxhover").find("div.downlist").show();
                obj.find("div.downlist").show();
                var e = e || window.event;
                e.stopPropagation();
                $('body').on("click",
                    function (e) {
                        var e = e || window.event;
                        $("div.downlist").hide();
                        e.stopPropagation();
                    });
            });

        $('#msglist').on("mouseleave",
            function (e) {
                var e = e || window.event;
                $("div.downlist").hide();
                e.stopPropagation();
            });

        /*********/

    })
</script>