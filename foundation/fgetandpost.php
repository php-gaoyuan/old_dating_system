<?php
//�Ա���ͳһ����
function get_args($name)
{
	if(isset($_POST[$name]))return $_POST[$name];
	if(isset($_GET[$name]))return $_GET[$name];
	return null;
}

function get_argus($name)
{
	if(isset($_POST[$name]))return iconv('GB2312', 'UTF-8',$_POST[$name]);
	if(isset($_GET[$name]))return iconv('GB2312', 'UTF-8',$_GET[$name]);
	return null;
}

//get��������
function get_argg($name){
	if(isset($_GET[$name]))return $_GET[$name];
	return null;
}

//post��������
function get_argp($name){
	if(isset($_POST[$name]))return $_POST[$name];
	return null;
}
?>
