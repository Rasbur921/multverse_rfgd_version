<?php
  session_start();
  $code = $_POST['pass'];  

	if($code != 'ВАШ ПАРОЛЬ'){
        header("Location: ../index.php");
        die();
    }else{
        $_SESSION['admin_password'] = $code;
        header("Location: ../index.php");
    }
?>