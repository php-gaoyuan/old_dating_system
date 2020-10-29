<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/users/user_fri_recommended.html
 * 如果您的模型要进行修改，请修改 models/modules/users/user_fri_recommended.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php

require("foundation/module_mypals.php");
//引入语言包
$mp_langpackage=new mypalslp;
$f_langpackage=new friendlp;
$send_hi="hi_action";
$t_users=$tablePreStr."users";
$userId = get_sess_userid();
$send_script_js="location.href='modules.php?app=msg_creator&2id={uid}&nw=1';";
$send_join_js="mypals_add({uid});";
$condition = "";
$pals = get_sess_mypals();
if (!empty($pals)){
	$condition .=" and user_id not in ({$pals},$userId)";
} else {
	$condition .= " and user_id <> $userId";
}
$sql="select * from wy_recommend where 1=1$condition order by wy_recommend.rec_order limit 3";
$dbo=new dbex;
dbplugin('r');
$recommend = $dbo->getALL($sql);
?><?php if(!empty($recommend)){?>
	<div class="container">
         <div class="sideitem_head"><h4><?php echo $mp_langpackage->mp_pal_recomment;?></h4><a href="modules.php?app=user_fri_rec_more" target='frame_content'><?php echo $mp_langpackage->mp_more;?></a></div>
         <div class="sideitem_body">
         	<ul id='user_fri_recomment' class="userlist">
			<?php foreach($recommend as $val){?>
			<li>
				<a class="avatar" href="home2.0.php?h=<?php echo $val['user_id'];?>" target="_blank" title="<?php echo $f_langpackage->f_fri;?>">
					<img src="<?php echo $val['user_ico'];?>" />
				</a>
				<span class="name">
					<a class="name" href="home2.0.php?h=<?php echo $val['user_id'];?>" target="_blank"><?php echo $val['user_name'];?></a>
				</span>
				<span>
			    	<img style="cursor:pointer;" onclick="<?php echo $send_hi;?>(<?php echo $val["user_id"];?>)" src="skin/<?php echo $skinUrl;?>/images/hi.gif" title="<?php echo $f_langpackage->f_greet;?>" />
					<img class="<?php echo $show_add_friend;?>" style="cursor:pointer;" onclick="javascript:<?php echo str_replace("{uid}",$val['user_id'],$send_join_js);?>" src="skin/<?php echo $skinUrl;?>/images/add.gif"  title="<?php echo str_replace("{he}",get_TP_pals_sex($val['user_sex']),$mp_langpackage->mp_add_mypals);?>" />
				</span>
			</li>
			<?php }?>
		</ul>
	</div>
 </div>
<?php }?>
		
	
      