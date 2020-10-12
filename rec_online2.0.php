<?php
error_reporting(E_ALL);

header("content-type:text/html;charset=utf-8");
require ("foundation/asession.php");
require ("configuration.php");
require ("includes.php");
//必须登录才能浏览该页面
require ("foundation/auser_mustlogin.php");
require ("foundation/module_users.php");
require ("foundation/fplugin.php");
require ("api/base_support.php");
require ("foundation/fdnurl_aget.php");
require ("foundation/fgrade.php");
//语言包引入
$u_langpackage = new userslp;
$ef_langpackage = new event_frontlp;
$mn_langpackage = new menulp;
$pu_langpackage = new publiclp;
$mp_langpackage = new mypalslp;
$s_langpackage = new sharelp;
$hi_langpackage = new hilp;
$l_langpackage = new loginlp;
$rp_langpackage = new reportlp;
$ah_langpackage = new arrayhomelp;
$rm_langpackage = new readmorelp;
$rf_langpackage = new recaffairlp;
$dbo = new dbex; //连接数据库执行
dbtarget('r', $dbServs);
$user_id = get_sess_userid(); //删除之后客户机获取缓存中的id，
$sqlg = "select * from wy_users where user_id=$user_id";
$userinfo = $dbo->getRow($sqlg);
$sql = "select * from wy_users where user_id=$user_id"; //与服务器进行比较
$isNull = $dbo->getRow($sql);
$user_name = get_sess_username();
$user_info = api_proxy("user_self_by_uid", "guest_num,user_ico,integral,onlinetimecount,user_group", $user_id);
/*
if(empty($user_info)){
     echo "<script type='text/javascript'>alert('{$pu_langpackage->pu_lockdel}');location.href='do.php?act=logout';</script>";
}
*/
//男性  删除
if (empty($isNull)) {
    echo "<script type='text/javascript'>alert('I\'m Sorry,Your account is delete by Root.Please do not do hacked work.[你的账号被删除了！] You can send email to ky.service@yahoo.com ask for why.');location.href='do.php?act=logout';</script>";
    echo "<script>top.Dialog.alert('" . $l_langpackage->l_lock_u . "');</script>";
    echo "违反规定，删除账号";
    setcookie("IsReged", '');
    session_regenerate_id();
    session_destroy();
    echo '<script language=javascript>top.location="/";</script>';
}
/*
    $user_ico=end(explode('/',$user_info['user_ico']));
    if($user_ico=='d_ico_0_small.gif'||$user_ico=='d_ico_1_small.gif'){
        echo "<script type='text/javascript'>alert('请上传头像');window.open('modules.php?app=user_ico','user_ico','left=300,top=120');</script>";
        exit;
    }
*/
//照片数量
$sql = "select photo_num from wy_album where user_id=$user_id";
$p_num = $dbo->getRow($sql);
$photo_num = $p_num['photo_num'];
//金币邮票个数
$sqlg = "select golds,stamps_num from wy_users where user_id=$user_id";
$golds = $dbo->getRow($sqlg);
$golds_num = $golds['golds'];
$stamps_num = $golds['stamps_num'];
//获取用户自定义属性列表
//$information_rs=array();
//$information_rs=userInformationGetList($dbo,'*');
//好友速配推荐
//$friends_list=$dbo->getRs("select user_id,user_name,user_ico from wy_users order by rand() limit 0,12");
//获取推荐群组
$group_recommend_list = $dbo->getRs("select * from wy_groups where recommed_time is not null order by recommed_time desc limit 6");
//读取幻灯片
$sql = "select * from wy_hd where cat_id=4 order by ord desc , id desc limit 5";
$xhd_list = $dbo->getRs($sql);
//用户资料
$sql = "select user_sex,is_txrz from wy_users where user_id='$user_id' ";
$u_sex_txrz = $dbo->getRow($sql);





/*****************************获取在线用户***************************************/
    //变量取得 
    $user_id=get_sess_userid(); 
    $user_sex=get_sess_usersex();//$_SESSION[$session_prefix.'user_sex'];
    //echo $user_sex; 
    $ra_rs= array(); //数据库读操作 
    $dbo=new dbex; 
    dbtarget('r',$dbServs);


    



    //page start 
    $pagesize=12;//设置显示页码 
    $page_num =trim(get_argg('page'));
    //$page_total =count($dbo->getRs("select * from wy_online where user_id != '$user_id'")); 
    //女士全部上线，男士在线就算是在线
    if($user_sex == 1){//男士,女士全部上线
        $page_total =count($dbo->getRs("select * from wy_users where user_sex <> '$user_sex'"));
    }else{
        $page_total =count($dbo->getRs("select * from wy_online where user_id <> '$user_id'")); 
    }

    //gaoyuanadd判断tiaozhuan
    if($_GET["page"]>1){
    	//echo "<pre>";print_r($user_info);exit;
    	if($user_info["user_group"] == 1 || $user_info["user_group"] == "base"){
    		echo "<script>parent.location.href='/main2.0.php?app=user_upgrade';</script>";exit;
    		//header("location:/main2.0.php?app=user_upgrade");exit;
    	}
    }





     
    if($_GET['page']){
        $page=($page_num-1)*$pagesize; 
        if($page<0) $page=0;
    }else{ 
        $page=0; 
    } 
    if($page_num<=1){ 
        $page_num=1; 
    } 
    $pre=$page_num-1;
    $next=$page_num+1; 
    if($pre<0)$pre=0; 
    if($next>ceil($page_total/$pagesize)) 
    $next=ceil($page_total/$pagesize); 
    //if($page_total<=10) $next=1; 
    //var_dump($_SESSION); 
    //page end 



    $sqlg="select * from wy_users where user_id=$user_id"; 
    $userinfo=$dbo->getRow($sqlg);


    
    if($userinfo['user_sex'] == 1){ 
        //$sql = "select * from wy_users where user_id != '$user_id' and user_sex != '$user_sex' and is_pass!='0' order by lastlogin_datetime desc limit $page, $pagesize"; 
        $sql = "select * from wy_users as u left join wy_online as o on u.user_id=o.user_id where u.user_sex != '$user_sex' and u.is_pass!='0' order by u.is_service desc,o.active_time desc"; 
        //$sql = "select * from wy_users where user_sex != 1 and is_pass !=0";
    }else{ 
        //$sql="select * from wy_online where user_id != '$user_id' and user_sex != '$user_sex' order by active_time limit $page, $pagesize";
        $sql = "select * from wy_users as u left join wy_online as o on u.user_id=o.user_id where u.user_sex != '$user_sex' order by o.active_time desc"; 
    } 


    // 开始新版分页
    require("foundation/fpages_bar.php");
    $dbo->setPages($pagesize,$page_num);//设置分页
    $ra_rs=$dbo->getRs($sql);
    $page_total=$dbo->totalPage;//分页总数
    $isNull=0;
    if(empty($ra_rs)){
        $none_data="";
        $isNull=1;
    }
    //echo $page_total;exit;

    // 结束新版分页
    //echo $sql;exit; 
    $ra_rs=$dbo->getRs($sql);
    
    $ra_rs0519=array(); 
    foreach($ra_rs as $rss){ 
        //删除客服
        // if($rss["is_service"] == 1){
        //     unset($rss);
        //     continue;
        // }
        //$sql="select integral,user_ico,country,reside_province,reside_city,birth_year,birth_month,birth_day,user_group,is_txrz from wy_users where user_id = '$rss[user_id]' "; 
        $sql="select * from wy_users where user_id = '$rss[0]' "; 
        $arr=$dbo->getRow($sql); 

        $rs=array_merge($rss,$arr); 
        $sql="select mood,mood_pic from wy_mood where user_id='$rss[user_id]' order by mood_id desc limit 1 "; 
        $arrmood=$dbo->getRow($sql);
        //echo "<pre>";print_r($rs);exit;

        
        if($arrmood) $rs=array_merge($rs,$arrmood); 
        if(!$rs['user_ico']){ 
            $rs[10]=$rs['user_ico']='skin/default/jooyea/images/d_ico_'.$rs[4].'.gif';
        } if($rs[4]==0){
            $rs[4]=$rs['user_sex']=$rf_langpackage->rf_woman;
        }else{
            $rs[4]=$rs['user_sex']=$rf_langpackage->rf_man;
        }
        if($rs['user_group']==3){ 
            $rs['user_tt']='VIP'; 
        }else if($rs['user_group']==2){
            $rs['user_tt']='Senior Membe'; 
        }else{ 
            $rs['user_tt']=''; 
        } 
        if(empty($rs['mood'])){
            $rs['mood']=$rf_langpackage->rf_lan;
        }
        $ra_rs0519[]=$rs; 
    } 
    if(empty($ra_rs0519)){ 
        $p1=$_GET['page']-1; 
        $url="/rec_online2.0.php?page=$p1";
        //echo "<script>alert('抱歉，已经没有用户了!');window.location.href = '$url'</script>"; 
    }
    /* $sql ="select * from wy_online where 1"; 
    $arr_id = $dbo->getRs($sql);
    foreach($arr_id as $k=>$v) { 
        $str.=$v['user_id'].','; 
    } 
    $ex = substr($str,0,-1);
    $exp = explode(',',$ex);*/ 

    //取出客服
    //$kefu_info = $dbo->getRow("select * from wy_users where is_service='1'");
    //echo "<pre>";print_r($kefu_info);exit;
/*****************************获取在线用户 end***************************************/
?>

<!DOCTYPE html>
<html xmlns:ng="http://angularjs.org">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Content-Language" content="zh-cn">
        <title>
            <?php echo $user_name;?>的个人首页-<?php echo $siteName;?>
        </title>
        <base href='<?php echo $siteDomain;?>' />
        <?php $plugins=unserialize('a:0:{}');?>
        <link href="./skin/gaoyuan/css/online.css" rel="stylesheet" type="text/css">
    </head>
    <body class="lan_cn" style=" background:none;text-align:left">
        

        <!-- 在线用户 -->
        <div class="samle_tu">
            <div class="staff">
                <ul>


                    <!-- <li>
                        <a href="home2.0.php?h=<?php echo $kefu_info['user_id'];?>" target="_blank">
                            <img src="<?php echo $kefu_info['user_ico'];?>" alt="" width="178" height="178" />
                        </a>
                        <div class="mid">
                            <div class="mid_left">
                                <img src="./skin/gaoyuan/images/zx.png" />
                                <?php echo $kefu_info['user_name']; ?>
                            </div>
                            <div class="mid_right">
                                <?php if($kefu_info["user_group"] == 2){ ?>
                                <img src="/skin/default/jooyea/images/xin/gaoji.png" width="23" />
                                <?php }elseif($kefu_info["user_group"] == 3){ ?>
                                <img src="/skin/default/jooyea/images/xin/vip.gif" width="23" />
                                <?php }elseif($kefu_info["user_group"] == 4){ ?>
                                <img src="/skin/default/jooyea/images/xin/vip-yj.gif" width="23" />
                                <?php } ?>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="notes">
                            <p style="width:140px;white-space:nowrap; overflow:hidden;">
                                <?php echo $kefu_info["user_sex"]; ?> &nbsp; <?php echo date("Y")-$kefu_info[13]; ?> &nbsp;&nbsp;
                            </p>
                        </div>
                        <div class="way">
                            <i class="xin" id="collect" onclick="top.mypals_add('<?php echo $kefu_info['user_id'];?>');" title="Collect" name="83"></i>
                            <i class="email" onclick="<?php if(1){ ?> window.open ('modules.php?app=msg_creator&2id=<?php echo $kefu_info['user_id'];?>','新邮件','height=800,width=800,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');return false; <?php } else { ?> alert('<?php echo $u_langpackage->readmore; ?>');<?php } ?>" title="Email"></i>
                            
                            <i class="dope" onclick="parent.open_chat('<?php echo $kefu_info['user_id'];?>','<?php echo $kefu_info['user_name'];?>','<?php echo $kefu_info['user_ico'];?>');" title="Say hello">
                            </i>
                        </div>
                    </li> -->

                    <style>
                        .staff ul li a{display: block;}
                        .staff ul li a img{border-radius: 100%;}
                    </style>
                <?php foreach($ra_rs0519 as $key=> $hd){ //echo "<pre>";print_r($ra_rs0519);exit;?>
                    <li>
                        <a href="home2.0.php?h=<?php echo $hd[0];?>" target="_blank">
                            <img src="<?php echo $hd['user_ico'];?>" alt="" width="178" height="178" />
                        </a>
                        <div class="mid">
                            <div class="mid_left">
                                <?php if($hd[ 'online_id']){ ?>
                                <img src="./skin/gaoyuan/images/zx.png" />
                                <?php }else{ ?>
                                <img src="./skin/gaoyuan/images/zx.png" />
                                <?php } ?>
                                <?php echo $hd[2]; ?>
                            </div>
                            <div class="mid_right">
                                <?php if($hd["user_group"] == 2){ ?>
                                <img src="/skin/default/jooyea/images/xin/gaoji.png" width="23" />
                                <?php }elseif($hd["user_group"] == 3){ ?>
                                <img src="/skin/default/jooyea/images/xin/vip.gif" width="23" />
                                <?php }elseif($hd["user_group"] == 4){ ?>
								<img src="/skin/default/jooyea/images/xin/vip-yj.gif" width="23" />
                                <?php } ?>
                            </div>
                            <div class="clear">
                            </div>
                        </div>
                        <div class="notes">
                            <p style="width:140px;white-space:nowrap; overflow:hidden;">
                                <?php echo $hd["user_sex"]; ?> &nbsp; <?php echo date("Y")-$hd[13]; ?> &nbsp;&nbsp;
                            </p>
                        </div>
                        <div class="way">


                            <i class="xin" id="collect" onclick="top.mypals_add('<?php echo $hd[0];?>');" title="Collect" name="83">
                            </i>


                            <i class="email" onclick="<?php if(1){ ?> window.open ('modules.php?app=msg_creator&2id=<?php echo $hd[0];?>','新邮件','height=800,width=800,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');return false; <?php } else { ?> alert('<?php echo $u_langpackage->readmore; ?>');<?php } ?>"
                            title="Email">
                            </i>



                            <!-- <i class="dope" onclick="top.i_im_talkWin('<?php echo $hd[0];?>','imWin');" title="Say hello"> -->
                            <i class="dope" onclick="parent.open_chat('<?php echo $hd['user_id'];?>');" title="Say hello">
                            </i>
                        </div>
                    </li>
                <?php } ?>
                

                </ul>
            </div>
            <link rel="stylesheet" href="/skin/default/jooyea/css/iframe.css">
            <style>
            .pages_bar{margin-left: 12px;}
            </style>
            <?php echo page_show($isNull,$page_num,$page_total);?>

        </div>
        <!--在线用户-->                                   



        <script src="./template/main/jquery-1.7.min.js"></script>
        <script>
            jQuery(function() {
                var $ = jQuery;
                //底部图标点击变色
                $(".piclib-icon").delegate('li', 'click',
                function() {
                    $(this).addClass("active").siblings('.active').removeClass("active");
                    alert('xxx');
                });
                var index = 1;
                var moveBox = $(".overview");

                //左按钮
                $(".picbtn-1").click(function() {

                    if (index == 1) {
                        window.location.href = 'rec_online2.0.php?page=<?php echo $_GET["page"] ?$_GET["page"]-1:1; ?>';
                        return;
                    }
                    index--;
                    rollingRight();
                    if (index == 1) {
                        $(".picbtn-1").addClass("disable");
                        window.location.href = 'rec_online2.0.php?page=<?php echo $_GET["page"] ?$_GET["page"]-1:1; ?>';
                    } else {
                        $(".picbtn-1").removeClass("disable");
                    }

                });
                var golds = <?php echo $userinfo['golds']; ?>;
                var user_group = <?php echo intval($userinfo['user_group']); ?>;

                //右按钮
                $(".picbtn-2").click(function() {
                    if (user_group < 2) {
                        if (!golds) {
                            window.parent.location.href = 'main2.0.php?app=user_pay';
                            return false;
                        }
                    }
                    if (index == 3) {
                        window.location.href = 'rec_online2.0.php?page=<?php echo $_GET["page"] ?$_GET["page"]+1:1+1; ?>';
                        return;
                    }
                    index++;
                    rollingLeft();
                    if (index != 1) {
                        $(".picbtn-1").removeClass("disable");
                    }
                });

                //向右
                function rollingLeft() {
                    moveBox.animate({
                        left: "-=738px"
                    },
                    900);
                }
                //向左
                function rollingRight() {
                    moveBox.animate({
                        left: "+=738px"
                    },
                    900);
                }
            });




            $(function() {
                //**********右侧指定div fixed&&topbar右侧下拉列表
                var jqNav = $('#nav_lq');
                $('.expand_a1_lq,#expand_nav_lq', jqNav).bind('mouseenter mouseleave',toggleNav);
                //展开选项
                function toggleNav(e) {
                    if (e.type == 'mouseenter') {
                        $('#nav_lq .expand_a1_lq').addClass('active');
                        $('#expand_nav_lq').removeClass('hidden1_lq');
                    } else {
                        $('#nav_lq .expand_a1_lq').removeClass('active');
                        $('#expand_nav_lq').addClass('hidden1_lq');
                    }
                }


                $("#msgbox").bind("click",function(e){
                    var obj = $(this).closest("#msgbox");
                    // $(this).addClass("msgboxhover").find("div.downlist").show(); 
                    obj.find("div.downlist").show();
                    var e = e || window.event;
                    e.stopPropagation();
                    $('body').on("click",
                    function(e) {
                        var e = e || window.event;
                        $("div.downlist").hide();
                        e.stopPropagation();
                    });
                });


                $('#msglist').on("mouseleave",
                function(e) {
                    var e = e || window.event;
                    $("div.downlist").hide();
                    e.stopPropagation();
                });

                /*********/
                //最大字符量限制
                function isMaxLen(o) {
                    var nMaxLen = 300;
                    if (o.getAttribute && o.value.length > nMaxLen) {
                        o.value = o.value.substring(0, nMaxLen)
                    }
                    var less_len = document.getElementById('less_txt');
                    $(".js_char_count1_lq").html(300 - o.value.length);
                    //less_len.innerHTML=300-o.value.length;

                }

                /******************/

                //************返回顶部
                $(window).bind('scroll',function() {
                    var w_scrollTop = $(window).scrollTop();
                    if (w_scrollTop > 150) {
                        $("#gotop").fadeIn(600);
                    } else if (w_scrollTop < 200) {
                        $("#gotop").fadeOut(600);
                    }
                });
                $("#gotop").click(function() {
                    $("html,body").animate({
                        scrollTop: 0
                    },400);
                    return false;
                });

                /*****心情**********/
                $('.mood_text1_lq').focus(function() {
                    if ($(this).val() == $(this).attr('title')) $(this).val('');
                }).blur(function() {
                    if (!$(this).val()) $(this).val($(this).attr('title'));
                }).bind("keyup",function(e) {
                    return isMaxLen(this);
                });

                /*****心情**********/



                /*聊天面板下拉*/
                $(".chat-tree-parent").toggle(function() {
                    $(this).removeClass('hide');
                    $(this).siblings().removeClass('none');
                },function() {
                    $(this).addClass('hide');
                    $(this).siblings().addClass('none');
                });
                /*****聊天面板下拉*************8/
    
                /*****语言选择菜单******************/
                $(".js_select_top").on('click', 'label',function(e) {
                    $("#face_jqface").hide();
                    $(this).closest(".js_select_top").find("ul,.triggle-top").toggle();
                    $("#face_jqface").addClass("hidden1_lq");
                    e.stopPropagation();
                });

                //模拟select--正常
                $(".js_select_top ul").on('click', 'li',function(e) {
                    var selected = $(this).text();
                    var value = $(this).attr("langs-lang");
                    $(this).closest(".js_select_top").find("span").text(selected).attr("data-lang", value);
                    $("#LetterLang").val($(this).attr("langs-lang")); //私信选择翻译语言
                    if ($("#LetterLang").val() != "no") { //私信是否翻译
                        $("#IsTrans").val("yes");
                    } else if ($("#LetterLang").val() == "no") {
                        $("#IsTrans").val("no");
                    }
                    $(".js_select_top ul,.triggle-top").hide();
                    // e.preventDefault(); 
                });


                $(".faces_icon1_lq").on("click",function() {
                    $(".js_select_top ul").hide();

                });
                /*****语言选择菜单****************/


                $(document).on("click",function() {
                    $('.js_select_top ul,.triggle-top').hide();
                    $("#face_jqface").hide();
                });

                $(".mood-face").on("click",function(e) {
                    $("#face_jqface").toggle();
                    e.stopPropagation();
                    return fasle;
                });

                $(".close_jqface").on("click",function() {
                    $("#face_jqface").hide();
                });
            });
            function mypals_add_callback(content, other_id) {
                if (content == "success") {
                    parent.Dialog.alert("<?php echo $mp_langpackage->mp_suc_add;?>");
                    //document.getElementById("operate_" + other_id).innerHTML = "<?php echo $mp_langpackage->mp_suc_add;?>";
                } else {
                    parent.Dialog.alert(content);
                    //document.getElementById("operate_" + other_id).innerHTML = content;
                }
            }
            /***********添加好友***************/
            function mypals_add(other_id) {
                $.get("do.php", {
                    act: 'add_mypals',
                    other_id: '' + other_id
                },
                function(c) {
                    mypals_add_callback(c, other_id);
                });
            }
            /***********添加好友*********************/
        </script>
    </body>

</html>