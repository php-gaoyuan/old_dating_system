<?php
if (@$_GET['tuid']) {
    $tuid = $_GET['tuid'];
    setcookie('tuid', $tuid);
}

require ("foundation/asession.php");
require ("configuration.php");
require ("includes.php");
//语言包引入
$pu_langpackage = new publiclp;
$u_langpackage = new userslp;
$l_langpackage = new loginlp;
$re_langpackage = new reglp;
$ah_langpackage = new arrayhomelp;
if (get_sess_userid()) {
    echo '<script type="text/javascript">location.href="main.php";</script>';exit;
}
$tg = get_argg('tg');
if ($tg == 'invite') {
    $index_ref = "modules/invite.php";
} elseif ($tg == 'search_pals_list') {
    $index_ref = "modules/mypals/search_pals_list.php";
} else {
    $index_ref = "modules/default.php";
}
?>
<!DOCTYPE html>
<html>
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE">
        <title><?php echo $siteName;?></title>
        <meta name="Description" content="<?php echo $metaDesc;?>" />
        <meta name="Keywords" content="<?php echo $metaKeys;?>" />
        <meta name="author" content="<?php echo $metaAuthor;?>" />
        <meta name="robots" content="all" />
        <meta name="renderer" content="webkit|ie-comp|ie-stand">

        <base href='<?php echo $siteDomain;?>' />
        <link rel="shortcut icon" href="/favicon.png" />
        <link type="text/css" rel="stylesheet" href="./template/index/css/login_pd.css">
        <script src="./template/index/js/jquery1.42.min.js" type="text/javascript"></script>
        <script src="./template/layer/layer.js" type="text/javascript"></script>
        <style>#reg_btn[disabled]{background:grey;}</style>
    </head>
    
    <body>
        <div class="head">
            <div class="wrp">
                <em class="head_logo">
                </em>
                <dl class="head_lang">
                    <dd id="head_lang_txt" class="head_lang_txt">
                        <?php 
                            if(isset($_COOKIE['lp_name'])){
                                if($_COOKIE['lp_name'] == 'en'){
                                    echo "English";
                                }elseif($_COOKIE['lp_name'] == 'zh'){
                                    echo "简体中文";
                                }elseif($_COOKIE['lp_name'] == 'fanti'){
                                    echo "繁體中文";
                                }elseif($_COOKIE['lp_name'] == 'han'){
                                    echo "한국어";
                                }elseif($_COOKIE['lp_name'] == 'e'){
                                    echo "русский";
                                }elseif($_COOKIE['lp_name'] == 'de'){
                                    echo "Deutsch";
                                }elseif($_COOKIE['lp_name'] == 'xi'){
                                    echo "Español";
                                }elseif($_COOKIE['lp_name'] == 'ri'){
                                    echo "日本語";
                                }
                            }else{
                                echo "English";
                            }
                        ?>
                    </dd>
                    <dd class="head_lang_arrow">
                    </dd>
                    <dd id="head_lang_viewer" class="head_lang_viewer">
                        <a onclick="setCookie('lp_name','en');" href="javascript:viod();" class="head_lang_item">English</a>
                        <a onclick="setCookie('lp_name','zh');" href="javascript:viod();" class="head_lang_item">简体中文</a>
                        <a onclick="setCookie('lp_name','fanti');" href="javascript:viod();" class="head_lang_item">繁體中文</a>
                        <a onclick="setCookie('lp_name','han');" href="javascript:viod();" class="head_lang_item">한국어</a>
                        <a onclick="setCookie('lp_name','ri');" href="javascript:viod();" class="head_lang_item">日本語</a>
                    </dd>
                </dl>
                <form name="login_form" id="login_form" method="post" action="javascript:;">
                    <input type="submit" name="loginsubm" id="loginsubm" value="<?php echo $l_langpackage->l_login;?>">
                    <dl class="head_east">
                        <dd>
                            <input type="text" id="login_name"  placeholder="<?php echo $u_langpackage->u_uname;?>"
                            class="head_input head_input_mask">
                            <input type="password" id="login_pwd"  placeholder="<?php echo $u_langpackage->u_reg_password;?>"
                            class="head_input head_input_mask">
                        </dd>
                        <!-- <dd><a href="forgot.do" class="head_find"><?php echo $ah_langpackage->ah_forgot_password;?>?</a></dd> -->
                    </dl>
                </form>
            </div>
        </div>
        <!--注册-->
        
        <div class="reg">
            <div class="wrp">
                <form action="javascript:void(0);" id="reg_form" name="reg_form" method="post" class="reg_main">
                    <input type="hidden" name="uid" value="">
                    <input type="hidden" name="tuid" value="">
                    <input type="hidden" name="invite_from_uid" value="">
                    <div class="reg_caption">
                        Welcome to partyings.com
                    </div>
                    <table class="reg_table">
                        <tbody>
                            <tr>
                                <td class="reg_td0">
                                    <dl id="reg_alias_tip">
                                    </dl>
                                    <?php echo $u_langpackage->u_uname;?>
                                </td>
                                <td>
                                    <input type="text" class="reg_input" id="reg_name">
                                </td>
                            </tr>
                            <tr>
                                <td class="reg_td0">
                                    <dl id="reg_pwd_tip">
                                    </dl>
                                    <?php echo $u_langpackage->u_reg_password;?>
                                </td>
                                <td>
                                    <input type="password" class="reg_input" id="reg_pwd" >
                                </td>
                            </tr>
                            <tr>
                                <td class="reg_td0">
                                    <dl id="reg_email_tip">
                                    </dl>
                                    <?php echo $u_langpackage->u_reg_mailbox;?>
                                </td>
                                <td>
                                    <input type="text" class="reg_input" id="reg_email">
                                </td>
                            </tr>
                            <tr>
                                <td class="reg_td0">
                                    <dl id="reg_birth_tip">
                                    </dl>
                                    <?php echo $u_langpackage->u_reg_birth;?>
                                </td>
                                <td>
                                    <select id="reg_year" style="margin-right: 0;">
                                        <option value="">
                                            <?php echo $u_langpackage->u_year;?>
                                        </option>
                                        <?php for ($i=date('Y'); $i > 1905; $i--) { ?>
                                          <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                    <select id="reg_month">
                                        <option value="">
                                            <?php echo $u_langpackage->u_month;?>
                                        </option>
                                        <?php for ($i=0; $i <= 12; $i++) { ?>
                                          <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                    <select id="reg_day">
                                        <option value="">
                                           <?php echo $u_langpackage->u_day;?>
                                        </option>
                                        <?php for ($i=0; $i <= 31; $i++) { ?>
                                          <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="reg_td0">
                                    <?php echo $u_langpackage->u_reg_sex;?>
                                </td>
                                <td>
                                    <input id="reg_gender1" checked="" name="user_sex" type="radio" value="1">
                                    <label for="reg_gender1">
                                        <?php echo $u_langpackage->u_man;?>
                                    </label>
                                    <input id="reg_gender2" name="user_sex" value="0" type="radio">
                                    <label for="reg_gender2">
                                        <?php echo $u_langpackage->u_wen;?>
                                    </label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <input type="submit" id="reg_btn" name="reg" value="<?php echo $u_langpackage->u_reg_fast_registration;?>">
                    </div>
                </form>
            </div>

            <!-- 下载二维码 -->
            <style>
                .download {
                    /*width: 400px;margin-right: 125px;
                    margin-right: 450px;
                    margin-top: 20px;
                    border-radius: 10px;*/
                    width:318px;
                    float: right;
                    background: rgba(0, 0, 0, 0.3);
                    padding: 15px;
                    border-top:1px dashed #ccc;
                    display: ;
                }
                .download .download-left {
                    text-align: center;
                    float: left;
                    width:100%;
                }
                .download .download-right {
                    text-align: center;
                    float: right;
                }
                .download button {
                    border: 0;
                    border-radius: 3px;
                    padding: 10px 15px;
                    background: #437bdc;
                    color: #fff;
                    margin: 15px 0;
                }
            </style>

            <div class="wrp">
                <div class="download">
                    <div class="download-left">
                        <img src="apk/ewm.png" alt="" style="width:160px;">
                        <div>
                            <button class="android">Partyings for Android</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!--注册-->
        <div class="join">
            <div class="wrp">
                <div class="join_caption">
                    <strong>
                        <?php echo $l_langpackage->bg1_tit; ?>
                    </strong>
                    <p>
                        <?php echo $l_langpackage->bg1_txt; ?>
                    </p>
                </div>
                <img src="./template/index/images/bg_1.jpg">
            </div>
        </div>
        <div class="join2">
        </div>
        <div class="love">
            <b>
                <?php echo $l_langpackage->bg2_tit;?>
            </b>
            <p>
                <?php echo $l_langpackage->bg2_tit;?>
            </p>
            <img src="./template/index/images/bg8.jpg">
        </div>
        <div class="love2">
        </div>
        <div class="phone">
            <div class="wrp phone_wrp">
                <div class="phone_line1">
                    <?php echo $l_langpackage->bg3_tit;?>
                </div>
                <div class="phone_line2">
                    <?php echo $l_langpackage->bg3_txt;?>
                </div>
                <div class="phone_line2">
                    <?php echo $l_langpackage->bg3_txt2;?>
                </div>
            </div>
        </div>
        <div class="bottom" style="height:auto;">
            <script type="text/javascript" src="https://www.wshtmltool.com/Get_info.js?mid=600864&corp=partyings"></script>
            <center><script>document.write(copy_right_logo);</script></center>
            <p>Copyright © <script>var myDate = new Date();document.write(myDate.getFullYear());</script>
                <script>document.write(copy_right_company);</script>
                All Rights Reserved.
            </p>

            <p>
                <a href="modules2.0.php?app=article_article&id=58">
                    <?php echo $pu_langpackage->pu_about_us;?>
                </a>
                |
                <a href="modules2.0.php?app=article_article&id=63">
                    <?php echo $newpub_lp['terms'];?>
                </a>
                |
                <a href="modules2.0.php?app=article_article&id=60">
                    <?php echo $pu_langpackage->yinsi;?>
                </a>
                |
                <a href="modules2.0.php?app=article_article&id=59">
                    <?php echo $pu_langpackage->jiaoyouanquan;?>
                </a>
                |
                <a href="modules2.0.php?app=article_article&id=61">
                    <?php echo $pu_langpackage->bangzhu;?>
                </a>
                |
                <a href="modules2.0.php?app=article_article&id=62">
                    <?php echo $pu_langpackage->lianxiwomen;?>
                </a>
            </p>
<!--            <p>-->
<!--                Copyright © --><?php //echo date("Y");?><!-- partyings All Rights Reserved-->
<!--                &nbsp;-->
<!--            </p>-->
        </div>
        
        <script language="javascript">
            //全局变量
            var errTip = {
                l_name_null: '<?php echo $u_langpackage->u_reg_fill_username; ?>',
                l_pwd_null: '<?php echo $u_langpackage->u_reg_fill_password;?>',
                r_name_format: '<?php echo $u_langpackage->u_reg_username_format_error;?>',
                r_name_check_success: '<?php echo $u_langpackage->u_reg_username_available;?>',
                r_name_check_fail: '用户名已被占用！',
                r_check_failBack: '参数错误',
                r_email_check_null: '请输入你的邮箱地址',
                r_email_check_format: '邮箱格式不正确，请重新输入',
                r_email_check_success: '邮箱可以使用',
                r_email_check_fail: '邮箱已存在',
                r_pwd_check_null: '密码不能为空,请重新输入',
                r_pwd_check_len: '密码长度应大于6个字符',
                r_pwd_check_sameuser: '用户名与密码不能相同',
                r_pwd_check_success: '密码可以使用',
                r_repwd_check_null: '确认密码',
                r_repwd_check_notsame: '两次密码不一致',
                r_leastage_check: '年龄不能小于18岁',
                r_utcnow_year: '2015'
            };
            /*****************************************登录开始********************************************/
            $("#loginsubm").click(function(e){
                if(check_login()){
                    var url = '/do.php?act=login';
                    var _login_name = $("#login_name").val();
                    var _login_pwd = $("#login_pwd").val();
                    
                    $.post(url,{u_email: _login_name, u_pws: _login_pwd},function(data){
                        var returns =data.split('|');
                        returns[0]=returns[0].replace(/\ +/g,"");
                        returns[0]=returns[0].replace(/[\r\n]/g,"");
                        if (returns[0]=='1') {
                            window.location ="main.php";;
                        } else {
                            if (returns[0]== "emailmsg") {
                                //帐号不存在
                                alert(returns[1]);
                            } else if (returns[0] == "pwdmsg") {
                                //密码不对
                                alert(returns[1]);
                            }
                        }
                    },"text");
                }
            });
            
            function check_login(){
                var login_name = $("#login_name");
                var login_pwd = $("#login_pwd");
                //检查用户名
                if(login_name.val().trim() == ""){
                    alert(errTip.l_name_null);
                    return false;
                }
                //检查密码
                if(login_pwd.val().trim() == ""){
                    alert(errTip.l_pwd_null);
                    return false;
                }

                return true;

            }
            /*****************************************登录结束********************************************/


            /*****************************************注册开始********************************************/
            $("#reg_btn").click(function(){
                var url = '/do.php?act=reg&ajax=1';
                var value = {
                    user_name:$('#reg_name').val(),
                    user_password:$('#reg_pwd').val(),
                    user_email:$('#reg_email').val(),
                    user_sex:$("input[name='user_sex']:checked").val(),
                    birth_year:$('#reg_year').val(),
                    birth_month:$('#reg_month').val(),
                    birth_day:$('#reg_day').val()
                };

                $.post(url, value, function (data) {
                    if(data.code == 0){
                        window.location.href = data.url;
                    }else if(data.code > 0){
                        console.log(data.msg);
                        alert(data.msg);
                        if(data.url != ""){
                            window.location.href=data.url;
                        }
                    }
                },"json");
                
            });
            /*****************************************注册结束********************************************/

            /*滚动到底部按钮*/
            $(".home_scroll a").click(function (e) {
                $("html,body").animate({ scrollTop: $("#index_more").offset().top }, 500);
            });




            function setCookie (name,value) {
                var date=new Date(); 
                var expireDays=1; 
                date.setTime(date.getTime()+expireDays*24*3600*1000);
                document.cookie = name+"="+escape(value)+";expires="+date.toGMTString();
                document.cookie = "i_im_language="+escape(value)+";expires="+date.toGMTString();
                window.location.reload();
            }
        </script>
    </body>
</html>