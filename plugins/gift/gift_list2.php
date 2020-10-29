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

//创建系统对数据库进行操作的对象
$dbo=new dbex();
//对数据进行读写分离，读操作
dbplugin('r');
//查询对应的礼品
$id=$_GET['id'];
$sql="select * from gift_news where  id=$id";
$gifts=$dbo->getRs($sql);

//如果用户在线
if(get_sess_userid())
{
	//列出对应的礼品信息
	$size=30;
	$totalpage= floor((count($gifts)-1)/$size)+1;
	$gift_array=array_chunk($gifts,$size,true);	
	$index=intval(get_args('index'));
	$gifts=$gift_array[$index];
	foreach($gifts as $gift)
	{
		echo "<div class='giftbox'><img title='".$gift['giftname']."' width=70 height=70 src='/".$gift['patch']."'/><span>".$gift['money']."&nbsp;<img src='/skin/default/jooyea/images/s_main_46.gif' style='vertical-align:middle;'/></span><input type='radio' name='gift_img' checked value='".$gift['id']."'/></div>";
	}
	if($totalpage>1)
	{
		$str="<div/><div id='gift_page_list' style='clear:both'>";
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
		$str="<div/><div id='gift_page_list' style='clear:both;height:20px'>";
		$str.="&nbsp;</div>";
		echo $str;
	}
}
?>
