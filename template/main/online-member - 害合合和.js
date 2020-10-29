jQuery(function () {
    var $ = jQuery;   
    //底部图标点击变色
    $(".piclib-icon").delegate('li', 'click', function () {
        $(this).addClass("active").siblings('.active').removeClass("active");
        alert('xxx')
    });
    var index = 1;
    var moveBox = $(".overview");

    //左按钮
    $(".picbtn-1").click(function () {
		
		
        if (index == 1) {
            return;
        }
        index--;
        rollingRight();
        if (index == 1) {
            $(".picbtn-1").addClass("disable");
        } else {
            $(".picbtn-1").removeClass("disable");
        }

    });
    //右按钮
    $(".picbtn-2").click(function () {
		
		
        if (index == 3) {
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
            left: "-=730px"
        }, 900);

    }
    //向左
    function rollingRight() {
        moveBox.animate({
            left: "+=730px"
}, 900);
    }
});