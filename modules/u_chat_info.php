<?php
//语言包引入
$u_langpackage=new userslp;
$mn_langpackage=new menulp;
$pu_langpackage=new publiclp;
require("foundation/auser_mustlogin.php");
$from_id=get_sess_userid();
$user_id=$_GET['uid'];


//读取客服信息
$sql="select s.*,u.is_service,u.user_ico,u.zx_try from wy_servicers as s join wy_users as u  where u.user_id=s.user_id and s.user_id='$user_id' and u.is_service>0";
$info=$dbo->getRow($sql);if($info['zx_try']==1){	$time=100;}else{	$time=1000*60;}$ison=$dbo->getRow("select user_id from wy_online where user_id='$user_id'");
$note_list=$dbo->getRs("select * from wy_service_note where to_id='$user_id' order by id desc limit 8");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $pu_langpackage->zixun_title;?>-<?php echo $siteName;?></title>
<base href='<?php echo $siteDomain;?>' />
<?php $plugins=unserialize('a:0:{}');?>
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/layout.css">
<script type="text/javascript" src="skin/default/js/jy.js"></script>
<script type="text/javascript" src="skin/default/js/jooyea.js"></script>
<script type='text/javascript' src="servtools/imgfix.js"></script>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDrag.js"></script>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDialog.js"></script>
<script type="text/javascript" language="javascript" src="servtools/calendar.js"></script>
<script type="text/javascript" src="servtools/ajax_client/ajax.js"></script>
<style>.main {text-align:left}</style>
</head>
<body>
<div class="container">
  <?php require("uiparts/mainheader.php");?>
	<div class="wrapper" style="margin-top:50px;">
		<div class="main">
			<div class="chat_top">
				<ul>
					<li class="li1"><b><?php echo $pu_langpackage->zixun1;?></b><span><?php echo $pu_langpackage->zixun1_1;?></span></li>
					<li class="li2"><b><?php echo $pu_langpackage->zixun2;?></b><span><?php echo $pu_langpackage->zixun2_1;?> </span></li>
					<li class="li3"><b><?php echo $pu_langpackage->zixun3;?></b><span><?php echo $pu_langpackage->zixun3_1;?></span></li>
					<li class="li4"><b><?php echo $pu_langpackage->zixun4;?></b><span><?php echo $pu_langpackage->zixun4_1;?></span></li>
				</ul>
			</div>
			<div class="chat_c1">
				<div class="chat_c1_tit" style="background:none;font-size;12px;font-weight:100"><?php echo $mn_langpackage->mn_location;?>:<?php echo $mn_langpackage->mn_index;?> > <?php echo $mn_langpackage->mn_service;?>
				</div>
				<div style="border:3px solid #B0B0B0"></div>
				<div class="s_info_top">
					<div class="s_info_top_l"><!--头像-->
						<div class="s_info_ico"><img src="<?php echo $info['user_ico'];?>" /></div>
						<div class="s_info_name"><?php echo $info['user_name'];?><?php echo $mn_langpackage->mn_sname;?></div>
						<div class="s_info_btn"><a href="javascript:void(0);" <?php if($ison){?>onclick="chat_start(<?php echo $from_id;?>,<?php echo $info['user_id'];?>);"<?php }?>><?php echo $pu_langpackage->zixun_chat;?></a></div>
						<div class="s_info_btn" id="zixun_end_btn" style="display:none"><a href="javascript:void(0);" onclick="location.reload()"><?php echo $pu_langpackage->zixun_end;?></a></div>
					</div>
					<div class="s_info_top_r">
						<b><?php echo $info['user_name'];?><?php echo $pu_langpackage->degerenziliao;?></b>
						<ul>
							<li><?php echo $pu_langpackage->serv_name;?>:<?php echo $info['user_name'];?></li>
							<li><?php echo $pu_langpackage->serv_gift;?>:<?php echo $info['gift_num'];?></li>
							<li><?php echo $pu_langpackage->serv_sex;?>:<?php if($info['user_sex']==0){echo $pu_langpackage->pu_woman;}else{echo $pu_langpackage->pu_man;}?></li>
							<li><?php echo $pu_langpackage->serv_age;?>:<?php echo $info['user_age'];?></li>
							
							<li class="bgline"><?php echo $pu_langpackage->serv_shanchang;?>:
							<?php if($info['shanchang']==1){echo $pu_langpackage->zixun1;}elseif($info['shanchang']==2){echo $pu_langpackage->zixun2;}elseif($info['shanchang']==3){echo $pu_langpackage->zixun3;}elseif($info['shanchang']==4){echo $pu_langpackage->zixun4;}?>
							</li>
							<li class="bgline"><?php echo $pu_langpackage->serv_feiyong;?>: <?php $feiyongs=explode('/',$info['feiyong']); echo $feiyongs[0].$pu_langpackage->pu_zibi.'/'.$feiyongs[1].$pu_langpackage->serv_fenzhong;?> (<?php echo $pu_langpackage->serv_qian10fz;?>)</li>
						</ul>
						<span><?php echo $pu_langpackage->serv_time;?><br/><b style="font-size:16px;color:#FF6D00;">9:00-17:00</b></span>
						<div class="r_bottom"><?php echo $pu_langpackage->gexingqianming;?>:<?php echo $info['gerenqianming'];?></div>
						<div class="r_bottom"><?php echo $pu_langpackage->fuwuzongzhi;?>:<?php echo $info['fuwuzongzhi'];?></div>
					</div>
				</div>
				<div class="s_info_middle">
					<div class="s_info_top_l" style="border:none">
						<div class="middle_title"><?php echo $pu_langpackage->fuwuzongzhi;?></div>
						<div class="middle_lcon">
							<ul>
								<?php foreach($note_list as $note){?>
								<li><?php echo $pu_langpackage->chenggongyu;?>'<?php echo mb_substr($note['from_name'],0,2).'***';?>'<?php echo $pu_langpackage->zixunwancheng;?>..</li>
								<?php }?>
							<ul>
						</div>
					</div>
					<div class="s_info_top_r2"  style="border:none">
						<span class="middle_r_title"><?php echo $pu_langpackage->gerenjieshao;?></span>
						<span class="middle_r_title"><?php echo $pu_langpackage->serv_gift;?></span>
						<div class="middle_lcon">
							<ul>
								<li><b><?php echo $pu_langpackage->gerenjieshao;?></b>:</li>
								<li><?php echo $info['gerenqianming'];?></li>
								<li><b><?php echo $pu_langpackage->fuwuzongzhi;?></b>:</li>
								<li><?php echo $info['fuwuzongzhi'];?></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
  <?php require("uiparts/footor.php");?>
</div>
<script>
function chat_start(from_id,to_id){
	if(from_id==to_id){
		Dialog.alert('<?php echo $pu_langpackage->bunengheziji;?>');return false;
	}
	var chat_ajax=new Ajax();
	chat_ajax.getInfo("do.php?act=service_chat","get","app","&from_id="+from_id+"&to_id="+to_id,function(c){
		if(c=='<?php echo $pu_langpackage->less_golds;?>'){
			Dialog.alert('<?php echo $pu_langpackage->less_golds;?>');
		}else{			<?php if($info['zx_try']!=1){?>
			Dialog.alert('<?php echo $pu_langpackage->miniter10;?>');			<?php }?>
			top.i_im_talkWin(<?php echo $info['user_id'];?>,'imWin');
			kaishijifei(to_id);
			document.getElementById('zixun_end_btn').style.display='block';
		}
	});
}
function kaishijifei(to_id){	
	setTimeout(function(){		
		setInterval(function(){
			var jifei=new Ajax();
			jifei.getInfo("do.php?act=kaishijifei","get","app","&to_id="+to_id+"&golds_one=<?php echo $feiyongs[0];?>",function(c){				if(c==1){window.location.reload();}			})
		},1000*60*<?php echo $feiyongs[1];?>);
	},1);
	
}
</script>
<script language="JavaScript" src="im/im_forsns_js.php"></script>
</body>
</html>