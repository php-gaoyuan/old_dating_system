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
    $user_id=get_sess_userid();


	$dbo=new dbex();
	//定义读操作
	dbtarget('r',$dbServs);
	//在线会员个数
    $online=$dbo->getRow("select count(*) as num from $t_online");
    $online_count = $online['num'];
	//取出当前用户信息
    $user_info=$dbo->getRow("select user_id,user_name,user_sex,user_group,user_add_time from $t_users where user_id=$user_id");


        //本周达人
        $super_user_list=$dbo->getRs("select * from $t_users order by guest_num desc limit 0,4");
        
        //商城礼物
        $gift_list=$dbo->getRs("select patch,giftname from gift_news order by rand() limit 0,4");
        //取出当前用户信息
        $user_info=$dbo->getRow("select user_id,user_name,user_group,user_add_time from $t_users where user_id=$user_id");
        //print_r($user_info);
        //选取用户额外信息的键值对
		/*
        $user_information_list=$dbo->getRs("select info_id,info_name from $t_users_information");
        $user_information_arr=array();
        foreach($user_information_list as $value){
            $user_information_arr[$value['info_id']]=$value['info_name'];
        }
		*/
        $page_num=trim(get_argg('page'));
        $sql="select user_id,user_name,user_sex,birth_year,user_ico,user_group from $t_users order by user_id desc";
            
        $dbo->setPages(20,$page_num);//设置分页
        $user_new_rs=$dbo->getRs($sql);
       //print_r($user_new_rs);exit;
       $page_total=$dbo->totalPage;

    //验证30分钟体验时间
        $addtime = strtotime($user_info['user_add_time']);
        
        $endtime = $addtime + 30*60;

        $nowtime = time();
        
        if($nowtime>=$endtime || $user_info['user_sex'] ==1 ){

            if($user_info['user_group']==1){
                if($page_num>2){
                    echo "<script>alert('".$mp_langpackage->mp_quanxian."');location.href='main.php?app=user_pay';</script>";
                    exit();
                }
            }else if($user_info['user_group']=='2'){
                if($page_num>15){
                    echo "<script>alert('".$mp_langpackage->mp_quanxian."');location.href='main.php?app=user_pay';</script>";
                    exit();
                }
            }else{
                 
            }
        
        }

        /*
        $dbo2=new dbex();
        //定义读操作
        dbtarget('r',$dbServs);
        $now_today=intval(date('Y'));
        //循环的取出每个会员的额外信息
        foreach($user_new_rs as $key=>$value){
            if(empty($value['birth_year'])){
                $user_new_rs[$key]['birth_year']=$mp_langpackage->mp_noyear;
            }else{
                $user_new_rs[$key]['birth_year']=$now_today-$value['birth_year'].$mp_langpackage->mp_years;
            }
            $extra_info=$dbo2->getRs("select info_id,info_value from $t_users_info where user_id=".$value['user_id']);
             $online_info=$dbo2->getRs("select online_id from $t_online where user_id=".$value['user_id']);
           foreach($online_info as $k=>$v){
               $user_new_rs[$key]['online_id'] = $v['online_id']; 
            }
            foreach($extra_info as $k=>$v){
                $user_new_rs[$key][$user_information_arr[$v['info_id']]]=$v['info_value'];
            }
        }
		*/
		
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
<script type='text/javascript' src="skin/default/js/jy.js"></script>
<script type='text/javascript' src="servtools/imgfix.js"></script>
<script type='text/javascript' src="skin/default/js/jooyea.js"></script>
<SCRIPT type='text/javascript' src="servtools/ajax_client/ajax.js"></SCRIPT>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDrag.js"></script>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDialog.js"></script>
<script type="text/javascript" language="javascript" src="servtools/calendar.js"></script>

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
	<li class="hydqbj"><a style="color:#FFFFFF;" href="modules2.0.php?app=mypals_list" ><?php echo $mp_langpackage->mp_all_members;?></a></li>
	<li ><a href="modules2.0.php?app=mypals_online" ><?php echo $mp_langpackage->mp_online_members;?></a></li>
	<li><a href="modules2.0.php?app=mypals_search_new"><?php echo $mp_langpackage->mp_new_members;?></a></li>
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
<div class="zxhyind">
<!--会员搜索部分开始-->
<?php require("uiparts/search.php");?>
<!--会员搜索部分结束-->
<div class="zxhytex">
<div class="zxhytextop"><?php echo str_replace("{online_num}","$online_count",$mp_langpackage->mp_online_num);?></div>
<div class="zxhytexul">
<ul>

<?php foreach($user_new_rs as $rs){?>
<li>
<a href="home2.0.php?h=<?php echo $rs['user_id'];?>"><img src='<?php echo $rs["user_ico"];?>' width="70" height="70" border="2" /></a>
	<div class="zxhy_hyxx">
	<table width="130" height="35" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="middle"><a href="javascript:void(0);">
    
	<?php if($rs['user_group']=='base' || $rs['user_group']=='1' || $rs['user_group']=='0'){?>
		<img src="skin/<?php echo $skinUrl;?>/images/xin/01.gif" border="0" />
	<?php }?>	
	<?php if($rs['user_group']=='2'){?>
		<img src="skin/<?php echo $skinUrl;?>/images/xin/02.gif" border="0" />
	<?php }?>
	<?php if($rs['user_group']=='3'){?>
		<img src="skin/<?php echo $skinUrl;?>/images/xin/03.gif" border="0" />
	<?php }?>
    
    </a></td>
    <td align="center" valign="middle" style="padding-bottom:10px;"><a href="main.php?app=msg_creator&2id=<?php echo $rs['user_id'];?>&nw=2" target="_blank"><img src="skin/<?php echo $skinUrl;?>/images/ico_hy_email.jpg" width="16"  height="11" border="0" /></a></td>
    <td align="center" valign="middle" style="padding-bottom:2px;"><a href="javascript:void(0);" onclick="javascript:window.alert('Temporarily not opening, please look.');"><img src="skin/<?php echo $skinUrl;?>/images/ico_hy_xx.jpg" width="22" height="21"  border="0" /></a></td>
    <td align="center" valign="middle" style="padding-bottom:4px;"><a href="/main.php?app=gift&uname=<?php echo $rs['user_name'];?>"><img src="skin/<?php echo $skinUrl;?>/images/ico_hy_gift.jpg" width="16" height="16" border="0" /></a></td>
  </tr>
</table>
<p><?php echo $rs["user_name"];?></p>
<p>

	

	


</p>
<p><a href="home2.0.php?h=<?php echo $rs['user_id'];?>"><?php echo $u_langpackage->u_details;?></a></p>
<?php if($user_id!=$rs['user_id']){?>
<p style="text-align:left;"><?php if($rs['online_id']){?>
    <img src="skin/<?php echo $skinUrl;?>/images/ico_zt_zx.jpg"/>
    <?php }?>
    <?php if($rs['online_id']==0){?>
     <img src="skin/<?php echo $skinUrl;?>/images/ico_zt_zx2.jpg"/>
     <?php }?><a href="main.php?app=msg_creator&2id=<?php echo $rs['user_id'];?>&nw=2" target="_blank">
    <?php if($rs['user_sex']==0){?>
    <?php echo $u_langpackage->u_chat_her;?>
    <?php }?>
    <?php if($rs['user_sex']==1){?>
    <?php echo $u_langpackage->u_chat_him;?>
    <?php }?>
     </a>
</p>
<?php }?>
<?php if($user_id==$rs['user_id']){?>
<p style="text-align:left"><img src="skin/<?php echo $skinUrl;?>/images/ico_zt_zx.jpg" /><a href="main.php?app=msg_minbox&2id=<?php echo $rs['user_id'];?>&nw=2" >
        <?php echo $pu_langpackage->pu_lookemail;?>
    </a>
</p>
<?php }?>
</div>
</li>

<?php }?>

</ul>
</div><div class="clear"></div>
</div>
</div>
<!--主体结束-->
<!--分页开始-->
<div class="zxhyind" style="background:#FFFFFF;">
  <div class="dede_pages">
<?php echo page_show($isNull,$page_num,$page_total);?>
  </div><div class="clear"></div></div>
<!-- 分页结束 -->
<!--底部开始-->
<div class="clear"></div>
<?php require("uiparts/mainfooter.php");?>
<!--底部结束-->

</body>
</html>
