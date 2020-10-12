<?php

$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4); //只取前4位，这样只判断最优先的语言。

    if (preg_match("/zh-c/i", $lang)){

		//默认语言包参数

		$langPackagePara="en";

	}else if (preg_match("/zh/i", $lang)){

		$langPackagePara="fanti";//繁体

	}else if (preg_match("/en/i", $lang)){

		$langPackagePara="en";//英语

	}

	else if (preg_match("/fr/i", $lang)){

		$langPackagePara="fa";//法语

	}

	else if (preg_match("/jp/i", $lang)){

		$langPackagePara="ri";//日本语

	}else if (preg_match("/ko/i", $lang)){

		$langPackagePara="han";//韩国语

	}else if (preg_match("/de/i", $lang)){

		$langPackagePara="de";//德语

	}else if (preg_match("/ru/i", $lang)){

		$langPackagePara="e";//俄语

	}else if (preg_match("/es/i", $lang)){

		$langPackagePara="xi";//西班牙

	}else{

		$langPackagePara="en";//默认

	}