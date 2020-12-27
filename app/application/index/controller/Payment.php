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
}