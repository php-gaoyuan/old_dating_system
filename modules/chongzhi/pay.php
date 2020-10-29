<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/chongzhi/pay.html
 * 如果您的模型要进行修改，请修改 models/modules/chongzhi/pay.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
	//引入公共模块
	require("foundation/module_event.php");
	require("api/base_support.php");
	
	//引入语言包
	$er_langpackage=new rechargelp;
	$dopost="savesend";
	
	//必须登录才能浏览该页面
	require("foundation/auser_mustlogin.php");
	
	$user_id=get_sess_userid();
	$uname=get_args('uname');
	
	//echo $user_id;
	//限制时间段访问站点
	limit_time($limit_action_time);
		
	$friends=Api_Proxy("pals_self_by_paid","pals_name,pals_id,pals_ico");

	$userinfo=Api_Proxy("user_self_by_uid","*",$user_id);

	$info="<font color='#ce1221' style='font-weight:bold;'>".$er_langpackage->er_currency."</font>：".$userinfo['golds'];

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
		}						$groups=$dbo->getRow("select name from wy_frontgroup where gid='$userinfo[user_group]'");		if($langPackagePara!='zh')		{			$groups['name']=str_replace('普通会员','',$groups['name']);			$groups['name']=str_replace('高级会员',$er_langpackage->js_8,$groups['name']);			$groups['name']=str_replace('星级会员',$er_langpackage->js_10,$groups['name']);		}		if($days>0){
			$userinfo=Api_Proxy("user_self_by_uid","*",$user_id);			$info.="&nbsp;&nbsp;&nbsp;&nbsp;".$er_langpackage->er_nowtype."：".$groups['name'];		}
	}

	$sumoney=0;
	switch ($userinfo['user_group'])
	{
		/*case 1:
		  $sumoney=200*95/100;
		  break;*/
		case 2:
		  $sumoney=200;
		  break;
		case 3:
		  $sumoney=200;
		  break;
		default:
		  $sumoney=200;
	}
	$uid=get_argg('user_id');
	if($uid){
		$u=$dbo->getRow("select user_name from wy_users where user_id='$uid'");
	}
?><link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css" />
<script language=JavaScript src="skin/default/js/jooyea.js"></script>
<SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDrag.js"></script>
<script type="text/javascript" language="javascript" src="servtools/dialog/zDialog.js"></script>
<script type="text/javascript" language="javascript" src="skin/default/jooyea/jquery-1.9.1.min.js"></script>
<script>
var zkk=0;
function check(obj)
{
	var check=new Ajax();
	check.getInfo("do.php","get","app","act=pay&ajax=1&user_name="+obj,function(c){if(c){zkk=c;getdollar();}else{Dialog.alert('<?php echo $er_langpackage->er_Dos_notex;?>');}});
}

function getsumdollar()
{
	var zhekou=0;
	var who=document.getElementsByName("touser");
	if(who[0].checked==true)
	{
		if(document.getElementById("zkk").value=='base')
		{
			zhekou=0;
		}
		else
		{
			zhekou=document.getElementById("zkk").value;
		}
	}
	else
	{
		zhekou=zkk;
	}

	var sumdollar=new Number(document.getElementById("dollar").innerHTML);
	switch(zhekou)
	{
	   //case '1':
		// sumdollar=sumdollar*95/100;
		// break
	   // case '2':
		 // sumdollar=sumdollar*95/100;
		 // break
	   // case '3':
		 // sumdollar=sumdollar*9/10;
		 // break
	   default:
		 sumdollar=sumdollar;
	}
	document.getElementById("dollar").innerHTML=sumdollar.toFixed(2);
}

function getdollar()
{
	var obj=document.getElementById("sxzibi");
	if(obj.value=='')
	{
		var dollar="";
		var zibi=document.getElementsByName("zibi");
		for(var i=0;i<zibi.length;i++)
		{
			if(zibi[i].checked==true)
			{
				dollar=zibi[i].value;
			}
		}
		document.getElementById("dollar").innerHTML=dollar;
		document.getElementById("sxzibi").value='';
	}
	else
	{
		document.getElementById("dollar").innerHTML=obj.value;
	}
	getsumdollar();
}
</script>
<body>
<div class="tabs" style="border:1px solid #ce1221;text-align:left;background:#F5F5B9;padding-left:15px;line-height:25px;">
    <?php  echo $info;?>
</div>
<div class="tabs">
    <ul class="menu">
        <li class="active"><a href="modules2.0.php?app=user_pay" hidefocus="true"><?php echo $er_langpackage->er_recharge;?></a></li>
        <li><a href="modules2.0.php?app=user_paylog" hidefocus="true"><?php echo $er_langpackage->er_recharge_log;?></a></li>
        <li><a href="modules2.0.php?app=user_consumption" hidefocus="true"><?php echo $er_langpackage->er_consumption_log;?></a></li>
        <li><a href="modules2.0.php?app=user_upgrade" hidefocus="true"><?php echo $er_langpackage->er_upgrade;?></a></li>
        <li><a href="modules2.0.php?app=user_introduce" hidefocus="true"><?php echo $er_langpackage->er_introduce;?></a></li>
        <li><a href="modules2.0.php?app=user_help" hidefocus="true"><?php echo $er_langpackage->er_help;?></a></li>
    </ul>
</div>
<div class="feedcontainer">
	<ul id="sec_Content">
	<form id="pay" name="pay" method="post" action="do.php" target="_blank">
	<input name="act" type="hidden" value="pay" />
	<input name="zkk" id="zkk" type="hidden" value="<?php echo $userinfo['user_group'];?>" />
	<!--<li style="height:auto;padding: 19px 25px;">
		<?php echo $er_langpackage->er_tshi;?>
	</li>-->
	<li style="height:auto;padding: 19px 25px;border-bottom:0px;">
			
			<div style="font-weight:700;line-height:40px;text-align:left"><?php echo $er_langpackage->er_goumaijinbi;?></div>
			<div class="pay_content">
			 <label><input type="radio" name="touser" onclick="getdollar();$('#friends_text').css('display','none');$('#friends').val('')" value="1" checked="checked" />:
				<?php echo $er_langpackage->er_oneself;?></label>
				<label>
					<input type="radio" name="touser" id="tofriends" onclick="getdollar();$('#friends_text').css('display','')" value="2" <?php if($uname || $uid){?>checked="checked"<?php }?> />:
					<?php echo $er_langpackage->er_friends;?>&nbsp;&nbsp;
					<span id="friends_text" style="<?php if($uid){echo 'display:';}else{echo 'display:none';}?>">
						<input type="text" name="friends" id="friends" style="width:80px;height:25px;" onchange="check(value)" value="<?php echo $u['user_name'];?>" />&nbsp;&nbsp;
						<select name="selfriend" id="selfriend" onchange="document.getElementById('friends').value=value;check(value);$('#tofriends').click()">
						  <option value=""><?php echo $er_langpackage->er_choose_fr;?></option>
						  <?php foreach($friends as $friend){?>
						  <option value="<?php echo $friend['pals_name'];?>"><?php echo $friend['pals_name'];?></option>
						  <?php }?>
						</select>
					</span>
				</label>
			</div>
			<div style="font-weight:700;font-size:14px;line-height:40px;text-align:left"><?php echo $er_langpackage->er_chongzhijine;?></div>
				
					<div class="gold_list">
						<label>
						<input name="zibi" type="radio" value="30" onclick="getdollar()" />&nbsp;
						<img src="/skin/<?php echo $skinUrl;?>/images/s_main_46.gif" style="vertical-align: middle;" /><?php echo $er_langpackage->er_20jinbi;?>
						</label>
					</div>
					<div class="gold_list">
						<label>
						<input name="zibi" type="radio" value="50" onclick="getdollar()" />&nbsp;
						<img src="/skin/<?php echo $skinUrl;?>/images/s_main_46.gif" style="vertical-align: middle;" /><?php echo $er_langpackage->er_50jinbi;?>
						</label>
					</div>
					<div class="gold_list">
						<label>
						<input name="zibi" type="radio" value="100" onclick="getdollar()" />&nbsp;
						<img src="/skin/<?php echo $skinUrl;?>/images/s_main_46.gif" style="vertical-align: middle;" /><?php echo $er_langpackage->er_100jinbi;?>
						</label>
					</div>
					<div class="gold_list">
						<label>
						<input name="zibi" type="radio" value="200" onclick="getdollar()" checked="checked" />&nbsp;
						<img src="/skin/<?php echo $skinUrl;?>/images/s_main_46.gif" style="vertical-align: middle;" /><?php echo $er_langpackage->er_200jinbi;?>
						</label>
					</div>
					<div class="gold_list">
						<label>
						<input name="zibi" type="radio" value="500" onclick="getdollar()" />&nbsp;
						<img src="/skin/<?php echo $skinUrl;?>/images/s_main_46.gif" style="vertical-align: middle;" /><?php echo $er_langpackage->er_500jinbi;?>
						</label>
					</div>
					<div class="gold_list">
						<label>
						<input name="zibi" type="radio" value="1000" onclick="getdollar()" />&nbsp;
						<img src="/skin/<?php echo $skinUrl;?>/images/s_main_46.gif" style="vertical-align: middle;" /><?php echo $er_langpackage->er_1000jinbi;?>
						</label> 
					</div>
					<div class="gold_list">
						<label><?php echo $er_langpackage->er_zidingyi;?><input type="text" name="sxzibi" id="sxzibi" style="width:80px;height:25px;" onkeyup="value=value.replace(/[^\d]/g,'');getdollar();" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"  onkeydown="getdollar()" /></label>
						<font  style="font-weight:bold;"><?php echo $er_langpackage->er_currency;?>&nbsp;&nbsp;<?php echo $er_langpackage->er_need;?>(</font><span style="color:red;" id="dollar"><?php echo $sumoney;?></span><font  style="font-weight:bold;">)<?php echo $er_langpackage->er_dollars;?></font>
					</div>
					<div class="gold_list">
						<label><input name="zhifu" type="radio" value="5" checked="checked" /><img src="/skin/<?php echo $skinUrl;?>/images/fuHui.png"/>&nbsp;&nbsp;</label>
						<label><input name="zhifu" type="radio" value="1" /><img src="/skin/<?php echo $skinUrl;?>/images/papy.jpg"/>&nbsp;&nbsp;</label>
						<!--<label><input name="zhifu" type="radio" value="2" /><img src="/skin/<?php echo $skinUrl;?>/images/caifutong.jpg"/>&nbsp;&nbsp;</label>-->
						<!-- <label><input name="zhifu" type="radio" value="4" /><img src="/skin/<?php echo $skinUrl;?>/images/alipay.gif"/>&nbsp;&nbsp;</label>
						<label><input name="zhifu" type="radio" value="3" /><img src="/skin/<?php echo $skinUrl;?>/images/kqlogo.gif"/>&nbsp;&nbsp;</label> -->
						
					</div> 

					<!-- 弹窗start -->
					<style>
						#ipays{
							padding:10px;
							text-align: left;
							border:1px solid #333;
							border-radius: 3px;
							/*display: none;*/
						}
						#ipays h1{
							margin: 8px 0 15px;
						}
						#ipays lable{
							display: block;
							margin: 5px;
						}
						#ipays lable span{
							display: inline-block;
							width:150px;
							text-align: right;
						}
						#ipays lable input{
							width:260px;
							height: 35px;
							line-height: 35px;
							border:1px solid #ccc;
							border-radius: 3px;
							padding: 0 5px;
						}
					</style>
					<?php 
						require_once($webRoot.$langPackageBasePath."fhtpaylp.php");
						$fhtpaylp = new fhtpay_lp;
					?>
					<div id="ipays">
						<h1><?php echo $fhtpaylp->card_support; ?></h1>
						<label>
							<span><?php echo $fhtpaylp->card_number; ?>：</span>
							<input type="text" name="card_number" placeholder="<?php echo $fhtpaylp->card_desc; ?>" value="">
						</label>
						<label>
							<span><?php echo $fhtpaylp->card_name; ?>：</span>
							<input type="text" name="name[]" placeholder="<?php echo $fhtpaylp->last_name; ?>" style="width:129px;" value="">
							<input type="text" name="name[]" placeholder="<?php echo $fhtpaylp->first_name; ?>" style="width:129px;" value="">
						</label>
						<label>
							<span><?php echo $fhtpaylp->Term_of_validity; ?>：</span>
							<select id="exp_year" name="exp_date[]" style="width:110px;"></select><?php echo $fhtpaylp->year; ?>
							<select id="exp_month" name="exp_date[]" style="width:110px;"></select><?php echo $fhtpaylp->month; ?>
						</label>
						<label>
							<span>cvv：</span>
							<input type="text" name="cvv" placeholder="<?php echo $fhtpaylp->cvv_desc; ?>" value="">
						</label>
						<label>
							<span><?php echo $fhtpaylp->card_email; ?>：</span>
							<input type="text" name="email" placeholder="<?php echo $fhtpaylp->email_desc; ?>" value="">
						</label>

					</div>
					<!-- 弹窗end -->



					<div class="gold_list">	
						<input type="submit" style="cursor:pointer" name="button" id="button" value="<?php echo $er_langpackage->er_gorecharge;?>" />
					</div>
		
			</li>
			</form>
		</ul>
	</div>
	<script>
		$(function(){

			var date = new Date(); // new 一个Date对象
		    var year = date.getFullYear(); // 年份
		    var month = date.getMonth() + 1; // 月份（从0开始，所以应+1）
		    for(var i = year; i<=year+10; i++) {
		        $("<option value='"+i+"'>" + i + "</option>").appendTo($("#exp_year")); 
		    }
		    for(var x = 1; x<=12; x++) {
		        if(x<=9){
		            $("<option value='0"+x+"'>" +"0"+ x + "</option>").appendTo($("#exp_month"));
		        }else{
		            $("<option value='"+x+"'>" + x + "</option>").appendTo($("#exp_month"));
		        }  
		    }
			if($("input[name='zhifu']:checked").val() == 5){
				$("#ipays").show();
				var height = calcPageHeight(document);
	        	parent.document.getElementById('ifr').style.height = height +50+ 'px'   ;
			}
			$("input[name='zhifu']").click(function(){
				if($(this).val() == 5){
					$("#ipays").show();
					var height = calcPageHeight(document);
	        		parent.document.getElementById('ifr').style.height = height +50+ 'px'   ;
				}else{
					$("#ipays").hide();
				}
			});
		});

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
