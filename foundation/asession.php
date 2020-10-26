<?php
session_start();
$lifeTime = 24*3600; 
session_set_cookie_params($lifeTime); 
?>