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
	$res = http_post($apiUrl,$data);
	return json_decode($res,true);
}

function http_post($url,$data){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $res = curl_exec($ch);//halt($res);
    curl_close($ch);
    return $res;
}