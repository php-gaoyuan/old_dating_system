<?php
//语言包引入
$u_langpackage=new userslp;
$mn_langpackage=new menulp;
$pu_langpackage=new publiclp;


$user_id=get_sess_userid();
$user_name=get_sess_username();

//读取在线客服列表
//$sql="select o.user_name,o.user_ico,o.user_id from wy_online as o left join wy_users as u on o.user_id=u.user_id where u.is_service >0 order by o.active_time desc";$sql="select user_name,user_ico,user_id from wy_users where is_service>0 order by rand()";//echo $sql;exit;
$service_list=$dbo->getRs($sql);
foreach($service_list as $k=>$v){
	$gexing=$dbo->getRow("select gerenqianming from wy_servicers where user_id=$v[user_id]");
	$service_list[$k]['content']=$gexing['gerenqianming'];
}
$note_list=$dbo->getRs("select s.*,e.shanchang,u.user_ico from wy_service_note as s join wy_servicers as e join wy_users as u where s.from_id=e.user_id and s.to_id=u.user_id order by s.id desc limit 5");
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
				<div class="chat_c1_tit"><?php echo $pu_langpackage->tuijiankefu;?>
				<span class="c1_list" id="c1_0" onclick="kefu_check(0)" style="font-weight:bold"><?php echo $pu_langpackage->quanbu;?></span>
				<span class="c1_list" id="c1_1" onclick="kefu_check(1)"><?php echo $pu_langpackage->zixun1;?></span>
				<span class="c1_list" id="c1_2" onclick="kefu_check(2)"><?php echo $pu_langpackage->zixun2;?></span>
				<span class="c1_list" id="c1_3" onclick="kefu_check(3)"><?php echo $pu_langpackage->zixun3;?></span>
				<span class="c1_list" id="c1_4" onclick="kefu_check(4)"><?php echo $pu_langpackage->zixun4;?></span></div>
				<div style="border:3px solid #B0B0B0"></div>
					<div class="chat_c2 dis" id="c2_0" >
					<?php foreach($service_list as $slist){?>
						<div class="kefu_lists">
							<a class="kefu_img" href="modules.php?app=u_chat_info&uid=<?php echo $slist['user_id'];?>"><img src="<?php echo $slist['user_ico'];?>" /></a>
							<div class="kefu_jianjie" title="<?php echo $slist['content'];?>"><?php echo $slist['user_name'];?>[<?php echo $pu_langpackage->pu_online;?>]:"<?php echo $slist['content'];?>"</div>
							<a class="btn_zixun" href="modules.php?app=u_chat_info&uid=<?php echo $slist['user_id'];?>"><?php echo $pu_langpackage->zixun_chat;?></a>
						</div>
					<?php }?>
					<div style="clear:both"></div>
					</div>
				<div class="chat_c2" id="c2_1">1</div>
				<div class="chat_c2" id="c2_2">2</div>
				<div class="chat_c2" id="c2_3">3</div>
				<div class="chat_c2" id="c2_4">4</div>
			</div>
			<div class="chat_c1">
				<div class="chat_c1_tit" style="background:url(skin/default/jooyea/images/tag2.png) no-repeat;"><?php echo $pu_langpackage->kefudongtai;?></div>
				<div style="border:3px solid #B0B0B0"></div>
				<div class="chat_c3">
					<?php foreach($note_list as $note){?>
					<div class="c3_list">
						<a href="modules.php?app=u_chat_info&uid=<?php echo $note['to_id']?>"><img src="<?php echo $note['user_ico'];?>" /></a>
						<div class="c3_txt_tit"><?php echo $note['to_name'];?></div>
						<div class="c3_txt_tit"><?php if($note['shanchang']==1){echo $pu_langpackage->zixun1;}elseif($note['shanchang']==2){echo $pu_langpackage->zixun2;}elseif($note['shanchang']==3){echo $pu_langpackage->zixun3;}elseif($note['shanchang']==4){echo $pu_langpackage->zixun4;}?></div>
						<div class="c3_txt_tit"><?php echo $pu_langpackage->chenggongyu.mb_substr($note['from_name'],0,2).'***'.$pu_langpackage->zixunwancheng;?></div>
						<div class="c3_txt_tit back"><?php echo date('Y-m-d H:i',$note['start_time']);?></div>
					</div>
					<?php }?>
					
				</div>
			</div>
			<div class="chat_c1">
				<div class="chat_c1_tit" style="background:url(skin/default/jooyea/images/tag3.png) no-repeat;"><?php echo $pu_langpackage->changjianwenti;?>
				<span class="zixun_span" id="cj_0" onclick="cj_check(0)" style="font-weight:bold"><?php echo $pu_langpackage->quanbu;?></span>
				<span class="zixun_span" id="cj_1" onclick="cj_check(1)" ><?php echo $pu_langpackage->zixun1;?></span>
				<span class="zixun_span" id="cj_2" onclick="cj_check(2)"><?php echo $pu_langpackage->zixun2;?></span>
				<span class="zixun_span" id="cj_3" onclick="cj_check(3)"><?php echo $pu_langpackage->zixun3;?></span>
				<span class="zixun_span" id="cj_4" onclick="cj_check(4)"><?php echo $pu_langpackage->zixun4;?></span></div>
				<div style="border:3px solid #B0B0B0"></div>
				<div class="zixun" id="zixun_0" style="display:block">
					<ul>
						<li><span class="li_left">七夕你想送她什么礼物，知道每个礼物的含义吗？</span><span class="li_right">2014-04-03</span></li>
						
						
					</ul>
				</div>
				<div class="zixun" id="zixun_1">1</div>
				<div class="zixun" id="zixun_2">2</div>
				<div class="zixun" id="zixun_3">3</div>
				<div class="zixun" id="zixun_4">4</div>
			</div>
		</div>
	</div>
  <?php require("uiparts/footor.php");?>
</div>
<script>
function cj_check(d){
	var chat_list=document.getElementsByClassName('zixun');
	for(var i=0;i<chat_list.length;i++){
		chat_list[i].style.display='none';
	}
	var c1_list=document.getElementsByClassName('zixun_span');
	for(var i=0;i<c1_list.length;i++){
		c1_list[i].style.fontWeight='100';
	}
	document.getElementById('zixun_'+d).style.display='block';
	document.getElementById('cj_'+d).style.fontWeight='bold';
}
function kefu_check(d){
	
	var c1_list=document.getElementsByClassName('c1_list');
	for(var i=0;i<c1_list.length;i++){
		c1_list[i].style.fontWeight='100';
	}
	
	document.getElementById('c1_'+d).style.fontWeight='bold';
	obj_ajax=new Ajax();
	obj_ajax.getInfo("do.php?act=get_kefu_list&type="+d,"get","app","",function(c){
		document.getElementById('c2_0').innerHTML=c;
	});
}
function getElementsByClassName(n) {
    var classElements = [],allElements = document.getElementsByTagName('*');
    for (var i=0; i< allElements.length; i++ )
   {
       if (allElements[i].className == n ) {
           classElements[classElements.length] = allElements[i];
        }
   }
   return classElements;
}
</script>
<script language="JavaScript" src="im/im_forsns_js.php"></script>
</body>
</html>