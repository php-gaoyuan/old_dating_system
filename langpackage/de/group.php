<?php
class grouplp{
	var $g_group="Gruppen";
	var $g_list="Liste Gruppen";
	var $g_name="Name";
	var $g_mine="Meine Gruppen";
	var $g_creat="erstellen Sie eine Gruppe";
	var $g_hot="Top Gruppen";
	var $g_search_group="Suche nach Gruppen";
	var $g_return_hot="Top Gruppen";
	var $g_return_search="Suche nach Gruppen";
	var $g_lock_group="Die Gruppe wurde gesperrt";
	var $g_resume_len="Gruppen Einführung zu lang ist, bitte beheben";
	var $g_no_photo="Keine Upload-Gruppenlogo";
	var $g_c_suc="Erstellen Sie eine Gruppe Erfolg";
	var $g_false="Operation fehlgeschlagen, bitte nochmals Besuch";
	var $g_no_pass="Füllen Optionen";
	var $g_re_suc="Antworten zum Erfolg";
	var $g_intro="Gruppen Einführung";
	var $g_wrong="Fehler, kontaktieren Sie bitte den Administrator";
	var $g_no_group="Es tut mir leid, wenn keine Gruppe";
	var $g_m_limit="Übermäßige Anzahl der Administratoren";
	var $g_no_privilege="Sorry, Sie haben nicht die Berechtigung";
	var $g_app_suc="Stellen Sie den Administrator erfolgreich";
	var $g_revoke_suc="Widerruf Administrator Erfolg";
	var $g_no_manager="Kein Administrator";
	var $g_del_suc="erfolgreich gelöscht";
	var $g_drop_suc="Abbrechen Erfolg";
	var $g_drop="Stornierung Gruppen";
	var $g_c_limit="Gruppen, zu viel zu schaffen";
	var $g_exit_suc="Beenden Gruppe Erfolg";
	var $g_change_suc="erfolgreich geändert";
	var $g_rep_join="Sie sind bereits Mitglieder der";
	var $g_a_exit="Beenden Sie den Gruppen？";
	var $g_exit="Beenden Sie den Gruppen";
	var $g_rep_reg="Sie haben einen Antrag gestellt";
	var $g_join_suc="Schließen Sie sich der Erfolg der";
	var $g_reg_suc="Antrag eingereicht wurde, bitte warten";
	var $g_manage="Konzernlage";
	var $g_info="Daten";
	var $g_info_change="Änderung";
	var $g_manage_member="Crew Management";
	var $g_en_space="Zugang zum Weltraum";
	var $g_space="Gruppen Raum";
	var $g_click_join="Klicken Sie sich registrieren";
	var $g_find_group="Finden Gruppen";
	var $g_return="Liste";
	var $g_re_space="Gruppen Raum";
	var $g_a_drop="Stornierung Gruppen？";
	var $g_manager="Administrator";
	var $g_m_normal="Ordentliche Mitglieder";
	var $g_c_time="Zeit erstellen";
	var $g_r_time="Time-Anwendungen";
	var $g_tag="Anhänger";
	var $g_resume="Kurze Einführung";
	var $g_m_num="Anzahl der Mitglieder";
	var $g_join_type="Registriert Weg";
	var $g_logo="Gruppenlogo";
	var $g_type="Kategorie";
	var $g_creator="Schöpfer";
	var $g_gonggao="Ankündigung";
	var $g_m_name="Name";
	var $g_sex="gender";
	var $g_role="Identität";
	var $g_state="Status";
	var $g_ctrl="Betriebs-";
	var $g_freedom_join="Kostenlose Mitgliedschaft";
	var $g_check_join="Stellen Sie sicher, beitreten";
	var $g_refuse_join="Refused beitreten";
	var $g_examine="anzeigen";
	var $g_del_member="Mitglieder entfernen?";
	var $g_del_subject="Löschen Sie das Thema?";
	var $g_set_manager="Stellen Administrator";
	var $g_revoke_manager="Widerruf der Administratoren";
	var $g_req_member="Warten Sie ein Mitglied des Prüfungs";
	var $g_re_search="Neue Suche";
	var $g_check="ok";
	var $g_del="löschen";
	var $g_not_pass="Nicht durch";
	var $g_pass="bestanden hat";
	var $g_none_group="Sorry,Sie müssen nicht Gruppe,Sie können<a href='modules.php?app=group_creat'>erstellen Sie eine Gruppe</a>";
	var $g_search_none="Sorry, nein, du für eine Gruppe suchen，<a href='modules.php?app=group_select'>Neue Suche</a>";
	var $g_s_none_sub="Sorry, kein Thema, das Sie suchen";
	var $g_my_creat="Gruppen erstellt";
	var $g_my_join="Der Gruppe beitreten";
	var $g_none="Leider ist diese Benutzergruppe noch nicht";
	
	var $g_button_creat="schaffen";
	var $g_button_cancel="stornieren";
	var $g_button_yes="bestimmen";
	var $g_button_re="Restaurierung";
	
	var $g_change_logo="ändern logo";
	var $g_man="männlich";
	var $g_woman="weiblich";
	var $g_f_name="Suche nach Gruppenname";
	var $g_f_type="Suchen Sie nach Kategorie Gruppe";
	var $g_f_tag="Drücken Sie auf die Registerkarte Gruppen zu finden";
	var $g_not_null="Informationen darf nicht leer sein";
	var $g_data_none="Informationen besuchen Sie die Seite existiert nicht";
	var $g_members="Besatzungsliste";
	var $g_bbs="Gruppenforum";
	var $g_topic_num="haben{t_num}Thema";
	var $g_search="Suche";
	var $g_send="Neues Nachricht";
	var $g_subject="Thema";
	var $g_sendor="Autor";
	var $g_time="Zeit";
	var $g_read="lesen";
	var $g_re="antworten";
	var $g_editor="Autor";
	var $g_leave_me="[schreiben Sie eine Notiz]";
	var $g_they_re="Benutzeraktion";
	var $g_arrest="Es tut uns leid, Ihnen keine Privilegien zugreifen können";
	var $g_send_time="Verfasst um：{date}";
	var $g_i_re="antworten";
	var $g_title="Bitte füllen Sie in der Titel";
	var $g_none_content="Bitte füllen Sie die Inhalte";
	var $g_content="Inhalt";
	var $g_pic="Bild";
	var $g_search_result="Die Ergebnisse der Abfrage";
	var $g_his_group="{holder}Gruppen";
	var $g_logo_limit="Sorry, das Bild Typenkonflikt";
	var $g_relation="Gruppe";
	var $g_cho="Bitte wählen Sie";
	var $g_sel_album="（Wählen Sie Bild aus dem Album hochgeladen direkt）";
	var $g_join_num="hat{num}beitreten";
	var $g_iam="Ich war";
	var $g_submit="einreichen";
	var $g_face="Ausdruck";
	var $g_remind="{num}Wer der Gruppe beitreten anfordern";
	
	var $g_fill_100_characters="Füllen Sie bis zu 100 Zeichen";
	var $g_fill_200_characters="Füllen Sie bis zu 200 Zeichen";
	var $g_founder="Erstellt";
	var $g_seek="finden";
	var $g_data_loading="Lade, bitte warten";
	var $g_content_not_saved="Ihre Eingabe konnte nicht gespeichert werden";
	
	var $g_you_assigned = "Sie haben als identifiziert";
	var $g_group_administrator = "Gruppen von Administratoren";
	var $g_system_sends = "Das System sendet";
	var $g_a_notice = "Bekanntmachung";
	var $g_joined_group = "Der Gruppe beitreten";
	var $g_create_group = "Erstellen einer Gruppe";
	var $g_you_as = "Sie";
	var $g_admin_revocation = "Gruppe Administrator widerrufen";
	
};
?>