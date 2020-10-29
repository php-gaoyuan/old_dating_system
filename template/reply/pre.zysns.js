/**
常用工具函数，以后扩展到jquery中
 by：kule 2012-06-06
 */
var toolLq = {
    //记录错误信息及调试信息
    log: function (caption, str) {
        try {
            console.log(caption + '：');
            console.log(str);
        } catch (ex) {
            alert(caption + '：' + str);
        }
    },
    //返回存储的key:value,格式内容。value可为字符串，但是不能含有英文逗点，
    //英文逗点请用&dlq;代替
    getStrValue: function (key, str) {
        str = [',', str, ','].join('');
        var regExp = new RegExp(',' + key + ':([^,]+),');
        str = str.match(regExp);
        return str ? str[1].replace(/&dlq;/g, ',') : str;
    },
    //str转换成json对象，不使用eval
    //英文逗点请用&dlq;代替
    strToJson: function (jsonStr) {
        jsonStr = [',', jsonStr, ','].join('');
        var rstArray, rstObj = {};
        var regExp = new RegExp(',([_\\w]+[\\w\\d_]+):([^,]+),', 'g');
        while ((rstArray = regExp.exec(jsonStr)) != null) {
            regExp.lastIndex--;
            rstObj[rstArray[1]] = rstArray[2].replace(/&dlq;/g, ',');
        }
        rstArray = regExp = null;
        return rstObj;
    },
    //HTML模板替换
    htmlTemplate: function (template, data) {
        //替换符号为${xxx}
        return template.replace(/\$\{([_\w]+[\w\d_]+)\}/g,
            function (s, s1) {
                if (data[s1] != null && data[s1] != undefined) {
                    return data[s1];
                } else {
                    return s;
                }
            });
    },
    //"\/Date(1339264818000)\/"json时间解析
    jsonDateParse: function (str) {
        var regExp = new RegExp('[\'\"]?\\\\\/(Date\\(\\d+\\))\\\\\/[\'\"]?', 'gi');
        return str.replace(regExp, 'new $1');
    },
    //utc时间解析，将utc时间解析为本地时间，返回date对象，date.str为字串
    utcStrParse: function (dateStr,format) {      
           
       /// 
        //dateStr='2015/05/12 20:40';        
        var tempArray = [],
            date = new Date(),
            srcDate=new Date(),
            funQueue = {
                'y': 'FullYear',
                'M': 'Month',
                'd': 'Date',
                'h': 'Hours',
                'm': 'Minutes',
                's': 'Seconds'
            },
            patt = /(\d+)([\D]+)/g,
            i=0,
            formatArr=[false];

        //格式推断
        if(!format){
            formatArr=[['y','M','d'],//年月日
                ['M','d','y'],//月日年
                ['d','M','y'],//日月年
                ['y','d','M']];//年日月
        }
        dateStr += ';';
        for(var k=0;k<formatArr.length;k++){
            format=formatArr[k]?formatArr[k].concat(['h','m','s']):format;
            i=0;

            date.str = [];
            srcDate.str=[];
            while ((tempArray = patt.exec(dateStr)) != null) { 
                if (funQueue[format[i]] == 'Month'){
                     tempArray[1] = tempArray[1] - 0 - 1;                              
                }
                srcDate['set' + funQueue[format[i]]](tempArray[1] - 0);
                date['setUTC' + funQueue[format[i]]](tempArray[1] - 0);    
                i++;
            }
            i=0;
            while ((tempArray = patt.exec(dateStr)) != null) {              
                tempArray.l = tempArray[1].length;                   
                srcDate.temp = srcDate['get' + funQueue[format[i]]]();
                date.temp = date['get' + funQueue[format[i]]]();
                if (funQueue[format[i]] == 'Month'){
                    srcDate.temp++;
                    date.temp++;
                }
                srcDate.str.push(tempArray.l > (srcDate.temp + '').length ? '0' + srcDate.temp : srcDate.temp, tempArray[2]);
                date.str.push(tempArray.l > (date.temp + '').length ? '0' + date.temp : date.temp, tempArray[2]);
                i++;
            }
            srcDate.str = srcDate.str.slice(0, -1).join('');
            date.str = date.str.slice(0, -1).join('');
            if(srcDate.str+';'==dateStr)break;
        }
        delete date.temp;
        date.toString = function () {
            return date.str;
        };
        return date;
    },
    getUTCMi: function (date) {
        return Date.UTC(date.getFullYear(), date.getUTCMonth(), date.getUTCDate(), date.getUTCHours(), date.getUTCMinutes(), date.getUTCSeconds(), date.getUTCMilliseconds());
    },
    getUTCStr: function (date) {
        return [date.getFullYear(), '/', date.getUTCMonth() + 1, '/', date.getUTCDate()].join('');
    },
    //日期格式化，参数为yyyy-MM-dd，HH:mm:ss
    dateFormat: function (date, format) {
        var _weekName = ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'];
        var _monthName = ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'];
        var formatStr = {
            "M+": date.getMonth() + 1,
            "d+": date.getDate(),
            "h+": date.getHours() > 12 ? date.getHours() - 12 : date.getHours(),
            "H+": date.getHours(),
            "m+": date.getMinutes(),
            "s+": date.getSeconds(),
            "q+": Math.floor((date.getMonth() + 3) / 3),
            "w": '0123456'.indexOf(date.getDay()),
            "t": date.getHours() < 12 ? 'am' : 'pm',
            "W": _weekName[date.getDay()],
            "L": _monthName[date.getMonth()] //non-standard
        };
        if (/(y+)/.test(format)) {
            format = format.replace(RegExp.$1, (date.getFullYear() + '').substr(4 - RegExp.$1.length));
        }
        for (var k in formatStr) {
            if (new RegExp('(' + k + ')').test(format))
                format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? formatStr[k] : ('00' + formatStr[k]).substr(('' + formatStr[k]).length));
        }
        return format;
    },
    //得到好友生日
    utcBirth:function(dateStr,format){
        var day=[x18n.today,x18n.tomorrow];
        var friendDate=new Date(toolLq.utcStrParse(dateStr,format).setHours(8,0,0,0));
        var now=new Date(new Date().setHours(8,0,0,0));
        var zone=Math.floor((friendDate-now)/86400000);
        return zone>=0?day[zone]:friendDate.str;
    },
    //json过滤特殊字符，防止单双引号破坏
    filterJsonChar: function (str,code) {
        switch (code){
            case '1':
                return str.replace(/([^\\])(?=['"])/g,'$1$-\\');
            case '-1':
                return str.replace(/\$\-\\(['"])/g,'$1');
        }
        return str.replace(/['"]/g, '');
    },
    filterCRLF:function(str,code){
        switch(code){
            case '1':
                return str.replace(/(\r\n|\r|\n)/gi,'$-\\n');
            case '-1'://转换html换行
                return str.replace(/\$\-\\n/g,'<br />');
            case '-1.1':
                return str.replace(/\$\-\\n/g,'\n');
        }
        return str.replace(/(\r\n|\r|\n)/gi,'\\n');
    },
    //去空格ltrim()，rtrim(),trim()
    ltrim: function (str) {
        return str.replace(/^\s+/, '');
    },
    rtrim: function (str) {
        return str.replace(/\s+$/, '');
    },
    trim: function (str) {
        return str.replace(/^\s*(\S*)\s*$/, '$1');
    },
    //去单引号，filterChar()
    //若是特殊字符需要转义，未来实现自动判断
    filterChar: function (str, cha) {
        var regExp = new RegExp(cha, 'gi');
        return str.replace(regExp, '');
    },
    //过滤<>符号
    filterLt: function (str) {
        return str.replace(/(<|>)/gi, function (s, s1) {
            if (s1 == '<') {
                return '&lt;';
            } else {
                return '&gt;';
            }
        });
    },
    //过滤script
    filterScript:function(str,tagName){
        tagName=tagName||'script';
        var regExp=new RegExp(['<\\s*(',tagName,'[^>]*)>|<\\*s(\/)\\s*(',tagName,'[^>]*)>'].join(''),'gi');
        return str.replace(regExp,function(s,s1,s2,s3){
            return ['&lt;',s1,s2,s3,'&gt;'].join('');
        });
    },
    getCharsImgs:function(str,imgs,width,height,words){
        var tempDom=$(['<div>',str,'</div>'].join(''));
        var imgDom=tempDom.find('img:lt('+(imgs?imgs:2)+')');
        var rst={imgs:[]};
        var regExp=new RegExp('^'+location.protocol+'//'+location.host,'i');
        words=words||100;
        rst.str=tempDom.text().replace(/\s{2,}/g,' ').slice(0,words);
        imgDom.each(function(){
            rst.imgs.push(['<img src="',this.src.replace(regExp,''),'" width="',width,'" height="',height,'" />'].join(''));
        });
        rst.imgs = rst.imgs.join('');
        return rst;
    },
    //过滤HTML
    filterHtml:function(str,noTagName,hasTagName){
        noTagName=noTagName||
            ['(html|head|body|iframe|a|area|b|big|br|button|dd|dl|dt|div|dd|fieldset|font|',
                'form|frame|frameset|h1|h2|h3|h4|h5|h6|hr|img|input|label|li|link|map|meta|object|',
                'ol|option|p|script|select|span|style|table|tbody|td|textarea|tfoot|th|thead|title|tr|',
                'tt|ul|img|i|s|u)'].join('');
        noTagName=hasTagName?noTagName.replace(hasTagName,''):noTagName;
        var regExp=new RegExp(['<\\s*\/?',noTagName,'\\b[^>]*>'].join(''),'gi');
        return str.replace(regExp,function(s,s1){
            return '';
        });
    },
    //过滤标签，firefox等会以xml解析自定义标签,如pa,故需要过滤所有被<>包围的内容
    filterTag:function(str,hasTagName){
        hasTagName=hasTagName||'';
        var regExp=hasTagName?new RegExp(['<\\s*\/?(?!',hasTagName,'\\b)\\w+\\b[^>]*>'].join(''),'gi'):
            new RegExp('<\\s*\/?\\w+\\b[^>]*>','gi');
        return str.replace(regExp,function(s,s1){
            return '';
        });
    },
    //标记图片
    filterMarkImgs:function(str,flag){
        flag=flag||'${imgs}';
        var imgs=[],
            regExp=new RegExp('<\\s*\/?img\\b[^>]*(src\\s*=(?:[^>=](?!http:))*\\.(?:png|jpg|gif))[^>]*>','gi');
        str=str.replace(regExp,function(s,s1){
            imgs.push(s1);
            return flag;
        });
        return {str:str,imgs:imgs};
    },
    filterRecoverImgs:function(str,imgs,flag,property){
        flag=flag||'\\$\\{imgs\\}';
        property=property||{};
        var pos=0,
            regExp=new RegExp(flag,'gi');
        return str.replace(regExp,function(){
            if(pos>=imgs.length)return '';
            var str=['<img src="',imgs[pos],'" ',
                property.width?'width="'+property.width+'" ':'',
                property.height?'height="'+property.height+'" ':'',
                property.alt?'alt="'+property.alt+'" ':'',
                ' />'].join('');
            pos++;
            return str;
        });
    },
    filterOnlyImg:function(str,flag,property){
        var strObj=toolLq.filterMarkImgs(str,flag);
        str=toolLq.filterTag(strObj.str);
        return toolLq.filterRecoverImgs(str,strObj.imgs,flag,property);
    },
    //过滤邮箱和QQ
    filterEmail:function(str){
        var regExp=new RegExp(['@|([\\d零一二三四五六七八九十]\\s?){6,}|',//数字号码
            'q\\s?q|',//qq
            'm\\s?s\\s?n|',//msn
            'f\\s?a\\s?c\\s?e\\s?b\\s?o\\s?o\\s?k|',//facebook
            'F\\s?B|y\\s?a\\s?h\\s?o\\s?o|',//FB yahoo
            'h\\s?o\\s?t\\s?m\\s?a\\s?i\\s?l|',//hotmail
            's\\s?k\\s?y\\s?p\\s?e|',//skype
            'g\\s?m\\s?a\\s?i\\s?l|',//gmail
            '\\.\\s?c\\s?o\\s?m|163.\\s?c\\s?o\\s?m|',//.com 163.com
            'h\\s?t\\s?t\\s?p.*\\.\\w{2,4}(\\/\\w*)?\\b'//http:
            ].join(''),'gi');
        return str.replace(regExp,'');
    },
    //获得指定节点相对父节点的偏移量，若无指定父节点或父节点错误则指定父节点为html
    //参数node,parentID；返回{left:offsety,top;offsety}
    //by kule 2012-3-3 9:24:50
    offsetParent: function (node, parentId) {
        var offsetParent = null; //用来存储offsetParent
        var offsetFlag = true; //用来决定是否offset累加
        var offsetLeft = Math.max(document.documentElement.scrollLeft,
            document.body.scrollLeft); //兼容不同浏览器对body.scroll的解释
        var offsetTop = Math.max(document.documentElement.scrollTop,
            document.body.scrollLeft);
        offsetLeft += node.offsetLeft;
        offsetTop += node.offsetTop;
        //循环累加offsetParent的offset,直到指定父对象
        //循环累加父级的scroll,直到html元素
        offsetParent = node.offsetParent;
        while ((node = node.parentNode) && node.tagName) {
            //if(node.scrollLeft||node.scrollTop){
            //offsetLeft-=node.scrollLeft;
            //offsetTop+=node.scrollTop;
            //}
            if (node.id == parentId) offsetFlag = false;
            if (node == offsetParent && offsetFlag) {
                offsetLeft += node.offsetLeft;
                offsetTop += node.offsetTop;
                offsetParent = offsetParent.offsetParent;
            }
        }
        node = offsetParent = offsetFlag = null;
        return { left: offsetLeft, top: offsetTop };
    },
    emptyFun: function () {},
    levelToImg: function (level) {//等级
        if (isNaN(level)) return;
        var star, //星星的个数
            moon, //月亮的个数
            sun; //太阳的个数
        star = level % 4;
        moon = (level - star) / 4 % 4;
        sun = ((level - star) / 4 - moon) / 4;
        var html = new Array();
        for (var i = 0; i < sun; i++) {
            html.push("<span class='level_icon3_lq'></span>");
        }
        for (i = 0; i < moon; i++) {
            html.push("<span class='level_icon1_lq'></span>");
        }
        for (i = 0; i < star; i++) {
            html.push("<span class='level_icon2_lq'></span>");
        }
        return html.join("");
    },
    charTran: function (str) {
        var tranSet = {
            lt: '<',
            gt: '>'
        };
        return str.replace(/&([^;]+);/gi, function (s, s1) { return tranSet[s1] || s });
    }
};
//post,get重写
$.each(['post','get'],function(i,method){
    $[method]=function(url,data,callback,type,setting){
        var dia;
        var options={
            isLoad:true,
            openMsg:function(){
                dia=loadingDialog(x18n.loading);
            },
            closeMsg:function(){
                dia.close();
                dia=null;
            }
        };
        $.extend(true,options,setting);
        if ( jQuery.isFunction( data ) ) {
            type = type || callback;
            callback = data;
            data = undefined;
        }
        if(!options.isLoad){
            return $.ajax({
                type: method,
                url: url,
                data: data,
                success: callback,
                dataType: type
            });
        }
        options.openMsg();
        return $.ajax({
            type: method,
            url: url,
            data: data,
            success: isLoadCall,
            dataType: type,
            error:options.closeMsg
        });
        function isLoadCall(res){
            options.closeMsg();
            callback(res);
        }
        function loadingDialog(content,lock,skin){
            content=content||'x18n.loading';
            lock=lock||false;
            skin=skin||'loading';
            return $.artDialog({
                content:['<div class="inb_lq ',skin,'"></div><div class="inb_lq info">',content,'</div>'].join(''),
                skin:'remind',
                padding:'0 15px',
                lock:lock,
                esc:false,
                dblClose:false
            });
        }
    };
});

/*!
 * jQuery BBQ: Back Button & Query Library - v1.3pre - 8/26/2010
 * http://benalman.com/projects/jquery-bbq-plugin/
 * kule修改 2012-07-12
 */
(function ($, window) {
    '$:nomunge'; // Used by YUI compressor.
    // Some convenient shortcuts.
    var undefined,
        aps = Array.prototype.slice,
        decode = decodeURIComponent,
        // Method / object references.
        jq_param = $.param,
        jq_param_sorted,
        jq_param_fragment,
        jq_deparam,
        jq_deparam_fragment,
        jq_bbq = $.bbq = $.bbq || {},
        jq_bbq_pushState,
        jq_bbq_getState,
        jq_elemUrlAttr,
        special = $.event.special,
        // Reused strings.
        str_hashchange = 'hashchange',
        str_querystring = 'querystring',
        str_fragment = 'fragment',
        str_elemUrlAttr = 'elemUrlAttr',
        str_href = 'href',
        str_src = 'src',
        // Reused RegExp.
        re_params_querystring = /^.*\?|#.*$/g,
        re_params_fragment,
        re_fragment,
        re_no_escape,
        ajax_crawlable,
        fragment_prefix,
        // Used by jQuery.elemUrlAttr.
        elemUrlAttr_cache = {};
    function is_string(arg) {
        return typeof arg === 'string';
    }
    // Why write the same function twice? Let's curry! Mmmm, curry..
    //函数式编程中的科里化，curry
    function curry(func) {
        var args = aps.call(arguments, 1);
        return function () {
            return func.apply(this, args.concat(aps.call(arguments)));
        };
    }
    function get_fragment(url) {
        return url.replace(re_fragment, '$2');
    }
    function get_querystring(url) {
        return url.replace(/(?:^[^?#]*\?([^#]*).*$)?.*/, '$1');
    }
    // Section: Param (to string)
    //
    // Method: jQuery.param.querystring
    //
    // Retrieve the query string from a URL or if no arguments are passed, the
    // current window.location.href.
    //
    // Usage:
    //
    // > jQuery.param.querystring( [ url ] );
    //
    // Arguments:
    //
    //  url - (String) A URL containing query string params to be parsed. If url
    //    is not passed, the current window.location.href is used.
    //
    // Returns:
    //
    //  (String) The parsed query string, with any leading "?" removed.
    //

    // Method: jQuery.param.querystring (build url)
    //
    // Merge a URL, with or without pre-existing query string params, plus any
    // object, params string or URL containing query string params into a new URL.
    //
    // Usage:
    //
    // > jQuery.param.querystring( url, params [, merge_mode ] );
    //
    // Arguments:
    //
    //  url - (String) A valid URL for params to be merged into. This URL may
    //    contain a query string and/or fragment (hash).
    //  params - (String) A params string or URL containing query string params to
    //    be merged into url.
    //  params - (Object) A params object to be merged into url.
    //  merge_mode - (Number) Merge behavior defaults to 0 if merge_mode is not
    //    specified, and is as-follows:
    //
    //    * 0: params in the params argument will override any query string
    //         params in url.
    //    * 1: any query string params in url will override params in the params
    //         argument.
    //    * 2: params argument will completely replace any query string in url.
    //
    // Returns:
    //
    //  (String) A URL with a urlencoded query string in the format '?a=b&c=d&e=f'.

    // Method: jQuery.param.fragment
    //
    // Retrieve the fragment (hash) from a URL or if no arguments are passed, the
    // current window.location.href.
    //
    // Usage:
    //
    // > jQuery.param.fragment( [ url ] );
    //
    // Arguments:
    //
    //  url - (String) A URL containing fragment (hash) params to be parsed. If
    //    url is not passed, the current window.location.href is used.
    //
    // Returns:
    //
    //  (String) The parsed fragment (hash) string, with any leading "#" removed.

    // Method: jQuery.param.fragment (build url)
    //console.log('');
    function jq_param_sub(is_fragment, get_func, url, params, merge_mode) {
        var result,
            qs,
            matches,
            url_params,
            hash;
        if (params !== undefined) {
            matches = url.match(is_fragment ? re_fragment : /^([^#?]*)\??([^#]*)(#?.*)/);
            hash = matches[3] || '';
            if (merge_mode === 2 && is_string(params)) {
                qs = params.replace(is_fragment ? re_params_fragment : re_params_querystring, '');
            } else {
                url_params = jq_deparam(matches[2]);
                params = is_string(params)
                    ? jq_deparam[ is_fragment ? str_fragment : str_querystring ](params)
                    : params;
                qs = merge_mode === 2 ? params                              // passed params replace url params
                    : merge_mode === 1 ? $.extend({}, params, url_params)  // url params override passed params
                    : $.extend({}, url_params, params);                     // passed params override url params
                qs = jq_param_sorted(qs);
                if (is_fragment) {
                    qs = qs.replace(re_no_escape, decode);
                }
            }
            result = matches[1] + ( is_fragment ? fragment_prefix : qs || !matches[1] ? '?' : '' ) + qs + hash;
        } else {
            result = get_func(url !== undefined ? url : location.href);
        }
        return result;
    }
    jq_param[ str_querystring ] = curry(jq_param_sub, 0, get_querystring);
    jq_param[ str_fragment ] = jq_param_fragment = curry(jq_param_sub, 1, get_fragment);
    // Method: jQuery.param.sorted
    //
    // Returns a params string equivalent to that returned by the internal
    // jQuery.param method, but sorted, which makes it suitable for use as a
    // cache key.
    //
    // For example, in most browsers jQuery.param({z:1,a:2}) returns "z=1&a=2"
    // and jQuery.param({a:2,z:1}) returns "a=2&z=1". Even though both the
    // objects being serialized and the resulting params strings are equivalent,
    // if these params strings were set into the location.hash fragment
    // sequentially, the hashchange event would be triggered unnecessarily, since
    // the strings are different (even though the data described by them is the
    // same). By sorting the params string, unecessary hashchange event triggering
    // can be avoided.
    //
    // Usage:
    //
    // > jQuery.param.sorted( obj [, traditional ] );
    //
    // Arguments:
    //
    //  obj - (Object) An object to be serialized.
    //  traditional - (Boolean) Params deep/shallow serialization mode. See the
    //    documentation at http://api.jquery.com/jQuery.param/ for more detail.
    //
    // Returns:
    //
    //  (String) A sorted params string.
    jq_param.sorted = jq_param_sorted = function (a, traditional) {
        var arr = [],
            obj = {};

        $.each(jq_param(a, traditional).split('&'), function (i, v) {
            var key = v.replace(/(?:%5B|=).*$/, ''),
                key_obj = obj[ key ];

            if (!key_obj) {
                key_obj = obj[ key ] = [];
                arr.push(key);
            }

            key_obj.push(v);
        });

        return $.map(arr.sort(),
            function (v) {
                return obj[ v ];
            }).join('&');
    };
    // Method: jQuery.param.fragment.noEscape
    //
    // Specify characters that will be left unescaped when fragments are created
    // or merged using <jQuery.param.fragment>, or when the fragment is modified
    // using <jQuery.bbq.pushState>. This option only applies to serialized data
    // object fragments, and not set-as-string fragments. Does not affect the
    // query string. Defaults to ",/" (comma, forward slash).
    //
    // Note that this is considered a purely aesthetic option, and will help to
    // create URLs that "look pretty" in the address bar or bookmarks, without
    // affecting functionality in any way. That being said, be careful to not
    // unescape characters that are used as delimiters or serve a special
    // purpose, such as the "#?&=+" (octothorpe, question mark, ampersand,
    // equals, plus) characters.
    //
    // Usage:
    //
    // > jQuery.param.fragment.noEscape( [ chars ] );
    //
    // Arguments:
    //
    //  chars - (String) The characters to not escape in the fragment. If
    //    unspecified, defaults to empty string (escape all characters).
    //
    // Returns:
    //
    //  Nothing.
    jq_param_fragment.noEscape = function (chars) {
        chars = chars || '';
        var arr = $.map(chars.split(''), encodeURIComponent);
        re_no_escape = new RegExp(arr.join('|'), 'g');
    };

    // A sensible default. These are the characters people seem to complain about
    // "uglifying up the URL" the most.
    jq_param_fragment.noEscape(',/');

    // Method: jQuery.param.fragment.ajaxCrawlable
    jq_param_fragment.ajaxCrawlable = function (state) {
        if (state !== undefined) {
            if (state) {
                re_params_fragment = /^.*(?:#!|#)/;
                re_fragment = /^([^#]*)(?:#!|#)?(.*)$/;
                fragment_prefix = '#!';
            } else {
                re_params_fragment = /^.*#/;
                re_fragment = /^([^#]*)#?(.*)$/;
                fragment_prefix = '#';
            }
            ajax_crawlable = !!state;
        }
        return ajax_crawlable;
    };
    jq_param_fragment.ajaxCrawlable(0);

    // Section: Deparam (from string)
    //
    // Method: jQuery.deparam
    //
    // Deserialize a params string into an object, optionally coercing numbers,
    // booleans, null and undefined values; this method is the counterpart to the
    // internal jQuery.param method.
    //
    // Usage:
    //
    // > jQuery.deparam( params [, coerce ] );
    //
    // Arguments:
    //
    //  params - (String) A params string to be parsed.
    //  coerce - (Boolean) If true, coerces any numbers or true, false, null, and
    //    undefined to their actual value. Defaults to false if omitted.
    //
    // Returns:
    //
    //  (Object) An object representing the deserialized params string.

    $.deparam = jq_deparam = function (params, coerce) {
        var obj = {},
            coerce_types = { 'true':!0, 'false':!1, 'null':null };

        // Iterate over all name=value pairs.
        $.each(params.replace(/\+/g, ' ').split('&'), function (j, v) {
            var param = v.split('='),
                key = decode(param[0]),
                val,
                cur = obj,
                i = 0,

                // If key is more complex than 'foo', like 'a[]' or 'a[b][c]', split it
                // into its component parts.
                keys = key.split(']['),
                keys_last = keys.length - 1;

            // If the first keys part contains [ and the last ends with ], then []
            // are correctly balanced.
            if (/\[/.test(keys[0]) && /\]$/.test(keys[ keys_last ])) {
                // Remove the trailing ] from the last keys part.
                keys[ keys_last ] = keys[ keys_last ].replace(/\]$/, '');

                // Split first keys part into two parts on the [ and add them back onto
                // the beginning of the keys array.
                keys = keys.shift().split('[').concat(keys);

                keys_last = keys.length - 1;
            } else {
                // Basic 'foo' style key.
                keys_last = 0;
            }

            // Are we dealing with a name=value pair, or just a name?
            if (param.length === 2) {
                val = decode(param[1]);

                // Coerce values.
                if (coerce) {
                    val = val && !isNaN(val) ? +val              // number
                        : val === 'undefined' ? undefined         // undefined
                        : coerce_types[val] !== undefined ? coerce_types[val] // true, false, null
                        : val;                                                // string
                }

                if (keys_last) {
                    // Complex key, build deep object structure based on a few rules:
                    // * The 'cur' pointer starts at the object top-level.
                    // * [] = array push (n is set to array length), [n] = array if n is
                    //   numeric, otherwise object.
                    // * If at the last keys part, set the value.
                    // * For each keys part, if the current level is undefined create an
                    //   object or array based on the type of the next keys part.
                    // * Move the 'cur' pointer to the next level.
                    // * Rinse & repeat.
                    for (; i <= keys_last; i++) {
                        key = keys[i] === '' ? cur.length : keys[i];
                        cur = cur[key] = i < keys_last
                            ? cur[key] || ( keys[i + 1] && isNaN(keys[i + 1]) ? {} : [] )
                            : val;
                    }

                } else {
                    // Simple key, even simpler rules, since only scalars and shallow
                    // arrays are allowed.

                    if ($.isArray(obj[key])) {
                        // val is already an array, so push on the next value.
                        obj[key].push(val);

                    } else if (obj[key] !== undefined) {
                        // val isn't an array, but since a second value has been specified,
                        // convert val into an array.
                        obj[key] = [ obj[key], val ];

                    } else {
                        // val is a scalar.
                        obj[key] = val;
                    }
                }

            } else if (key) {
                // No value was defined, so set something meaningful.
                obj[key] = coerce
                    ? undefined
                    : '';
            }
        });

        return obj;
    };

    // Method: jQuery.deparam.querystring
    //
    // Parse the query string from a URL or the current window.location.href,
    // deserializing it into an object, optionally coercing numbers, booleans,
    // null and undefined values.
    //
    // Usage:
    //
    // > jQuery.deparam.querystring( [ url ] [, coerce ] );
    //
    // Arguments:
    //
    //  url - (String) An optional params string or URL containing query string
    //    params to be parsed. If url is omitted, the current
    //    window.location.href is used.
    //  coerce - (Boolean) If true, coerces any numbers or true, false, null, and
    //    undefined to their actual value. Defaults to false if omitted.
    //
    // Returns:
    //
    //  (Object) An object representing the deserialized params string.

    // Method: jQuery.deparam.fragment
    //
    // Parse the fragment (hash) from a URL or the current window.location.href,
    // deserializing it into an object, optionally coercing numbers, booleans,
    // null and undefined values.
    //
    // Usage:
    //
    // > jQuery.deparam.fragment( [ url ] [, coerce ] );
    //
    // Arguments:
    //
    //  url - (String) An optional params string or URL containing fragment (hash)
    //    params to be parsed. If url is omitted, the current window.location.href
    //    is used.
    //  coerce - (Boolean) If true, coerces any numbers or true, false, null, and
    //    undefined to their actual value. Defaults to false if omitted.
    //
    // Returns:
    //
    //  (Object) An object representing the deserialized params string.

    function jq_deparam_sub(is_fragment, url_or_params, coerce) {
        if (url_or_params === undefined || typeof url_or_params === 'boolean') {
            // url_or_params not specified.
            coerce = url_or_params;
            url_or_params = jq_param[ is_fragment ? str_fragment : str_querystring ]();
        } else {
            url_or_params = is_string(url_or_params)
                ? url_or_params.replace(is_fragment ? re_params_fragment : re_params_querystring, '')
                : url_or_params;
        }

        return jq_deparam(url_or_params, coerce);
    }

    ;

    jq_deparam[ str_querystring ] = curry(jq_deparam_sub, 0);
    jq_deparam[ str_fragment ] = jq_deparam_fragment = curry(jq_deparam_sub, 1);

    // Section: Element manipulation
    //
    // Method: jQuery.elemUrlAttr
    //
    // Get the internal "Default URL attribute per tag" list, or augment the list
    // with additional tag-attribute pairs, in case the defaults are insufficient.
    //
    // In the <jQuery.fn.querystring> and <jQuery.fn.fragment> methods, this list
    // is used to determine which attribute contains the URL to be modified, if
    // an "attr" param is not specified.
    //
    // Default Tag-Attribute List:
    //
    //  a      - href
    //  base   - href
    //  iframe - src
    //  img    - src
    //  input  - src
    //  form   - action
    //  link   - href
    //  script - src
    //
    // Usage:
    //
    // > jQuery.elemUrlAttr( [ tag_attr ] );
    //
    // Arguments:
    //
    //  tag_attr - (Object) An object containing a list of tag names and their
    //    associated default attribute names in the format { tag: 'attr', ... } to
    //    be merged into the internal tag-attribute list.
    //
    // Returns:
    //
    //  (Object) An object containing all stored tag-attribute values.

    // Only define function and set defaults if function doesn't already exist, as
    // the urlInternal plugin will provide this method as well.
    $[ str_elemUrlAttr ] || ($[ str_elemUrlAttr ] = function (obj) {
        return $.extend(elemUrlAttr_cache, obj);
    })({
        a:str_href,
        base:str_href,
        iframe:str_src,
        img:str_src,
        input:str_src,
        form:'action',
        link:str_href,
        script:str_src
    });

    jq_elemUrlAttr = $[ str_elemUrlAttr ];

    // Method: jQuery.fn.querystring
    //
    // Update URL attribute in one or more elements, merging the current URL (with
    // or without pre-existing query string params) plus any params object or
    // string into a new URL, which is then set into that attribute. Like
    // <jQuery.param.querystring (build url)>, but for all elements in a jQuery
    // collection.
    //
    // Usage:
    //
    // > jQuery('selector').querystring( [ attr, ] params [, merge_mode ] );
    //
    // Arguments:
    //
    //  attr - (String) Optional name of an attribute that will contain a URL to
    //    merge params or url into. See <jQuery.elemUrlAttr> for a list of default
    //    attributes.
    //  params - (Object) A params object to be merged into the URL attribute.
    //  params - (String) A URL containing query string params, or params string
    //    to be merged into the URL attribute.
    //  merge_mode - (Number) Merge behavior defaults to 0 if merge_mode is not
    //    specified, and is as-follows:
    //
    //    * 0: params in the params argument will override any params in attr URL.
    //    * 1: any params in attr URL will override params in the params argument.
    //    * 2: params argument will completely replace any query string in attr
    //         URL.
    //
    // Returns:
    //
    //  (jQuery) The initial jQuery collection of elements, but with modified URL
    //  attribute values.

    // Method: jQuery.fn.fragment
    //
    // Update URL attribute in one or more elements, merging the current URL (with
    // or without pre-existing fragment/hash params) plus any params object or
    // string into a new URL, which is then set into that attribute. Like
    // <jQuery.param.fragment (build url)>, but for all elements in a jQuery
    // collection.
    //
    // Usage:
    //
    // > jQuery('selector').fragment( [ attr, ] params [, merge_mode ] );
    //
    // Arguments:
    //
    //  attr - (String) Optional name of an attribute that will contain a URL to
    //    merge params into. See <jQuery.elemUrlAttr> for a list of default
    //    attributes.
    //  params - (Object) A params object to be merged into the URL attribute.
    //  params - (String) A URL containing fragment (hash) params, or params
    //    string to be merged into the URL attribute.
    //  merge_mode - (Number) Merge behavior defaults to 0 if merge_mode is not
    //    specified, and is as-follows:
    //
    //    * 0: params in the params argument will override any params in attr URL.
    //    * 1: any params in attr URL will override params in the params argument.
    //    * 2: params argument will completely replace any fragment (hash) in attr
    //         URL.
    //
    // Returns:
    //
    //  (jQuery) The initial jQuery collection of elements, but with modified URL
    //  attribute values.

    function jq_fn_sub(mode, force_attr, params, merge_mode) {
        if (!is_string(params) && typeof params !== 'object') {
            // force_attr not specified.
            merge_mode = params;
            params = force_attr;
            force_attr = undefined;
        }
        return this.each(function () {
            var that = $(this),

                // Get attribute specified, or default specified via $.elemUrlAttr.
                attr = force_attr || jq_elemUrlAttr()[ ( this.nodeName || '' ).toLowerCase() ] || '',

                // Get URL value.
                url = attr && that.attr(attr) || '';

            // Update attribute with new URL.
            that.attr(attr, jq_param[ mode ](url, params, merge_mode));
        });
    }

    $.fn[ str_querystring ] = curry(jq_fn_sub, str_querystring);
    $.fn[ str_fragment ] = curry(jq_fn_sub, str_fragment);
    // Section: History, hashchange event
    jq_bbq.pushState = jq_bbq_pushState = function (params, merge_mode) {
        if (is_string(params) && /^#/.test(params) && merge_mode === undefined) {
            merge_mode = 2;
        }
        var has_args = params !== undefined,
            url = jq_param_fragment(location.href,
                has_args ? params : {}, has_args ? merge_mode : 2);
        location.href = url;
    };
    jq_bbq.getState = jq_bbq_getState = function (key, coerce) {
        return key === undefined || typeof key === 'boolean'
            ? jq_deparam_fragment(key) // 'key' really means 'coerce' here
            : jq_deparam_fragment(coerce)[ key ];
    };
    jq_bbq.removeState = function (arr) {
        var state = {};
        if (arr !== undefined) {
            state = jq_bbq_getState();
            $.each($.isArray(arr) ? arr : arguments, function (i, v) {
                delete state[ v ];
            });
        }
        jq_bbq_pushState(state, 2);
    };
    // Event: hashchange event (BBQ)
    special[str_hashchange] = $.extend(special[str_hashchange], {
        add:function (handleObj) {
            var old_handler;
            function new_handler(e) {
                var hash = e[str_fragment] = jq_param_fragment();
                e.getState = function (key, coerce) {
                    return key === undefined || typeof key === 'boolean'
                        ? jq_deparam(hash, key) // 'key' really means 'coerce' here
                        : jq_deparam(hash, coerce)[ key ];
                };
                old_handler.apply(this, arguments);
            }
            if ($.isFunction(handleObj)) {
                old_handler = handleObj;
                return new_handler;
            } else {
                old_handler = handleObj.handler;
                handleObj.handler = new_handler;
            }
        }
    });
})(jQuery, this);
/*!
 * jQuery hashchange event - v1.3 - 7/21/2010
 * http://benalman.com/projects/jquery-hashchange-plugin/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
(function ($, window, undefined) {
    '$:nomunge'; // Used by YUI compressor
    var str_hashchange = 'hashchange',
        doc = document,
        fake_onhashchange,
        special = $.event.special,
        // Does the browser support window.onhashchange? Note that IE8 running in
        // IE7 compatibility mode reports true for 'onhashchange' in window, even
        // though the event isn't supported, so also test document.documentMode.
        doc_mode = doc.documentMode,
        supports_onhashchange = 'on' + str_hashchange in window && ( doc_mode === undefined || doc_mode > 7 );
    function get_fragment(url) {
        url = url || location.href;
        return '#' + url.replace(/^[^#]*#?(.*)$/, '$1');
    }
    // Method: jQuery.fn.hashchange
    $.fn[str_hashchange] = function (fn) {
        return fn ? this.bind(str_hashchange, fn) : this.trigger(str_hashchange);
    };
    // Property: jQuery.fn.hashchange.delay
    $.fn[str_hashchange].delay = 50;
    /*
     $.fn[ str_hashchange ].domain = null;
     $.fn[ str_hashchange ].src = null;
     */
    // Event: hashchange event
    // Override existing $.event.special.hashchange methods (allowing this plugin
    // to be defined after jQuery BBQ in BBQ's source code).
    special[str_hashchange] = $.extend(special[ str_hashchange ], {
        setup:function () {
            if (supports_onhashchange) {
                return false;
            }
            $(fake_onhashchange.start);
        },
        teardown:function () {
            if (supports_onhashchange) {
                return false;
            }
            $(fake_onhashchange.stop);
        }
    });
    // fake_onhashchange does all the work of triggering the window.onhashchange
    // event for browsers that don't natively support it, including creating a
    // polling loop to watch for hash changes and in IE 6/7 creating a hidden
    // Iframe to enable back and forward.
    fake_onhashchange = (function () {
        var self = {},
            timeout_id,
            last_hash = get_fragment(),
            fn_retval = function (val) {
                return val;
            },
            history_set = fn_retval,
            history_get = fn_retval;
        self.start = function () {
            timeout_id || poll();
        };
        self.stop = function () {
            timeout_id && clearTimeout(timeout_id);
            timeout_id = undefined;
        };
        function poll() {
            var hash = get_fragment(),
                history_hash = history_get(last_hash);
            if (hash !== last_hash) {
                history_set(last_hash = hash, history_hash);
                $(window).trigger(str_hashchange);
            } else if (history_hash !== last_hash) {
                location.href = location.href.replace(/#.*/, '') + history_hash;
            }
            timeout_id = setTimeout(poll, $.fn[ str_hashchange ].delay);
        }
        // vvvvvvvvvvvvvvvvvvv REMOVE IF NOT SUPPORTING IE6/7/8 vvvvvvvvvvvvvvvvvvv
        $.browser.msie && !supports_onhashchange && (function () {
            var iframe,
                iframe_src;
            // When the event is bound and polling starts in IE 6/7, create a hidden
            // Iframe for history handling.
            self.start = function () {
                if (!iframe) {
                    iframe_src = $.fn[str_hashchange].src;
                    iframe_src = iframe_src && iframe_src + get_fragment();
                    // by using techniques from http://www.paciellogroup.com/blog/?p=604.
                    iframe = $('<iframe tabindex="-1" title="empty"/>').hide()
                        .one('load', function () {
                            iframe_src || history_set(get_fragment());
                            poll();
                        })
                        .attr('src', iframe_src || 'javascript:0')
                        .insertAfter('body')[0].contentWindow;
                    doc.onpropertychange = function () {
                        try {
                            if (event.propertyName === 'title') {
                                iframe.document.title = doc.title;
                            }
                        } catch (e) {
                        }
                    };
                }
            };
            self.stop = fn_retval;
            // Get history by looking at the hidden Iframe's location.hash.
            history_get = function () {
                return get_fragment(iframe.location.href);
            };
            history_set = function (hash, history_hash) {
                var iframe_doc = iframe.document,
                    domain = $.fn[ str_hashchange ].domain;
                if (hash !== history_hash) {
                    iframe_doc.title = doc.title;
                    iframe_doc.open();
                    domain && iframe_doc.write('<script>document.domain="' + domain + '"</script>');
                    iframe_doc.close();
                    iframe.location.hash = hash;
                }
            };

        })();
        // ^^^^^^^^^^^^^^^^^^^ REMOVE IF NOT SUPPORTING IE6/7/8 ^^^^^^^^^^^^^^^^^^^
        return self;
    })();
})(jQuery, this);

/**
 * 地址栏更新
 * 需要bbq组件支持
 * by:kule 2012-07-16
 */
//静态属性
function HashLoad(setting){
    var This=this;
    $.extend(This,{
        contLevel:['#iframe_div_lq','#js_app_cont','#js_app_inner'],//分级容器，每个级别在地址中表现为!分割
        changeTabs:[cTab1,cTab2],//每级选项卡高亮接口
        oldUrls:[],//记录上一次操作的url
        defUrl:'index_lf_inner.html',//默认加载的url
        loadData:{level1:null,level2:null,level3:null},//地址栏更新时，发给服务器的参数
        onLeveled:{level1:$.noop,level2:$.noop,level3:$.noop},//地址栏更新后的回调
        prefix:{level1:'',level2:'',level3:''},//地址栏更新时，请求地址的前缀
        isLoad:false,//是否处于层级请求中
        queue:{},//pid队列
        isScroll:true//是否更新Body滚动条位置
    });
    $.extend(This,setting);
    This.init();
    //一级导航变化
    function cTab1(url){
        //toolLq.log('url',url);
        var eqN=url.match(/^eq\((\d+)\)/);
        eqN=eqN?eqN[1]:null;
        var jqObj={};
        if(eqN){//采用eq定位
            jqObj=$('#app_nav1_lq').find('li').eq(eqN);
        }else{
            jqObj=$('#app_nav1_lq').find('li').has('a[url="'+url+'"]');
        }
        jqObj.addClass('nav1_active_lq').
            siblings('.nav1_active_lq').
            removeClass('nav1_active_lq');
        jqObj=null;
    }
    //二级导航变化
    function cTab2(url){
        //toolLq.log('url',url);
        var eqN=url.match(/^eq\((\d+)\)/);
        eqN=eqN?eqN[1]:null;
        var jqObj={};
        if(eqN){//采用eq定位
            jqObj=$('#iframe_div_lq .tabs_lq').find('a[url]').eq(eqN);
        }else{
            jqObj=$('#iframe_div_lq .tabs_lq').find('a[url="'+url+'"]');
        }
        jqObj.addClass('active1_tab_lq').
            siblings('.active1_tab_lq').
            removeClass('active1_tab_lq');
        jqObj=null;
    }
}
(function(HashLoad){
    //动态方法
    $.extend(HashLoad.prototype,{
        sendRequest:function(urls){
            var pid='loadLoop'+(new Date()).getTime();
            //层级请求处理
            for(var i=0;i<urls.length;i++){
                if(urls[i]!=this.oldUrls[i]){
                    if(this.isScroll)$(window).scrollTop(0);//更新滚动条位置
                    this.oldUrls=this.oldUrls.slice(0,i);
                    //toolLq.log('oldUrls',this.oldUrls);
                    //toolLq.log('i',i);
                    if(this.isLoad)this.queue={};
                    this.queue[pid]=pid;
                    unload(i,this.contLevel);
                    loadLoop.call(this,i,urls,pid);
                    return;
                }
            }
            //平级请求处理
        },
        load:function(hash,datas){
            if(!hash)return;
            var oldHash=location.hash;
            var urls=getUrlsWithParam(hash);
            this.loadData={};
            $.extend(this.loadData,datas);

            this.defUrl=hash;//更改defUrl，强制路径
            this.oldUrls=urls.length>1?this.oldUrls.slice(0,urls.length-1):[];//改变历史记录强制刷新
            location.hash='#'+hash;//更新地址栏

            if(oldHash==location.hash){//若地址栏未变则强制触发
                $(window).trigger('hashchange');
            }

            //toolLq.log('oldhash',oldHash);
            //toolLq.log('location',location.hash);
            return false;
        },
        defLoad:function(hash){
            this.defUrl=hash;
            $(window).trigger('hashchange');
        },
        anchor:function(selector,top){
        	top=top||0;
            $(window).scrollTop($(selector).offset().top+top);
        },
        init:function(){
            var This=this;
            $(window).bind('hashchange',function(e){
                var defs=getUrlsWithParam(This.defUrl);
                var urls=getUrlsWithParam(e.fragment);
                //toolLq.log('hashurl',urls);
                //toolLq.log('defs',defs);
                for(var i=0;i<defs.length;i++){
                    if(!urls[i])urls[i]=defs[i];
                }
                This.defUrl=[];
                //toolLq.log('newurl',urls);
                //toolLq.log('oldUrl',This.oldUrls);
                This.sendRequest(urls);
            });
        }
    });
    //逐级查找，父级未出现时铁定没有子级
    function loadLoop(i,urls,pid){
        if(!(pid in this.queue)){
            this.isLoad=false;
            return;
        }
        var url=urls[i];
        if(!url)return;
        var This=this;
        var jqL0=$(This.contLevel[0]);
        var level='level'+(i+1);
        var loadData=This.loadData[level]||null;
        var param=url.search(/\+\+(.*)\+\+/);
        if(param>0){
            url=url.slice(0,param);
            param=toolLq.strToJson(decodeURI(urls[i].slice(param+2,-2)));
        }
        if(This.prefix[level]){
            url=typeof This.prefix[level]=='function'?This.prefix[level](url):
                This.prefix[level]+url;
        }
        if(i<urls.length){
            This.isLoad=true;
            if(i<1){
                jqL0.load(url,loadData,function(){
                    if(i+2>urls.length)return delete This.queue[pid];
                    loadLoop.call(This,i+1,urls,pid);
                    This.onLeveled[level](url);
                });
            }else{
                jqL0.find(This.contLevel[i]).load(url,loadData,function(){
                    if(i+2>urls.length)return delete This.queue[pid];
                    loadLoop.call(This,i+1,urls,pid);
                    This.onLeveled[level](url);
                });
            }
            This.oldUrls.push(urls[i]);//与url及defUrl对比，不能分离param参数
            This.changeTabs[i](getTabActParam(i,urls,param));
        }
        This.loadData[level]=null;
    }
    //逐级注销，从子级到父级
    function unload(i,conts){
        var jqCont,unloader;
        for(var j=conts.length-1;j>=i;j--){
            jqCont=$(conts[j]);
            unloader=jqCont.data('unloader');
            typeof unloader=='function'&&unloader();
            jqCont.removeData('unloader');
        }
        jqCont=unloader=null;
    }
    //高亮地址参数获取tabAct
    function getTabActParam(i,urls,param){
        var url=urls.slice(0,i+1).join('!');
        if(typeof param.tabAct=='undefined'||!param.tabAct){
            return url.replace(/(\/[^\?!]*)\?[^!]*((!)|.$)/g,'$1$3');//默认去掉每个地址中的？参数块
        }
        switch (param.tabAct){
            case '0'://保留所有参数块
                return url;
            case '1'://保留最后一级参数
                return [urls.slice(0,i).join('!').replace(/(\/[^\?!]*)\?[^!]*((!)|.$)/g,'$1$3'),'!',urls[i]].join('');
        }
        return param.tabAct;//直接返回参数
    }
    //获取!分割的地址参数，屏蔽param中的!干扰
    function getUrlsWithParam(str){
        var tempArr=[];
        if(str){
            (str+'!').replace(/(\/?[^!\+]+(\+\+[^\+]*\+\+)?)!/g,function(s,s1){
                tempArr.push(s1);
                return s;
            });
        }
        return tempArr;
    }
})(HashLoad);

﻿$.ajaxSetup({ cache: false });

//清空表单
function form_clear($form) {
    $form.find('input[type=text]').val('');
}
//获取会员的小图像路径
function toMemberSmallHeader(member) {
    if (member.length < 3) { return "/Content/Images/female.jpg"; }
    var str="/Upload/Header/" + member.substring(0, 1) + "/" + member.substring(0, 2) + "/" + member.substring(0, 3) + "/" + member + "_small.png";
    return str.replace("/Upload/Header/b/bi/bin/", "/bing/");
}
// 获取会员的中等图像路径
function toMemberMiddleHeader(member) {
    if (member.length < 3) { return "/Content/Images/female.jpg"; }
    var str="/Upload/Header/" + member.substring(0, 1) + "/" + member.substring(0, 2) + "/" + member.substring(0, 3) + "/" + member + "_middle.png";
    return str.replace("/Upload/Header/b/bi/bin/", "/bing/");
}
// 获取会员的大图像路径
function toMemberBigHeader(member) {
    if (member.length < 3) { return "/Content/Images/female.jpg"; }
    var str="/Upload/Header/" + member.substring(0, 1) + "/" + member.substring(0, 2) + "/" + member.substring(0, 3) + "/" + member + "_big.png";
    return str.replace("/Upload/Header/b/bi/bin/", "/bing/");
}
//快捷提示框(成功提示)
function success_message(content, callback) {
    var settings = {
        time: { time: 1000 },
        fadeOutTime: 2000,
        type: 'ok',
        content: content,
        beforeunload: function () { }
    };
    if (callback != undefined) { settings.beforeunload = callback; }
    $.remindDialog({
        time: settings.time,
        fadeOutTime: settings.fadeOutTime,
        type: settings.type,
        content: settings.content,
        beforeunload: settings.beforeunload
    });
}
//快捷提示框(警告提示)
function warning_message(content, callback) {
    var settings = {
        time: { time: 1000 },
        fadeOutTime: 2000,
        type: 'warning',
        content: content,
        beforeunload: function () { }
    };
    if (callback != undefined) { settings.beforeunload = callback; }
    $.remindDialog({
        time: settings.time,
        fadeOutTime: settings.fadeOutTime,
        type: settings.type,
        content: settings.content,
        beforeunload: settings.beforeunload
    });
}
//快捷提示框(失败提示)
function failure_message(content, callback) {
    var settings = {
        time: { time: 1000 },
        fadeOutTime: 2000,
        type: 'error',
        content: content,
        beforeunload: function () { }
    };
    if (callback != undefined) { settings.beforeunload = callback; }
    $.remindDialog({
        time: settings.time,
        fadeOutTime: settings.fadeOutTime,
        type: settings.type,
        content: settings.content,
        beforeunload: settings.beforeunload
    });
}
//询问对话框(例如删除之前)
function confirm_dialog(title, content, okValue, okCallback, cancelValue, cancelCallback) {
    $.icoDialog({
        type: 1,
        title: title,
        content: content,
        okValue: okValue,
        ok: okCallback,
        cancelValue: cancelValue,
        cancel: cancelCallback
    });
}
//成功对话框提示(例如充值成功，发礼物成功后提示可以继续发送)
function success_dialog(title, content, okValue, okCallback) {
    $.icoDialog({
        type: 2,
        title: title,
        content: content,
        okValue: okValue,
        ok: okCallback
    });
}
//提示对话框(例如金币不足时提示充值金币等这种比较重要的提示)
function warning_dialog(title, content, okValue, okCallback) {
    $.icoDialog({
        type: 3,
        title: title,
        content: content,
        okValue: okValue,
        ok: okCallback
    });
}
//对话框
function dialog(content, title, callback) {
    var settings = {
        content: '',
        title: '',
        callback: function () { }
    };

    if (content != undefined) {
        switch (typeof content) {
            case 'string':
                settings.content = content;
                break;
            case 'function':
                settings.callback = content;
                break;
        }
    }

    if (title != undefined) {
        switch (typeof title) {
            case 'string':
                settings.title = title;
                break;
            case 'function':
                settings.callback = title;
                break;
        }
    }

    if (callback != undefined) {
        settings.callback = callback;
    }

    $.dialog({
        title: settings.title,
        content: settings.content,
        okValue: x18n.ok,
        ok: function () {
            settings.callback();
        },
        cancelValue: x18n.cancel,
        cancel: function () {
        }
    });
}

//提醒框
function msg(content, title, callback) {
    var settings = {
        content: '',
        title: '',
        callback: function () { }
    };

    if (content != undefined) {
        switch (typeof content) {
            case 'string':
                settings.content = content;
                break;
            case 'function':
                settings.callback = content;
                break;
        }
    }

    if (title != undefined) {
        switch (typeof title) {
            case 'string':
                settings.title = title;
                break;
            case 'function':
                settings.callback = title;
                break;
        }
    }

    if (callback != undefined) {
        settings.callback = callback;
    }

    $.dialog({
        title: settings.title,
        content: settings.content,
        okValue: x18n.ok,
        ok: function () {
            settings.callback();
        }
    });
}

//替换#GAGA#（语言包）
String.prototype.replaceGaga = function (str) {
    return this.replace('{0}', str);
};

//重置图片大小 <img src="" onload="resizeImg(this,200,20,0.9)" />
function resizeImg(obj, w, h, stretch) {
    var img = obj;
    if (obj.tagName.toLowerCase() == "img") {
        img.width / img.height >= w / h ? img.width = w : img.height = h;
        if (img.width >= parseInt(w * stretch) && img.height >= parseInt(h * stretch)) {
            img.width = w;
            img.height = h;
        }
    }
}
//等比缩放
function AutoResizeImage(maxWidth,maxHeight,objImg){
    var img = new Image();
    img.src = objImg.src;
    var hRatio;
    var wRatio;
    var Ratio = 1;
    var w = img.width;
    var h = img.height;
    wRatio = maxWidth / w;
    hRatio = maxHeight / h;
    if (maxWidth ==0 && maxHeight==0){
        Ratio = 1;
    }else if (maxWidth==0){//
        if (hRatio<1) Ratio = hRatio;
    }else if (maxHeight==0){
        if (wRatio<1) Ratio = wRatio;
    }else if (wRatio<1 || hRatio<1){
        Ratio = (wRatio<=hRatio?wRatio:hRatio);
    }
    if (Ratio<1){
        w = w * Ratio;
        h = h * Ratio;
    }
    objImg.height = h;
    objImg.width = w;
}

(function ($) {
    // 检测是否支持css2.1 max-width属性
    var isMaxWidth = 'maxWidth' in document.documentElement.style,
        // 检测是否IE7浏览器
//        isIE7 = !-[1,] && !('prototype' in Image) && isMaxWidth;
        isIE7=$.browser.msie&&$.browser.version.indexOf('7')>=0;

    $.fn.autoIMG = function (setting) {
        var _width = this.width(),
            _height=this.height();

        var options={
            maxWidth:_width,
            maxHeight:_height
        };
        $.extend(options,setting);

        var imgs=null;
        if(this[0].tagName.toLowerCase()=='img'){
            imgs=this;
        }else{
            imgs=this.find('img');
        }

        return imgs.each(function (i, img) {
            // 如果支持max-width属性则使用此，否则使用下面方式
            //if (isMaxWidth) return img.style.maxWidth = maxWidth + 'px';
            var src = img.src;
            if(src.indexOf('middle')>=0)return;
            // 隐藏原图
            img.style.display = 'none';
            img.removeAttribute('src');

            // 获取图片头尺寸数据后立即调整图片
            imgReady(src, function (width, height) {
                // 等比例缩小
                var hRatio;
                var wRatio;
                var Ratio = 1;
                wRatio = options.maxWidth / width;
                hRatio = options.maxHeight / height;
                if (wRatio<1 || hRatio<1){
                    Ratio = (wRatio<=hRatio?wRatio:hRatio);
                }
                if (Ratio<1){
                    width = width * Ratio;
                    height = height * Ratio;
                }

                img.style.width = width + 'px';
                img.style.height = height + 'px';

                // 显示原图
                img.style.display = '';
                img.setAttribute('src', src);
            });

        });
    };

    // IE7缩放图片会失真，采用私有属性通过三次插值解决
    isIE7 && (function (c,d,s) {s=d.createElement('style');d.getElementsByTagName('head')[0].appendChild(s);s.styleSheet&&(s.styleSheet.cssText+=c)||s.appendChild(d.createTextNode(c))})('img {-ms-interpolation-mode:bicubic}',document);

    /**
     * 图片头数据加载就绪事件
     * @see		http://www.planeart.cn/?p=1121
     * @param	{String}	图片路径
     * @param	{Function}	尺寸就绪 (参数1接收width; 参数2接收height)
     * @param	{Function}	加载完毕 (可选. 参数1接收width; 参数2接收height)
     * @param	{Function}	加载错误 (可选)
     */
    var imgReady = (function () {
        var list = [], intervalId = null,

            // 用来执行队列
            tick = function () {
                var i = 0;
                for (; i < list.length; i++) {
                    list[i].end ? list.splice(i--, 1) : list[i]();
                }
                !list.length && stop();
            },

            // 停止所有定时器队列
            stop = function () {
                clearInterval(intervalId);
                intervalId = null;
            };

        return function (url, ready, load, error) {
            var check, width, height, newWidth, newHeight,
                img = new Image();

            img.src = url;

            // 如果图片被缓存，则直接返回缓存数据
            if (img.complete) {
                ready(img.width, img.height);
                load && load(img.width, img.height);
                return;
            }

            // 检测图片大小的改变
            width = img.width;
            height = img.height;
            check = function () {
                newWidth = img.width;
                newHeight = img.height;
                if (newWidth !== width || newHeight !== height ||
                    // 如果图片已经在其他地方加载可使用面积检测
                    newWidth * newHeight > 1024
                    ) {
                    ready(newWidth, newHeight);
                    check.end = true;
                }
            };
            check();

            // 加载错误后的事件
            img.onerror = function () {
                error && error();
                check.end = true;
                img = img.onload = img.onerror = null;
            };

            // 完全加载完毕的事件
            img.onload = function () {
                load && load(img.width, img.height);
                !check.end && check();
                // IE gif动画会循环执行onload，置空onload即可
                img = img.onload = img.onerror = null;
            };

            // 加入队列中定期执行
            if (!check.end) {
                list.push(check);
                // 无论何时只允许出现一个定时器，减少浏览器性能损耗
                if (intervalId === null) intervalId = setInterval(tick, 40);
            }
        };
    })();

})(jQuery);

//阻止鼠标滚轮
(function ($) {
    $.fn.preventScroll = function () {
        this.each(function(){
            if ($.browser.mozilla) {
                this.addEventListener('DOMMouseScroll', function (e) {
                    this.scrollTop += e.detail > 0 ? 60 : -60;
                    e.preventDefault();
                }, false);
            } else {
                this.onmousewheel = function (e) {
                    e = e || window.event;
                    this.scrollTop += e.wheelDelta > 0 ? -60 : 60;
                    e.returnValue = false
                };
            }
        });
        return this;
    };
})(jQuery);


﻿(function ($) {
    $.fn.lazyload = function (options) {
        var settings = {
            threshold: 0,//触发加载的偏移
            failurelimit: 0,
            event: "scroll",
            effect: "fadeIn",
            effectspeed:500,//动画效果时间
            container: window//发生事件的容器
        };
        if (options) {
            $.extend(settings, options);
        }
        var elements = this;
        //触发显隐事件
        if ("scroll" == settings.event) {
            $(settings.container).unbind('scroll.lazyload').bind("scroll.lazyload", function () {
                var counter = 0;
                elements.each(function () {
                    if ($.abovethetop(this, settings) || $.leftofbegin(this, settings)) {//若超出可视区域

                    } else if (!$.belowthefold(this, settings) && !$.rightoffold(this, settings)) {
                        $(this).trigger("appear");
                    } else {
                        if (counter++ > settings.failurelimit) {//失败容错，为0时，失败立即跳出
                            return false;
                        }
                    }
                });
                var temp = $.grep(elements, function (element) {
                    return !$(element).data('loaded');
                });
                elements = $(temp);
            });
        }
        //绑定加载事件
        this.each(function () {
            var jqThis=$(this);
            var src=jqThis.attr('src');
            if($.abovethetop(this, settings) || $.leftofbegin(this, settings) ||
                    $.belowthefold(this, settings) || $.rightoffold(this, settings)){
                //未加载标志
                jqThis.data('loaded',false).
                    one("appear", function () {
                        var jqThis=$(this);
                        if (!jqThis.data('loaded')) {
                            $("<img />").bind("load", function () {
                                jqThis.css({opacity:0})
                                    .attr("src", jqThis.attr("original"))
                                    .data('loaded',true)
                                    .animate({opacity:1},settings.effectspeed);
//                                    [settings.effect](settings.effectspeed);//等价于$(self).show(speed)；使用$(self)['show']()来让用户自定义动画效果
                            }).attr("src", jqThis.attr("original"));//利用一个浏览器对图片进行缓存的原理，创建一个新的img标签去请求图片，图片到达后对原图片进行动画效果展示
                        }
                    });
            }else{
                jqThis.data('loaded',true).attr('src',jqThis.attr('original'));//可视区域的图片直接改变src
            }
        });
        return this;
    };

    $.belowthefold = function (element, settings) {//位于可视区域底部
        var jqCont= $(settings.container);
        var fold=settings.container === window?jqCont.height() + jqCont.scrollTop():jqCont.offset().top+jqCont.height();
        jqCont=null;
        return fold <= $(element).offset().top - settings.threshold;
    };
    $.rightoffold = function (element, settings) {//位于可视区域右侧
        var jqCont= $(settings.container);
        var fold=settings.container === window?jqCont.width() + jqCont.scrollLeft():jqCont.offset().left+jqCont.width();
        jqCont=null;
        return fold <= $(element).offset().left - settings.threshold;
    };
    $.abovethetop = function (element, settings) {//超出可视区域顶部
        var jqCont= $(settings.container);
        var fold=settings.container === window?jqCont.scrollTop():jqCont.offset().top;
        jqCont=null;
        return fold >= $(element).offset().top + settings.threshold + $(element).height();
    };
    $.leftofbegin = function (element, settings) {
        var jqCont= $(settings.container);
        var fold=settings.container === window?jqCont.scrollLeft():jqCont.offset().left;
        jqCont=null;
        return fold >= $(element).offset().left + settings.threshold + $(element).width();
    };
    $.extend($.expr[':'], {//扩展jquery选择器，可以使用以下属性选择器来选择指定元素
        "below-the-fold": "$.belowthefold(a, {threshold : 0, container: window})",
        "above-the-fold": "!$.belowthefold(a, {threshold : 0, container: window})",
        "right-of-fold": "$.rightoffold(a, {threshold : 0, container: window})",
        "left-of-fold": "!$.rightoffold(a, {threshold : 0, container: window})"
    });
})(jQuery);

//使用说明
/*
<div class="lee_lasyload" url="<%=Url.Action("Hello","Home") %>">
</div>
*/
(function ($) {
    $.fn.divlazyload = function (options) {
        var settings = {
            threshold: 0,//触发加载的偏移
            failurelimit: 0,
            event: "scroll",
            effectspeed:null,//动画效果时间
            container: window,//发生事件的容器
            callback:$.noop,
            addMethod:'replaceWith'
        };
        if (options) {
            $.extend(settings, options);
        }
        var elements = this;
        //触发显隐事件
        if ("scroll" == settings.event) {
            $(settings.container).unbind('scroll.divlazyload').bind("scroll.divlazyload", function () {
                var counter = 0;
                elements.each(function () {
                    if ($.abovethetop(this, settings) || $.leftofbegin(this, settings)) {//若超出可视区域

                    } else if (!$.belowthefold(this, settings) && !$.rightoffold(this, settings)) {
                        $(this).trigger("appear");
                    } else {
                        if (counter++ > settings.failurelimit) {//失败容错，为0时，失败立即跳出
                            return false;
                        }
                    }
                });
                var temp = $.grep(elements, function (element) {
                    return !$(element).data('loaded');
                });
                elements = $(temp);
            });
        }
        //绑定加载事件
        this.each(function () {
            var jqThis=$(this);
            var jqselc;
            if($.abovethetop(this, settings) || $.leftofbegin(this, settings) ||
                $.belowthefold(this, settings) || $.rightoffold(this, settings)){
                //未加载标志
                jqThis.data('loaded',false).
                    one("appear", function () {
                        var jqThis=$(this);
                        var jqselc='divlazy'+(new Date()).getTime();
                        jqThis.attr('data-jqselc',jqselc);
                        if (!jqThis.data('loaded')) {
                            asyncLoad(jqThis.attr('url'),jqselc);
                        }
                        jqThis=null;
                    });
            }else{
                jqselc='divlazy'+(new Date()).getTime();
                jqThis.attr('data-jqselc',jqselc);
                asyncLoad(jqThis.attr('url'),jqselc);//可视区域的div直接加载
            }
            jqThis=null;
        });
        //异步加载数据
        function asyncLoad(url,jqselc){
            $.get(url,function(res){
                if(res=='false'){
                    settings.callback('empty','[data-jqselc='+jqselc+']');
                    return;
                }
                var jqObj=$(res),jqP;
                $('[data-jqselc='+jqselc+']')[settings.addMethod](jqObj);
                jqP=$('[data-jqselc='+jqselc+']');
                if(jqP.length<1){
                    jqP=jqObj;
                    jqObj=null;
                }
                if(settings.effectspeed){
                    jqP.css({opacity:0}).animate({opacity:1},settings.effectspeed,settings.callback);
                }else{
                    settings.callback(jqP);
                }
            },'html');
        }
        return this;
    };
})(jQuery);