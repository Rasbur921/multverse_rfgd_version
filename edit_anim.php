<?php
	include('php/db.php');
	session_start();
	$get_id = $_GET['id'];
	$error = $_GET['error'];
	$session_id = $_SESSION['id'];
	$result = mysqli_query($conn, "SELECT * FROM anims WHERE id = '$get_id'");
	$row = mysqli_fetch_assoc($result);
	
	$title = $row['title'];
	$desc = $row['desc'];
    $age = $row['age'];
	$width = $row['width'];
	$height = $row['height'];
	$user_id = $row['user_id'];
	$season = $row['season'];
	$mult_id = $row['mult_id'];
	
	if($session_id != $user_id){
?>
	<script>window.close()</script>
<?php
	die();
	}
?>
<html>
<head>
	<title>Редактирование анимации | MultVerse</title>
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
			<h2>Изменение данных анимации:</h2>
		<?
			}
		?>
	<form action="php/change_anim_icon.php?id=<?=$get_id?>" method="post" enctype="multipart/form-data">
		<a>Иконка:</a>
		<br>
		<input type="file" name="file">
		<div align="center"><button type="submit">Изменить иконку</button></div>
		<a class="small_a">Файл иконки должен быть не больше 75 КБ.</a>
	</form>
	<hr>
	<form action="php/edit_anim.php?id=<?=$get_id?>" method="post">
		<a>Название:</a>
		<br>
		<input type="text" name="title" value="<?=$title?>" required>
		<hr>
		<a>Описание:</a>
		<br>
		<textarea name="desc" style="width: 280px; height: 80px"><?=$desc?></textarea>
		<br>
		<hr>
		<a>Возрастной рейтинг:</a>
			<br>
				<select name="age" style="width:270px">
					<option value='0' <?php if($age == 0) echo'selected'; ?>>0+</option>
					<option value='16' <?php if($age == 16) echo'selected'; ?>>16+</option>
					<option value='18' <?php if($age == 18) echo'selected'; ?>>18+</option>
				</select>
		<hr>
		<a>Мульт:</a>
		<br>
		<select name="mult" style="width:270px">
		<option value="-1" <?php if($mult_id == '-1') echo'selected'; ?>><Самоделки></option>
		<?php
			$query_m = mysqli_query($conn, "SELECT * FROM `mults` WHERE user_id = '$session_id' ORDER BY id DESC");
			while ($array_m = mysqli_fetch_assoc($query_m)) {
			$id_m = $array_m['id'];
			$title_m = $array_m['title'];
		?>
							<option value="<?=$id_m?>" <?php if($mult_id == $id_m) echo'selected'; ?>><?=$title_m?></option>
		<?php
			}
		?>
		</select>
		<hr>
		<a>Сезон:</a>
		<br>
		<select name="season" style="width:270px">
			<?php
			for ($i = 1; $i <= 25; $i++) {
			?>
				<option value='<?=$i?>' <?php if($season == $i) echo'selected'; ?>><?=$i?> сезон</option>;
			<?php
			}
			?>
			<option value='-1' <?php if($season == '-1') echo'selected'; ?>>Доп. контент</option>
		</select>
		<div align="center"><button type="submit">Изменить</button></div>
	</form>
</body>
</html>