<?php 
	require("foundation/asession.php");
    require("configuration.php");
    require("includes.php");
	//引入语言包
	require_once($webRoot.$langPackageBasePath."cash.php");
	$cashlp=new cashlp;

?>


<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $cashlp->title; ?></title>
	<link rel="stylesheet" href="http://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.css">
	<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style>
		.card-box{border:1px solid #ccc;border-radius: 4px;background: #e3e3e3;padding: 10px;height: 42px;margin-bottom:10px;}
		.icon{display: inline-block;width: 32px;height: 21px;background: url("https://www.paypalobjects.com/images/checkout/hermes/sprite_logos_wallet_v10_1x.png") no-repeat 0 100px;}
		.icon1{background-position:0 -62px;}
		.icon2{background-position: 0 -93px;}
		.icon3{background-position: 0 -124px;}
		.icon4{background-position: 0 -31px;}
	</style>
</head>
<body>
	<div class="container">
		<h2>
			<?php echo $cashlp->h2; ?><br>
			<small>
				<?php echo $cashlp->h2_small; ?>
			</small>
		</h2>

		<div class="card-box">
			<span class="icon icon1"></span>
			<span class="icon icon2"></span>
			<span class="icon icon3"></span>
			<span class="icon icon4"></span>
		</div>

		<form>
			<div class="form-group">
				<label for="city"><?php echo $cashlp->input_txt1; ?></label>
				<input type="email" class="form-control" id="city" placeholder="<?php echo $cashlp->input_txt1; ?>">
			</div>
			<div class="form-group">
				<label for="card_code"><?php echo $cashlp->card_code; ?></label>
				<input type="password" class="form-control" id="card_code" placeholder="<?php echo $cashlp->card_code; ?>">
			</div>
			<div class="form-group">
				<label for="name"><?php echo $cashlp->name; ?></label>
				<input type="password" class="form-control" id="name" placeholder="<?php echo $cashlp->name; ?>">
			</div>
			<div class="form-group">
				<label for="money"><?php echo $cashlp->money; ?></label>
				<input type="password" class="form-control" id="exampleInputPassword1" placeholder="<?php echo $cashlp->money; ?>">
			</div>
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".info"><?php echo $cashlp->sub_title; ?></button>
		</form>
	</div>



	<div class="modal fade info" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  <div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content">
	    	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title"><?php echo $cashlp->tip; ?></h4>
		    </div>
		    <div class="modal-body">
		        <p><?php echo $cashlp->tip_success; ?></p>
		    </div>
	    	
	    </div>
	  </div>
	</div>
	<script>
		$(function(){
			$('.info').on('hidden.bs.modal', function (e) {
			  // do something...
			})
		});
	</script>
</body>
</html>