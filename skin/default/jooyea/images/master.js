$(function(){
	//���������˵�
	var $mainnav_li = $("#mainnav > li[rel]");
	$mainnav_li.each(function(){
		var $thirel = $(this).attr("rel"),$thisapp = $("#"+$thirel).html();
	   	$(this).append("<div>"+$thisapp+"</div>").children("a").append("<i><s>��</s></i>");
	 });
	$mainnav_li.mouseenter(function(){
		$(this).addClass("navcur").siblings("li").removeClass("navcur");
	}).mouseleave(function(){
		$(this).removeClass("navcur")
	});
	/*���tag*/
	var tags_a = $("#tags").find("a");
         tags_a.each(function(){
             var x = 9;
             var y = 0;
             var rand = parseInt(Math.random() * (x - y + 1) + y);
             $(this).addClass("tags"+rand);
          });
	/*tab*/ 
	$.jqtab = function(tabtit,tabconbox) {
		$(tabtit).children("h3").eq(0).addClass("thistab"); 
		$(tabtit).children("h3").click(function() {
			var index_tit = $(this).index();
			$(this).addClass("thistab").siblings("h3").removeClass("thistab"); 
			$(tabconbox).children("dd").eq(index_tit).fadeIn().siblings("dd").hide(); 
			return false;
		});
		
	};
	/*���÷������£�*/
	$.jqtab("#tabstit1","#tabconbox1");
	$.jqtab("#tabstit2","#tabconbox2");
	$.jqtab("#tabstit3","#tabconbox3");
	$.jqtab("#tabstit4","#tabconbox4");
	/*���벹��*/
	var limorea = $(".limore a");
	var abtni = $(".abtn");
	limorea.prepend("�鿴����-"); 
	/*||���벹��*/
	/*��ʱ����ͼƬ*/
	$("img[data-original]").lazyload({ 
		effect : "fadeIn"
	});
	$("div.tabstit h3").click( function(){ 
		var thistab = $(this).find("a").attr("tab");
		var thismore = $(this).attr("more");
		var thistext = $(this).find("a").text();
		var thishref = $(this).find("a").attr("href");
		$("#"+thismore).attr("href",thishref).html("<var>"+thistext+" >></var>");
		$("#tit"+thismore).attr("href",thishref).html(thistext);
		
		$(thistab+" img[data-original]").lazyload({ 
			effect : "fadeIn"
		});
		
	});
	
	//�ײ����
	var bottom_gg = $("#bottom_gg");
	var ad_gb = $("#ad_gb");
	var ad_body = $("div.ad_body");
	var fanhuibut = $("#fanhui");
	ad_body.hide();
	$(window).scroll(function() {
		var w_scrollTop = $(window).scrollTop();
		if(w_scrollTop > 100){
			bottom_gg.fadeIn(600);
		}
		else if(w_scrollTop < 200){
			bottom_gg.fadeOut(600);
			//$('#pagenav').fadeOut(600);
		}
		//�������·���ʱ�����ҳ���ڵ�
		/*var distanceTop = $('#copyright').offset().top - $(window).height()-400;
		if  ($(window).scrollTop() > distanceTop){
			$('#pagenav').fadeIn(600);
			}*/
	});
	ad_gb.click(function() {
		ad_body.fadeOut(600);
	});
	//���ض���
	fanhuibut.click(function() {
        $("html,body").animate({ scrollTop:0},200);
		return false;
    });
	//focusblur
	jQuery.focusblur = function(focusid) {
		var focusblurid = $(focusid);
		var defval = focusblurid.val();
		focusblurid.focus(function(){
			var thisval = $(this).val();
			if(thisval==defval){
				$(this).val("");
			}
		});
		focusblurid.blur(function(){
			var thisval = $(this).val();
			if(thisval==""){
				$(this).val(defval);
			}
		});
		
	};
	/*�����ǵ��÷���*/
	$.focusblur("#searchkey");
	//չ���������˵��
	$("#introduce").after("<a href='#' id='zhankai'>û�о��������</a>");
	$("#zhankai").toggle(
	  function () {
		$("#introduce").css("height","auto");
		$(this).html("�۵�����ӡ���");
		return false;
	  },
	  function () {
		$("#introduce").css("height","93");
		$(this).html("û�о����鿴�����");
		return false;
	  }
	);
	//�����б�ǰ��������
	$("#sidebar").find("ul.listnum li:lt(3)").addClass("top13");
//tool_tip
$.tooltip = function(tiphoverdom) {
	var tipbox = $("#tipbox");	
	var tipboximg = tipbox.find("img");
	var tipboximg = tipbox.find("strong");
	tiptime = '';
	$(tiphoverdom).hover(function(){
		var thisa = $(this).find("a");
		var imgsrc = thisa.attr("data-img");
		var tiptit = thisa.text();
		tipbox.html("<div><img src="+imgsrc+"><strong>"+tiptit+"</strong></div>");
		tiptime=setTimeout(function(){tipbox.fadeIn();},500);
	}, function() {
		clearTimeout(tiptime);
		tipbox.hide();	  
	}).mousemove(function(e) {
		var mousex = e.pageX + 45;
		var mousey = e.pageY + 25; 
		var tipboxWidth = tipbox.width(); 
		var tipboxHeight = tipbox.height();
		var tipboxVisX = $(window).width() - (mousex + tipboxWidth);
		var tipboxVisY = $(window).height() - (mousey + tipboxHeight);
		if ( tipboxVisX < 20 ) { 
			mousex = e.pageX - tipboxWidth - 45;
		} if ( tipboxVisY < 20 ) { 
			mousey = e.pageY - tipboxHeight - 25;
		} 
		tipbox.css({ top: mousey, left: mousex });
	});
};
//tool_tip����
});
$(window).load(function() {
    /*$("#tb950").html("<a href='http://coco9010.taobao.com' target='_blank'><img src='http://ww1.sinaimg.cn/large/4035398atw1dug60r7njtg.gif' width='950' height='100'/></a>").css("background-color","#DCC951");*/
});
/*����pop*/
(function ($) {
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
			//<a class='submit'>�ύ</a><a class='cancel'>ȡ��</a><a class='next'>��һ��</a><a href='http://www.baidu.com' target='_blank' class='gourl'>��ת</a>
            callback:function(){}
        },_this=this;
        $.extend(opts,options);
		//����html�ṹ�����Լ���һ�㶼�ǰ�html�ṹֱ��д��ҳ�����ˣ�����������һ�����Ⱥã����԰�html�ṹֱ��д�����õĵײ��ļ��С�
		if(!$("#lrpop_warp").length>0){
			$("body").append("<div class='lrpop_warp' id='lrpop_warp'><div class='lrpop' id='lrpop'><div class='lrpop_tit' id='lrpop_tit'><strong>��������</strong></div><a class='x' id='lrpop_x'>��</a><div class='lrpop_con' id='lrpop_con'>���ź���ʲô��û�з��֡�</div><div class='lrpop_btns' id='lrpop_btns'></div></div><div class='lrpop_brd' id='lrpop_brd'></div></div><div id='lrpop_mask'></div>");	
			}
		var $lrpop_mask = $("#lrpop_mask"),$lrpop_warp = $("#lrpop_warp"),$lrpop_con = $("#lrpop_con"),
			$lrpop_tit = $("#lrpop_tit").find("strong"),$lrpop_x = $("#lrpop_x"),$lrpop_btns = $("#lrpop_btns"),
			$lrpop_warp_w = opts.lrpop_w,$lrpop_warp_h = opts.lrpop_h
		//�������ֺ�ģ���͸���߿�
		$lrpop_mask.css({
			opacity:+opts.maskopa,height:$(document).height(),width:$(document).width()
		});
		$lrpop_warp.addClass(opts.styleclass).children("#lrpop_brd").css({
			opacity:+opts.brdopa,
			width:opts.lrpop_w*1+opts.brd_w*2,height:opts.lrpop_h*1+opts.brd_w*2,
			top:-opts.brd_w,left:-opts.brd_w
		});
		//���ñ���ͼ��ذ�ť
		if(opts.lrpop_tit){$lrpop_tit.html(opts.lrpop_tit);}else{$lrpop_tit.html(_this.text());}
		$lrpop_btns.html(opts.lrpop_btns);
		//show������
		$.fn.lrsimpop.show($lrpop_warp_w,$lrpop_warp_h);
		//��������
		var content_array = opts.contype;
		contentType=content_array.substring(0,content_array.indexOf(":"));
		content=opts.contype.substring(content_array.indexOf(":")+1,content_array.length);
		switch(contentType){
  			case "text":
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
			  		$lrpop_con.html("error...");
				},
				success:function(data){
			  		$lrpop_con.html(data);
				}
			});
			break;
			case "iframe":
  			$lrpop_con.html("<iframe src=\""+content+"\" width=\"100%\" height=\""+(parseInt($lrpop_warp_h)-80)+"px"+"\" scrolling=\"auto\" frameborder=\"0\" marginheight=\"0\" marginwidth=\"0\"></iframe>");
			break;
		}
		//�ص�
		opts.callback();
		//���贰��ʱ������λ��
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
		//�����ر�
		$lrpop_x.on('click', function(){
			$lrpop_mask.hide();
			$lrpop_warp.hide();
			$lrpop_con.html("");
		});
		//��ť
		$lrpop_btns.children("a").on('click', function(){
			$lrpop_x.trigger('click');
		});
		//�������ֹر�
		$lrpop_mask.on('click', function(){
			$lrpop_x.trigger('click');
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
			top:-show_h-100				//��ʼ��top����ȥ����Ҫ���Զ��嶯����
		}).animate({
			top:win_h*0.5-(show_h)*0.5
		});
		
    };
   
})(jQuery);
/*lazy loading images Version:1.7.2*/
(function(a,b){$window=a(b),a.fn.lazyload=function(c){function f(){var b=0;d.each(function(){var c=a(this);if(e.skip_invisible&&!c.is(":visible"))return;if(!a.abovethetop(this,e)&&!a.leftofbegin(this,e))if(!a.belowthefold(this,e)&&!a.rightoffold(this,e))c.trigger("appear");else if(++b>e.failure_limit)return!1})}var d=this,e={threshold:0,failure_limit:0,event:"scroll",effect:"show",container:b,data_attribute:"original",skip_invisible:!0,appear:null,load:null};return c&&(undefined!==c.failurelimit&&(c.failure_limit=c.failurelimit,delete c.failurelimit),undefined!==c.effectspeed&&(c.effect_speed=c.effectspeed,delete c.effectspeed),a.extend(e,c)),$container=e.container===undefined||e.container===b?$window:a(e.container),0===e.event.indexOf("scroll")&&$container.bind(e.event,function(a){return f()}),this.each(function(){var b=this,c=a(b);b.loaded=!1,c.one("appear",function(){if(!this.loaded){if(e.appear){var f=d.length;e.appear.call(b,f,e)}a("<img />").bind("load",function(){c.hide().attr("src",c.data(e.data_attribute))[e.effect](e.effect_speed),b.loaded=!0;var f=a.grep(d,function(a){return!a.loaded});d=a(f);if(e.load){var g=d.length;e.load.call(b,g,e)}}).attr("src",c.data(e.data_attribute))}}),0!==e.event.indexOf("scroll")&&c.bind(e.event,function(a){b.loaded||c.trigger("appear")})}),$window.bind("resize",function(a){f()}),f(),this},a.belowthefold=function(c,d){var e;return d.container===undefined||d.container===b?e=$window.height()+$window.scrollTop():e=$container.offset().top+$container.height(),e<=a(c).offset().top-d.threshold},a.rightoffold=function(c,d){var e;return d.container===undefined||d.container===b?e=$window.width()+$window.scrollLeft():e=$container.offset().left+$container.width(),e<=a(c).offset().left-d.threshold},a.abovethetop=function(c,d){var e;return d.container===undefined||d.container===b?e=$window.scrollTop():e=$container.offset().top,e>=a(c).offset().top+d.threshold+a(c).height()},a.leftofbegin=function(c,d){var e;return d.container===undefined||d.container===b?e=$window.scrollLeft():e=$container.offset().left,e>=a(c).offset().left+d.threshold+a(c).width()},a.inviewport=function(b,c){return!a.rightofscreen(b,c)&&!a.leftofscreen(b,c)&&!a.belowthefold(b,c)&&!a.abovethetop(b,c)},a.extend(a.expr[":"],{"below-the-fold":function(c){return a.belowthefold(c,{threshold:0,container:b})},"above-the-top":function(c){return!a.belowthefold(c,{threshold:0,container:b})},"right-of-screen":function(c){return a.rightoffold(c,{threshold:0,container:b})},"left-of-screen":function(c){return!a.rightoffold(c,{threshold:0,container:b})},"in-viewport":function(c){return!a.inviewport(c,{threshold:0,container:b})},"above-the-fold":function(c){return!a.belowthefold(c,{threshold:0,container:b})},"right-of-fold":function(c){return a.rightoffold(c,{threshold:0,container:b})},"left-of-fold":function(c){return!a.rightoffold(c,{threshold:0,container:b})}})})(jQuery,window)
//�����ղؼ�
    function addCookie() {
        if (document.all) {
            window.external.addFavorite(document.location.href,document.title);
        }
        else if (window.sidebar) {
            window.sidebar.addPanel(document.title,document.location.href,"")
        }
    }