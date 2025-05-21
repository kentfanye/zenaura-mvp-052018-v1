<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

session_start();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $birth_date = filter_input(INPUT_POST, 'birth_date', FILTER_SANITIZE_STRING);
    $hour = filter_input(INPUT_POST, 'birth_hour_slot', FILTER_VALIDATE_INT);

    if (!$birth_date || !$hour) {
        $error = 'Please fill in all fields with valid values.';
    } elseif (!preg_match('/^\d{8}$/', $birth_date)) {
        $error = 'Please enter a valid date in YYYYMMDD format (e.g., 19900101).';
    } else {
        $year = substr($birth_date, 0, 4);
        $month = substr($birth_date, 4, 2);
        $day = substr($birth_date, 6, 2);
        
        if (!validate_date($year, $month, $day)) {
            $error = 'Please enter a valid date.';
        } elseif (!validate_hour($hour)) {
            $error = 'Please enter a valid hour (0-23).';
        } else {
            $_SESSION['birth_date'] = $birth_date;
            $_SESSION['birth_hour'] = $hour;
            header('Location: step2_dashboard.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Your Birth Information - Zenaura.club</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Enter Your Birth Information</h1>
        <p class="info-text">Please provide your accurate birth date and time for the most precise BaZi calculation. We respect your privacy.</p>

        <?php if ($error): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form id="birth-form" method="POST" action="" class="card">
            <div class="form-group">
                <label for="birth_date">Birth Date (YYYYMMDD)</label>
                <input type="text" id="birth_date" name="birth_date" class="form-control" 
                       pattern="\d{8}" maxlength="8" placeholder="YYYYMMDD (e.g., 19900101)" required
                       value="<?php echo isset($_POST['birth_date']) ? htmlspecialchars($_POST['birth_date']) : ''; ?>">
                <small class="form-text">Enter your birth date in YYYYMMDD format (e.g., 19900101 for January 1, 1990)</small>
            </div>

            <div class="form-group">
                <label for="birth_hour_slot">Birth Hour (24-hour format)</label>
                <select id="birth_hour_slot" name="birth_hour_slot" class="form-control" required>
                    <option value="">Select Hour</option>
                    <?php for ($i = 0; $i <= 23; $i++): ?>
                        <option value="<?php echo $i; ?>"
                                <?php echo (isset($_POST['birth_hour_slot']) && $_POST['birth_hour_slot'] == $i) ? 'selected' : ''; ?>>
                            <?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?>:00
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <button type="submit" class="btn">Calculate My BaZi Chart</button>
        </form>
    </div>

    <script>
    document.getElementById('birth_date').addEventListener('input', function(e) {
        // 只允许输入数字
        this.value = this.value.replace(/[^\d]/g, '');
        
        // 限制长度为8位
        if (this.value.length > 8) {
            this.value = this.value.slice(0, 8);
        }
        
        // 自动格式化显示
        if (this.value.length >= 4) {
            let year = this.value.slice(0, 4);
            let month = this.value.slice(4, 6);
            let day = this.value.slice(6, 8);
            
            // 验证月份
            if (month && parseInt(month) > 12) {
                month = '12';
            }
            
            // 验证日期
            if (day) {
                let daysInMonth = new Date(year, month, 0).getDate();
                if (parseInt(day) > daysInMonth) {
                    day = daysInMonth.toString();
                }
            }
            
            this.value = year + (month || '') + (day || '');
        }
    });
    </script>
</body>
</html>