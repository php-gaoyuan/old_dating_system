$(function () {
    MT = {};
    //限制字符个数 
    $(".old-data-chat .msg-cont-cont").each(function () {
        var maxwidth = 150;
        if ($(this).text().length > maxwidth) {
            $(this).text($(this).text().substring(0, maxwidth)); $(this).html($(this).html() + '...');
        }
    });
    $(".oldata-cont").each(function () {
        var maxwidth = 50;
        if ($(this).text().length > maxwidth) {
            $(this).text($(this).text().substring(0, maxwidth)); $(this).html($(this).html() + '...');
        }
    });

    //删除按钮
    // $(".js_item").on("click", ".js_close_icon", function () {
    // $(this).closest(".js_item").remove();
    // });
    //量文本宽高
    MT.measureText = function (pText) {
        var dimension,
            lDiv = $('<div></div>');
        $(document.body).append(lDiv);
        lDiv.css({
            postition: "absolute",
            left: -1000
        });
        lDiv.html(pText);
        dimension = {
            w: lDiv.width(),
            h: lDiv.outerHeight(true)
        };
        lDiv.remove();
        lDiv = null;
        return dimension;
    };
});