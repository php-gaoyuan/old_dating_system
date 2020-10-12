<?php 
if($_POST){
require("session_check.php");
require("../api/base_support.php");

//数据库
$dbo = new dbex;
dbtarget('w',$dbServs);
$cat_name=$_POST['cat_name'];
$name=$_POST['name'];

	if(!$cat_name || !$name){
		echo "<script>alert('不能为空');window.location.href='hd_cat_add.php'</script>";
	}
	if($dbo->exeUpdate("insert into wy_hd_cat (`cat_name`,`name`) values ('$cat_name','$name')")){
		echo "<script>alert('添加成功');window.location.href='huandeng_list.php'</script>";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" media="all" href="css/admin.css">
    <script type='text/javascript' src='../servtools/ajax_client/ajax.js'></script>

</head>
<body>
    <div id="maincontent">
        <div class="wrap">
            <div class="crumbs">当前位置 &gt;&gt; <a href="javascript:void(0);">幻灯管理</a> &gt;&gt; <a href="hd_cat_add.php">添加栏目</a></div>         
            
             <div class="infobox">
                <h3>添加栏目</h3>
                <div class="content">
 				  <form action="" method="post">
                  
                    <table class="form-table">
                        <tr>
                            <th width="90">*栏目名称</th>
                             
                            <td><input type="text" class="small-text" name="cat_name" value="" /></td>
                        </tr>
						<tr>
                            <th width="90">*栏目介绍</th>
                             
                            <td><input type="text" class="small-text" name="name" value="" style="width:300px" /></td>
                        </tr>
                         
                         <tr>
                            <th width="90"></th>
                            <td><input type="submit" class="regular-button" value="添加栏目"/></td>
                        </tr>
                    </table>
                  </form>
                </div>
            </div>  
        </div>
    </div>
</body>
</html>
