//login
function setUserTmpUiid() {
      if(getCookieData("UserIId")!="")
      {  
         document.getElementById("login_email").value=getCookieData("UserIId");
         document.getElementById("tmpiId").checked=true;
      }
}

function getCookieData(label){
  	var labelLen=label.length;
  	var cLen=document.cookie.length;
  	var i=0;
  	var cEnd;
 	while(i<cLen){
 		var j=i+labelLen;
  		if(document.cookie.substring(i,j)==label){
    		cEnd=document.cookie.indexOf(";",j);
    		if(cEnd==-1){
     			cEnd=document.cookie.length;
    		}
    		return document.cookie.substring(j+1,cEnd);
  		}
  		i++
 	}
 	return ""
}

//set

function show_set(value){
	value.setAttribute("class", "set set_hover"); 
}
function hide_set(value){
	value.setAttribute("class", "set set_out"); 
}

//ÇÐ»»tab_js
function tab_tit(index,t,c){
	index = index-1;
	$('.'+t+' li:eq('+index+')').siblings().attr('id','');
	$('.'+t+' li:eq('+index+')').attr('id','cur');

	$('.'+c+' li.li:eq('+index+')').siblings().attr('id','');
	$('.'+c+' li.li:eq('+index+')').attr('id','block');
}

//ÇÐ»»tab_js
function tab_space_tit(index,t,idclass){
	index = index-1;
	$('.'+t+' li:eq('+index+')').siblings().attr('class','');
	$('.'+t+' li:eq('+index+')').attr('class',idclass);
}