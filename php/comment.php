<?php
error_reporting(E_ALL);
ini_set('display_startup_errors', 1);
ini_set('display_errors', '1'); 

	include('db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$text = $_POST['text'];
	$date = date('d.m.Y H:i');
	$get_id = $_GET['id'];
	$user_id = $_GET['user_id'];

    if(empty($session_id)){
        die();
    }

	if(empty($text)){
		echo'??????????, ??????? ?????!';
		die();
	}
	
	mysqli_query($conn, "INSERT INTO comments (text, user_id, date, anim_id, ischange) VALUES ('$text', '$session_id', '$date', '$get_id', '0')");
	if($session_id != $user_id){
		mysqli_query($conn, "INSERT INTO notifications (text, user_id, send_user_id, view_id, link, comm, `read`) VALUES ('оставил комментарий под вашей анимацией', '$session_id', '$user_id', '$get_id', 'view', '1', '0')");
	}
	header("Location: ../view.php?id=" . $get_id . "#comments");
?>