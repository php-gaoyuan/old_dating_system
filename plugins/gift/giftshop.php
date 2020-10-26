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

//创建系统对数据库进行操作的对象
$dbo=new dbex();
dbplugin('r');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="/plugins/gift/Common.js"></script>
<script type="text/javascript" src="/servtools/dialog/zDrag.js"></script>
<script type="text/javascript" src="/servtools/dialog/zDialog.js"></script>
<title></title>
<style type="text/css">
#zishu{margin-bottom: -1px;margin-top:0;}
#zishu li{list-style:none;display:inline-block;}
#zishu .nav_a a{font-size:14px;text-decoration:none;display:block;background:#03a0d7;color:#fff;border:1px solid #C2D9F2;padding:5px 15px;}
#zishu .nav_a.active a{color:#03a0d7;background:#fff;margin-top:3px;}
#gift_list{width: 805px;border:#C2D9F2 solid 1px;margin-bottom:10px;padding:5px;}
#gift_friends{clear:both;border:1px solid #C2D9F2;position:absolute;display:none;left: 68px;*left: 70px;top: 45px;width: 86%;background:#FFFFFF;}
#gift_info{background:none repeat scroll 0 0 #ce1221;border:1px solid #EBDBA5;margin-bottom:10px;display:none;padding:9px 100px;width:62%;color:#fff;}
#gift_list .giftbox{width:185px;float:left;text-align:center;font-size:12px;margin-left:7px;height: 210px;}
#gift_list .giftbox:after{display:block;clear:both;}
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
</style>
</head>

<body>
<table style="color:#333333;width:100%;border:0;">
  <tr>
	<td>
		<ul id="zishu">
		  <li class="nav_a active"><a href="javascript:;" onclick="getGifts(4);"><?php echo $gf_langpackage->gf_xn;?></a></li>
		  <li class="nav_a"><a href="/plugins/gift/gift_box.php"><?php echo $gf_langpackage->gf_putin;?></a></li>
		  <li class="nav_a"><a href="/plugins/gift/gift_outbox.php"><?php echo $gf_langpackage->gf_putout;?></a></li>
		</ul>
		<div id="gift_list"></div>
	</td>
  </tr>
</table>

<script>
function getGifts(type, index) {
    ajax = new Ajax();
    ajax.getInfo("/plugins/gift/giftshop_list.php?r=<?php echo rand();?>", "post", "get", "type=" + type + "&index=" + index, "gift_list");
}
function calcPageHeight(doc) {
    var cHeight = Math.max(doc.body.clientHeight, doc.documentElement.clientHeight);
    var sHeight = Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight);
    var height = Math.max(cHeight, sHeight);
    return height;
}
window.onload = function() {
    var height = calcPageHeight(document);
    parent.document.getElementById('ifr').style.height = height + 800 + 'px';
    getGifts(4);
}
</script>
</body>
</html>

