<?php
require("session_check.php"); 
require("../api/base_support.php");

//数据库操作初始化
$dbo = new dbex;
dbtarget('w',$dbServs);
//变量区
$motion="add";
$submit_str='添加';

$wz_list=$dbo->getRs("select * from wy_wangzhuan");




if(get_argp('motion')=='add')
{
  $wuname=get_argp('wuname');
  $money=get_argp('money');
  $type=get_argp('type');
  $reason=get_argp('reason');

  if(empty($wuname)){
    echo "<script type='text/javascript'>alert('员工名不能为空');window.history.go(-1);</script>";
    die();
  }
  if(empty($money)){
    echo "<script type='text/javascript'>alert('金额不能为空');window.history.go(-1);</script>";
    die();
  }

  $wz=$dbo->getRow("select * from wy_wangzhuan where name='$wuname'");
  if(!$wz)
  {
    echo "<script type='text/javascript'>alert('该员工不存在');window.history.go(-1);</script>";
    die();
  }
  
  $sql="insert into wy_wzmoney (wuid,wuname,money,ip,reason,type,gotime) values('".$wz['id']."','".$wz['name']."','$money','$_SERVER[REMOTE_ADDR]','$reason','$type',now())";
  $is_success=$dbo->exeUpdate($sql);
  if($is_success){
    echo "<script type='text/javascript'>window.location.href='salary_list.php'</script>";
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
            <div class="crumbs">当前位置 &gt;&gt; <a href="javascript:void(0);">薪资管理</a> &gt;&gt; <a href="salary_add.php">添加薪资记录</a></div>         
            
             <div class="infobox">
                <h3>添加薪资记录</h3>
                <div class="content">
          <form action="" method="post" name='form' enctype="multipart/form-data">
                  <input type="hidden" name="motion" value="<?php echo $motion;?>" />
                    <table class="form-table">
                        <tr>
                            <th width="90">员工名</th>
                            <td>
              
              <!--<input type="text" class="small-text" name='wuname' value="" />-->
              
              <select name="wuname">
              <?php 
              
              foreach($wz_list as $k=>$vo){
                echo "<option value='".$vo['name']."'>".$vo['name']."</option>";
              }
              ?>
              </select>
              
              </td>
                        </tr>
                         <tr>
                            <th width="90">支出类别</th>
                            <td><select name="type">
                                 <option value="1">薪水支出</option>
                                 <option value="2">拒付</option>
                                 <option value="0">其他</option>
                              </select>                      
                            </td>
                        </tr>
                        <tr>
                            <th width="90">金额</th>
                            <td><input type="text" class="small-text" name='money' value="" /></td>
                        </tr>
                         <tr>
                            <th width="90">支出说明</th>
                            <td>
                <textarea name="reason" id="reason" cols="45" rows="5"></textarea>
              </td>
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