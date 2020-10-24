<?php
header("content-type:text/html;charset=utf-8");
require ("foundation/asession.php");
require ("configuration.php");
require ("includes.php");
//必须登录才能浏览该页面
require ("foundation/auser_mustlogin.php");
require ("foundation/module_users.php");
require ("foundation/fplugin.php");
require ("api/base_support.php");
require ("foundation/fdnurl_aget.php");
require ("foundation/fgrade.php");
//语言包引入
$u_langpackage = new userslp;
$ef_langpackage = new event_frontlp;
$mn_langpackage = new menulp;
$pu_langpackage = new publiclp;
$mp_langpackage = new mypalslp;
$s_langpackage = new sharelp;
$hi_langpackage = new hilp;
$l_langpackage = new loginlp;
$rp_langpackage = new reportlp;
$ah_langpackage = new arrayhomelp;
$rm_langpackage = new readmorelp;
$count0520 = 0;
$dbo = new dbex; //连接数据库执行
dbtarget('r', $dbServs);
$user_id = get_sess_userid(); //删除之后客户机获取缓存中的id，
$sqlg = "select * from wy_users where user_id={$user_id}";
$userinfo = $dbo->getRow($sqlg);
$sex = $userinfo['user_sex'];
$user_name = get_sess_username();
?>



<!DOCTYPE html>
<html xmlns:ng="http://angularjs.org">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title></title>
	<link href="./template/main/base_icon-min.css" rel="stylesheet" type="text/css">
	<link href="./template/main/index-min.css" rel="stylesheet" type="text/css">
	<link href="./template/main/jqzysns-min.css" rel="stylesheet" type="text/css">
	<link href="./template/main/friends_visit_other_lf-min.css" rel="stylesheet" type="text/css">
	<link href="./template/main/optimization-icon.css" rel="stylesheet" type="text/css">
	<link href="./template/main/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css">
	<link href="./template/main/something.css" rel="stylesheet" type="text/css">
	<script src="./template/main/jquery-1.7.min.js"></script>
	<script src="servtools/ajax_client/ajax.js"></script>

	<script type="text/javascript" >
		//ajax回调函数
		function get_com_callback(content,type_id,mod_id){
			if(content&&frame_content.$("show_"+type_id+"_"+mod_id))
			{
				frame_content.$("show_"+type_id+"_"+mod_id).style.display='';
				var history_com=frame_content.$("show_"+type_id+"_"+mod_id).innerHTML;
				frame_content.$("show_"+type_id+"_"+mod_id).innerHTML=history_com+content;
			}
		}

		//评论翻译
		function fyc_com(id,to,fid){
			var text=$('#sub_com_'+id).html();
			var need=0;
			need=len(text)/100;
			if(need<1) need=1;
			top.Dialog.confirm('<?php echo $u_langpackage->fy_tishi2;?> '+need,function(){
				$.get("fanyi.php",{lan:text,tos:to,ne:need,fid:fid},function(c){
					if(c==0){
						top.Dialog.alert("<?php echo $u_langpackage->fy_tishi1;?>");
						return false;
					}
					$('#sub_com_'+id).html(c);
				});
			})
		}
		
		//评论翻译
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

		//取得评论内容
		function get_mod_com(type_id,mod_id,start_num,end_num){
			if(frame_content.$("max_"+type_id+"_"+mod_id)){
				var max_num=parseInt(frame_content.$("max_"+type_id+"_"+mod_id).innerHTML);
				start_num=max_num;
			}
			var ajax_get_com=new Ajax();
			ajax_get_com.getInfo("modules2.0.php","GET","app","app=restore&mod_id="+mod_id+"&type_id="+type_id+"&start_num="+start_num+"&end_num="+end_num,function(c){
				//get_com_callback(c,type_id,mod_id);
				//document.write(c);
			});
		}
		window.onload=function(){
			var _height=$(document).height();
			parent.set_xxs_height(_height);
			//alert(_height);
		}

	    // 计算页面的实际高度，iframe自适应会用到
	    function calcPageHeight(doc) {
	        var cHeight = Math.max(doc.body.clientHeight, doc.documentElement.clientHeight)
	        var sHeight = Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight)
	        var height  = Math.max(cHeight, sHeight)
	        return height
	    }

	    function resizeWin(){
	    	var height = calcPageHeight(document);
	        parent.document.getElementById('ifr').style.height = height +100+ 'px';
	    }
	    window.onload = function() {
	        var height = calcPageHeight(document);
	        parent.document.getElementById('ifr').style.height = height +100+ 'px';
	    }
	</script>
	<script>	
		$(function(){
			/*****语言选择菜单******************/
		    $(".js_select_top").on('click', function (e) {
	        	$(this).find("ul").toggle();
	        	e.stopPropagation();
	    	});
		
		
		    //模拟select--正常
		    $(".js_select_top ul").on('click', 'li', function (e) {
		        var selected = $(this).text();
		        var value = $(this).attr("langs-lang");
		        $(this).closest(".js_select_top").find("span").text(selected).attr("data-lang", value);
				  $(this).closest(".js_select_top").find("input").val(value);
		        $("#LetterLang").val($(this).attr("langs-lang")); //私信选择翻译语言
		        if ($("#LetterLang").val() != "no") {//私信是否翻译
		            $("#IsTrans").val("yes");
		        }
		        else if ($("#LetterLang").val() == "no") {
		            $("#IsTrans").val("no");
		        }
		        $(this).parent().hide();
		        e.stopPropagation();
		    });

		    $(".faces_icon1_lq").on("click", function () {
		        $(".js_select_top ul").hide();
		    });
		
			/*****语言选择菜单****************/
			/****************/
			
			$('.reply_simple_lq').on("focus", function(){
		        $("#face_jqface").hide();
				$('.reply_input_lq').addClass('hidden1_lq');
				 $(this).addClass('hidden1_lq');
		        $(this).siblings('.reply_input_lq').removeClass('hidden1_lq');
				 var height = calcPageHeight(document);
		        parent.document.getElementById('ifr').style.height = height+ 'px'   ;

		    });
			/************************/
			$('.mood_text1_lq').on('focus',function(){
				if($(this).val()==$(this).attr('title'))
				$(this).val('');
			}).on('blur',function(){
				if($(this).val()=='')
					$(this).val($(this).attr('title'));
			});
			var _dom=null;
			/***********************/
			$(".faces_icon1_lq").on("click", function(e){
				_dom=this;
				var _top=$(this).offset().top;
				var _left=$(this).offset().left;
				$("#face_jqface").toggle();
				$("#face_jqface").css({'top':_top+20+'px','left':_left-480+'px'});
				e.stopPropagation();
				return false;
			});
				
			
			/*****************************/
			$(".js_faceContentList a").on("click", function(){
				//alert($(this).attr('alt'));
				//alert($(this).index());
				//insertFace ('',$(this).index(),'mood_text1_lq');
				insertFace ('',$(this).index(),_dom);
			});
			
			function insertFace(name,id,target){
				//当前用户可输入字符小于7时，则不允许插入表情
				if(document.getElementById('mood_txt')){
					var ta_num_status = document.getElementById('mood_txt').value.length;
					if(ta_num_status>293){
						Dialog.alert("很抱歉，您的状态剩余可输入字数不足以插入表情了。");
						return;
					}
				}	
				//$("#"+target).focus();
				var _area=$(target).parent().siblings('textarea');
				_area.focus();
				var faceText = '[em_'+id+']';
				if(_area != null) {
					_area.val(_area.val() + faceText);
				}
			}
			
			/**************/
		   	$(document).on("click", function(){
				$('.js_select_top ul,.triggle-top').hide();
					$("#face_jqface").hide();
			});
		});
	</script>
	<script>
		function trim(str){
			return str.replace(/(^\s*)|(\s*$)|(　*)/g , "");
		}
		function error_fun(content){
			var exp_str = new RegExp('error:');
			if(exp_str.test(content)){
				var return_array=content.split(":");
				var error_str = (return_array[1]=='') ? '操作发生错误' : return_array[1];
				top.Dialog.alert(error_str);
				return true;
			}
		}
		//回复评论
		function restore_com(_this,holder_id,type_id,mod_id){
			var contentd=$(_this).parent().siblings('textarea');
			var contenta=contentd.val();
			if(trim(contenta)=='' || contenta == "添加回复"){
				top.Dialog.alert('<?php echo $pu_langpackage->pu_data_empty;?>');
			}else
			/******************************************************/
			$.post("do.php",{act:'restore_add',holder_id:holder_id,type_id:type_id,mod_id:mod_id,is_hidden:0,to_userid:"",CONTENT:contenta},function(d){	
				if(!error_fun(d)){
					$("#mood_"+type_id+"_"+mod_id).append(d);
					contentd.val(contentd.attr('title'));
					var height = calcPageHeight(document);
					parent.document.getElementById('ifr').style.height = height + 'px'   ;
					top.Dialog.alert('<?php echo $u_langpackage->u_sent_successfully;?>');
				}
			});
		}
	</script>
</head>
	<body style="background:none;">
 		<div id="iframe_div_lq" style="margin:0;">
 			<!--begin-->
			<div id="js_app_cont">
<!--				<div id="home_list_box1_lf">-->
				<div>
					<?php
						$more=true;
						//控制显示条数
						$mainAffairNum=14;
						//引入语言包
						$rf_langpackage=new recaffairlp;

						//变量取得
						$ra_type=intval(get_argg('t'));
						$user_id=get_sess_userid();
						$pals_id=get_sess_mypals();
						$start_num=intval(get_argg('start_num'));
						$hidden_pals_id=get_session('hidden_pals');
						$hidden_type_id=get_session('hidden_type');
						$holder_id=intval(get_argg('user_id'));
						$visitor_ico=get_sess_userico();
						$ra_type_str=$ra_type ? " and type_id=$ra_type " : "";
						$pals_str='';
						$limit_num=0;
						$ra_rs = array();
					     
					   


					    if ($sex == 1) {
					    	  $where =  ' where user_sex = 0';
					    }else {
					          $where =  ' where user_sex = 1';
					    }
					    $sql = "select * from  wy_users $where";
					    $arr_id = $dbo->getRs($sql);

					    foreach ($arr_id as $k => $v) {
					         $str.=$v['user_id'].',';
					    }  

					   
					    if ($ra_type_str == '' ) {
					    	$ra_type_str = 'where user_id in('.substr($str, 0,-1).')';
					    } else {
					    	$ra_type_str.= ' and  user_id in('.substr($str, 0,-1).')';
					    }
						

						//数据表定义区
						$t_rec_affair=$tablePreStr."recent_affair";
						
						//数据库读操作
						$start=intval(get_argg('start'))>1 ? intval(get_argg('start')):1;
						$startIndex=($start-1)*$mainAffairNum;
						$dbo=new dbex;

						$sql = "select count(*) as total from $t_rec_affair  $ra_type_str";


						$totalArr=$dbo->getRs($sql);
						
						$toalPage=ceil($totalArr['total']/$mainAffairNum);

						if($start==$toalPage){
							$more=false;
						}
						//exit($toalPage);
						dbtarget('r',$dbServs);	
						
						{

							$sql = "select * from $t_rec_affair  $ra_type_str $ra_mod_type order by id desc limit $startIndex,$mainAffairNum";
							$ra_rs=$dbo->getRs($sql);

							foreach($ra_rs as $k=>$v){
								if($v['title']=='心情更新'){
									$arrr=$dbo->getRow("select mood_pic from wy_mood where user_id='$v[user_id]' order by mood_id desc limit 1");
									$ra_rs[$k]['mood_pic']=$arrr['mood_pic'];
								}
								//if(empty($v['user_ico'])){
									$arrr=$dbo->getRow("select user_ico, user_sex from wy_users where user_id='$v[user_id]' limit 1");
									$ra_rs[$k]['user_ico']=$arrr['user_ico'];
									$ra_rs[$k]['user_sex']=$arrr['user_sex'];
								//}
							}
						}
					?>
				<?php 
				//echo "<pre>";print_r($ra_rs);exit;
				foreach($ra_rs as $rs){?>
				<!--循环-->
					<dl >
				        <dt><a target="_blank" href="home2.0.php?h=<?php echo $rs['user_id'];?>">
				        	<img src='<?php if($rs['user_ico']){ echo str_replace("_small","",$rs['user_ico']);}else{echo "/skin/default/jooyea/images/d_ico_".$rs['user_sex'].".gif";}?>' width="52" height="52" ></a>
				            <i class="christmas-adornments  "></i>
				        </dt>
				        <dd class="share_title_sun somethingnew_tr">
				            <a target="_blank" class="name_box1_lf" href="home2.0.php?h=<?php echo $rs['user_id'];?>" style=" display: inline-block;  padding:0 5px; font-weight:bold;font-family: Arial, Helvetica, sans-serif;vertical-align: middle;white-space: nowrap;color: #b20000;"><?php echo filt_word($rs["user_name"]);?></a><?php echo $rs['title'];?> 
				    	</dd>                                
				        <dd class="comment_cont_lf comment_tree1_parent_lq">
				        	<div class="forImg">           
								<?php 
									if(strtotime($rs['date_time'])<strtotime('2015-07-12 17:46:42'))
										echo filt_word(get_face($rs['content']));
									else
										echo get_face2($rs['content']);

									if(!empty($rs["mood_pic"])){
										echo "<div><img src='{$rs['mood_pic']}' style='max-width:150px;'></div>";               	
									}
								?>
							</div>    
				            <p class="info_box1_lf">
				            	<span class="send_time" ><?php echo $rs['date_time'];?></span>
				                <!--<a class="recomment_op1_lf" target="_blank"><?php echo $rf_langpackage->rf_re_com;?></a>-->
				            </p>
				        </dd>
				        <dd class="comment_box_lf reply_input1_lq comment_tree1_lq ml75" id="mood_<?php echo $rs['mod_type'];?>_<?php echo $rs['for_content_id'];?>">                  
						<?php
							//引入语言包
							$pu_langpackage=new publiclp;
							$rl=new recaffairlp;

							//变量取得
							$type_id=intval($rs['mod_type']);
							$mod_id=intval($rs['for_content_id']);
							$start_num=0;
							$show_num=4;

							$dbo = new dbex;
							dbtarget('r',$dbServs);

							$t_share=$tablePreStr."share";
							$t_share_comment=$tablePreStr."share_comment";

							$t_poll=$tablePreStr."poll";
							$t_poll_comment=$tablePreStr."poll_comment";

							$t_album=$tablePreStr."album";
							$t_album_comment = $tablePreStr."album_comment";

							$t_photo=$tablePreStr."photo";
							$t_photo_comment = $tablePreStr."photo_comment";

							$t_blog=$tablePreStr."blog";
							$t_blog_comment=$tablePreStr."blog_comment";

							$t_subject=$tablePreStr."group_subject";
							$t_subject_comment=$tablePreStr."group_subject_comment";

							$t_mood=$tablePreStr."mood";
							$t_mood_comment=$tablePreStr."mood_comment";

							$t_event=$tablePreStr."event";
							$t_event_comment=$tablePreStr."event_comment";  

							switch($type_id){
								case "0":
								$t_table=$t_blog;
								$t_table_com=$t_blog_comment;
								$mod_col="log_id";
								break;
								case "1":
								$t_table=$t_subject;
								$t_table_com=$t_subject_comment;
								$mod_col="subject_id";
								break;
								case "2":
								$t_table=$t_album;
								$t_table_com=$t_album_comment;
								$mod_col="album_id";
								break;
								case "3":
								$t_table=$t_photo;
								$t_table_com=$t_photo_comment;
								$mod_col="photo_id";
								break;
								case "4":
								$t_table=$t_poll;
								$t_table_com=$t_poll_comment;
								$mod_col="p_id";
								break;
								case "5":
								$t_table=$t_share;
								$t_table_com=$t_share_comment;
								$mod_col="s_id";
								break;
								case "6":
								$t_table=$t_mood;
								$t_table_com=$t_mood_comment;
								$mod_col="mood_id";
								break;
								case "7":
								$t_table=$t_event;
								$t_table_com=$t_event_comment;
								$mod_col="event_id";
								break;
								default:
								echo 'error';
								break;
							}
							$function="parent.get_mod_com(".$type_id.",".$mod_id.",".intval($show_num+$start_num).",10);document.getElementById('page_".$type_id."_".$mod_id."').parentNode.style.display='none';document.getElementById('page_".$type_id."_".$mod_id."').parentNode.innerHTML='';";
							$visitor_id=get_sess_userid();
							$info_row=array();
							$com_rs=array();
							$show_str=intval($start_num+$show_num);
							$sql="select comments,user_id from $t_table where $mod_col=$mod_id";
							$info_row=$dbo->getRow($sql);
							$is_show=0;
							if($info_row['comments']>0){
								$is_show=1;
								$sql="select * from $t_table_com where $mod_col=$mod_id order by `comment_id` desc limit $start_num,$show_num";
								$com_rs=$dbo->getRs($sql);
								if($info_row['comments'] <= $start_num+$show_num){
									$show_str=intval($info_row['comments']);
									$function="void(0)";
								}
							}

							foreach ($com_rs as $k => $v) {
								$arrr=$dbo->getRow("select user_ico, user_sex from wy_users where user_id='$v[visitor_id]' limit 1");
								$com_rs[$k]['visitor_ico']=$arrr['user_ico'];
								$com_rs[$k]['user_sex']=$arrr['user_sex'];
							}

							
							//echo "<pre>";print_r($com_rs);
							// echo "</pre>";

						?>



						<?php 
						if($is_show==1){
							foreach($com_rs as $rs_restore){
								if($sex == 1){
									$sql = "select user_sex from wy_users where user_id='{$rs_restore['visitor_id']}'";
									$res = $dbo->getRow($sql);
									if($res["user_sex"] == 1){
										if($rs_restore["visitor_id"] != $userinfo["user_id"]){
											break;
										}
									}
									break;
									
								}
						?>
					 	<!--循环项-->
					    <dl  class="child_box1_lf" >
					        <dt>
					            <a target="_blank" class="name_box1_lf" href="home2.0.php?h=<?php echo $rs_restore["visitor_id"];?>">
					            	<img src="<?php if($rs_restore['visitor_ico']){ echo str_replace("_small","",$rs_restore['visitor_ico']);}else{echo "/skin/default/jooyea/images/d_ico_".$rs_restore['user_sex'].".gif";}?>" width="38" height="38" alt="<?php echo filt_word($rs_restore["visitor_name"]);?>">
					            </a>
					        </dt>
					        <dd>
					            <p>
					            	<a class="name_box1_lq"><?php echo filt_word($rs_restore["visitor_name"]);?></a>
					            </p> 
					            <div class="somethingnew_tr" id='sub_com_<?php echo $rs_restore['comment_id'];?>'>
									<?php 
										if(strtotime($rs_restore['add_time'])<strtotime('2015-07-10 17:46:42'))
											echo filt_word(get_face($rs_restore["content"]));
										else
											echo (get_face2($rs_restore["content"]));
									?>
								</div>
					            <div class="info_box1_lf">
					            <span class="send_time" ><?php echo $rs_restore["add_time"];?></span>
					            <span class="comment_op1_lq">
					            	<div class="lang-select js_select_top mr10" style=" display:inline-block">
					            		<label style="position: relative;">
					            			<span data-lang="no" id="moodLang"><?php echo $rl->rf_fanyi;?></span>
					            			<i style="position:absolute;right: 0;top:10px;right: 10px;"></i>
					            		</label>
						              	<ul class="lang-uls lr-hide"  style=" display:none">
											<li langs-lang="en" onclick='fyc_com("<?php echo $rs_restore['comment_id'];?>","en","<?php echo $rs_restore['visitor_id'];?>");'>English</li>
												<li langs-lang="zh" onclick='fyc_com("<?php echo $rs_restore['comment_id'];?>","zh","<?php echo $rs_restore['visitor_id'];?>");'>中文(简体)</li>
												<li langs-lang="kor" onclick='fyc_com("<?php echo $rs_restore['comment_id'];?>","kor","<?php echo $rs_restore['visitor_id'];?>");'>한국어</li>
												<li langs-lang="ru" onclick='fyc_com("<?php echo $rs_restore['comment_id'];?>","ru","<?php echo $rs_restore['visitor_id'];?>");'>русский</li>
												<li langs-lang="spa" onclick='fyc_com("<?php echo $rs_restore['comment_id'];?>","spa","<?php echo $rs_restore['visitor_id'];?>");'>Español</li>
												<li langs-lang="fra" onclick='fyc_com("<?php echo $rs_restore['comment_id'];?>","fra","<?php echo $rs_restore['visitor_id'];?>");'>Français</li>
												<li langs-lang="ara" onclick='fyc_com("<?php echo $rs_restore['comment_id'];?>","ara","<?php echo $rs_restore['visitor_id'];?>");'> عربي</li>
												<li langs-lang="jp" onclick='fyc_com("<?php echo $rs_restore['comment_id'];?>","jp","<?php echo $rs_restore['visitor_id'];?>");'>日本語</li>	
							              	</ul>
						            	</div><!--翻译回复-->
						            </span>
					            </div>
					        </dd>
					        <dd class="hidden1_lq reply_box1_lq"></dd>
					    </dl>
						<!--循环项-->
						<?php }} ?>
						</dd>











			            <!--回复框--> 
			            <dd class="root_reply_lq ml75">
			            	<input class="reply_simple_lq" type="text" value="<?php echo $rf_langpackage->rf_add_com;?>">
			            	<div class="reply_input_lq hidden1_lq"><div class="left_arrow1_lq"></div>
			            		<textarea class="mood_text1_lq" title="<?php echo $rf_langpackage->rf_add_com;?>"><?php echo $rf_langpackage->rf_add_com;?></textarea>
			            		<div class="input_infobox_lq">
			            			<a class="faces_icon1_lq"></a>
			        				<!--<span class="char_count1_lq">240</span>-->
				            	</div>
				            	<div class="mood_op1_lq">
				            		<!--     翻译:
						            <select>
						                    <option value="">不翻译</option>
						                    <option value="en" selected="selected">English</option>
						                    <option value="cn">中文(简体)</option>
						                    <option value="tr">中文(繁体)</option>
						                    <option value="ko">한국어</option>
						                    <option value="rs">Pусский</option>
						                    <option value="gm">Deutsch</option>
						                    <option value="sp">Español</option>
						                    <option value="jp">日本語</option>
						            </select>-->
				            		<a class="gray_btn1_lq" onclick="restore_com(this,<?php echo $rs['user_id'];?>,<?php echo $rs['mod_type'];?>,<?php echo $rs['for_content_id'];?>);"><?php echo $rf_langpackage->rf_submit;?></a>
				            	</div>
				            </div>            
			            </dd>
              			<!--回复框--> 
        			</dl>
					<?php }?>
	        		<!--循环-->
        
  
    
					<?php if($more){	?>
					<div class="promptbox loading" style=' cursor:pointer' onclick='window.location="rec_affair2.0.php?start=<?php
					echo $start+1;?>"'>
						<strong><?php echo $rf_langpackage->rf_see_more;?></strong>
					</div>
					<?php }	?>
				</div>
			</div>
		</div>

		<!---表情-->
		<div id="face_jqface" class="" style=" z-index:10000;  height:300px; overflow:hidden; border:1px solid #ccc; display:none">
			<div class="texttb_jqface">
				<a class="default_face">表情</a>
				<a class="close_jqface" title="close">×</a>
			</div>
			<div class="facebox_jqface mCustomScrollbar _mCS_1 _mCS_2 mCS_no_scrollbar" style="  height:300px">
				<div id="mCSB_1_container" class="mCSB_container" style="position: relative; top: 0px; left: 0px; " dir="ltr">
		            <div class="js_face_bg" style="background-image: url(./template/main/b0.png); width: 436px; height: 249px; z-index: 1; margin-left: 10px; background-position: initial initial; background-repeat: no-repeat no-repeat;"></div>
		            <div class="faceContent-list js_faceContentList" ><a title="[微笑]" alt="[微笑]"></a><a title="[撇嘴]" alt="[撇嘴]"></a><a title="[色]" alt="[色]"></a><a title="[发呆]" alt="[发呆]"></a><a title="[得意]" alt="[得意]"></a><a title="[流泪]" alt="[流泪]"></a><a title="[害羞]" alt="[害羞]"></a><a title="[闭嘴]" alt="[闭嘴]"></a><a title="[睡]" alt="[睡]"></a><a title="[大哭]" alt="[大哭]"></a><a title="[尴尬]" alt="[尴尬]"></a><a title="[发怒]" alt="[发怒]"></a><a title="[调皮]" alt="[调皮]"></a><a title="[龇牙]" alt="[龇牙]"></a><a title="[惊讶]" alt="[惊讶]"></a><a title="[难过]" alt="[难过]"></a><a title="[酷]" alt="[酷]"></a><a title="[冷汗]" alt="[冷汗]"></a><a title="[抓狂]" alt="[抓狂]"></a><a title="[吐]" alt="[吐]"></a><a title="[偷笑]" alt="[偷笑]"></a><a title="[可爱]" alt="[可爱]"></a><a title="[白眼]" alt="[白眼]"></a><a title="[傲慢]" alt="[傲慢]"></a><a title="[饥饿]" alt="[饥饿]"></a><a title="[困]" alt="[困]"></a><a title="[惊恐]" alt="[惊恐]"></a><a title="[流汗]" alt="[流汗]"></a><a title="[憨笑]" alt="[憨笑]"></a><a title="[大兵]" alt="[大兵]"></a><a title="[奋斗]" alt="[奋斗]"></a><a title="[咒骂]" alt="[咒骂]"></a><a title="[疑问]" alt="[疑问]"></a><a title="[嘘]" alt="[嘘]"></a><a title="[晕]" alt="[晕]"></a><a title="[折磨]" alt="[折磨]"></a><a title="[衰]" alt="[衰]"></a><a title="[骷髅]" alt="[骷髅]"></a><a title="[敲打]" alt="[敲打]"></a><a title="[再见]" alt="[再见]"></a><a title="[擦汗]" alt="[擦汗]"></a><a title="[抠鼻]" alt="[抠鼻]"></a><a title="[鼓掌]" alt="[鼓掌]"></a><a title="[糗大了]" alt="[糗大了]"></a><a title="[坏笑]" alt="[坏笑]"></a><a title="[左哼哼]" alt="[左哼哼]"></a><a title="[右哼哼]" alt="[右哼哼]"></a><a title="[哈欠]" alt="[哈欠]"></a><a title="[鄙视]" alt="[鄙视]"></a><a title="[委屈]" alt="[委屈]"></a><a title="[快哭了]" alt="[快哭了]"></a><a title="[阴险]" alt="[阴险]"></a><a title="[亲亲]" alt="[亲亲]"></a><a title="[吓]" alt="[吓]"></a><a title="[可怜]" alt="[可怜]"></a><a title="[菜刀]" alt="[菜刀]"></a><a title="[西瓜]" alt="[西瓜]"></a><a title="[啤酒]" alt="[啤酒]"></a><a title="[篮球]" alt="[篮球]"></a><a title="[乒乓]" alt="[乒乓]"></a><a title="[咖啡]" alt="[咖啡]"></a><a title="[饭]" alt="[饭]"></a><a title="[猪头]" alt="[猪头]"></a><a title="[玫瑰]" alt="[玫瑰]"></a><a title="[凋谢]" alt="[凋谢]"></a><a title="[示爱]" alt="[示爱]"></a><a title="[爱心]" alt="[爱心]"></a><a title="[心碎]" alt="[心碎]"></a><a title="[蛋糕]" alt="[蛋糕]"></a><a title="[闪电]" alt="[闪电]"></a><a title="[炸弹]" alt="[炸弹]"></a><a title="[刀]" alt="[刀]"></a><a title="[足球]" alt="[足球]"></a><a title="[瓢虫]" alt="[瓢虫]"></a><a title="[屎]" alt="[屎]"></a><a title="[月亮]" alt="[月亮]"></a><a title="[太阳]" alt="[太阳]"></a><a title="[礼物]" alt="[礼物]"></a><a title="[抱抱]" alt="[抱抱]"></a><a title="[强]" alt="[强]"></a><a title="[弱]" alt="[弱]"></a><a title="[握手]" alt="[握手]"></a><a title="[胜利]" alt="[胜利]"></a><a title="[抱拳]" alt="[抱拳]"></a><a title="[勾引]" alt="[勾引]"></a><a title="[拳头]" alt="[拳头]"></a><a title="[差劲]" alt="[差劲]"></a><a title="[爱你]" alt="[爱你]"></a><a title="[NO]" alt="[NO]"></a><a title="[OK]" alt="[OK]"></a><a title="[爱情]" alt="[爱情]"></a><a title="[飞吻]" alt="[飞吻]"></a><a title="[跳跳]" alt="[跳跳]"></a><a title="[发抖]" alt="[发抖]"></a><a title="[怄火]" alt="[怄火]"></a><a title="[转圈]" alt="[转圈]"></a><a title="[磕头]" alt="[磕头]"></a><a title="[回头]" alt="[回头]"></a><a title="[跳绳]" alt="[跳绳]"></a><a title="[挥手]" alt="[挥手]"></a><a title="[激动]" alt="[激动]"></a><a title="[街舞]" alt="[街舞]"></a><a title="[献吻]" alt="[献吻]"></a><a title="[左太极]" alt="[左太极]"></a><a title="[右太极]" alt="[右太极]"></a></div>
		        </div>
		    </div>
		    <div class="arrow_t"></div>
		</div>
		<!---表情-->

		<script src="/template/layer/layer.js"></script>
		<script>
			$(function(){
				$(".forImg>a").attr("href","javascript:;");
				$(".photo_frame").click(function(){
					var src=$(this).attr("src");
					src = src.replace(/thumb_/ig,"");
					top.topBigImg(src);
					return false;
				});			
			});
		</script>
	</body>
</html>