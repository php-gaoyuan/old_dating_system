<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/group/group_sub_show.html
 * 如果您的模型要进行修改，请修改 models/modules/group/group_sub_show.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
	//引入公共模块
	require("foundation/fpages_bar.php");
	require("foundation/module_group.php");
	require("api/base_support.php");

	//引入语言包
	$g_langpackage=new grouplp;
	$mn_langpackage=new menulp;
	$rl=new recaffairlp;
	$u_langpackage=new userslp;

	//变量区
	$url_group_id=intval(get_argg('group_id'));
	$subject_id=intval(get_argg('subject_id'));
	$visitor_id=get_sess_userid();
	$visitor_name=get_sess_username();
	$user_id=intval(get_argg('user_id'));

	$role='';
	
	//数据表定义
	$t_blog=$tablePreStr."blog";
	
	//权限判断
	if($visitor_id!=''){
		$role=api_proxy("group_member_by_role",$url_group_id,$user_id);
		$role=$role[0];
	}

	$g_join_type=api_proxy("group_self_by_gid","*",$url_group_id);
	$join_type=$g_join_type['group_join_type'];

	//控制评论
		$isNull=0;
		$show_com='';
	if(empty($comment_rs)){
		$isNull=1;
	}

	$subject_row=api_proxy("group_sub_by_sid","*",$subject_id);
	$host_id=$subject_row['user_id'];
	
echo "<pre>";
//var_dump($subject_row);
echo "</pre>";
	//防止刷新访问量
	if($visitor_id!=getCookie('g_'.$subject_id)){
		$dbo=new dbex;
		dbtarget('w',$dbServs);
		$t_group_subject=$tablePreStr.'group_subject';	
		$sql="update $t_group_subject set hits=hits+1 where subject_id=$subject_id";
		$dbo->exeUpdate($sql);
		set_cookie('g_'.$subject_id,$visitor_id);
	}

	//权限显示控制
	$is_pri=1;
	$show_error="content_none";
	$error_str="";
	$isset_data="";
	$is_admin=get_sess_admin();
	if($is_admin==''){
		if($role=='' && $join_type!=0){
			$is_pri=0;
			$show_error="";
			$isset_data="content_none";
			$error_str=$g_langpackage->g_arrest;
			$show_com="content_none";
		}
	}
	//显示控制
	if(empty($subject_row)){
		$show_error="";
		$isset_data="content_none";
		$error_str=$g_langpackage->g_data_none;
		$show_com="content_none";
	}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
<script type='text/javascript' src="skin/default/js/jooyea.js"></script>
<SCRIPT language=JavaScript src="servtools/imgfix.js"></SCRIPT>
<script type='text/javascript'>parent.hiddenDiv();</script>
<script charset="utf-8" src="skin/default/jooyea/jquery-1.9.1.min.js"></script>
<script>var jq=jQuery.noConflict();</script>
<style>
#f_list a{color:#2C589E}
.f_list a{color:#2C589E}
</style>
<script>
function fyc(con,to,fid){
	var need=0;
	need=len(con)/100;
	if(need<1) need=1;
	top.Dialog.confirm('<?php echo $u_langpackage->fy_tishi2;?> '+need,function(){
		jq.get("fanyi.php",{lan:con,tos:to,ne:need,fid:fid},function(c){
			if(c==0){
				top.Dialog.alert("<?php echo $u_langpackage->fy_tishi1;?>");
				return false;
			}
			jq('#subject_con').html(c);
			jq('#f_list').css('display','none');
		});
	})
}
function fyc_com(id,to,fid){
	var text=jq('#sub_com_'+id).html();
	var need=0;
	need=len(text)/100;
	if(need<1) need=1;
	top.Dialog.confirm('<?php echo $u_langpackage->fy_tishi2;?> '+need,function(){
		jq.get("fanyi.php",{lan:text,tos:to,ne:need,fid:fid},function(c){
			if(c==0){
				top.Dialog.alert("<?php echo $u_langpackage->fy_tishi1;?>");
				return false;
			}
			jq('#sub_com_'+id).html(c)
			jq('#com_list_'+id).css('display','none')
		});
	})
}
function len(s) {//按字节计算中英文字符长度
		var l = 0;
		var a = s.split('');
		for (var i=0;i<a.length;i++) {
		 if (a[i].charCodeAt(0)<299) {
		  l++;
		 } else {
		  l+=2;
		 }
		}
		return l;
	}
</script>
</head>
<body id="iframecontent">
    <div class="create_button"><a href="modules2.0.php?app=group_space&group_id=<?php echo $url_group_id;?>&user_id=<?php echo $user_id;?>"><?php echo $g_langpackage->g_re_space;?></a></div>
    <h2 class="app_group"><?php echo $g_langpackage->g_space;?></h2>
    <div class="tabs">
        <ul class="menu">
            <li class="active"><a href="javascript:;" hidefocus="true"><?php echo $g_langpackage->g_subject;?></a></li>
        </ul>
    </div>

<?php if(!empty($subject_row)&&$is_pri==1){?>
		<div class="poll_list_box <?php echo $isset_data;?>">
			<div class="poll_user">
				<a class="avatar" href="home2.0.php?h=<?php echo $subject_row['user_id'];?>" target="_blank">
					<img src=<?php echo $subject_row['user_ico'];?> alt='<?php echo $subject_row['user_name'];?>' title='<?php echo $subject_row['user_name'];?>'/>
				</a>
			</div>
			<div class="subject_content">
				<dl style='float:left'>
					<dt><?php echo filt_word($subject_row['title']);?></dt>
					<dd class="<?php echo $isset_data;?>"><?php echo $g_langpackage->g_editor;?>：<a href="home2.0.php?h=<?php echo $subject_row['user_id'];?>" target="_blank">
				<?php echo filt_word($subject_row['user_name']);?></a> <a href='modules2.0.php?app=msg_creator&2id=<?php echo $subject_row["user_id"];?>&nw=1'><?php echo $g_langpackage->g_leave_me;?></a></dd>
					<dd style='padding-top:15px;padding-bottom:15px'><span id="subject_con"><?php echo filt_word($subject_row['content']);?></span><a style="color:#CE1221" href="javascript:;" onclick="if(document.getElementById('f_list').style.display=='none'){document.getElementById('f_list').style.display=''}else{document.getElementById('f_list').style.display='none'}"> [<?php echo $rl->rf_fanyi;?>]</a>
					<span id="f_list" style="display:none">
						<span><a href='javascript:fyc("<?php echo filt_word($subject_row['content']);?>","en","<?php echo $host_id;?>");'>English</a> <a href='javascript:fyc("<?php echo filt_word($subject_row['content']);?>","zh","<?php echo $host_id;?>")'>中文</a> <a href='javascript:fyc("<?php echo filt_word($subject_row['content']);?>","kor","<?php echo $host_id;?>");'>한국어</a> <a href='javascript:fyc("<?php echo filt_word($subject_row['content']);?>","ru","<?php echo $host_id;?>");'>русский</a> <a href='javascript:fyc("<?php echo filt_word($subject_row['content']);?>","spa","<?php echo $host_id;?>");'>Español</a> <a href='javascript:fyc("<?php echo filt_word($subject_row['content']);?>","fra","<?php echo $host_id;?>");'>Français</a> <a href='javascript:fyc("<?php echo filt_word($subject_row['content']);?>","jp","<?php echo $host_id;?>");'>日本語</a></span>
					</span>
					</dd>
					<dd><span class='gray'><?php echo $g_langpackage->g_read;?>(<?php echo $subject_row['hits'];?>)</span> <span style='padding-left:15px' class='gray'><?php echo $g_langpackage->g_re;?>(<?php echo $subject_row['comments'];?>)</span></dd>
				</dl>
			</div>
			<?php if($visitor_id!=$subject_row['user_id']&&$visitor_id){?>
			<div class="subject_status" style="padding-top:0;">
				<a class="fenxiang" href="javascript:void(0);" onclick="parent.show_share(8,<?php echo $subject_row['subject_id'];?>,'<?php echo $subject_row['title'];?>','','');"><?php echo $mn_langpackage->mn_share;?></a>
				<a class="jubao" href="javascript:void(0);" onclick="parent.report(9,<?php echo $subject_row['user_id'];?>,<?php echo $subject_row['subject_id'];?>);"><?php echo $mn_langpackage->mn_report;?></a>
			</div>
			<?php }?>
		</div>

<div class="tleft ml20">
<?php if($role!=''){?>
	<div class="comment">
    <div id='show_1_<?php echo $subject_row["subject_id"];?>' class="<?php echo $show_com;?>">
        <script type='text/javascript'>parent.get_mod_com(1,<?php echo $subject_row['subject_id'];?>,0,20);</script>
    </div>
    <?php if($visitor_id!=''){?>
		<div class="reply">
			<img class="figure" src='<?php echo get_sess_userico();?>' />
			<p><textarea type="text" maxlength="150"  onkeyup="return isMaxLen(this)" id="reply_1_<?php echo $subject_row['subject_id'];?>_input"></textarea></p>
			<div class="replybt">
				<input class="left button" onclick="parent.restore_com(<?php echo $subject_row['user_id'];?>,1,<?php echo $subject_row['subject_id'];?>,'');" type="submit" name="button" id="button" value="<?php echo $g_langpackage->g_submit;?>" />
				<a class="right" href="javascript: void(0);" onclick="showim(''); showFace(this,'face_list_menu','reply_1_<?php echo $subject_row['subject_id'];?>_input');"><?php echo $g_langpackage->g_face;?></a>
			</div>
			<div class="clear"></div>
		</div>
		<?php }?>
	</div>
	<?php }?>
	</div>
	<?php }?>

	<div class="guide_info <?php echo $show_error;?>">
		<?php echo $error_str;?>
	</div>
	<!-- face begin -->
	<div id="face_list_menu" class="emBg" style="display:none;z-index:100;">
	</div>
	<!-- face end -->
</body>
</html>