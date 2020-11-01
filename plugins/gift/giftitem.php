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
a:hover{text-decoration:underline;color:#2C589E;}
.giftitem_top{height:30px;text-align:right;line-height:30px;border-bottom:1px solid #E5E5E5;}
.giftitem_top a{display:inline-block;}
.giftitem_top i{display:inline-block;float:left;width:19px;height:18px;background:url(icon_01.png) 0 -206px no-repeat;position:relative;top:5px;}
.giftitem_top span{display:inline-block;float:left;}
.giftitem_name{width:100%;height:42px;line-height:42px;font-weight:bold;font-size:16px;float:left;}
.giftitem_img{float:left;width:256px;/*height:256px;*/padding:2px;border:1px solid #C1EBFF;}
.giftitem_img img{width:256px;height:256px;}
ul#small_pic{margin:0;padding:0px;}
ul#small_pic li{display: inline-block;width: 22%;height: 60px;padding:2px;cursor: pointer;}
ul#small_pic li img{width: 60px;height: 60px;}
.giftitem_right{width:330px;height:258px;float:right;padding:2px;}
.giftitem_right_s , b{color:#999;height:40px;line-height:40px;}
.giftitem_right_s span{color:#FF6500;font-size:20px;font-weight:bold;font-family:黑体}
.giftitem_right_s i{display:inline-block;width:16px;height:16px;background:url(ico.png) no-repeat;}
.giftitem_right_num{height:120px;background:#F1F1F2;border:1px solid #F3F3F3;padding:10px;}
.giftitem_right_num input{text-align:center;}
.giftitem_right_num big{display:inline-block;text-align:center;line-height:16px;height:16px;width:16px;border:1px solid #C0C0C0;cursor:pointer;}
.giftitem_right_num big:hover{border:1px solid #FF6500;background:#fff;}
.giftitem_right_num #gobuy{width:120px;height:37px;margin-top:20px;cursor:pointer;font-size:19px;line-height:34px;background:url(czbtn.png) -10px 0 repeat-x;border:none;color:#fff;}
#xiangqing img{max-width:620px;}
</style>
</head>
<body>
	<div class="giftitem_top">
		<i></i><span><?php echo $gf_langpackage->gf_xiangqing;?></span><a href="giftshop.php"><?php echo $gf_langpackage->gf_fanhui;?></a>
	</div>
	<div class="giftitem_name"><?php echo $gifts['giftname'];?></div>
	<div style="float: left;">
	<div class="giftitem_img" id="enlarge" src="/<?php echo $yuanpatchs[0];?>">
		<img src="/rootimg.php?src=/<?php echo $yuanpatchs[0];?>&h=256&w=256&zc=1" />
		
	</div>
	<ul id="small_pic">
			<?php foreach ($yuanpatchs as $key => $value) { if($key<4){?>
			<li> <img src="/<?php echo $value;?>" alt="" /></li>
			<?php }} ?>
		</ul></div>
	<div class="giftitem_right">
		<div class="giftitem_right_s"><b><?php echo $gf_langpackage->gf_jiage;?>:</b><span><i></i><?php echo $gifts['money'];?></span></div>
		<!--<div class="giftitem_right_s"><b><?php echo $gf_langpackage->gf_caizhi;?>:</b><?php echo $gifts['caizhi'];?></div>-->
		<div class="giftitem_right_num">
			<div><b><?php echo $gf_langpackage->gf_shuliang;?>:</b><big onclick="check_item_num(-1)">-</big><input id="item_num" type="text" value="1" size="3" /><big onclick="check_item_num(1)">+</big></div>
			<div><button id="gobuy"><?php echo $gf_langpackage->gf_goumai;?></button></div>
			<input type="hidden" id="itemid" value="<?php echo $_GET['id']; ?>" />
		</div>
	</div>
	<!--<div  class="giftitem_name" style="border-bottom:1px solid #A33F3F;height:25px;margin-top:10px;"><span style="display:inline-block;padding:0px 15px;color:#fff;background:#A33F3F;margin-left:10px;height:25px;line-height:27px"><?php echo $gf_langpackage->gf_xiangqing;?></span></div>
	<div style="width:100%;float:left;padding:10px;color:#666;" id="xiangqing">
        <?php
        $contentByRoot = $gifts['desc'];    //获取文章内容
        $pattern = '/<p><img\ssrc=\"(.*)\"/isU';
        preg_match_all($pattern, $contentByRoot, $matches);
        $rootImageSize = array();
        $rDomain = $_SERVER['SERVER_NAME'] ? $_SERVER['HTTP_HOST'] : "/";
        for ($i = 0; $i < count($matches[1]); $i++) {
        $strTrueAll = $rDomain . $matches[1][$i];
        $strTrueAll = "http://" . $strTrueAll;
        $rootImageSize[$i]['path'] = $strTrueAll;   //由此:$rootImageSize 是一个2维3个下标的数组
        }

        $i = 0;
        function reImage($matches)
        {     //example: src="/uploadfiles/article/20140505/13992621165363.jpg" style="float:none;width:800px;height:600px;" width="800" height="600" border="0" hspace="0" vspace="0" />
        global $i;
        global $rootImageSize;
        $matches = "<p><img src='/rootimg.php?src=/{$rootImageSize[$i]['path']}&h=&w=620&zc=1'/></p>";//注意src前面有个空格
        $i++;
        return $matches;
        }

        $pattern = '/<p><img(.*)<\/p>/isU';
        preg_match_all($pattern, $contentByRoot, $matches);
        $contentByRoot = preg_replace_callback($pattern, "reImage", $contentByRoot);
        echo $contentByRoot;
        ?>
	</div>-->
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
		$("#enlarge>img").attr("src","/rootimg.php?src="+_src+"&h=256&w=256&zc=1");
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


	  // 计算页面的实际高度，iframe自适应会用到
    function calcPageHeight(doc) {
        var cHeight = Math.max(doc.body.clientHeight, doc.documentElement.clientHeight)
        var sHeight = Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight)
        var height  = Math.max(cHeight, sHeight)
        return height
    }

	
    window.onload = function() {
        var height = calcPageHeight(document);
        parent.document.getElementById('ifr').style.height = height + 'px'   ;
    }
</script>
</body>
</html>
