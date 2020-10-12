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
$id=$_REQUEST['id'];
$sql="select * from gift_shop where  id='$id'";
$gifts=$dbo->getRow($sql);
$yuanpatchs = explode("|", $gifts["yuanpatch"]);
$patchs = explode("|", $gifts["patch"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" language="javascript" src="/plugins/gift/Common.js"></script>
<script type="text/javascript" language="javascript" src="/servtools/dialog/zDrag.js"></script>
<script type="text/javascript" language="javascript" src="/servtools/dialog/zDialog.js"></script>
<script type="text/javascript" language="javascript" src="/skin/default/jooyea/jquery-1.9.1.min.js"></script>
<script type="text/javascript" language="javascript" src="/skin/default/jooyea/jquery.enlarge.js"></script>
<title>礼品</title>
<style type="text/css">
*{font-family:"微软雅黑";font-size:12px;}
a{text-decoration:none;color:#666;}
a:hover {text-decoration:underline;color:#2C589E;}

.giftitem_top {height:30px;text-align:right;line-height:30px;border-bottom:1px solid #E5E5E5;}
.giftitem_top a{display:inline-block;}
.giftitem_top i{display:inline-block;float:left;width:19px;height:18px;background:url(icon_01.png) 0 -206px no-repeat;position:relative;top:5px;}
.giftitem_top span{display:inline-block;float:left;}
.giftitem_name{width:100%;height:42px;line-height:42px;font-weight:bold;font-size:16px;float:left;}
.giftitem_img{float:left;width:256px;/*height:256px;*/padding:2px;border:1px solid #C1EBFF;}
.giftitem_img img{width:256px;height:256px;}
ul#small_pic{
		margin:0;
		padding:0px;
	}
ul#small_pic li {
		display: inline-block;
		width: 22%;
		height: 60px;
		padding:2px;
		cursor: pointer;
	}
ul#small_pic li img{
		width: 60px;
		height: 60px;
	}
.giftitem_right{width:330px;height:258px;float:right;padding:2px;}
.giftitem_right_s ,  b{color:#999;height:40px;line-height:40px;}
.giftitem_right_s span{color:#FF6500;font-size:20px;font-weight:bold;font-family:黑体}
.giftitem_right_s i{display:inline-block;width:16px;height:16px;background:url(ico.png) no-repeat;}
.giftitem_right_num{height:120px;background:#F1F1F2;border:1px solid #F3F3F3;padding:10px;}
.giftitem_right_num input{text-align:center;}
.giftitem_right_num big{display:inline-block;text-align:center;line-height:16px;height:16px;width:16px;border:1px solid #C0C0C0;cursor:pointer;}
.giftitem_right_num big:hover {border:1px solid #FF6500;background:#fff;}
.giftitem_right_num #gobuy {width:120px;height:37px;margin-top:20px;cursor:pointer;font-size:19px;line-height:34px;background:url(czbtn.png) -10px 0 repeat-x; border:none;color:#fff;}
#xiangqing img{max-width:620px;}
</style>
</head>
<?php
	//创建系统对数据库进行操作的对象
	$dbo=new dbex();
	//读写分离，进行读操作
	dbplugin('r');
	$send_id=get_sess_userid();
	$sql="select * from wy_users where user_id=$send_id";
	$user_info=$dbo->getRow($sql);
	$golds = $user_info['golds'];
	//等级信息
	$info="<font color='#ce1221' style='font-weight:bold;'>".$er_langpackage->er_currency."</font>：".$golds;
	if(!empty($user_info['user_group'])&&$user_info['user_group']!='base')
	{
		$groups=$dbo->getRow("select * from wy_frontgroup where gid='$user_info[user_group]'");

		if($langPackagePara!='zh')
		{
			$groups['name']=str_replace('普通会员','',$groups['name']);
			$groups['name']=str_replace('高级会员',$er_langpackage->js_8,$groups['name']);
			$groups['name']=str_replace('星级会员',$er_langpackage->js_10,$groups['name']);
		}
		$info.="&nbsp;&nbsp;&nbsp;&nbsp;".$er_langpackage->er_nowtype."：".$groups['name'];

		$groups=$dbo->getRow("select * from wy_upgrade_log where mid='$send_id' and state='0' order by id desc limit 1");
		//print_r($groups);
		$startdate=strtotime(date("Y-m-d"));
		$enddate=strtotime($groups['endtime']);
		$days=round(($enddate-$startdate)/3600/24);
		if($days>0){
			$info.="&nbsp;&nbsp;&nbsp;&nbsp;".$er_langpackage->er_howtime."：".$days.$er_langpackage->er_day;
		}else{
			$sql="update wy_upgrade_log set state='1' where mid='$user_id'";
			$dbo->exeUpdate($sql);
			$sql="update wy_users set  user_group='1'   where  user_id='$user_id'";
			$dbo->exeUpdate($sql);
		}
		
	}
?>
<body>
	<div class="tabs" style="border:1px solid #ce1221;text-align:left;background:#F5F5B9;padding-left:15px;line-height:25px;">
		<?php echo $info;?>
	</div>
	<div class="giftitem_top">
		<i></i><span><?php echo $gf_langpackage->gf_xiangqing;?></span><a href="giftshop.php"><?php echo $gf_langpackage->gf_fanhui;?></a>
	</div>
	<div class="giftitem_name"><?php echo $gifts['giftname'];?></div>
	<div style="float: left;">
	<div class="giftitem_img" id="enlarge" src="/<?php echo $yuanpatchs[0];?>">
		<img src="http://www.pauzzz.com/rootimg.php?src=<?php echo $yuanpatchs[0];?>&h=256&w=256&zc=1" />
		
	</div>
	<ul id="small_pic">
			<?php foreach ($yuanpatchs as $key => $value) { if($key<4){?>
			<li> <img src="/<?php echo $value;?>" alt="" /></li>
			<?php }} ?>
		</ul></div>
	<div class="giftitem_right">
		<div class="giftitem_right_s"><b><?php echo $gf_langpackage->gf_jiage;?>:</b><span><i></i><?php echo $gifts['money'];?></span></div>
		<div class="giftitem_right_s"><b><?php echo $gf_langpackage->gf_caizhi;?>:</b><?php echo $gifts['caizhi'];?></div>
		<div class="giftitem_right_num">
			<div><b><?php echo $gf_langpackage->gf_shuliang;?>:</b><big onclick="check_item_num(-1)">-</big><input id="item_num" type="text" value="1" size="3" /><big onclick="check_item_num(1)">+</big></div>
			<div><button id="gobuy"><?php echo $gf_langpackage->gf_goumai;?></button></div>
			<input type="hidden" id="itemid" value="<?php echo $_GET['id']; ?>" />
		</div>
	</div>
	<div  class="giftitem_name" style="border-bottom:1px solid #A33F3F;height:25px;margin-top:10px;"><span style="display:inline-block;padding:0px 15px;color:#fff;background:#A33F3F;margin-left:10px;height:25px;line-height:27px"><?php echo $gf_langpackage->gf_xiangqing;?></span></div>
	<div style="width:100%;float:left;padding:10px;color:#666;" id="xiangqing">
	
	

















	<?php   
	
	//Add By Root Time:20141019 Begin
	
	$contentByRoot = $gifts['desc'];	//获取文章内容
	
	
  
    
	 $pattern = '/<p><img\ssrc=\"(.*)\"/isU';
	
	 preg_match_all($pattern, $contentByRoot, $matches);
	

	 $rootImageSize = array();
	
	
	 $rDomain = $_SERVER['SERVER_NAME'] ? $_SERVER['HTTP_HOST'] : "http://www.pauzzz.com";

	
	 for($i=0; $i<count($matches[1]);$i++){
	
		
		$strTrueAll = $rDomain.$matches[1][$i];
        $strTrueAll ="http://".$strTrueAll;

	    $rootImageSize[$i]['path'] = $strTrueAll;   //由此:$rootImageSize 是一个2维3个下标的数组
	}


    

    $i=0;
    function reImage($matches){     //example: src="/uploadfiles/article/20140505/13992621165363.jpg" style="float:none;width:800px;height:600px;" width="800" height="600" border="0" hspace="0" vspace="0" />

        global $i;
        global $rootImageSize;


            $matches="<p><img src=http://"."www.pauzzz.com/rootimg.php?src=".$rootImageSize[$i]['path']."&h=&w=620&zc=1 /></p>";//注意src前面有个空格

            $i++;

        return $matches;
         
     }
    
    
    
     $pattern = '/<p><img(.*)<\/p>/isU';
	
     preg_match_all($pattern, $contentByRoot, $matches);
	

     $contentByRoot = preg_replace_callback($pattern, "reImage", $contentByRoot);




     
     echo $contentByRoot;

	
	?>
	
	

















	
	
	</div>
<script>
//放大镜
$(function(){
	$('#enlarge').enlarge({
		// 鼠标遮罩层样式
		shadecolor: "#FFD24D",
		shadeborder: "#FF8000",
		shadeopacity: 0.5,
		cursor: "move",
		// 大图外层样式
		layerwidth: 290,
		layerheight: 290,
		layerborder: "#DDD",
		
		largewidth: 600,
		largeheight: 600
	});



	//gaoyuan  small_pic
	$("#small_pic li").click(function(){
		//alert("aaa");
		var _src=$(this).find("img").attr('src');
		$("#enlarge").attr("src",_src);
		$("#enlarge>img").attr("src","http://www.pauzzz.com/rootimg.php?src="+_src+"&h=256&w=256&zc=1");
		$('#enlarge').enlarge({
			// 鼠标遮罩层样式
			shadecolor: "#FFD24D",
			shadeborder: "#FF8000",
			shadeopacity: 0.5,
			cursor: "move",
			// 大图外层样式
			layerwidth: 290,
			layerheight: 290,
			layerborder: "#DDD",
			
			largewidth: 600,
			largeheight: 600
		});
	});
})



$(function(){
	$('#gobuy').click(function(){
		var id=$('#itemid').val();
		var num=$('#item_num').val();
		location.href="create_order.php?id="+id+"&num="+num;
	})
})
function  check_item_num(n){
	var m=parseInt(n);
	var num=parseInt($('#item_num').val() );
	if(m<0 && num<=1) return false;
	$('#item_num').val(num+m)
}
function checkname(obj)
{
	check=new Ajax();
	check.getInfo("/do.php","get","app","act=reg&ajax=1&user_name="+obj,function(c){if(!c){Dialog.alert('<?php echo $gf_langpackage->gf_mess_0;?>');}});
}

//得到对应类型的礼品
function getGifts(type,index)
{
	//调用系统的Ajax类
	ajax=new Ajax(); 
	ajax.getInfo("/plugins/gift/giftshop_list.php","post","get","type="+type+"&index="+index,"gift_list"); 
}
/*//得到好友列表
function getFriends()
{
	friends=new Ajax(); 
	friends.getInfo("/plugins/gift/friends.php","get","app","","friend_list"); 
}
//显示好友列表
function showFriends()
{
	document.getElementById('gift_friends').style.display='block';
	getFriends();
}
//隐藏好友列表
function hiddenFriends()
{
	var accept_ids=document.getElementsByName('accept_id');
	for(i=0;i<accept_ids.length;i++)
	{
		if(document.getElementsByName('accept_id')[i].checked)document.forms['gift'].accept.value=document.getElementById("gift_accept_"+document.getElementsByName('accept_id')[i].value).innerHTML;
	}
	document.getElementById('gift_friends').style.display='none';
}*/
//检测表单填写的正确性
function check()
{
	var select_flag=false;
	if(document.forms['gift'].accept.value=="")
	{
		document.getElementById('gift_info').style.display='block';
		document.getElementById("gift_info").innerHTML="<?php echo $gf_langpackage->gf_mess_1;?>";
		return false;
	}
	for(i=0;i<document.forms['gift'].gift_img.length;i++)
	{
		if(document.forms['gift'].gift_img[i].checked)select_flag=true;
	}
	if(!select_flag)
	{
		document.getElementById('gift_info').style.display='block';
		document.getElementById("gift_info").innerHTML="<?php echo $gf_langpackage->gf_mess_2;?>";
		return false;
	}
	
}

function changeStyle_gift(obj){
	var tabList = document.getElementById('zishu').getElementsByTagName('li');
	for(i=0;i<tabList.length;i++){
		tabList[i].className = 'nav_a';
	}
	obj.parentNode.className += ' active';
}

	  // 计算页面的实际高度，iframe自适应会用到
    function calcPageHeight(doc) {
        var cHeight = Math.max(doc.body.clientHeight, doc.documentElement.clientHeight)
        var sHeight = Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight)
        var height  = Math.max(cHeight, sHeight)
        return height
    }

	
    window.onload = function() {

		//alert('dddddddddddd');
	   
        var height = calcPageHeight(document);
        parent.document.getElementById('ifr').style.height = height + 'px'   ;
		
		  
    }
</script>
<?php
//判断表单是否正常提交
//if($accept_name!="" && $accept_id!="" && $gift!="")
if($accept_name!="" && $gift!="")
{
	$msg=get_args("msg");
	//通过session得到用户ID
	$send_id=get_sess_userid();
	//通过session得到用户名
	$send_name=get_sess_username();
	date_default_timezone_set("Asia/Shanghai");
	$send_time=date('Y-m-d H:i:s');
	//通过表前缀得到表名
	$order=$table_prefix."order";
	//创建系统对数据库进行操作的对象
	$dbo=new dbex();
	//读写分离，进行读操作
	dbplugin('r');
	$sql="select * from wy_users where user_id=$send_id";
	//得到用户积分
	$user_info=$dbo->getRow($sql);
    $golds = $user_info['golds'];

	$sql="select * from wy_users where user_name='$accept_name'";
	//得到用户积分
	$accept_id=$dbo->getRow($sql);
	$accept_id=$accept_id['user_id'];

	//$score=0;

	//判定礼品的类型，从而处理积分的变化
	$sql="select * from gift_news where id=$gift";
	//得到用户积分
	$gift=$dbo->getRow($sql);
	//print_r($gift);exit;
	 $score=$gift['money'];
	/*
	if($gift['typeid']==1)
	{
		$score=0.00;
	}
	else if($gift['typeid']==2)
	{
		$sql="select count(*) as c from $order where send_id='$send_id' and gifttype='{$gift[typeid]}' and TO_DAYS(send_time)=TO_DAYS(now())";
		$count=$dbo->getRow($sql);
		if(intval($user_info['user_group'])==2)
		{
			if($count['c']<1)
			{
				$score=0.00;
			}
		}
		else if(intval($user_info['user_group'])==3)
		{
			if($count['c']<5)
			{
				$score=0.00;
			}
		}
	}
		*/
	dbplugin('w');
	//判定剩下的积分是否还能发送礼品
	if(($user_info['golds']-$score)>=0)
	{	
		
		//写数据
		
		$ordernumber='S-P'.time().mt_rand(100,999);
		$addtime=time();
		$addtime=date('Y-m-d H:i:s',$addtime);
		$sql="insert into wy_balance set type='4',uid='$send_id',uname='$send_name',touid='$accept_id',touname='$accept_name',message='送礼物，价格：$score',state='2',addtime='$addtime',funds='$score',ordernumber='$ordernumber'";
	
		if(!$dbo->exeUpdate($sql)){
			exit('送礼物失败');
		}

		
		//发送的礼品记录到数据库
		$sql="insert into $order(send_id,accept_id,send_name,accept_name,msg,gift,send_time,gifttype) values('$send_id','$accept_id','$send_name','$accept_name','$msg','{$gift[patch]}','$send_time','{$gift[typeid]}')";
		if($dbo->exeUpdate($sql));
		{
			//显示发送成功
			echo"<script>document.getElementById('gift_info').style.display='block';document.getElementById('gift_info').innerHTML='".$gf_langpackage->gf_mess_4."';</script>";
			//更新用户的积分
			$sql="update wy_users set golds=$golds-$score where user_id=$send_id";
			$dbo->exeUpdate($sql);
		}
	}
	else
	{
		//当积分不够时提醒用户
		echo"<script>document.getElementById('gift_info').style.display='block';document.getElementById('gift_info').innerHTML='".$gf_langpackage->gf_mess_5."';</script>";
	}	
}
?>
</body>
</html>
