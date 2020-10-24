<?php
//活动前台
class event_frontlp{
	var $ef_activity_management = "이벤트 관리";
	var $ef_search = "수색";
	var $ef_no_permission = "죄송합니다, 당신은 권한이 없습니다";
	var $ef_donot_failed_or_locked = "활동이 감사에 의해 잠기거나하지 않기 때문에 당신은 친구에게 초대장을 보낼 수 없습니다。";
	var $ef_donot_ended = "활동이 종료 때문에, 친구에게 초대장을 보낼 수 없습니다。";
	var $ef_donot_deadline = "활동 기한이 있기 때문에 당신은 친구에게 초대장을 보낼 수 없습니다。";
	var $ef_donot_number_full = "활동의 숫자가 작성 되었기 때문에 당신은 친구에게 초대장을 보낼 수 없습니다。";
	var $ef_not_friends = "당신은 친구가 아냐";
	var $ef_add_friend_now = "지금 친구를 추가로 이동";
	var $ef_set_live_city = "당신은 도시를 설정하지 않은";
	var $ef_now_settings = "지금 설정으로 이동";
	var $ef_no_related_activity = "아무 관련 이벤트는 현재 없습니다";
	var $ef_activity = "활동";
	var $ef_is_activity = "활동";
	var $ef_my_albums = "내 앨범";
	var $ef_Holder_album = "{holder}앨범";
	var $ef_update_photo_info = "사진 정보를 편집하려면 여기를 클릭하십시오";
	var $ef_activity_not_exist_canceled = "이 활동은 존재하지 않거나 취소되었습니다";
	var $ef_participated_activity = "이 이벤트에 참가";
	var $ef_attented_activity = "이 이벤트에 주목";
	var $ef_your_app_audit = "등록 검토되고있다";
	var $ef_activity_not_start = "이 활동은 아직 시작되지 않았습니다";
	var $ef_activity_ongoing = "이 활동은 진행 중입니다";
	var $ef_activity_already_end = "이 이벤트는 종료";
	var $ef_activity_not_approved_locked = "이 활동은 승인되지 않았거나 잠겨";
	var $ef_all_activity = "모든 이벤트";
	var $ef_launch_activity = "포스트 이벤트";
	var $ef_recommended_activity = "추천 이벤트";
	var $ef_same_city_activity = "시티 이벤트";
	var $ef_my_activity = "내 이벤트";
	var $ef_update_activity = "활동을 수정";
	var $ef_invite_friends = "친구 초대";
	var $ef_member_management = "관리의 회원";
	var $ef_photo_management = "사진 관리";
	var $ef_activity_name = "이벤트 이름";
	var $ef_activity_city = "이벤트";
	var $ef_please_select = "선택하세요";
	var $ef_activity_location = "이벤트 위치";
	var $ef_activity_time = "시간";
	var $ef_to = "에";
	var $ef_closing = "사선";
	var $ef_activity_sort = "활동의 분류";
	var $ef_posters = "포스터";
	var $ef_activity_number = "이벤트의 수";
	var $ef_activity_number_ef_limit = "참가자의 수는 무제한 0으로 활동이 제한 설정。";
	var $ef_activity_privacy = "활동 개인 정보 보호 정책";
	var $ef_privacy_publicity = "눈에 보이는 모든 사람에게 공개 이벤트는 가입하실 수 있습니다";
	var $ef_half_publicity_activity = "모든 사람이 볼 수 반 공개 이벤트는 초대";
	var $ef_privacy_activity = "개인 이벤트, 초대 볼 수";
	var $ef_activity_options = "활동 옵션";
	var $ef_allowed_invite_friends = "참가자가 친구를 초대 할 수 있도록 추가, 초대받은 사람은 활동을 감사 할 필요가 없습니다";
	var $ef_allows_sharing_photos = "참가자가 이벤트 사진을 공유 할 수 있습니다";
	var $ef_allowed_issue_message = "모두가 의견을 추가 할";
	var $ef_participation_requires_approval = "승인이 필요한 활동에 참여";
	var $ef_allowed_bring_friends = "친구를 가지고 몇 친구를 가지고 참가자가 적극적으로 참여하고 장소를 취할 것입니다 수 있도록 허용";
	var $ef_reg_info = "등록 정보";
	var $ef_submit = "제출";
	var $ef_fill_in_activity_name = "이벤트의 이름을 기입 해주세요";
	var $ef_activity_name_overrun = "이벤트 이름 길이가 제한을 초과";
	var $ef_select_activity_city = "도시를 선택하세요";
	var $ef_fill_in_activity_location = "장소를 기입 해주세요";
	var $ef_activity_location_overrun = "장소 길이 제한을 초과";
	var $ef_select_start_end_time = "시작을 선택하거나 시간을 종료하십시오";
	var $ef_start_after_launch = "이벤트 시작 시간은 시작 시간보다 이전 할 수 없습니다";
	var $ef_end_after_start = "종료 시간이 시작 시간보다 빠를 수 없다";
	var $ef_select_reg_deadline = "등록 마감일을 선택하세요";
	var $ef_end_after_deadline = "시간은 이벤트 등록 마감일의 끝 이전 할 수 없습니다";
	var $ef_deadline_after_start = "등록 마감일은 시작 시간 활동을 이전 할 수 없습니다";
	var $ef_select_activity_sort = "활동 분류를 선택하세요";
	var $ef_reg_info_overrun = "등록 메시지 길이가 제한을 초과";
	var $ef_whether_load = "프리젠 테이션 템플릿이 유형의로드 여부를 확인하시기 바랍니다";
	var $ef_join_not_invite_friends = "당신은 초대를 보낸 친구에게이 이벤트에 참가할 수 없습니다";
	var $ef_invited = "초대했습니다";
	var $ef_selected = "선택된";
	var $ef_invite = "초대";
	var $ef_search_activity = "검색 활동";
	var $ef_select_activity = "전망";
	var $ef_sponsor = "스폰서";
	var $ef_people_select = "사람들은보기";
	var $ef_people_participate = "참가자";
	var $ef_people_attention = "관심";
	var $ef_member = "회원";
	var $ef_photo = "사진";
	var $ef_upload_photo = "사진을 업로드";
	var $ef_come_from = "에서 오는";
	var $ef_select_all = "모든 선택에";
	var $ef_bulk_delete = "일괄 삭제";
	var $ef_current_without_photo = "제공된 사진이 현재 활성화되지";
	var $ef_identity= "정체";
	var $ef_full_member = "전체 회원";
	var $ef_name = "이름";
	var $ef_sex = "섹스";
	var $ef_operation = "운영";
	var $ef_confirm_delete = "삭제 확인";
	var $ef_set_organizer = "설정 주최자";
	var $ef_revocation_organizer = "해지 주최자";
	var $ef_pending_member = "대기 회원";
	var $ef_concerned_user = "관련 사용자";
	var $ef_cancel_activity = "이벤트 취소";
	var $ef_exit_activity = "종료 체험 활동";
	var $ef_cancel_concern = "팔로 잉 언";
	var $ef_confirm_exit = "종료를 확인";
	var $ef_confirm_cancel = "확인 취소";
	var $ef_i_is = "내가했다";
	var $ef_no_activity_you_can = "죄송합니다, 아니 관련 활동을 수행 할 수 있습니다";
	var $ef_initiate_activity = "활동을 시작";
	var $ef_start_date = "시작 날짜";
	var $ef_reg_deadline = "신청 마감";
	var $ef_all_photo = "사진";
	var $ef_activity_type = "이벤트 종류";
	var $ef_fill_in_reg_info = "등록 정보를 입력";
	var $ef_update_reg_info = "등록 정보를 수정";
	var $ef_confirm_participate = "참여를 확정";
	var $ef_carry_number = "사람을 운반";
	var $ef_carrying_tips = "（당신은 친구를 가지고있는 경우, 캐리의 수를 표시하시기 바랍니다）";
	var $ef_reg_info_Tips = "（채우기 위해 템플릿을 제공 발기인 추천）";
	var $ef_this_no_reg_info = "등록 정보를 입력 할 필요없이이 활동";
	var $ef_need_review = "검토해야";
	var $ef_participate_activity = "활동에 참여";
	var $ef_attention_activity = "인식 캠페인";
	var $ef_activity_introduction = "활동 소개";
	var $ef_more = "더";
	var $ef_activity_members = "활동 회원";
	var $ef_album = "앨범";
	var $ef_message = "메시지를 남겨주세요";
	var $ef_reply = "대답";
	var $ef_expression = "표현";
	var $ef_upload_photos_noncompliant = "죄송합니다, 업로드 된 사진이 규격에 맞지 않습니다, ​​제발 다시 업로드";
	var $ef_upload_photo_tips = "上传照片：（각 1M, 그림 유형을 초과 할 수 없습니다jpg | png | gif）";
	var $ef_not_selecte_up_photos_activity = "당신이 사진을 업로드 할 수있는 활동을 선택하지 않은";
	var $ef_select = "전망";
	var $ef_delete = "삭제";
	var $ef_failed = "하지 않음으로써";
	var $ef_verify_join = "가입 확인";
	var $ef_p_name = "이름：";
	var $ef_p_inf = "기술：";
	var $ef_b_con = "결정";
	var $ef_b_del = "취소";
	var $ef_back = "이전으로 돌아 가기";
	var $ef_data_none="이러한 데이터는 현재 멤버도 없습니다";
}

//活动后台
class event_backstagelp{
	var $eb_your = "당신의";
	var $eb_activity_locked = "활동 잠겨 있습니다";
	var $eb_activity_notice_content = "계약의 위반에 대한 활동이 사이트를 잠긴, 그렇지 않으면 작업에서 발생하는 모든 결과를 수정하고 삭제하는 개인 정보의 관리자가 가능한 한 빨리 수정하십시오, 당신은 책임을지지 않습니다。";
	var $eb_system_sends = "시스템은 전송";
	var $eb_num_notice = "{num}예고";
	var $eb_delete_succ = "성공적으로 삭제!";
	var $eb_secret_not_recommended = "개인 활동이다,하지 않는 것이 좋습니다。";
	var $eb_lock = "잠금";
	var $eb_normal = "표준";
	var $eb_date_format_input_error = "날짜 형식이 잘못 입력";
	var $eb_confirm_delete = "삭제 확인";
	var $eb_location = "현재 위치";
	var $eb_app_management = "응용 프로그램 관리";
	var $eb_activity_management = "이벤트 관리";
	var $eb_filter_condition = "필터";
	var $eb_activity_ID = "활동 ID";
	var $eb_title = "표제";
	var $eb_creator_name = "작성자 이름";
	var $eb_activity_type = "이벤트 종류";
	var $eb_public_nature = "공공성";
	var $eb_unlimited = "한정";
	var $eb_privacy = "개인 정보 보호 정책";
	var $eb_half_publicity = "더 많거나 적은 열려";
	var $eb_publicity = "공공의";
	var $eb_activity_city = "이벤트";
	var $eb_please_select = "선택하세요";
	var $eb_end_if = "종료할지 여부";
	var $eb_not_end = "의 끝은 아니다";
	var $eb_already_end = "닫은";
	var $eb_activity_time = "시간";
	var $eb_activity_Status = "활동적인";
	var $eb_to_audit = "대기 중";
	var $eb_failed_audit = "승인되지";
	var $eb_passed_audit = "승인 된";
	var $eb_closed = "닫은";
	var $eb_recommend = "추천";
	var $eb_results_sort = "종류";
	var $eb_default_sort = "기본 정렬";
	var $eb_launch_time = "시간을 시작합니다";
	var $eb_start_time = "시작 시간";
	var $eb_participants_number = "참가자 수";
	var $eb_number_limit = "수의 제한";
	var $eb_search = "수색";
	var $eb_activity_list = "이벤트 목록";
	var $eb_activity_name = "이벤트 이름";
	var $eb_participation_interest = "참여 / 우려";
	var $eb_sponsor = "창시자";
	var $eb_management_status = "관리 상태";
	var $eb_operation = "운영";
	var $eb_time_display_format = "H의 I의 m 달에있는 Y의 D 일";
	var $eb_unlock = "잠금 해제";
	var $eb_sure_lock = "잠금에게 확인";
	var $eb_delete = "삭제";
	var $eb_select_all = "모두 선택";
	var $eb_bulk_delete = "일괄 삭제";
	var $eb_execution_operation = "작업을 수행";
	var $eb_not_select_match_data = "데이터와의 경기에 상품 문의가 없습니다";
	var $eb_user_management = "사용자 관리";
	var $eb_activity_sort = "활동의 분류";
	var $eb_activity = "활동";
	var $eb_update = "수정";
	var $eb_insert = "추가";
	var $eb_ranked_num="주문 상품";
	var $eb_name="이름";
	var $eb_enter_category_name = "카테고리 이름을 입력하십시오";
	var $eb_enter_category_sort = "정렬을 입력하십시오";
	var $eb_category_name = "카테고리 이름";
	var $eb_default_poster = "기본 포스터";
	var $eb_default_poster_prompt = "발기인 이러한 유형의 작업을 시작 할 때, 경우는,이 포스터의 기본을 포스터를 업로드。";
	var $eb_default_template = "기본 템플릿";
	var $eb_default_template_prompt = "이 유형의 활동의 개시는, 기본 디스플레이 콘텐츠 프리젠 테이션 팁에 입력 할 때 활동 시작。";
	var $eb_display_order = "표시 순서";
	var $eb_submit = "제출";
	var $eb_image_loading = "이미지 로딩...";
	
};

//活动action
class event_actionlp{
	var $ea_upload_exceed_limit = "업로드하여 포스터 시스템 한계를 초과";
	var $ea_launch_failure_resubmit = "활동을 시작하지 않으면, 다시 제출하시기 바랍니다";
	var $ea_no_permission = "죄송합니다, 당신은 권한이 없습니다";
	var $ea_you_assigned_to = "당신은에 할당";
	var $ea_organizing_people = "인간 활동의 조직";
	var $ea_system_sends = "시스템은 전송";
	var $ea_num_notice = "{num}예고";
	var $ea_you_join = "당신은 가입";
	var $ea_activity_app_by = "응용 프로그램의 활동은 통과";
	var $ea_you_invited_out = "당신은 밖으로 초대";
	var $ea_activity = "활동";
	var $ea_add_activity = "추가 활동";
	var $ea_activity_were_rejected = "신청 활동이 거부되었습니다";
	var $ea_operation_failed_relogin = "작업이 실패, 제발 다시 방문";
	var $ea_operation_failed_tryagain = "작동 실패, 제발 다시 작동";
	var $ea_not_participate_activity = "이 이벤트에 참여하지 않아도!";
	var $ea_reg_closed = "죄송합니다, 등록이 닫힌!";
	var $ea_activity_ended = "죄송합니다, 활동 종료!";
	var $ea_carry_people_excessive = "나는 여분의 장소 덜 활동의 번호를 가지고 죄송합니다, 너무 많이 해요!";
	var $ea_info_modified = "정보가 수정되었습니다";
	var $ea_sponsor_not_out = "당신은 프로모터, 종료되지 있습니다!";
	var $ea_join_or_app_activity = "당신은 이미이 활동에 참여하기 위해 적용했거나";
	var $ea_attention_activity = "이 이벤트에 관심을 지불";
	var $ea_no_attention_activity = "이 이벤트는없고";
	var $ea_invite_participate = "당신이 참여하도록 초대";
	var $ea_you_can = "당신은 할 수 있습니다";
	var $ea_accept_invite = "초대를 수락";
	var $ea_or_view = "또는보기";
	var $ea_event_details = "이벤트 세부 정보";
	var $ea_participated_activity = "이 이벤트에 참여!";
	var $ea_app_submitted = "당신은 응용 프로그램을 제출 한!";
	var $ea_people_aged = "미안 해요, 전체의 수!";
	var $ea_private_activity_rejoin = "죄송합니다, 개인 이벤트, 가입 거부!";
	var $ea_activity_invited_join = "죄송합니다,이 활동에 초대합니다!";
	var $ea_operation_failed = "작업이 실패";
	var $ea_successfully_add = "축하합니다, 당신은 성공적으로 합류!";
	var $ea_num_people_request_join = "{num}활동에 참여하도록 요청하는 사람";
	var $ea_app_submitted_later = "응용 프로그램이 제출되었습니다, ​​기다려주세요!";
	var $ea_you_in = "당신";
	var $ea_activity_status_revoked = "조직의 정체성 활동은 취소됩니다";
	
};
?>