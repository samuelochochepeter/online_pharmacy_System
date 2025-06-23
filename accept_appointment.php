<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_id = mysqli_real_escape_string($conn, $_POST['appointment_id']);
    $appointment_date = mysqli_real_escape_string($conn, $_POST['appointment_date']);
    $appointment_time = mysqli_real_escape_string($conn, $_POST['appointment_time']);

    $query = "UPDATE appointments 
              SET status = 'Accepted', 
                  appointment_date = '$appointment_date', 
                  appointment_time = '$appointment_time' 
              WHERE id = '$appointment_id'";

    if (mysqli_query($conn, $query)) {
        header('Location: admin_dashboard.php');
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>
