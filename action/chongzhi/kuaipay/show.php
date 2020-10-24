<?php
require("api/base_support.php");
$er_langpackage=new rechargelp;
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en" >
<html>
	<head>
		<title>快钱支付结果</title>
			<meta http-equiv=Content-Type content="text/html;charset=utf-8">
		<style type="text/css">
			td{text-align:center}
		</style>
	</head>
	
<BODY>
	<div align="center">
		<h2 align="center">快钱支付结果页面</h2>
    	<table width="500" border="1" style="border-collapse: collapse" bordercolor="green" align="center">
			<tr>
				<td id="payResult">
					处理结果
				</td>
				<td>
					<?PHP echo $_REQUEST['msg']; ?>
				</td>
			</tr>	
		</table>
	</div>
<?php
sleep(3);
?>
<script type="text/javascript">window.location.href="main.php";</script>
</BODY>
</HTML>