<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

include('db.php');

// Fetch appointments
$query = "SELECT * FROM appointments";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="admin_dashboard.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center">Appointments</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Doctor/Nurse</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
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
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <?php if ($row['status'] == 'Pending'): ?>
                        <form action="accept_appointment.php" method="POST">
                            <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <input type="hidden" name="action" value="accept">
                            <div class="form-group">
                                <label for="appointment_date">Appointment Date</label>
                                <input type="date" class="form-control" id="appointment_date" name="appointment_date" value="<?php echo htmlspecialchars($row['appointment_date']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="appointment_time">Appointment Time</label>
                                <select class="form-control" id="appointment_time" name="appointment_time" required>
                                    <option value="08:00" <?php if ($row['appointment_time'] == '08:00') echo 'selected'; ?>>08:00 AM</option>
                                    <option value="09:00" <?php if ($row['appointment_time'] == '09:00') echo 'selected'; ?>>09:00 AM</option>
                                    <option value="10:00" <?php if ($row['appointment_time'] == '10:00') echo 'selected'; ?>>10:00 AM</option>
                                    <option value="11:00" <?php if ($row['appointment_time'] == '11:00') echo 'selected'; ?>>11:00 AM</option>
                                    <option value="12:00" <?php if ($row['appointment_time'] == '12:00') echo 'selected'; ?>>12:00 PM</option>
                                    <option value="13:00" <?php if ($row['appointment_time'] == '13:00') echo 'selected'; ?>>01:00 PM</option>
                                    <option value="14:00" <?php if ($row['appointment_time'] == '14:00') echo 'selected'; ?>>02:00 PM</option>
                                    <option value="15:00" <?php if ($row['appointment_time'] == '15:00') echo 'selected'; ?>>03:00 PM</option>
                                    <option value="16:00" <?php if ($row['appointment_time'] == '16:00') echo 'selected'; ?>>04:00 PM</option>
                                    <option value="17:00" <?php if ($row['appointment_time'] == '17:00') echo 'selected'; ?>>05:00 PM</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Accept Appointment</button>
                        </form>
                        <?php else: ?>
                        <span class="text-muted">No action required</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
