<?php
function halt($data=[]){
    echo "<pre style='color:red'>";
    print_r($data);
    exit("</pre>");
}
function json($data=array()){
    header('content-type:application/json;charset=utf-8');
    return json_encode($data);
}

function getAddressByIp($ip=""){
	$ip = !empty($ip)?$ip:"myip";
	$apiUrl = "http://ip.taobao.com/outGetIpInfo";
	$data = [
		"ip"=>$ip,
		"accessKey"=>"alibaba-inc",
	];
	$res = http_post($url,$data);
	return json_decode($res,true);
}

function http_post($url, $data)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL ,$url);
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_REFERER,$website);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
    $data = curl_exec($ch);
    if($data === false){
        echo 'Curl error: ' . curl_error($ch);
    }
    curl_close($ch);
    return $data;
}