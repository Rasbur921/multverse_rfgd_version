<?php
	include('db.php');
	session_start();
	$session_id = $_SESSION['id'];
	
	mysqli_query($conn, "DELETE FROM `notifications` WHERE `send_user_id` = '$session_id'");
	header("Location: ../notifications.php");
?>