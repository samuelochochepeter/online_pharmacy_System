<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

include('db.php');

// Fetch pending appointments
$query = "SELECT * FROM appointments WHERE status = 'Pending' ORDER BY appointment_date";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #e6f7ff; /* Light blue background color */
        }
        .container {
            margin-top: 50px;
            background-color: #ffffff; /* White background for content */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
        h2, h3 {
            color: #007bff; /* Blue color for headings */
        }
        .btn-success, .btn-danger, .btn-logout {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Admin Dashboard</h2>
        <div class="list-group mb-4">
            <a href="upload_drugs.php" class="list-group-item list-group-item-action">Upload Drugs</a>
            <a href="view_drugs.php" class="list-group-item list-group-item-action">View Drugs</a>
            <a href="manage_users.php" class="list-group-item list-group-item-action">Manage Users</a>
        </div>

        <h3>Manage Appointments</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Doctor/Nurse</th>
                    <th>Appointment Date</th>
                    <th>Appointment Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['doctor_nurse']); ?></td>
                    <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['appointment_time']); ?></td>
                    <td>
                        <form method="POST" action="update_appointment.php" class="d-inline">
                            <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <input type="hidden" name="action" value="accept">
                            <input type="date" name="appointment_date" value="<?php echo htmlspecialchars($row['appointment_date']); ?>" required>
                            <input type="time" name="appointment_time" value="<?php echo htmlspecialchars($row['appointment_time']); ?>" required>
                            <button type="submit" class="btn btn-success">Accept</button>
                        </form>
                        <form method="POST" action="update_appointment.php" class="d-inline">
                            <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <input type="hidden" name="action" value="cancel">
                            <button type="submit" class="btn btn-danger">Cancel</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="text-center">
            <form method="POST" action="logout.php">
                <button type="submit" class="btn btn-danger btn-logout">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>
