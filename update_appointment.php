<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_id = mysqli_real_escape_string($conn, $_POST['appointment_id']);
    $action = mysqli_real_escape_string($conn, $_POST['action']);
    $appointment_date = mysqli_real_escape_string($conn, $_POST['appointment_date']);
    $appointment_time = mysqli_real_escape_string($conn, $_POST['appointment_time']);
    $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
    
    if ($action === 'accept') {
        $status = 'Accepted';
        $query = "UPDATE appointments 
                  SET status = '$status', appointment_date = '$appointment_date', appointment_time = '$appointment_time', purpose = '$purpose' 
                  WHERE id = '$appointment_id'";
    } elseif ($action === 'cancel') {
        $status = 'Cancelled';
        $query = "UPDATE appointments 
                  SET status = '$status' 
                  WHERE id = '$appointment_id'";
    } else {
        header('Location: admin_dashboard.php');
        exit;
    }
    
    if (mysqli_query($conn, $query)) {
        header('Location: admin_dashboard.php');
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>
