<?php
	include('db.php');
	session_start();
	
	$login = $_POST['login'];
	$password = md5($_POST['password']);
	
	if(empty($login) || empty($password)){
		header("Location: index.php");
		die();
	}
	
	$stmt = $conn->prepare("SELECT id, login FROM users WHERE login = ? AND password = ?");
	$stmt->bind_param("ss", $login, $password);
	$stmt->execute();
	
	$stmt->store_result(); // сохраняем результат
	if ($stmt->num_rows > 0) {
		$stmt->bind_result($id, $login_db);
		$stmt->fetch();
		
		$_SESSION['login'] = $login_db;
		$_SESSION['id'] = $id;
		
		header("Location: ../profile.php?id=" . $id);
		echo 'Успешный вход!
		<br>
		<a href="../index.php">Вернуться на главную страницу</a>';
		
	} else {
		header("Location: ../index.php?msng=fail_login");
	}
?>