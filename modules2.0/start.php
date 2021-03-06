<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/start.html
 * 如果您的模型要进行修改，请修改 models/modules/start.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
//引入心情模块公共方法
	require("foundation/module_mood.php");
	require("foundation/module_users.php");
	require("foundation/fgrade.php");
	require("foundation/fdnurl_aget.php");
	require("foundation/fpages_bar.php");
	require("api/base_support.php");
	require("foundation/auser_mustlogin.php");


//引入语言包
	//$mo_langpackage=new moodlp;
	$l_langpackage=new loginlp;
    $pu_langpackage=new publiclp;
	$rf_langpackage=new recaffairlp;
	$ah_langpackage=new arrayhomelp;
    $mp_langpackage=new mypalslp;
    $im_langpackage=new impressionlp;
	$mn_langpackage=new menulp;
	$rl=new recaffairlp;
	$u_langpackage=new userslp;
	$rond=get_argg('rond');
	
	$user_id=get_sess_userid();

	//数据表定义区
	//数据表定义区
	$table='';
    $t_online=$tablePreStr."online";
	$t_mood=$tablePreStr."mood";
    $t_users=$tablePreStr."users";
	$t_users_info=$tablePreStr."user_info";
	$t_users_information=$tablePreStr."user_information";

	$dbo=new dbex;
	//读写分离定义方法
	dbtarget('r',$dbServs);
	/*
	//获得最新的心情
	$last_mood_rs=get_last_mood($dbo,$t_mood,$user_id);
    //print_r($last_mood_rs);exit;
	$last_mood_txt='';
	if(isset($last_mood_rs['mood'])){
		$last_mood_txt=sub_str($last_mood_rs['mood'],35).' [<a href="modules.php?app=mood_more">'.$mo_langpackage->mo_more_label.'</a>]';
	}else{
		$last_mood_txt=$mo_langpackage->mo_null_txt;
	}
	*/
	//读取幻灯片
	$sql="select * from wy_hd where cat_id=3 order by ord desc , id desc limit 5";
	$hd_list=$dbo->getRs($sql);
	
	$lovemes="";
	if(!empty($rond))
	{
		$rf_langpackage->rf_hylb=$rf_langpackage->rf_onelove;
		$lovemes='<div class="gray mt20">'.$rf_langpackage->rf_mess.'</div>';
	}

	$user_info=api_proxy("user_self_by_uid","guest_num,integral,user_add_time,user_group,onlinetimecount",$user_id);
    //print_r($user_info);

	//$remind_rs=api_proxy("message_get","remind",1,5);//取得空间提醒
	//$remind_count=api_proxy("message_get_remind_count");//取得空间提醒数量
    //$t_users on $t_online.user_id=$t_users.user_id
	$page_num=trim(get_argg('page'));
    
  /*
    
	$sql="select  $t_users.*,$t_online.*,$t_mood.* from $t_users left join $t_online on $t_users.user_id=$t_online.user_id  left join $t_mood on $t_users.user_id=$t_mood.user_id where $t_users.user_id=$t_online.user_id   order by $t_mood.add_time desc";
	
    select $t_online.*,$t_mood.*,$t_users.* from  $t_online  left join $t_mood on $t_mood.user_id=$t_online.user_id left join $t_users on $t_users.user_id=$t_online.user_id  GROUP BY $t_online.user_id order by $t_mood.add_time desc limit 0,6	

    select * from (select $t_mood.mood,$t_users.user_id,$t_users.user_name,$t_users.user_ico,$t_users.user_group from  $t_users  left join $t_mood on $t_users.user_id=$t_mood.user_id order by $t_mood.add_time desc) as tmp GROUP BY tmp.user_id

	$online_list=$dbo->getRs($sql);
    //取出全部会员
	*/
    $sql=" select user_id,user_name,user_sex,birth_year,user_ico,user_group from  $t_users  order by user_id desc limit 6";

  
   // $page_num=trim(get_argg('page'));
   //$online_list=$dbo->getRs($sql);
    //$dbo->setPages(6,$page_num);//设置分页
    $online_list=$dbo->getRs($sql);
   //print_r($user_new_rs);exit;
  // $page_total=$dbo->totalPage;
   //echo $page_total;
   //echo  $page_num;
   //print_r($online_list);
  
//
    //验证30分钟体验时间
        $addtime = strtotime($user_info['user_add_time']);
        
        $endtime = $addtime + 30*60;

        $nowtime = time();

        if($nowtime>=$endtime || $user_info['user_sex'] ==1 ){

            if($user_info['user_group']=='base' || $user_info['user_group']=='1'){
                if($page_num>2){
                    echo "<script>alert('".$mp_langpackage->mp_quanxian."');location.href='modules.php?app=user_pay';</script>";
                    exit();
                }
            }else if($user_info['user_group']=='2'){
                if($page_num>15){
                    echo "<script>alert('".$mp_langpackage->mp_quanxian."');location.href='modules.php?app=user_pay';</script>";
                    exit();
                }
            }else{
                 
            }

        
        }

        $dbo2=new dbex();
        //定义读操作
        dbtarget('r',$dbServs);
        $now_today=intval(date('Y'));
        //循环的取出每个会员的额外信息
       
        foreach($online_list as $key=>$value){
          
            $online_info=$dbo2->getRs("select online_id from $t_online where user_id=".$value['user_id']);
           foreach($online_info as $k=>$v){
               $online_list[$key]['online_id'] = $v['online_id']; 
            }
          
 
        }
        
        //控制显示
        $isset_data="";
        $none_data="content_none";
        $isNull=0;
        if(empty($online_list)){
            $isset_data="content_none";
            $none_data="";
            $isNull=1;
        }
	
 //var_dump(page_show($isNull,$page_num,$page_total));exit;
    //$sql="select * from  $t_online  order by active_time desc";
     //echo $sql;
   //$online_list=$dbo->getRs($sql);

   	//获取用户自定义属性列表
   
	//$information_rs=array();
	$information_rs=userInformationGetList($dbo,'*');
    

    //评价印象用户列表
    $sql="select user_id,user_name,user_ico from $t_users order by rand() limit 1";
    $impression_list=$dbo->getRs($sql);
    $dbo2=new dbex();
    //定义读操作
    dbtarget('r',$dbServs);
    $now_today=intval(date('Y'));
    //循环的取出每个会员的额外信息
    /*
    foreach($impression_list as $key=>$value){
        if(empty($value['birth_year'])){
             $impression_list[$key]['birth_year']=$mp_langpackage->mp_noyear;
        }else{
             $impression_list[$key]['birth_year']=$now_today-$value['birth_year'].$mp_langpackage->mp_years;
        }
        $extra_info=$dbo2->getRs("select info_id,info_value from $t_users_info where user_id=".$value['user_id']);
        
        foreach($extra_info as $k=>$v){
             $impression_list[$key][$user_information_arr[$v['info_id']]]=$v['info_value'];
        }
    }
    */
    //print_r($impression_list);exit;
	$user=$dbo->getRow("select * from $t_users where user_id='$user_id'");
	/*if(!$user['user_ico'] && !$_COOKIE['uico']){
		setcookie('uico',1,time()+60);
		echo "<script>top.Dialog.alert('".$u_langpackage->u_set_ico."');</script>";
		echo "<script>setTimeout(function(){window.location.href='/modules.php?app=user_ico'},2000)</script>";
	}*/
	if($user['is_pass']==0){
		echo "<script>top.Dialog.alert('".$l_langpackage->l_lock_u."');</script>";
		echo "<script>window.location.href='/modules.php?app=user_info';</script>";
	}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css" />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/shou.css" />
<script charset="utf-8" src="skin/default/jooyea/jquery-1.9.1.min.js"></script>
<script>var jq=jQuery.noConflict();</script>
<script language=JavaScript src="skin/default/js/jooyea.js"></script>
<script language=JavaScript src="skin/default/js/yao.js"></script>
<SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>

<script type='text/javascript'>
	
	<?php 
	if($_GET['v']){ ?>
		location.href='/plugins/gift/giftitem.php?id=<?php echo $_GET['v']; ?>';
	<?php } ?>
	function set_state_view(set_ol_hidden){
		var ol_state_ico=$("ol_ioc_gif");
		var ol_state_label=$("ol_label_txt");
		var ol_state_reset=$("set_state");
		if(set_ol_hidden==1){
			ol_state_ico.src='skin/<?php echo $skinUrl;?>/images/hiddenline.gif';
			ol_state_label.innerHTML='<?php echo $u_langpackage->u_hidden;?>';
			ol_state_reset.innerHTML='<a href="javascript:set_ol_state(0);"><?php echo $u_langpackage->u_set_onl;?></a>';
		}else if(set_ol_hidden==0){
			ol_state_ico.src='skin/<?php echo $skinUrl;?>/images/online.gif';
			ol_state_label.innerHTML='<?php echo $u_langpackage->u_onl;?>';
			ol_state_reset.innerHTML='<a href="javascript:set_ol_state(1);"><?php echo $u_langpackage->u_set_hidden;?></a>';
		}
	}
	function set_ol_state(set_ol_hidden){
		//var ol_state=new Ajax();//实例化Ajax
		//ol_state.getInfo("do.php","GET","app","act=user_ol_reset&is_hidden="+set_ol_hidden,function(c){set_state_view(set_ol_hidden);});
		jq.get("do.php?act=user_ol_reset",{'is_hidden':set_ol_hidden},function(c){
			set_state_view(set_ol_hidden);
		});
	}
	function fanyi_mood(id){
		var fanyi_txt=document.getElementById('rs_mood_'+id).innerHTML;
		
		var fanyi_select=document.getElementById('fanyi_select_'+id).value;
		var need=0;
		need=len(fanyi_txt)/100;
		if(need<1) need=1;
		if(fanyi_select==''){return false;}
		top.Dialog.confirm('<?php echo $u_langpackage->fy_tishi2;?>'+need,function(){
			jq.post("fanyi.php",{lan:fanyi_txt,tos:fanyi_select,ne:need,fid:id},function(c){
				if(c=='0'){
					parent.Dialog.alert("<?php echo $u_langpackage->fy_tishi1;?>");
					return false;
				}
				jq('#rs_mood_'+id).html(c);
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
	function submit_new_mood(){
		var fanyi_tp=jq('#fanyifs').val();//翻译类型
		var mood_r_pic=jq('#mood_real_pic').val();//心情图片
		var last_mood_div=$("the_last_mood");
		var mood_text=trim(jq("#mood_txt").val());
		var need=0;
		
		need=len(mood_text)/100;
		if(need<1) need=1;
		if(mood_text=='<?php echo $rf_langpackage->rf_placeholder_text;?>'){
			return false
		}
		if(fanyi_tp){
			if(mood_text==''){
				return false;
			}
			top.Dialog.confirm('<?php echo $u_langpackage->fy_tishi2;?>'+need,function(){
				jq.get("fanyi.php",{lan:mood_text,tos:fanyi_tp,ne:need},function(ca){
					
					if(ca==0 || !ca){
						parent.Dialog.alert("<?php echo $u_langpackage->fy_tishi1;?>");
						return false;
					}
					
					jq.post("do.php?act=mood_add&ajax=1",{mood:ca,mood_r_pic:mood_r_pic},function(d){
						
						last_mood_div.innerHTML='';$("mood_txt").value="";
						$('add_mood').onclick();
					});
				});
			})
			
		}else{
			if(mood_text==''){
				return false;
			}else{
				last_mood_div.innerHTML='<?php echo $u_langpackage->u_data_post;?>';
				
				jq.post("do.php?act=mood_add&ajax=1",{mood:mood_text,mood_r_pic:mood_r_pic},function(c){
					last_mood_div.innerHTML='';$("mood_txt").value="";
					$('add_mood').onclick();
				});
			}
		}
		
		
	}

//新鲜事
function list_recent_affair(h_id,ra_type,is_more,page){
	if(page=='') page=1;
	
	var recent_affair_div=jq("#sec_Content");
	if(is_more!=1){//重新切换类别新鲜事则清空预设值
		jq('#affair_start_num').val(0);
		recent_affair_div.html("<div id=\"loadingid\" class=\"loading\"><span class='right'><?php echo $ah_langpackage->ah_loading_data;?></span><img src='skin/<?php echo $skinUrl;?>/images/loading.gif'></div>");
	}else{
		jq('#affair_start_num').val(parseInt(jq('#affair_start_num').val())+<?php echo $mainAffairNum;?>);
	}
	if(ra_type=='' && ra_type!==0)	ra_type=jq('#affair_type').val();
		else jq('#affair_type').val(ra_type);
		var start_num=parseInt(jq('#affair_start_num').val());
		//var list_affair=new Ajax();//实例化Ajax
		if(ra_type!=5){
			hidden_obj('none_data');show_obj('affair_info');
			
			jq.get("modules.php?app=recent_affair&",{'t':ra_type,'start_num':start_num},function(c){
				if(is_more==1 && c){
					
					recent_affair_div.html(recent_affair_div.html()+c);
					
				}else{
					recent_affair_div.html(c);
				}
				if(c=='' || !c){
					jq("#loadingid").css('display','none');
					jq("#none_data").css('display','block');
					jq("#affair_info").css('display','none');
				}else{pick_script(c);}
			});
		}else if(ra_type==5){
			hidden_obj('affair_info');
			
			jq.get("modules.php?app=recent_online&",{'page':page},function(c){
				hidden_obj('none_data');
				recent_affair_div.html(c);
				if(c=='' || !c){show_obj('none_data');}else{pick_script(c);}
			});
		}
		
}

function clear_remind(remind_id){
	if(parseInt($("remind_count").innerHTML)==1){
		$("remind_main").style.display='none';
	}
	$("remind_count").innerHTML=parseInt($("remind_count").innerHTML)-1;
	var ajax_remind=new Ajax();
	ajax_remind.getInfo("do.php","GET","app","act=message_del&id="+remind_id,function(c){$("remind_list").innerHTML=c;});
}

function changeStyle(obj){
	var tagList = obj.parentNode;
	var tagOptions = tagList.getElementsByTagName("li");
	for(i=0;i<tagOptions.length;i++){
		if(tagOptions[i].className.indexOf('active')>=0){
			tagOptions[i].className = '';
		}
	}
	obj.className = 'active';
}
parent.showDiv();



function fyc(con,to){
	var need=0;
	need=len(con)/100;
	if(need<1) need=1;
	top.Dialog.confirm('<?php echo $u_langpackage->fy_tishi2;?> '+need,function(){
		jq.get("fanyi.php",{lan:con,tos:to,ne:need},function(c){
			if(c==0){
				top.Dialog.alert("<?php echo $u_langpackage->fy_tishi1;?>");
				return false;
			}
			jq('#subject_con').html(c);
			jq('#f_list').css('display','none');
		});
	})
}
function fyc_com(id,to){
	var text=jq('#sub_com_'+id).html();
	var need=0;
	need=len(text)/100;
	if(need<1) need=1;
	top.Dialog.confirm('<?php echo $u_langpackage->fy_tishi2;?> '+need,function(){
		jq.get("fanyi.php",{lan:text,tos:to,ne:need},function(c){
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
<body id="main_iframe">
<input type='hidden' id='affair_type' value=0 />
<input type='hidden' id='affair_start_num' value=0 />
<div class="mypanel"  style="<?php if(get_argg('if_home')==1){echo 'margin-top:-10px';}?>">
   
    <div class="weiduduan clearfix" id="hd_m" style="<?php if(get_argg('if_home')==1){echo 'display:none';}?>">
<div id="news">
    <?php foreach($hd_list as $hd){?>
	<dl><dt>
	  <a target="_blank" href="<?php echo $hd['ad_link'];?>" title="<?php echo $hd['title'];?>"><img src="<?php echo $hd['ad_pic'];?>" alt="<?php echo $hd['title'];?>" /></a>
	</dt></dl>
	<?php }?>
    <p id="newsInfo">
		<?php foreach($hd_list as $key=>$hd){?>
		<a href="javascript:;" class="current"> </a>
		<?php }?>
	</p>
	<div class="close" onclick="hide_hd()">X</div>
<script type="text/javascript">
function hide_hd(){
	document.getElementById('hd_m').style.display='none';
	document.getElementById('show_face').style.top='45px';
	document.getElementById('id_txt').style.top='35px';
}
<!--
YAO.YTabs({
	tabs: YAO.getEl('newsInfo').getElementsByTagName('a'),
	contents: YAO.getEl('news').getElementsByTagName('dl'),
	auto: true,
	fadeUp: true
});
//-->
</script>    
</div>
</div>

    <div class="sendbox" onclick="show('face_list_menu',200)"><span id="sendbox_jt"></span>
      <textarea type="text" name="mood_txt" maxlength="300" onkeyup="return isMaxLen(this);" id="mood_txt" onfocus="if(this.value=='<?php echo $rf_langpackage->rf_placeholder_text;?>'){this.value=''}" title="<?php echo $rf_langpackage->rf_placeholder_text;?>"><?php echo $rf_langpackage->rf_placeholder_text;?></textarea>
	 
	  <select name="fanyif" id="fanyifs" style="width:90px;">
		<option value=""><?php echo $rf_langpackage->rf_nofanyi;?></option>
		<option value="en">English</option>
		<option value="zh">中文(简体)</option>
		<option value="kor">한국어</option>
		<option value="ru">русский</option>
		<option value="spa">Español</option>
		<option value="fra">Français</option>
		<option value="ara"> عربي</option>
		<option value="jp">日本語</option>
	  </select>
      <input type="submit" name="button" id="button" value="<?php echo $u_langpackage->u_putout?>" onclick="submit_new_mood();" />
      <span id="the_last_mood" class="newmood"><?php echo filt_word($last_mood_txt);?></span>
    </div> 
	<!--<div class="add_pic" style="<?php if(get_argg('if_home')==1){echo 'margin-top:-130px';}?>"><a onclick="document.getElementById('mood_pic').click()"></a>
		<form id="hide_form" action="do.php?act=mood_up_acttion" method="post" enctype="multipart/form-data" target="frame_up" style="position:relative;left:1000px">
		<input id="mood_pic" type="file" name="attach" style="margin-left:1000px" onchange="jq('#hide_form').submit()"/>
		</form>
	</div>-->
	<input type="hidden" name="mood_real_pic" id="mood_real_pic" value="">
	<div class="show_face" style="<?php if(get_argg('if_home')==1){echo 'margin-top:-130px';}?>" id="show_face" onclick="showFace(document.getElementById('mood_txt'),'face_list_menu','mood_txt');"></div>
	<div class="less_txt" style="<?php if(get_argg('if_home')==1){echo 'margin-top:-130px';}?>" id="id_txt"><i id="less_txt">300</i></div>
	<iframe name='frame_up' id="frame_up" style='display:none'></iframe>
	
</div>
<!--空间提醒!-->
<?php if($remind_rs){?>
<div class="remind_box" id="remind_main">
	<div class="remind_title">
		<a href="modules.php?app=remind_message" class="more"><?php echo $rf_langpackage->rf_more;?></a>
		<?php echo $rf_langpackage->rf_space;?>(<span id='remind_count'><?php echo $remind_count[0];?></span>)
	</div>
	<ul class="remind_list" id="remind_list">
		<?php foreach($remind_rs as $rs){?>
			<li id='remind_<?php echo $rs['id'];?>'>
				<div class="photo"><a href="home2.0.php?h=<?php echo $rs['from_uid'];?>" target="_blank"><img src="<?php echo $rs['from_uico'];?>" width="20px" height="20px" alt="" target="_blank" /></a></div>
				<div class="remind_content">
					<a href="home2.0.php?h=<?php echo $rs['from_uid'];?>" target="_blank"><?php echo $rs['from_uname'];?></a>
					<?php echo str_replace(array("{link}","{js}"),array($rs['link'],"clear_remind(".$rs['id'].")"),filt_word($rs['content']));?>
					<?php echo $rs['count']>=2 ? "(".$rs['count'].$ah_langpackage->ah_times.")":'';?>
				</div>
				<div class="remind_del"><a href="javascript:clear_remind(<?php echo $rs['id'];?>)"></a></div>
			</li>
		<?php }?>
	</ul>
</div>
<div class="clear"></div>
<?php }?>

<!--空间提醒!-->
<div class="tabs" style="padding-left:10px;">
    <ul class="menu">
        <li onclick="list_recent_affair(<?php echo $user_id;?>,5);changeStyle(this);" id="click_index" class="active"><a href="javascript:;" hidefocus="true"><?php echo $rf_langpackage->rf_onlines;?></a></li>
        <li id="add_mood" onclick="list_recent_affair(<?php echo $user_id;?>,0);changeStyle(this);"><a href="javascript:;" hidefocus="true"><?php echo $rf_langpackage->rf_affair;?></a></li>
        <!-- <li onclick="list_recent_affair(<?php echo $user_id;?>,1);changeStyle(this);"><a href="javascript:;" hidefocus="true"><?php echo $rf_langpackage->rf_state;?></a></li> -->
        <li onclick="list_recent_affair(<?php echo $user_id;?>,2);changeStyle(this);"><a href="javascript:;" hidefocus="true"><?php echo $rf_langpackage->rf_album;?></a></li>
        <li onclick="list_recent_affair(<?php echo $user_id;?>,3);changeStyle(this);"><a href="javascript:;" hidefocus="true"><?php echo $rf_langpackage->rf_blog;?></a></li>
        <li onclick="list_recent_affair(<?php echo $user_id;?>,4);changeStyle(this);"><a href="javascript:;" hidefocus="true"><?php echo $rf_langpackage->rf_share;?></a></li>
        <li onclick="list_recent_affair(<?php echo $user_id;?>,6);changeStyle(this);"><a href="javascript:;" hidefocus="true"><?php echo $mn_langpackage->mn_group;?></a></li>
    </ul>
</div>
<div class="feedcontainer">
	<ul id="sec_Content"></ul>
	<div id='none_data' style="display:none;" class="gray mt20"><?php echo $rf_langpackage->rf_none;?></div>
	<div title="<?php echo $ah_langpackage->ah_see_more_novelty;?>" id="affair_info" onclick="list_recent_affair(<?php echo $user_id;?>,'',1);" class="more" ></div>
</div>
<!-- <div class="set_fresh_news"><a class="highlight" href="modules.php?app=user_affair"><?php echo $rf_langpackage->rf_new_set;?></a></div> -->
<div id="append_parent"></div>
<div style="display: none;" class="emBg" id="face_list_menu"></div>

<script type='text/javascript'>
	//set_state_view(<?php echo get_sess_online();?>);
	window.onload=function(){
		document.getElementById('click_index').onclick();
		
	}
	
</script>

</body>
</html>