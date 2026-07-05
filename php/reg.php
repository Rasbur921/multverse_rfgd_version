<?php
	include('db.php');
	session_start();

    $ip = $_SERVER['REMOTE_ADDR'];
    $time = time();

    // создаём папку для логов (если её нет)
    if (!is_dir('anti_ddos')) {
        mkdir('anti_ddos', 0755, true);
    }

    $file = "anti_ddos/" . md5($ip) . ".txt";

    // если файл уже есть — проверяем интервал между запросами
    if (file_exists($file)) {
        $last_time = file_get_contents($file);
        if ($time - $last_time < 5) { // меньше 5 секунд с последней попытки
            die('Слишком частые запросы, подожди немного.');
        }
    }

    // обновляем время последней попытки
    file_put_contents($file, $time);
	
	$login = $_POST['login'];
	$password = md5($_POST['password']);
	$verif_password = md5($_POST['verif_password']);
	$date = date('d.m.Y H:i');
	
	$post_code = $_POST['captcha'];
	$session_code = $_SESSION['captcha'];

	if(!empty($_POST['chudozashitaotloshkov'])){
	  die('Bot detected');
	}

	if ($post_code != $session_code) {
		header("Location: ../reg.php?error=fail_captcha");
		die();
	}

	if($verif_password != $password){
		header("Location: ../reg.php?error=not_verif");
		die();
	}
	
	if(empty($login) || empty($password) || empty($verif_password)){
		header("Location: ../reg.php?error=empty");
		die();
	}
	
	$result = mysqli_query($conn, "SELECT id FROM users WHERE login = '$login'");

	if (mysqli_num_rows($result) > 0) {
		header("Location: ../reg.php?error=occupied_login");
		exit();
	}

	mysqli_query($conn, "INSERT INTO users (login, password, date, avatar, ip) VALUES ('$login', '$password', '$date', 'default', '$ip')");
	header("Location: ../reg_finish.php");
?>