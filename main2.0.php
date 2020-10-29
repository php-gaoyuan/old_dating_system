<?php
header("content-type:text/html;charset=utf-8");
require ("foundation/asession.php");
require ("configuration.php");
require ("includes.php");
//必须登录才能浏览该页面
require ("foundation/auser_mustlogin.php");
require ("foundation/module_users.php");
require ("foundation/fplugin.php");
require ("api/base_support.php");
require ("foundation/fdnurl_aget.php");
require ("foundation/fgrade.php");
//语言包引入
$u_langpackage = new userslp;
$ef_langpackage = new event_frontlp;
$mn_langpackage = new menulp;
$pu_langpackage = new publiclp;
$mp_langpackage = new mypalslp;
$s_langpackage = new sharelp;
$hi_langpackage = new hilp;
$l_langpackage = new loginlp;
$rp_langpackage = new reportlp;
$ah_langpackage = new arrayhomelp;
$rm_langpackage = new readmorelp;
$dbo = new dbex; //连接数据库执行
dbtarget('r', $dbServs);
$user_id = get_sess_userid(); //删除之后客户机获取缓存中的id，
$sqlg = "select * from wy_users where user_id=$user_id";
$userinfo = $dbo->getRow($sqlg);
$sql = "select * from wy_users where user_id=$user_id"; //与服务器进行比较
$isNull = $dbo->getRow($sql);
$user_name = get_sess_username();
$user_info = api_proxy("user_self_by_uid", "guest_num,user_ico,integral,onlinetimecount", $user_id);
/*
if(empty($user_info)){
	 echo "<script type='text/javascript'>alert('{$pu_langpackage->pu_lockdel}');location.href='do.php?act=logout';</script>";
}
*/
//男性  删除
if (empty($isNull)) {
    echo "<script type='text/javascript'>alert('I\'m Sorry,Your account is delete by Root.Please do not do hacked work.[你的账号被删除了！] You can send email to service@lovelove.com ask for why.');location.href='do.php?act=logout';</script>";
    echo "<script>top.Dialog.alert('" . $l_langpackage->l_lock_u . "');</script>";
    echo "违反规定，删除账号";
    setcookie("IsReged", '');
    session_regenerate_id();
    session_destroy();
    echo '<script language=javascript>top.location="/";</script>';
}
$rf_langpackage = new recaffairlp;
/*
    $user_ico=end(explode('/',$user_info['user_ico']));
    if($user_ico=='d_ico_0_small.gif'||$user_ico=='d_ico_1_small.gif'){
        echo "<script type='text/javascript'>alert('请上传头像');window.open('modules.php?app=user_ico','user_ico','left=300,top=120');</script>";
      	exit;
    }
*/
//照片数量
$sql = "select photo_num from wy_album where user_id=$user_id";
$p_num = $dbo->getRow($sql);
$photo_num = $p_num['photo_num'];
//金币邮票个数
$sqlg = "select golds,stamps_num from wy_users where user_id=$user_id";
$golds = $dbo->getRow($sqlg);
$golds_num = $golds['golds'];
$stamps_num = $golds['stamps_num'];
//获取用户自定义属性列表
//$information_rs=array();
//$information_rs=userInformationGetList($dbo,'*');
//好友速配推荐
//$friends_list=$dbo->getRs("select user_id,user_name,user_ico from wy_users order by rand() limit 0,12");
//获取推荐群组
$group_recommend_list = $dbo->getRs("select * from wy_groups where recommed_time is not null order by recommed_time desc limit 6");
//读取幻灯片
$sql = "select * from wy_hd where cat_id=4 order by ord desc , id desc limit 5";
$xhd_list = $dbo->getRs($sql);
//用户资料
$sql = "select user_sex,is_txrz from wy_users where user_id='$user_id' ";
$u_sex_txrz = $dbo->getRow($sql);
$pageDir = array('cash' => 'modules2.0.php?app=cash', 'user_upgrade' => 'modules2.0.php?app=user_upgrade', 'appdownload' => 'appdownload', 'msg_minbox' => 'modules2.0.php?app=msg_minbox', 'msg_rpshow' => 'modules2.0.php?' . $_SERVER['QUERY_STRING'], 'user_pay' => 'modules2.0.php?app=user_pay', 'mypals' => 'modules2.0.php?app=mypals', 'u_horn' => 'modules2.0.php?app=u_horn&active=1s', 'album' => 'modules2.0.php?app=album', 'blog_list' => 'modules2.0.php?app=blog_list', 'mood_more' => 'modules2.0.php?app=mood_more', 'share_list' => 'modules.php?app=share_list&m=mine', 'gift' => 'plugins/gift/gift.php', 'giftshop' => 'plugins/gift/giftshop.php', 'mypals_invite' => 'modules2.0.php?app=mypals_invite', 'renzheng' => 'modules2.0.php?app=renzheng', 'gorenzheng' => 'modules2.0.php?app=gorenzheng', 'user_info' => 'modules2.0.php?app=user_info', 'user_ico' => 'modules2.0.php?app=user_ico', 'user_pw_change' => 'modules2.0.php?app=user_pw_change', 'user_dressup' => 'modules2.0.php?app=user_dressup', 'privacy' => 'modules2.0.php?app=privacy', 'mypals_search' => 'modules2.0.php?app=mypals_search', 'msg_creator' => 'modules2.0.php?' . $_SERVER['QUERY_STRING'], 'giftitem' => 'plugins/gift/giftitem.php?' . $_SERVER['QUERY_STRING']);
$redr = $pageDir[$_GET['app']];
?>








<!DOCTYPE html>
<html xmlns:ng="http://angularjs.org">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Language" content="zh-cn">
<title><?php echo $user_name;?>的个人首页-<?php echo $siteName;?></title>
<style type="text/css">
#swf1 {
	position: fixed;
	top: 10px;
	left: 320px;
	z-index: 10000;
}
</style>
<link rel="shortcut icon" href="favicon.png">
<link href="./template/main/base_icon-min.css" rel="stylesheet" type="text/css">
<link href="./template/main/index-min.css" rel="stylesheet" type="text/css">
<link href="./template/main/jqzysns-min.css" rel="stylesheet" type="text/css">
<link href="./template/main/email_gift_recharge_lq-min.css" rel="stylesheet" type="text/css">
<link href="./template/main/photo_user_vote_sun-min.css" rel="stylesheet" type="text/css">
<link href="./template/main/blog_group_invit_lf-min.css" rel="stylesheet" type="text/css">
<link href="./template/main/friends_visit_other_lf-min.css" rel="stylesheet" type="text/css">
<link href="./template/main/flower.css" rel="stylesheet" type="text/css">
<link href="./template/main/list.css" rel="stylesheet" type="text/css">
<link href="./template/main/optimization-icon.css" rel="stylesheet" type="text/css">
<link href="./template/main/online-member.css" rel="stylesheet" type="text/css">
<link href="./template/main/christmas2014.css" rel="stylesheet" type="text/css">
<link href="./template/main/discounts.css" rel="stylesheet" type="text/css">
<link href="./template/main/widgets.css" rel="stylesheet" type="text/css">
<link href="./template/main/private-letter.css" rel="stylesheet" type="text/css">
<link href="./template/main/online-updater.css" rel="stylesheet" type="text/css">
<link href="./template/main/upgrade.css" rel="stylesheet" type="text/css">
<link href="./template/main/giftone.css" rel="stylesheet" type="text/css">
<link href="./template/main/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="./template/main/headUpload.css" type="text/css">

<link href="./template/main/something.css" rel="stylesheet" type="text/css">
<link href="./template/main/gifttwo.css" rel="stylesheet" type="text/css">


<script src="./template/main/jquery-1.7.min.js" type="text/javascript"></script>
<script type=" text/javascript">
    /****************提交心情******************/

    function trim(str) {
        return str.replace(/(^\s*)|(\s*$)|(　*)/g, "");
    }

    function submit_new_mood() {
        var fanyi_tp = $('#fanyifs').val(); //翻译类型
        //var mood_r_pic=$('#mood_real_pic').val();//心情图片
        //
        var mood_r_pic = ''; //心情图片
        var last_mood_div = $("the_last_mood");
        var mood_text = trim($("#mood_txt").val());
        var need = 0;

        need = len(mood_text) / 100;
        if (need < 1) need = 1;
        if (mood_text == '<?php echo $rf_langpackage->rf_placeholder_text;?>') {
            return false
        }
        if (fanyi_tp) {
            if (mood_text == '') {
                return false;
            }
            top.Dialog.confirm('<?php echo $u_langpackage->fy_tishi2;?>' + need,
            function() {
                $.get("fanyi.php", {
                    lan: mood_text,
                    tos: fanyi_tp,
                    ne: need
                },
                function(ca) {

                    if (ca == 0 || !ca) {
                        parent.Dialog.alert("<?php echo $u_langpackage->fy_tishi1;?>");
                        return false;
                    }

                    $.post("do.php?act=mood_add&ajax=1", {
                        mood: ca,
                        mood_r_pic: mood_r_pic
                    },
                    function(d) {

                        //last_mood_div.innerHTML='';
                        if (d) {
                            $("#mood_txt").value = "";

                        }
                        //$('add_mood').click();
                    });
                });
            })

        } else {
            if (mood_text == '') {
                return false;
            } else {
                last_mood_div.innerHTML = '<?php echo $u_langpackage->u_data_post;?>';

                $.post("do.php?act=mood_add&ajax=1", {
                    mood: mood_text,
                    mood_r_pic: mood_r_pic
                },
                function(c) {
                    $("#mood_txt").val('<?php echo $rf_langpackage->rf_placeholder_text;?>');
                    parent.Dialog.alert('<?php echo $u_langpackage->u_sent_successfully?>');
                    //$('add_mood').onclick();
                });
            }
        }

    }
    /****************提交心情******************/
    function mypals_add_callback(content, other_id) {
        if (content == "success") {
            parent.Dialog.alert("<?php echo $mp_langpackage->mp_suc_add;?>");
            document.getElementById("operate_" + other_id).innerHTML = "<?php echo $mp_langpackage->mp_suc_add;?>";
        } else {
            parent.Dialog.alert(content);
            document.getElementById("operate_" + other_id).innerHTML = content;
        }
    }
    /***********添加好友***************/
    function mypals_add(other_id) {

        $.get("do.php", {
            act: 'add_mypals',
            other_id: '' + other_id
        },
        function(c) {

            mypals_add_callback(c, other_id);

        });
    }
    /***********添加好友*********************/
    
</script>
<style>
/*左侧导航标题*/
#app_nav1_lq .li-title{overflow: visible;position: relative;padding: 0;width: 100%;padding-left: 10px;}
#app_nav1_lq .li-title .li-title-label{position: absolute;background: #fff;z-index: 5;padding-right: 8px;}
#app_nav1_lq .li-title:before{position: absolute;top: 12px;content: '';height: 1px;width: 100%;background: #d9d9d9;overflow: hidden;}
#app_nav1_lq .li-title:hover{background: transparent;}
#app_nav1_lq .li-title i{position: absolute;top: -28px;left: 145px;cursor: pointer;}
#left_nav_lq #app_nav1_lq li a{margin-left: 8px;font-size: 12px;font-weight: 500;font-family: 'Microsoft YaHei';}
</style>

<link href="./template/main/themes.css" rel="stylesheet" type="text/css">
<link charset="utf-8" rel="stylesheet" href="./template/base.css?v=1.0.0">

</head>
<body class="lan_cn">
<div class="" style="left: 0px; top: 0px; position: fixed; visibility: hidden;">
  <div class="d-outer">
    <table class="d-border">
      <tbody>
        <tr class="d-firstRow">
          <td class="d-nw"></td>
          <td class="d-n"></td>
          <td class="d-ne"></td>
        </tr>
        <tr>
          <td class="d-w"></td>
          <td class="d-c"><div class="d-inner">
              <table class="d-dialog">
                <tbody>
                  <tr>
                    <td class="d-header"><div class="d-titleBar">
                        <div class="d-title"></div>
                        <a class="d-close">×</a></div></td>
                  </tr>
                  <tr>
                    <td class="d-main" style="width: auto; height: auto;"><div class="d-content" style="padding: 0px 15px;"></div></td>
                  </tr>
                  <tr>
                    <td class="d-footer"><div class="d-buttons" style="display: none;"></div></td>
                  </tr>
                </tbody>
              </table>
            </div></td>
          <td class="d-e"></td>
        </tr>
        <tr>
          <td class="d-sw"></td>
          <td class="d-s"></td>
          <td class="d-se"></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="" style="left: 0px; top: 0px; position: fixed; visibility: hidden;">
  <div class="d-outer">
    <table class="d-border">
      <tbody>
        <tr class="d-firstRow">
          <td class="d-nw"></td>
          <td class="d-n"></td>
          <td class="d-ne"></td>
        </tr>
        <tr>
          <td class="d-w"></td>
          <td class="d-c"><div class="d-inner">
              <table class="d-dialog">
                <tbody>
                  <tr>
                    <td class="d-header"><div class="d-titleBar">
                        <div class="d-title"></div>
                        <a class="d-close">×</a></div></td>
                  </tr>
                  <tr>
                    <td class="d-main" style="width: auto; height: auto;"><div class="d-content" style="padding: 0px 15px;"></div></td>
                  </tr>
                  <tr>
                    <td class="d-footer"><div class="d-buttons" style="display: none;"></div></td>
                  </tr>
                </tbody>
              </table>
            </div></td>
          <td class="d-e"></td>
        </tr>
        <tr>
          <td class="d-sw"></td>
          <td class="d-s"></td>
          <td class="d-se"></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<!---表情-->
<div id="face_jqface" class="" style=" z-index:10000;  height:300px; overflow:hidden; border:1px solid #ccc; display:none">
	<div class="texttb_jqface"><a class="default_face">表情</a><a class="close_jqface" title="close">×</a></div>
	<div class="facebox_jqface mCustomScrollbar _mCS_1 _mCS_2 mCS_no_scrollbar" style="  height:300px">
		<div id="mCSB_1_container" class="mCSB_container" style="position: relative; top: 0px; left: 0px; " dir="ltr">
			<div class="js_face_bg" style="background-image: url(./template/main/b0.png); width: 436px; height: 249px; z-index: 1; margin-left: 10px; background-position: initial initial; background-repeat: no-repeat no-repeat;"></div>
            <div class="faceContent-list js_faceContentList" ><a title="[微笑]" alt="[微笑]"></a><a title="[撇嘴]" alt="[撇嘴]"></a><a title="[色]" alt="[色]"></a><a title="[发呆]" alt="[发呆]"></a><a title="[得意]" alt="[得意]"></a><a title="[流泪]" alt="[流泪]"></a><a title="[害羞]" alt="[害羞]"></a><a title="[闭嘴]" alt="[闭嘴]"></a><a title="[睡]" alt="[睡]"></a><a title="[大哭]" alt="[大哭]"></a><a title="[尴尬]" alt="[尴尬]"></a><a title="[发怒]" alt="[发怒]"></a><a title="[调皮]" alt="[调皮]"></a><a title="[龇牙]" alt="[龇牙]"></a><a title="[惊讶]" alt="[惊讶]"></a><a title="[难过]" alt="[难过]"></a><a title="[酷]" alt="[酷]"></a><a title="[冷汗]" alt="[冷汗]"></a><a title="[抓狂]" alt="[抓狂]"></a><a title="[吐]" alt="[吐]"></a><a title="[偷笑]" alt="[偷笑]"></a><a title="[可爱]" alt="[可爱]"></a><a title="[白眼]" alt="[白眼]"></a><a title="[傲慢]" alt="[傲慢]"></a><a title="[饥饿]" alt="[饥饿]"></a><a title="[困]" alt="[困]"></a><a title="[惊恐]" alt="[惊恐]"></a><a title="[流汗]" alt="[流汗]"></a><a title="[憨笑]" alt="[憨笑]"></a><a title="[大兵]" alt="[大兵]"></a><a title="[奋斗]" alt="[奋斗]"></a><a title="[咒骂]" alt="[咒骂]"></a><a title="[疑问]" alt="[疑问]"></a><a title="[嘘]" alt="[嘘]"></a><a title="[晕]" alt="[晕]"></a><a title="[折磨]" alt="[折磨]"></a><a title="[衰]" alt="[衰]"></a><a title="[骷髅]" alt="[骷髅]"></a><a title="[敲打]" alt="[敲打]"></a><a title="[再见]" alt="[再见]"></a><a title="[擦汗]" alt="[擦汗]"></a><a title="[抠鼻]" alt="[抠鼻]"></a><a title="[鼓掌]" alt="[鼓掌]"></a><a title="[糗大了]" alt="[糗大了]"></a><a title="[坏笑]" alt="[坏笑]"></a><a title="[左哼哼]" alt="[左哼哼]"></a><a title="[右哼哼]" alt="[右哼哼]"></a><a title="[哈欠]" alt="[哈欠]"></a><a title="[鄙视]" alt="[鄙视]"></a><a title="[委屈]" alt="[委屈]"></a><a title="[快哭了]" alt="[快哭了]"></a><a title="[阴险]" alt="[阴险]"></a><a title="[亲亲]" alt="[亲亲]"></a><a title="[吓]" alt="[吓]"></a><a title="[可怜]" alt="[可怜]"></a><a title="[菜刀]" alt="[菜刀]"></a><a title="[西瓜]" alt="[西瓜]"></a><a title="[啤酒]" alt="[啤酒]"></a><a title="[篮球]" alt="[篮球]"></a><a title="[乒乓]" alt="[乒乓]"></a><a title="[咖啡]" alt="[咖啡]"></a><a title="[饭]" alt="[饭]"></a><a title="[猪头]" alt="[猪头]"></a><a title="[玫瑰]" alt="[玫瑰]"></a><a title="[凋谢]" alt="[凋谢]"></a><a title="[示爱]" alt="[示爱]"></a><a title="[爱心]" alt="[爱心]"></a><a title="[心碎]" alt="[心碎]"></a><a title="[蛋糕]" alt="[蛋糕]"></a><a title="[闪电]" alt="[闪电]"></a><a title="[炸弹]" alt="[炸弹]"></a><a title="[刀]" alt="[刀]"></a><a title="[足球]" alt="[足球]"></a><a title="[瓢虫]" alt="[瓢虫]"></a><a title="[屎]" alt="[屎]"></a><a title="[月亮]" alt="[月亮]"></a><a title="[太阳]" alt="[太阳]"></a><a title="[礼物]" alt="[礼物]"></a><a title="[抱抱]" alt="[抱抱]"></a><a title="[强]" alt="[强]"></a><a title="[弱]" alt="[弱]"></a><a title="[握手]" alt="[握手]"></a><a title="[胜利]" alt="[胜利]"></a><a title="[抱拳]" alt="[抱拳]"></a><a title="[勾引]" alt="[勾引]"></a><a title="[拳头]" alt="[拳头]"></a><a title="[差劲]" alt="[差劲]"></a><a title="[爱你]" alt="[爱你]"></a><a title="[NO]" alt="[NO]"></a><a title="[OK]" alt="[OK]"></a><a title="[爱情]" alt="[爱情]"></a><a title="[飞吻]" alt="[飞吻]"></a><a title="[跳跳]" alt="[跳跳]"></a><a title="[发抖]" alt="[发抖]"></a><a title="[怄火]" alt="[怄火]"></a><a title="[转圈]" alt="[转圈]"></a><a title="[磕头]" alt="[磕头]"></a><a title="[回头]" alt="[回头]"></a><a title="[跳绳]" alt="[跳绳]"></a><a title="[挥手]" alt="[挥手]"></a><a title="[激动]" alt="[激动]"></a><a title="[街舞]" alt="[街舞]"></a><a title="[献吻]" alt="[献吻]"></a><a title="[左太极]" alt="[左太极]"></a><a title="[右太极]" alt="[右太极]"></a></div>
        </div>
    </div>
    <div class="arrow_t"></div>
</div>
<!---表情-->

<!--头部-->
<?php require("uiparts2.0/mainheader.php");?>
<!--头部-->


<script src="./template/main/online-member.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDialog.js"></script>



<?php

if($_GET['app']!='user_info'&&$_GET['app']!='user_ico'){

$dbo = new dbex;	//连接数据库执行

dbtarget('r',$dbServs);

$t_users=$tablePreStr."users";
	$user_id=get_sess_userid();
	$user=$dbo->getRow("select * from $t_users where user_id='$user_id'");

	if($user['is_pass']==0){
		echo "<script>Dialog.alert('".$l_langpackage->l_lock_u."');</script>";
		echo "<script>window.location.href='/main2.0.php?app=user_info';</script>";
	}
	if(!$user['user_ico'] && !$_COOKIE['uico']){
		setcookie('uico',1,time()+60);
		//echo "<script>Dialog.alert('".$u_langpackage->u_set_ico."');</script>";
		//echo "<script>setTimeout(function(){window.location.href='/main2.0.php?app=user_ico'},2000)</script>";
	}

}
?>


		<script type="text/javascript">
		    $(function() {

		        function insertFace(name, id, target) {

		            //当前用户可输入字符小于7时，则不允许插入表情
		            if (document.getElementById('mood_txt')) {
		                var ta_num_status = document.getElementById('mood_txt').value.length;
		                if (ta_num_status > 293) {
		                    Dialog.alert("很抱歉，您的状态剩余可输入字数不足以插入表情了。");
		                    return;
		                }
		            }

		            $("#" + target).focus();
		            var faceText = '[em_' + id + ']';
		            if ($("#" + target) != null) {
		                $("#" + target).val($("#" + target).val() + faceText);
		            }
		        }

		        $(".js_faceContentList a").on("click",
		        function() {

		            //alert($(this).attr('alt'));
		            //alert($(this).index());
		            insertFace('', $(this).index(), 'mood_txt');

		        });

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
		        function(e) {

		            //alert('aaa');
		            var obj = $(this).closest("#msgbox");
		            // $(this).addClass("msgboxhover").find("div.downlist").show(); 
		            obj.find("div.downlist").show();
		            var e = e || window.event;
		            e.stopPropagation();
		            $('body').on("click",
		            function(e) {
		                var e = e || window.event;
		                $("div.downlist").hide();
		                e.stopPropagation();
		            });
		        });

		        $('#msglist').on("mouseleave",
		        function(e) {
		            var e = e || window.event;
		            $("div.downlist").hide();
		            e.stopPropagation();
		        });

		        /*********/
		        //最大字符量限制
		        function isMaxLen(o) {
		            var nMaxLen = 300;
		            if (o.getAttribute && o.value.length > nMaxLen) {
		                o.value = o.value.substring(0, nMaxLen)
		            }
		            var less_len = document.getElementById('less_txt');
		            $(".js_char_count1_lq").html(300 - o.value.length);
		            //less_len.innerHTML=300-o.value.length;

		        }

		        /******************/

		        //************返回顶部
		        $(window).bind('scroll',
		        function() {
		            var w_scrollTop = $(window).scrollTop();
		            if (w_scrollTop > 150) {
		                $("#gotop").fadeIn(600);
		            } else if (w_scrollTop < 200) {
		                $("#gotop").fadeOut(600);
		            }
		        });
		        $("#gotop").click(function() {
		            $("html,body").animate({
		                scrollTop: 0
		            },
		            400);
		            return false;
		        });

		        /*****心情**********/

		        $('.mood_text1_lq').focus(function() {

		            if ($(this).val() == $(this).attr('title')) $(this).val('');

		        }).blur(function() {

		            if (!$(this).val()) $(this).val($(this).attr('title'));

		        }).bind("keyup",
		        function(e) {

		            return isMaxLen(this);

		        });

		        /*****心情**********/

		        /*聊天面板下拉*/

		        $(".chat-tree-parent").toggle(

		        function() {
		            $(this).removeClass('hide');

		            $(this).siblings().removeClass('none');

		        },

		        function() {

		            $(this).addClass('hide');
		            $(this).siblings().addClass('none');

		        }

		        );

		        /*****聊天面板下拉*************8/
			
			/*****语言选择菜单******************/
		        $(".js_select_top").on('click', 'label',
		        function(e) {

		            $("#face_jqface").hide();
		            $(this).closest(".js_select_top").find("ul,.triggle-top").toggle();
		            $("#face_jqface").addClass("hidden1_lq");

		            e.stopPropagation();

		        });

		        //模拟select--正常
		        $(".js_select_top ul").on('click', 'li',
		        function(e) {
		            var selected = $(this).text();
		            var value = $(this).attr("langs-lang");
		            $(this).closest(".js_select_top").find("span").text(selected).attr("data-lang", value);
		            $(this).closest(".js_select_top").find("input").val(value);
		            $("#LetterLang").val($(this).attr("langs-lang")); //私信选择翻译语言
		            if ($("#LetterLang").val() != "no") { //私信是否翻译
		                $("#IsTrans").val("yes");
		            } else if ($("#LetterLang").val() == "no") {
		                $("#IsTrans").val("no");
		            }
		            $(".js_select_top ul,.triggle-top").hide();
		            // e.preventDefault(); 
		        });
		        $(".faces_icon1_lq").on("click",
		        function() {
		            $(".js_select_top ul").hide();

		        });

		        /*****语言选择菜单****************/

		        $(document).on("click",
		        function() {
		            $('.js_select_top ul,.triggle-top').hide();
		            $("#face_jqface").hide();

		        });

		        $(".mood-face").on("click",
		        function(e) {

		            var _top = $(this).offset().top;
		            var _left = $(this).offset().left;

		            $("#face_jqface").toggle();

		            $("#face_jqface").css({
		                'top': _top + 20 + 'px',
		                'left': _left + 20 + 'px'
		            });
		            e.stopPropagation();
		            return false;

		        });

		        $(".close_jqface").on("click",
		        function() {

		            $("#face_jqface").hide();

		        });

		    });
		</script>



		<div id="container_lq" class="container">

			<!--左列表-->
			<?php require("uiparts2.0/mainleft.php");?>
			<!--左列表-->

			<!---右边-->
			<div id="content_box1_lq" style="margin-bottom: 60px;">
				<?php if($redr=='appdownload'){?>
				<div style=" padding-top:50px">
					<img src="./template/app.png"   />
				</div>
				<?php }else{?>
					<iframe src="<?php echo $redr;?>" width="100%;" style="min-height:700px;" height="100%" FRAMEBORDER=0 SCROLLING=NO  id="ifr"></iframe>
				<?php }?>
			</div>
			<!---右边-->

			<br class="clear_lq">
		</div>

		<style type="text/css">
		    .mr5{margin-right: 5px;}
		</style>
		<?php require("uiparts2.0/footor.php");?>



		<!--<div id="gotop" style="display: block;width: 28px;height: 28px;cursor: pointer;position: fixed;right: 60px;bottom: 0px;z-index: 9999;background: url(skin/default/jooyea/images/back_top.gif) no-repeat;_background: url(skin/default/jooyea/images/back_top.gif) no-repeat;top: auto;s" onclick="pageScroll();" title="TOP"></div>
		<script type="text/javascript">
		    $(function() {

		        $(window).bind('scroll',
		        function() {
		            var w_scrollTop = $(window).scrollTop();
		            if (w_scrollTop > 150) {
		                $("#gotop").fadeIn(600);
		            } else if (w_scrollTop < 200) {
		                $("#gotop").fadeOut(600);
		            }
		        });
		        $("#gotop").click(function() {
		            $("html,body").animate({
		                scrollTop: 0
		            },
		            400);
		            return false;
		        });

		    })
		</script>-->
	</body>

</html>