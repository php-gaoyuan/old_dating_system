<?php
	header("Content-Type: text/xml;charset=utf-8");
	//告诉浏览器不要缓存数据
	header("Cache-Control: no-cache");
	//获取用户提交城市名
	require("foundation/module_remind.php");
	require("configuration.php");
	require("includes.php");
	$provinceName=$_GET['sheng'];
	dbtarget('r',$dbServs);
	$dbo=new dbex;
	$sql="select wy_country.*,wy_province.* from wy_province left join wy_country on wy_province.cid=wy_country.id where wy_country.cname='{$provinceName}'";
	$province=$dbo->getRs($sql);
	//print_r($province);
	//准备返回xml格式的结果..
		$result="";
		$result="<states>";
		$result.="<city>-省份-</city>";
		
			foreach($province as $p){
				
					$result.="<city>".$p['pname']."</city>";
				
			}
		
		$result.="</states>";
		echo $result;
	exit();
	
	
	
?>