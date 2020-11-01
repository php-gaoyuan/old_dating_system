<?php require("foundation/module_lang.php"); ?>



<script type="text/javascript">
    function set_cookie_lp(lp_str) {
        document.cookie = "lp_name=" + escape(lp_str);
        window.location.reload();

    }
    function setCookie(name, value) {
        var date = new Date();
        var expifffays = 1;
        date.setTime(date.getTime() + expifffays * 24 * 3600 * 1000);
        document.cookie = name + "=" + escape(value) + ";expires=" + date.toGMTString();
        document.cookie = "i_im_language=" + escape(value) + ";expires=" + date.toGMTString();
        window.location.reload();
        top.window.location.reload();
    }
    //  加入收藏 <a onclick="AddFavorite(window.location,document.title)">加入收藏</a>
    function AddFavorite(sURL, sTitle) {
        try {
            window.external.addFavorite(sURL, sTitle);
        } catch(e) {
            try {
                window.sidebar.addPanel(sTitle, sURL, "");
            } catch(e) {
                alert("加入收藏失败，请使用Ctrl+D进行添加");
            }
        }
    }
    //设为首页 <a onclick="SetHome(this,window.location)">设为首页</a>
    function SetHome(obj, vrl) {
        try {
            obj.style.behavior = 'url(#default#homepage)';
            obj.setHomePage(vrl);
        } catch(e) {
            if (window.netscape) {
                try {
                    netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
                } catch(e) {
                    alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入“about:config”并回车\n然后将 [signed.applets.codebase_principal_support]的值设置为'true',双击即可。");
                }
                var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
                prefs.setCharPref('browser.startup.homepage', vrl);
            }
        }
    }
</script>
<style>
    #foot1{margin-top:0;height:20px;background:#0D7976;} #foot1 a{color:#fff;padding:0
    20px;text-decoration:none;display:inline-block;height:25px;position:relative;top:-5px;line-height:
    25px;} #foot1 a:hover{background:#b20000;} #foot1 a.current{background:#b20000;}
    body{margin: 0;padding: 0;}
</style>

<div style="background:#B20000;">
	<div class="foot" style="margin-top:0;height:50px;line-height:50px;background:#B20000;">
	    <div class="snslogo" style="margin:0">
	        <a href="index.php">
	            <img src="skin/<?php echo $skinUrl;?>/images/snslogo.png" />
	        </a>
	    </div>
	    <div style="width:30px;height:20px;display:inline-block;float:left">
	    </div>
	    <a style="color:#fff" onclick="setCookie('lp_name','zh');" href="javascript:void(0);">
	        <?php if($langPackagePara=='en' ){ ?>
	        Chinese
	        <?php }else{ ?>
	        简体中文
	        <?php }?>
	    </a>
	    <a>
	        |
	    </a>
	    <a style="color:#fff" onclick="setCookie('lp_name','fanti');" href="javascript:void(0);">
	        繁體中文
	    </a>
	    <a>
	        |
	    </a>
	    <a style="color:#fff" onclick="setCookie('lp_name','en');" href="javascript:void(0);">
	        English
	    </a>
	    <a>
	        |
	    </a>
	    <a style="color:#fff" onclick="setCookie('lp_name','han');" href="javascript:void(0);">
	        한국어
	    </a>
	    <a>
	        |
	    </a>
	    <a style="color:#fff" onclick="setCookie('lp_name','e');" href="javascript:void(0);">
	        русский
	    </a>
	    <a>
	        |
	    </a>
	    <a style="color:#fff" onclick="setCookie('lp_name','xi');" href="javascript:void(0);">
	        Español
	    </a>
	    <a>
	        |
	    </a>
	    <a style="color:#fff" onclick="setCookie('lp_name','de');" href="javascript:void(0);">
	        Deutsch
	    </a>
	    <a>
	        |
	    </a>
	    <a style="color:#fff" onclick="setCookie('lp_name','ri');" href="javascript:void(0);">
	        日本語
	    </a>
	    <div style="width:30px;height:20px;display:inline-block;float:left">
	    </div>
	    <a style="color:#fff" onclick="AddFavorite(window.location,document.title)"
	    href="javascript:;">
	        加入收藏
	    </a>
	    <a>
	        |
	    </a>
	    <a style="color:#fff" onclick="SetHome(this,window.location)" href="javascript:;">
	        设为首页
	    </a>
	</div>
</div>
<div style="background:#0D7976;">
	<div class="foot" id="foot1" style="">
	    <a class="<?php if($_GET['id']==58){echo 'current';}?>" href="modules2.0.php?app=article_article&id=58">
	        <?php echo $pu_langpackage->pu_about_us;?>
	    </a>
	    <a class="<?php if($_GET['id']==59){echo 'current';}?>" href="modules2.0.php?app=article_article&id=59">
	        交友安全
	    </a>
	    <a class="<?php if($_GET['id']==60){echo 'current';}?>" href="modules2.0.php?app=article_article&id=60">
	        隐私条款
	    </a>
	    <a class="<?php if($_GET['id']==61){echo 'current';}?>" href="modules2.0.php?app=article_article&id=61">
	        帮助中心
	    </a>
	    <a class="<?php if($_GET['id']==62){echo 'current';}?>" href="modules2.0.php?app=article_article&id=62">
	        联系我们
	    </a>
	</div>
</div>