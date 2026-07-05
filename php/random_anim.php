<?php
    include('db.php');
    
    $result = mysqli_query($conn, "SELECT id FROM anims ORDER BY RAND() LIMIT 1");
    $row = mysqli_fetch_assoc($result);

    $random_id = $row['id'];

    header("Location: ../view.php?id=" . $random_id);
?>