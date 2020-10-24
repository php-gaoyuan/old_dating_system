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
	require("foundation/fcontent_format.php");
	require("foundation/fgrade.php");
	//引入语言包
	$rf_langpackage=new recaffairlp;
	$u_langpackage=new userslp;
	

	//变量取得
	$user_id=get_sess_userid();
	$user_sex=$_SESSION[$session_prefix.'user_sex'];//echo $user_sex;
	$ra_rs = array();
	
	
	//数据库读操作
	$dbo=new dbex;
	dbtarget('r',$dbServs);	
	//page start
	$pagesize = 20;//设置显示页码  
	$pageval=$_GET['page'];
	$num=count($dbo->getRs("select * from wy_online where user_id != '$user_id'"));
	if($_GET['page']){
		$page=($pageval-1)*$pagesize;
		if($page<0) $page=0;
		$page.=',';
	}
	if($pageval<=1){  
		$pageval=1;
	}    
	$pre = $pageval-1;  
	$next = $pageval+1; 
	if($next>($num)) $next=$num;
	if($num<=10) $next=1;
	//var_dump($_SESSION);
	//page end
	
	
	$sqlg = "select * from wy_users where user_id=$user_id";
	$userinfo = $dbo->getRow($sqlg);
	
	if($userinfo['user_sex'] == 1){
			$sql = "select * from wy_users where user_id != '$user_id' and user_sex != '$user_sex' and is_pass!='0' order by user_id desc limit $page $pagesize";

		}else{

				$sql="select * from wy_online where user_id != '$user_id' and user_sex != '$user_sex' order by online_id desc limit $page $pagesize";
	
		}
	



	//$sql="select * from wy_online where user_id != '$user_id' and user_sex != '$user_sex' order by online_id desc limit $page $pagesize";
	
	$ra_rs=$dbo->getRs($sql);




	foreach($ra_rs as $rss){
		$sql="select integral,user_ico,country,reside_province,reside_city,birth_year,birth_month,birth_day,user_group,is_txrz from wy_users where user_id = '$rss[user_id]' ";
		$arr=$dbo->getRow($sql);
		$arr[]=array();
		$rs=array_merge($rss,$arr);
		$sql="select mood,mood_pic from wy_mood where user_id='$rss[user_id]' order by mood_id desc limit 1 ";
		$arrmood=$dbo->getRow($sql);
		if($arrmood)
			$rs=array_merge($rs,$arrmood);
		if(!$rs['user_ico']){
			$rs['user_ico']='skin/default/jooyea/images/d_ico_'.$rs['user_sex'].'.gif';
		}
		if($rs['user_sex']==0){$rs['user_sex']=$rf_langpackage->rf_woman;}else{$rs['user_sex']=$rf_langpackage->rf_man;}
		if($rs['user_group']==3){
			$rs['user_tt']='VIP';
		}else if($rs['user_group']==2){
			$rs['user_tt']='Senior Membe';
		}else{
			$rs['user_tt']='';
		}
		if(empty($rs['mood'])){$rs['mood']=$rf_langpackage->rf_lan;}
		
?>

<li id="feed_<?php echo $rs['online_id'];?>">
	<div class="avatar">
		<a href="home2.0.php?h=<?php echo $rs['user_id'];?>" target="_blank" title=""><img src="<?php echo $rs['user_ico'];?>"></a>
	</div>
	<div class="details">
		<h3><?php echo $rs['user_name'];?> <img src="skin/default/jooyea/images/ico_zt_zx.png" style="position:relative;top:5px;cursor:pointer" title="<?php echo $u_langpackage->u_onl;?>"/></h3>
		<div class="content" style="position:relative;"><span style="display:block;width:350px;float:left;"><?php echo $rs['user_sex'].' '.$rs['country'];?></span>
			<span class="add_f" style="display:inline-block;position:relative;left:80px;"><img src="skin/default/jooyea/images/add.gif"/><a href="javascript:top.mypals_add(<?php echo $rs[user_id];?>);"><?php echo $rf_langpackage->rf_jiahaoyou;?></a></span>
			
		</div>
		<div class="content" style="position:relative;"><span>
		<?php if($rs['user_group']==2){echo "<img title='$rs[user_tt]' src='skin/default/jooyea/images/xin/gaoji.png'/>";} ?>
		<?php if($rs['user_group']==3){echo "<img title='$rs[user_tt]' src='skin/default/jooyea/images/xin/vip.gif'/>";} ?>
		</span>
		<?php if($rs['is_txrz']==1){echo '<a href="modules2.0.php?app=renzheng"><i class="txrz_home" title="'.$u_langpackage->touxiangrenzheng.'"></i></a>';}?>
		<span style="position:relative;top:-4px"><span title="<?php echo count_level($rs['integral']);?>"><?php echo grade($rs['integral']);?></span></span>
			<div class="add_f content_ch1" style="background:url(skin/default/jooyea/images/ch.jpg) no-repreat;height:22px;width:90px;position:absolute;right:0;top:0;">
				<a style="width:22px;height:22px;float:left;display:block" href="javascript:;" title="<?php echo $rf_langpackage->rf_liaotian;?>" onclick="top.i_im_talkWin('<?php echo $rs[user_id];?>','imWin');"></a>
				<a style="width:22px;height:22px;float:left;display:block" href="javascript:;" title="<?php echo $rf_langpackage->rf_dazhaohu;?>" onclick="top.hi_action(<?php echo $rs[user_id];?>)"></a>
				<a style="width:22px;height:22px;float:left;display:block" href="javascript:;" title="<?php echo $rf_langpackage->rf_fayoujian;?>" onclick="<?php if($userinfo['user_group']==2 || $userinfo['user_group'] == 3){ ?> top.frame_content.location.href='modules2.0.php?app=msg_creator&2id=<?php echo $rs[user_id];?> ';return false; <?php } else { ?> alert('<?php echo $u_langpackage->readmore; ?>');<?php } ?>"></a>
				<a style="width:22px;height:22px;float:left;display:block" href="plugins/gift/giftshop.php" title="<?php echo $rf_langpackage->rf_songliwu;?>"></a>
				<div style="clear:both"></div>
				
			</div>
			<div style="clear:both"></div>
		
		</div>
		
		<div class="content content_mood" title="<?php echo $rs['mood'];?>" style="">
			<div class="rs_mood" id="rs_mood_<?php echo $rs['user_id'];?>"><?php echo filt_word(get_face($rs['mood']));?></div>
			
			<div id="fanyi_mood">
				<select id="fanyi_select_<?php echo $rs['user_id'];?>" onchange="fanyi_mood('<?php echo $rs['user_id'];?>')">
					<option value=""><?php echo $rf_langpackage->rf_fanyi;?></option>
					<option value="en">English</option>
					<option value="zh">中文(简体)</option>
					<option value="kor">한국어</option>
					<option value="ru">русский</option>
					<option value="spa">Español</option>
					<option value="fra">Français</option>
					<option value="ara"> عربي</option>
					<option value="jp">日本語</option>
				</select>
			</div>
			<div style="clear:both;"></div>
		</div>
		
	</div>
	
</li>




<?php } ?>

<?php if($userinfo['user_group']==2 || $userinfo['user_group'] == 3){
	
	echo "<div class=\"pages_bar\">";
	echo "<a href=\"javascript:;\" onclick=\"list_recent_affair('',5,'',$pre);window.top.document.body.scrollTop=0;\">$rf_langpackage->rf_prev</a> ";
	echo "<a href=\"javascript:;\" onclick=\"list_recent_affair('',5,'',$next);window.top.document.body.scrollTop=0;\" >$rf_langpackage->rf_next</a>";
	echo "</div>";

}else{
	echo "<br/>
	<style>
	
	</style>
	<span><a href='http://www.partyings.com/main.php?app=user_upgrade' target='_blank'>$u_langpackage->readmore</a></span>";
}

?>



