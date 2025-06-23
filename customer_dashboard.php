<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: user_login.php');
    exit;
}

include('db.php');

// Fetch drugs
$query = "SELECT * FROM drugs";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background for the entire page */
        }
        .navbar {
            background-color: greenyellow; /* Dark background for the navbar */
        }
        .navbar-brand, .nav-link {
            color: #ffffff; /* White text color for navbar items */
        }
        .navbar-nav .nav-link:hover {
            color: #d1d1d1; /* Lighter gray for hover effect */
        }
        .card {
            background-color: #ffffff; /* White background for card */
            border: 1px solid #dee2e6; /* Light gray border for card */
        }
        .card-body {
            background-color: #e9ecef; /* Light gray background for card body */
        }
        .card-img-top {
            height: 200px; /* Set a fixed height for images */
            object-fit: cover; /* Ensure images cover the space without distortion */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Pharmacy</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="book_appointment.php">Book Appointment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="feedback.php">Give Feedback</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center">Available Drugs</h2>
        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <?php if (!empty($row['image'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>">
                    <?php else: ?>
                    <img src="uploads/default.jpg" class="card-img-top" alt="Default Image">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                        <p class="card-text">Price: N<?php echo htmlspecialchars($row['amount']); ?></p>
                        <a href="purchase_drugs.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Purchase</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
