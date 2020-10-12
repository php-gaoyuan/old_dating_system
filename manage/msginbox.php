<?php
require("session_check.php");	
require("../api/base_support.php");

	//语言包引入
	$f_langpackage=new foundationlp;
	$ad_langpackage=new adminmenulp;
    /*
    //表定义区
    $t_users=$tablePreStr."users";
    //数据库操作初始化
    $dbo = new dbex;
    dbtarget('w',$dbServs);


	$sql="select user_id from $t_users";
	
	$t_users=$dbo->getRs($sql);
    $tuid = array();
    foreach ($t_users as $k => $v) {
        array_push($tuid,$v['user_id']);
    }
    $tuid = implode(",", $tuid);
    //print_r($tuid);exit;
    $from_user_ico="skin/$skinUrl/images/d_ico_1_small.gif";
    echo $from_user_ico;
    */

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
            <div class="crumbs">当前位置 &gt;&gt; <a href="javascript:void(0);">群发邮件</a> </div>         
            
             <div class="infobox">
                <h3>邮件内容</h3>
                <div class="content">
 				  <form action="msginbox_send.php" method="post" enctype="multipart/form-data">
                  
                  
                    <table class="form-table">
                        <tr>
                            <th width="90">*邮件主题</th>
                             
                            <td><input type="text" class="small-text" name="mess_title" value="" /></td>
                        </tr>
                        
                        <tr>
                            <th width="90">邮件内容</th>
                             
                            <td><textarea id="content" name="mess_content"></textarea></td>
                        </tr>
                         <tr>
                            <th width="90"></th>
                            <td><input type="submit" class="regular-button" name="send" value="群发邮件"/></td>
                        </tr>
                    </table>
                  </form>
                </div>
            </div>  
        </div>
    </div>
<script type="text/javascript" src="../ueditor/editor_config.js"></script>
<script type="text/javascript" src="../ueditor/editor_all_min.js"></script>
<script type="text/javascript">

var edit = new UE.ui.Editor({initialContent:'',initialFrameWidth:750});
edit.render("content");
</script>
</body>
</html>