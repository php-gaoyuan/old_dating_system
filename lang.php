<?php

$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4); //ֻȡǰ4λ������ֻ�ж������ȵ����ԡ�

    if (preg_match("/zh-c/i", $lang)){

		//Ĭ�����԰�����

		$langPackagePara="en";

	}else if (preg_match("/zh/i", $lang)){

		$langPackagePara="fanti";//����

	}else if (preg_match("/en/i", $lang)){

		$langPackagePara="en";//Ӣ��

	}

	else if (preg_match("/fr/i", $lang)){

		$langPackagePara="fa";//����

	}

	else if (preg_match("/jp/i", $lang)){

		$langPackagePara="ri";//�ձ���

	}else if (preg_match("/ko/i", $lang)){

		$langPackagePara="han";//������

	}else if (preg_match("/de/i", $lang)){

		$langPackagePara="de";//����

	}else if (preg_match("/ru/i", $lang)){

		$langPackagePara="e";//����

	}else if (preg_match("/es/i", $lang)){

		$langPackagePara="xi";//������

	}else{

		$langPackagePara="en";//Ĭ��

	}