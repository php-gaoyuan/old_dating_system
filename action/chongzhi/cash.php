<?php 
	//引入公共模块
	require("api/base_support.php");
	$dbo = new dbex;
	dbtarget('w',$dbServs);
	$do_act = isset($_REQUEST['do_act']) ? $_REQUEST['do_act'] : 'display';
	if($do_act = 'save'){
		// $cur_time = strtotime(date("Y-m-d 00:00:00"));
		// $sql = "select * from wy_cash_logs where create_time>'{$cur_time}' order by id desc";
		// $list=$dbo->getALL($sql);
		// echo "<pre>";print_r($list);exit;
		$data = array();
		$data['nickname'] = get_sess_username();
		$data['country'] = $_POST['city'];
		$data['card_num'] = $_POST['card_code'];
		$data['name'] = $_POST['name'];
		$data['golds'] = $_POST['money'];
		$data['create_time'] = time();

		$is_save = true;
		foreach ($data as $k => $val) {
			if(empty($val)){
				$is_save = false;
			}
		}
		if($is_save === false){
			echo "fail";exit;
		}
		$sql = "INSERT INTO wy_cash_logs (`nickname`,`country`,`card_num`,`name`,`golds`,`create_time`) VALUES('{$data["nickname"]}','{$data["country"]}','{$data["card_num"]}','{$data["name"]}','{$data["golds"]}','{$data["create_time"]}')";

		$res = $dbo->exeUpdate($sql);
		if($res!==false){
			echo 'ok';
		}else{
			echo 'fail';
		}
	}
?>