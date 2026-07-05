<?php
	include('db.php');
	session_start();
	$session_id = $_SESSION['id'];
	
	if(empty($session_id)){
        die();
    }	

    echo"<script>alert('Нажмите ОК если подтверждаете что хотите удалить аккаунт. Если нет, то перейдите на предыдущую страницу')</script>";
    
	mysqli_query($conn, "DELETE FROM `users` WHERE `id` = '$session_id'");
	mysqli_query($conn, "DELETE FROM `rate` WHERE `user_id` = '$session_id'");
	mysqli_query($conn, "DELETE FROM `anims` WHERE `user_id` = '$session_id'");
	mysqli_query($conn, "DELETE FROM `mults` WHERE `user_id` = '$session_id'");
	mysqli_query($conn, "DELETE FROM `comments` WHERE `user_id` = '$session_id'");
	mysqli_query($conn, "DELETE FROM `subs` WHERE `user_id` = '$session_id'");
	mysqli_query($conn, "DELETE FROM `notifications` WHERE `user_id` = '$session_id'");
	session_unset();
	session_destroy();
	header("Location: ../index.php?msng=account_deleted");
?>