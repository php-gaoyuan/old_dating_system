<?php
namespace app\index\controller;
use app\common\model\Balance;
use app\common\model\UpgradeLog;

class Payment extends Base
{
    public function index($pay_method,$pay_type,$oid,$am){
        $this->assign("order",compact("pay_type","oid","am"));
        return $this->fetch($pay_method);
    }

    public function pay($oid){
        $order = (new Balance())->where(["ordernumber"=>$oid])->find();
        if(!empty($order['pay_userinfo'])){
            echo "<script>alert('不要重複提交訂單(Do not repeat orders)');window.location.href='/';</script>";exit;
        }
        (new Balance)->where(['ordernumber'=>$order['ordernumber']])->update(['pay_userinfo'=>json_encode(input("post."),JSON_UNESCAPED_UNICODE)]);



        $payMethod = "\\payment\\".ucfirst($order['pay_method']);
        $payObj = new $payMethod();
        if($order['pay_method']=="lianyin"){
            $pay_type = input("pay_type",1,"intval");
            //halt($pay_type);
            $payRes = $payObj->pay($order,$pay_type);
        }elseif($order['pay_method']=="lianyin"){
            $payObj->pay($order);exit;
        }else{
            $payRes = $payObj->pay($order);
        }

        //halt($payRes);

        if(isset($payRes['status']) && $payRes['status']=="success"){
            if($order->type==1){
                $res = (new Balance())->payRecharge($payRes);
            }elseif($order->type==2){
                $res = (new UpgradeLog())->upgrade_change_date($payRes);
                if($res!==false){
                    $res = lang('pay_success') ;
                }else{
                    $res = lang('pay_fail') ;
                }
            }
        }else{
            $res = lang('pay_fail').":".$payRes;
        }
        echo "<script>alert('{$res}');window.history.back();</script>";exit;
    }

    public function notifyUrl(){
        file_put_contents("ipasspay_notify.log",date("Y-m-d H:i:s").PHP_EOL.var_export($_POST,true).PHP_EOL,FILE_APPEND);
        $code = input("code");
        $payMethod = "\\payment\\".ucfirst($code);
        $payObj = new $payMethod();
        $res = $payObj->notify();
        if($res){
//            $result = array(
//                'status' => 'success',
//                'ordernumber' => $order_no,
//                'amount' => $order_amount,
//                'out_trade_no' => $gateway_order_no,
//                'err_msg' => $request_data['errmsg']
//            );
//            $sql = "SELECT * FROM wy_balance WHERE ordernumber = '{$order_no}'";
//            $order = $dbo->getRow($sql, "arr");
//            if ($order['type'] == 1) {
//                $payRes = payRecharge($result, $dbo, $paymentlp);
//            } elseif ($order['type'] == 2) {
//                $payRes = payUpgrade($result, $dbo, $paymentlp);
//            }
        }
    }
    public function returnUrl(){
        file_put_contents("ipasspay_return.log",date("Y-m-d H:i:s").PHP_EOL.var_export($_GET,true).PHP_EOL,FILE_APPEND);
        $errmsg = $_GET['errmsg'];
        echo "<script>alert('{$errmsg}');location.href='/';</script>";
    }
}