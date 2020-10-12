$(function(){
	//$("#iframe_div_lq").find("#flowebanner li").soChange();
	/*加加减减*/
	$("#iframe_div_lq").on('click','#floweradd',function(){
		var $buynumval = $("#buynum").val();
		$("#buynum").val($buynumval*1+1);
		return false;
	});
	$("#iframe_div_lq").on('click','#flowercut',function(){
		var $buynumval = $("#buynum").val();
		if($buynumval>1){
			$("#buynum").val($buynumval*1-1);
		}
		return false;
	});
	$("#iframe_div_lq").on('blur','#buynum',function(){
		var $buynumval = $(this).val();
		if($buynumval<1){
			$(this).val(1);
		}
	});
	/*产品放大*/
	$("#iframe_div_lq").jqueryzoom({
        xzoom: 300, //设置放大 DIV 长度（默认为 200）
        yzoom: 290, //设置放大 DIV 高度（默认为 200）
        offset: 10, //设置放大 DIV 偏移（默认为 10）
        position: "right", //设置放大 DIV 的位置（默认为右边）
        preload:1,
        lens:1
    });
	/*切换点击鲜花*/
	$("#iframe_div_lq").on('click','#flowerthums li',function(){
		var $jqzoomimg = $("#jqzoom img");
		var $thisimg = $("img",this);
		$jqzoomimg.attr({
			src:$thisimg.attr("src"),
			'data-zimg':$thisimg.attr("data-bimg")
		});
		$(this).addClass("thumcur").siblings("li").removeClass("thumcur");
	});
	/*懒人选项卡调用*/
	$("#iframe_div_lq").lrtab({});
});
/*懒人选项卡*/
(function ($) {
	$.fn.lrtab = function (options) {
		var opts={
			Event:'click',
			lrtabdom:"div.tabtit h3 a",
			lrtabcon:"div.tabcon",
			callback:function(){}
		};
		$.extend(opts,options);
		this.on(opts.Event,opts.lrtabdom,function(){
			$thisindex = $(this).index();
			$(this).addClass("tabcur").siblings("a").removeClass("tabcur");
			$(opts.lrtabcon).children("div.tabshow").eq($thisindex).show().siblings("div.tabshow").hide();
			opts.callback();
		});
		
		
		
	};
})(jQuery);
/*焦点图*/
;(function($){
	$.fn.extend({
		"soChange": function(o){

			o= $.extend({
				thumbObj:null,//导航对象
				botPrev:null,//按钮上一个
				botNext:null,//按钮下一个
				changeType:'fade',//切换方式，可选：fade,slide，默认为fade
				thumbNowClass:'now',//导航对象当前的class,默认为now
				thumbOverEvent:true,//鼠标经过thumbObj时是否切换对象，默认为true，为false时，只有鼠标点击thumbObj才切换对象
				slideTime:1000,//平滑过渡时间，默认为1000ms，为0或负值时，忽略changeType方式，切换效果为直接显示隐藏
				autoChange:true,//是否自动切换，默认为true
				clickFalse:true,//导航对象点击是否链接无效，默认是return false链接无效，当thumbOverEvent为false时，此项必须为true，否则鼠标点击事件冲突
				overStop:true,//鼠标经过切换对象时，是否停止切换，并于鼠标离开后重启自动切换，前提是已开启自动切换
				changeTime:5000,//自动切换时间
				delayTime:300//鼠标经过时对象切换迟滞时间，推荐值为300ms
			}, o || {});

			var _self = $(this);
			var thumbObj;
			var size = _self.size();
			var nowIndex =0; //定义全局指针
			var index;//定义全局指针
			var startRun;//预定义自动运行参数
			var delayRun;//预定义延迟运行参数

			//主切换函数
			function fadeAB () {
				if (nowIndex != index) {
					if (o.thumbObj) {
						$(o.thumbObj).removeClass(o.thumbNowClass).eq(index).addClass(o.thumbNowClass);
					}
					if (o.slideTime <= 0) {
						_self.eq(nowIndex).hide();
						_self.eq(index).show();
					}else if(o.changeType=='fade'){
						_self.eq(nowIndex).fadeOut(o.slideTime);
						_self.eq(index).fadeIn(o.slideTime);
					}else{
						_self.eq(nowIndex).slideUp(o.slideTime);
						_self.eq(index).slideDown(o.slideTime);
					}
					nowIndex = index;
//					if (o.autoChange) {
//						clearInterval(startRun);//重置自动切换函数
//						startRun = setInterval(runNext,o.changeTime);
//					}
				}
			}

			//切换到下一个
			function runNext() {
				index =  (nowIndex+1)%size;
				fadeAB();
			}

			//初始化
			_self.hide().eq(0).show();

			//点击任一图片
			if (o.thumbObj) {
				thumbObj = $(o.thumbObj);

				//初始化thumbObj
				thumbObj.removeClass(o.thumbNowClass).eq(0).addClass(o.thumbNowClass);
				thumbObj.click(function () {
					index = thumbObj.index($(this));
					fadeAB();
					if (o.clickFalse) {return false;}
				});
				if (o.thumbOverEvent) {
					thumbObj.hover(function () {//去除jquery1.2.6不支持的mouseenter方法
						index = thumbObj.index($(this));
						delayRun = setTimeout(fadeAB,o.delayTime);
					},function () {
						clearTimeout(delayRun);
					});
				}
			}

		//点击上一个
			if (o.botNext) {
				$(o.botNext).click(function () {
					if(_self.queue().length<1){runNext();}
					return false;
				});
			}

		//点击下一个
			if (o.botPrev) {
				$(o.botPrev).click(function () {
					if(_self.queue().length<1){
						index = (nowIndex+size-1)%size;
						fadeAB();
					}
					return false;
				});
			}

		//自动运行
			if (o.autoChange) {
				startRun = setInterval(runNext,o.changeTime);
				if (o.overStop) {
					_self.hover(function () {//去除jquery1.2.6不支持的mouseenter方法
						clearInterval(startRun);//重置自动切换函数
					},function () {
						startRun = setInterval(runNext,o.changeTime);
					});
				}
			}
		}
	})

})(jQuery);
/*产品放大*/
(function($) {
    $.fn.jqueryzoom = function(options) {
        var settings = {
			jqzoomdom:'#jqzoom',
            xzoom: 200,
            yzoom: 200,
            offset: 10,
            position: "right",
            lens: 1,
            preload: 1
        };
        if (options) {
            $.extend(settings, options);
        };
        var noalt = '';
		/*划入划出*/
        this.on('mouseenter',settings.jqzoomdom,function() {
            var imageLeft = $(this).offset().left;
            var imageTop = $(this).offset().top;
			var thisWidth = $(this).width();
			var thisHeight = $(this).height();
            var imageWidth = $(this).children('img').get(0).offsetWidth;
            var imageHeight = $(this).children('img').get(0).offsetHeight;
            noalt = $(this).children("img").attr("alt");
            var bigimage = $(this).children("img").attr("data-zimg");
            $(this).children("img").attr("alt", '');
            if ($("div.zoomdiv").get().length == 0) {
                $(this).after("<div class='zoomdiv'><img class='bigimg' src='" + bigimage + "'/></div>");
                $(this).append("<div class='jqZoomPup'>&nbsp;</div>");
            };
            if (settings.position == "right") {
                if (imageLeft + thisWidth + settings.offset + settings.xzoom > screen.width) {
                    leftpos = imageLeft - settings.offset - settings.xzoom;
                } else {
                    leftpos = imageLeft + thisWidth + settings.offset;
                }
            } else {
                leftpos = imageLeft - settings.xzoom - settings.offset;
                if (leftpos < 0) {
                    leftpos = imageLeft + thisWidth + settings.offset;
                }
            };
            $("div.zoomdiv").css({
                top: imageTop,
                left: leftpos
            });
            $("div.zoomdiv").width(settings.xzoom);
            $("div.zoomdiv").height(settings.yzoom);
            $("div.zoomdiv").show();
            if (!settings.lens) {
                $(this).css('cursor', 'crosshair');
            };
            $(document.body).mousemove(function(e) {
                mouse = new MouseEvent(e);
                var bigwidth = $(".bigimg").get(0).offsetWidth;
                var bigheight = $(".bigimg").get(0).offsetHeight;
                var scaley = 'x';
                var scalex = 'y';
                if (isNaN(scalex) | isNaN(scaley)) {
                    var scalex = (bigwidth / thisWidth);
                    var scaley = (bigheight / thisHeight);
                    $("div.jqZoomPup").width((settings.xzoom) / (scalex * 1));
                    $("div.jqZoomPup").height((settings.yzoom) / (scaley * 1));
                    if (settings.lens) {
                        $("div.jqZoomPup").css('visibility', 'visible');
                    }
                };
                xpos = mouse.x - $("div.jqZoomPup").width() / 2 - imageLeft;
                ypos = mouse.y - $("div.jqZoomPup").height() / 2 - imageTop;
                if (settings.lens) {
                    xpos = (mouse.x - $("div.jqZoomPup").width() / 2 < imageLeft) ? 0 : (mouse.x + $("div.jqZoomPup").width() / 2 > imageWidth + imageLeft) ? (imageWidth - $("div.jqZoomPup").width() - 2) : xpos;
                    ypos = (mouse.y - $("div.jqZoomPup").height() / 2 < imageTop) ? 0 : (mouse.y + $("div.jqZoomPup").height() / 2 > imageHeight + imageTop) ? (imageHeight - $("div.jqZoomPup").height() - 2) : ypos;
                };
                if (settings.lens) {
                    $("div.jqZoomPup").css({
                        top: ypos,
                        left: xpos
                    });
                };
                scrolly = ypos;
                $("div.zoomdiv").get(0).scrollTop = scrolly * scaley;
                scrollx = xpos;
                $("div.zoomdiv").get(0).scrollLeft = (scrollx) * scalex;
            });
        }).on('mouseleave',settings.jqzoomdom,function() {
			$(this).children("img").attr("alt", noalt);
			$(document.body).unbind("mousemove");
			if (settings.lens) {
				$("div.jqZoomPup").remove();
			};
			$("div.zoomdiv").remove();
		});
		
        count = 0;
        if (settings.preload) {
            $('body').append("<div style='display:none;' class='jqPreload" + count + "'>&nbsp;</div>");
            $(this).each(function() {
                var imagetopreload = $(this).children("img").attr("data-zimg");
                var content = jQuery('div.jqPreload' + count + '').html();
                jQuery('div.jqPreload' + count + '').html(content + '<img src=\"' + imagetopreload + '\">');
            });
        }
    }
})(jQuery);
function MouseEvent(e) {
    this.x = e.pageX;
    this.y = e.pageY;
}