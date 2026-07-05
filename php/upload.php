<?php
include('db.php');
session_start();
$session_id = $_SESSION['id'];

if(empty($session_id)){
    die();
}

if (isset($_FILES['swf']) || isset($_FILES['icon'])) {

    $swf = $_FILES['swf'];
    $icon = $_FILES['icon'];
	
	$title = $_POST['title'];
	$desc = $_POST['desc'];
    $age = $_POST['age'];
	$mult = $_POST['mult'];
	$season = $_POST['season'];
	$date = date('d.m.Y H:i');
	$width = $_POST['width'];
	$height = $_POST['height'];
    
	$width = (float)$width;
	$height = (float)$height;
	
	if ($width !== 420) {
		$ratio = 420 / $width;
		$width = 420;
		$height = round($height * $ratio);
	}
	
    if ($swf['error'] !== UPLOAD_ERR_OK) {
        header("Location: ../upload.php?error=fail");
        die();
    }
	
    if ($icon['error'] !== UPLOAD_ERR_OK) {
        header("Location: ../upload.php?error=fail");
        die();
    }
    
	$max_size = 75 * 1024; // 75 KB
	
    if ($icon['size'] > $max_size) {
        header("Location: ../upload.php?error=limit");
		die();
    }

	$result = mysqli_query($conn, "INSERT INTO anims (`title`, `desc`, `age`, `date`, `mult_id`, `user_id`, `width`, `height`, `season`) 
	VALUES ('$title', '$desc', '$age', '$date', '$mult', '$session_id', '$width', '$height', '$season')");
	
	if (!$result) {
		die('?????? ???????: ' . mysqli_error($conn));
	}
	$future_id = $conn->insert_id;
    
 	$result_s = mysqli_query($conn, "SELECT * FROM subs WHERE mult_id = '$mult'");
	while ($row_s = mysqli_fetch_assoc($result_s)) {
		$sub_user_id = $row_s['user_id'];
		$mult = $_POST['mult'];

		mysqli_query($conn, "
			INSERT INTO notifications (text, user_id, send_user_id, view_id, link, comm, `read`)
			VALUES ('выпустил новую серию в мульте', '$session_id', '$sub_user_id', '$future_id', 'view', '0', '0')
		");
	}
    
    // ??????????? ????? ? ??????? ??????????
    $upload_dir = '../swf/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
 
    $file_path = $upload_dir . $future_id . '.swf';
	move_uploaded_file($swf['tmp_name'], $file_path);
	
    // ??????????? ????? ? ??????? ??????????
    $upload_dir_icon = '../imgs/anim-icons/';
    if (!is_dir($upload_dir_icon)) {
        mkdir($upload_dir_icon, 0755, true);
    }
    
    $file_path_icon = $upload_dir_icon . $future_id . '.gif';
    
    if (move_uploaded_file($icon['tmp_name'], $file_path_icon)) {
        header("Location: ../view.php?id=" . $future_id);
    } else {
        header("Location: ../upload.php?error=fail");
    }
}else{
	header("Location: ../upload.php?error=fail");
}
?>