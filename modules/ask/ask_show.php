<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/ask/ask_show.html
 * 如果您的模型要进行修改，请修改 models/modules/ask/ask_show.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
	//引入公共模块
	require("foundation/module_ask.php");
	require("api/base_support.php");

	//语言包引入
	$b_langpackage=new bloglp;
	$pu_langpackage=new publiclp;

	//变量区
	$url_uid = intval(get_argg('user_id'));
	$ses_uid = get_sess_userid();
	$ask_id=intval(get_argg("id"));
	$ask_row=array();
	$is_show=1;
	$status=0;	//是否已解决问题
	$is_asker=0;	//是否提问者
	$is_reply=0;	//是否回答过
	$page_num=intval(get_argg('page'));
	$reply_rs=array();
	$answer_row=array();
	$condition='';

	//引入模块公共权限过程文件
	$is_self_mode='partLimit';
	$is_login_mode='';
	require("foundation/auser_validate.php");

	//数据表定义
	$t_ask=$tablePreStr."ask";
	$t_ask_reply=$tablePreStr."ask_reply";

	//初始化数据库操作对象
	$dbo=new dbex;
	dbtarget('w',$dbServs);

	//更新查看次数
	if($ses_uid!=getCookie('ask_'.$ask_id)){
		$sql="update $t_ask set view_num=view_num+1 where ask_id=$ask_id";
		$dbo->exeUpdate($sql);
		set_cookie('ask_'.$ask_id,$ses_uid);
	}

	if($ask_id){
		$sql="select * from $t_ask where ask_id=$ask_id";
		$ask_row=$dbo->getRow($sql);
		
		$status = $ask_row['status'];
		$is_asker=$ask_row['user_id']==$ses_uid?1:0;
	}

	//控制数据显示
	$content_data_none="content_none";
	if(empty($ask_row)){
		$is_show=0;
		$content_data_none="";
	}

	//是否已解决问题
	if($status==1){
		$sql="select * from $t_ask_reply where ask_id=$ask_id and is_answer=1 ";
		$answer_row=$dbo->getRow($sql);
		//其余的回答
		$condition=" and is_answer=0 ";
	}

	//回答列表
	$sql="select * from $t_ask_reply where ask_id=$ask_id $condition order by `reply_id` asc ";
	$reply_rs=$dbo->getRs($sql); //取得结果集
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/ask.css">
<script type='text/javascript' src="skin/default/js/jooyea.js"></script>
<script type="text/javascript" src="servtools/imgfix.js"></script>
<SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>
<script type='text/javascript'>

$=function (id){
	return document.getElementById(id);
}

//添加图片
function addImage(imgSrc){
	$('reply_input').value+='[img]'+imgSrc+'[/img]';
}

//回答问题表单校验
function restore_reply(){
	var r_content=$('reply_input').value;

	if(trim(r_content)==''){
		parent.Dialog.alert('请填写回答内容');
		return false;
	}
	return true;
}

//显示隐藏 修改答案表单
function edit_reply(show){
	$('edit_reply_div').style.display=show;
}

//采纳为答案
function set_answer(ask_id,reply_id,user_id){
	var ajax_answer=new Ajax();
	ajax_answer.getInfo("do.php","GET","app","act=ask_set_answer&ask_id="+ask_id+"&reply_id="+reply_id+"&user_id="+user_id,function(c){if(c=='success'){location.href="modules.php?app=ask_show&id="+ask_id;}else{parent.Dialog.alert(c);}});
}

parent.hiddenDiv();
</script>
</head>
<body id="iframecontent">
	<?php if($is_self=='Y'){?>
    	<div class="create_button"><a href="modules.php?app=ask">待解决问题</a></div>
	<?php }?>
    <h2 id="page_title" class="app_ask">问吧</h2>
	<?php if($is_show){?>
    <div class="answer_box normal">
        <h3><?php echo $status=='1'?'已解决':'待解决';?>问题</h3>
    	<div class="answer_content">
            <h4><?php echo filt_word($ask_row["title"]);?></h4>
            <div class="question_class"><span class="money">&nbsp;&nbsp;&nbsp;</span><a href="javascript:;">悬赏分:<?php echo $ask_row['reward'];?></a>&nbsp;&nbsp;&nbsp;类别：<a href="modules.php?app=ask&type=<?php echo $ask_row['type_id'];?>"><?php echo $ask_row['type_name'];?></a></div>
			<p><?php echo filt_word($ask_row['detail']);?></p>
            
            <?php if($ask_row['replenish']){?>
            <p class="replenish"><span>问题补充：</span><?php echo filt_word($ask_row['replenish']);?></p>
            <?php }?>
            
            <div class="answer_info">
                <div class="answer_time">

                    <?php if($is_asker==1 && $status==0){?>
                    <span class="log_edit_link">
                        <a class="red" href="modules.php?app=ask_edit&id=<?php echo $ask_row['ask_id'];?>">编辑</a>
                    </span>
                    <?php }?>

                    <span>提问者：<a class="red" href="home2.0.php?h=<?php echo $ask_row['user_id'];?>" target="_blank"><?php echo $ask_row['user_name'];?></a></span>
                    回答：<span id="reply_num"><?php echo $ask_row['reply_num'];?></span>
                    <span>提问时间：<?php echo $ask_row['add_time'];?></span>
                    <span><?php echo $status=='1'?'解决时间：'.$ask_row['solved_time']:'';?></span>
               </div>
           </div>
                <!--评论控制显示!-->
                <dd class="log_list_comment"></dd>
            </dl>
        </div>
    </div>

	<!--满意答案开始-->
	<?php if(!empty($answer_row)){?>
	<div class="answer_box sloved">
    	<div class="answer_content">
        	<h4>满意答案：</h4>
            <p><?php echo filt_word(get_face($answer_row['content']));?></p>
            <div class="answer_info">
                <div class="answer_time">
                    <a class="red" href="home2.0.php?h=<?php echo $answer_row['user_id'];?>" target="_blank"><?php echo $answer_row['user_name'];?></a>
                    <label><?php echo $answer_row['add_time'];?></label>
                </div>
            	<div class="answer_user">
                	<a class="red" href="home2.0.php?h=<?php echo $answer_row['user_id'];?>" target="_blank" class="figure"><img src="<?php echo $answer_row['user_ico'];?>" /></a>
                </div>
            </div>
        </div>
	</div>
	<?php }?>
	<!--满意答案结束-->

	<!--其他答案开始-->
	<?php if(!empty($reply_rs)){?>
	<div class="answer_box normal">
        <h3><?php echo $status==0?'答案':'其它答案';?>：</h3>
        <div id='show_reply' class="answer_content">

			<!--回答列表开始-->
			<?php foreach($reply_rs as $rs){?>
			<p id="reply_content_<?php echo $rs['reply_id'];?>"><?php echo filt_word(get_face($rs['content']));?></p>
			<div class="answer_info clearfix">

				<div class="answer_time">
				  <a class="red" href="home2.0.php?h=<?php echo $rs['user_id'];?>" target="_blank"><?php echo $rs['user_name'];?></a>
				  <span><?php echo $rs['add_time'];?></span>
				</div>

				<div class="answer_user">
					<a class="red"  href="home2.0.php?h=<?php echo $rs['user_id'];?>" target="_blank" class="figure"><img src="<?php echo $rs['user_ico'];?>" /></a>
				</div>

				<div class="answer_operate">
					<?php if($status=='0'){?>
						<!--如果是登陆用户的答案-->
						<?php if($ses_uid==$rs['user_id']){?>
							<?php $is_reply=1;?>
							<span class="log_edit_link">
							<a href="javascript:void(0);" onclick="edit_reply('block');">修改答案</a></span>
						<?php }?>

						<!--如果是提问者-->
						<?php if($is_asker==1){?>
							<span><a href="javascript:void(0);" onclick="set_answer(<?php echo $ask_id;?>,<?php echo $rs['reply_id'];?>,<?php echo $rs['user_id'];?>)">采纳为答案</a></span>
						<?php }?>

					<?php }?>
				</div>
				<div class="clear"></div>
				<!--修改答案表单开始-->

				<?php if($ses_uid==$rs['user_id']){?>
				<div class="reply" id="edit_reply_div" style="display:none">
				<form action='do.php?act=ask_reply_edit' name="myform" method='post' onsubmit="return restore_reply();">
					<table width="97%" cellspacing="0" cellpadding="0" border="0">
						<tbody>
						<tr valign="top">
                        	<td width="20px" class="f14">&nbsp;</td>
							<td style="position: relative;">
							<textarea type="text" maxlength="150" id="reply_input" name="CONTENT" style="height:80px"><?php echo $rs['content'];?></textarea>
						   <iframe width="100%" height=50   allowTransparency="true" scrolling=no src='modules.php?app=upload_form' frameborder=0></iframe>
							</td>
						</tr>
						</tbody>
					</table>
					<table cellspacing="0" cellpadding="0" border="0" id="replay_submit_panel">
						<tbody>
							<tr>
							<td width="20px" class="f14">&nbsp;</td>
							<td>
							<input class="regular-btn" type="submit" name="reply_button" value="确定" />
							<input class="regular-btn" type="button" onclick="edit_reply('none');" value="取消" />
							</td>
							</tr>
						</tbody>
					</table>
					<input type="hidden" name="reply_id" value="<?php echo $rs['reply_id'];?>" />
					<input type="hidden" name="user_id" value="<?php echo $rs['user_id'];?>" />
				</form>
			</div>
			<?php }?>
			<!--修改答案表单结束-->


			</div>
			<div class="line"></div>
			<?php }?>
			<!--回答列表结束-->

        </div>
	</div>
	<?php }?>
	<!--其他答案结束-->

	<!--回答表单开始 显示条件：已登录 未解决 不是提问者 未回答过-->
	<?php if($ses_uid && $status=='0' && $is_asker==0 && $is_reply==0){?>
	<div class="answer_box normal">
    	<div class="answer_content">
			<div class="reply">
				<form action='do.php?act=ask_reply_add' name="form1" method='post' onsubmit="return restore_reply();">
					<table width="97%" cellspacing="0" cellpadding="0" border="0">
						<tbody>
						<tr valign="top">
							<td width="80px" class="f14">我来回答：</td>
							<td style="position: relative;">
							<textarea type="text" maxlength="150" id="reply_input" name="CONTENT" style="height:80px"></textarea>
						   <iframe width="100%" height=50   allowTransparency="true" scrolling=no src='modules.php?app=upload_form' frameborder=0></iframe>
							</td>
						</tr>
						</tbody>
					</table>
					<table cellspacing="0" cellpadding="0" border="0" id="replay_submit_panel">
						<tbody>
							<tr>
							<td width="80px" class="f14">&nbsp;</td>
							<td>
							<input class="regular-btn" type="submit" name="reply_button" value="回答" /> 回答被采纳则获得悬赏分
							</td>
							</tr>
						</tbody>
					</table>
					<input type="hidden" name="holder_id" value="<?php echo $ask_row['user_id'];?>" />
					<input type="hidden" name="ask_id" value="<?php echo $ask_row['ask_id'];?>" />
				</form>
			</div>
        </div>
	</div>
	<?php }?>
	<!--回答表结束-->

	</div>
	</div>
	<?php }?>

	<!-- face begin -->
	<div id="face_list_menu" class="emBg" style="display:none;z-index:100;"></div>
	<!-- face end -->

	<div class="guide_info <?php echo $content_data_none;?>">没有找到该问题或问题已被删除！</div>
</body>
</html>