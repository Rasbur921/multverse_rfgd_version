<?php
include('db.php');
session_start();
$session_id = $_SESSION['id'];

if (isset($_FILES['file'])) {
    $max_size = 75 * 1024; // 75 KB в байтах
    $file = $_FILES['file'];
    
    // Проверка размера файла
    if ($file['size'] > $max_size) {
        header("Location: ../edit_profile.php?error=file_limit");
		die();
    }
    
    // Проверка на ошибки загрузки
    if ($file['error'] !== UPLOAD_ERR_OK) {
        header("Location: ../edit_profile.php?error=no_file");
    }
    
    // Перемещение файла в целевую директорию
    $upload_dir = '../imgs/avatars/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $file_path = $upload_dir . $session_id . '.gif';
    
    if (move_uploaded_file($file['tmp_name'], $file_path)) {
		mysqli_query($conn, "UPDATE `users` SET `avatar` = '$session_id' WHERE `id` = '$session_id'");
        header("Location: ../edit_profile.php?error=done_ava");
    } else {
        echo "Ошибка при сохранении файла";
    }
}else{
	header("Location: ../edit_profile.php?error=no_file");
}
?>