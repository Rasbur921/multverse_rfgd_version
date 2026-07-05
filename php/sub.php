<?php
	include('db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$get_id = $_GET['id'];
	
	if(empty($session_id)){
		die();
	}
	
	$check = mysqli_query($conn, "SELECT * FROM subs WHERE user_id = '$session_id' AND mult_id = '$get_id'");

	if (mysqli_num_rows($check) == 0) {
		// Если записи нет — вставляем
		mysqli_query($conn, "INSERT INTO subs (user_id, mult_id) VALUES ('$session_id', '$get_id')");
		header("Location: ../mult.php?id=" . $get_id);
	} else {
		// Уже есть
		echo "Уже подписан";
	}
?>