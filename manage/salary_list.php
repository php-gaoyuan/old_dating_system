<?php
require("session_check.php");   
require("../foundation/fpages_bar.php");
require("../api/base_support.php");

//数据库操作初始化
$dbo = new dbex;
dbtarget('w',$dbServs);
$ri_langpackage=new rightlp;

//当前页面参数
$page_num=trim(get_argg('page'));
//变量区
$dbo->setPages(10,$page_num);//设置分页
//搜索条件设置
$condition="where 1=1";

if(get_argg('search')){
    $wuname=get_argg('wuname');
  $condition=$condition."  and wuname='$wuname'";
}
//取出数据列表
$sql="select * from wy_wzmoney ".$condition ."  order by id desc";
//取得数据
$info_rs=$dbo->getRs($sql);
$page_total=$dbo->totalPage; //分页总数
//显示控制
$isNull=0;
$isset_data="";
$none_data="content_none";
if(empty($info_rs)){
    $isset_data="content_none";
    $none_data="";
    $isNull=1;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" media="all" href="css/admin.css">
    <script type='text/javascript' src='../servtools/ajax_client/ajax.js'></script>
    <script type="text/javascript">
        function  del_information(info_id){
            var del_inf=new Ajax();
            del_inf.getInfo("gift_info_aedt.action.php","post","app","motion=del&id="+info_id,function(c){del_information_callback(c);}); 
        } 
        function del_information_callback(c){
            if(c!='success'){
                alert('删除失败');
            }
            window.location.reload();
        }

        function Update(message){
            parent.Dialog.alert2(message);
        }
    </script>
</head>
<body>
    <div id="maincontent">
        <div class="wrap">
            <div class="crumbs">当前位置 &gt;&gt; <a href="javascript:void(0);">变更记录</a></div>
            <hr />
            <div class="infobox">
                <h3>筛选条件</h3>
                <div class="content">
                    <form action="" method="get" name='form' onsubmit='return check_form();'>
                    <input type="hidden" name="search" id="search" value="1" />
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <th width="90">员工名</th>
                            <td>
                                <input type="text" class="small-text" name='wuname' value="" />
                            </td>
                        </tr>
                        <tr>
                            <td ><input class="regular-button" type="submit" value="搜索" /></td>
                        </tr>
                        </tbody>
                    </table>
                    </form>
                </div>
            </div>           
            <div class="infobox">
                <h3>薪资记录</h3>
                <div class="content">
                    <table class="list_table <?php echo $isset_data;?>">
                        <thead>
                        <tr>
                            <th>员工名</th>
                            <th style="text-align:center">时间</th>
                            <th style="text-align:center">ip</th>
                            <th style="text-align:center">价格</th>
                            <th style="text-align:center">说明</th>
                        </tr>
                        </thead>
                        <?php foreach($info_rs as $rs){ ?>
                        <tr>
                            <td><?php echo $rs['wuname'];?></td>
                            <td style="text-align:center"><?php echo $rs['gotime'];?></td>
                            <td style="text-align:center"><?php echo $rs['ip'];?></td>
                            <td style="text-align:center"><?php echo $rs['money'];?></td>
                            <td style="text-align:center">
                                <a href="javascript:void(0);" onclick="Update('<?php echo $rs['reason'];?>')" >详细</a>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </table>
                    <?php page_show($isNull,$page_num,$page_total);?>
                    <input class="regular-button" type="button" value="添加" onclick="location='salary_add.php';"/>
                    <div class='guide_info <?php echo $none_data;?>'>没有查询到与条件相匹配的数据</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>