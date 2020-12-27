<?php 
//前台容器页语言包
class arrayhomelp{
	var $ah_reply = "回覆";
	var $ah_label = "標籤";
	var $ah_enable_dress = "是否啟用此裝扮";
	var $ah_system_will = "系統將在";
	var $ah_seconds_return = "秒鐘返回首頁...";
	var $ah_click_return_home = "如果瀏覽器沒有自動調整，點擊這裡返回首頁";
	var $ah_have = "有";
	var $ah_had_seen = "人看過";
	var $ah_more_mood = "更多心情";
	var $ah_personal_homepage = "個人主頁";
	var $ah_data = "資 料";
	var $ah_log = "日 誌";
	var $ah_album = "相 冊";
	var $ah_share = "分 享";
	var $ah_vote = "投 票";
	var $ah_groups = "群 組";
	var $ah_visitors = "訪 客";
	var $ah_events = "活 動";
	var $ah_more = "更多";
	var $ah_friends_circle = "朋友圈";
	var $ah_current_online = "當前在綫";
	var $ah_offline = "離綫";
	var $ah_stealth = "隱身";
	var $ah_friends_add_suc = "好友添加成功";
	var $ah_browser_clipboard = "您的瀏覽器不允許腳本訪問剪切板，請手動設置！";
	var $ah_enter_name = "輸入姓名...";
	var $ah_advanced_search = "高級搜索";
	var $ah_homepage = "首頁";
	var $ah_see_who_online = "看誰在綫";
	var $ah_set_application = "設置應用";
	var $ah_add_friend = "加為好友";
	var $ah_say_hello_to = "向TA打招呼";
	var $ah_chongzhi = "給TA充值";
	var $ah_gift = "送TA禮物";
	var $ah_send_letter = "發站內信";
	var $ah_report_user = "舉報該用戶";
	var $ah_forgot_password = "忘記密碼";
	var $ah_total = "共有";
	var $ah_member_events_here = "名會員活動在這裡...";
	var $ah_personal_space = "個人空間";
	var $ah_groups_share = "群組/分享";
	var $ah_game_application = "遊戲應用";
	var $ah_personal_space_detail = "<dd>建立自己的空間，發表日誌、照片，分</dd><dd>享生活中的點點滴滴..</dd>";
	var $ah_groups_share_detail = "<dd>創建自己的群組，與志同道合者討論感</dd><dd>興趣話題，分享交流信息...</dd>";
	var $ah_game_application_detail = "<dd>與好友們一起玩超酷的互動遊戲和應用</dd><dd>滿足你休閒娛樂的需求...</dd>";
	var $ah_loading_data = "數據加載中...";
	var $ah_fill_content = "請填寫留言內容！";
	var $ah_latest_photos = "最新照片";
	var $ah_view_all_my_photos = "查看我的全部照片";
	var $ah_all_photos = "全部照片";
	var $ah_latest_blog = "最新日誌";
	var $ah_see_all_my_log = "查看我的全部日誌";
	var $ah_all_logs = "全部日誌";
	var $ah_you_can_enter = "您還可以輸入";
	var $ah_word = "字";
	var $ah_to = "給";
	var $ah_message = "留言";
	var $ah_expression = "表情";
	var $ah_new_nothing = "新鮮事";
	var $ah_message_board = "留言板";
	var $ah_see_more_novelty = "查看更多新鮮事";
	var $ah_welcome_you = "歡迎您:";
	var $ah_invite_you_friends = "熱情邀請您為好友。";
	var $ah_after_friend = "成為好友後，您們就可以一起討論話題，及時關注對方的更新，還可以玩有趣的遊戲 ... <br />您也可以方便快捷的發佈自己的日誌、上傳圖片、記錄生活點滴與好友分享。 <br />還等什麼呢？趕快加入我們吧。";
	var $ah_times = "次";
	var $ah_basic_info="基本信息";
	var $ah_birthday="生 日";
	var $ah_hometown="家 鄉";
	var $ah_residence="国家";
}
//错误机制语言包
class errorlp{
	var $er_db_unset="數據庫設置出現問題，請查看相關的數據庫、表和字段是否正常";
	var $er_dont_know="系統出現未知錯誤";
	var $commit_bug="您可以把遇到的問題提交到iwebSNS的Bug討論區";
	var $er_refuse_guest="對不起，當前的時間段拒絕訪問網站。";
	var $er_refuse_action="對不起，當前的時間段拒絕與網站進行交互。";
	var $er_refuse_ip="對不起，您的ip地址拒絕訪問網站。";
}
//登录系统语言包
class loginlp{
	var $l_empty_mail="Email帳戶不能為空！";
	var $l_empty_pass="密碼不能為空!";
	var $l_empty_repa="重複密碼項不能為空!";	
	var $l_not_check="登錄帳號錯誤，請重試";
	var $l_wrong_pass="用戶密碼錯誤!";
	var $l_lock_u="對不起，您的帳戶已被鎖定";
	var $l_loading="登錄連接中...";
	var $l_email="帳號";
	var $l_pass="密碼";
	var $l_repass="重複密碼";
	var $l_save_aco="記住我";
	var $l_hid="隱身登錄";
	var $l_login="登錄";
	var $l_r_aco="還沒有開通你的lovelove帐号？";
	var $l_search_result="搜索結果";
	var $l_user_name="用戶名";
	var $l_momber_login="會員登陸";
	var $l_forget_pw="忘記密碼了？";
	var $l_momber_register="會員註冊";
	var $l_30s_register="30秒快速註冊新用戶！";
	var $l_wel_insert="期待你的加入";
	var $l_jooyea_star="推薦會員";
	var $l_new_momber="最新酷友";
	var $l_sell="我要自薦";
	var $l_location="所在地";
	var $l_chose="請選擇";
	var $l_confirm="確定";
	var $l_age="年</label>齡";
	var $l_sex="性</label>別";
	var $l_no_restraint="不限";
	var $l_search="搜索";
	var $l_lady="女士";
	var $l_men="男士";
	var $l_close="關閉";

	/*new login add*/
	var $bg1_tit = "眾裡尋她千百度";
	var $bg1_txt = "寧願相信我們前世有約，今生的愛情故事不會再改變";

	var $bg2_tit = "你的桃花緣在此開始";
	var $bg2_txt = "想交朋友，就要先為別人做些事——那些需要花時間體力、體貼、奉獻才能做到的事";

	var $bg3_tit = "全新的社交體驗滿足你的需求";
	var $bg3_txt = "命運讓你在這裡遇見我，我們相遇在開始，";
	var $bg3_txt2 = "到這裡來找到你的童話世界";
}
?>