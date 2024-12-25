<?php
// Include the QR Code library
require_once 'vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;

// Payment details (this can be dynamic based on your system)
$paymentAmount = 100; // e.g., $100
$paymentReceiver = "receiver@example.com";

// Encode the payment information in the QR code (can include amount, account, etc.)
$paymentUrl = "https://payment-gateway.com/pay?receiver=" . urlencode($paymentReceiver) . "&amount=" . urlencode($paymentAmount);

try {
    // Generate the QR code
    $result = Builder::create()
        ->data($paymentUrl)
        ->size(200)
        ->build();

    // Save the QR code image (or render it directly)
    $qrcodePath = 'qrcode.png';
    $result->saveToFile($qrcodePath);
} catch (Exception $e) {
    die('Error generating QR code: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>QR Code Payment</title>
</head>
<body>
    <h1>Scan QR Code to Pay</h1>
    <p>Amount to pay: $<?php echo htmlspecialchars($paymentAmount, ENT_QUOTES, 'UTF-8'); ?></p>

    <?php if (file_exists($qrcodePath)): ?>
        <img src="<?php echo htmlspecialchars($qrcodePath, ENT_QUOTES, 'UTF-8'); ?>" alt="Payment QR Code">
    <?php else: ?>
        <p>QR Code could not be generated. Please try again later.</p>
    <?php endif; ?>

    <p>Or click <a href="<?php echo htmlspecialchars($paymentUrl, ENT_QUOTES, 'UTF-8'); ?>">here to pay directly</a></p>
</body>
</html>
