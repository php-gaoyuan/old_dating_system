<?php
header("content-type:text/html;charset=utf-8");
exit("test");
require("../foundation/asession.php");
require("../configuration.php");
require("../includes.php");
include_once("common.php");
$dbo = new dbex;
dbtarget('w',$dbServs);


$data = array (
    'merchant_id' => '600864',
    'merch_order_ori_id' => 'U1605863040946',
    'merch_order_id' => '20201119230017-R1605798008640',
    'price_currency' => 'USD',
    'price_amount' => '500.00',
    'order_remark' => '',
    'order_id' => '2177418586092560',
    'bill_email' => 'yaohuiliew@gmail.com',
    'status' => 'Y',
    'message' => '',
    'signature' => 'd8a5eabf1710a5a625d41bcbb2ead96d',
);
//根据得到的数据  进行相对应的操作
if($data["status"]=='Y'){
    $merch_order_ori_id=$data['merch_order_ori_id'];
    $result = array(
        'status' => 'success',
        'ordernumber' => $data['merch_order_ori_id'],
        'amount' => $data['price_amount'],
        'out_trade_no' => $data['order_id'],
        'err_msg' => $data['message']
    );
    $sql="SELECT * FROM wy_balance WHERE ordernumber = '{$merch_order_ori_id}'";
    $order=$dbo->getRow($sql,"arr");
    if($order['type'] == 1){
        $payRes = payRecharge($result,$dbo,$paymentlp);
    }elseif($order['type'] == 2){
        $payRes = payUpgrade($result,$dbo,$paymentlp);
    }
    print_r($payRes);exit;
}
