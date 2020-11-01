<?php 
	//引入模块公共权限过程文件
	require("foundation/fpages_bar.php");
	require("foundation/module_mypals.php");
    require("foundation/auser_mustlogin.php");

	//引入语言包
	$mp_langpackage=new mypalslp;
    $u_langpackage=new userslp;
    $pu_langpackage=new publiclp;
	
	//数据表定义区
	$table='';
    $t_online=$tablePreStr."online";
	$t_users=$tablePreStr."users";
	$t_users_info=$tablePreStr."user_info";
	$t_users_information=$tablePreStr."user_information";
    $t_mood=$tablePreStr."mood";

	$dbo=new dbex();
	//定义读操作
	dbtarget('r',$dbServs);
	

	/*
	//选取用户额外信息的键值对
	$user_information_list=$dbo->getRs("select info_id,info_name from $t_users_information");
	$user_information_arr=array();
	foreach($user_information_list as $value){
		$user_information_arr[$value['info_id']]=$value['info_name'];
	}
	*/
	$page_num=trim(get_argg('page'));
	//$sql="select * from (select $t_users.user_id,$t_users.user_name,$t_users.user_sex,$t_users.user_ico,$t_users.birth_year,$t_users.user_group,$t_users.user_add_time,$t_mood.mood from $t_users left join $t_mood on $t_users.user_id=$t_mood.user_id  order by $t_mood.add_time desc) as tmp group by tmp.user_id order by tmp.user_add_time desc limit 12";
		
	$sql="select user_id,user_name,user_sex,birth_year,user_ico,user_group from $t_users order by user_id desc limit 12";
	//$dbo->setPages(12,$page_num);//设置分页
	$user_new_rs=$dbo->getRs($sql);
	
	//$page_total=$dbo->totalPage;//分页总数
	
	
	$dbo2=new dbex();
	//定义读操作
	dbtarget('r',$dbServs);
	$now_today=intval(date('Y'));
	//循环的取出每个会员的额外信息
	foreach($user_new_rs as $key=>$value){
		
        $online_info=$dbo2->getRs("select online_id from $t_online where user_id=".$value['user_id']);
         foreach($online_info as $k=>$v){
               $user_new_rs[$key]['online_id'] = $v['online_id']; 
            }
		
	}
	
   // print_r($user_new_rs);
	//控制显示
	$isset_data="";
	$none_data="content_none";
	$isNull=0;
	if(empty($user_new_rs)){
		$isset_data="content_none";
		$none_data="";
		$isNull=1;
	}	

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $user_name;?>-<?php echo $siteName;?></title>

<link href="skin/<?php echo $skinUrl;?>/css/layout.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo $skinUrl;?>/css/jy.css" rel="stylesheet" type="text/css" />
</head>

<body>
<!--头部开始-->
<?php require("uiparts/mainheader2.php");?>
<div class="hymenu">
<table width="1000" height="44" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="132"><img src="skin/<?php echo $skinUrl;?>/images/hy_menu_bgl.jpg" width="132" height="44" /></td>
    <td width="600">
	<div class="hymenu2">
	<ul>
	<li><a href="modules2.0.php?app=mypals_list" ><?php echo $mp_langpackage->mp_all_members;?></a></li>
	<li><a href="modules2.0.php?app=mypals_online" ><?php echo $mp_langpackage->mp_online_members;?></a></li>
	<li  class="hydqbj"><a href="modules2.0.php?app=mypals_search_new" style="color:#FFFFFF;"><?php echo $mp_langpackage->mp_new_members;?></a></li>
	<li><a href="modules2.0.php?app=mypals_search2"><?php echo $mp_langpackage->mp_search_members;?></a></li>
	<li><a href="modules2.0.php?app=article_list"><?php echo $mp_langpackage->mp_xingzuo;?></a></li>
	</ul>
	</div>
	</td>
    <td width="267"><img src="skin/<?php echo $skinUrl;?>/images/hy_menu_bgr.jpg" width="267" height="44" /></td>
  </tr>
</table>

</div>
<!--搜索行结束-->
<!--广告图开始-->
<div class="hyad01"><a href=""><img src="skin/<?php echo $skinUrl;?>/images/test28.jpg" /></a></div>
<!--广告图结束-->

<!--主体开始-->
<table width="1000" border="0" cellspacing="0" cellpadding="0" style="margin:5px auto;">
  <tr>
    <td width="784" valign="top">
	<div class="hyzxhy">
	<!--最新会员开始-->
<?php require("uiparts/search.php");?>

<div class="hyzxul">
<ul>
<?php foreach($user_new_rs as $rs){?>
<li>
<table width="305" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="95" align="center" valign="top" style="padding-right:5px;"><a href="home2.0.php?h=<?php echo $rs['user_id'];?>"><img src="<?php echo $rs['user_ico'];?>" width="88" height="97" border="0" /></a>
	<div class="hyzxzt"><a href="main.php?app=msg_creator&2id=<?php echo $rs['user_id'];?>&nw=2">
    <?php if($rs['online_id']){?>
    <img src="skin/<?php echo $skinUrl;?>/images/ico_zt_zx.jpg"/>
    <?php }?>
    <?php if($rs['online_id']==0){?>
     <img src="skin/<?php echo $skinUrl;?>/images/ico_zt_zx2.jpg"/>
     <?php }?>
    <?php if($rs['user_sex']==0){?>
    <?php echo $u_langpackage->u_chat_her;?>
    <?php }?>
    <?php if($rs['user_sex']==1){?>
    <?php echo $u_langpackage->u_chat_him;?>
    <?php }?></a></div>	<div class="hyzxp4"><a href="home2.0.php?h=<?php echo $rs['user_id'];?>"><?php echo $u_langpackage->u_details;?></a></div></td>
    <td width="210" align="left" valign="top">
	<div class="hyzxp1"><a href=""><?php echo $rs["user_name"];?></a></div>
	<div class="hy_hyxx">
	<table width="210" height="40" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="middle">
    <a href="javascript:void(0);">
	<?php if($rs['user_group']=='1'){?>
		<img src="skin/<?php echo $skinUrl;?>/images/xin/01.gif" border="0" />
	<?php }?>	
	<?php if($rs['user_group']=='2'){?>
		<img src="skin/<?php echo $skinUrl;?>/images/xin/02.gif" border="0" />
	<?php }?>
	<?php if($rs['user_group']=='3'){?>
		<img src="skin/<?php echo $skinUrl;?>/images/xin/03.gif" border="0" />
	<?php }?>
    </a></td>
    <td align="center" valign="middle" style="padding-bottom:10px;"><a href="main.php?app=msg_creator&2id=<?php echo $rs['user_id'];?>&nw=2"><img src="skin/<?php echo $skinUrl;?>/images/ico_hy_email.jpg" border="0" /></a></td>
    <td align="center" valign="middle" style="padding-bottom:2px;"><a href="javascript:void(0);" onclick="javascript:window.alert('Temporarily not opening, please look.');"><img src="skin/<?php echo $skinUrl;?>/images/ico_hy_xx.jpg" border="0" /></a></td>
    <td align="center" valign="middle" style="padding-bottom:4px;"><a href="/main.php?app=gift&uname=<?php echo $rs['user_name'];?>"><img src="skin/<?php echo $skinUrl;?>/images/ico_hy_gift.jpg" border="0" /></a></td>
	<td width="80">&nbsp;</td>
  </tr>
</table>
</div>
<div class="hyzxp2">
	<?php if(!empty($rs['birth_year'])){?>
		<?php echo $rs['birth_year'];?>
	<?php }?>	
	
	<?php if(!empty($rs['Country'])){?>
		<?php echo $rs['Country'];?>
	<?php }?>
	
	<?php if(!empty($rs['birth_province'])){?>
		<?php echo $rs['birth_province'];?>
	<?php }?>
	
	
	</div>
<div class="hyzxp3"></div>	</td>
  </tr>
</table>
</li>
<?php }?>
</ul><div class="clear"></div>
</div>
<!--最新会员结束-->
	</div>
<!--分页开始-->
  <div class="dede_pages">
<!--<?php echo page_show($isNull,$page_num,$page_total);?>-->
  </div>
<!-- 分页结束 -->
	</td>
    <td width="15">&nbsp;</td>
    <td align="left" valign="top" style="padding-top:10px;">
	<!--本周达人开始-->
 <?php require("uiparts/mainright.php");?>
	<!--浏览记录结束-->
	</td>
  </tr>
</table>

<!--主体结束-->

<!--底部开始-->
<div class="clear"></div>
 <?php require("uiparts/mainfooter.php");?>
<!--底部结束-->

</body>
</html>
