<?php
require("session_check.php");	
require("../foundation/fpages_bar.php");
require("../api/base_support.php");


//数据库操作初始化
$dbo = new dbex;
dbtarget('w',$dbServs);

//变量区
$id=short_check(get_argg('id'));

//取出数据列表
$sql="select * from chat_txt where id='$id'";

//取得数据
$info_rs=$dbo->getRow($sql);
$con=format_message(array(0,0),$info_rs);
foreach($con as $k=>$v){
	$uid=$v['id'];
	$ress=$dbo->getRow("select user_name from wy_users where user_id='$uid'");
	$con[$k]['uname']=$ress['user_name'];
}
$con=array_reverse_order($con);//数组倒序排序

// 格式聊天记录到数组
function format_message($pagect,$txt) {
	$array = array();
	if($txt['txt_pagenum']>$pagect[0] || $pagect[1]==0) {
		preg_match_all("/<ct_([0-9]+)>([0-9]+){([0-9]+-[0-9]+-[0-9]+ [0-9]+:[0-9]+:[0-9]+)}(.+?)<\/ct_[0-9]+>/",$txt['txt_content'],$out);
	} else {
		$ex_result = explode("<ct_".($pagect[1]+1).">",$txt['txt_content']);
		preg_match_all("/<ct_([0-9]+)>([0-9]+){([0-9]+-[0-9]+-[0-9]+ [0-9]+:[0-9]+:[0-9]+)}(.+?)<\/ct_[0-9]+>/","<ct_".($pagect[1]+1).">".$ex_result[1],$out);
	}
	foreach($out[1] as $key=>$value) {
		$array[$key] = array(
			'rid'=>	$out[1][$key],
			'id' => $out[2][$key],
			'time' => $out[3][$key],
			'txt' => preg_replace("/{:(\d+):}/i","<span class='smile_$1'></span>",$out[4][$key])
		);
	}
	
	return $array;
}
function array_reverse_order($array){
        $array_key = array_keys($array);
        $array_value = array_values($array);
        
        $array_return = array();
        for($i=1, $size_of_array=sizeof($array_key);$i<=$size_of_array;$i++){
            $array_return[$array_key[$size_of_array-$i]] = $array_value[$size_of_array-$i];
        }
        
        return $array_return;
}
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
            <div class="crumbs">当前位置 &gt;&gt; <a href="javascript:void(0);">员工管理</a> &gt;&gt; <a href="user_custom.php">UUchat记录</a></div>
            <hr />
                    
            <div class="infobox">
                <h3>信息列表</h3>
                <div class="content">
                    <table class="list_table <?php echo $isset_data;?>">
                        <thead>
                        <tr>
                            <th width="100px;">FROM</th>
                            
                            <th style="text-align:center">时间</th>
                            <th style="text-align:center">内容</th>
                           
                        </tr>
                        </thead>
                        <?php foreach($con as $rs){ ?>
                        <tr>
                            <td style="text-align:center"><?php echo $rs['uname'];?></td>
                           
                            <td style="text-align:center"><?php echo $rs['time'];?></td>
                            <td style="text-align:center;overflow:hidden;" title="<?php echo $rs['txt'];?>" ><?php echo $rs['txt'];?></td>
                           
                        </tr>
                        <?php
                        }
                        ?>
                    </table>
                   
                   
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>