<?php
require("session_check.php");	
require("../api/base_support.php");

//表定义区
$t_cat=$tablePreStr."cat";
//数据库操作初始化
$dbo = new dbex;
dbtarget('w',$dbServs);
//变量区
$cat_id=$_POST['cat_id']+0;
$cat_name=trim($_POST['cat_name']);
$act = $_GET['act'];
if($act == 'edit'){
    $sql = "update $t_cat set cat_name = '".$cat_name."' where cat_id=$cat_id";
   
    if($dbo->exeUpdate($sql)){
        $info="修改成功";
    }else{
        $info = "修改失败";
    }
}elseif($act == 'add'){
    $time = time();
    if(!empty($cat_name)){
        
    
        $sql = "insert into $t_cat (cat_name,cat_time) values ('{$cat_name}',{$time})"; 
       
        if($dbo->exeUpdate($sql)){
           $info="添加成功";
        }else{
           $info="添加失败"; 
        }
   }else{
        $info = "栏目名称不能为空";
   }
}

else{
    $info = '方法没找到';
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
            <div class="crumbs">当前位置 &gt;&gt; <a href="javascript:void(0);">文章管理</a> &gt;&gt; <a href="user_custom_edit.php">修改栏目</a></div>         
            
             <div class="infobox">
                <h3>修改栏目</h3>
                <div class="content">
 				 
                  
                    <table class="form-table">
                        <tr>
                            <td><font color="red"><?php echo $info;?></font></td>
                        </tr>
                    </table>
                
                </div>
            </div>  
        </div>
    </div>
</body>
</html>