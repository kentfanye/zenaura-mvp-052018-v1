<?php
require_once 'config.php';

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validate_date($year, $month, $day) {
    return checkdate($month, $day, $year);
}

function validate_hour($hour) {
    return is_numeric($hour) && $hour >= 0 && $hour <= 23;
}

function format_birth_date($year, $month, $day) {
    return sprintf('%04d%02d%02d', $year, $month, $day);
}

function get_element_color($element) {
    $colors = [
        'Wood' => '#4CAF50',
        'Fire' => '#F44336',
        'Earth' => '#795548',
        'Metal' => '#9E9E9E',
        'Water' => '#2196F3'
    ];
    return $colors[$element] ?? '#000000';
}

function calculate_price($wallpaper_count) {
    $prices = [
        1 => 9.99,
        2 => 17.99,
        3 => 24.99,
        4 => 29.99,
        5 => 34.99
    ];
    return $prices[$wallpaper_count] ?? 0;
}

function get_phone_models() {
    return [
        'apple' => [
            'iPhone 15 Pro Max' => '1290x2796',
            'iPhone 15 Pro' => '1179x2556',
            'iPhone 15 Plus' => '1290x2796',
            'iPhone 15' => '1179x2556'
        ],
        'samsung' => [
            'Galaxy S24 Ultra' => '1440x3088',
            'Galaxy S24+' => '1440x3088',
            'Galaxy S24' => '1080x2340'
        ],
        'google' => [
            'Pixel 8 Pro' => '1344x2992',
            'Pixel 8' => '1080x2400'
        ]
    ];
} 