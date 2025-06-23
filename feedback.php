<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include('db.php');

// Handle feedback submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $created_at = date('Y-m-d H:i:s'); // Current date and time

    $query = "INSERT INTO feedback (user_id, message, created_at) VALUES ('$user_id', '$message', '$created_at')";

    if (mysqli_query($conn, $query)) {
        $success_message = "Feedback submitted successfully!";
    } else {
        $error_message = "Error: " . mysqli_error($conn);
    }
}

// Fetch user feedback
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM feedback WHERE user_id = '$user_id' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'header.php'; ?><br><br><br>

    <div class="container">
        <h3>Feedback</h3>

        <!-- Feedback Submission Form -->
        <form action="feedback.php" method="POST">
            <div class="form-group">
                <label for="message">Your Feedback</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Feedback</button>
        </form>

        <?php if (isset($success_message)): ?>
        <div class="alert alert-success mt-3" role="alert">
            <?php echo $success_message; ?>
        </div>
        <?php elseif (isset($error_message)): ?>
        <div class="alert alert-danger mt-3" role="alert">
            <?php echo $error_message; ?>
        </div>
        <?php endif; ?>

        <h4 class="mt-5">Your Feedback History</h4>
        <div class="list-group mt-3">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="list-group-item">
                <p><strong><?php echo htmlspecialchars($row['created_at']); ?></strong></p>
                <p><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
