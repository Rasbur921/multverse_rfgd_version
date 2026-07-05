<?php
	include('php/db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$error = $_GET['error'];
	$result = mysqli_query($conn, "SELECT * FROM users WHERE id = '$session_id'");
	$row = mysqli_fetch_assoc($result);
	
	$id = $row['id'];
	$name = $row['login'];
	$desc = $row['desc'];
	
	if($session_id != $id){
?>
	<script>window.close()</script>
<?php
	die();
	}
?>
<html>
<head>
	<title>Редактирование профиля | MultVerse</title>
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
			<h3 style="color: red">Поле с именем не должно быть пустым!</h3>
		<?
			}elseif($error == 'done_ava'){
		?>
			<h3 style="color: green">Аватарка успешна измененна!</h3>
		<?
			}elseif($error == 'done_del_ava'){
		?>
			<h3 style="color: green">Аватарка успешна убранна!</h3>
		<?
			}elseif($error == 'file_limit'){
		?>
			<h3 style="color: red">Файл должен быть не больше 75 КБ!</h3>
		<?
			}elseif($error == 'no_file'){
		?>
			<h3 style="color: red">Пожалуйста, загрузите файл!</h3>
		<?
			}elseif($error == 'occupied_login'){
		?>
			<h3 style="color: red">Этот логин уже занят!</h3>
		<?
			}else{
		?>
			<h2>Изменение профиля:</h2>
		<?
			}
		?>
	<form action="php/upload_ava.php" method="post" enctype="multipart/form-data">
		<a>Аватарка:</a>
		<br>
		<input type="file" name="file">
		<div align="center"><button type="submit">Изменить аватарку</button></div>
		<a class="small_a">Файл аватарки должен быть не больше 75 КБ.</a>
	</form>
	<a href="php/delete_ava.php">Убрать аватарку</a>
	<hr>
	<form action="php/edit_profile.php" method="post">
		<a>Имя:</a>
		<br>
		<input type="text" name="name" value="<?=$name?>" required>
		<hr>
		<a>Описание:</a>
		<br>
		<textarea name="desc" style="width: 280px; height: 80px"><?=$desc?></textarea>
		<br>
		<div align="center"><button type="submit">Изменить</button></div>
	</form>
</body>
</html>