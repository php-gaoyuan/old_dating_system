<?php
	require("foundation/aintegral.php");
	require("api/Check_MC.php");

	//引入语言包
	$mb_langpackage=new msgboardlp;
	$b_langpackage=new bottlelp;

	//变量获得
	$user_id=get_sess_userid();
	$bott_id=trim(get_argg('id'));

	//数据表定义区
	$t_bottle=$tablePreStr."bottle";

	$dbo=new dbex;
	//读写分离定义方法
	dbtarget('r',$dbServs);
	
	$sql="select * from $t_bottle where (from_user_id=$user_id or to_user_id=$user_id) and bott_id=$bott_id";
	
	$oneBottle=$dbo->getRow($sql);
	
	if(empty($oneBottle)){
		action_return(0,$b_langpackage->b_nobottle,"-1");
		exit;
	}
	
	//看看是否主题漂流瓶,如果不是直接删除,否则相关子漂流瓶也删除
	if($oneBottle['bott_reid']=='0'){
		$sons=$dbo->getRs("select bott_id from $t_bottle where bott_reid=".$oneBottle['bott_id']);
		dbtarget('w',$dbServs);
		if(!empty($sons)){
			$sql="delete from $t_bottle where bott_reid=".$oneBottle['bott_id'];
			$dbo->exeUpdate($sql);
		}
		$sql="delete from $t_bottle where bott_id=".$oneBottle['bott_id'];
		
		if($dbo->exeUpdate($sql)){
			action_return(1,$b_langpackage->b_ztbottle1,"-1");
		}else{
			action_return(0,$b_langpackage->b_ztbottle2,"-1");
		}
	}else{
		dbtarget('w',$dbServs);
		$sql="delete from $t_bottle where bott_id=".$oneBottle['bott_id'];
		
		if($dbo->exeUpdate($sql)){
			action_return(1,$b_langpackage->b_dbottle1,"-1");
		}else{
			action_return(0,$b_langpackage->b_dbottle2,"-1");
		}
	}
	
?>
