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
$hidd_value='gift_shop_info_aedt.action.php';
if($id){
	$sql="select * from gift_shop where id=$id";
	$info_row=$dbo->getRow($sql);
	$info_patch=$info_row['patch'];
	$info_yuanpatch=$info_row['yuanpatch'];
	$info_giftname=$info_row['giftname'];
	$info_sort=$info_row['ordersum'];
	$info_type=$info_row['typeid'];
	$info_money=$info_row['money'];
	$desc=$info_row['desc'];
	$submit_str='修改';
	$motion="edit";
	$hidd_value="gift_shop_info_aedt.action.php?id=$id";
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
                            <th width="90">名称</th>
                            <td>
                                <input type="text" class="small-text" name='info_giftname' value="<?php echo $info_giftname;?>" />
                            </td>
                        </tr>

                         <tr>
                            <th width="90">礼品图片</th>
                            <td>
                              <input class='small-text' style="height:23px;" type="file" name="info_patch[]" multiple/>
							                 <?php if($motion=='edit'&&$info_patch!=''){echo '<img style="vertical-align:middle;margin-left:125px;" width=70 height=70 src="/'. $info_yuanpatch.'"/>';};?>&nbsp;请上传400*400以上正方形图片，否则图片会模糊，最多长传四张图</td>
                        </tr>
                         <tr>
                            <th width="90">金币</th>
                            <td><input type="text" class="small-text" name='info_money' value="<?php echo $info_money;?>" />默认为0</td>
                        </tr>
						<tr>
                            <th width="90">详细描述</th>
                            <td>
							<textarea name="desc" id="content" ><?php echo $desc;?></textarea>
							</td>
                        </tr>
                         <tr>
                            <th width="90"></th>
                            <td>
                                <input type="submit" class="regular-button" value="<?php echo $submit_str;?>"/>
                                <input type="hidden" name="info_type" value="4">
                                <input type="hidden" name="info_sort" value="0">
                            </td>
                        </tr>
                    </table>
                  </form>
                </div>
				<script type="text/javascript" src="../ueditor/editor_config.js"></script>
                <script type="text/javascript" src="../ueditor/editor_all_min.js"></script>
                <script type="text/javascript">
                var edit = new UE.ui.Editor({initialContent:'',initialFrameWidth:750});
                edit.render("content");
                </script>
            </div>  
        </div>
    </div>
</body>
</html>