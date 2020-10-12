<?php
	$rl=new recaffairlp;
	$u_langpackage=new userslp;

	$sql="select * from wy_horn order by `end_time` desc limit 8";
	$horn_list=$dbo->getRs($sql);
	$horn_list[]=array();
	$horn_list[]=array();
	//echo "<pre>";print_r($rl);exit;
?>



<!DOCTYPE >
<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8">
		<title></title>
		
		<script charset="utf-8" src="skin/default/jooyea/jquery-1.9.1.min.js"></script>
		<script>var jq=jQuery.noConflict();</script>
		<script>
			jq(function(){
				jq('.shell').mouseover(function(){
					jq('.horn_fanyi').show();
				}).mouseout(function(){
					setTimeout(function(){jq('.horn_fanyi').hide()},10000)
				})
			})
			function fyc(id,to,fid){
				var text=jq('#h_con_'+id).html();
				
				var need=0;
				need=len(text)/100;
				if(need<1) need=1;
				top.Dialog.confirm('<?php echo $u_langpackage->fy_tishi2;?> '+need,function(){
					jq.get("fanyi.php",{lan:text,tos:to,ne:need,fid:fid},function(c){
						if(c==0){
							top.Dialog.alert("<?php echo $u_langpackage->fy_tishi1;?>");
							return false;
						}
						jq('#fan_list').css('display','none')
						jq('#h_con_'+id).html(c)
					});
				})
			}
			function len(s) {//按字节计算中英文字符长度
				var l = 0;
				var a = s.split('');
				for (var i=0;i<a.length;i++) {
					if (a[i].charCodeAt(0)<299) {
						l++;
					} else {
						l+=2;
					}
				}
				return l;
			}
		</script>
	</head>
	<body>
		<!--把下面代码加到<head>与</head>之间-->
		<style type="text/css">
		*{ margin:0; padding:0}
		.shell{position:relative;top:0px; width:750px }
		.shell a{display:block;line-height:30px;text-decoration:none;color:#333;font-family:Arial;font-size:13px;cursor:default; height:30px}
		.shell a span{font-size:12px;}
		.shell a:hover b{color:#FF0000}
		#Y{height:30px;overflow:hidden;text-align:left;}
		.horn_fanyi{float:right;margin-top:-25px;font-size:12px;line-height:24px;cursor:pointer}
		</style>
		<div class="shell" >
			<div id="Y">
				<?php foreach($horn_list as $k=>$v){ ?>
				<a>
					<span><?php echo $v['user_name'];?>:</span>
					<b style="font-weight:100" id="h_con_<?php echo $k;?>"><?php echo $v['horn_content'];?></b>
				</a>
				<span class="horn_fanyi" style=" display:none" >
					<select name="fanyif" class="fanyifs"  onchange="fyc('<?php echo $k;?>',this.value,<?php echo $v['user_id'];?>)">
						<option value=""><?php echo $rl->rf_fanyi;?></option>
						<option value="en">English</option>
						<option value="zh">中文(简体)</option>
						<option value="kor">한국어</option>
						<option value="ru">русский</option>
						<option value="spa">Español</option>
						<option value="fra">Français</option>
						<option value="ara"> عربي</option>
						<option value="jp">日本語</option>
					</select>
				</span>
				<?php } ?>
			</div> 
		</div>
		
		<script type="text/javascript">
			var o=document.getElementById("Y"),p=0,d=o.innerHTML;d+=d;
			var intv=setInterval('~Top%30||p++;p%72?1:~Top=++~Top%(~Height/2)'.replace(/~/g,'o.scroll'),30);
			jq('body').mouseover(function(){
				clearInterval(intv);
			})
			setInterval(function(){
				window.location.reload()
			},20000);
		</script>
	</body>
</html>