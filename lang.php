<?php
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4); //提取浏览器语言
if (preg_match("/zh-c/i", $lang)) {
    //默认语言
    $langPackagePara = "fanti";
} else if (preg_match("/zh/i", $lang)) {
    $langPackagePara = "fanti"; //中文繁体

} else if (preg_match("/en/i", $lang)) {
    $langPackagePara = "en"; //英文

} else if (preg_match("/fr/i", $lang)) {
    $langPackagePara = "fa"; //法语

} else if (preg_match("/jp/i", $lang)) {
    $langPackagePara = "ri"; //日语

} else if (preg_match("/ko/i", $lang)) {
    $langPackagePara = "han"; //韩语

} else if (preg_match("/de/i", $lang)) {
    $langPackagePara = "de"; //德语

} else if (preg_match("/ru/i", $lang)) {
    $langPackagePara = "e"; //俄语

} else if (preg_match("/es/i", $lang)) {
    $langPackagePara = "xi"; //西班牙语

} else {
    $langPackagePara = "fanti"; //英语

}
