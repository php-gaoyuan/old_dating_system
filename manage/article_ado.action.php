<?php

require("session_check.php");
require("../foundation/fcontent_format.php");
require("../api/base_support.php");
//require("../foundation/function.php");
//表定义区
$t_article=$tablePreStr."article";
//数据库
$dbo = new dbex;
dbtarget('w',$dbServs);
$title = get_argp('title');
$id=get_argp('id')+0;
$cat_id=get_argp('cat_id')+0;
$content=get_argp('content');
$time = time();
if($_FILES){
	$allow_type=array('image/gif','image/jpeg','image/jpg','image/png');
	if(!in_array($_FILES['thumb']['type'],$allow_type)){
		echo "<script>alert('你上传的是啥鸟东西，不懂什么叫图片吗？');</script>";
		die('你上传的是啥鸟东西，不懂什么叫图片吗？  ');
	}
}
if(get_argp('motion')=='add'){
    if(!empty($title)){
        
        if(!empty($_FILES['thumb']['name'])){
            $up = new upload();
            $up->field='thumb';
            $up->set_dir($webRoot.'uploadfiles/article/','{y}/{m}{d}');
            $up->set_thumb(285,360);
            $fs=$up->single_exe();
            if($fs['flag'] = 1){
                $thumb = str_replace($webRoot,'',$fs['dir']).$fs['name'];
            }

           $sql = "insert into $t_article (cat_id,title,thumb,content,addtime) values ({$cat_id},'{$title}','{$thumb}','{$content}',{$time})"; 
        }else{
            $sql = "insert into $t_article (cat_id,title,content,addtime) values ({$cat_id},'{$title}','{$content}',{$time})"; 
        }
       
        if($dbo->exeUpdate($sql)){
           $info="添加成功";
        }else{
           $info="添加失败"; 
        }
    }else{
        $info = "标题不能为空";
    }
}else if(get_argp('motion') == 'edit'){
    if(!empty($title)){
		
        if(!empty($_FILES['thumb']['name'])){
            $up = new upload();
            $up->field='thumb';
            $up->set_dir($webRoot.'uploadfiles/article/','{y}/{m}{d}');
            $up->set_thumb(285,360);
            $fs=$up->single_exe();
            if($fs['flag'] = 1){
                $thumb = str_replace($webRoot,'',$fs['dir']).$fs['name'];
            }
       
            $sql = "update $t_article set cat_id=$cat_id,title='{$title}',thumb='{$thumb}',content='{$content}' where id=$id"; 
        }else{
            $sql = "update $t_article set cat_id=$cat_id,title='{$title}',content='{$content}' where id=$id"; 
        }
        if($dbo->exeUpdate($sql)){
           $info="修改成功";
        }else{
           $info="修改失败"; 
        }
    }else{
        $info = "标题不能为空";
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
            <div class="crumbs">当前位置 &gt;&gt; <a href="javascript:void(0);">文章管理</a> &gt;&gt; <a href="article_list.php">文章列表</a></div>         
            
             <div class="infobox">
                <h3>修改文档</h3>
                <div class="content">
 				 
                  
                    <table class="form-table">
                        <tr>
                            <td><font color="red" align="center"><?php echo $info;?></font></td>
                        </tr>
                    </table>
                
                </div>
            </div>  
        </div>
    </div>
</body>
</html>