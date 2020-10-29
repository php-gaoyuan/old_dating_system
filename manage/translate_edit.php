<?php
require("session_check.php");	
require("../api/base_support.php");

	//语言包引入
	$f_langpackage=new foundationlp;
	$ad_langpackage=new adminmenulp;
    //表定义区
    $t_msg_inbox=$tablePreStr."msg_inbox";
    //数据库操作初始化
    $dbo = new dbex;
    dbtarget('w',$dbServs);
    $mess_id=$_GET['mess_id']+0;
	$sql="select mess_id,from_user_id,mess_title,mess_content from $t_msg_inbox where mess_id=$mess_id";
	
	$msg_inbox=$dbo->getRow($sql);
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
            <div class="crumbs">当前位置 &gt;&gt; <a href="javascript:void(0);">邮件管理</a> &gt;&gt; <a href="translate_list.php">邮件列表</a></div>         
            
             <div class="infobox">
                <h3>翻译邮件</h3>
                <div class="content">
 				  <form action="translate_ado.action.php" method="post" enctype="multipart/form-data">
                   <input type="hidden" name="motion" value="edit" />
                  <input type="hidden" name="mess_id" value="<?php echo $msg_inbox['mess_id'];?>" />
				  <input type="hidden" name="from_user_id" value="<?php echo $msg_inbox['from_user_id'];?>" />
                    <table class="form-table">
                        <tr>
                            <th width="90">邮件主题</th>
                             
                            <td><?php echo $msg_inbox['mess_title'];?></td>
							
							 
                        </tr>
               
                       
                        <tr>
                            <th width="90">邮件内容</th>
                             
                            <td><div ><?php echo $msg_inbox['mess_content'];?></div></td>
							
							
                        </tr>
                     
                         <tr>
                            <th width="90"></th>
                            <td><a href="javascript:void" onclick="javascript:history.go(-1);">返回</a></td>
                        </tr>
                    </table>
                  </form>
                </div>
            </div>  
        </div>
    </div>
</body>
</html>