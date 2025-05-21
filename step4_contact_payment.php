<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

session_start();

if (!isset($_POST['selected_wallpapers']) || !isset($_SESSION['wallpaper_designs'])) {
    header('Location: step3_wallpaper_selection.php');
    exit;
}

$selectedWallpapers = $_POST['selected_wallpapers'];
$wallpaperCount = count($selectedWallpapers);
$totalPrice = calculate_price($wallpaperCount);

// Store selection in session
$_SESSION['selected_wallpapers'] = $selectedWallpapers;
$_SESSION['total_price'] = $totalPrice;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Order - Zenaura.club</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Complete Your Order & Connect</h1>

        <div class="card">
            <h2>Order Summary</h2>
            <p>You have selected <?php echo $wallpaperCount; ?> wallpaper(s).</p>
            <p>Total Price: $<?php echo number_format($totalPrice, 2); ?></p>
        </div>

        <div class="card">
            <h2>Connect with Our Feng Shui Assistant</h2>
            <p>To receive your personalized wallpapers, please connect with our Feng Shui Assistant.</p>
            <p>Scan the QR code below to add our assistant on WeChat or WhatsApp.</p>
            <p>Once connected, please mention 'Zenaura Wallpaper Order' and our assistant will guide you through the final steps and send you your downloads.</p>

            <div class="qr-code-container">
                <div class="qr-code">
                    <h3>WeChat</h3>
                    <img src="images/wechat_qr.png" alt="WeChat QR Code">
                    <p>Scan to add on WeChat</p>
                </div>
                <div class="qr-code">
                    <h3>WhatsApp</h3>
                    <img src="images/whatsapp_qr.png" alt="WhatsApp QR Code">
                    <p>Scan to add on WhatsApp</p>
                </div>
            </div>
        </div>

        <div class="card">
            <h2>Next Steps</h2>
            <ol>
                <li>Connect with our assistant using either WeChat or WhatsApp</li>
                <li>Mention "Zenaura Wallpaper Order"</li>
                <li>Our assistant will confirm your order and guide you through the payment process</li>
                <li>After payment confirmation, you'll be able to select your phone model and receive your wallpapers</li>
            </ol>
        </div>

        <form action="step5_download_prep.php" method="POST">
            <button type="submit" class="btn">I've Contacted the Assistant / Proceed to Phone Selection</button>
        </form>
    </div>

    <script src="js/main.js"></script>
</body>
</html> 