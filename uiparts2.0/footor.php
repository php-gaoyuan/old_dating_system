<script language="javascript">
    function setCookie(name, value) {
        var date = new Date();
        var expireDays = 1;
        date.setTime(date.getTime() + expireDays * 24 * 3600 * 1000);
        document.cookie = name + "=" + escape(value) + ";expires=" + date.toGMTString();
        document.cookie = "i_im_language=" + escape(value) + ";expires=" + date.toGMTString();
        window.location.reload();
        top.window.location.reload();
    }

    function goLogin() {
        Dialog.confirm("登陸後才能執行操作,現在登錄？",
        function() {
            top.location = "index.php";
        });
    }
</script>
<div id="bottom_lq" style="height: auto; line-height: 24px;position: fixed;z-index:0; margin:0 auto">
    <div class="width980_lq" style="height: auto; line-height: 24px;padding: 5px 0;background: #fafafa;  ">
        <div>
            <span class="copy_right_lq">
                <a href="javascript:setCookie('lp_name','en')">
                    English
                </a>
                |
                <a href="javascript:setCookie('lp_name','zh')">
                    简体中文
                </a>
                |
                <a href="javascript:setCookie('lp_name','fanti')">
                    繁體中文
                </a>
                |
                <a href="javascript:setCookie('lp_name','han')">
                    한국어
                </a>
                |
                <a href="javascript:setCookie('lp_name','ri')">
                    日本語
                </a>
            </span>
        </div>
        <span class="bottom_link_lq">
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
        </span>
        <div>
        </div>
    </div>
</div>
<?php require("uiparts2.0/chat.php");?>
<?php require("uiparts2.0/kefu.php");?>