<?php
require("session_check.php");	
require("../api/base_support.php");

//数据库操作初始化
$dbo = new dbex;
dbtarget('w',$dbServs);
//变量区
$motion="add";
$submit_str='添加';

if(get_argp('motion')=='add')
{
	$name=get_argp('name');
	$password=md5(get_argp('pwd'));
	$addtime=time();

	if(empty($name)){
		echo "<script type='text/javascript'>alert('员工名不能为空');window.history.go(-1);</script>";
		die();
	}
	if(empty($password)){
		echo "<script type='text/javascript'>alert('密码不能为空');window.history.go(-1);</script>";
		die();
	}

	$wz=$dbo->getRow("select * from wy_wangzhuan where name='$name'");
	if($wz)
	{
		echo "<script type='text/javascript'>alert('该员工已经存在');window.history.go(-1);</script>";
		die();
	}
	
	$sql="insert into wy_wangzhuan (name,password,addtime,loginip) values('$name','$password','$addtime','$_SERVER[REMOTE_ADDR]')";
	$is_success=$dbo->exeUpdate($sql);
	if($is_success){
	  echo "<script type='text/javascript'>window.location.href='employees_list.php'</script>";
	  die();
	}else{
	  echo "<script type='text/javascript'>alert('添加失败');window.history.go(-1);</script>";
	  die();
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
            <div class="crumbs">当前位置 &gt;&gt; <a href="javascript:void(0);">员工管理</a> &gt;&gt; <a href="salary_add.php">添加员工</a></div>         
            
             <div class="infobox">
                <h3>添加员工</h3>
                <div class="content">
 				  <form action="" method="post" name='form' enctype="multipart/form-data">
                  <input type="hidden" name="motion" value="<?php echo $motion;?>" />
                    <table class="form-table">
                        <tr>
                            <th width="90">员工名</th>
                            <td><input type="text" class="small-text" name='name' value="" /></td>
                        </tr>
                        <tr>
                            <th width="90">密　码</th>
                            <td><input type="text" class="small-text" name='pwd' value="" /></td>
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