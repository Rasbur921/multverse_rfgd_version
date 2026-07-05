<?php
	include('php/db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$session_login = $_SESSION['login'];
	$msng = $_GET['msng'];
	
	if($msng == 'account_deleted'){
?>
	<script>alert('Аккаунт успешно удалён!')</script>
<?php
	}elseif($msng == 'no_user'){
?>
	<script>alert('Пользователь не найден!')</script>
<?php
	}elseif($msng == 'no_anim'){
?>
	<script>alert('Анимация не найдена!')</script>
<?php
	}elseif($msng == 'no_mult'){
?>
	<script>alert('Мульт не найден!')</script>
<?php
	}elseif($msng == 'anim_deleted'){
?>
	<script>alert('Анимация успешна удалена!')</script>
<?php
	}elseif($msng == 'mult_deleted'){
?>
	<script>alert('Мульт успешно удалён!')</script>
<?php
	}elseif($msng == 'fail_login'){
?>
	<script>alert('Неверный логин или пароль!')</script>
<?php
	}
?>
<html lang="RU">
	<head>
		<title>MultVerse - Вселенная мультов</title>
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
				<h2 style="color: red">Лучшее:</h2>
				<table>
						<?php
							$query_bet = mysqli_query($conn, "
								SELECT a.*, AVG(r.value) AS avg_rating
								FROM anims a
								LEFT JOIN rate r ON a.id = r.rate_id AND r.type = 'anim'
								GROUP BY a.id
								ORDER BY avg_rating DESC LIMIT 5							
							");
							while ($array_bet = mysqli_fetch_assoc($query_bet)) {
							$id_b = $array_bet['id'];
							$title_b = htmlspecialchars($array_bet['title']);
                            $age_b = $array_bet['age'];
							$mult_id_b = $array_bet['mult_id'];
							$user_id_b = $array_bet['user_id'];
							
							$result_b = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id_b'");
							$row_b = mysqli_fetch_assoc($result_b);
							
							$name_b = htmlspecialchars($row_b['login']);
							
							$result_bet = mysqli_query($conn, "SELECT * FROM mults WHERE id = '$mult_id_b'");
							$row_bet = mysqli_fetch_assoc($result_bet);
							
							$title_mb = htmlspecialchars($row_bet['title']);
							
							$rquery_br = "SELECT AVG(value) AS avg_rate FROM `rate` WHERE `rate_id`= '{$id_b}' AND `type` = 'anim'";
							$rquery_result_br = mysqli_query($conn, $rquery_br);
							$rrow_br = mysqli_fetch_assoc($rquery_result_br);
							
							$rating_bet = round($rrow_br['avg_rate'], 1);
						?>
					<tr>
						<td>
						<a href="view.php?id=<?=$id_b?>"><img src="imgs/anim-icons/<?=$id_b?>.gif" width="200"></a>
						<br>
                                <table>
                                    <tr>
                                        <td><img src="imgs/rating/<?=$age_b?>+.gif" width=35 height=35></td>
                                        <td><a href="view.php?id=<?=$id_b?>"><h3><?=$title_b?></h3></a></td>
                                    </tr>
                                </table> 
								<a>Рейтинг: <a style="color:<?php
								if($rating_bet < '2.4'){
									echo'red';
								}elseif($rating_bet < '4.5' && $rating_bet > '2.3'){
									echo'#EBCD00';
								}elseif($rating_bet < '5.1' && $rating_bet > '4.4'){
										echo'green';
								}?>"><?=$rating_bet?></a></a>
						<br>
						<?php
							if($mult_id_b != '-1'){
						?>
							Мульт: <a href="mult.php?id=<?=$mult_id_b?>"><?=$title_mb?></a>
							<br>
						<?php
							}
						?>
						От: <a href="profile.php?id=<?=$user_id_b?>"><?=$name_b?></a>
						<td>
					</tr>
                    <tr>
                        <td>
                        	<hr>
                        </td>
                    </tr>
				<?php
					}
				?>
				</table>
				<br>
				</td>
				<td>
				<td>
				<td width="560" valign="top">
					<h3>Навигация по сайту:</h3>
					<a>Самоделки - Небольшие анимации, которые не зависят ни от какого мульта.
					<br><hr>Мульты - Сериалы с эпизодами и сезонами.
					<br><hr>Эпизоды - Серии из разных мультов.</a>
					<br>
					<?
						if(empty($session_id)){
					?>
					<br>
					<form class="blue_panel" style="width: 250px;" action="php/login.php" method="post">
						<h4 align="center">Войти в аккаунт:</h4>
						<table cellpadding="3" cellspacing="3">
							<tr>
								<td>
									<a>Логин:</a>
								</td>
								<td>
									<input type="text" name="login" required>
								</td>
							</tr>
							<tr>
								<td>
									<a>Пароль:</a>
								</td>
								<td>
									<input type="password" name="password" required>
								</td>
							</tr>
						</table>
						<div align="center"><button type="submit">Войти</button></div>
						<div align="center">Нет аккаунта? <a href="#" onclick="window.open('reg.php','reg_popup','width=300,height=520,menubar=no,status=no,scrollbars=no'); return false;">Зарегистрируйся!</a></div>
					</form>
					<?
						}
					?>
					<h2 style="color: #EBCD00">Новинки:</h2>
					<table>
						<?php
							$query_new = mysqli_query($conn, "SELECT * FROM `anims` ORDER BY id DESC LIMIT 8");
							while ($array_new = mysqli_fetch_assoc($query_new)) {
							$id_n = $array_new['id'];
							$title_n = htmlspecialchars($array_new['title']);
                            $age_n = $array_new['age'];
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
						<tr>
							<td valign="top">
								<a href="view.php?id=<?=$id_n?>"><img src="imgs/anim-icons/<?=$id_n?>.gif" width="130"></a>
							</td>
							<td style="width:340px" valign="top">
                                <table>
                                    <tr>
                                        <td valign="top"><img src="imgs/rating/<?=$age_n?>+.gif" width=23 height=23></td>
                                        <td><a href="view.php?id=<?=$id_n?>"><?=$title_n?></a></td>
                                    </tr>
                                </table>  
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
							</td>
						</tr>
                        <tr>
                            <td>
                                
                            </td>
                            <td>
                                <hr>
                    		</td>
                        </tr>
						<?php
							}
						?>
					</table>
				</td>
			</tr>
		</table><!--
		--><img src="imgs/content-bg-bottom.gif" width="760" height="10" border="0" style="display:block">
		<?
			include('includes/footer.php');
		?>
	</body>
</html>