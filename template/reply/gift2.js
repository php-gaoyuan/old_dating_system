/**
 * Created with JetBrains WebStorm.
 * User: Tony
 * Date: 14-11-14
 * Time: 下午2:54
 * To change this template use File | Settings | File Templates.
 */


$(function () {

    //礼物二级导航tab切换
    $(".gift_tab a").eq(0).addClass("checked");
    //$(".gift_tab a").on("click", function () {
    $(".gift_tab").on("click", "a", function () {
        var loadBlock = $(this).attr("data-block");
        //  alert(loadBlock)
        $(this).addClass('checked').siblings('.checked').removeClass('checked');
        var value = $(".price_cont:visible").find("ul li.checked");
        gift_category($(this).attr("data-category"), value, loadBlock);
    });
    //  gift_category($('.gift_tab').find(".checked").attr("data-category"), $('.gift_tab').find(".checked"), "js_facePackage_list");
    //查看全套阻止默认事件
    $(".js_stop_default").click(function (e) {
        e.stopPropagation();
    });
    //选择礼物---只能选择一件礼物
    $("#js_facePackage_list ").delegate("li", "click", function () {
        var self = $(this);
        popGiftFace(self);
    });
    //鼠标经过遮黑的点击购买.
    $("#email_detail_ez").on("click", ".js_buyFacePackage", function () {
       // var obj = $(this).find("img");
          var obj = $(this);
        $.post(faceData.isHaved, { package: obj.attr("data-id") }, function (res) {//没买过是0,否则是该表情包的数量.
            if (res == 0) {
                warning_dialog(giftData.Noun_Prompt, faceData.Gift_Haved, giftData.Btn_Confirm, function () { });
            } else {
                var Count = faceData.Count;
                var facePackageCount = Count.replace("{0}", res);
                popGiftFace(obj, facePackageCount);
            }
        });
    });
    //详细页购买
    $(".js_buyFaceBtn").on("click", function () {
        var self = $(this);
        //popGiftFace(self);
        var imgId = self.attr("data-id"),
            receiver_cyw = self.attr("data-receiver"),
            giftName = self.attr("data-name");
        fastBuyFacePackage(imgId, receiver_cyw, giftName);

    });
});
function popGiftFace(obj, facePackageCount) {
    var   imgSrc = obj.find("dt img").attr("src")||obj.attr("data-src"), //img src
            giftPrice = obj.attr("data-price"), //获取礼物价格
            giftName = obj.attr("data-name"), //获取表情包称
            imgId = obj.attr("data-id"), //表情包ID
            totalGold = parseInt($("#img .per-info2-num").text()); //本人总金币数
    if (facePackageCount) {
        giftNum = facePackageCount; //yuyanbao
    } else {
        giftNum = obj.attr("data-count"); //表情包数量
    }
    //  integration = 2; //parseInt(obj.attr("data-integral").split("+")[1]); //需要积分数
    $(".js_giftOuter").find("img").attr("src", imgSrc)
             .end().find(".js_giftName").text(giftName)
             .end().find(".js_goldNum").text(giftPrice)
            .end().find(".js_faceNum").text("("+giftNum+")");

    $("#send_giftId").val(imgId);

    $("#Receiver").focus(function () {
        $("#noReceiver").hide();
        $("#Receiver").removeClass("noReceiverInput").addClass("contsend-input");
    });
    var dia = $.dialog({
        title: giftName,
        content: $('#gift_send2_lf')[0],
        okValue: giftData.Gift_Give,
        ok: function () {
            var receiver_cyw = $('#Receiver').val(),
                     comment_cyw = $('.js_sendInfo').val();
            if (receiver_cyw == '') {
                $("#noReceiver").show();
                $("#Receiver").removeClass("contsend-input").addClass("noReceiverInput");
                return false;
            }
            else {
                $.post(giftData.sendGiftUrl, { isIntegral: false, gift: imgId, receiver: receiver_cyw, comment: comment_cyw, giftType: "package" }, function (res) {
                    
                    if (res == 'error') {
                        warning_dialog(giftData.Noun_Prompt, giftData.Gift_SendFail, giftData.Btn_Confirm, function () { });
                    }
                    else if (res == 'noMember') {
                        warning_dialog(giftData.Noun_Prompt, giftData.Gift_ReceiveNotExist, giftData.Btn_Confirm, function () { });
                    }
                    else if (res == 'noGold') {
                        $.icoDialog({
                            skin: 'new-dialog-skin',
                            initialize: function () {
                                $('.d-footer').find('.d-button:eq(0)').addClass('btn btn-ok');
                            },
                            type: 3,
                            title: giftData.Noun_Prompt, //提示
                            content: giftData.Member_GoldNotEnough, //提示消息
                            okValue: giftData.RightNowPay, //确定
                            ok: function () {
                                location.href = giftData.upgradeUrl;
                            },
                            lock: true
                        });
                        
                    } else if (res == 'isHaved') {
                        warning_dialog(giftData.Noun_Prompt, faceData.Gift_Haved, giftData.Btn_Confirm, function () { });
                    } else {
                        var json = eval(res);
                        var successNum = 0;
                        var failResult = '';
                        for (var i = 0; i < json.length; i++) {
                            if (json[i].Result == true) {
                                successNum += 1;
                            } else {
                                failResult += giftData.Gift_SendFail;
                            }
                        }
                        if (successNum > 0) {
                            Global_keepLive();
                        }
                        if (successNum == json.length) {
                            success_dialog(giftData.Message_Title_Remind, faceData.EmotionPackage +" <b>"+ giftName+"</b> " + faceData.faceSuccess, giftData.Btn_Confirm, function () { });

                        } else if (successNum > 0 && failResult != '') {
                            warning_dialog(giftData.Message_Title_Remind, giftData.Gift_SendSuccess3 + failResult, giftData.Gift_ContinueGift, function () {
                            });
                        } else if (successNum == 0 && failResult != '') {
                            $.dialog({
                                title: giftData.Btn_GiveGift + giftName,
                                content: $("#sendFail").html(),
                                okValue: giftData.RightNowPay,
                                ok: function () {
                                    location.href = giftData.upgradeUrl;
                                }
                            });
                        }
                    }
                });
            }
        },
        lock: true
    });
}
function fastBuyFacePackage(imgId, receiver_cyw,giftName) {
    var comment_cyw = "";
    $.post(giftData.sendGiftUrl, { isIntegral: false, gift: imgId, receiver: receiver_cyw, comment: comment_cyw, giftType: "package" }, function (res) {
        if (res == 'error') {
            warning_dialog(giftData.Noun_Prompt, giftData.Gift_SendFail, giftData.Btn_Confirm, function () { });
        }
        else if (res == 'noMember') {
            warning_dialog(giftData.Noun_Prompt, giftData.Gift_ReceiveNotExist, giftData.Btn_Confirm, function () { });
        }
        else if (res == 'noGold') {
            $.icoDialog({
                skin: 'new-dialog-skin',
                initialize: function () {
                    $('.d-footer').find('.d-button:eq(0)').addClass('btn btn-ok');
                },
                type: 3,
                title: giftData.Noun_Prompt, //提示
                content: giftData.Member_GoldNotEnough, //提示消息
                okValue: giftData.RightNowPay, //确定
                ok: function () {
                    location.href = giftData.upgradeUrl;
                },
                lock: true
            });
        } else if (res == 'isHaved') {
            warning_dialog(giftData.Noun_Prompt, faceData.Gift_Haved, giftData.Btn_Confirm, function () { });
        } else {
            var json = eval(res);
            var successNum = 0;
            var failResult = '';
            for (var i = 0; i < json.length; i++) {
                if (json[i].Result == true) {
                    successNum += 1;
                } else {
                    failResult += giftData.Gift_SendFail;
                }
            }
            if (successNum > 0) {
                Global_keepLive();
            }
            if (successNum == json.length) {
                if ($("#BuyFaceState").length > 0) {
                    //只有个人主页才有container_lf.个人主页不 需要更新json
                    $.post(facePData.SenderJsonUrl, function (res) {
                        facePData.SenderJson = eval(res);
                        $("#BuyFaceState").val("1");
                    });
                }
                success_dialog(giftData.Message_Title_Remind, faceData.EmotionPackage + " " + giftName + " " + faceData.faceSuccess, giftData.Btn_Confirm, function () { });
                $(".js_meimai").remove();
                $(".js_faceBottom_ul ").find("li.active .gray").removeClass("gray");
               

            } else if (successNum > 0 && failResult != '') {
                warning_dialog(giftData.Message_Title_Remind, giftData.Gift_SendSuccess3 + failResult, giftData.Gift_ContinueGift, function () {
                    /*obj.find("dt").removeClass("checked").find('.gift_checked').remove();
                    $.cookie("giftCookie",null);*/
                });
            } else if (successNum == 0 && failResult != '') {
                $.dialog({
                    title: giftData.Noun_Prompt,
                    content: $("#sendFail").html(),
                    okValue: giftData.RightNowPay,
                    ok: function () {
                        location.href = giftData.upgradeUrl;
                    }
                });
                //warning_dialog(giftData.Message_Title_Remind, failResult, giftData.Gift_ContinueGift, function () { });
            }
        }
    });
}