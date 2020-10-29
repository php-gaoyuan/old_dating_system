<?php
//语言包引入
$ah_langpackage = new arrayhomelp;

$remind_count = api_proxy("message_get_remind_count");
//好友提示数量
$uid = get_sess_userid();
$t_scrip = $tablePreStr . "msg_inbox";
//$result_rs=array();
$dbo = new dbex;
dbplugin('r');
$sql = " select count(*) as num from $t_scrip where user_id = $uid and from_user='系统发送' and readed=0";
//$dbo->setPages(20,$page_num);
$friends_num = $dbo->getRow($sql);
//$page_total=$dbo->totalPage;
//return $result_rs;
$friendnum = $friends_num['num'];
$sql = "select `count` from wy_remind where user_id='$user_id' ";
$messs = $dbo->getRs($sql);
$num = 0;
foreach ($messs as $k => $m) {
	$num += $m[count];
}
?>
<div class="head_w" id="head_navs" style="height:50px;background:#b20000;position:fixed;top:0;z-index:1000;-webkit-box-shadow: 0px 1px 3px;-moz-box-shadow: 0px 1px 3px;box-shadow: 0px 1px 3px;">
    <div class="search" id="main_search">
        <div class="snslogo">
            <a href="main.php"><img src="skin/<?php echo $skinUrl; ?>/images/snslogo.png"/></a>
            <div class="top_msg" id="top_msg_hv" onmouseout="sideMenuShow(false);" onmouseover="sideMenuShow(true);">
                <span class="msg_1"><span id="top_msg_num"><?php echo $num; ?></span></span></div>
            <div class="msg_iframe">
                <iframe id="remind" name="remind" src="modules.php?app=remind" scrolling="no" frameborder="0"
                        allowTransparency="true"
                        onmouseout="sideMenuShow(false);document.getElementById('top_msg_hv').style.backgroundColor=''"
                        onmouseover="sideMenuShow(true);document.getElementById('top_msg_hv').style.backgroundColor='#fff'"
                        style="display:none;width:160px;"></iframe>
            </div>
        </div>
        <!--<div class="schbox main_schbox">
				<form class="search_box" action="main.php" onsubmit="clear_def(this,'<?php echo $ah_langpackage->ah_enter_name; ?>');">
					<input id="searchtop_input" maxlength='20' class="inpt" type="text" name='memName' value="<?php echo $ah_langpackage->ah_enter_name; ?>" onblur="inputTxt(this,'set');" onfocus="inputTxt(this,'clean');" />
					<input class="btn" type="submit" value="" />
					<input type='hidden' name='app' value='mypals_search_list' />
				</form>
			</div>-->
        <div class="main_top_nav">
            <ul>
                <li><a href="main.php?app=user_pay"><?php echo $u_langpackage->u_pay; ?></a></li>
                <li><a href="main.php"><?php echo $u_langpackage->u_index1; ?></a></li>
                <li><a href="home2.0.php?h=<?php echo get_sess_userid(); ?>"
                       target="_blank"><?php echo $u_langpackage->u_homepage; ?></a></li>
                <!-- <li><a href="main.php?app=mypals_search_list&online=1" hidefocus="true" >看谁在线</a></li> -->
                <li><a href="javascript:void(0);" onclick="location.href='main.php?app=mypals';return false;"
                       hidefocus="true"><?php echo $u_langpackage->u_myfriends; ?></a></li>
                <li><a href="main.php?app=mypals_search"><?php echo $u_langpackage->u_my_search; ?></a></li>
                <li id="li_sitting" onmouseout="setMenuShow(false);" onclick="setMenuShow(true);"
                    onmouseover="setMenuShow(true);"><a><img src="skin/default/jooyea/images/setting.png"/>
                        <!--<?php echo $u_langpackage->u_mysetting; ?>--></a></li>
                <li><a href="main.php?app=user_dressup" target="_top" hidefocus="true"><img
                                src="skin/default/jooyea/images/skint.png"/>
                        <!--<?php echo $u_langpackage->u_my_skin; ?>--></a></li>

            </ul>
            <div id="set_menu_bridge" style="display:none;" onmouseover="setMenuShow(true);"
                 onmouseout="setMenuShow(false);">
                <ul id="set_menu" class="set_menu" style="display:none;">
                    <li class="user_info"><a href="modules.php?app=user_info"
                                             target="frame_content"><?php echo $u_langpackage->u_achives; ?></a></li>
                    <li class="user_ico"><a href="modules.php?app=user_ico" target="frame_content"
                                            hidefocus="true"><?php echo $u_langpackage->u_icon; ?></a></li>
                    <li class="user_pw_change"><a href="modules.php?app=user_pw_change"
                                                  target="frame_content"><?php echo $u_langpackage->u_pw; ?></a></li>
                    <li class="user_dressup"><a href="modules.php?app=user_dressup"
                                                target="frame_content"><?php echo $u_langpackage->u_dressup; ?></a></li>
                    <!-- <li class="user_affair"><a href="modules.php?app=user_affair" target="frame_content" hidefocus="true"><?php echo $u_langpackage->u_set_affair; ?></a></li> -->
                    <li class="user_privacy"><a href="modules.php?app=privacy"
                                                target="frame_content"><?php echo $mn_langpackage->mn_user_pri; ?></a>
                    </li>
                    <li class="user_privacy"><a href="do.php?act=logout"><?php echo $mn_langpackage->mn_out; ?></a></li>
                </ul>
            </div>
        </div>
        <!-- <a href="modules.php?app=mypals_search" target="frame_content"><?php echo $u_langpackage->u_senior_search; ?></a> -->
    </div>

</div>
<!-- <div class="head" style="float:left">
	<div class="head_top" style="">
		<h1><a title="main.php" href="main.php"><img alt="" src="skin/<?php echo $skinUrl; ?>/images/snslogo.png"></a><div class="sideitem_ico" style="top:10px"><a href="javascript:void(0);" hidefocus="true" onmouseout="sideMenuShow(false);" onmouseover="sideMenuShow(true);"></a>
			<div >
			<iframe onload="this.height=0" id="remind" name="remind" src="modules.php?app=remind" scrolling="no" frameborder="0" allowTransparency="true" onmouseout="sideMenuShow(false);" onmouseover="sideMenuShow(true);" style="display:none;width:160px;"></iframe>
			</div>
		</div></h1>
		
	</div>
</div> -->
<div class="clear"></div>

<div class="nav">

    <div class="right_nav">
        <dl>
            <!-- <dt><a href="home2.0.php?h=<?php echo get_sess_userid(); ?>" hidefocus="true"><?php echo filt_word(get_sess_username()); ?></a></dt>
            <dt><a href="modules.php?app=mypals_invite" target="frame_content" hidefocus="true"><?php echo $mn_langpackage->mn_user_invite; ?></a></dt> -->
            <dt><a href="javascript:void(0);" hidefocus="true" onmouseout="setMenuShow(false);"
                   onclick="setMenuShow(true);" style="font-size:0px;"><?php echo $mn_langpackage->mn_user_set; ?></a>

            </dt>
            <!-- <dt style="background:none"><a href="do.php?act=logout" hidefocus="true"><?php echo $mn_langpackage->mn_out; ?></a></dt> -->
        </dl>
    </div>
</div>