<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/mypals/search_pals_list2.html
 * 如果您的模型要进行修改，请修改 models/modules/mypals/search_pals_list2.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
/*
 * 此段代码由debug模式下生成运行，请勿改动！
 * 如果debug模式下出错不能再次自动编译时，请进入后台手动编译！
 */
/* debug模式运行生成代码 开始 */
if(!function_exists("tpl_engine")) {
	require("foundation/ftpl_compile.php");
}
if(filemtime("templates/default/modules/mypals/search_pals_list2.html") > filemtime(__file__) || (file_exists("models/modules/mypals/search_pals_list2.php") && filemtime("models/modules/mypals/search_pals_list2.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/mypals/search_pals_list2.html",1);
	include(__file__);
}else {
/* debug模式运行生成代码 结束 */
?><?php
	//引入模块公共权限过程文件
	require("foundation/fpages_bar.php");
	require("foundation/module_mypals.php");
    require("foundation/auser_mustlogin.php");

	//引入语言包
	$mp_langpackage=new mypalslp;
    $u_langpackage=new userslp;
    $pu_langpackage=new publiclp;

	$search_name=short_check(get_argg('memName'));
	$is_online=intval(get_argg('online'));
	$q_province=short_check(get_argg('q_province'));
	$q_city=short_check(get_argg('q_city'));
	$s_province=short_check(get_argg('s_province'));
	$s_city=short_check(get_argg('s_city'));
	
	$age=short_check(get_argg('age'));   
	$min_age=short_check(get_argg('min_age'));
	$max_age=short_check(get_argg('max_age'));
	$sex=short_check(get_argg('sex'));
	$type=short_check(get_argg('type'));	
	$memName=short_check(get_argg("memName"));	
	$user_id=get_sess_userid();	
	$user_name=get_sess_username();
	$user_sex=get_sess_usersex();
	$cols=" user_id <>'$user_id' ";
	$is_login=1;
	$send_script_js="location.href='modules.php?app=msg_creator&2id={uid}&nw=1';";
	$send_join_js="mypals_add({uid});";
	$error_str=$mp_langpackage->mp_no_search;
	$target="frame_content";
	if(empty($user_id)||$type=='index'){
		$is_login=0;
		$send_script_js="goLogin();";
		$send_join_js="goLogin();";
		$error_str=$mp_langpackage->mp_search_none;
		$target="";
	}
	//数据表定义区
	$table='';
	$t_users=$tablePreStr."users";
	$t_mypals=$tablePreStr."pals_mine";
	$t_pals_request=$tablePreStr."pals_request";
	$t_online=$tablePreStr."online";
    $t_mood=$tablePreStr."mood";
	$t_users_information=$tablePreStr."user_information";
    $t_users_info=$tablePreStr."user_info";
	$table=$t_users;
	$dbo=new dbex();
	//定义读操作
	dbtarget('r',$dbServs);
	//选取用户额外信息的键值对
	$user_information_list=$dbo->getRs("select info_id,info_name from $t_users_information");
	$user_information_arr=array();
	foreach($user_information_list as $value){
		$user_information_arr[$value['info_id']]=$value['info_name'];
	}

	//取出当前用户信息
    $user_info=$dbo->getRow("select user_id,user_name,user_sex,birth_year,user_group,user_add_time from $t_users where user_id=$user_id");
	$info=get_argg('info');
	$ids="";
   
	if(is_array($info)&&$info[14]!='请选择'&&$info[14]!='All')
	{
		$ids=array();
		$ids2=$dbo->getRs("select * from wy_user_info where info_id=14 and info_value='$info[14]'");
		foreach($ids2 as $idr)
		{
			$ids[]=$idr['user_id'];
		}
		$ids=implode(",",$ids);
	}

	$now_year=date('Y');
	if($memName!=''){
		$cols.=" and user_name like '%$search_name%' ";
	}
	
	if($q_province!=$mp_langpackage->mp_province && $q_province!='' && $q_province!=$mp_langpackage->mp_none_limit){
		$cols.=" and (birth_province like '%$q_province%') ";
	}
	if($s_province!=$mp_langpackage->mp_province && $s_province!='' && $s_province!=$mp_langpackage->mp_none_limit){
		$cols.=" and (reside_province like '%$s_province%') ";
	}
	
	if($q_city!=$mp_langpackage->mp_city && $q_city!='' && $q_city!=$mp_langpackage->mp_none_limit){
		$cols.=" and (birth_city like '%$q_city%') ";
	}
	if($s_city!=$mp_langpackage->mp_city && $s_city!='' && $s_city!=$mp_langpackage->mp_none_limit){
		$cols.=" and (reside_city like '%$s_city%') ";
	}
	
	if($sex!=''){
		$cols.=" and user_sex=$sex ";
	}
	if($age){
		$age=explode('|',$age);
		$cols.=" and $now_year-birth_year BETWEEN $age[0] and $age[1] ";
	}
	if($is_online==1){
		$table=$t_online;
		$cols.=" and hidden = 0 ";
	}
	$page_num=trim(get_argg('page'));

	if(!empty($ids))
	{
		$sql="select user_id,user_name,user_sex,birth_year,birth_province,birth_city,reside_province,reside_city,user_ico,user_group from $table where $cols and user_id in($ids)";
	}
	else
	{
		$sql="select user_id,user_name,user_sex,birth_province,birth_year,birth_city,reside_province,reside_city,user_ico,user_group from $table where $cols ";
	}

	 $dbo->setPages(12,$page_num);//设置分页
	$search_rs=$dbo->getRs($sql); 
   // print_r($search_rs);exit;
    //取出心情列表
   
	$dbo2=new dbex();
	//定义读操作
	dbtarget('r',$dbServs);
 /*
    foreach($search_rs as $k=>$v){
       
      
        $sql="select mood from $t_mood where user_id=".$v['user_id'];
        //echo $sql;
       // exit;
        $modeinfo = $dbo2->getRow($sql);
        $search_rs[$k]['mood'] = $modeinfo['mood'];
    }

   */
	//print_r($search_rs);exit;
  	$now_today=intval(date('Y'));
	//循环的取出每个会员的额外信息
	foreach($search_rs as $key=>$value){
		
		
        $online_info=$dbo2->getRs("select online_id from $t_online where user_id=".$value['user_id']);
        foreach($online_info as $k=>$v){
               $search_rs[$key]['online_id'] = $v['online_id']; 
          }
		
	}   
   
	$page_total=$dbo->totalPage;//分页总数
	//控制显示
		$isset_data="";
		$none_data="content_none";
		$isNull=0;
	if(empty($search_rs)){
		$isset_data="content_none";
		$none_data="";
		$isNull=1;
	}

    //验证40分钟体验时间
        $addtime = strtotime($user_info['user_add_time']);
        
        $endtime = $addtime + 60*60;

        $nowtime = time();

        if($nowtime>=$endtime || $user_info['user_sex'] ==1 ){

            if($user_info['user_group']=='base' || $user_info['user_group']=='1'){
                if($page_num>2){
                    echo "<script>alert('".$mp_langpackage->mp_quanxian."');history.back();</script>";
                    exit();
                }
            }else if($user_info['user_group']=='2'){
                if($page_num>15){
                    echo "<script>alert('".$mp_langpackage->mp_quanxian."');history.back();</script>";
                    exit();
                }
            }else{
                 
            }

        
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
	<li><a href="modules.php?app=mypals_list" ><?php echo $mp_langpackage->mp_all_members;?></a></li>
	<li><a href="modules.php?app=mypals_online" ><?php echo $mp_langpackage->mp_online_members;?></a></li>
	<li><a href="modules.php?app=mypals_search_new"><?php echo $mp_langpackage->mp_new_members;?></a></li>
	<li class="hydqbj"><a href="modules.php?app=mypals_search2" style="color:#FFFFFF;"><?php echo $mp_langpackage->mp_search_members;?></a></li>
	<li><a href="modules.php?app=article_list"><?php echo $mp_langpackage->mp_xingzuo;?></a></li>
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
<?php foreach($search_rs as $rs){?>
<li>
<table width="305" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="95" align="center" valign="top" style="padding-right:5px;"><a href="home2.0.php?h=<?php echo $rs['user_id'];?>"><img src="<?php echo $rs['user_ico'];?>" width="88" height="97" border="0" /></a>
	<div class="hyzxzt">
    <?php if($rs['online_id']){?>
    <img src="skin/<?php echo $skinUrl;?>/images/ico_zt_zx.jpg"/>
    <?php }?>
    <?php if($rs['online_id']==0){?>
     <img src="skin/<?php echo $skinUrl;?>/images/ico_zt_zx2.jpg"/>
     <?php }?>
    <a href="main.php?app=msg_creator&2id=<?php echo $rs['user_id'];?>&nw=2">
    <?php if($rs['user_sex']==0){?>
    <?php echo $u_langpackage->u_chat_her;?>
    <?php }?>
    <?php if($rs['user_sex']==1){?>
    <?php echo $u_langpackage->u_chat_him;?>
    <?php }?>
	</a></div>	<div class="hyzxp4"><a href="home2.0.php?h=<?php echo $rs['user_id'];?>"><?php echo $u_langpackage->u_details;?></a></div></td>
    <td width="210" align="left" valign="top">
	<div class="hyzxp1"><a href=""><?php echo $rs["user_name"];?></a></div>
	<div class="hy_hyxx">
	<table width="210" height="40" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="middle"><a href="javascript:void(0);">
    
	<?php if($rs['user_group']=='base' || $rs['user_group']=='1'){?>
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
<?php echo page_show($isNull,$page_num,$page_total);?>
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
<?php } ?>