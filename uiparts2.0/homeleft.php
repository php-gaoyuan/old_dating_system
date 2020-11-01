<?php
//引入语言包
$rem_langpackage = new remindlp;
//error_reporting(11);ini_set('display_errors','On');
//引入提醒模块公共函数
require ("foundation/fdelay.php");
require ("api/base_support.php");
//error_reporting(E_ALL);
function update_online_time($dbo, $table) {
    $user_id = get_sess_userid();
    $now_time = time();
    $kick_time = 720; //设置超时时间
    if ($user_id) {
        $sql = "update $table set active_time='$now_time' where user_id=$user_id";
        if (!$dbo->exeUpdate($sql)) {
            global $tablePreStr;
            $t_online = $tablePreStr . "online";
            $user_id = get_sess_userid();
            $user_name = get_sess_username();
            $user_ico = get_sess_userico();
            $user_sex = get_sess_usersex();
            $sql = "insert into $t_online (`user_id`,`user_name`,`user_sex`,`user_ico`,`active_time`,`hidden`) values ($user_id,'$user_name','$user_sex','$user_ico','$now_time',0)";
            $dbo->exeUpdate($sql);
        }
    }
    $sql = "select active_time from $table where $now_time-active_time>$kick_time*60";
    $onlines = $dbo->getRs($sql);
    foreach ($onlines as $online) {
        $sql = "select nowdatetime,lastlogin_datetime from wy_users where user_id='" . $online['user_id'] . "'";
        $user = $dbo->getRow($sql);
        if (date('Y-m-d', strtotime($user['lastlogin_datetime'])) == date('Y-m-d', $now_time)) {
            if ($online['active_time'] - strtotime($user['lastlogin_datetime']) >= 28800) {
                if (empty($user['nowdatetime'])) $nowdatetime = 1;
                else $nowdatetime+= 1;
                $sql = "update wy_users set nowdatetime='$nowdatetime' where user_id='" . $online['user_id'] . "'";
                $dbo->exeUpdate($sql);
            } else if ($online['active_time'] - strtotime($user['lastlogin_datetime']) >= 21800) {
                if (empty($user['nowdatetime'])) $nowdatetime = 0.5;
                else $nowdatetime+= 0.5;
                $sql = "update wy_users set nowdatetime='$nowdatetime' where user_id='" . $online['user_id'] . "'";
                $dbo->exeUpdate($sql);
            }
        }
    }
    $sql = "delete from $table where $now_time-active_time>$kick_time*60";
    $dbo->exeUpdate($sql);
}

// function rewrite_delay() {
//     $now_time = time();
//     $content = file_get_contents("foundation/fdelay.php");
//     $content = preg_replace('/(\$LAST_DELAY_TIME)=(\d*)(;)/', "$1={$now_time}$3", $content);
//     $ref = fopen("foundation/fdelay.php", 'w+');
//     fwrite($ref, $content);
//     fclose($ref);
// }
//表定义区
$t_online = $tablePreStr . "online";
$isset_data = "";
$DELAY_ONLINE = 4;
//$is_action = delay($DELAY_ONLINE);
$is_action = true;
//print_r($is_action);exit();
if ($is_action) {
    $dbo = new dbex;
    dbtarget('w', $dbServs);
    update_online_time($dbo, $t_online);
    // rewrite_delay();
}
$remind_rs = api_proxy("message_get", "remind");
//$remind_rs=$dbo->getRs("select * from wy_remind where user_id='$user_id' and is_focus=0");
//echo "<pre>";var_dump($remind_rs);exit;
if ($langPackagePara == 'zh') {
    $remind_rs2 = array();
    foreach ($remind_rs as $r) {
        $mess = $r[4];
        $mess = str_replace("hello", "个招呼", $mess);
        $r[4] = $mess;
        $r['content'] = $mess;
        $remind_rs2[] = $r;
    }
    if (!empty($remind_rs2)) {
        $remind_rs = $remind_rs2;
    } else {
        $remind_rs = array(array('count' => '0', 'content' => '暂时没有消息', 'link' => 'javascript:;'));
    }
} else
//if($langPackagePara=='en')
{
    $remind_rs2 = array();
    foreach ($remind_rs as $r) {
        $mess = $r[4];
        $mess = str_replace("个招呼", " hello", $mess);
        $r[4] = $mess;
        $r['content'] = $mess;
        $remind_rs2[] = $r;
    }
    if (!empty($remind_rs2)) {
        $remind_rs = $remind_rs2;
    } else {
        $remind_rs = array(array('count' => '0', 'content' => 'There is no news!', 'link' => 'javascript:;'));
    }
}
if (empty($remind_rs)) {
    $isset_data = "content_none";
}
//add by root end
//引入语言包
$mn_langpackage = new menulp;
$u_langpackage = new userslp;
$ah_langpackage = new arrayhomelp;
$rf_langpackage = new recaffairlp;
$send_msgscrip = 'modules.php?app=msg_creator&2id=' . $holder_id . '&nw=2';
$add_friend = "javascript:mypalsAddInit($holder_id)";
$leave_word = 'modules.php?app=msgboard_more&user_id=' . $holder_id;
$send_hi = "hi_action($holder_id)";
$send_report = "report_action(10,$holder_id,$holder_id);";
$impression = 'modules.php?app=impression&user_id=' . $holder_id;
if (!isset($user_id)) {
    $send_msgscrip = "javascript:parent.goLogin();";
    $add_friend = 'javascript:parent.goLogin()';
    $leave_word = "javascript:parent.goLogin();";
    $send_hi = 'javascript:parent.goLogin()';
    $send_report = 'javascript:parent.goLogin()';
    set_session('pre_login_url', $_SERVER["REQUEST_URI"]);
}
$uu = $dbo->getRow("select is_txrz,user_group,integral from wy_users where user_id='$holder_id'"); //未读邮件数量$email_count=$dbo->getRs("select readed from wy_msg_inbox where user_id='$user_id' and readed=0");$email_num=count($email_count);
$user_id = get_sess_userid();
$sqlg = "select * from wy_users where user_id=$user_id";
$sessuserinfo = $dbo->getRow($sqlg);
$user_id = $holder_id;
$sqlg = "select count(*) from wy_album where user_id=$user_id";
$albumcount = $dbo->getRow($sqlg);
$sqlg = "select count(*) from wy_blog where user_id=$user_id";
$blogcount = $dbo->getRow($sqlg);
//echo "<pre>";print_r($user_info);exit;
?>





<script type="text/javascript" language="javascript" src="servtools/dialog/zDialog.js"></script>
<script type='text/javascript' language="javascript">
function goLogin(){
	Dialog.confirm("<?php echo $pu_langpackage->pu_login;?>",function(){window.location="<?php echo $indexFile;?>";});
}

function mypalsAddInit(other_id)
{
	  var mypals_add=new Ajax();
	  mypals_add.getInfo("do.php","GET","app","act=add_mypals&other_id="+other_id,function(c){if(c=="success"){Dialog.alert("<?php echo $ah_langpackage->ah_friends_add_suc;?>");}else{Dialog.alert(c);}});
}
function hi_action_int(){
	<?php echo $send_hi;?>;
}

function report_action_int(){
	<?php echo $send_report;?>
}

function report_action(type_id,user_id,mod_id){
	var diag = new Dialog();
	diag.Width = 300;
	diag.Height = 150;
	diag.Top="50%";
	diag.Left="50%";
	diag.Title = "<?php echo $pu_langpackage->pu_report;?>";
	diag.InnerHtml= '<div class="report_notice"><?php echo $pu_langpackage->pu_report_info;?><?php echo $pu_langpackage->pu_report_re;?><textarea id="reason"></textarea></div>';
	diag.OKEvent = function(){act_report(type_id, user_id, mod_id);diag.close();};
	diag.show();
}

function hi_action(uid){
	var diag = new Dialog();
	diag.Width = 330;
	diag.Height = 150;
	diag.Top="50%";
	diag.Left="50%";
	diag.Title = "<?php echo $u_langpackage->u_choose_type;?>";
	diag.InnerHtml= '<?php echo hi_window();?>';
	diag.OKEvent = function(){send_hi(uid);diag.close();};
	diag.show();
}

function send_hi_callback(content){
	if(content=="success"){
		Dialog.alert("<?php echo $hi_langpackage->hi_success;?>");
	}else{
		Dialog.alert(content);
	}
}

function send_hi(uid){
	var hi_type=document.getElementsByName("hi_type");
	for(def=0;def<hi_type.length;def++){
		if(hi_type[def].checked==true){
			var hi_t=hi_type[def].value;
		}
	}
	var get_album=new Ajax();
	get_album.getInfo("do.php","get","app","act=user_add_hi&to_userid="+uid+"&hi_t="+hi_t,function(c){send_hi_callback(c);});
}
/***********添加好友***************/
function mypals_add_callback(content,other_id){
	if(content=="success"){
		Dialog.alert("<?php echo $mp_langpackage->mp_suc_add;?>");
		document.getElementById("operate_"+other_id).innerHTML="<?php echo $mp_langpackage->mp_suc_add;?>";
	}else{
		Dialog.alert(content);
		document.getElementById("operate_"+other_id).innerHTML=content;
	}
}
	/***********添加好友***************/
	function mypals_add(other_id){

	
	$.get("do.php",{act:'add_mypals',other_id:''+other_id},function(c){
		
		mypals_add_callback(c,other_id);
		
		
		});
}

/***********添加好友***************/
</script>


<div id="left_nav_lf">
    <dl id="personal_info_lq">
        <dt>
            <a id="member_header">
                <i class="christmas-adornment "></i>
                <i class="christmas-adornment"></i>
                <img class="head_img1_lq" src="<?php if($user_info['user_ico']){ echo str_replace("_small "," ",$user_info['user_ico']);}else{echo "/skin/default/jooyea/images/d_ico_".$user_info['user_sex'].".gif ";}?>" width="160" height="205" alt="<?php echo $user_info['user_name'];?>">
            </a>
        </dt>
        <dd class="first_dd_lf">
            <span class="count_lf" style=" width:70px">
                <?php echo $blogcount[0]; ?>
                <br>
                <?php echo $ah_langpackage->ah_log;?>
            </span>
            <span class="count3_lf" style=" width:70px">
                <?php echo $albumcount[0];?>
                <br>
                <?php echo $ah_langpackage->ah_album;?>
            </span>
        </dd>
        <?php if($holder_id!=$user_id0530){?>
            <dd class="add_info_lf">
                <p>
                    <span class="addfriend_icon1_lq mr5"></span>
                    <span class="text_box1_lf" onclick="window.mypals_add(<?php echo $user_id;?>);">
                        <?php echo $rf_langpackage->rf_jiahaoyou;?>
                    </span>
                </p>
                <!--<p>-->
                <!--    <span class="email_icon1_lq mr5">-->
                <!--    </span>-->
                <!--    <span class="text_box1_lf" onclick="<?php if(1){ ?> window.location.href='modules.php?app=msg_creator&2id=<?php echo $user_id;?> ';return false; <?php } else { ?> alert('<?php echo $u_langpackage->readmore; ?>');<?php } ?>">-->
                <!--        <?php echo $rf_langpackage->rf_fayoujian;?>-->
                <!--    </span>-->
                <!--</p>-->
                <p>
                    <span class="zxchat" style="margin-right: 4px;"></span>
                    <!-- <a style="font-size:12px;color:#000;" member="fuzhi" data-hito="fuzhi" onclick="window.i_im_talkWin('<?php echo $user_id;?>','imWin');">
                        <?php echo $rf_langpackage->rf_liaotian;?>
                    </a> -->
                    <a style="font-size:12px;color:#000;" member="fuzhi" data-hito="fuzhi" onclick="parent.open_chat('<?php echo $user_id;?>','<?php echo $user_info[user_name];?>','<?php echo $user_info[user_ico];?>');">
                        <?php echo $rf_langpackage->rf_liaotian;?>
                    </a>
                </p>
            </dd>
        <?php }?>
            <dd class="second_dd_lf">
                <p>
                    <?php echo $pu_langpackage->pu_levl;?>：
                    <label class="lv-num">
                        <?php echo grade($user_info[ 'integral']);?>
                    </label>
                </p>
                <p>
                    <?php echo $u_langpackage->huizhang;?>：
                    <?php if($uu[ 'user_group']==2){echo'<img src="/skin/default/jooyea/images/xin/gaoji.png" />';} if($uu[ 'user_group']==3){echo'<img src="/skin/default/jooyea/images/xin/vip.gif" />';}?>
                    <?php if($uinfo[ 'is_txrz']==1){echo '<i class="txrz_home" title="'.$u_langpackage->touxiangrenzheng.'"></i>';}?>
                </p>
            </dd>
            <dd class="third_dd_lf">
                <span class="edit_info_icon_lf">
                </span>
                <?php echo $ah_langpackage->ah_basic_info;?>
            </dd>
            <dd class="last_dd_lf">
                <p>
                    <?php echo $ah_langpackage->ah_residence;?>:
                    <?php echo $uinfo[ 'country']?$uinfo[ 'country']:$u_langpackage->u_set;?>
                </p>
                <p>
                    <?php echo $ah_langpackage->ah_birthday;?>:
                    <?php echo $user_info[ "birth_year"]&&$user_info[ "birth_month"]&&$user_info["birth_day"]?$user_info[ "birth_year"].$u_langpackage->u_year.$user_info["birth_month"].$u_langpackage->u_month.$user_info["birth_day"].$u_langpackage->u_day:$u_langpackage->u_set;?>
                </p>
            </dd>
    </dl>
    <script type="text/javascript">
        $(function() {
            //聊天--
            $('#js_chat').on('click',
            function(e) {
                var _this = $(this),
                name = _this.attr('member'),
                imgUrl = _this.attr('data-img'),
                apId = _this.attr('member'),
                chatHtml = '';
                chatHtml += '<li data-id="' + name + '" title="' + name + '" class="' + name + '">';
                chatHtml += '<img class="chat-user-pic" src="' + imgUrl + '">';
                chatHtml += '<p class="chat-user-name">' + name + '</p>';
                chatHtml += '<span class="chat-num-tran none"></span>';
                chatHtml += '<span class="chat-num-msg none"></span>';
                chatHtml += '<s class="chat-icon-offline"></s>';
                chatHtml += '</li>';
                //$('.chat-win-talkerList').prepend(chatHtml);
                var liLength = $('.chat-win-talkerList li').length;

                if (liLength >= 1) {
                    $('.chat-win-talkerList li').each(function() {
                        var liId = $(this).attr('data-id');
                        $('.chat-win-talkerList').find('.' + apId).remove();
                        $('.chat-win-talker .chat-win-talkerList').prepend(chatHtml);
                    });
                } else {
                    $('.chat-win-talker .chat-win-talkerList').prepend(chatHtml);
                }
                var talker = $('.chat-win-talker'),
                ul = $('.chat-win-talkerList'),
                liLength = $('.chat-win-talkerList li').length,
                liHeight = 43,
                ulHeight = liHeight * liLength + 60,
                talkHeight = talker.height();
                if (ulHeight >= talkHeight) {
                    $('.chat-win-talker .pre,.chat-win-talker .next').css('cursor', 'pointer');
                    //$('.chat-win-talker .pre').attr('onclick','scrollPre()');
                    //$('.chat-win-talker .next').attr('onclick','scrollNext()');
                } else {
                    $('.chat-win-talker .pre,.chat-win-talker .next').css('cursor', 'default');
                }
                $('.chat-win-talkerList li').on('click',
                function(e) {
                    var dataName = $(this).attr('data-id');
                    IM.friendsPanel.openMsgWin(dataName);
                    e.stopPropagation();
                    return false;
                });
                IM.friendsPanel.openMsgWin(name);
                e.stopPropagation();
                return false;
            });
            //聊天。。
            $("#edit_info").bind("click",
            function() {
                $('#content_index_lf').load('/Member/MyInfo/buckly427');
            });

            $("#left_nav_lf dt").bind("hover",
            function() {
                $("#left_nav_lf span.top_box1_lf").toggle();
            });
            //更改图像
            $("#left_nav_lf span.top_box1_lf").bind("click",
            function() {
                $('#content_box1_lf').load('/Member/UpdateHeader/buckly427');
            });
            //举报
            Global_report('#report_cyw');
        });
        //打招呼代码
        //    $('#left_nav_lf').on('.hi_icon1_wsf', 'click', function (e) {
        $('#left_nav_lf').on('click', '.hi_icon1_wsf',
        function(e) {
            var $this = $(this);
            if ($this.data('jqface')) return;
            var receiver = $this.data('hito');
            //发站内信打招呼
            sayHello(receiver);
            return true;

            //        var $this = $(this);
            //        if ($this.data('jqface')) return;
            //        var receiver = $this.data('hito');
            //        $this.jqface({
            //            onSelect: function (emo) {
            //                sayHello(emo, receiver);
            //                return true;
            //            }
            //        });
            //        $this.jqface('open', e, this);
        });
        //红心
        function redHeartClick(obj) {
            createRedHeart($(obj).parent().attr('member'), $(obj).next('.text_box1_lf'));
        }
        //发邮件
        function sendEmail_cyw(name) {
            //window.location.href = '/Home#/InternalLetter/List!/InternalLetter/Send?id=' + name;
            var sendLetterHtml = $(".js_letter_layer").html();
            $.icoDialog({
                skin: 'new-dialog-skin',
                initialize: function() {
                    $('.d-footer').find('.d-button:eq(0)').addClass('btn btn-ok');
                },
                type: 1,
                title: '发私信',
                //发私信
                content: sendLetterHtml,
                //提示消息
                //            okValue: '确定', //确定
                //            cancelValue: '取消', //取消
                //            ok: function () {
                //                delete_theme_list(theme_idList);
                //            },
                //            cancel: function () {
                //            },
                lock: true
            });
            $(".receiver").val(name);

        }
        function upgrade_cyw() {
            window.location.href = '/Home#/Recharge/List!/Recharge/Upgrade/buckly427';
        }
        function popGift_cyw(member) {
            $.post('/Member/IsLogon',
            function(res) {
                if (res != 'True') {
                    showlogin();
                } else {
                    var urldia = $.urlDialog({
                        initialize: function() {
                            $('.d-outer').addClass('orange');
                            $('.d-titleBar').addClass('orange');
                            $(".d-buttons").addClass("orange");
                        },
                        url: '/Gift/GiftBox?inte=' + 2,
                        title: '送礼物',
                        padding: '0',
                        okValue: '赠送',
                        ok: function() {
                            return quickPopGift.submit(urldia);
                        },
                        lock: true,
                        skin: 'gray_skin',
                        callback: function() {
                            quickPopGift.fill(member);
                        }
                    });
                }
            });
        }
        //选择礼物框
        function Global_popGift(member) {
            member = typeof member == 'string' ? member: $(member).parent().attr('member');
            var urldia = $.urlDialog({
                url: '/Gift/GiftBox',
                title: '送礼物',
                padding: '0',
                okValue: '确定',
                ok: function() {
                    return quickPopGift.submit(urldia);
                },
                cancelValue: '取消',
                cancel: function() {
                    quickPopGift.cancel();
                },
                lock: true,
                skin: 'gray_skin',
                callback: function() {
                    quickPopGift.fill(member);
                }
            });
        }
    </script>
</div>