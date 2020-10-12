<?php
	//必须登录才能浏览该页面
	require("foundation/auser_mustlogin.php");
	error_reporting(E_ALL);
	//引入公共模块
	require("foundation/module_mypals.php");
	require("foundation/fpages_bar.php");
	require("api/base_support.php");

	//引入语言包
	$mp_langpackage=new mypalslp;
	$user_id=get_sess_userid();
	$user_ico=get_sess_userico();
	$sort_id=intval(get_argg('sort_id'));
	$search_name=short_check(get_argp('search_name'));

	//数据表定义区
	$t_mypals=$tablePreStr."pals_mine";
	$t_pals_sort=$tablePreStr."pals_sort";

	//当前页面参数
	$page_num=trim(get_argg('page'));
	$show_none_str=$mp_langpackage->mp_no_pals;

	$dbo=new dbex;
	dbtarget('r',$dbServs);
	$sort_str='';
	$mp_list_rs=array();
	$mp_sort_list=array();
	$sql="select * from $t_mypals where user_id=$user_id and accepted > 0 ";


	$user_id = get_sess_userid();
	$sqlg = "select * from wy_users where user_id=$user_id";
	$sessuserinfo = $dbo->getRow($sqlg);

	if($sort_id!=''){
		$str=$mp_langpackage->mp_whole;
		$show_none_str=$mp_langpackage->mp_sort_pals;
		$sql.=" and pals_sort_id = $sort_id ";
	}else if($search_name!=''){
		$show_none_str=$mp_langpackage->mp_none_search;
		$sql.=" and pals_name like '%$search_name%' ";
	}
	$sql.=" order by pals_sort_id desc ";

	$dbo->setPages(20,$page_num);//设置分页
	$mp_list_rs=$dbo->getRs($sql);
	$page_total=$dbo->totalPage;//分页总数
	
	$none_data="content_none";
	$isNull=0;
	if(empty($mp_list_rs)){
		$none_data="";
		$isNull=1;
	}
	$mp_sort_list=api_proxy("pals_sort");//取得好友圈分类

?>







<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
        <script type='text/javascript' src="servtools/ajax_client/ajax.js"></script>
        <script type="text/javascript">
            function show_sort_list(obj, p_id, old_id) {
                var sortwin = document.createElement("div");
                var parentnode = document.getElementById('mypals_iframe');
                var t = obj.offsetTop;
                var l = obj.offsetLeft;
                while (obj = obj.offsetParent) {
                    t += obj.offsetTop;
                    l += obj.offsetLeft;
                }

                <?php if ($mp_sort_list) { ?>
                    sortwin.id = "sort_select_" + p_id;
                    sortwin.className = "sort_select";
                    sortwin.style.top = (t + 15) + 'px';
                    sortwin.style.left = l + 'px'; 
                    <?php foreach($mp_sort_list as $val) { ?>
                        <?php $sort_str .= "<li><a href='javascript:void(0);' onclick=changeSort(\"+p_id+\",".$val['id'].",this,\"+old_id+\");>".$val['name']."</a></li>";?>
                    <?php } ?>
                    sortwin.innerHTML = "<div class='sort_sel_box'><ul><?php echo $sort_str;?></ul></div>";
                    parentnode.appendChild(sortwin);
                    sortwin.focus(); 
                <?php } ?>

                if (document.all) {
                    sortwin.onblur = function() {
                        window.setTimeout(function() {
                            parentnode.removeChild(sortwin);
                        },
                        250);
                    }
                } else {
                    sortwin.onclick = function() {
                        window.setTimeout(function() {
                            parentnode.removeChild(sortwin);
                        },
                        50);
                    }
                }
            }

            function changeSort(p_id, sort_id, obj, old_id) {
                var old_value = document.getElementById(p_id + '_old_value').value;
                if (navigator.appName.indexOf("Explorer") > -1) {
                    var sortName = obj.innerText;
                } else {
                    var sortName = obj.textContent;
                }
                var changeSort = new Ajax();
                changeSort.getInfo("do.php?act=pals_change&id=" + p_id, "post", "app", "name=" + sortName + "&sort_id=" + sort_id + "&old_sort_id=" + old_value,
                function(c) {
                    document.getElementById('sort_name_' + p_id).innerHTML = "<span>" + sortName + "</span>";
                    document.getElementById(p_id + '_old_value').value = sort_id;
                });
            }
            function changeStyle(obj, p_id) {
                obj.className = 'hover';
            }
            function recoverStyle(obj, p_id) {
                obj.className = '';
            }
        </script>
        <style>
            .content_ch1{width:90px;height:20px;background:url("skin/default/jooyea/images/ch.jpg") no-repeat;} 
            .content_ch1 a{width:22px;height:20px;display:block;float:left;cursor:pointer;}
        </style>
    </head>
    
    <body id="iframecontent">
        <div class="create_button">
            <a href="modules.php?app=mypals_search">
                <?php echo $mp_langpackage->mp_add;?>
            </a>
        </div>
        <h2 class="app_friend">
            <?php echo $mp_langpackage->mp_mypals;?>
        </h2>
        <div class="tabs">
            <ul class="menu">
                <li class="active">
                    <a href="modules.php?app=mypals" title="<?php echo $mp_langpackage->mp_list;?>">
                        <?php echo $mp_langpackage-> mp_list;?>
                    </a>
                </li>
                <li>
                    <a href="modules.php?app=mypals_request" title="<?php echo $mp_langpackage->mp_req;?>">
                        <?php echo $mp_langpackage->mp_req;?>
                    </a>
                </li>
                <li>
                    <a href="modules.php?app=mypals_invite" title="<?php echo $mp_langpackage->mp_invite;?>">
                        <?php echo $mp_langpackage->mp_invite;?>
                    </a>
                </li>
                <!--<li><a href="modules.php?app=mypals_sort" title="<?php echo $mp_langpackage->mp_m_sort;?>"><?php echo $mp_langpackage->mp_m_sort;?></a></li>-->
            </ul>
        </div>
        <div class="search_friend">
            <div class="share_box right">
                <form method='post' action='' id='search_pals'>
                    <input class="small-text" type='text' maxlength='20' value='<?php echo $search_name;?>' id='search_name' name='search_name' style="color:#333; background-image:nonel; background-color:#fff;" autocomplete='off' />
                    <span class="share_button" onclick="document.getElementById('search_pals').submit();">
                        <?php echo $mp_langpackage->mp_search;?>
                    </span>
                </form>
            </div>
            <!-- <select id="sort_id" class="tleft" onchange="javascript:location.href='modules.php?app=mypals&sort_id='+this.value">
            <option value='' 'selected'><?php echo $mp_langpackage->mp_all;?></option>
            <?php foreach($mp_sort_list as $val){?>
            <?php if($sort_id==$val['id']){?><?php $select='selected';?><?php }?>
            <?php if($sort_id!=$val['id']){?><?php $select='';?><?php }?>
            <option value='<?php echo $val['id'];?>' <?php echo $select;?>><?php echo $val['name'];?> (<?php echo $val['count'];?>)</option>
            <?php }?>
            </select> -->
        </div>
        <div id="mypals_iframe">
        <?php if($mp_list_rs){ ?>
            <div class="friend_list">
                <div style="text-align:right;line-height:25px;margin-top:10px;">
                    <a href="do.php?act=del_mypals" onclick='return confirm("If you delete all your friends")'
                    style="display:inline-block;border-radius:5px;background:#CE0000;color:#fff;border:1px solid #F0F0F0;padding:0px 10px;">
                        Delete All
                    </a>
                </div>
                <ul id="tab0_content0" class="user_list">
                    <?php foreach($mp_list_rs as $rs){ ?>
                        <?php $psort_name=$rs[ 'pals_sort_name']?$rs[ 'pals_sort_name']:$mp_langpackage->mp_select_sort;?>
                        <li onmouseover='changeStyle(this,<?php echo $rs["id"];?>)' onmouseout='recoverStyle(this,<?php echo $rs["id"];?>)'>
                            <div class="photo">
                                <a href="home2.0.php?h=<?php echo $rs['pals_id'];?>" target="_blank" class="avatar">
                                    <img title="<?php echo $mp_langpackage->mp_en_home;?>" src=<?php echo $rs[ 'pals_ico']; ?> onerror="parent.pic_error(this)" />
                                </a>
                            </div>
                            <dl>
                                <dt>
                                    <?php echo $rs[ 'pals_name'];?>
                                </dt>
                                <input type='hidden' value='<?php echo $rs["pals_sort_id"];?>' id='<?php echo $rs["pals_id"];?>_old_value' />
                                <!--<dd class="sort"><a href="javascript:void(0);" onclick='show_sort_list(this,<?php echo $rs["pals_id"];?>,<?php echo $rs["pals_sort_id"];?>)' hidefocus="true" id='sort_name_<?php echo $rs["pals_id"];?>'><span><?php echo $psort_name;?></span></a></dd><dd class="sort">
                                <a class="send_bt" href='modules.php?app=msg_creator&2id=<?php echo $rs["pals_id"];?>&nw=1' target="frame_content"><?php echo str_replace("{he}",get_TP_pals_sex($rs["pals_sex"]),$mp_langpackage->mp_scrip);?></a>
                                </dd> -->



                                <!-- Add By Root Time:20141017 Begin -->
                                <div class="content_ch1" style="background:url(skin/default/jooyea/images/ch.jpg) ">
                                    <a style="width:22px;height:22px;float:left;display:block" href="javascript:;"
                                    title="<?php echo $rf_langpackage->rf_liaotian;?>"  onclick="parent.open_chat('<?php echo $rs[pals_id];?>');">
                                    </a>
                                    <a style="width:22px;height:22px;float:left;display:block" href="javascript:;"
                                    title="<?php echo $rf_langpackage->rf_dazhaohu;?>" onclick="top.hi_action(<?php echo $rs["
                                    pals_id "];?>)">
                                    </a>
                                    <a style="width:22px;height:22px;float:left;display:block" href="javascript:;"
                                    title="<?php echo $rf_langpackage->rf_fayoujian;?>" onclick="location.href='modules.php?app=msg_creator&2id=<?php echo $rs["
                                    pals_id "];?>';return false;">
                                    </a>
                                    <a style="width:22px;height:22px;float:left;display:block" href="plugins/gift/giftshop.php"
                                    title="<?php echo $rf_langpackage->rf_songliwu;?>">
                                    </a>
                                </div>
                                <!-- Add By Root Time:20141017 End -->



                            </dl>
                            <div class="tool" id="ctrl_<?php echo $rs['id'];?>">
                                <a title="<?php echo $mp_langpackage->mp_del;?>" class="del_bt" href="do.php?act=del_mypals&mypals_id=<?php echo $rs['pals_id'];?>&sort_id=<?php echo $rs['pals_sort_id'];?>"
                                onclick='return confirm("<?php echo $mp_langpackage->mp_a_del;?>")'>
                                </a>
                            </div>
                        </li>
                    <?php }?>
                </ul>
            </div>
        <?php }?>
        </div>
        <div class="clear"></div>
        <?php echo page_show($isNull,$page_num,$page_total);?>
        <div class="guide_info <?php echo $none_data;?>">
            <?php echo $show_none_str;?>
        </div>
        <script type='text/javascript' src="im/ajax.php?act=updatapals"></script>
    </body>

</html>