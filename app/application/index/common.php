<?php 
function getUid(){
    $user_id=0;
    if(cookie("?user_id")){
        $user_id = cookie("user_id");
    }else{
        $user_id = session("user_id");
    }
    return $user_id;
}
function return_json($code=0,$data=[],$msg="",$url=""){
	return json(["code"=>$code,"data"=>$data,"msg"=>$msg,"url"=>$url]);
}

function return_json_error($msg="",$url="",$code=1){
	return return_json($code,[],$msg,$url);
}

function return_json_success($msg="",$data="",$url=""){
	return return_json(0,$data,"",$url);
}

//组装图片的全路径
function img_path($path, $user_sex=false){
    if(empty($path)){
        if($user_sex === false){
            $user_sex = session("userinfo.user_sex");
        }
        return "/public/static/default/imgs/d_ico_{$user_sex}.gif";
    }else{
        if(strpos($path, "http") !== false){
            return $path;
        }else{
            return config("webconfig.pc_url").$path;
        }
    }
}

function img_add_pcUrl($path){
    if(strpos($path, "http") === false){
        return config("webconfig.pc_url").$path;
    }
    return $path;
}

//正则匹配出图片
function img_add_url($content){
    $content = str_replace("src=\"", "src=\"".config("webconfig.pc_url"), $content);
    return $content;
}


function empty_userico($user_sex){
    return "/public/static/default/imgs/d_ico_{$user_sex}.gif";
}


/** 
 * 计算几分钟前、几小时前、几天前、几月前、几年前。 
 * $agoTime string Unix时间 
 * @author tangxinzhuan 
 * @version 2016-10-28 
 */  
function time_ago($agoTime)  
{  
    $agoTime = (int)$agoTime;  
      
    // 计算出当前日期时间到之前的日期时间的毫秒数，以便进行下一步的计算  
    $time = time() - $agoTime;  
      
    if ($time >= 31104000) { // N年前  
        $num = (int)($time / 31104000);  
        return $num.'年前';  
    }  
    if ($time >= 2592000) { // N月前  
        $num = (int)($time / 2592000);  
        return $num.'月前';  
    }  
    if ($time >= 86400) { // N天前  
        $num = (int)($time / 86400);  
        return $num.'天前';  
    }  
    if ($time >= 3600) { // N小时前  
        $num = (int)($time / 3600);  
        return $num.'小时前';  
    }  
    if ($time > 60) { // N分钟前  
        $num = (int)($time / 60);  
        return $num.'分钟前';  
    }  
    return '1分钟前';  
} 



//二维数组在头部加入元素
function array_unshift2($arr,$val){
    $data=array($val);
    foreach ($arr as $key => $value) {
        $data[] = $value;
    }

    return $data;
}



//判断用户终端
function get_device_type(){
    $agent=strtolower($_SERVER['HTTP_USER_AGENT']);
    $type = 'other';

    if(strpos($agent, 'iphone') || strpos($agent, 'ipad') ){
        $type = 'ios' ;
    } 

    if(strpos($agent, 'android')){
        $type= 'android' ;
    }
    
    return $type; 
}




//保存64位编码图片
function saveBase64Image($base64_image_content, $path){
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
        //图片后缀
        $type = $result[2];

        //保存位置--图片名
        $dir = ROOT_PATH.$path.date('Ymd').'/';
        $image_name=date('His').str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT).".".$type;
        $image_url = $dir.$image_name; 
        //halt($image_url);          
        if(!is_dir($dir)){
            mkdir($dir);
            chmod($dir, 0777);
            //umask($oldumask);//用于linux
        }


        //解码
        $decode=base64_decode(str_replace($result[1], '', $base64_image_content));

        if (file_put_contents($image_url, $decode)){
            $image_url = str_replace("../", "", $image_url);
            $data['code']=0;
            $data['imageName']=$image_name;
            $data['url']=$image_url;
            $data['msg']='保存成功！';
        }else{
            $data['code']=1;
            $data['imgageName']='';
            $data['url']='';
            $data['msg']='图片保存失败！';
        }
    }else{
        $data['code']=1;
        $data['imgageName']='';
        $data['url']='';
        $data['msg']='base64图片格式有误！';
    }
    return $data;
}


//判断是否是Html5Plus环境下
function is_h5_plus(){
    $agent = $_SERVER['HTTP_USER_AGENT'];
    if(strpos($agent,"Html5Plus") === false){
        return false;
    }else{
        return true;
    }
}


function http_post($url,$data){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $res = curl_exec($ch);//halt($res);
    curl_close($ch);
    return $res;
}







