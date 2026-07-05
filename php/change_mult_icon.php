<?php
include('db.php');
$get_id = $_GET['id'];

if (isset($_FILES['file'])) {
    $max_size = 75 * 1024; // 75 KB в байтах
    $file = $_FILES['file'];
    
    // Проверка размера файла
    if ($file['size'] > $max_size) {
        header("Location: ../edit_mult.php?error=file_limit");
		die();
    }
    
    // Проверка на ошибки загрузки
    if ($file['error'] !== UPLOAD_ERR_OK) {
        header("Location: ../edit_mult.php?error=no_file");
    }
    
    // Перемещение файла в целевую директорию
    $upload_dir = '../imgs/mult-icons/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $file_path = $upload_dir . $get_id . '.gif';
    
    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        header("Location: ../edit_mult.php?id=" . $get_id . "&error=done_icon");
    } else {
        echo "Ошибка при сохранении файла";
    }
}else{
	header("Location: ../edit_mult.php?id=" . $get_id . "&error=no_file");
}
?>