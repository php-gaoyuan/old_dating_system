<?php

//充值语言包

class rechargelp{
########################井号中间的是新加的################################

	//会员介绍
	var $js_1="用戶身份說明：";
	var $js_2="身份";
	var $js_3="標志";
	var $js_4="簡介";
	var $js_5="操作";
	var $js_6="普通會員";
	var $js_7="免費使用網站的部分功能，每天可以適當的與其他用戶聯系、互動";
	var $js_8="高級會員";
	var $js_9="可以使用網站的多數功能，每天可以更多的與其他用戶聯系、交友、互動";
	var $js_sj="立即升級";
	var $js_10="VIP會員";
	var $js_11="可以使用網站的全部功能，每天不單可以與任意用戶聯系、交友、互動，還可以享有人工翻譯、高速升級等尊貴特權。";
	var $js_12="用戶升級規則：";
	var $js_13="等級";
	var $js_14="等級圖標";
	var $js_15="普通用戶在線時長";
	var $js_16="高級用戶在線時長";
	var $js_17="Vip用戶在線時長";
	var $js_18="等級功能權限：";
	var $js_19="功能和特權";
	var $js_20="等級圖標";
	var $js_21="相關身份";
	var $js_22="說明";
	var $js_23="充值";
	var $js_24="購買金條給自己或朋友，用來兌換高級身份和享有更多的功能";
	var $js_25="相冊";
	var $js_26="普通用戶可以上傳10張照片，高級用戶30張，VIP用戶100張。普通用戶不可評論照片。";
	var $js_27="日志";
	var $js_28="普通用戶每天可以發表1篇日志，高級與VIP不限。";
	var $js_29="喇叭";
	var $js_30="所有用戶需要購買才可以使用";
	var $js_31="群組";
	var $js_32="VIP可以建多個群。達到16級可以免費建壹個群組";
	var $js_33="即時通";
	var $js_34="高級以上會員可以使用即時通功能，使用即時通無限制";
	var $js_35="禮物";
	var $js_36="給心愛的他或她發送禮物表達愛慕之意和祝福。";
	var $js_37="分享";
	var $js_38="分享好友的新情況";
	var $js_39="咨詢聊天";
	var $js_40="3金條/12分鍾";
	var $js_41="裝飾";
	var $js_42="VIP或者在線達到16級可以任意更換空間皮膚";
	var $js_43="推廣";
	var $js_44="邀請妳的朋友來lovelove吧，每邀請壹個，將得到10積分";
	var $help_1="如何充值/購買金條？";
	var $help_2="您可以登錄-充值。我們目前僅提供PayPal、支付寶等網絡安全支付方式，如果您沒有PayPal賬戶，您可以選擇-PayPal-信用卡支付的方式。所有的支付方式都是絕對安全的。本站絕沒有任何自動記憶或重複收費的程序。有任何疑問，請馬上與我們聯系。";
	var $help_3="壹金條需要多少美元？";
	var $help_4="1枚金條大約需要1美元。";
	var $help_5="充值有優惠嗎？";
	var $help_6="充值1金條需1美元，目前充值沒有優惠。";
	var $help_7="在充值頁面無法成功充值？";
	var $help_8="如果您在partyings的充值頁面無法成功充值，請先查看妳的信用卡是否有問題然後更換浏覽器重新嘗試。有時您也可以選擇聯系貝寶（比如在系統提示'您的信用卡不能用于支付這筆交易'的情況下）。如果各種方法都嘗試過後仍舊無法成功充值，請將詳細情況告訴我們，比如您使用的是哪種充值方式，有何錯誤提示？使用哪種浏覽器？爲了協助我們技術人員快速查找原因幫妳解決問題，請您盡可能將出錯頁面截圖發給我們。";
	var $help_9="充值過後多長時間可以到賬？";
	var $help_10="通常情況下充值過後金額就會在賬戶裏顯示出來的。但是電子帳單支付，需要等待3-6個交易日才能到帳。如果您對交易有疑問的話可以提交給我們您的貨品號和交易號，以便我們幫您核查。";
########################################################

	//新增
	var $er_goumaijinbi="購買金條，1金條只需1 USD";
	var $er_chongzhijine="選擇充值金額:";
	var $er_20jinbi="30金條 需要30 USD";
	var $er_50jinbi="50金條 需要50 USD";
	var $er_100jinbi="100金條 需要100 USD";
	var $er_200jinbi="200金條 需要200 USD";
	var $er_500jinbi="500金條 需要500 USD";
	var $er_1000jinbi="1000金條 需要1000 USD";
	var $er_zidingyi="自定義";




	var $er_goupgrade="立即升級";
	var $er_gorecharge="立即充值";
	var $er_recharge="充值";
	var $er_recharge_log="充值記錄";
	var $er_consumption_log="消費記錄";
	var $er_upgrade="在線升級";
	var $er_introduce="會員介紹";
	var $er_help="充值幫助";
	var $er_oneself="充給自己";
	var $er_friends="充給好友";
	var $er_rechargeable="選擇充值金額";
	var $er_currency="金條";
	var $er_Other="其他數量";
	var $er_need="需要";
	var $er_dollars="美元";
	var $er_change="選擇支付方式";
	var $er_choose_fr="請選擇好友";



	var $er_Dos_notex="系統不存在該賬號，請確認後再填";
	var $er_userrecharge="請填寫用戶名";
	var $er_rechargewill="充值失敗";
	var $er_rechargegood="充值成功";



	var $er_onumber="訂單號";
	var $er_topeo="付款人";
	var $er_hapeo="受益人";
	var $er_ostat="訂單狀態";
	var $er_otime="交易時間";
	var $er_good="成功";



	var $er_updage="升級";
	var $er_putmsg="郵件";
	var $er_gift="禮品";



	var $er_ortype="消費類型";
	var $er_full="暫時不存在相關數據。";



	var $er_gj="白金會員";
	var $er_gj_1y="1 個月<br>（12 USD）";
	var $er_gj_3y="3 個月<br>（30 USD）";
	var $er_gj_6y="6 個月<br>（59 USD）";
	var $er_gj_1n="1 年<br>（108 USD）";



	var $er_vip="鑽石會員";
	var $er_vip_1y="1 個月<br>（100 USD）";
	var $er_vip_3y="3 個月<br>（288 USD）";
	var $er_vip_6y="6 個月<br>（521 USD）";
	var $er_vip_1n="1 年<br>（999 USD）";


	var $er_tshi="<font color='#ce1221' style='font-weight:bold;'>購買金條</font>：1 金條僅需 1 USD";
	var $er_mess="當前妳的帳號還有";
	var $er_mess2="金條不足用于升級會員，現在去充值吧。";
	var $er_nowtype="妳當前會員級別爲";
    var $er_slerror="金條數量不足，請先充值";
    var $er_slsucess="兌換成功";
    var $er_sler="兌換失敗";
	var $er_howtime="期限";
	var $er_day="天";


	var $er_gj_shuoming1="使用全站大部分功能";
	var $er_gj_shuoming3="交友溝通無限制,人工免費翻譯,在線等級2倍加速";
	var $er_gj_shuoming2="交友溝通無限制,在線等級1.5倍加速";


}



class stampslp{

    var $s_change="兑换";  

    var $s_guize="兑换规则";  

    var $s_guize2="<font color='#ce1221' style='font-weight:bold;'>兑换邮票</font>：2金币兑换1张邮票";  

    var $s_changenum="兑换数量"; 

    var $s_stamps="邮票"; 

    var $s_fastchange="立即兑换"; 

}

?>