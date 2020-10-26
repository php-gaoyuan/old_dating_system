<?php
require("session_check.php");
require("../foundation/fpages_bar.php");
require("../foundation/fsqlseletiem_set.php");

//语言包引入
$eb_langpackage = new event_backstagelp;

require("../foundation/fback_search.php");
require("../api/base_support.php");
$user_id=$_GET['uid'];
//读写初始化
$dbo = new dbex;
dbtarget('w',$dbServs);
if($_POST){
	$user_name=$_POST['user_name'];
	$user_sex=$_POST['user_sex'];
	$gift_num=$_POST['gift_num'];
	$user_age=$_POST['user_age'];
	$shanchang=$_POST['shanchang'];
	$feiyong=$_POST['feiyong_1'].'/'.$_POST['feiyong_2'];
	$gerenqianming=$_POST['gerenqianming'];
	$fuwuzongzhi=$_POST['fuwuzongzhi'];
	$sql="update wy_servicers set user_name='$user_name',user_sex='$user_sex',gift_num='$gift_num',user_age='$user_age',shanchang='$shanchang',feiyong='$feiyong',gerenqianming='$gerenqianming',fuwuzongzhi='$fuwuzongzhi' where user_id='$user_id'";
	echo $sql;
	if($dbo->exeUpdate($sql)){
		header("location:servicer_list.php");
	}
	
}else{
	$sql="select s.* from wy_servicers as s left join wy_users as u on s.user_id=u.user_id where s.user_id='$user_id'";
	$uinfo=$dbo->getRow($sql);
	$feiyongs=explode('/',$uinfo['feiyong']);
	$feiyong_1=$feiyongs[0];
	$feiyong_2=$feiyongs[1];
}

?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" media="all" href="css/admin.css">
<script type='text/javascript' src='../servtools/ajax_client/ajax.js'></script>
<SCRIPT language=JavaScript src="../servtools/kindeditor/kindeditor.js"></SCRIPT>

<script type='text/javascript'>

</script>
</head>
<body>
<div id="maincontent">
<div class="wrap">

<form enctype="multipart/form-data" id="event_type_detail" name="event_type_detail" method="post" action="">
  <table class="form-table" border="0">
    <tr>
      <th>客服昵称</th>
      <td><input class="regular-text" type="text" name="user_name" id="typename"  value="<?php echo $uinfo['user_name'];?>" /></td>
    </tr>
	<tr>
      <th>性别</th>
      <td><input type="radio" name="user_sex" value="0" <?php if($uinfo['user_sex']=='0'){echo 'checked';}?>>女  
	  <input type="radio" name="user_sex" value="1" <?php if($uinfo['user_sex']=='1'){echo 'checked';}?>>男</td>
    </tr>
	<tr>
      <th>收到礼物</th>
      <td><input class="regular-text" type="text" name="gift_num" value="<?php echo $uinfo['gift_num'];?>" /></td>
    </tr>
	<tr>
      <th>年龄</th>
      <td><input class="regular-text" type="text" name="user_age" value="<?php echo $uinfo['user_age'];?>" /></td>
    </tr>
	<tr>
      <th>擅长领域</th>
      <td>
		<select name="shanchang">
			<option value="1" <?php if($uinfo['shanchang']==1){echo 'selected';}?>>中华美食区</option>
			<option value="2" <?php if($uinfo['shanchang']==2){echo 'selected';}?>>身心休闲室</option>
			<option value="3" <?php if($uinfo['shanchang']==3){echo 'selected';}?>>旅游百事通</option>
			<option value="4" <?php if($uinfo['shanchang']==4){echo 'selected';}?>>华夏文史馆</option>
		</select>
	  </td>
    </tr>
	<tr>
      <th>咨询费用</th>
      <td><input type="text" size="3" name="feiyong_1" value="<?php echo $feiyong_1;?>" />金币/ <input type="text" size="3" name="feiyong_2" value="<?php echo $feiyong_2;?>" />分钟</td>
    </tr>
	<tr>
      <th>个人签名</th>
      <td><input class="regular-text" type="text" name="gerenqianming" value="<?php echo $uinfo['gerenqianming'];?>" /></td>
    </tr>
	<tr>
      <th>服务宗旨</th>
      <td><textarea style="width:300px;height:60px;resize:none" name="fuwuzongzhi"><?php echo $uinfo['fuwuzongzhi'];?></textarea></td>
    </tr>
    <tr>
      <th><input class="regular-button" type="submit" name="sm" id="sm" value="修改" /></th>
      <td></td>
    </tr>
  </table>
</form>
</div>
</div>

<script type="text/javascript">
KE.show({
	id:'templates',
	resizeMode:0
});
</script>
</body>
</html>