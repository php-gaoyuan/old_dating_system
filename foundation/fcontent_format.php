<?php
//获得文本部分内容
function get_lentxt($txtstr,$maxlen=180){
	$txtstr=strip_tags($txtstr);
	if(strlen($txtstr) > $maxlen){
	  return sub_str(filt_word($txtstr),$maxlen).'...';
	}else{
	  return filt_word($txtstr);
	}
}

function is_utf8($word){
	if(preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$word) == true){
		return true;
	}else{
		return false;
	}
}

//格式化日期文本函数
function format_datetime_txt($event_time){
	global $langPackagePara;
  $nyear=date("Y", time());
  $nmonth=date("m", time());
  $nday=date("d", time());
  $nhour=date("H", time());
  $nminute=date("i", time());

  $etimeArr=explode('-',$event_time);
  $eyear=$etimeArr[0];
  $emonth=$etimeArr[1];
  $etimeArr2=explode(' ',$etimeArr[2]);
  $eday=$etimeArr2[0];
  $etimeArr3=explode(':',$etimeArr2[1]);
  $ehour=$etimeArr3[0];
  $eminute=$etimeArr3[1];
  $tmpStr='';
  if(time()-strtotime($event_time) >= 60*60*24*365){
	  if($langPackagePara=='zh')
		  $tmpStr=$eyear."年".$emonth."月";
	  else
		  $tmpStr=$eyear."-".$emonth;
  }else{
		if(time()-strtotime($event_time) < 60*60){
			if($langPackagePara=='zh')
			{
				$tmpStr=intval((time()-strtotime($event_time))/60);
				$tmpStr=empty($tmpStr) ? 1:$tmpStr;
				$tmpStr=intval($tmpStr)."分钟前";
			}
			else
				$tmpStr=$ehour.":".$eminute;
		}
		elseif(time()-strtotime($event_time) < 60*60*9 && time()-strtotime($event_time) >= 60*60){
			if($langPackagePara=='zh')
			  $tmpStr=intval((time()-strtotime($event_time))/(60*60))."小时前";
			else
			  $tmpStr=$ehour.":".$eminute;
		}
		elseif(strtotime($nyear."-".$nmonth."-".$nday) - strtotime($eyear."-".$emonth."-".$eday) < 60*60*24  && time()-strtotime($event_time) >= 60*60*9){
			if($langPackagePara=='zh')
			  $tmpStr="今天".$ehour."时".$eminute."分";
			else
			  $tmpStr="Today".$ehour.":".$eminute.":";
		}
		elseif(strtotime($nyear."-".$nmonth."-".$nday) - strtotime($eyear."-".$emonth."-".$eday) >= 60*60*24 && strtotime($nyear."-".$nmonth."-".$nday) - strtotime($eyear."-".$emonth."-".$eday) < 60*60*24*2){
			if($langPackagePara=='zh')
			  $tmpStr="昨天".$ehour."时".$eminute."分";
			else
			  $tmpStr="yesterday".$ehour.":".$eminute.":";
		}
		elseif(strtotime($nyear."-".$nmonth."-".$nday) - strtotime($eyear."-".$emonth."-".$eday) < 60*60*24*3 && strtotime($nyear."-".$nmonth."-".$nday) - strtotime($eyear."-".$emonth."-".$eday) >= 60*60*24*2){
			if($langPackagePara=='zh')
			  $tmpStr="前天".$ehour."时".$eminute."分";
			else
			  $tmpStr=$emonth."/".$eday." ".$ehour.":".$eminute.":";
		}
		else{
			if($langPackagePara=='zh')
			  $tmpStr=$emonth."月".$eday."日";
			else
			  $tmpStr=$emonth."-".$eday;
		}
	}
	return $tmpStr;
}

//格式化日期文本函数(短的)
function format_datetime_short($event_time){
	global $langPackagePara;
  $nyear=date("Y", time());
  $nmonth=date("m", time());
  $nday=date("d", time());
  $nhour=date("H", time());
  $nminute=date("i", time());

  $etimeArr=explode('-',$event_time);
  $eyear=$etimeArr[0];
  $emonth=$etimeArr[1];
  $etimeArr2=explode(' ',$etimeArr[2]);
  $eday=$etimeArr2[0];
  $etimeArr3=explode(':',$etimeArr2[1]);
  $ehour=$etimeArr3[0];
  $eminute=$etimeArr3[1];
  $tmpStr='';
  if(time()-strtotime($event_time) >= 60*60*24*365){
	if($langPackagePara=='zh')
	  $tmpStr=$eyear."年".$emonth."月";
	else
	  $tmpStr=$eyear."-".$emonth;
  }else{
		if(time()-strtotime($event_time) < 60*60){
			if($langPackagePara=='zh')
			{
				$tmpStr=intval((time()-strtotime($event_time))/60);
				$tmpStr=empty($tmpStr) ? 1:$tmpStr;
				$tmpStr=intval($tmpStr)."分钟前";
			}
			else
				$tmpStr=$ehour.":".$eminute;
		}
		elseif(time()-strtotime($event_time) < 60*60*9 && time()-strtotime($event_time) >= 60*60){
			if($langPackagePara=='zh')
			  $tmpStr=intval((time()-strtotime($event_time))/(60*60))."小时前";
			else
			  $tmpStr=$ehour.":".$eminute;
		}
		elseif(strtotime($nyear."-".$nmonth."-".$nday) - strtotime($eyear."-".$emonth."-".$eday) < 60*60*24  && time()-strtotime($event_time) >= 60*60*9){
			if($langPackagePara=='zh')
			  $tmpStr="今天";
			else
			  $tmpStr="Today";
		}
		elseif(strtotime($nyear."-".$nmonth."-".$nday) - strtotime($eyear."-".$emonth."-".$eday) >= 60*60*24 && strtotime($nyear."-".$nmonth."-".$nday) - strtotime($eyear."-".$emonth."-".$eday) < 60*60*24*2){
			if($langPackagePara=='zh')
			  $tmpStr="昨天";
			else
			  $tmpStr="yesterday";
		}
		elseif(strtotime($nyear."-".$nmonth."-".$nday) - strtotime($eyear."-".$emonth."-".$eday) < 60*60*24*3 && strtotime($nyear."-".$nmonth."-".$nday) - strtotime($eyear."-".$emonth."-".$eday) >= 60*60*24*2){
			if($langPackagePara=='zh')
			  $tmpStr="前天";
			else
			  $tmpStr=$emonth."-".$eday."-";
		}
		else{
			if($langPackagePara=='zh')
			  $tmpStr=$emonth."月".$eday."日";
			else
			  $tmpStr=$emonth."-".$eday;
		}
	}
	return $tmpStr;
}

function leave_time($date_value,$life_time){
	if(preg_match("/\d{4}-\d{2}-\d{2}/",$date_value)){
		$date_value=strtotime($date_value);
	}
	$life_sec=$life_time*60*60;
	$time=time();
	$pass_sec=$time-$date_value;
	if($pass_sec >= $life_sec){
		return '已过期';
	}else{
		$leave_sec=$life_sec-$pass_sec;
		return conver_time($leave_sec);
	}
}

function conver_time($second){
	global $langPackagePara;
	$result_str='';
	$leave_time='';
	$leave_time=$leave_time ? $leave_time:$second;
	if($leave_day=floor($leave_time/(3600*24))){
		$leave_time=$leave_time-($leave_day*3600*24);
		if($langPackagePara=='zh')
			$result_str.=$leave_day.'天';
		else
			$result_str.=$leave_day.'days';
	}
	$leave_time=$leave_time ? $leave_time:$second;
	if($leave_hour=floor($leave_time/3600)){
		$leave_time=$leave_time-($leave_hour*3600);
		if($langPackagePara=='zh')
			$result_str.=$leave_hour.'小时';
		else
			$result_str.=$leave_hour.'hours ';
	}
	$leave_time=$leave_time ? $leave_time:$second;
	if($leave_min=floor($leave_time/60)){
		$leave_time=$leave_time-($leave_min*60);
		if($langPackagePara=='zh')
			$result_str.=$leave_min.'分钟';
		else
			$result_str.=$leave_min.'minutes';
	}
	if($leave_time==$second){
		if($langPackagePara=='zh')
			$result_str='1分钟以内';
		else
			$result_str='Within 1 minute';
	}
	return $result_str;
}

function info_item_format($defaultTxt,$inputTxt){
    if($inputTxt!=''){
    	 return $inputTxt;
    }else{
    	 return $defaultTxt;
    }
}

function brithday_format($y,$m,$d){
	global $langPackagePara;
	$tmp='';
    if($y!=''){
		if($langPackagePara=='zh')
		  $tmp=$y."年";
		else
		  $tmp=$y;
    }
    if($m!=''){
		if($langPackagePara=='zh')
		  $tmp=$tmp.$m."年";
		else
		  $tmp=$tmp.$m;
    }
    if($d!=''){
		if($langPackagePara=='zh')
		  $tmp=$tmp.$d."日";
		else
		  $tmp=$tmp.$d;
    }
    return $tmp;
}

function radio_checked($input_val,$rs_val){
	if($input_val==$rs_val){
	  return ' checked ';
	}
}

//列表控制
$def_show_list=0;
function newline($num){
	global $def_show_list;
	if($def_show_list%$num==0){
		if($def_show_list>0){ echo "</div>"; }
		echo "<div style='clear:both'>";
	}
	$def_show_list++;
}

//取得后缀名
function get_ext($file_name)
{
	$extend=explode("." , $file_name);
	$va=count($extend)-1;
	$ext_name=trim($extend[$va]);

	return $ext_name;
}
?>