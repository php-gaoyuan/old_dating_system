/**
 * Created by sunbing.
 * Date: 13-3-21
 * Time: 上午9:20
 * 说明：
 *      1、4/1 1.0.0
 */
(function(){
    var im=window.IM={
        version:"1.0.0",
    //domain: 'http://localhost:3476/'
            domain: 'https://im.gagahi.com/'
    };
    //配置参数
    var config=im.config={
        wsurl:'',//webSocket地址
        name:'',//用户名
        sex:'',//用户性别
        //Gold:'',//用户金币
        language:'',//语言
        getHome: $.noop,//个人主页地址
        gotoHistory: $.noop,//历史记录
        debug:false,
        session:''//seesionkey
    };
    //外部配置
    im.initConfig=function(cf){
        $.extend(true,config,cf);
    };

    function _load(files){
        var cssReg=/\.css(?:\?|$)/i;

        for(var i=files.length-1;i>=0;i--){
            var file=[im.domain,files[i],'?v=',im.version].join('');
            var isCss=cssReg.test(file);

            var node=document.createElement(isCss?'link':'script');
            node.charset='utf-8';

            if(isCss){
                node.rel='stylesheet';
                node.href=file;
            }else{
                node.async=true;
                node.src=file;
            }
            document.getElementsByTagName('head')[0].appendChild(node);
        }
    }

    im.load=function(data){
        $.extend(true,config,data||{});
        window.WEB_SOCKET_SWF_LOCATION=IM.domain+'/Content/dist/WebSocketMainInsecure.swf';
        window.WEB_SOCKET_SUPPRESS_CROSS_DOMAIN_SWF_ERROR=true;
//        window.WEB_SOCKET_DISABLE_AUTO_INITIALIZATION=true;
//        window.WEB_SOCKET_DEBUG = true;
        window.TOOLS_DEBUG=false;
        _load(['Content/dist/gim.min.js','Content/css/base.css','Content/css/im.css']);
    };
})();