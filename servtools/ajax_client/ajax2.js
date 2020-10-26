function  Ajax(){  
    var _xmlHttp = null;  
 this.createXMLHttpRequest = function(){  
  try{  
   if (window.ActiveXObject) {                                                       
    _xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");                                        
   }                                                                                 
   else if (window.XMLHttpRequest) {                                                     
    _xmlHttp = new XMLHttpRequest();                                                  
   }  
  }catch(e){  
     alert(e.name +" : " + e.message);  
  }  
 }  
   
 this.backFunction = function(_backFunction){  
  if(_xmlHttp.readyState == 4) {  
   if(_xmlHttp.status == 200) {  
    _backFunction(_xmlHttp.responseText);//这里可以设置返回类型  
   }  
  }  
   _xmlHttp.onreadystatechange = null;  
 }  
  
 this.doPost = function(_url,_parameter,_backFunction){  
     try{  
      _xmlHttp.open("POST",_url, false);   
   _xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");  
   _xmlHttp.send(_parameter);   
   }catch(e){  
    alert(e.name +" : " + e.message);  
     }  
 }  
   
 this.doGet = function(_url,_parameter,_backFunction){  
    try{  
        var _random = Math.round(Math.random()*10000);  
        _xmlHttp.open("GET", (_url+"?random=" +_random +"&" + _parameter), false);   
     _xmlHttp.send(null);   
   }catch(e){  
      alert(e.name +" : " + e.message);  
   }  
 }  
   
    this.getInfo = function(_url,_parameter,_method,_backFunction){  
          try{  
            this.createXMLHttpRequest();  
         if(_method.toLowerCase() == "post"){  
            this.doPost(_url,_parameter,_backFunction);  
         }else{  
            this.doGet(_url,_parameter,_backFunction);    
         }  
         try{  
           _xmlHttp.onreadystatechange = this.backFunction(_backFunction);  
         }catch(err){  
            //??????IE?????????????????  
         }  
      }catch(e){  
      alert(e.name +" : " + e.message);  
   }  
     }  
  
}  