<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"/www/wwwroot/www.pauzzz.com/app/application/index/view/update/down.html";i:1567989608;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>pauzzz-APP</title>
    <link rel="stylesheet" href="<?php echo config('skin_path'); ?>/mui/css/mui.min.css">
    <script src="<?php echo config('skin_path'); ?>/mui/js/mui.min.js"></script>
</head>
<body>
<header class="mui-bar mui-bar-nav mui-badge-danger" style="background-color:#36373C;">
    <h1 class="mui-title" style="color:#fff">pauzzz-APP</h1>
</header>
<div class="mui-content">
    <div style="height: 50px;"></div>
    <center>
        <img src="<?php echo config('webconfig.pc_url'); ?>apk/app_logo.png" alt="" style="width:150px;height:150px;    box-shadow: 0px 0px 10px #888888;
    border-radius: 10px;
    margin-bottom: 15px;"/>
        <br>
        pauzzz(<?php echo $size; ?>)
    </center>
    <div style="text-align: center;margin:20px 50px;line-height: 2rem;">
        pauzzz官方APP(<?php echo $version; ?>)
        <br>多语言交友，自动翻译，撩妹更方便
    </div>
    <div style="margin:0 50px;">
        <button type="button" class="mui-btn mui-btn-danger mui-btn-block" id="download"
                style="font-size:14px;padding:10px 0;background-color:#36373C;border-color:#36373C">点击下载最新版APP
        </button>
    </div>
</div>
<script>
    var downloadBtn = document.getElementById("download");
    downloadBtn.onclick = function () {
        if (isWechat()) {
            mui.alert("请点击右上角的三个点，选择在浏览器打开该页面进行下载");
        } else {
            window.location.href = "<?php echo $downLoadUrl; ?>";
        }

    }


    function isWechat() {
        var ua = window.navigator.userAgent.toLowerCase();
        if (ua.match(/MicroMessenger/i) == 'micromessenger') {
            return true;
        } else {
            return false;
        }
    }
</script>
</body>
</html>