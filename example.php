<?php
	include('php/db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$session_login = $_SESSION['login'];
	$get_id = $_GET['id'];
	
	$result = mysqli_query($conn, "SELECT * FROM mults WHERE id = '$get_id'");
	$row = mysqli_fetch_assoc($result);
	
	$title = $row['title'];
	$desc = $row['desc'];
	$date = $row['date'];
?>
<html lang="RU">
	<head>
		<title>Мульт "<?=$title?>" | MultVerse</title>
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
				<td width="200" valign="top">

				</td>
				<td>
				<td>
				<td width="560" valign="top">

				</td>
			</tr>
		</table><!--
		--><img src="imgs/content-bg-bottom.gif" width="760" height="10" border="0" style="display:block">
		<?
			include('includes/footer.php');
		?>
	</body>
</html>