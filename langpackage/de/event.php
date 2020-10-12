<?php
//活动前台
class event_frontlp{
	var $ef_activity_management = "Event Management";
	var $ef_search = "Suche";
	var $ef_no_permission = "tut mir leid，Sie haben keine Berechtigung";
	var $ef_donot_failed_or_locked = "Sie können eine Einladung nicht an einen Freund senden，Aktivität gesperrt。";
	var $ef_donot_ended = "Sie können eine Einladung nicht an einen Freund senden，Ende der Veranstaltung。";
	var $ef_donot_deadline = "Sie können eine Einladung nicht an einen Freund senden，Aktivitäten haben Schluss。";
	var $ef_donot_number_full = "Sie können eine Einladung nicht an einen Freund senden，die maximale Anzahl von。";
	var $ef_not_friends = "Sie haben keine Freunde";
	var $ef_add_friend_now = "Jetzt Freunde hinzufügen";
	var $ef_set_live_city = "Kein Aufenthalts";
	var $ef_now_settings = "Jetzt gehen Sie zu Einstellungen";
	var $ef_no_related_activity = "Es liegen noch keine verwandten Ereignissen";
	var $ef_activity = "Aktivität";
	var $ef_is_activity = "Aktivität";
	var $ef_my_albums = "My Album";
	var $ef_Holder_album = "{holder}Album";
	var $ef_update_photo_info = "Klicken Sie hier, um das Bild zu bearbeiten, Informationen";
	var $ef_activity_not_exist_canceled = "Diese Tätigkeit ist nicht vorhanden oder wurde abgesagt";
	var $ef_participated_activity = "Beteiligen Sie sich an dieser Veranstaltung";
	var $ef_attented_activity = "Sehen Sie diese Tätigkeit";
	var $ef_your_app_audit = "Prüfung";
	var $ef_activity_not_start = "Aktivität nicht gestartet";
	var $ef_activity_ongoing = "Laufende Aktivitäten";
	var $ef_activity_already_end = "Ende der Veranstaltung";
	var $ef_activity_not_approved_locked = "Diese Aktivität wird nicht genehmigt oder gesperrt";
	var $ef_all_activity = "Alle Veranstaltungen";
	var $ef_launch_activity = "Beitrag Ereignis";
	var $ef_recommended_activity = "Empfohlene Veranstaltungen";
	var $ef_same_city_activity = "Veranstaltungen der Stadt";
	var $ef_my_activity = "Meine Veranstaltungen";
	var $ef_update_activity = "ändern Aktivitäten";
	var $ef_invite_friends = "Lade einen Freund ein";
	var $ef_member_management = "Vorstandsmitglieder";
	var $ef_photo_management = "Fotoverwaltung";
	var $ef_activity_name = "Event Name";
	var $ef_activity_city = "City";
	var $ef_please_select = "Bitte wählen Sie";
	var $ef_activity_location = "Event-Location";
	var $ef_activity_time = "Zeit";
	var $ef_to = "zu";
	var $ef_closing = "Stopp";
	var $ef_activity_sort = "Klassifikation der Aktivitäten";
	var $ef_posters = "Poster";
	var $ef_activity_number = "Anzahl der Personen";
	var $ef_activity_number_ef_limit = "Beschränken Sie die Anzahl der，auf 0 gesetzt bedeutet unbegrenzte。";
	var $ef_activity_privacy = "Geheimnis";
	var $ef_privacy_publicity = "Öffentliche Veranstaltungen，Jeder kann beitreten sichtbar";
	var $ef_half_publicity_activity = "Semi-öffentlichen Veranstaltungen，für jeden sichtbar, beitreten";
	var $ef_privacy_activity = "Private Veranstaltungen，Menschen sichtbar einladen";
	var $ef_activity_options = "Aktivitäten Optionen";
	var $ef_allowed_invite_friends = "Lassen Sie die Teilnehmer, Freunde einzuladen，Eingeladene ohne Stich";
	var $ef_allows_sharing_photos = "Ermöglicht den Teilnehmern, Fotos zu teilen";
	var $ef_allowed_issue_message = "Lassen Post einen Kommentar";
	var $ef_participation_requires_approval = "Beteiligen Sie sich an Aktivitäten, die eine Genehmigung erfordern";
	var $ef_allowed_bring_friends = "Ermöglicht den Teilnehmern, einen Freund mitbringen，Aber wird Plätze besetzen";
	var $ef_reg_info = "Informationen zur Anmeldung";
	var $ef_submit = "einreichen";
	var $ef_fill_in_activity_name = "Bitte füllen Sie das Event Name";
	var $ef_activity_name_overrun = "Event Name Länge den Grenzwert überschreitet";
	var $ef_select_activity_city = "Bitte Stadt auswählen";
	var $ef_fill_in_activity_location = "Bitte füllen Veranstaltungsort";
	var $ef_activity_location_overrun = "Veranstaltungsort Länge Grenze überschreitet";
	var $ef_select_start_end_time = "Bitte wählen Sie den Start-oder Endzeit";
	var $ef_start_after_launch = "Event-Startzeit kann nicht früher als die Startzeit sein";
	var $ef_end_after_start = "Endzeit kann nicht früher als die Startzeit sein";
	var $ef_select_reg_deadline = "Bitte wählen Sie den Anmeldeschluss";
	var $ef_end_after_deadline = "Die Zeit kann nicht früher als das Ende der Veranstaltung Anmeldeschluss sein";
	var $ef_deadline_after_start = "Anmeldeschluss kann nicht früher als die Startzeit sein Aktivitäten";
	var $ef_select_activity_sort = "Bitte wählen Sie die Aktivität Klassifizierung";
	var $ef_reg_info_overrun = "Registrierung Nachrichtenlänge den Grenzwert überschreitet";
	var $ef_whether_load = "Bitte bestätigen Sie, ob diese Art der Präsentationsvorlage geladen";
	var $ef_join_not_invite_friends = "Sie können andere einladen";
	var $ef_invited = "eingeladen hat";
	var $ef_selected = "ausgewählt";
	var $ef_invite = "laden";
	var $ef_search_activity = "Suchen Aktivitäten";
	var $ef_select_activity = "anzeigen";
	var $ef_sponsor = "Sponsor";
	var $ef_people_select = "anzeigen";
	var $ef_people_participate = "teilnehmen";
	var $ef_people_attention = "Achtung";
	var $ef_member = "Mitglied ";
	var $ef_photo = "Foto";
	var $ef_upload_photo = "hochladen";
	var $ef_come_from = "kommen aus";
	var $ef_select_all = "Alle auswählen";
	var $ef_bulk_delete = "Batch löschen";
	var $ef_current_without_photo = "Kein Foto ist derzeit aktiv";
	var $ef_identity= "Identität";
	var $ef_full_member = "Ordentliches Mitglied";
	var $ef_name = "Name";
	var $ef_sex = "Geschlecht";
	var $ef_operation = "Betriebs-";
	var $ef_confirm_delete = "Löschen bestätigen";
	var $ef_set_organizer = "Veranstalter";
	var $ef_revocation_organizer = "Widerruf";
	var $ef_pending_member = "anstehend";
	var $ef_concerned_user = "Betroffenen Nutzer";
	var $ef_cancel_activity = "stornieren";
	var $ef_exit_activity = "Beenden Aktivitäten";
	var $ef_cancel_concern = "unfollow";
	var $ef_confirm_exit = "Beenden bestätigen";
	var $ef_confirm_cancel = "bestätigen Abbrechen";
	var $ef_i_is = "Ich war";
	var $ef_no_activity_you_can = "tut mir leid,Keine Aktivität, Sie können";
	var $ef_initiate_activity = "Initiieren Sie eine Aktivität";
	var $ef_start_date = "Startdatum";
	var $ef_reg_deadline = "Bewerbungsschluss";
	var $ef_all_photo = "Alle Fotos";
	var $ef_activity_type = "Event Type";
	var $ef_fill_in_reg_info = "Füllen Sie das Anmeldeinformationen";
	var $ef_update_reg_info = "Ändern Sie die Registrierungsinformationen";
	var $ef_confirm_participate = "bestätigen";
	var $ef_carry_number = "Anzahl der Personen";
	var $ef_carrying_tips = "（Bringen Sie einen Freund，Anzahl der Personen）";
	var $ef_reg_info_Tips = "（In Übereinstimmung mit der Vorlage zu füllen）";
	var $ef_this_no_reg_info = "Brauchen Sie nicht, füllen Sie die Registrierungsinformationen";
	var $ef_need_review = "Prüfung";
	var $ef_participate_activity = "Teilnahme an Aktivitäten";
	var $ef_attention_activity = "Awareness Campaign";
	var $ef_activity_introduction = "Aktivitäten Einführung";
	var $ef_more = "mehr";
	var $ef_activity_members = "Aktives Mitglied";
	var $ef_album = "Album";
	var $ef_message = "bleiben";
	var $ef_reply = "antworten";
	var $ef_expression = "Ausdruck";
	var $ef_upload_photos_noncompliant = "tut mir leid，Ihr Foto nicht die Anforderungen erfüllen，Bitte erneut hochladen";
	var $ef_upload_photo_tips = "hochladen：（nicht überschreiten 1M ，Bildtyp jpg | png | gif）";
	var $ef_not_selecte_up_photos_activity = "Haben Sie nicht die Aktivitäten, die Sie Fotos hochladen möchten, wählen Sie";
	var $ef_select = "anzeigen";
	var $ef_delete = "löschen";
	var $ef_failed = "Nicht durch";
	var $ef_verify_join = "beitreten";
	var $ef_p_name = "Name：";
	var $ef_p_inf = "Beschreibung：";
	var $ef_b_con = "bestimmen";
	var $ef_b_del = "stornieren";
	var $ef_back = "Rückkehr zum vorherigen";
	var $ef_data_none="Es gibt keine Daten";
}

//活动后台
class event_backstagelp{
	var $eb_your = "Ihre";
	var $eb_activity_locked = "verschlossen";
	var $eb_activity_notice_content = "Aktivität gesperrt，Bitte ändern，Ansonsten sind alle Folgen，Auf eigene Gefahr。";
	var $eb_system_sends = "Das System sendet";
	var $eb_num_notice = "{num}Bekanntmachung";
	var $eb_delete_succ = "erfolgreich gelöscht!";
	var $eb_secret_not_recommended = "Ist eine private Tätigkeit，Nicht zu empfehlen。";
	var $eb_lock = "Sperrung";
	var $eb_normal = "normal";
	var $eb_date_format_input_error = "Datumsformat falsch eingegeben";
	var $eb_confirm_delete = "Löschen bestätigen";
	var $eb_location = "Aktuelle Position";
	var $eb_app_management = "Anwendung";
	var $eb_activity_management = "Aktivität";
	var $eb_filter_condition = "Filter";
	var $eb_activity_ID = "Aktivitäts-ID";
	var $eb_title = "Titel";
	var $eb_creator_name = "Creator Namen";
	var $eb_activity_type = "Ereignistyp";
	var $eb_public_nature = "Öffentliche Natur";
	var $eb_unlimited = "Einschränkung";
	var $eb_privacy = "Geheimnis";
	var $eb_half_publicity = "mehr oder weniger offenen";
	var $eb_publicity = "Öffentlichkeit";
	var $eb_activity_city = "City";
	var $eb_please_select = "Bitte wählen Sie";
	var $eb_end_if = "End?";
	var $eb_not_end = "noch nicht zu Ende";
	var $eb_already_end = "geschlossen";
	var $eb_activity_time = "Zeit";
	var $eb_activity_Status = "Status";
	var $eb_to_audit = "Überprüfung steht";
	var $eb_failed_audit = "Nicht genehmigt";
	var $eb_passed_audit = "Wurde genehmigt";
	var $eb_closed = "geschlossen";
	var $eb_recommend = "empfehlen";
	var $eb_results_sort = "Art";
	var $eb_default_sort = "Default";
	var $eb_launch_time = "Starten Zeit";
	var $eb_start_time = "Starten Zeit";
	var $eb_participants_number = "Anzahl der Personen";
	var $eb_number_limit = "Limit-";
	var $eb_search = "Suche";
	var $eb_activity_list = "Liste";
	var $eb_activity_name = "Name";
	var $eb_participation_interest = "teilnehmen/Achtung";
	var $eb_sponsor = "Initiator";
	var $eb_management_status = "Status";
	var $eb_operation = "Betriebs-";
	var $eb_time_display_format = "Y Year m month d Day H Zeit i Punkt";
	var $eb_unlock = "aufschließen";
	var $eb_sure_lock = "bestätigen Sperre";
	var $eb_delete = "löschen";
	var $eb_select_all = "Wählen Sie alle";
	var $eb_bulk_delete = "Batch löschen";
	var $eb_execution_operation = "Führen Operationen";
	var $eb_not_select_match_data = "Haben einstimmenden Daten nicht finden";
	var $eb_user_management = "Benutzerverwaltung";
	var $eb_activity_sort = "Klassifikation";
	var $eb_activity = "Aktivität";
	var $eb_update = "Änderung";
	var $eb_insert = "hinzufügen";
	var $eb_ranked_num="Seriennummer";
	var $eb_name="Name";
	var $eb_enter_category_name = "Geben Sie den Namen der Kategorie";
	var $eb_enter_category_sort = "Geben Sie die Sortierung";
	var $eb_category_name = "Kategorie Name";
	var $eb_default_poster = "Die Standard-Poster";
	var $eb_default_poster_prompt = "Bei der Einleitung Aktivitäten，Wenn Sie nicht Plakat hochladen，Mit diesem Plakat Standard。";
	var $eb_default_template = "Schablone";
	var $eb_default_template_prompt = "Bei der Einleitung Aktivitäten，Die Standardanzeige。";
	var $eb_display_order = "Anzeigereihenfolge";
	var $eb_submit = "einreichen";
	var $eb_image_loading = "Bild wird geladen...";
	
};

//活动action
class event_actionlp{
	var $ea_upload_exceed_limit = "Laden Sie Ihre Poster die Systemgrenze überschreitet";
	var $ea_launch_failure_resubmit = "Nicht Aktivitäten initiieren, bitte erneut";
	var $ea_no_permission = "Sorry, Sie haben nicht die Berechtigung";
	var $ea_you_assigned_to = "Sie sind zu vergeben";
	var $ea_organizing_people = "Veranstalter";
	var $ea_system_sends = "Das System sendet";
	var $ea_num_notice = "{num}Bekanntmachung";
	var $ea_you_join = "beitreten";
	var $ea_activity_app_by = "von";
	var $ea_you_invited_out = "wird entfernt";
	var $ea_activity = "Aktivität";
	var $ea_add_activity = "Hinzugefügt Aktivitäten";
	var $ea_activity_were_rejected = "Anwendungsaktivität wurde verweigert";
	var $ea_operation_failed_relogin = "Operation fehlgeschlagen, bitte nochmals Besuch";
	var $ea_operation_failed_tryagain = "Operation fehlgeschlagen, bitte nochmals Betrieb";
	var $ea_not_participate_activity = "Sie müssen nicht an dieser Veranstaltung teilnehmen!";
	var $ea_reg_closed = "Sorry, Registrierung wurde geschlossen!";
	var $ea_activity_ended = "Sorry, Aktivität beendet!";
	var $ea_carry_people_excessive = "Sorry, nicht genug Plätze!";
	var $ea_info_modified = "Informationen wurde geändert";
	var $ea_sponsor_not_out = "Sie können nicht aufhören!";
	var $ea_join_or_app_activity = "Sie haben bereits angewendet, um an dieser Aktivität teilzunehmen oder";
	var $ea_attention_activity = "Achtung";
	var $ea_no_attention_activity = "Nicht betroffen";
	var $ea_invite_participate = "zur Teilnahme eingeladen";
	var $ea_you_can = "Sie können";
	var $ea_accept_invite = "Nehmen Sie die Einladung";
	var $ea_or_view = "oder Blick";
	var $ea_event_details = "Weitere Informationen zur Veranstaltung";
	var $ea_participated_activity = "Sie haben an dieser Veranstaltung teilgenommen!";
	var $ea_app_submitted = "Sie haben einen Antrag gestellt!";
	var $ea_people_aged = "Es tut mir leid, die Zahl der Voll!";
	var $ea_private_activity_rejoin = "Es tut uns leid, private Veranstaltungen, weigerte sich zu kommen!";
	var $ea_activity_invited_join = "Sorry, muss diese Aktivität eingeladen werden!";
	var $ea_operation_failed = "Operation fehlgeschlagen";
	var $ea_successfully_add = "Herzlichen Glückwunsch, Sie erfolgreich beigetreten sind!";
	var $ea_num_people_request_join = "{num}Anfrage auf Aufnahme";
	var $ea_app_submitted_later = "Eingereicht wurde, bitte warten!";
	var $ea_you_in = "Sie";
	var $ea_activity_status_revoked = "Organisationsidentität wird widerrufen";
	
};
?>