<?php
require("session_check.php");	
require("../api/base_support.php");

//表定义区
$t_cat=$tablePreStr."cat";
//数据库操作初始化
$dbo = new dbex;
dbtarget('w',$dbServs);
//变量区
$cat_id=intval(get_argg('cat_id'));
$sql="select cat_id,cat_name from $t_cat where cat_id=$cat_id";
	
$info=$dbo->getRow($sql);


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
            <div class="crumbs">当前位置 &gt;&gt; <a href="javascript:void(0);">文章管理</a> &gt;&gt; <a href="user_custom_edit.php">修改栏目</a></div>         
            
             <div class="infobox">
                <h3>修改栏目</h3>
                <div class="content">
 				  <form action="cat_do.php?act=edit" method="post"  >
                  
                    <table class="form-table">
                        <tr>
                            <th width="90">*栏目名称</th>
                             <input type="hidden" name='cat_id' value="<?php echo $info['cat_id'];?>" />
                            <td><input type="text" class="small-text" name='cat_name' value="<?php echo $info['cat_name'];?>" /></td>
                        </tr>
                         
                         <tr>
                            <th width="90"></th>
                            <td><input type="submit" class="regular-button" value="修改栏目"/></td>
                        </tr>
                    </table>
                  </form>
                </div>
            </div>  
        </div>
    </div>
</body>
</html>