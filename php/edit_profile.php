<?php
	include('db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$session_login = $_SESSION['login'];
	$login = $_POST['name'];
	$desc = $_POST['desc'];
	
	if(empty($login)){
		header("Location: ../edit_profile.php?error=empty");
		die();
	}

	$result = mysqli_query($conn, "SELECT id FROM users WHERE login = '$login'");

	if (mysqli_num_rows($result) > 0 && $session_login != $login) {
		header("Location: ../edit_profile.php?error=occupied_login");
		exit();
	}
	
	mysqli_query($conn, "UPDATE `users` SET `login` = '$login', `desc` = '$desc' WHERE `id` = '$session_id'");
	$_SESSION['login'] = $login;
	header("Location: ../edit_profile.php?error=done");
?>