<?php
	include('php/db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$get_id = $_GET['id'];
	$error = $_GET['error'];
	$result = mysqli_query($conn, "SELECT * FROM comments WHERE id = '$get_id' AND user_id = '$session_id'");
	$row = mysqli_fetch_assoc($result);
	
	$id = $row['id'];
	$user_id = $row['user_id'];
	$text = $row['text'];
	
	if($session_id != $user_id){
?>
	<script>window.close()</script>
<?php
	die();
	}
?>
<html>
<head>
	<title>Редактирование комментария | MultVerse</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<link href="style.css" rel="stylesheet" type="text/css">
	<link rel="icon" href="imgs/icon.png" type="image/x-icon"/>
</head>
<body style="background-image: url('imgs/login-bg.gif')">
	<center>
		<?
			if($error == 'done'){
		?>
			<h3 style="color: green">Изменения прошли успешно!</h3>
		<?
			}elseif($error == 'empty'){
		?>
			<h3 style="color: red">Поле не должно быть пустым!</h3>
		<?
			}else{
		?>
			<h2>Изменение комментария:</h2>
		<?
			}
		?>
	<form action="php/edit_comm.php?id=<?=$get_id?>" method="post">
		<br>
		<textarea name="text" style="width: 420px; height: 150px"><?=$text?></textarea>
		<br>
		<div align="center"><button type="submit">Изменить</button></div>
	</form>
</body>
</html>