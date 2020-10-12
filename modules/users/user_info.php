<?php
/*
 * 注意：此文件由tpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/users/user_info.html
 * 如果您的模型要进行修改，请修改 models/modules/users/user_info.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如有您有问题请到官方论坛（http://tech.jooyea.com/bbs/）提问，谢谢您的支持。
 */
?><?php
 //引入模块公共方法文件
 require("foundation/fgrade.php");
 require("foundation/module_users.php");
 require("api/base_support.php");

	//语言包引入
	$u_langpackage=new userslp;

	//变量获得
	$ses_uid=get_sess_userid();
	$url_uid=intval(get_argg('user_id')?get_argg('user_id'):$ses_uid);
	
	$show_type=intval(get_argg('single'));
	$is_finish=intval(get_argg('is_finish'));

  //引入模块公共权限过程文件
	$is_self_mode='partLimit';
	$is_login_mode='';
	require("foundation/auser_validate.php");
	
	//数据表定义
	$t_user_information=$tablePreStr."user_information";

	dbtarget('r',$dbServs);
	$dbo=new dbex;
	
	//获取用户自定义属性列表
	$information_rs=array();
	$information_rs=userInformationGetList($dbo,'*');
	
	//用户自定义资料预定义
	$info_c_rs=array();
	$info_c_rs=userInformationCombine($dbo,$userid);
	
	//用户已定义资料
	/*$user_row = api_proxy("user_self_by_uid","*",$userid);*/
	$user_row=$dbo->getRow("select * from wy_users where user_id='$url_uid'");
	
	//性别预定义
	$woman_c=$user_row['user_sex'] ? "checked=checked":"";
	$man_c=$user_row['user_sex'] ? "":"checked=checked";
	
	$county = $dbo->getRs("select id,cname from wy_country");
	
	$uinfo=$dbo->getRow("select height,weight,income,birth_year,birth_month,birth_day,waimao,sexual,birth_city,country from wy_users where user_id='$ses_uid'");
	//print_r($county);
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<base href='<?php echo $siteDomain;?>' />
<link rel="stylesheet" type="text/css" href="skin/<?php echo $skinUrl;?>/css/iframe.css">
<script src="servtools/area.js" type="text/javascript"></script>
<SCRIPT language=JavaScript src="servtools/ajax_client/ajax.js"></SCRIPT>
</head>
<script type="text/javascript">
	function check_form(){
		var birth_year=document.getElementById('birth_year').value;
		var cou=document.getElementById('cou').value;
		var income=document.getElementById('income').value;
		var height=document.getElementById('height').value;
		var weight=document.getElementById('weight').value;
		
		if(!birth_year || !cou || !income || !height || !weight ){
			parent.Dialog.alert("<?php echo $u_langpackage->u_fill;?>");
			return false;
		}
	}
</script>
<script type="text/javascript">
	
	//定义一个http_request
	var http_request;
	//发送请求到服务器[用户名]
	function sendRequest(){
	
			//得到用户选择的是哪个省
			var sheng=document.getElementById('sheng').value;
			
			//window.alert("用户选择的是:"+sheng);
			
			//创建ajax引擎.
			if(window.ActiveXObject){
				
			//	window.alert("ie");
				//说明用户是ie浏览器
				http_request=new ActiveXObject("Microsoft.XMLHTTP");
			}else{
				
				//window.alert("no ie");
				//别的浏览器
				http_request=new XMLHttpRequest();
			}
			
			
			//如果ajax引擎创建ok
			if(http_request){
				
				var url="user_city.php?sheng="+sheng;
				//alert(url);
				http_request.open("GET",url,true);
				
				http_request.onreadystatechange=chuli;
				
				http_request.send();
				
			}
		
		
		
	}
	
	//处理函数
	function chuli(){
		
		//成功返回
		if(http_request.readyState==4){
			
			if(http_request.status==200){


					
				//取出结果
				var cities=http_request.responseXML.getElementsByTagName("city");

				
				
				//把返回的城市动态添加到city控件 
				var mycity=document.getElementById('city');
				//清空一下select
				mycity.options.length=0;
				for(var i=0;i<cities.length;i++){
					
					
					mycity.options[i]=new Option(cities[i].firstChild.data,cities[i].firstChild.data);
					
					//window.alert(cities[i].firstChild.data);
				}
			}
			
		}
	}
	
	
	-->
</script>
<script type="text/javascript">
	
	//定义一个http_request
	var http_request;
	//发送请求到服务器[用户名]
	function sendProvince(){
	
			//得到用户选择的是哪个省
			var citys=document.getElementById('city').value;
			
			//window.alert("用户选择的是:"+citys);
			
			//创建ajax引擎.
			if(window.ActiveXObject){
				
			//	window.alert("ie");
				//说明用户是ie浏览器
				http_request=new ActiveXObject("Microsoft.XMLHTTP");
			}else{
				
				//window.alert("no ie");
				//别的浏览器
				http_request=new XMLHttpRequest();
			}
			
			
			//如果ajax引擎创建ok
			if(http_request){
				
				var url="user_province.php?citys="+citys;
				//alert(url);
				http_request.open("GET",url,true);
				
				http_request.onreadystatechange=citychuli;
				
				http_request.send();
				
			}
		
		
		
	}
	
	//处理函数
	function citychuli(){
		
		//成功返回
		if(http_request.readyState==4){
			
			if(http_request.status==200){


					
				//取出结果
				var country=http_request.responseXML.getElementsByTagName("citys");

				
				//alert(country.length);
				//把返回的城市动态添加到city控件 
				var mycity=document.getElementById('country');
				//alert(mycity.length);
				//清空一下select
				mycity.options.length=0;
				for(var i=0;i<country.length;i++){
					
					
					mycity.options[i]=new Option(country[i].firstChild.data,country[i].firstChild.data);
					
					//window.alert(country[i].firstChild.data);
				}
			}
			
		}
	}
	
	
	-->
</script>
<style>
.form_table img{max-width:480px}
</style>
<body id="iframecontent">
<?php if($url_uid == $ses_uid){?>
<div class="create_button">
	<a target="frame_content" href="modules.php?app=user_info&is_finish=1"><?php echo $u_langpackage->u_perfect_info;?></a>
</div>
<?php }?>
<h2 class="app_user"><?php echo $u_langpackage->u_info;?></h2>
<?php if(!$show_type){?>
<?php if(!$is_finish){?>
<div class="tabs">
	<ul class="menu">
	  <li class="active"><a href="modules.php?app=user_info" title="<?php echo $u_langpackage->u_info;?>"><?php echo $u_langpackage->u_info;?></a></li>
	  <li><a href="modules.php?app=user_ico" title="<?php echo $u_langpackage->u_icon;?>"><?php echo $u_langpackage->u_icon;?></a></li>
	  <li><a href="modules.php?app=user_pw_change" title="<?php echo $u_langpackage->u_pw;?>"><?php echo $u_langpackage->u_pw;?></a></li>
	  
	  <li><a href="modules.php?app=user_affair" title="<?php echo $u_langpackage->u_set_affair;?>"><?php echo $u_langpackage->u_set_affair;?></a></li>
	</ul>
</div>
<div class="rs_head"><?php echo $u_langpackage->u_fill;?></div>
<?php }?>
		<form name="form" method="post" action="do.php?act=user_info&is_finish=<?php echo $is_finish;?>" onsubmit="return check_form();">
			<table class="form_table" border="0" style="display:block;border:1px solid #ccc;border-radius:6px;width;460px;padding:10px 0">
				<tr>
					<th><?php echo $u_langpackage->u_name;?></th>
					<td><?php echo $user_row['user_name'];?> </span></td>
				</tr>

				<tr>
					<th><?php echo $u_langpackage->u_sex;?></th>
					<td>
							<?php echo ($user_row['user_sex']==0)?$u_langpackage->u_wen:$u_langpackage->u_man;?>
					</td>
				</tr>

				<tr>
					<th><?php echo $u_langpackage->u_bird;?></th>
					<td>
						<?php echo get_birth_date($user_row['birth_year'],$user_row['birth_month'],$user_row['birth_day']);?>
					</td>
				</tr>

				<tr >
					<th><?php echo $u_langpackage->u_res;?></th>

					<td>
						<div >
						
							<select onchange="document.getElementById('cou').value=this.value">
							<?php if($user_row['country']){?>
							<option value="<?php echo $user_row['country'];?>" checked><?php echo $user_row["country"];?></option>
							<?php }?>
							<option value="">-<?php echo $u_langpackage->u_select;?>-</option>
							
							<?php foreach($county as $c){ ?>
							
							<option value="<?php echo $c['cname']; ?>"><?php echo $c['cname'];?></option>
							<?php }?>
							</select>
							<input type='hidden' name='country' id="cou" value='<?php echo $uinfo["country"];?>' />
							
						
						</div>
					</td>
				</tr>
				<tr>
					<th><?php echo $u_langpackage->waimao;?></th>
					<td>
						<label><input type="radio"  name="waimao" value="1" <?php if($uinfo['waimao']==1) echo 'checked';?>/><?php echo $u_langpackage->yiban;?>&nbsp;</label>
						<label><input type="radio"  name="waimao" value="2"<?php if($uinfo['waimao']==2) echo 'checked';?>/><?php echo $u_langpackage->haokan;?>&nbsp; </label>
						<label><input type="radio"  name="waimao" value="3"<?php if($uinfo['waimao']==3) echo 'checked';?>/><?php echo $u_langpackage->chuzhong;?> &nbsp;</label>
					</td>
				</tr>
				<tr>
					<th><?php echo $u_langpackage->xingquxiang;?></th>
					<td>
						<label><input type="radio"  name="sexual" value="1" <?php if($uinfo['sexual']==1) echo 'checked';?>/><?php echo $u_langpackage->yixing;?>&nbsp; </label>
						<label><input type="radio"  name="sexual" value="2" <?php if($uinfo['sexual']==2) echo 'checked';?>/><?php echo $u_langpackage->tongxing;?>&nbsp; </label>
						<label><input type="radio"  name="sexual" value="3"<?php if($uinfo['sexual']==3) echo 'checked';?>/><?php echo $u_langpackage->shuangxing;?>&nbsp; </label>
					</td>
				</tr>
				<tr>
					<th><?php echo $u_langpackage->shengao;?></th>
					<td>
						<select name="height" id="height">
						<?php if($uinfo['height']){?>
						<option value="<?php echo $uinfo['height'];?>"><?php echo $uinfo['height'];?></option>
						<?php }?>
						<option value=""><?php echo $u_langpackage->u_select;?></option>
							<script>
								for(var i=150;i<200;i++){
									document.write("<option value="+i+">"+i+"</option>");
								}
							</script>
						</select>cm
					</td>
				</tr>
				<tr>
					<th><?php echo $u_langpackage->tizhong;?></th>
					<td>
						<input type="text" class="small-text" name="weight" id="weight" value="<?php echo $uinfo['weight'];?>" />kg
					</td>
				</tr>
				
				<tr>
					<th><?php echo $u_langpackage->shouru;?></th>
					<td>
						
						<select name="income" id="income">
						<?php if($uinfo['income']){?>
						<option value="<?php echo $uinfo['income'];?>"><?php echo $uinfo['income'];?></option>
						<?php }?>
						<option value=""><?php echo $u_langpackage->u_select;?></option>
						<option value="$10,000">$10,000</option>
						<option value="$10,000-30,000">$10,000-30,000</option>
						<option value="$30,000-50,000">$30,000-50,000</option>
						<option value="$50,000-80,000">$50,000-80,000</option>
						<option value="$80,000-120,000">$80,000-120,000</option>
						<option value="$120,000-150,000">$120,000-150,000</option>
						<option value="$150,000-200,000">$150,000-200,000</option>
						<option value="$200,000-300,000">$200,000-300,000</option>
						<option value="$300,000-800,000">$300,000-800,000</option>
						<option value="$800,000 Above">$800,000 Above</option></select>
					</td>
				</tr>
				
				<!--
				<tr style="display:none;">
					<th><?php echo $u_langpackage->u_res;?></th>

					<td >
						<div id="birth"><select name='s1' id="s1" onchange="document.getElementById('birth_province').value=this.value;"><option><?php echo $u_langpackage->u_select;?></option></select>
							<input type='hidden' name='birth_province' id='birth_province' value='<?php echo $user_row["birth_province"];?>' />
							<select name='s2' id="s2" onchange="document.getElementById('birth_city').value=this.value;"><option><?php echo $u_langpackage->u_select;?></option></select>
							<input type='hidden' name='birth_city' id='birth_city' value='<?php echo $user_row["birth_city"];?>' />
						  <script type="text/javascript">
								setup();
								document.getElementById('s1').value='<?php echo $user_row["birth_province"];?>';
								change(1);
								document.getElementById('s2').value='<?php echo $user_row["birth_city"];?>';
							</script>

						</div>
					</td>
				</tr>
				-->
				<tr style="display:none;">
					<th><?php echo $u_langpackage->u_res;?></th>
					<td>
						<div id="reside">
							<select name='r1' id="r1" ><option><?php echo $u_langpackage->u_select;?></option></select>
							<input type='hidden' name='reside_province' id='reside_province' value='<?php echo $user_row["reside_province"];?>' />
							<select name='r2' id="r2" ><option><?php echo $u_langpackage->u_select;?></option></select>
							<input type='hidden' name='reside_city' id='reside_city' value='<?php echo $user_row["reside_city"];?>' />
						  <script type="text/javascript">
								setup2();
								document.getElementById('r1').value='<?php echo $user_row['reside_province'];?>';
								change2(1);
								document.getElementById('r2').value='<?php echo $user_row['reside_city'];?>';
							</script>

						</div>
					</td>
				</tr>
				
			
			
				<tr>
					<th><?php echo $u_langpackage->u_outline;?></th>
					<td><textarea id="msContent" maxlength="150" name="gerenjieshao" ><?php echo $user_row['gerenjieshao'];?></textarea></td>
				</tr>
<SCRIPT language=JavaScript src="servtools/kindeditor/kindeditor.js"></SCRIPT>
<script>
	var editor;
	KindEditor.ready(function(K) {
		editor = K.create('#msContent', {
			allowFileManager : true,
			width : '380px',
			height:'200px',
			items : [ 
				'fontname', 'fontsize', '|','forecolor','hilitecolor','|',   'bold',
				'italic', 'underline', '|', 'emoticons',  'image',
			],
		});

	});
</script>
				<tr>
					<th><?php echo $u_langpackage->u_reg_time;?></th>
					<td><?php echo $user_row['user_add_time'];?></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" name="profilesubmit2" value="<?php echo $u_langpackage->u_b_con;?>" class="regular-btn" />
						<input type="reset" name="Submit" class="regular-btn" value="<?php echo $u_langpackage->u_b_can;?>" />
					</td>
				</tr>
			</table>
</form>
	<?php }?>
	<?php if($show_type){?>
		<table class="form_table"  style="display:block;border:1px solid #ccc;border-radius:6px;width;460px;padding:10px 0">
			<tr><th><?php echo $u_langpackage->u_name;?>：</th><td><?php echo $user_row['user_name'];?></td></tr>
			<tr><th><?php echo $u_langpackage->u_sex;?>：</th><td><?php echo $man_c ? $u_wen : $u_man;?></td></tr>
			<tr><th><?php echo $u_langpackage->u_bird;?>：</th><td><?php echo $user_row["birth_year"]&&$user_row["birth_month"]&&$user_row["birth_day"]?$user_row["birth_year"].$u_langpackage->u_year.$user_row["birth_month"].$u_langpackage->u_month.$user_row["birth_day"].$u_langpackage->u_day:$u_langpackage->u_set;?></td></tr>
			<tr><th><?php echo $u_langpackage->u_res;?>：</th><td><?php echo $user_row['country']?$user_row['country']:$u_langpackage->u_set;?></td></tr>
			<tr><th><?php echo $u_langpackage->waimao;?>：</th><td><?php if($user_row['waimao']==1){echo $u_langpackage->yiban;}elseif($user_row['waimao']==2){echo $u_langpackage->haokan;}elseif($user_row['waimao']==3){echo $u_langpackage->chuzhong;}else{echo $u_langpackage->u_set;}?></td></tr>			<tr><th><?php echo $u_langpackage->xingquxiang;?>：</th><td><?php if($user_row['sexual']==1){echo $u_langpackage->yixing;}elseif($user_row['sexual']==2){echo $u_langpackage->tongxing;}elseif($user_row['sexual']==3){echo $u_langpackage->shuangxing;}else{echo $u_langpackage->u_set;}?></td></tr>			<tr><th><?php echo $u_langpackage->shengao;?>：</th><td><?php echo $user_row['height']?$user_row['height']:$u_langpackage->u_set;?>cm</td></tr>			<tr><th><?php echo $u_langpackage->tizhong;?>：</th><td><?php echo $user_row['weight']?$user_row['weight']:$u_langpackage->u_set;?>kg</td></tr>			
			<tr><th><?php echo $u_langpackage->shouru;?>：</th><td><?php echo $user_row['income']?$user_row['income']:$u_langpackage->u_set;?></td></tr>
			<tr>
				<th><?php echo $u_langpackage->u_outline;?></th>
				<td><div style="width:300px;border:1px solid #D3D3D3;border-radius:5px;padding:10px;min-height:100px;" ><?php if($user_row['gerenjieshao']){echo $user_row['gerenjieshao'];}else{echo $u_langpackage->u_set;}?></div></td>
			</tr>

			
			
		</table>
	<?php }?>
	
	
</body>
</html>
