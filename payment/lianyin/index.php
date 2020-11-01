<?php
header("content-type:text/html;charset=utf-8");
require("../../foundation/asession.php");
require("../../configuration.php");
require("../../includes.php");
require("../../{$langPackageBasePath}/paymentlp.php");
$paymentlp = new paymentlp();


//读写分离定义函数
$dbo = new dbex;
dbtarget('w', $dbServs);
$order_no = $_GET["oid"];
$pt = $_GET["pt"];
$user_id = get_sess_userid();

$sql = "select * from wy_balance where uid={$user_id} and ordernumber='{$order_no}' and type='{$pt}'";
$order = $dbo->getRow($sql,"arr");
//echo "<pre>";print_r($order);exit;
if(empty($order)){
    header("location:/");exit;
}
?>





<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $paymentlp->title;?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
<div class="container">
    <div class="py-2 text-center">
        <h2>
            <script type="text/javascript" src="https://www.wshtmltool.com/get_payment_info.js?mid=600864"></script>
            <script>document.write(payment_info);</script>
        </h2>
    </div>
    <hr class="mb-4">
    <div class="row">
        <div class="col-md-12 order-md-1">
            <form class="needs-validation" method="post" id="payForm" action="./pay.php" novalidate>
                <div class="info-wrap">
                    <div class="row">
                        <div class="col-md-6 mb-3 offset-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?php echo $paymentlp->order_no;?></span>
                                </div>
                                <input type="text" class="form-control" name="product" id="product" value="<?php echo $_REQUEST['oid'];?>" required readonly>
                                <input type="hidden" name="oid" value="<?php echo $_REQUEST['oid'];?>">
                                <input type="hidden" name="pt" value="<?php echo $_REQUEST['pt'];?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 offset-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?php echo $paymentlp->amount;?></span>
                                </div>
                                <input type="text" class="form-control" name="amount" id="amount" value="<?php echo $_REQUEST['am'];?>USD"  required readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3 text-center">
                        <h4><?php echo $paymentlp->bill_info;?></h4>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 offset-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?php echo $paymentlp->name;?></span>
                                </div>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                    </div>
                    <!--                -->
                    <div class="row">
                        <div class="col-md-6 mb-3 offset-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?php echo $paymentlp->email;?></span>
                                </div>
                                <input type="text" class="form-control" name="email" id="email" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3 offset-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?php echo $paymentlp->phone;?></span>
                                </div>
                                <input type="text" class="form-control" name="phone" id="phone" required>
                            </div>
                        </div>
                    </div>



                    <div class="container-fluid py-3">
                        <div class="row">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-4 mx-auto">
                                <div>
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        <i class="fa fa-lock fa-lg"></i>&nbsp;
                                        <span id="payment-button-amount"><?php echo $paymentlp->btn_pay;?></span>
                                        <span id="payment-button-sending" style="display:none;">Sending…</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

</div>

<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap.bundle.js"></script>
<script type="text/javascript">
    $("#payment-button").click(function(e) {
        // Fetch form to apply Bootstrap validation
        var form = $(this).parents('form');

        if (form[0].checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
        }else {
            // Perform ajax submit here
            form.submit();
        }

        form.addClass('was-validated');
    });
</script>
</body>
</html>