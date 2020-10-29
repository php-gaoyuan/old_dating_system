<?php
	require ("includes.php");
	require ("api/base_support.php");
	require ("foundation/module_users.php");
	
	//引入语言包
	$mp_langpackage = new mypalslp;
	$l_langpackage = new loginlp;
	$pu_langpackage = new publiclp;
	dbtarget('r', $dbServs);
	$dbo = new dbex;
	//echo "<pre>";print_r($dbServs);exit;
	//获取用户自定义属性列表
	$information_rs = array();
	$information_rs = userInformationGetList($dbo, '*');
	//取得国家列表
	$sql = "select * from wy_country order by id asc";
	$country_lists = $dbo->getRs($sql);
	//取得身高列表
	$sql = "select info_values from wy_user_information where info_id=6";
	$height = $dbo->getRow($sql);
	$heights = explode("\n", $height['info_values']);
	//取得收入列表
	$sql = "select info_values from wy_user_information where info_id=9";
	$income = $dbo->getRow($sql);
	$incomes = explode("\n", $income['info_values']);
	//echo "<pre>";var_dump($incomes);
?>












<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
<script src="servtools/area.js" type="text/javascript"></script>
<script src="skin/default/js/jooyea.js" type="text/javascript"></script>
</head>
<body id="iframecontent">
    <div class="create_button"><a href="modules.php?app=mypals"><?php echo $mp_langpackage->mp_re_list;?></a></div>
    <h2 class="app_friend"><?php echo $mp_langpackage->mp_mypals;?></h2>
    <div class="tabs">
        <ul class="menu">
            <li class="active"><a href="modules.php?app=mypals_search" hidefocus="true"><?php echo $mp_langpackage->mp_find;?></a></li>
        </ul>
    </div>

<div class="iframe_contentbox">
	<div class="search_box">
		<div class="search_box_ct">
			<form action='modules.php'>
				<input type='hidden' name='app' value='mypals_search_list' />
				<table cellpadding="0" cellspacing="0" class="form_table">
					<tr><th><?php echo $mp_langpackage->mp_name;?>：</th><td><input name="memName" value="" size="12" class="small-text" type="text"></td></tr>
					<tr><th><?php echo $mp_langpackage->mp_country;?>：</th><td>
						<select id="s1" name='country'>
							<option value=""><?php echo $mp_langpackage->mp_p_sel;?></option>
							<?php foreach($country_lists as $country){
								echo "<option value='{$country[cname]}'>".$country[cname]."</option>";
							}?>
						</select>
					</td></tr>
					
					<tr><th><?php echo $mp_langpackage->mp_age;?>：</th><td><select name='age' ><option value=''><?php echo $mp_langpackage->mp_none_limit;?></option><option value='16|22'>16-22<?php echo $mp_langpackage->mp_years;?></option><option value='23|30'>23-30<?php echo $mp_langpackage->mp_years;?></option><option value='31|40'>31-40<?php echo $mp_langpackage->mp_years;?></option><option value='40|100'>40<?php echo $mp_langpackage->mp_years;?><?php echo $mp_langpackage->mp_over;?></option></select></select></td></tr>
					
					<tr><th><?php echo $mp_langpackage->mp_online;?>：</th><td><input type="checkbox" name='online' value=1 /></td></tr>
					<tr><th></th><td><input value="<?php echo $mp_langpackage->mp_search;?>" class="regular-btn" type="submit"></td></tr>
				</table>
			</form>
		</div>
	</div>
</div>
</body>
</html>