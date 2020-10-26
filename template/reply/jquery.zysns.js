/*!
* artDialog 5
* Date: 2012-03-21
* http://code.google.com/p/artdialog/
* (c) 2009-2012 TangBin, http://www.planeArt.cn
*
* This is licensed under the GNU LGPL, version 2.1 or later.
* For details, see: http://creativecommons.org/licenses/LGPL/2.1/
*/

;(function ($, window, undefined) {

// artDialog 只支持 xhtml 1.0 或者以上的 DOCTYPE 声明
if (document.compatMode === 'BackCompat') {
    throw new Error('artDialog: Document types require more than xhtml1.0');
};

var _singleton,
    _count = 0,
    _expando = 'artDialog' + + new Date,
    _isIE6 = window.VBArray && !window.XMLHttpRequest,
    _isMobile = 'createTouch' in document && !('onmousemove' in document)
        || /(iPhone|iPad|iPod)/i.test(navigator.userAgent),
    _isFixed = !_isIE6 && !_isMobile;

    
var artDialog = function (config, ok, cancel) {

    config = config || {};
    
    if (typeof config === 'string' || config.nodeType === 1) {
    
        config = {content: config, fixed: !_isMobile};
    };
    
    
    var api, defaults = artDialog.defaults;
    var elem = config.follow = this.nodeType === 1 && this || config.follow;
        
    
    // 合并默认配置
    for (var i in defaults) {
        if (config[i] === undefined) {
            config[i] = defaults[i];
        };
    };

    
    config.id = elem && elem[_expando + 'follow'] || config.id || _expando + _count;
    api = artDialog.list[config.id];
    
    
    
    if (api) {
        if (elem) {
            api.follow(elem)
        };
        api.zIndex().focus();
        return api;
    };
    
    
    
    // 目前主流移动设备对fixed支持不好
    if (!_isFixed) {
        config.fixed = false;
    };
    
    // !$.isArray(config.button)
    if (!config.button || !config.button.push) {
        config.button = [];
    };
    
    
    // 确定按钮
    if (ok !== undefined) {
        config.ok = ok;
    };
    
    if (config.ok) {
        config.button.push({
            id: 'ok',
            value: config.okValue,
            callback: config.ok,
            focus: true
        });
    };
    
    
    // 取消按钮
    if (cancel !== undefined) {
        config.cancel = cancel;
    };
    
    if (config.cancel) {
        config.button.push({
            id: 'cancel',
            value: config.cancelValue,
            callback: config.cancel
        });
    };
    
    // 更新 zIndex 全局配置
    artDialog.defaults.zIndex = config.zIndex;
    
    _count ++;

    return artDialog.list[config.id] = _singleton ?
        _singleton.constructor(config) : new artDialog.fn.constructor(config);
};

artDialog.version = '5.0';

artDialog.fn = artDialog.prototype = {
    
    /** @inner */
    constructor: function (config) {
        var dom;
        
        this.closed = false;
        this.config = config;
        this.dom = dom = this.dom || this._getDom();
        
        config.skin && dom.wrap.addClass(config.skin);
        
        dom.wrap.css('position', config.fixed ? 'fixed' : 'absolute');
        dom.close[config.cancel === false ? 'hide' : 'show']();
        dom.content.css('padding', config.padding);
        
        this.button.apply(this, config.button);
        
        this.title(config.title)
        .content(config.content)
        .size(config.width, config.height)
        .time(config.time);

        config.follow
        ? this.follow(config.follow)
        : this.position();
        
        this.zIndex();
        config.lock && this.lock();
        
        this._addEvent();
        this[config.visible ? 'visible' : 'hidden']().focus();
        
        _singleton = null;
        
        config.initialize && config.initialize.call(this);
        
        return this;
    },
    
    
    /**
    * 设置内容
    * @param	{String, HTMLElement, Object}	内容 (可选)
    */
    content: function (message) {
    
        var prev, next, parent, display,
            that = this,
            $content = this.dom.content,
            content = $content[0];
        
        
        if (this._elemBack) {
            this._elemBack();
            delete this._elemBack;
        };
        
        
        if (typeof message === 'string') {
        
            $content.html(message);
        } else
        
        if (message && message.nodeType === 1) {
        
            // 让传入的元素在对话框关闭后可以返回到原来的地方
            display = message.style.display;
            prev = message.previousSibling;
            next = message.nextSibling;
            parent = message.parentNode;
            
            this._elemBack = function () {
                if (prev && prev.parentNode) {
                    prev.parentNode.insertBefore(message, prev.nextSibling);
                } else if (next && next.parentNode) {
                    next.parentNode.insertBefore(message, next);
                } else if (parent) {
                    parent.appendChild(message);
                };
                message.style.display = display;
                that._elemBack = null;
            };
            
            $content.html('');
            content.appendChild(message);
            $(message).show();
            
        };
        
        return this.position();
    },
    
    
    /**
    * 设置标题
    * @param	{String, Boolean}	标题内容. 为 false 则隐藏标题栏
    */
    title: function (content) {
    
        var dom = this.dom,
            outer = dom.outer,
            $title = dom.title,
            className = 'd-state-noTitle';
        
        if (content === false) {
            $title.hide().html('');
            outer.addClass(className);
        } else {
            $title.show().html(content);
            outer.removeClass(className);
        };
        
        return this;
    },
    

    /** @inner 位置居中 */
    position: function () {
    
        var dom = this.dom,
            wrap = dom.wrap[0],
            $window = dom.window,
            $document = dom.document,
            fixed = this.config.fixed,
            dl = fixed ? 0 : $document.scrollLeft(),
            dt = fixed ? 0 : $document.scrollTop(),
            ww = $window.width(),
            wh = $window.height(),
            ow = wrap.offsetWidth,
            oh = wrap.offsetHeight,
            left = (ww - ow) / 2 + dl,
            top = top = (oh < 4 * wh / 7 ? wh * 0.382 - oh / 2 : (wh - oh) / 2) + dt,
            style = wrap.style;

        style.left = Math.max(left, dl) + 'px';
        style.top = Math.max(top, dt) + 'px';
        
        return this;
    },
    
    
    /**
    *	尺寸
    *	@param	{Number, String}	宽度
    *	@param	{Number, String}	高度
    */
    size: function (width, height) {
    
        var style = this.dom.main[0].style;
        
        if (typeof width === 'number') {
            width = width + 'px';
        };
        
        if (typeof height === 'number') {
            height = height + 'px';
        };
            
        style.width = width;
        style.height = height;
        
        return this;
    },
    
    
    /**
    * 跟随元素
    * @param	{HTMLElement}
    */
    follow: function (elem) {
    
        var $elem = $(elem),
            config = this.config;
        
        
        // 隐藏元素不可用
        if (!elem || !elem.offsetWidth && !elem.offsetHeight) {
        
            return this.position(this._left, this._top);
        };
        
        var fixed = config.fixed,
            expando = _expando + 'follow',
            dom = this.dom,
            $window = dom.window,
            $document = dom.document,
            winWidth = $window.width(),
            winHeight = $window.height(),
            docLeft =  $document.scrollLeft(),
            docTop = $document.scrollTop(),
            offset = $elem.offset(),
            width = elem.offsetWidth,
            height = elem.offsetHeight,
            left = fixed ? offset.left - docLeft : offset.left,
            top = fixed ? offset.top - docTop : offset.top,
            wrap = this.dom.wrap[0],
            style = wrap.style,
            wrapWidth = wrap.offsetWidth,
            wrapHeight = wrap.offsetHeight,
            setLeft = left - (wrapWidth - width) / 2,
            setTop = top + height,
            dl = fixed ? 0 : docLeft,
            dt = fixed ? 0 : docTop;
            
            
        setLeft = setLeft < dl ? left :
        (setLeft + wrapWidth > winWidth) && (left - wrapWidth > dl)
        ? left - wrapWidth + width
        : setLeft;

        
        setTop = (setTop + wrapHeight > winHeight + dt)
        && (top - wrapHeight > dt)
        ? top - wrapHeight
        : setTop;
        
        
        style.left = setLeft + 'px';
        style.top = setTop + 'px';
        
        
        this._follow && this._follow.removeAttribute(expando);
        this._follow = elem;
        elem[expando] = config.id;
        
        return this;
    },
    
    
    /**
    * 自定义按钮
    * @example
        button({
            value: 'login',
            callback: function () {},
            disabled: false,
            focus: true
        }, .., ..)
    */
    button: function () {
    
        var dom = this.dom,
            $buttons = dom.buttons,
            elem = $buttons[0],
            strongButton = 'd-state-highlight',
            listeners = this._listeners = this._listeners || {},
            ags = [].slice.call(arguments);
            
        var i = 0, val, value, id, isNewButton, button;
        
        for (; i < ags.length; i ++) {
            
            val = ags[i];
            
            value = val.value;
            id = val.id || value;
            isNewButton = !listeners[id];
            button = !isNewButton ? listeners[id].elem : document.createElement('input');
            
            button.type = 'button';
            button.className = 'd-button';
                    
            if (!listeners[id]) {
                listeners[id] = {};
            };
            
            if (value) {
                button.value = value;
            };
            
            if (val.width) {
                button.style.width = val.width;
            };
            
            if (val.callback) {
                listeners[id].callback = val.callback;
            };
            
            if (val.focus) {
                this._focus && this._focus.removeClass(strongButton);
                this._focus = $(button).addClass(strongButton);
                this.focus();
            };
            
            button[_expando + 'callback'] = id;
            button.disabled = !!val.disabled;
            

            if (isNewButton) {
                listeners[id].elem = button;
                elem.appendChild(button);
            };
        };
        
        $buttons[0].style.display = ags.length ? '' : 'none';
        
        return this;
    },
    
    
    /** 显示对话框 */
    visible: function () {
        //this.dom.wrap.show();
        this.dom.wrap.css('visibility', 'visible');
        this.dom.outer.addClass('d-state-visible');
        
        if (this._isLock) {
            this._lockMask.show();
        };
        
        return this;
    },
    
    
    /** 隐藏对话框 */
    hidden: function () {        
        //this.dom.wrap.hide();
        this.dom.wrap.css('visibility', 'hidden');
        this.dom.outer.removeClass('d-state-visible');
        
        if (this._isLock) {
            this._lockMask.hide();
        };
        
        return this;
    },
    
    
    /** 关闭对话框 */
    close: function () {        
        if (this.closed) {
            return this;
        };
        var dom = this.dom,
            $wrap = dom.wrap,
            list = artDialog.list,
            beforeunload = this.config.beforeunload,
            follow = this.config.follow;

        if (beforeunload && beforeunload.call(this) === false) {
            return this;
        };
        
        
        if (artDialog.focus === this) {
            artDialog.focus = null;
        };
        
        
        if (follow) {
            follow.removeAttribute(_expando + 'follow');
        };
        
        
        if (this._elemBack) {
            this._elemBack();
        };


        this.time();
        this.unlock();
        this._removeEvent();
        delete list[this.config.id];
        
        
        if (_singleton) {
            $wrap.remove();

        // 使用单例模式
        } else {
        
            _singleton = this;
            dom.title.html('');
            dom.content.html('');
            dom.buttons.html('');
            
            $wrap[0].className = $wrap[0].style.cssText = '';
            dom.outer[0].className = 'd-outer';
            
            $wrap.css({
                left: 0,
                top: 0,
                position: _isFixed ? 'fixed' : 'absolute'
            });
            
            for (var i in this) {
                if (this.hasOwnProperty(i) && i !== 'dom') {
                    delete this[i];
                };
            };
            
            this.hidden();
            
        };
        
        this.closed = true;
        return this;
    },
    
    
    /**
    * 定时关闭
    * @param	{Number}	单位毫秒, 无参数则停止计时器
    */
    time: function (time) {
        var that = this,
            timer = this._timer;
        timer && clearTimeout(timer);
        
        if (time) {
            this._timer = setTimeout(function(){
                that._click('cancel');
            }, time.time);
        };
        
        
        return this;
    },
    
    /** @inner 设置焦点 */
    focus: function () {

        if (this.config.focus) {
            //setTimeout(function () {
                try {
                    var elem = this._focus && this._focus[0] || this.dom.close[0];
                    elem && elem.focus();
                // IE对不可见元素设置焦点会报错
                } catch (e) {};
            //}, 0);
        };
        
        return this;
    },
    
    
    /** 置顶对话框 */
    zIndex: function () {
    
        var dom = this.dom,
            top = artDialog.focus,
            index = artDialog.defaults.zIndex ++;
        
        // 设置叠加高度
        dom.wrap.css('zIndex', index);
        this._lockMask && this._lockMask.css('zIndex', index - 1);
        
        // 设置最高层的样式
        top && top.dom.outer.removeClass('d-state-focus');
        artDialog.focus = this;
        dom.outer.addClass('d-state-focus');
        
        return this;
    },
    
    
    /** 设置屏锁 */
    lock: function () {
    
        if (this._isLock) {
            return this;
        };
        
        var that = this,
            config = this.config,
            dom = this.dom,
            div = document.createElement('div'),
            $div = $(div),
            index = artDialog.defaults.zIndex - 1;
        
        this.zIndex();
        dom.outer.addClass('d-state-lock');
            
        $div.css({
            zIndex: index,
            position: 'fixed',
            left: 0,
            top: 0,
            width: '100%',
            height: '100%',
            overflow: 'hidden'
        }).addClass('d-mask');
        
        if (!_isFixed) {
            $div.css({
                position: 'absolute',
                width: $(window).width() + 'px',
                height: $(document).height() + 'px'
            });
        };
        
            
        $div.bind('click', function () {
            that._reset();
        }).bind('dblclick', function () {
            if(config.dblClose)that._click('cancel');
        });
        
        document.body.appendChild(div);
        
        this._lockMask = $div;
        this._isLock = true;
        
        return this;
    },
    
    
    /** 解开屏锁 */
    unlock: function () {

        if (!this._isLock) {
            return this;
        };
        
        this._lockMask.unbind();
        this._lockMask.hide();
        this._lockMask.remove();
        
        this.dom.outer.removeClass('d-state-lock');
        this._isLock = false;

        return this;
    },
    
    
    // 获取元素
    _getDom: function () {
    
        var body = document.body;
        
        if (!body) {
            throw new Error('artDialog: "documents.body" not ready');
        };
        
        var wrap = document.createElement('div');
            
        wrap.style.cssText = 'position:absolute;left:0;top:0';
        wrap.innerHTML = artDialog._templates;
        body.insertBefore(wrap, body.firstChild);
        var name,
            i = 0,
            dom = {},
            els = wrap.getElementsByTagName('*'),
            elsLen = els.length;
            
        for (; i < elsLen; i ++) {
            name = els[i].className.split('d-')[1];
            if (name) {
                dom[name] = $(els[i]);
            };
        };
        
        dom.window = $(window);
        dom.document = $(document);
        dom.wrap = $(wrap);
        
        return dom;
    },
    
    
    // 按钮回调函数触发
    _click: function (id) { 
        var fn = this._listeners[id] && this._listeners[id].callback;
        
        return typeof fn !== 'function' || fn.call(this) !== false ?
            this.close() : this;
    },
    
    
    // 重置位置
    _reset: function () {
        var elem = this.config.follow;
        elem ? this.follow(elem) : this.position();
    },
    
    
    // 事件代理
    _addEvent: function () {
    
        var that = this,
            dom = this.dom;
        
        
        // 监听点击
        dom.wrap
        .bind('click', function (event) {
        
            var target = event.target, callbackID;
            
            // IE BUG
            if (target.disabled) {
                return false;
            };
            
            if (target === dom.close[0]) {
                that._click('cancel');
                return false;
            } else {
                callbackID = target[_expando + 'callback'];
                callbackID && that._click(callbackID);
            };
            
        })
        .bind('mousedown', function () {
            that.zIndex();
        });
        
    },
    
    
    // 卸载事件代理
    _removeEvent: function () {
        this.dom.wrap.unbind();
    }
    
};

artDialog.fn.constructor.prototype = artDialog.fn;



$.fn.dialog = $.fn.artDialog = function () {
    var config = arguments;
    this[this.live ? 'live' : 'bind']('click', function () {
        artDialog.apply(this, config);
        return false;
    });
    return this;
};



/** 最顶层的对话框API */
artDialog.focus = null;



/**
* 根据 ID 获取某对话框 API
* @param	{String}	对话框 ID
* @return	{Object}	对话框 API (实例)
*/
artDialog.get = function (id) {
    return id === undefined
    ? artDialog.list
    : artDialog.list[id];
};

artDialog.list = {};



// 全局快捷键
$(document).bind('keydown', function (event) {
    var target = event.target,
        nodeName = target.nodeName,
        rinput = /^input|textarea$/i,
        api = artDialog.focus,
        keyCode = event.keyCode;

    if (!api || !api.config.esc || rinput.test(nodeName) && target.type !== 'button') {
        return;
    };
    
    // ESC
    keyCode === 27 && api._click('cancel');
});



// 浏览器窗口改变后重置对话框位置
$(window).bind('resize', function () {
    var dialogs = artDialog.list;
    for (var id in dialogs) {
        dialogs[id]._reset();
    };
});



// XHTML 模板
// 使用 uglifyjs 压缩能够预先处理"+"号合并字符串
// @see	http://marijnhaverbeke.nl/uglifyjs
artDialog._templates = 
'<div class="d-outer">'
+	'<table class="d-border">'
+		'<tbody>'
+			'<tr class="d-firstRow">'
+				'<td class="d-nw"></td>'
+				'<td class="d-n"></td>'
+				'<td class="d-ne"></td>'
+			'</tr>'
+			'<tr>'
+				'<td class="d-w"></td>'
+				'<td class="d-c">'
+					'<div class="d-inner">'
+					'<table class="d-dialog">'
+						'<tbody>'
+							'<tr>'
+								'<td class="d-header">'
+									'<div class="d-titleBar">'
+										'<div class="d-title"></div>'
+										'<a class="d-close">'
+											'\xd7'
+										'</a>'
+									'</div>'
+								'</td>'
+							'</tr>'
+							'<tr>'
+								'<td class="d-main">'
+									'<div class="d-content">${icon1}</div>'
+								'</td>'
+							'</tr>'
+							'<tr>'
+								'<td class="d-footer">'
+									'<div class="d-buttons"></div>'
+								'</td>'
+							'</tr>'
+						'</tbody>'
+					'</table>'
+					'</div>'
+				'</td>'
+				'<td class="d-e"></td>'
+			'</tr>'
+			'<tr>'
+				'<td class="d-sw"></td>'
+				'<td class="d-s"></td>'
+				'<td class="d-se"></td>'
+			'</tr>'
+		'</tbody>'
+	'</table>'
+'</div>';



/**
 * 默认配置
 */
artDialog.defaults = {

    // 消息内容
    content: '<div class="d-loading"><span>loading..</span></div>',
    
    // 标题
    title: 'message',
    
    // 自定义按钮
    button: null,
    
    // 确定按钮回调函数
    ok: null,
    
    // 取消按钮回调函数
    cancel: null,
    
    // 对话框初始化后执行的函数
    initialize: null,
    
    // 对话框关闭前执行的函数
    beforeunload: null,
    
    // 确定按钮文本
    okValue: 'ok',
    
    // 取消按钮文本
    cancelValue: 'cancel',
    
    // 内容宽度
    width: 'auto',
    
    // 内容高度
    height: 'auto',
    
    // 内容与边界填充距离
    padding: '20px 25px',
    
    // 皮肤名(多皮肤共存预留接口)
    skin: null,
    
    // 自动关闭时间
    time: null,
    
    // 是否支持Esc键关闭
    esc: true,
    
    // 是否支持对话框按钮自动聚焦
    focus: true,
    
    // 初始化后是否显示对话框
    visible: true,
    
    // 让对话框跟随某元素
    follow: null,
    
    // 是否锁屏
    lock: false,

    //双击遮罩关闭
    dblClose:true,

    // 是否固定定位
    fixed: true,
    
    // 对话框叠加高度值(重要：此值不能超过浏览器最大限制)
    zIndex: 10000,

    fadeOutTime:null
    
};

this.artDialog = $.dialog = $.artDialog = artDialog;
}(this.art || this.jQuery, this));

;(function ($) {

    /**
     * 输入框
     * @param   {Object}   扩展自artdialog配置，新增value:'输入框默认值'，
     * 重写ok，回传参数value
     */
    $.prompt = $.dialog.prompt = function (option) {
        option.value = option.value || '';
        var input;
        var tempfun=option.initialize||function(){};
        var tempfun1=option.ok||function(){};
        option.content=[
            '<div style="margin-bottom:5px;font-size:12px">',
            option.content,
            '</div>',
            '<div>',
            '<input type="text" class="d-input-text" value="',
            option.value,
            '" style="width:18em;padding:6px 4px" />',
            '</div>'
            ].join('');
        option.initialize=function (){
            input = this.dom.content.find('.d-input-text')[0];
            input.select();
            input.focus();
            tempfun();
        };
        option.ok=function () {
            return tempfun1.call(this, input.value);
        };
        return $.dialog(option);
    };


     /*填入url的dialog
    */
    $.urlDialog = $.dialog.url = function (option) {
    var currentDialog;
        option.url = option.url || '';
        option.callback = option.callback || function(){};
        var tempfun = option.initialize || function () { };
         option.content = [
            '<div style="margin-bottom:5px;font-size:12px">',
            "Loading...",
            '</div>'
            ].join('');
        option.initialize = function () {
            tempfun();
        };
        currentDialog=$.dialog(option);
        
        $.get(option.url,function(res){
       currentDialog.content( [
            '<div style="margin-bottom:5px;font-size:12px">',
            res,
            '</div>'
            ].join(''));
            option.callback();
        });
        return currentDialog;
    };

    /*
        带图标的提示框
     */
    $.icoDialog = $.dialog.icoDialog = function (option) {
        var template='<div class="icon_box_lq ${icon}"></div><div class="fr_lq">${content}</div>';
        var icons={
            type1:'questions_icon2_lq',
            type2:'success_icon1_lq',
            type3:'alert_icon1_lq'
        };
        var date={};
        date.icon=icons['type'+option.type]||icons.type1;
        date.content=option.content||'';
        option.value = option.value || '';
        option.content=htmlTemplate(template,date);
        option.width=300;
        
        //HTML模板替换
        function htmlTemplate(template,data){
            //替换符号为${xxx}
            return template.replace(/\$\{([_\w]+[\w\d_]+)\}/g,
                function(s,s1){
                    if(data[s1]!=null&&data[s1]!=undefined){
                        return data[s1];
                    }else{
                        return s
                    }
                });
        }
        option.padding='';
        var ico=$.dialog(option);
        $(option.closeButton).click(function(){  
            ico._click("cancel")();
        });
        return ico;

    };
    /*消息提醒提示框*/
    $.remindDialog = $.dialog.remindDialog = function (option) {
        var template='<div class="inb_lq ${icon}"></div><div class="inb_lq info">${content}</div>';
        var icons={
            ok:'ok',
            error:'error',
            warning:'warning'
        };
        var date={};
        var count=0;
        date.icon=icons[option.type]||icons.ok;
        date.content=option.content||'';
        option.value = option.value || '';
        option.padding='0px 15px';
        option.skin='remind';
        option.time=option.time||{time:1000};
        option.fadeOutTime=option.fadeOutTime||1000;
        option.content=htmlTemplate(template,date);
        var onClose=option.beforeunload;
        option.beforeunload=function(){
            var This=this;
            if(count<1){
                this.dom.wrap.fadeOut(option.fadeOutTime,function(){
                    try{
                        if(This&&This.config&&This.config.time)This.config.time=null;
                    }catch(ex){}finally{
                        count++;
                        This.close();
                    }
                });
                onClose();
                return false;
            }
        };
        //HTML模板替换
        function htmlTemplate(template,data){
            //替换符号为${xxx}
            return template.replace(/\$\{([_\w]+[\w\d_]+)\}/g,
                function(s,s1){
                    if(data[s1]!=null&&data[s1]!=undefined){
                        return data[s1];
                    }else{
                        return s;
                    }
                });
        }
        return $.dialog(option);
    };
    /** 抖动效果 */
    $.dialog.prototype.shake = (function () {

        var fx = function (ontween, onend, duration) {
            var startTime = + new Date;
            var timer = setInterval(function () {
                var runTime = + new Date - startTime;
                var pre = runTime / duration;

                if (pre >= 1) {
                    clearInterval(timer);
                    onend(pre);
                } else {
                    ontween(pre);
                };
            }, 13);
        };

        var animate = function (elem, distance, duration) {
            var quantity = arguments[3];

            if (quantity === undefined) {
                quantity = 6;
                duration = duration / quantity;
            };

            var style = elem.style;
            var from = parseInt(style.marginLeft) || 0;

            fx(function (pre) {
                elem.style.marginLeft = from + (distance - from) * pre + 'px';
            }, function () {
                if (quantity !== 0) {
                    animate(
                        elem,
                        quantity === 1 ? 0 : (distance / quantity - distance) * 1.3,
                        duration,
                        -- quantity
                    );
                };
            }, duration);
        };

        return function () {
            animate(this.dom.wrap[0], 40, 600);
            return this;
        };
    })();

    // 拖拽支持
    var DragEvent = function () {
        var that = this,
            proxy = function (name) {
                var fn = that[name];
                that[name] = function () {
                    return fn.apply(that, arguments);
                };
            };

        proxy('start');
        proxy('over');
        proxy('end');
    };


    DragEvent.prototype = {

        // 开始拖拽
        // onstart: function () {},
        start: function (event) {
            $(document)
                .bind('mousemove', this.over)
                .bind('mouseup', this.end);

            this._sClientX = event.clientX;
            this._sClientY = event.clientY;
            this.onstart(event.clientX, event.clientY);

            return false;
        },

        // 正在拖拽
        // onover: function () {},
        over: function (event) {
            this._mClientX = event.clientX;
            this._mClientY = event.clientY;
            this.onover(
                event.clientX - this._sClientX,
                event.clientY - this._sClientY
            );

            return false;
        },

        // 结束拖拽
        // onend: function () {},
        end: function (event) {
            $(document)
                .unbind('mousemove', this.over)
                .unbind('mouseup', this.end);

            this.onend(event.clientX, event.clientY);
            return false;
        }

    };

    var $window = $(window),
        $document = $(document),
        html = document.documentElement,
        isIE6 = !('minWidth' in html.style),
        isLosecapture = !isIE6 && 'onlosecapture' in html,
        isSetCapture = 'setCapture' in html,
        dragstart = function () {
            return false
        };

    var dragInit = function (event) {

        var dragEvent = new DragEvent,
            api = artDialog.focus,
            dom = api.dom,
            $wrap = dom.wrap,
            $title = dom.title,
            $main = dom.main,
            wrap = $wrap[0],
            title = $title[0],
            main = $main[0],
            wrapStyle = wrap.style,
            mainStyle = main.style;


        var isResize = event.target === dom.se[0] ? true : false;
        var isFixed = wrap.style.position === 'fixed',
            minX = isFixed ? 0 : $document.scrollLeft(),
            minY = isFixed ? 0 : $document.scrollTop(),
            maxX = $window.width() - wrap.offsetWidth + minX,
            maxY = $window.height() - wrap.offsetHeight + minY;


        var startWidth, startHeight, startLeft, startTop;


        // 对话框准备拖动
        dragEvent.onstart = function (x, y) {

            if (isResize) {
                startWidth = main.offsetWidth;
                startHeight = main.offsetHeight;
            } else {
                startLeft = wrap.offsetLeft;
                startTop = wrap.offsetTop;
            };

            $document.bind('dblclick', dragEvent.end)
                .bind('dragstart', dragstart);

            if (isLosecapture) {
                $title.bind('losecapture', dragEvent.end)
            } else {
                $window.bind('blur', dragEvent.end)
            };

            isSetCapture && title.setCapture();

            $wrap.addClass('d-state-drag');
            api.focus();
        };

        // 对话框拖动进行中
        dragEvent.onover = function (x, y) {

            if (isResize) {
                var width = x + startWidth,
                    height = y + startHeight;

                wrapStyle.width = 'auto';
                mainStyle.width = Math.max(0, width) + 'px';
                wrapStyle.width = wrap.offsetWidth + 'px';

                mainStyle.height = Math.max(0, height) + 'px';

            } else {
                var left = Math.max(minX, Math.min(maxX, x + startLeft)),
                    top = Math.max(minY, Math.min(maxY, y + startTop));

                wrapStyle.left = left  + 'px';
                wrapStyle.top = top + 'px';
            };


        };

        // 对话框拖动结束
        dragEvent.onend = function (x, y) {

            $document.unbind('dblclick', dragEvent.end)
                .unbind('dragstart', dragstart);

            if (isLosecapture) {
                $title.unbind('losecapture', dragEvent.end);
            } else {
                $window.unbind('blur', dragEvent.end)
            };

            isSetCapture && title.releaseCapture();

            $wrap.removeClass('d-state-drag');
        };


        dragEvent.start(event);

    };


// 代理 mousedown 事件触发对话框拖动
    $(document).bind('mousedown', function (event) {
        
        var api = artDialog.focus;
        if (!api) return;

        var target = event.target,
            config = api.config,
            dom = api.dom;

        if (config.drag !== false && target === dom.title[0]
            || config.resize !== false && target === dom.se[0]) {
            dragInit(event);

            // 防止firefox与chrome滚屏
            return false;
        };
    });


}(this.art || this.jQuery));

/* 更新记录

1.  follow 不再支持 String 类型
2.  button 参数只支持 Array 类型
3.  button name 成员改成 value
4.  button 增加 id 成员
5.  okVal 参数更名为 okValue, 默认值由 '确定' 改为 'ok'
6.  cancelVal 参数更名为 cancelValue, 默认值由 '取消' 改为 'cancel'
6.  close 参数更名为 beforeunload
7.  init 参数更名为 initialize
8.  title 参数默认值由 '消息' 改为 'message'
9.  time 参数与方法参数单位由秒改为毫秒
10. hide 参数方法更名为 hidden
11. 内部为皮肤增加动态样式 d-state-visible 类
12. 给遮罩增添样式 d-mask 类
13. background 参数被取消, 由 CSS 文件定义
14. opacity 参数被取消, 由 CSS 文件定义
15. 取消拖动特性，改由插件支持
16. 取消 left 与 top 参数
17. 取消对 ie6 提供 fixed 支持，自动转换为 absolute
18. 取消对 ie6 提供 alpha png 支持
19. 取消对 ie6 提供 select 标签遮盖支持
20. 增加 focus 参数
21. 取消 position 方法
22. 取消对 <script type="text/dialog"></script> 的支持
23. 取消对 iframe 的支持
24. title 方法不支持空参数
25. content 方法不支持空参数
26. button 方法的参数不支持数组类型
27. 判断 DOCTYPE, 对 xhtml1.0 以下的页面报告错误
28. 修复 IE8 动态等新内容时没有撑开对话框高度，特意为 ie8 取消 .d-content { display:inline-block }
29. show 参数与方法更名为 visible
30. 修正重复调用 close 方法出现的错误

*/


/**
弹出菜单
 by:kule
 */
(function($){
$.fn.popMenu=function(setting,arg){
    if(typeof setting=='string')return runDatafun(setting,this,arg);
    var options={id:(new Date()).getTime(),
        title:null,
        width:null,
        btns:[],
        jqCont:$('body'),
        offset:{left:0,top:0},//用户自定义偏移值
        onopen:$.noop,
        onopened:$.noop,
        onclose:$.noop
    };
    $.extend(options,setting);
    if(arg)options.jqCont.append($(initHTML()));
    var This=$('#'+options.id);
    if(options.width)This.css({width:options.width+'px'});
    //注册弹出事件
    this.bind('click',btnClick);
    //事件注册
    This.delegate('a','click',aClick);
    //按钮事件处理
    function btnClick(e){
        e.stopPropagation();
        if(This.data('srcBtnObj')==this&&!This.hasClass('hidden1_lq')){
            return;
        }
        This.data('srcBtnObj',this);//存入触发按钮
        if(!This.hasClass('hidden1_lq'))close(This);//先关闭，在打开
        pop(This,this);//e.target不一定都等于this,有可能是this的子元素
    }
    //popMenu中的a标签事件处理
    function aClick(){
        var i=$(this).parent().find('a').index(this)+1;
        if(options.btn0){
            options.btn0(i,this,This.data('srcBtnObj'));
        }else{
            options['btn'+i]&&options['btn'+i](i,this,This.data('srcBtnObj'));
        }
        close(This);
    }
    //document动态注册
    function bindDoc(e){
        close(This);
    }
    //弹出popMenu
    function pop(This,obj){
        var jqobj=$(obj),
            offset=jqobj.offset(),
            client={},
            popOffset={},
            jqParent=This.parent();
       //查找第一个非static定位父级
        while(jqParent.css('position')=='static'){
            if(jqParent[0].tagName.toLowerCase()=='body')break;
            jqParent=jqParent.parent();
        }
        jqParent.oft=jqParent.offset();
        //矫正弹出位置，防止出现在窗口之外
        offset.outHeight=jqobj.outerHeight();
        offset.outWidth=jqobj.outerWidth();
        client.height=document.documentElement.clientHeight;
        client.width=document.documentElement.clientWidth;
        popOffset.height=This.outerHeight();
        popOffset.width=This.outerWidth();
        popOffset.top=client.height-offset.top-offset.outHeight-options.offset.top>popOffset.height?
            offset.top+offset.outHeight+options.offset.top:
            offset.top-popOffset.height;
        popOffset.left=client.width-offset.left-options.offset.left>popOffset.width?
            offset.left+options.offset.left:
            offset.left-(popOffset.width-offset.outWidth);
        $(document).bind('click',bindDoc);
        options.onopen(jqobj[0]);
        This.css({top:Math.floor(popOffset.top-jqParent.oft.top),left:Math.floor(popOffset.left-jqParent.oft.left)})
            .removeClass('hidden1_lq');
        options.onopened(jqobj[0]);
    }
    //打开弹框
    function open(obj){
        pop(This,obj);
    }
    //关闭弹框
    function close(This){
        if(This.data('autoClose')=='false')return;
        This.addClass('hidden1_lq');
        $(document).unbind('click',bindDoc);
        options.onclose(This.data('srcBtnObj'));
    }
    //填充HTML
    function initHTML(){
        options.repeat1=[];
        for(var i=0;i<options.btns.length;i++){
            options.repeat1.push('<a>',options.btns[i],'</a>');
        }
        options.repeat1=options.repeat1.join('');
        options.title=options.title!=null?['<div class="menu_title_lq">',options.title,'</div>'].join(''):'';
        options.width=options.width!=null?['width:',options.width,'px'].join(''):'';
        var tempstr='<div id="${id}" class="pop_menu1_lq hidden1_lq" style="${width};">${title}${repeat1}</div>';
        return tempstr.replace(/\$\{([_\w]+[\w\d_]+)\}/g,function(s,s1){return options[s1]});
    }
    //扩展方法
    $.fn.addPopMenu=function(selector){
        var This=$(selector);
        this.unbind('click',btnClick).bind('click',btnClick);
    };
    $.fn.removePopMenu=function(selector){
        var This=$(selector);
        this.unbind('click',btnClick);
    };
    $.fn.destoryPopMenu=function(){
        this.undelegate('a','click',aClick);
    };
    this.data('close',close).data('open',open);
    this.popM=This;
    return this;
};
    function runDatafun(key,jqObj,arg){
        if(typeof jqObj.data(key)=='function'){
            return jqObj.data(key)(arg);
        }
        return null;
    }
})(jQuery);
/**
模拟select
继承自jquery.pop.menu
 by:kule
 */
;(function($){
    $.fn.popSelect=function(setting,init){
        var options={
            offset:{top:-1,left:0},
            width:'auto'
        };
        $.extend(options,setting);
        var This;
        if(this[0].tagName.toLowerCase()=='select'){
            options.width=options.width=='auto'?'auto':this.outerWidth();
            this.addClass('hidden1_lq');
            This=$(['<div class="pop_select1_lq ',this[0].className,'"><input type="text" value="',$('option:selected',this).text(),'" /><span class="blue_select_icon_lf"></span></div>'].join(''))
                .insertAfter(this);
            var vals=[];
            options.btns=$('option',this).map(function(){
                var jqObj=$(this);
                vals.push(jqObj.val());
                return jqObj.text()}).get();
            options.btn0=function(i,aObj,btn){
                $(btn).find('input').attr('value',toolLq.charTran(aObj.innerHTML)).attr('val',vals[i-1])
                    .end().prev('select')[0].selectedIndex=i-1;
                setting&&typeof setting.btn0=='function'&&setting.btn0(i,aObj,btn);
            };
            options.jqCont=This.parent();
            init=true;
        }else{
            This=this.parent();
            if(This.hasClass('pop_select1_lq')<1){
                This=this.wrap('<div class="pop_select1_lq"></div>')
                    .parent().append('<span class="blue_select_icon_lf"></span>');
            }
            options.btn0=function(i,aObj,btn){
                $(btn).find('input').val(toolLq.charTran(aObj.innerHTML));
                setting&&typeof setting.btn0=='function'&&setting.btn0(i,aObj,btn);
            };
        }
        if(options.width){
            This.css({width:options.width+'px'})
                .find('input').attr('readonly','readonly')
                .css({width:options.width-2+'px'});
        }
        $.fn.popSelectAddItem=function(option){
            var jqObj;
            try{
                this[0].add($(option)[0],null);
            }catch(ex){

                this[0].add($(option)[0]);
            }
            jqObj=this.find('option:last');
            vals.push(jqObj.val());
            This.popM.append(['<a>',jqObj.text(),'</a>'].join(''));
            return This;
        };
        $.fn.popSelectRemoveItem=function(i){
            var jqObj=This.popM.find('a');
            var jqInp=This.find('input');
            if(jqInp.val()==jqObj.eq(i).text()){
                jqInp.val(toolLq.charTran(jqObj.eq(i-1).text()))
                    .attr('val',vals[i-1]);
            }
            this[0].remove(i);
            jqObj.eq(i).remove();
            vals.splice(i,1);
            jqObj=jqInp=null;
            return This;
        };
        $.fn.popSelectChoose=function(i){
            var jqObj=This.popM.find('a');
            var jqInp=This.find('input');
            i=jqObj.length<i?jqObj.length:i;
            jqInp.val(toolLq.charTran(jqObj.eq(i).text()))
                .attr('val',vals[i]);
            this[0].selectedIndex=i;
            jqObj=jqInp=null;
            return This;
        };
        This.popM=This.popMenu(options,init).popM;
        return This;
    }
})(jQuery);
/*!
 * Tiny Scrollbar 1.67
 * http://www.baijs.nl/tinyscrollbar/
 * Copyright 2012, Maarten Baijs
 * Date: 11 / 05 / 2012
 * Depends on library: jQuery
 * kule修改，2012-06-05
 */
(function ($) {
    $.tiny = $.tiny || {};
    //这么写的作用是什么？省去get?方便读取配置？
    $.tiny.scrollbar = {
        options: {
            axis: 'y', // vertical or horizontal scrollbar? ( x || y ).
            wheel: 40,  //how many pixels must the mouswheel scroll at a time.
            scroll: true, //enable or disable the mousewheel.
            lockscroll: true, //return scrollwheel to browser if there is no more content.
            size: 'auto', //set the size of the scrollbar to auto or a fixed number.
            sizethumb: 'auto', //set the size of the thumb to auto or a fixed number.
            limitHeight: '100', //限制内容长度，即内容超过多少高度时会出现滚动条
            scrollWidth: '6', //滚动条宽度
            content: null, //执行wrapAll的jquery筛选器
            triggerBtm: null,
            freeLength:null,
            onbottom: function () { }
        }
    };

    $.fn.tinyscrollbar = function (options, init) {
        options = $.extend({}, $.tiny.scrollbar.options, options);
        if (init) initHTML(this);
        this.addClass('scroll_bar1_lq');
        //使用this实现多选择器插件
        this.each(function () { $(this).data('tsb', new Scrollbar($(this), options)); });
        return this; //保持jquery链不断裂
        //填充HTML
        function initHTML(jqObj) {
            var jqWrapper=options.content?$(options.content):$('*',jqObj);
            if(jqWrapper.length<1){
                jqObj.append('<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div><div class="viewport"><div class="overview"></div></div>');
            }else{
                jqWrapper.wrapAll('<div class="viewport"><div class="overview"></div></div>')
                    .parents('.viewport').before('<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>');
            }
        }
    };
    //分离出更新方法，巧妙的对象存储在标签的data中
    $.fn.tinyscrollbar_update = function (sScroll, expand, tWidth) { return $(this).data('tsb').update(sScroll, expand, tWidth); };
    $.fn.tinyscrollbar_btnScroll = function (delta, animate, speed) { return $(this).data('tsb').btnScroll(delta, animate, speed) };

    //真正的ScrollBar类
    function Scrollbar(root, options) {
        var oSelf = this;
        var oWrapper = root;
        var oViewport = { obj: $('.viewport', root) };
        var oContent = { obj: $('.overview', root) };
        var oScrollbar = { obj: $('.scrollbar', root) };
        var oTrack = { obj: $('.track', oScrollbar.obj) };
        var oThumb = { obj: $('.thumb', oScrollbar.obj) };
        var oEnd = { obj: $('.end', oScrollbar.obj) };
        var sAxis = options.axis == 'x', sDirection = sAxis ? 'left' : 'top', sSize = sAxis ? 'Width' : 'Height';
        var iScroll, iPosition = { start: 0, now: 0 }, iMouse = {};

        function initialize() {
            oSelf.update();
            setEvents();
            return oSelf;
        }
        this.update = function (sScroll, expand, tWidth) {
            if (sAxis && tWidth) oContent.obj.css('width', tWidth);
            if (sAxis && expand) oContent.obj.css('width', oContent.obj.outerWidth() + expand);
            oViewport[options.axis] = options.limitHeight;
            oContent[options.axis] = oContent.obj[0]['scroll' + sSize];
            oContent.ratio = oViewport[options.axis] / oContent[options.axis];
            //            oViewport.width=oContent.ratio >= 1?(oContent.obj.outerWidth()-0):(oContent.obj.outerWidth()-0)+(options.scrollWidth-0);
            oScrollbar.obj.toggleClass('disable', oContent.ratio >= 1);
            oTrack[options.axis] = options.size == 'auto' ? oViewport[options.axis] : options.size;
            oThumb[options.axis] = Math.min(oTrack[options.axis], Math.max(0, (options.sizethumb == 'auto' ? (oTrack[options.axis] * oContent.ratio) : options.sizethumb)));
            oScrollbar.ratio = options.sizethumb == 'auto' ? (oContent[options.axis] / oTrack[options.axis]) : (oContent[options.axis] - oViewport[options.axis]) / (oTrack[options.axis] - oThumb[options.axis]);
            iScroll = (sScroll == 'relative' && oContent.ratio <= 1) ? Math.min((oContent[options.axis] - oViewport[options.axis]), Math.max(0, iScroll)) : 0;
            iScroll = (sScroll == 'bottom' && oContent.ratio <= 1) ? (oContent[options.axis] - oViewport[options.axis]) : isNaN(parseInt(sScroll)) ? iScroll : oContent.ratio >= 1 ? 0 : parseInt(sScroll);
            setSize();
        };
        function setSize() {
            //            oWrapper.css({width:oViewport.width});//用户定义宽度
            oThumb.obj.css(sDirection, iScroll / oScrollbar.ratio);
            oContent.obj.css(sDirection, -iScroll);
            iMouse['start'] = oThumb.obj.offset()[sDirection];
            var sCssSize = sSize.toLowerCase();
            oScrollbar.obj.css(sCssSize, oTrack[options.axis]);
            oTrack.obj.css(sCssSize, oTrack[options.axis]);
            oThumb.obj.css(sCssSize, oThumb[options.axis]);
            oViewport.obj.css({ height: options.limitHeight, width:options.freeLength||oContent.obj.outerWidth() });
            oEnd.obj.css(sAxis ? 'height' : 'width', options.scrollWidth);
            if (sAxis) {
                oViewport.obj.css({ width: options.limitHeight, height:options.freeLength||oContent.obj.outerHeight() });
            } else {
                oScrollbar.margin = oViewport.obj.position();
                oScrollbar.obj.css({ marginTop: oScrollbar.margin.top });
            }
        }
        function setEvents() {
            oThumb.obj.bind('mousedown', start);
            oThumb.obj[0].ontouchstart = function (oEvent) {
                oEvent.preventDefault();
                oThumb.obj.unbind('mousedown');
                start(oEvent.touches[0]); //多点触控转成单点
                return false;
            };
            oTrack.obj.bind('mouseup', drag);
            if (options.scroll && this.addEventListener) {
                oWrapper[0].addEventListener('DOMMouseScroll', wheel, false);
                oWrapper[0].addEventListener('mousewheel', wheel, false);
            }
            else if (options.scroll) { oWrapper[0].onmousewheel = wheel; }
        }
        //新理念，需要document事件支持的操作，在事件触发时注册docuemnt，在处理结束后释放注销掉document绑定
        function start(oEvent) {
            iMouse.start = sAxis ? oEvent.pageX : oEvent.pageY;
            var oThumbDir = parseInt(oThumb.obj.css(sDirection));
            iPosition.start = oThumbDir == 'auto' ? 0 : oThumbDir;
            $(document).bind('mousemove', drag);
            document.ontouchmove = function (oEvent) {
                $(document).unbind('mousemove');
                drag(oEvent.touches[0]);
            };
            $(document).bind('mouseup', end);
            oThumb.obj.bind('mouseup', end);
            oThumb.obj[0].ontouchend = document.ontouchend = function (oEvent) {
                $(document).unbind('mouseup');
                oThumb.obj.unbind('mouseup');
                end(oEvent.touches[0]);
            };
            return false;
        }
        function wheel(oEvent) {
            if (!(oContent.ratio >= 1)) {
                oEvent = oEvent || window.event;
                var iDelta = oEvent.wheelDelta ? oEvent.wheelDelta / 120 : -oEvent.detail / 3;
                iScroll -= iDelta * options.wheel;
                iScroll = Math.min((oContent[options.axis] - oViewport[options.axis]), Math.max(0, iScroll));
                oThumb.obj.css(sDirection, iScroll / oScrollbar.ratio);
                oContent.obj.css(sDirection, -iScroll);
                if (options.lockscroll || (iScroll !== (oContent[options.axis] - oViewport[options.axis]) && iScroll !== 0)) {
                    oEvent = $.event.fix(oEvent);
                    oEvent.preventDefault();
                }
                detectBottom(iScroll, oEvent);
            }
        }
        function end(oEvent) {
            $(document).unbind('mousemove', drag);
            $(document).unbind('mouseup', end);
            oThumb.obj.unbind('mouseup', end);
            document.ontouchmove = oThumb.obj[0].ontouchend = document.ontouchend = null;
            return false;
        }
        function drag(oEvent) {
            if (!(oContent.ratio >= 1)) {
                iPosition.now = Math.min((oTrack[options.axis] - oThumb[options.axis]), Math.max(0, (iPosition.start + ((sAxis ? oEvent.pageX : oEvent.pageY) - iMouse.start))));
                iScroll = iPosition.now * oScrollbar.ratio;
                detectBottom(iScroll, oEvent);
                oContent.obj.css(sDirection, -iScroll);
                oThumb.obj.css(sDirection, iPosition.now);
            }
            return false;
        }
        function detectBottom(iScroll, oEvent) {
            if (!options.triggerBtm || oContent.ratio >= 1) return;
            if (oContent[options.axis] - iScroll - oViewport[options.axis] < options.triggerBtm) options.onbottom(oContent.obj, iScroll, oEvent);
        }
        this.btnScroll = function (delta, animate, speed) {
            if (oContent.ratio >= 1) return;
            iScroll = Math.min((oContent[options.axis] - oViewport[options.axis]), Math.max(0, iScroll + delta));
            var param1 = {}, param2 = {};
            param1[sDirection] = -iScroll;
            param2[sDirection] = iScroll / oScrollbar.ratio;
            switch (animate) {
                case 'liner':
                    oContent.obj.animate(param1, speed);
                    oThumb.obj.animate(param2, speed, function () {
                        detectBottom(iScroll, null);
                    });
                    break;
                default:
                    oThumb.obj.css(sDirection, iScroll / oScrollbar.ratio);
                    oContent.obj.css(sDirection, -iScroll);
                    detectBottom(iScroll, null);
            }
        };
        return initialize();
    }
})(jQuery);
/*!
 * jQuery UI @VERSION
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI
 */
(function( $, undefined ) {

var uuid = 0,
	runiqueId = /^ui-id-\d+$/;

// prevent duplicate loading
// this is only a problem because we proxy existing functions
// and we don't want to double proxy them
$.ui = $.ui || {};
if ( $.ui.version ) {
	return;
}

$.extend( $.ui, {
	version: "@VERSION",

	keyCode: {
		BACKSPACE: 8,
		COMMA: 188,
		DELETE: 46,
		DOWN: 40,
		END: 35,
		ENTER: 13,
		ESCAPE: 27,
		HOME: 36,
		LEFT: 37,
		NUMPAD_ADD: 107,
		NUMPAD_DECIMAL: 110,
		NUMPAD_DIVIDE: 111,
		NUMPAD_ENTER: 108,
		NUMPAD_MULTIPLY: 106,
		NUMPAD_SUBTRACT: 109,
		PAGE_DOWN: 34,
		PAGE_UP: 33,
		PERIOD: 190,
		RIGHT: 39,
		SPACE: 32,
		TAB: 9,
		UP: 38
	}
});

// plugins
$.fn.extend({
	_focus: $.fn.focus,
	focus: function( delay, fn ) {
		return typeof delay === "number" ?
			this.each(function() {
				var elem = this;
				setTimeout(function() {
					$( elem ).focus();
					if ( fn ) {
						fn.call( elem );
					}
				}, delay );
			}) :
			this._focus.apply( this, arguments );
	},

	scrollParent: function() {
		var scrollParent;
		if (($.browser.msie && (/(static|relative)/).test(this.css('position'))) || (/absolute/).test(this.css('position'))) {
			scrollParent = this.parents().filter(function() {
				return (/(relative|absolute|fixed)/).test($.css(this,'position')) && (/(auto|scroll)/).test($.css(this,'overflow')+$.css(this,'overflow-y')+$.css(this,'overflow-x'));
			}).eq(0);
		} else {
			scrollParent = this.parents().filter(function() {
				return (/(auto|scroll)/).test($.css(this,'overflow')+$.css(this,'overflow-y')+$.css(this,'overflow-x'));
			}).eq(0);
		}

		return (/fixed/).test(this.css('position')) || !scrollParent.length ? $(document) : scrollParent;
	},

	zIndex: function( zIndex ) {
		if ( zIndex !== undefined ) {
			return this.css( "zIndex", zIndex );
		}

		if ( this.length ) {
			var elem = $( this[ 0 ] ), position, value;
			while ( elem.length && elem[ 0 ] !== document ) {
				// Ignore z-index if position is set to a value where z-index is ignored by the browser
				// This makes behavior of this function consistent across browsers
				// WebKit always returns auto if the element is positioned
				position = elem.css( "position" );
				if ( position === "absolute" || position === "relative" || position === "fixed" ) {
					// IE returns 0 when zIndex is not specified
					// other browsers return a string
					// we ignore the case of nested elements with an explicit value of 0
					// <div style="z-index: -10;"><div style="z-index: 0;"></div></div>
					value = parseInt( elem.css( "zIndex" ), 10 );
					if ( !isNaN( value ) && value !== 0 ) {
						return value;
					}
				}
				elem = elem.parent();
			}
		}

		return 0;
	},

	uniqueId: function() {
		return this.each(function() {
			if ( !this.id ) {
				this.id = "ui-id-" + (++uuid);
			}
		});
	},

	removeUniqueId: function() {
		return this.each(function() {
			if ( runiqueId.test( this.id ) ) {
				$( this ).removeAttr( "id" );
			}
		});
	},

	disableSelection: function() {
		return this.bind( ( $.support.selectstart ? "selectstart" : "mousedown" ) +
			".ui-disableSelection", function( event ) {
				event.preventDefault();
			});
	},

	enableSelection: function() {
		return this.unbind( ".ui-disableSelection" );
	}
});

// support: jQuery <1.8
if ( !$( "<a>" ).outerWidth( 1 ).jquery ) {
	$.each( [ "Width", "Height" ], function( i, name ) {
		var side = name === "Width" ? [ "Left", "Right" ] : [ "Top", "Bottom" ],
			type = name.toLowerCase(),
			orig = {
				innerWidth: $.fn.innerWidth,
				innerHeight: $.fn.innerHeight,
				outerWidth: $.fn.outerWidth,
				outerHeight: $.fn.outerHeight
			};

		function reduce( elem, size, border, margin ) {
			$.each( side, function() {
				size -= parseFloat( $.css( elem, "padding" + this ) ) || 0;
				if ( border ) {
					size -= parseFloat( $.css( elem, "border" + this + "Width" ) ) || 0;
				}
				if ( margin ) {
					size -= parseFloat( $.css( elem, "margin" + this ) ) || 0;
				}
			});
			return size;
		}

		$.fn[ "inner" + name ] = function( size ) {
			if ( size === undefined ) {
				return orig[ "inner" + name ].call( this );
			}

			return this.each(function() {
				$( this ).css( type, reduce( this, size ) + "px" );
			});
		};

		$.fn[ "outer" + name] = function( size, margin ) {
			if ( typeof size !== "number" ) {
				return orig[ "outer" + name ].call( this, size );
			}

			return this.each(function() {
				$( this).css( type, reduce( this, size, true, margin ) + "px" );
			});
		};
	});
}

// selectors
function focusable( element, isTabIndexNotNaN ) {
	var map, mapName, img,
		nodeName = element.nodeName.toLowerCase();
	if ( "area" === nodeName ) {
		map = element.parentNode;
		mapName = map.name;
		if ( !element.href || !mapName || map.nodeName.toLowerCase() !== "map" ) {
			return false;
		}
		img = $( "img[usemap=#" + mapName + "]" )[0];
		return !!img && visible( img );
	}
	return ( /input|select|textarea|button|object/.test( nodeName ) ?
		!element.disabled :
		"a" === nodeName ?
			element.href || isTabIndexNotNaN :
			isTabIndexNotNaN) &&
		// the element and all of its ancestors must be visible
		visible( element );
}

function visible( element ) {
	return !$( element ).parents().andSelf().filter(function() {
		return $.css( this, "visibility" ) === "hidden" ||
			$.expr.filters.hidden( this );
	}).length;
}

$.extend( $.expr[ ":" ], {
	data: function( elem, i, match ) {
		return !!$.data( elem, match[ 3 ] );
	},

	focusable: function( element ) {
		return focusable( element, !isNaN( $.attr( element, "tabindex" ) ) );
	},

	tabbable: function( element ) {
		var tabIndex = $.attr( element, "tabindex" ),
			isTabIndexNaN = isNaN( tabIndex );
		return ( isTabIndexNaN || tabIndex >= 0 ) && focusable( element, !isTabIndexNaN );
	}
});

// support
$(function() {
	var body = document.body,
		div = body.appendChild( div = document.createElement( "div" ) );

	// access offsetHeight before setting the style to prevent a layout bug
	// in IE 9 which causes the element to continue to take up space even
	// after it is removed from the DOM (#8026)
	div.offsetHeight;

	$.extend( div.style, {
		minHeight: "100px",
		height: "auto",
		padding: 0,
		borderWidth: 0
	});

	$.support.minHeight = div.offsetHeight === 100;
	$.support.selectstart = "onselectstart" in div;

	// set display to none to avoid a layout bug in IE
	// http://dev.jquery.com/ticket/4014
	body.removeChild( div ).style.display = "none";
});





// deprecated
$.extend( $.ui, {
	// $.ui.plugin is deprecated.  Use the proxy pattern instead.
	plugin: {
		add: function( module, option, set ) {
			var i,
				proto = $.ui[ module ].prototype;
			for ( i in set ) {
				proto.plugins[ i ] = proto.plugins[ i ] || [];
				proto.plugins[ i ].push( [ option, set[ i ] ] );
			}
		},
		call: function( instance, name, args ) {
			var i,
				set = instance.plugins[ name ];
			if ( !set || !instance.element[ 0 ].parentNode || instance.element[ 0 ].parentNode.nodeType === 11 ) {
				return;
			}
	
			for ( i = 0; i < set.length; i++ ) {
				if ( instance.options[ set[ i ][ 0 ] ] ) {
					set[ i ][ 1 ].apply( instance.element, args );
				}
			}
		}
	},
	
	contains: $.contains,
	
	// only used by resizable
	hasScroll: function( el, a ) {
	
		//If overflow is hidden, the element might have extra content, but the user wants to hide it
		if ( $( el ).css( "overflow" ) === "hidden") {
			return false;
		}
	
		var scroll = ( a && a === "left" ) ? "scrollLeft" : "scrollTop",
			has = false;
	
		if ( el[ scroll ] > 0 ) {
			return true;
		}
	
		// TODO: determine which cases actually cause this to happen
		// if the element doesn't have the scroll set, see if it's possible to
		// set the scroll
		el[ scroll ] = 1;
		has = ( el[ scroll ] > 0 );
		el[ scroll ] = 0;
		return has;
	},
	
	// these are odd functions, fix the API or move into individual plugins
	isOverAxis: function( x, reference, size ) {
		//Determines when x coordinate is over "b" element axis
		return ( x > reference ) && ( x < ( reference + size ) );
	},
	isOver: function( y, x, top, left, height, width ) {
		//Determines when x, y coordinates is over "b" element
		return $.ui.isOverAxis( y, top, height ) && $.ui.isOverAxis( x, left, width );
	}
});

})( jQuery );

/*!
 * jQuery UI Widget @VERSION
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Widget
 */
(function( $, undefined ) {

var slice = Array.prototype.slice,
	_cleanData = $.cleanData;
$.cleanData = function( elems ) {
	for ( var i = 0, elem; (elem = elems[i]) != null; i++ ) {
		try {
			$( elem ).triggerHandler( "remove" );
		// http://bugs.jquery.com/ticket/8235
		} catch( e ) {}
	}
	_cleanData( elems );
};

$.widget = function( name, base, prototype ) {
	var fullName, existingConstructor, constructor, basePrototype,
		namespace = name.split( "." )[ 0 ];

	name = name.split( "." )[ 1 ];
	fullName = namespace + "-" + name;

	if ( !prototype ) {
		prototype = base;
		base = $.Widget;
	}

	// create selector for plugin
	$.expr[ ":" ][ fullName ] = function( elem ) {
		return !!$.data( elem, fullName );
	};

	$[ namespace ] = $[ namespace ] || {};
	existingConstructor = $[ namespace ][ name ];
	constructor = $[ namespace ][ name ] = function( options, element ) {
		// allow instantiation without "new" keyword
		if ( !this._createWidget ) {
			return new constructor( options, element );
		}

		// allow instantiation without initializing for simple inheritance
		// must use "new" keyword (the code above always passes args)
		if ( arguments.length ) {
			this._createWidget( options, element );
		}
	};
	// extend with the existing constructor to carry over any static properties
	$.extend( constructor, existingConstructor, {
		version: prototype.version,
		// copy the object used to create the prototype in case we need to
		// redefine the widget later
		_proto: $.extend( {}, prototype ),
		// track widgets that inherit from this widget in case this widget is
		// redefined after a widget inherits from it
		_childConstructors: []
	});

	basePrototype = new base();
	// we need to make the options hash a property directly on the new instance
	// otherwise we'll modify the options hash on the prototype that we're
	// inheriting from
	basePrototype.options = $.widget.extend( {}, basePrototype.options );
	$.each( prototype, function( prop, value ) {
		if ( $.isFunction( value ) ) {
			prototype[ prop ] = (function() {
				var _super = function() {
						return base.prototype[ prop ].apply( this, arguments );
					},
					_superApply = function( args ) {
						return base.prototype[ prop ].apply( this, args );
					};
				return function() {
					var __super = this._super,
						__superApply = this._superApply,
						returnValue;

					this._super = _super;
					this._superApply = _superApply;

					returnValue = value.apply( this, arguments );

					this._super = __super;
					this._superApply = __superApply;

					return returnValue;
				};
			})();
		}
	});
	constructor.prototype = $.widget.extend( basePrototype, {
		// TODO: remove support for widgetEventPrefix
		// always use the name + a colon as the prefix, e.g., draggable:start
		// don't prefix for widgets that aren't DOM-based
		widgetEventPrefix: name
	}, prototype, {
		constructor: constructor,
		namespace: namespace,
		widgetName: name,
		// TODO remove widgetBaseClass, see #8155
		widgetBaseClass: fullName,
		widgetFullName: fullName
	});

	// If this widget is being redefined then we need to find all widgets that
	// are inheriting from it and redefine all of them so that they inherit from
	// the new version of this widget. We're essentially trying to replace one
	// level in the prototype chain.
	if ( existingConstructor ) {
		$.each( existingConstructor._childConstructors, function( i, child ) {
			var childPrototype = child.prototype;

			// redefine the child widget using the same prototype that was
			// originally used, but inherit from the new version of the base
			$.widget( childPrototype.namespace + "." + childPrototype.widgetName, constructor, child._proto );
		});
		// remove the list of existing child constructors from the old constructor
		// so the old child constructors can be garbage collected
		delete existingConstructor._childConstructors;
	} else {
		base._childConstructors.push( constructor );
	}

	$.widget.bridge( name, constructor );
};

$.widget.extend = function( target ) {
	var input = slice.call( arguments, 1 ),
		inputIndex = 0,
		inputLength = input.length,
		key,
		value;
	for ( ; inputIndex < inputLength; inputIndex++ ) {
		for ( key in input[ inputIndex ] ) {
			value = input[ inputIndex ][ key ];
			if (input[ inputIndex ].hasOwnProperty( key ) && value !== undefined ) {
				target[ key ] = $.isPlainObject( value ) ? $.widget.extend( {}, target[ key ], value ) : value;
			}
		}
	}
	return target;
};

$.widget.bridge = function( name, object ) {
	var fullName = object.prototype.widgetFullName;
	$.fn[ name ] = function( options ) {
		var isMethodCall = typeof options === "string",
			args = slice.call( arguments, 1 ),
			returnValue = this;

		// allow multiple hashes to be passed on init
		options = !isMethodCall && args.length ?
			$.widget.extend.apply( null, [ options ].concat(args) ) :
			options;

		if ( isMethodCall ) {
			this.each(function() {
				var methodValue,
					instance = $.data( this, fullName );
				if ( !instance ) {
					return $.error( "cannot call methods on " + name + " prior to initialization; " +
						"attempted to call method '" + options + "'" );
				}
				if ( !$.isFunction( instance[options] ) || options.charAt( 0 ) === "_" ) {
					return $.error( "no such method '" + options + "' for " + name + " widget instance" );
				}
				methodValue = instance[ options ].apply( instance, args );
				if ( methodValue !== instance && methodValue !== undefined ) {
					returnValue = methodValue && methodValue.jquery ?
						returnValue.pushStack( methodValue.get() ) :
						methodValue;
					return false;
				}
			});
		} else {
			this.each(function() {
				var instance = $.data( this, fullName );
				if ( instance ) {
					instance.option( options || {} )._init();
				} else {
					new object( options, this );
				}
			});
		}

		return returnValue;
	};
};

$.Widget = function( options, element ) {};
$.Widget._childConstructors = [];

$.Widget.prototype = {
	widgetName: "widget",
	widgetEventPrefix: "",
	defaultElement: "<div>",
	options: {
		disabled: false,

		// callbacks
		create: null
	},
	_createWidget: function( options, element ) {
		element = $( element || this.defaultElement || this )[ 0 ];
		this.element = $( element );
		this.options = $.widget.extend( {},
			this.options,
			this._getCreateOptions(),
			options );

		this.bindings = $();
		this.hoverable = $();
		this.focusable = $();

		if ( element !== this ) {
			// 1.9 BC for #7810
			// TODO remove dual storage
			$.data( element, this.widgetName, this );
			$.data( element, this.widgetFullName, this );
			this._bind({ remove: "destroy" });
			this.document = $( element.style ?
				// element within the document
				element.ownerDocument :
				// element is window or document
				element.document || element );
			this.window = $( this.document[0].defaultView || this.document[0].parentWindow );
		}

		this._create();
		this._trigger( "create", null, this._getCreateEventData() );
		this._init();
	},
	_getCreateOptions: $.noop,
	_getCreateEventData: $.noop,
	_create: $.noop,
	_init: $.noop,

	destroy: function() {
		this._destroy();
		// we can probably remove the unbind calls in 2.0
		// all event bindings should go through this._bind()
		this.element
			.unbind( "." + this.widgetName )
			// 1.9 BC for #7810
			// TODO remove dual storage
			.removeData( this.widgetName )
			.removeData( this.widgetFullName );
		this.widget()
			.unbind( "." + this.widgetName )
			.removeAttr( "aria-disabled" )
			.removeClass(
				this.widgetFullName + "-disabled " +
				"ui-state-disabled" );

		// clean up events and states
		this.bindings.unbind( "." + this.widgetName );
		this.hoverable.removeClass( "ui-state-hover" );
		this.focusable.removeClass( "ui-state-focus" );
	},
	_destroy: $.noop,

	widget: function() {
		return this.element;
	},

	option: function( key, value ) {
		var options = key,
			parts,
			curOption,
			i;

		if ( arguments.length === 0 ) {
			// don't return a reference to the internal hash
			return $.widget.extend( {}, this.options );
		}

		if ( typeof key === "string" ) {
			// handle nested keys, e.g., "foo.bar" => { foo: { bar: ___ } }
			options = {};
			parts = key.split( "." );
			key = parts.shift();
			if ( parts.length ) {
				curOption = options[ key ] = $.widget.extend( {}, this.options[ key ] );
				for ( i = 0; i < parts.length - 1; i++ ) {
					curOption[ parts[ i ] ] = curOption[ parts[ i ] ] || {};
					curOption = curOption[ parts[ i ] ];
				}
				key = parts.pop();
				if ( value === undefined ) {
					return curOption[ key ] === undefined ? null : curOption[ key ];
				}
				curOption[ key ] = value;
			} else {
				if ( value === undefined ) {
					return this.options[ key ] === undefined ? null : this.options[ key ];
				}
				options[ key ] = value;
			}
		}

		this._setOptions( options );

		return this;
	},
	_setOptions: function( options ) {
		var key;

		for ( key in options ) {
			this._setOption( key, options[ key ] );
		}

		return this;
	},
	_setOption: function( key, value ) {
		this.options[ key ] = value;

		if ( key === "disabled" ) {
			this.widget()
				.toggleClass( this.widgetFullName + "-disabled ui-state-disabled", !!value )
				.attr( "aria-disabled", value );
			this.hoverable.removeClass( "ui-state-hover" );
			this.focusable.removeClass( "ui-state-focus" );
		}

		return this;
	},

	enable: function() {
		return this._setOption( "disabled", false );
	},
	disable: function() {
		return this._setOption( "disabled", true );
	},

	_bind: function( element, handlers ) {
		// no element argument, shuffle and use this.element
		if ( !handlers ) {
			handlers = element;
			element = this.element;
		} else {
			// accept selectors, DOM elements
			element = $( element );
			this.bindings = this.bindings.add( element );
		}

		var instance = this;
		$.each( handlers, function( event, handler ) {
			function handlerProxy() {
				// allow widgets to customize the disabled handling
				// - disabled as an array instead of boolean
				// - disabled class as method for disabling individual parts
				if ( instance.options.disabled === true ||
						$( this ).hasClass( "ui-state-disabled" ) ) {
					return;
				}
				return ( typeof handler === "string" ? instance[ handler ] : handler )
					.apply( instance, arguments );
			}

			// copy the guid so direct unbinding works
			if ( typeof handler !== "string" ) {
				handlerProxy.guid = handler.guid =
					handler.guid || handlerProxy.guid || jQuery.guid++;
			}

			var match = event.match( /^(\w+)\s*(.*)$/ ),
				eventName = match[1] + "." + instance.widgetName,
				selector = match[2];
			if ( selector ) {
				instance.widget().delegate( selector, eventName, handlerProxy );
			} else {
				element.bind( eventName, handlerProxy );
			}
		});
	},

	_delay: function( handler, delay ) {
		function handlerProxy() {
			return ( typeof handler === "string" ? instance[ handler ] : handler )
				.apply( instance, arguments );
		}
		var instance = this;
		return setTimeout( handlerProxy, delay || 0 );
	},

	_hoverable: function( element ) {
		this.hoverable = this.hoverable.add( element );
		this._bind( element, {
			mouseenter: function( event ) {
				$( event.currentTarget ).addClass( "ui-state-hover" );
			},
			mouseleave: function( event ) {
				$( event.currentTarget ).removeClass( "ui-state-hover" );
			}
		});
	},

	_focusable: function( element ) {
		this.focusable = this.focusable.add( element );
		this._bind( element, {
			focusin: function( event ) {
				$( event.currentTarget ).addClass( "ui-state-focus" );
			},
			focusout: function( event ) {
				$( event.currentTarget ).removeClass( "ui-state-focus" );
			}
		});
	},

	_trigger: function( type, event, data ) {
		var prop, orig,
			callback = this.options[ type ];

		data = data || {};
		event = $.Event( event );
		event.type = ( type === this.widgetEventPrefix ?
			type :
			this.widgetEventPrefix + type ).toLowerCase();
		// the original event may come from any element
		// so we need to reset the target on the new event
		event.target = this.element[ 0 ];

		// copy original event properties over to the new event
		orig = event.originalEvent;
		if ( orig ) {
			for ( prop in orig ) {
				if ( !( prop in event ) ) {
					event[ prop ] = orig[ prop ];
				}
			}
		}

		this.element.trigger( event, data );
		return !( $.isFunction( callback ) &&
			callback.apply( this.element[0], [ event ].concat( data ) ) === false ||
			event.isDefaultPrevented() );
	}
};

$.each( { show: "fadeIn", hide: "fadeOut" }, function( method, defaultEffect ) {
	$.Widget.prototype[ "_" + method ] = function( element, options, callback ) {
		if ( typeof options === "string" ) {
			options = { effect: options };
		}
		var hasOptions,
			effectName = !options ?
				method :
				options === true || typeof options === "number" ?
					defaultEffect :
					options.effect || defaultEffect;
		options = options || {};
		if ( typeof options === "number" ) {
			options = { duration: options };
		}
		hasOptions = !$.isEmptyObject( options );
		options.complete = callback;
		if ( options.delay ) {
			element.delay( options.delay );
		}
		if ( hasOptions && $.effects && ( $.effects.effect[ effectName ] || $.uiBackCompat !== false && $.effects[ effectName ] ) ) {
			element[ method ]( options );
		} else if ( effectName !== method && element[ effectName ] ) {
			element[ effectName ]( options.duration, options.easing, callback );
		} else {
			element.queue(function( next ) {
				$( this )[ method ]();
				if ( callback ) {
					callback.call( element[ 0 ] );
				}
				next();
			});
		}
	};
});

// DEPRECATED
if ( $.uiBackCompat !== false ) {
	$.Widget.prototype._getCreateOptions = function() {
		return $.metadata && $.metadata.get( this.element[0] )[ this.widgetName ];
	};
}

})( jQuery );

/*!
 * jQuery UI Position @VERSION
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Position
 */
(function( $, undefined ) {

$.ui = $.ui || {};

var cachedScrollbarWidth,
	max = Math.max,
	abs = Math.abs,
	round = Math.round,
	rhorizontal = /left|center|right/,
	rvertical = /top|center|bottom/,
	roffset = /[\+\-]\d+%?/,
	rposition = /^\w+/,
	rpercent = /%$/,
	_position = $.fn.position;

function getOffsets( offsets, width, height ) {
	return [
		parseInt( offsets[ 0 ], 10 ) * ( rpercent.test( offsets[ 0 ] ) ? width / 100 : 1 ),
		parseInt( offsets[ 1 ], 10 ) * ( rpercent.test( offsets[ 1 ] ) ? height / 100 : 1 )
	];
}
function parseCss( element, property ) {
	return parseInt( $.css( element, property ), 10 ) || 0;
}

$.position = {
	scrollbarWidth: function() {
		if ( cachedScrollbarWidth !== undefined ) {
			return cachedScrollbarWidth;
		}
		var w1, w2,
			div = $( "<div style='display:block;width:50px;height:50px;overflow:hidden;'><div style='height:100px;width:auto;'></div></div>" ),
			innerDiv = div.children()[0];

		$( "body" ).append( div );
		w1 = innerDiv.offsetWidth;
		div.css( "overflow", "scroll" );

		w2 = innerDiv.offsetWidth;

		if ( w1 === w2 ) {
			w2 = div[0].clientWidth;
		}

		div.remove();

		return (cachedScrollbarWidth = w1 - w2);
	},
	getScrollInfo: function( within ) {
		var overflowX = within.isWindow ? "" : within.element.css( "overflow-x" ),
			overflowY = within.isWindow ? "" : within.element.css( "overflow-y" ),
			hasOverflowX = overflowX === "scroll" ||
				( overflowX === "auto" && within.width < within.element[0].scrollWidth ),
			hasOverflowY = overflowY === "scroll" ||
				( overflowY === "auto" && within.height < within.element[0].scrollHeight );
		return {
			width: hasOverflowX ? $.position.scrollbarWidth() : 0,
			height: hasOverflowY ? $.position.scrollbarWidth() : 0
		};
	},
	getWithinInfo: function( element ) {
		var withinElement = $( element || window ),
			isWindow = $.isWindow( withinElement[0] );
		return {
			element: withinElement,
			isWindow: isWindow,
			offset: withinElement.offset() || { left: 0, top: 0 },
			scrollLeft: withinElement.scrollLeft(),
			scrollTop: withinElement.scrollTop(),
			width: isWindow ? withinElement.width() : withinElement.outerWidth(),
			height: isWindow ? withinElement.height() : withinElement.outerHeight()
		};
	}
};

$.fn.position = function( options ) {
	if ( !options || !options.of ) {
		return _position.apply( this, arguments );
	}

	// make a copy, we don't want to modify arguments
	options = $.extend( {}, options );

	var atOffset, targetWidth, targetHeight, targetOffset, basePosition,
		target = $( options.of ),
		within = $.position.getWithinInfo( options.within ),
		scrollInfo = $.position.getScrollInfo( within ),
		targetElem = target[0],
		collision = ( options.collision || "flip" ).split( " " ),
		offsets = {};

	if ( targetElem.nodeType === 9 ) {
		targetWidth = target.width();
		targetHeight = target.height();
		targetOffset = { top: 0, left: 0 };
	} else if ( $.isWindow( targetElem ) ) {
		targetWidth = target.width();
		targetHeight = target.height();
		targetOffset = { top: target.scrollTop(), left: target.scrollLeft() };
	} else if ( targetElem.preventDefault ) {
		// force left top to allow flipping
		options.at = "left top";
		targetWidth = targetHeight = 0;
		targetOffset = { top: targetElem.pageY, left: targetElem.pageX };
	} else {
		targetWidth = target.outerWidth();
		targetHeight = target.outerHeight();
		targetOffset = target.offset();
	}
	// clone to reuse original targetOffset later
	basePosition = $.extend( {}, targetOffset );

	// force my and at to have valid horizontal and vertical positions
	// if a value is missing or invalid, it will be converted to center
	$.each( [ "my", "at" ], function() {
		var pos = ( options[ this ] || "" ).split( " " ),
			horizontalOffset,
			verticalOffset;

		if ( pos.length === 1) {
			pos = rhorizontal.test( pos[ 0 ] ) ?
				pos.concat( [ "center" ] ) :
				rvertical.test( pos[ 0 ] ) ?
					[ "center" ].concat( pos ) :
					[ "center", "center" ];
		}
		pos[ 0 ] = rhorizontal.test( pos[ 0 ] ) ? pos[ 0 ] : "center";
		pos[ 1 ] = rvertical.test( pos[ 1 ] ) ? pos[ 1 ] : "center";

		// calculate offsets
		horizontalOffset = roffset.exec( pos[ 0 ] );
		verticalOffset = roffset.exec( pos[ 1 ] );
		offsets[ this ] = [
			horizontalOffset ? horizontalOffset[ 0 ] : 0,
			verticalOffset ? verticalOffset[ 0 ] : 0
		];

		// reduce to just the positions without the offsets
		options[ this ] = [
			rposition.exec( pos[ 0 ] )[ 0 ],
			rposition.exec( pos[ 1 ] )[ 0 ]
		];
	});

	// normalize collision option
	if ( collision.length === 1 ) {
		collision[ 1 ] = collision[ 0 ];
	}

	if ( options.at[ 0 ] === "right" ) {
		basePosition.left += targetWidth;
	} else if ( options.at[ 0 ] === "center" ) {
		basePosition.left += targetWidth / 2;
	}

	if ( options.at[ 1 ] === "bottom" ) {
		basePosition.top += targetHeight;
	} else if ( options.at[ 1 ] === "center" ) {
		basePosition.top += targetHeight / 2;
	}

	atOffset = getOffsets( offsets.at, targetWidth, targetHeight );
	basePosition.left += atOffset[ 0 ];
	basePosition.top += atOffset[ 1 ];

	return this.each(function() {
		var collisionPosition, using,
			elem = $( this ),
			elemWidth = elem.outerWidth(),
			elemHeight = elem.outerHeight(),
			marginLeft = parseCss( this, "marginLeft" ),
			marginTop = parseCss( this, "marginTop" ),
			collisionWidth = elemWidth + marginLeft + parseCss( this, "marginRight" ) + scrollInfo.width,
			collisionHeight = elemHeight + marginTop + parseCss( this, "marginBottom" ) + scrollInfo.height,
			position = $.extend( {}, basePosition ),
			myOffset = getOffsets( offsets.my, elem.outerWidth(), elem.outerHeight() );

		if ( options.my[ 0 ] === "right" ) {
			position.left -= elemWidth;
		} else if ( options.my[ 0 ] === "center" ) {
			position.left -= elemWidth / 2;
		}

		if ( options.my[ 1 ] === "bottom" ) {
			position.top -= elemHeight;
		} else if ( options.my[ 1 ] === "center" ) {
			position.top -= elemHeight / 2;
		}

		position.left += myOffset[ 0 ];
		position.top += myOffset[ 1 ];

		// if the browser doesn't support fractions, then round for consistent results
		if ( !$.support.offsetFractions ) {
			position.left = round( position.left );
			position.top = round( position.top );
		}

		collisionPosition = {
			marginLeft: marginLeft,
			marginTop: marginTop
		};

		$.each( [ "left", "top" ], function( i, dir ) {
			if ( $.ui.position[ collision[ i ] ] ) {
				$.ui.position[ collision[ i ] ][ dir ]( position, {
					targetWidth: targetWidth,
					targetHeight: targetHeight,
					elemWidth: elemWidth,
					elemHeight: elemHeight,
					collisionPosition: collisionPosition,
					collisionWidth: collisionWidth,
					collisionHeight: collisionHeight,
					offset: [ atOffset[ 0 ] + myOffset[ 0 ], atOffset [ 1 ] + myOffset[ 1 ] ],
					my: options.my,
					at: options.at,
					within: within,
					elem : elem
				});
			}
		});

		if ( $.fn.bgiframe ) {
			elem.bgiframe();
		}

		if ( options.using ) {
			// adds feedback as second argument to using callback, if present
			using = function( props ) {
				var left = targetOffset.left - position.left,
					right = left + targetWidth - elemWidth,
					top = targetOffset.top - position.top,
					bottom = top + targetHeight - elemHeight,
					feedback = {
						target: {
							element: target,
							left: targetOffset.left,
							top: targetOffset.top,
							width: targetWidth,
							height: targetHeight
						},
						element: {
							element: elem,
							left: position.left,
							top: position.top,
							width: elemWidth,
							height: elemHeight
						},
						horizontal: right < 0 ? "left" : left > 0 ? "right" : "center",
						vertical: bottom < 0 ? "top" : top > 0 ? "bottom" : "middle"
					};
				if ( targetWidth < elemWidth && abs( left + right ) < targetWidth ) {
					feedback.horizontal = "center";
				}
				if ( targetHeight < elemHeight && abs( top + bottom ) < targetHeight ) {
					feedback.vertical = "middle";
				}
				if ( max( abs( left ), abs( right ) ) > max( abs( top ), abs( bottom ) ) ) {
					feedback.important = "horizontal";
				} else {
					feedback.important = "vertical";
				}
				options.using.call( this, props, feedback );
			};
		}

		elem.offset( $.extend( position, { using: using } ) );
	});
};

$.ui.position = {
	fit: {
		left: function( position, data ) {
			var within = data.within,
				withinOffset = within.isWindow ? within.scrollLeft : within.offset.left,
				outerWidth = within.width,
				collisionPosLeft = position.left - data.collisionPosition.marginLeft,
				overLeft = withinOffset - collisionPosLeft,
				overRight = collisionPosLeft + data.collisionWidth - outerWidth - withinOffset,
				newOverRight;

			// element is wider than within
			if ( data.collisionWidth > outerWidth ) {
				// element is initially over the left side of within
				if ( overLeft > 0 && overRight <= 0 ) {
					newOverRight = position.left + overLeft + data.collisionWidth - outerWidth - withinOffset;
					position.left += overLeft - newOverRight;
				// element is initially over right side of within
				} else if ( overRight > 0 && overLeft <= 0 ) {
					position.left = withinOffset;
				// element is initially over both left and right sides of within
				} else {
					if ( overLeft > overRight ) {
						position.left = withinOffset + outerWidth - data.collisionWidth;
					} else {
						position.left = withinOffset;
					}
				}
			// too far left -> align with left edge
			} else if ( overLeft > 0 ) {
				position.left += overLeft;
			// too far right -> align with right edge
			} else if ( overRight > 0 ) {
				position.left -= overRight;
			// adjust based on position and margin
			} else {
				position.left = max( position.left - collisionPosLeft, position.left );
			}
		},
		top: function( position, data ) {
			var within = data.within,
				withinOffset = within.isWindow ? within.scrollTop : within.offset.top,
				outerHeight = data.within.height,
				collisionPosTop = position.top - data.collisionPosition.marginTop,
				overTop = withinOffset - collisionPosTop,
				overBottom = collisionPosTop + data.collisionHeight - outerHeight - withinOffset,
				newOverBottom;

			// element is taller than within
			if ( data.collisionHeight > outerHeight ) {
				// element is initially over the top of within
				if ( overTop > 0 && overBottom <= 0 ) {
					newOverBottom = position.top + overTop + data.collisionHeight - outerHeight - withinOffset;
					position.top += overTop - newOverBottom;
				// element is initially over bottom of within
				} else if ( overBottom > 0 && overTop <= 0 ) {
					position.top = withinOffset;
				// element is initially over both top and bottom of within
				} else {
					if ( overTop > overBottom ) {
						position.top = withinOffset + outerHeight - data.collisionHeight;
					} else {
						position.top = withinOffset;
					}
				}
			// too far up -> align with top
			} else if ( overTop > 0 ) {
				position.top += overTop;
			// too far down -> align with bottom edge
			} else if ( overBottom > 0 ) {
				position.top -= overBottom;
			// adjust based on position and margin
			} else {
				position.top = max( position.top - collisionPosTop, position.top );
			}
		}
	},
	flip: {
		left: function( position, data ) {
			var within = data.within,
				withinOffset = within.offset.left + within.scrollLeft,
				outerWidth = within.width,
				offsetLeft = within.isWindow ? 0 : within.offset.left,
				collisionPosLeft = position.left - data.collisionPosition.marginLeft,
				overLeft = collisionPosLeft - offsetLeft,
				overRight = collisionPosLeft + data.collisionWidth - outerWidth - offsetLeft,
				myOffset = data.my[ 0 ] === "left" ?
					-data.elemWidth :
					data.my[ 0 ] === "right" ?
						data.elemWidth :
						0,
				atOffset = data.at[ 0 ] === "left" ?
					data.targetWidth :
					data.at[ 0 ] === "right" ?
						-data.targetWidth :
						0,
				offset = -2 * data.offset[ 0 ],
				newOverRight,
				newOverLeft;

			if ( overLeft < 0 ) {
				newOverRight = position.left + myOffset + atOffset + offset + data.collisionWidth - outerWidth - withinOffset;
				if ( newOverRight < 0 || newOverRight < abs( overLeft ) ) {
					position.left += myOffset + atOffset + offset;
				}
			}
			else if ( overRight > 0 ) {
				newOverLeft = position.left - data.collisionPosition.marginLeft + myOffset + atOffset + offset - offsetLeft;
				if ( newOverLeft > 0 || abs( newOverLeft ) < overRight ) {
					position.left += myOffset + atOffset + offset;
				}
			}
		},
		top: function( position, data ) {
			var within = data.within,
				withinOffset = within.offset.top + within.scrollTop,
				outerHeight = within.height,
				offsetTop = within.isWindow ? 0 : within.offset.top,
				collisionPosTop = position.top - data.collisionPosition.marginTop,
				overTop = collisionPosTop - offsetTop,
				overBottom = collisionPosTop + data.collisionHeight - outerHeight - offsetTop,
				top = data.my[ 1 ] === "top",
				myOffset = top ?
					-data.elemHeight :
					data.my[ 1 ] === "bottom" ?
						data.elemHeight :
						0,
				atOffset = data.at[ 1 ] === "top" ?
					data.targetHeight :
					data.at[ 1 ] === "bottom" ?
						-data.targetHeight :
						0,
				offset = -2 * data.offset[ 1 ],
				newOverTop,
				newOverBottom;
			if ( overTop < 0 ) {
				newOverBottom = position.top + myOffset + atOffset + offset + data.collisionHeight - outerHeight - withinOffset;
				if ( ( position.top + myOffset + atOffset + offset) > overTop && ( newOverBottom < 0 || newOverBottom < abs( overTop ) ) ) {
					position.top += myOffset + atOffset + offset;
				}
			}
			else if ( overBottom > 0 ) {
				newOverTop = position.top -  data.collisionPosition.marginTop + myOffset + atOffset + offset - offsetTop;
				if ( ( position.top + myOffset + atOffset + offset) > overBottom && ( newOverTop > 0 || abs( newOverTop ) < overBottom ) ) {
					position.top += myOffset + atOffset + offset;
				}
			}
		}
	},
	flipfit: {
		left: function() {
			$.ui.position.flip.left.apply( this, arguments );
			$.ui.position.fit.left.apply( this, arguments );
		},
		top: function() {
			$.ui.position.flip.top.apply( this, arguments );
			$.ui.position.fit.top.apply( this, arguments );
		}
	}
};

// fraction support test
(function () {
	var testElement, testElementParent, testElementStyle, offsetLeft, i,
		body = document.getElementsByTagName( "body" )[ 0 ],
		div = document.createElement( "div" );

	//Create a "fake body" for testing based on method used in jQuery.support
	testElement = document.createElement( body ? "div" : "body" );
	testElementStyle = {
		visibility: "hidden",
		width: 0,
		height: 0,
		border: 0,
		margin: 0,
		background: "none"
	};
	if ( body ) {
		$.extend( testElementStyle, {
			position: "absolute",
			left: "-1000px",
			top: "-1000px"
		});
	}
	for ( i in testElementStyle ) {
		testElement.style[ i ] = testElementStyle[ i ];
	}
	testElement.appendChild( div );
	testElementParent = body || document.documentElement;
	testElementParent.insertBefore( testElement, testElementParent.firstChild );

	div.style.cssText = "position: absolute; left: 10.7432222px;";

	offsetLeft = $( div ).offset().left;
	$.support.offsetFractions = offsetLeft > 10 && offsetLeft < 11;

	testElement.innerHTML = "";
	testElementParent.removeChild( testElement );
})();

// DEPRECATED
if ( $.uiBackCompat !== false ) {
	// offset option
	(function( $ ) {
		var _position = $.fn.position;
		$.fn.position = function( options ) {
			if ( !options || !options.offset ) {
				return _position.call( this, options );
			}
			var offset = options.offset.split( " " ),
				at = options.at.split( " " );
			if ( offset.length === 1 ) {
				offset[ 1 ] = offset[ 0 ];
			}
			if ( /^\d/.test( offset[ 0 ] ) ) {
				offset[ 0 ] = "+" + offset[ 0 ];
			}
			if ( /^\d/.test( offset[ 1 ] ) ) {
				offset[ 1 ] = "+" + offset[ 1 ];
			}
			if ( at.length === 1 ) {
				if ( /left|center|right/.test( at[ 0 ] ) ) {
					at[ 1 ] = "center";
				} else {
					at[ 1 ] = at[ 0 ];
					at[ 0 ] = "center";
				}
			}
			return _position.call( this, $.extend( options, {
				at: at[ 0 ] + offset[ 0 ] + " " + at[ 1 ] + offset[ 1 ],
				offset: undefined
			} ) );
		};
	}( jQuery ) );
}

}( jQuery ) );

/*!
 * jQuery UI Menu @VERSION
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Menu
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.widget.js
 */
(function($) {

var currentEventTarget = null;

$.widget( "ui.menu", {
	version: "@VERSION",
	defaultElement: "<ul>",
	delay: 300,
	options: {
		menus: "ul",
		position: {
			my: "left top",
			at: "right top"
		},
		role: "menu",

		// callbacks
		blur: null,
		focus: null,
		select: null
	},
	_create: function() {
		this.activeMenu = this.element;
		this.element
			.uniqueId()
			.addClass( "ui-menu ui-widget ui-widget-content ui-corner-all" )
			.toggleClass( "ui-menu-icons", !!this.element.find( ".ui-icon" ).length )
			.attr({
				role: this.options.role,
				tabIndex: 0
			})
			// need to catch all clicks on disabled menu
			// not possible through _bind
			.bind( "click.menu", $.proxy(function( event ) {
				if ( this.options.disabled ) {
					event.preventDefault();
				}
			}, this ));

		if ( this.options.disabled ) {
			this.element
				.addClass( "ui-state-disabled" )
				.attr( "aria-disabled", "true" );
		}

		this._bind({
			// Prevent focus from sticking to links inside menu after clicking
			// them (focus should always stay on UL during navigation).
			"mousedown .ui-menu-item > a": function( event ) {
				event.preventDefault();
			},
			"click .ui-state-disabled > a": function( event ) {
				event.preventDefault();
			},
			"click .ui-menu-item:has(a)": function( event ) {
				var target = $( event.target );
				if ( target[0] !== currentEventTarget ) {
					currentEventTarget = target[0];
					target.one( "click.menu", function( event ) {
						currentEventTarget = null;
					});
					// Don't select disabled menu items
					if ( !target.closest( ".ui-menu-item" ).is( ".ui-state-disabled" ) ) {
						this.select( event );
						// Redirect focus to the menu with a delay for firefox
						this._delay(function() {
							if ( !this.element.is(":focus") ) {
								this.element.focus();
							}
						}, 20 );
					}
				}
			},
			"mouseenter .ui-menu-item": function( event ) {
				var target = $( event.currentTarget );
				// Remove ui-state-active class from siblings of the newly focused menu item
				// to avoid a jump caused by adjacent elements both having a class with a border
				target.siblings().children( ".ui-state-active" ).removeClass( "ui-state-active" );
				this.focus( event, target );
			},
			mouseleave: "collapseAll",
			"mouseleave .ui-menu": "collapseAll",
			focus: function( event ) {
				var menu = this.element,
					firstItem = menu.children( ".ui-menu-item" ).eq( 0 );
				if ( this._hasScroll() && !this.active ) {
					menu.children().each(function() {
						var currentItem = $( this );
						if ( currentItem.offset().top - menu.offset().top >= 0 ) {
							firstItem = currentItem;
							return false;
						}
					});
				} else if ( this.active ) {
					firstItem = this.active;
				}
				this.focus( event, firstItem );
			},
			blur: function( event ) {
				this._delay(function() {
					if ( !$.contains( this.element[0], this.document[0].activeElement ) ) {
						this.collapseAll( event );
					}
				});
			},
			keydown: "_keydown"
		});

		this.refresh();

		// TODO: We probably shouldn't bind to document for each menu.
		// TODO: This isn't being cleaned up on destroy.
		this._bind( this.document, {
			click: function( event ) {
				if ( !$( event.target ).closest( ".ui-menu" ).length ) {
					this.collapseAll( event );
				}
			}
		});
	},

	_destroy: function() {
		// destroy (sub)menus
		this.element
			.removeAttr( "aria-activedescendant" )
			.find( ".ui-menu" ).andSelf()
				.removeClass( "ui-menu ui-widget ui-widget-content ui-corner-all ui-menu-icons" )
				.removeAttr( "role" )
				.removeAttr( "tabIndex" )
				.removeAttr( "aria-labelledby" )
				.removeAttr( "aria-expanded" )
				.removeAttr( "aria-hidden" )
				.removeAttr( "aria-disabled" )
				.removeUniqueId()
				.show();

		// destroy menu items
		this.element.find( ".ui-menu-item" )
			.removeClass( "ui-menu-item" )
			.removeAttr( "role" )
			.removeAttr( "aria-disabled" )
			.children( "a" )
				.removeUniqueId()
				.removeClass( "ui-corner-all ui-state-hover" )
				.removeAttr( "tabIndex" )
				.removeAttr( "role" )
				.removeAttr( "aria-haspopup" )
				.children().each( function() {
					var elem = $( this );
					if ( elem.data( "ui-menu-submenu-carat" ) ) {
						elem.remove();
					}
				});

		// destroy menu dividers
		this.element.find( ".ui-menu-divider" ).removeClass( "ui-menu-divider ui-widget-content" );

		// unbind currentEventTarget click event handler
		$( currentEventTarget ).unbind( "click.menu" );
	},

	_keydown: function( event ) {
		var match, prev, character, skip,
			preventDefault = true;

		function escape( value ) {
			return value.replace( /[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&" );
		}

		switch ( event.keyCode ) {
		case $.ui.keyCode.PAGE_UP:
			this.previousPage( event );
			break;
		case $.ui.keyCode.PAGE_DOWN:
			this.nextPage( event );
			break;
		case $.ui.keyCode.HOME:
			this._move( "first", "first", event );
			break;
		case $.ui.keyCode.END:
			this._move( "last", "last", event );
			break;
		case $.ui.keyCode.UP:
			this.previous( event );
			break;
		case $.ui.keyCode.DOWN:
			this.next( event );
			break;
		case $.ui.keyCode.LEFT:
			this.collapse( event );
			break;
		case $.ui.keyCode.RIGHT:
			if ( !this.active.is( ".ui-state-disabled" ) ) {
				this.expand( event );
			}
			break;
		case $.ui.keyCode.ENTER:
			this._activate( event );
			break;
		case $.ui.keyCode.SPACE:
			this._activate( event );
			break;
		case $.ui.keyCode.ESCAPE:
			this.collapse( event );
			break;
		default:
			preventDefault = false;
			prev = this.previousFilter || "";
			character = String.fromCharCode( event.keyCode );
			skip = false;

			clearTimeout( this.filterTimer );

			if ( character === prev ) {
				skip = true;
			} else {
				character = prev + character;
			}

			match = this.activeMenu.children( ".ui-menu-item" ).filter(function() {
				return new RegExp( "^" + escape( character ), "i" )
					.test( $( this ).children( "a" ).text() );
			});
			match = skip && match.index( this.active.next() ) !== -1 ?
				this.active.nextAll( ".ui-menu-item" ) :
				match;

			// If no matches on the current filter, reset to the last character pressed
			// to move down the menu to the first item that starts with that character
			if ( !match.length ) {
				character = String.fromCharCode( event.keyCode );
				match = this.activeMenu.children( ".ui-menu-item" ).filter(function() {
					return new RegExp( "^" + escape(character), "i" )
						.test( $( this ).children( "a" ).text() );
				});
			}

			if ( match.length ) {
				this.focus( event, match );
				if ( match.length > 1 ) {
					this.previousFilter = character;
					this.filterTimer = this._delay(function() {
						delete this.previousFilter;
					}, 1000 );
				} else {
					delete this.previousFilter;
				}
			} else {
				delete this.previousFilter;
			}
		}

		if ( preventDefault ) {
			event.preventDefault();
		}
	},

	_activate: function( event ) {
		if ( !this.active.is( ".ui-state-disabled" ) ) {
			if ( this.active.children( "a[aria-haspopup='true']" ).length ) {
				this.expand( event );
			} else {
				this.select( event );
			}
		}
	},

	refresh: function() {
		// initialize nested menus
		var menus,
			submenus = this.element.find( this.options.menus + ":not(.ui-menu)" )
				.addClass( "ui-menu ui-widget ui-widget-content ui-corner-all" )
				.hide()
				.attr({
					role: this.options.role,
					"aria-hidden": "true",
					"aria-expanded": "false"
				});

		// don't refresh list items that are already adapted
		menus = submenus.add( this.element );

		menus.children( ":not( .ui-menu-item ):has( a )" )
			.addClass( "ui-menu-item" )
			.attr( "role", "presentation" )
			.children( "a" )
				.uniqueId()
				.addClass( "ui-corner-all" )
				.attr({
					tabIndex: -1,
					role: this._itemRole()
				});

		// initialize unlinked menu-items containing spaces and/or dashes only as dividers
		menus.children( ":not(.ui-menu-item)" ).each( function() {
			var item = $( this );
			// hyphen, em dash, en dash
			if ( !/[^\-—–\s]/.test( item.text() ) ) {
				item.addClass( "ui-widget-content ui-menu-divider" );
			}
		});

		// add aria-disabled attribute to any disabled menu item
		menus.children( ".ui-state-disabled" ).attr( "aria-disabled", "true" );

		submenus.each(function() {
			var menu = $( this ),
				item = menu.prev( "a" ),
				submenuCarat = $( '<span class="ui-menu-icon ui-icon ui-icon-carat-1-e"></span>' ).data( "ui-menu-submenu-carat", true );

			item
				.attr( "aria-haspopup", "true" )
				.prepend( submenuCarat );
			menu.attr( "aria-labelledby", item.attr( "id" ) );
		});
	},

	_itemRole: function() {
		return {
			menu: "menuitem",
			listbox: "option"
		}[ this.options.role ];
	},

	focus: function( event, item ) {
		var nested, focused;
		this.blur( event, event && event.type === "focus" );

		this._scrollIntoView( item );

		this.active = item.first();
		focused = this.active.children( "a" ).addClass( "ui-state-focus" );
		// only update aria-activedescendant if there's a role
		// otherwise we assume focus is managed elsewhere
		if ( this.options.role ) {
			this.element.attr( "aria-activedescendant", focused.attr( "id" ) );
		}

		// highlight active parent menu item, if any
		this.active
			.parent()
			.closest( ".ui-menu-item" )
			.children( "a:first" )
			.addClass( "ui-state-active" );

		if ( event && event.type === "keydown" ) {
			this._close();
		} else {
			this.timer = this._delay(function() {
				this._close();
			}, this.delay );
		}

		nested = $( "> .ui-menu", item );
		if ( nested.length && ( /^mouse/.test( event.type ) ) ) {
			this._startOpening(nested);
		}
		this.activeMenu = item.parent();

		this._trigger( "focus", event, { item: item } );
	},

	_scrollIntoView: function( item ) {
		var borderTop, paddingTop, offset, scroll, elementHeight, itemHeight;
		if ( this._hasScroll() ) {
			borderTop = parseFloat( $.css( this.activeMenu[0], "borderTopWidth" ) ) || 0;
			paddingTop = parseFloat( $.css( this.activeMenu[0], "paddingTop" ) ) || 0;
			offset = item.offset().top - this.activeMenu.offset().top - borderTop - paddingTop;
			scroll = this.activeMenu.scrollTop();
			elementHeight = this.activeMenu.height();
			itemHeight = item.height();

			if ( offset < 0 ) {
				this.activeMenu.scrollTop( scroll + offset );
			} else if ( offset + itemHeight > elementHeight ) {
				this.activeMenu.scrollTop( scroll + offset - elementHeight + itemHeight );
			}
		}
	},

	blur: function( event, fromFocus ) {
		if ( !fromFocus ) {
			clearTimeout( this.timer );
		}

		if ( !this.active ) {
			return;
		}

		this.active.children( "a" ).removeClass( "ui-state-focus" );
		this.active = null;

		this._trigger( "blur", event, { item: this.active } );
	},

	_startOpening: function( submenu ) {
		clearTimeout( this.timer );

		// Don't open if already open fixes a Firefox bug that caused a .5 pixel
		// shift in the submenu position when mousing over the carat icon
		if ( submenu.attr( "aria-hidden" ) !== "true" ) {
			return;
		}

		this.timer = this._delay(function() {
			this._close();
			this._open( submenu );
		}, this.delay );
	},

	_open: function( submenu ) {
		var position = $.extend({
			of: this.active
		}, $.type( this.options.position ) === "function" ?
			this.options.position( this.active ) :
			this.options.position
		);

		clearTimeout( this.timer );
		this.element.find( ".ui-menu" ).not( submenu.parents() )
			.hide()
			.attr( "aria-hidden", "true" );

		submenu
			.show()
			.removeAttr( "aria-hidden" )
			.attr( "aria-expanded", "true" )
			.position( position );
	},

	collapseAll: function( event, all ) {
		clearTimeout( this.timer );
		this.timer = this._delay(function() {
			// if we were passed an event, look for the submenu that contains the event
			var currentMenu = all ? this.element :
				$( event && event.target ).closest( this.element.find( ".ui-menu" ) );

			// if we found no valid submenu ancestor, use the main menu to close all sub menus anyway
			if ( !currentMenu.length ) {
				currentMenu = this.element;
			}

			this._close( currentMenu );

			this.blur( event );
			this.activeMenu = currentMenu;
		}, this.delay );
	},

	// With no arguments, closes the currently active menu - if nothing is active
	// it closes all menus.  If passed an argument, it will search for menus BELOW
	_close: function( startMenu ) {
		if ( !startMenu ) {
			startMenu = this.active ? this.active.parent() : this.element;
		}

		startMenu
			.find( ".ui-menu" )
				.hide()
				.attr( "aria-hidden", "true" )
				.attr( "aria-expanded", "false" )
			.end()
			.find( "a.ui-state-active" )
				.removeClass( "ui-state-active" );
	},

	collapse: function( event ) {
		var newItem = this.active &&
			this.active.parent().closest( ".ui-menu-item", this.element );
		if ( newItem && newItem.length ) {
			this._close();
			this.focus( event, newItem );
			return true;
		}
	},

	expand: function( event ) {
		var newItem = this.active &&
			this.active
				.children( ".ui-menu " )
				.children( ".ui-menu-item" )
				.first();

		if ( newItem && newItem.length ) {
			this._open( newItem.parent() );

			// timeout so Firefox will not hide activedescendant change in expanding submenu from AT
			this._delay(function() {
				this.focus( event, newItem );
			}, 20 );
			return true;
		}
	},

	next: function( event ) {
		this._move( "next", "first", event );
	},

	previous: function( event ) {
		this._move( "prev", "last", event );
	},

	isFirstItem: function() {
		return this.active && !this.active.prevAll( ".ui-menu-item" ).length;
	},

	isLastItem: function() {
		return this.active && !this.active.nextAll( ".ui-menu-item" ).length;
	},

	_move: function( direction, filter, event ) {
		var next;
		if ( this.active ) {
			if ( direction === "first" || direction === "last" ) {
				next = this.active
					[ direction === "first" ? "prevAll" : "nextAll" ]( ".ui-menu-item" )
					.eq( -1 );
			} else {
				next = this.active
					[ direction + "All" ]( ".ui-menu-item" )
					.eq( 0 );
			}
		}
		if ( !next || !next.length || !this.active ) {
			next = this.activeMenu.children( ".ui-menu-item" )[ filter ]();
		}

		this.focus( event, next );
	},

	nextPage: function( event ) {
		if ( !this.active ) {
			this._move( "next", "first", event );
			return;
		}
		if ( this.isLastItem() ) {
			return;
		}
		if ( this._hasScroll() ) {
			var base = this.active.offset().top,
				height = this.element.height(),
				result;
			this.active.nextAll( ".ui-menu-item" ).each(function() {
				result = $( this );
				return $( this ).offset().top - base - height < 0;
			});

			this.focus( event, result );
		} else {
			this.focus( event, this.activeMenu.children( ".ui-menu-item" )
				[ !this.active ? "first" : "last" ]() );
		}
	},

	previousPage: function( event ) {
		if ( !this.active ) {
			this._move( "next", "first", event );
			return;
		}
		if ( this.isFirstItem() ) {
			return;
		}
		if ( this._hasScroll() ) {
			var base = this.active.offset().top,
				height = this.element.height(),
				result;
			this.active.prevAll( ".ui-menu-item" ).each(function() {
				result = $( this );
				return $(this).offset().top - base + height > 0;
			});

			this.focus( event, result );
		} else {
			this.focus( event, this.activeMenu.children( ".ui-menu-item" ).first() );
		}
	},

	_hasScroll: function() {
		return this.element.outerHeight() < this.element.prop( "scrollHeight" );
	},

	select: function( event ) {
		// save active reference before collapseAll triggers blur
		var ui = {
			item: this.active
		};
		this.collapseAll( event, true );
		this._trigger( "select", event, ui );
	}
});

}( jQuery ));

/*!
 * jQuery UI Autocomplete @VERSION
 *
 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Autocomplete
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.widget.js
 *	jquery.ui.position.js
 *	jquery.ui.menu.js
 *
 * 修改优化，支持中文
 * by:kule 2012-06-07
 */
(function( $, undefined ) {

// used to prevent race conditions with remote data sources
var requestIndex = 0;

$.widget( "ui.autocomplete", {
	version: "@VERSION",
	defaultElement: "<input>",
	options: {
		appendTo: "body",
		autoFocus: false,
		delay: 300,
		minLength: 1,
		position: {
			my: "left top",
			at: "left bottom",
			collision: "none"
		},
		source: null,
        popMax:null,
		// callbacks
        onpopMax:$.noop,
		change: null,
		close: null,
		focus: null,
		open: null,
		response: null,
		search: null,
		select: null
	},

	pending: 0,

	_create: function() {
		// Some browsers only repeat keydown events, not keypress events,
		// so we use the suppressKeyPress flag to determine if we've already
		// handled the keydown event. #7269
		// Unfortunately the code for & in keypress is the same as the up arrow,
		// so we use the suppressKeyPressRepeat flag to avoid handling keypress
		// events when we know the keydown event was used to modify the
		// search term. #7799
		var suppressKeyPress, suppressKeyPressRepeat, suppressInput;

		this.isMultiLine = this.element.is( "textarea,[contenteditable]" );
		this.valueMethod = this.element[ this.element.is( "input,textarea" ) ? "val" : "text" ];
		this.isNewMenu = true;

		this.element
			.addClass( "ui-autocomplete-input" )
			.attr( "autocomplete", "off" );

		this._bind({
			keydown: function( event ) {
				if ( this.element.prop( "readOnly" ) ) {
					suppressKeyPress = true;
					suppressInput = true;
					suppressKeyPressRepeat = true;
					return;
				}

				suppressKeyPress = false;
				suppressInput = false;
				suppressKeyPressRepeat = false;
				var keyCode = $.ui.keyCode;
				switch( event.keyCode ) {
				case keyCode.PAGE_UP:
					suppressKeyPress = true;
					this._move( "previousPage", event );
					break;
				case keyCode.PAGE_DOWN:
					suppressKeyPress = true;
					this._move( "nextPage", event );
					break;
				case keyCode.UP:
					suppressKeyPress = true;
					this._keyEvent( "previous", event );
					break;
				case keyCode.DOWN:
					suppressKeyPress = true;
					this._keyEvent( "next", event );
					break;
				case keyCode.ENTER:
				case keyCode.NUMPAD_ENTER:
					// when menu is open and has focus
					if ( this.menu.active ) {
						// #6055 - Opera still allows the keypress to occur
						// which causes forms to submit
						suppressKeyPress = true;
						event.preventDefault();
						this.menu.select( event );
					}
					break;
				case keyCode.TAB:
					if ( this.menu.active ) {
						this.menu.select( event );
					}
					break;
				case keyCode.ESCAPE:
					if ( this.menu.element.is( ":visible" ) ) {
						this._value( this.term );
						this.close( event );
						// Different browsers have different default behavior for escape
						// Single press can mean undo or clear
						// Double press in IE means clear the whole form
						event.preventDefault();
					}
					break;
				default:
					suppressKeyPressRepeat = true;
					// search timeout should be triggered before the input value is changed
					this._searchTimeout( event );
					break;
				}
			},
			keypress: function( event ) {
				if ( suppressKeyPress ) {
					suppressKeyPress = false;
					event.preventDefault();
					return;
				}
				if ( suppressKeyPressRepeat ) {
					return;
				}

				// replicate some key handlers to allow them to repeat in Firefox and Opera
				var keyCode = $.ui.keyCode;
				switch( event.keyCode ) {
				case keyCode.PAGE_UP:
					this._move( "previousPage", event );
					break;
				case keyCode.PAGE_DOWN:
					this._move( "nextPage", event );
					break;
				case keyCode.UP:
					this._keyEvent( "previous", event );
					break;
				case keyCode.DOWN:
					this._keyEvent( "next", event );
					break;
				}
			},
			input: function( event ) {
				if ( suppressInput ) {
					suppressInput = false;
					event.preventDefault();
					return;
				}
				this._searchTimeout( event );
			},
			focus: function() {
				this.selectedItem = null;
				this.previous = this._value();
			},
			blur: function( event ) {
				if ( this.cancelBlur ) {
					delete this.cancelBlur;
					return;
				}

				clearTimeout( this.searching );
				this.close( event );
				this._change( event );
			}
		});

		this._initSource();
		this.menu = $( "<ul>" )
			.addClass( "ui-autocomplete" )
			.appendTo( this.document.find( this.options.appendTo || "body" )[ 0 ] )
			.menu({
				// custom key handling for now
				input: $(),
				// disable ARIA support, the live region takes care of that
				role: null
			})
			.zIndex( this.element.zIndex() + 1 )
			.hide()
			.data( "menu" );
		this._bind( this.menu.element, {
			mousedown: function( event ) {
				// prevent moving focus out of the text field
				event.preventDefault();

				// IE doesn't prevent moving focus even with event.preventDefault()
				// so we set a flag to know when we should ignore the blur event
				this.cancelBlur = true;
				this._delay(function() {
					delete this.cancelBlur;
				});

				// clicking on the scrollbar causes focus to shift to the body
				// but we can't detect a mouseup or a click immediately afterward
				// so we have to track the next mousedown and close the menu if
				// the user clicks somewhere outside of the autocomplete
				var menuElement = this.menu.element[ 0 ];
				if ( !$( event.target ).closest( ".ui-menu-item" ).length ) {
					this._delay(function() {
						var that = this;
						this.document.one( "mousedown", function( event ) {
							if ( event.target !== that.element[ 0 ] &&
									event.target !== menuElement &&
									!$.contains( menuElement, event.target ) ) {
								that.close();
							}
						});
					});
				}
			},
			menufocus: function( event, ui ) {
				// #7024 - Prevent accidental activation of menu items in Firefox
				if ( this.isNewMenu ) {
					this.isNewMenu = false;
					if ( event.originalEvent && /^mouse/.test( event.originalEvent.type ) ) {
						this.menu.blur();

						this.document.one( "mousemove", function() {
							$( event.target ).trigger( event.originalEvent );
						});

						return;
					}
				}

				// back compat for _renderItem using item.autocomplete, via #7810
				// TODO remove the fallback, see #8156
				var item = ui.item.data( "ui-autocomplete-item" ) || ui.item.data( "item.autocomplete" );
				if ( false !== this._trigger( "focus", event, { item: item } ) ) {
					// use value to match what will end up in the input, if it was a key event
					if ( event.originalEvent && /^key/.test( event.originalEvent.type ) ) {
						this._value( item.value );
					}
				} else {
					// Normally the input is populated with the item's value as the
					// menu is navigated, causing screen readers to notice a change and
					// announce the item. Since the focus event was canceled, this doesn't
					// happen, so we update the live region so that screen readers can
					// still notice the change and announce it.
					this.liveRegion.text( item.value );
				}
			},
			menuselect: function( event, ui ) {
				// back compat for _renderItem using item.autocomplete, via #7810
				// TODO remove the fallback, see #8156
				var item = ui.item.data( "ui-autocomplete-item" ) || ui.item.data( "item.autocomplete" ),
					previous = this.previous;

				// only trigger when focus was lost (click on menu)
				if ( this.element[0] !== this.document[0].activeElement ) {
					this.element.focus();
					this.previous = previous;
					// #6109 - IE triggers two focus events and the second
					// is asynchronous, so we need to reset the previous
					// term synchronously and asynchronously :-(
					this._delay(function() {
						this.previous = previous;
						this.selectedItem = item;
					});
				}

				if ( false !== this._trigger( "select", event, { item: item } ) ) {
					this._value( item.value );
				}
				// reset the term after the select event
				// this allows custom select handling to work properly
				this.term = this._value();

				this.close( event );
				this.selectedItem = item;
			}
		});

		this.liveRegion = $( "<span>", {
				role: "status",
				"aria-live": "polite"
			})
			.addClass( "ui-helper-hidden-accessible" )
			.insertAfter( this.element );

		if ( $.fn.bgiframe ) {
			 this.menu.element.bgiframe();
		}

		// turning off autocomplete prevents the browser from remembering the
		// value when navigating through history, so we re-enable autocomplete
		// if the page is unloaded before the widget is destroyed. #7790
		this._bind( this.window, {
			beforeunload: function() {
				this.element.removeAttr( "autocomplete" );
			}
		});
	},

	_destroy: function() {
		clearTimeout( this.searching );
		this.element
			.removeClass( "ui-autocomplete-input" )
			.removeAttr( "autocomplete" );
		this.menu.element.remove();
		this.liveRegion.remove();
	},

	_setOption: function( key, value ) {
		this._super( key, value );
		if ( key === "source" ) {
			this._initSource();
		}
		if ( key === "appendTo" ) {
			this.menu.element.appendTo( this.document.find( value || "body" )[0] );
		}
		if ( key === "disabled" && value && this.xhr ) {
			this.xhr.abort();
		}
	},

	_initSource: function() {
		var array, url,
			that = this;
		if ( $.isArray(this.options.source) ) {
			array = this.options.source;
			this.source = function( request, response ) {
				response( $.ui.autocomplete.filter( array, request.term,this.options.popMax,this.options.onpopMax) );
			};
		} else if ( typeof this.options.source === "string" ) {
			url = this.options.source;
			this.source = function( request, response ) {
				if ( that.xhr ) {
					that.xhr.abort();
				}
				that.xhr = $.ajax({
					url: url,
					data: request,
					dataType: "json",
					success: function( data, status ) {
						response( data );
					},
					error: function() {
						response( [] );
					}
				});
			};
		} else {
			this.source = this.options.source;
		}
	},

	_searchTimeout: function( event ) {
		clearTimeout( this.searching );
		this.searching = this._delay(function() {
			// only search if the value has changed
			if ( this.term !== this._value() ) {
				this.selectedItem = null;
				this.search( null, event );
			}
		}, this.options.delay );
	},

	search: function( value, event ) {
		value = value != null ? value : this._value();

		// always save the actual value, not the one passed as an argument
		this.term = this._value();

		if ( value.length < this.options.minLength ) {
			return this.close( event );
		}

		if ( this._trigger( "search", event ) === false ) {
			return;
		}

		return this._search( value );
	},

	_search: function( value ) {
		this.pending++;
		this.element.addClass( "ui-autocomplete-loading" );
		this.cancelSearch = false;

		this.source( { term: value }, this._response() );
	},

	_response: function() {
		var that = this,
			index = ++requestIndex;

		return function( content ) {
			if ( index === requestIndex ) {
				that.__response( content );
			}

			that.pending--;
			if ( !that.pending ) {
				that.element.removeClass( "ui-autocomplete-loading" );
			}
		};
	},

	__response: function( content ) {
		if ( content ) {
			content = this._normalize( content );
		}
		this._trigger( "response", null, { content: content } );
		if ( !this.options.disabled && content && content.length && !this.cancelSearch ) {
			this._suggest( content );
			this._trigger( "open" );
		} else {
			// use ._close() instead of .close() so we don't cancel future searches
			this._close();
		}
	},

	close: function( event ) {
		this.cancelSearch = true;
		this._close( event );
	},

	_close: function( event ) {
		if ( this.menu.element.is( ":visible" ) ) {
			this.menu.element.hide();
			this.menu.blur();
			this.isNewMenu = true;
			this._trigger( "close", event );
		}
	},

	_change: function( event ) {
		if ( this.previous !== this._value() ) {
			this._trigger( "change", event, { item: this.selectedItem } );
		}
	},

	_normalize: function( items ) {
		// assume all items have the right format when the first item is complete
		if ( items.length && items[0].label && items[0].value ) {
			return items;
		}
		return $.map( items, function( item ) {
			if ( typeof item === "string" ) {
				return {
					label: item,
					value: item
				};
			}
			return $.extend({
				label: item.label || item.value,
				value: item.value || item.label
			}, item );
		});
	},

	_suggest: function( items ) {
		var ul = this.menu.element
			.empty()
			.zIndex( this.element.zIndex() + 1 );
		this._renderMenu( ul, items );
		// TODO refresh should check if the active item is still in the dom, removing the need for a manual blur
		this.menu.blur();
		this.menu.refresh();

		// size and position menu
		ul.show();
		this._resizeMenu();
		ul.position( $.extend({
			of: this.element
		}, this.options.position ));

		if ( this.options.autoFocus ) {
			this.menu.next();
		}
	},

	_resizeMenu: function() {
		var ul = this.menu.element;
		ul.outerWidth( Math.max(
			// Firefox wraps long text (possibly a rounding bug)
			// so we add 1px to avoid the wrapping (#7513)
			ul.width( "" ).outerWidth() + 1,
			this.element.outerWidth()
		) );
	},

	_renderMenu: function( ul, items ) {
		var that = this;
		$.each( items, function( index, item ) {
			that._renderItemData( ul, item );
		});
	},

	_renderItemData: function( ul, item ) {
		return this._renderItem( ul, item ).data( "ui-autocomplete-item", item );
	},

	_renderItem: function( ul, item ) {
		return $( "<li>" )
			.append( $( "<a>" ).text( item.label ) )
			.appendTo( ul );
	},

	_move: function( direction, event ) {
		if ( !this.menu.element.is( ":visible" ) ) {
			this.search( null, event );
			return;
		}
		if ( this.menu.isFirstItem() && /^previous/.test( direction ) ||
				this.menu.isLastItem() && /^next/.test( direction ) ) {
			this._value( this.term );
			this.menu.blur();
			return;
		}
		this.menu[ direction ]( event );
	},

	widget: function() {
		return this.menu.element;
	},

	_value: function( value ) {
		return this.valueMethod.apply( this.element, arguments );
	},

	_keyEvent: function( keyEvent, event ) {
		if ( !this.isMultiLine || this.menu.element.is( ":visible" ) ) {
			this._move( keyEvent, event );

			// prevents moving cursor to beginning/end of the text field in some browsers
			event.preventDefault();
		}
	}
});

$.extend( $.ui.autocomplete, {
	escapeRegex: function( value ) {
		return value.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&");
	},
	filter: function(array, term,popMax,onpopMax) {
        //可设置auto的最大长度，提高性能
        var n=0;
        var ret=[];
		var matcher = new RegExp( $.ui.autocomplete.escapeRegex(term), "i" );
        for(var i=0;i<array.length;i++){
            if(matcher.test(array[i].label || array[i].value || array[i])){
                ret.push(array[i]);
                n++;
                if(popMax!=null&&n>popMax){
                    onpopMax(true);
                    return ret.slice(0,-1);
                }
            }
        }
        onpopMax(false);
        return ret;
//		return $.grep( array, function(value) {
//			return matcher.test( value.label || value.value || value );
//		});
	}
});

// live region extension, adding a `messages` option
// NOTE: This is an experimental API. We are still investigating
// a full solution for string manipulation and internationalization.
$.widget( "ui.autocomplete", $.ui.autocomplete, {
	options: {
		messages: {
			noResults: "No search results.",
			results: function(amount) {
				return amount + ( amount > 1 ? " results are" : " result is" ) +
					" available, use up and down arrow keys to navigate.";
			}
		}
	},

	__response: function( content ) {
		var message;
		this._superApply( arguments );
		if ( this.options.disabled || this.cancelSearch) {
			return;
		}
		if ( content && content.length ) {
			message = this.options.messages.results( content.length );
		} else {
			message = this.options.messages.noResults;
		}
		this.liveRegion.text( message );
	}
});

}( jQuery ));

/*
 * JQuery zTree core 3.2
 * http://code.google.com/p/jquerytree/
 *
 * Copyright (c) 2010 Hunter.z (baby666.cn)
 *
 * Licensed same as jquery - MIT License
 * http://www.opensource.org/licenses/mit-license.php
 *
 * email: hunter.z@263.net
 * Date: 2012-05-13
 */
(function($){
	var settings = {}, roots = {}, caches = {}, zId = 0,
	//default consts of core
	_consts = {
		event: {
			NODECREATED: "ztree_nodeCreated",
			CLICK: "ztree_click",
			EXPAND: "ztree_expand",
			COLLAPSE: "ztree_collapse",
			ASYNC_SUCCESS: "ztree_async_success",
			ASYNC_ERROR: "ztree_async_error"
		},
		id: {
			A: "_a",
			ICON: "_ico",
			SPAN: "_span",
			SWITCH: "_switch",
			UL: "_ul"
		},
		line: {
			ROOT: "root",
			ROOTS: "roots",
			CENTER: "center",
			BOTTOM: "bottom",
			NOLINE: "noline",
			LINE: "line"
		},
		folder: {
			OPEN: "open",
			CLOSE: "close",
			DOCU: "docu"
		},
		node: {
			CURSELECTED: "curSelectedNode"
		}
	},
	//default setting of core
	_setting = {
		treeId: "",
		treeObj: null,
		view: {
			addDiyDom: null,
			autoCancelSelected: true,
			dblClickExpand: true,
			expandSpeed: "fast",
			fontCss: {},
			nameIsHTML: false,
			selectedMulti: true,
			showIcon: true,
			showLine: true,
			showTitle: true
		},
		data: {
			key: {
				children: "children",
				name: "name",
				title: "",
				url: "url"
			},
			simpleData: {
				enable: false,
				idKey: "id",
				pIdKey: "pId",
				rootPId: null
			},
			keep: {
				parent: false,
				leaf: false
			}
		},
		async: {
			enable: false,
			contentType: "application/x-www-form-urlencoded",
			type: "post",
			dataType: "text",
			url: "",
			autoParam: [],
			otherParam: [],
			dataFilter: null
		},
		callback: {
			beforeAsync:null,
			beforeClick:null,
			beforeRightClick:null,
			beforeMouseDown:null,
			beforeMouseUp:null,
			beforeExpand:null,
			beforeCollapse:null,
			beforeRemove:null,

			onAsyncError:null,
			onAsyncSuccess:null,
			onNodeCreated:null,
			onClick:null,
			onRightClick:null,
			onMouseDown:null,
			onMouseUp:null,
			onExpand:null,
			onCollapse:null,
			onRemove:null
		}
	},
	//default root of core
	//zTree use root to save full data
	_initRoot = function (setting) {
		var r = data.getRoot(setting);
		if (!r) {
			r = {};
			data.setRoot(setting, r);
		}
		r.children = [];
		r.expandTriggerFlag = false;
		r.curSelectedList = [];
		r.noSelection = true;
		r.createdNodes = [];
	},
	//default cache of core
	_initCache = function(setting) {
		var c = data.getCache(setting);
		if (!c) {
			c = {};
			data.setCache(setting, c);
		}
		c.nodes = [];
		c.doms = [];
	},
	//default bindEvent of core
	_bindEvent = function(setting) {
		var o = setting.treeObj,
		c = consts.event;
		o.unbind(c.NODECREATED);
		o.bind(c.NODECREATED, function (event, treeId, node) {
			tools.apply(setting.callback.onNodeCreated, [event, treeId, node]);
		});

		o.unbind(c.CLICK);
		o.bind(c.CLICK, function (event, srcEvent, treeId, node, clickFlag) {
			tools.apply(setting.callback.onClick, [srcEvent, treeId, node, clickFlag]);
		});

		o.unbind(c.EXPAND);
		o.bind(c.EXPAND, function (event, treeId, node) {
			tools.apply(setting.callback.onExpand, [event, treeId, node]);
		});

		o.unbind(c.COLLAPSE);
		o.bind(c.COLLAPSE, function (event, treeId, node) {
			tools.apply(setting.callback.onCollapse, [event, treeId, node]);
		});

		o.unbind(c.ASYNC_SUCCESS);
		o.bind(c.ASYNC_SUCCESS, function (event, treeId, node, msg) {
			tools.apply(setting.callback.onAsyncSuccess, [event, treeId, node, msg]);
		});

		o.unbind(c.ASYNC_ERROR);
		o.bind(c.ASYNC_ERROR, function (event, treeId, node, XMLHttpRequest, textStatus, errorThrown) {
			tools.apply(setting.callback.onAsyncError, [event, treeId, node, XMLHttpRequest, textStatus, errorThrown]);
		});
	},
	//default event proxy of core
	_eventProxy = function(event) {
		var target = event.target,
		setting = settings[event.data.treeId],
		tId = "", node = null,
		nodeEventType = "", treeEventType = "",
		nodeEventCallback = null, treeEventCallback = null,
		tmp = null;

		if (tools.eqs(event.type, "mousedown")) {
			treeEventType = "mousedown";
		} else if (tools.eqs(event.type, "mouseup")) {
			treeEventType = "mouseup";
		} else if (tools.eqs(event.type, "contextmenu")) {
			treeEventType = "contextmenu";
		} else if (tools.eqs(event.type, "click")) {
			if (tools.eqs(target.tagName, "span") && target.getAttribute("treeNode"+ consts.id.SWITCH) !== null) {
				tId = target.parentNode.id;
				nodeEventType = "switchNode";
			} else {
				tmp = tools.getMDom(setting, target, [{tagName:"a", attrName:"treeNode"+consts.id.A}]);
				if (tmp) {
					tId = tmp.parentNode.id;
					nodeEventType = "clickNode";
				}
			}
		} else if (tools.eqs(event.type, "dblclick")) {
			treeEventType = "dblclick";
			tmp = tools.getMDom(setting, target, [{tagName:"a", attrName:"treeNode"+consts.id.A}]);
			if (tmp) {
				tId = tmp.parentNode.id;
				nodeEventType = "switchNode";
			}
		}
		if (treeEventType.length > 0 && tId.length == 0) {
			tmp = tools.getMDom(setting, target, [{tagName:"a", attrName:"treeNode"+consts.id.A}]);
			if (tmp) {tId = tmp.parentNode.id;}
		}
		// event to node
		if (tId.length>0) {
			node = data.getNodeCache(setting, tId);
			switch (nodeEventType) {
				case "switchNode" :
					if (!node.isParent) {
						nodeEventType = "";
					} else if (tools.eqs(event.type, "click") 
						|| (tools.eqs(event.type, "dblclick") && tools.apply(setting.view.dblClickExpand, [setting.treeId, node], setting.view.dblClickExpand))) {
						nodeEventCallback = handler.onSwitchNode;
					} else {
						nodeEventType = "";
					}
					break;
				case "clickNode" :
					nodeEventCallback = handler.onClickNode;
					break;
			}
		}
		// event to zTree
		switch (treeEventType) {
			case "mousedown" :
				treeEventCallback = handler.onZTreeMousedown;
				break;
			case "mouseup" :
				treeEventCallback = handler.onZTreeMouseup;
				break;
			case "dblclick" :
				treeEventCallback = handler.onZTreeDblclick;
				break;
			case "contextmenu" :
				treeEventCallback = handler.onZTreeContextmenu;
				break;
		}
		var proxyResult = {
			stop: false,
			node: node,
			nodeEventType: nodeEventType,
			nodeEventCallback: nodeEventCallback,
			treeEventType: treeEventType,
			treeEventCallback: treeEventCallback
		};
		return proxyResult
	},
	//default init node of core
	_initNode = function(setting, level, n, parentNode, isFirstNode, isLastNode, openFlag) {
		if (!n) return;
		var childKey = setting.data.key.children;
		n.level = level;
		n.tId = setting.treeId + "_" + (++zId);
		n.parentTId = parentNode ? parentNode.tId : null;
		if (n[childKey] && n[childKey].length > 0) {
			if (typeof n.open == "string") n.open = tools.eqs(n.open, "true");
			n.open = !!n.open;
			n.isParent = true;
			n.zAsync = true;
		} else {
			n.open = false;
			if (typeof n.isParent == "string") n.isParent = tools.eqs(n.isParent, "true");
			n.isParent = !!n.isParent;
			n.zAsync = !n.isParent;
		}
		n.isFirstNode = isFirstNode;
		n.isLastNode = isLastNode;
		n.getParentNode = function() {return data.getNodeCache(setting, n.parentTId);};
		n.getPreNode = function() {return data.getPreNode(setting, n);};
		n.getNextNode = function() {return data.getNextNode(setting, n);};
		n.isAjaxing = false;
		data.fixPIdKeyValue(setting, n);
	},
	_init = {
		bind: [_bindEvent],
		caches: [_initCache],
		nodes: [_initNode],
		proxys: [_eventProxy],
		roots: [_initRoot],
		beforeA: [],
		afterA: [],
		innerBeforeA: [],
		innerAfterA: [],
		zTreeTools: []
	},
	//method of operate data
	data = {
		addNodeCache: function(setting, node) {
			data.getCache(setting).nodes[node.tId] = node;
		},
		addAfterA: function(afterA) {
			_init.afterA.push(afterA);
		},
		addBeforeA: function(beforeA) {
			_init.beforeA.push(beforeA);
		},
		addInnerAfterA: function(innerAfterA) {
			_init.innerAfterA.push(innerAfterA);
		},
		addInnerBeforeA: function(innerBeforeA) {
			_init.innerBeforeA.push(innerBeforeA);
		},
		addInitBind: function(bindEvent) {
			_init.bind.push(bindEvent);
		},
		addInitCache: function(initCache) {
			_init.caches.push(initCache);
		},
		addInitNode: function(initNode) {
			_init.nodes.push(initNode);
		},
		addInitProxy: function(initProxy) {
			_init.proxys.push(initProxy);
		},
		addInitRoot: function(initRoot) {
			_init.roots.push(initRoot);
		},
		addNodesData: function(setting, parentNode, nodes) {
			var childKey = setting.data.key.children;
			if (!parentNode[childKey]) parentNode[childKey] = [];
			if (parentNode[childKey].length > 0) {
				parentNode[childKey][parentNode[childKey].length - 1].isLastNode = false;
				view.setNodeLineIcos(setting, parentNode[childKey][parentNode[childKey].length - 1]);
			}
			parentNode.isParent = true;
			parentNode[childKey] = parentNode[childKey].concat(nodes);
		},
		addSelectedNode: function(setting, node) {
			var root = data.getRoot(setting);
			if (!data.isSelectedNode(setting, node)) {
				root.curSelectedList.push(node);
			}
		},
		addCreatedNode: function(setting, node) {
			if (!!setting.callback.onNodeCreated || !!setting.view.addDiyDom) {
				var root = data.getRoot(setting);
				root.createdNodes.push(node);
			}
		},
		addZTreeTools: function(zTreeTools) {
			_init.zTreeTools.push(zTreeTools);
		},
		exSetting: function(s) {
			$.extend(true, _setting, s);
		},
		fixPIdKeyValue: function(setting, node) {
			if (setting.data.simpleData.enable) {
				node[setting.data.simpleData.pIdKey] = node.parentTId ? node.getParentNode()[setting.data.simpleData.idKey] : setting.data.simpleData.rootPId;
			}
		},
		getAfterA: function(setting, node, array) {
			for (var i=0, j=_init.afterA.length; i<j; i++) {
				_init.afterA[i].apply(this, arguments);
			}
		},
		getBeforeA: function(setting, node, array) {
			for (var i=0, j=_init.beforeA.length; i<j; i++) {
				_init.beforeA[i].apply(this, arguments);
			}
		},
		getInnerAfterA: function(setting, node, array) {
			for (var i=0, j=_init.innerAfterA.length; i<j; i++) {
				_init.innerAfterA[i].apply(this, arguments);
			}
		},
		getInnerBeforeA: function(setting, node, array) {
			for (var i=0, j=_init.innerBeforeA.length; i<j; i++) {
				_init.innerBeforeA[i].apply(this, arguments);
			}
		},
		getCache: function(setting) {
			return caches[setting.treeId];
		},
		getNextNode: function(setting, node) {
			if (!node) return null;
			var childKey = setting.data.key.children,
			p = node.parentTId ? node.getParentNode() : data.getRoot(setting);
			if (node.isLastNode) {
				return null;
			} else if (node.isFirstNode) {
				return p[childKey][1];
			} else {
				for (var i=1, l=p[childKey].length-1; i<l; i++) {
					if (p[childKey][i] === node) {
						return p[childKey][i+1];
					}
				}
			}
			return null;
		},
		getNodeByParam: function(setting, nodes, key, value) {
			if (!nodes || !key) return null;
			var childKey = setting.data.key.children;
			for (var i = 0, l = nodes.length; i < l; i++) {
				if (nodes[i][key] == value) {
					return nodes[i];
				}
				var tmp = data.getNodeByParam(setting, nodes[i][childKey], key, value);
				if (tmp) return tmp;
			}
			return null;
		},
		getNodeCache: function(setting, tId) {
			if (!tId) return null;
			var n = caches[setting.treeId].nodes[tId];
			return n ? n : null;
		},
		getNodes: function(setting) {
			return data.getRoot(setting)[setting.data.key.children];
		},
		getNodesByParam: function(setting, nodes, key, value) {
			if (!nodes || !key) return [];
			var childKey = setting.data.key.children,
			result = [];
			for (var i = 0, l = nodes.length; i < l; i++) {
				if (nodes[i][key] == value) {
					result.push(nodes[i]);
				}
				result = result.concat(data.getNodesByParam(setting, nodes[i][childKey], key, value));
			}
			return result;
		},
		getNodesByParamFuzzy: function(setting, nodes, key, value) {
			if (!nodes || !key) return [];
			var childKey = setting.data.key.children,
			result = [];
			for (var i = 0, l = nodes.length; i < l; i++) {
				if (typeof nodes[i][key] == "string" && nodes[i][key].indexOf(value)>-1) {
					result.push(nodes[i]);
				}
				result = result.concat(data.getNodesByParamFuzzy(setting, nodes[i][childKey], key, value));
			}
			return result;
		},
		getNodesByFilter: function(setting, nodes, filter, isSingle) {
			if (!nodes) return (isSingle ? null : []);
			var childKey = setting.data.key.children,
			result = isSingle ? null : [];
			for (var i = 0, l = nodes.length; i < l; i++) {
				if (tools.apply(filter, [nodes[i]], false)) {
					if (isSingle) {return nodes[i];}
					result.push(nodes[i]);
				}
				var tmpResult = data.getNodesByFilter(setting, nodes[i][childKey], filter, isSingle);
				if (isSingle && !!tmpResult) {return tmpResult;}
				result = isSingle ? tmpResult : result.concat(tmpResult);
			}
			return result;
		},
		getPreNode: function(setting, node) {
			if (!node) return null;
			var childKey = setting.data.key.children,
			p = node.parentTId ? node.getParentNode() : data.getRoot(setting);
			if (node.isFirstNode) {
				return null;
			} else if (node.isLastNode) {
				return p[childKey][p[childKey].length-2];
			} else {
				for (var i=1, l=p[childKey].length-1; i<l; i++) {
					if (p[childKey][i] === node) {
						return p[childKey][i-1];
					}
				}
			}
			return null;
		},
		getRoot: function(setting) {
			return setting ? roots[setting.treeId] : null;
		},
		getSetting: function(treeId) {
			return settings[treeId];
		},
		getSettings: function() {
			return settings;
		},
		getTitleKey: function(setting) {
			return setting.data.key.title === "" ? setting.data.key.name : setting.data.key.title;
		},
		getZTreeTools: function(treeId) {
			var r = this.getRoot(this.getSetting(treeId));
			return r ? r.treeTools : null;
		},
		initCache: function(setting) {
			for (var i=0, j=_init.caches.length; i<j; i++) {
				_init.caches[i].apply(this, arguments);
			}
		},
		initNode: function(setting, level, node, parentNode, preNode, nextNode) {
			for (var i=0, j=_init.nodes.length; i<j; i++) {
				_init.nodes[i].apply(this, arguments);
			}
		},
		initRoot: function(setting) {
			for (var i=0, j=_init.roots.length; i<j; i++) {
				_init.roots[i].apply(this, arguments);
			}
		},
		isSelectedNode: function(setting, node) {
			var root = data.getRoot(setting);
			for (var i=0, j=root.curSelectedList.length; i<j; i++) {
				if(node === root.curSelectedList[i]) return true;
			}
			return false;
		},
		removeNodeCache: function(setting, node) {
			var childKey = setting.data.key.children;
			if (node[childKey]) {
				for (var i=0, l=node[childKey].length; i<l; i++) {
					arguments.callee(setting, node[childKey][i]);
				}
			}
			delete data.getCache(setting).nodes[node.tId];
		},
		removeSelectedNode: function(setting, node) {
			var root = data.getRoot(setting);
			for (var i=0, j=root.curSelectedList.length; i<j; i++) {
				if(node === root.curSelectedList[i] || !data.getNodeCache(setting, root.curSelectedList[i].tId)) {
					root.curSelectedList.splice(i, 1);
					i--;j--;
				}
			}
		},
		setCache: function(setting, cache) {
			caches[setting.treeId] = cache;
		},
		setRoot: function(setting, root) {
			roots[setting.treeId] = root;
		},
		setZTreeTools: function(setting, zTreeTools) {
			for (var i=0, j=_init.zTreeTools.length; i<j; i++) {
				_init.zTreeTools[i].apply(this, arguments);
			}
		},
		transformToArrayFormat: function (setting, nodes) {
			if (!nodes) return [];
			var childKey = setting.data.key.children,
			r = [];
			if (tools.isArray(nodes)) {
				for (var i=0, l=nodes.length; i<l; i++) {
					r.push(nodes[i]);
					if (nodes[i][childKey])
						r = r.concat(data.transformToArrayFormat(setting, nodes[i][childKey]));
				}
			} else {
				r.push(nodes);
				if (nodes[childKey])
					r = r.concat(data.transformToArrayFormat(setting, nodes[childKey]));
			}
			return r;
		},
		transformTozTreeFormat: function(setting, sNodes) {
			var i,l,
			key = setting.data.simpleData.idKey,
			parentKey = setting.data.simpleData.pIdKey,
			childKey = setting.data.key.children;
			if (!key || key=="" || !sNodes) return [];

			if (tools.isArray(sNodes)) {
				var r = [];
				var tmpMap = [];
				for (i=0, l=sNodes.length; i<l; i++) {
					tmpMap[sNodes[i][key]] = sNodes[i];
				}
				for (i=0, l=sNodes.length; i<l; i++) {
					if (tmpMap[sNodes[i][parentKey]] && sNodes[i][key] != sNodes[i][parentKey]) {
						if (!tmpMap[sNodes[i][parentKey]][childKey])
							tmpMap[sNodes[i][parentKey]][childKey] = [];
						tmpMap[sNodes[i][parentKey]][childKey].push(sNodes[i]);
					} else {
						r.push(sNodes[i]);
					}
				}
				return r;
			}else {
				return [sNodes];
			}
		}
	},
	//method of event proxy
	event = {
		bindEvent: function(setting) {
			for (var i=0, j=_init.bind.length; i<j; i++) {
				_init.bind[i].apply(this, arguments);
			}
		},
		bindTree: function(setting) {
			var eventParam = {
				treeId: setting.treeId
			},
			o = setting.treeObj;
			o.unbind('click', event.proxy);
			o.bind('click', eventParam, event.proxy);
			o.unbind('dblclick', event.proxy);
			o.bind('dblclick', eventParam, event.proxy);
			o.unbind('mouseover', event.proxy);
			o.bind('mouseover', eventParam, event.proxy);
			o.unbind('mouseout', event.proxy);
			o.bind('mouseout', eventParam, event.proxy);
			o.unbind('mousedown', event.proxy);
			o.bind('mousedown', eventParam, event.proxy);
			o.unbind('mouseup', event.proxy);
			o.bind('mouseup', eventParam, event.proxy);
			o.unbind('contextmenu', event.proxy);
			o.bind('contextmenu', eventParam, event.proxy);
		},
		doProxy: function(e) {
			var results = [];
			for (var i=0, j=_init.proxys.length; i<j; i++) {
				var proxyResult = _init.proxys[i].apply(this, arguments);
				results.push(proxyResult);
				if (proxyResult.stop) {
					break;
				}
			}
			return results;
		},
		proxy: function(e) {
			var setting = data.getSetting(e.data.treeId);
			if (!tools.uCanDo(setting, e)) return true;
			var results = event.doProxy(e),
			r = true, x = false;
			for (var i=0, l=results.length; i<l; i++) {
				var proxyResult = results[i];
				if (proxyResult.nodeEventCallback) {
					x = true;
					r = proxyResult.nodeEventCallback.apply(proxyResult, [e, proxyResult.node]) && r;
				}
				if (proxyResult.treeEventCallback) {
					x = true;
					r = proxyResult.treeEventCallback.apply(proxyResult, [e, proxyResult.node]) && r;
				}
			}
			try{
				if (x && $("input:focus").length == 0) {
					tools.noSel(setting);
				}
			} catch(e) {}
			return r;
		}
	},
	//method of event handler
	handler = {
		onSwitchNode: function (event, node) {
			var setting = settings[event.data.treeId];
			if (node.open) {
				if (tools.apply(setting.callback.beforeCollapse, [setting.treeId, node], true) == false) return true;
				data.getRoot(setting).expandTriggerFlag = true;
				view.switchNode(setting, node);
			} else {
				if (tools.apply(setting.callback.beforeExpand, [setting.treeId, node], true) == false) return true;
				data.getRoot(setting).expandTriggerFlag = true;
				view.switchNode(setting, node);
			}
			return true;
		},
		onClickNode: function (event, node) {
			var setting = settings[event.data.treeId],
			clickFlag = ( (setting.view.autoCancelSelected && event.ctrlKey) && data.isSelectedNode(setting, node)) ? 0 : (setting.view.autoCancelSelected && event.ctrlKey && setting.view.selectedMulti) ? 2 : 1;
			if (tools.apply(setting.callback.beforeClick, [setting.treeId, node, clickFlag], true) == false) return true;
			if (clickFlag === 0) {
				view.cancelPreSelectedNode(setting, node);
			} else {
				view.selectNode(setting, node, clickFlag === 2);
			}
			setting.treeObj.trigger(consts.event.CLICK, [event, setting.treeId, node, clickFlag]);
			return true;
		},
		onZTreeMousedown: function(event, node) {
			var setting = settings[event.data.treeId];
			if (tools.apply(setting.callback.beforeMouseDown, [setting.treeId, node], true)) {
				tools.apply(setting.callback.onMouseDown, [event, setting.treeId, node]);
			}
			return true;
		},
		onZTreeMouseup: function(event, node) {
			var setting = settings[event.data.treeId];
			if (tools.apply(setting.callback.beforeMouseUp, [setting.treeId, node], true)) {
				tools.apply(setting.callback.onMouseUp, [event, setting.treeId, node]);
			}
			return true;
		},
		onZTreeDblclick: function(event, node) {
			var setting = settings[event.data.treeId];
			if (tools.apply(setting.callback.beforeDblClick, [setting.treeId, node], true)) {
				tools.apply(setting.callback.onDblClick, [event, setting.treeId, node]);
			}
			return true;
		},
		onZTreeContextmenu: function(event, node) {
			var setting = settings[event.data.treeId];
			if (tools.apply(setting.callback.beforeRightClick, [setting.treeId, node], true)) {
				tools.apply(setting.callback.onRightClick, [event, setting.treeId, node]);
			}
			return (typeof setting.callback.onRightClick) != "function";
		}
	},
	//method of tools for zTree
	tools = {
		apply: function(fun, param, defaultValue) {
			if ((typeof fun) == "function") {
				return fun.apply(zt, param?param:[]);
			}
			return defaultValue;
		},
		canAsync: function(setting, node) {
			var childKey = setting.data.key.children;
			return (setting.async.enable && node && node.isParent && !(node.zAsync || (node[childKey] && node[childKey].length > 0)));
		},
		clone: function (jsonObj) {
			var buf;
			if (jsonObj instanceof Array) {
				buf = [];
				var i = jsonObj.length;
				while (i--) {
					buf[i] = arguments.callee(jsonObj[i]);
				}
				return buf;
			}else if (typeof jsonObj == "function"){
				return jsonObj;
			}else if (jsonObj instanceof Object){
				buf = {};
				for (var k in jsonObj) {
					buf[k] = arguments.callee(jsonObj[k]);
				}
				return buf;
			}else{
				return jsonObj;
			}
		},
		eqs: function(str1, str2) {
			return str1.toLowerCase() === str2.toLowerCase();
		},
		isArray: function(arr) {
			return Object.prototype.toString.apply(arr) === "[object Array]";
		},
		getMDom: function (setting, curDom, targetExpr) {
			if (!curDom) return null;
			while (curDom && curDom.id !== setting.treeId) {
				for (var i=0, l=targetExpr.length; curDom.tagName && i<l; i++) {
					if (tools.eqs(curDom.tagName, targetExpr[i].tagName) && curDom.getAttribute(targetExpr[i].attrName) !== null) {
						return curDom;
					}
				}
				curDom = curDom.parentNode;
			}
			return null;
		},
		noSel: function(setting) {
			var r = data.getRoot(setting);
			if (r.noSelection) {
				try {
					window.getSelection ? window.getSelection().removeAllRanges() : document.selection.empty();
				} catch(e){}
			}
		},
		uCanDo: function(setting, e) {
			return true;
		}
	},
	//method of operate ztree dom
	view = {
		addNodes: function(setting, parentNode, newNodes, isSilent) {
			if (setting.data.keep.leaf && parentNode && !parentNode.isParent) {
				return;
			}
			if (!tools.isArray(newNodes)) {
				newNodes = [newNodes];
			}
			if (setting.data.simpleData.enable) {
				newNodes = data.transformTozTreeFormat(setting, newNodes);
			}
			if (parentNode) {
				var target_switchObj = $("#" + parentNode.tId + consts.id.SWITCH),
				target_icoObj = $("#" + parentNode.tId + consts.id.ICON),
				target_ulObj = $("#" + parentNode.tId + consts.id.UL);

				if (!parentNode.open) {
					view.replaceSwitchClass(parentNode, target_switchObj, consts.folder.CLOSE);
					view.replaceIcoClass(parentNode, target_icoObj, consts.folder.CLOSE);
					parentNode.open = false;
					target_ulObj.css({
						"display": "none"
					});
				}

				data.addNodesData(setting, parentNode, newNodes);
				view.createNodes(setting, parentNode.level + 1, newNodes, parentNode);
				if (!isSilent) {
					view.expandCollapseParentNode(setting, parentNode, true);
				}
			} else {
				data.addNodesData(setting, data.getRoot(setting), newNodes);
				view.createNodes(setting, 0, newNodes, null);
			}
		},
		appendNodes: function(setting, level, nodes, parentNode, initFlag, openFlag) {
			if (!nodes) return [];
			var html = [],
			childKey = setting.data.key.children,
			nameKey = setting.data.key.name,
			titleKey = data.getTitleKey(setting);
			for (var i = 0, l = nodes.length; i < l; i++) {
				var node = nodes[i],
				tmpPNode = (parentNode) ? parentNode: data.getRoot(setting),
				tmpPChild = tmpPNode[childKey],
				isFirstNode = ((tmpPChild.length == nodes.length) && (i == 0)),
				isLastNode = (i == (nodes.length - 1));
				if (initFlag) {
					data.initNode(setting, level, node, parentNode, isFirstNode, isLastNode, openFlag);
					data.addNodeCache(setting, node);
				}

				var childHtml = [];
				if (node[childKey] && node[childKey].length > 0) {
					//make child html first, because checkType
					childHtml = view.appendNodes(setting, level + 1, node[childKey], node, initFlag, openFlag && node.open);
				}
				if (openFlag) {
					var url = view.makeNodeUrl(setting, node),
					fontcss = view.makeNodeFontCss(setting, node),
					fontStyle = [];
					for (var f in fontcss) {
						fontStyle.push(f, ":", fontcss[f], ";");
					}
					html.push("<li id='", node.tId, "' class='level", node.level,"' tabindex='0' hidefocus='true' treenode>",
						"<span id='", node.tId, consts.id.SWITCH,
						"' title='' class='", view.makeNodeLineClass(setting, node), "' treeNode", consts.id.SWITCH,"></span>");
					data.getBeforeA(setting, node, html);
					html.push("<a id='", node.tId, consts.id.A, "' class='level", node.level,"' treeNode", consts.id.A," onclick=\"", (node.click || ''),
						"\" ", ((url != null && url.length > 0) ? "href='" + url + "'" : ""), " target='",view.makeNodeTarget(node),"' style='", fontStyle.join(''),
						"'");
					if (tools.apply(setting.view.showTitle, [setting.treeId, node], setting.view.showTitle) && node[titleKey]) {html.push("title='", node[titleKey].replace(/'/g,"&#39;").replace(/</g,'&lt;').replace(/>/g,'&gt;'),"'");}
					html.push(">");
					data.getInnerBeforeA(setting, node, html);
					var name = setting.view.nameIsHTML ? node[nameKey] : node[nameKey].replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
					html.push("<span id='", node.tId, consts.id.ICON,
						"' title='' treeNode", consts.id.ICON," class='", view.makeNodeIcoClass(setting, node), "' style='", view.makeNodeIcoStyle(setting, node), "'></span><span id='", node.tId, consts.id.SPAN,
						"'>",name,"</span>");
					data.getInnerAfterA(setting, node, html);
					html.push("</a>");
					data.getAfterA(setting, node, html);
					if (node.isParent && node.open) {
						view.makeUlHtml(setting, node, html, childHtml.join(''));
					}
					html.push("</li>");
					data.addCreatedNode(setting, node);
				}
			}
			return html;
		},
		appendParentULDom: function(setting, node) {
			var html = [],
			nObj = $("#" + node.tId),
			ulObj = $("#" + node.tId + consts.id.UL),
			childKey = setting.data.key.children,
			childHtml = view.appendNodes(setting, node.level+1, node[childKey], node, false, true);
			view.makeUlHtml(setting, node, html, childHtml.join(''));
			if (!nObj.get(0) && !!node.parentTId) {
				view.appendParentULDom(setting, node.getParentNode());
				nObj = $("#" + node.tId);
			}
			if (ulObj.get(0)) {
				ulObj.remove();
			}

			nObj.append(html.join(''));
			view.createNodeCallback(setting);
		},
		asyncNode: function(setting, node, isSilent, callback) {
			var i, l;
			if (node && !node.isParent) {
				tools.apply(callback);
				return false;
			} else if (node && node.isAjaxing) {
				return false;
			} else if (tools.apply(setting.callback.beforeAsync, [setting.treeId, node], true) == false) {
				tools.apply(callback);
				return false;
			}
			if (node) {
				node.isAjaxing = true;
				var icoObj = $("#" + node.tId + consts.id.ICON);
				icoObj.attr({"style":"", "class":"button ico_loading"});
			}

			var isJson = (setting.async.contentType == "application/json"), tmpParam = isJson ? "{" : "", jTemp="";
			for (i = 0, l = setting.async.autoParam.length; node && i < l; i++) {
				var pKey = setting.async.autoParam[i].split("="), spKey = pKey;
				if (pKey.length>1) {
					spKey = pKey[1];
					pKey = pKey[0];
				}
				if (isJson) {
					jTemp = (typeof node[pKey] == "string") ? '"' : '';
					tmpParam += '"' + spKey + ('":' + jTemp + node[pKey]).replace(/'/g,'\\\'') + jTemp + ',';
				} else {
					tmpParam += spKey + ("=" + node[pKey]).replace(/&/g,'%26') + "&";
				}
			}
			if (tools.isArray(setting.async.otherParam)) {
				for (i = 0, l = setting.async.otherParam.length; i < l; i += 2) {
					if (isJson) {
						jTemp = (typeof setting.async.otherParam[i + 1] == "string") ? '"' : '';
						tmpParam += '"' + setting.async.otherParam[i] + ('":' + jTemp + setting.async.otherParam[i + 1]).replace(/'/g,'\\\'') + jTemp + ",";
					} else {
						tmpParam += setting.async.otherParam[i] + ("=" + setting.async.otherParam[i + 1]).replace(/&/g,'%26') + "&";
					}
				}
			} else {
				for (var p in setting.async.otherParam) {
					if (isJson) {
						jTemp = (typeof setting.async.otherParam[p] == "string") ? '"' : '';
						tmpParam += '"' + p + ('":' + jTemp + setting.async.otherParam[p]).replace(/'/g,'\\\'') + jTemp + ",";
					} else {
						tmpParam += p + ("=" + setting.async.otherParam[p]).replace(/&/g,'%26') + "&";
					}
				}
			}
			if (tmpParam.length > 1) tmpParam = tmpParam.substring(0, tmpParam.length-1);
			if (isJson) tmpParam += "}";

			$.ajax({
				contentType: setting.async.contentType,
				type: setting.async.type,
				url: tools.apply(setting.async.url, [setting.treeId, node], setting.async.url),
				data: tmpParam,
				dataType: setting.async.dataType,
				success: function(msg) {
					var newNodes = [];
					try {
						if (!msg || msg.length == 0) {
							newNodes = [];
						} else if (typeof msg == "string") {
							newNodes = eval("(" + msg + ")");
						} else {
							newNodes = msg;
						}
					} catch(err) {}

					if (node) {
						node.isAjaxing = null;
						node.zAsync = true;
					}
					view.setNodeLineIcos(setting, node);
					if (newNodes && newNodes != "") {
						newNodes = tools.apply(setting.async.dataFilter, [setting.treeId, node, newNodes], newNodes);
						view.addNodes(setting, node, !!newNodes ? tools.clone(newNodes) : [], !!isSilent);
					} else {
						view.addNodes(setting, node, [], !!isSilent);
					}
					setting.treeObj.trigger(consts.event.ASYNC_SUCCESS, [setting.treeId, node, msg]);
					tools.apply(callback);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					if (node) node.isAjaxing = null;
					view.setNodeLineIcos(setting, node);
					setting.treeObj.trigger(consts.event.ASYNC_ERROR, [setting.treeId, node, XMLHttpRequest, textStatus, errorThrown]);
				}
			});
			return true;
		},
		cancelPreSelectedNode: function (setting, node) {
			var list = data.getRoot(setting).curSelectedList;
			for (var i=0, j=list.length-1; j>=i; j--) {
				if (!node || node === list[j]) {
					$("#" + list[j].tId + consts.id.A).removeClass(consts.node.CURSELECTED);
					view.setNodeName(setting, list[j]);
					if (node) {
						data.removeSelectedNode(setting, node);
						break;
					}
				}
			}
			if (!node) data.getRoot(setting).curSelectedList = [];
		},
		createNodeCallback: function(setting) {
			if (!!setting.callback.onNodeCreated || !!setting.view.addDiyDom) {
				var root = data.getRoot(setting);
				while (root.createdNodes.length>0) {
					var node = root.createdNodes.shift();
					tools.apply(setting.view.addDiyDom, [setting.treeId, node]);
					if (!!setting.callback.onNodeCreated) {
						setting.treeObj.trigger(consts.event.NODECREATED, [setting.treeId, node]);
					}
				}
			}
		},
		createNodes: function(setting, level, nodes, parentNode) {
			if (!nodes || nodes.length == 0) return;
			var root = data.getRoot(setting),
			childKey = setting.data.key.children,
			openFlag = !parentNode || parentNode.open || !!$("#" + parentNode[childKey][0].tId).get(0);
			root.createdNodes = [];
			var zTreeHtml = view.appendNodes(setting, level, nodes, parentNode, true, openFlag);
			if (!parentNode) {
				setting.treeObj.append(zTreeHtml.join(''));
			} else {
				var ulObj = $("#" + parentNode.tId + consts.id.UL);
				if (ulObj.get(0)) {
					ulObj.append(zTreeHtml.join(''));
				}
			}
			view.createNodeCallback(setting);
		},
		expandCollapseNode: function(setting, node, expandFlag, animateFlag, callback) {
			var root = data.getRoot(setting),
			childKey = setting.data.key.children;
			if (!node) {
				tools.apply(callback, []);
				return;
			}
			if (root.expandTriggerFlag) {
				var _callback = callback;
				callback = function(){
					if (_callback) _callback();
					if (node.open) {
						setting.treeObj.trigger(consts.event.EXPAND, [setting.treeId, node]);
					} else {
						setting.treeObj.trigger(consts.event.COLLAPSE, [setting.treeId, node]);
					}
				};
				root.expandTriggerFlag = false;
			}
			if (node.open == expandFlag) {
				tools.apply(callback, []);
				return;
			}
			if (!node.open && node.isParent && ((!$("#" + node.tId + consts.id.UL).get(0)) || (node[childKey] && node[childKey].length>0 && !$("#" + node[childKey][0].tId).get(0)))) {
				view.appendParentULDom(setting, node);
			}
			var ulObj = $("#" + node.tId + consts.id.UL),
			switchObj = $("#" + node.tId + consts.id.SWITCH),
			icoObj = $("#" + node.tId + consts.id.ICON);

			if (node.isParent) {
				node.open = !node.open;
				if (node.iconOpen && node.iconClose) {
					icoObj.attr("style", view.makeNodeIcoStyle(setting, node));
				}

				if (node.open) {
					view.replaceSwitchClass(node, switchObj, consts.folder.OPEN);
					view.replaceIcoClass(node, icoObj, consts.folder.OPEN);
					if (animateFlag == false || setting.view.expandSpeed == "") {
						ulObj.show();
						tools.apply(callback, []);
					} else {
						if (node[childKey] && node[childKey].length > 0) {
							ulObj.slideDown(setting.view.expandSpeed, callback);
						} else {
							ulObj.show();
							tools.apply(callback, []);
						}
					}
				} else {
					view.replaceSwitchClass(node, switchObj, consts.folder.CLOSE);
					view.replaceIcoClass(node, icoObj, consts.folder.CLOSE);
					if (animateFlag == false || setting.view.expandSpeed == "" || !(node[childKey] && node[childKey].length > 0)) {
						ulObj.hide();
						tools.apply(callback, []);
					} else {
						ulObj.slideUp(setting.view.expandSpeed, callback);
					}
				}
			} else {
				tools.apply(callback, []);
			}
		},
		expandCollapseParentNode: function(setting, node, expandFlag, animateFlag, callback) {
			if (!node) return;
			if (!node.parentTId) {
				view.expandCollapseNode(setting, node, expandFlag, animateFlag, callback);
				return;
			} else {
				view.expandCollapseNode(setting, node, expandFlag, animateFlag);
			}
			if (node.parentTId) {
				view.expandCollapseParentNode(setting, node.getParentNode(), expandFlag, animateFlag, callback);
			}
		},
		expandCollapseSonNode: function(setting, node, expandFlag, animateFlag, callback) {
			var root = data.getRoot(setting),
			childKey = setting.data.key.children,
			treeNodes = (node) ? node[childKey]: root[childKey],
			selfAnimateSign = (node) ? false : animateFlag,
			expandTriggerFlag = data.getRoot(setting).expandTriggerFlag;
			data.getRoot(setting).expandTriggerFlag = false;
			if (treeNodes) {
				for (var i = 0, l = treeNodes.length; i < l; i++) {
					if (treeNodes[i]) view.expandCollapseSonNode(setting, treeNodes[i], expandFlag, selfAnimateSign);
				}
			}
			data.getRoot(setting).expandTriggerFlag = expandTriggerFlag;
			view.expandCollapseNode(setting, node, expandFlag, animateFlag, callback );
		},
		makeNodeFontCss: function(setting, node) {
			var fontCss = tools.apply(setting.view.fontCss, [setting.treeId, node], setting.view.fontCss);
			return (fontCss && ((typeof fontCss) != "function")) ? fontCss : {};
		},
		makeNodeIcoClass: function(setting, node) {
			var icoCss = ["ico"];
			if (!node.isAjaxing) {
				icoCss[0] = (node.iconSkin ? node.iconSkin + "_" : "") + icoCss[0];
				if (node.isParent) {
					icoCss.push(node.open ? consts.folder.OPEN : consts.folder.CLOSE);
				} else {
					icoCss.push(consts.folder.DOCU);
				}
			}
			return "button " + icoCss.join('_');
		},
		makeNodeIcoStyle: function(setting, node) {
			var icoStyle = [];
			if (!node.isAjaxing) {
				var icon = (node.isParent && node.iconOpen && node.iconClose) ? (node.open ? node.iconOpen : node.iconClose) : node.icon;
				if (icon) icoStyle.push("background:url(", icon, ") 0 0 no-repeat;");
				if (setting.view.showIcon == false || !tools.apply(setting.view.showIcon, [setting.treeId, node], true)) {
					icoStyle.push("width:0px;height:0px;");
				}
			}
			return icoStyle.join('');
		},
		makeNodeLineClass: function(setting, node) {
			var lineClass = [];
			if (setting.view.showLine) {
				if (node.level == 0 && node.isFirstNode && node.isLastNode) {
					lineClass.push(consts.line.ROOT);
				} else if (node.level == 0 && node.isFirstNode) {
					lineClass.push(consts.line.ROOTS);
				} else if (node.isLastNode) {
					lineClass.push(consts.line.BOTTOM);
				} else {
					lineClass.push(consts.line.CENTER);
				}
			} else {
				lineClass.push(consts.line.NOLINE);
			}
			if (node.isParent) {
				lineClass.push(node.open ? consts.folder.OPEN : consts.folder.CLOSE);
			} else {
				lineClass.push(consts.folder.DOCU);
			}
			return view.makeNodeLineClassEx(node) + lineClass.join('_');
		},
		makeNodeLineClassEx: function(node) {
			return "button level" + node.level + " switch ";
		},
		makeNodeTarget: function(node) {
			return (node.target || "_blank");
		},
		makeNodeUrl: function(setting, node) {
			var urlKey = setting.data.key.url;
			return node[urlKey] ? node[urlKey] : null;
		},
		makeUlHtml: function(setting, node, html, content) {
			html.push("<ul id='", node.tId, consts.id.UL, "' class='level", node.level, " ", view.makeUlLineClass(setting, node), "' style='display:", (node.open ? "block": "none"),"'>");
			html.push(content);
			html.push("</ul>");
		},
		makeUlLineClass: function(setting, node) {
			return ((setting.view.showLine && !node.isLastNode) ? consts.line.LINE : "");
		},
		removeChildNodes: function(setting, node) {
			if (!node) return;
			var childKey = setting.data.key.children,
			nodes = node[childKey];
			if (!nodes) return;

			for (var i = 0, l = nodes.length; i < l; i++) {
				data.removeNodeCache(setting, nodes[i]);
			}
			data.removeSelectedNode(setting);
			delete node[childKey];

			if (!setting.data.keep.parent) {
				node.isParent = false;
				node.open = false;
				var tmp_switchObj = $("#" + node.tId + consts.id.SWITCH),
				tmp_icoObj = $("#" + node.tId + consts.id.ICON);
				view.replaceSwitchClass(node, tmp_switchObj, consts.folder.DOCU);
				view.replaceIcoClass(node, tmp_icoObj, consts.folder.DOCU);
				$("#" + node.tId + consts.id.UL).remove();
			} else {
				$("#" + node.tId + consts.id.UL).empty();
			}
		},
		removeNode: function(setting, node) {
			var root = data.getRoot(setting),
			childKey = setting.data.key.children,
			parentNode = (node.parentTId) ? node.getParentNode() : root;

			node.isFirstNode = false;
			node.isLastNode = false;
			node.getPreNode = function() {return null;};
			node.getNextNode = function() {return null;};

			$("#" + node.tId).remove();
			data.removeNodeCache(setting, node);
			data.removeSelectedNode(setting, node);

			for (var i = 0, l = parentNode[childKey].length; i < l; i++) {
				if (parentNode[childKey][i].tId == node.tId) {
					parentNode[childKey].splice(i, 1);
					break;
				}
			}
			var tmp_ulObj,tmp_switchObj,tmp_icoObj;

			//repair nodes old parent
			if (!setting.data.keep.parent && parentNode[childKey].length < 1) {
				//old parentNode has no child nodes
				parentNode.isParent = false;
				parentNode.open = false;
				tmp_ulObj = $("#" + parentNode.tId + consts.id.UL);
				tmp_switchObj = $("#" + parentNode.tId + consts.id.SWITCH);
				tmp_icoObj = $("#" + parentNode.tId + consts.id.ICON);
				view.replaceSwitchClass(parentNode, tmp_switchObj, consts.folder.DOCU);
				view.replaceIcoClass(parentNode, tmp_icoObj, consts.folder.DOCU);
				tmp_ulObj.css("display", "none");

			} else if (setting.view.showLine && parentNode[childKey].length > 0) {
				//old parentNode has child nodes
				var newLast = parentNode[childKey][parentNode[childKey].length - 1];
				newLast.isLastNode = true;
				newLast.isFirstNode = (parentNode[childKey].length == 1);
				tmp_ulObj = $("#" + newLast.tId + consts.id.UL);
				tmp_switchObj = $("#" + newLast.tId + consts.id.SWITCH);
				tmp_icoObj = $("#" + newLast.tId + consts.id.ICON);
				if (parentNode == root) {
					if (parentNode[childKey].length == 1) {
						//node was root, and ztree has only one root after move node
						view.replaceSwitchClass(newLast, tmp_switchObj, consts.line.ROOT);
					} else {
						var tmp_first_switchObj = $("#" + parentNode[childKey][0].tId + consts.id.SWITCH);
						view.replaceSwitchClass(parentNode[childKey][0], tmp_first_switchObj, consts.line.ROOTS);
						view.replaceSwitchClass(newLast, tmp_switchObj, consts.line.BOTTOM);
					}
				} else {
					view.replaceSwitchClass(newLast, tmp_switchObj, consts.line.BOTTOM);
				}
				tmp_ulObj.removeClass(consts.line.LINE);
			}
		},
		replaceIcoClass: function(node, obj, newName) {
			if (!obj || node.isAjaxing) return;
			var tmpName = obj.attr("class");
			if (tmpName == undefined) return;
			var tmpList = tmpName.split("_");
			switch (newName) {
				case consts.folder.OPEN:
				case consts.folder.CLOSE:
				case consts.folder.DOCU:
					tmpList[tmpList.length-1] = newName;
					break;
			}
			obj.attr("class", tmpList.join("_"));
		},
		replaceSwitchClass: function(node, obj, newName) {
			if (!obj) return;
			var tmpName = obj.attr("class");
			if (tmpName == undefined) return;
			var tmpList = tmpName.split("_");
			switch (newName) {
				case consts.line.ROOT:
				case consts.line.ROOTS:
				case consts.line.CENTER:
				case consts.line.BOTTOM:
				case consts.line.NOLINE:
					tmpList[0] = view.makeNodeLineClassEx(node) + newName;
					break;
				case consts.folder.OPEN:
				case consts.folder.CLOSE:
				case consts.folder.DOCU:
					tmpList[1] = newName;
					break;
			}
			obj.attr("class", tmpList.join("_"));
			if (newName !== consts.folder.DOCU) {
				obj.removeAttr("disabled");
			} else {
				obj.attr("disabled", "disabled");
			}
		},
		selectNode: function(setting, node, addFlag) {
			if (!addFlag) {
				view.cancelPreSelectedNode(setting);
			}
			$("#" + node.tId + consts.id.A).addClass(consts.node.CURSELECTED);
			data.addSelectedNode(setting, node);
		},
		setNodeFontCss: function(setting, treeNode) {
			var aObj = $("#" + treeNode.tId + consts.id.A),
			fontCss = view.makeNodeFontCss(setting, treeNode);
			if (fontCss) {
				aObj.css(fontCss);
			}
		},
		setNodeLineIcos: function(setting, node) {
			if (!node) return;
			var switchObj = $("#" + node.tId + consts.id.SWITCH),
			ulObj = $("#" + node.tId + consts.id.UL),
			icoObj = $("#" + node.tId + consts.id.ICON),
			ulLine = view.makeUlLineClass(setting, node);
			if (ulLine.length==0) {
				ulObj.removeClass(consts.line.LINE);
			} else {
				ulObj.addClass(ulLine);
			}
			switchObj.attr("class", view.makeNodeLineClass(setting, node));
			if (node.isParent) {
				switchObj.removeAttr("disabled");
			} else {
				switchObj.attr("disabled", "disabled");
			}
			icoObj.removeAttr("style");
			icoObj.attr("style", view.makeNodeIcoStyle(setting, node));
			icoObj.attr("class", view.makeNodeIcoClass(setting, node));
		},
		setNodeName: function(setting, node) {
			var nameKey = setting.data.key.name,
			titleKey = data.getTitleKey(setting),
			nObj = $("#" + node.tId + consts.id.SPAN);
			nObj.empty();
			if (setting.view.nameIsHTML) {
				nObj.html(node[nameKey]);
			} else {
				nObj.text(node[nameKey]);
			}
			if (tools.apply(setting.view.showTitle, [setting.treeId, node], setting.view.showTitle) && node[titleKey]) {
				var aObj = $("#" + node.tId + consts.id.A);
				aObj.attr("title", node[titleKey]);
			}
		},
		setNodeTarget: function(node) {
			var aObj = $("#" + node.tId + consts.id.A);
			aObj.attr("target", view.makeNodeTarget(node));
		},
		setNodeUrl: function(setting, node) {
			var aObj = $("#" + node.tId + consts.id.A),
			url = view.makeNodeUrl(setting, node);
			if (url == null || url.length == 0) {
				aObj.removeAttr("href");
			} else {
				aObj.attr("href", url);
			}
		},
		switchNode: function(setting, node) {
			if (node.open || !tools.canAsync(setting, node)) {
				view.expandCollapseNode(setting, node, !node.open);
			} else if (setting.async.enable) {
				if (!view.asyncNode(setting, node)) {
					view.expandCollapseNode(setting, node, !node.open);
					return;
				}
			} else if (node) {
				view.expandCollapseNode(setting, node, !node.open);
			}
		}
	};
	// zTree defind
	$.fn.zTree = {
		consts : _consts,
		_z : {
			tools: tools,
			view: view,
			event: event,
			data: data
		},
		getZTreeObj: function(treeId) {
			var o = data.getZTreeTools(treeId);
			return o ? o : null;
		},
		init: function(obj, zSetting, zNodes) {
			var setting = tools.clone(_setting);
			$.extend(true, setting, zSetting);
			setting.treeId = obj.attr("id");
			setting.treeObj = obj;
			setting.treeObj.empty();
			settings[setting.treeId] = setting;
			if ($.browser.msie && parseInt($.browser.version)<7) {
				setting.view.expandSpeed = "";
			}

			data.initRoot(setting);
			var root = data.getRoot(setting),
			childKey = setting.data.key.children;
			zNodes = zNodes ? tools.clone(tools.isArray(zNodes)? zNodes : [zNodes]) : [];
			if (setting.data.simpleData.enable) {
				root[childKey] = data.transformTozTreeFormat(setting, zNodes);
			} else {
				root[childKey] = zNodes;
			}

			data.initCache(setting);
			event.bindTree(setting);
			event.bindEvent(setting);
			
			var zTreeTools = {
				setting : setting,
				addNodes : function(parentNode, newNodes, isSilent) {
					if (!newNodes) return null;
					if (!parentNode) parentNode = null;
					if (parentNode && !parentNode.isParent && setting.data.keep.leaf) return null;
					var xNewNodes = tools.clone(tools.isArray(newNodes)? newNodes: [newNodes]);
					function addCallback() {
						view.addNodes(setting, parentNode, xNewNodes, (isSilent==true));
					}

					if (tools.canAsync(setting, parentNode)) {
						view.asyncNode(setting, parentNode, isSilent, addCallback);
					} else {
						addCallback();
					}
					return xNewNodes;
				},
				cancelSelectedNode : function(node) {
					view.cancelPreSelectedNode(this.setting, node);
				},
				expandAll : function(expandFlag,animateFlag,callback) {
					expandFlag = !!expandFlag;
					view.expandCollapseSonNode(this.setting, null, expandFlag,animateFlag,callback);
					return expandFlag;
				},
				expandNode : function(node, expandFlag, sonSign, focus, callbackFlag) {
					if (!node || !node.isParent) return null;
					if (expandFlag !== true && expandFlag !== false) {
						expandFlag = !node.open;
					}
					callbackFlag = !!callbackFlag;

					if (callbackFlag && expandFlag && (tools.apply(setting.callback.beforeExpand, [setting.treeId, node], true) == false)) {
						return null;
					} else if (callbackFlag && !expandFlag && (tools.apply(setting.callback.beforeCollapse, [setting.treeId, node], true) == false)) {
						return null;
					}
					if (expandFlag && node.parentTId) {
						view.expandCollapseParentNode(this.setting, node.getParentNode(), expandFlag, false);
					}
					if (expandFlag === node.open && !sonSign) {
						return null;
					}
					
					data.getRoot(setting).expandTriggerFlag = callbackFlag;
					if (sonSign) {
						view.expandCollapseSonNode(this.setting, node, expandFlag, true, function() {
							if (focus !== false) {$("#" + node.tId).focus().blur();}
						});
					} else {
						node.open = !expandFlag;
						view.switchNode(this.setting, node);
						if (focus !== false) {$("#" + node.tId).focus().blur();}
					}
					return expandFlag;
				},
				getNodes : function() {
					return data.getNodes(this.setting);
				},
				getNodeByParam : function(key, value, parentNode) {
					if (!key) return null;
					return data.getNodeByParam(this.setting, parentNode?parentNode[this.setting.data.key.children]:data.getNodes(this.setting), key, value);
				},
				getNodeByTId : function(tId) {
					return data.getNodeCache(this.setting, tId);
				},
				getNodesByParam : function(key, value, parentNode) {
					if (!key) return null;
					return data.getNodesByParam(this.setting, parentNode?parentNode[this.setting.data.key.children]:data.getNodes(this.setting), key, value);
				},
				getNodesByParamFuzzy : function(key, value, parentNode) {
					if (!key) return null;
					return data.getNodesByParamFuzzy(this.setting, parentNode?parentNode[this.setting.data.key.children]:data.getNodes(this.setting), key, value);
				},
				getNodesByFilter: function(filter, isSingle, parentNode) {
					isSingle = !!isSingle;
					if (!filter || (typeof filter != "function")) return (isSingle ? null : []);
					return data.getNodesByFilter(this.setting, parentNode?parentNode[this.setting.data.key.children]:data.getNodes(this.setting), filter, isSingle);
				},
				getNodeIndex : function(node) {
					if (!node) return null;
					var childKey = setting.data.key.children,
					parentNode = (node.parentTId) ? node.getParentNode() : data.getRoot(this.setting);
					for (var i=0, l = parentNode[childKey].length; i < l; i++) {
						if (parentNode[childKey][i] == node) return i;
					}
					return -1;
				},
				getSelectedNodes : function() {
					var r = [], list = data.getRoot(this.setting).curSelectedList;
					for (var i=0, l=list.length; i<l; i++) {
						r.push(list[i]);
					}
					return r;
				},
				isSelectedNode : function(node) {
					return data.isSelectedNode(this.setting, node);
				},
				reAsyncChildNodes : function(parentNode, reloadType, isSilent) {
					if (!this.setting.async.enable) return;
					var isRoot = !parentNode;
					if (isRoot) {
						parentNode = data.getRoot(this.setting);
					}
					if (reloadType=="refresh") {
						parentNode[this.setting.data.key.children] = [];
						if (isRoot) {
							this.setting.treeObj.empty();
						} else {
							var ulObj = $("#" + parentNode.tId + consts.id.UL);
							ulObj.empty();
						}
					}
					view.asyncNode(this.setting, isRoot? null:parentNode, !!isSilent);
				},
				refresh : function() {
					this.setting.treeObj.empty();
					var root = data.getRoot(this.setting),
					nodes = root[this.setting.data.key.children]
					data.initRoot(this.setting);
					root[this.setting.data.key.children] = nodes
					data.initCache(this.setting);
					view.createNodes(this.setting, 0, root[this.setting.data.key.children]);
				},
				removeChildNodes : function(node) {
					if (!node) return null;
					var childKey = setting.data.key.children,
					nodes = node[childKey];
					view.removeChildNodes(setting, node);
					return nodes ? nodes : null;
				},
				removeNode : function(node, callbackFlag) {
					if (!node) return;
					callbackFlag = !!callbackFlag;
					if (callbackFlag && tools.apply(setting.callback.beforeRemove, [setting.treeId, node], true) == false) return;
					view.removeNode(setting, node);
					if (callbackFlag) {
						this.setting.treeObj.trigger(consts.event.REMOVE, [setting.treeId, node]);
					}
				},
				selectNode : function(node, addFlag) {
					if (!node) return;
					if (tools.uCanDo(this.setting)) {
						addFlag = setting.view.selectedMulti && addFlag;
						if (node.parentTId) {
							view.expandCollapseParentNode(this.setting, node.getParentNode(), true, false, function() {
								$("#" + node.tId).focus().blur();
							});
						} else {
							$("#" + node.tId).focus().blur();
						}
						view.selectNode(this.setting, node, addFlag);
					}
				},
				transformTozTreeNodes : function(simpleNodes) {
					return data.transformTozTreeFormat(this.setting, simpleNodes);
				},
				transformToArray : function(nodes) {
					return data.transformToArrayFormat(this.setting, nodes);
				},
				updateNode : function(node, checkTypeFlag) {
					if (!node) return;
					var nObj = $("#" + node.tId);
					if (nObj.get(0) && tools.uCanDo(this.setting)) {
						view.setNodeName(this.setting, node);
						view.setNodeTarget(node);
						view.setNodeUrl(this.setting, node);
						view.setNodeLineIcos(this.setting, node);
						view.setNodeFontCss(this.setting, node);
					}
				}
			}
			root.treeTools = zTreeTools;
			data.setZTreeTools(setting, zTreeTools);

			if (root[childKey] && root[childKey].length > 0) {
				view.createNodes(setting, 0, root[childKey]);
			} else if (setting.async.enable && setting.async.url && setting.async.url !== '') {
				view.asyncNode(setting);
			}
			return zTreeTools;
		}
	};

	var zt = $.fn.zTree,
	consts = zt.consts;
})(jQuery);
/**
权限窗口
 继承自autocomplete，pop.menu，tinyscrollbar，ztree.core-3.2
 by:kule
 */
;(function($){
    $.fn.powerWin=function(setting,arg){
        var This=this;
        if(typeof setting=='string')return runDatafun(setting,this,arg);
        function init(){
            var options={
                cbSelect:$.noop,
                data:[],
                popMaxTip:x18n.popMaxTip,
                limitHeight:120
            };
            $.extend(options,setting);
            var ztree1,tScroll1,names=[];
            var pleft=5;
            var ztreeId=$('.friends_tree_lq',This)[0].id='tree'+(new Date()).getTime();
            var ztSetting={
                view:{
                    showLine:false,
                    dblClickExpand:false
                },
                callback:{
                    onClick:function(event, treeId, treeNode){
                        if(treeNode.level<1){
                            ztree1.expandNode(treeNode,null,false,true,true);
                            return;
                        }
                        options.cbSelect(treeNode);
                    },
                    onExpand:updateScroll,
                    onCollapse:updateScroll
                }};
            //autocomplete
            for (var i=0;i<options.data.length;i++){
                if(options.data[i].children.length>0){
                    for(var j=0;j<options.data[i].children.length;j++){
                        names.push(options.data[i].children[j].name);
                    }
                }
            }
            $('.friend_search1_lq',This).autocomplete({
                source: names,
                appendTo:This,
                popMax:4,
                onpopMax:onpopMax,
                close:function(){onpopMax(false)},
                minLength:1,
                select:slideNode
            });
            ztree1=$.fn.zTree.init($('.friends_tree_lq',This),ztSetting,options.data);
            pleft=$('.friend_search1_lq',This).position().left+5;
            tScroll1=This.tinyscrollbar({limitHeight:options.limitHeight});
            This.delegate('.search_icon_lf','click',function(){
                var ui={
                    item:{value:$('.friend_search1_lq',This).val()}
                };
                slideNode(null,ui);
            }).data('autoClose','false');//阻止popMenu自动关闭
            This.bind('mouseenter',function(){
                $(This).data('autoClose','false');//阻止popMenu自动关闭
            }).bind('mouseleave',function(){
                $(This).data('autoClose','true');//移出区域后允许关闭
            });
            //更新滚动条
            function updateScroll(){
                tScroll1.tinyscrollbar_update('relative');
            }
            //超出自动完成后提示
            function onpopMax(flag){
                var jqObj=$('.popmax_tip',This);
                if(!flag){
                    jqObj.css({display:'none'});
                    return;
                }
                if(jqObj.length>0){
                    jqObj.html(options.popMaxTip).css({display:'block'});
                }else{
                    $(['<div class="popmax_tip" style="position: absolute; z-index: 2500;top: 157px; width: 122px;height: 24px ;line-height:24px;text-indent:8px;border:1px solid #5678AE;border-top:0 none; overflow:hidden; background-color:#fff;">',options.popMaxTip,'</div>'].join('')).
                        appendTo(This).css({left:pleft});
                }
            }
            //查找节点
            function slideNode(e,ui){
                var node=ztree1.getNodeByParam('name',ui.item.value);
                if(!node)return;
                var offset;
                ztree1.expandAll(true,false);
                ztree1.selectNode(node,false);
                //offset=toolLq.offsetParent($('#'+node.tId)[0],ztreeId);
                offset=$('#'+node.tId).position();
                tScroll1.tinyscrollbar_update(offset.top-options.limitHeight/2);
            }
            This.data('resize',updateScroll);
            This.ztree=ztree1;
            return This;
        }
        this.data('init',init);
        return init();
    };
    //两列右侧带头像生成方法
    $.fn.powerWinImgSelect=function(setting,arg){
        if(typeof setting=='string')return runDatafun(setting,this,arg);
        var options={
            cbSelect:$.noop,
            data:[],
            limitHeight:160,
            type:0//0为右侧带头像，1右侧为文本
        };
        $.extend(options,setting);
        var selected={},
            powerWin1={},
            jqPw1=$('.power_w1_lq',this),
            jqPw2=$('.power_w2_lq',this),
            className=[
                {closeBtn:'.black_close_icon_lf',
                nameBox:'.copy_lq',
                clearBtn:'.white_dustbin_icon_lf'
                },
                {closeBtn:'.white_close_icon_lf',
                nameBox:'.create_lq',
                clearBtn:'.clear_up_lq'
                }
            ];
        var tScroll2=jqPw2.tinyscrollbar({limitHeight:options.limitHeight});
        powerWin1=jqPw1.powerWin({
            cbSelect:function(node){
                if (node.name in selected){
                    var jqObj=$(className[options.type].nameBox,jqPw2).filter('[datalq$="'+node.name+'"]').addClass('act_lq');
                    var offset=jqObj.position();
                    if(offset.top>=options.limitHeight/2){
                        tScroll2.tinyscrollbar_update(offset.top-options.limitHeight/2);
                    }else{
                        tScroll2.tinyscrollbar_update(0);
                    }
                    setTimeout(function(){jqObj.removeClass('act_lq')},1000);
                    options.cbSelect(node);
                    return;
                }
                copyNode([node]);
                options.cbSelect(node);
            },
            data:options.data,
            limitHeight:options.limitHeight-20
        });
        jqPw2.delegate(className[options.type].clearBtn,'click',function(){
            clearSelect();
        }).delegate(className[options.type].closeBtn,'click',function(){
            var jqObj=$(this).parent();
            delete selected[toolLq.getStrValue('name',jqObj.attr('datalq'))];
            jqObj.remove();
        }).delegate(className[options.type].nameBox,'mouseenter',function(){
            if(options.type==0){
                $(className[options.type].closeBtn,this).removeClass('hidden2_lq');
            }
        }).delegate(className[options.type].nameBox,'mouseleave',function(){
            if(options.type==0){
                $(className[options.type].closeBtn,this).addClass('hidden2_lq');
            }
        });
        function copyNode(nodes){
            var html=[];
            switch(options.type){
                case 1:
                    for(var i=0;i<nodes.length;i++){
                        if(nodes[i].name in selected)continue;
                        html.push(['<a class="create_lq" datalq="name:',nodes[i].name,'">',nodes[i].name,'<div class="white_close_icon_lf"></div></a>'].join(''));
                        selected[nodes[i].name]=nodes[i].name;
                    }
                    break;
                default:
                    options.type=0;
                    for(var i=0;i<nodes.length;i++){
                        if(nodes[i].name in selected)continue;
                        if(nodes[i].tId==undefined){//若是传入节点，则输出html语句
                            html.push(['<a class="copy_lq" datalq="name:',nodes[i].name,'"><span style="background:url(',nodes[i].icon,') 0 0 no-repeat;" class="button ico_docu"></span><span>',
                                nodes[i].name,'</span><div class="black_close_icon_lf hidden2_lq"></div></a>'].join(''));
                        }else{
                            html.push(['<a class="copy_lq" datalq="name:',nodes[i].name,'">',filterId($('#'+nodes[i].tId).find('a.level1').html()),'<div class="black_close_icon_lf hidden2_lq"></div></a>'].join(''));
                        }
                        selected[nodes[i].name]=nodes[i].name;
                    }
            }
            $('.ztree',jqPw2).append(html.join(''));
            tScroll2.tinyscrollbar_update('relative');
        }
        this.data('getNames',getNames).data('clearSelect',clearSelect).data('addNames',copyNode);
        function filterId(str){
            return str.replace(/id="[^"]*"/gi,'');
        }
        function getNames(){
            var rst=[];
            for(var i in selected){
                rst.push(selected[i]);
            }
            return rst;
        }
        function clearSelect(){
            $('.friends_tree_lq',jqPw2).empty();
            selected={};
            tScroll2.tinyscrollbar_update();
        }
        this.powerWin=[powerWin1];
        return this;
    };
    function runDatafun(key,jqObj,arg){
        if(typeof jqObj.data(key)=='function'){
            return jqObj.data(key)(arg);
        }
        return null;
    }
})(jQuery);
/*textarea和div输入框
by:kule
2012-07-01*/
(function($){
    var ems={
        emCn:{
        '[微笑]':'id0',
        '[撇嘴]':'id1',
        '[色]':'id2',
        '[发呆]':'id3',
        '[得意]':'id4',
        '[流泪]':'id5',
        '[害羞]':'id6',
        '[闭嘴]':'id7',
        '[睡]':'id8',
        '[大哭]':'id9',
        '[尴尬]':'id10',
        '[发怒]':'id11',
        '[调皮]':'id12',
        '[龇牙]':'id13',
        '[惊讶]':'id14',
        '[难过]':'id15',
        '[酷]':'id16',
        '[冷汗]':'id17',
        '[抓狂]':'id18',
        '[吐]':'id19',
        '[偷笑]':'id20',
        '[可爱]':'id21',
        '[白眼]':'id22',
        '[傲慢]':'id23',
        '[饥饿]':'id24',
        '[困]':'id25',
        '[惊恐]':'id26',
        '[流汗]':'id27',
        '[憨笑]':'id28',
        '[大兵]':'id29',
        '[奋斗]':'id30',
        '[咒骂]':'id31',
        '[疑问]':'id32',
        '[嘘]':'id33',
        '[晕]':'id34',
        '[折磨]':'id35',
        '[衰]':'id36',
        '[骷髅]':'id37',
        '[敲打]':'id38',
        '[再见]':'id39',
        '[擦汗]':'id40',
        '[抠鼻]':'id41',
        '[鼓掌]':'id42',
        '[糗大了]':'id43',
        '[坏笑]':'id44',
        '[左哼哼]':'id45',
        '[右哼哼]':'id46',
        '[哈欠]':'id47',
        '[鄙视]':'id48',
        '[委屈]':'id49',
        '[快哭了]':'id50',
        '[阴险]':'id51',
        '[亲亲]':'id52',
        '[吓]':'id53',
        '[可怜]':'id54',
        '[菜刀]':'id55',
        '[西瓜]':'id56',
        '[啤酒]':'id57',
        '[篮球]':'id58',
        '[乒乓]':'id59',
        '[咖啡]':'id60',
        '[饭]':'id61',
        '[猪头]':'id62',
        '[玫瑰]':'id63',
        '[凋谢]':'id64',
        '[示爱]':'id65',
        '[爱心]':'id66',
        '[心碎]':'id67',
        '[蛋糕]':'id68',
        '[闪电]':'id69',
        '[炸弹]':'id70',
        '[刀]':'id71',
        '[足球]':'id72',
        '[瓢虫]':'id73',
        '[屎]':'id74',
        '[月亮]':'id75',
        '[太阳]':'id76',
        '[礼物]':'id77',
        '[抱抱]':'id78',
        '[强]':'id79',
        '[弱]':'id80',
        '[握手]':'id81',
        '[胜利]':'id82',
        '[抱拳]':'id83',
        '[勾引]':'id84',
        '[拳头]':'id85',
        '[差劲]':'id86',
        '[爱你]':'id87',
        '[NO]':'id88',
        '[OK]':'id89',
        '[爱情]':'id90',
        '[飞吻]':'id91',
        '[跳跳]':'id92',
        '[发抖]':'id93',
        '[怄火]':'id94',
        '[转圈]':'id95',
        '[磕头]':'id96',
        '[回头]':'id97',
        '[跳绳]':'id98',
        '[挥手]':'id99',
        '[激动]':'id100',
        '[街舞]':'id101',
        '[献吻]':'id102',
        '[左太极]':'id103',
        '[右太极]':'id104'
    },
        emEn:{
        '[Smile]':'id0',
        '[Grimace]':'id1',
        '[Drooling]':'id2',
        '[Scowl]':'id3',
        '[Chill]':'id4',
        '[Sob]':'id5',
        '[Shy]':'id6',
        '[Silence]':'id7',
        '[Sleep]':'id8',
        '[Cry]':'id9',
        '[Embarrassed]':'id10',
        '[On fire]':'id11',
        '[Wink]':'id12',
        '[Grin]':'id13',
        '[Surprised]':'id14',
        '[Sad]':'id15',
        '[Cool]':'id16',
        '[Frightened]':'id17',
        '[Scream]':'id18',
        '[Puke]':'id19',
        '[Chuckle]':'id20',
        '[Lovely]':'id21',
        '[Sneer]':'id22',
        '[Arrogant]':'id23',
        '[Hungry]':'id24',
        '[Drowsy]':'id25',
        '[Panic]':'id26',
        '[Sweating]':'id27',
        '[Laugh]':'id28',
        '[Soldier]':'id29',
        '[strive]':'id30',
        '[Scold]':'id31',
        '[Confused]':'id32',
        '[Shhh]':'id33',
        '[Hypnotized]':'id34',
        '[Torment]':'id35',
        '[Frustrated]':'id36',
        '[Skull]':'id37',
        '[Hammer]':'id38',
        '[Wave/Bye]':'id39',
        '[Relived/Wipe]':'id40',
        '[Pick nose]':'id41',
        '[Applause]':'id42',
        '[Flushed]':'id43',
        '[Hellooo]':'id44',
        '[Snub1]':'id45',
        '[Snub2]':'id46',
        '[Yawn]':'id47',
        '[Booo]':'id48',
        '[Distressed]':'id49',
        '[Sniffle]':'id50',
        '[Sly]':'id51',
        '[Pucker]':'id52',
        '[Scared]':'id53',
        '[Pathetic]':'id54',
        '[Cleaver]':'id55',
        '[Water Melon]':'id56',
        '[Beer]':'id57',
        '[Basketball]':'id58',
        '[Ping Pong]':'id59',
        '[Coffee]':'id60',
        '[Rice]':'id61',
        '[Pig]':'id62',
        '[Rose]':'id63',
        '[Fade]':'id64',
        '[Kisses]':'id65',
        '[Heart]':'id66',
        '[Broken Heart]':'id67',
        '[Cake]':'id68',
        '[Lightning]':'id69',
        '[Bomb]':'id70',
        '[Dagger]':'id71',
        '[Football]':'id72',
        '[Ladybug]':'id73',
        '[Shit]':'id74',
        '[Moon]':'id75',
        '[Sun]':'id76',
        '[Gift]':'id77',
        '[Hug]':'id78',
        '[Strong]':'id79',
        '[Weak]':'id80',
        '[Shake]':'id81',
        '[Victory]':'id82',
        '[Admire]':'id83',
        '[Beckon]':'id84',
        '[Fist]':'id85',
        '[Pinky]':'id86',
        '[ILoveU]':'id87',
        '[NO]':'id88',
        '[OK]':'id89',
        '[Love]':'id90',
        '[Flying Kiss]':'id91',
        '[Jump]':'id92',
        '[Tremble]':'id93',
        '[Aaagh]':'id94',
        '[Circle]':'id95',
        '[Kotow]':'id96',
        '[Turn]':'id97',
        '[Skip]':'id98',
        '[Surrnder]':'id99',
        '[Hooray]':'id100',
        '[Hippop]':'id101',
        '[Smooches]':'id102',
        '[Fighting Girl]':'id103',
        '[Fighting Boy]':'id104'
    }
    };

    var urls={
        'id0':'0.gif',
        'id1':'1.gif',
        'id2':'2.gif',
        'id3':'3.gif',
        'id4':'4.gif',
        'id5':'5.gif',
        'id6':'6.gif',
        'id7':'7.gif',
        'id8':'8.gif',
        'id9':'9.gif',
        'id10':'10.gif',
        'id11':'11.gif',
        'id12':'12.gif',
        'id13':'13.gif',
        'id14':'14.gif',
        'id15':'15.gif',
        'id16':'16.gif',
        'id17':'17.gif',
        'id18':'18.gif',
        'id19':'19.gif',
        'id20':'20.gif',
        'id21':'21.gif',
        'id22':'22.gif',
        'id23':'23.gif',
        'id24':'24.gif',
        'id25':'25.gif',
        'id26':'26.gif',
        'id27':'27.gif',
        'id28':'28.gif',
        'id29':'29.gif',
        'id30':'30.gif',
        'id31':'31.gif',
        'id32':'32.gif',
        'id33':'33.gif',
        'id34':'34.gif',
        'id35':'35.gif',
        'id36':'36.gif',
        'id37':'37.gif',
        'id38':'38.gif',
        'id39':'39.gif',
        'id40':'40.gif',
        'id41':'41.gif',
        'id42':'42.gif',
        'id43':'43.gif',
        'id44':'44.gif',
        'id45':'45.gif',
        'id46':'46.gif',
        'id47':'47.gif',
        'id48':'48.gif',
        'id49':'49.gif',
        'id50':'50.gif',
        'id51':'51.gif',
        'id52':'52.gif',
        'id53':'53.gif',
        'id54':'54.gif',
        'id55':'55.gif',
        'id56':'56.gif',
        'id57':'57.gif',
        'id58':'58.gif',
        'id59':'59.gif',
        'id60':'60.gif',
        'id61':'61.gif',
        'id62':'62.gif',
        'id63':'63.gif',
        'id64':'64.gif',
        'id65':'65.gif',
        'id66':'66.gif',
        'id67':'67.gif',
        'id68':'68.gif',
        'id69':'69.gif',
        'id70':'70.gif',
        'id71':'71.gif',
        'id72':'72.gif',
        'id73':'73.gif',
        'id74':'74.gif',
        'id75':'75.gif',
        'id76':'76.gif',
        'id77':'77.gif',
        'id78':'78.gif',
        'id79':'79.gif',
        'id80':'80.gif',
        'id81':'81.gif',
        'id82':'82.gif',
        'id83':'83.gif',
        'id84':'84.gif',
        'id85':'85.gif',
        'id86':'86.gif',
        'id87':'87.gif',
        'id88':'88.gif',
        'id89':'89.gif',
        'id90':'90.gif',
        'id91':'91.gif',
        'id92':'92.gif',
        'id93':'93.gif',
        'id94':'94.gif',
        'id95':'95.gif',
        'id96':'96.gif',
        'id97':'97.gif',
        'id98':'98.gif',
        'id99':'99.gif',
        'id100':'100.gif',
        'id101':'101.gif',
        'id102':'102.gif',
        'id103':'103.gif',
        'id104':'104.gif'
    };
    $.fn.extend({
        jqface : function(setting,arg) {
            var jqFace;
            if(typeof setting=='string')return runDatafun(setting,this,Array.prototype.slice.call(arguments,1));
            var options = {
                txtAreaObj:null, //TextArea对象
                once:true,//是否立即关闭
                onSelect:$.noop,
                emotions:ems[x18n.emCode],//表情信息json格式
                imageUrl: '/Content/blue/emotions/images/',
                onopen:$.noop,
                onopened:$.noop,
                offset:{top:0,left:0},
                selector:null
            };
            
           $.extend(options,setting);
            var scrBtn={};
            this.bind("click.jqface",open);
            //生成表情html
            function creatFace(index) {
                var id=options.selector?options.selector+'_jqface':'face_jqface';
                var selector=options.selector||'body';
                var template=['<div id="',id,'" class="hidden1_lq"><div class="texttb_jqface"><a class="default_face">'+x18n.defaultText+'</a><a class="close_jqface" title="close">×</a></div><div class="facebox_jqface"><div class="js_face_bg" style="background: url(/Content/gifttwo/emotions/b0.png);width: 436px;height: 249px;z-index: 1;margin-left:10px;"></div><div class="faceContent-list js_faceContentList">'];
                if (index == 0) {
                    for (var k in options.emotions) {
                        template.push('<a title="', k, '" alt="', k, '" ></a>');
                    }
               }

                template.push('</div></div><div class="arrow_t"></div><div class="faceBottom-sort">'+faceData.js_faceBottom+'</div></div>');
                jqFace=$(template.join('')).appendTo(selector);
                initFace();
                $(".facebox_jqface").mCustomScrollbar({
                    theme:"3d-dark",
                    //theme:"light3",
                     scrollButtons:{ enable: true },
                });
                $(".js_faceBottomUl_box").mCustomScrollbar({
                    axis:"x",
                    alwaysShowScrollbar:0,
                    scrollbarPosition: "outside",
                    autoHideScrollbar:true,
                   //scrollButtons:{ enable: true },
                });
            }

            function replaceFace(index) {
                if (index == 0) {
                    var defaultFace=[];
                      for (var k in options.emotions) {
                            defaultFace.push('<a title="', k, '" alt="', k, '" ></a>');
                        }
                     $(".js_faceContentList").html(defaultFace.join(''));
                } else {
                    $.post(faceData.faceContentUrl, { package: index }, function(res) {
                        $(".js_faceContentList").html(res);
                    });
                }
            }

//表情中绑定事件
            function initFace() {
                jqFace.delegate('.facebox_jqface a[alt],.facebox_jqface li[alt]','click.jqface',selectFace).
              //  jqFace.delegate('img[alt]','click.jqface',selectFace).
                    delegate('.close_jqface','click.jqface',closeFace).
                    delegate('.js_faceBottom_ul li ','click.jqface',switchFaceClass).
                    delegate('.js_noBuyTips','click.jqface', function() {
                       // var imgId = $(this).attr("data-id");
                        var imgId = $(this).closest("#face_jqface").find("li.active").attr("data-class"),
                            receiver_cyw = $(this).attr("data-name"),
                            giftName=$(this).closest("#face_jqface").find("li.active").attr("data-name");
                           fastBuyFacePackage(imgId, receiver_cyw, giftName);

                    }).
                    delegate('.js_leftOffset','click.jqface',function() {
                        faceClassOffset("left");
                    }).//向左滚
                    delegate('.js_rightOffset','click.jqface', function() {
                        faceClassOffset("right");
                    }).//向右滚
                    bind('click.jqface',function(e){e.stopPropagation()});
            }
            //表情分类
            function switchFaceClass() {
                var self = $(this);
                var dataClass = self.attr("data-class");
                self.siblings(".active").removeClass("active").end().
                    addClass("active");
                var title = self.attr("data-name");
                
                if (dataClass != 0) {
                    $(".js_face_bg").hide();
                    $(".js_faceContentList").addClass("noDefault");
                    $(".texttb_jqface .default_face").text(title);
                } else {
                    $(".js_face_bg").show();
                    $(".js_face_bg").css({
                          background:"url(/Content/gifttwo/emotions/b0.png) no-repeat"
                    });
                    $(".js_faceContentList").removeClass("noDefault");
                    $(".texttb_jqface .default_face").text(x18n.defaultText);
                }
                replaceFace(dataClass);
            }

        //选择face
            function selectFace() {
                var options=$('#face_jqface').data('options');
                if(!options.txtAreaObj){
                    if(options.onSelect($(this).attr('alt')))closeFace();
                    return;
                }
                options.txtAreaObj.val(options.txtAreaObj.val()+$(this).attr('alt'));
                var setFocusText = options.txtAreaObj;
                var txtRange={};
                //主流浏览器聚焦
                setFocusText.focus();
                //ie聚焦
                if($.browser.msie) {
                    txtRange = setFocusText[0].createTextRange();
                    txtRange.moveStart('character', setFocusText.val().length);
                    txtRange.collapse(true);
                    txtRange.select();
                }
                if(options.once)closeFace();
            }
            //关闭表情框
            function closeFace(){
                 jqFace.addClass('hidden1_lq');
                $(document).unbind('click.jqface',closeFace);
            }
            //弹出表情框
            function popFace(e,This,obj,isFacePackage,zIndexLetterLayer) {
                if (isFacePackage) {//判断是表情包还是心情的弹窗,如果是表情包就把底部分类显示出来
                    $(".faceBottom-sort").addClass("boShow");
                    $("#face_jqface").css({"z-index":zIndexLetterLayer});
                } else {
                    $(".faceBottom-sort ul li").eq(0).click();
                    $(".faceBottom-sort").removeClass("boShow");
                }
                var jqobj=$(obj),
                    offset=jqobj.offset(),
                    client={},
                    popOffset={},
                    jqParent=This.parent();
                //查找第一个非static定位父级
                while(jqParent.css('position')=='static'){
                    if(jqParent[0].tagName.toLowerCase()=='body')break;
                    jqParent=jqParent.parent();
                }
                jqParent.oft=jqParent.offset();
                //矫正弹出位置，防止出现在窗口之外
                offset.outHeight=jqobj.outerHeight();
                offset.outWidth=jqobj.outerWidth();
                client.height=document.documentElement.clientHeight;
                client.width=document.documentElement.clientWidth;
                popOffset.height=This.outerHeight();
                popOffset.width=This.outerWidth();
                popOffset.top=client.height-e.clientY-offset.outHeight-options.offset.top>popOffset.height?
                    offset.top+offset.outHeight+options.offset.top:
                    offset.top-popOffset.height-2;
                popOffset.left=client.width-e.clientX-options.offset.left>popOffset.width?
                    offset.left+options.offset.left:
                    offset.left-(popOffset.width-offset.outWidth);
                $(document).bind('click',closeFace);
                options.onopen(jqobj[0]);
                This.data('options',options);
                This.css({top:Math.floor(popOffset.top-jqParent.oft.top),left:Math.floor(popOffset.left-jqParent.oft.left)})
                    .removeClass('hidden1_lq');
                options.onopened(jqobj[0]);
            }
            //公开方法
            function open(e) {
                var isFacePackage = $(this).hasClass("js_faceLetter_icon");
                var zIndexLetterLayer = $(this).closest(".new-dialog-skin").css("z-index");//获得私信弹框的zindex,以便表情弹框在上面,而且不遮住成功等其他弹窗
                var obj;
                if(e instanceof Array){
                    obj=e[1];
                    e=e[0];
                }else{
                    obj=this;
                }
                e.stopPropagation();
                jqFace=$('#face_jqface');
                if(jqFace.length<1){
                    creatFace(0);
                }
                if(scrBtn!=obj){
                    closeFace();
                }
                if(jqFace.hasClass('hidden1_lq')){
                    popFace(e,jqFace,obj,isFacePackage,zIndexLetterLayer);
                    scrBtn=obj;
                }else{
                    closeFace();
                }
            }
            this.data('close',closeFace).data('open',open).data('jqface','1.0');
            return this;
        },
        //表情文字符号转换为html格式
        jqfaceShow : function(setting) {
            var options={
                imageUrl:'/Content/blue/emotions/images/',
                str:'',
                emCode:x18n.emCode
            };
            $.extend(options,setting);
            var regExp=/\[[^\[\]]+\]/gi;
            return options.str.replace(regExp,function(s) {
                //
                 var ss=s.split("[")[1];
                    ss = ss.split("]")[0];
                if(s in ems[options.emCode]) {
                    //alert(s[0])
                   // s.splice(0,1);
                    return ['<img title="',ss,'" alt="',ss,'" src="',options.imageUrl,urls[ems[options.emCode][s]],'" />'].join('');
                }
                else if (options.type == "letter") {
//                     for (var i in faceData.faceImgUrl) {
//                        if (s == faceData.faceImgUrl[i].Title_Enus) {
//                         return ['<span class="face-toHtml-box js_buyFacePackage" data-id="',faceData.faceImgUrl[i].Id,'" data-price="',faceData.faceImgUrl[i].Gold,'" data-name="',faceData.faceImgUrl[i].Language,'" data-src="',faceData.faceImgUrl[i].Url,'"><span class="face-toHtml-mask">',faceData.EmotionBuyPackage,'</span><img  title="',s,'" alt="',s,'" src="', faceData.faceImgUrl[i].Url,'" /></span>'].join('');
//                         //return ['<img  title="[',faceData.faceImgUrl[i].Language,']" alt="',s,'" src="', faceData.faceImgUrl[i].Url,'" width="88" height="88" class="js_face_img"   data-id="',faceData.faceImgUrl[i].Id,'" data-price="',faceData.faceImgUrl[i].Gold,'" data-name="',faceData.faceImgUrl[i].Language,'" data-src="',faceData.faceImgUrl[i].Url,'"/>'].join('');
//                        }
//                    } 
                    for (var i in options.faceJson) {
                        if (s == options.faceJson[i].Title_Enus) {
                            if (options.noLayer == "no"||options.Identity=="sender") {//消息记录页只需要返回图片
                                return ['<img  title="', options.faceJson[i].Language, '" alt="', ss, '" src="',  options.faceJson[i].Url, '" width="88" height="88"  />'].join('');
                            } else {
                               return ['<span class="face-toHtml-box js_buyFacePackage" data-id="',options.faceJson[i].Id,'" data-price="',options.faceJson[i].Gold,'" data-name="',options.faceJson[i].Language,'" data-src="',options.faceJson[i].Url,'"><span class="face-toHtml-mask">',faceData.EmotionBuyPackage,'</span><img  title="[',options.faceJson[i].Language,']" alt="',ss,'" src="', options.faceJson[i].Url,'" /></span>'].join('');
                            }
                         //return ['<img  title="[',faceData.faceImgUrl[i].Language,']" alt="',s,'" src="', faceData.faceImgUrl[i].Url,'" width="88" height="88" class="js_face_img"   data-id="',faceData.faceImgUrl[i].Id,'" data-price="',faceData.faceImgUrl[i].Gold,'" data-name="',faceData.faceImgUrl[i].Language,'" data-src="',faceData.faceImgUrl[i].Url,'"/>'].join('');
                        }
                    }
//                   if (s in opitons.faceImgUrl) {
//                        return ['<img title="',s,'" alt="',s,'" src="',options.imageUrl,urls[ems[options.emCode][s]],'" />'].join('');
//                    }
                }
                for(var k in ems){
                    if(k==options.emCode)continue;
                    if(s in ems[k]) return ['<img title="',ss,'" alt="',ss,'" src="',options.imageUrl,urls[ems[k][s]],'" />'].join('');
                }
                for(var k in appEmotion){
                    if(s in appEmotion[k])
                        return ['<img title="',ss,'" ',appEmotion[k]['isemotions']=='true'?'style="width:24px;height:24px;"':'',' alt="',ss,'" src="',appEmotion[k]['url'],appEmotion[k][s],'" />'].join('');
                }
                return toolLq.filterScript(s);
            });
        }
    });
    var faceself;
    $.fn.replyInput=function(setting,arg) {
         faceself = $(this);
        if(typeof setting=='string')return runDatafun(setting,this,arg);
        if(arg)return initHtml();
        this.each(function(){
           var rpi=new ReplyInput(this,setting);
            //组件初始化
            //表情插件
            $('.faces_icon1_lq',rpi.root).jqface({
                txtAreaObj:rpi.jqTxtArea,
                //emotions:ems[rpi.emCode],
                bottom:rpi.options.bottom,
                emotions:rpi.options.emotions,
                imageUrl:rpi.options.gifurl
            });
            //事件绑定
            rpi.jqTxtArea.bind('paste cut keydown keyup focus blur',function(e){
                rpi.typeIn(e);
            });
            $(this).data('replyInput',rpi).data('getReplyInput',getReplyInput).data('getCount',rpi.getCount);
//            返回自身
            function getReplyInput(){
                return rpi;
            }
        });
        //生成html
        function initHtml(){
            var template = '<div class="reply_input_lq"><div class="left_arrow1_lq"></div><textarea class="mood_text1_lq"></textarea><div class="input_infobox_lq"><a class="faces_icon1_lq"></a><span class="char_count1_lq">240</span></div><div class="mood_op1_lq">${transate}:<select><option value="">'+x18n.noTrans+'</option><option value="en" selected="selected">English</option><option value="cn">中文(简体)</option><option value="tr">中文(繁体)</option><option value="ko">한국어</option><option value="rs">Pусский</option><option value="gm">Deutsch</option><option value="sp">Español</option><option value="jp">日本語</option></select><a class="gray_btn1_lq">${submitText}</a></div></div>';
            return toolLq.htmlTemplate(template,x18n);
        }
        return this;
    };
    //ReplyInput静态属性
    function ReplyInput(root,setting) {
        var This=$(root),
            jqTxtArea=$('textarea',This);
        var options={
            minHeight:jqTxtArea.height(),
            maxHeight:300,
            wordMax:240,
            emCode:x18n.emCode,
            gifurl:'/Content/blue/emotions/images/',
            filterRegs:[]
        };
        $.extend(options,setting);
        var heightMem=jqTxtArea[0].scrollHeight;
        var emCode=options.emCode;
        //接口开放
        this.root=This;
        this.jqTxtArea=jqTxtArea;
        this.options=options;
        this.heightMem=heightMem;
        this.emCode=emCode;
    }
    //Reply静态方法
    $.extend(ReplyInput.prototype,{
        //输入时执行
        typeIn:function (e){
            var text=this.jqTxtArea.val();
            //字数统计
            //
            $('.char_count1_lq',this.root).text(this.options.wordMax-this.textCount(text,ems[this.emCode]));
            //高度自增
            //this.autoH(e);
        },
        //智能删除识别
        delWord:function (str,filterJson,em){
            var regExp=/\[[^\[\]]+\]/gi;
            var count=0;
            str=str.replace(regExp,function(s){
                if(s in filterJson){
                }else{
                    return s;
                }
            });
            return count+str.length;
        },
        //字数统计
        textCount:function (str,em){
            var regExp=/\[[^\[\]]+\]/gi;
            var count=0;
            var filterRegs=this.options.filterRegs;
            str=str.replace(regExp,function(s){
                //提高性能，过滤与表情分离
                if(s in em){
                    count++;
                    return '';
                }else{
                    return s;
                }
            });
            for(var i=0;i<filterRegs.length;i++){
                str=str.replace(filterRegs[i].reg,filterRegs[i].str);
            }
            return count+str.length;
        },
        //高度自增
        autoH:function (e){
            var domTxt=this.jqTxtArea[0];
            var options=this.options;
            if(e.type=='cut'||(e.type=='keydown'&&(e.keyCode==8||e.keyCode==46))){
                domTxt.style.height=options.minHeight+'px';
            }
            this.heightMem=domTxt.scrollHeight;
            if (this.heightMem > options.minHeight) {
                if (this.heightMem > options.maxHeight) {
                    this.heightMem = options.maxHeight;
                    domTxt.style.overflowY = 'scroll';
                } else {
                    domTxt.style.overflowY = 'hidden';
                }
                domTxt.style.height = this.heightMem + 'px';
            }
        },
        //开放的接口
        getCount:function(){
            var count=this.textCount(this.jqTxtArea.val(),ems[this.emCode]);
            return {isFlow:count>this.options.wordMax,count:count};
        },
        getContent:function() {
            return $.fn.jqfaceShow({imageUrl:this.options.gifurl,
                str:toolLq.filterLt(this.jqTxtArea.val()),
                emCode:this.options.emCode
            });
        }
    });
    function runDatafun(key,jqObj,arg) {
    
        if(typeof jqObj.data(key)=='function'){
            return jqObj.data(key)(arg);
        }
        return null;
    }
})(jQuery);
/**
 *评论盖楼效果
 * 数据要求如下：
 * [{Pid:null,id:1,userId:1,content:'1',date:new Date()},
 {Pid:1,id:2,userId:10,content:'1.1',date:new Date()},
 {Pid:null,id:3,userId:10,content:'2',date:new Date()}]
 Pid为空或null时为顶级节点，数据必须按时间排序（正序）
 * by:kule 2012-05-28
 */
(function($){
    $.fn.commentTree=function(setting,arg){
        var This=this;
        if(typeof setting=='string')return runDatafun(setting,this,arg);
        var options={
            html:{templateParent:'<dl datalq1="Id:${id},userId:${userId}"><dt><img src="${memberHeader}" width="32" height="32" alt="${userId}"/></dt><dd><p><a class="name_box1_lq">${userId}：&nbsp;</a>${content}</p><p><span class="send_time" dateutc="${sendTime}"></span><span class="comment_op1_lq"><a class="recomment_op1_lq">${recommentText}</a><a class="delete_op1_lq close_icon1_lq">×</a></span></p></dd>',
                templateChild:'<dd><dl datalq1="Id:${id},userId:${userId}" class="child_box1_lq"><dt><img src="${memberHeader}" width="32" height="32" alt="${userId}"/></dt><dd><p><a class="name_box1_lq">${userId}&nbsp;${recommentText}&nbsp;${parentUserId}：</a>${content}</p><p><span class="send_time" dateutc="${sendTime}"></span><span class="comment_op1_lq"><a class="recomment_op1_lq">${recommentText}</a><a class="delete_op1_lq close_icon1_lq">×</a></span></p></dd></dl></dd>',
                //templateClose:'<dd><input class="reply_simple_lq" type="text" value="${quickReply}" /></dd></dl>',
                templateClose:'<dd class="hidden1_lq reply_box1_lq"></dd></dl>',
                staticData:{translateText:x18n.transate,recommentText:x18n.btnReply,quickReply:x18n.quickReply}},
            getJson:function(){return [];},
            emCode:'emCn'
        };
        $.extend(true,options,setting);
        var fastTree,roots;
        This.refresh=function(data,reverse){
            var tempHtml=[];
            var rst=[];
            fastTree=root={};//更新数据
            if(data){//支持多载
                roots=sortJson(data,options.html.staticData)
            }else{
                roots=sortJson(options.getJson(),options.html.staticData);
            }
            for(var root in roots){
                tempHtml=[toolLq.htmlTemplate(options.html.templateParent,roots[root][0])];
                for(var i=1;i<roots[root].length;i++){//root中第一个元素为根，其他元素为子节点
                    tempHtml.push(toolLq.htmlTemplate(options.html.templateChild,roots[root][i]));
                }
                tempHtml.push(toolLq.htmlTemplate(options.html.templateClose,roots[root][0]));
                rst.push(tempHtml.join(''));
            }
            if(reverse)rst.reverse();
            rst=$.fn.jqfaceShow({str:rst.join(''),emCode:options.emCode});
            switch(options.addMethod){
                case 'append':
                    return This.append(rst);
                default:
                    return This.empty().append(rst);
            }
        };
        //json生成二级树
        function sortJson(json,inheritClass){
            var ret={};
            var pid='';
            for(var i=0;i<json.length;i++){
                fastNodeAdd(json[i],fastTree);
                json[i].userIdImg=toMemberSmallHeader(json[i].userId);
                if((!json[i].Pid)){//若为顶级节点
                    ret['Pid'+json[i].id]=[json[i]];
                }else{
                    pid=json[i].Pid;
                    json[i].parentUserId=findNode(pid,json).userId;//写入父节点的用户名Id
                    while(!('Pid'+pid in ret)){//找到顶级节点后终止循环
                        pid=findNode(pid,json).Pid;
                        if(!(pid)||pid==''){
                            //toolLq.log('数据格式错误，可能未按时间排序');
                            break;
                        }
                    }
                    ret['Pid'+pid].push(json[i]);
                }
                $.extend(json[i],inheritClass);
            }
            return ret;
        }
        //直接递归遍历，性能爆弱，没有转换二叉树后遍历
        //使用一个循环减少性能
        function fastNodeAdd(node,fastTree){
            var tempStr;
            if((tempStr='id'+node.Pid) in fastTree){
                fastTree[tempStr].children.push(node.id);
            }
            fastTree['id'+node.id]={id:node.id,children:[],parent:node.Pid};
        }
        //递归获取节点子id，性能爆弱
        This.getChildren=function(id,del){
            if(!('id'+id in fastTree)) return null;
            var ret=[];
            findNodes(id,ret);
            return ret;
        };
        //删除节点
        This.delNode=function(id){
            if(!('id'+id in fastTree)){
                //toolLq.log('id不存在，无法操作!',null);
                return id;
            }
            var ret=[],
                tempArr=[];
            if(tempArr=fastTree['id'+id].parent){
                tempArr=fastTree['id'+tempArr].children;
                for(var j=0;j<tempArr.length;j++){//从父级节点中移除该节点
                    if(tempArr[j]==id){
                        tempArr.splice(j,1);
                        break;
                    }
                }
            }
            findNodes(id,ret);
            ret.push(id);
            for(var i=0;i<ret.length;i++){//删除子节点
                delete fastTree['id'+ret[i]];
            }
            return ret;
        };
        //添加节点
        This.addNode=function(id,pid){
            if('id'+id in fastTree){
                //toolLq.log('id已存在，无法操作!',null);
                return id;
            }
            if(pid||pid==0){//插入节点
                if(!('id'+pid in fastTree)){
                    //toolLq.log('pid错误，无法操作!',null);
                    return pid;
                }
                fastTree['id'+pid].children.push(id);
            }
            fastTree['id'+id]={id:id,children:[],parent:pid};
            return id;
        };
        //递归查找子节点，性能爆弱
        function findNodes(id,ret){
            var tempArr=fastTree['id'+id].children;
            for(var i=0;i<tempArr.length;i++){
                ret.push(tempArr[i]);
                if(fastTree['id'+tempArr[i]].children.length>0){
                    findNodes(tempArr[i],ret);
                }
            }
            return tempArr;
        }
        //循环查找节点
        function findNode(id,nodes){
            for(var i=0;i<nodes.length;i++){
                if(nodes[i].id==id){
                    return nodes[i]
                }
            }
        }
        //返回handler
        function getTreeHd(){
            return This;
        }
        this.data('getTreeHd',getTreeHd);
        return this;
    };
    function runDatafun(key,jqObj,arg){
        if(typeof jqObj.data(key)=='function'){
            return jqObj.data(key)(arg);
        }
        return null;
    }
})(jQuery);
(function ($) {
    $.fn.reply = function (setting, arg) {        
        //
        if (typeof setting == 'string') return runDatafun(setting, this, arg);
        this.each(function () {
            var This = $(this);
            var reply = new Reply(this, setting);
            //事件绑定
            This.attr("id",This.attr("data-id"));//替换id
            This.delegate('.recomment_op1_lq', 'click', function () { reply.showReplyInput(this) }).
                delegate('.reply_simple_lq', 'click', function () { reply.showReplyInput(this) }).
                delegate('.reply_input_lq', 'mouseenter', function () { $(this).data('disableClose', true) }).
                delegate('.reply_input_lq', 'mouseleave', function () { $(this).data('disableClose', false) }).
                delegate('.reply_input_lq', 'focus', function () { $(this).data('disableClose', true); reply.closeReply() }).
                delegate('.reply_input_lq', 'blur', function () { $(this).data('disableClose', false); }).
                delegate('.gray_btn1_lq', 'click', function (e) { e.stopPropagation(); reply.submitReply(this) }).
                delegate('.delete_op1_lq', 'click', function () { reply.delReply(this) });
            //捆绑指令
            $(this).data('getReply', getReply);
            function getReply() {
                return reply;
            }
        });
        return this;
    };
    //Reply静态属性
    function Reply(root, setting) {
        this.options = {
            input: { maxHeight: 150,
                wordMax: 240,
                emCode: x18n.emCode,
                gifurl: '/Content/blue/emotions/images/',
                onFlow: function () { return true },
                onEmpty:function () { return true }
            },
            faceshow: {
                imageUrl: '/Content/blue/emotions/images/',
                str: '',
                emCode:x18n.emCode
            },
            memberId: 'eee',
            reverse:false,
            onResize:$.noop,
            tree: {
                createNode: $.noop,
                delNode: $.noop,
                template: {
                    inner: '<dd><dl datalq1="Id:${id},userId:${userId}" class="child_box1_lq"><dt><img src="${memberHeader}" width="32" height="32" alt="${userId}"/></dt><dd><p><a class="name_box1_lq">${userId}&nbsp;${recommentText}&nbsp;${parentUserId}：</a>${content}</p><p><span class="send_time" dateutc="${sendTime}"></span><span class="comment_op1_lq"><a class="recomment_op1_lq">${recommentText}</a><a class="delete_op1_lq close_icon1_lq">×</a></span></p></dd></dl></dd>',
                    outer: '<dl datalq1="Id:${id},userId:${userId}"><dt><img src="${memberHeader}" width="32" height="32" alt="${userId}"/></dt><dd><p><a class="name_box1_lq">${userId}&nbsp;：</a>${content}</p><p><span class="send_time" dateutc="${sendTime}"></span><span class="comment_op1_lq"><a class="recomment_op1_lq">${recommentText}</a><a class="delete_op1_lq close_icon1_lq">×</a></span></p></dd></dl>',
                    data: {}
                }
            }
        };
        $.extend(true, this.options, setting);
        this.root = $(root);
        this.tree = this.root.find('.comment_tree1_lq').commentTree('getTreeHd');
        this.docBinds = 0;
    }
    //Reply动态方法
    $.extend(Reply.prototype, {
        //显示回复框
        showReplyInput: function (dom) {
            var jqBtnOrInp = $(dom);
            var jqDd = jqBtnOrInp.parent();
            var jqReply;
            var json;
            var This = this;
            if (dom.className == 'recomment_op1_lq') {
                jqDd = jqBtnOrInp.closest('.comment_tree1_lq>dl').has(dom).
                    find('.reply_box1_lq,.reply_simple_lq');
                if (jqDd[0].tagName.toLowerCase() == 'input') {
                    jqDd = jqDd.parent();
                } else {
                    jqDd.removeClass('hidden1_lq');
                }
            }
            jqReply = jqDd.find('.reply_input_lq');
            if (jqReply.length < 1) {
                jqReply = $($.fn.replyInput(null, true)).appendTo(jqDd);
                jqReply.replyInput(this.options.input);
            }
            if (dom.className == 'recomment_op1_lq') {
                json = toolLq.strToJson(jqBtnOrInp.closest('dl').attr('datalq1'));
                this.fillReply(jqReply, json.userId);
                jqReply.find('.mood_text1_lq').data('pid', json.Id);
            } else {
                json = toolLq.strToJson(jqReply.closest('dl').attr('datalq1'));
                this.fillReply(jqReply, json.userId);
                jqReply.find('.mood_text1_lq').data('pid', json.Id);
            }
            jqReply.prev().addClass('hidden1_lq').end().
                removeClass('hidden1_lq');
                var text = jqReply.find('.mood_text1_lq').val();
                jqReply.find('.mood_text1_lq').val('');
                jqReply.find('.mood_text1_lq')[0].focus();
                jqReply.find('.mood_text1_lq').val(text);
            jqReply.find('.mood_text1_lq')[0].focus();
            if (this.docBinds < 1) {//只注册一次
                $(document).bind('click.closeReply', function (e) {if($(e.target).parents('.reply_box1_lq').length > 0 || $(e.target).parents('.root_reply_lq').length > 0) return; This.closeReply.call(This) });
            }
            this.options.onResize();
            this.docBinds++;
            jqBtnOrInp = jqDd = jqReply = null;
        },
        //自动填充回复内容
        fillReply: function (jqReply, name) {
            var tempStr = [x18n.btnReply, ' ', name, ':'].join('');
            var fillReg = new RegExp('^' + tempStr, 'i');
            jqReply.data('replyInput').options.filterRegs = [{ reg: fillReg, str: ''}];
            jqReply.find('.mood_text1_lq').focus().val(tempStr).data('fillReg', fillReg).
                data('userId', name);
        },
        //关闭回复框
        closeReply: function () {
            var This = this;
            this.root.find('.mood_text1_lq:visible').each(function () {
                var jqObj = $(this).closest('.reply_input_lq');
                if (jqObj.data('disableClose')) return;
                This.delFillReply(this);
                if (!toolLq.trim(this.value)) {
                    jqObj.addClass('hidden1_lq').prev().removeClass('hidden1_lq');
                    This.docBinds--;
                    if (This.docBinds < 1) {
                        $(document).unbind('click.closeReply');
                    }
                }
            });
            this.options.onResize();
        },
        //删除自动填充
        delFillReply: function (domTexta) {
            if (!toolLq.trim(domTexta.value.replace($(domTexta).data('fillReg'), ''))) {
                domTexta.value = '';
            }
        },
        //发布评论
        submitReply: function (content, jqTxt, id, pid, data) {
            //            重载
            //            content为dom时参数为domBtn,data（外部数据替换),template模板
            //            content为string时，为content,jqTxt,id,pid,data
            if (typeof content == 'string') {
                this.options.faceshow.str = toolLq.filterLt(content);
                content = $.fn.jqfaceShow(this.options.faceshow);
                jqDl = jqTxt.data('jqDl');
                if (data) {
                    jqDl.html(toolLq.htmlTemplate(jqDl.html(), data));
                    content=toolLq.htmlTemplate(content,data);
                }
                jqDl.find('.waiting_lq').replaceWith(content);
                jqDl.attr('datalq1', toolLq.htmlTemplate(jqDl.attr('datalq1'), { id: id }));
                this.tree.addNode(id, pid);
                jqTxt.val('');
                this.closeReply();
            } else {
                jqTxt = $(arguments[0]).parent().siblings('.mood_text1_lq');
                var count = jqTxt.closest('.reply_input_lq').data('replyInput').getCount();
                if (count.isFlow) {
                    if (!this.options.input.onFlow(count.count)) return;
                }
                if(count.count<1){
                    if (!this.options.input.onEmpty(count.count)) return;
                }
                arguments[2] = arguments[2] ? arguments[2] : {};
                var template = arguments[2].inner || this.options.tree.template.inner;
                var data = {
                    userId: this.options.memberId,
                    userIdImg: toMemberSmallHeader(this.options.memberId),
                    recommentText: x18n.btnReply,
                    parentUserId: jqTxt.data('userId'),
                    content: '<span class="waiting_lq" >'+x18n.dataProcessing+'....</span>',
                    sendTime: toolLq.getUTCStr(new Date())
                };
              //  console.log(data);
                var jqDl;
                $.extend(data, this.options.tree.template.data);
                $.extend(data, arguments[1]);
                var tempJqCt = this.root.find('.comment_tree1_lq');
                if (tempJqCt.find(arguments[0]).length > 0) {//若回复框在树中，则直接添加
                    jqDl = $(toolLq.htmlTemplate(template, data));
                    jqTxt.closest('dd').before(jqDl);
                    jqTxt.data('jqDl', jqDl.children('dl'));
                } else {//回复框在外部
                    template = arguments[2].outer || this.options.tree.template.outer;
                    jqDl = $(toolLq.htmlTemplate(template, data));
                    if(this.options.reverse){
                        tempJqCt.prepend(jqDl);
                    }else{
                        tempJqCt.append(jqDl);
                    }
                    jqTxt.data('jqDl', jqDl);
                }
                pid = jqTxt.data('pid');
                data.content = jqTxt.val().replace(jqTxt.data('fillReg'), '');
                this.options.tree.createNode(toolLq.filterEmail(toolLq.filterLt(data.content)), pid, jqTxt, this);
                this.options.onResize();
            }
        },
        //删除评论
        delReply: function (ids, jqDl) {
            if (ids instanceof Array) {
                this.tree.delNode(ids[ids.length - 1]);
                this.removeDom(ids, jqDl);
            } else {
                jqDl = $(ids).closest('dl');
                var id = toolLq.getStrValue('Id', jqDl.attr('datalq1'));
                ids = this.tree.getChildren(id);
                ids.push(id);
                this.options.tree.delNode(ids, jqDl, this);
                this.options.onResize();
            }
        },
        //移除对应节点
        removeDom: function (ids, jqDl) {
            if (jqDl.parent().hasClass('comment_tree1_lq')) {//顶级节点
                jqDl.remove();
            } else if (ids.length == 1) {//单个节点，直接删除
                jqDl.parent().remove();
            } else {
                var hashTab = {};
                var count = ids.length;
                for (var i = 0; i < ids.length; i++) {
                    hashTab[ids[i]] = ids[i];
                }
                jqDl.parent().closest('dl').find('dl').each(function () {
                    var jqObj = $(this);
                    if (toolLq.getStrValue('Id', jqObj.attr('datalq1')) in hashTab) {
                        jqObj.parent().remove();
                        count--;
                        if (count == 0) return false;
                    }
                });
            }
            this.options.onResize();
        }
    });
    function runDatafun(key, jqObj, arg) {
        if (typeof jqObj.data(key) == 'function') {
            return jqObj.data(key)(arg);
        }
        return null;
    }
})(jQuery);
/**
邮件对话形式显示
 by:kule 2012-05-22
 */
//opShowTime，opDelTime为操作按钮动画时间，设为null时禁用动画
//showData为显示原文内容函数，需返回原文字符串，参数为按钮的this引用
//deleteOp为删除前的截获函数，返回true则执行删除，否则不执行，参数为按钮的this引用
//translateOp为翻译处理函数，参数为按钮的this引用
//showBtnName为显示原文按钮文本，hiddenBtnName为隐藏原文按钮文本
//显示对话操作框
;(function($){
    $.fn.emailDialog=function(options,args){
        var This=this;
        if (typeof options == 'string') return runDatafun(options,this,args);
        var emptyfun=function(){};
        options=$.extend({
            opShowTime:500,
            opDelTime:1000,
            sourceData:emptyfun,
            deleteOp:emptyfun,
            translateOp:emptyfun,
            showBtnName:x18n.showBtnName,
            hiddenBtnName:x18n.hiddenBtnName,
            loading:x18n.loading
        },options);
/*        this.delegate('dd','mouseenter',function(){
            $('.dialogue_op1',this).removeClass('hidden1_lq');
        })
        //操作按钮隐现
        .delegate('dd','mouseleave',function(){
            $('.dialogue_op1,.translate_op2',this)
                .addClass('hidden1_lq');
        });*/
        //显示原文
        this.delegate('.show_original_op1','click',function(){
            var This=$(this);
            var jqObj=This.closest('dd').find('.original_text');
            if(jqObj.length<1){//若为第一次显示则远程获取翻译原文
                jqObj=This.closest('dd').prepend(['<div class="original_text">',
                    options.loading,'</div>'].join('')).find('.original_text');
                options.sourceData(this,jqObj);
            }
            if(This.html()==options.showBtnName){
                jqObj.removeClass('hidden1_lq');
                This.html(options.hiddenBtnName);
            }else{
                jqObj.addClass('hidden1_lq');
                This.html(options.showBtnName);
            }
            This=jqObj=null;
        })
        //删除
        .delegate('.delete_email_op1','click',function(){
                options.deleteOp(this);
        })
        //翻译
        .delegate('.translate_op1','click',function(e){
            var jqObj=$(this).parent('span');
            jqObj.addClass('hidden1_lq').next('.translate_op2')
                .removeClass('hidden3_lq');
        })
        .delegate('.translate_op2 a','click',function(e){
            options.translateOp(this);
            $(this).parent().addClass('hidden3_lq');
        })
        .delegate('.translate_op2','mouseleave',function(){
            $(this).addClass('hidden3_lq').prev().removeClass('hidden1_lq');
        });
        This.data('delDia',delEffect);
        function delEffect(btn){
            var jqObj={};
            var position={};
            if(options.opDelTime){//删除特效
                jqObj=$(btn).closest('dl');
                position=jqObj.position();
                jqObj.css({position:'absolute',zIndex:'999',top:position.top})
                    .animate({top:position.top+200+'px',opacity:0},options.opDelTime,
                    function(){
                        $(this).remove();
                    });
            }else{
                $(btn).closest('dl').remove();
            }
        }
        return this;
    };
    function runDatafun(key, jqObj, arg) {
        if (typeof jqObj.data(key) == 'function') {
            return jqObj.data(key)(arg);
        }
        return null;
    }
})(jQuery);
/**
 *  Zebra_DatePicker
 *
 *  Zebra_DatePicker is a small, compact and highly configurable date picker plugin for jQuery
 *
 *  Visit {@link http://stefangabos.ro/jquery/zebra-datepicker/} for more information.
 *
 *  For more resources visit {@link http://stefangabos.ro/}
 *
 *  @author     Stefan Gabos <contact@stefangabos.ro>
 *  @version    1.4.1 (last revision: July 29, 2012)
 *  @copyright  (c) 2011 - 2012 Stefan Gabos
 *  @license    http://www.gnu.org/licenses/lgpl-3.0.txt GNU LESSER GENERAL PUBLIC LICENSE
 *  @package    Zebra_DatePicker
 */
;(function($) {

    $.Zebra_DatePicker = function(element, options) {

        var defaults = {

            //  by default, the button for clearing a previously selected date is shown only if a previously selected date
            //  already exists; this means that if the input the date picker is attached to is empty, and the user selects
            //  a date for the first time, this button will not be visible; once the user picked a date and opens the date
            //  picker again, this time the button will be visible.
            //
            //  setting this property to TRUE will make this button visible all the time
            always_show_clear:  false,

            //  setting this property to a jQuery element, will result in the date picker being always visible, the indicated
            //  element being the date picker's container;
            //  note that when this property is set to TRUE, the "always_show_clear" property will automatically be set to TRUE
            always_visible:     false,

            //  days of the week; Sunday to Saturday
            days:               ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],

            //  direction of the calendar
            //
            //  a positive or negative integer: n (a positive integer) creates a future-only calendar beginning at n days
            //  after today; -n (a negative integer); if n is 0, the calendar has no restrictions. use boolean true for
            //  a future-only calendar starting with today and use boolean false for a past-only calendar ending today.
            //
            //  you may also set this property to an array with two elements in the following combinations:
            //
            //  -   first item is boolean TRUE (calendar starts today), an integer > 0 (calendar starts n days after
            //      today), or a valid date given in the format defined by the "format" attribute (calendar starts at the
            //      specified date), and the second item is boolean FALSE (the calendar has no ending date), an integer
            //      > 0 (calendar ends n days after the starting date), or a valid date given in the format defined by
            //      the "format" attribute and which occurs after the starting date (calendar ends at the specified date)
            //
            //  -   first item is boolean FALSE (calendar ends today), an integer < 0 (calendar ends n days before today),
            //      or a valid date given in the format defined by the "format" attribute (calendar ends at the specified
            //      date), and the second item is an integer > 0 (calendar ends n days before the ending date), or a valid
            //      date given in the format defined by the "format" attribute and which occurs before the starting date
            //      (calendar starts at the specified date)
            //
            //  [1, 7] - calendar starts tomorrow and ends seven days after that
            //  [true, 7] - calendar starts today and ends seven days after that
            //  ['2013-01-01', false] - calendar starts on January 1st 2013 and has no ending date ("format" is YYYY-MM-DD)
            //  [false, '2012-01-01'] - calendar ends today and starts on January 1st 2012 ("format" is YYYY-MM-DD)
            //
            //  note that "disabled_dates" property will still apply!
            //
            //  default is 0 (no restrictions)
            direction:          0,

            //  an array of disabled dates in the following format: 'day month year weekday' where "weekday" is optional
            //  and can be 0-6 (Saturday to Sunday); the syntax is similar to cron's syntax: the values are separated by
            //  spaces and may contain * (asterisk) - (dash) and , (comma) delimiters:
            //
            //  ['1 1 2012'] would disable January 1, 2012;
            //  ['* 1 2012'] would disable all days in January 2012;
            //  ['1-10 1 2012'] would disable January 1 through 10 in 2012;
            //  ['1,10 1 2012'] would disable January 1 and 10 in 2012;
            //  ['1-10,20,22,24 1-3 *'] would disable 1 through 10, plus the 22nd and 24th of January through March for every year;
            //  ['* * * 0,6'] would disable all Saturdays and Sundays;
            //  ['01 07 2012', '02 07 2012', '* 08 2012'] would disable 1st and 2nd of July 2012, and all of August of 2012
            //
            //  default is FALSE, no disabled dates
            disabled_dates:     false,

            //  week's starting day
            //
            //  valid values are 0 to 6, Sunday to Saturday
            //
            //  default is 1, Monday
            first_day_of_week:  1,

            //  format of the returned date
            //
            //  accepts the following characters for date formatting: d, D, j, l, N, w, S, F, m, M, n, Y, y borrowing
            //  syntax from (PHP's date function)
            //
            //  note that when setting a date format without days ('d', 'j'), the users will be able to select only years
            //  and months, and when setting a format without months and days ('F', 'm', 'M', 'n', 't', 'd', 'j'), the
            //  users will be able to select only years.
            //
            //  also note that the value of the "view" property (see below) may be overridden if it is the case: a value of
            //  "days" for the "view" property makes no sense if the date format doesn't allow the selection of days.
            //
            //  default is Y-m-d
            format:             'Y-m-d',

            //  should the icon for opening the datepicker be inside the element?
            //  if set to FALSE, the icon will be placed to the right of the parent element, while if set to TRUE it will
            //  be placed to the right of the parent element, but *inside* the element itself
            //
            //  default is TRUE
            inside:             true,

            //  the caption for the "Clear" button
            lang_clear_date:    'Clear',

            //  months names
            months:             ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],

            //  the offset, in pixels (x, y), to shift the date picker's position relative to the top-left of the icon
            //  that toggles the date picker
            //
            //  default is [20, -5]
            offset:             [0,0],

            //  if set as a jQuery element with a Zebra_Datepicker attached, that particular date picker will use the
            //  current date picker's value as starting date
            //  note that the rules set in the "direction" property will still apply, only that the reference date will
            //  not be the current system date but the value selected in the current date picker
            //  default is FALSE (not paired with another date picker)
            pair:              false,

            //  should the element the calendar is attached to, be read-only?
            //  if set to TRUE, a date can be set only through the date picker and cannot be entered manually
            //
            //  default is TRUE
            readonly_element:   true,

            //  should an extra column be shown, showing the number of each week?
            //  anything other than FALSE will enable this feature, and use the given value as column title
            //  i.e. show_week_number: 'Wk' would enable this feature and have "Wk" as the column's title
            //
            //  default is FALSE
            show_week_number:   false,

            //  a default date to start the date picker with
            //  must be specified in the format defined by the "format" property, or it will be ignored!
            //  note that this value is used only if there is no value in the field the date picker is attached to!
            start_date:         false,

            //  how should the date picker start; valid values are "days", "months" and "years"
            //  note that the date picker is always cycling days-months-years when clicking in the date picker's header,
            //  and years-months-days when selecting dates (unless one or more of the views are missing due to the date's
            //  format)
            //
            //  also note that the value of the "view" property may be overridden if the date's format requires so! (i.e.
            //  "days" for the "view" property makes no sense if the date format doesn't allow the selection of days)
            //
            //  default is "days"
            view:               'days',

            //  days of the week that are considered "weekend days"
            //  valid values are 0 to 6, Sunday to Saturday
            //
            //  default values are 0 and 6 (Saturday and Sunday)
            weekend_days:       [0, 6],

            //  callback function to be executed when a date is selected
            //  the callback function takes 3 parameters:
            //  -   the date in the format specified by the "format" attribute;
            //  -   the date in YYYY-MM-DD format
            //  -   the date as a JavaScript Date object
            onSelect:           null,
            selector:'body'

        };

        // private properties
        var view, datepicker, icon, header, daypicker, monthpicker, yearpicker, footer, current_system_month, current_system_year,
            current_system_day, first_selectable_month, first_selectable_year, first_selectable_day, selected_month, selected_year,
            default_day, default_month, default_year, disabled_dates, shim, start_date, end_date, last_selectable_day,
            last_selectable_year, last_selectable_month, daypicker_cells, monthpicker_cells, yearpicker_cells, views;

        var plugin = this;

        plugin.settings = {

        };

        // the jQuery version of the element
        // "element" (without the $) will point to the DOM element
        var $element = $(element);

        /**
         *  Constructor method. Initializes the date picker.
         *
         *  @return void
         */
        var init = function(update) {

            // merge default settings with user-settings (unless we're just updating settings)
            if (!update) plugin.settings = $.extend({}, defaults, options);

            // if the element should be read-only, set the "readonly" attribute
            if (plugin.settings.readonly_element) $element.attr('readonly', 'readonly');

            // determine the views the user can cycle through, depending on the format
            // that is, if the format doesn't contain the day, the user will be able to cycle only through years and months,
            // whereas if the format doesn't contain months nor days, the user will only be able to select years

            var

                // the characters that may be present in the date format and that represent days, months and years
                date_chars = {
                    days:   ['d', 'j'],
                    months: ['F', 'm', 'M', 'n', 't'],
                    years:  ['o', 'Y', 'y']
                },

                // some defaults
                has_days = false,
                has_months = false,
                has_years = false;

            // iterate through all the character blocks
            for (type in date_chars)

                // iterate through the characters of each block
                $.each(date_chars[type], function(index, character) {

                    // if current character exists in the "format" property
                    if (plugin.settings.format.indexOf(character) > -1)

                        // set to TRUE the appropriate flag
                        if (type == 'days') has_days = true;
                        else if (type == 'months') has_months = true;
                        else if (type == 'years') has_years = true;

                });

            // if user can cycle through all the views, set the flag accordingly
            if (has_days && has_months && has_years) views = ['years', 'months', 'days'];

            // if user can cycle only through year and months, set the flag accordingly
            else if (!has_days && has_months && has_years) views = ['years', 'months'];

            // if user can only see the year picker, set the flag accordingly
            else if (!has_days && !has_months && has_years) views = ['years'];

            // if invalid format (no days, no months, no years) use the default where the user is able to cycle through
            // all the views
            else views = ['years', 'months', 'days'];

            // if the starting view is not amongst the views the user can cycle through, set the correct starting view
            if ($.inArray(plugin.settings.view, views) == -1) plugin.settings.view = views[views.length - 1];

            var

                // cache the current system date
                date = new Date(),

                // when the date picker's starting date depends on the value of another date picker, this value will be
                // set by the other date picker
                // this value will be used as base for all calculations (if not set, will be the same as the current
                // system date)
                reference_date = (!plugin.settings.reference_date ? ($element.data('zdp_reference_date') ? $element.data('zdp_reference_date') : date) : plugin.settings.reference_date),
                tmp_start_date, tmp_end_date;

            // reset these values here as this method might be called more than once during a date picker's lifetime
            // (when the selectable dates depend on the values from another date picker)
            start_date = undefined; end_date = undefined;

            // extract the date parts
            // also, save the current system month/day/year - we'll use them to highlight the current system date
            first_selectable_month = reference_date.getMonth();
            current_system_month = date.getMonth();
            first_selectable_year = reference_date.getFullYear();
            current_system_year = date.getFullYear();
            first_selectable_day = reference_date.getDate();
            current_system_day = date.getDate();

            // check if the calendar has any restrictions

            // calendar is future-only, starting today
            // it means we have a starting date (the current system date), but no ending date
            if (plugin.settings.direction === true) start_date = reference_date;

            // calendar is past only, ending today
            else if (plugin.settings.direction === false) {

                // it means we have an ending date (the reference date), but no starting date
                end_date = reference_date;

                // extract the date parts
                last_selectable_month = end_date.getMonth();
                last_selectable_year = end_date.getFullYear();
                last_selectable_day = end_date.getDate();

            } else if (

                // if direction is not given as an array and the value is an integer > 0
                (!$.isArray(plugin.settings.direction) && is_integer(plugin.settings.direction) && to_int(plugin.settings.direction) > 0) ||

                // or direction is given as an array
                ($.isArray(plugin.settings.direction) && (

                    // and first entry is boolean TRUE
                    plugin.settings.direction[0] === true ||
                    // or an integer > 0
                    (is_integer(plugin.settings.direction[0]) && plugin.settings.direction[0] > 0) ||
                    // or a valid date
                    (tmp_start_date = check_date(plugin.settings.direction[0]))

                ) && (

                    // and second entry is boolean FALSE
                    plugin.settings.direction[1] === false ||
                    // or integer >= 0
                    (is_integer(plugin.settings.direction[1]) && plugin.settings.direction[1] >= 0) ||
                    // or a valid date
                    (tmp_end_date = check_date(plugin.settings.direction[1]))

                ))

            ) {


                // if an exact starting date was given, use that as a starting date
                if (tmp_start_date) start_date = tmp_start_date;

                // otherwise
                else

                    // figure out the starting date
                    // use the Date object to normalize the date
                    // for example, 2011 05 33 will be transformed to 2011 06 02
                    start_date = new Date(
                        first_selectable_year,
                        first_selectable_month,
                        first_selectable_day + (!$.isArray(plugin.settings.direction) ? to_int(plugin.settings.direction) : to_int(plugin.settings.direction[0] === true ? 0 : plugin.settings.direction[0]))
                    );

                // re-extract the date parts
                first_selectable_month = start_date.getMonth();
                first_selectable_year = start_date.getFullYear();
                first_selectable_day = start_date.getDate();

                // if an exact ending date was given and the date is after the starting date, use that as a ending date
                if (tmp_end_date && +tmp_end_date > +start_date) end_date = tmp_end_date;

                // if have information about the ending date
                else if (!tmp_end_date && plugin.settings.direction[1] !== false && $.isArray(plugin.settings.direction))

                    // figure out the ending date
                    // use the Date object to normalize the date
                    // for example, 2011 05 33 will be transformed to 2011 06 02
                    end_date = new Date(
                        first_selectable_year,
                        first_selectable_month,
                        first_selectable_day + to_int(plugin.settings.direction[1])
                    );

                // if a valid ending date exists
                if (end_date) {

                    // extract the date parts
                    last_selectable_month = end_date.getMonth();
                    last_selectable_year = end_date.getFullYear();
                    last_selectable_day = end_date.getDate();

                }

            } else if (

                // if direction is not given as an array and the value is an integer < 0
                (!$.isArray(plugin.settings.direction) && is_integer(plugin.settings.direction) && to_int(plugin.settings.direction) < 0) ||

                // or direction is given as an array
                ($.isArray(plugin.settings.direction) && (

                    // and first entry is boolean FALSE
                    plugin.settings.direction[0] === false ||
                    // or an integer < 0
                    (is_integer(plugin.settings.direction[0]) && plugin.settings.direction[0] < 0)

                ) && (

                    // and second entry is integer >= 0
                    (is_integer(plugin.settings.direction[1]) && plugin.settings.direction[1] >= 0) ||
                    // or a valid date
                    (tmp_start_date = check_date(plugin.settings.direction[1]))

                ))

            ) {

                // figure out the ending date
                // use the Date object to normalize the date
                // for example, 2011 05 33 will be transformed to 2011 06 02
                end_date = new Date(
                    first_selectable_year,
                    first_selectable_month,
                    first_selectable_day + (!$.isArray(plugin.settings.direction) ? to_int(plugin.settings.direction) : to_int(plugin.settings.direction[0] === false ? 0 : plugin.settings.direction[0]))
                );

                // re-extract the date parts
                last_selectable_month = end_date.getMonth();
                last_selectable_year = end_date.getFullYear();
                last_selectable_day = end_date.getDate();

                // if an exact starting date was given, and the date is before the ending date, use that as a starting date
                if (tmp_start_date && +tmp_start_date < +end_date) start_date = tmp_start_date;

                // if have information about the starting date
                else if (!tmp_start_date && $.isArray(plugin.settings.direction))

                    // figure out the staring date
                    // use the Date object to normalize the date
                    // for example, 2011 05 33 will be transformed to 2011 06 02
                    start_date = new Date(
                        last_selectable_year,
                        last_selectable_month,
                        last_selectable_day - to_int(plugin.settings.direction[1])
                    );

                // if a valid starting date exists
                if (start_date) {

                    // extract the date parts
                    first_selectable_month = start_date.getMonth();
                    first_selectable_year = start_date.getFullYear();
                    first_selectable_day = start_date.getDate();

                }

            }

            // if a first selectable date exists but is disabled, find the actual first selectable date
            if (start_date && is_disabled(first_selectable_year, first_selectable_month, first_selectable_day)) {

                // loop until we find the first selectable year
                while (is_disabled(first_selectable_year)) {

                    // if calendar is past-only, decrement the year
                    if (!start_date) first_selectable_year--;

                    // otherwise, increment the year
                    else first_selectable_year++;

                    // because we've changed years, reset the month to January
                    first_selectable_month = 0;

                }

                // loop until we find the first selectable month
                while (is_disabled(first_selectable_year, first_selectable_month)) {

                    // if calendar is past-only, decrement the month
                    if (!start_date) first_selectable_month--;

                    // otherwise, increment the month
                    else first_selectable_month++;

                    // if we moved to a following year
                    if (first_selectable_month > 11) {

                        // increment the year
                        first_selectable_year++;

                        // reset the month to January
                        first_selectable_month = 0;

                    // if we moved to a previous year
                    } else if (first_selectable_month < 0) {

                        // decrement the year
                        first_selectable_year--;

                        // reset the month to January
                        first_selectable_month = 0;

                    }

                    // because we've changed months, reset the day to the first day of the month
                    first_selectable_day = 1;

                }

                // loop until we find the first selectable day
                while (is_disabled(first_selectable_year, first_selectable_month, first_selectable_day))

                    // if calendar is past-only, decrement the day
                    if (!start_date) first_selectable_day--;

                    // otherwise, increment the day
                    else first_selectable_day++;

                // use the Date object to normalize the date
                // for example, 2011 05 33 will be transformed to 2011 06 02
                date = new Date(first_selectable_year, first_selectable_month, first_selectable_day);

                // re-extract date parts from the normalized date
                // as we use them in the current loop
                first_selectable_year = date.getFullYear();
                first_selectable_month = date.getMonth();
                first_selectable_day = date.getDate();

            }

            // parse the rules for disabling dates and turn them into arrays of arrays

            // array that will hold the rules for disabling dates
            disabled_dates = [];

            // iterate through the rules for disabling dates
            $.each(plugin.settings.disabled_dates, function() {

                // split the values in rule by white space
                var rules = this.split(' ');

                // there can be a maximum of 4 rules (days, months, years and, optionally, day of the week)
                for (var i = 0; i < 4; i++) {

                    // if one of the values is not available
                    // replace it with a * (wildcard)
                    if (!rules[i]) rules[i] = '*';

                    // if rule contains a comma, create a new array by splitting the rule by commas
                    // if there are no commas create an array containing the rule's string
                    rules[i] = (rules[i].indexOf(',') > -1 ? rules[i].split(',') : new Array(rules[i]));

                    // iterate through the items in the rule
                    for (var j = 0; j < rules[i].length; j++)

                        // if item contains a dash (defining a range)
                        if (rules[i][j].indexOf('-') > -1) {

                            // get the lower and upper limits of the range
                            var limits = rules[i][j].match(/^([0-9]+)\-([0-9]+)/);

                            // if range is valid
                            if (null != limits) {

                                // iterate through the range
                                for (var k = to_int(limits[1]); k <= to_int(limits[2]); k++)

                                    // if value is not already among the values of the rule
                                    // add it to the rule
                                    if ($.inArray(k, rules[i]) == -1) rules[i].push(k + '');

                                // remove the range indicator
                                rules[i].splice(j, 1);

                            }

                        }

                    // iterate through the items in the rule
                    // and make sure that numbers are numbers
                    for (j = 0; j < rules[i].length; j++) rules[i][j] = (isNaN(to_int(rules[i][j])) ? rules[i][j] : to_int(rules[i][j]));

                }

                // add to the list of processed rules
                disabled_dates.push(rules);

            });

            // get the default date, from the element, and check if it represents a valid date, according to the required format
            var default_date = check_date($element.val() || (plugin.settings.start_date ? plugin.settings.start_date : ''));

            // if there is a default date but it is disabled
            if (default_date && is_disabled(default_date.getFullYear(), default_date.getMonth(), default_date.getDate()))

                // clear the value of the parent element
                $element.val('');

            // updates value for the date picker whose starting date depends on the selected date (if any)
            update_dependent(default_date);

            // if we just needed to recompute the things above, return now
            if (update) return;

            // if date picker is not always visible
            if (!plugin.settings.always_visible) {

                // create the calendar icon (show a disabled icon if the element is disabled)
                var html = '<button type="button" class="Zebra_DatePicker_Icon' + ($element.attr('disabled') == 'disabled' ? ' Zebra_DatePicker_Icon_Disabled' : '') + '">Pick a date</button>';

                // convert to a jQuery object
                icon = $(html);

                // a reference to the icon, as a global property
                plugin.icon = icon;

                // by default, only clicking the calendar icon shows the date picker
                // if text box is read-only, clicking it, will also show the date picker

                // attach the click event
                (plugin.settings.readonly_element ? icon.add($element) : icon).bind('click', function(e) {

                    e.preventDefault();

                    // if element is not disabled
                    if (!$element.attr('disabled'))

                        // if the date picker is visible, hide it
                        if (datepicker.css('display') != 'none') plugin.hide();

                        // if the date picker is not visible, show it
                        else plugin.show();

                });

                // inject the icon into the DOM
                icon.insertAfter(element);

                var

                    // get element's position relative to the offset parent
                    element_position = $(element).position(),

                    // get element's width and height
                    element_height = $(element).outerHeight(true),
                    element_width = $(element).outerWidth(true);

                    // get icon's width and height
                    icon_width = icon.outerWidth(true),
                    icon_height = icon.outerHeight(true);

                // if icon is to be placed *inside* the element
                if (plugin.settings.inside) {

                    // add an extra class to the icon
                    icon.addClass('Zebra_DatePicker_Icon_Inside');

                    // position the icon accordingly
                    icon.css({
                        'left': element_position.left + element_width - icon_width,
                        'top': element_position.top + ((element_height - icon_height) / 2)
                    });

                // if icon is to be placed to the right of the element
                } else

                    // position the icon accordingly
                    icon.css({
                        'left': element_position.left + element_width,
                        'top': element_position.top + ((element_height - icon_height) / 2)
                    });

            }

            // generate the container that will hold everything
            var html = '' +
                '<div class="Zebra_DatePicker">' +
                    '<table class="dp_header">' +
                        '<tr>' +
                            '<td class="dp_previous">&laquo;</td>' +
                            '<td class="dp_caption">&nbsp;</td>' +
                            '<td class="dp_next">&raquo;</td>' +
                        '</tr>' +
                    '</table>' +
                    '<table class="dp_daypicker"></table>' +
                    '<table class="dp_monthpicker"></table>' +
                    '<table class="dp_yearpicker"></table>' +
                    '<table class="dp_footer">' +
                        '<tr><td>' + plugin.settings.lang_clear_date + '</td></tr>' +
                    '</table>' +
                '</div>';

            // create a jQuery object out of the HTML above and create a reference to it
            datepicker = $(html);

            // a reference to the calendar, as a global property
            plugin.datepicker = datepicker;

            // create references to the different parts of the date picker
            header = $('table.dp_header', datepicker);
            daypicker = $('table.dp_daypicker', datepicker);
            monthpicker = $('table.dp_monthpicker', datepicker);
            yearpicker = $('table.dp_yearpicker', datepicker);
            footer = $('table.dp_footer', datepicker);
            // if date picker is not always visible
            if (!plugin.settings.always_visible)

                // inject the container into the DOM
                $(plugin.settings.selector).append(datepicker);

            // otherwise, if element is not disabled
            else if (!$element.attr('disabled')) {

                // inject the date picker into the designated container element
                plugin.settings.always_visible.append(datepicker);

                // and make it visible right away
                plugin.show();

            }

            // add the mouseover/mousevents to all to the date picker's cells
            // except those that are not selectable
            datepicker.
                delegate('td:not(.dp_disabled, .dp_weekend_disabled, .dp_not_in_month, .dp_blocked, .dp_week_number)', 'mouseover', function() {
                    $(this).addClass('dp_hover');
                }).
                delegate('td:not(.dp_disabled, .dp_weekend_disabled, .dp_not_in_month, .dp_blocked, .dp_week_number)', 'mouseout', function() {
                    $(this).removeClass('dp_hover');
                });

            // prevent text highlighting for the text in the header
            // (for the case when user keeps clicking the "next" and "previous" buttons)
            disable_text_select($('td', header));

            // event for when clicking the "previous" button
            $('.dp_previous', header).bind('click', function() {

                // if button is not disabled
                if (!$(this).hasClass('dp_blocked')) {

                    // if view is "months"
                    // decrement year by one
                    if (view == 'months') selected_year--;

                    // if view is "years"
                    // decrement years by 12
                    else if (view == 'years') selected_year -= 12;

                    // if view is "days"
                    // decrement the month and
                    // if month is out of range
                    else if (--selected_month < 0) {

                        // go to the last month of the previous year
                        selected_month = 11;
                        selected_year--;

                    }

                    // generate the appropriate view
                    manage_views();

                }

            });

            // attach a click event to the caption in header
            $('.dp_caption', header).bind('click', function() {

                // if current view is "days", take the user to the next view, depending on the format
                if (view == 'days') view = ($.inArray('months', views) > -1 ? 'months' : ($.inArray('years', views) > -1 ? 'years' : 'days'));

                // if current view is "months", take the user to the next view, depending on the format
                else if (view == 'months') view = ($.inArray('years', views) > -1 ? 'years' : ($.inArray('days', views) > -1 ? 'days' : 'months'));

                // if current view is "years", take the user to the next view, depending on the format
                else view = ($.inArray('days', views) > -1 ? 'days' : ($.inArray('months', views) > -1 ? 'months' : 'years'));

                // generate the appropriate view
                manage_views();

            });

            // event for when clicking the "next" button
            $('.dp_next', header).bind('click', function() {

                // if button is not disabled
                if (!$(this).hasClass('dp_blocked')) {

                    // if view is "months"
                    // increment year by 1
                    if (view == 'months') selected_year++;

                    // if view is "years"
                    // increment years by 12
                    else if (view == 'years') selected_year += 12;

                    // if view is "days"
                    // increment the month and
                    // if month is out of range
                    else if (++selected_month == 12) {

                        // go to the first month of the next year
                        selected_month = 0;
                        selected_year++;

                    }

                    // generate the appropriate view
                    manage_views();

                }

            });

            // attach a click event for the cells in the day picker
            daypicker.delegate('td:not(.dp_disabled, .dp_weekend_disabled, .dp_not_in_month, .dp_week_number)', 'click', function() {

                // put selected date in the element the plugin is attached to, and hide the date picker
                select_date(selected_year, selected_month, to_int($(this).html()), 'days', $(this));

            });

            // attach a click event for the cells in the month picker
            monthpicker.delegate('td:not(.dp_disabled)', 'click', function() {

                // get the month we've clicked on
                var matches = $(this).attr('class').match(/dp\_month\_([0-9]+)/);

                // set the selected month
                selected_month = to_int(matches[1]);

                // if user can select only years and months
                if ($.inArray('days', views) == -1)

                    // put selected date in the element the plugin is attached to, and hide the date picker
                    select_date(selected_year, selected_month, 1, 'months', $(this));

                else {

                    // direct the user to the "days" view
                    view = 'days';

                    // if date picker is always visible
                    // empty the value in the text box the date picker is attached to
                    if (plugin.settings.always_visible) $element.val('');

                    // generate the appropriate view
                    manage_views();

                }

            });

            // attach a click event for the cells in the year picker
            yearpicker.delegate('td:not(.dp_disabled)', 'click', function() {

                // set the selected year
                selected_year = to_int($(this).html());

                // if user can select only years
                if ($.inArray('months', views) == -1)

                    // put selected date in the element the plugin is attached to, and hide the date picker
                    select_date(selected_year, 1, 1, 'years', $(this));

                else {

                    // direct the user to the "months" view
                    view = 'months';

                    // if date picker is always visible
                    // empty the value in the text box the date picker is attached to
                    if (plugin.settings.always_visible) $element.val('');

                    // generate the appropriate view
                    manage_views();

                }

            });

            // bind a function to the onClick event on the table cell in the footer
            $('td', footer).bind('click', function(e) {

                e.preventDefault();

                // clear the element's value
                $element.val('');

                // if date picker is not always visible
                if (!plugin.settings.always_visible) {

                    // reset these values
                    default_day = null; default_month = null; default_year = null; selected_month = null; selected_year = null;

                    // remove the footer element
                    footer.css('display', 'none');

                }

                // hide the date picker
                plugin.hide();

            });

            // if date picker is not always visible
            if (!plugin.settings.always_visible)

                // bind some events to the document
                $(document).bind({

                    //whenever anything is clicked on the page or a key is pressed
                    'mousedown.zebra_datepicker': plugin._mousedown,
                    'keyup.zebra_datepicker': plugin._keyup

                });

            // last thing is to pre-render some of the date picker right away
            manage_views();

        };

        /**
         *  Hides the date picker.
         *
         *  @return void
         */
        plugin.hide = function() {

            // if date picker is not always visible
            if (!plugin.settings.always_visible) {

                // hide the iFrameShim in Internet Explorer 6
                iframeShim('hide');

                // hide the date picker
                datepicker.css('display', 'none');

            }

        };

        /**
         *  Shows the date picker.
         *
         *  @return void
         */
        plugin.show = function() {

            // always show the view defined in settings
            view = plugin.settings.view;

            // get the default date, from the element, and check if it represents a valid date, according to the required format
            var default_date = check_date($element.val() || (plugin.settings.start_date ? plugin.settings.start_date : ''));

            // if the value represents a valid date
            if (default_date) {

                // extract the date parts
                // we'll use these to highlight the default date in the date picker and as starting point to
                // what year and month to start the date picker with
                // why separate values? because selected_* will change as user navigates within the date picker
                default_month = default_date.getMonth();
                selected_month = default_date.getMonth();
                default_year = default_date.getFullYear();
                selected_year = default_date.getFullYear();
                default_day = default_date.getDate();

                // if the default date represents a disabled date
                if (is_disabled(default_year, default_month, default_day)) {

                    // clear the value of the parent element
                    $element.val('');

                    // the calendar will start with the first selectable year/month
                    selected_month = first_selectable_month;
                    selected_year = first_selectable_year;

                }

            // if a default value is not available, or value does not represent a valid date
            } else {

                // the calendar will start with the first selectable year/month
                selected_month = first_selectable_month;
                selected_year = first_selectable_year;

            }

            // generate the appropriate view
            manage_views();

            // if date picker is not always visible
            if (!plugin.settings.always_visible) {
                //新定位
                var jqobj=$element,
                    offset=jqobj.offset(),
                    client={},
                    popOffset={},
                    jqParent=datepicker.parent();
                //查找第一个非static定位父级
                while(jqParent.css('position')=='static'){
                    if(jqParent[0].tagName.toLowerCase()=='body')break;
                    jqParent=jqParent.parent();
                }
                jqParent.oft=jqParent.offset();
                //矫正弹出位置，防止出现在窗口之外
                offset.outHeight=jqobj.outerHeight();
                offset.outWidth=jqobj.outerWidth();
                client.height=document.documentElement.clientHeight;
                client.width=document.documentElement.clientWidth;
                popOffset.height=datepicker.outerHeight();
                popOffset.width=datepicker.outerWidth();
                popOffset.top=client.height-offset.top-offset.outHeight-plugin.settings.offset[1]>popOffset.height?
                    offset.top+offset.outHeight+plugin.settings.offset[1]:
                    offset.top-popOffset.height-plugin.settings.offset[1];
                popOffset.left=client.width-offset.left-plugin.settings.offset[0]>popOffset.width?
                    offset.left+plugin.settings.offset[0]:
                    offset.left-(popOffset.width-offset.outWidth)-plugin.settings.offset[0];
                datepicker.css({
                    top:Math.floor(popOffset.top-jqParent.oft.top),
                    left:Math.floor(popOffset.left-jqParent.oft.left)
                });
                /*var
                    // get the date picker width and height
                    datepicker_width = datepicker.outerWidth(),
                    datepicker_height = datepicker.outerHeight(),

                    // compute the date picker's default left and top
                    left = icon.offset().left + plugin.settings.offset[0],
                    top = icon.offset().top - datepicker_height + plugin.settings.offset[1],

                    // get browser window's width and height
                    window_width = $(window).width(),
                    window_height = $(window).height(),

                    // get browser window's horizontal and vertical scroll offsets
                    window_scroll_top = $(window).scrollTop(),
                    window_scroll_left = $(window).scrollLeft();

                // if date picker is outside the viewport, adjust its position so that it is visible
                if (left + datepicker_width > window_scroll_left + window_width) left = window_scroll_left + window_width - datepicker_width;
                if (left < window_scroll_left) left = window_scroll_left;
                if (top + datepicker_height > window_scroll_top + window_height) top = window_scroll_top + window_height - datepicker_height;
                if (top < window_scroll_top) top = window_scroll_top;

                // make the date picker visible
                datepicker.css({
                    'left':     left,
                    'top':      top
                });*/

                // fade-in the date picker
                // for Internet Explorer < 9 show the date picker instantly or fading alters the font's weight
                datepicker.fadeIn($.browser.msie && $.browser.version.match(/^[6-8]/) ? 0 : 150, 'linear');

                // show the iFrameShim in Internet Explorer 6
                iframeShim();

            // if date picker is always visible, show it
            } else datepicker.css('display', 'block');

        };

        /**
         *  Updates the configuration options given as argument
         *
         *  @param  object  values  An object containing any number of configuration options to be updated
         *
         *  @return void
         */
        plugin.update = function(values) {

            // if original direction not saved, save it now
            if (plugin.original_direction) plugin.original_direction = plugin.direction;

            // update configuration options
            plugin.settings = $.extend(plugin.settings, values);

            // re-initialize the object with the new options
            init(true);

        }

        /**
         *  Checks if a string represents a valid date according to the format defined by the "format" property.
         *
         *  @param  string  str_date    A string representing a date, formatted accordingly to the "format" property.
         *                              For example, if "format" is "Y-m-d" the string should look like "2011-06-01"
         *
         *  @return boolean             Returns TRUE if string represents a valid date according formatted according to
         *                              the "format" property or FALSE otherwise.
         *
         *  @access private
         */
        var check_date = function(str_date) {

            // treat argument as a string
            str_date += '';

            // if value is given
            if ($.trim(str_date) != '') {

                var

                    // prepare the format by removing white space from it
                    // and also escape characters that could have special meaning in a regular expression
                    format = escape_regexp(plugin.settings.format.replace(/\s/g, '')),

                    // allowed characters in date's format
                    format_chars = ['d','D','j','l','N','S','w','F','m','M','n','Y','y'],

                    // "matches" will contain the characters defining the date's format
                    matches = new Array,

                    // "regexp" will contain the regular expression built for each of the characters used in the date's format
                    regexp = new Array;

                // iterate through the allowed characters in date's format
                for (var i = 0; i < format_chars.length; i++)

                    // if character is found in the date's format
                    if ((position = format.indexOf(format_chars[i])) > -1)

                        // save it, alongside the character's position
                        matches.push({character: format_chars[i], position: position});

                // sort characters defining the date's format based on their position, ascending
                matches.sort(function(a, b){ return a.position - b.position });

                // iterate through the characters defining the date's format
                $.each(matches, function(index, match) {

                    // add to the array of regular expressions, based on the character
                    switch (match.character) {

                        case 'd': regexp.push('0[1-9]|[12][0-9]|3[01]'); break;
                        case 'D': regexp.push('[a-z]{3}'); break;
                        case 'j': regexp.push('[1-9]|[12][0-9]|3[01]'); break;
                        case 'l': regexp.push('[a-z]+'); break;
                        case 'N': regexp.push('[1-7]'); break;
                        case 'S': regexp.push('st|nd|rd|th'); break;
                        case 'w': regexp.push('[0-6]'); break;
                        case 'F': regexp.push('[a-z]+'); break;
                        case 'm': regexp.push('0[1-9]|1[012]+'); break;
                        case 'M': regexp.push('[a-z]{3}'); break;
                        case 'n': regexp.push('[1-9]|1[012]'); break;
                        case 'Y': regexp.push('[0-9]{4}'); break;
                        case 'y': regexp.push('[0-9]{2}'); break;

                    }

                });

                // if we have an array of regular expressions
                if (regexp.length) {

                    // we will replace characters in the date's format in reversed order
                    matches.reverse();

                    // iterate through the characters in date's format
                    $.each(matches, function(index, match) {

                        // replace each character with the appropriate regular expression
                        format = format.replace(match.character, '(' + regexp[regexp.length - index - 1] + ')');

                    });

                    // the final regular expression
                    regexp = new RegExp('^' + format + '$', 'ig');

                    // if regular expression was matched
                    if ((segments = regexp.exec(str_date.replace(/\s/g, '')))) {

                        // check if date is a valid date (i.e. there's no February 31)

                        var original_day,
                            original_month,
                            original_year,
                            english_days   = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
                            english_months = ['January','February','March','April','May','June','July','August','September','October','November','December'],
                            iterable,

                            // by default, we assume the date is valid
                            valid = true;

                        // reverse back the characters in the date's format
                        matches.reverse();

                        // iterate through the characters in the date's format
                        $.each(matches, function(index, match) {

                            // if the date is not valid, don't look further
                            if (!valid) return true;

                            // based on the character
                            switch (match.character) {

                                case 'm':
                                case 'n':

                                    // extract the month from the value entered by the user
                                    original_month = to_int(segments[index + 1]);

                                    break;

                                case 'd':
                                case 'j':

                                    // extract the day from the value entered by the user
                                    original_day = to_int(segments[index + 1]);

                                    break;

                                case 'D':
                                case 'l':
                                case 'F':
                                case 'M':

                                    // if day is given as day name, we'll check against the names in the used language
                                    if (match.character == 'D' || match.character == 'l') iterable = plugin.settings.days;

                                    // if month is given as month name, we'll check against the names in the used language
                                    else iterable = plugin.settings.months;

                                    // by default, we assume the day or month was not entered correctly
                                    valid = false;

                                    // iterate through the month/days in the used language
                                    $.each(iterable, function(key, value) {

                                        // if month/day was entered correctly, don't look further
                                        if (valid) return true;

                                        // if month/day was entered correctly
                                        if (segments[index + 1].toLowerCase() == value.substring(0, (match.character == 'D' || match.character == 'M' ? 3 : value.length)).toLowerCase()) {

                                            // extract the day/month from the value entered by the user
                                            switch (match.character) {

                                                case 'D': segments[index + 1] = english_days[key].substring(0, 3); break;
                                                case 'l': segments[index + 1] = english_days[key]; break;
                                                case 'F': segments[index + 1] = english_months[key]; original_month = key + 1; break;
                                                case 'M': segments[index + 1] = english_months[key].substring(0, 3); original_month = key + 1; break;

                                            }

                                            // day/month value is valid
                                            valid = true;

                                        }

                                    });

                                    break;

                                case 'Y':

                                    // extract the year from the value entered by the user
                                    original_year = to_int(segments[index + 1]);

                                    break;

                                case 'y':

                                    // extract the year from the value entered by the user
                                    original_year = '19' + to_int(segments[index + 1]);

                                    break;

                            }
                        });

                        // if everything is ok so far
                        if (valid) {

                            // generate a Date object using the values entered by the user
                            // (handle also the case when original_month and/or original_day are undefined - i.e date format is "Y-m" or "Y")
                            var date = new Date(original_year, (original_month || 1) - 1, original_day || 1);

                            // if, after that, the date is the same as the date entered by the user
                            if (date.getFullYear() == original_year && date.getDate() == (original_day || 1) && date.getMonth() == ((original_month || 1) - 1))

                                // return the date as JavaScript date object
                                return date;

                        }

                    }

                }

                // if script gets this far, return false as something must've went wrong
                return false;

            }

        }

        /**
         *  Prevents the possibility of selecting text on a given element. Used on the "previous" and "next" buttons
         *  where text might get accidentally selected when user quickly clicks on the buttons.
         *
         *  Code by http://chris-barr.com/index.php/entry/disable_text_selection_with_jquery/
         *
         *  @param  jQuery Element  el  A jQuery element on which to prevents text selection.
         *
         *  @return void
         *
         *  @access private
         */
        var disable_text_select = function(el) {

            // if browser is Firefox
			if ($.browser.mozilla) el.css('MozUserSelect', 'none');

            // if browser is Internet Explorer
            else if ($.browser.msie) el.bind('selectstart', function() { return false });

            // for the other browsers
			else el.mousedown(function() { return false });

        }

        /**
         *  Escapes special characters in a string, preparing it for use in a regular expression.
         *
         *  @param  string  str     The string in which special characters should be escaped.
         *
         *  @return string          Returns the string with escaped special characters.
         *
         *  @access private
         */
        var escape_regexp = function(str) {

            // return string with special characters escaped
            return str.replace(/([-.*+?^${}()|[\]\/\\])/g, '\\$1');

        }

        /**
         *  Formats a JavaScript date object to the format specified by the "format" property.
         *  Code taken from http://electricprism.com/aeron/calendar/
         *
         *  @param  date    date    A valid JavaScript date object
         *
         *  @return string          Returns a string containing the formatted date
         *
         *  @access private
         */
        var format = function(date) {

            var result = '',

                // extract parts of the date:
                // day number, 1 - 31
                j = date.getDate(),

                // day of the week, 0 - 6, Sunday - Saturday
                w = date.getDay(),

                // the name of the day of the week Sunday - Saturday
                l = plugin.settings.days[w],

                // the month number, 1 - 12
                n = date.getMonth() + 1,

                // the month name, January - December
                f = plugin.settings.months[n - 1],

                // the year (as a string)
                y = date.getFullYear() + '';

            // iterate through the characters in the format
            for (var i = 0; i < plugin.settings.format.length; i++) {

                // extract the current character
                var chr = plugin.settings.format.charAt(i);

                // see what character it is
                switch(chr) {

                    // year as two digits
                    case 'y': y = y.substr(2);

                    // year as four digits
                    case 'Y': result += y; break;

                    // month number, prefixed with 0
                    case 'm': n = str_pad(n, 2);

                    // month number, not prefixed with 0
                    case 'n': result += n; break;

                    // month name, three letters
                    case 'M': f = f.substr(0, 3);

                    // full month name
                    case 'F': result += f; break;

                    // day number, prefixed with 0
                    case 'd': j = str_pad(j, 2);

                    // day number not prefixed with 0
                    case 'j': result += j; break;

                    // day name, three letters
                    case 'D': l = l.substr(0, 3);

                    // full day name
                    case 'l': result += l; break;

                    // ISO-8601 numeric representation of the day of the week, 1 - 7
                    case 'N': w++;

                    // day of the week, 0 - 6
                    case 'w': result += w; break;

                    // English ordinal suffix for the day of the month, 2 characters
                    // (st, nd, rd or th (works well with j))
                    case 'S':

                        if (j % 10 == 1 && j != '11') result += 'st';

                        else if (j % 10 == 2 && j != '12') result += 'nd';

                        else if (j % 10 == 3 && j != '13') result += 'rd';

                        else result += 'th';

                        break;

                    // this is probably the separator
                    default: result += chr;

                }

            }

            // return formated date
            return result;

        }

        /**
         *  Generates the day picker view, and displays it
         *
         *  @return void
         *
         *  @access private
         */
        var generate_daypicker = function() {

            var

                // get the number of days in the selected month
                days_in_month = new Date(selected_year, selected_month + 1, 0).getDate(),

                // get the selected month's starting day (from 0 to 6)
                first_day = new Date(selected_year, selected_month, 1).getDay(),

                // how many days are there in the previous month
                days_in_previous_month = new Date(selected_year, selected_month, 0).getDate(),

                // how many days are there to be shown from the previous month
                days_from_previous_month = first_day - plugin.settings.first_day_of_week;

            // the final value of how many days are there to be shown from the previous month
            days_from_previous_month = days_from_previous_month < 0 ? 7 + days_from_previous_month : days_from_previous_month;

            // manage header caption and enable/disable navigation buttons if necessary
            manage_header(plugin.settings.months[selected_month] + ', ' + selected_year);

            // start generating the HTML
            var html = '<tr>';

            // if a column featuring the number of the week is to be shown
            if (plugin.settings.show_week_number)

                // column title
                html += '<th>' + plugin.settings.show_week_number + '</th>';

            // name of week days
            // show only the first two letters
            // and also, take in account the value of the "first_day_of_week" property
            for (var i = 0; i < 7; i++)

                html += '<th>' + plugin.settings.days[(plugin.settings.first_day_of_week + i) % 7].substr(0, 2) + '</th>';

            html += '</tr><tr>';

            // the calendar shows a total of 42 days
            for (var i = 0; i < 42; i++) {

                // seven days per row
                if (i > 0 && i % 7 == 0) html += '</tr><tr>';

                // if week number is to be shown
                if (i % 7 == 0 && plugin.settings.show_week_number) {

                    // get the ISO 8601 week number
                    // code taken from http://www.epoch-calendar.com/support/getting_iso_week.html

                    var

                        // current normalized date
                        current_date = new Date(selected_year, selected_month, (i - days_from_previous_month + 1)),

                        // create a new date object representing january 1st of the currently selected year
                        year_start_date = new Date(selected_year, 0, 1),

                        // the day of week day the year begins with (0 to 6)
                        // (taking locale into account)
                        start_weekday = year_start_date.getDay() - plugin.settings.first_day_of_week,

                        // the number of the current day
                        current_day_number = Math.floor(
                            (
                                current_date.getTime() - year_start_date.getTime() -
                                (current_date.getTimezoneOffset() - year_start_date.getTimezoneOffset()) * 60000
                            ) / 86400000
                        ) + 1,

                        // this will be the current week number
                        week_number;

                    // normalize starting day of the year in case it is < 0
                    start_weekday = (start_weekday >= 0 ? start_weekday : start_weekday + 7);

                    //if the year starts before the middle of a week
                    if (start_weekday < 4) {

                        // get the week's number
                        week_number = Math.floor((current_day_number + start_weekday - 1) / 7) + 1;

                        // if week is > 52 then we have to figure out if it is the 53rd week of the current year
                        // or the 1st week of the next year
                        if (week_number + 1 > 52) {

                            var

                                // create a date object represnting january 1st of the next year
                                tmp_year = new Date(current_date.getFullYear() + 1, 0, 1),

                                // the day of week day the year begins with (0 to 6)
                                // (taking locale into account)
                                tmp_day = nYear.getDay() - plugin.settings.first_day_of_week;

                            // normalize starting day of the year in case it is < 0
                            tmp_day = (tmp_day >= 0 ? tmp_day : tmp_day + 7);

                            // if the next year starts before the middle of the week,
                            // the week number represents the 1st week of that year
                            week_number = (tmp_day < 4 ? 1 : 53);

                        }

                    // otherwise, this is the week's number
                    } else week_number = Math.floor((current_day_number + start_weekday - 1) / 7)

                    // add week number
                    html += '<td class="dp_week_number">' + week_number + '</td>';

                }

                // the number of the day in month
                var day = (i - days_from_previous_month + 1);

                // if this is a day from the previous month
                if (i < days_from_previous_month)

                    html += '<td class="dp_not_in_month">' + (days_in_previous_month - days_from_previous_month + i + 1) + '</td>';

                // if this is a day from the next month
                else if (day > days_in_month)

                    html += '<td class="dp_not_in_month">' + (day - days_in_month) + '</td>';

                // if this is a day from the current month
                else {

                    var

                        // get the week day (0 to 6, Sunday to Saturday)
                        weekday = (plugin.settings.first_day_of_week + i) % 7,

                        class_name = '';

                    // if date needs to be disabled
                    if (is_disabled(selected_year, selected_month, day)) {

                        // if day is in weekend
                        if ($.inArray(weekday, plugin.settings.weekend_days) > -1) class_name = 'dp_weekend_disabled';

                        // if work day
                        else class_name += ' dp_disabled';

                        // highlight the current system date
                        if (selected_month == current_system_month && selected_year == current_system_year && current_system_day == day) class_name += ' dp_disabled_current';

                    // if there are no restrictions
                    } else {

                        // if day is in weekend
                        if ($.inArray(weekday, plugin.settings.weekend_days) > -1) class_name = 'dp_weekend';

                        // highlight the currently selected date
                        if (selected_month == default_month && selected_year == default_year && default_day == day) class_name += ' dp_selected';

                        // highlight the current system date
                        if (selected_month == current_system_month && selected_year == current_system_year && current_system_day == day) class_name += ' dp_current';

                    }

                    // print the day of the month
                    html += '<td' + (class_name != '' ? ' class="' + $.trim(class_name) + '"' : '') + '>' + str_pad(day, 2) + '</td>';

                }

            }

            // wrap up generating the day picker
            html += '</tr>';

            // inject the day picker into the DOM
            daypicker.html($(html));

            // if date picker is always visible
            if (plugin.settings.always_visible)

                // cache all the cells
                // (we need them so that we can easily remove the "dp_selected" class from all of them when user selects a date)
                daypicker_cells = $('td:not(.dp_disabled, .dp_weekend_disabled, .dp_not_in_month, .dp_blocked, .dp_week_number)', daypicker);

            // make the day picker visible
            daypicker.css('display', '');

        }

        /**
         *  Generates the month picker view, and displays it
         *
         *  @return void
         *
         *  @access private
         */
        var generate_monthpicker = function() {

            // manage header caption and enable/disable navigation buttons if necessary
            manage_header(selected_year);

            // start generating the HTML
            var html = '<tr>';

            // iterate through all the months
            for (var i = 0; i < 12; i++) {

                // three month per row
                if (i > 0 && i % 3 == 0) html += '</tr><tr>';

                var class_name = 'dp_month_' + i;

                // if month needs to be disabled
                if (is_disabled(selected_year, i)) class_name += ' dp_disabled';

                // else, if a date is already selected and this is that particular month, highlight it
                else if (default_month !== false && default_month == i) class_name += ' dp_selected';

                // else, if this the current system month, highlight it
                else if (current_system_month == i && current_system_year == selected_year) class_name += ' dp_current';

                // first three letters of the month's name
                html += '<td class="' + $.trim(class_name) + '">' + plugin.settings.months[i].substr(0, 3) + '</td>';

            }

            // wrap up
            html += '</tr>';

            // inject into the DOM
            monthpicker.html($(html));

            // if date picker is always visible
            if (plugin.settings.always_visible)

                // cache all the cells
                // (we need them so that we can easily remove the "dp_selected" class from all of them when user selects a month)
                monthpicker_cells = $('td:not(.dp_disabled)', monthpicker);

            // make the month picker visible
            monthpicker.css('display', '');

        }

        /**
         *  Generates the year picker view, and displays it
         *
         *  @return void
         *
         *  @access private
         */
        var generate_yearpicker = function() {

            // manage header caption and enable/disable navigation buttons if necessary
            manage_header(selected_year - 7 + ' - ' + (selected_year + 4));

            // start generating the HTML
            var html = '<tr>';

            // we're showing 9 years at a time, current year in the middle
            for (var i = 0; i < 12; i++) {

                // three years per row
                if (i > 0 && i % 3 == 0) html += '</tr><tr>';

                var class_name = '';

                // if year needs to be disabled
                if (is_disabled(selected_year - 7 + i)) class_name += ' dp_disabled';

                // else, if a date is already selected and this is that particular year, highlight it
                else if (default_year && default_year == selected_year - 7 + i) class_name += ' dp_selected'

                // else, if this is the current system year, highlight it
                else if (current_system_year == (selected_year - 7 + i)) class_name += ' dp_current';

                // first three letters of the month's name
                html += '<td' + ($.trim(class_name) != '' ? ' class="' + $.trim(class_name) + '"' : '') + '>' + (selected_year - 7 + i) + '</td>';

            }

            // wrap up
            html += '</tr>';

            // inject into the DOM
            yearpicker.html($(html));

            // if date picker is always visible
            if (plugin.settings.always_visible)

                // cache all the cells
                // (we need them so that we can easily remove the "dp_selected" class from all of them when user selects a year)
                yearpicker_cells = $('td:not(.dp_disabled)', yearpicker);

            // make the year picker visible
            yearpicker.css('display', '');

        }

        /**
         *  Generates an iFrame shim in Internet Explorer 6 so that the date picker appears above select boxes.
         *
         *  @return void
         *
         *  @access private
         */
        var iframeShim = function(action) {

            // this is necessary only if browser is Internet Explorer 6
    		if ($.browser.msie && $.browser.version.match(/^6/)) {

                // if the iFrame was not yet created
                // "undefined" evaluates as FALSE
                if (!shim) {

                    // the iFrame has to have the element's zIndex minus 1
                    var zIndex = to_int(datepicker.css('zIndex')) - 1;

                    // create the iFrame
                    shim = jQuery('<iframe>', {
                        'src':                  'javascript:document.write("")',
                        'scrolling':            'no',
                        'frameborder':          0,
                        'allowtransparency':    'true',
                        css: {
                            'zIndex':       zIndex,
                            'position':     'absolute',
                            'top':          -1000,
                            'left':         -1000,
                            'width':        datepicker.outerWidth(),
                            'height':       datepicker.outerHeight(),
                            'filter':       'progid:DXImageTransform.Microsoft.Alpha(opacity=0)',
                            'display':      'none'
                        }
                    });

                    // inject iFrame into DOM
                    $('body').append(shim);

                }

                // what do we need to do
                switch (action) {

                    // hide the iFrame?
                    case 'hide':

                        // set the iFrame's display property to "none"
                        shim.css('display', 'none');

                        break;

                    // show the iFrame?
                    default:

                        // get date picker top and left position
                        var offset = datepicker.offset();
						console.log(offset.top);

                        // position the iFrame shim right underneath the date picker
                        // and set its display to "block"
                        shim.css({
                            'top':      offset.top,
                            'left':     offset.left,
                            'display':  'block'
                        });

                }

            }

        };

        /**
         *  Checks if, according to the restrictions of the calendar and/or the values defined by the "disabled_dates"
         *  property, a day, a month or a year needs to be disabled.
         *
         *  @param  integer     year    The year to check
         *  @param  integer     month   The month to check
         *  @param  integer     day     The day to check
         *
         *  @return boolean         Returns TRUE if the given value is not disabled or FALSE otherwise
         *
         *  @access private
         */
        var is_disabled = function(year, month, day) {

            // if calendar has direction restrictions
            if (!(!$.isArray(plugin.settings.direction) && to_int(plugin.settings.direction) === 0)) {

                var
                    // normalize and merge arguments then transform the result to an integer
                    now = to_int(str_concat(year, (typeof month != 'undefined' ? str_pad(month, 2) : ''), (typeof day != 'undefined' ? str_pad(day, 2) : ''))),

                    // get the length of the argument
                    len = (now + '').length;

                // if we're checking days
                if (len == 8 && (

                    // day is before the first selectable date
                    (typeof start_date != 'undefined' && now < to_int(str_concat(first_selectable_year, str_pad(first_selectable_month, 2), str_pad(first_selectable_day, 2)))) ||

                    // or day is after the last selectable date
                    (typeof end_date != 'undefined' && now > to_int(str_concat(last_selectable_year, str_pad(last_selectable_month, 2), str_pad(last_selectable_day, 2))))

                // day needs to be disabled
                )) return true;

                // if we're checking months
                else if (len == 6 && (

                    // month is before the first selectable month
                    (typeof start_date != 'undefined' && now < to_int(str_concat(first_selectable_year, str_pad(first_selectable_month, 2)))) ||

                    // or day is after the last selectable date
                    (typeof end_date != 'undefined' && now > to_int(str_concat(last_selectable_year, str_pad(last_selectable_month, 2))))

                // month needs to be disabled
                )) return true;

                // if we're checking years
                else if (len == 4 && (

                    // year is before the first selectable year
                    (typeof start_date != 'undefined' && now < first_selectable_year) ||

                    // or day is after the last selectable date
                    (typeof end_date != 'undefined'  && now > last_selectable_year)

                // year needs to be disabled
                )) return true;

            }

            // if there are rules for disabling dates
            if (disabled_dates) {

                // if month is given as argument, increment it (as JavaScript uses 0 for January, 1 for February...)
                if (typeof month != 'undefined') month = month + 1

                // by default, we assume the day/month/year is not to be disabled
                var disabled = false;

                // iterate through the rules for disabling dates
                $.each(disabled_dates, function() {

                    // if the date is to be disabled, don't look any further
                    if (disabled) return;

                    var rule = this;

                    // if the rules apply for the current year
                    if ($.inArray(year, rule[2]) > -1 || $.inArray('*', rule[2]) > -1)

                        // if the rules apply for the current month
                        if ((typeof month != 'undefined' && $.inArray(month, rule[1]) > -1) || $.inArray('*', rule[1]) > -1)

                            // if the rules apply for the current day
                            if ((typeof day != 'undefined' && $.inArray(day, rule[0]) > -1) || $.inArray('*', rule[0]) > -1) {

                                // if day is to be disabled whatever the day
                                // don't look any further
                                if (rule[3] == '*') return (disabled = true);

                                // get the weekday
                                var weekday = new Date(year, month - 1, day).getDay();

                                // if weekday is to be disabled
                                // don't look any further
                                if ($.inArray(weekday, rule[3]) > -1) return (disabled = true);

                            }

                });

                // if the day/month/year needs to be disabled
                if (disabled) return true;

            }

            // if script gets this far it means that the day/month/year doesn't need to be disabled
            return false;

        }

        /**
         *  Checks whether a value is an integer number.
         *
         *  @param  mixed   value   Value to check
         *
         *  @return                 Returns TRUE if the value represents an integer number, or FALSE otherwise
         *
         *  @access private
         */
        var is_integer = function(value) {

            // return TRUE if value represents an integer number, or FALSE otherwise
            return (value + '').match(/^\-?[0-9]+$/) ? true : false;

        }

        /**
         *  Sets the caption in the header of the date picker and enables or disables navigation buttons when necessary.
         *
         *  @param  string  caption     String that needs to be displayed in the header
         *
         *  @return void
         *
         *  @access private
         */
        var manage_header = function(caption) {

            // update the caption in the header
            $('.dp_caption', header).html(caption);

            // if calendar has direction restrictions
            if (!(!$.isArray(plugin.settings.direction) && to_int(plugin.settings.direction) === 0)) {

                // get the current year and month
                var year = selected_year,
                    month = selected_month,
                    next, previous;

                // if current view is showing days
                if (view == 'days') {

                    // clicking on "previous" should take us to the previous month
                    // (will check later if that particular month is available)
                    previous = (month - 1 < 0 ? str_concat(year - 1, '11') : str_concat(year, str_pad(month - 1, 2)));

                    // clicking on "next" should take us to the next month
                    // (will check later if that particular month is available)
                    next = (month + 1 > 11 ? str_concat(year + 1, '00') : str_concat(year, str_pad(month + 1, 2)));

                // if current view is showing months
                } else if (view == 'months') {

                    // clicking on "previous" should take us to the previous year
                    // (will check later if that particular year is available)
                    previous = year - 1;

                    // clicking on "next" should take us to the next year
                    // (will check later if that particular year is available)
                    next = year + 1;

                // if current view is showing years
                } else if (view == 'years') {

                    // clicking on "previous" should show a list with some previous years
                    // (will check later if that particular list of years contains selectable years)
                    previous = year - 7;

                    // clicking on "next" should show a list with some following years
                    // (will check later if that particular list of years contains selectable years)
                    next = year + 7;

                }

                // if the previous month/year is not selectable or, in case of years, if the list doesn't contain selectable years
                if (is_disabled(previous)) {

                    // disable the "previous" button
                    $('.dp_previous', header).addClass('dp_blocked');
                    $('.dp_previous', header).removeClass('dp_hover');

                // otherwise enable the "previous" button
                } else $('.dp_previous', header).removeClass('dp_blocked');

                // if the next month/year is not selectable or, in case of years, if the list doesn't contain selectable years
                if (is_disabled(next)) {

                    // disable the "next" button
                    $('.dp_next', header).addClass('dp_blocked');
                    $('.dp_next', header).removeClass('dp_hover');

                // otherwise enable the "next" button
                } else $('.dp_next', header).removeClass('dp_blocked');

            }

        };

        /**
         *  Shows the appropriate view (days, months or years) according to the current value of the "view" property.
         *
         *  @return void
         *
         *  @access private
         */
		var manage_views = function() {

            // if the day picker was not yet generated
            if (daypicker.text() == '' || view == 'days') {

                // if the day picker was not yet generated
                if (daypicker.text() == '') {

                    // if date picker is not always visible
                    if (!plugin.settings.always_visible)

                        // temporarily set the date picker's left outside of view
                        // so that we can later grab its width and height
                        datepicker.css('left', -1000);

                    // temporarily make the date picker visible
                    // so that we can later grab its width and height
                    datepicker.css({
                        'display':  'block'
                    });

    				// generate the day picker
    				generate_daypicker();

                    // get the day picker's width and height
                    var width = daypicker.outerWidth(),
                        height = daypicker.outerHeight();

                    // adjust the size of the header
                    header.css('width', width);

                    // make the month picker have the same size as the day picker
                    monthpicker.css({
                        'width':    width,
                        'height':   height
                    });

                    // make the year picker have the same size as the day picker
                    yearpicker.css({
                        'width':    width,
                        'height':   height
                    });

                    // adjust the size of the footer
                    footer.css('width', width);

                    // hide the date picker again
                    datepicker.css({
                        'display':  'none'
                    });

                // if the day picker was previously generated at least once
				// generate the day picker
                } else generate_daypicker();

                // hide the year and the month pickers
                monthpicker.css('display', 'none');
                yearpicker.css('display', 'none');

            // if the view is "months"
            } else if (view == 'months') {

                // generate the month picker
                generate_monthpicker();

                // hide the day and the year pickers
                daypicker.css('display', 'none');
                yearpicker.css('display', 'none');

            // if the view is "years"
            } else if (view == 'years') {

                // generate the year picker
                generate_yearpicker();

                // hide the day and the month pickers
                daypicker.css('display', 'none');
                monthpicker.css('display', 'none');

            }

            // if the button for clearing a previously selected date needs to be visible all the time,
            // or the date picker is always visible - case in which the "clear" button is always visible -
            // or there is content in the element the date picker is attached to
            // and the footer is not visible
            if ((plugin.settings.always_show_clear || plugin.settings.always_visible || $element.val() != '') && footer.css('display') != 'block')

                // show the footer
                footer.css('display', '');

            // hide the footer otherwise
            else footer.css('display', 'none');

		}

        /**
         *  Puts the specified date in the element the plugin is attached to, and hides the date picker.
         *
         *  @param  integer     year    The year
         *
         *  @param  integer     month   The month
         *
         *  @param  integer     day     The day
         *
         *  @param  string      view    The view from where the method was called
         *
         *  @param  object      cell    The element that was clicked
         *
         *  @return void
         *
         *  @access private
         */
        var select_date = function(year, month, day, view, cell) {

            var

                // construct a new date object from the arguments
                default_date = new Date(year, month, day),

                // pointer to the cells in the current view
                view_cells = (view == 'days' ? daypicker_cells : (view == 'months' ? monthpicker_cells : yearpicker_cells)),

                // the selected date, formatted correctly
                selected_value = format(default_date);

            // set the currently selected and formated date as the value of the element the plugin is attached to
            $element.val(selected_value);

            // if date picker is always visible
            if (plugin.settings.always_visible) {

                // extract the date parts and re-assign values to these variables
                // so that everything will be correctly highlighted
                default_month = default_date.getMonth();
                selected_month = default_date.getMonth();
                default_year = default_date.getFullYear();
                selected_year = default_date.getFullYear();
                default_day = default_date.getDate();

                // remove the "selected" class from all cells in the current view
                view_cells.removeClass('dp_selected');

                // add the "selected" class to the currently selected cell
                cell.addClass('dp_selected');

            }

            // hide the date picker
            plugin.hide();

            // updates value for the date picker whose starting date depends on the selected date (if any)
            update_dependent(default_date);

            // if a callback function exists for when selecting a date
            if (plugin.settings.onSelect && typeof plugin.settings.onSelect == 'function')

                // execute the callback function
                plugin.settings.onSelect(selected_value, year + '-' + str_pad(month + 1, 2) + '-' + str_pad(day, 2), new Date(year, month, day));

        }

        /**
         *  Concatenates any number of arguments and returns them as string.
         *
         *  @return string  Returns the concatenated values.
         *
         *  @access private
         */
        var str_concat = function() {

            var str = '';

            // concatenate as string
            for (var i = 0; i < arguments.length; i++) str += (arguments[i] + '');

            // return the concatenated values
            return str;

        }

        /**
         *  Left-pad a string to a certain length with zeroes.
         *
         *  @param  string  str     The string to be padded.
         *
         *  @param  integer len     The length to which the string must be padded
         *
         *  @return string          Returns the string left-padded with leading zeroes
         *
         *  @access private
         */
        var str_pad = function(str, len) {

            // make sure argument is a string
            str += '';

            // pad with leading zeroes until we get to the desired length
            while (str.length < len) str = '0' + str;

            // return padded string
            return str;

        }

        /**
         *  Returns the integer representation of a string
         *
         *  @return int     Returns the integer representation of the string given as argument
         *
         *  @access private
         */
        var to_int = function(str) {

            // return the integer representation of the string given as argument
            return parseInt(str , 10);

        }

        /**
         *  Updates the paired date picker (whose starting date depends on the value of the current date picker)
         *
         *  @param  date    date    A JavaScript date object representing the currently selected date
         *
         *  @return void
         *
         *  @access private
         */
        var update_dependent = function(date) {

            // if the pair element exists
            if (plugin.settings.pair) {

                // chances are that at the beginning the pair element doesn't have the Zebra_DatePicker attached to it yet
                // (as the "start" element is usually created before the "end" element)
                // so we'll have to rely on "data" to send the starting date to the pair element

                // therefore, if Zebra_DatePicker is not yet attached
                if (!(plugin.settings.pair.data && plugin.settings.pair.data('Zebra_DatePicker')))

                    // set the starting date like this
                    plugin.settings.pair.data('zdp_reference_date', date);

                // if Zebra_DatePicker is attached to the pair element
                else {

                    // reference the date picker object attached to the other element
                    var dp = plugin.settings.pair.data('Zebra_DatePicker');

                    // update the other date picker's starting date
                    // the value depends on the original value of the "direction" attribute
                    dp.update({
                        'reference_date': date
                    });

                    // if the other date picker is always visible, update the visuals now
                    if (dp.settings.always_visible) dp.show()

                }

            }

        }

        /**
         *  Function to be called when the "onKeyUp" event occurs
         *
         *  Why as a separate function and not inline when binding the event? Because only this way we can "unbind" it
         *  if the date picker is destroyed
         *
         *  @return boolean     Returns TRUE
         *
         *  @access private
         */
        plugin._keyup = function(e) {

            // if the date picker is visible
            // and the pressed key is ESC
            // hide the date picker
            if (datepicker.css('display') == 'block' || e.which == 27) plugin.hide();

            return true;

        };

        /**
         *  Function to be called when the "onMouseDown" event occurs
         *
         *  Why as a separate function and not inline when binding the event? Because only this way we can "unbind" it
         *  if the date picker is destroyed
         *
         *  @return boolean     Returns TRUE
         *
         *  @access private
         */
        plugin._mousedown = function(e) {

            // if the date picker is visible
            if (datepicker.css('display') == 'block') {

                // if we clicked the date picker's icon, let the onClick event of the icon to handle the event
                // (we want it to toggle the date picker)
                if ($(e.target).get(0) === icon.get(0)) return true;

                // if what's clicked is not inside the date picker
                // hide the date picker
                if ($(e.target).parents().filter('.Zebra_DatePicker').length == 0) plugin.hide();

            }

            return true;

        };

        // initialize the plugin
        init();

    };

    $.fn.Zebra_DatePicker = function(options) {

        return this.each(function() {

            // if element has a date picker already attached
            if (undefined != $(this).data('Zebra_DatePicker')) {

                // get reference to the previously attached date picker
                var plugin = $(this).data('Zebra_DatePicker');

                // remove the attached icon and calendar
                plugin.icon.remove();
                plugin.datepicker.remove();

                // remove associated event handlers from the document
                $(document).unbind('keyup.zebra_datepicker', plugin._keyup);
                $(document).unbind('mousedown.zebra_datepicker', plugin._mousedown);

            }
            if(options=='destroy')return;
            // create a new instance of the plugin
            var plugin = new $.Zebra_DatePicker(this, options);

            // save a reference to the newly created object
            $(this).data('Zebra_DatePicker', plugin);

        });

    }

})(jQuery);
/**
 * This jQuery plugin displays pagination links inside the selected elements.
 *
 * @author Gabriel Birke (birke *at* d-scribe *dot* de)
 * @version 1.2
 * @param {int} maxentries Number of entries to paginate
 * @param {Object} opts Several options (see README for documentation)
 * @return {Object} jQuery Object
 */
jQuery.fn.pagination = function(maxentries, opts){
	opts = jQuery.extend({
		items_per_page:10,
		num_display_entries:10,
		current_page:0,
		num_edge_entries:1,
		link_to:"#",
		prev_text:"Prev",
		next_text:"Next",
		ellipse_text:"...",
		prev_show_always:true,
		next_show_always:true,
		callback:function(){return false;}
	},opts||{});
	
	return this.each(function() {
		/**
		 * Calculate the maximum number of pages
		 */
		function numPages() {
			return Math.ceil(maxentries/opts.items_per_page);
		}
		
		/**
		 * Calculate start and end point of pagination links depending on 
		 * current_page and num_display_entries.
		 * @return {Array}
		 */
		function getInterval()  {
			var ne_half = Math.ceil(opts.num_display_entries/2);
			var np = numPages();
			var upper_limit = np-opts.num_display_entries;
			var start = current_page>ne_half?Math.max(Math.min(current_page-ne_half, upper_limit), 0):0;
			var end = current_page>ne_half?Math.min(current_page+ne_half, np):Math.min(opts.num_display_entries, np);
			return [start,end];
		}
		
		/**
		 * This is the event handling function for the pagination links. 
		 * @param {int} page_id The new page number
		 */
		function pageSelected(page_id, evt){
			current_page = page_id;
			drawLinks();
			var continuePropagation = opts.callback(page_id, panel);
			if (!continuePropagation) {
				if (evt.stopPropagation) {
					evt.stopPropagation();
				}
				else {
					evt.cancelBubble = true;
				}
			}
			return continuePropagation;
		}
		
		/**
		 * This function inserts the pagination links into the container element
		 */
		function drawLinks() {
			panel.empty();
			var np = numPages();
            if(np>1){
                var interval = getInterval();
                // This helper function returns a handler function that calls pageSelected with the right page_id
                var getClickHandler = function(page_id) {
                    return function(evt){ return pageSelected(page_id,evt); }
                };
                // Helper function for generating a single link (or a span tag if it's the current page)
                var appendItem = function(page_id, appendopts){
                    page_id = page_id<0?0:(page_id<np?page_id:np-1); // Normalize page id to sane value
                    appendopts = jQuery.extend({text:page_id+1, classes:""}, appendopts||{});
                    if(page_id == current_page){
                        var lnk = jQuery("<span class='current'>"+(appendopts.text)+"</span>");
                    }
                    else
                    {
                        var lnk = jQuery("<a>"+(appendopts.text)+"</a>")
                            .bind("click", getClickHandler(page_id));

                        if(opts.link_to!=""){
                            lnk =lnk.attr('href', opts.link_to.replace(/__id__/,page_id));
                        }

                    }
                    if(appendopts.classes){lnk.addClass(appendopts.classes);}
                    panel.append(lnk);
                };
                // Generate "Previous"-Link
                if(opts.prev_text && (current_page > 0 || opts.prev_show_always)){
                    appendItem(current_page-1,{text:opts.prev_text, classes:"prev"});
                }
                // Generate starting points
                if (interval[0] > 0 && opts.num_edge_entries > 0)
                {
                    var end = Math.min(opts.num_edge_entries, interval[0]);
                    for(var i=0; i<end; i++) {
                        appendItem(i);
                    }
                    if(opts.num_edge_entries < interval[0] && opts.ellipse_text)
                    {
                        jQuery("<span>"+opts.ellipse_text+"</span>").appendTo(panel);
                    }
                }
                // Generate interval links
                for(var i=interval[0]; i<interval[1]; i++) {
                    appendItem(i);
                }
                // Generate ending points
                if (interval[1] < np && opts.num_edge_entries > 0)
                {
                    if(np-opts.num_edge_entries > interval[1]&& opts.ellipse_text)
                    {
                        jQuery("<span>"+opts.ellipse_text+"</span>").appendTo(panel);
                    }
                    var begin = Math.max(np-opts.num_edge_entries, interval[1]);
                    for(var i=begin; i<np; i++) {
                        appendItem(i);
                    }

                }
                // Generate "Next"-Link
                if(opts.next_text && (current_page < np-1 || opts.next_show_always)){
                    appendItem(current_page+1,{text:opts.next_text, classes:"next"});
                }
            }
		}
		
		// Extract current_page from options
		var current_page = opts.current_page;
		// Create a sane value for maxentries and items_per_page
		maxentries = (!maxentries || maxentries < 0)?1:maxentries;
		opts.items_per_page = (!opts.items_per_page || opts.items_per_page < 0)?1:opts.items_per_page;
		// Store DOM element for easy access from all inner functions
		var panel = jQuery(this);
		// Attach control functions to the DOM element 
		this.selectPage = function(page_id){ pageSelected(page_id);}
		this.prevPage = function(){ 
			if (current_page > 0) {
				pageSelected(current_page - 1);
				return true;
			}
			else {
				return false;
			}
		};
		this.nextPage = function(){ 
			if(current_page < numPages()-1) {
				pageSelected(current_page+1);
				return true;
			}
			else {
				return false;
			}
		};
		// When all initialisation is done, draw the links
		drawLinks();
        // call callback function
//        opts.callback(current_page, this);
	});
};



/**
 * @license 
 * jQuery Tools @VERSION Overlay - Overlay base. Extend it.
 * 
 * NO COPYRIGHTS OR LICENSES. DO WHAT YOU LIKE.
 * 
 * http://flowplayer.org/tools/overlay/
 *
 * Since: March 2008
 * Date: @DATE 
 */
(function ($) {

    // static constructs
    $.tools = $.tools || { version: '@VERSION' };

    $.tools.overlay = {

        addEffect: function (name, loadFn, closeFn) {
            effects[name] = [loadFn, closeFn];
        },

        conf: {
            close: null,
            closeOnClick: true,
            closeOnEsc: true,
            closeSpeed: 'fast',
            effect: 'default',

            // since 1.2. fixed positioning not supported by IE6
            fixed: !$.browser.msie || $.browser.version > 6,

            left: 'center',
            load: false, // 1.2
            mask: null,
            oneInstance: true,
            speed: 'fast',
            target: null, // target element to be overlayed. by default taken from [rel]
            top: '10%'
        }
    };


    var instances = [], effects = {};

    // the default effect. nice and easy!
    $.tools.overlay.addEffect('default',

    /* 
    onLoad/onClose functions must be called otherwise none of the 
    user supplied callback methods won't be called
    */
		function (pos, onLoad) {
		    var conf = this.getConf(),
				 w = $(window);

		    if (!conf.fixed) {
		        pos.top += w.scrollTop();
		        pos.left += w.scrollLeft();
		    }
		    pos.position = conf.fixed ? 'fixed' : 'absolute';
		    this.getOverlay().css(pos).fadeIn(conf.speed, onLoad);

		}, function (onClose) {
		    this.getOverlay().fadeOut(this.getConf().closeSpeed, onClose);
		}
	);


    function Overlay(trigger, conf) {
        // private variables
        var self = this,
			 fire = trigger.add(self),
			 w = $(window),
			 closers,
			 overlay,
			 opened,
			 maskConf = $.tools.expose && (conf.mask || conf.expose),
			 uid = Math.random().toString().slice(10);
        // mask configuration
        if (maskConf) {
            if (typeof maskConf == 'string') { maskConf = { color: maskConf }; }
            maskConf.closeOnClick = maskConf.closeOnEsc = false;
        }

        // get overlay and trigger
        var jq = conf.target || trigger.attr("rel");
        overlay = jq ? $(jq) : null || trigger;

        // overlay not found. cannot continue
        if (!overlay.length) { throw "Could not find Overlay: " + jq; }

        // trigger's click event
        if (trigger && trigger.index(overlay) == -1) {
            trigger.click(function (e) {
                self.load(e);
                return e.preventDefault();
            });
        }

        // API methods  
        $.extend(self, {

            load: function (e) {

                // can be opened only once
                if (self.isOpened()) { return self; }

                // find the effect
                var eff = effects[conf.effect];
                if (!eff) { throw "Overlay: cannot find effect : \"" + conf.effect + "\""; }

                // close other instances?
                if (conf.oneInstance) {
                    $.each(instances, function () {                 
                        this.close(e);
                    });
                }

                // onBeforeLoad
                e = e || $.Event();
                e.type = "onBeforeLoad";
                fire.trigger(e);
                if (e.isDefaultPrevented()) { return self; }

                // opened
                opened = true;

                // possible mask effect
                if (maskConf) { $(overlay).expose(maskConf); }

                // position & dimensions 
                var top = conf.top,
					 left = conf.left,
					 oWidth = overlay.outerWidth({ margin: true }),
					 oHeight = overlay.outerHeight({ margin: true });

                if (typeof top == 'string') {
                    top = top == 'center' ? Math.max((w.height() - oHeight) / 2, 0) :
						parseInt(top, 10) / 100 * w.height();
                }

                if (left == 'center') { left = Math.max((w.width() - oWidth) / 2, 0); }


                // load effect  		 		
                eff[0].call(self, { top: top, left: left }, function () {
                    if (opened) {
                        e.type = "onLoad";
                        fire.trigger(e);
                    }
                });

                // mask.click closes overlay
                if (maskConf && conf.closeOnClick) {
                    $.mask.getMask().one("click", self.close);
                }


                //解决点击扣费弹出框取消按钮，会关闭相册弹出层的问题
                // when window is clicked outside overlay, we close
//                if (conf.closeOnClick) {
//                    $(document).on("click." + uid, function (e) {
//                        if (!$(e.target).closest(overlay).length) {                            
//                            self.close(e);
//                        }
//                    });
//                }

                // keyboard::escape
                if (conf.closeOnEsc) {
                    // one callback is enough if multiple instances are loaded simultaneously
                    $(document).on("keydown." + uid, function (e) {
                        if (e.keyCode == 27) {
                            self.close(e);
                        }
                    });
                }


                return self;
            },

            close: function (e) {                                     
                if (!self.isOpened()) { return self; }

                e = e || $.Event();
                e.type = "onBeforeClose";
                fire.trigger(e);
                if (e.isDefaultPrevented()) { return; }

                opened = false;
                
                // close effect
                effects[conf.effect][1].call(self, function () {
                    e.type = "onClose";
                    fire.trigger(e);
                });
                
                // unbind the keyboard / clicking actions
                $(document).off("click." + uid + " keydown." + uid);
                 
                if (maskConf) {
                    $.mask.close();
                }

                return self;
            },

            getOverlay: function () {
                return overlay;
            },

            getTrigger: function () {
                return trigger;
            },

            getClosers: function () {
                return closers;
            },

            isOpened: function () {
                return opened;
            },

            // manipulate start, finish and speeds
            getConf: function () {
                return conf;
            }

        });

        // callbacks	
        $.each("onBeforeLoad,onStart,onLoad,onBeforeClose,onClose".split(","), function (i, name) {

            // configuration
            if ($.isFunction(conf[name])) {
                $(self).on(name, conf[name]);
            }

            // API
            self[name] = function (fn) {
                if (fn) { $(self).on(name, fn); }
                return self;
            };
        });

        // close button
        closers = overlay.find(conf.close || ".close");

        if (!closers.length && !conf.close) {
            closers = $('<a class="close"></a>');
            overlay.prepend(closers);
        }

        closers.click(function (e) {            
            self.close(e);
        });

        // autoload
        if (conf.load) { self.load(); }

    }

    // jQuery plugin initialization
    $.fn.overlay = function (conf) {

        // already constructed --> return API
        //this --
        var el = this.data("overlay");
        if (el) { return el; }

        if ($.isFunction(conf)) {
            conf = { onBeforeLoad: conf };
        }

        conf = $.extend(true, {}, $.tools.overlay.conf, conf);
        this.each(function () {
            el = new Overlay($(this), conf);
            instances.push(el);
            $(this).data("overlay", el);
        });
        return conf.api ? el : this;
    };

})(jQuery);


/**
 * @license 
 * jQuery Tools @VERSION / Expose - Dim the lights
 * 
 * NO COPYRIGHTS OR LICENSES. DO WHAT YOU LIKE.
 * 
 * http://flowplayer.org/tools/toolbox/expose.html
 *
 * Since: Mar 2010
 * Date: @DATE 
 */
(function($) { 	

	// static constructs
	$.tools = $.tools || {version: '@VERSION'};
	
	var tool;
	
	tool = $.tools.expose = {
		
		conf: {	
			maskId: 'exposeMask',
			loadSpeed: 'slow',
			closeSpeed: 'fast',
			closeOnClick: true,
			closeOnEsc: true,
			
			// css settings
			zIndex: 9998,
			opacity: 0.8,
			startOpacity: 0,
			color: '#fff',
			
			// callbacks
			onLoad: null,
			onClose: null,

            //扩展
            fixed:false
		}
	};

	/* one of the greatest headaches in the tool. finally made it */
	function viewport() {	
		// the horror case
		if ($.browser.msie) {
			
			// if there are no scrollbars then use window.height
			var d = $(document).height(), w = $(window).height();
			
			return [
				window.innerWidth || 							// ie7+
				document.documentElement.clientWidth || 	// ie6  
				document.body.clientWidth, 					// ie6 quirks mode
				d - w < 20 ? w : d
			];
		} 
		
		// other well behaving browsers
		return [$(document).width(), $(document).height()]; 
	} 
	
	function call(fn) {
		if (fn) { return fn.call($.mask); }
	}
	
	var mask, exposed, loaded, config, overlayIndex;		
	
	
	$.mask = {
		
		load: function(conf, els) {
			
			// already loaded ?
			if (loaded) { return this; }			
			
			// configuration
			if (typeof conf == 'string') {
				conf = {color: conf};	
			}
			
			// use latest config
			conf = conf || config;
			
			config = conf = $.extend($.extend({}, tool.conf), conf);

			// get the mask
			mask = $("#" + conf.maskId);
				
			// or create it
			if (!mask.length) {
				mask = $('<div/>').attr("id", conf.maskId);
				$("body").append(mask);
			}
			
			// set position and dimensions 			
			var size = viewport();

            mask.css({
                position:'absolute',
                top: 0,
                left: 0,
                width: size[0],
                height: size[1],
                display: 'none',
                opacity: conf.startOpacity,
                zIndex: conf.zIndex
            });

            if(conf.fixed){
                mask.css('position','fixed');
            }
			
			if (conf.color) {
				mask.css("backgroundColor", conf.color);	
			}			
			
			// onBeforeLoad
			if (call(conf.onBeforeLoad) === false) {
				return this;
			}
			
			// esc button
			if (conf.closeOnEsc) {						
				$(document).on("keydown.mask", function(e) {							
					if (e.keyCode == 27) {
						$.mask.close(e);	
					}		
				});			
			}
			
			// mask click closes
			if (conf.closeOnClick) {
				mask.on("click.mask", function(e)  {
					$.mask.close(e);		
				});					
			}			
			
			// resize mask when window is resized
			$(window).on("resize.mask", function() {
				$.mask.fit();
			});
			
			// exposed elements
			if (els && els.length) {
				
				overlayIndex = els.eq(0).css("zIndex");

				// make sure element is positioned absolutely or relatively
				$.each(els, function() {
					var el = $(this);
					if (!/relative|absolute|fixed/i.test(el.css("position"))) {
						el.css("position", "relative");		
					}					
				});
			 
				// make elements sit on top of the mask
				exposed = els.css({ zIndex: Math.max(conf.zIndex + 1, overlayIndex == 'auto' ? 0 : overlayIndex)});			
			}	
			
			// reveal mask
			mask.css({display: 'block'}).fadeTo(conf.loadSpeed, conf.opacity, function() {
				$.mask.fit(); 
				call(conf.onLoad);
				loaded = "full";
			});
			
			loaded = true;			
			return this;				
		},
		
		close: function() {
			if (loaded) {
				
				// onBeforeClose
				if (call(config.onBeforeClose) === false) { return this; }
					
				mask.fadeOut(config.closeSpeed, function()  {					
					call(config.onClose);					
					if (exposed) {
						exposed.css({zIndex: overlayIndex});						
					}				
					loaded = false;
				});				
				
				// unbind various event listeners
				$(document).off("keydown.mask");
				mask.off("click.mask");
				$(window).off("resize.mask");  
			}
			
			return this; 
		},
		
		fit: function() {
			if (loaded) {
				var size = viewport();				
				mask.css({width: size[0], height: size[1]});
			}				
		},
		
		getMask: function() {
			return mask;	
		},
		
		isLoaded: function(fully) {
			return fully ? loaded == 'full' : loaded;	
		}, 
		
		getConf: function() {
			return config;	
		},
		
		getExposed: function() {
			return exposed;	
		}		
	};
	
	$.fn.mask = function(conf) {
		$.mask.load(conf);
		return this;		
	};			
	
	$.fn.expose = function(conf) {
		$.mask.load(conf, this);
		return this;			
	};


})(jQuery);

var appEmotion = {
    chat: {
        'url': '/Content/blue/emotions/chat/',
        'isemotions': 'false',
        '[cHat]': 'chat1.png',
        '[cBalloon]': 'chat2.png',
        '[cCake]': 'chat3.png',
        '[cCrutch]': 'chat4.png',
        '[cWreath]': 'chat5.png',
        '[cCandle]': 'chat6.png',
        '[cGift]': 'chat7.png',
        '[cBell]': 'chat8.png',
        '[cHats]': 'chat9.png',
        '[aCow]': 'chat10.png',
        '[aBallons]': 'chat11.png',
        '[aChocolate]': 'chat12.png',
        '[aInvitation]': 'chat13.png',
        '[aSantaClaus]': 'chat14.png',
        '[aChristmastree]': 'chat15.png',
        '[aSocks]': 'chat16.png',
        '[aSmallbell]': 'chat17.png',
        '[aSmallStar]': 'chat18.png',
        '[aSnowflake]': 'chat19.png',
        '[aSnowman]': 'chat20.png'
    },
    christmas: {
        'url': '/Content/blue/emotions/christmas/',
        'isemotions': 'true',
        '[bag]': 'chris02x.png',
        '[bear]': 'chris12x.png',
        '[bell]': 'chris22x.png',
        '[bells]': 'chris32x.png',
        '[calendar]': 'chris42x.png',
        '[candle]': 'chris52x.png',
        '[chocolate]': 'chris62x.png',
        '[deer]': 'chris72x.png',
        '[gift]': 'chris82x.png',
        '[gift2]': 'chris92x.png',
        '[glove]': 'chris102x.png',
        '[hat]': 'chris112x.png',
        '[oldman]': 'chris122x.png',
        '[perfume]': 'chris132x.png',
        '[snowman]': 'chris142x.png',
        '[snow]': 'chris152x.png',
        '[sock]': 'chris162x.png',
        '[star]': 'chris172x.png',
        '[stick]': 'chris182x.png',
        '[tree]': 'chris192x.png'
    },
    ali: {
        'url': '/Content/blue/emotions/ali/',
        'isemotions': 'true',
        '[A_Amazed]': '0000Amazed.png',
        '[A_Angry]': '0001Angry.png',
        '[A_Bye]': '0002Bye.png',
        '[A_Cry]': '0003Cry.png',
        '[A_Dizzy]': '0004Dizzy.png',
        '[A_Embarrassed]': '0005Embarrassed.png',
        '[A_Frozen]': '0006Frozen.png',
        '[A_Gifts]': '0007Gifts.png',
        '[A_Flowers]': '0008Flowers.png',
        '[A_Impatient]': '0009Impatient.png',
        '[A_Moved]': '0010Moved.png',
        '[A_Pinch Face]': '0011Pinch Face.png',
        '[A_Sex]': '0012Sex.png',
        '[A_Shut up]': '0013Shut up.png',
        '[A_Shy]': '0014Shy.png',
        '[A_Superman]': '0015Superman.png',
        '[A_Touched]': '0016Touched.png'
    },
    liumangtu: {
        'url': '/Content/blue/emotions/liumangtu/',
        'isemotions': 'true',
        '[B_complacent]': '0017complacent.png',
        '[B_Bye]': '0018Bye.png',
        '[B_Cry]': '0019Cry.png',
        '[B_happy]': '0020happy.png',
        '[B_Hope]': '0021Hope.png',
        '[B_Hum]': '0022Hum.png',
        '[B_Imagine]': '0023Imagine.png',
        '[B_Juggle]': '0024Juggle.png',
        '[B_Like]': '0025Like.png',
        '[B_Loser]': '0026Loser.png',
        '[B_Love]': '0027Love U.png',
        '[B_OMG]': '0028OMG.png',
        '[B_terrified]': '0029terrified.png',
        '[B_yeah]': '0030yeah.png',
        '[B_Snicker]': '0031Snicker.png',
        '[B_Star]': '0032Star.png',
        '[B_Sweat]': '0033Sweat.png'
    },
    chanzuihou: {
        'url': '/Content/blue/emotions/chanzuihou/',
        'isemotions': 'true',
        '[C_Admire]': '0034Admire.png',
        '[C_Annoyed]': '0035Annoyed.png',
        '[C_Brushing]': '0036Brushing.png',
        '[C_Embarrassed]': '0037Embarrassed.png',
        '[C_Faint]': '0038Faint.png',
        '[C_Hurt]': '0039Hurt.png',
        '[C_Infatuated]': '0040Infatuated.png',
        '[C_Love]': '0041Love.png',
        '[C_Money]': '0042Money.png',
        '[C_Poor]': '0043Poor.png',
        '[C_Question]': '0044Question.png',
        '[C_Regret]': '0045Regret.png',
        '[C_Sentimental]': '0046Sentimental.png',
        '[C_Shocked]': '0047Shocked.png',
        '[C_Speechless]': '0048Speechless.png',
        '[C_Splenetic]': '0049Splenetic.png',
        '[C_Surrender]': '0050Surrender.png'
    },
    xiaopohai: {
        'url': '/Content/blue/emotions/xiaopohai/',
        'isemotions': 'true',
        '[D_Blame]': '0051Blame.png',
        '[D_Carry U]': '0052Carry U.png',
        '[D_Chat]': '0053Chat.png',
        '[D_Confess]': '0054Confess.png',
        '[D_Cry]': '0055Cry.png',
        '[D_Flower]': '0056Flower.png',
        '[D_Hold]': '0057Hold Hand.png',
        '[D_I love U]': '0058I love U.png',
        '[D_Kiss]': '0059Kiss.png',
        '[D_Love]': '0060Love.png',
        '[D_Marry]': '0061Marry.png',
        '[D_Parade]': '0062Parade.png',
        '[D_Protect you]': '0063Protect you.png',
        '[D_Ride]': '0064Ride.png',
        '[D_Sex]': '0065Sex.png',
        '[D_Shy]': '0066Shy.png',
        '[D_Sleepy]': '0067Sleepy.png'
    }
};