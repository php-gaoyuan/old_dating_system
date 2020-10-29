<?php 
namespace app\index\controller;
use think\Controller;
use think\Db;
class Payment extends Controller{
	public function notityUrl(){
		file_put_contents("paypal_wap_notify.txt", var_export(input("post."),1)."\n\n",FILE_APPEND);
		$code = input("code");
		if($code == "paypal"){
			//paypal支付
			$post_data = input("post.");

			$res = http_post("https://www.paypal.com/cgi-bin/webscr", $post_data);



			$ordernumber = isset($post_data["item_number"]) ? $post_data["item_number"]: "";//订单号
			$amount = isset($post_data["mc_gross"]) ? $post_data["mc_gross"] : "";//支付金币
			// $payer_id = $post_data["payer_id"];//支付流水号
			// $payment_status = $post_data["payment_status"];//支付状态
			// $type = $post_data["custom"];//recharge充值update升级
			// $correlation_id = $post_data["ipn_track_id"];//支付单号

			

			//支付验证成功
			if($res===true){
				$row = model("Balance")->where(["ordernumber"=>$ordernumber])->find();
				if(empty($row)){exit("fail");}
				
				if($row['state'] == '2' || $row['state'] == 2){
					exit("success");
				}
				if($amount != $row["funds"]){
					exit("fail");
				}

				//先更新状态
				$res = model("Balance")->where(["ordernumber"=>$ordernumber])->update(["state"=>2]);
				if($res){
					//添加金币
					if(empty($row['touid'])){
						model("Users")->where(["user_id"=>$row["uid"]])->setInc("golds",$row["funds"]);
						//$sql = "UPDATE wy_users SET golds=golds+{$row['funds']} WHERE user_id='{$row[uid]}'";
					}else{
						model("Users")->where(["user_id"=>$row["touid"]])->setInc("golds",$row["funds"]);
						//$sql = "UPDATE wy_users SET golds=golds+{$row['funds']} WHERE user_id='{$row[touid]}'";
					}
					exit("success");
				} else {
					exit("fail");
				}
			}else{
				exit("fail");
			}
			
		}
	}


	public function returnUrl(){
		$code = input("code");
		if($code == "paypal"){
			//http://www.lover419.com/index.php?m=Index&c=Pay&a=paypal_return
			file_put_contents("paypal_wap_return.txt", var_export(input("get."),1)."\n\n",FILE_APPEND);
			$data = input("get.");

			if($data["st"] == "Completed"){
				echo "<script>alert('Pay Success');location.href='/';</script>";
			}else{
				echo "<script>alert('Pay fail');location.href='/';</script>";
			}
			exit();			
		}
	}


	public function newpay_fail(){
		$msg = input("message");
		echo "<script>alert('Pay Fail:".$msg."');window.location.href='/';</script>";exit;
	}
}