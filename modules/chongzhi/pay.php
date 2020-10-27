<?php
//引入公共模块
require("foundation/module_event.php");
require("api/base_support.php");
//引入语言包
$er_langpackage = new rechargelp;
$dopost = "savesend";
//必须登录才能浏览该页面
require("foundation/auser_mustlogin.php");
$user_id = get_sess_userid();
$uname = get_args('uname');
//echo $user_id;
//限制时间段访问站点
limit_time($limit_action_time);
$friends = Api_Proxy("pals_self_by_paid", "pals_name,pals_id,pals_ico");
$userinfo = Api_Proxy("user_self_by_uid", "*", $user_id);
$info = "<font color='#ce1221' style='font-weight:bold;'>" . $er_langpackage->er_currency . "</font>：" . $userinfo['golds'];
if ($userinfo['user_group'] > 1) {
	$groups = $dbo->getRow("select endtime from wy_upgrade_log where mid='$user_id' and state='0' order by id desc limit 1");
	//print_r($groups);
	$startdate = strtotime(date("Y-m-d"));
	$enddate = strtotime($groups['endtime']);
	$days = round(($enddate - $startdate) / 3600 / 24);
	if ($days > 0) {
		$info .= "&nbsp;&nbsp;&nbsp;&nbsp;" . $er_langpackage->er_howtime . "：" . $days . $er_langpackage->er_day;
	} else {
		$sql = "update wy_upgrade_log set state='1' where mid='$user_id'";
		$dbo->exeUpdate($sql);
		$sql = "update wy_users set  user_group='1'   where  user_id='$user_id'";
		$dbo->exeUpdate($sql);
	}
	$groups = $dbo->getRow("select name from wy_frontgroup where gid='{$userinfo['user_group']}'");
	if ($langPackagePara != 'zh') {
		$groups['name'] = str_replace('普通会员', 'normal', $groups['name']);
		$groups['name'] = str_replace('白金会员', $er_langpackage->er_gj, $groups['name']);
		$groups['name'] = str_replace('钻石会员', $er_langpackage->er_vip, $groups['name']);
	}
	if ($days > 0) {
		$userinfo = Api_Proxy("user_self_by_uid", "*", $user_id);
		$info .= "&nbsp;&nbsp;&nbsp;&nbsp;" . $er_langpackage->er_nowtype . "：" . $groups['name'];
	}
}
$sumoney = 0;
switch ($userinfo['user_group']) {
	/*case 1:
		$sumoney=200*95/100;
		break;*/
	case 2:
		$sumoney = 200;
		break;
	case 3:
		$sumoney = 200;
		break;
	default:
		$sumoney = 200;
}
$uid = get_argg('user_id');
if ($uid) {
	$u = $dbo->getRow("select user_name from wy_users where user_id={$uid}");
}
?>


<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl; ?>/css/iframe.css"/>
<script src="skin/default/js/jooyea.js"></script>
<SCRIPT src="servtools/ajax_client/ajax.js"></SCRIPT>
<script src="servtools/dialog/zDrag.js"></script>
<script src="servtools/dialog/zDialog.js"></script>
<script src="skin/default/jooyea/jquery-1.9.1.min.js"></script>
<script>
    function getdollar(_this,type) {
        if(type=='radio'){
            document.getElementById("dollar").innerHTML = (_this.value);
            document.getElementById("custom_gold").value = (_this.value);
        }else if(type=='text'){
            document.getElementById("dollar").innerHTML = (document.getElementById("custom_gold").value);
        }
    }
    function checkForm(){return true;}
</script>
<body>


<div class="tabs">
    <ul class="menu">
        <li class="active"><a href="modules2.0.php?app=user_pay"><?php echo $er_langpackage->er_recharge; ?></a></li>
        <li><a href="modules2.0.php?app=user_upgrade"><?php echo $er_langpackage->er_upgrade; ?></a></li>
        <li><a href="modules2.0.php?app=user_consumption" ><?php echo $er_langpackage->er_consumption_log; ?></a></li>
        <!--        <li><a href="modules2.0.php?app=user_introduce">--><?php //echo $er_langpackage->er_introduce; ?><!--</a></li>-->
        <!--<li><a href="modules2.0.php?app=user_help"><?php echo $er_langpackage->er_help; ?></a></li>-->
    </ul>
</div>
<div class="tabs" style="border:1px solid #ce1221;text-align:left;background:#F5F5B9;padding-left:15px;line-height:45px;margin-top:20px;">
    <?php echo $info; ?>
</div>
<div class="feedcontainer">
    <ul id="sec_Content">
        <form id="pay" name="pay" method="post" action="do.php?act=pay" target="_blank">
            <li style="height:auto;padding: 19px 25px;"><?php echo $er_langpackage->er_tshi; ?></li>
            <li style="height:auto;padding: 19px 25px;border-bottom:0px;">
                <div class="pay_content">
                    <label>
                        <input type="radio" name="touser" value="self" checked="checked" onclick="$('#friends_text').css('display','none');"/>:
                        <?php echo $er_langpackage->er_oneself; ?>
                    </label>
                    <label>
                        <input type="radio" name="touser" value="friend" onclick="$('#friends_text').css('display','')"/>:
						<?php echo $er_langpackage->er_friends; ?>
                        <span id="friends_text" style="display:none;">
                            <select name="friend_username" id="friend_username">
                                <option value=""><?php echo $er_langpackage->er_choose_fr; ?></option>
                                <?php foreach ($friends as $friend) { ?>
                                <option value="<?php echo $friend['pals_name']; ?>"><?php echo $friend['pals_name']; ?></option>
                                <?php } ?>
                            </select>
                        </span>
                    </label>
                </div>
                <div style="font-weight:700;font-size:14px;line-height:40px;text-align:left">
					<?php echo $er_langpackage->er_chongzhijine; ?>
                </div>
                <div class="gold_list">
                    <label>
                        <input name="gold" type="radio" value="30" onclick="getdollar(this,'radio')"/>
                        <img src="/template/main/ico/gold-icon.png" style="width:40px;margin:0;" />
						<?php echo $er_langpackage->er_20jinbi; ?>
                    </label>
                </div>
                <div class="gold_list">
                    <label>
                        <input name="gold" type="radio" value="50" onclick="getdollar(this,'radio')"/>
                        <img src="/template/main/ico/gold-icon.png" style="width:40px;margin:0;" />
						<?php echo $er_langpackage->er_50jinbi; ?>
                    </label>
                </div>
                <div class="gold_list">
                    <label>
                        <input name="gold" type="radio" value="100" onclick="getdollar(this,'radio')"/>
                        <img src="/template/main/ico/gold-icon.png" style="width:40px;margin:0;" />
						<?php echo $er_langpackage->er_100jinbi; ?>
                    </label>
                </div>
                <div class="gold_list">
                    <label>
                        <input name="gold" type="radio" value="200" onclick="getdollar(this,'radio')" checked="checked"/>
                        <img src="/template/main/ico/gold-icon.png" style="width:40px;margin:0;" />
						<?php echo $er_langpackage->er_200jinbi; ?>
                    </label>
                </div>
                <div class="gold_list">
                    <label>
                        <input name="gold" type="radio" value="500" onclick="getdollar(this,'radio')"/>
                        <img src="/template/main/ico/gold-icon.png" style="width:40px;margin:0;" />
						<?php echo $er_langpackage->er_500jinbi; ?>
                    </label>
                </div>
                <div class="gold_list">
                    <label>
                        <input name="gold" type="radio" value="1000" onclick="getdollar(this,'radio')"/>
                        <img src="/template/main/ico/gold-icon.png" style="width:40px;margin:0;" />
						<?php echo $er_langpackage->er_1000jinbi; ?>
                    </label>
                </div>
                <div class="gold_list">
                    <label>
						<?php echo $er_langpackage->er_zidingyi; ?>
                        <input type="text" name="custom_gold" id="custom_gold" value="200" style="width:80px;height:25px;"
                               onkeyup="value=value.replace(/[^\d]/g,'');getdollar(this,'text');"
                               onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"
                               onkeydown="getdollar(this,'text')"/>
                    </label>
                    <span style="font-weight:bold;">
						<?php echo $er_langpackage->er_currency; ?>&nbsp;&nbsp;
						<?php echo $er_langpackage->er_need; ?>
                        (<span style="color:red;" id="dollar"><?php echo $sumoney; ?>USD</span>)
                    <?php echo $er_langpackage->er_dollars; ?>
                    </span>
                </div>
                <div class="gold_list" style="margin-top:20px;">
                    <label><input name="pay_type" type="radio" value="lianyin" checked="checked"/><img
                                src="/skin/<?php echo $skinUrl; ?>/images/vml.png"
                                style="width:220px;vertical-align:middle;"/>&nbsp;&nbsp;</label>
                    <!--<label><input name="pay_type" type="radio" value="yingfu"/><img-->
                    <!--            src="/skin/<?php echo $skinUrl; ?>/images/fuHui.png"-->
                    <!--            style="width:220px;vertical-align:middle;"/>&nbsp;&nbsp;</label>-->
                </div>

                <div class="gold_list">
                    <input type="submit" style="cursor:pointer" name="button" id="button"
                           value="<?php echo $er_langpackage->er_gorecharge; ?>"/>
                </div>
            </li>
        </form>
    </ul>

    <script>
        $(function () {
            var date = new Date(); // new 一个Date对象
            var year = date.getFullYear(); // 年份
            var month = date.getMonth() + 1; // 月份（从0开始，所以应+1）
            for (var i = year; i <= year + 10; i++) {
                $("<option value='" + i + "'>" + i + "</option>").appendTo($("#exp_year"));
            }
            for (var x = 1; x <= 12; x++) {
                var month_tmp = 1;
                if (x <= 9) {
                    month_tmp = "0" + x;
                } else {
                    month_tmp = x;
                }
                if (month == month_tmp) {
                    $("<option value='" + month_tmp + "' selected>" + month_tmp + "</option>").appendTo($("#exp_month"));
                } else {
                    $("<option value='" + month_tmp + "'>" + month_tmp + "</option>").appendTo($("#exp_month"));
                }
            }

            //银行卡四位显示
            $("#card_number").keyup(function a(e) {
                var obj = e;
                if (obj.keyCode != 8) {                                           //判断是否为Backspace键，若不是执行函数；
                    var b = $("#card_number").val();       //定义变量input  value值；
                    var maxValue = 16;                                        //限制输入框的最大值；
                    b = b.replace(/[^\d\s]/g, "");                               //正则表达式：如果输入框中输入的不是数字或者空格，将不会显示；
                    if (b.length > maxValue) return false;
                    $("#card_number").val(b);           //把新得到得value值赋值给输入框；
                    for (n = 1; n <= 4; n++) {
                        if (b.length <= 5 * n - 2 || b.length > 5 * n - 1) {                       //判断是否是该加空格的时候，若不会，还是原来的值；
                            b = b;
                        } else {
                            b = b + " ";                                                 //给value添加一个空格；
                            $("#card_number").val(b);           //赋值给输入框新的value值；
                        }
                    }
                }
            });
        });

        // 计算页面的实际高度，iframe自适应会用到
        function calcPageHeight(doc) {
            var cHeight = Math.max(doc.body.clientHeight, doc.documentElement.clientHeight)
            var sHeight = Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight)
            var height = Math.max(cHeight, sHeight)
            return height
        }

        window.onload = function () {
            var height = calcPageHeight(document);
            parent.document.getElementById('ifr').style.height = height + 50 + 'px';
        }

    </script>

</div>
</body>
