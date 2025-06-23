<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include('db.php');

$success_message = '';
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize inputs
    $user_id = $_SESSION['user_id'];
    $doctor_nurse = mysqli_real_escape_string($conn, $_POST['doctor_nurse']);
    $appointment_date = mysqli_real_escape_string($conn, $_POST['appointment_date']);
    $appointment_time = mysqli_real_escape_string($conn, $_POST['appointment_time']);
    $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
    
    // Insert appointment into the database
    $sql = "INSERT INTO appointments (user_id, doctor_nurse, appointment_date, appointment_time, purpose, status)
            VALUES ('$user_id', '$doctor_nurse', '$appointment_date', '$appointment_time', '$purpose', 'Pending')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Appointment booked successfully!";
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Pharmacy</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="customer_dashboard.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="book_appointment.php">Book Appointment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="feedback.php">Give Feedback</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user_view_appointments.php">View Appointments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center">Book Appointment</h2>
        
        <?php if (!empty($success_message)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success_message; ?>
        </div>
        <?php elseif (!empty($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
        <?php endif; ?>

        <form action="book_appointment.php" method="POST">
            <div class="form-group">
                <label for="doctor_nurse">Select Doctor or Nurse</label>
                <select class="form-control" id="doctor_nurse" name="doctor_nurse" required>
                    <option value="">Select...</option>
                    <option value="Doctor">Doctor</option>
                    <option value="Nurse">Nurse</option>
                </select>
            </div>
            <div class="form-group">
                <label for="appointment_date">Appointment Date</label>
                <select class="form-control" id="appointment_date" name="appointment_date" required>
                    <?php
                    $today = new DateTime();
                    $dayOfWeek = $today->format('N');
                    $daysToMonday = ($dayOfWeek % 7) - 1; // Calculate days to previous Monday
                    $startDate = $today->modify('-' . $daysToMonday . ' days'); // Set to Monday of the current week
                    
                    for ($i = 0; $i < 6; $i++) {
                        $date = $startDate->format('Y-m-d');
                        $dayName = $startDate->format('l');
                        echo "<option value=\"$date\">$dayName, $date</option>";
                        $startDate->modify('+1 day'); // Move to the next day
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="appointment_time">Appointment Time</label>
                <select class="form-control" id="appointment_time" name="appointment_time" required>
                    <?php
                    $times = ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];
                    foreach ($times as $time) {
                        echo "<option value=\"$time\">$time</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="purpose">Purpose of Appointment</label>
                <textarea class="form-control" id="purpose" name="purpose" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Book Appointment</button>
        </form>
    </div>
</body>
</html>
