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
$search_uname = get_argg("user_name");

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



//判断chat_users有没有信息
$chat_users_info = $dbo->getRow("select * from chat_users where uid='{$user_id}'");
if(empty($chat_users_info)){
    if(empty($user_ico)){
        $user_ico = "skin/default/jooyea/images/d_ico_".$user_sex."_small.gif";
    }
    //插入数据
    $time = time();
    $sql = "INSERT INTO `chat_users` (`uid`,`u_name`,`u_ico`,`last_time`,`contacted`) VALUES ('{$user_id}','{$user_name}','{$user_ico}','{$time}','1')";
    //echo "<pre>";print_r($sql);exit;
    $dbo->exeUpdate($sql);
}
//插入默认客服
$kefu = $dbo->getRow("select * from wy_users where is_service=1","arr");
$pals_mine_info = $dbo->getRow("select * from wy_pals_mine where user_id='{$user_id}' and pals_id='{$kefu['user_id']}'");
if(empty($pals_mine_info)){
    $date = date("Y-m-d H:i;s");
    $sql="insert into wy_pals_mine (user_id,pals_id,pals_name,pals_sex,pals_ico,is_service,add_time,active_time) values('{$user_id}','{$kefu['user_id']}','{$kefu['user_name']}','{$kefu['user_sex']}','{$kefu['user_ico']}','1','{$date}','{$date}')";
    //echo "<pre>";print_r($sql);exit;
    $dbo->exeUpdate($sql);
}




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
//读取幻灯片
$sql = "select * from wy_hd where cat_id=4 order by ord desc , id desc limit 5";
$xhd_list = $dbo->getRs($sql);






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
    	if($user_info["user_group"] == 1 ){
    		echo "<script>parent.location.href='/main2.0.php?app=user_upgrade';</script>";exit;
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


    $userinfo=$dbo->getRow("select * from wy_users where user_id={$user_id}");


    
    if($userinfo['user_sex'] == 1){
        $sql = "select * from wy_users as u left join wy_online as o on u.user_id=o.user_id where  ";
        if(!empty($search_uname)){
            $sql .=" (u.user_sex != '{$user_sex}' and u.is_pass!='0' and u.user_name like '%{$search_uname}%') ";
        }else{
            $sql .=" (u.user_sex != '{$user_sex}' and u.is_pass!='0') or u.is_service=1 ";
        }
        $sql .= " order by u.is_service desc, rand() ";
    }else{
        $sql = "select * from wy_users as u left join wy_online as o on u.user_id=o.user_id where u.user_sex != '{$user_sex}' ";
        if(!empty($search_uname)){
            $sql .=" and u.user_name like '%{$search_uname}%' ";
        }
        $sql .= " order by u.is_service desc,o.active_time desc ";
    }

//print_r($sql);


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
    // 结束新版分页
//print_r($ra_rs);
    
    $ra_rs0519=array(); 
    foreach($ra_rs as $k=>$rss){
        $sql="select * from wy_users where user_id = '$rss[0]' ";
        $arr=$dbo->getRow($sql);

        $rs=array_merge($rss,$arr);
        $sql="select mood,mood_pic from wy_mood where user_id='$rss[user_id]' order by mood_id desc limit 1 ";
        $arrmood=$dbo->getRow($sql);
        //echo "<pre>";print_r($rs);exit;


        if($arrmood) $rs=array_merge($rs,$arrmood);
        if(empty($rs['user_ico'])){
            $rs['user_ico']='skin/default/jooyea/images/d_ico_'.$rs['user_sex'].'.gif';
        } if($rs['user_sex']==0){
            $rs['user_sex']=$rf_langpackage->rf_woman;
        }else{
            $rs['user_sex']=$rf_langpackage->rf_man;
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
    /*
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
        <title></title>
        <link href="./skin/gaoyuan/css/online.css" rel="stylesheet" type="text/css">
        <script src="./template/main/jquery-1.7.min.js"></script>
    </head>
    <body class="lan_cn" style=" background:none;text-align:left">
    <style>
        .search_box{display: flex;justify-content: center;align-items: center;border: 1px solid #ccc; width:222px;margin: 25px auto 0;}
        .search_box  input{border-radius: 3px;padding: 5px 10px;border:0;}
        .search_box .search_icon{}
        .search_box  img{width:32px;border-left: 1px solid #ccc;
            cursor: pointer;}
    </style>
    <script>
        function search(){
            var user_name = $("#user_name").val();
            if(user_name == ""){
                return false;
            }
            var href = window.location.href;
            if(href.indexOf("?")==-1){
                window.location.href = href+"?user_name="+user_name;
            }else{
                window.location.href = href+"&user_name="+user_name;
            }
        }
    </script>
        <div class="search_box">
            <input type="text" name="user_name" id="user_name" value="<?php echo $_GET["user_name"];?>">
            <img src="/skin/gaoyuan/images/search-icon.png" alt="" onclick="search();">
        </div>

        <!-- 在线用户 -->
        <div class="samle_tu">
            <div class="staff">
                <ul>
                    <style>
                        .staff ul li a{display: block;}
                        .staff ul li a img{border-radius: 100%;}
                    </style>
                <?php foreach($ra_rs0519 as $key=> $hd){ //echo "<pre>";print_r($ra_rs0519);exit;?>
                    <li>
                        <a href="home2.0.php?h=<?php echo $hd['user_id'];?>" target="_blank">
                            <img src="<?php echo $hd['user_ico'];?>" alt="" width="178" height="178" />
                        </a>
                        <div class="mid">
                            <div class="mid_left">
                                <?php if($hd[ 'online_id']){ ?>
                                <img src="./skin/gaoyuan/images/zx.png" />
                                <?php }else{ ?>
                                <img src="./skin/gaoyuan/images/zx.png" />
                                <?php } ?>
                                <?php echo $hd['user_name']; ?>
                            </div>
                            <div class="mid_right">
                                <?php echo date("Y")-$hd['birth_year']; ?> &nbsp;&nbsp;
                            </div>
                            <div class="clear">
                            </div>
                        </div>

                        <div class="way">
                            <i class="xin" id="collect" onclick="top.mypals_add('<?php echo $hd['user_id'];?>');" title="Collect" name="83"></i>
                            <i class="dope" onclick="parent.open_chat('<?php echo $hd['user_id'];?>');" title="Say hello"></i>
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