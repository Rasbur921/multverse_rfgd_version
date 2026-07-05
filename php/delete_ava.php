<?php
	include('db.php');
	session_start();
	$session_id = $_SESSION['id'];
	
	mysqli_query($conn, "UPDATE `users` SET `avatar` = 'default' WHERE `id` = '$session_id'");
	$_SESSION['login'] = $login;
	header("Location: ../edit_profile.php?error=done_del_ava");
?>