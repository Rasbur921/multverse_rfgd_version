<?php
	include('db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$get_id = $_GET['id'];
	$view_id = $_GET['v_id'];
	
	mysqli_query($conn, "DELETE FROM `comments` WHERE `id` = '$get_id' AND `user_id` = '$session_id'");
	header("Location: ../view.php?id=" . $view_id . "#comments");
?>