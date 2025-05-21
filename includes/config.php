<?php
// API Configuration
define('QWEN_API_KEY', 'sk-25217ad8cb0f47a297f4d88868473339');
define('QWEN_API_URL', 'https://dashscope.aliyuncs.com/api/v1/services/aigc/text-generation/generation');

// Session Configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set to 1 in production with HTTPS

// Error Reporting (for development)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Time Zone
date_default_timezone_set('UTC'); 