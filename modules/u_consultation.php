<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/u_consultation.html
 * 如果您的模型要进行修改，请修改 models/modules/u_consultation.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>咨询聊天-<?php echo $user_name;?>-<?php echo $siteName;?></title>
<base href='<?php echo $siteDomain;?>' />
<?php $plugins=unserialize('a:0:{}');?>

<script language=JavaScript src="skin/<?php echo $skinUrl;?>/jquery-1.9.1.min.js"></script>
<script language=JavaScript src="skin/<?php echo $skinUrl;?>/cfcoda.js"></script>
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/custom.css" />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/chat.css" />
<script language=JavaScript src="skin/<?php echo $skinUrl;?>/custom.js"></script>
<script language=JavaScript src="skin/<?php echo $skinUrl;?>/effect_commonv1.1.js"></script>
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/layout.css">
<script type="text/javascript" src="skin/default/js/jy.js"></script>
<script type="text/javascript" src="skin/default/js/jooyea.js"></script>
<script type='text/javascript' src="servtools/imgfix.js"></script>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDrag.js"></script>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDialog.js"></script>
<script type="text/javascript" language="javascript" src="servtools/calendar.js"></script>
<script type="text/javascript" src="servtools/ajax_client/ajax.js"></script>
<script type="text/javascript" language="javascript" src="skin/default/js/iframeautoh.js"></script>


<script type="text/javascript" language="javascript">
        $(function () {
			
            var $menu_li = $("div.menu ul li");
            $menu_li.click(function () {
                $(this).addClass("selected")
		    .siblings().removeClass("selected");
                var index = $menu_li.index($(this));
                $("div.box>div")
		    .eq(index).show()
			.siblings().hide();
            });
			var $menu2_li = $("div.menu2 ul li");
			$menu2_li.click(function () {
				$(this).addClass("selected")
				.siblings().removeClass("selected");
				var index = $menu2_li.index($(this));
				$("div.content>div")
				.eq(index).show()
				.siblings().hide();
			});
        });
</script>

</head>
<?php
header("content-type:text/html;charset=utf-8");
require("foundation/asession.php");
require("configuration.php");
require("includes.php");

//语言包引入
$u_langpackage=new userslp;
$ef_langpackage=new event_frontlp;
$mn_langpackage=new menulp;
$pu_langpackage=new publiclp;
$mp_langpackage=new mypalslp;
$s_langpackage=new sharelp;
$hi_langpackage=new hilp;
$l_langpackage=new loginlp;
$rp_langpackage=new reportlp;
$ah_langpackage=new arrayhomelp;

$user_id=get_sess_userid();
$user_name=get_sess_username();
?>
<body>
<input type="hidden" value="" id="restore" />
<div class="container">
  <?php require("uiparts/mainheader.php");?>
  <div class="wrapper" style="width:1000px">
    <div class="main" style="background:none;min-height:200px;">
		<div id="center1">
       <div class="pic">
          <a href="#"><img src="skin/<?php echo $skinUrl;?>/images/pic1.png"/></a>
          <a href="#"><img src="skin/<?php echo $skinUrl;?>/images/pic2.png"/></a>
          <a href="#"><img src="skin/<?php echo $skinUrl;?>/images/pic3.png"/></a>
          <a href="#"><img src="skin/<?php echo $skinUrl;?>/images/pic4.png"/></a>
       </div>
    </div>
    <div id="best">
        <div class="title">
           <img src="skin/<?php echo $skinUrl;?>/images/tag1.png"/>
           <h1>最佳客服</h1>
        </div>
        <div class="menu">
           <ul>
              <li class="selected">首页</li>
              <li>中华美食区</li>
              <li>心理减压室</li>
              <li>旅游百事通</li>
              <li>华夏文史馆</li>
            </ul>
        </div>
        <div class="clear"></div>
        <hr/>
        <div  class="box">
           <div class="display1">
              <a>首页</a>
           </div>
           <div class="hide">中华美食区</div>
           <div class="hide">心理减压室</div>
           <div class="hide">旅游百事通</div>
           <div class="hide">华夏文史馆</div>
        </div>
    </div>
    <div id="service">
       <div class="title">
          <img src="skin/<?php echo $skinUrl;?>/images/tag2.png"/>
          <h1>客服动态</h1>
       </div>
       <div class="clear"></div>
       <hr/>
       <div class="content">
          <table>
          <tbody>
             <tr>
                <td><img src="skin/<?php echo $skinUrl;?>/images/people2.png"/></td>
                <td><img src="skin/<?php echo $skinUrl;?>/images/people2.png"/></td>
                <td><img src="skin/<?php echo $skinUrl;?>/images/people2.png"/></td>
                <td><img src="skin/<?php echo $skinUrl;?>/images/people2.png"/></td>
                <td style=" border-right-width:0px;"><img src="skin/<?php echo $skinUrl;?>/images/people2.png"/></td>
             </tr>
             <tr>
                <td>Angel</td>
                <td>Angel</td>
                <td>Angel</td>
                <td>Angel</td>
                <td style=" border-right-width:0px;">Angel</td>
             </tr>
             <tr>
                <td>身心休闲室<br />成功与Rainy用<br />户完成咨询服务</td><br />
                <td>身心休闲室<br />成功与Rainy用<br />户完成咨询服务</td>
                <td>身心休闲室<br />成功与Rainy用<br />户完成咨询服务</td>
                <td>身心休闲室<br />成功与Rainy用<br />户完成咨询服务</td>
                <td style=" border-right-width:0px;">身心休闲室<br />成功与Rainy用<br />户完成咨询服务</td>
             </tr>
             <tr>
                <td><img src="skin/<?php echo $skinUrl;?>/images/blackfoot.png"/>2013-12-21 14:37:20</td>
                <td><img src="skin/<?php echo $skinUrl;?>/images/blackfoot.png"/>2013-12-21 14:37:20</td>
                <td><img src="skin/<?php echo $skinUrl;?>/images/blackfoot.png"/>2013-12-21 14:37:20</td>
                <td><img src="skin/<?php echo $skinUrl;?>/images/blackfoot.png"/>2013-12-21 14:37:20</td>
                <td style=" border-right-width:0px;"><img src="skin/<?php echo $skinUrl;?>/images/blackfoot.png"/>2013-12-21 14:37:20</td>
             </tr>
             <tr>
                <td><hr /></td>
                <td><hr /></td>
                <td><hr /></td>
                <td><hr /></td>
                <td style=" border-right-width:0px;"><hr /></td>
             </tr>
             <tr>
                <td style="padding-top: 20px;"><img src="skin/<?php echo $skinUrl;?>/images/people2.png"/></td>
                <td style="padding-top: 20px;"><img src="skin/<?php echo $skinUrl;?>/images/people2.png"/></td>
                <td style="padding-top: 20px;"><img src="skin/<?php echo $skinUrl;?>/images/people2.png"/></td>
                <td style="padding-top: 20px;"><img src="skin/<?php echo $skinUrl;?>/images/people2.png"/></td>
                <td style="padding-top: 20px;border-right-width:0px;"><img src="skin/<?php echo $skinUrl;?>/images/people2.png"/></td>
             </tr>
             <tr>
                <td>Angel</td>
                <td>Angel</td>
                <td>Angel</td>
                <td>Angel</td>
                <td style=" border-right-width:0px;">Angel</td>
             </tr>
             <tr>
                <td>身心休闲室<br />成功与Rainy用<br />户完成咨询服务</td><br />
                <td>身心休闲室<br />成功与Rainy用<br />户完成咨询服务</td>
                <td>身心休闲室<br />成功与Rainy用<br />户完成咨询服务</td>
                <td>身心休闲室<br />成功与Rainy用<br />户完成咨询服务</td>
                <td style=" border-right-width:0px;">身心休闲室<br />成功与Rainy用<br />户完成咨询服务</td>
             </tr>
             <tr>
                <td><img src="skin/<?php echo $skinUrl;?>/images/blackfoot.png"/>2013-12-21 14:37:20</td>
                <td><img src="skin/<?php echo $skinUrl;?>/images/blackfoot.png"/>2013-12-21 14:37:20</td>
                <td><img src="skin/<?php echo $skinUrl;?>/images/blackfoot.png"/>2013-12-21 14:37:20</td>
                <td><img src="skin/<?php echo $skinUrl;?>/images/blackfoot.png"/>2013-12-21 14:37:20</td>
                <td style=" border-right-width:0px;"><img src="skin/<?php echo $skinUrl;?>/images/blackfoot.png"/>2013-12-21 14:37:20</td>
             </tr>
             <tr>
                <td><hr /></td>
                <td><hr /></td>
                <td><hr /></td>
                <td><hr /></td>
                <td style=" border-right-width:0px;"><hr /></td>
             </tr>
             </tbody>
          </table>
       </div>
    </div>
    <div id="problem">
       <div class="title">
          <img src="skin/<?php echo $skinUrl;?>/images/tag3.png"/>
          <h1>常见问题</h1>
       </div>
       <div class="menu2">
           <ul>
              <li class="selected">首页</li>
              <li>中华美食区</li>
              <li>心理减压室</li>
              <li>旅游百事通</li>
              <li>华夏文史馆</li>
              <div class="clear"></div>
            </ul>
        </div>
        <div class="clear"></div>
        <hr/>
        <div class="content">
           <div class="index">
           <table>
               <tbody>
                    <tr>
                       <td style="width:350px;border-bottom:1px dashed #B0B0B0;">
                          <ul style="line-height:30px;">
                             <li>有关的民间传说</li>
                             <li>七夕你想送她什么礼物，知道每个礼物的含义吗？</li>
                             <li>交友禁忌大总结</li>
                             <li>交友必知</li>
                             <li>交友秘籍</li>
                          </ul>
                       </td>
                       <td style="width:130px;border-bottom:1px dashed #B0B0B0;">
                          <ul style="list-style-type:none;line-height:30px;">
                             <li>2013-8-13</li>
                             <li>2013-8-13</li>
                             <li>2013-8-13</li>
                             <li>2013-8-13</li>
                             <li>2013-8-13</li>
                          </ul>
                       </td>
                       <td style="width:350px;border-bottom:1px dashed #B0B0B0;">
                          <ul style="line-height:30px;">
                             <li>有关的民间传说</li>
                             <li>七夕你想送她什么礼物，知道每个礼物的含义吗？</li>
                             <li>交友禁忌大总结</li>
                             <li>交友必知</li>
                             <li>交友秘籍</li>
                          </ul>
                       </td>
                       <td style="width:130px;">
                          <ul style="list-style-type:none;line-height:30px;">
                             <li>2013-8-13</li>
                             <li>2013-8-13</li>
                             <li>2013-8-13</li>
                             <li>2013-8-13</li>
                             <li>2013-8-13</li>
                          </ul>
                       </td>
                    </tr>
                    
                    <tr>
                       <td style="width:350px;">
                          <ul style="line-height:30px;">
                             <li>有关的民间传说</li>
                             <li>七夕你想送她什么礼物，知道每个礼物的含义吗？</li>
                             <li>交友禁忌大总结</li>
                             <li>交友必知</li>
                             <li>交友秘籍</li>
                          </ul>
                       </td>
                       <td style="width:130px;">
                          <ul style="list-style-type:none;line-height:30px;">
                             <li>2013-8-13</li>
                             <li>2013-8-13</li>
                             <li>2013-8-13</li>
                             <li>2013-8-13</li>
                             <li>2013-8-13</li>
                          </ul>
                       </td>
                       <td style="width:350px;">
                          <ul style="line-height:30px;">
                             <li>有关的民间传说</li>
                             <li>七夕你想送她什么礼物，知道每个礼物的含义吗？</li>
                             <li>交友禁忌大总结</li>
                             <li>交友必知</li>
                             <li>交友秘籍</li>
                          </ul>
                       </td>
                       <td style="width:130px;">
                          <ul style="list-style-type:none;line-height:30px;">
                             <li>2013-8-13</li>
                             <li>2013-8-13</li>
                             <li>2013-8-13</li>
                             <li>2013-8-13</li>
                             <li>2013-8-13</li>
                          </ul>
                       </td>
                    </tr>
               </tbody>
           </table>
           </div>
           <div class="hide">中华美食区</div>
           <div class="hide">心理减压室</div>
           <div class="hide">旅游百事通</div>
           <div class="hide">华夏文史馆</div>
        </div>
    </div>
    <div id="user">
       <div class="title">
          <img src="skin/<?php echo $skinUrl;?>/images/tag4.png"/>
          <h1>用户动态</h1>
       </div>
       <div class="clear"></div>
       <hr/>
       <div class="content">
          <table>
             <tr>
                <td><img src="skin/<?php echo $skinUrl;?>/images/people3.png"/></td>
                <td><img src="skin/<?php echo $skinUrl;?>/images/people3.png"/></td>
                <td><img src="skin/<?php echo $skinUrl;?>/images/people3.png"/></td>
                <td><img src="skin/<?php echo $skinUrl;?>/images/people3.png"/></td>
                <td style=" border-right-width:0px;"><img src="skin/<?php echo $skinUrl;?>/images/people3.png"/></td>
             </tr>
             <tr>
                <td>Angel</td>
                <td>Angel</td>
                <td>Angel</td>
                <td>Angel</td>
                <td style=" border-right-width:0px;">Angel</td>
             </tr>
             <tr>
                <td>身心休闲室<br />成功与Rainy用<br />户完成咨询服务</td><br />
                <td>身心休闲室<br />成功与Rainy用<br />户完成咨询服务</td>
                <td>身心休闲室<br />成功与Rainy用<br />户完成咨询服务</td>
                <td>身心休闲室<br />成功与Rainy用<br />户完成咨询服务</td>
                <td style=" border-right-width:0px;">身心休闲室<br />成功与Rainy用<br />户完成咨询服务</td>
             </tr>
             <tr>
                <td><img src="skin/<?php echo $skinUrl;?>/images/greenfoot.png"/>2013-12-21 14:37:20</td>
                <td><img src="skin/<?php echo $skinUrl;?>/images/greenfoot.png"/>2013-12-21 14:37:20</td>
                <td><img src="skin/<?php echo $skinUrl;?>/images/greenfoot.png"/>2013-12-21 14:37:20</td>
                <td><img src="skin/<?php echo $skinUrl;?>/images/greenfoot.png"/>2013-12-21 14:37:20</td>
                <td style=" border-right-width:0px;"><img src="skin/<?php echo $skinUrl;?>/images/greenfoot.png"/>2013-12-21 14:37:20</td>
             </tr>
             <tr>
                <td><hr /></td>
                <td><hr /></td>
                <td><hr /></td>
                <td><hr /></td>
                <td style=" border-right-width:0px;"><hr /></td>
             </tr>
          </table>
       </div>
   </div>
    </div>
   
  </div>
  <?php require("uiparts/footor.php");?>
</div>

<script language=JavaScript src="servtools/ajax_client/auto_ajax.js"></script>
<script language="JavaScript" src="im/im_forsns_js.php"></script>
</body>
</html>