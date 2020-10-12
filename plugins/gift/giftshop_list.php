<?php
header("Content-Type: text/html;chartset=UTF-8");
?>
<?php
//打开get和post的封装
$getpost_power=true;
//打开session
$session_power=true;
//引入系统文件的支持文件
include_once(dirname(__file__)."/../includes.php");
//引入自己的配制文件
include_once(dirname(__file__)."/config.php");
include_once("../../includes.php");
//得到礼品的类型
$type=get_args('type');
//语言包
$gl=new giftlp();
if($type=='5'){
	echo "<div style='font-weight: bold;font-size: 13px;color: #153473;margin:10px;'>$gl->gf_con0;</div><div  class='giftshop_tit' style='margin:10px;padding-bottom:15px;border-bottom:1px dotted #ccc'>$gl->gf_con1;</div><div style='font-weight: bold;font-size: 13px;color: #153473;margin:10px;'>$gl->gf_con2;</div><div style='margin:10px;padding-bottom:15px;border-bottom:1px dotted #ccc' class='giftshop_tit'>$gl->gf_con3;</div><div style='font-weight: bold;font-size: 13px;color: #153473;margin:10px;'>$gl->gf_con4;</div><div style='margin:10px;padding-bottom:15px;line-height:18px;' class='giftshop_tit'>$gl->gf_con5;</div>";exit;
}
if($type=='6'){
	$str="<div style='font-weight: bold;font-size: 16px;color: #000;margin:10px;'>$gl->gf_con6;</div>";
	$str.= "<div style='font-weight: bold;font-size: 13px;color: #153473;margin:10px;'>$gl->gf_con7;</div>";
	$str.="<div  class='giftshop_tit' style='margin:10px;padding-bottom:15px;border-bottom:1px dotted #ccc'>$gl->gf_con8;</div>";
	$str.="<div style='font-weight: bold;font-size: 16px;color: #000;margin:10px;'>$gl->gf_con9;</div>";
	$str.= "<div style='font-weight: bold;font-size: 13px;color: #153473;margin:10px;'>$gl->gf_con10;</div>";
	$str.="<div  class='giftshop_tit' style='margin:10px;padding-bottom:15px;border-bottom:1px dotted #ccc;line-height:20px;'>$gl->gf_con11;</div>";
	$str.= "<div style='font-weight: bold;font-size: 13px;color: #153473;margin:10px;'>$gl->gf_con12;</div>";
	$str.="<div  class='giftshop_tit' style='margin:10px;padding-bottom:15px;border-bottom:1px dotted #ccc;line-height:20px;'>$gl->gf_con13;</div>";
	$str.= "<div style='font-weight: bold;font-size: 13px;color: #153473;margin:10px;'>$gl->gf_con14;</div>";
	$str.="<div  class='giftshop_tit' style='margin:10px;padding-bottom:15px;border-bottom:1px dotted #ccc;line-height:20px;'>$gl->gf_con15;</div>";
	$str.= "<div style='font-weight: bold;font-size: 13px;color: #153473;margin:10px;'>$gl->gf_con16;</div>";
	$str.="<div  class='giftshop_tit' style='margin:10px;padding-bottom:15px;border-bottom:1px dotted #ccc;line-height:20px;'>$gl->gf_con17;</div>";
	$str.= "<div style='font-weight: bold;font-size: 13px;color: #153473;margin:10px;'>$gl->gf_con18;</div>";
	$str.="<div  class='giftshop_tit' style='margin:10px;padding-bottom:15px;border-bottom:1px dotted #ccc;line-height:20px;'>$gl->gf_con19;</div>";
	$str.= "<div style='font-weight: bold;font-size: 13px;color: #153473;margin:10px;'>$gl->gf_con20;</div>";
	$str.="<div  class='giftshop_tit' style='margin:10px;padding-bottom:15px;line-height:20px;'>$gl->gf_con21;</div>";
	echo $str;
	exit;
}
//创建系统对数据库进行操作的对象
$dbo=new dbex();
//对数据进行读写分离，读操作
dbplugin('r');

//查询对应的礼品
$sql="select * from gift_shop where  typeid='$type' order by ordersum desc , id desc";
$gifts=$dbo->getRs($sql);

//如果用户在线
if(get_sess_userid())
{
	//列出对应的礼品信息
	$size=20;
	$totalpage= floor((count($gifts)-1)/$size)+1;
	$gift_array=array_chunk($gifts,$size,true);	
	$index=intval(get_args('index'));
	$gifts=$gift_array[$index];
	if($gifts){	
		foreach($gifts as $gift)
		{
			$yuanpatchs=explode("|", $gift['yuanpatch']);
			echo "<div class='giftbox'><a href=giftitem.php?id=".$gift['id']." target='_self'><img class='gift_img' title='".$gift['giftname']."' src='http://www.pauzzz.com/rootimg.php?src=http://www.pauzzz.com/".$yuanpatchs[0]."&h=130&w=130&zc=1'/><span>".$gift['giftname']."</span><span style='color:#c20606;font-weight:700'>".$gift['money']."&nbsp;<img src='/skin/default/jooyea/images/s_main_46.gif' style='vertical-align:middle;'/></span></a></div>";
			
		}
	}else{
		echo "<div class='giftbox'>$gl->gf_zanshimeiyou</div>";
	}
	
	if($totalpage>1)
	{
		$str="<div/><div id='gift_page_list' style='float:left;'>";
		for($i=1;$i<=$totalpage;$i++)
		{
			if($i==($index+1))$str.="<a href='#' onclick='getGifts($type,".($i-1).")' class='active'>$i</a>";
			else $str.="<a href='#' onclick='getGifts($type,".($i-1).")'>$i</a>";
		}
		$str.="</div>";
		echo $str;
	}
	else
	{
		$str="<div/><div id='gift_page_list' style='float:left;height:20px'>";
		$str.="&nbsp;</div>";
		echo $str;
	}
}
?>
