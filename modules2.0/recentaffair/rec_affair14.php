<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/recentaffair/rec_affair14.html
 * 如果您的模型要进行修改，请修改 models/modules/recentaffair/rec_affair14.php
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
if(filemtime("templates/default/modules/recentaffair/rec_affair14.html") > filemtime(__file__) || (file_exists("models/modules/recentaffair/rec_affair14.php") && filemtime("models/modules/recentaffair/rec_affair14.php") > filemtime(__file__)) ) {
	tpl_engine("default","modules/recentaffair/rec_affair14.html",1);
	include(__file__);
}else {
/* debug模式运行生成代码 结束 */
?><?php
	require("foundation/fcontent_format.php");
	require("foundation/fgrade.php");
	require("api/base_support.php");
	require("foundation/module_mypals.php");
	
	//引入语言包
	$rf_langpackage=new recaffairlp;
	$mp_langpackage=new mypalslp;
	$f_langpackage=new friendlp;

	//变量取得
	$limit_num=0;
	$user_id=get_sess_userid();
	$sex=get_sess_usersex();
	$mypals=get_sess_mypals();
	$ra_rs = array();
	
	//数据表定义区
	$t_rec_affair=$tablePreStr."recent_affair";
	
	//数据库读操作
	$dbo=new dbex;
	dbtarget('r',$dbServs);	

	$send_join_js="parent.mypals_add({uid});";
	$send_hi="parent.hi_action";

	if($looklike=='looklike'){
		$start_num=intval(get_argg('start_num'));
		//是否开启更多
		$is_more=intval($start_num/5);
		$start=$is_more*$mainAffairNum;

		$sql = "select r.* from wy_recent_affair r,wy_users u where r.user_id=u.user_id and u.user_sex !=$sex and r.mod_type in(3) order by r.id desc limit $start,$mainAffairNum";

		$ra_rs_part=$dbo->getRs($sql);
		$ra_rs=array_merge($ra_rs,$ra_rs_part);
	}
?><?php foreach($ra_rs as $rs){?>
<li id="feed_<?php echo $rs['id'];?>" onmouseover="<?php echo str_replace('{id}',$rs['id'],$hidden_button_over);?>" onmouseout="<?php echo str_replace('{id}',$rs['id'],$hidden_button_out);?>;">
	<a id="a_feed_menu_<?php echo $rs['id'];?>" class="popbtn" href="javascript:void(0);" onclick="ajaxmenu(this, this.id,<?php echo $rs['user_id'];?>,<?php echo $rs['mod_type'];?>)" style="display: none;"></a>
	<div class="avatar">
		<a href="home2.0.php?h=<?php echo $rs['user_id'];?>" target="_blank" title="<?php echo $rf_langpackage->rf_v_home;?>"><img src='<?php echo $rs["user_ico"];?>' /></a>
	</div>
  <div class="details">
  	<h3><a href="home2.0.php?h=<?php echo $rs['user_id'];?>" target="_blank" title="<?php echo $rf_langpackage->rf_v_home;?>"><?php echo filt_word($rs["user_name"]);?></a><?php echo $rs['title'];?></h3>
    <div class="content">
    	<?php echo filt_word(get_face($rs['content']));?>
	</div>
		<div class="toolbar toolbar_<?php echo $rs['mod_type'];?>">
			<span>(<?php echo format_datetime_txt($rs['date_time']);?>)</span>
			<?php if($rs['for_content_id']!=0){?><a onclick=toggle("replycontent",<?php echo $rs['mod_type'];?>,<?php echo $rs['for_content_id'];?>) id="openreply_<?php echo $rs['mod_type'];?>_<?php echo $rs['for_content_id'];?>" href="javascript:void(0);"><?php echo $rf_langpackage->rf_re_com;?></a><?php }?>
		</div>
		<div id='replycontent_<?php echo $rs['mod_type'];?>_<?php echo $rs['for_content_id'];?>'>
		<?php if($rs['for_content_id']!=0){?>
    <div class="comment">
			<div id="show_<?php echo $rs['mod_type'];?>_<?php echo $rs['for_content_id'];?>"><script>parent.get_mod_com(<?php echo $rs['mod_type'];?>,<?php echo $rs['for_content_id'];?>,0,3);</script></div>
    <?php if($user_id!=''){?>
    <div id="reply_<?php echo $rs['mod_type'];?>_<?php echo $rs['for_content_id'];?>_1" class="replyer"><input onclick='toggle2("reply_<?php echo $rs['mod_type'];?>_<?php echo $rs['for_content_id'];?>")' name="input" value="<?php echo $rf_langpackage->rf_add_com;?>" type="text"></div>
		<div id="reply_<?php echo $rs['mod_type'];?>_<?php echo $rs['for_content_id'];?>_2" class="reply" style="display: none;">
			<img class="figure" src="<?php echo $visitor_ico;?>">
			<p><textarea type="text" maxlength="150" onkeyup="return isMaxLen(this)" id="reply_<?php echo $rs['mod_type'];?>_<?php echo $rs['for_content_id'];?>_input" onblur=toggle2("reply_<?php echo $rs['mod_type'];?>_<?php echo $rs['for_content_id'];?>")></textarea></p>
			<div class="replybt">
				<input class="left button" onclick="parent.restore_com(<?php echo $rs['user_id'];?>,<?php echo $rs['mod_type'];?>,<?php echo $rs['for_content_id'];?>);" type="submit" name="button" id="button" value="<?php echo $rf_langpackage->rf_submit;?>" />
				<a class="right" href="javascript: void(0);" onclick="showim(''); showFace(this,'face_list_menu','reply_<?php echo $rs['mod_type'];?>_<?php echo $rs['for_content_id'];?>_input');"><?php echo $rf_langpackage->rf_face;?></a>
			</div>
			<div class="clear"></div>
		</div>
		<?php }?>
	</div>
		<?php }?>
		</div>
  </div>
</li>
<?php }?><?php } ?>