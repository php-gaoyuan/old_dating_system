<?php
class grouplp{
	var $g_group="주 그룹";
	var $g_list="그룹 목록";
	var $g_name="이름";
	var $g_mine="내 그룹";
	var $g_creat="그룹 만들기";
	var $g_hot="인기 그룹";
	var $g_search_group="그룹 검색";
	var $g_return_hot="인기 그룹";
	var $g_return_search="그룹 검색";
	var $g_lock_group="그룹이 잠겨 있습니다";
	var $g_resume_len="그룹 소개가 너무 길고, 고정 해주세요";
	var $g_no_photo="아니 업로드 그룹이 없습니다logo";
	var $g_c_suc="그룹의 성공을 만들기";
	var $g_false="작업이 실패, 제발 다시 방문";
	var $g_no_pass="각 옵션을 기입 해주세요";
	var $g_re_suc="성공에 댓글";
	var $g_intro="그룹 소개";
	var $g_wrong="오류, 관리자에게 문의하십시오";
	var $g_no_group="죄송합니다, 현재 그룹이 없습니다";
	var $g_m_limit="관리자의 개수가 많음";
	var $g_no_privilege="죄송합니다, 당신은 권한이 없습니다";
	var $g_app_suc="성공적인 관리자를 설정";
	var $g_revoke_suc="해지 관리자 성공";
	var $g_no_manager="관리자없이";
	var $g_del_suc="성공적으로 삭제";
	var $g_drop_suc="취소 그룹 성공";
	var $g_drop="취소 그룹";
	var $g_c_limit="당신이 너무 많이 생성 그룹";
	var $g_exit_suc="종료 그룹의 성공";
	var $g_change_suc="성공적으로 수정";
	var $g_rep_join="이미의 구성원";
	var $g_a_exit="그룹을 종료할지 여부？";
	var $g_exit="그룹을 종료";
	var $g_rep_reg="당신은 응용 프로그램을 제출 한";
	var $g_join_suc="의 성공에 가입";
	var $g_reg_suc="응용 프로그램이 제출되었습니다, ​​기다려주세요";
	var $g_manage="그룹 관리";
	var $g_info="기본 정보";
	var $g_info_change="데이터 수정";
	var $g_manage_member="승무원 관리";
	var $g_en_space="공간에 대한 액세스";
	var $g_space="그룹 공간";
	var $g_click_join="가입 클릭";
	var $g_find_group="단체 찾기";
	var $g_return="그룹 목록";
	var $g_re_space="그룹 공간";
	var $g_a_drop="취소 그룹은？";
	var $g_manager="관리자";
	var $g_m_normal="일반 회원";
	var $g_c_time="생성";
	var $g_r_time="응용 프로그램 시간";
	var $g_tag="꼬리표";
	var $g_resume="짧은 소개";
	var $g_m_num="회원 수";
	var $g_join_type="방법에 가입";
	var $g_logo="그룹logo";
	var $g_type="범주";
	var $g_creator="창조자";
	var $g_gonggao="발표";
	var $g_m_name="이름";
	var $g_sex="섹스";
	var $g_role="정체";
	var $g_state="지위";
	var $g_ctrl="운영";
	var $g_freedom_join="무료 가입";
	var $g_check_join="가입 확인";
	var $g_refuse_join="가입 거부";
	var $g_examine="전망";
	var $g_del_member="승무원 삭제?";
	var $g_del_subject="이 항목을 삭제?";
	var $g_set_manager="설정 관리자";
	var $g_revoke_manager="관리자의 해지";
	var $g_req_member="대기중인 승무원";
	var $g_re_search="새로운 검색";
	var $g_check="동의";
	var $g_del="삭제";
	var $g_not_pass="하지 않음으로써";
	var $g_pass="통과";
	var $g_none_group="죄송합니다, 당신은 당신이 할 수있는, 아직 그룹 없습니다<a href='modules.php?app=group_creat'>그룹 만들기</a>";
	var $g_search_none="죄송합니다, 아니 당신은 그룹을 찾고，<a href='modules.php?app=group_select'>새로운 검색</a>";
	var $g_s_none_sub="당신이 찾고있는 죄송합니다, 주제가 없습니다";
	var $g_my_creat="생성 된 그룹";
	var $g_my_join="그룹에 가입";
	var $g_none="죄송합니다,이 사용자 그룹은 아직있다";
	
	var $g_button_creat="만들기";
	var $g_button_cancel="취소";
	var $g_button_yes="결정";
	var $g_button_re="복구";
	
	var $g_change_logo="변화logo";
	var $g_man="남성";
	var $g_woman="여성";
	var $g_f_name="그룹 이름으로 찾기";
	var $g_f_type="범주 그룹으로 찾기";
	var $g_f_tag="찾을 수있는 그룹 탭을 누릅니다";
	var $g_not_null="정보는 비워 둘 수 없습니다";
	var $g_data_none="당신은이 페이지를 방문 정보가 존재하지 않습니다";
	var $g_members="크루 목록";
	var $g_bbs="그룹 포럼";
	var $g_topic_num="합계{t_num}주제";
	var $g_search="수색";
	var $g_send="새 주제를 게시";
	var $g_subject="테마";
	var $g_sendor="에 의해 게시 됨";
	var $g_time="시간";
	var $g_read="읽기";
	var $g_re="대답";
	var $g_editor="저자";
	var $g_leave_me="[작은 주에게 보내기]";
	var $g_they_re="사용자 응답";
	var $g_arrest="죄송합니다, 당신은 권한을 액세스 할 수 없습니다";
	var $g_send_time="에 게시：{date}";
	var $g_i_re="나는 회신 할";
	var $g_title="제목에 기입 해주세요";
	var $g_none_content="내용을 기입 해주세요";
	var $g_content="만족";
	var $g_pic="그림";
	var $g_search_result="쿼리 결과";
	var $g_his_group="{holder}그룹";
	var $g_logo_limit="죄송, 픽처 타입 불일치";
	var $g_relation="그룹";
	var $g_cho="선택하세요";
	var $g_sel_album="（이미지 선택 앨범에서 직접 업로드）";
	var $g_join_num="이{num}참여하는 사람들";
	var $g_iam="내가했다";
	var $g_submit="제출";
	var $g_face="표현";
	var $g_remind="{num}그룹에 가입하도록 요청할 누구";
	
	var $g_fill_100_characters="100 자까지 입력합니다";
	var $g_fill_200_characters="200 자까지 입력합니다";
	var $g_founder="생성";
	var $g_seek="발견";
	var $g_data_loading="로딩 중, 잠시 기다려주십시오";
	var $g_content_not_saved="귀하의 입력은 저장되지 않은";
	
	var $g_you_assigned = "당신은에 할당";
	var $g_group_administrator = "관리자 그룹";
	var $g_system_sends = "시스템은 전송";
	var $g_a_notice = "예고";
	var $g_joined_group = "그룹에 가입";
	var $g_create_group = "그룹 만들기";
	var $g_you_as = "당신";
	var $g_admin_revocation = "그룹 관리자가 취소됩니다";
	
};
?>