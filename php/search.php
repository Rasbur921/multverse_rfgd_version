<?php
	$q = $_POST['search'];
	
	header("Location: ../search.php?q=" . $q);
?>