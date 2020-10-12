<?php
	header("Content-Type: text/xml;charset=utf-8");
	//告诉浏览器不要缓存数据
	header("Cache-Control: no-cache");
	//获取用户提交城市名
	require("foundation/module_remind.php");
	require("configuration.php");
	require("includes.php");
	$cityName=$_GET['citys'];
	//echo $cityName;
	

	//print_r($pid);exit;
	$result="<states><city>11111</city></states>";
	
	dbtarget('r',$dbServs);
	$dbo=new dbex;
	$sql="select wy_city.*,wy_province.* from wy_city left join wy_province on wy_city.pid=wy_province.id where wy_province.pname='{$cityName}'";
	$province=$dbo->getRs($sql);
	//print_r($province);
	//准备返回xml格式的结果..
		$result="";
		$result="<states>";
		$result.="<citys>-城市-</citys>";
		
			foreach($province as $p){
				
					$result.="<citys>".$p['name']."</citys>";
				
			}
		
		$result.="</states>";

		echo $result;
	exit();

	
	
?>