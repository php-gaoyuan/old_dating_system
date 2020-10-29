<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/uiparts/search.html
 * 如果您的模型要进行修改，请修改 models/uiparts/search.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
/*
 * 此段代码由debug模式下生成运行，请勿改动！
 * 如果debug模式下出错不能再次自动编译时，请进入后台手动编译！
 */
/* debug模式运行生成代码 开始 */
if(!function_exists("tpl_engine")) {
	require("foundation/ftpl_compile.php");
}
if(filemtime("templates/default/uiparts/search.html") > filemtime(__file__) || (file_exists("models/uiparts/search.php") && filemtime("models/uiparts/search.php") > filemtime(__file__)) ) {
	tpl_engine("default","uiparts/search.html",1);
	include(__file__);
}else {
/* debug模式运行生成代码 结束 */
?><?php
	require("api/base_support.php");
	require("foundation/module_users.php");
	//引入语言包
	$mp_langpackage=new mypalslp;
	$l_langpackage=new loginlp;
	$pu_langpackage=new publiclp;
		
	
	dbtarget('r',$dbServs);
	$dbo=new dbex;
	//获取用户自定义属性列表
	$information_rs=array();
	$information_rs=userInformationGetList($dbo,'*');
?>	<div class="hyzxhytop">

	<table width="782" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><b><?php echo $pu_langpackage->pu_all;?></b></td>
    <td>
                <form action='modules.php'>
				<input type='hidden' name='app' value='mypals_search_list2' />

	<table width="500" border="0" cellspacing="0" cellpadding="0" style="float:left; margin-left:10px;">
  <tr>
    <td><img src="skin/<?php echo $skinUrl;?>/images/ico_ss1.jpg" width="16" height="16" /></td>
    <td><?php echo $pu_langpackage->pu_myfind;?></td>
    <td><select name="sex" id="search-option">
               <option value="0" selected='1'><?php echo $pu_langpackage->pu_woman;?></option>
			   <option value="1"><?php echo $pu_langpackage->pu_man;?></option>
           </select></td>
    <td><?php echo $pu_langpackage->pu_agename;?></td>
    <td>
	<select name="age" id="search-option">
               <option value="" selected='1'><?php echo $mp_langpackage->mp_none_limit;?></option>
            <option value='16|22'>16-22<?php echo $mp_langpackage->mp_years;?></option>
            <option value='23|30'>23-30<?php echo $mp_langpackage->mp_years;?></option>
            <option value='31|40'>31-40<?php echo $mp_langpackage->mp_years;?></option>
            <option value='40|100'>40<?php echo $mp_langpackage->mp_years;?><?php echo $mp_langpackage->mp_over;?></option>
           </select>	</td>
    <td><?php echo $pu_langpackage->pu_year;?></td>
    <td>&nbsp;</td>
    <td><?php echo $pu_langpackage->pu_nationality;?></td>
    <td>
					<?php foreach($information_rs as $val){?>
						<?php if($val['info_name']=='Country'){?>
						
							
						<?php echo getInformationValue($dbo,$val['input_type'],$val['info_values'],$val['info_id'],0);?>
					 
					  <?php }?>
					<?php }?>

    </td>
    <td><input type="image" src="skin/<?php echo $skinUrl;?>/images/button_so2.jpg" /></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</td>
    <td><span><a href="modules.php?app=mypals_search2"><?php echo $pu_langpackage->pu_advanced;?></a></span></td>
  </tr>
</table>

</div><?php } ?>