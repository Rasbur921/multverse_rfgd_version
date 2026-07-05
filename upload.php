<?php
	include('php/db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$session_login = $_SESSION['login'];
	
	$error = $_GET['error'];	
	
	if(empty($session_id)){
		header("Location: index.php");
		die();
	}
?>
<html lang="RU">
	<head>
		<title>Загрузить анимацию | MultVerse</title>
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="icon" href="imgs/favicon.png" type="image/x-icon"/>
	</head>
	<body link="0072C9" vlink="#0079D7" alink="#0083E8">
		<?
			include('includes/header.php');
		?>
		<br>
		<center>
			<img src="imgs/content-bg-top.gif" width="760" height="10" border="0" style="display:block"><!--
		--><table width="760" border="0" align="center" cellpadding="3" cellspacing="3" background="imgs/content-bg.gif" style="display:block">
			<tr>
				<td width="310" valign="top">
					<h2>Условия загрузки анимации:</h2>
					Анимация должна быть оригинальная.<br>
					(Она должна быть сделана вами, а не другим автором.)<br>
                    <hr>
					Не зависимо от возрастного рейтинга - обложка всегда должна быть без откровенных сцен.<br>
					<hr>
					Если 0+: Анимация не должна содержать сцен насилия.<br>
                    Если 16+: Разрешается сдерженное насилие. (Не злоупотреблять)<br>
					<hr>
                    Если 0+: Запрещается нецензурная лексика.<br>
					Если 16+: Не злоупотребляйте нецензурной лексикой.<br>
					<hr>
                    Запрещается выкладывать сконвертированные видеоформаты. Только Флеш анимация.<br>
                    <hr>
					Старайтесь делать больше развлекательный контент:-)
				</td>
				<td>
				<td>
				<td width="450" valign="top">
					<?php
						if($error == 'fail'){
					?>
						<h2 style="color:red">Произошла ошибка во время загрузки!</h2>
					<?php
						}elseif($error == 'limit'){
					?>
						<h2 style="color:red">Обложка имеет вес больше 75 КБ!</h2>
					<?php
						}
					?>
					<form action="php/upload.php" method="post" style="width:300px" enctype="multipart/form-data">
						<a>Название:</a>
						<br>
						<input type="text" name="title" required style="width:280px">
						<hr>
						<a>Описание:</a>
                        <br>
						<a class="small_a">(Опционально)</a>
						<textarea style="width: 280px; height: 140px" name="desc"></textarea>
						<hr>
						<a>Возрастной рейтинг:</a>
						<br>
						<select name="age" style="width:270px">
							<option value='0'>0+</option>
							<option value='16'>16+</option>
							<option value='18'>18+</option>
						</select>
						<hr>
						<a>Мульт:</a>
						<br>
						<select name="mult" style="width:270px">
							<option value="-1"><Самоделки></option>
						<?php
							$query_m = mysqli_query($conn, "SELECT * FROM `mults` WHERE user_id = '$session_id' ORDER BY id DESC");
							while ($array_m = mysqli_fetch_assoc($query_m)) {
							$id_m = $array_m['id'];
							$title_m = $array_m['title'];
						?>
							<option value="<?=$id_m?>"><?=$title_m?></option>
						<?php
							}
						?>
						</select>
						<br>
						<br>
						<a class="small_a">Здесь вы можете выбрать свой мульт, эпизодом которого анимация будет. Либо если вы не хотите выкладывать как эпизод мульта, а просто как короткую анимацию, то выкладываете её как самоделку.</a>
						<hr>
						<a>Сезон:</a>
						<br>
						<select name="season" style="width:270px">
							<?php
							for ($i = 1; $i <= 25; $i++) {
								echo "<option value='$i'>{$i} сезон</option>";
							}
							?>
                            <option value='-1'>Доп. контент</option>
						</select>
                        <br>
                        <a class="small_a">Если это дополнительный контент к мульту, то откройте список, долистайте до конца и выберете "Доп. контент"</a>
						<hr>
						<a>Разрешение:</a>
						<br>
						<a class="small_a">Ширина</a>
						<input type="text" name="width" required>
						<br>
						<a class="small_a">Высота</a>
						<input type="text" name="height" required>
						<hr>
						<a>SWF файл:</a>
						<br>
						<input type="file" name="swf" required>
						<hr>
						<a>Обложка:</a>
						<br>
						<input type="file" name="icon" required>
						<br>
                        <a class="small_a">Файл обложки должен быть не больше 75 КБ.</a>
                        <br>
                        <br>
						<button type="submit">Загрузить!</button>
					</form>
				</td>
			</tr>
		</table><!--
		--><img src="imgs/content-bg-bottom.gif" width="760" height="10" border="0" style="display:block">
		<?
			include('includes/footer.php');
		?>
	</body>
</html>