<?php
require("session_check.php");	
require("../api/base_support.php");

	//语言包引入
	$f_langpackage=new foundationlp;
	$ad_langpackage=new adminmenulp;
    //表定义区
    $t_province=$tablePreStr."province";
    $t_city=$tablePreStr."city";
    //数据库操作初始化
    $dbo = new dbex;
    dbtarget('w',$dbServs);
    $id=$_GET['id']+0;
	$sql="select * from $t_city where id=$id";
	
	$article_rs=$dbo->getRow($sql);

	$sql="select id,pname from $t_province";
	
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
            <div class="crumbs">当前位置 &gt;&gt; <a href="javascript:void(0);">城市管理</a> &gt;&gt;<a href="user_city.php">城市列表</a></div>         
            
             <div class="infobox">
                <h3>修改内容</h3>
                <div class="content">
 				  <form action="city_ado.action.php" method="post" enctype="multipart/form-data">
                   <input type="hidden" name="motion" value="edit" />
                  <input type="hidden" name="id" value="<?php echo $article_rs['id'];?>" />
                    <table class="form-table">
                        <tr>
                            <th width="90">*城市名称</th>
                             
                            <td><input type="text" class="small-text" name="title" value="<?php echo $article_rs['name'];?>" /></td>
                        </tr>
                        <tr>
                            <th width="90">*省份名称</th>
                             
                            <td><select name="pid" style="width:110px;">
                                <?php foreach($cat_rs as $rs){?>
                                <?php if($article_rs['pid']==$rs['id']){?>
                               
                                
                                <option value="<?php echo $rs['id'];?>" selected><?php echo $rs['pname'];?></option>
                                    <?php }else{ ?>
                                <option value="<?php echo $rs['id'];?>" ><?php echo $rs['pname'];?></option>
                                     <?php }?>
                                <?php }?>
                            </select></td>
                        </tr>

 
                         <tr>
                            <th width="90"></th>
                            <td><input type="submit" class="regular-button" value="修改"/></td>
                        </tr>
                    </table>
                  </form>
                </div>
            </div>  
        </div>
    </div>
</body>
</html>