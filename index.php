<?php
session_start();
include('db.php');

// Search functionality
$search_query = '';
if (isset($_POST['search'])) {
    $search_query = mysqli_real_escape_string($conn, $_POST['search_query']);
    $query = "SELECT * FROM drugs WHERE name LIKE '%$search_query%'";
} else {
    $query = "SELECT * FROM drugs";
}

$result = mysqli_query($conn, $query);

// Check if the query executed successfully
if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Pharmacy</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5; /* Light gray background for a clean look */
            color: #333; /* Dark text for contrast */
        }
        .navbar {
            background-color: #007bff; /* Bootstrap primary color */
        }
        .navbar-brand {
            color: #fff !important;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card img {
            height: 200px;
            object-fit: cover;
        }
        .carousel-item img {
            height: 300px;
            object-fit: cover;
        }
        h1, h6 {
            color: #007bff; /* Match the primary color for headings */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <a class="navbar-brand" href="index.php">Pharmacy</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="customer_dashboard.php">Enter Pharmacy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_login.php">Admin</a>
                </li>
            </ul>
        </div>
    </nav>
    <br><br><br>
    <div class="container mt-4">
        <form method="POST" class="form-inline mb-4">
            <input class="form-control mr-sm-2" type="search" name="search_query" placeholder="Search for drugs" aria-label="Search" value="<?php echo htmlspecialchars($search_query); ?>">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search">Search</button>
        </form>
    </div>
    <div class="container">
        <center><h1>Welcome to our pharmacy</h1></center><br><br>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-3">
                        <div class="card mb-4">
                            <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                                <a href="user_login.php" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-center">No drugs found matching your search.</p>
        <?php endif; ?>

        <!-- Your carousel and other sections -->
        <!-- Carousel -->
        <center><div id="vehicleCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./images/pha.jpeg" width='300' class="d-block w-30 rounded-circle" alt="Jeep">
                </div>
                <div class="carousel-item">
                    <img src="./images/pha1.jpeg" width='300' class="d-block w-30 rounded-circle" alt="Image 2">
                </div>
                <div class="carousel-item">
                    <img src="./images/pha2.webp" width='300' class="d-block w-10 rounded-circle" alt="Image 3">
                </div>
            </div></center>
            <a class="carousel-control-prev" href="#vehicleCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#vehicleCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
        </a>
        </div>

        <div class="container mt-5">
            <center><h6>ANTIBIOTICS</h6></center>
            <div class="row justify-content-end bg-light">
                <div class="col bg-mute align-self-end">
                    <img src="./images/zedex.jpg" width="100px">
                    <p>zedex</p>
                    <img src="./images/pha10.jpg" width="100px">
                    <p>pharmacy</p>
                </div>
                <div class="col bg-mute">
                    <img src="./images/pha7.jpg" width="100px">
                    <p>pharmacy</p>
                    <img src="./images/pha6.jpeg" width="100px">
                    <p>pharmcy</p>
                </div>
                <div class="col bg-mute">
                    <img src="./images/pha9.jpg" width="100px">
                    <p>pharmacy</p>
                    <img src="./images/mon.jpg" width="100px">
                    <p>mon</p>
                </div>
            </div>

            <center><h6>COLD AND FLU</h6></center>
            <div class="row justify-content-end bg-light mt-3">
                <div class="col bg-mute align-self-end">
                    <img src="./images/asad.jpg" width="100px">
                    <p>asad</p>
                    <img src="./images/coda.jpg" width="100px">
                    <p>coda</p>
                </div>
                <div class="col bg-mute">
                    <img src="./images/da.jpg" width="100px">
                    <p>da</p>
                    <img src="./images/df.jpg" width="100px">
                    <p>df</p>
                </div>
                <div class="col bg-mute">
                    <img src="./images/cot.jpj" width="100px">
                    <p>cot</p>
                    <img src="./images/lora.jpg" width="100px">
                    <p>Lora</p>
                </div>
            </div>
        </div>
</body>
</html>
