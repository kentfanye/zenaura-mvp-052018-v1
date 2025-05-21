<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

session_start();

if (!isset($_SESSION['selected_wallpapers']) || !isset($_SESSION['total_price'])) {
    header('Location: step3_wallpaper_selection.php');
    exit;
}

$phoneModels = get_phone_models();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prepare Your Wallpapers - Zenaura.club</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Prepare Your Wallpapers for Download</h1>
        <p class="info-text">Select your phone model to ensure your wallpapers are perfectly sized. Download links will be activated once your connection with our assistant is confirmed.</p>

        <form method="POST" action="" class="card">
            <div class="form-group">
                <label for="phone-brand">Phone Brand</label>
                <select id="phone-brand" name="phone_brand" class="form-control" required>
                    <option value="">Select Brand</option>
                    <option value="apple">Apple</option>
                    <option value="samsung">Samsung</option>
                    <option value="google">Google</option>
                </select>
            </div>

            <div class="form-group">
                <label for="phone-model">Phone Model</label>
                <select id="phone-model" name="phone_model" class="form-control" required>
                    <option value="">Select Model</option>
                </select>
            </div>

            <div class="card">
                <h2>Your Order Details</h2>
                <p>Number of wallpapers: <?php echo count($_SESSION['selected_wallpapers']); ?></p>
                <p>Total price: $<?php echo number_format($_SESSION['total_price'], 2); ?></p>
            </div>

            <div class="card">
                <h2>Important Information</h2>
                <p>Your personalized wallpapers are being prepared. Our assistant will provide you with the download links via WeChat/WhatsApp shortly after confirming your order. Please ensure you have contacted them.</p>
                <p>If you haven't connected with our assistant yet, please go back to the previous step and scan the QR code to connect.</p>
            </div>

            <div class="thank-you-message">
                <h2>Thank You for Choosing Zenaura.club!</h2>
                <p>We wish you enhanced luck and prosperity with your new Feng Shui wallpapers.</p>
            </div>
        </form>
    </div>

    <script src="js/main.js"></script>
</body>
</html> 