<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/msgscrip/rpshow.html
 * 如果您的模型要进行修改，请修改 models/modules/msgscrip/rpshow.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
	//引入语言包
	require('api/base_support.php');
	$m_langpackage=new msglp;
	$mp_langpackage=new mypalslp;

  //变量获得
  $msg_id=intval(get_argg("id"));
  $user_id=get_sess_userid();
  $type=intval(get_argg("t"));
  $send_join_js="";
  $user_id=get_sess_userid();
    $ses_uid=get_sess_userid();
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
   $user_info=$dbo->getRow("select user_id,user_name,user_sex,user_group,user_add_time from $t_users where user_id=$user_id");



        //验证30分钟体验时间
        $addtime = strtotime($user_info['user_add_time']);
        
        $endtime = $addtime + 30*60;

        $nowtime = time();

        if($nowtime>=$endtime){


              if($type==1){//发件箱

                $sql="select mess_title,mess_content,to_user_id,to_user,to_user_ico,add_time,state,mess_id,mess_acc "
                     ."from $t_msg_outbox where mess_id='$msg_id'";
                    $msg_row = $dbo ->getRow($sql);
                    
                $relaUserStr=$m_langpackage->m_to_user;
                $reTurnTxt=$m_langpackage->m_out;
                $reTurnUrl="modules.php?app=msg_moutbox";
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
                    
                    $sql="select mess_title,mess_content,from_user_id,from_user,from_user_ico,add_time,mesinit_id,mess_id,readed,transtype,enmess_title,enmess_content,mess_acc "
                       ."from $t_msg_inbox where mess_id='$msg_id'";
                    $msg_row = $dbo ->getRow($sql);
                     
                    //print_r($msg_row);
                    if($msg_row['readed']=='0' && $msg_row['mesinit_id']!=0){	      
                        
                      //站内信邮票判断开始
					  /*
                      $to_user_info=$dbo->getRow("select * from $t_users where user_id=$user_id");
                     
                      if($to_user_info['user_group']<=2){//非星级会员
                          $sex=$to_user_info['user_sex'];
                          if($sex!=0){//非女性会员
                              $t_stamps= $tablePreStr."stamps";
                              $sql="select id from $t_stamps where from_uid=".$to_user_info['user_id']." and to_uid=".$msg_row['from_user_id'];
                    
                              $recorder=$dbo->getRow($sql);
                              
                              if(empty($recorder)){
                                  if($to_user_info['stamps_num']<1){  	  	  	
                                      echo "<script type='text/javascript'>alert('".$m_langpackage->m_stampsmsg."');location.href='modules.php?app=user_stamps';</script>";
                                      exit;
                                  }else{
                                      $date=date('Y-m-d H:i:s');
                                      $from_uid=$to_user_info['user_id'];
                                      $from_uname=$to_user_info['user_name'];
                                      
                                      $to_uid=$msg_row['from_user_id'];
                                      $to_uname=$msg_row['from_user'];
                                      
                                      $sql="insert into $t_stamps (from_uid,from_uname,to_uid,to_uname,addtime) 
                                      values ('$from_uid','$from_uname','$to_uid','$to_uname','$date')";
                                      
                                      $dbo->exeUpdate($sql);
                                      
                                      //减少会员邮票数量
                                      $sql="update $t_users set stamps_num=stamps_num-1 where user_id=".$from_uid;
                                      $dbo->exeUpdate($sql);		  	  	  	  	  
                                  }
                              }
                          }
                      }*/
                      //站内信邮票判断结束			
                    }	

                    
                    $relaUserStr=$m_langpackage->m_from_user;
                    $reTurnTxt=$m_langpackage->m_in;
                    $reButTxt=$m_langpackage->m_b_com;
                    $reTurnUrl="modules.php?app=msg_minbox";
                    $mess_id=$msg_row['mess_id'];
                    $from_user_id=$msg_row['from_user_id'];
                    $mess_title=$msg_row['mess_title'];
                    $mesint_id=$msg_row['mesinit_id'];
                    $reButUrl="modules.php?app=msg_creator&2id=$from_user_id&rt=".urlencode($mess_title)."&mesid=".$mess_id;

                    if($type=='2'){
                        $send_join_js="mypals_add($from_user_id);";
                        $reTurnUrl="modules.php?app=msg_notice";
                        $reButTxt=$m_langpackage->m_b_bak;
                        $reTurnTxt=$m_langpackage->m_to_notice;
                        $reButUrl=$reTurnUrl;
                    }
                    //读写分离定义函数
                    dbtarget('w',$dbServs);
                if($msg_row['readed']=="0"){
                  $sql="update $t_msg_inbox set readed='1' where mess_id=$mess_id";
                  $dbo ->exeUpdate($sql);
                  $sql="update $t_msg_outbox set state='2' where mess_id=$mesint_id";
                  $dbo ->exeUpdate($sql);
                }
              }

        
        }else{
              if($type==1){//发件箱

                $sql="select mess_title,mess_content,to_user_id,to_user,to_user_ico,add_time,state,mess_id,mess_acc "
                     ."from $t_msg_outbox where mess_id='$msg_id'";
                    $msg_row = $dbo ->getRow($sql);
                    
                $relaUserStr=$m_langpackage->m_to_user;
                $reTurnTxt=$m_langpackage->m_out;
                $reTurnUrl="modules.php?app=msg_moutbox";
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
                    
                    $sql="select mess_title,mess_content,from_user_id,from_user,from_user_ico,add_time,mesinit_id,mess_id,readed,transtype,enmess_title,enmess_content,mess_acc "
                       ."from $t_msg_inbox where mess_id='$msg_id'";
                    $msg_row = $dbo ->getRow($sql);	

                    
                    $relaUserStr=$m_langpackage->m_from_user;
                    $reTurnTxt=$m_langpackage->m_in;
                    $reButTxt=$m_langpackage->m_b_com;
                    $reTurnUrl="modules.php?app=msg_minbox";
                    $mess_id=$msg_row['mess_id'];
                    $from_user_id=$msg_row['from_user_id'];
                    $mess_title=$msg_row['mess_title'];
                    $mesint_id=$msg_row['mesinit_id'];
                    $reButUrl="modules.php?app=msg_creator&2id=$from_user_id&rt=".urlencode($mess_title)."&mesid=".$mess_id;

                    if($type=='2'){
                        $send_join_js="mypals_add($from_user_id);";
                        $reTurnUrl="modules.php?app=msg_notice";
                        $reButTxt=$m_langpackage->m_b_bak;
                        $reTurnTxt=$m_langpackage->m_to_notice;
                        $reButUrl=$reTurnUrl;
                    }
                    //读写分离定义函数
                    dbtarget('w',$dbServs);
                if($msg_row['readed']=="0"){
                  $sql="update $t_msg_inbox set readed='1' where mess_id=$mess_id";
                  $dbo ->exeUpdate($sql);
                  $sql="update $t_msg_outbox set state='2' where mess_id=$mesint_id";
                  $dbo ->exeUpdate($sql);
                }
              }
        }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
<SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>
<script type='text/javascript'>
function mypals_add_callback(content,other_id){
	if(content=="success"){
		parent.Dialog.alert("<?php echo $mp_langpackage->mp_suc_add;?>");
	}else{
		parent.Dialog.alert(content);
	}
}

function mypals_add(other_id){
	var mypals_add=new Ajax();
	mypals_add.getInfo("do.php","get","app","act=add_mypals&other_id="+other_id,function(c){mypals_add_callback(c,other_id);}); 
}

function join_event(event_id,fellow,template){
	var event_add=new Ajax();
	event_add.getInfo("do.php?act=event_join","post","app","event_id="+event_id+"&fellow="+fellow+"&template="+template,function(c){parent.Dialog.alert(c);location.href="modules.php?app=event_space&event_id="+event_id}); 
}
</script>
</head>
<body id="iframecontent">
   
    <div class="tabs" style="margin-top:0">
        <ul class="menu">
             <li class=""><a href="modules.php?app=msg_creator" title="<?php echo $m_langpackage->m_title;?>" hidefocus="true"><?php echo $m_langpackage->m_title;?></a></li>
            <li <?php if($_GET['t']==0){echo 'class="active"';}?>><a href="modules.php?app=msg_minbox" title="<?php echo $m_langpackage->m_in;?>" hidefocus="true"><?php echo $m_langpackage->m_in;?></a></li>
            <li <?php if($_GET['t']==1){echo 'class="active"';}?>><a href="modules.php?app=msg_moutbox" title="<?php echo $m_langpackage->m_out;?>" hidefocus="true"><?php echo $m_langpackage->m_out;?></a></li>
            <li><a href="modules.php?app=msg_notice" title="<?php echo $m_langpackage->m_notice;?>" hidefocus="true"><?php echo $m_langpackage->m_notice;?></a></li>
           <!-- <li><a href="#" title="<?php echo $m_langpackage->m_uuchat;?>" hidefocus="true"><?php echo $m_langpackage->m_uuchat;?></a></li>
            <li><a href="#" title="<?php echo $m_langpackage->m_zixunjilu;?>" hidefocus="true"><?php echo $m_langpackage->m_zixunjilu;?></a></li>-->
        </ul>
    </div>

	<div class="mess_main">
	<?php if($type!='2'){?>
	<div class="mess_ico">
		<a class="mess_a" href='home2.0.php?h=<?php echo $msg_row[to_user_id];?>' target="_blank">
			<img src='<?php echo $msg_row[to_user_ico];?>' onerror="parent.pic_error(this)" class='user_ico' />
		</a>
		<div class="mess_name">
			<p><?php echo $msg_row['to_user'];?></p>
			<p><a href='home2.0.php?h=<?php echo $msg_row[to_user_id];?>' target="_blank"><?php echo $m_langpackage->m_jrgrzy;?></a></p>
			
		</div>
	</div>
	<?php }?>
	<table class="form_table <?php echo $isset_data;?>" >
		
		
		<tr>
			<th><?php echo $m_langpackage->m_tit;?>：</th>
			<td><?php echo $msg_row[0];?></td>
		</tr>
		
		<tr>
			<th> <?php echo $m_langpackage->m_time;?>：</th>
			<td><?php echo $msg_row[5];?></td>
		</tr>
		<tr>
			<th><?php echo $m_langpackage->m_cont;?>：</td>
			<td><?php echo str_replace("{send_join_js}",$send_join_js,$msg_row[1]);?></td>
		</tr>
		
		<tr>
			<td>
				&nbsp;
			</td>
			<td>
				<input type=button class="regular-btn" value="<?php echo $reButTxt;?>" onclick="location.href='<?php echo $reButUrl;?>'">
			</td>
			<td>
				<input type=button class="regular-btn" value="<?php echo $m_langpackage->m_del;?>"	onclick='location.href="do.php?act=msg_del&id=<?php echo $msg_id;?>&t=<?php echo get_argg("t");?>";'>
			</td>
		</tr>
	</table>
	</div>
</body>
</html>