/**
 首页行为控制
 by:kule
 2012-05-25
 */
$(function(){
    //访客记录时间转换
    global_date_change("#viewers_box1_lq");
    //divFixedInit();
    $('#app_nav1_lq li:not(".li-title")').bind('click',activeAppNav);
    //$(window).bind('resize',divFixedInit);

    //激活左侧导航
	/*
	 function activeAppNav(){
        $(this).addClass('nav1_active_lq').
            siblings().removeClass('nav1_active_lq');
    }
	
	*/
   
    //初始化fixed
    function divFixedInit(){
        var jqFixP=$('#js_pos_fix1'),
            jqObjR=$('#right_info_lq'),
            jqObjL=$('#left_nav_lq');
        if(jqFixP.length>0)jqFixP.children().unwrap();
        var winH=$(window).height();
        var fixTop=jqObjR.offset().top;
        var jqArr=jqObjR.children();
        var fixH=0;
        var leftH=jqObjL.outerHeight();
        var fixJqArr=[];
        for(var i=jqArr.length;i>0;i--){
            fixH+=$(jqArr[i-1]).outerHeight();
            fixJqArr.push(jqArr[i-1]);
            if(fixH+fixTop+40>winH){//底部浮动条height为40px;
                fixJqArr.pop();
                break;
            }
        }
        if(fixJqArr.length>0){//进入删选
            $(fixJqArr).wrapAll('<div id="js_pos_fix1"></div>');
            divFixed(fixTop);
        }
        if(leftH+fixTop+36>winH){//若超出屏幕范围，position
            jqObjL.css({position:'absolute',"top":"10px"});
        }else if(!$("#container_lq").hasClass("container_rel")){
            jqObjL.css({position:'fixed',"top":"56px"});
        }
        jqArr=null;
        fixJqArr=null;
        jqFixP=null;
    }
    //启动fixed
    function divFixed(fixTop){
        var fixOffset=$('#js_pos_fix1').offset();
        var jqTemp=$('#right_info_lq');
        jqTemp.css({height:jqTemp.height()});//修复内容时指定fixed的bug
        jqTemp=null;
        function fixScroll(e){
            var jqDiv=$('#js_pos_fix1');
            var sTop=$(document).scrollTop();
            if(sTop>=(fixOffset.top-fixTop)){
                jqDiv.addClass('fix1_lq').css({top:fixTop+20});
            }else if(jqDiv.hasClass('fix1_lq')&&sTop<fixOffset.top){
                jqDiv.removeClass('fix1_lq');
            }
            jqDiv=null;
        }
        $(window).unbind('scroll.fix1').bind('scroll.fix1',fixScroll);
    }
	//************返回顶部
    $("#bottom_lq .width980_lq").append("<a id='gotop' onfocus='this.blur()'>" + x18n.gotoTop + "</a>");
	$(window).bind('scroll',function() {
		var w_scrollTop = $(window).scrollTop();
		if(w_scrollTop > 150){
			$("#gotop").fadeIn(600);
		}
		else if(w_scrollTop < 200){
			$("#gotop").fadeOut(600);
		}
	});
	$("#gotop").click(function() {
	   $("html,body").animate({ scrollTop:0},400);
		return false;
	});
});