<?php 

include("functions/init.php");


session_destroy();

if(isset($COOKIE['email'])) {
	unset($COOKIE['email']);
	setcookie(('email', '', time()-60));
}

redirect("login.php");