<?php
require_once 'includes/config.php';
require_once 'includes/qwen_api_client.php';

// 启用错误显示
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    echo "Testing Qwen API connection...\n";
    echo "API URL: " . QWEN_API_URL . "\n";
    
    $qwen = new QwenApiClient();
    
    // 测试简单的 API 调用
    $testPrompt = "Please respond with a simple 'Hello, World!' message.";
    echo "\nSending test prompt: " . $testPrompt . "\n";
    
   // $response = $qwen->makeApiCall($testPrompt);
   $response=$qwen->testApi($testPrompt);
 
    echo "\nAPI Response:\n";
    print_r($response);
    
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