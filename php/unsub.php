<?php
	include('db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$get_id = $_GET['id'];
	
	if(empty($session_id)){
		die();
	}
	
	mysqli_query($conn, "DELETE FROM `subs` WHERE `mult_id` = '$get_id' AND `user_id` = '$session_id'");
	header("Location: ../mult.php?id=" . $get_id);
?>