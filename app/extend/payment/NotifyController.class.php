<?php
namespace Index\Controller;
use Think\Controller;
class NotifyController extends controller {
	public function paypal_notify(){
		//http://www.lover419.com/index.php?m=Index&c=Notify&a=paypal_notify
		
		file_put_contents("paypal_pc_notify.txt", var_export(I("post."),1)."\n\n",FILE_APPEND);
		$post_data = I("post.");
		
		/***********************验证支付****************************/
		if(!empty($post_data)){
			$post_data["cmd"] = "_notify-validate";
		}else{
			return false;
		}
		
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://www.paypal.com/cgi-bin/webscr");
		curl_setopt($ch, CURLOPT_VERBOSE, 1);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		//curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

		$res = curl_exec($ch);
		file_put_contents("paypal_pc_res.txt", var_export($res,1)."\n\n",FILE_APPEND);
		curl_close($ch);
		/***********************验证支付 end****************************/
		
		$order_sn = $post_data["item_number"];//订单号
		$amount = $post_data["mc_gross"];//支付金币
		$payer_id = $post_data["payer_id"];//支付流水号
		$payment_status = $post_data["payment_status"];//支付状态
		$type = $post_data["custom"];//recharge充值update升级
		$correlation_id = $post_data["ipn_track_id"];//支付单号


		if($res===true){
			//支付成功逻辑
			$orderModel = M('order_record');
			$userModel = M('user');
			$webConfModel = M('web_conf');
			$webInfo = $webConfModel->where('id=1')->find();
			$commisionModel = M('commission');

			$where = array("order_sn"=>$order_sn);
			$order = $orderModel->where($where)->find();
			if(empty($order) || $order["pay_status"]=='4'){return false;}

			if(strcmp($payment_status, "Completed") == 0){
				if($amount == $order["amount"]){
					if ($order['goods_type'] == 'recharge') {
						$gold=$userModel->where('id='.$order['gainer'])->getField('gold');
	            		$userId = $order['gainer'];
	            		$newGold = floatval($gold) + floatval($amount);
	            		$goldRecord = M('gold_record');
						$data = array(
								'gold' => $amount,
								'sum' => $newGold,
								'status' => 'success',
								'mark' => '+',
								'type' => 'recharge',
								'updated' => time()
							);
						$goldID = $goldRecord->where('id='.$order['record_id'])->save($data);
						$orderdata = array(
								'payer_id' => $payer_id,
								'correlation_id' => $correlation_id,
				    			'pay_status' => 4,
				    			'record_id' => $goldID,
				    			'updated' => time()
				    		);
						
				    	$res = $orderModel->where($where)->save($orderdata);
				    	if ($res) {
							$paypaldata = array(
									'user_id' => $order['user_id'],
									'gainer' => $order['user_id'],//返给绑定的上级
									'gainer2' => $order['gainer'],//返给绑定的上级
									'type' => 'recharge',
									'amount' => $order['amount'],
									'rate' => $webInfo['paypal_commission'],
									'commision' => $order['amount'] * $webInfo['paypal_commission'] / 100,
									'order_sn' => $order['order_sn'],
									'created' => time()
								);
							//p($paypaldata);
							$result = $commisionModel->add($paypaldata);
				    		$userdata = array(
				    				'gold' => $newGold,
				    				'updated' => time() 
				    			);
				    		$result = $userModel->where('id='.$userId)->save($userdata);
				    	}
					}else if($order["goods_type"] == 'upgrade'){
						$upgradeModel = M('upgrade_record');
						$record_id = $order['record_id'];
						$upgradeRecord = $upgradeModel->where('id='.$record_id)->find();

						if ($upgradeRecord) {
							$updata = array(
									'status' => 'success', 
									'updated' => time() 
								); 
							$res1 =  $upgradeModel->where('id='.$record_id)->save($updata);
						}
				    	$orderdata = array(
				    			'payer_id' => $payer_id,
								'correlation_id' => $correlation_id,
				    			'pay_status' => 4,
				    			'updated' => time()
				    		);
				    	$res2 = $orderModel->where($where)->save($orderdata);
				    	if ($res1 && $res2) {
				    		$paypaldata = array(
									'user_id' => $order['user_id'],
									'gainer' => $order['user_id'],
									'type' => 'upgrade',
									'amount' => $order['amount'],
									'rate' => $webInfo['paypal_commission'],
									'commision' => $order['amount'] * $webInfo['paypal_commission'] / 100,
									'order_sn' => $order['order_sn'],
									'created' => time()
								);
							$goldata = array(
									'user_id' => $order['user_id'],
									'gainer' => $order['gainer'],//返给绑定的上级
									'type' => 'upgrade',
									'amount' => $order['amount'],
									'rate' => $webInfo['consume_commission'],
									'commision' => $order['amount'] * $webInfo['consume_commission'] / 100,
									'order_sn' => $order['order_sn'],
									'created' => time()
								);
							$paypalRes = $commisionModel->add($paypaldata);
							$goldRes = $commisionModel->add($goldata);

				    		$custom = $userModel->where('id='.$upgradeRecord['target_id'])->find();
							$t = time();
							$month = $upgradeRecord['time'];
							if (empty($custom['deadline_1'])) {
								$custom['deadline_1'] = 0;
							}
							if (empty($custom['deadline'])) {
								$custom['deadline'] = 0;
							}
							$level = $upgradeRecord['type_id'];
							if ($custom['deadline_1'] == 0 && $custom['deadline'] == 0) {
								if ($level == 1) {
									$deadline1 = $t + $month*30*24*3600;
									$deadline = 0;
								}elseif ($level == 2) {
									$deadline1 = 0;
									$deadline = $t + $month*30*24*3600;
								}
							}elseif ($custom['deadline_1'] == 0 && $custom['deadline'] != 0) {
								if ($level == 1) {
									$deadline1 = $t + $month*30*24*3600;
									$deadline = $custom['deadline'] + $month*30*24*3600;
								}elseif ($level == 2) {
									$deadline1 = 0;
									$deadline = $custom['deadline'] + $month*30*24*3600;
								}
							}elseif ($custom['deadline_1'] != 0 && $custom['deadline'] == 0) {
								if ($level == 1) {
									$deadline1 = $custom['deadline_1'] + $month*30*24*3600;
									$deadline = 0;
								}elseif ($level == 2) {
									$deadline1 = $custom['deadline_1']+$month*30*24*3600;
									$deadline = $t + $month*30*24*3600;
								}
							}elseif ($custom['deadline_1'] != 0 && $custom['deadline'] != 0) {
								if ($custom['deadline_1'] > $custom['deadline']) {
									$time1 =  $custom['deadline_1'] - $custom['deadline'];
									$time = $custom['deadline'] - $t;
								}else{
									$time1 = $custom['deadline_1'] - $t;
									$time = $custom['deadline'] - $custom['deadline_1'];
								}
								if ($level == 1) {
									$deadline1 = $t + $month*30*24*3600 + $time1;
									$deadline = $deadline1 + $time;
								}elseif ($level == 2) {
									$deadline = $t + $month*30*24*3600 + $time;
									$deadline1 = $deadline + $time1;
								}
							}
							$userdata = array(
									'is_member' => 1,
									'level' => $upgradeRecord['type_id'],
									'deadline_1' => $deadline1,
									'deadline' => $deadline,
									'updated' => $t
								);
				        	$userwhere = array('id' => $upgradeRecord['target_id']);
				        	$result = $userModel->where($userwhere)->save($userdata);
				    	}


					}//支付类型结束
					
				}//对比金额结束
			}//检查支付状态结束

			//验证成功
			echo "success";exit;
		}else{//验证失败
			echo "fail";exit;
		}
	}


	public function new_notify(){
		if (!empty($_GET) && empty($_POST)) {
		    $_POST = $_GET;
		}
		unset($_GET);
		if (empty($_POST)) {
		    die('data error');
		}
		$_GET = $_POST;
		$merchant_id = $_GET ['merchant_id'];
		$merch_order_id = $_GET ['merch_order_id'];
		$price_currency = $_GET ['price_currency'];
		$price_amount = $_GET ['price_amount'];
		$merch_order_ori_id = $_GET ['merch_order_ori_id'];
		$order_id = $_GET ['order_id'];
		$status = $_GET ['status'];
		$message = $_GET ['message'];
		$signature = $_GET ['signature'];


		$hashkey = 'qZoZmoUaaL31DZEzL4XStTmXHttCZdC782acE0asCLBLGKFqlVpJRU4FMAr24sk6i51KYB3T4EqRsKr5WcqdW1qn6EyeIgxkBDCKR4BS1EOmEnmcivg1bgjpOONtdYlX'; // 测试商户证书


		$strVale = $hashkey . $merchant_id . $merch_order_id . $price_currency . $price_amount . $order_id . $status;
		$getsignature = md5 ( $strVale );
		if ($getsignature != $signature) {
			die ( 'Signature error!' );
		}
		//根据得到的数据  进行相对应的操作
		if($status=='Y'){
			$data = array(
				'status'=>$status,
				'order_sn'=>$merch_order_ori_id,
				'amount'=>$price_amount,
				'payer_id'=>$order_id,
				'err_msg'=>$message
			);
			$this->succ_act($data);
			//echo 'ISRESPONSION';
			//echo ('交易成功');//可以跳转到指定的成功页面
			//die;
		}elseif($status=='T'){
			echo 'ISRESPONSION';
			echo ('交易处理中...........');//可以跳转到指定的成功页面
			die;
		}else{
			echo 'ISRESPONSION';
			echo ('交易失败');//可以跳转到指定的成功页面
			die;
		}
	}


	//www.lgomete.com/Index/Notify/succ_act
	private function succ_act($respondData){
		// $respondData = array(
		// 	'order_sn'=>'or_15429550685bf7a03c436d1',
		// 	'amount'=>'500',
		// 	'payer_id'=>'',
		// 	'err_msg'=>''
		// );
		$amount = $respondData['amount'];
		$orderModel = M('order_record');
		$where = array("order_sn"=>$respondData['order_sn']);
		$order = $orderModel->where($where)->find();
		if($order['pay_status'] == '4'){
			$this->error('Do not repeat payment.','/#home',3);
		}



		//查询当前用户金币
		$userModel = M("user");
		$userId = $order['user_id'];
		$gold = $userModel->where('id='.$userId)->getField('gold');

		$webConfModel = M('web_conf');
		$webInfo = $webConfModel->where('id=1')->find();
		$commisionModel = M('commission');


		//判断金额
		if($amount!=$order['amount']){
			$this->error('Pay Fail!','/#home',3);exit;
		}




		$type = $order['goods_type'];
		if($type == 'recharge'){
			//开始分成gaoyuanadd
			$newGold = floatval($gold) + floatval($amount);
    		$goldRecord = M('gold_record');
			$data = array(
					'gold' => $amount,
					'sum' => $newGold,
					'status' => 'success',
					'mark' => '+',
					'type' => 'recharge',
					'updated' => time()
				);
			
			$goldID = $goldRecord->where('id='.$order['record_id'])->save($data);
			$orderdata = array(
					'payer_id' => $respondData['payer_id'],
	    			'pay_status' => 4,
	    			'record_id' => $order['record_id'],
	    			'updated' => time()
	    		);
	    	$res = $orderModel->where($where)->save($orderdata);
	    	if ($res) {
				$paypaldata = array(
						'user_id' => $order['user_id'],
						'gainer' => $order['user_id'],//返给绑定的上级
						'type' => 'recharge',
						'amount' => $order['amount'],
						'rate' => $webInfo['paypal_commission'],
						'commision' => $order['amount'] * $webInfo['paypal_commission'] / 100,
						'order_sn' => $order['order_sn'],
						'created' => time()
					);
				$result = $commisionModel->add($paypaldata);
	    		$userdata = array(
	    				'gold' => $newGold,
	    				'updated' => time() 
	    			);
	    		$result = $userModel->where('id='.$userId)->save($userdata);
	    	}
			$this -> success('pay success!','/#home',3);
			
		}else if($type == 'upgrade'){
			//更新升级记录
			$upgradeModel = M('upgrade_record');
			$record_id = $order['record_id'];
			$upgradeRecord = $upgradeModel->where('id='.$record_id)->find();
			if ($upgradeRecord) {
				$updata = array(
						'status' => 'success', 
						'updated' => time() 
					); 
				$res1 =  $upgradeModel->where('id='.$record_id)->save($updata);
			}

			//更新订单状态
			$orderdata = array(
    			'payer_id' => $respondData['payer_id'],//支付流水号
    			'pay_status' => 4,
    			'updated' => time()
    		);
			//更改订单状态为支付
			$res2 = $orderModel->where($where)->save($orderdata);
			//分成
			if ($res1 && $res2) {
	    		$paypaldata = array(
						'user_id' => $order['user_id'],
						'gainer' => $order['user_id'],
						'type' => 'upgrade',
						'amount' => $order['amount'],
						'rate' => $webInfo['paypal_commission'],
						'commision' => $order['amount'] * $webInfo['paypal_commission'] / 100,
						'order_sn' => $order['order_sn'],
						'created' => time()
					);
				$goldata = array(
						'user_id' => $order['user_id'],
						'gainer' => $order['gainer'],//返给绑定的上级
						'type' => 'upgrade',
						'amount' => $order['amount'],
						'rate' => $webInfo['consume_commission'],
						'commision' => $order['amount'] * $webInfo['consume_commission'] / 100,
						'order_sn' => $order['order_sn'],
						'created' => time()
					);
				$paypalRes = $commisionModel->add($paypaldata);
				$goldRes = $commisionModel->add($goldata);


				// 查找被充值用户的会员信息
				$custom = $userModel->where('id='.$upgradeRecord['target_id'])->find();
				$t = time();
				if (empty($custom['deadline_1'])) {
					$custom['deadline_1'] = 0;
				}
				if (empty($custom['deadline'])) {
					$custom['deadline'] = 0;
				}
				if ($custom['deadline_1'] == 0 && $custom['deadline'] == 0) {
					if ($level == 1) {
						$deadline1 = $t + $month*30*24*3600;
						$deadline = 0;
					}elseif ($level == 2) {
						$deadline1 = 0;
						$deadline = $t + $month*30*24*3600;
					}
				}elseif ($custom['deadline_1'] == 0 && $custom['deadline'] != 0) {
					if ($level == 1) {
						$deadline1 = $t + $month*30*24*3600;
						$deadline = $custom['deadline'] + $month*30*24*3600;
					}elseif ($level == 2) {
						$deadline1 = 0;
						$deadline = $custom['deadline'] + $month*30*24*3600;
					}
				}elseif ($custom['deadline_1'] != 0 && $custom['deadline'] == 0) {
					if ($level == 1) {
						$deadline1 = $custom['deadline_1'] + $month*30*24*3600;
						$deadline = 0;
					}elseif ($level == 2) {
						$deadline1 = $custom['deadline_1']+$month*30*24*3600;
						$deadline = $t + $month*30*24*3600;
					}
				}elseif ($custom['deadline_1'] != 0 && $custom['deadline'] != 0) {
					if ($custom['deadline_1'] > $custom['deadline']) {
						$time1 =  $custom['deadline_1'] - $custom['deadline'];
						$time = $custom['deadline'] - $t;
					}else{
						$time1 = $custom['deadline_1'] - $t;
						$time = $custom['deadline'] - $custom['deadline_1'];
					}
					if ($level == 1) {
						$deadline1 = $t + $month*30*24*3600 + $time1;
						$deadline = $deadline1 + $time;
					}elseif ($level == 2) {
						$deadline = $t + $month*30*24*3600 + $time;
						$deadline1 = $deadline + $time1;
					}
				}
				//增加用户到期时间
				$userdata = array(
						'is_member' => 1,
						'level' => $upgradeRecord['type_id'],
						'deadline_1' => $deadline1,
						'deadline' => $deadline,
						'updated' => $t
					);
	        	$userwhere = array('id' => $upgradeRecord['target_id']);
	        	$result = $userModel->where($userwhere)->save($userdata);
			}
			
			$this -> success("pay success!",'/#home',3);
		}else{
			$this -> error(L('error')."：".$respondData['err_msg'],'/#home',3);
		}
	}
}