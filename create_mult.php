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
		<title>Создать мульт | MultVerse</title>
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
					<h2>Условия создания мульта:</h2>
                    Желательно, чтобы хотя бы 1 эпизод мульта был готов.<br>
                    <hr>
					Мульт должен быть оригинальным.<br>
					(Он должен быть сделан вами, а не другим автором.)<br>
					<hr>
					Обложка мульта не должна содержать откровенных сцен.<br>
				</td>
				<td>
				<td>
				<td width="450" valign="top">
					<?php
						if($error == 'fail'){
					?>
						<h2 style="color:red">Произошла ошибка во время создания!</h2>
					<?php
						}elseif($error == 'limit'){
					?>
						<h2 style="color:red">Обложка имеет вес больше 75 КБ!</h2>
					<?php
						}
					?>
					<form action="php/create_mult.php" method="post" style="width:300px" enctype="multipart/form-data">
						<a>Название:</a>
						<br>
						<input type="text" name="title" required style="width:280px">
						<hr>
						<a>Описание:</a>
                        <br>
						<a class="small_a">(Опционально)</a>
						<textarea style="width: 280px; height: 140px" name="desc"></textarea>
						<hr>
						<a>Обложка:</a>
						<br>
						<input type="file" name="file" required>
						<br>
                        <a class="small_a">Файл обложки должен быть не больше 75 КБ.</a>
                        <br>
                        <br>
						<button type="submit">Создать!</button>
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