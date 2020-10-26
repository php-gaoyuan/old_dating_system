<?php
//充值语言包
class rechargelp{
########################井号中间的是新加的################################
	//会员介绍
	var $js_1="Instrucciones para el usuario：";
	var $js_2="identidad";
	var $js_3="signo";
	var $js_4="Breve introducción";
	var $js_5="funcionamiento";
	var $js_6="Miembros ordinario";
	var $js_7="Puede utilizar algunas de las funciones,y puede contactar con otros usuarios、utilizar algunas de las funciones，al día contacta con otros usuarios、actuan mutuamente";
	var $js_8="Miembro superior";
	var $js_9="Puede usar la mayor parte de las funciones,puede contactar con otros usuarios、agregar a los amigos、actuar mutuamente.";
	var $js_sj="Ascende ahora";
	var $js_10="VIP";
	var $js_11="Puede utilizar todas las funciones,no sólo puede contactar con otros usuarios、agregar a los amigos、actuar mutuamente,sino también puede disfrutar de la traducción humana、ascender rápidamente etc.";
	var $js_12="Reglas de escalado de usuario：";
	var $js_13="grado";
	var $js_14="Icono de Nivel";
	var $js_15="Los usuarios comunes en línea larga";
	var $js_16="Advanced User Time Online";
	var $js_17="Usuarios Vip Tiempo Online";
	var $js_18="Los permisos de nivel：";
	var $js_19="Funciones y privilegios";
	var $js_20="Icono de Nivel";
	var $js_21="identidad relacionados";
	var $js_22="Explicación";
	var $js_23="Recargar";
	var $js_24="Compra los monedas de oro para sí mismo o los amigos,que sirve para convertirse en la identidad mayor o la función";
	var $js_25="Fotos";
	var $js_26="Los miembros comunes pueden subir 10*L fotos,los miembros superiores pueden subir 100*L fotos,los miembros VIP pueden subir 1000*L fotos.";
	var $js_27="Diarios";
	var $js_28="Los usuarios comunes pueden publicar un diario todos los días, la limitación principal y VIP.";
	var $js_29="altavoz";
	var $js_30="Todos los usuarios tienen que comprar para poder utilizar";
	var $js_31="Grupos";
	var $js_32="VIP pueden crear muchos grupos.Los usuarios más de 16 niveles pueden crear un grupo";
	var $js_33="IM";
	var $js_34="Muy por encima de los miembros pueden utilizar las funciones de mensajería instantánea, uso ilimitado de Instant Messenger";
	var $js_35="regalo";
	var $js_36="Para él o su amado regalo Enviar a expresar el significado de amor y bendiciones";
	var $js_37="Compartir";
	var $js_38="Compartir los nuevos casos de amigos";
	var $js_39="charla Aseso";
	var $js_40="3 de oro / 12 minutos";
	var $js_41="Plantillas";
	var $js_42="Los usuarios VIP o más de 16 niveles pueden cambiar la piel del espacio";
	var $js_43="Invitar";
	var $js_44="Invita a tus amigos a lovelove ella, invitar a todos y cada uno recibirá 10 puntos";
	var $help_1=" ¿Cómo recarga / compra las monedas de oro？";
	var $help_2="Puede entrar-Recargar.Apoyamos la manera de pago que son PayPal、Alipay etc，si no tiene una cuenta de PayPal，selecciona la Tarjeta de Crédito PayPal para pagar.Todas los maneras de pago son seguros.Este sitio no se recorda automáticamente o coge el dinero doblemente.Si hay ningún problema,contacte con nosotros inmediatamente.";
	var $help_3="¿Cuantos dólares se necesita una moneda de oro？";
	var $help_4="1 moneda de oro más o menos necesita 1 dólar.";
	var $help_5="Recarga de descuento？";
	var $help_6="Si recargas una moneda de oro,necesitas un dólar.";
	var $help_7=" ¿No puedes recargar con éxito？";
	var $help_8="Si no puedes recargar con éxito en la página de lovelove,primero por favor ve tu tarjeta de crédito si tiene el probelma,y luego cambia el navegador,trata de hacerlo otra vez.A veces también puedes ponerte en contacto con PayPal(Por ejemplo el sistema te solicita”Tu tarjeta de crédito no puede pagar este negocio”). ¿Si al fin todavía la operación es fracasada,por favor dinos los detalles,por ejemplo la manera para pagar,el recordatorio de errores? ¿Qué navegador usas?Ofrecenos la captura de pantalla de la página de errores para que nuestros técnicos ayuden a resolver tus probelmas.";
	var $help_9=" ¿Cuando tiempo lo conseguiré después de recargar？";
	var $help_10="En el común caso,después de recargar,el dinero se podrá aparecer en tu cuenta.Sin embargo, el pago electrónico de facturasnecesita esperar por 3-6 días.Si tiene ningún problema,nos envia su número de la cosa o el número del negocio，para que le ayudamos a exminarlo.";
########################################################
	//新增
	var $er_goumaijinbi="Comprar las monedas de oro：1 moneda de oro necesita 1 dólares";
	var $er_chongzhijine="Seleccione la cantidad de la recarga:";
	var $er_20jinbi="30 Moneda de oro Necesita  30 dólares";
	var $er_50jinbi="50 Moneda de oro Necesita  50 dólares";
	var $er_100jinbi="100 Moneda de oro Necesita  100 dólares";
	var $er_200jinbi="200 Moneda de oro Necesita  200 dólares";
	var $er_500jinbi="500 Moneda de oro Necesita  500 dólares";
	var $er_1000jinbi="1000 Moneda de oro Necesita  1000 dólares";
	var $er_zidingyi="costumbre";
	
	
	
	var $er_goupgrade="Ascende ahora";
	var $er_gorecharge="Ahora recargar";
	var $er_recharge="Recargar";
	var $er_recharge_log="Recargue récord";
	var $er_consumption_log="registros de consumo";
	var $er_upgrade="actualización en línea";
	var $er_introduce="Introducción miembros";
	var $er_help="Recarga Ayuda";
	var $er_oneself="Dése recarga";
	var $er_friends="Recarga a un amigo";
	var $er_rechargeable="Elija la cantidad de la recarga";
	var $er_currency="Gold";
	var $er_Other="Otras cantidades";
	var $er_need="necesitar";
	var $er_dollars="dólar";
	var $er_change="Elija la forma de pago";
	var $er_choose_fr="Por favor, selecciona un amigo";

	var $er_Dos_notex="El sistema no existe en la cuenta y, a continuación, asegúrese de llenar.";
	var $er_userrecharge="Por favor rellene el nombre de usuario";
	var $er_rechargewill="Recargue fracaso。";
	var $er_rechargegood="la recarga exitosa";

	var $er_onumber="Número de pedido";
	var $er_topeo="pagador";
	var $er_hapeo="beneficiario";
	var $er_ostat="Estado del pedido";
	var $er_otime="Horas de negociación";
	var $er_good="éxito";

	var $er_updage="modernización";
	var $er_putmsg="correo";
	var $er_gift="regalo";

	var $er_ortype="Tipo del Consumidor";

	var $er_full="Datos temporales no existe";

	var $er_gj="Área de los miembros VIP";
	var $er_gj_1y="1 mes (199 monedas de oro)";
	var $er_gj_3y="3 meses (499 Oros,salvan 98 Oros)";
	var $er_gj_6y="6 meses (899 Oros,salvan 295 Oros)";
	var $er_gj_1n="1 año (1499 Oros,salvan 889 Oros)";

	var $er_vip="Zona de Los miembros superiores";
	var $er_vip_1y="1 meses (14.9 monedas de oro)";
	var $er_vip_3y="3 meses (30 Oros,salvan 10 Oros)";
	var $er_vip_6y="6 meses (60 Oros,salvan 30 Oros)";
	var $er_vip_1n="1 año (120 Oros,salvan 90 Oros)";

	var $er_zvip="Área de los miembros VIP";
	var $er_zvip_1y="1 meses (30 monedas de oro)";
	var $er_zvip_3y="3 meses (70 Oros,salvan 98 Oros)";
	var $er_zvip_6y="6 meses (110 Oros,salvan 295 Oros)";
	var $er_zvip_1n="1 año (180 Oros,salvan 889 Oros)";
	var $er_yj="VIP permanent members upgrade VIP permanent member upgrades";
	var $er_zvip_yj="Permanent (199 gold coins)";

	var $er_tshi="<font color='#ce1221' style='font-weight:bold;'>Comprar monedas de oro</font>：1 de oro sólo $ 0.99";
	var $er_mess="Hay actualmente su cuenta";
	var $er_mess2="Oro insuficiente para la actualización de los miembros, ahora ve recargarla.";

	var $er_nowtype="Su nivel de socio actual es";
    
    var $er_slerror="Cantidad insuficiente de monedas de oro, por favor, recargue";
    var $er_slsucess="Conversión exitosa";
    var $er_sler="error de conversión";

	var $er_howtime="fecha tope";
	var $er_day="día";
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