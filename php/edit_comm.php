<?php
	include('db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$id = $_GET['id'];
	$text = $_POST['text'];
	
	if(empty($text)){
		header("Location: ../edit_comm.php?error=empty&id=" . $id);
		die();
	}
	
	mysqli_query($conn, "UPDATE `comments` SET `text` = '$text', `ischange` = '1' WHERE `id` = '$id' AND user_id = '$session_id'");
	header("Location: ../edit_comm.php?error=done&id=" . $id);
?>