<?php
	include('db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$get_id = $_GET['id'];
	
	mysqli_query($conn, "DELETE FROM `anims` WHERE `id` = '$get_id' AND `user_id` = '$session_id'");
	header("Location: ../index.php?msng=anim_deleted");
?>