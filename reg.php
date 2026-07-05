<?php
	$error = $_GET['error'];
?>
<html>
<head>
	<title>Регистрация | MultVerse</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<link href="style.css" rel="stylesheet" type="text/css">
	<link rel="icon" href="imgs/icon.png" type="image/x-icon"/>
</head>
<body style="background-image: url('imgs/login-bg.gif')">
	<center>
		<?
			if($error == 'not_verif'){
		?>
			<h3 style="color: red">Повторный пароль не соответсвует основному паролю!</h3>
		<?
			}elseif($error == 'empty'){
		?>
			<h3 style="color: red">Все поля должны быть заполненны!</h3>
		<?
			}elseif($error == 'fail_captcha'){
		?>
			<h3 style="color: red">Код написан неверно!</h3>
		<?
			}elseif($error == 'occupied_login'){
		?>
			<h3 style="color: red">Этот логин уже занят!</h3>
		<?
			}else{
		?>
			<h2>Регистрация на MultVerse:</h2>
		<?
			}
		?>
		
	<form action="php/reg.php" method="post">
        <input type="text" name="chudozashitaotloshkov" style="display:none">
		<a>Логин (Имя пользователя):</a>
		<br>
		<input type="text" name="login" required>
		<hr>
		<a>Пароль:</a>
		<br>
		<input type="password" name="password" required>
		<hr>
		<a>Повторите пароль:</a>
		<br>
		<input type="password" name="verif_password" required>
		<hr>
		<a>Код:</a>
		<br>
		<img src="captcha.php" alt="captcha"><br>
		<input type="text" name="captcha">
		<br>
		<div align="center"><button type="submit" onclick="return confirm('Вы уверены?')">Зарегистрироваться</button></div>
	</form>
</body>
</html>