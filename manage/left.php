<?php
error_reporting(11);
ini_set('display_errors','On'); 

$part_id = $_GET['part_id'];
$default_target = '';

$xml=file_get_contents(dirname(__FILE__)."/menu.xml");
$xmldom=new DOMDocument();
$xmldom->loadXML($xml);


$xpath=new DOMXpath($xmldom);
$part_node=$xpath->Query("/menu/part[@id='$part_id']/item");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" media="all" href="css/admin.css" />
<style type="text/css">html{overflow:hidden;}body{overflow:hidden;}</style>
</head>
<body>
<ul id="submenu" class="submenu">
<?php
foreach($part_node as $rs){
	$is_default = $rs->attributes->item(2)->value;
	if($is_default === 'true')
	{
		$default_target = $rs->attributes->item(1)->value;
	}
	echo '<li '.($is_default === 'true' ? ' class="active" ' : '').' onClick="changeLeftMenu(this);"><a hidefocus="true" href="'.$rs->attributes->item(1)->value.'" target="right">'.$rs->attributes->item(0)->value.'</a></li>';
}
?>
</ul>
<script type="text/javascript" language="javascript">
	parent.document.getElementById('BoardTitle').style.width = '200px';
	parent.document.getElementById('separator').className = 'menu_fold';
	parent.showMenuScrollBar();
	window.parent.frames["right"].location = "<?php echo $default_target;?>";
</script>
<script type="text/javascript" src="js/jy.js"></script>
</body>
</html>