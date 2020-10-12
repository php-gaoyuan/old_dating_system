var toolLq = { log: function (a, c) { try { console.log(a + "："), console.log(c) } catch (d) { alert(a + "：" + c) } }, getStrValue: function (a, c) { c = [",", c, ","].join(""); return (c = c.match(RegExp("," + a + ":([^,]+),"))) ? c[1].replace(/&dlq;/g, ",") : c }, strToJson: function (a) { for (var a = [",", a, ","].join(""), c, d = {}, b = RegExp(",([_\\w]+[\\w\\d_]+):([^,]+),", "g"); null != (c = b.exec(a)); ) b.lastIndex--, d[c[1]] = c[2].replace(/&dlq;/g, ","); return d }, htmlTemplate: function (a, c) {
    return a.replace(/\$\{([_\w]+[\w\d_]+)\}/g, function (a, b) {
        return null !=
c[b] && void 0 != c[b] ? c[b] : a
    })
}, jsonDateParse: function (a) { var b = new RegExp("['\"]?\\\\/(Date\\(\\d+\\))\\\\/['\"]?", "gi"); return a.replace(b, "new $1") }, utcStrParse: function (a, b) { var c = [], d = new Date, e = new Date, f = { y: "FullYear", M: "Month", d: "Date", h: "Hours", m: "Minutes", s: "Seconds" }, g = /(\d+)([\D]+)/g, h = 0, i = [!1]; b || (i = [["y", "M", "d"], ["M", "d", "y"], ["d", "M", "y"], ["y", "d", "M"]]), a += ";"; for (var j = 0; j < i.length; j++) { for (b = i[j] ? i[j].concat(["h", "m", "s"]) : b, h = 0, d.str = [], e.str = []; null != (c = g.exec(a)); ) c.l = c[1].length, "Month" == f[b[h]] && (c[1] = c[1] - 0 - 1), e["set" + f[b[h]]](c[1] - 0), d["setUTC" + f[b[h]]](c[1] - 0), e.temp = e["get" + f[b[h]]](), d.temp = d["get" + f[b[h]]](), "Month" == f[b[h]] && (e.temp++, d.temp++), e.str.push(c.l > (e.temp + "").length ? "0" + e.temp : e.temp, c[2]), d.str.push(c.l > (d.temp + "").length ? "0" + d.temp : d.temp, c[2]), h++; if (e.str = e.str.slice(0, -1).join(""), d.str = d.str.slice(0, -1).join(""), e.str + ";" == a) break } return delete d.temp, d.toString = function () { return d.str }, d }, getUTCMi: function (a) { return Date.UTC(a.getFullYear(), a.getUTCMonth(), a.getUTCDate(), a.getUTCHours(), a.getUTCMinutes(), a.getUTCSeconds(), a.getUTCMilliseconds()) }, getUTCStr: function (a) { return [a.getFullYear(), "/", a.getUTCMonth() + 1, "/", a.getUTCDate()].join("") }, dateFormat: function (a, b) { var c = ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"], d = ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"], e = { "M+": a.getMonth() + 1, "d+": a.getDate(), "h+": a.getHours() > 12 ? a.getHours() - 12 : a.getHours(), "H+": a.getHours(), "m+": a.getMinutes(), "s+": a.getSeconds(), "q+": Math.floor((a.getMonth() + 3) / 3), w: "0123456".indexOf(a.getDay()), t: a.getHours() < 12 ? "am" : "pm", W: c[a.getDay()], L: d[a.getMonth()] }; /(y+)/.test(b) && (b = b.replace(RegExp.$1, (a.getFullYear() + "").substr(4 - RegExp.$1.length))); for (var f in e) new RegExp("(" + f + ")").test(b) && (b = b.replace(RegExp.$1, 1 == RegExp.$1.length ? e[f] : ("00" + e[f]).substr(("" + e[f]).length))); return b }, utcBirth: function (a, c) { var d = [x18n.today, x18n.tomorrow], b = new Date(toolLq.utcStrParse(a, c).setHours(8, 0, 0, 0)), e = new Date((new Date).setHours(8, 0, 0, 0)), e = Math.floor((b - e) / 864E5); return 0 <= e ? d[e] : b.str }, filterJsonChar: function (a,
c) { switch (c) { case "1": return a.replace(/([^\\])(?=['"])/g, "$1$-\\"); case "-1": return a.replace(/\$\-\\(['"])/g, "$1") } return a.replace(/['"]/g, "") }, filterCRLF: function (a, c) { switch (c) { case "1": return a.replace(/(\r\n|\r|\n)/gi, "$-\\n"); case "-1": return a.replace(/\$\-\\n/g, "<br />"); case "-1.1": return a.replace(/\$\-\\n/g, "\n") } return a.replace(/(\r\n|\r|\n)/gi, "\\n") }, ltrim: function (a) { return a.replace(/^\s+/, "") }, rtrim: function (a) { return a.replace(/\s+$/, "") }, trim: function (a) {
    return a.replace(/^\s*(\S*)\s*$/,
"$1")
}, filterChar: function (a, c) { return a.replace(RegExp(c, "gi"), "") }, filterLt: function (a) { return a.replace(/(<|>)/gi, function (a, d) { return "<" == d ? "&lt;" : "&gt;" }) }, filterScript: function (a, c) { var c = c || "script", d = RegExp(["<\\s*(", c, "[^>]*)>|<\\*s(/)\\s*(", c, "[^>]*)>"].join(""), "gi"); return a.replace(d, function (a, c, d, h) { return ["&lt;", c, d, h, "&gt;"].join("") }) }, getCharsImgs: function (a, c, d, b, e) {
    var a = $(["<div>", a, "</div>"].join("")), c = a.find("img:lt(" + (c ? c : 2) + ")"), g = { imgs: [] }, h = RegExp("^" + location.protocol +
"//" + location.host, "i"); g.str = a.text().replace(/\s{2,}/g, " ").slice(0, e || 100); c.each(function () { g.imgs.push(['<img src="', this.src.replace(h, ""), '" width="', d, '" height="', b, '" />'].join("")) }); g.imgs = g.imgs.join(""); return g
}, filterHtml: function (a, c, d) {
    c = c || "(html|head|body|iframe|a|area|b|big|br|button|dd|dl|dt|div|dd|fieldset|font|form|frame|frameset|h1|h2|h3|h4|h5|h6|hr|img|input|label|li|link|map|meta|object|ol|option|p|script|select|span|style|table|tbody|td|textarea|tfoot|th|thead|title|tr|tt|ul|img|i|s|u)";
    c = d ? c.replace(d, "") : c; c = RegExp(["<\\s*/?", c, "\\b[^>]*>"].join(""), "gi"); return a.replace(c, function () { return "" })
}, filterTag: function (a, c) { var d = (c = c || "") ? RegExp(["<\\s*/?(?!", c, "\\b)\\w+\\b[^>]*>"].join(""), "gi") : RegExp("<\\s*/?\\w+\\b[^>]*>", "gi"); return a.replace(d, function () { return "" }) }, filterMarkImgs: function (a, c) { var c = c || "${imgs}", d = [], a = a.replace(RegExp("<\\s*/?img\\b[^>]*(src\\s*=(?:[^>=](?!http:))*\\.(?:png|jpg|gif))[^>]*>", "gi"), function (a, e) { d.push(e); return c }); return { str: a, imgs: d} }, filterRecoverImgs: function (a,
c, d, b) { var b = b || {}, e = 0; return a.replace(RegExp(d || "\\$\\{imgs\\}", "gi"), function () { if (e >= c.length) return ""; var a = ['<img src="', c[e], '" ', b.width ? 'width="' + b.width + '" ' : "", b.height ? 'height="' + b.height + '" ' : "", b.alt ? 'alt="' + b.alt + '" ' : "", " />"].join(""); e++; return a }) }, filterOnlyImg: function (a, c, d) { var b = toolLq.filterMarkImgs(a, c), a = toolLq.filterTag(b.str); return toolLq.filterRecoverImgs(a, b.imgs, c, d) }, filterEmail: function (a) {
    return a.replace(RegExp("@|([\\d零一二三四五六七八九十]\\s?){6,}|q\\s?q|m\\s?s\\s?n|f\\s?a\\s?c\\s?e\\s?b\\s?o\\s?o\\s?k|F\\s?B|y\\s?a\\s?h\\s?o\\s?o|h\\s?o\\s?t\\s?m\\s?a\\s?i\\s?l|s\\s?k\\s?y\\s?p\\s?e|g\\s?m\\s?a\\s?i\\s?l|\\.\\s?c\\s?o\\s?m|163.\\s?c\\s?o\\s?m|h\\s?t\\s?t\\s?p.*\\.\\w{2,4}(\\/\\w*)?\\b",
"gi"), "")
}, offsetParent: function (a, c) { for (var d = null, b = !0, e = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft), g = Math.max(document.documentElement.scrollTop, document.body.scrollLeft), e = e + a.offsetLeft, g = g + a.offsetTop, d = a.offsetParent; (a = a.parentNode) && a.tagName; ) a.id == c && (b = !1), a == d && b && (e += a.offsetLeft, g += a.offsetTop, d = d.offsetParent); return { left: e, top: g} }, emptyFun: function () { }, levelToImg: function (a) {
    if (!isNaN(a)) {
        var c, d; c = a % 4; d = (a - c) / 4 % 4; for (var a = ((a - c) / 4 - d) / 4, b = [], e = 0; e < a; e++) b.push("<span class='level_icon3_lq'></span>");
        for (e = 0; e < d; e++) b.push("<span class='level_icon1_lq'></span>"); for (e = 0; e < c; e++) b.push("<span class='level_icon2_lq'></span>"); return b.join("")
    }
}, charTran: function (a) { var c = { lt: "<", gt: ">" }; return a.replace(/&([^;]+);/gi, function (a, b) { return c[b] || a }) }
};
$.each(["post", "get"], function (a, c) {
    $[c] = function (a, b, e, g, h) {
        var f, i = { isLoad: !0, openMsg: function () { var a = x18n.loading, c; c = !1; f = $.artDialog({ content: ['<div class="inb_lq loading"></div><div class="inb_lq info">', a || "x18n.loading", "</div>"].join(""), skin: "remind", padding: "0 15px", lock: c, esc: !1, dblClose: !1 }) }, closeMsg: function () { f.close(); f = null } }; $.extend(!0, i, h); jQuery.isFunction(b) && (g = g || e, e = b, b = void 0); if (!i.isLoad) return $.ajax({ type: c, url: a, data: b, success: e, dataType: g }); i.openMsg(); return $.ajax({ type: c,
            url: a, data: b, success: function (a) { i.closeMsg(); e(a) }, dataType: g, error: i.closeMsg
        })
    } 
});
(function (a) {
    function c(a) { return "string" === typeof a } function d(a) { var c = f.call(arguments, 1); return function () { return a.apply(this, c.concat(f.call(arguments))) } } function b(b, d, e, g, f) { var l; g !== h ? (d = e.match(b ? t : /^([^#?]*)\??([^#]*)(#?.*)/), e = d[3] || "", 2 === f && c(g) ? g = g.replace(b ? u : w, "") : (l = n(d[2]), g = c(g) ? n[b ? q : r](g) : g, g = 2 === f ? g : 1 === f ? a.extend({}, g, l) : a.extend({}, l, g), g = j(g), b && (g = g.replace(x, i))), b = d[1] + (b ? v : g || !d[1] ? "?" : "") + g + e) : b = d(e !== h ? e : location.href); return b } function e(a, b, d) {
        b === h || "boolean" ===
typeof b ? (d = b, b = l[a ? q : r]()) : b = c(b) ? b.replace(a ? u : w, "") : b; return n(b, d)
    } function g(b, d, e, g) { !c(e) && "object" !== typeof e && (g = e, e = d, d = h); return this.each(function () { var c = a(this), h = d || y()[(this.nodeName || "").toLowerCase()] || "", f = h && c.attr(h) || ""; c.attr(h, l[b](f, e, g)) }) } "$:nomunge"; var h, f = Array.prototype.slice, i = decodeURIComponent, l = a.param, j, m, n, o, p = a.bbq = a.bbq || {}, k, s, y, z = a.event.special, r = "querystring", q = "fragment", w = /^.*\?|#.*$/g, u, t, x, A, v, B = {}; l[r] = d(b, 0, function (a) {
        return a.replace(/(?:^[^?#]*\?([^#]*).*$)?.*/,
"$1")
    }); l[q] = m = d(b, 1, function (a) { return a.replace(t, "$2") }); l.sorted = j = function (b, c) { var d = [], e = {}; a.each(l(b, c).split("&"), function (a, b) { var c = b.replace(/(?:%5B|=).*$/, ""), g = e[c]; g || (g = e[c] = [], d.push(c)); g.push(b) }); return a.map(d.sort(), function (a) { return e[a] }).join("&") }; m.noEscape = function (b) { b = a.map((b || "").split(""), encodeURIComponent); x = RegExp(b.join("|"), "g") }; m.noEscape(",/"); m.ajaxCrawlable = function (a) {
        a !== h && (a ? (u = /^.*(?:#!|#)/, t = /^([^#]*)(?:#!|#)?(.*)$/, v = "#!") : (u = /^.*#/, t = /^([^#]*)#?(.*)$/,
v = "#"), A = !!a); return A
    }; m.ajaxCrawlable(0); a.deparam = n = function (b, c) {
        var d = {}, e = { "true": !0, "false": !1, "null": null }; a.each(b.replace(/\+/g, " ").split("&"), function (b, g) {
            var f = g.split("="), j = i(f[0]), l = d, n = 0, m = j.split("]["), k = m.length - 1; /\[/.test(m[0]) && /\]$/.test(m[k]) ? (m[k] = m[k].replace(/\]$/, ""), m = m.shift().split("[").concat(m), k = m.length - 1) : k = 0; if (2 === f.length) if (f = i(f[1]), c && (f = f && !isNaN(f) ? +f : "undefined" === f ? h : e[f] !== h ? e[f] : f), k) for (; n <= k; n++) j = "" === m[n] ? l.length : m[n], l = l[j] = n < k ? l[j] || (m[n + 1] &&
isNaN(m[n + 1]) ? {} : []) : f; else a.isArray(d[j]) ? d[j].push(f) : d[j] = d[j] !== h ? [d[j], f] : f; else j && (d[j] = c ? h : "")
        }); return d
    }; n[r] = d(e, 0); n[q] = o = d(e, 1); a.elemUrlAttr || (a.elemUrlAttr = function (b) { return a.extend(B, b) })({ a: "href", base: "href", iframe: "src", img: "src", input: "src", form: "action", link: "href", script: "src" }); y = a.elemUrlAttr; a.fn[r] = d(g, r); a.fn[q] = d(g, q); p.pushState = k = function (a, b) { c(a) && (/^#/.test(a) && b === h) && (b = 2); var d = a !== h, d = m(location.href, d ? a : {}, d ? b : 2); location.href = d }; p.getState = s = function (a, b) {
        return a ===
h || "boolean" === typeof a ? o(a) : o(b)[a]
    }; p.removeState = function (b) { var c = {}; b !== h && (c = s(), a.each(a.isArray(b) ? b : arguments, function (a, b) { delete c[b] })); k(c, 2) }; z.hashchange = a.extend(z.hashchange, { add: function (b) { function c(a) { var b = a[q] = m(); a.getState = function (a, c) { return a === h || "boolean" === typeof a ? n(b, a) : n(b, c)[a] }; d.apply(this, arguments) } var d; if (a.isFunction(b)) return d = b, c; d = b.handler; b.handler = c } })
})(jQuery, this);
(function (a, c, d) {
    function b(a) { a = a || location.href; return "#" + a.replace(/^[^#]*#?(.*)$/, "$1") } "$:nomunge"; var e = "hashchange", g = document, h, f = a.event.special, i = g.documentMode, l = "on" + e in c && (i === d || 7 < i); a.fn[e] = function (a) { return a ? this.bind(e, a) : this.trigger(e) }; a.fn[e].delay = 50; f[e] = a.extend(f[e], { setup: function () { if (l) return !1; a(h.start) }, teardown: function () { if (l) return !1; a(h.stop) } }); h = function () {
        function f() {
            var d = b(), g = s(o); d !== o ? (k(o = d, g), a(c).trigger(e)) : g !== o && (location.href = location.href.replace(/#.*/,
"") + g); i = setTimeout(f, a.fn[e].delay)
        } var h = {}, i, o = b(), p = function (a) { return a }, k = p, s = p; h.start = function () { i || f() }; h.stop = function () { i && clearTimeout(i); i = d }; a.browser.msie && !l && function () {
            var c, d; h.start = function () { c || (d = (d = a.fn[e].src) && d + b(), c = a('<iframe tabindex="-1" title="empty"/>').hide().one("load", function () { d || k(b()); f() }).attr("src", d || "javascript:0").insertAfter("body")[0].contentWindow, g.onpropertychange = function () { try { "title" === event.propertyName && (c.document.title = g.title) } catch (a) { } }) };
            h.stop = p; s = function () { return b(c.location.href) }; k = function (b, d) { var f = c.document, h = a.fn[e].domain; b !== d && (f.title = g.title, f.open(), h && f.write('<script>document.domain="' + h + '"<\/script>'), f.close(), c.location.hash = b) } 
        } (); return h
    } ()
})(jQuery, this);
function HashLoad(a) {
    $.extend(this, { contLevel: ["#iframe_div_lq", "#js_app_cont", "#js_app_inner"], changeTabs: [function (a) { var d = a.match(/^eq\((\d+)\)/), d = d ? d[1] : null, b = {}, b = d ? $("#app_nav1_lq").find("li").eq(d) : $("#app_nav1_lq").find("li").has('a[url="' + a + '"]'); b.addClass("nav1_active_lq").siblings(".nav1_active_lq").removeClass("nav1_active_lq") }, function (a) {
        var d = a.match(/^eq\((\d+)\)/), d = d ? d[1] : null, b = {}, b = d ? $("#iframe_div_lq .tabs_lq").find("a[url]").eq(d) : $("#iframe_div_lq .tabs_lq").find('a[url="' +
a + '"]'); b.addClass("active1_tab_lq").siblings(".active1_tab_lq").removeClass("active1_tab_lq")
    } ], oldUrls: [], defUrl: "index_lf_inner.html", loadData: { level1: null, level2: null, level3: null }, onLeveled: { level1: $.noop, level2: $.noop, level3: $.noop }, prefix: { level1: "", level2: "", level3: "" }, isLoad: !1, queue: {}, isScroll: !0
    }); $.extend(this, a); this.init()
}
(function (a) {
    function c(a, b, h) {
        if (h in this.queue) {
            var f = b[a]; if (f) {
                var i = this, l = $(i.contLevel[0]), j = "level" + (a + 1), m = i.loadData[j] || null, n = f.search(/\+\+(.*)\+\+/); 0 < n && (f = f.slice(0, n), n = toolLq.strToJson(decodeURI(b[a].slice(n + 2, -2)))); i.prefix[j] && (f = "function" == typeof i.prefix[j] ? i.prefix[j](f) : i.prefix[j] + f); a < b.length && (i.isLoad = !0, 1 > a ? l.load(f, m, function () { if (a + 2 > b.length) return delete i.queue[h]; c.call(i, a + 1, b, h); i.onLeveled[j](f) }) : l.find(i.contLevel[a]).load(f, m, function () {
                    if (a + 2 > b.length) return delete i.queue[h];
                    c.call(i, a + 1, b, h); i.onLeveled[j](f)
                }), i.oldUrls.push(b[a]), i.changeTabs[a](d(a, b, n))); i.loadData[j] = null
            } 
        } else this.isLoad = !1
    } function d(a, b, c) { var d = b.slice(0, a + 1).join("!"); if ("undefined" == typeof c.tabAct || !c.tabAct) return d.replace(/(\/[^\?!]*)\?[^!]*((!)|.$)/g, "$1$3"); switch (c.tabAct) { case "0": return d; case "1": return [b.slice(0, a).join("!").replace(/(\/[^\?!]*)\?[^!]*((!)|.$)/g, "$1$3"), "!", b[a]].join("") } return c.tabAct } function b(a) {
        var b = []; a && (a + "!").replace(/(\/?[^!\+]+(\+\+[^\+]*\+\+)?)!/g,
function (a, c) { b.push(c); return a }); return b
    } $.extend(a.prototype, { sendRequest: function (a) { for (var b = "loadLoop" + (new Date).getTime(), d = 0; d < a.length; d++) if (a[d] != this.oldUrls[d]) { this.isScroll && $(window).scrollTop(0); this.oldUrls = this.oldUrls.slice(0, d); this.isLoad && (this.queue = {}); this.queue[b] = b; for (var f = d, i = this.contLevel, l = void 0, j = void 0, m = i.length - 1; m >= f; m--) l = $(i[m]), j = l.data("unloader"), "function" == typeof j && j(), l.removeData("unloader"); c.call(this, d, a, b); break } }, load: function (a, c) {
        if (a) {
            var d =
location.hash, f = b(a); this.loadData = {}; $.extend(this.loadData, c); this.defUrl = a; this.oldUrls = 1 < f.length ? this.oldUrls.slice(0, f.length - 1) : []; location.hash = "#" + a; d == location.hash && $(window).trigger("hashchange"); return !1
        } 
    }, defLoad: function (a) { this.defUrl = a; $(window).trigger("hashchange") }, anchor: function (a, b) { b = b || 0; $(window).scrollTop($(a).offset().top + b) }, init: function () {
        var a = this; $(window).bind("hashchange", function (c) {
            for (var d = b(a.defUrl), c = b(c.fragment), f = 0; f < d.length; f++) c[f] || (c[f] = d[f]); a.defUrl =
[]; a.sendRequest(c)
        })
    } 
    })
})(HashLoad); $.ajaxSetup({ cache: !1 }); function form_clear(a) { a.find("input[type=text]").val("") }
function success_message(a, c) { var d = function () { }; void 0 != c && (d = c); $.remindDialog({ time: { time: 1E3 }, fadeOutTime: 2E3, type: "ok", content: a, beforeunload: d }) } function warning_message(a, c) { var d = function () { }; void 0 != c && (d = c); $.remindDialog({ time: { time: 1E3 }, fadeOutTime: 2E3, type: "warning", content: a, beforeunload: d }) }
function failure_message(a, c) { var d = function () { }; void 0 != c && (d = c); $.remindDialog({ time: { time: 1E3 }, fadeOutTime: 2E3, type: "error", content: a, beforeunload: d }) } function confirm_dialog(a, c, d, b, e, g) { $.icoDialog({ type: 1, title: a, content: c, okValue: d, ok: b, cancelValue: e, cancel: g }) } function success_dialog(a, c, d, b) { $.icoDialog({ type: 2, title: a, content: c, okValue: d, ok: b }) } function warning_dialog(a, c, d, b) { $.icoDialog({ type: 3, title: a, content: c, okValue: d, ok: b }) }
function dialog(a, c, d) { var b = { content: "", title: "", callback: function () { } }; if (void 0 != a) switch (typeof a) { case "string": b.content = a; break; case "function": b.callback = a } if (void 0 != c) switch (typeof c) { case "string": b.title = c; break; case "function": b.callback = c } void 0 != d && (b.callback = d); $.dialog({ title: b.title, content: b.content, okValue: x18n.ok, ok: function () { b.callback() }, cancelValue: x18n.cancel, cancel: function () { } }) }
function msg(a, c, d) { var b = { content: "", title: "", callback: function () { } }; if (void 0 != a) switch (typeof a) { case "string": b.content = a; break; case "function": b.callback = a } if (void 0 != c) switch (typeof c) { case "string": b.title = c; break; case "function": b.callback = c } void 0 != d && (b.callback = d); $.dialog({ title: b.title, content: b.content, okValue: x18n.ok, ok: function () { b.callback() } }) } String.prototype.replaceGaga = function (a) { return this.replace("{0}", a) };
function resizeImg(a, c, d, b) { "img" == a.tagName.toLowerCase() && (a.width / a.height >= c / d ? a.width = c : a.height = d, a.width >= parseInt(c * b) && a.height >= parseInt(d * b) && (a.width = c, a.height = d)) } function AutoResizeImage(a, c, d) { var b = new Image; b.src = d.src; var e, g = 1, h = b.width, f = b.height; e = a / h; b = c / f; if (0 == a && 0 == c) g = 1; else if (0 == a) 1 > b && (g = b); else if (0 == c) 1 > e && (g = e); else if (1 > e || 1 > b) g = e <= b ? e : b; 1 > g && (h *= g, f *= g); d.height = f; d.width = h }
(function (a) {
    var c = a.browser.msie && 0 <= a.browser.version.indexOf("7"); a.fn.autoIMG = function (b) {
        var c = this.width(), g = this.height(), h = { maxWidth: c, maxHeight: g }; a.extend(h, b); b = null; b = "img" == this[0].tagName.toLowerCase() ? this : this.find("img"); return b.each(function (a, b) {
            var c = b.src; 0 <= c.indexOf("middle") || (b.style.display = "none", b.removeAttribute("src"), d(c, function (a, d) {
                var e, g, f = 1; g = h.maxWidth / a; e = h.maxHeight / d; if (1 > g || 1 > e) f = g <= e ? g : e; 1 > f && (a *= f, d *= f); b.style.width = a + "px"; b.style.height = d + "px"; b.style.display =
""; b.setAttribute("src", c)
            }))
        })
    }; c && function (a, c, d) { d = c.createElement("style"); c.getElementsByTagName("head")[0].appendChild(d); d.styleSheet && (d.styleSheet.cssText += a) || d.appendChild(c.createTextNode(a)) } ("img {-ms-interpolation-mode:bicubic}", document); var d = function () {
        var a = [], c = null, d = function () { for (var d = 0; d < a.length; d++) a[d].end ? a.splice(d--, 1) : a[d](); a.length || (clearInterval(c), c = null) }; return function (h, f, i, l) {
            var j, m, n, o, p, k = new Image; k.src = h; k.complete ? (f(k.width, k.height), i && i(k.width, k.height)) :
(m = k.width, n = k.height, j = function () { o = k.width; p = k.height; if (o !== m || p !== n || 1024 < o * p) f(o, p), j.end = !0 }, j(), k.onerror = function () { l && l(); j.end = !0; k = k.onload = k.onerror = null }, k.onload = function () { i && i(k.width, k.height); !j.end && j(); k = k.onload = k.onerror = null }, j.end || (a.push(j), null === c && (c = setInterval(d, 40))))
        } 
    } ()
})(jQuery);
(function (a) { a.fn.preventScroll = function () { this.each(function () { a.browser.mozilla ? this.addEventListener("DOMMouseScroll", function (a) { this.scrollTop += 0 < a.detail ? 60 : -60; a.preventDefault() }, !1) : this.onmousewheel = function (a) { a = a || window.event; this.scrollTop += 0 < a.wheelDelta ? -60 : 60; a.returnValue = !1 } }); return this } })(jQuery);
(function (a) {
    a.fn.lazyload = function (c) {
        var d = { threshold: 0, failurelimit: 0, event: "scroll", effect: "fadeIn", effectspeed: 500, container: window }; c && a.extend(d, c); var b = this; "scroll" == d.event && a(d.container).unbind("scroll.lazyload").bind("scroll.lazyload", function () {
            var c = 0; b.each(function () { if (!a.abovethetop(this, d) && !a.leftofbegin(this, d)) if (!a.belowthefold(this, d) && !a.rightoffold(this, d)) a(this).trigger("appear"); else if (c++ > d.failurelimit) return !1 }); var g = a.grep(b, function (b) { return !a(b).data("loaded") });
            b = a(g)
        }); this.each(function () { var b = a(this); b.attr("src"); if (a.abovethetop(this, d) || a.leftofbegin(this, d) || a.belowthefold(this, d) || a.rightoffold(this, d)) b.data("loaded", !1).one("appear", function () { var b = a(this); b.data("loaded") || a("<img />").bind("load", function () { b.css({ opacity: 0 }).attr("src", b.attr("original")).data("loaded", !0).animate({ opacity: 1 }, d.effectspeed) }).attr("src", b.attr("original")) }); else b.data("loaded", !0).attr("src", b.attr("original")) }); return this
    }; a.belowthefold = function (c, d) {
        var b =
a(d.container); return (d.container === window ? b.height() + b.scrollTop() : b.offset().top + b.height()) <= a(c).offset().top - d.threshold
    }; a.rightoffold = function (c, d) { var b = a(d.container); return (d.container === window ? b.width() + b.scrollLeft() : b.offset().left + b.width()) <= a(c).offset().left - d.threshold }; a.abovethetop = function (c, d) { var b = a(d.container); return (d.container === window ? b.scrollTop() : b.offset().top) >= a(c).offset().top + d.threshold + a(c).height() }; a.leftofbegin = function (c, d) {
        var b = a(d.container); return (d.container ===
window ? b.scrollLeft() : b.offset().left) >= a(c).offset().left + d.threshold + a(c).width()
    }; a.extend(a.expr[":"], { "below-the-fold": "$.belowthefold(a, {threshold : 0, container: window})", "above-the-fold": "!$.belowthefold(a, {threshold : 0, container: window})", "right-of-fold": "$.rightoffold(a, {threshold : 0, container: window})", "left-of-fold": "!$.rightoffold(a, {threshold : 0, container: window})" })
})(jQuery);
(function (a) {
    a.fn.divlazyload = function (c) {
        function d(d, c) { a.get(d, function (d) { if ("false" == d) b.callback("empty", "[data-jqselc=" + c + "]"); else { var d = a(d), e; a("[data-jqselc=" + c + "]")[b.addMethod](d); e = a("[data-jqselc=" + c + "]"); 1 > e.length && (e = d); b.effectspeed ? e.css({ opacity: 0 }).animate({ opacity: 1 }, b.effectspeed, b.callback) : b.callback(e) } }, "html") } var b = { threshold: 0, failurelimit: 0, event: "scroll", effectspeed: null, container: window, callback: a.noop, addMethod: "replaceWith" }; c && a.extend(b, c); var e = this; "scroll" ==
b.event && a(b.container).unbind("scroll.divlazyload").bind("scroll.divlazyload", function () { var d = 0; e.each(function () { if (!a.abovethetop(this, b) && !a.leftofbegin(this, b)) if (!a.belowthefold(this, b) && !a.rightoffold(this, b)) a(this).trigger("appear"); else if (d++ > b.failurelimit) return !1 }); var c = a.grep(e, function (b) { return !a(b).data("loaded") }); e = a(c) }); this.each(function () {
    var c = a(this), e; if (a.abovethetop(this, b) || a.leftofbegin(this, b) || a.belowthefold(this, b) || a.rightoffold(this, b)) c.data("loaded", !1).one("appear",
function () { var b = a(this), c = "divlazy" + (new Date).getTime(); b.attr("data-jqselc", c); b.data("loaded") || d(b.attr("url"), c) }); else e = "divlazy" + (new Date).getTime(), c.attr("data-jqselc", e), d(c.attr("url"), e); c = null
}); return this
    } 
})(jQuery);
