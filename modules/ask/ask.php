<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/ask/ask.html
 * 如果您的模型要进行修改，请修改 models/modules/ask/ask.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
  //引入公共模块
	require("foundation/fpages_bar.php");
	require("foundation/module_ask.php");
	require("api/base_support.php");

	//语言包引入
	$b_langpackage=new bloglp;

	//变量区

	$ses_uid=get_sess_userid();
	$url_uid = intval(get_argg('user_id'));
	$mod=get_argg('mod');
	$type=intval(get_argg('type'));
	$page_num=intval(get_argg('page'));
	$page_total='';
	$mod_unsolved='';
	$mod_solved='';
	$mod_reply='';
	$mod_reward='';
	$mod_mine='';
	$mod_mine_reply='';
	$sql='';
	$ask_rs=array();
	
	//引入模块公共权限过程文件
	$is_self_mode='partLimit';
	$is_login_mode='';
	require("foundation/auser_validate.php");	

	//数据表定义
	$t_ask=$tablePreStr."ask";
	$t_ask_type=$tablePreStr."ask_type";

	dbtarget('r',$dbServs);
	$dbo=new dbex;
	
	switch($mod){
		//已解决
		case "solved":
			$mod_solved='class=active';
			$condition=" where status=1 ";
			$order=" order by ask_id desc ";
		break;
		//最新回复
		case "reply":
			$mod_reply='class=active';
			$condition=" where status=0 and reply_num>0 ";
			$order=" order by reply_time desc ";
		break;
		//高分问题
		case "reward":
			$mod_reward='class=active';
			$condition=" where status=0 ";
			$order=" order by reward desc ";
		break;
		//我的问题
		case "mine":
			$mod_mine='class=active';
			$condition=" where user_id=$userid ";
			$order=" order by ask_id desc ";
		break;
		//我回答过的问题
		case "mine_reply":
			$mod_mine_reply='class=active';		
			$ask_id_str=get_reply_askid($dbo,$userid);
			$order="";
			if($ask_id_str){
				$condition=" where ask_id in ($ask_id_str) ";
			}else{
				$condition=" where ask_id=0 ";
			}
		break;
		//默认未解决问题
		default:
			$mod_unsolved='class=active';
			$condition=" where status=0 ";
			$order=" order by ask_id desc ";
		break;
	}
	
	if($type){
		$condition.=" and type_id=$type ";
	}
	
	$sql="select * from $t_ask ".$condition.$order;
	$dbo->setPages(20,$page_num);//设置分页
	$ask_rs=$dbo->getRs($sql); //取得结果集
	$page_total=$dbo->totalPage; //分页总数
	
	
	//分类列表
	$sql="select * from $t_ask_type order by order_num asc ";
	$ask_type_rs=$dbo->getAll($sql);


	//控制数据显示
	$content_data_none="content_none";
	$isNull=0;
	if(empty($ask_rs)){
		$isNull=1;
		$content_data_none="";
	}
	?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/ask.css">
<link rel="stylesheet" type="text/css" href="servtools/menu_pop/menu_pop.css">
<script type='text/javascript' src='servtools/ajax_client/ajax.js'></script>
<script type="text/javascript">parent.hiddenDiv();</script>
</head>
<body id="iframecontent" >
<?php if($is_self=='Y'){?>
	<div class="create_button"><a href="modules2.0.php?app=ask_edit">我要提问</a></div>
<?php }?>
<h2 class="app_ask">问吧</h2>
<?php if($is_self=='Y'){?>
<div class="ask_bar">
    <div class="ask_class" href="javascript:void(0);" onmouseover="document.getElementById('ask_classlist').style.display='';this.className = 'ask_class active'" onmouseout="document.getElementById('ask_classlist').style.display='none';this.className = 'ask_class'">咨询分类
        <dl id="ask_classlist" style="display:none" onmouseover="this.style.display=''" onmouseout="this.style.display='none'">
            <?php foreach($ask_type_rs as $val){?>
                <dd><a href="modules2.0.php?app=ask&mod=<?php echo $mod;?>&type=<?php echo $val['id'];?>"><?php echo $val['name'];?></a></dd>
            <?php }?>
            <dd class="clear"></dd>
        </dl>
    </div>
		<ul>
			<li><a <?php echo $mod_unsolved;?> href="modules2.0.php?app=ask" hidefocus="true">待解决问题</a></li>
			<li><a <?php echo $mod_solved;?> href="modules2.0.php?app=ask&mod=solved" hidefocus="true">已解决问题</a></li>
			<li><a <?php echo $mod_reply;?> href="modules2.0.php?app=ask&mod=reply" hidefocus="true">最新回复</a></li>
			<li><a <?php echo $mod_reward;?> href="modules2.0.php?app=ask&mod=reward" hidefocus="true">高分问题</a></li>
			<li><a <?php echo $mod_mine;?> href="modules2.0.php?app=ask&mod=mine" hidefocus="true">我的提问</a></li>
			<li><a <?php echo $mod_mine_reply;?> href="modules2.0.php?app=ask&mod=mine_reply" hidefocus="true">我的回答</a></li>
       </ul>
</div>
<?php }?>
<?php if(!empty($ask_rs)){?>

    <div class="ask_listbox">
        <dl>

            <dd>
             <table class="ask_table">
                 <tr>
                    <th class="l">标题</th><th>提问者</th><th>回答数</th><th>查看数</th><th>悬赏分</th><th>时间</th>
                 </tr>
                <?php foreach($ask_rs as $val){?>
                <tr>
                    <td class="l"><a href="modules2.0.php?app=ask_show&id=<?php echo $val['ask_id'];?>"><?php echo $val['title'];?></a></td>
                    <td><a href="home2.0.php?h=<?php echo $val['user_id'];?>" target="_blank"><?php echo $val['user_name'];?></a></td>
                    <td><?php echo $val['reply_num'];?></td>
                    <td><?php echo $val['view_num'];?></td>
                    <td class="title"><span class="money">&nbsp;&nbsp;&nbsp;</span><?php echo intval($val['reward']);?></td>
                    <td><?php echo $val['add_time'];?></td>
                </tr>
                <?php }?>
            </table>
            </dd>
        </dl>
    </div>

<?php }?>
  <?php page_show($isNull,$page_num,$page_total);?>
  <div class="rs_box guide_info <?php echo $content_data_none;?>">
		对不起，没有找到相关问题！
  </div>
</div>
</body>
</html>