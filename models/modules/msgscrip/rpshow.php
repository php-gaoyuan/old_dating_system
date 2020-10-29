<?php
	//引入语言包
	require('api/base_support.php');
	$m_langpackage=new msglp;
	$mp_langpackage=new mypalslp;

    $ah_langpackage=new arrayhomelp;
    $gu_langpackage=new guestlp;
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
                      }
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
	//echo 123;
   //echo str_replace('send_join_js',$send_join_js,$msg_row['mess_content']);

?>