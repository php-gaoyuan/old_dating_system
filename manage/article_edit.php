<?php
require("session_check.php");	
require("../api/base_support.php");

	//语言包引入
	$f_langpackage=new foundationlp;
	$ad_langpackage=new adminmenulp;
    //表定义区
    $t_cat=$tablePreStr."cat";
    $t_article=$tablePreStr."article";
    //数据库操作初始化
    $dbo = new dbex;
    dbtarget('w',$dbServs);
    $id=$_GET['id']+0;
	$sql="select * from $t_article where id=$id";
	
	$article_rs=$dbo->getRow($sql);

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
            <div class="crumbs">当前位置 &gt;&gt; <a href="javascript:void(0);">文章管理</a> &gt;&gt; <a href="article_list.php">内容列表</a></div>         
            
             <div class="infobox">
                <h3>修改内容</h3>
                <div class="content">
 				  <form action="article_ado.action.php" method="post" enctype="multipart/form-data">
                   <input type="hidden" name="motion" value="edit" />
                  <input type="hidden" name="id" value="<?php echo $article_rs['id'];?>" />
                    <table class="form-table">
                        <tr>
                            <th width="90">*文章标题</th>
                             
                            <td><input type="text" class="small-text" name="title" value="<?php echo $article_rs['title'];?>" /></td>
                        </tr>
                        <tr>
                            <th width="90">*栏目名称</th>
                             
                            <td><select name="cat_id">
                                <?php foreach($cat_rs as $rs){?>
                                <?php if($article_rs['cat_id']==$rs['cat_id']){?>
                               
                                
                                <option value="<?php echo $rs['cat_id'];?>" selected><?php echo $rs['cat_name'];?></option>
                                    <?php }else{ ?>
                                <option value="<?php echo $rs['cat_id'];?>" ><?php echo $rs['cat_name'];?></option>
                                     <?php }?>
                                <?php }?>
                            </select></td>
                        </tr>
                        <tr>
                            <th width="90">缩略图</th>
                             
                            <td><input type="file"  name="thumb"/>
                            <?php if($article_rs['thumb']){ ?>
                            <img src="../<?php echo $article_rs['thumb']; ?>" height="50" width="30"/>
                            <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <th width="90">文章内容</th>
                             
                            <td><textarea id="content" name="content" ><?php echo $article_rs['content'];?></textarea></td>
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
<script type="text/javascript" src="../ueditor/editor_config.js"></script>
<script type="text/javascript" src="../ueditor/editor_all_min.js"></script>
<script type="text/javascript">

var edit = new UE.ui.Editor({initialContent:'',initialFrameWidth:750});
edit.render("content");
</script>
</body>
</html>