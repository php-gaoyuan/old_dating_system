<?php
require("session_check.php");	
require("../api/base_support.php");

//数据库操作初始化
$dbo = new dbex;
dbtarget('w',$dbServs);
//变量区
$id=intval(get_argg('id'));
$motion="add";
$info_patch='';
$info_giftname='';
$info_sort=0;
$info_type=0;
$info_money=0;
$submit_str='添加';
$hidd_value='gift_info_aedt.action.php';
if($id){
	$sql="select * from gift_news where id=$id";
	$info_row=$dbo->getRow($sql);
	$info_patch=$info_row['patch'];
	$info_giftname=$info_row['giftname'];
	$info_sort=$info_row['ordersum'];
	$info_type=$info_row['typeid'];
	$info_money=$info_row['money'];
	$submit_str='修改';
	$motion="edit";
	$hidd_value="gift_info_aedt.action.php?id=$id";
}
$input_type_value=array();
$sql="select * from gift_types order by id asc";
$gift_types=$dbo->getRs($sql);
$group_array=array();
if($gift_types){
	foreach($gift_types as $type){
		$input_type_value[$type['id']]=$type['typename'];
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" media="all" href="css/admin.css">
</head>
<body>
    <div id="maincontent">
        <div class="wrap">
            <div class="crumbs">当前位置 &gt;&gt; <a href="javascript:void(0);">礼品管理</a> &gt;&gt; <a href="user_custom_edit.php">添加礼品</a></div>         
            
             <div class="infobox">
                <h3>添加礼品信息</h3>
                <div class="content">
 				  <form action="<?php echo $hidd_value; ?>" method="post" name='form' enctype="multipart/form-data">
                  <input type="hidden" name="motion" value="<?php echo $motion;?>" />
				  <input type="hidden" name="id" value="<?php echo $id;?>" />
                    <table class="form-table">
                        <tr>
                            <th width="90">排序</th>
                            <td><input type="text" class="small-text" name='info_sort' value="<?php echo $info_sort;?>" />默认为0</td>
                        </tr>
                        <tr>
                            <th width="90">名称</th>
                            <td><input type="text" class="small-text" name='info_giftname' value="<?php echo $info_giftname;?>" /></td>
                        </tr>
                         <tr>
                            <th width="90">礼品类别</th>
                            <td><select name="info_type">
                                 <?php 
								 	foreach($input_type_value as $key=>$value){
									  $select='';
									  if($key==$info_type){
									     $select="selected";
									  }
									echo "<option value='".$key."' $select >".$value."</option>";
									}
								 ?>
                             	</select>                      
                            </td>
                        </tr>
                         <tr>
                            <th width="90">礼品图片</th>
                            <td><input class='small-text' style="height:23px;" type="file" name="info_patch[]" />
							<?php if($motion=='edit'&&$info_patch!=''){echo '<img style="vertical-align:middle;margin-left:125px;" src="/'.$info_patch.'"/>';};?></td>
                        </tr>
                         <tr>
                            <th width="90">金币</th>
                            <td><input type="text" class="small-text" name='info_money' value="<?php echo $info_money;?>" />默认为0</td>
                        </tr>
                         <tr>
                            <th width="90"></th>
                            <td><input type="submit" class="regular-button" value="<?php echo $submit_str;?>"/></td>
                        </tr>
                    </table>
                  </form>
                </div>
            </div>  
        </div>
    </div>
</body>
</html>