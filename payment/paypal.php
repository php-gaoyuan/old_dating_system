<?php
/**
 * 支付宝接口类
 */
class Paypal{
    var $dsql;
    var $mid;
    var $return_url;


    /**
    * 生成支付代码
    * @param   array   $order      订单信息
    * @param   array   $payment    支付方式信息
    */
    function GetCode($order, $payment){
        //$payment = "anniweet@outlook.com";
        $payment="woainizuguo188@163.com";

		//if($order['price']>500)
		//   $payment='1751991229@qq.com';
		//$mess='<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		$mess='<body><form name="paypal" target="_top" action="https://www.paypal.com/cgi-bin/websc" method="post">';
		$mess.='<input type="hidden" name="business" value="'.$payment.'">';
		$mess.='<input type="hidden" name="item_name" value="golds">';
		$mess.='<input type="hidden" name="amount" value="'.$order['price'].'">';
		$mess.='<input type="hidden" name="no_note" value="1">';
		$mess.='<input type="hidden" name="return" value="'.$this->return_url.'&code=paypal">';
		$mess.='<input type="hidden" name="cancel_return" value="http://www.site.com">';
		$mess.='<input type="hidden" name="custom" value="'.$order['out_trade_no'].'">';
		$mess.='<input type="hidden" name="notify_url" value="'.$this->return_url.'&code=paypal">';
		$mess.='<input type="hidden" name="cmd" value="_xclick">';
		$mess.='<input type="hidden" name="currency_code" value="USD">';
		$mess.='<input type="hidden" name="charset" value="utf-8" />';
		$mess.='<input type="hidden" name="cpp_header_image" value="http://www.pauzzz.com/skin/default/zeal/images/logo2.png">';
		$mess.='<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but23.gif" border="0" name="submit" >';
		$mess.='</form><script LANGUAGE="javascript">document.paypal.submit();</script></body>';
        return $mess;
    }







    



    /**
    * 响应操作
    */
    function respond(){
        // read the post from PayPal system and add 'cmd'
        $req = 'cmd=_notify-validate';
        foreach ($_POST as $key => $value) {
			$value = urlencode(stripslashes($value));
			$req .= "&$key=$value";
        }

        // post back to PayPal system to validate
        $header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

        //$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30); // 沙盒用
        $fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30); // 正式用

        // assign posted variables to local variables
        $item_name = $_POST['item_name'];
        $item_number = $_POST['item_number'];
        $payment_status = $_POST['payment_status'];
        $payment_amount = $_POST['mc_gross'];
        $payment_currency = $_POST['mc_currency'];
        $txn_id = $_POST['txn_id'];
        $receiver_email = $_POST['receiver_email'];
        $payer_email = $_POST['payer_email'];
        $mc_gross = $_POST['mc_gross']; // 付款金额
        $custom = $_POST['custom']; // 得到订单号   


        /*if (!$fp) {
			// HTTP ERROR
        } else {
			fputs ($fp, $header . $req);
			while (!feof($fp)) {
				$res = fgets ($fp, 1024);
				if (strcmp ($res, "VERIFIED") == 0) {   */
					$row = $this->dsql->getRow("SELECT * FROM wy_balance WHERE ordernumber = '{$custom}'");
					if($row['state'] == '2' || $row['state'] == 2){
						return true;
					}
					$sql = "UPDATE wy_balance SET `state`='2' WHERE ordernumber = '{$custom}'";
					if($this->dsql->exeUpdate($sql)){
						if(empty($row['touid'])){
							$sql = "UPDATE wy_users SET golds=golds+{$row['funds']} WHERE user_id='{$row[uid]}'";
						}else{
							$sql = "UPDATE wy_users SET golds=golds+{$row['funds']} WHERE user_id='{$row[touid]}'";
						}
						$this->dsql->exeUpdate($sql);
						return true;
					} else {
						return false;
					}
				/*} else if (strcmp ($res, "INVALID") == 0) {
					$sql = "UPDATE wy_balance SET `state`='1' WHERE ordernumber = '{$custom}'";
					$this->dsql->exeUpdate($sql);
					return false;
				}
			}
			fclose ($fp);
       }*/
    }
}//End API