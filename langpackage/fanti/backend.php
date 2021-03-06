<?php
/*
 * Created on 2009-11-20
 */
class back_publiclp{
	var $bp_select_deselect = "全選/反選";
	var $bp_bulk_delete = "批量刪除";
}

class foundationlp{
	var $f_wel_back="觀影光臨管理後臺";
	var $f_set="通過登錄管理平臺，您可以對站點的參數進行設置，并可以及時獲取官方的更新動態和重要補丁通告。";
	var $f_data_num="站點數據統計";
	var $f_people_num="註冊人數";
	var $f_group_num="群組總數";
	var $f_album_num="相冊總數";
	var $f_photo_num="照片總數";
	var $f_blog_num="日誌總數";
	var $f_online_num="在綫人數";
	var $f_subject_num="話題總數";
	var $f_affair_num="動態總數";
	var $f_mess_num="留言總數";
	var $f_share_num="分享總數";
	var $f_new_official="官方最新動態";
	var $f_wel_web="歡迎訪問我們的網站，並且下載最新的iweb sns軟件產品，點擊{url}iweb產品網";
	var $f_new_edition="官方最新版本";
	var $f_skill_serve="技術支持服務";
	var $f_official_bbs="官方交流論壇";
	var $f_Program_db_edition="程序數據庫/版本";
	var $f_OS="操作系統";
	var $f_sever_edition="服務器環境版本";
	var $f_db_edition="數據庫版本";
	var $f_sns_edition="當前程序版本";
	var $f_team="開發及測試";
	var $f_copyright="版權所有：jooyea開發團隊";
	var $f_ceo="系統設計";
	var $f_art="主體及UI";
	var $f_web="產品網站";
	var $f_sess_pre="session前綴設置";
	var $f_sess_pre_inf="（定義本系統的session前缀，默認：isns_）";
	var $f_site_set="站點設置";
	var $f_site_name="站點名稱";
	var $f_domain="站點訪問地址";
	var $f_keyword="站點關鍵字";
	var $f_description="站點描述";
	var $f_author="站點作者";
	var $f_mail="站點郵箱";
	var $f_copyright_inf="版權信息";
	var $f_record="ICP/IP/域名備案";
	var $f_close_say="站點關閉說明";
	var $f_open_err="開啟錯誤報告";
	var $f_close_control="站點關閉控制";
	var $f_display_set="顯示設置";
	var $f_main_dynamic_num="首頁動態顯示好友";
	var $f_home_dynamic_num="主頁動態顯示條數";
	var $f_cache="緩存功能";
	var $f_cache_update="緩存更新時間";
	var $f_page_num="緩存分頁數";
	var $f_birthday="出生年月範圍";
	var $f_article="註冊服務條款";
	var $f_watering_set="防灌水設置";
	var $f_alternation_time="操作間隔時間";
	var $f_defer_time="延遲時間";
	var $f_filter_set="過濾設置";
	var $f_open_filter="開闢過濾";
	var $f_filter_content="要過濾的詞語";
	var $f_high_set="高級配置";
	var $f_support_library="使用的支持庫";
	var $f_language_pack="站點默認語言包";
	var $f_index_pic="首頁幻燈片圖片";
	var $f_index_list="的相冊列表：";
	var $f_select_pic="從他的相冊中選擇圖片設置為首頁幻燈圖";
	var $f_now_index="當前幻燈圖片：";
	var $f_site_name_annotations="（網站標題，顯示在頁面的左上角。如：聚易網）";
	var $f_check_domain="程序檢測訪問地址：";
	var $f_tip_domain="您設置的<站點訪問地址>項與程序检测的路徑不同，所以推薦好友，flash上傳照片，添加收藏等功能會因此而無法找到正確的路徑！\\n\\n您確定還要修改嗎？";
	var $f_keyword_annotations="（便於引擎查找，當輸入多個時，用“，”或者“|”分隔。如：sns，聚易，iweb）";
	var $f_description_annotations="（網站的重點描述信息，讓訪客清楚瞭解網站概要。如：iweb sns交友網站）";
	var $f_click_set="點擊設置完整地址";
	var $f_copyright_inf_annotations="（網站所屬的版權。如：Copyright©2009 www.Jooyea.net）";
	var $f_record_annotations="（信息產業部所頒發的備案信息。如：京ICP備09092256號 ）";
	var $f_close_say_annotations="（當選擇網站關閉時，訪客所看到的提示性信息。如：本網站正在進行維護更新。）";
	var $f_open_err_annotations="（是否開啟網站的程序錯誤報告，當程序有錯誤時會在頁面中給與提示，但會暴露出網站的漏洞。默認：關閉）";
	var $f_close_annotations="（關閉網站，此時任何人都無法訪問站點內容。默認：打開）";
	var $f_main_dynamic_num_annotations="（首頁顯示好友動態（新鮮事）的人數。默認：5）";
	var $f_home_dynamic_num_annotations="（主頁顯示好友動態（新鮮事）的數據量。默認：10）";
	var $f_cache_annotations="（網站啟用緩存功能，將大幅提升網站負載能力，增加網站性能，但數據更新會有延遲。默認：關閉）";
	var $f_cache_update_annotations="（更新緩存的間隔時間，當開啟緩存時此參數才有效，參數單位為秒。默認：60）";
	var $f_page_num_annotations="（緩存的分頁數。默認：10）";
	var $f_birthday_annotations="（網站出生年份的選擇範圍，格式：YYYY 。如：1940）";
	var $f_article_annotations="（用戶註冊時所需要同意的服務條款。支持html代碼格式:&lt;br /&gt;換行；&lt;b&gt;加粗）";
	var $f_alternation_time_annotations="（每兩次操作所間隔的時間，參數單位秒。默認：3秒）";
	var $f_defer_time_annotations="（當操作超過規定的時間，程序將延遲，參數單位秒。默認：5）";
	var $f_open_filter_annotations='（過否開啟過濾功能，對於敏感的詞語會自動替換為"*"(星號)。默認：關閉）';
	var $f_filter_content_annotations='（每兩個詞語之間用","(逗號) 或者 "|"(豎線)進行分隔。如：黃色,暴力）';
	var $f_group_admin_annotations="（群組所能設定的管理員數量。默認：3）";
	var $f_my_group_num_annotations="（每個用戶所能創建群組數量。默認：3）";
	var $f_support_library_annotations="（可以更換的高級si類庫路徑地址，以便提升網站吞吐能力。默認：iweb_mini_lib/）";
	var $f_language_pack_annotations="（根據網站的“langpackage/”目錄下的語言包文件來更換網站的默認語言。默認：zh）";
	var $f_open="開啟";
	var $f_close="關閉";
	var $f_refer="提交";
	var $f_group_sort="群組類別管理";
	var $f_fir_sort="好友默認分類";
	var $f_arrange_num="排列序號";
	var $f_name="名稱";
	var $f_handle="操作";
	var $f_del_con="確定刪除此類別嗎？";
	var $f_del="刪除";
	var $f_amend="修改";
	var $f_confirm="確定";
	var $f_cancel="取消";
	var $f_add_sort="添加類別";
	var $f_integral="積分規則";
	var $f_add_integral="增加積分操作";
	var $f_add="增加(+)";
	var $f_abatement_integral="減少積分操作";
	var $f_abatement="減少(-)";
	var $f_add_blog="發佈日誌";
	var $f_del_blog="日誌被刪除";
	var $f_add_poll="發佈投票";
	var $f_del_poll="投票被刪除";
	var $f_add_pic="上傳圖片";
	var $f_del_pic="圖片被刪除";
	var $f_add_com="發佈評論/留言";
	var $f_del_com="評論/留言被刪除";
	var $f_add_sub="發起話題";
	var $f_del_sub="話題被刪除";
	var $f_add_reply="發佈回帖";
	var $f_del_reply="回帖被刪除";
	var $f_add_share="發佈分享";
	var $f_del_share="分享被刪除";
	var $f_request_friend="邀請好友註冊成功";
	var $f_login="每天登錄";
	var $f_set_head="設置頭像";
	var $f_intergral_class="積分等級換算";
	var $f_change_num="圖標兌換分數設置";
	var $f_upgrade_num="圖標升級個數設置";
	var $f_amend_suc="修改成功！";
	var $f_index_suc="幻燈片添加成功！";
	var $f_img_preview="圖像預覽";
	var $f_handle_los="操作失敗";
	var $f_none_photo="請選擇圖片";
	var $f_open_cookie="開啟cookie";
	var $f_rewrite_info="普通：需要apache開啟Rewrite模塊，然後把docs目錄下的.htaccess文件複製到網站根目錄才能啟用。<br>高級：不用apache開啟設置，通過程序處理url。";
	var $f_rewrite_set="URL重寫設置";
	var $f_mail_set="郵件設置";
	var $f_smtp_address="SMTP服務器地址";
	var $f_smtp_port="SMTP服務器端口";
	var $f_smtp_email="SMTP服務器郵箱";
	var $f_smtp_user="SMTP服務器用戶名";
	var $f_smtp_password="SMTP服務器密碼";
	var $f_general="普通";
	var $f_advanced="高級";
	var $f_site_logo="站點Logo";
	var $f_home_logo="用户主页Logo";
	var $f_site_logo_rule="請在上傳前將圖片的文件名命名為snslogo.gif，尺寸為(218 * 50)";
	var $f_home_logo_rule="請在上傳前將圖片的文件名命名為logo.gif，尺寸為(106 * 18)";
	var $f_person="人";
	var $f_item="條";
	var $f_page="頁";
	var $f_second="秒";
	var $f_site_logo_upload_error="站點Logo上傳錯誤";
	var $f_home_logo_upload_error="個人主頁Logo上傳錯誤";
	var $f_email_set_error="郵件設置修改錯誤";
	var $f_site_Set_error="站點設置修改錯誤";
	var $f_update_successful="更新成功";
	
	var $f_open_email_reg = "開啟郵箱激活註冊";
	var $f_form_yes = "是";
	var $f_form_no = "否";
	var $f_need_goto_email = "（開啟後需進入自己的註冊郵箱內，點擊激活連接方可註冊成功）";
	var $f_failure_time_activation= "郵箱激活碼有效時間";
	var $f_day = "天";
	var $f_activation_valid_time = "（激活碼生成後的有效時間，默認為1天0小時）";
	
	var $f_reg_set = "註冊設置";
	var $f_open_new_user_reg = "開啟新用戶註冊";
	var $f_yes = "是";
	var $f_no = "否";
	var $f_whether_allow_reg = "（網站是否允許用戶註冊）";
	var $f_open_invite_reg = "開啟邀請註冊";
	var $f_need_invite_reg = "（開啟後需要填寫邀請碼才可以註冊）";
	var $f_failure_time_invite= "邀請碼失效時限";
	var $f_hour = "小時";
	var $f_invite_valid_time_hour = "（邀請碼生成後的有效時間，單位:小時。默認：72）";
	var $f_invite_valid_time_minute = "（邀請碼生成後的有效時間，單位:分鐘。默認：1）";
	var $f_point = "分";
	var $f_takes_invite_points = "申請邀請碼所花費積分";
	
}

class uilp{
	var	$u_get_false="獲取最新的遠程模版列表失敗，請您稍後再試";
	var $u_loading="正在下載，請稍等...";
	var $u_compling="正在編譯，請稍等...";
	var $u_user_skin="使用皮膚";
	var $u_choose_skin="選擇皮膚";
	var $u_open="啟用";
	var $u_comp_type1="模版編譯方式：服務模式";
	var $u_comp_type2="調試模式";
	var $u_comp_info="選擇了新的模版編譯方式後，必須重新編譯模版設置才會生效。\\n\\n現在是否開啟編譯模版？";
	var $u_ctrl="操作";
	var $u_sure="確定";
	var $u_cancel="取消";
	var $u_download="下載";
	var $u_change_dir="更改目錄";
	var $u_ask_tpl="您確定要下載此模版嗎？";
	var $u_ask_skin="您確定要下载此皮膚嗎？";
	var $u_new_list="可下載的模版列表";
	var $u_tpl_name="模版方案名稱";
	var $u_dir_pos="下載到目錄";
	var $u_temp_admin="模版管理";
	var $u_temp_list="模版方案";
	var $u_amend_time="修改時間";
	var $u_currently_apply="當前使用";
	var $u_admin_handle="管理操作";
	var $u_app_temp="應用模版";
	var $u_admin_temp="管理模版";
	var $u_admin_con="此功能會改變網站整體風格，對您的網站產生重大影響，確定要整體編譯此模版嗎？";
	var $u_tpl_prompt_1="1，當前列出了從遠程服務器上可以下載的模版，點擊 \"下載\" 即可把他們下載到模版目錄templates目錄中，並在 \"模版管理\" 中使用。";
	var $u_tpl_prompt_2="2，下載最新的模版需要產品授權，詳情請登錄我們的官方主站：http://www.jooyea.net";
	var $u_skin_prompt_1="1，當前列出了從遠程服務器上可以下载的皮膚，點擊 \"下載\" 即可把他們下載到皮膚目錄skin目錄中，並在 \"皮膚管理\" 中使用。";
	var $u_skin_prompt_2="2，下載最新的皮膚需要產品授權，詳情請登录我们的官方主站：http://www.jooyea.net";
	var $u_prompt_inf="提示信息";
	var $u_prompt_1="1、所有模版方案都保存在 /templates/ 目錄下；";
	var $u_prompt_2="2、網站當前使用的模版方案為：{default} ，保存路徑為： /templates/{default}/ ，對於其他模版方案的變化不會影响網站前臺的顯示；";
	var $u_prompt_3="3、如果您需要增加網站模版方案，請把新的模版方案根據網站的根目錄結構整理複製到 /templates/ 目錄中；";
	var $u_prompt_4="4、如果您需要應用新的網站模版方案，請點擊應用模版，但是其他目錄結構一定要與根目錄結構相匹配；";
	var $u_prompt_5="5、應用模版操作會把新的風格樣式替換成所選擇的方案，替換時要謹慎；";
	var $u_prompt_6="6、如果替換時發生錯誤可以進入站點UI恢復——>恢復模版，進行恢復；";
	var $u_skin_1="1、當前列出的皮膚方案保存在 /skin/{template}/ 目錄下，這是和您所選擇的模版方案相匹配的，每個模版方案可以對應多個皮膚方案；";
	var $u_skin_2="2、直接點擊“應用皮膚”就可以看到效果，不用在進行編譯；皮膚方案名不要用中文，以免產生亂碼";
	var $u_skin_3="3、如果您需要增加网站皮膚方案，请把新的皮膚方案根據網站的模版目錄結構整理複製到 \"/skin/模版方案名\" 目錄中 ；";
	var $u_skin_4="4、應用皮膚操作會把當前的風格樣式替換成所選擇的方案，替換時需要謹慎；";
	var $u_skin_5="5、如果替換時發生錯誤可以進入站點UI恢復——>恢復皮膚，進行恢復；";
	var $u_skin_plan="皮膚方案";
	var $u_app_skin="應用皮膚";
	var $u_tempfile_list="模版文件列表";
	var $u_choice="選擇";
	var $u_file_name="文件名";
	var $u_check="全選/反選";
	var $u_compile="批量編譯";
	var $u_list_back="返回列表";
	var $u_clew_inf="提示信息";
	var $u_temp_save="當前模版保存在 <font color='red'>/templates/{temp}</font>目錄";
	var $u_do_flow="iweb_sns 模版製作與標籤設置的基本流程：";
	var $u_flow_1="1、通過Deamweaver、Fireworks、Flash 和 Photoshop 等軟件設計好 html 頁面；";
	var $u_flow_2="2、根據頁面佈局插入標籤，標籤的具體規則請參考手冊；";
	var $u_flow_3="3、在 /templates 目錄下建立一個新的模版目錄，然後把做好的 html 頁面按照 iweb_sns 模版命名規則命名並存放到模版目錄；";
	var $u_flow_4="4、登錄iweb_sns後臺，進入“模版管理”，把自己新建的模版方案設置為使用方案；";
	var $u_flow_5="5、編譯後即可看到頁面效果；";
	var $u_flow_6="6，模版方案的目錄結構一定要與網站的根目錄結構相同，請參考templates/default下的目錄結構；";
	var $u_file_no="沒有選擇方案！";
	var $u_amend="修改";
	var $u_compile_state="編譯狀態";
	var $u_skin_admin="皮膚管理";
	var $u_amend_temp="修改模版";
	var $u_belong_temp="所屬模版";
	var $u_temp_path="模版路徑";
	var $u_last_amend_time="上次修改時間";
	var $u_save="保存";
	var $u_reset="重置";
	var $u_amend_suc="修改成功!";
	var $u_worning="警告：執行當前操作會覆蓋您站點當前的相關程序文件！強烈建議您先做好文件備份！\\n提示：當您的網站運行良好的狀態下不要使用此操作！\\n您確定還要執行此操作嗎？";
	var $u_re_worning="您已經做好備份，並且確定要執行此操作恢復嗎？";
	var $u_UI_cback="UI修復";
	var $u_cback_temp="恢復模版";
	var $u_cback_temp_say="1，當您的網站頁面的顯示出現問題時，可以使用此功能把前臺頁面恢復到初始狀態；	<br />
		2，恢復缺省的模版文件到templates/default目錄下，在此目錄下的文件，將會被替換掉；<br />
		3，恢復完畢後，可以到模版管理——>應用模版，選擇default模版方案並且進行編譯，從而使頁面恢復到默認樣式；<br />";
	var $u_cback_model="恢復模型";
	var $u_cback_model_say="1，當您的網站功能出現問題時，程序發生錯誤時，可以使用此功能把程序文件恢復到初始狀態；<br />
			2，恢復缺省的數據模型文件到models/目錄下，在此目錄下的文件，將會被替換掉；<br />
			3，恢復完畢後，可以到模版管理——>應用模版，選擇相應的模版方案並且進行編譯從而恢復程序功能；<br />";
	var $u_cback_skin="恢復皮膚";
	var $u_cback_skin_say="1，當您的網站樣式皮膚出現問題，或者想恢復到初始樣式，可以使用此功能；<br />
			2，恢复缺省的樣式皮膚文件到skin/default/jooyea目錄下，在此目錄下的文件將會被覆蓋掉；<br />";
	var $u_cback_all="恢復整體編譯結果";
	var $u_cback_all_say="1，當您的網站有錯誤，並且執行了以上恢復操作都無法解決問題，可以使用此功能來對網站系統進行恢復；<br />
		2，此UI恢復功能的使用，會對您的網站系統產生巨大的影響，此操作會把現有的功能，潔面等恢復到默認初始化時的狀態。<br />
		3，此操作是將網站缺省的編譯結果直接覆蓋到您的網站內，執行完畢後，網站可以立即使用；<br />";
	var $u_make_suc="創建目錄 {dir} /成功!";
	var $u_make_lose="創建目錄 {dir} /失敗!";
	var $u_cback_suc="恢復 {dir} 成功!";
	var $u_cback_lose="恢復 {dir} 失敗!";
	var $u_back="返回上一級";
	var $u_none="沒有選擇要下載的模版方案";
	var $u_none_url="沒有填寫存放下載模版的路徑";
	var $u_dir_used="目錄已經被佔用，請重新填寫存放目錄";
	var $u_down_false="<font color='red'>文件下載失敗</font><br />";
	var $u_file_suc="下載{file}成功！<br />";
	var $u_dir_suc="創建目錄{dir}成功！<br />";
	var $u_skins_list="可下載的皮膚列表";
}
class modulelp{
	//public
	var $m_check_condition="篩選條件";
	var $m_result_order="結果排序";
	var $m_def_order="默認排序";
	var $m_asc="遞增";
	var $m_desc="遞減";
	var $m_page_20="每頁顯示20條";
	var $m_page_50="每页显示50條";
	var $m_page_100="每頁顯示100條";
	var $m_search="搜索";
	var $m_red="帶 ' <font color=red>*</font> ' 的表示支持模糊查詢";
	var $m_none_data="沒有查詢到與條件相匹配的數據";
	var $m_content="內容";
	var $m_time="時間";
	var $m_del="刪除";
	var $m_ctrl="操作";
	var $m_lock="鎖定";
	var $m_normal="正常";
	var $m_unlock="解鎖";
	var $m_ask_lock="確定要鎖定?";
	var $m_ask_del="確定要刪除?";
	var $m_state="狀態";
	var $m_issue_time="發佈時間";
	var $m_comments="評論數";
	var $m_type="類型";
	var $m_public_pro="公開性質";
	var $m_public="公開";
	var $m_only="僅好友";
	var $m_only_self="僅自己";
	var $m_preg_link="分享了連接地址";
	var $m_astrict_no="不限";
	var $m_blog="日誌";
	var $m_subject="話題";
	var $m_album="相冊";
	var $m_photo="圖片";
	var $m_group="群組";
	var $m_poll="投票";
	var $m_share="分享";
	var $m_space="空間";
	var $m_mood="心情";
	var $m_date_wrong="日期格式輸入不正確,如:2009-01-01";
	var $m_userid="用戶UID";
	var $m_author_id="作者UID";
	var $m_author_name="作者名";
	var $m_uname="用戶名";
	var $m_ip="用戶ip";
	var $m_no_pri="對不起，您所在的用戶組沒有該權限";
	//group
	var $m_name="名稱";
	var $m_group_list="群組列表";
	var $m_greator="創建者";
	var $m_great_date="成立時間";
	var $m_member_num="成員數";
	var $m_sub_num="話題數";
	var $m_free_join="自由加入";
	var $m_check_join="驗證加入";
	var $m_check_rejuse="拒絕加入";
	var $m_join_type="加入權限";
	var $m_group_id="指定群組ID";
	//feed
	var $m_feed_list="動態列表";
	var $m_feed_id="動態ID";
	//member
	var $m_member_list="會員列表";
	var $m_ico="頭像";
	var $m_normal_member="普通用戶";
	var $m_lock_member="鎖定用戶";
	var $m_recomed="已推薦";
	var $m_recom="推薦";
	var $m_sex="性別";
	var $m_man="男";
	var $m_woman="女";
	var $m_reg_date="註冊時間";
	var $m_login_date="登錄時間";
	var $m_area="按地獄城市";
	var $m_online="在綫";
	var $m_guest="訪問量";
	var $m_inter="積分";
	var $m_last_login="最後登陸時間";
	var $m_more="查看詳細";
	var $m_visitor_home="訪問主頁";
	var $m_email="郵箱";
	//blog
	var $m_blog_list="日誌列表";
	var $m_title="標題";
	var $m_blog_id="指定日誌ID";
	var $m_scanf_num="查看數";
	var $m_reply_num="回覆數";
	var $m_send_date="發佈時間";
	//poll
	var $m_poll_num="投票數";
	var $m_poll_list="投票列表";
	var $m_sendor="發佈者";
	var $m_award_inter="懸賞積分";
	var $m_over_date="已過期";
	var $m_no_over="未過期";
	var $m_over="過期投票";
	var $m_poll_limit="投票限制";
	var $m_comments_limit="評論限制";
	var $m_poll_id="指定投票ID";
	//recommend
	var $m_recom_value="推薦度";
	var $m_top="置頂";
	var $m_cancel="取消推薦";
	var $m_order="排序";
	var $m_app_order="應用排序";
	var $m_top_recom="置頂排序";
	var $m_cancel_recom="取消置頂";
	var $m_num_no="排序值位數字";
	var $m_index_pic="置頂幻燈";
	var $m_batch_order="批量排序";
	//report
	var $m_report_type="舉報類型";
	var $m_creat_time="創建時間";
	var $m_report_list="舉報列表";
	var $m_report_reason="舉報理由";
	var $m_informer="舉報人";
	var $m_handle="操作";
	var $m_handle_con="本操作不可恢復，確認繼續？";
	var $m_del_report="刪除舉報";
	var $m_lock_type="刪除舉報及{type}信息";
	var $m_rep_num="舉報次數";
	//share
	var $m_share_id="指定分享ID";
	var $m_share_list="分享列表";
	var $m_share_p="分享人";
	var $m_share_type="分享類型";
	//msgboard
	var $m_mess_id="留言ID";
	var $m_mess_uid="留言UID";
	var $m_mess_name="留言者";
	var $m_mess_by_id="被留言UID";
	var $m_mess_time="留言時間";
	var $m_mess_list="留言列表";
	//comment
	var $m_com_type="評論類型";
	var $m_com_uid="；評論UID";
	var $m_com_name="評論者";
	var $m_com_by_uid="被評論UID";
	var $m_com_time="評論時間";
	var $m_com_list="評論列表";
	var $m_com_by_id="被評論ID";
	//photo
	var $m_alb_id="所在相冊ID";
	var $m_pho_id="指定圖片ID";
	var $m_pho_inf="圖片說明";
	var $m_upd_time="上傳時間";
	var $m_pho_list="照片列表";
	var $m_com_admin="評論管理";
	//album
	var $m_album_name="相冊名";
	var $m_album_id="相冊ID";
	var $m_pho_num="圖片數";
	var $m_alb_list="相冊列表";
	var $m_admin_com="管理評論";
	//subject
	var $m_sub_id="話題ID";
	var $m_see_num="查看數";
	var $m_sub_list="話題列表";
	var $m_author="作者";
	var $m_reply="回覆";
	var $m_see="查看";
	var $m_see_particular="查看詳細";
	var $m_del_suc="刪除成功！";
	var $m_del_lose="刪除失敗！";
	var $m_recomed_lose="推薦失敗！";
	//心情
	var $m_mood_list="心情列表";
	
	var $m_information="的資料";
	var $m_names="姓名";
	var $m_marriage_status="婚戀狀態";
	var $m_secrecy="保密";
	var $m_single="單身";
	var $m_married="已婚";
	var $m_birthday="生日";
	var $m_years="年";
	var $m_month="月";
	var $m_day="日";
	var $m_not_filled="未填";
	var $m_blood_type="血型";
	var $m_hometown="家鄉";
	var $m_location="所在地";
}

class softwarelp{
	var $so_tip_inf="提示信息";
	var $so_list_false="獲取程序升級列表失敗";
	var $so_last_version="系統當前版本為最新版本，沒有可升級的版本";
	var $so_update_list="軟件升級列表";
	var $so_soft_version="軟件版本";
	var $so_time="時間";
	var $so_ctrl="操作";
	var $so_ask_update="你確定要直接升級到此版本嗎？";
	var $so_act_update="立即升級到此版本";
	var $so_loction_version="當前軟件版本：{version}";
	var $so_pro_1="1，“軟件升級列表”列出了系統目前可以升級到的版本，升級模式是在線一鍵升級，支持跨版本升級。";
	var $so_pro_2="2，升級成功後系統版本自動更新，且不可以恢復到升級前的版本，所以升級需要做好備份工作。";
	var $so_pro_3="3，關於升級方面的任何問題可以登錄到jooyea.net尋求幫助。";
	var $so_success="成功";
	var $so_false="<font color=red>失敗</font>";
	var $so_update_success="升級完成";
	var $so_update_false="升級失敗";
	var $so_sql_result="sql語句執行{result}<br />";
	var $so_dir_result="創建目錄{dir}{result}<br />";
	var $so_del_file_result="刪除文件{file}{result}<br />";
	var $so_del_dir_result="刪除目錄{dir}{result}<br />";
	var $so_download_result="下載文件{file}{result}<br />";
}

class pluginslp{
	var $pl_unset="未安裝";
	var $pl_install="安裝";
	var $pl_isset="已安裝";
	var $pl_unload="卸載";
	var $pl_next_step="下一步";
	var $pl_guide="IWebSNS插件嚮導";
	var $pl_install_info="插件女裝說明";
	var $pl_install_worning="插件分為官方插件和第三方插件兩種，由第三方開發的插件請確定安全性后再安裝，或者下載官方推薦的插件。";
	var $pl_sure="確 定";
	var $pl_unload_info="插件卸載說明";
	var $pl_unload_remind="插件卸載後不會影響系統的運行，請放心卸載！";
	var $pl_update="更 新";
	var $pl_manage_str="IWebSNS插件管理";
	var $pl_manage="插件管理";
	var $pl_set_update="對插件進行設置更新";
	var $pl_worning="警告：插件刪除後，不能修復，您確定刪除此插件嗎？";
	var $pl_unset_state="此插件還未安裝";
	var $pl_list="插件列表";
	var $pl_name="插件名稱";
	var $pl_state="狀態";
	var $pl_ctrl="操作";
	var $pl_select_site="選擇安裝位置";
	var $pl_update_suc="更新成功！";
	var $pl_update_false="更新失敗！";
	var $pl_site_info="說明：安裝位置指插件要在系統中顯示的位置。";
	var $pl_is_order="是否自由定制";
	var $pl_order_info="自由定制是指，此插件允許用戶自己控制插件是否顯示。";
	var $pl_inspire="是否啟用";
	var $pl_inspire_info="啟用是指，插件是否生效。";
	
	var $pl_widget_plugin="Widget插件";
	var $pl_app_application="APP應用";
	var $pl_plug_description="插件描述";
	var $pl_details="詳細說明";
	var $pl_version_number="版本號";
	var $pl_author="作者";
	var $pl_developer_home="開發者主頁";
	var $pl_placements="展示位置";
	var $pl_import_documents="入口文件";
	var $pl_other_information="其他信息";
	var $pl_database_file="數據庫文件";
	var $pl_plugin_not_installed="插件配置信息不全，不具備安裝條件！";
	
	var $pl_success="成功";
	var $pl_failure="失敗";
	var $pl_database_success="數據庫文件已經配置成功!";
	var $pl_database_failure="數據庫文件已經配置失敗!";
	var $pl_table="表";
	var $pl_presence="已經存在";
	var $pl_unable_install="致使插件無法安裝!";
	var $pl_can_installed="此插件具備強行安裝條件,點擊下一步蔣強行安裝!";
	var $pl_can_not_installed="次插件不具備強行安裝條件,安裝終止!";
	
	var $pl_plugin_permissions="插件權限";
	var $pl_plugin_success_install="插件已經成功安裝!";
	var $pl_if_ordered="是否自由訂制";
	var $pl_enabled="是否啟用";
	var $pl_if_ordered_definition="自由訂制是指，此插件允許用戶自己控制插件是否顯示。";
	var $pl_enabled_definition="啟用是指，插件是否生效。";
	
	var $pl_back_link_address="後臺鏈接地址";
	var $pl_management_entrance="管理入口";
	var $pl_uninstall_successful="此插件卸載成功!";
	var $pl_delete_successful="已成功刪除";
}

class datalp{
	var $d_db_backup="數據庫備份";
	var $d_choice="選擇";
	var $d_db_id="ID";
	var $d_db_table="數據庫表";
	var $d_check_all="全選";
	var $d_refer="提交";
	var $d_boject_no="沒有選擇操作對象";
	var $d_backup_suc="已全部備份完成,備份文件保存在docs目錄下";
	var $d_db_cback="數據庫恢復";
	var $d_file_name="文件名";
	var $d_edition="版本";
	var $d_backup_time="備份時間";
	var $d_sub_volume="卷號";
	var $d_lead="導入";
	var $d_del="刪除";
	var $d_lead_con="確定要導入嗎？";
	var $d_del_con="確定要刪除嗎？";
	var $d_lead_suc="導入成功！";
	var $d_del_suc="備份文件已刪除！";
}

class toollp{
	var $t_total_del_num="發現有{num}個測試用戶<br />";
	var $t_del_start="開始清理要刪除的用戶在各個模塊中的數據......<br />";
	var $t_none_test="對不起，未在您的系統中發現測試數據";
	var $t_onclick_act="點擊運行";
	var $t_tip_inf="提示信息";
	var $t_none_tool="對不起，您的系統當前還沒有添加任何工具";
	var $t_ask_action="您確定要執行{tool}嗎？";
	var $t_list="工具箱列表";
	var $t_tool_pro_1="1，\"工具箱列表\" 列出了目前系統內所有可用的工具箱組件，其路徑在後臺目錄(sysadmin)->toolsBox目錄下。";
	var $t_tool_pro_2="2，您可以通過 \"下載工具箱\" 操作，來獲取最新的工具箱組件；您也可以通過 \"工具箱管理\" 來卸載不需要的工具箱組件。";
	var $t_tool_pro_3="3，只要您遵循我們的組建規範，您可也以自己編寫工具箱組件，詳情請參考我們的開發手冊。";
	var $t_tool_pro_4="4，下載最新的模版需要产品授權，詳情請登錄我們的官方主站：http://www.jooyea.net";
	var $t_download_none="您的系統當前沒有可下載的工具箱";
	var $t_get_false="獲取最新的遠程工具箱列表失敗，請您稍後再試";
	var $t_loading="正在下載，請稍等...";
	var $t_id_wrong="工具編號發生錯誤！";
	var $t_not_stand="您的工具箱列表文件不符合規範，請仔細檢查";
	var $t_not_find="沒有找到您本地的工具箱列表";
	var $t_false_connect="連接遠程服務器失敗！";
	var $t_sql_false="sql執行失敗";
	var $t_isset_tool="下載失敗，該\"工具編號\"已經存在，請檢查工具箱列表文件";
	var $t_success="下載工具組建成功";
	var $t_name="名稱";
	var $t_code_num="工具編號";
	var $t_time="時間";
	var $t_author="作者";
	var $t_ctrl="操作";
	var $t_ask_download="您確定要下載此工具嗎？";
	var $t_download="下載";
	var $t_download_pro_1="1，當前列出了您的系統中沒有集成的工具組件，點擊 \"下載\" 即可把它們下載到後臺目錄(sysadmin)->toolsBox目錄中，並在 \"工具箱列表\" 中使用。";
	var $t_download_pro_2="2，工具組件的編號是唯一的，如果您的系統中沒有列表中的某個工具，卻又下載不了，請您修改後臺目錄(sysadmin)->toolsBox目錄中的 \"tool.xml\" 文件。";
	var $t_download_pro_3="3，下載最新的模版需要產品授權，詳情請登錄我們的官方主站：http://www.jooyea.net";
	var $t_tool_manage="工具箱管理";
	var $t_ask_unset="您確定要下載此工具嗎？";
	var $t_unset="卸載";
	var $t_manage_pro_1="1，當前列出您系統中集成的工具箱組件，點擊 \"卸載\" 即可把不需要的組件從系統中卸掉。";
	var $t_manage_pro_2="2，工具箱組件存放在後臺目錄(sysadmin)->toolsBox目錄中，詳情請參考開發手冊。";
	var $t_manage_pro_3="3，下載最新的模版需要產品授權，詳情請登錄我們的官方主站：http://www.jooyea.net";
	var $t_code_wrong="工具編號發生錯誤！";
	var $t_unload_sucess="卸載成功";
	var $t_unload_false="卸載失敗，請檢查工具配置文件";
}

class errorlp{
	var $er_error_1="授權碼不正確";
	var $er_error_2="連接遠程服務器失敗";
	var $er_error_3="您的授權碼已經到期";
	var $er_error_4="您的授權碼已經被封";
	var $er_error_5="獲取遠程升級列表失敗";
	var $er_error_6="沒有選擇要查看更新模塊";
	var $er_error_7="沒有授權碼或升級模塊為空";
	var $er_error_8="沒有找到要下載的文件";
	var $er_error_9="對不起，當前沒有可下載的資源";
}

class pwlp{
	var $p_null="用戶名和密碼不能為空！";
	var $p_differ="兩次密碼輸入不一致，請重新輸入！";
	var $p_amend_pw="修改用戶名密碼";
	var $p_name="用戶名";
	var $p_formerly_pw="原始密碼";
	var $p_new_pw="新密碼";
	var $p_new_pw_repeat="重複密碼";
	var $p_refer="提交";
	var $p_cancel="取消";
}

class loginlp{
	var $l_manage="後臺管理";
	var $l_help="在綫幫助";
	var $l_mismatch="用戶名或密碼不匹配";
	var $l_backend="後臺管理";
	var $l_null="登錄名與密碼不能為空";
	var $l_login_entrance="後臺登錄入口";
	var $l_login_admin="登錄管理面板";
	var $l_name="用戶名";
	var $l_pw="密碼";
	var $l_forget="忘記您的密碼了?";
	var $l_login="登錄";
	var $l_title="iwebAx軟件產品家族";
	var $l_login_again="請重新登錄";
	var $l_wel_login="歡迎登錄，今天是";
	var $l_login_name="登錄名";
	var $l_login_hello="您好";
	var $l_permissions="權限為";
	var $l_super_admin="超級管理員";
	var $l_amend_pw="修改密碼";
	var $l_out="退出";
	var $l_index="首頁";
	
	var $l_back_management_sys="後臺管理系統";
	var $l_Management_home="管理首頁";
	var $l_global_set="全局設置";
	var $l_user_management="用戶管理";
	var $l_administration="管理";
	var $l_app_management="應用管理";
	var $l_tool_box="工 具 箱";
	
}

class adminmenulp{
	var $ad_global_set="全局設置";
	var $ad_user_management="用戶管理";
	var $ad_manage_skin="皮膚管理";
	var $ad_basic_set="基本設置";
	var $ad_manage_index="管理首頁";
	var $ad_site_set="站點設置";
	var $ad_group_sort="群組分類";
	var $ad_pals_sort="好友分類";
	var $ad_inter_rule="積分規則";
	var $ad_ui_set="UI管理";
	var $ad_manage_tpl="模版管理";
	var $ad_ui_restore="站點UI恢復";
	var $ad_manage_mod="應用管理";
	var $ad_manage_msg="留言管理";
	var $ad_manage_feed="動態管理";
	var $ad_manage_com="評論管理";
	var $ad_manage_sub="話題管理";
	var $ad_manage_gro="群組管理";
	var $ad_manage_poll="投票管理";
	var $ad_manage_blog="日子好管理";
	var $ad_manage_recom="推薦會員";
	var $ad_manage_member="會員管理";
	var $ad_manage_photo="照片管理";
	var $ad_manage_album="相冊管理";
	var $ad_manage_share="分享管理";
	var $ad_manage_report="舉報管理";
	var $ad_manage_mood="心情管理";
	var $ad_manage_data="數據管理";
	var $ad_backup_data="備份數據";
	var $ad_restore_data="恢復數據";
	var $ad_manage_plug="插件管理";
	var $ad_download_skin="下載皮膚";
	var $ad_download_tpl="下載模版";
	var $ad_download_plug="下載插件";
	var $ad_manager_plug="管理插件";
	var $ad_update_online="在綫升級";
	var $ad_update_main="升級主程序";
	var $ad_tools="工具箱";
	var	$ad_tools_list="工具箱列表";
	var $ad_tools_download="下載工具箱";
	var $ad_tools_manage="工具箱管理";
	var $ad_guest_limit="訪問限制";
	var $ad_rights_manage="權限管理";
	var $ad_users_manage="管理員角色分配";
	var $ad_manage_users="管理員角色管理";
	var $ad_front_manage="前臺角色管理";
	var $ad_front_users="用戶角色分配";
	var $ad_member_role_distribution = "會員角色分配";
	var $ad_member_role_management = "會員角色管理";
	var $ad_modify_admin_password = "修改管理員密碼";
	var $ad_invite_code_management = "邀請碼管理";
	var $ad_member_recommend_management = "會員推薦管理";
	
	var $ad_location="當前位置";
	var $ad_compile_status="編譯狀態";
	var $ad_change_password="修改密碼";
	var $ad_amend_temp="修改模版";
	var $ad_top_slide="置頂幻燈";
	var $ad_image_cut="圖片剪切";
	var $ad_member_details="會員詳細信息";
	var $ad_front_role_rights="前臺角色分配權限";
	var $ad_back_role_rights="後臺角色分配權限";
}

class limitlp{
	var $li_update_suc="更新成功";
	var $li_refuse_ip="禁止訪問的ip列表";
	var $li_refuse_ip_info="用戶的ip地址如果處於本列表中則禁止訪問站點。注：每個 IP 一行，既可輸入完整地址，例如：127.0.0.1 也可輸入IP段或者ip頭。如192.168.1.* 或 192.168.";
	var $li_refuse_time="禁止訪問的時間段";
	var $li_refuse_time_info="每天該時間段內用戶不能訪問網站，請使用 24 小時時段格式，每個時間段一行，如需要也可跨越零點，留空為不限制。例如:每日晚 11:25 到次日早 5:05 可設置為: 23:25-5:05每日早 9:00 到當日下午 2:30 可設置為: 9:00-14:30";
	var $li_refuse_action="禁止交互的時間段";
	var $li_refuse_action_info="每天該時間段內用戶不能與網站進行交互，每個時間段為一行，時間格式同上";
	var $li_submit="提交";
}

class rightlp{
	var $ri_refuse="拒絕訪問此頁面";
	var $ri_choose="請選擇";
	var $ri_isset_user="此用戶已存在！";
	var $ri_add_manager="添加管理員";
	var $ri_users="用戶組";
	var $ri_referrer="推薦人";
	var $ri_purple="金幣";
	var $ri_add_users="添加用戶";
	var $ri_users_list="用戶列表";
	var $ri_add="添加";
	var $ri_empty_wrong="請為此管理員選擇用戶組";
	var $ri_pass_wrong="密碼必須不能少於6個字符";
	var $ri_allot="分配權限";
	var $ri_local_user="當前的用戶組";
	var $ri_all_select="全選";
	var $ri_isset_id="此組ID已經存在！";
	var $ri_refuse_id="此組ID已被系統禁用！";
	var $ri_user_wrong="用戶組名稱不能為空";
	var $ri_empty_info="用戶組id和用戶組名稱不能為空";
	var $ri_user_manage="用戶組管理";
	var $ri_user_name="用戶組名稱";
	var $ri_user_id="用戶組ID";
	var $ri_no_pri="對不起，您所在的用戶組沒有該權限";
}
?>
