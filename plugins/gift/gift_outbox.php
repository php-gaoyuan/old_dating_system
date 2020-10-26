<?php
//打开get和post的封装
$getpost_power=true;
//打开系统库的支持
$iweb_power=true;
//打开session
$session_power=true;
//引入系统文件的支持文件
include_once(dirname(__file__)."/../includes.php");
//引入自己的配制文件
include_once(dirname(__file__)."/config.php");
include_once("../../includes.php");
include_once("../../foundation/fpages_bar.php");
//引入语言包
$gf_langpackage=new giftlp;
//得到表名
$order=$table_prefix."order";
//创建系统对数据库进行操作的对象
$dbo=new dbex();
//对数据进行读写分离，读操作
dbplugin('r');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">
    #zishu{margin-bottom: -1px;}
    #zishu li{list-style:none;display:inline-block;}
    #zishu .nav_a a{font-size:14px;text-decoration:none;display:block;background:#03a0d7;color:#fff;border:1px solid #C2D9F2;padding:5px 15px;}
    #zishu .nav_a.active a{color:#03a0d7;background:#fff;margin-top:3px;}
    #gift_list{width: 805px;border:#C2D9F2 solid 1px;margin-bottom:10px;padding:5px;}
    #gift_friends{clear:both;border:1px solid #C2D9F2;position:absolute;display:none;left: 68px;*left: 70px;top: 45px;width: 86%;background:#FFFFFF;}
    #gift_info{background:none repeat scroll 0 0 #ce1221;border:1px solid #EBDBA5;margin-bottom:10px;display:none;padding:9px 100px;width:62%;color:#fff;}
    #gift_list .giftbox{width:185px;float:left;text-align:center;font-size:12px;margin-left:7px;height: 210px;}
    #gift_list .giftbox *{border:none}
    #gift_list .giftbox img:hover{cursor:pointer;filter:alpha(opacity=50);-moz-opacity:0.5;opacity: 0.5;}
    #gift_list .giftbox .gift_img{width:180px;height:150px;border:1px solid #FAFAFA;}
    #gift_list .giftbox .gift_img:hover{border:1px solid #FF931B;}
    #gift_list .giftbox a{color:#444;text-decoration:none}
    #gift_list .giftbox a:hover{color:#2C589E;}
    #gift_list span{display:block;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;}
    #gift_page_list{float:right;text-align:center;margin:10px 0 5px 0;width:100%;}
    #gift_page_list a{display:block;width:20px;height:20px;line-height:20px;float:left;border:1px #0096c6 solid;text-decoration:none;margin:0 5px;background-color:#dee7f7;color:#000;}
    #gift_page_list a.active{background-color:#0096c6;color:#fff;}
    .tabs{border-bottom: 1px solid #ce1221;height: 26px;margin-top: 20px;position: relative;outline: medium none;}
    .tabs li.active{-moz-border-bottom-colors: none;-moz-border-left-colors: none;-moz-border-right-colors: none;-moz-border-top-colors: none;background-color: #FFFFFF;border-color: #ce1221 #ce1221 -moz-use-text-color;border-image: none;border-style: solid solid none;border-width: 1px 1px 0;color: #ce1221;font-weight: bold;text-decoration: none;word-break: keep-all;}
    .tabs li{}
    .tabs li{background-color: #ce1221;color: #FFFFFF;float: left;height: 26px;margin-right: 8px;}
    .tabs li.active a{color: #ce1221;text-decoration: none;}
    .tabs li a{color: #FFFFFF;display: block;height: 18px;padding: 6px 19px 0;text-decoration: none;}
    .menu{list-style: none outside none;margin:0px;padding:0px;}
    .giftshop_tit:hover{color:#2C589E;}

    li#active{background:#fff;}li#active a{color:#A33F3F}li a{color:#fff}
</style>
<script type="text/javascript" src="/plugins/gift/Common.js"></script>
<script type="text/javascript" src="/servtools/dialog/zDrag.js"></script>
<script type="text/javascript" src="/servtools/dialog/zDialog.js"></script>
<script>
function changeStyle_gift(_this){
    var tabList = document.getElementById('zishu').getElementsByTagName('li');
    for(i=0;i<tabList.length;i++){
        tabList[i].classList.remove("active");
    }
    _this.classList.add("active");
}
function getGifts(type,index)
{
    //调用系统的Ajax类
    ajax=new Ajax();
    ajax.getInfo("/plugins/gift/giftshop_list.php","post","get","type="+type+"&index="+index,"gift_list");
}
</script>
</head>

<body>
<div>
    <ul id="zishu">
        <li class="nav_a" onclick="getGifts(4);changeStyle_gift(this);"><a href="javascript:;"><?php echo $gf_langpackage->gf_xn; ?></a></li>
        <li class="nav_a"><a href="/plugins/gift/gift_box.php"><?php echo $gf_langpackage->gf_putin; ?></a></li>
        <li class="nav_a active"><a href="/plugins/gift/gift_outbox.php"><?php echo $gf_langpackage->gf_putout; ?></a></li>
    </ul>
</div>
<?php
if(get_sess_userid())
{
	//查询用户的礼品
	$page_num=trim(get_argg('page'));
	//查询用户的礼品
	$dbo->setPages(6,$page_num);//设置分页	
	$sql="select * from ".$order." where send_id=".get_sess_userid();
	$rows=$dbo->getRs($sql);
	$page_total=$dbo->totalPage;//分页总数
	$no_accept="";
	$accept="";
	//echo "<div style='clear:both;height:45px;border-bottom:1px #ccc solid;line-height:25px;margin-bottom:5px;'><img onclick=\"location='".self_url(__file__)."gift.php';\" src='".self_url(__file__)."send.gif' title='赠送礼品'/></div><div id='gift_list'>";
	echo "</div><div id='gift_list'>";
	if(count($rows)>0)
	{
		foreach($rows as $row)
		{
			//分别取出接收和未接收的礼品
			
			if($row['is_see']==0)$no_accept.="<div style='clear:both;height:85px;border-bottom:1px #ccc solid;line-height:25px;margin-bottom:5px;'><img style='display:block;float:left' src='/{$row['gift']}'/><span style='float:left;display:block;padding-left:10px;'>".$gf_langpackage->gf_mess_16.$row['send_time'].$gf_langpackage->gf_mess_17."<b>[{$row['accept_name']}]</b>".$gf_langpackage->gf_mess_18."<br />".$gf_langpackage->gf_zengyan."：$row[msg]</span></div>";
			else $accept.="<div style='clear:both;height:85px;border-bottom:1px #ccc solid;line-height:25px;margin-bottom:5px;'><img style='display:block;float:left' src='/{$row['gift']}'/><span style='float:left;display:block;padding-left:10px;'>".$gf_langpackage->gf_mess_16.$row['send_time'].$gf_langpackage->gf_mess_17."<b>[{$row['send_name']}]</b>".$gf_langpackage->gf_mess_18."<br />".$gf_langpackage->gf_zengyan."：$row[msg]</span></div>";
		}
	}
	echo $no_accept;
	echo "";
	echo $accept;
	if(count($rows)>0)
	{
		echo page_show(0,$page_num,$page_total);
	}
	echo "<div>";
}
?>
</body>
</html>
