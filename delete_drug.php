<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

include('db.php');

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "DELETE FROM drugs WHERE id = '$id'";
    
    if (mysqli_query($conn, $query)) {
        header('Location: view_drugs.php');
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
