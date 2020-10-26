<?php
//打开get和post的封装
$getpost_power=true;
//打开系统库的支持
$iweb_power=true;
//打开session
$session_power=true;
//引入系统文件的支持文件
include_once("../includes.php");
//引入自己的配制文件
include_once("config.php");
include_once("../../includes.php");
//引入语言包
$er_langpackage=new rechargelp;
$gf_langpackage=new giftlp;
//取得变量区
$uname=get_args("uname");
$accept_name=get_args("accept");
//$accept_id=get_args("accept_id");
//$accept_id=empty($accept_id)?get_args("uid"):$accept_id;
$gift=get_args("gift_img");
if(empty($uname)){
	$friends=Api_Proxy("pals_self_by_paid","pals_name,pals_id,pals_ico");
}
//创建系统对数据库进行操作的对象
$dbo=new dbex();
//对数据进行读写分离，读操作
dbplugin('r');
//查询对应的礼品
$sql="select id,giftname,money,yuanpatch from gift_shop where typeid=4 and valentine=1 order by ordersum desc,id desc";
$arr1=$dbo->getAll($sql);
$sql="select id,giftname,money,yuanpatch from gift_shop where typeid=4 and valentine=2 order by ordersum desc,id desc";
$arr2=$dbo->getAll($sql);
$sql="select id,giftname,money,yuanpatch from gift_shop where typeid=4 and valentine=3 order by ordersum desc,id desc";
$arr3=$dbo->getAll($sql);
$sql="select id,giftname,money,yuanpatch from gift_shop where typeid=4 and valentine=4 order by ordersum desc,id desc";
$arr4=$dbo->getAll($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" language="javascript" src="/plugins/gift/Common.js"></script>
<script type="text/javascript" language="javascript" src="/skin/default/jooyea/jquery-1.9.1.min.js"></script>

<title><?PHP echo $gf_langpackage->langman;?></title>
<style type="text/css">
*{font-family:"微软雅黑";font-size:12px;}
body{margin:0}
a{text-decoration:none;color:#666;}
a:hover {text-decoration:underline;color:#2C589E;}
.container{width:100%;min-height:500px;background:url(valentine/vbg.jpg) no-repeat center top; }
.container .con_top{width:1230px;height:717px;min-height:500px;background:url(valentine/banner.png) no-repeat;margin:0 auto; }
.container .con_top_en{width:1230px;height:717px;min-height:500px;background:url(valentine/banner_en.png) no-repeat;margin:0 auto; }
.container .con_xian{width:1460px;height:80px;margin:0 auto;position:relative;top:-200px;background:url(valentine/xian.png) no-repeat;}
.container .con_xian .uli{width:960px;height:83px;margin:0 auto;position:relative;left:20px;}
.container .con_xian .uli a{width:96px;height:83px;display:inline-block;margin:0 68px;line-height:190px;text-align:center;color:#fff;background:url(valentine/index.png) no-repeat;font-size:16px}
.container .con_xian .uli a#flower{background-position:-90px -145px;width:70px;height:62px;}
.container .con_xian .uli a#chocolate{background-position:-82px 0;width:70px;height:62px;}
.container .con_xian .uli a#package{background-position:-161px 0;width:70px;height:62px;}
.container .con_xian .uli a#exqu{background-position:-2px -70px;width:70px;height:62px;}
.container .mainbgbig{margin-top:-120px;}
.container .mainbg{background:url(valentine/contBt.jpg) no-repeat center -10px;width:100%;height:580px;}
.container .mainbg .mainbgs{background:url(valentine/contBt.jpg) no-repeat center -10px;margin:0 auto;width:1008px;height:580px;}
.container .mainbg .mainbgs .mainbgs_t{background:url(valentine/juxingto.png) no-repeat;width:1008px;height:47px;position:relative;top:35px;}
.container .mainbg .mainbgs .mainbgs_t b{color:#fff;font-size:28px;text-indent:100px;position:relative;left:60px;top:-75px;}
.container .mainbg .mainbgs .mainbgs_t .mainbgs_tl{background:url(valentine/index.png) 0 -132px  no-repeat;width:88px;height:86px;position:relative;left:-50px;top:-20px;}
.container .mainbg  .mainbg_con{min-height:530px;margin-top:36px;}
.container .mainbg  .mainbg_con .mainbg_gift{height:240px;width:190px;float:left;border:1px solid #2E1028;margin:2px;padding:2px;background:#DE2449}
.container .mainbg  .mainbg_con .mainbg_gift:hover{border: 1px solid #FFE400;}
.container .mainbg  .mainbg_con .mainbg_gift img{width:190px;height:190px;}
.container .mainbg  .mainbg_con .mainbg_gift a{display:inline-block;color:#fff;}
.container .mainbg  .mainbg_con .mainbg_gift a span.main_title{font-size:18px;text-align:center;line-height:50px;display:inline-block;width:130px;}
.container .mainbg  .mainbg_con .mainbg_gift a span{height:50px;overflow:hidden}
.container .mainbg  .mainbg_con .mainbg_gift a span.main_title{border-right:1px dashed #A01430}
.container .mainbg  .mainbg_con .mainbg_gift a span.main_price{border-left:1px dashed #F64E70;color:#FFC84B;font-size:24px;font-weight:bold;text-shadow:0px 1px #fff;text-align:center;line-height:50px;display:inline-block;width:55px}
.container .mainbg  .mainbg_con .mainbg_gift a span i{background:url(valentine/index.png) -245px -1px  no-repeat;display:inline-block;width:16px;height:16px;}

</style>
</head>
<body>
<div class="container">
	<div class="<?php if($_COOKIE['lp_name']=='zh'){echo 'con_top';}else{echo 'con_top_en';}?>"></div>
	<div class="con_xian">
		<div class="uli">
			<a id="flower" href="#step1"><?PHP echo $gf_langpackage->xianhua;?></a>
			<a id="chocolate" href="#step2"><?PHP echo $gf_langpackage->qiaokeli;?></a>
			<a id="package" href="#step3"><?PHP echo $gf_langpackage->taocan;?></a>
			<a id="exqu" href="#step4"><?PHP echo $gf_langpackage->jingmei;?></a>
		</div>
	</div>
	<div class="mainbgbig">
		<div class="mainbg" id="step1">
			<div class="mainbgs">
				<div class="mainbgs_t"><div class="mainbgs_tl"></div><b><?PHP echo $gf_langpackage->xianhua;?></b></div>
				<div class="mainbg_con">
					<?php foreach($arr1 as $gift1){ ?>
					<div class="mainbg_gift">
						<a href="/main2.0.php?app=giftitem&id=<?php echo $gift1['id']; ?>" target="_blank" title="<?php echo $gift1['giftname']; ?>"><img alt="<?php echo $gift1['giftname']; ?>" src="<?php echo '/'.$gift1['yuanpatch']; ?>" />
						<span class="main_title"><?php echo $gift1['giftname']; ?></span><span class="main_price"><i></i><?php echo (int)$gift1['money']; ?></span></a>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="mainbg" id="step2">
			<div class="mainbgs">
				<div class="mainbgs_t"><div class="mainbgs_tl"></div><b><?PHP echo $gf_langpackage->qiaokeli;?></b></div>
				<div class="mainbg_con">
					<?php foreach($arr2 as $gift2){ ?>
					<div class="mainbg_gift">
						<a href="/main2.0.php?app=giftitem&id=<?php echo $gift2['id']; ?>" target="_blank" title="<?php echo $gift2['giftname']; ?>"><img alt="<?php echo $gift2['giftname']; ?>" src="<?php echo '/'.$gift2['yuanpatch']; ?>" />
						<span class="main_title"><?php echo $gift2['giftname']; ?></span><span class="main_price"><i></i><?php echo (int)$gift2['money']; ?></span></a>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="mainbg" id="step3">
			<div class="mainbgs">
				<div class="mainbgs_t"><div class="mainbgs_tl"></div><b><?PHP echo $gf_langpackage->taocan;?></b></div>
				<div class="mainbg_con">
					<?php foreach($arr3 as $gift3){ ?>
					<div class="mainbg_gift">
						<a href="/main2.0.php?app=giftitem&id=<?php echo $gift3['id']; ?>" target="_blank" title="<?php echo $gift3['giftname']; ?>"><img alt="<?php echo $gift3['giftname']; ?>" src="<?php echo '/'.$gift3['yuanpatch']; ?>" />
						<span class="main_title"><?php echo $gift3['giftname']; ?></span><span class="main_price"><i></i><?php echo (int)$gift3['money']; ?></span></a>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="mainbg" id="step4">
			<div class="mainbgs">
				<div class="mainbgs_t"><div class="mainbgs_tl"></div><b><?PHP echo $gf_langpackage->jingmei;?></b></div>
				<div class="mainbg_con">
					<?php foreach($arr4 as $gift4){ ?>
					<div class="mainbg_gift">
						<a href="/main2.0.php?app=giftitem&id=<?php echo $gift4['id']; ?>" target="_blank" title="<?php echo $gift4['giftname']; ?>"><img alt="<?php echo $gift4['giftname']; ?>" src="<?php echo '/'.$gift4['yuanpatch']; ?>" />
						<span class="main_title"><?php echo $gift4['giftname']; ?></span><span class="main_price"><i></i><?php echo (int)$gift4['money']; ?></span></a>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

</body>
</html>
