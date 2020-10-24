<?php
namespace payment;
use think\Db;
class Paypal{
	function __construct(){

    }

    function GetCode($order){
    	$payment=config("webconfig.paypal_account");

    	$mess='<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

		$mess.='<body><form name="paypal" target="_top" action="https://www.paypal.com/cgi-bin/websc" method="post">';

		$mess.='<input type="hidden" name="business" value="'.$payment.'">';

		$mess.='<input type="hidden" name="item_name" value="golds">';

		$mess.='<input type="hidden" name="amount" value="'.$order['price'].'">';

		$mess.='<input type="hidden" name="no_note" value="1">';

		$mess.='<input type="hidden" name="return" value="'.$this->return_url.'">';

		$mess.='<input type="hidden" name="cancel_return" value="http://www.site.com">';

		$mess.='<input type="hidden" name="custom" value="'.$order['out_trade_no'].'">';

		$mess.='<input type="hidden" name="notify_url" value="'.$this->return_url.'&code=paypal">';

		$mess.='<input type="hidden" name="cmd" value="_xclick">';

		$mess.='<input type="hidden" name="currency_code" value="USD">';

		$mess.='<input type="hidden" name="charset" value="utf-8" />';

		$mess.='<input type="hidden" name="cpp_header_image" value="'.config("webconfig.pc_url").'skin/default/zeal/images/logo2.png">';

		$mess.='</form><script LANGUAGE="javascript">document.paypal.submit();</script></body>';

        return $mess;

    }




    /**
    * 响应操作
    */

    public function respond(){
    	$header = "";
        $req = 'cmd=_notify-validate';
        foreach ($_POST as $key => $value) {   
			$value = urlencode(stripslashes($value));   
			$req .= "&$key=$value";   
        }
        //halt(input("code"));

           

        // post back to PayPal system to validate   
        $header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";   
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";   
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";   

           

        //$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30); // 沙盒用   
        $fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30); // 正式用   

           

        // assign posted variables to local variables   
        $item_name = input('item_name');
        $item_number = input('item_number');   
        $payment_status = input('payment_status');
        $payment_amount = input('mc_gross');
        $payment_currency = input('mc_currency');   
        $txn_id = input('txn_id');
        $receiver_email = input('receiver_email');
        $payer_email = input('payer_email');
        $mc_gross = input('mc_gross'); // 付款金额   
        $custom = input('custom'); // 得到订单号   

        file_put_contents("paypal_return.txt", var_export(request()->param(),1));

        /*if (!$fp) {   
			// HTTP ERROR   
        } else {   
			fputs ($fp, $header . $req);   
			while (!feof($fp)) {   
				$res = fgets ($fp, 1024);   
				if (strcmp ($res, "VERIFIED") == 0) {   */


					$row = model("Balance")->where(["ordernumber"=>$custom])->find();
					if($row['state'] == '2' || $row['state'] == 2){
						return true;
					}

					//先更新状态
					$res = model("Balance")->where(["ordernumber"=>$custom])->update(["state"=>2]);

					if($res){
						//添加金币
						if(empty($row['touid'])){
							model("Users")->where(["user_id"=>$row["uid"]])->setInc("golds",$row["funds"]);
							//$sql = "UPDATE wy_users SET golds=golds+{$row['funds']} WHERE user_id='{$row[uid]}'";
						}else{
							model("Users")->where(["user_id"=>$row["touid"]])->setInc("golds",$row["funds"]);
							//$sql = "UPDATE wy_users SET golds=golds+{$row['funds']} WHERE user_id='{$row[touid]}'";
						}
						return true;
					} else {
						return false;
					}

				/*}else if (strcmp ($res, "INVALID") == 0) {   
					$sql = "UPDATE wy_balance SET `state`='1' WHERE ordernumber = '{$custom}'";
					$this->dsql->exeUpdate($sql);
					return false;   
				}   
			}   
			fclose ($fp);   
       }*/
    }
}