<?php
    include('php/db.php');

	$result_h = mysqli_query($conn, "SELECT * FROM users WHERE id = '$session_id'");
	$row_h = mysqli_fetch_assoc($result_h);
	$ava_h = $row_h['avatar'];
	$id_h = $row_h['id'];

	if($session_id != $id_h){
        session_start();
        session_unset();
        session_destroy();
        header('Location: ../index.php');
        die();
    }

    $result_hn = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM notifications WHERE send_user_id = '$session_id' AND `read` = 0");
    $row_hn = mysqli_fetch_assoc($result_hn);

    $has_read = $row_hn['cnt'] > 0;

								$query_notif = "SELECT COUNT(*) AS count FROM `notifications` WHERE `send_user_id`= '$session_id' AND `read` = 0";
								$query_results_notif = mysqli_query($conn, $query_notif);
								while($rows_notif = mysqli_fetch_assoc($query_results_notif)) {
								$outputs_notif = $rows_notif['count'];
                                }
?>
		<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<a href="index.php"><img src="imgs/logo.gif" width=218 height=96 alt="MultVerse"></a>
				</td>
					
				<td style="nav" width="454" height="103">
					<a href="selfmades.php"><img src="imgs/nav/samodelki<?php if($nav_sel == 'sam'){echo '_sel';} ?>.gif" width=165 height=49 alt="Самоделки"></a><!--
					--><a href="mults.php"><img src="imgs/nav/mults<?php if($nav_sel == 'mult'){echo '_sel';} ?>.gif" width=150 height=49 alt="Мульты"></a><!--
					--><a href="episodes.php"><img src="imgs/nav/episodes<?php if($nav_sel == 'ep'){echo '_sel';} ?>.gif" width=139 height=49 alt="Эпизоды"></a><!--
					--><table width="454" height="54" background="imgs/nav/bottom-bg.gif">
						<tr>
							<td>
								<form action="php/search.php" method="post" style="margin-top:4px;">
                                    &nbsp
									<a style="color: white">Поиск: </a>
									<input type="text" name="search" required>
									&nbsp
									<button type="submit">Искать</button>
								</form>
							</td>
							<td>
							<?
								if($session_id){
							?>
								<a href="upload.php"><img src="imgs/nav/upload.gif" width="23" height="23" title="Загрузить анимацию"></a>
								<a href="notifications.php"><img src="imgs/nav/notifications<?php if($has_read){echo '_full';} ?>.gif" width="23" height="23" title="Уведомления (<?=$outputs_notif?>)"></a>
								<a href="profile.php?id=<?=$session_id?>"><img src="imgs/avatars/<?=$ava_h?>.gif" height="23" title="Профиль"></a>
							<?
								}
							?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
<center>
		<table width="760" align="center">
            <tr>
                <br>
                                <script>
                                        window.RufflePlayer = window.RufflePlayer || {};
                                        window.RufflePlayer.config = {
                                            "warnOnUnsupportedContent": false, 
                                            "autoplay": "on", 
                                            "unmuteOverlay": "hidden"
                                        };
                                </script>
                                <script src="https://unpkg.com/@ruffle-rs/ruffle"></script>
                <object data="swf/navs/nav2.swf" width="760" height="50"></object> 
            </tr>
        </table>
</center>