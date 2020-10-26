<?php
require("session_check.php");
require("../api/base_support.php");
//变量区
$id=intval(get_argg('sort_id'));
$type=short_check(get_argg('type_value'));

$dbo = new dbex;
dbtarget('w',$dbServs);

//表定义区
switch($type){
	case "add":
		$name=short_check(get_argp('sort_name'));
		$order_num=intval(get_argp('sort_order'));
		if (empty($name)){
			break;
		}
		$sql_check = "select typename from gift_types where `typename`='$name'";
		$info = $dbo->getRow($sql_check);
		if ($info){			
			break;
		}
		if(function_exists('mb_strlen')){
			if (mb_strlen($name,'utf-8')>15){
				break;
			}
		} else {
			if (strlen($name)>30){
				break;
			}
		}		
		$sql="insert into gift_types(`typename`,`addtime`) value('$name','".time()."')";
		$dbo->exeUpdate($sql);
	break;

	case "del":
		$sql="delete from gift_types where id=$id";
		$dbo->exeUpdate($sql);
	break;

	case "change":
		$name=short_check(get_argp('sort_name'));
		$sql="update gift_types set `typename`='$name' where id=$id";
		$dbo->exeUpdate($sql);
	break;

	default:
	echo "error";
	break;
}

?>