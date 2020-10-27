<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/mypals/search_pals_list.html
 * 如果您的模型要进行修改，请修改 models/modules/mypals/search_pals_list.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?>

<style>
.avatar{width:84px;height:84px;background:none;border:1px solid #ccc;border-radius:5px;position:absolute;left:80px}
.avatar img{width:80px;height:80px}
.details{width:400px;margin-left:20px;}
.content{height:30px;line-height:30px;position:relative}
.content img{cursor:pointer;}
.add_f{display:block;width:90px;font-size:12px;color:#385679;cursor:pointer;position:absolute;right:0;top:0}
.add_f:hover {color:#ff0000;}
.add_f img{position:relative;top:5px}
.content_ch1{width:90px;height:20px;background:url("skin/default/jooyea/images/ch.jpg") no-repeat;}
.content_ch1 a{width:22px;height:20px;display:block;float:left;cursor:pointer;}
.lpages{margin:10px 0 20px;}

.content_mood{background-color:#EEEFF3;height:30px;width:510px;text-indent:5px;}
#fanyi_mood{float:right;display:block;max-width:140px;cursor:pointer;background:#EEEFF3;color:white;border-radius:5px;text-align:center;}

.content_mood:hover #fanyi_mood{display:block;}

.rs_mood{width:405px;float:left;height:30px;overflow:hidden}
</style>




<?php
	//引入模块公共权限过程文件
	require("foundation/fpages_bar.php");
	require("foundation/module_mypals.php");
	
	
	require("foundation/fcontent_format.php");//add_
	require("foundation/fgrade.php");	//add
				
				//引入语言包
	$rf_langpackage=new recaffairlp;	//add

				
				
	
	//引入语言包
	$mp_langpackage=new mypalslp;
	
	$search_name=short_check(get_argg('memName'));
	$country=short_check(get_argg('country'));//
	$height=short_check(get_argg('height'));//
	$income=short_check(get_argg('income'));//
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
	$send_script_js="location.href='modules2.0.php?app=msg_creator&2id={uid}&nw=1';";
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
	$table=$t_users;
	$dbo=new dbex();
	//定义读操作
	dbtarget('r',$dbServs);

	$info=get_argg('info');
	$ids="";
	if(is_array($info)&&$info[14]!='请选择')
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
	if($country!=''){
		$cols.=" and country like '%$country%' ";
	}//
	if($height!=''){
		$cols.=" and height like '%$height%' ";
	}//
	if($income!=''){
		$cols.=" and income like '%$income%' ";
	}//
	
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
		$sql="select user_id,user_name,user_sex,birth_province,birth_city,reside_province,reside_city,user_ico from $table where $cols and user_id in($ids)";
	}
	else
	{
		$sql="select user_id,user_name,user_sex,birth_province,birth_city,reside_province,reside_city,user_ico from $table where $cols ";
	}

	$dbo->setPages(8,$page_num);//设置分页

	$sql .= " and user_sex <> '$user_sex'";
	$search_rs=$dbo->getRs($sql);
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
	?><?php if($is_login==1){?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
<SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>
<script type='text/javascript'>
function mypals_add_callback(content,other_id){
	if(content=="success"){
		parent.Dialog.alert("<?php echo $mp_langpackage->mp_suc_add;?>");
		document.getElementById("operate_"+other_id).innerHTML="<?php echo $mp_langpackage->mp_suc_add;?>";
	}else{
		parent.Dialog.alert(content);
		document.getElementById("operate_"+other_id).innerHTML=content;
	}
}

function mypals_add(other_id){
	var mypals_add=new Ajax();
	mypals_add.getInfo("do.php","get","app","act=add_mypals&other_id="+other_id,function(c){mypals_add_callback(c,other_id);}); 
}
</script>
</head>

<body id="iframecontent">
<div class="create_button"><a href="modules2.0.php?app=mypals_search"><?php echo $mp_langpackage->mp_re_search;?></a></div>
<h2 class="app_friend"><?php echo $mp_langpackage->mp_find;?></h2>
<div class="tabs">
	<ul class="menu">
        <li class="active"><a href="javascript:;" hidefocus="true"><?php echo $mp_langpackage->mp_find;?></a></li>
    </ul>
</div>

	<?php }?>
<?php foreach($search_rs as $rs){?>
<div class="pals_list" onmouseover="this.className += ' pals_list_active';" onmouseout="this.className='pals_list';">




			<div class="right" style="margin-top:20px;">
               <p id='operate_<?php echo $rs["user_id"];?>'>
                        <a href='javascript:<?php echo str_replace("{uid}",$rs['user_id'],$send_join_js);?>'><?php echo "&nbsp;&nbsp;";?><?php echo str_replace("{he}",get_TP_pals_sex($rs['user_sex']),$mp_langpackage->mp_add_mypals);?></a>
                </p>
				
				<div class="content_ch1" style="background:url(skin/default/jooyea/images/ch.jpg);display:none;">
    				<a style="width:22px;height:22px;float:left;display:block" href="javascript:;" title="<?php echo $rf_langpackage->rf_liaotian;?>" onclick="top.i_im_talkWin('<?php echo $rs[user_id];?>','imWin');"></a>
    				<a style="width:22px;height:22px;float:left;display:block" href="javascript:;" title="<?php echo $rf_langpackage->rf_dazhaohu;?>" onclick="top.hi_action(<?php echo $rs[user_id];?>)"></a>
    				<a style="width:22px;height:22px;float:left;display:block" href="javascript:;" title="<?php echo $rf_langpackage->rf_fayoujian;?>" onclick="top.frame_content.location.href='modules2.0.php?app=msg_creator&2id=<?php echo $rs[user_id];?>';return false;"></a>
    				<a style="width:22px;height:22px;float:left;display:block" href="plugins/gift/giftshop.php" title="<?php echo $rf_langpackage->rf_songliwu;?>"></a>
    			</div>

	
            </div>
			

            <div class="avatar"><a href="home2.0.php?h=<?php echo $rs['user_id'];?>" target="_blank"><img alt="<?php echo $mp_langpackage->mp_en_home;?>" title='<?php echo $mp_langpackage->mp_sex;?>:<?php echo get_pals_sex($rs['user_sex']);?>' src='<?php echo $rs["user_ico"];?>' /></a>
			</div>
			<dl>
            	<dd><?php echo $mp_langpackage->mp_name;?>：<?php echo filt_word($rs["user_name"]);?></dd>
				<dd><?php echo $mp_langpackage->mp_reside;?>：<?php echo get_pals_reside($rs['reside_province'],$rs['reside_city']);?></dd>
                <dd><?php echo $mp_langpackage->mp_birth;?>：<?php echo get_pals_birth($rs['birth_province'],$rs['birth_city']);?></dd>
			</dl>
</div>
<?php }?>
<div class="clear" style="display:inline-block;"></div>
<?php echo page_show($isNull,$page_num,$page_total);?><div class='guide_info <?php echo $none_data;?>'>
  <?php echo $error_str;?>
</div>
  
</body>
</html>