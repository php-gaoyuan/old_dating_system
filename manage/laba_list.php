<?php
require("session_check.php");	
require("../foundation/fpages_bar.php");
require("../api/base_support.php");

//表定义区
$t_horn=$tablePreStr."horn";

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
$condition=" where 1 ";

if(get_argg('user_name')){
  $user_name=get_argg('user_name');
  $condition.=" and user_name like '%$user_name%' ";
}
if(get_argg('horn_content')){
  $horn_content=get_argg('horn_content');
  $condition.=" and horn_content like '%$horn_content%' ";
}
if(get_argg('start_time')){
  $start_time=get_argg('start_time');
  $start_time=date("Y-m-d",strtotime($start_time) );
  $condition.=" and from_unixtime(`start_time`) like '%$start_time%' ";
}
//取出数据列表
$sql="select * from $t_horn ".$condition ."  order by start_time desc";

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

    <script type="text/javascript">
    	function  del_horn(id){
			var del_inf=new Ajax();
			del_inf.getInfo("del_horn.action.php","get","app","id="+id,function(c){
				if(c=='删除成功') window.location.reload();
				else alert(c);
			}); 
		} 
		
    
    </script>
</head>
<body>
    <div id="maincontent">
        <div class="wrap">
            <div class="crumbs">当前位置 &gt;&gt; <a href="javascript:void(0);">管理首页</a> &gt;&gt; <a href="user_custom.php">喇叭记录</a></div>
            <hr />
            <div class="infobox">
                <h3>筛选条件</h3>
                <div class="content">
                    <form action="" method="get" name='form'>
                    
                    <table class="form-table">
                        <tbody>
                        <tr>
                  
                            <td>
							发布人：<input type="text" class="small-text" name='user_name' value="<?php echo get_argg('user_name');?>">
							喇叭内容：<input type="text" class="small-text" name='horn_content' value="<?php echo get_argg('horn_content');?>" style="width:300px;">
							发布时间：<input type="text" class="small-text" name='start_time' value="<?php echo get_argg('start_time');?>" onclick="calendar(this);">
							
							</td>
                        </tr>
                        <tr>
                        	<td ><input class="regular-button" type="submit" value="检索" /><input class="regular-button" type="reset" value="重置" onclick="window.location.href='laba_list.php'" /></td>
                        	<td ></td>
                        </tr>
                        </tbody>
                    </table>
                    </form>
                </div>
            </div>           
            <div class="infobox">
                <h3>信息列表</h3>
                <div class="content">
                    <table class="list_table <?php echo $isset_data;?>">
                        <thead>
                        <tr>
                            <th width="100px;">发布人</th>
                            <th style="text-align:center">发布内容</th>
                            <th style="text-align:center">发布时间</th>
                            <th style="text-align:center">操作</th>
                        </tr>
                        </thead>
                        <?php foreach($info_rs as $rs){ ?>
                        <tr>
                            <td style="text-align:center"><?php echo $rs['user_name'];?></td>
                            <td style="text-align:center"><?php echo $rs['horn_content'];?></td>
                            <td style="text-align:center"><?php echo date("Y-m-d H:i:s",$rs['start_time']);?></td>
                            <td align="center">
                                <a href="javascript:del_horn(<?php echo $rs['horn_id'];?>);" onclick='return confirm("确认删除");'>删除</a>
                            </td>
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