<?php
class grouplp{
	var $g_group="群組";
	var $g_list="群組列表";
	var $g_name="名稱";
	var $g_mine="我的群組";
	var $g_creat="創建群組";
	var $g_hot="熱門群組";
	var $g_search_group="搜索群組";
	var $g_return_hot="熱門群組";
	var $g_return_search="搜索群組";
	var $g_lock_group="該群組已被鎖定";
	var $g_resume_len="群組介紹過長，請修正";
	var $g_no_photo="沒有上傳群組logo";
	var $g_c_suc="創建群組成功";
	var $g_false="操作失敗,請重新登錄";
	var $g_no_pass="請認真填寫每個選項";
	var $g_re_suc="回覆成功";
	var $g_intro="群組介紹";
	var $g_wrong="發生錯誤，請與管理員聯繫";
	var $g_no_group="對不起，當前沒有群組";
	var $g_m_limit="管理員人數過多";
	var $g_no_privilege="對不起，您沒有權限";
	var $g_app_suc="設置管理員成功";
	var $g_revoke_suc="撤銷管理員成功";
	var $g_no_manager="沒有該管理員";
	var $g_del_suc="刪除成功";
	var $g_drop_suc="註銷群組成功";
	var $g_drop="註銷群組";
	var $g_c_limit="您所建立的群組過多";
	var $g_exit_suc="退出群組成功";
	var $g_change_suc="修改成功";
	var $g_rep_join="您已經是組員了";
	var $g_a_exit="是否退出群組？";
	var $g_exit="退出群組";
	var $g_rep_reg="您已經提交了申請";
	var $g_join_suc="加入成功";
	var $g_reg_suc="申請已提交,請等待";
	var $g_manage="群組管理";
	var $g_info="基本資料";
	var $g_info_change="資料修改";
	var $g_manage_member="組員管理";
	var $g_en_space="進入空間";
	var $g_space="群組空間";
	var $g_click_join="點擊加入";
	var $g_find_group="查找群組";
	var $g_return="群組列表";
	var $g_re_space="群組空間";
	var $g_a_drop="是否註銷群組？";
	var $g_manager="管理員";
	var $g_m_normal="普通組員";
	var $g_c_time="創建時間";
	var $g_r_time="申請時間";
	var $g_tag="標籤";
	var $g_resume="簡介";
	var $g_m_num="成員數";
	var $g_join_type="加入方式";
	var $g_logo="群組logo";
	var $g_type="類別";
	var $g_creator="創建者";
	var $g_gonggao="公告";
	var $g_m_name="名字";
	var $g_sex="性別";
	var $g_role="身份";
	var $g_state="狀態";
	var $g_ctrl="操作";
	var $g_freedom_join="自由加入";
	var $g_check_join="驗證加入";
	var $g_refuse_join="拒絕加入";
	var $g_examine="查看";
	var $g_del_member="是否刪除組員?";
	var $g_del_subject="是否刪除此話題?";
	var $g_set_manager="設置管理員";
	var $g_revoke_manager="撤銷管理員";
	var $g_req_member="待審核的組員";
	var $g_re_search="重新搜索";
	var $g_check="同意";
	var $g_del="刪除";
	var $g_not_pass="未通過";
	var $g_pass="已通過";
	var $g_none_group="對不起，您目前還沒有群組,您可以<a href='modules.php?app=group_creat'>創建群組</a>";
	var $g_search_none="對不起，您沒有要查找的群組，<a href='modules.php?app=group_select'>重新搜索</a>";
	var $g_s_none_sub="對不起，您沒有要查找的主題";
	var $g_my_creat="創建的群組";
	var $g_my_join="加入的群組";
	var $g_none="對不起，該用戶還沒有群組";
	
	var $g_button_creat="創建";
	var $g_button_cancel="取消";
	var $g_button_yes="確定";
	var $g_button_re="恢復";
	
	var $g_change_logo="更改logo";
	var $g_man="男";
	var $g_woman="女";
	var $g_f_name="按群組名稱查找";
	var $g_f_type="按群組類別查找";
	var $g_f_tag="按群組標籤查找";
	var $g_not_null="信息不能為空";
	var $g_data_none="您所訪問的頁面信息不存在";
	var $g_members="組員列表";
	var $g_bbs="群組討論區";
	var $g_topic_num="共有{t_num}个主題";
	var $g_search="搜索";
	var $g_send="發表新帖";
	var $g_subject="主题";
	var $g_sendor="發帖人";
	var $g_time="時間";
	var $g_read="閱讀";
	var $g_re="回覆";
	var $g_editor="作者";
	var $g_leave_me="[發小紙條]";
	var $g_they_re="網友回覆";
	var $g_arrest="對不起，您的全縣不能訪問";
	var $g_send_time="發表於：{date}";
	var $g_i_re="我要回覆";
	var $g_title="請填寫標題";
	var $g_none_content="請填寫內容";
	var $g_content="內容";
	var $g_pic="圖片";
	var $g_search_result="查詢結果";
	var $g_his_group="{holder}的群組";
	var $g_logo_limit="對不起，圖片類型不匹配";
	var $g_relation="屬群組";
	var $g_cho="請選擇";
	var $g_sel_album="（直接從相冊中選擇圖片上傳）";
	var $g_join_num="已有{num}人加入";
	var $g_iam="我是";
	var $g_submit="提交";
	var $g_face="表情";
	var $g_remind="{num}人請求加入群組";
	
	var $g_fill_100_characters="最多填寫100个字符";
	var $g_fill_200_characters="最多填寫200个字符";
	var $g_founder="創建人";
	var $g_seek="查找";
	var $g_data_loading="數據加載中，請稍候";
	var $g_content_not_saved="您填寫的內容尚未保存";
	
	var $g_you_assigned = "您被指派位";
	var $g_group_administrator = "群組的管理員";
	var $g_system_sends = "系統發送";
	var $g_a_notice = "个通知";
	var $g_joined_group = "加入了群組";
	var $g_create_group = "創建了群組";
	var $g_you_as = "您在";
	var $g_admin_revocation = "群組的管理員身份被撤銷";
	
};
?>