<?php
require("session_check.php");	
require("../foundation/fcontent_format.php");
require("../api/base_support.php");

	//语言包引入
	$f_langpackage=new foundationlp;
	$ad_langpackage=new adminmenulp;

    //数据库操作初始化
    $dbo = new dbex;
    dbtarget('w',$dbServs);
	$sql="select cat_id,cat_name,name from wy_hd_cat order by cat_id desc";
	$cat_rs=$dbo->getRs($sql);
	if($_POST || $_GET['add']==1){
		$title=get_argp('title');
		$ord=get_argp('ord');
		$cat_id=$_POST['cat_id'];
		$ad_pic=$_POST['ad_pic'];
		$ad_link=$_POST['ad_link'];
		$allow_type=array('image/gif','image/jpeg','image/jpg','image/png');
		if(!in_array($_FILES['ad_pic']['type'],$allow_type)){
			echo "<script>alert('你上传的是啥鸟东西，不懂什么叫图片吗？');</script>";
			die('你上传的是啥鸟东西，不懂什么叫图片吗？  ');
		}
		if(!empty($title) && !empty($ad_link)){
        
        if(!empty($_FILES['ad_pic']['name'])){
            $up = new upload();
            $up->field='ad_pic';
            $up->set_dir($webRoot.'uploadfiles/hd/','');
            if($cat_id==3){
				$up->set_thumb(590,120);
			}elseif($cat_id==4){
				$up->set_thumb(170,200);
			}
            $fs=$up->single_exe();
            if($fs['flag'] = 1){
                $ad_pic = str_replace($webRoot,'',$fs['dir']).'thumb_'.$fs['name'];
                $ad_pic_y = str_replace($webRoot,'',$fs['dir']).$fs['name'];
            }
           $update_pic=" `ad_pic`='$ad_pic',`ad_pic_y`='$ad_pic_y', ";
        }else{
			$update_pic=" ";
		}
		
		if($_POST['update']){
			$sql="update wy_hd set `title`='$title',`cat_id`='$cat_id', ".$update_pic." `ord`='$ord',`ad_link`='$ad_link' where id=$_POST[update]";
		}else{
			$sql="insert into wy_hd (`title`,`cat_id`,`ad_pic`,`ad_pic_y`, `ord`,`ad_link`) values ('$title','$cat_id','$ad_pic','$ad_pic_y','$ord','$ad_link')";
		}
		
		$res=$dbo->exeUpdate($sql);
		if($res){
			echo "<script>alert('添加成功');window.location.href='huandeng_list.php'</script>";
		}
		EXIT;
        
		}else{
			echo "<script>alert('标题/链接 不能为空');window.location.href='huandeng_add.php'</script>";
		}
		
	}else{
		if($_GET['id']){
			$id=$_GET['id'];
			$sql="select * from wy_hd where id=$id";
			$hd_info=$dbo->getRow($sql);
		}
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
            <div class="crumbs">当前位置 &gt;&gt; <a href="huandeng_list.php">幻灯管理</a> &gt;&gt; <a href="huandeng_add.php"><?php if($_GET['id']){echo "修改幻灯";}else{echo "添加幻灯";}?></a></div>         
            
             <div class="infobox">
                <h3>添加内容</h3>
                <div class="content">
 				  <form action="?add=1" method="post" enctype="multipart/form-data">
                  
                  <input type="hidden" name="update" value="<?php echo $hd_info['id'];?>">
                    <table class="form-table">
                        <tr>
                            <th width="90">*标题</th>
                             
                            <td><input type="text" class="small-text" name="title" value="<?php echo $hd_info['title'];?>" /></td>
                        </tr>
                        <tr>
                            <th width="90">*选择栏目</th>
                             
                            <td><select name="cat_id">
                                <?php foreach($cat_rs as $rs){?>
                                <option value="<?php echo $rs['cat_id'];?>" title="<?php echo $rs['name'];?>" <?php if($hd_info['cat_id']==$rs['cat_id']){echo ' selected ';}?>> 　<?php echo $rs['cat_name'];?> 　</option>
                                <?php }?>
                            </select> | <a href="hd_cat_add.php">添加栏目</a></td>
                        </tr>
                        <tr>
                            <th width="90">广告图</th>
                             
                            <td>
							<input type="file"  name="ad_pic" value="<?php echo $hd_info['ad_pic'];?>"/>
							<?php if($hd_info['ad_pic']){echo "<img style='max-width:180px;max-height:100px;' src='../".$hd_info['ad_pic']."'>";}?></td>
                        </tr>
						<tr>
                            <th width="90">排序</th>
                             
                            <td><input type="text"  name="ord" value="<?php echo $hd_info['ord'];?>"/>数字，越大越靠前</td>
                        </tr>
						<tr>
                            <th width="90">广告链接</th>
                             
                            <td><input type="text"  name="ad_link" value="<?php echo $hd_info['ad_link'];?>" style="width:300px" /></td>
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