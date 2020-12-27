<?php
	require("foundation/fcontent_format.php");
	require("foundation/fgrade.php");
	//引入语言包
	$rf_langpackage=new recaffairlp;
	$u_langpackage=new userslp;

    ////变量取得
    //$user_id=get_sess_userid();
    //$user_sex=$_SESSION[$session_prefix.'user_sex'];//echo $user_sex;
    //$ra_rs = array();
	
	
    ////数据库读操作
    //$dbo=new dbex;
    //dbtarget('r',$dbServs);	
    ////page start
    //$pagesize = 20;//设置显示页码  
    //$pageval=$_GET['page'];
    //$num=count($dbo->getRs("select * from wy_online where user_id != '$user_id'"));
    //if($_GET['page']){
    //    $page=($pageval-1)*$pagesize;
    //    if($page<0) $page=0;
    //    $page.=',';
    //}
    //if($pageval<=1){  
    //    $pageval=1;
    //}    
    //$pre = $pageval-1;  
    //$next = $pageval+1; 
    //if($next>($num)) $next=$num;
    //if($num<=10) $next=1;
    ////var_dump($_SESSION);
    ////page end
    //$sql="select * from wy_online where user_id != '$user_id' and user_sex != '$user_sex' order by online_id desc limit $page $pagesize";
    //$ra_rs=$dbo->getRs($sql);
    //foreach($ra_rs as $rss){
    //    $sql="select integral,user_ico,country,reside_province,reside_city,birth_year,birth_month,birth_day,user_group,is_txrz from wy_users where user_id = '$rss[user_id]' ";
    //    $arr=$dbo->getRow($sql);
    //    $arr[]=array();
    //    $rs=array_merge($rss,$arr);
    //    $sql="select mood,mood_pic from wy_mood where user_id='$rss[user_id]' order by mood_id desc limit 1 ";
    //    $arrmood=$dbo->getRow($sql);
    //    if($arrmood)
    //        $rs=array_merge($rs,$arrmood);
    //    if(!$rs['user_ico']){
    //        $rs['user_ico']='skin/default/jooyea/images/d_ico_'.$rs['user_sex'].'.gif';
    //    }
    //    if($rs['user_sex']==0){$rs['user_sex']=$rf_langpackage->rf_woman;}else{$rs['user_sex']=$rf_langpackage->rf_man;}
    //    if($rs['user_group']==3){
    //        $rs['user_tt']='VIP';
    //    }else if($rs['user_group']==2){
    //        $rs['user_tt']='Senior Membe';
    //    }else{
    //        $rs['user_tt']='';
    //    }
    //    if(empty($rs['mood'])){$rs['mood']=$rf_langpackage->rf_lan;}
		
?>

<?php
	//引入语言包
	//require('api/base_support.php');
	$m_langpackage=new msglp;
	$mp_langpackage=new mypalslp;


  //变量获得
  $msg_id=intval(get_argg("id"));
  $user_id=get_sess_userid();
  $type=intval(get_argg("t"));
  $send_join_js="";

    $ses_uid=$user_id;
  //数据表定义
  $t_msg_inbox = $tablePreStr."msg_inbox";
  $t_msg_outbox = $tablePreStr."msg_outbox";
  $t_users=$tablePreStr."users";
  
	
	//加为好友 打招呼
	$add_friend="mypalsAddInit";
	$send_hi="hi_action";
	if(!$ses_uid){
	  	$add_friend='goLogin';
	  	$send_hi='goLogin';
	}
	

  $dbo = new dbex;
		//读写分离定义函数
  dbtarget('r',$dbServs);
  		//取出当前用户信息
  // $user_info=$dbo->getRow("select user_id,user_name,user_sex,user_group,user_add_time from $t_users where user_id=$user_id");

              if($type==1){//发件箱

                $sql="select mess_title,mess_content,to_user_id,to_user,to_user_ico,add_time,state,mess_id,mess_acc "
                     ."from $t_msg_outbox where mess_id='$msg_id'";
                    $msg_row = $dbo ->getRow($sql);
                    
                $relaUserStr=$m_langpackage->m_to_user;
                $reTurnTxt=$m_langpackage->m_out;
                $reTurnUrl="modules2.0.php?app=msg_moutbox";
                    $mess_id=$msg_row['mess_id'];
                if($msg_row['state']=="0"){
                   $reButTxt=$m_langpackage->m_b_sed;
                   $reButUrl="do.php?act=msg_send&to_id=$mess_id";
                }else{
                   $reButTxt=$m_langpackage->m_b_con;
                   $reButUrl=$reTurnUrl;
                }
              }else{//收件箱
                
                    $dbo = new dbex;
                    //读写分离定义函数
                    dbtarget('r',$dbServs);
                    $hh_id=$_GET['hhid'];
					if($hh_id==''){
						header("location:modules2.0.php?app=msg_rpshow2&id=".$_GET['id']."&t=".$type);
						exit;
					}
                    $sql="select * from $t_msg_inbox where hh_id='$hh_id' order by mess_id asc";
                    $msg_row = $dbo ->getRs($sql);
                    if(!$msg_row){header("location:".$siteDomain."modules2.0.php?app=msg_minbox");}
					//查询对方信息
					$sql="select mess_title,mess_id,user_id,from_user_ico,from_user,from_user_id from $t_msg_inbox where hh_id='$hh_id' and from_user_id!='$user_id' order by mess_id asc limit 1";
					$you_info=$dbo->getRow($sql);
                    
                    $relaUserStr=$m_langpackage->m_from_user;
                    $reTurnTxt=$m_langpackage->m_in;
                    $reButTxt=$m_langpackage->m_b_com;
                    $reTurnUrl="modules2.0.php?app=msg_minbox";
                    $mess_id=$you_info['mess_id'];
                    $from_user_id=$you_info['from_user_id'];
                    $mess_title=$you_info['mess_title'];
                    $mesint_id=$you_info['mesinit_id'];
                    $reButUrl="modules2.0.php?app=msg_creator&2id=$from_user_id&rt=".urlencode($mess_title)."&mesid=".$you_info;

                    if($type=='2'){
                        $send_join_js="mypals_add($from_user_id);";
                        $reTurnUrl="modules2.0.php?app=msg_notice";
                        $reButTxt=$m_langpackage->m_b_bak;
                        $reTurnTxt=$m_langpackage->m_to_notice;
                        $reButUrl=$reTurnUrl;
                    }
                    //读写分离定义函数
                    dbtarget('w',$dbServs);
					foreach($msg_row as $row2){
						 if($row2['readed']=="0"){
						  //$sql="update $t_msg_inbox set readed='1' where mess_id=$row2[mess_id]";
						 // $dbo ->exeUpdate($sql);
						  $sql="update $t_msg_outbox set state='2' where mess_id=$row2[mesinit_id]";
						  $dbo ->exeUpdate($sql);
						}
					}
					
					$sql="update $t_msg_inbox set readed='1' where mess_id=$msg_id";
					$dbo ->exeUpdate($sql);
					
              }
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
<link rel="stylesheet" href="servtools/kindeditor/themes/simple/simple.css" />
<link rel="stylesheet" href="servtools/kindeditor/themes/default/default.css" />
<SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>
<SCRIPT charset="utf-8" language=JavaScript src="servtools/kindeditor/kindeditor.js"></SCRIPT>
<script charset="utf-8" src="servtools/kindeditor/lang/zh_TW.js"></script>
<script charset="utf-8" src="skin/default/jooyea/jquery-1.9.1.min.js"></script>
<script type='text/javascript'>

function mypals_add_callback(content,other_id){
	if(content=="success"){
		parent.Dialog.alert("<?php echo $mp_langpackage->mp_suc_add;?>");
	}else{
		parent.Dialog.alert(content);
	}
}

function mypals_add(other_id){
	$.get("do.php?act=add_mypals&other_id="+other_id,function(c){mypals_add_callback(c,other_id);});
}

function join_event(event_id,fellow,template){
	$.post("do.php?act=event_join&event_id="+event_id+"&fellow="+fellow+"template="+template,function(c){parent.Dialog.alert(c);location.href="modules2.0.php?app=event_space&event_id="+event_id});
}
function sunitinfocheck(){
	var msContent=document.getElementById('msContent').value;
	if(!msContent || msContent==''){
		//parent.Dialog.alert("<?php echo $m_langpackage->m_no_cont;?>");
		return false;
	}
	//翻译
	var fanyi_select=document.getElementById('hf_fanyi').value;
	
	if(fanyi_select){
		var need=0;
		need=msContent.length/100;
		if(need<1) need=1;
		if(!confirm('<?php echo $m_langpackage->m_fanyitishi;?>'+need)){
			return false;
		}
		
	}
}
function fyc(id,to,fid){
	fanyi_txt=$('#fy_'+id).html();	
	var need=0;
	need=fanyi_txt.length/100;	
	if(need<1) need=1;
	top.Dialog.confirm('<?php echo $m_langpackage->m_fanyitishi;?> '+need,function(){
		$.get("fanyi.php",{lan:fanyi_txt,tos:to,ne:need,fid:fid},function(c){
			if(c==0){
				top.Dialog.alert("<?php echo $m_langpackage->qingchongzhi;?>");
				return false;
			}
			$('#fy_'+id).html(c);
		});
	})
}
function mail_fanyi(id,fid){
	var oldcon=document.getElementById('fy_btn_'+id).innerHTML;
	document.getElementById('fy_btn_'+id).innerHTML="<span style='width:400px;' class=' mess_span3'><a href='javascript:fyc("+id+",\"en\","+fid+");'>English</a><a href='javascript:fyc("+id+",\"zh\","+fid+");'>中文</a><a href='javascript:fyc("+id+",\"kor\","+fid+");'>한국어</a><a href='javascript:fyc("+id+",\"ru\","+fid+");'>русский</a><a href='javascript:fyc("+id+",\"spa\","+fid+");'>Español</a><a href='javascript:fyc("+id+",\"fra\","+fid+");'>Français</a><a href='javascript:fyc("+id+",\"jp\","+fid+");'>日本語</a></span>";
}
</script>
</head>
<body id="iframecontent">
   
    <div class="tabs" style="margin-top:0">
        <ul class="menu">
             <li class=""><a href="modules2.0.php?app=msg_creator" title="<?php echo $m_langpackage->m_title;?>" hidefocus="true"><?php echo $m_langpackage->m_title;?></a></li>
            <li class="active"><a href="modules2.0.php?app=msg_minbox" title="<?php echo $m_langpackage->m_in;?>" hidefocus="true"><?php echo $m_langpackage->m_in;?></a></li>
            <li><a href="modules2.0.php?app=msg_moutbox" title="<?php echo $m_langpackage->m_out;?>" hidefocus="true"><?php echo $m_langpackage->m_out;?></a></li>
            <li><a href="modules2.0.php?app=msg_notice" title="<?php echo $m_langpackage->m_notice;?>" hidefocus="true"><?php echo $m_langpackage->m_notice;?></a></li>
            <!--<li><a href="#" title="<?php echo $m_langpackage->m_uuchat;?>" hidefocus="true"><?php echo $m_langpackage->m_uuchat;?></a></li>
            <li><a href="#" title="<?php echo $m_langpackage->m_zixunjilu;?>" hidefocus="true"><?php echo $m_langpackage->m_zixunjilu;?></a></li>-->
        </ul>
    </div>
	<div class="mess_main">
		<div class="mess_ico">
			<a class="mess_a" href='home2.0.php?h=<?php echo $you_info['from_user_id'];?>' target="_blank">
				<img src='<?php echo $you_info['from_user_ico'];?>' onerror="parent.pic_error(this)" class='user_ico' />
			</a>
			<div class="mess_name">
				<p><?php echo $you_info['from_user'];?></p><!-- 进入个人首页 -->
				<p><a href='home2.0.php?h=<?php echo $you_info['from_user_id'];?>' target="_blank"><?php echo $m_langpackage->m_jrgrzy;?></a>

                <!-- Add By Root Begin -->
                
                <a style="position:relative; bottom:-7px;right:-30px" href="javascript:;" title="<?php echo $rf_langpackage->rf_liaotian;?>" onclick="top.i_im_talkWin('<?php echo $you_info['from_user_id'];?>','imWin');"><img src="skin/default/jooyea/images/C6.png" /></a></p>

                <!-- Add By Root End -->

			</div>
		</div>
		<div class="mess_xunhuan">
			<div class="mess_xh_tit"><span><a href="do.php?act=msg_del&t=all&hhid=<?php echo $hh_id;?>"><?php echo $m_langpackage->m_qbsc;?></a></span><span><a href="modules2.0.php?app=msg_minbox"><?php echo $m_langpackage->m_fanhuiliebiao;?></a></span></div>
		</div>
		<div class="mess_content">
			<?php foreach($msg_row as $k=>$v){?>
			
			<div class="mess_ico" id="mess_c_ico">
				<a class="mess_a" title="<?php echo $v['from_user'];?>" href='home2.0.php?h=<?php echo $v['from_user_id'];?>' target="_blank">
					<img src='<?php echo $v['from_user_ico'];?>' onerror="parent.pic_error(this)" class='user_ico' />
				</a>
				<div class="mess_name <?php if($v['from_user_id']!=$user_id){echo 'self';}else{echo 'other';}?>">
					<div class="<?php if($v['from_user_id']!=$user_id){echo 'mess_jt1';}else{echo 'mess_jt2';}?>"></div>
					<p id="fy_<?php echo $v['mess_id'];?>"><?php echo $v['mess_content'];?></p>
					<p style='color:#A5A5A6'><span class="mess_span1" id="fy_btn_<?php echo $v['mess_id'];?>"><?php echo $v['add_time'];?></span><span style='color:#2C589E' class="mess_span2"> <a href="javascript:void(0)" onclick="window.top.document.body.scrollTop=$('.mess_content').height();"><?php echo $m_langpackage->m_res;?></a>
					<a href="javascript:mail_fanyi('<?php echo $v['mess_id'];?>','<?php echo $v['from_user_id'];?>');">
					<?php echo $m_langpackage->m_transzd;?> 
					</a>
					<a href="do.php?act=msg_del&id=<?php echo $v['mess_id'];?>&t=3&hhid=<?php echo $v['hh_id'];?>"><?php echo $m_langpackage->m_del;?></a></span></p>
				</div>
			</div>
			
			<?php }?>
			
		</div>
		
	</div>
	<div id="huifu"  style="float:left;">
		<div class="anquantishi"><?php echo $m_langpackage->m_anquantishi;?></div>
		<form name="form1" onsubmit="sunitinfocheck();" method="post" action="do.php?act=msg_crt_hf" enctype="multipart/form-data">
			<input type="hidden" name="msg_title" value="<?php echo $you_info['mess_title'];?>">
			<input type="hidden" name="hh_id" value="<?php echo $hh_id;?>">
			<input name='2id' value='<?php echo $from_user_id;?>' type=hidden>
			<input name='mesid' value='<?php echo $you_info['mess_id'];?>' type=hidden>
			<span style="display:inline-block;float:left;line-height:25px;text-align: left;"><?php echo $m_langpackage->m_transzd;?>:
			<select id="hf_fanyi" name='hf_fanyi' onchange="if(this.value==''){document.getElementById('translate_s').innerHTML=''}else{document.getElementById('translate_s').innerHTML='<?php echo $mp_langpackage->translate_s;?>'}">
				<option value="" selected><?php echo $m_langpackage->m_transno;?></option>
				<option value="en">English</option>
				<option value="zh">中文(简体)</option>
				<option value="kor">한국어</option>
				<option value="ru">русский</option>
				<option value="spa">Español</option>
				<option value="fra">Français</option>
				<option value="ara"> عربي</option>
				<option value="jp">日本語</option>
			</select><span id="translate_s" style="color:#ff0000;"></span><br/>
			<textarea class="med-textarea" name="msContent" id="msContent" maxlength="160" cols="40" style="height:150px;background:transparent;overflow-x:hidden;visibility:hidden;float:left"></textarea>
			<input type="submit" id="hf_submit"  value="<?php echo $m_langpackage->m_b_con;?>">
		</form>
		<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('#msContent', {
					allowFileManager : true,
					width : '600px',
					height:'150px',
					items : [ 
						'fontname', 'fontsize', '|','forecolor','hilitecolor','|',   'bold',
						'italic', 'underline',    '|', 'justifyleft', 'justifycenter', 'justifyright','insertorderedlist', 'insertunorderedlist','|', 'emoticons',  'image',
					],
				});
			});
			
			function isMaxLen(o){
				var nMaxLen=o.getAttribute? parseInt(o.getAttribute("maxlength")):"";  
				if(o.getAttribute && o.value.length>nMaxLen){  
					o.value=o.value.substring(0,nMaxLen)  
				}
			}
			window.onload=function(){
				if($('.mess_content').height()>800){
					window.top.document.body.scrollTop=$('.mess_content').height();
				}
			}
		</script>
	</div>
</body>
</html>