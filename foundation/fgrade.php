<?php
//引入语言包
$fd_langpackage=new foundationlp;
//等级换算
function grade($integral){
	global $skinUrl;
	global $int_convert;
	global $int_upgrade;

	$integral=(int)$integral;

	if( $int_convert > $integral){
		echo "<img src='skin/$skinUrl/images/star.gif' />";
	}else{
		$level=0;
		for($i=1;$i<$i+1;$i++)
		{
			$sum=1;
			for($j=0;$j<3;$j++)
			{
				$sum=$sum*$i;
			}

			if($integral<$sum)
			{
				$level=$i-1;
				break;
			}
			else if($integral==$sum)
			{
				$level=$i;
				break;
			}
		}
		up_level($level);
	}
}

function up_level($integral){
	global $int_convert;
	global $int_upgrade;
	global $skinUrl;

	if($integral >= $int_upgrade*$int_upgrade ){
		echo "<img src='skin/$skinUrl/images/sun.gif' />";
		up_level($integral-$int_upgrade*$int_upgrade);
	}else{
		if($integral >= $int_upgrade){
			echo "<img src='skin/$skinUrl/images/moon.gif' />";
			up_level($integral - $int_upgrade);
		}else{
			if( $integral >= 1 ){
				echo "<img src='skin/$skinUrl/images/star.gif' />";
				up_level($integral - 1);
			}else{
				return NULL;
			}
		}
	}
}

function count_level($integral){
	global $int_convert;
	global $fd_langpackage;
	if($integral < $int_convert){
		$level=ceil($integral/$int_convert);
	}else{
		//$level=floor($integral/$int_convert);
		$level=0;
		for($i=1;$i<$i+1;$i++)
		{
			$sum=1;
			for($j=0;$j<3;$j++)
			{
				$sum=$sum*$i;
			}

			if($integral<$sum)
			{
				$level=$i-1;
				break;
			}
			else if($integral==$sum)
			{
				$level=$i;
				break;
			}
		}
	}
	return $fd_langpackage->fd_grade."：".$level;
}
function count_level2($integral){
	global $int_convert;
	global $fd_langpackage;
	if($integral < $int_convert){
		$level=ceil($integral/$int_convert);
	}else{
		//$level=floor($integral/$int_convert);
		$level=0;
		for($i=1;$i<$i+1;$i++)
		{
			$sum=1;
			for($j=0;$j<3;$j++)
			{
				$sum=$sum*$i;
			}

			if($integral<$sum)
			{
				$level=$i-1;
				break;
			}
			else if($integral==$sum)
			{
				$level=$i;
				break;
			}
		}
	}
	return $level;
}

?>