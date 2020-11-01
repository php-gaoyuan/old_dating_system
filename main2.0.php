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
        echo "<script type='text/javascript'>alert('请上传头像');window.open('modules2.0.php?app=user_ico','user_ico','left=300,top=120');</script>";
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
$pageDir = array('user_upgrade' => 'modules2.0.php?app=user_upgrade', 'appdownload' => 'appdownload', 'msg_minbox' => 'modules2.0.php?app=msg_minbox', 'msg_rpshow' => 'modules2.0.php?' . $_SERVER['QUERY_STRING'], 'user_pay' => 'modules2.0.php?app=user_pay', 'mypals' => 'modules2.0.php?app=mypals', 'u_horn' => 'modules2.0.php?app=u_horn&active=1s', 'album' => 'modules2.0.php?app=album', 'blog_list' => 'modules2.0.php?app=blog_list', 'mood_more' => 'modules2.0.php?app=mood_more', 'share_list' => 'modules2.0.php?app=share_list&m=mine', 'gift' => 'plugins/gift/gift.php', 'giftshop' => 'plugins/gift/giftshop.php', 'gift_box' => 'plugins/gift/gift_box.php', 'gift_outbox' => 'plugins/gift/gift_outbox.php', 'mypals_invite' => 'modules2.0.php?app=mypals_invite', 'renzheng' => 'modules2.0.php?app=renzheng', 'gorenzheng' => 'modules2.0.php?app=gorenzheng', 'user_info' => 'modules2.0.php?app=user_info', 'user_ico' => 'modules2.0.php?app=user_ico', 'user_pw_change' => 'modules2.0.php?app=user_pw_change', 'user_dressup' => 'modules2.0.php?app=user_dressup', 'privacy' => 'modules2.0.php?app=privacy', 'mypals_search' => 'modules2.0.php?app=mypals_search', 'msg_creator' => 'modules2.0.php?' . $_SERVER['QUERY_STRING'], 'giftitem' => 'plugins/gift/giftitem.php?' . $_SERVER['QUERY_STRING']);
$redr = $pageDir[$_GET['app']];



$dbo=new dbex;
//连接数据库执行 
dbtarget('r',$dbServs);
$t_users=$tablePreStr. "users";
$user_id=get_sess_userid();
$user=$dbo->getRow("select * from $t_users where user_id='$user_id'");
if($user['is_pass']==0){
	echo "<script>Dialog.alert('".$l_langpackage->l_lock_u."');</script>";
	echo "<script>window.location.href = '/main2.0.php?app=user_info';</script>";
}
if(!$user['user_ico'] && !$_COOKIE['uico']){
	setcookie('uico',1,time()+60);
	//echo "<script>Dialog.alert('".$u_langpackage->u_set_ico."');</script>";
	//echo "<script>setTimeout(function() {window.location.href = '/main2.0.php?app=user_ico'},2000)</script>";
}
?>




<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="Content-Language" content="zh-cn">
		<title>
			<?php echo $user_name;?>-missinglovelove
		</title>
		<base href='<?php echo $siteDomain;?>' />

		<link rel="shortcut icon" href="favicon.ico">
        <link href="./template/main/base_icon-min.css" rel="stylesheet" type="text/css">
        <link href="./template/main/index-min.css" rel="stylesheet" type="text/css">
        <link href="./template/main/optimization-icon.css" rel="stylesheet" type="text/css">
        <link href="./template/main/jqzysns-min.css" rel="stylesheet" type="text/css">
        <link href="./template/main/something.css" rel="stylesheet" type="text/css">
        <link href="./template/main/themes.css" rel="stylesheet" type="text/css">
        <link charset="utf-8" rel="stylesheet" href="./template/base.css?v=1.0.0">
        <link href="./template/main/gifttwo.css" rel="stylesheet" type="text/css">

        <script src="./template/main/jquery-1.7.min.js" type="text/javascript"></script>
		<script src="servtools/dialog/zDialog.js" type="text/javascript"></script>
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
							<td class="d-c">
								<div class="d-inner">
									<table class="d-dialog">
										<tbody>
											<tr>
												<td class="d-header">
													<div class="d-titleBar">
														<div class="d-title"></div>
														<a class="d-close">×</a></div>
												</td>
											</tr>
											<tr>
												<td class="d-main" style="width: auto; height: auto;">
													<div class="d-content" style="padding: 0px 15px;"></div>
												</td>
											</tr>
											<tr>
												<td class="d-footer">
													<div class="d-buttons" style="display: none;"></div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</td>
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
							<td class="d-c">
								<div class="d-inner">
									<table class="d-dialog">
										<tbody>
											<tr>
												<td class="d-header">
													<div class="d-titleBar">
														<div class="d-title"></div>
														<a class="d-close">×</a></div>
												</td>
											</tr>
											<tr>
												<td class="d-main" style="width: auto; height: auto;">
													<div class="d-content" style="padding: 0px 15px;"></div>
												</td>
											</tr>
											<tr>
												<td class="d-footer">
													<div class="d-buttons" style="display: none;"></div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</td>
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
            <div class="texttb_jqface">
                <a class="default_face">
                    表情
                </a>
                <a class="close_jqface" title="close">
                    ×
                </a>
            </div>
            <div class="facebox_jqface mCustomScrollbar _mCS_1 _mCS_2 mCS_no_scrollbar" style="  height:300px">
                <div id="mCSB_1_container" class="mCSB_container" style="position: relative; top: 0px; left: 0px; "
                dir="ltr">
                    <div class="js_face_bg" style="background-image: url(./template/main/b0.png); width: 436px; height: 249px; z-index: 1; margin-left: 10px; background-position: initial initial; background-repeat: no-repeat no-repeat;">
                    </div>
                    <div class="faceContent-list js_faceContentList">
                        <a 1="[微笑]"2="[微笑]"></a><a 1="[撇嘴]"2="[撇嘴]"></a><a 1="[色]"2="[色]"></a><a 1="[发呆]"2="[发呆]"></a><a 1="[得意]"2="[得意]"></a><a 1="[流泪]"2="[流泪]"></a><a 1="[害羞]"2="[害羞]"></a><a 1="[闭嘴]"2="[闭嘴]"></a><a 1="[睡]"2="[睡]"></a><a 1="[大哭]"2="[大哭]"></a><a 1="[尴尬]"2="[尴尬]"></a><a 1="[发怒]"2="[发怒]"></a><a 1="[调皮]"2="[调皮]"></a><a 1="[龇牙]"2="[龇牙]"></a><a 1="[惊讶]"2="[惊讶]"></a><a 1="[难过]"2="[难过]"></a><a 1="[酷]"2="[酷]"></a><a 1="[冷汗]"2="[冷汗]"></a><a 1="[抓狂]"2="[抓狂]"></a><a 1="[吐]"2="[吐]"></a><a 1="[偷笑]"2="[偷笑]"></a><a 1="[可爱]"2="[可爱]"></a><a 1="[白眼]"2="[白眼]"></a><a 1="[傲慢]"2="[傲慢]"></a><a 1="[饥饿]"2="[饥饿]"></a><a 1="[困]"2="[困]"></a><a 1="[惊恐]"2="[惊恐]"></a><a 1="[流汗]"2="[流汗]"></a><a 1="[憨笑]"2="[憨笑]"></a><a 1="[大兵]"2="[大兵]"></a><a 1="[奋斗]"2="[奋斗]"></a><a 1="[咒骂]"2="[咒骂]"></a><a 1="[疑问]"2="[疑问]"></a><a 1="[嘘]"2="[嘘]"></a><a 1="[晕]"2="[晕]"></a><a 1="[折磨]"2="[折磨]"></a><a 1="[衰]"2="[衰]"></a><a 1="[骷髅]"2="[骷髅]"></a><a 1="[敲打]"2="[敲打]"></a><a 1="[再见]"2="[再见]"></a><a 1="[擦汗]"2="[擦汗]"></a><a 1="[抠鼻]"2="[抠鼻]"></a><a 1="[鼓掌]"2="[鼓掌]"></a><a 1="[糗大了]"2="[糗大了]"></a><a 1="[坏笑]"2="[坏笑]"></a><a 1="[左哼哼]"2="[左哼哼]"></a><a 1="[右哼哼]"2="[右哼哼]"></a><a 1="[哈欠]"2="[哈欠]"></a><a 1="[鄙视]"2="[鄙视]"></a><a 1="[委屈]"2="[委屈]"></a><a 1="[快哭了]"2="[快哭了]"></a><a 1="[阴险]"2="[阴险]"></a><a 1="[亲亲]"2="[亲亲]"></a><a 1="[吓]"2="[吓]"></a><a 1="[可怜]"2="[可怜]"></a><a 1="[菜刀]"2="[菜刀]"></a><a 1="[西瓜]"2="[西瓜]"></a><a 1="[啤酒]"2="[啤酒]"></a><a 1="[篮球]"2="[篮球]"></a><a 1="[乒乓]"2="[乒乓]"></a><a 1="[咖啡]"2="[咖啡]"></a><a 1="[饭]"2="[饭]"></a><a 1="[猪头]"2="[猪头]"></a><a 1="[玫瑰]"2="[玫瑰]"></a><a 1="[凋谢]"2="[凋谢]"></a><a 1="[示爱]"2="[示爱]"></a><a 1="[爱心]"2="[爱心]"></a><a 1="[心碎]"2="[心碎]"></a><a 1="[蛋糕]"2="[蛋糕]"></a><a 1="[闪电]"2="[闪电]"></a><a 1="[炸弹]"2="[炸弹]"></a><a 1="[刀]"2="[刀]"></a><a 1="[足球]"2="[足球]"></a><a 1="[瓢虫]"2="[瓢虫]"></a><a 1="[屎]"2="[屎]"></a><a 1="[月亮]"2="[月亮]"></a><a 1="[太阳]"2="[太阳]"></a><a 1="[礼物]"2="[礼物]"></a><a 1="[抱抱]"2="[抱抱]"></a><a 1="[强]"2="[强]"></a><a 1="[弱]"2="[弱]"></a><a 1="[握手]"2="[握手]"></a><a 1="[胜利]"2="[胜利]"></a><a 1="[抱拳]"2="[抱拳]"></a><a 1="[勾引]"2="[勾引]"></a><a 1="[拳头]"2="[拳头]"></a><a 1="[差劲]"2="[差劲]"></a><a 1="[爱你]"2="[爱你]"></a><a 1="[3]"2="[3]"></a><a 1="[4]"2="[4]"></a><a 1="[爱情]"2="[爱情]"></a><a 1="[飞吻]"2="[飞吻]"></a><a 1="[跳跳]"2="[跳跳]"></a><a 1="[发抖]"2="[发抖]"></a><a 1="[怄火]"2="[怄火]"></a><a 1="[转圈]"2="[转圈]"></a><a 1="[磕头]"2="[磕头]"></a><a 1="[回头]"2="[回头]"></a><a 1="[跳绳]"2="[跳绳]"></a><a 1="[挥手]"2="[挥手]"></a><a 1="[激动]"2="[激动]"></a><a 1="[街舞]"2="[街舞]"></a><a 1="[献吻]"2="[献吻]"></a><a 1="[左太极]"2="[左太极]"></a><a 1="[右太极]"2="[右太极]"></a>
                    </div>
                </div>
            </div>
            <div class="arrow_t">
            </div>
        </div>
        <!---表情-->

		<!--头部-->
		<?php require( "uiparts2.0/mainheader.php");?>
		<!--头部-->

		<div id="container_lq" class="container">
			<?php require( "uiparts2.0/mainleft.php");?>

			<div id="content_box1_lq" style="margin-bottom: 60px;width:830px;">
			<?php if($redr=='appdownload' ){ ?>
				<div style=" padding-top:50px"><img src="./template/app.png" /></div>
			<?php }else{ ?>
				<iframe src="<?php echo $redr;?>" style="min-height:1000px;height:100%;width:100%;border:0;"  scrolling=NO id="ifr"></iframe>
			<?php } ?>
			</div>

			<br class="clear_lq"></div>
			<?php require( "uiparts2.0/footor.php");?>
		</div>
		<script>
			$('#ifr').load(function() { //方法2
			    var iframeHeight=$(this).contents().height();
			    $(this).height(iframeHeight+'px');
			});
		</script>
	</body>
</html>