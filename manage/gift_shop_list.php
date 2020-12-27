<?php
require("session_check.php");	
require("../foundation/fpages_bar.php");
require("../api/base_support.php");

//数据库操作初始化
$dbo = new dbex;
dbtarget('w',$dbServs);
$ri_langpackage=new rightlp;
$selecttype=get_argg('search_name');
$sql="select * from gift_types order by id asc";
$gift_types=$dbo->getRs($sql);
$options="<option value=\"\" selected>".$ri_langpackage->ri_choose."</option>";
$group_array=array();
if($gift_types){
	foreach($gift_types as $type){
		$selected='';
		if($selecttype==$type['id']){
			$selected='selected';
		}
		$options.='<option value="'.$type['id'].'" '.$selected.'>'.$type['typename'].'</option>';
		$group_array[$type['id']]=$type['typename'];
	}
}

//当前页面参数
$page_num=trim(get_argg('page'));
//变量区
$dbo->setPages(10,$page_num);//设置分页
//搜索条件设置
$condition="where 1=1";

if(get_argg('search')){
  $condition=$condition."  and typeid='$selecttype'";
}

//取出数据列表
$sql="select * from gift_shop ".$condition ."  order by id desc";
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
			del_inf.getInfo("gift_shop_info_aedt.action.php","post","app","motion=del&id="+info_id,function(c){del_information_callback(c);}); 
		} 
		function del_information_callback(c){
			
			if(c!='success'){
				alert('删除失败');
			}
			window.location.reload();
		}
    
    </script>
</head>
<body>
    <div id="maincontent">
        <div class="wrap">
            <div class="crumbs">当前位置 &gt;&gt; <a href="javascript:void(0);">礼品管理</a> &gt;&gt; <a href="gift_list.php">礼品列表</a></div>
            <hr />
<!--            <div class="infobox">-->
<!--                <h3>筛选条件</h3>-->
<!--                <div class="content">-->
<!--                    <form action="" method="get" name='form' onsubmit='return check_form();'>-->
<!--                    <input type="hidden" name="search" id="search" value="1" />-->
<!--                    <table class="form-table">-->
<!--                        <tbody>-->
<!--                        <tr>-->
<!--                            <th width="90">礼品类别</th>-->
<!--                            <td>-->
<!--								<select name='search_name'>-->
<!--									<option value="0">--请选择--</option>-->
<!--									<option value="2">普通礼物</option>-->
<!--									<option value="3">高级礼物</option>-->
<!--									<option value="4">真实礼物</option>-->
<!--								</select>-->
<!--							</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                        	<td ><input class="regular-button" type="submit" value="搜索" /></td>-->
<!--                        </tr>-->
<!--                        </tbody>-->
<!--                    </table>-->
<!--                    </form>-->
<!--                </div>-->
<!--            </div>           -->
            <div class="infobox">
                <h3>礼品列表</h3>
                <div class="content">
                    <table class="list_table <?php echo $isset_data;?>">
                        <thead>
                        <tr>
                            <th>名称</th>
                            <th style="text-align:center">礼品类型</th>
                            <th style="text-align:center">图片</th>
                            <th style="text-align:center">价格</th>
                            <th style="text-align:center">操作</th>
                        </tr>
                        </thead>
                        <?php foreach($info_rs as $rs){ $yuanpatchs=explode("|", $rs['yuanpatch']);?>
                        <tr>
                            <td><?php echo $rs['giftname'];?></td>
                            <td style="text-align:center"><?php if($rs['typeid']==1) echo '虚拟礼物'; elseif($rs['typeid']==2){echo '真实礼物';} ?></td>
                            <td style="text-align:center"><img src='/<?php echo $yuanpatchs[0];?>' width=70 height=70/></td>
                            <td style="text-align:center"><?php echo $rs['money'];?></td>
                            <td align="center">
                                <a href="gift_shop_edit.php?id=<?php echo $rs['id'];?>" >修改</a> |
                                <a href="javascript:del_information(<?php echo $rs['id'];?>);" onclick='return confirm("确认删除");'>删除</a>
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