<?php
require("session_check.php");	
require("../api/base_support.php");

//表定义区
$t_article=$tablePreStr."province";
//数据库操作初始化
$dbo = new dbex;
dbtarget('w',$dbServs);
//变量区
$id=$_GET['id']+0;

$sql = "delete from $t_article where id=$id";

    if($dbo->exeUpdate($sql)){
        $info="删除成功";
    }else{
        $info = "删除失败";
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
            <div class="crumbs">当前位置 &gt;&gt; <a href="javascript:void(0);">国家管理</a> &gt;&gt; <a href="user_province.php">省份列表</a></div>         
            
             <div class="infobox">
                <h3>修改栏目</h3>
                <div class="content">
 				 
                  
                    <table class="form-table">
                        <tr>
                            <td align="center"><font color="red" size="14"><?php echo $info;?></font></td>
                        </tr>
                    </table>
                
                </div>
            </div>  
        </div>
    </div>
</body>
</html>