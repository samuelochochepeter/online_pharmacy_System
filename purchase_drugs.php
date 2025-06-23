<?php
include 'db.php'; // Include your database connection file

// Retrieve the drug ID from the query parameters
$drug_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';
$success_message = '';
$error_message = '';

// Fetch drug details
$query = "SELECT * FROM drugs WHERE id='$drug_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    $error_message = "Drug not found!";
} else {
    $drug = mysqli_fetch_assoc($result);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve and sanitize inputs
        $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
        $customer_email = mysqli_real_escape_string($conn, $_POST['customer_email']);
        $payment_amount = mysqli_real_escape_string($conn, $_POST['payment_amount']);
        $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);

        // Handle different payment methods
        if ($payment_method == 'card') {
            $card_number = mysqli_real_escape_string($conn, $_POST['card_number']);
            $card_expiry = mysqli_real_escape_string($conn, $_POST['card_expiry']);
            $card_cvv = mysqli_real_escape_string($conn, $_POST['card_cvv']);
            // Save card details securely
        } else if ($payment_method == 'ebanking') {
            $bank_name = mysqli_real_escape_string($conn, $_POST['bank_name']);
            $transaction_id = mysqli_real_escape_string($conn, $_POST['transaction_id']);
            // Save e-banking details securely
        }

        // Example SQL query to insert payment into database
        $sql = "INSERT INTO payments (product_id, customer_name, customer_email, payment_amount, payment_method)
                VALUES ('$drug_id', '$customer_name', '$customer_email', '$payment_amount', '$payment_method')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Payment processed successfully! We will contact you shortly.";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Drug</title>
    <!-- Bootstrap CSS via CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Link your custom CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include 'header.php'; ?><br><br><br>

    <div class="container">
        <h3>Purchase Drug</h3><br><br>

        <?php if (!empty($success_message)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success_message; ?>
        </div>
        <?php elseif (!empty($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
        <?php else: ?>
        <form action="purchase_drugs.php?id=<?php echo htmlspecialchars($drug_id); ?>" method="POST">
            <div class="form-group">
                <label for="drug_name">Drug Name</label>
                <input type="text" class="form-control" id="drug_name" name="drug_name" value="<?php echo htmlspecialchars($drug['name']); ?>" readonly required>
            </div>
            <div class="form-group">
                <label for="customer_name">Customer Name</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
            </div>
            <div class="form-group">
                <label for="customer_email">Customer Email</label>
                <input type="email" class="form-control" id="customer_email" name="customer_email" required>
            </div>
            <div class="form-group">
                <label for="payment_amount">Payment Amount</label>
                <input type="number" class="form-control" id="payment_amount" name="payment_amount" value="<?php echo htmlspecialchars($drug['amount']); ?>" readonly required>
            </div>
            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <select class="form-control" id="payment_method" name="payment_method" required>
                    <option value="">Select Payment Method</option>
                    <option value="card">ATM Card</option>
                    <option value="ebanking">E-banking/Transfer</option>
                </select>
            </div>
            <div id="card_details" style="display: none;">
                <div class="form-group">
                    <label for="card_number">Card Number</label>
                    <input type="text" class="form-control" id="card_number" name="card_number">
                </div>
                <div class="form-group">
                    <label for="card_expiry">Card Expiry Date</label>
                    <input type="text" class="form-control" id="card_expiry" name="card_expiry" placeholder="MM/YY">
                </div>
                <div class="form-group">
                    <label for="card_cvv">Card CVV</label>
                    <input type="text" class="form-control" id="card_cvv" name="card_cvv">
                </div>
            </div>
            <div id="ebanking_details" style="display: none;">
                <div class="form-group">
                    <label for="bank_name">Bank Name</label>
                    <input type="text" class="form-control" id="bank_name" name="bank_name">
                </div>
                <div class="form-group">
                    <label for="transaction_id">Transaction ID</label>
                    <input type="text" class="form-control" id="transaction_id" name="transaction_id">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit Payment</button>
        </form>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS and dependencies via CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('payment_method').addEventListener('change', function() {
            var cardDetails = document.getElementById('card_details');
            var ebankingDetails = document.getElementById('ebanking_details');
            if (this.value == 'card') {
                cardDetails.style.display = 'block';
                ebankingDetails.style.display = 'none';
            } else if (this.value == 'ebanking') {
                cardDetails.style.display = 'none';
                ebankingDetails.style.display = 'block';
            } else {
                cardDetails.style.display = 'none';
                ebankingDetails.style.display = 'none';
            }
        });
    </script>
</body>
</html>
