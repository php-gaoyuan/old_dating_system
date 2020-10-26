<?php 
namespace app\common\model;
use think\Model;
class Balance extends Model{
	public function payRecharge($pay_res){
        $order = model("Balance")->where(["ordernumber" => $pay_res['ordernumber']])->find();
        if ($order['state'] == '2' || $order['state'] == 2) {
            return lang("pay_success");
        }
//        if ($pay_res['amount'] != $row['funds']) {
//            return lang("pay_fail");
//        }
        if ($order['state'] != '2') {
            //先更新状态
            $res = $order->save([
                "state" => '2',
                'pay_msg'=>$pay_res['err_msg'],
                'out_trade_no'=>$pay_res['out_trade_no']
            ]);
            if ($res) {
                //添加金币
                if (empty($order['touid'])) {
                    model("Users")->where(["user_id" => $order["uid"]])->setInc("golds", $order["funds"]);
                } else {
                    model("Users")->where(["user_id" => $order["touid"]])->setInc("golds", $order["funds"]);
                }
                return lang("pay_success");
            } else {
                return lang("pay_fail");
            }
        }
    }

    public function payUpgrade(){

    }
}