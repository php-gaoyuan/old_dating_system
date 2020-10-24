<?php
require("session_check.php");	
require("../api/base_support.php");

	//语言包引入
	$f_langpackage=new foundationlp;
	$ad_langpackage=new adminmenulp;
    //表定义区
    $t_cat=$tablePreStr."cat";
    //数据库操作初始化
    $dbo = new dbex;
    dbtarget('w',$dbServs);


	$sql="select cat_id,cat_name from $t_cat";
	
	$cat_rs=$dbo->getRs($sql);
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
            <div class="crumbs">当前位置 &gt;&gt; <a href="javascript:void(0);">国家管理</a> &gt;&gt; <a href="user_country.php">国家列表</a></div>         
            
             <div class="infobox">
                <h3>添加国家</h3>
                <div class="content">
 				  <form action="country_ado.action.php" method="post" enctype="multipart/form-data">
                   <input type="hidden" name="motion" value="add" />
                  
                    <table class="form-table">
                        <tr>
                            <th width="90">*国家名称</th>
                             
                            <td><input type="text" class="small-text" name="title" value="" /></td>
                        </tr>

                         <tr>
                            <th width="90"></th>
                            <td><input type="submit" class="regular-button" value="添加"/></td>
                        </tr>
                    </table>
                  </form>
                </div>
            </div>  
        </div>
    </div>

</body>
</html>