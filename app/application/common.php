<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


//返回升级名称
function get_upgrader_name($money){
	$txt="";
	switch ($money) {
		case '30':
			$txt = "1个月VIP会员";
			break;
		case '70':
			$txt = "3个月VIP会员";
			break;
		case '110':
			$txt = "6个月VIP会员";
			break;
		case '180':
			$txt = "12个月VIP会员";
			break;
		case '199':
			$txt = "永久VIP会员";
			break;
	}
	return $txt;
}


function p($data){
	echo "<pre style='color:red'>";print_r($data);echo "<pre>";exit;
}



//判断一个文件大小
function file_size($path){
	if(!is_file($path)){return false;}
	$data = abs(filesize($path));
	$sizeM = $data/1024/1024;
	//$sizeM = sprintf("%.2f",$sizeM);
	return (int)$sizeM."M";
}


function log_data($filename,$data){
    file_put_contents($filename, "当前时间:".date("Y-m-d H:i:s")."\n",FILE_APPEND);
    file_put_contents($filename, "数据:"."\n",FILE_APPEND);
    file_put_contents($filename, print_r($data,true)."\n",FILE_APPEND);
    file_put_contents($filename, "***********************************************\n\n\n",FILE_APPEND);
}
