<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/qwen_api_client.php';

session_start();

if (!isset($_SESSION['five_elements_analysis'])) {
    header('Location: step1_birth_input.php');
    exit;
}

try {
    $qwen = new QwenApiClient();
    $wallpaperDesigns = $qwen->generateWallpaperDesigns($_SESSION['five_elements_analysis']);
    $_SESSION['wallpaper_designs'] = $wallpaperDesigns;
} catch (Exception $e) {
    $error = 'An error occurred while generating wallpaper designs. Please try again.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Your Feng Shui Wallpapers - Zenaura.club</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Choose Your Feng Shui Wallpapers</h1>
        <p class="info-text">Our AI Feng Shui Master has designed these 5 wallpapers based on your unique BaZi. Select 1 to 5 wallpapers to boost your fortune.</p>

        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php else: ?>
            <form action="step4_contact_payment.php" method="POST" id="wallpaper-form">
                <div class="wallpaper-grid">
                    <?php foreach ($wallpaperDesigns as $index => $design): ?>
                        <div class="wallpaper-card">
                            <div class="wallpaper-preview">
                                <!-- Placeholder image - in production, this would be generated from the prompt -->
                                <img src="images/placeholder-<?php echo ($index % 5) + 1; ?>.jpg" alt="<?php echo htmlspecialchars($design['title']); ?>">
                            </div>
                            <div class="content">
                                <h3><?php echo htmlspecialchars($design['title']); ?></h3>
                                <p><?php echo htmlspecialchars($design['feng_shui_rationale']); ?></p>
                                <div class="selection">
                                    <input type="checkbox" 
                                           id="wallpaper-<?php echo $index; ?>" 
                                           name="selected_wallpapers[]" 
                                           value="<?php echo $index; ?>" 
                                           class="wallpaper-checkbox">
                                    <label for="wallpaper-<?php echo $index; ?>">Select this wallpaper</label>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="price-summary card">
                    <h3>Your Selection</h3>
                    <p>Number of wallpapers selected: <span id="price-display">0</span></p>
                    <p>Total Price: <span id="total-price">$0.00</span></p>
                </div>

                <button type="submit" class="btn">Proceed to Get My Wallpapers</button>
            </form>
        <?php endif; ?>
    </div>

    <script src="js/main.js"></script>
</body>
</html> 