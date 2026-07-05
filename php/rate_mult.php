<?php
	include('db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$get_id = $_GET['id'];
	$value = $_POST['rate'];
	
	if(empty($session_id)){
        die();
    }

	if($value > 5 || $value < 1){
        die('Мацуда, не смей!!!');
    }

	mysqli_query($conn, "INSERT INTO rate (`value`, `user_id`, `rate_id`, `type`) VALUES ('$value', '$session_id', '$get_id', 'mult')");
	header("Location: ../mult.php?id=" . $get_id);
?>