<style type="text/css">
/*万圣节gif图样式*/


* {
	font-family: 'Microsoft YaHei';
	margin:0; 
	padding:0
}
#cwxBg {
	position: absolute;
	display: none;
	width: 100%;
	height: 100%;
	left: 0px;
	top: 0px;
	z-index: 1000;
}
#cwxWd {
	position: absolute;
	display: none;
	padding: 10px;
	z-index: 1500;
}
#cwxCn {
	display: block;
}
.imgd {
	width: 600px;
	height: 350px;
}
</style>
<style type="text/css">
#swf1 {
	position: fixed;
	top: 10px;
	left: 320px;
	z-index: 10000;
}
</style>
<link rel="shortcut icon" href="https://www.gagahi.com/favicon.png">
<link href="./template/main/base_icon-min.css" rel="stylesheet" type="text/css">
<link href="./template/main/index-min.css" rel="stylesheet" type="text/css">
<link href="./template/main/jqzysns-min.css" rel="stylesheet" type="text/css">
<link href="./template/main/email_gift_recharge_lq-min.css" rel="stylesheet" type="text/css">
<link href="./template/main/photo_user_vote_sun-min.css" rel="stylesheet" type="text/css">
<link href="./template/main/blog_group_invit_lf-min.css" rel="stylesheet" type="text/css">
<link href="./template/main/friends_visit_other_lf-min.css" rel="stylesheet" type="text/css">
<link href="./template/main/flower.css" rel="stylesheet" type="text/css">
<link href="./template/main/list.css" rel="stylesheet" type="text/css">
<link href="./template/main/optimization-icon.css" rel="stylesheet" type="text/css">
<link href="./template/main/online-member.css" rel="stylesheet" type="text/css">
<link href="./template/main/christmas2014.css" rel="stylesheet" type="text/css">
<link href="./template/main/discounts.css" rel="stylesheet" type="text/css">
<link href="./template/main/widgets.css" rel="stylesheet" type="text/css">
<link href="./template/main/private-letter.css" rel="stylesheet" type="text/css">
<link href="./template/main/online-updater.css" rel="stylesheet" type="text/css">
<link href="./template/main/upgrade.css" rel="stylesheet" type="text/css">
<link href="./template/main/giftone.css" rel="stylesheet" type="text/css">
<link href="./template/main/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="./template/main/headUpload.css" type="text/css">

<link href="./template/main/something.css" rel="stylesheet" type="text/css">
<link href="./template/main/gifttwo.css" rel="stylesheet" type="text/css">

 <!-----------在线用户------------->
      <div id="onlineMember-box" class="gift_send2_window">
        <div class="online-member-box">
          <div class="title-class"> <span class="online-title-icon"></span> <span class="ml10">在线用户</span> </div>
          <div id="jspub_main_box1_lf" class="scroll_bar1_lq">
            <div class="scrollbar" style="width: 735px;">
              <div class="track" style="width: 735px;">
                <div class="thumb hidden1_lq" style="left: 0px; width: 244.00406504065037px;">
                  <div class="end" style="height: 6px;"> </div>
                </div>
              </div>
            </div>
            <div class="viewport" style="height: 285px; width: 735px;">
              <div class="overview" style="left: 0px; width: 2214px;">
                <!---------在线-------------------->
                <ul class="js_list_ul js_giftBox_content  pic-box-list  js_memberList">
                  
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
	$pagesize = 18;//设置显示页码  
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
                  
                  
                  <li class="pblist-li mr15">
                    <div class="online-member-cols">
                      <div class="picboxli-head">
                        <div class="avatar-box" uname="wsox" data-label="美女"> <a target="_blank" href="https://www.gagahi.com/u/wsox"> <img src="./template/main/wsox_big.png"> <i class="online_icon1_lq"></i><i class="christmas-adornmentso"></i></a>
                          <div class="loveLabel">
                            <div class="setwh">
                              <label>美女</label>
                            </div>
                          </div>
                        </div>
                        <div class="picboxli-head-info">
                          <p class="phi-1"> <i class="left-nav-icon vip_icon0_lq mr5"></i><span class="picinfo-name"> <a target="_blank" href="https://www.gagahi.com/u/wsox" title="wsox"> wsox</a></span> 
                            <!--<i class="left-nav-icon lv_icon"></i><span class="lv-num">{{user.Level}}</span>--> 
                          </p>
                          <p class="phi-2"> <span> 28</span> <span class="ml5 mr5"> |</span> <span class="s-country" title="Taiwan(China)"> Taiwan(China)</span> </p>
                          <div class="piclib-icon"> <span class="lib-icon-1" member="wsox"><a member="wsox" onclick=" redHeartClick(this) "></a><i></i></span> <span class="lib-icon-3" member="wsox"><a onclick=" sendMailClick(this) "> </a><i></i></span><span class="lib-icon-4" member="wsox"><a member="wsox" data-hito="https://img.gagahi.com/Upload/Header/w/ws/wso/wsox_small.png" onclick=" addFriendClick(this) "></a><i></i> </span> </div>
                        </div>
                      </div>
                    </div>
                    <div class="online-member-cols">
                      <div class="picboxli-head">
                        <div class="avatar-box" uname="ivan124899" data-label=""> <a target="_blank" href="https://www.gagahi.com/u/ivan124899"> <img src="./template/main/ivan124899_big.png"> <i class="online_icon1_lq"></i><i class="christmas-adornmentso"></i></a>
                          <div class="loveLabel">
                            <div class="setwh"> </div>
                          </div>
                        </div>
                        <div class="picboxli-head-info">
                          <p class="phi-1"> <i class="left-nav-icon vip_icon0_lq mr5"></i><span class="picinfo-name"> <a target="_blank" href="https://www.gagahi.com/u/ivan124899" title="ivan124899"> ivan124899</a></span> 
                            <!--<i class="left-nav-icon lv_icon"></i><span class="lv-num">{{user.Level}}</span>--> 
                          </p>
                          <p class="phi-2"> <span> 27</span> <span class="ml5 mr5"> |</span> <span class="s-country" title="Bulgarien"> Bulgarien</span> </p>
                          <div class="piclib-icon"> <span class="lib-icon-1" member="ivan124899"><a member="ivan124899" onclick=" redHeartClick(this) "></a><i></i></span> <span class="lib-icon-3" member="ivan124899"><a onclick=" sendMailClick(this) "> </a><i></i></span><span class="lib-icon-4" member="ivan124899"><a member="ivan124899" data-hito="https://img.gagahi.com/Upload/Header/i/iv/iva/ivan124899_middle.png" onclick=" addFriendClick(this) "></a><i></i> </span> </div>
                        </div>
                      </div>
                    </div>
                  </li>
                
                  
                  
                  
              <?php } ?>    
                  
             
                </ul>
                
                 <!---------在线-------------------->
              </div>
            </div>
          </div>
          <div class="picbtn picbtn-1 js_prePicbtn disable"><a></a></div>
          <div class="picbtn picbtn-2 js_nextPicbtn"><a></a></div>
        </div>
      </div>
      
        <!-----------在线用户------------->

	

	