<?php
class msglp{
	var $b_xianzhi='Обычные пользователи могут отправлять каждый день (40 + уровень) сообщения, вы перерасход, пожалуйста, обновите.';
	var $qingchongzhi="Золото является недостаточным, пожалуйста, зарядите";
	var $geshicuowu="Формат ошибки";
	var $tupianguoda="Изображение слишком велико";
	var $m_fanhuiliebiao="Вернуться к списку";
	var $m_qbsc="Удалить все";
	var $m_jrgrzy="Введите личную страницу";
	var $m_jinbibuzu="Золото является недостаточным, пожалуйста, зарядите ";
	var $m_fanyitishi="Продолжать ли? Перевести сообщения нужно золото ";
	var $m_weikong="Содержимое не может быть пустым";
	var $m_sheqi="отказываться";
	var $m_anquantishi="Совет по соблюдению безопасности: Не разглашать свою контактную информацию, не давать деньги в чужой.";
	var $m_zixunjilu="Консультанты записи";
	var $m_uuchat="UU chat записи";
	var $m_fujian="привязанность";
	var $m_title="Написать письмо";
	var $m_in="входящие";
	var $m_out="Исходящие";
	var $m_creat="Новое сообщение";
	var $m_to_user="адресат";
	var $m_from_user="отправитель";
	var $m_cho="Пожалуйста, выберите";
	var $m_tit="тема";
	var $m_tupian="картинка";
	var $m_translation="перевод";
	var $m_transno="Не перевелись";
	var $m_transzd="перевод";
	var $m_cont="содержание";
	var $m_res = "ответ";
	var $m_del="удалять";
	var $m_time="дата";
	var $m_no_rd = "непрочитанный";
	var $m_rd = "читать";
	var $m_no_sed = "Неотправленное";
	var $m_sed = "посланный";
	var $m_state="статус";
	var $m_ico="Аватар";
	var $m_all="весь";
	var $m_user = "пользователь";
	var $m_none_wrong="Пожалуйста, выберите сообщения, которые требуется удалить";
	var $m_b_con = "послать";
	var $m_b_bak = "возвращение";
	var $m_b_can = "отменить";
	var $m_b_com = "ответ";
	var $m_b_sed = "послать";
	var $m_del_ask="Вы уверены, что хотите удалить его？";
	var $m_each_fri = "Взаимосогласованные с друзьями";
	var $m_agr_app = "Согласен, чтобы применить друзей";
	var $m_rej_app = "Отклоненные заявки на ваших друзей";
	var $m_app_fri = "Добавить тебя как друга";
	var $m_sys_send = "система отправляет";
	var $m_each_friend = "Взаимосогласованные с друзьями，Информация будет автоматически добавлен к вашему кругу друзей внутри。<br />Эта информация запись для системы, чтобы отправить, не отвечайте <br />Вы можете продолжать<a href=\"modules.php?app=mypals_search\">Поиск других друзей</a><br>";
	var $m_agree_app = "Согласен, чтобы применить друзей。<br />Эта информация запись для системы, чтобы отправить, не отвечайте <br />Вы можете продолжать<a href=\"modules.php?app=mypals_search\">Поиск других друзей</a><br>";
	var $m_reject_app = "Отклоненные заявки на ваших друзей。<br />Эта информация запись для системы, чтобы отправить, не отвечайте <br />Вы можете<a href=\"modules.php?app=mypals_search\">Поиск других друзей</a><br>";
	var $m_app_friend = "Добавить тебя как друга。<br />Эта информация запись для системы, чтобы отправить, не отвечайте <br />Вы можете<a href=\"javascript:{send_join_js}\">Добавьте его в друзья</a>или<a href=\"modules.php?app=mypals_search\">Поиск других друзей</a><br>";
	var $m_choose="выбирать：";
	var $m_no_mys = "Не можете дать себе почту！";
	var $m_del_suc = "Удаленные успешно！";
	var $m_one_err = "Вы заполняете получателя информация неверна, пожалуйста, проверьте перед отправкой！";
	var $m_cread_put = "Золото ваше дефицит, после обновления, вы можете отправить более подробную информацию.";
	var $m_data_err = "Ошибка в данных, пожалуйста, воссоздать！";
	var $m_send_err = "Не удалось отправить почту, были сданы на хранение в папке Исходящие!";
	var $m_add_exc = "Обновление более 160 символов！";
	var $m_no_one = "Выберите адресата!";
	var $m_no_tit = "Пожалуйста, введите тему сообщения электронной почты!";
	var $m_no_cont = "Пожалуйста, введите сообщение!";
	var $m_mess_detail = "подробнее почта";
	var $m_out_none="Извините, ваш исходящие, нет информации";
	var $m_in_none="К сожалению, ваш почтовый ящик нет информации";
	var $m_num_mail="общий{num}печать";
	var $m_remind="{num}сообщение";
	
	var $m_notice="Системные сообщения";
	var $m_have_read="Прочитали";
	var $m_unread="непрочитанный";
	var $m_given="рант";
	var $m_have_access="Осмотрели";
	var $m_to_notice="уведомление";
	
	var $m_mess_china="привязанность";
	var $m_mess_english="перевод";
	var $m_Dos_notex="Получатели выбранные не существует";
	var $m_stampsmsg="您的新用户体验时间已结束，请充值金币，使用金币兑换邮票，一张邮票与一位异性建立永久联系，如果您有金币，请使用金币直接兑换。";
	
}
class bottlelp{

	var $b_bottle='漂流瓶';
	var $b_find_one='捞一个';
	var $b_send_one='扔一个';
	var $b_find_bottle='收到的漂流瓶';
	var $b_send_bottle='扔出的漂流瓶';
	var $b_reply='回复';
	var $b_back='返回';
	var $b_type='种类';
	var $b_confirm='确定';
	
	var $b_normal='普通瓶';
	var $b_mood='心情瓶';
	var $b_city='同城瓶';
	var $b_ask='提问瓶';
	var $b_contacts='交往瓶';
	var $b_wish='祝愿瓶';
	
	var $b_range='您的漂流瓶漂到了{range}公里的海岸!';
	var $b_range2='您扔的漂流瓶石沉大海了';
	var $b_fail='很遗憾,您的漂流瓶没有扔出去!';
	var $b_nobottle='找不到该漂流瓶';
	var $b_ztbottle1='话题漂流瓶删除成功';
	var $b_ztbottle2='话题漂流瓶删除失败';
	var $b_dbottle1='漂流瓶删除成功';
	var $b_dbottle2='漂流瓶删除失败';
	
	var $b_quanxian='此功能暂不对普通用户开放，请升级高级会员';
	var $b_find='您捞到了一个漂流瓶,请在我的漂流瓶面板查看';
	var $b_nofind='很遗憾,您什么也没有捞到!';
	var $b_nofind2='很遗憾,您捞到了一条小鱼!';
	
	var $b_reply_s='回复成功!';
	var $b_reply_f='回复失败!';
	
	var $b_zhuangban='Обычные пользователи могут использовать 16, продвинутые пользователи не ограничен.';
	var $b_qunzu='Обычные пользователи могут построить более 16 групп, продвинутые пользователи не ограничен.';
	var $b_xianzhi='Обычные пользователи могут отправлять каждый день (40 + уровень) сообщения, вы перерасход, пожалуйста, обновите.';
	var $b_rizhi='Обычные пользователи могут отправлять (уровень) регистрирует каждый день, вы перерасход, пожалуйста, обновите.';
	
	
	
}
?>
