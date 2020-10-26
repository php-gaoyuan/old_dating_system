<?php

require("session_check.php");
require("../foundation/fcontent_format.php");
require("../api/base_support.php");
//require("../foundation/function.php");
//表定义区
$t_article=$tablePreStr."city";
//数据库
$dbo = new dbex;
dbtarget('w',$dbServs);
$title = get_argp('title');
$id=get_argp('id')+0;
$pid=get_argp('pid')+0;
$time = time();
if(get_argp('motion')=='add'){
    if(!empty($title)){
        
     
      $sql = "insert into $t_article (pid,name,addtime) values ($pid,'{$title}',{$time})"; 
       
       
        if($dbo->exeUpdate($sql)){
           $info="添加成功";
        }else{
           $info="添加失败"; 
        }
    }else{
        $info = "名称不能为空";
    }
}else if(get_argp('motion') == 'edit'){
    if(!empty($title)){
	
        
            $sql = "update $t_article set pid=$pid,name='{$title}' where id=$id"; 
       
        if($dbo->exeUpdate($sql)){
           $info="修改成功";
        }else{
           $info="修改失败"; 
        }
    }else{
        $info = "名称不能为空";
    }  
}else{
     $info = "方法不存在";
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
            <div class="crumbs">当前位置 &gt;&gt; <a href="user_city.php">城市管理</a> </div>         
            
             <div class="infobox">
                <h3>修改文档</h3>
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