<?php
	include('php/db.php');
	session_start();
	$get_id = $_GET['id'];
	$error = $_GET['error'];
	$session_id = $_SESSION['id'];
	$result = mysqli_query($conn, "SELECT * FROM mults WHERE id = '$get_id'");
	$row = mysqli_fetch_assoc($result);
	
	$title = $row['title'];
	$desc = $row['desc'];
	$user_id = $row['user_id'];
	
	if($session_id != $user_id){
?>
	<script>window.close()</script>
<?php
	die();
	}
?>
<html>
<head>
	<title>Редактирование мульта | MultVerse</title>
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
			<h3 style="color: red">Поле с названием не должно быть пустым!</h3>
		<?
			}elseif($error == 'done_icon'){
		?>
			<h3 style="color: green">Иконка успешна измененна!</h3>
		<?
			}elseif($error == 'file_limit'){
		?>
			<h3 style="color: red">Иконка должена быть не больше 75 КБ!</h3>
		<?
			}elseif($error == 'no_file'){
		?>
			<h3 style="color: red">Пожалуйста, загрузите файл!</h3>
		<?
			}else{
		?>
			<h2>Изменение данных мульта:</h2>
		<?
			}
		?>
	<form action="php/change_mult_icon.php?id=<?=$get_id?>" method="post" enctype="multipart/form-data">
		<a>Иконка:</a>
		<br>
		<input type="file" name="file">
		<div align="center"><button type="submit">Изменить иконку</button></div>
		<a class="small_a">Файл иконки должен быть не больше 75 КБ.</a>
	</form>
	<hr>
	<form action="php/edit_mult.php?id=<?=$get_id?>" method="post">
		<a>Название:</a>
		<br>
		<input type="text" name="title" value="<?=$title?>" required>
		<hr>
		<a>Описание:</a>
		<br>
		<textarea name="desc" style="width: 280px; height: 80px"><?=$desc?></textarea>
		<br>
		<div align="center"><button type="submit">Изменить</button></div>
	</form>
</body>
</html>