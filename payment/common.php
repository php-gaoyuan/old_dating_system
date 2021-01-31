<?php
//处理充值逻辑
function payRecharge($data,$dbo,$paymentlp){
    $sql = "SELECT * FROM wy_balance WHERE ordernumber = '{$data['ordernumber']}'";
    $order = $dbo->getRow($sql,"arr");
    if(empty($order)){
        return $paymentlp->msg_noorder;
    }
    if ($order['state'] == 2) {
        return $paymentlp->msg_paied;
    }

    if ($order['state'] != '2') {
        $sql = "UPDATE wy_balance SET `state`='2',`out_trade_no`='{$data['out_trade_no']}' WHERE ordernumber = '{$data['ordernumber']}'";
        if ($dbo->exeUpdate($sql)) {
            $sql = "UPDATE wy_users SET golds=golds+{$order['money']} WHERE user_id='{$order['touid']}'";
            if (!$dbo->exeUpdate($sql)) {
                return $paymentlp->msg_fail;
            } else {
                return $paymentlp->msg_success;
            }
        }else{
            return $paymentlp->msg_fail;
        }
    }
    return $paymentlp->msg_success;
}

//处理充值逻辑
function payUpgrade($data,$dbo,$paymentlp){
    $sql = "SELECT * FROM wy_balance WHERE ordernumber = '{$data['ordernumber']}'";
    $order = $dbo->getRow($sql,"arr");
    if(empty($order)){
        return $paymentlp->msg_noorder;
    }
    if ($order['state'] == 2) {
        return $paymentlp->msg_paied;
    }

    if ($order['state'] != 2) {
        $sql = "UPDATE wy_balance SET `state`='2',`out_trade_no`='{$data['out_trade_no']}' WHERE ordernumber = '{$data['ordernumber']}'";
        $dbo->exeUpdate($sql);
        $upgrade = $dbo->getRow("select * from wy_upgrade_log where mid='{$order['touid']}' and state='0' order by id desc limit 1");
        if ($upgrade) {
            if ($order['user_group'] == $upgrade['groups']) {
                $nowtime = $upgrade['endtime'];
            } else {
                $nowtime = date("Y-m-d");
            }
        } else {
            $nowtime = date("Y-m-d");
        }
        $sql = "update wy_upgrade_log set state='1' where mid='{$order['touid']}'";
        $dbo->exeUpdate($sql);
        //$nowtime=date("Y-m-d");
        $end = date("Y-m-d", strtotime($nowtime) + $order['day'] * 24 * 3600);
        $sql = "insert into wy_upgrade_log set mid='{$order['touid']}',groups='{$order['user_group']}',howtime='{$order['day']}',state='0',addtime='" . date('Y-m-d H:i:s') . "',endtime='$end'";
        if (!$dbo->exeUpdate($sql)) {
            return $paymentlp->msg_fail;
        } else {
            return $paymentlp->msg_success;
        }
    }
    return $paymentlp->msg_success;
}

function returnJs($msg,$url=""){
    $url = !empty($url)?$url:'/main.php';
    echo "<script>alert('Payment Result:{$msg}');window.location.href='{$url}'</script>";
    exit();
}