//显示隐藏
$(function () {
    $(".js_select_top").on('click', 'label', function (e) {
        $(this).closest(".js_select_top").find("ul,.triggle-top").toggle();
        $("#face_jqface").addClass("hidden1_lq");
        e.stopPropagation();
    $(document).click(function () {
            $('.js_select_top ul,.triggle-top').hide();
        });
    });
    
    //模拟select--正常
    $(".js_select_top ul").on('click', 'li', function (e) {
        var selected = $(this).text();
        var value = $(this).attr("langs-lang");
        $(this).closest(".js_select_top").find("span").text(selected).attr("data-lang", value);
        $("#LetterLang").val($(this).attr("langs-lang")); //私信选择翻译语言
        if ($("#LetterLang").val() != "no") {//私信是否翻译
            $("#IsTrans").val("yes");
        }
        else if ($("#LetterLang").val() == "no") {
            $("#IsTrans").val("no");
        }
        $(".js_select_top ul,.triggle-top").hide();
        // e.preventDefault(); 
    });
    $(".faces_icon1_lq").on("click", function () {
        $(".js_select_top ul").hide();

    });

});
