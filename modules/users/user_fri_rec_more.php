<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/users/user_fri_rec_more.html
 * 如果您的模型要进行修改，请修改 models/modules/users/user_fri_rec_more.php
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
require("foundation/module_mypals.php");
require("foundation/module_users.php");
require("foundation/fpages_bar.php");
//引入语言包
$mp_langpackage=new mypalslp;
$f_langpackage=new friendlp;
$hi_langpackage=new hilp;
$u_langpackage=new userslp;
$send_hi="hi_action";
$t_users=$tablePreStr."users";
$userId = get_sess_userid();
$condition = "";
$pals = get_sess_mypals();
$send_script_js="location.href='modules2.0.php?app=msg_creator&2id={uid}&nw=1';";
$send_join_js="mypals_add({uid});";
if (!empty($pals)){
	$condition .=" and user_id not in ({$pals},$userId)";
} else {
	$condition .= " and user_id <> $userId";
}
$sql=" select * from $t_users where is_pass = 1  $condition ";
$dbo=new dbex;
dbplugin('r');
$page_num=intval(get_argg('page'));
$dbo->setPages(20,$page_num);
$rec = $dbo->getRs($sql);
$page_total= $dbo->totalPage;//分页总数
$isNull=0;
if(empty($rec)){
	$isNull=1;
	$recommend =array();
} else {
	$recommend =$rec;
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
<script type="text/javascript" src="servtools/ajax_client/ajax.js"></script>
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
  <h2 class="app_friend">推荐用户</h2>
  <div class="tabs">
    <ul class="menu">
      <li class="active"><a href="javascript:void(0)" title="推荐用户">推荐用户</a></li>
    </ul>
  </div>
     <div id="mypals_iframe">
		<div id="fri_bir" class="friend_list">
			<ul class="user_list">
                <?php if(!empty($recommend)){?>
                <?php foreach($recommend as $val){?>
					<li onmouseover='changeStyle(this,<?php echo $val['user_id'];?>)' onmouseout='recoverStyle(this,<?php echo $val['user_id'];?>)'>
						<div class="photo">
						  <a href="home2.0.php?h=<?php echo $val['user_id'];?>" target="_blank" class="avatar">
							<img title="<?php echo $mp_langpackage->mp_en_home;?>" src="<?php echo $val['user_ico'];?>"  onerror="parent.pic_error(this)" /></a>
						</div>
						<dl>
							<dt><a target="_blank" href="home2.0.php?h=<?php echo $val['user_id'];?>" class="name"><?php echo $val['user_name'];?></a></dt>
                            <dd>
                            	<img style="cursor:pointer;" onclick="parent.<?php echo $send_hi;?>(<?php echo $val["user_id"];?>)" src="skin/<?php echo $skinUrl;?>/images/hi.gif" title="<?php echo $f_langpackage->f_greet;?>" />
                                <img style="cursor:pointer;" onclick="javascript:<?php echo str_replace("{uid}",$val['user_id'],$send_join_js);?>" src="skin/<?php echo $skinUrl;?>/images/add.gif"  title="<?php echo str_replace("{he}",get_TP_pals_sex($val['user_sex']),$mp_langpackage->mp_add_mypals);?>" />	
                           </dd>
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
</body>
</html>