<?php
require("session_check.php");	
require("../foundation/fpages_bar.php");
require("../api/base_support.php");

//表定义区
$t_manage_log=$tablePreStr."manage_log";

//数据库操作初始化
$dbo = new dbex;
dbtarget('w',$dbServs);
//当前页面参数
$page_num=trim(get_argg('page'));
//变量区
$info_name=short_check(get_argg('info_name'));
$c_perpage=get_argg('perpage') ? intval(get_argg('perpage')):20;
$dbo->setPages(10,$page_num);//设置分页
//搜索条件设置

//取出数据列表
$sql="select * from $t_manage_log where 1  order by id desc";

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
$input_type_value=array();
$input_type_value=array("0"=>"文本框","1"=>"下拉列表","2"=>"单选按钮","3"=>"多选按钮");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" media="all" href="css/admin.css">
    <script type='text/javascript' src='../servtools/ajax_client/ajax.js'></script>
	<script type='text/javascript' src='../servtools/calendar.js'></script>

    
</head>
<body>
    <div id="maincontent">
        <div class="wrap">
            <div class="crumbs">当前位置 &gt;&gt; <a href="javascript:void(0);">管理首页</a> &gt;&gt; <a href="feifa_list.php">非法登陆记录</a></div>
            <hr />
                    
            <div class="infobox">
                <h3>信息列表</h3>
                <div class="content">
                    <table class="list_table <?php echo $isset_data;?>">
                        <thead>
                        <tr>
                            <th width="100px;">id</th>
                            <th style="text-align:center">IP</th>
                            <th style="text-align:center">时间</th>
                            <th style="text-align:center">类型</th>
                        </tr>
                        </thead>
                        <?php foreach($info_rs as $rs){ ?>
                        <tr>
                            <td style="text-align:center"><?php echo $rs['id'];?></td>
                            <td style="text-align:center"><?php echo $rs['ip'];?></td>
                            <td style="text-align:center"><?php echo $rs['ltime'];?></td>
                            <td style="text-align:center"><?php echo $rs['ltype'];?></td>
                           
                        </tr>
                        <?php
                        }
                        ?>
                    </table>
                    <?php page_show($isNull,$page_num,$page_total);?>
                    <div class='guide_info <?php echo $none_data;?>'>没有查询到与条件相匹配的数据</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>