<?php

/*

 * 注意：此文件由tpl_engine编译型模板引擎编译生成。

 * 如果您的模板要进行修改，请修改 templates/default/uiparts/mainright.html

 * 如果您的模型要进行修改，请修改 models/uiparts/mainright.php

 *

 * 修改完成之后需要您进入后台重新编译，才会重新生成。

 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。

 * 如果您正式运行此程序时，请切换到service模式运行！

 *

 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。

 */

?><?php

/*

 * 此段代码由debug模式下生成运行，请勿改动！

 * 如果debug模式下出错不能再次自动编译时，请进入后台手动编译！

 */

/* debug模式运行生成代码 开始 */

if(!function_exists("tpl_engine")) {

	require("foundation/ftpl_compile.php");

}

if(filemtime("templates/default/uiparts/mainright.html") > filemtime(__file__) || (file_exists("models/uiparts/mainright.php") && filemtime("models/uiparts/mainright.php") > filemtime(__file__)) ) {

	tpl_engine("default","uiparts/mainright.html",1);

	include(__file__);

}else {

/* debug模式运行生成代码 结束 */

?><?php

	require("api/base_support.php");

	//require("foundation/module_users.php");

    $ah_langpackage=new arrayhomelp;

    $gu_langpackage=new guestlp;

    $pu_langpackage=new publiclp;

    $a_langpackage=new albumlp;

    dbtarget('r',$dbServs);

	$dbo=new dbex;

	//获取用户自定义属性列表

	$url_uid= intval(get_argg('user_id'));

	$ses_uid=get_sess_userid();

	$guest_user_name=get_sess_username();

	$guest_user_ico=get_sess_userico();

	$mypals=get_sess_mypals();

    //引入模块公共权限过程文件

	$is_login_mode='';

	$is_self_mode='partLimit';

	



	//数据表定义区

	$t_guest = $tablePreStr."guest";

	$t_users = $tablePreStr."users";



	

    

	

	//加为好友 打招呼

	$add_friend="mypalsAddInit";

	$send_hi="hi_action";

	if(!$ses_uid){

	  	$add_friend='goLogin';

	  	$send_hi='goLogin';

	}

	

	//读写分离定义方法

	$guest_rs = api_proxy("guest_self_by_uid","*",$userid,6); 







	$sql3="select id,user_id,pals_id,pals_sort_id,pals_sort_name,pals_name,pals_sex,add_time,pals_ico,accepted,active_time from wy_pals_mine where user_id=$user_id and accepted > 0 limit 0,9";

	$mp_list_rs=$dbo->getRs($sql3);



    $sql4="select user_id,user_name,user_add_time,user_sex,user_ico from wy_users where  is_recommend=1  order by user_add_time desc limit 0,4";

	$recommend_rs=$dbo->getRs($sql4);







    

?><SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>

<script type='text/javascript'>

function mypals_add_callback(content,other_id){

	if(content=="success"){

		parent.Dialog.alert("<?php echo $mp_langpackage->mp_suc_add;?>");

		document.getElementById("operate_"+other_id).innerHTML="<?php echo $mp_langpackage->mp_suc_add;?>";

	}else{

		parent.Dialog.alert(content);

		document.getElementById("operate_"+other_id).innerHTML=content;

	}

}



function mypals_add(other_id){

	var mypals_add=new Ajax();

	mypals_add.getInfo("do.php","get","app","act=add_mypals&other_id="+other_id,function(c){mypals_add_callback(c,other_id);}); 

}



function mypalsAddInit(other_id)

{

	  var mypals_add=new Ajax();

	  mypals_add.getInfo("do.php","GET","app","act=add_mypals&other_id="+other_id,function(c){if(c=="success"){Dialog.alert("<?php echo $ah_langpackage->ah_friends_add_suc;?>");}else{Dialog.alert(c);}});

}

function hi_action_int(){

	<?php echo $send_hi;?>;

}



function report_action_int(){

	<?php echo $send_report;?>

}



function report_action(type_id,user_id,mod_id){

	var diag = new Dialog();

	diag.Width = 300;

	diag.Height = 150;

	diag.Top="50%";

	diag.Left="50%";

	diag.Title = "<?php echo $pu_langpackage->pu_report;?>";

	diag.InnerHtml= '<div class="report_notice"><?php echo $pu_langpackage->pu_report_info;?><?php echo $pu_langpackage->pu_report_re;?><textarea id="reason"></textarea></div>';

	diag.OKEvent = function(){act_report(type_id, user_id, mod_id);diag.close();};

	diag.show();

}



function hi_action(uid){

	var diag = new Dialog();

	diag.Width = 330;

	diag.Height = 150;

	diag.Top="50%";

	diag.Left="50%";

	diag.Title = "<?php echo $u_langpackage->u_choose_type;?>";

	diag.InnerHtml= '<?php echo hi_window();?>';

	diag.OKEvent = function(){send_hi(uid);diag.close();};

	diag.show();

}



function send_hi_callback(content){

	if(content=="success"){

		Dialog.alert("<?php echo $hi_langpackage->hi_success;?>");

	}else{

		Dialog.alert(content);

	}

}



function send_hi(uid){

	var hi_type=document.getElementsByName("hi_type");

	for(def=0;def<hi_type.length;def++){

		if(hi_type[def].checked==true){

			var hi_t=hi_type[def].value;

		}

	}

	var get_album=new Ajax();

	get_album.getInfo("do.php","get","app","act=user_add_hi&to_userid="+uid+"&hi_t="+hi_t,function(c){send_hi_callback(c);});

}





</script>

    

    <!--本周达人开始-->

	<div class="dlindri">

	<div class="dlindritop"><?php echo $pu_langpackage->pu_talent;?></div>

	<div class="dlindri1">

	<ul>

        <?php foreach($recommend_rs as $rs){?>

        <li><table width="190" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td width="70" align="center" valign="top"><a href="home2.0.php?h=<?php echo $rs['user_id'];?>"><img src=<?php echo $rs['user_ico'];?> width="51" height="50" border="0" /></a></td>

            <td width="120" align="left" valign="top">

            <div class="dlindri1p"><a href="home2.0.php?h=<?php echo $rs['user_id'];?>"><?php echo $rs['user_name'];?></a></div>

            <div class="dlindri1p"><?php echo $rs['user_add_time'];?></div>

            <div class="dlindri1p"><img tyle="cursor:pointer;" onclick="<?php echo $send_hi;?>(<?php echo $val["guest_user_id"];?>)"  alt="发送消息" src="skin/<?php echo $skinUrl;?>/images/ico_dr_msg.jpg" border="0" /></a>

            <?php if(!strpos(",,$mypals,",','.$val['guest_user_id'].',')){?>

            <span><img alt="加为好友" src="skin/<?php echo $skinUrl;?>/images/ico_dr_jhy.jpg" border="0" style="cursor:pointer;" onclick="javascript:mypalsAddInit(<?php echo $rs['user_id'];?>)" /></span>

            <?php }?>

            </div>

            </td>

          </tr>

        </table>

        </li>

        <?php }?>



	</ul>

	</div>

	</div>

	<!--本周达人结束-->

	<!--我的朋友开始-->

	<div class="dlindri" style="background:#e5e4ea;">

	<div class="dlindritop"><a style="margin-left:2px;" href="main.php?app=mypals"><?php echo $a_langpackage->a_fri;?></a></div>

<div class="wdhy">

<ul id="friend_list">

<?php foreach($mp_list_rs as $rs){?>

<li><a href="home2.0.php?h=<?php echo $rs['pals_id'];?>"><img src=<?php echo $rs['pals_ico'];?> /><p><?php echo $rs['pals_name'];?></p></a></li>

<?php }?>

</ul>

</div><div class="clear"></div>

	</div>

	<!--我的朋友结束-->

	<!--广告位开始-->

	

<script type="text/javascript" src="skin/default/js/jquery.min.js"></script>

<script type="text/javascript" src="skin/default/js/master.js"></script>

<script type="text/javascript">

$(function() {

	var sWidth = $("#test23").width(); //获取焦点图的宽度（显示面积）

   

	var len = $("#test23 ul li").length; //获取焦点图个数

	var index = 0;

	var picTimer;

	

	//以下代码添加数字按钮和按钮后的半透明长条

	var btn = "<div class='btnBg'></div><div class='btn'>";

	for(var i=0; i < len; i++) {

		btn += "<span>" + (i+1) + "</span>";

	}

	btn += "</div>"

	$("#test23").append(btn);

	$("#test23 .btnBg").css("opacity",0.5);

	

	//为数字按钮添加鼠标滑入事件，以显示相应的内容

	$("#test23 .btn span").mouseenter(function() {

		index = $("#test23 .btn span").index(this);

		showPics(index);

	}).eq(0).trigger("mouseenter");

	

	//本例为左右滚动，即所有li元素都是在同一排向左浮动，所以这里需要计算出外围ul元素的宽度

	$("#test23 ul").css("width",sWidth * (len + 1));

	

	//鼠标滑入某li中的某div里，调整其同辈div元素的透明度，由于li的背景为黑色，所以会有变暗的效果

	$("#test23 ul li div").hover(function() {

		$(this).siblings().css("opacity",0.7);

	},function() {

		$("#test23 ul li div").css("opacity",1);

	});

	

	//鼠标滑上焦点图时停止自动播放，滑出时开始自动播放

	$("#test23").hover(function() {

		clearInterval(picTimer);

	},function() {

		picTimer = setInterval(function() {

			if(index == len) { //如果索引值等于li元素个数，说明最后一张图播放完毕，接下来要显示第一张图，即调用showFirPic()，然后将索引值清零

				showFirPic();

				index = 0;

			} else { //如果索引值不等于li元素个数，按普通状态切换，调用showPics()

				showPics(index);

			}

			index++;

		},3000); //此3000代表自动播放的间隔，单位：毫秒

	}).trigger("mouseleave");

	

	//显示图片函数，根据接收的index值显示相应的内容

	function showPics(index) { //普通切换

		var nowLeft = -index*sWidth; //根据index值计算ul元素的left值

		$("#test23 ul").stop(true,false).animate({"left":nowLeft},500); //通过animate()调整ul元素滚动到计算出的position

		$("#test23 .btn span").removeClass("on").eq(index).addClass("on"); //为当前的按钮切换到选中的效果

	}

	

	function showFirPic() { //最后一张图自动切换到第一张图时专用

		$("#test23 ul").append($("#test23 ul li:first").clone());

		var nowLeft = -len*sWidth; //通过li元素个数计算ul元素的left值，也就是最后一个li元素的右边

		$("#test23 ul").stop(true,false).animate({"left":nowLeft},500,function() {

			//通过callback，在动画结束后把ul元素重新定位到起点，然后删除最后一个复制过去的元素

			$("#test23 ul").css("left","0");

			$("#test23 ul li:last").remove();

		}); 

		$("#test23 .btn span").removeClass("on").eq(0).addClass("on"); //为第一个按钮添加选中的效果

	}

});



</script>



	<div class="jy_ad1" id="test23">

		<ul>

		  <li>

		    <div style="left:0; top:0;width:205px;height:135px; "><a href="#" target="_blank"><img src="skin/<?php echo $skinUrl;?>/images/test23.jpg" alt="" /></a></div>

	      </li>

		  <li><div style="left:0; top:0;width:205px;height:135px; "><a href="#" target="_blank"><img src="skin/<?php echo $skinUrl;?>/images/huiyuanjieshao.jpg" alt="" /></a></div></li>

<li><div style="left:0; top:0;width:205px;height:135px;"><a href="#" target="_blank"><img src="skin/<?php echo $skinUrl;?>/images/huiyuantiyan.jpg" alt="" /></a></div></li>

<li><div style="left:0; top:0;width:205px;height:135px;"><a href="#" target="_blank"><img src="skin/<?php echo $skinUrl;?>/images/youpiaoguize.jpg" alt="" /></a></div></li>

		</ul>

    </div>

	<!--广告位结束-->

	<!--浏览记录开始-->

	<div class="dlindri">

	<div class="dlindritop2"><span><a  onclick="location='/main.php?app=guest_more&user_id=<?php echo get_sess_userid();?>';return false;" hidefocus="true" href="javascript:void(0);"><?php echo $ah_langpackage->ah_more;?></a></span><a href=""><b><?php echo $pu_langpackage->pu_visitor;?></b></a></div>

	<div class="wdhy">

<ul id="current_guest"></ul>

</div><div class="clear"></div>

	</div>

<script type="text/javascript">

var current_guest=document.getElementById("current_guest");

//var friend_list=document.getElementById("friend_list");

function set_cur_guest(){

	var ajax_guest=new Ajax();

	ajax_guest.getInfo("modules.php","GET","app","app=guest2&user_id=<?php echo $user_id;?>",function(c){current_guest.innerHTML=trim(c);});

}



set_cur_guest();

</script>



	<!--浏览记录结束--><?php } ?>