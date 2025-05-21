<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/qwen_api_client.php';

session_start();

if (!isset($_SESSION['birth_date']) || !isset($_SESSION['birth_hour'])) {
    header('Location: step1_birth_input.php');
    exit;
}

$baziChart = null;
$fiveElementsAnalysis = null;
$error = null;

try {
    $qwen = new QwenApiClient();
    
    // Calculate BaZi
    $baziChart = $qwen->calculateBaZi($_SESSION['birth_date'], $_SESSION['birth_hour']);
    if (!$baziChart) {
        throw new Exception('Failed to calculate BaZi chart');
    }
    $_SESSION['bazi_chart'] = $baziChart;
    
    // Analyze Five Elements
    $fiveElementsAnalysis = $qwen->analyzeFiveElements($baziChart);
    if (!$fiveElementsAnalysis) {
        throw new Exception('Failed to analyze Five Elements');
    }
    $_SESSION['five_elements_analysis'] = $fiveElementsAnalysis;
    
} catch (Exception $e) {
    $error = 'An error occurred: ' . $e->getMessage();
    error_log('Error in step2_dashboard.php: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Feng Shui Dashboard - Zenaura.club</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Your Personalized Feng Shui Dashboard</h1>

        <?php if ($error): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <div class="retry-button">
                <a href="step1_birth_input.php" class="btn">Try Again</a>
            </div>
        <?php elseif ($baziChart && $fiveElementsAnalysis): ?>
            <div class="card">
                <h2>Your BaZi Chart (生辰八字)</h2>
                <div class="bazi-chart">
                    <div class="pillar">
                        <h3>Year Pillar</h3>
                        <p>Heavenly Stem: <?php echo htmlspecialchars($baziChart['year_pillar']['stem_char']); ?> (<?php echo htmlspecialchars($baziChart['year_pillar']['stem_pinyin']); ?>)</p>
                        <p>Earthly Branch: <?php echo htmlspecialchars($baziChart['year_pillar']['branch_char']); ?> (<?php echo htmlspecialchars($baziChart['year_pillar']['branch_pinyin']); ?>)</p>
                    </div>
                    <div class="pillar">
                        <h3>Month Pillar</h3>
                        <p>Heavenly Stem: <?php echo htmlspecialchars($baziChart['month_pillar']['stem_char']); ?> (<?php echo htmlspecialchars($baziChart['month_pillar']['stem_pinyin']); ?>)</p>
                        <p>Earthly Branch: <?php echo htmlspecialchars($baziChart['month_pillar']['branch_char']); ?> (<?php echo htmlspecialchars($baziChart['month_pillar']['branch_pinyin']); ?>)</p>
                    </div>
                    <div class="pillar">
                        <h3>Day Pillar</h3>
                        <p>Heavenly Stem: <?php echo htmlspecialchars($baziChart['day_pillar']['stem_char']); ?> (<?php echo htmlspecialchars($baziChart['day_pillar']['stem_pinyin']); ?>)</p>
                        <p>Earthly Branch: <?php echo htmlspecialchars($baziChart['day_pillar']['branch_char']); ?> (<?php echo htmlspecialchars($baziChart['day_pillar']['branch_pinyin']); ?>)</p>
                    </div>
                    <div class="pillar">
                        <h3>Hour Pillar</h3>
                        <p>Heavenly Stem: <?php echo htmlspecialchars($baziChart['hour_pillar']['stem_char']); ?> (<?php echo htmlspecialchars($baziChart['hour_pillar']['stem_pinyin']); ?>)</p>
                        <p>Earthly Branch: <?php echo htmlspecialchars($baziChart['hour_pillar']['branch_char']); ?> (<?php echo htmlspecialchars($baziChart['hour_pillar']['branch_pinyin']); ?>)</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <h2>Your Five Elements Analysis (五行风水)</h2>
                <div class="element-chart">
                    <?php foreach ($fiveElementsAnalysis['elements_strength'] as $element): ?>
                        <div class="element-bar">
                            <div class="fill" style="background-color: <?php echo get_element_color($element['element_en']); ?>; width: 0%;" 
                                 data-width="<?php echo $element['strength_percentage']; ?>">
                            </div>
                            <div class="label">
                                <span><?php echo htmlspecialchars($element['element_en']); ?> (<?php echo htmlspecialchars($element['element_zh']); ?>)</span>
                                <span><?php echo $element['strength_percentage']; ?>% (<?php echo htmlspecialchars($element['assessment']); ?>)</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="summary">
                    <h3>Day Master Element</h3>
                    <p><?php echo htmlspecialchars($fiveElementsAnalysis['day_master_element_en']); ?> (<?php echo htmlspecialchars($fiveElementsAnalysis['day_master_element_zh']); ?>)</p>
                    
                    <h3>Overall Analysis</h3>
                    <p><?php echo htmlspecialchars($fiveElementsAnalysis['overall_summary']); ?></p>
                </div>
            </div>

            <form action="step3_wallpaper_selection.php" method="POST">
                <button type="submit" class="btn">Generate My Lucky Wallpapers</button>
            </form>
        <?php else: ?>
            <div class="error-message">Unable to generate your chart. Please try again.</div>
            <div class="retry-button">
                <a href="step1_birth_input.php" class="btn">Try Again</a>
            </div>
        <?php endif; ?>
    </div>

    <script src="js/main.js"></script>
</body>
</html>