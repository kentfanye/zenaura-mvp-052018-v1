<?php
require_once 'includes/config.php';
require_once 'includes/qwen_api_client.php';

// 启用错误显示
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    echo "Testing BaZi Calculation...\n";
    
    $qwen = new QwenApiClient();
    
    // 测试数据
    $birthDate = '1990-01-01';
    $birthHourSlot = 23; // 23:00-23:59
    
    echo "\nTest Data:\n";
    echo "Birth Date: " . $birthDate . "\n";
    echo "Birth Hour: " . $birthHourSlot . ":00\n";
    
    // 计算八字
    echo "\nCalculating BaZi...\n";
    $baziChart = $qwen->calculateBaZi($birthDate, $birthHourSlot);
    
    echo "\nBaZi Chart Result:\n";
    print_r($baziChart);
    
    // 分析五行
    echo "\nAnalyzing Five Elements...\n";
    $fiveElementsAnalysis = $qwen->analyzeFiveElements($baziChart);
    
    echo "\nFive Elements Analysis Result:\n";
    print_r($fiveElementsAnalysis);
    
} catch (Exception $e) {
    echo "\nError occurred:\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    
    // 如果有错误日志，显示它
    if (file_exists('error_log')) {
        echo "\nError Log:\n";
        echo file_get_contents('error_log');
    }
}