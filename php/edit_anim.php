<?php
	include('db.php');
	session_start();
	$get_id = $_GET['id'];
	$session_id = $_SESSION['id'];
	$title = $_POST['title'];
	$desc = $_POST['desc'];
	$age = $_POST['age'];
	$mult = $_POST['mult'];
	$season = $_POST['season'];
	
	if(empty($title)){
		header("Location: ../edit_anim.php?id=" . $get_id . "&error=empty");
		die();
	}
	
	mysqli_query($conn, "UPDATE `anims` SET `title` = '$title', `desc` = '$desc', `age` = '$age', `mult_id` = '$mult', `season` = '$season' WHERE `id` = '$get_id'");
	header("Location: ../edit_anim.php?id=" . $get_id . "&error=done");
?>