<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

include('db.php');

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM drugs WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $drug = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $production_date = mysqli_real_escape_string($conn, $_POST['production_date']);
    $expiry_date = mysqli_real_escape_string($conn, $_POST['expiry_date']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);

    $query = "UPDATE drugs SET name = '$name', description = '$description', production_date = '$production_date', expiry_date = '$expiry_date', amount = '$amount' WHERE id = '$id'";
    
    if (mysqli_query($conn, $query)) {
        echo "Drug updated successfully!";
        header('Location: view_drugs.php');
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Drug</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-4">Edit Drug</h2>
        <form action="edit_drug.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $drug['id']; ?>">
            <div class="form-group">
                <label for="name">Drug Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $drug['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" required><?php echo $drug['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="production_date">Production Date</label>
                <input type="date" class="form-control" id="production_date" name="production_date" value="<?php echo $drug['production_date']; ?>" required>
            </div>
            <div class="form-group">
                <label for="expiry_date">Expiry Date</label>
                <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="<?php echo $drug['expiry_date']; ?>" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" value="<?php echo $drug['amount']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Drug</button>
        </form>
    </div>
</body>
</html>
