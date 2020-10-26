//好友相关函数
function addFriend(uid){
	$.get("/index/main/addFriend",{uid:uid},function(res){
		alert(res);
	});
}

//替换字符
function replaceAll(str,s1,s2) {
    while( str.indexOf(s1) != -1 ) {
        str = str.replace(s1,s2); 
    } 
    return str;
}

//设置cookie  
function setCookie(cname, cvalue, exdays) {  
    var d = new Date();  
    d.setTime(d.getTime() + (exdays*24*60*60*1000));  
    var expires = "expires="+d.toUTCString();  
    document.cookie = cname + "=" + cvalue + "; " + expires + ";path=/";  
}  
//获取cookie  
function getCookie(cname) {  
    var name = cname + "=";  
    var ca = document.cookie.split(';');  
    for(var i=0; i<ca.length; i++) {  
        var c = ca[i];  
        while (c.charAt(0)==' ') c = c.substring(1);  
        if (c.indexOf(name) != -1) return c.substring(name.length, c.length);  
    }  
    return "";  
} 

//清除cookie    
function delCookie(name) {    
    setCookie(name, "", -1);    
} 