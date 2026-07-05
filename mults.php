<?php
	include('php/db.php');
	session_start();
	$session_id = $_SESSION['id'];
	$session_login = $_SESSION['login'];
	
	$get_c = $_GET['c'];
?>
<html lang="RU">
	<head>
		<title>Мульты | MultVerse</title>
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="icon" href="imgs/favicon.png" type="image/x-icon"/>
	</head>
	<body link="0072C9" vlink="#0079D7" alink="#0083E8">
		<?
        	$nav_sel = 'mult';
			include('includes/header.php');
		?>
		<br>
		<center>
			<img src="imgs/content-bg-top.gif" width="760" height="10" border="0" style="display:block"><!--
		--><table width="760" border="0" align="center" cellpadding="3" cellspacing="3" background="imgs/content-bg.gif" style="display:block">
						<tr>
							<td>
								<select onchange="gotoPage(this.value)">
									<option value="0">-Выберете категорию-</option>
									<option value="mults.php?c=news">Новинки</option>
									<option value="mults.php?c=best">Лучшее</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>
                                <?php
                                	if(!empty($session_id)){
                                ?>
									<a href="create_mult.php"><img src="imgs/create_mult.gif" width="170" height="47" alt="Создать мульт"></a>
                                <?php
                                    }
                                ?>
							</td>
						</tr>
						<tr>
						<?php
							if($get_c == 'news' OR empty($get_c)){
								$query_new = mysqli_query($conn, "SELECT * FROM `mults` ORDER BY id DESC");
							}
							
							if($get_c == 'best'){
								$query_new = mysqli_query($conn, "
									SELECT a.*, AVG(r.value) AS avg_rating
									FROM mults a
									LEFT JOIN rate r ON a.id = r.rate_id AND r.type = 'mult'
									GROUP BY a.id
									ORDER BY avg_rating DESC						
								");
							}
                            
							if($get_c == 'most_episodes'){
								$query_new = mysqli_query($conn, "
									SELECT a.*, AVG(r.value) AS avg_episodes
									FROM mults a
									LEFT JOIN anims r ON a.id = r.mult_id
									GROUP BY a.id
									ORDER BY avg_episodes DESC						
								");
							}
							$count = 0;
							while ($array_new = mysqli_fetch_assoc($query_new)) {
							$id_n = $array_new['id'];
							$title_n = htmlspecialchars($array_new['title']);
							$user_id_n = $array_new['user_id'];
							
							$result_n = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id_n'");
							$row_n = mysqli_fetch_assoc($result_n);
							
							$name_n = htmlspecialchars($row_n['login']);
							
							$rquery_mr = "SELECT AVG(value) AS avg_rate FROM `rate` WHERE `rate_id`= '{$id_n}' AND `type` = 'mult'";
							$rquery_result_mr = mysqli_query($conn, $rquery_mr);
							$rrow_mr = mysqli_fetch_assoc($rquery_result_mr);
							
							$rating = round($rrow_mr['avg_rate'], 1);
                                
								$query_сs = "SELECT COUNT(*) AS count FROM `anims` WHERE `mult_id`= '$id_n'";
								$query_results = mysqli_query($conn, $query_сs);
								while($rows = mysqli_fetch_assoc($query_results)) {
								$outputs = $rows['count'];
                                }
						?>
							<td style="width: 130px" valign="top">
								<a href="mult.php?id=<?=$id_n?>"><img src="imgs/mult-icons/<?=$id_n?>.gif" width="150"></a>
								<br>
								<a href="mult.php?id=<?=$id_n?>"><?=$title_n?></a>
								<br>
								<a class="small_a">Рейтинг: <a style="color:<?php
								if($rating < '2.4'){
									echo'red';
								}elseif($rating < '4.5' && $rating > '2.3'){
									echo'#EBCD00';
								}elseif($rating < '5.1' && $rating > '4.4'){
										echo'green';
								}?>" class="small_a"><?=$rating?></a></a>
								<br>
								<a class="small_a">Эпизодов: <?=$outputs?></a>
								<br>
								<a class="small_a">От: <a href="profile.php?id=<?=$user_id_n?>" class="small_a"><?=$name_n?></a></a>
								<br>
								<br>
							</td>
						<?php
							$count++;
							if($count % 4 == 0) echo "</tr><tr>";
							}
						?>
						</tr>
		</table><!--
		--><img src="imgs/content-bg-bottom.gif" width="760" height="10" border="0" style="display:block">
		<?
			include('includes/footer.php');
		?>
		<script>
		function gotoPage(url) {
		  if (url != "0") {
			window.location.href = url;
		  }
		}
		</script>
	</body>
</html>