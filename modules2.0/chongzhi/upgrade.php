<?php


	//引入公共模块
	require("foundation/module_event.php");
	require("api/base_support.php");
	
	//引入语言包
	$er_langpackage=new rechargelp;
	$dopost="savesend";
	
	//必须登录才能浏览该页面
	require("foundation/auser_mustlogin.php");
	
	$user_id=get_sess_userid();
	//限制时间段访问站点
	limit_time($limit_action_time);

	$friends=Api_Proxy("pals_self_by_paid","pals_name,pals_id,pals_ico");

	$userinfo=Api_Proxy("user_self_by_uid","*",$user_id);

	$info="<font color='#ce1221' style='font-weight:bold;'>".$er_langpackage->er_currency."</font>：".$userinfo['zibis'];

	if($userinfo['user_group'] >1 && $userinfo['user_group']!='base')

	{

		$groups=$dbo->getRow("select endtime from wy_upgrade_log where mid='$user_id' and state='0' order by id desc limit 1");

		//print_r($groups);

		$startdate=strtotime(date("Y-m-d"));

		$enddate=strtotime($groups['endtime']);

		$days=round(($enddate-$startdate)/3600/24);
		
		if($days>0){

			$info.="&nbsp;&nbsp;&nbsp;&nbsp;".$er_langpackage->er_howtime."：".$days.$er_langpackage->er_day;

		}else{

			$sql="update wy_upgrade_log set state='1' where mid='$user_id'";

			$dbo->exeUpdate($sql);

			$sql="update wy_users set  user_group='1'   where  user_id='$user_id'";

			$dbo->exeUpdate($sql);

		}
		
		
		$groups=$dbo->getRow("select name from wy_frontgroup where gid='$userinfo[user_group]'");


		if($langPackagePara!='zh')

		{

			$groups['name']=str_replace('普通会员','',$groups['name']);

			$groups['name']=str_replace('高级会员',$er_langpackage->js_8,$groups['name']);

			$groups['name']=str_replace('星级会员',$er_langpackage->js_10,$groups['name']);

		}
		if($days>0){
			$userinfo=Api_Proxy("user_self_by_uid","*",$user_id);
			$info.="&nbsp;&nbsp;&nbsp;&nbsp;".$er_langpackage->er_nowtype."：".$groups['name'];
		}
	}
	$uid=get_argg('user_id');
	if($uid){
		$u=$dbo->getRow("select user_name from wy_users where user_id='$uid'");
	}
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<style type="text/css">
#swf1 {
	position: fixed;
	top: 10px;
	left: 320px;
	z-index: 10000;
}
</style>
<link href="./template/upgrade/base_icon-min.css" rel="stylesheet" type="text/css">
<link href="./template/upgrade/index-min.css" rel="stylesheet" type="text/css">
<link href="./template/upgrade/jqzysns-min.css" rel="stylesheet" type="text/css">
<link href="./template/upgrade/optimization-icon.css" rel="stylesheet" type="text/css">
<link href="./template/upgrade/online-updater.css" rel="stylesheet" type="text/css">
<link href="./template/upgrade/upgrade.css" rel="stylesheet" type="text/css">
<style>
/*左侧导航标题*/


#app_nav1_lq .li-title {
	overflow: visible;
	position: relative;
	padding: 0;
	width: 100%;
	padding-left: 10px;
}
#app_nav1_lq .li-title .li-title-label {
	position: absolute;
	background: #fff;
	z-index: 5;
	padding-right: 8px;
}
#app_nav1_lq .li-title:before {
	position: absolute;
	top: 12px;
	content: '';
	height: 1px;
	width: 100%;
	background: #d9d9d9;
	overflow: hidden;
}
#app_nav1_lq .li-title:hover {
	background: transparent;
}
#app_nav1_lq .li-title i {
	position: absolute;
	top: -28px;
	left: 145px;
	cursor: pointer;
}
#left_nav_lq #app_nav1_lq li a {
	margin-left: 8px;
}
</style>
<script src="./template/upgrade/jquery-1.7.min.js" type="text/javascript"></script>


<script  type="text/javascript">

$(function(){
	
	
	
	$(".upgrade li").on('click',function(){
		
		supert($(this).find('.upgrade_zibi').html());
		
		
		$(".upgrade li").removeClass('checked');
		$(".upgrade i").removeClass('upgrade_checked');
		
		
		var $browsers = $("input[name=zibi]");  
		$browsers.attr("checked",false);
		$(this).addClass('checked');
		
		
		$(this).find('i').addClass('upgrade_checked');
		
		$(this).find('input').attr("checked","checked");;
		
		
		
		
		});
	
	
	
	
	})

</script>
<link href="./template/upgrade/themes.css" rel="stylesheet" type="text/css">
</head>
<body class="lan_cn">

<!--需要的-->
<div id="content_box1_lq" style="margin-bottom: 60px; background:#fff">
  <div id="iframe_div_lq">
    <div id="recharge_app_cyw" class="upgrade_main">
      <div class="online-updater-main">
        <div class="oum-nav" style="margin-top:-10px;">
          <div id="oumUpNav" class="tabs_lq">
          
            <a class="active1_tab_lq first_child_lq" url="/Recharge/List!/Recharge/Upgrade"><?php echo $er_langpackage->er_upgrade;?></a>      <a href="modules2.0.php?app=user_pay" hidefocus="true"><?php echo $er_langpackage->er_recharge;?></a>
          <a href="modules2.0.php?app=user_paylog" hidefocus="true"><?php echo $er_langpackage->er_recharge_log;?></a>
           <a href="modules2.0.php?app=user_consumption" hidefocus="true"><?php echo $er_langpackage->er_consumption_log;?>
           <a href="modules2.0.php?app=user_introduce" hidefocus="true"><?php echo $er_langpackage->er_introduce;?></a>
           
           <a href="modules2.0.php?app=user_help" hidefocus="true"><?php echo $er_langpackage->er_help;?></a>
          
          </div>
        </div>
        <div class="oum-body" id="js_app_cont">
          <form id="pay" name="pay" method="post" action="do.php">
            <input type="hidden" value="0" id="upgradeLevel">
            <input type="hidden" value="True" id="upgradeFlag">
            <!--升级会员页面优化start-->
            <div class="upgrade">
              <p class="ob-1-for-other"> </p>
              



              <!--升级VIP-->
              <div class="upgrade_box">
                <div class="box_left"> <i class="upgrade_vip"></i> </div>
                <div class="box_right">
                  <dl>
                    <dt>&nbsp;&nbsp;<?php echo $er_langpackage->er_zvip;?></dt>
                    <dd> ·&nbsp;<?php echo $er_langpackage->er_gj_shuoming1;?> </dd>
                    <dd> ·&nbsp;<?php echo $er_langpackage->er_gj_shuoming3;?></dd>
                  </dl>
                </div>
              </div>
              <div class="upgrade_list vip" id="upgradeVip">
                <ul>
                  <li>
                       <div class="price"> <span class="upgrade_font pt5" style=" color:#385679; font-size:20px;  font-weight:bold">180</span> </div>
                    <div class="price_cont">
                    <p class="cont_text" > <span class="upgrade_font"><?php echo $er_langpackage->er_zvip_1n;?></span> </p>
                      <input type="radio" value="zvip4" name="zibi" style="display: none">
                    </div>
                    <i class=""></i>
                  </li>
                  <li>
                    <div class="price"> <span class="upgrade_font pt5" style=" color:#385679; font-size:20px;  font-weight:bold">110</span> </div>
                    <div class="price_cont">
                     <p class="cont_text" > <span class="upgrade_font"><?php echo $er_langpackage->er_zvip_6y;?></span> </p>
                      <input type="radio" value="zvip3" name="zibi" style="display: none">
                    </div>
                    <i class=""></i>
                  </li>
                  <li>
                        <div class="price"> <span class="upgrade_font pt5" style=" color:#385679; font-size:20px;  font-weight:bold">70</span> </div>
                    <div class="price_cont">
                    <p class="cont_text" > <span class="upgrade_font"><?php echo $er_langpackage->er_zvip_3y;?></span> </p>
                      <input type="radio" value="zvip2" name="zibi" style="display: none">
                    </div>
                    <i class=""></i>
                  </li>
                  <li>
                        <div class="price"> <span class="upgrade_font pt5" style=" color:#385679; font-size:20px;  font-weight:bold">30</span> </div>
                    <div class="price_cont">
                      <p class="cont_text" > <span class="upgrade_font"><?php echo $er_langpackage->er_zvip_1y;?></span> </p>
                      <input type="radio" value="zvip1" name="zibi" style="display: none">
                    </div>
                    <i class=""></i>
                  </li>
                </ul>
              </div>



            <!-- 永久 -->
              <div class="upgrade_box">
                <div class="box_left"> <i class="upgrade_yj"></i> </div>
                <div class="box_right">
                  <dl>
                    <dt>&nbsp;&nbsp;<?php echo $er_langpackage->er_yj;?></dt>
                    <dd> ·&nbsp;<?php echo $er_langpackage->er_yj_shuoming1;?> </dd>
                    <dd> ·&nbsp;<?php echo $er_langpackage->er_gj_shuoming3;?></dd>
                  </dl>
                </div>
              </div>
              <div class="upgrade_list vip" id="upgradeVip">
                <ul>
                  <li class="checked">
                      <div class="price"> 
                        <span class="upgrade_font pt5" style=" color:#385679; font-size:20px;  font-weight:bold">199</span> 
                      </div>
                      <div class="price_cont">
                        <p class="cont_text" > 
                          <span class="upgrade_font">
                            <?php echo $er_langpackage->er_zvip_yj;?>
                          </span> 
                        </p>
                      <input type="radio" value="yj" name="zibi" style="display: none" checked=checked="checked">
                      </div>
                      <i class="upgrade_checked"></i>
                  </li>
                </ul>
              </div>
            </div>
            <!-- 永久end -->



            <!--支付方式-->
            <div class="ob-0-selpay selpay" id="selplay">
            <!--支付-->
       <!--     <div>
            
              <p class="pay_title"> 选择支付方式</p>
              <ul>
                <li>
                  <label>
                    <input class="radio" name="PaymentMethod" onclick="DpclearHtml()" type="radio" checked="checked" value="Alipay">
                    <img src="./template/upgrade/alipay-logo.png" alt="支付宝充值"> </label>
                </li>
                <li>
                  <label>
                    <input class="radio" name="PaymentMethod" onclick="DpclearHtml()" type="radio" value="PayPal">
                    <img src="./template/upgrade/paypal.png" alt="paypal充值"> </label>
                </li>
                <li>
                  <label>
                    <input class="radio" name="PaymentMethod" type="radio" value="Master" onclick="DpclearHtml()">
                    <img src="./template/upgrade/mastcar.png" alt="Master"> </label>
                </li>
                <li>
                  <label>
                    <input class="radio" name="PaymentMethod" type="radio" value="Visa" onclick="DpclearHtml()">
                    <img src="./template/upgrade/visa.png" alt="Visa"> </label>
                </li>
                <li>
                  <label>
                    <input class="radio" name="PaymentMethod" onclick="dpfunction()" type="radio" id="zibiPay" value="zibi">
                    <img src="./template/upgrade/dollar-logo.png"> </label>
                </li>
              </ul>
              <div class="renewArgement" style="display: none;">
                <input type="checkbox" name="Recurring" value="PayPalRecurring">
                <span> 开通自动循环支付服务，将会在会员到期前一天，自动扣款续费<a href="javascript:;" class="protocol" onclick="showRenewArgement();">《自动续费服务协议》</a></span> </div>
              </div>-->
           <!--支付 -->
              <div class="ob-1-upnow">
                <p style="position: absolute; top: 12px; left: 18px;">
                  <label id="dp_lable"> </label>
                </p>
                <input type="submit" class="blue_submitbtn1_lq" id="Paysenior" value="立即升级">
              </div>
            </div>
            <!--升级会员页面优化-end-->
            <input type="hidden" name='act' value="upgrade"/>
            <input type="hidden" name='touser' value="1"/>
            <input type="hidden" name='friends' value=""/>
            <input type="hidden" name='selfriend' value=""/>

          </form>
        </div>
      </div>
    </div>
  </div>
  <br class="clear_lq">
</div>

<!--需要的-->
<script type="text/javascript">

 // 计算页面的实际高度，iframe自适应会用到
    function calcPageHeight(doc) {
        var cHeight = Math.max(doc.body.clientHeight, doc.documentElement.clientHeight)
        var sHeight = Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight)
        var height  = Math.max(cHeight, sHeight)
        return height
    }
    window.onload = function() {
        var height = calcPageHeight(document);
        parent.document.getElementById('ifr').style.height = height + 'px'   ;
		
		  
    }
function supert(obj)
{
	if(obj><?php echo $userinfo['golds'];?>)
	{
		parent.Dialog.confirm('<?php echo $er_langpackage->er_mess;?>'+<?php echo $userinfo['golds'];?>+'<?php echo $er_langpackage->er_mess2;?>',function (){location='modules2.0.php?app=user_pay';});
	}
}

</script>

<script>


    // 计算页面的实际高度，iframe自适应会用到
    function calcPageHeight(doc) {
        var cHeight = Math.max(doc.body.clientHeight, doc.documentElement.clientHeight)
        var sHeight = Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight)
        var height  = Math.max(cHeight, sHeight)
        return height
    }
    window.onload = function() {
        var height = calcPageHeight(document);
        parent.document.getElementById('ifr').style.height = height +50+ 'px'   ;
		
		  
    }

</script>
</body>
</html>