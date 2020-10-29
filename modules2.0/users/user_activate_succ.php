<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/users/user_activate_succ.html
 * 如果您的模型要进行修改，请修改 models/modules/users/user_activate_succ.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php

$u_langpackage=new userslp;
//激活码发送成功后跳转至此页面
$mail =array(
	'qq.com'=>"http://mail.qq.com",
	'163.com'=>"http://mail.163.com",
	'126.com'=>"http://mail.126.com",
	'188.com'=>"http://mail.188.com",
	'139.com'=>"http://mail.139.com",
	'sohu.com'=>"http://mail.sohu.com",
	'sina.com'=>"http://mail.sina.com",
	'sina.com.cn'=>"http://mail.sina.com.cn",
	'gmail.com'=>"http://mail.gmail.com"
);
$user_email = short_check(get_argg('user_email'));
preg_match("/(.*?)@(.*)/",$user_email,$mail_add);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" href="skin/<?php echo $skinUrl;?>/css/layout.css" />
</head>
<body id="iframecontent">

<div class="mail_sess_box">
	<a href='index.php'><?php echo $u_langpackage->zc_fanhuishouye;?></a>
    <div class="mail_sess">
        <p class="txt"><?php echo $u_langpackage->zc_jihuo;?> <?php echo $user_email;?><br></p>
        <p><a href="<?php if(in_array($mail_add[2],array_keys($mail))){?><?php echo $mail[$mail_add[2]];?><?php }?><?php if(!in_array($mail_add[2],array_keys($mail))){?><?php echo 'http://www.'.$mail_add[2];?><?php }?>" class="mail_sess_but"><?php echo $u_langpackage->zc_chakan;?></a></p>
    </div>
    <div class="mail_step">
        <p class="txt"><?php echo $u_langpackage->zc_meishoudao;?></p>
        <ul>
            <li><?php echo $u_langpackage->zc_changshi;?></li>
            <li><?php echo $u_langpackage->zc_baoqian;?><a href="/"><?php echo $u_langpackage->zc_chongxinzc;?></a></li>
            <li><?php echo $u_langpackage->zc_huozhe;?><a href='do.php?act=user_activation&user_email=<?php echo $user_email;?>'><?php echo $u_langpackage->zc_chongxin;?></a></li>
            <li><?php echo $u_langpackage->zc_huozhe;?><a href='index.php'><?php echo $u_langpackage->zc_fanhuishouye;?></a></li>
        </ul>
    </div>
</div>
<?php require('uiparts/footor.php');?>
<script>


    // 计算页面的实际高度，iframe自适应会用到
    function calcPageHeight(doc) {
        var cHeight = Math.max(doc.body.clientHeight, doc.documentElement.clientHeight)
        var sHeight = Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight)
        var height  = Math.max(cHeight, sHeight)
        return height
    }
    window.onload = function() {
        var height = calcPageHeight(document);
        parent.document.getElementById('ifr').style.height = height +50+ 'px'   ;
		
		  
    }

</script>
</body>
</html>