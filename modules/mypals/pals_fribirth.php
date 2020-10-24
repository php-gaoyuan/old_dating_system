<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/mypals/pals_fribirth.html
 * 如果您的模型要进行修改，请修改 models/modules/mypals/pals_fribirth.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php	
	$mp_langpackage=new mypalslp;
	$f_langpackage=new friendlp;
	$send_hi="hi_action";
	$user_id=get_sess_userid();	
	$fir_list = pals_birth($user_id,5);	
?><?php if(!empty($fir_list)){?>
<div class="container">
   <div class="sideitem_head"><h4><?php echo $mp_langpackage->mp_pal_birth;?></h4><a href="modules2.0.php?app=mypals_fribirth_month" target='frame_content'><?php echo $mp_langpackage->mp_more;?></a></div>
       <div class="sideitem_body">
       <ul id='pals_fribirth' class="userlist">
		<?php foreach($fir_list as $val){?>
		<li>
			<a class="avatar" href="home2.0.php?h=<?php echo $val['user_id'];?>" target="_blank" title="<?php echo $f_langpackage->f_fri;?>">
				<img src="<?php echo $val['user_ico'];?>" />
			</a>
		
			<span class="name">
				<a class="name" href="home2.0.php?h=<?php echo $val['user_id'];?>" target="_blank"><?php echo $val['user_name'];?></a>
			</span>
		
			<span class="time"><?php echo $val['birth_month'];?>-<?php echo $val['birth_day'];?></span>
			<span><img style="cursor:pointer;" onclick="<?php echo $send_hi;?>(<?php echo $val["user_id"];?>)" src="skin/<?php echo $skinUrl;?>/images/hi.gif" title="<?php echo $f_langpackage->f_greet;?>" /></span>
		</li>
		<?php }?>
		</ul>
    </div>
 </div>
<?php }?>
