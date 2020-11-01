<?php
function halt($data = [])
{
    echo "<pre style='color:red'>";
    print_r($data);
    exit("</pre>");
}

function json($data = array())
{
    header('content-type:application/json;charset=utf-8');
    return json_encode($data);
}

function getAddressByIp($ip = "")
{
    $ip = !empty($ip) ? $ip : "myip";
    $apiUrl = "http://ip.taobao.com/outGetIpInfo";
    $data = [
        "ip" => $ip,
        "accessKey" => "alibaba-inc",
    ];
    $res = http_post($apiUrl, $data);
    return json_decode($res, true);
}

function http_post($url, $data)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $res = curl_exec($ch);//halt($res);
    curl_close($ch);
    return $res;
}


function is_ajax(){
    if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == 'xmlhttprequest') {
        // 是ajax请求
        return true;
    } else {
        // 不是ajax请求
        return false;
    }
}

function is_post(){
    //判断form数据是否为POST而来，判断数据提交方式
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        return false;
    } else {
        return true;
    }
}