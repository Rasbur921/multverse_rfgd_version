<?php
  include('db.php');

  $text = md5($_POST['text']);

	mysqli_query($conn, "INSERT INTO hesh (text) VALUES ('$text')");
	header("Location: ../hesh_breda.php");
?>