<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname'] ?? '');
    $admission = trim($_POST['admission'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $yos = trim($_POST['yos'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $days = intval($_POST['days'] ?? 1);
    $workshopSelected = isset($_POST['workshop']);
    $mealsSelected = isset($_POST['meals']);
    
    // Server-side validation
    if (empty($fullname) || empty($email) || empty($phone) || empty($category) || $days < 1 || $days > 3) {
        die("<h3 style='color:red;'>Server Validation Error: Essential fields are missing or invalid.</h3>");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("<h3 style='color:red;'>Server Validation Error: Invalid email format.</h3>");
    }

    // Independent PHP Fee Calculation & Verification
    $regFee = 1000;
    $attendanceFee = $days * 500;
    $workshopFee = $workshopSelected ? 750 : 0;
    $mealFee = $mealsSelected ? ($days * 300) : 0;

    $subtotal = $regFee + $attendanceFee + $workshopFee + $mealFee;
    
    $isDiscountApplied = false;
    if ($days === 3) {
        $subtotal = $subtotal - ($subtotal * 0.10);
        $isDiscountApplied = true;
    }
    
    $verifiedTotal = $subtotal;
} else {
    header("Location: register.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Confirmation</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Conference Registration System</h1>
        </div>
    </header>

    <main class="container">
        <div class="hero" style="text-align: left;">
            <h2 style="color: green; text-align: center;">REGISTRATION SUCCESSFUL</h2>
            <hr>
            <p><strong>Participant:</strong> <?php echo htmlspecialchars($fullname); ?></p>
            <p><strong>Admission Number:</strong> <?php echo htmlspecialchars($admission); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
            <p><strong>Year of Study:</strong> Year <?php echo htmlspecialchars($yos); ?></p>
            <p><strong>Category:</strong> <?php echo htmlspecialchars($category); ?></p>
            <p><strong>Conference Days:</strong> <?php echo $days; ?></p>
            <p><strong>Workshop:</strong> <?php echo $workshopSelected ? "Yes" : "No"; ?></p>
            <p><strong>Meals:</strong> <?php echo $mealsSelected ? "Yes" : "No"; ?></p>
            <?php if ($isDiscountApplied): ?>
                <p style="color: green;"><strong>Special Note:</strong> 10% discount applied for 3-day attendance!</p>
            <?php endif; ?>
            <hr>
            <h3 class="total-display">TOTAL AMOUNT PAYABLE: KSh <?php echo number_format($verifiedTotal); ?></h3>
            <p style="margin-top: 20px; text-align: center;">Thank you for registering for the Student Technology and Innovation Conference.</p>
            
            <div style="text-align: center; margin-top: 20px;">
                <a href="register.html" class="btn">Register Another Participant</a>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Student Technology and Innovation Conference.</p>
    </footer>
</body>
</html>