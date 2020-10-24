/*
* 应用
* 2012-8-
*/
$(function () {
    //插入弹出层框架
    $("body").append("<div id='iframeWarp' class='formdivbox' style='height:500px;'><div class='closediv' id='closediv'><strong class='fl'><a id='goback'>" + x18n.backToList + "</a></strong><a class='fr formclose' id='formclose'></a><a class='fr formmax' id='formmax'></a><a class='fr formmin' id='formmin'></a></div><div id='app_overlay'></div><iframe scrolling='auto' frameborder='no' hidefocus='' allowtransparency='true' class='iframeApp' name='iframeAppWarp' id='iframeAppWarp' src=''></iframe></div><div id='minapps'></div><small id=formbj></small>");
	 //$.fn.apppop({});
	 $("#appbtn").apppop({});
});
//应用弹出层
; (function ($) {
	$.fn.apppop = function (options) {
		var opts={
			popwidth:'920',
			iframesrc:'/App/List',
			callback:function(){}
		},$formboxid = $("#iframeWarp"),$iframeApp = $("#iframeAppWarp");;
		$.extend(opts,options);
		////////////////////
		/*弹出层居中显示*/
		
		var win_w = $(window).width();
		var win_h = $(window).height();
		var divheight = win_h - 80;
		var iframeheight = win_h - 80 - 32;
		var divLeft = (win_w - opts.popwidth) / 2;
		//返回列表
		$("#goback").click(function () {
			$iframeApp.attr("src",'/App/List');
			return false;
		});
		// 窗口大小重设事件
		$(window).resize(function () {
			if ($("#iframeWarp").is(":visible")) {
				resizebox();
			}
		});
		/*单击show*/
		this.click(function(){appFrameOpen(null)});
		function appFrameOpen(url){
			if ((!$("#iframeAppWarp").attr("src"))||url) {//外部调用appFrame，覆盖最小化
				$("#iframeWarp").show().children("#iframeAppWarp").attr("src",url||opts.iframesrc);
				resizebox();
				//回调
				opts.callback();
			}
			else {
				//$("#iframeWarp").show();
				//showformbj();
                resizebox();
			}
			return false;
		}
        $("#app_nav1_lq a.app_frame").click(function () {
			$.get($(this).attr('appUrl'), function (res) {
                if (res && res.title) $.fn.apppop_open(res.url);
            });
			return false;
		 });

		$.fn.apppop_open=appFrameOpen;
		/*单击关闭*/
		$("#formclose").click(function () {
            $(this).parent().siblings("iframe").attr("src", "").parent().hide();
			$("#minapps").children("a").remove();
			hideformbj();
			return false;
		});
		//最大化窗体
        $("#formmax").click(function(){
            var $this = $(this);
            if($this.hasClass('formmaxv')){
                resizebox();
			    $this.removeClass("formmaxv"); 
            }else {
                var win_w = $(window).width();
			    var win_h = $(window).height();
			    $("#iframeWarp").animate({ top: "0", left: "0", height: win_h - 4, width: win_w - 4 }, "fast", function () { }).children("#iframeAppWarp").height(win_h - 32);
			    $this.addClass("formmaxv");
            }
        });
		//最小化层
		$("#formmin").click(function () {
			var win_w = $(window).width();
			var win_h = $(window).height();
			$("#iframeWarp").animate({ top: win_h-12, left:-12, height:"0", width: "0" }, 600, function () {
				//$(this).css({ "left": divLeft, "top": 40, "width":opts.popwidth, "height": divheight }).hide();
                $(this).hide();
				hideformbj();
			});
			$iframeApp.height(iframeheight);
		});
		//单击还原
		$("#minapps").on('click', 'a', function () {
			resizebox();
		});
		//阻止点击事件传播-拖拽
		$("#goback,#formclose,#formmax,#formmin").mousedown(function(e){
			e.stopPropagation();
			return false;
		});
		$("#closediv").mousedown(function () {
			$(this).parent("div").stop().end()
                   .next("div").css({'opacity':'0.1','display':'block'});
		}).mouseup(function () {
			$(this).next("div").css({'display':'none'});
		});
		//调用拖拽插件
		$formboxid.jqDrag($("#closediv"));
		//重置窗体大小
		function resizebox () {
			var win_h = $(window).height();
			var divheight = win_h - 80;
			var iframeheight = win_h - 80 - 32;
			var divLeft = ($(window).width() - opts.popwidth) / 2;
			var divTop = ($(window).height() - divheight) / 2;
            //$("#iframeWarp").css({top:40, left:divLeft,height:divheight,width:opts.popwidth,display:'block'});
			$("#iframeWarp").animate({ opacity: "1", top: 40, left: divLeft, height: divheight, width:opts.popwidth},300, function () {
				//$("#formbj").hide();
			}).show();
			$iframeApp.height(iframeheight);
            showformbj();
		}
		function showformbj() {
            var win_h = $(window).height();
			$("#formbj").css({'display':'block'});
			$("html").height(win_h).css("overflow", "hidden");
		}
        function hideformbj() {
			$("#formbj").hide();
			$('html').css("overflow", "auto");
		}
		$formboxid=null;
		////////////////////////
	};
})(jQuery);

//拖拽
(function($){
	$.fn.jqDrag=function(h){
        return i(this,h,'d');
    };
	$.fn.jqResize=function(h){return i(this,h,'r');};
	$.jqDnR={dnr:{},e:0,
	drag:function(v){
	 if(M.k == 'd')E.css({left:M.X+v.pageX-M.pX,top:M.Y+v.pageY-M.pY});
	 else E.css({width:Math.max(v.pageX-M.pX+M.W,0),height:Math.max(v.pageY-M.pY+M.H,0)});
	  return false;},
	stop:function(){E.css('opacity',M.o);$(document).unbind('mousemove',J.drag).unbind('mouseup',J.stop);}
	};
	var J=$.jqDnR,M=J.dnr,E=J.e,
	i=function(e,h,k){return e.each(function(){h=(h)?$(h,e):e;
	 h.bind('mousedown',{e:e,k:k},function(v){var d=v.data,p={};E=d.e;
	 // attempt utilization of dimensions plugin to fix IE issues
	 if(E.css('position') != 'relative'){try{E.position(p);}catch(e){}}
	 M={X:p.left||f('left')||0,Y:p.top||f('top')||0,W:f('width')||E[0].scrollWidth||0,H:f('height')||E[0].scrollHeight||0,pX:v.pageX,pY:v.pageY,k:d.k,o:E.css('opacity')};
	 E.css({opacity:1});$(document).mousemove($.jqDnR.drag).mouseup($.jqDnR.stop);
	 return false;
	 });
	});},
	f=function(k){return parseInt(E.css(k))||false;};
})(jQuery);

/*
 * 弹出层lrsimpop
 * Author:	不明物体 51xuediannao.com
 * Version: Beta 0.1
 * Date:	2012-12-12
 ************************************
 * 参数说明：
 * contype:"url:post或者get?请求路径?发送请求数据?数据类型"
 * 此插件目前不支持IE6
*/
//例子
//contype:"text:"+thistext+"",
//contype:"url:post?post.html?null?html",
//contype:"iframe:http://www.baidu.com/",
//contype:"id:testbox",
;(function ($) {
    $.fn.lrsimpop = function (options) {
        var opts={
			styleclass:"lrpop_def",
			maskopa:0.3,
			brdopa:0.3,
			brd_w:'8',
			lrpop_w:"300",
			lrpop_h:"160",
			contype:"",
			lrpop_tit:"",
			lrpop_btns:"",
			mask_x:'yes',
			x_reload:false,
			//<a class='submit'>提交</a><a class='cancel'>取消</a><a class='next'>下一步</a><a href='http://www.baidu.com' target='_blank' class='gourl'>跳转</a>
			ajaxok:function(data){$lrpop_con.html(data);},
            callback:function(){}
        },_this=this;
        $.extend(opts,options);
		
		//插入html结构
		if(!$("#lrpop_warp")[0]){
			$("body").append("<div class='lrpop_warp' id='lrpop_warp'><div class='lrpop' id='lrpop'><div class='lrpop_tit' id='lrpop_tit'><strong>弹出窗体</strong></div><a class='x' id='lrpop_x'>×</a><div class='lrpop_con' id='lrpop_con'>真遗憾！什么都没有发现。</div><div class='lrpop_btns' id='lrpop_btns'></div></div><div class='lrpop_brd' id='lrpop_brd'></div></div><div id='lrpop_mask'></div>");	
		}
		var $lrpop_mask = $("#lrpop_mask"),$lrpop_warp = $("#lrpop_warp"),$lrpop_con = $("#lrpop_con"),
			$lrpop_tit = $("#lrpop_tit > strong"),$lrpop_x = $("#lrpop_x"),$lrpop_btns = $("#lrpop_btns"),
			$lrpop_warp_w = opts.lrpop_w,$lrpop_warp_h = opts.lrpop_h
		//背景遮罩和模拟半透明边框
		$lrpop_mask.css({
			opacity:+opts.maskopa,height:$(document).height(),width:$(document).width()
		});
		$lrpop_warp.addClass(opts.styleclass).children("#lrpop_brd").css({
			opacity:+opts.brdopa,
			width:opts.lrpop_w*1+opts.brd_w*2,height:opts.lrpop_h*1+opts.brd_w*2,
			top:-opts.brd_w,left:-opts.brd_w
		});
		//设置标题和加载按钮
		if(opts.lrpop_tit){$lrpop_tit.html(opts.lrpop_tit);}else{$lrpop_tit.html(_this.text());}
		$lrpop_btns.html(opts.lrpop_btns);
		//show弹出层
		$.fn.lrsimpop.show($lrpop_warp_w,$lrpop_warp_h);
		var content_array = opts.contype;
		contentType=content_array.substring(0,content_array.indexOf(":"));
		content=opts.contype.substring(content_array.indexOf(":")+1,content_array.length);
		switch(contentType){
  			case "html":
			$lrpop_con.html(content);
			break;
			case "id":
			$lrpop_con.html($("#"+content+"").html());
			break;
			case "url":
			var content_array=content.split("?");
			$lrpop_con.ajaxStart(function(){
				$(this).html("loading...");
			});
			$.ajax({
				type:content_array[0],
				url:content_array[1],
				data:content_array[2],
				dataType:""+content_array[3]+"",
				error:function(){
			  		$lrpop_con.html("很遗憾！没有载入成功...");
				},
				success:opts.ajaxok
			});
			break;
			case "iframe":
  			$lrpop_con.html("<iframe src=\""+content+"\" width=\"100%\" height=\""+(parseInt($lrpop_warp_h)-80)+"px"+"\" scrolling=\"auto\" frameborder=\"0\" marginheight=\"0\" marginwidth=\"0\"></iframe>");
			break;
		}
		//回调
		opts.callback();
		//重设窗口时调整层位置
		$(window).resize(function(){
			var win_w = $(window).width();
			var win_h = $(window).height();
			var doc_h = $(document).height();
			$lrpop_mask.css({height:doc_h});
			$lrpop_warp.animate({
				left:win_w*0.5-($lrpop_warp_w)*0.5,
				top:win_h*0.5-($lrpop_warp_h)*0.5
			});
		});
		//单击关闭
		$lrpop_x.on('click', function(){
			$lrpop_mask.hide();
			$lrpop_warp.hide();
			$lrpop_con.html("");
			if(opts.x_reload==true){window.location.reload();}
		});
		//按钮
		$lrpop_btns.children("a").on('click', function(){
			$lrpop_x.trigger('click');
		});
		//单击遮罩关闭
		$lrpop_mask.on('click', function(){
			if(opts.mask_x=='yes'){
				$lrpop_x.trigger('click');
			}
		});
		
    };
	
	$.fn.lrsimpop.show = function(show_w,show_h){
		var win_w = $(window).width();
		var win_h = $(window).height();
		$("#lrpop_mask,#lrpop_warp").show().
		filter("#lrpop_warp").css({
			width:show_w,
			height:show_h,
			left:win_w*0.5-(show_w)*0.5,
			top:win_h*0.5-(show_h)*0.5
			//top:-show_h-100				//初始把top负出去下面要做自定义动画用
		}).animate({
			//top:win_h*0.5-(show_h)*0.5
		});
		
    };
   
})(jQuery);