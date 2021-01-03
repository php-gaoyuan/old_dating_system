<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"/www/wwwroot/www.dsrramtcys.com/app/application/index/view/recharge/index.html";i:1609145697;}*/ ?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo lang('recharge'); ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <link href="<?php echo config('skin_path'); ?>/css/mui.min.css" rel="stylesheet"/>
    <style>
        .mui-card{margin: 10px 0;border-radius: 0}
        #list{}
        #list .mui-col-sm-4{}
        #list .money{display: block;text-align: center;line-height: 3em;margin: 10px;border: 1px solid #2C6AD8;border-radius: 5px}
        #list .money.active{background: #2C6AD8;color: #fff}
    </style>
</head>
<body>
<?php if(!$is_h5_plus): ?>
<header class="mui-bar mui-bar-nav">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title"><?php echo lang('recharge'); ?></h1>
</header>
<?php endif; ?>
<div class="mui-content">
    <form action="<?php echo url('recharge/create_pay'); ?>" method="post">
        <div class="mui-card">
            <div class="mui-card-header"><?php echo lang('recharge_way'); ?></div>
            <div class="mui-card-content">
                <div class="mui-input-row mui-radio mui-left" style="margin: 10px 0;">
                    <label><?php echo lang('upgrade_foy_youself'); ?></label>
                    <input name="to_user" type="radio" value="1" checked>
                </div>
                <div class="mui-input-row mui-radio mui-left" style="border-top: 1px solid #e4e3e6;">
                    <label style="line-height:40px;"><?php echo lang('upgrade_foy_others'); ?>
                        <input type="text" name="friend" id="friend"  placeholder="<?php echo lang('friend_name'); ?>" style="width:40%;font-size:12px;margin: 0px;">
                    </label>
                    <input name="to_user" type="radio" value="2" style="line-height: 55px;">
                </div>
            </div>
        </div>
        <div class="mui-card">
            <!--页眉，放置标题-->
            <div class="mui-card-header"><?php echo lang('select_recharge'); ?></div>
            <!--内容区-->
            <div class="mui-card-content">
                <div class="mui-row" id="list">
                    <div class="mui-col-sm-4 mui-col-xs-4"><span class="money " data-val="30">30USD</span></div>
                    <div class="mui-col-sm-4 mui-col-xs-4"><span class="money" data-val="50">50USD</span></div>
                    <div class="mui-col-sm-4 mui-col-xs-4"><span class="money" data-val="100">100USD</span></div>
                    <div class="mui-col-sm-4 mui-col-xs-4"><span class="money active" data-val="200">200USD</span></div>
                    <div class="mui-col-sm-4 mui-col-xs-4"><span class="money" data-val="500">500USD</span></div>
                    <div class="mui-col-sm-4 mui-col-xs-4"><span class="money" data-val="1000">1000USD</span></div>
                </div>
            </div>
            <!--页脚，放置补充信息或支持的操作-->
            <div class="mui-card-footer">
                <div class="mui-input-row">
                    <label><?php echo lang('golds'); ?></label>
                    <input type="text" class="mui-input-clear"  name="money"  >
                </div>
            </div>
        </div>
        <style>
            #pay_list > div{text-align: center}
            #pay_list img{border: 2px solid #ccc;border-radius: 5px;margin: 10px 0;min-height: 52px;width: 95%;height: 56px}
            #pay_list img.active{border: 2px solid #007aff}
            #fht_cont{border: 1px solid #ccc;border-radius: 5px;margin: 20px;padding: 10px;background: #fff}
            .input-row label{display: inline-block;width: 30%;line-height: 40px;margin-bottom: 15px}
            .input-row input{display: inline-block;width: 65%}
            .input-row select{display: inline-block;width: 32%;border: 1px solid #ccc !important}
        </style>
        <div class="mui-card">
            <!--页眉，放置标题-->
            <div class="mui-card-header"><?php echo lang('select_pay_type'); ?></div>
            <!--内容区-->
            <div class="mui-card-content">
                <div class="mui-row" id="pay_list">
<!--                    <div class="mui-col-sm-6 mui-col-xs-6">-->
<!--                        <img src="<?php echo config('skin_path'); ?>/images/vml.png" alt="lianyin2" class="pay_type active">-->
<!--                    </div>-->
<!--                    <div class="mui-col-sm-6 mui-col-xs-6">-->
<!--                        <img src="<?php echo config('skin_path'); ?>/images/vm.png" alt="lianyin" class="pay_type">-->
<!--                    </div>-->
                    <div class="mui-col-sm-6 mui-col-xs-6">
                        <img src="<?php echo config('skin_path'); ?>/images/jcb.png" alt="ipasspay" class="pay_type active">
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="select_money" value="200">
        <input type="hidden" name="pay_method" value="ipasspay">
        <button type="submit" class="mui-btn mui-btn-blue mui-btn-block" style="width:90%;margin:0 auto;" id="sub">
            <?php echo lang('submit'); ?>
        </button>
        <div style="height:20px;"></div>
    </form>
</div>
<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo config('skin_path'); ?>/js/public.js"></script>
<script type="text/javascript">
    $(function () {
        $(".pay_type").click(function () {
            $(".pay_type").removeClass("active");
            $(this).addClass("active");
            var pay_name = $(this).attr("alt");
            $("input[name='pay_method']").val(pay_name);
        });
    });
    $(function () {
        $(".money").click(function () {
            $(".money").removeClass("active");
            $(this).addClass("active");
            $("input[name='select_money']").val($(".active").data("val"))
        });
        $("input[name='money']").bind('input propertychange', function () {
            // $(".money").removeClass("active");
            // if ($(this).val() < 5) {
            //     $(this).val(5)
            // }
        });
        $("#sub").click(function () {
            var money = $(".money.active").data("val");
            var input_money = $("input[name='money']").val();
            // if (parseInt(input_money) > 0 && parseInt(input_money) < 5) {
            //     mui.toast("<?php echo lang('recharge low'); ?>");
            //     $("input[name='money']").val(5);
            //     return false
            // } else if (input_money >= 1000) {
            //     mui.toast('單筆交易金額最大不能超過1000USD');
            //     return false
            // }
            if (parseInt(input_money) <= 0) {
                mui.toast("<?php echo lang('recharge low'); ?>");
                $("input[name='money']").val(1);
                return false
            }
            var friend = $("input[name='friend']");
            var to_user = $("input[name='to_user']:checked");
            if (to_user.val() == "2") {
                if (friend.val() == "") {
                    mui.toast("<?php echo lang('friend name no empty'); ?>");
                    friend.focus();
                    return false
                }
            }
            return true
        })
    });
</script>
</body>
</html>