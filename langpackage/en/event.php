<?php
//活动前台
class event_frontlp{
	var $ef_activity_management = "Activity management";
	var $ef_search = "Search";
	var $ef_no_permission = "Sorry, you do not have permission";
	var $ef_donot_failed_or_locked = "You can not send an invitation to friends, because the activity is not locked up by the audit or。";
	var $ef_donot_ended = "You can not send an invitation to friends, because the activity has ended.";
	var $ef_donot_deadline = "You can not send an invitation to friends, because the activity has a Deadline.";
	var $ef_donot_number_full = "You can not send an invitation to friends, because the number of activities have been filled.";
	var $ef_not_friends = "No friends";
	var $ef_add_friend_now = "Now go to Add Friend";
	var $ef_set_live_city = "You have not set City";
	var $ef_now_settings = "Now go to Settings";
	var $ef_no_related_activity = "There are currently no related events";
	var $ef_activity = "Activity";
	var $ef_is_activity = "Activity";
	var $ef_my_albums = "My photo album";
	var $ef_Holder_album = "{holder}Album";
	var $ef_update_photo_info = "Click here to edit the picture information.";
	var $ef_activity_not_exist_canceled = "This activity does not exist or has been canceled.";
	var $ef_participated_activity = "You participated in this event";
	var $ef_attented_activity = "You focus on this activity";
	var $ef_your_app_audit = "Your application is under review";
	var $ef_activity_not_start = "This activity has not yet started";
	var $ef_activity_ongoing = "This activity is underway";
	var $ef_activity_already_end = "This event has ended";
	var $ef_activity_not_approved_locked = "This activity is not approved or is locked";
	var $ef_all_activity = "All Events";
	var $ef_launch_activity = "Post Event";
	var $ef_recommended_activity = "Recommended Events";
	var $ef_same_city_activity = "City events";
	var $ef_my_activity = "My Events";
	var $ef_update_activity = "Modify activities";
	var $ef_invite_friends = "Invite a friend";
	var $ef_member_management = "Members of the Management";
	var $ef_photo_management = "Photo Management";
	var $ef_activity_name = "Event Name";
	var $ef_activity_city = "Urban activities";
	var $ef_please_select = "Please select";
	var $ef_activity_location = "Event Location";
	var $ef_activity_time = "Time activities";
	var $ef_to = "To";
	var $ef_closing = "Registration has closed";
	var $ef_activity_sort = "Classification of activities";
	var $ef_posters = "Posters activities";
	var $ef_activity_number = "Number of events";
	var $ef_activity_number_ef_limit = "Activities limit the number of participants, is set to 0 for unlimited。";
	var $ef_activity_privacy = "Activities Privacy";
	var $ef_privacy_publicity = "Public events, visible to everyone can join";
	var $ef_half_publicity_activity = "Semi-public events, visible to everyone invited to join";
	var $ef_privacy_activity = "Private events, invitees visible";
	var $ef_activity_options = "Activities Options";
	var $ef_allowed_invite_friends = "Allow participants to invite friends, add invitees do not need to audit activity";
	var $ef_allows_sharing_photos = "Allows participants to share event photos";
	var $ef_allowed_issue_message = "Allow everyone to comment";
	var $ef_participation_requires_approval = "Participate in activities that require approval";
	var $ef_allowed_bring_friends = "Allows participants to bring a friend, bring a few friends will take active participant places";
	var $ef_reg_info = "Registration Information";
	var $ef_submit = "Submit";
	var $ef_fill_in_activity_name = "Please fill in the Event Name";
	var $ef_activity_name_overrun = "Event Name length exceeds the limit";
	var $ef_select_activity_city = "Please Select City";
	var $ef_fill_in_activity_location = "Please fill Venue";
	var $ef_activity_location_overrun = "Venue length exceeds limit";
	var $ef_select_start_end_time = "Please select the start or end time";
	var $ef_start_after_launch = "Event Start Time can not be earlier than the launch time";
	var $ef_end_after_start = "End Time can not be earlier than the start time";
	var $ef_select_reg_deadline = "Please select the registration deadline";
	var $ef_end_after_deadline = "Time can not be earlier than the end of the event registration deadline";
	var $ef_deadline_after_start = "Registration deadline can not be earlier than the start time activities";
	var $ef_select_activity_sort = "Please select the activity classification";
	var $ef_reg_info_overrun = "Registration message length exceeds the limit";
	var $ef_whether_load = "Please confirm whether this type of presentation template is loaded";
	var $ef_join_not_invite_friends = "Send an invitation to a friend";
	var $ef_invited = "Has invited";
	var $ef_selected = "Selected";
	var $ef_invite = "Invite";
	var $ef_search_activity = "Search Activities";
	var $ef_select_activity = "Activities View";
	var $ef_sponsor = "Sponsor";
	var $ef_people_select = "View";
	var $ef_people_participate = "Participate";
	var $ef_people_attention = "Attention";
	var $ef_member = "Member";
	var $ef_photo = "Photo";
	var $ef_upload_photo = "Upload Photos";
	var $ef_come_from = "Come from";
	var $ef_select_all = "Select All";
	var $ef_bulk_delete = "Batch Delete";
	var $ef_current_without_photo = "No photo is currently active";
	var $ef_identity= "Identity";
	var $ef_full_member = "Full member";
	var $ef_name = "Name";
	var $ef_sex = "Gender";
	var $ef_operation = "Operation";
	var $ef_confirm_delete = "Confirm Delete";
	var $ef_set_organizer = "Set organizer";
	var $ef_revocation_organizer = "Revocation organizer";
	var $ef_pending_member = "Pending members";
	var $ef_concerned_user = "Users concerned";
	var $ef_cancel_activity = "Cancel Events";
	var $ef_exit_activity = "Exit Activities";
	var $ef_cancel_concern = "Cancel attention";
	var $ef_confirm_exit = "Confirm quit";
	var $ef_confirm_cancel = "Confirm Cancel";
	var $ef_i_is = "I am";
	var $ef_no_activity_you_can = "Sorry, no related activities, you can";
	var $ef_initiate_activity = "Initiate an activity";
	var $ef_start_date = "Start Date";
	var $ef_reg_deadline = "Application deadline";
	var $ef_all_photo = "All photos";
	var $ef_activity_type = "Event Type";
	var $ef_fill_in_reg_info = "Fill out the registration information";
	var $ef_update_reg_info = "Modify registration information";
	var $ef_confirm_participate = "Confirmed their participation";
	var $ef_carry_number = "Carry persons";
	var $ef_carrying_tips = "（If you bring a friend, please indicate the number of carry）";
	var $ef_reg_info_Tips = "（Recommended by the promoters given template to fill）";
	var $ef_this_no_reg_info = "This activity without having to fill out the registration information";
	var $ef_need_review = "Need to review";
	var $ef_participate_activity = "Participate in activities";
	var $ef_attention_activity = "Awareness Campaign";
	var $ef_activity_introduction = "Activities Introduction";
	var $ef_more = "More";
	var $ef_activity_members = "Active member";
	var $ef_album = "Album";
	var $ef_message = "Leave a message";
	var $ef_reply = "Reply";
	var $ef_expression = "Expression";
	var $ef_upload_photos_noncompliant = "Sorry, your uploaded photo does not meet specifications, please re-upload";
	var $ef_upload_photo_tips = "Upload photos：（Each must not exceed 1M, picture typejpg | png | gif）";
	var $ef_not_selecte_up_photos_activity = "Did not choose the activities you want to upload photos";
	var $ef_select = "view";
	var $ef_delete = "Delete";
	var $ef_failed = "Not through";
	var $ef_verify_join = "Verify join";
	var $ef_p_name = "Name：";
	var $ef_p_inf = "Description：";
	var $ef_b_con = "Determine";
	var $ef_b_del = "Cancel";
	var $ef_back = "Return to the previous one";
	var $ef_data_none="These members no data";
}

//活动后台
class event_backstagelp{
	var $eb_your = "Your";
	var $eb_activity_locked = "Activity has been locked";
	var $eb_activity_notice_content = "Activities for breach of the agreement has been locked site, please modify as soon as possible，By the administrator to modify, and delete your information such as operation, all consequences resulting from, will be borne by your own.";
	var $eb_system_sends = " system sends";
	var $eb_num_notice = "{num}Notice";
	var $eb_delete_succ = "Deleted successfully!";
	var $eb_secret_not_recommended = "Is a private activity, not recommended。";
	var $eb_lock = "Locking";
	var $eb_normal = "Normal";
	var $eb_date_format_input_error = "Date format is entered incorrectly";
	var $eb_confirm_delete = "Confirm Delete";
	var $eb_location = "Current Position";
	var $eb_app_management = "Application Management";
	var $eb_activity_management = "Event Management";
	var $eb_filter_condition = "Screening conditions";
	var $eb_activity_ID = "Activity ID";
	var $eb_title = "Title";
	var $eb_creator_name = "Creator name";
	var $eb_activity_type = "Event Type";
	var $eb_public_nature = "Public nature";
	var $eb_unlimited = "unlimited";
	var $eb_privacy = "Privacy";
	var $eb_half_publicity = "More or less open";
	var $eb_publicity = "Public";
	var $eb_activity_city = "Urban activities";
	var $eb_please_select = "Please select";
	var $eb_end_if = "Whether to end";
	var $eb_not_end = "Not the end of the";
	var $eb_already_end = "Has ended";
	var $eb_activity_time = "Time activities";
	var $eb_activity_Status = "Active state";
	var $eb_to_audit = "Pending";
	var $eb_failed_audit = "Not approved";
	var $eb_passed_audit = "Has been approved";
	var $eb_closed = "Has been closed";
	var $eb_recommend = "Recommend";
	var $eb_results_sort = "Sort";
	var $eb_default_sort = "default sort";
	var $eb_launch_time = "Launch time";
	var $eb_start_time = "Start time";
	var $eb_participants_number = "Number of participants";
	var $eb_number_limit = "Limit the number of";
	var $eb_search = "Search";
	var $eb_activity_list = "Events List";
	var $eb_activity_name = "Event Name";
	var $eb_participation_interest = "Participate/Attention";
	var $eb_sponsor = "Initiator";
	var $eb_management_status = "Management Status";
	var $eb_operation = "Operating";
	var $eb_time_display_format = "Y Year m Month d Month  H Time i Point";
	var $eb_unlock = "Unlock";
	var $eb_sure_lock = "Confirm Lock";
	var $eb_delete = "Delete";
	var $eb_select_all = "Select all";
	var $eb_bulk_delete = "Batch Delete";
	var $eb_execution_operation = "Perform operations";
	var $eb_not_select_match_data = "No inquiry into the match with the data";
	var $eb_user_management = "User Management";
	var $eb_activity_sort = "Classification of activities";
	var $eb_activity = "Activity";
	var $eb_update = "Modification";
	var $eb_insert = "Add";
	var $eb_ranked_num="Arrange the serial number";
	var $eb_name="Name";
	var $eb_enter_category_name = "Please enter the category name";
	var $eb_enter_category_sort = "Please enter the sorting";
	var $eb_category_name = "Category Name";
	var $eb_default_poster = "default poster";
	var $eb_default_poster_prompt = "When promoters to initiate this type of activity, if not upload poster, the default for this poster.";
	var $eb_default_template = "default template";
	var $eb_default_template_prompt = "Activities initiated when the initiator of this type of activity, the default display Fill in content presentation tips.";
	var $eb_display_order = "Display Order";
	var $eb_submit = "Submit";
	var $eb_image_loading = "Image Loading...";
	
};

//活动action
class event_actionlp{
	var $ea_upload_exceed_limit = "Upload your poster exceeds the system limit";
	var $ea_launch_failure_resubmit = "Failure to initiate activities, please resubmit";
	var $ea_no_permission = "Sorry, you do not have permission";
	var $ea_you_assigned_to = "You are assigned to";
	var $ea_organizing_people = "Organization of human activities";
	var $ea_system_sends = "system sends";
	var $ea_num_notice = "{num}Notice";
	var $ea_you_join = "You join";
	var $ea_activity_app_by = "Application activity has passed";
	var $ea_you_invited_out = "You are invited out";
	var $ea_activity = "Activity";
	var $ea_add_activity = "Added activities";
	var $ea_activity_were_rejected = "Application activity has been denied";
	var $ea_operation_failed_relogin = "Operation failed, please re-visit";
	var $ea_operation_failed_tryagain = "Operation failed, please re-operation";
	var $ea_not_participate_activity = "You do not have to participate in this event!";
	var $ea_reg_closed = "Sorry, registration has closed!";
	var $ea_activity_ended = "Sorry, activity has ended!";
	var $ea_carry_people_excessive = "I'm sorry, too much to bring the number of spare places less activity!";
	var $ea_info_modified = "Information has been modified";
	var $ea_sponsor_not_out = "Are you a promoter, not exit!";
	var $ea_join_or_app_activity = "You have already applied to participate in this activity or";
	var $ea_attention_activity = "You have paid attention to this event";
	var $ea_no_attention_activity = "You are not concerned about this event";
	var $ea_invite_participate = "Invites you to participate";
	var $ea_you_can = "You can";
	var $ea_accept_invite = "Accept the invitation";
	var $ea_or_view = "Or view";
	var $ea_event_details = "Event Details";
	var $ea_participated_activity = "You have participated in this event!";
	var $ea_app_submitted = "You have submitted an application!";
	var $ea_people_aged = "I'm sorry, the number of full!";
	var $ea_private_activity_rejoin = "Sorry, private events, refused to join!";
	var $ea_activity_invited_join = "Sorry, this activity must be invited to join!";
	var $ea_operation_failed = "Operation failed";
	var $ea_successfully_add = "Congratulations, you have successfully joined!";
	var $ea_num_people_request_join = "{num}Request to Join Activities";
	var $ea_app_submitted_later = "Your application has been submitted, please wait!";
	var $ea_you_in = "You";
	var $ea_activity_status_revoked = "Organizational identity activity is revoked";
	
};
?>