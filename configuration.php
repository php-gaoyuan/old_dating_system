<?php
//error_reporting(E_ALL || ~E_NOTICE);
error_reporting(0);
//判断浏览器语言
include "lang.php";

//配置信息
$webRoot = strtr(dirname(__FILE__), "\\", "/") . "/";
$metaDesc = "dsrramtcys－亞洲最大的跨語言愛情在綫互動交友公寓網站,love makes through games, shares interests and hobbies, friends advice, you browse the personal data and more way to get to know and make new friends. It is an international dating service";
$metaKeys = "single girls,Single dating,Dating site, free personals,lovelove國際交友,亞洲交友,海外交友";
$metaAuthor = "";
$siteName = "dsrramtcys亚洲国际交友中心网站－You match with single girls by dating_单身男女的爱情公寓";
$copyright = "CopyRight 2017 dsrramtcys 2.0";
$domainRemark = "";
$offLine = 0;
$adminEmail = "";

$siteDomain = "https://{$_SERVER['HTTP_HOST']}/";

$skinUrl = "default/jooyea";

$tplAct = "default";

$compileType = "serve";

$indexFile = "index.php";

$urlRewrite = 0;

$inviteCode = 0;

$inviteCodeLength = 8;

$inviteCodeValue = 1;

$allowReg = 1;

$inviteCodeLife = 72;

$mailCodeLifeDay = 7;

$mailCodeLifeHour = 0;

$mailActivation = 0;

define('ROOT', $webRoot);

//时区设置

date_default_timezone_set("Asia/Shanghai");

//当前时间

defined('NOWTIME') or define('NOWTIME', date('Y-m-d H:i:s', time()));

//支持库配置

$baseLibsPath = "iweb_mini_lib/";

//防刷新时间设置,只限制insert动作.单位:秒

$allowRefreshTime = 5;

//超限系统延时设置,单位:秒

$delayTime = 5;

//开启缓存

$ctrlCache = 0;

//缓存更新延时设置,单位为秒

$cache_update_delay_time = 20;

//出生年份范围

$setMinYear = 1850;

$setMaxYear = 2016;

//站点调试信息设置

ini_set("display_errors", 1);

//站点关闭提示信息

$offlineMessage = "本网站目前正在维护中,请稍后再来访问!";

//分页数据量

$cachePages = 10;

//限制访问的时间段

$limit_guest_time = "";

//限制交互时间段

$limit_action_time = "";

//限制访问的ip列表

$limit_ip_list = array();

//主页显示动态条数

$homeAffairNum = 5;

//首页显示动态人数

$mainAffairNum = 5;

//是否开启过滤

$wordFilt = 1;

//敏感词过滤

$filtrateStr = "草,你妹,日你,共产党,政府,myloveyou011,yahoo,gagamatch,aydate,momo,陌陌,雅虎通,yahoo通,msn,feelmuch live,zestlove gagahi  mateloving";

//cookie开启校验

$cookieOpen = 1;

//session前缀

global $session_prefix;

$session_prefix = "isns_";

//plugins位置文件

$pluginOpsition = array("home.html", "index.html", "main.html", "modules/blog/blog_edit.html");

?>