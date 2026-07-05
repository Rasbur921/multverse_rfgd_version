<?php
	include('php/db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$session_login = $_SESSION['login'];
	$q = $_GET['q'];
?>
<html lang="RU">
	<head>
		<title>Поиск "<?=$q?>" | MultVerse</title>
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
						<?php
							$query_new = mysqli_query($conn, "SELECT * FROM `anims` WHERE `title` LIKE '%" . $q . "%' OR `desc` LIKE '%" . $q . "%' ORDER BY id DESC");
							$count = 0;
							while ($array_new = mysqli_fetch_assoc($query_new)) {
							$id_n = $array_new['id'];
							$title_n = htmlspecialchars($array_new['title']);
							$mult_id_n = $array_new['mult_id'];
							$user_id_n = $array_new['user_id'];
							
							$result_n = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id_n'");
							$row_n = mysqli_fetch_assoc($result_n);
							
							$name_n = htmlspecialchars($row_n['login']);
							
							$result = mysqli_query($conn, "SELECT * FROM mults WHERE id = '$mult_id_n'");
							$row = mysqli_fetch_assoc($result);
							
							$title_m = htmlspecialchars($row['title']);
							
							$rquery_mr = "SELECT AVG(value) AS avg_rate FROM `rate` WHERE `rate_id`= '{$id_n}' AND `type` = 'anim'";
							$rquery_result_mr = mysqli_query($conn, $rquery_mr);
							$rrow_mr = mysqli_fetch_assoc($rquery_result_mr);
							
							$rating = round($rrow_mr['avg_rate'], 1);
						?>
							<td style="width: 130px" valign="top">
								<a href="view.php?id=<?=$id_n?>"><img src="imgs/anim-icons/<?=$id_n?>.gif" width="130"></a>
								<br>
								<a href="view.php?id=<?=$id_n?>"><?=$title_n?></a>
								<br>
								<a class="small_a">Рейтинг: <a style="color:<?php
								if($rating < '2.4'){
									echo'red';
								}elseif($rating < '4.5' && $rating > '2.3'){
									echo'#EBCD00';
								}elseif($rating < '5.1' && $rating > '4.4'){
										echo'green';
								}?>" class="small_a"><?=$rating?></a></a>
								<?php
									if($mult_id_n !== '-1'){
								?>
									<br>
									<a class="small_a">Мульт: <a href="mult.php?id=<?=$mult_id_n?>" class="small_a"><?=$title_m?></a></a>
								<?php
									}
								?>
								<br>
								<a class="small_a">От: <a href="profile.php?id=<?=$user_id_n?>" class="small_a"><?=$name_n?></a></a>
								<br>
								<br>
							</td>
						<?php
							$count++;
							if($count % 5 == 0) echo "</tr><tr>";
							}
						?>
						</tr>
		</table><!--
		--><img src="imgs/content-bg-bottom.gif" width="760" height="10" border="0" style="display:block">
	</body>
</html>