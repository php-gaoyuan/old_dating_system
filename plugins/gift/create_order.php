<?php
    //打开get和post的封装
    $getpost_power=true;
    //打开系统库的支持
    $iweb_power=true;
    //打开session
    $session_power=true;
    //引入系统文件的支持文件
    include_once("../includes.php");
    //引入自己的配制文件
    include_once("config.php");
    include_once("../../includes.php");
    //echo "<pre>";print_r($_COOKIE);exit;
    //引入语言包
    $er_langpackage=new rechargelp;
    $gf_langpackage=new giftlp;
    $pu_langpackage=new publiclp;
    //取得变量区
    $uname=get_args("uname");
    $accept_name=get_args("accept");
    //$accept_id=get_args("accept_id");
    //$accept_id=empty($accept_id)?get_args("uid"):$accept_id;
    $gift=get_args("gift_img");
    if(empty($uname)){
        $friends=Api_Proxy("pals_self_by_paid","pals_name,pals_id,pals_ico");
    }
    //创建系统对数据库进行操作的对象
    $dbo=new dbex();
    //对数据进行读写分离，读操作
    dbplugin('r');
    //查询对应的礼品
    $id=$_REQUEST['id'];
    $sql="select * from gift_shop where  id='$id'";
    $gifts=$dbo->getRow($sql);
    //通过session得到用户ID
	$send_id=get_sess_userid();
	
	//创建系统对数据库进行操作的对象
	$dbo=new dbex();
	//读写分离，进行读操作
	dbplugin('r');
	//得到礼物所需金币
	$gift_id=$_GET['id'];
	$sql="select * from gift_shop where id=$_GET[id]";
	$gift_info=$dbo->getRow($sql);
	$money=(int)($gift_info['money']);
	$gift_path=$gift_info['patch'];
	$gifttype=$gift_info['typeid'];
	//得到发送者积分
	$sql="select * from wy_users where user_id={$send_id}";
	$user_info=$dbo->getRow($sql);
	$send_name=$user_info['user_name'];
    $golds = $user_info['golds'];
	$msg=addslashes($_POST['advice']);
	$send_time=date('Y-m-d H:i:s',time());
	$address=$_POST['toself'];
	$score=$money*$_GET[num];
	$gift_num=$_GET[num];
	//echo "<pre>";print_r($_REQUEST);


    //提交并写入订单
    if($_POST && ((!empty($_POST['toself']) || !empty($_POST['tofriends']) ))){
        //得到接受者信息
        $accept_name=$_POST['tofriends'];
        if($accept_name){
            $sql="select user_id from wy_users where user_name='$accept_name'";
            $accept_info=$dbo->getRow($sql);
            if(empty($accept_info)){
                if($_COOKIE['lp_name'] == 'zh') echo "<script>top.Dialog.alert('找不到礼物接受人');</script>";
                if($_COOKIE['lp_name'] == 'en') echo "<script>top.Dialog.alert('Can\'t find a gift recipient');</script>";
                echo "<script>top.location.href='/main2.0.php?app=giftshop';</script>";
                exit;
            }
        }
        $accept_id=$accept_info['user_id'];

        if($golds < $score){
            //echo "<script>top.Dialog.alert('".$pu_langpackage->less_golds."');</script>";
            echo "<script>alert('".$pu_langpackage->less_golds."');</script>";
            echo "<script>top.location.href='/main2.0.php?app=user_pay';</script>";
            exit;
        }else{
            dbplugin('w');

            //如果送给自己
            if(!empty($_POST['toself'])){
                if($_POST['toself'] != $send_name){
                    if($_COOKIE['lp_name'] == 'zh') echo "<script>alert('送给自己礼物出错');</script>";
                    if($_COOKIE['lp_name'] == 'en') echo "<script>alert('Give yourself a present.');</script>";
                    echo "<script>top.location.reload();</script>";
                    exit;
                }
                $sql="insert into gift_order(send_id,accept_id,send_name,accept_name,msg,gift,send_time,gifttype,accept_address,gift_id,gift_num) values('$send_id','$send_id','$send_name','$send_name','$msg','$gift_path','$send_time','$gifttype','$address','$gift_id','{$gift_num}')";
                //echo $sql;exit;
                if($dbo->exeUpdate($sql)){
                    echo "<script>top.Dialog.alert('$gf_langpackage->gf_mess_4');</script>";
                    $sql="update wy_users set golds=$golds-$score where user_id=$send_id";
                    $dbo->exeUpdate($sql);
                }
                //写充值记录
                $ordernumber='N-P'.time().mt_rand(100,999);
                $sql="insert into wy_balance set type='4',uid='$send_id',uname='$send_name',touid='$send_id',touname='$send_name',message='送禮物，價格：$score',state='2',addtime='$send_time',funds='$score',ordernumber='$ordernumber'";
                $dbo->exeUpdate($sql);

                api_proxy("message_set",$send_id,"{num}个礼物","main2.0.php?app=giftshop",0,20,"remind");
            }

            if(!empty($_POST['tofriends'])){
                $sql="insert into gift_order(send_id,accept_id,send_name,accept_name,msg,gift,send_time,gifttype,gift_id,gift_num) values('$send_id','$accept_id','$send_name','$accept_name','$msg','$gift_path','$send_time','$gifttype','$gift_id','{$gift_num}')";
                if($dbo->exeUpdate($sql)){
                    echo "<script>top.Dialog.alert('$gf_langpackage->gf_mess_4');</script>";
                    $sql="update wy_users set golds=$golds-$score where user_id=$send_id";

                    $dbo->exeUpdate($sql);
                }

                //写充值记录
                $ordernumber='N-P'.time().mt_rand(100,999);
                $sql="insert into wy_balance set type='4',uid='$send_id',uname='$send_name',touid='$accept_id',touname='$accept_name',message='送禮物，價格：$score',state='2',addtime='$send_time',funds='$score',ordernumber='$ordernumber'";
                $dbo->exeUpdate($sql);

                api_proxy("message_set",$accept_id,"{num}个礼物","main2.0.php?app=giftshop",0,20,"remind");
            }


        }
    }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title></title>
<style type="text/css">
*{font-family:"微软雅黑";font-size:12px;}
a{text-decoration:none;color:#666;}
a:hover {text-decoration:underline;color:#2C589E;}
.giftitem_top {height:30px;text-align:right;line-height:30px;border-bottom:1px solid #E5E5E5;}
.giftitem_top a{display:inline-block;}
.giftitem_top i{display:inline-block;float:left;width:19px;height:18px;background:url(icon_01.png) 0 -206px no-repeat;position:relative;top:5px;}
.giftitem_top span{display:inline-block;float:left;}
.giftitem_name{width:100%;height:42px;line-height:42px;font-weight:bold;font-size:16px;}
.gift_li{height:42px;line-height:42px;font-size:14px;}
.giftorderinfo ul li{list-style:none;width:25%;height:25px;line-height:25px;float:left;text-align:center;font-weight:bold;color:#666;border-top:1px solid #2C56A0;border-bottom:1px solid #9AA8C3;}
.giftorderinfo2 ul li{list-style:none;width:25%;height:70px;line-height:70px;float:left;text-align:center;border-bottom:1px dotted #666;padding:5px 0}
.giftorderinfo2 ul li img{width:70px;height:70px;border:1px solid #ccc;}
.giftorderinfo2:hover img{border:1px solid #FF931B;}
.text_advice #advice{color:#666;padding:3px;width:100%;height:50px;resize:none}
.text_advice #advice:focus {color:#666;padding:3px;width:100%;height:80px;}
#order_submit{margin-top:15px;color:#fff;border:none;padding:0 20px;font-size:15px;lin-height:32px;height:32px;background:url(czbtn.png) -10px 0 repeat-x;}
</style>
<script type="text/javascript" src="/skin/default/jooyea/jquery-1.9.1.min.js"></script>
</head>
<body>
	<form method="post" onsubmit="return checkform();">
        <div class="giftitem_top">
            <span><?php echo $pu_langpackage->querendingdan;?></span><a href="javascript:history.back();"><?php echo $pu_langpackage->fanhui;?></a>
        </div>
        <div class="giftitem_name"><?php echo $pu_langpackage->xuanzeshouhuoren;?></div>
        <div  class="gift_li">
            <label>
                <input type="radio" id="label1" name="towho" checked /><?php echo $pu_langpackage->songziji;?>
                <input type="hidden" name="toself" id="toself" value="<?php echo $user_info["user_name"];?>"  />
            </label>
        </div>
        <div  class="gift_li" style="border-bottom:1px dotted #ccc;padding-bottom:15px;">
            <label>
                <input type="radio" id="label2" name="towho"/><?php echo $pu_langpackage->songpengyou;?>
            </label>
            <input type="hidden" id="tofriends" name="tofriends"/>
            <select id="friends_list" name="friends_select" onchange="document.getElementById('tofriends').value=value;">
                <option value="" id="option_s"><?php echo $pu_langpackage->xuanzehaoyou;?></option>
                <?php foreach($friends as $friend){ ?>
                <option value="<?php echo $friend['pals_name'];?>"><?php echo $friend['pals_name'];?></option>
                <?php } ?>
            </select>
        </div>
        <div class="giftitem_name"><?php echo $pu_langpackage->liwuxinxi;?></div>
        <div class="giftorderinfo">
            <ul>
                <li><?php echo $pu_langpackage->shangpin;?></li><li><?php echo $pu_langpackage->danjia;?></li><li><?php echo $pu_langpackage->shuliang;?></li><li><?php echo $pu_langpackage->jinexiaoji;?>($)</li>
            </ul>
        </div>
        <div class="giftorderinfo2">
            <ul>
                <li><a href="giftitem.php?id=<?php echo $id;?>"><img src="/rootimg.php?src=<?php echo $gifts['yuanpatch'];?>&h=70&w=70&zc=1" /></a></li><li><?php echo $gifts['money'];?></li><li><?php echo $_REQUEST['num'];?></li><li><?php echo $gifts['money']*$_REQUEST['num'];?></li>
            </ul>
        </div>
        <div class="giftitem_name" style="clear:both"><?php echo $pu_langpackage->zengyan;?></div>
        <div class="text_advice">
            <textarea name="advice" id="advice"><?php echo $pu_langpackage->zengyans;?></textarea>
        </div>
        <div><input type="submit" id="order_submit" value="<?php echo $pu_langpackage->fukuan;?>"/></div>
	</form>
    <script>
    $(function(){
        $('#friends_list').change(function(){
            $('#label2').click()
        })
    })
    function checkform(){
        //if($('#tofriends').val() =='' && $('#toself').val() =='') {
        if($('#label2').attr('checked') ) {
            if($('#tofriends').val() ==''){
                top.Dialog.alert('<?php echo $pu_langpackage->zengsongduixiang;?>');
                return false;
            }
        }
        // if(!window.confirm("<?php echo $pu_langpackage->quedingma;?>")){
        // 	return false;
        // }
        return true;
    }
    </script>

</body>
</html>
