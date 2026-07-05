<?php
	session_start();
	$session_id = $_SESSION['id'];
	$session_login = $_SESSION['login'];
	$session_ac = $_SESSION['admin_code'];
	
	echo('ID: ' . $session_id);
	echo "<br>";
	echo('Login: ' . $session_login);
	echo "<br>";
	echo('Admin Code: ' . $session_ac);
	echo "<br>";
	echo phpversion();
?>