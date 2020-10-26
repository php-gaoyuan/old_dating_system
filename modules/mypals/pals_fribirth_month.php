<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/mypals/pals_fribirth_month.html
 * 如果您的模型要进行修改，请修改 models/modules/mypals/pals_fribirth_month.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
//必须登录才能浏览该页面
	require("foundation/auser_mustlogin.php");
	require("api/base_support.php");
	require("foundation/fcontent_format.php");
	//引入公共模块
	require("foundation/module_mypals.php");
	require("foundation/module_users.php");	
	require("foundation/fpages_bar.php");

	//引入语言包
	$mp_langpackage=new mypalslp;
	$monthArr = array(
		1=>"一月",
		2=>"二月",
		3=>"三月",
		4=>"四月",
		5=>"五月",
		6=>"六月",
		7=>"七月",
		8=>"八月",
		9=>"九月",
		10=>"十月",
		11=>"十一月",
		12=>"十二月",		
	);
	$send_hi="hi_action";
	$user_id=get_sess_userid();
	$page_num=trim(get_argg('page'));
	$month = intval(get_argg("month"));
	if (!$month){
		$month = date("n");
	}
	$firBirth = pals_friBirthMon($month,$user_id,$page_num,20);	
	$page_total = $firBirth[1];
	$isNull=0;
	if(empty($firBirth[0])){		
		$isNull=1;
		$fir_list =array();
	} else {
		$fir_list =$firBirth[0];
	}	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
<script type='text/javascript' src='servtools/ajax_client/ajax.js'></script>
<script type="text/javascript">parent.hiddenDiv();</script>
<script type="text/javascript">
	function changeStyle(obj,p_id){
		obj.className = 'hover';
	}
	function recoverStyle(obj,p_id){
		obj.className = '';
	}
</script>
</head>
<body id="iframecontent">
  <div class="create_button"><a href="modules2.0.php?app=mypals_search"><?php echo $mp_langpackage->mp_add;?></a></div>
  <h2 class="app_friend"><?php echo $mp_langpackage->mp_mypals;?></h2>
  <div class="tabs">
    <ul class="menu">
      <li class="active"><a href="javascript:void(0)" title="好友生日">好友生日</a></li>
      <li><a href="modules2.0.php?app=mypals" title="<?php echo $mp_langpackage->mp_list;?>"><?php echo $mp_langpackage->mp_list;?></a></li>
    </ul>
  </div>
  <div class="month_bar">
  	<ul>
    <?php foreach($monthArr as $key=>$val){?>
            <li><a <?php if($month==$key){?> class="active" <?php }?> href="modules2.0.php?app=mypals_fribirth_month&month=<?php echo $key;?>" target="frame_content"><span><?php echo $val;?></span></a></li>
    <?php }?>	
	</ul>
   </div> 
     <div id="mypals_iframe">
		<div id="fri_bir" class="friend_list">
			<ul class="user_list">
                <?php if(!empty($fir_list)){?>
                <?php foreach($fir_list as $val){?>
					<li onmouseover='changeStyle(this,<?php echo $val['user_id'];?>)' onmouseout='recoverStyle(this,<?php echo $val['user_id'];?>)'>
						<div class="photo">
						  <a href="home2.0.php?h=<?php echo $val['user_id'];?>" target="_blank" class="avatar">
							<img title="<?php echo $mp_langpackage->mp_en_home;?>" src="<?php echo $val['user_ico'];?>"  onerror="parent.pic_error(this)" /></a>
						</div>
						<dl>
							<dt><a target="_blank" href="home2.0.php?h=<?php echo $val['user_id'];?>" class="name"><?php echo $val['user_name'];?></a></dt>
                            <dd><?php echo $val['birth_month'];?>-<?php echo $val['birth_day'];?></dd>
                            <div class="tool" id="ctrl_<?php echo $val['user_id'];?>">
                                <a class="send_bt" href='modules2.0.php?app=msg_creator&2id=<?php echo $val["user_id"];?>&nw=1' target="frame_content" title='<?php echo str_replace("{he}",get_TP_pals_sex($val["user_sex"]),$mp_langpackage->mp_scrip);?>'></a>
                            </div>
						</dl>
					</li>
                <?php }?>
                <?php }?>
			</ul>
		</div>
  </div>
<div class="clear"></div>
<?php echo page_show($isNull,$page_num,$page_total);?>
</div>
</body>
</html>