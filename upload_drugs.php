<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $production_date = mysqli_real_escape_string($conn, $_POST['production_date']);
    $expiry_date = mysqli_real_escape_string($conn, $_POST['expiry_date']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    
    // Handling the image upload
    $image = $_FILES['image']['name'];
    $target = "images/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        // Insert the drug information along with the image path into the database
        $query = "INSERT INTO drugs (name, description, production_date, expiry_date, amount, image) 
                  VALUES ('$name', '$description', '$production_date', '$expiry_date', '$amount', '$image')";
        
        if (mysqli_query($conn, $query)) {
            echo "Drug uploaded successfully!";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Failed to upload image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Drugs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center">Upload Drugs</h2>
        <form action="upload_drugs.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Drug Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="production_date">Production Date</label>
                <input type="date" class="form-control" id="production_date" name="production_date" required>
            </div>
            <div class="form-group">
                <label for="expiry_date">Expiry Date</label>
                <input type="date" class="form-control" id="expiry_date" name="expiry_date" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="form-group">
                <label for="image">Drug Image</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
</body>
</html>
