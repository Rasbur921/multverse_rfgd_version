<?php
	include('db.php');
	session_start();
	$get_id = $_GET['id'];
	$session_id = $_SESSION['id'];
	$title = $_POST['title'];
	$desc = $_POST['desc'];
	
	if(empty($title)){
		header("Location: ../edit_mult.php?id=" . $get_id . "&error=empty");
		die();
	}
	
	mysqli_query($conn, "UPDATE `mults` SET `title` = '$title', `desc` = '$desc' WHERE `id` = '$get_id'");
	header("Location: ../edit_mult.php?id=" . $get_id . "&error=done");
?>