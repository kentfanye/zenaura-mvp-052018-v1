<?php
require_once "config.php";

class QwenApiClient {
    private $apiKey;
    private $apiUrl;

    public function __construct() {
        $this->apiKey = QWEN_API_KEY;
        $this->apiUrl = QWEN_API_URL;
        set_time_limit(300);
    }

    public function testApi($prompt) {
        return $this->makeApiCall($prompt);
    }

    private function makeApiCall($prompt) {
        $headers = [
            "Authorization: Bearer " . $this->apiKey,
            "Content-Type: application/json",
            "X-DashScope-SSE: disable"
        ];

        $data = [
            "model" => "qwen-max",
            "input" => [
                "messages" => [
                    [
                        "role" => "system",
                        "content" => "You are a JSON-only API. Always respond with valid JSON objects and no additional text or formatting."
                    ],
                    [
                        "role" => "user",
                        "content" => $prompt
                    ]
                ]
            ],
            "parameters" => [
                "temperature" => 0.3,
                "top_p" => 0.8,
                "result_format" => "message",
                "stop" => ["```"]
            ]
        ];

        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 180);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error = "Curl error: " . curl_error($ch);
            curl_close($ch);
            throw new Exception($error);
        }

        curl_close($ch);

        if ($httpCode !== 200) {
            throw new Exception("API request failed with status code: " . $httpCode . "\nResponse: " . $response);
        }

        $result = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Failed to decode API response: " . json_last_error_msg() . "\nResponse: " . $response);
        }

        if (!isset($result["output"]["choices"][0]["message"]["content"])) {
            throw new Exception("Unexpected API response format: " . json_encode($result));
        }

        return $result;
    }

    public function calculateBaZi($birthDate, $birthHourSlot) {
        $prompt = "You are an expert BaZi (Four Pillars of Destiny) calculator. Given the birth date: {$birthDate} And the birth hour slot starting at: {$birthHourSlot}:00 local time. Calculate the Four Pillars (BaZi) and return ONLY the JSON result, without any explanation or additional text. The JSON should follow this exact format: { \"year_pillar\": {\"stem_char\": \"甲\", \"stem_pinyin\": \"Jia\", \"branch_char\": \"子\", \"branch_pinyin\": \"Zi\"}, \"month_pillar\": {\"stem_char\": \"丙\", \"stem_pinyin\": \"Bing\", \"branch_char\": \"寅\", \"branch_pinyin\": \"Yin\"}, \"day_pillar\": {\"stem_char\": \"庚\", \"stem_pinyin\": \"Geng\", \"branch_char\": \"午\", \"branch_pinyin\": \"Wu\"}, \"hour_pillar\": {\"stem_char\": \"壬\", \"stem_pinyin\": \"Ren\", \"branch_char\": \"申\", \"branch_pinyin\": \"Shen\"} } Rules: 1. Return ONLY the JSON object, no other text 2. Use the correct Heavenly Stems (天干) and Earthly Branches (地支) for each pillar 3. Include both Chinese characters and Pinyin for each component 4. Ensure the hour pillar is correctly determined based on the 2-hour traditional Chinese \"Shi Chen\" (时辰)";

        $response = $this->makeApiCall($prompt);
        $content = $response["output"]["choices"][0]["message"]["content"];
        $result = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Failed to decode BaZi result: " . json_last_error_msg() . "\nContent: " . $content);
        }

        return $result;
    }

    public function analyzeFiveElements($baziChart) {
        $baziJson = json_encode($baziChart);
        $prompt = "You are a Feng Shui master specializing in BaZi Five Element analysis. Given the following BaZi chart: {$baziJson} Analyze the strength of the five elements (Wood, Fire, Earth, Metal, Water) for the Day Master (element of the Day Pillar's Heavenly Stem). For each element, calculate its strength based on: 1. Presence in the Four Pillars (Heavenly Stems and Earthly Branches) 2. Season of birth (from Month Pillar's Earthly Branch) 3. Supporting and controlling relationships between elements 4. Day Master's element and its strength Calculate strength percentages as follows: - Base strength: 20% for each element - Add 10% for each occurrence in Heavenly Stems - Add 5% for each occurrence in Earthly Branches - Add 15% if the element is in season - Add 10% if the element is supported by another element - Subtract 10% if the element is controlled by another element - Add 20% if it's the Day Master's element The total percentage should be between 0-100 for each element. Output the analysis in a structured JSON format: { \"elements_strength\": [ {\"element_en\": \"Wood\", \"element_zh\": \"木\", \"strength_percentage\": 0, \"assessment\": \"Very Weak|Weak|Balanced|Strong|Very Strong\"}, {\"element_en\": \"Fire\", \"element_zh\": \"火\", \"strength_percentage\": 0, \"assessment\": \"Very Weak|Weak|Balanced|Strong|Very Strong\"}, {\"element_en\": \"Earth\", \"element_zh\": \"土\", \"strength_percentage\": 0, \"assessment\": \"Very Weak|Weak|Balanced|Strong|Very Strong\"}, {\"element_en\": \"Metal\", \"element_zh\": \"金\", \"strength_percentage\": 0, \"assessment\": \"Very Weak|Weak|Balanced|Strong|Very Strong\"}, {\"element_en\": \"Water\", \"element_zh\": \"水\", \"strength_percentage\": 0, \"assessment\": \"Very Weak|Weak|Balanced|Strong|Very Strong\"} ], \"day_master_element_en\": \"Element\", \"day_master_element_zh\": \"干\", \"overall_summary\": \"Provide a concise summary here highlighting strong, weak elements and suggested balancing approach for wallpaper design.\" } Rules: 1. Calculate actual percentages based on the formula above 2. Set assessment based on percentage ranges: - 0-20%: Very Weak - 21-40%: Weak - 41-60%: Balanced - 61-80%: Strong - 81-100%: Very Strong 3. Return ONLY the JSON object, no other text or explanation";

        $response = $this->makeApiCall($prompt);
        $content = $response["output"]["choices"][0]["message"]["content"];
        $result = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Failed to decode Five Elements analysis: " . json_last_error_msg() . "\nContent: " . $content);
        }

        return $result;
    }

    public function generateWallpaperDesigns($fiveElementsAnalysis) {
        $analysisJson = json_encode($fiveElementsAnalysis);
        $prompt = "You are a Feng Shui wallpaper design expert. Based on the following Five Elements analysis: {$analysisJson} Generate 5 unique wallpaper design concepts that will help balance and enhance the user's elemental energies. Each design should be described in a JSON format with the following structure: { \"designs\": [ { \"title\": \"Design Name\", \"feng_shui_rationale\": \"Explanation of how this design balances the elements\", \"color_scheme\": [\"color1\", \"color2\", \"color3\"], \"elemental_focus\": [\"element1\", \"element2\"], \"design_elements\": [\"element1\", \"element2\", \"element3\"] } ] } Rules: 1. Each design should focus on balancing the weak elements while maintaining harmony with strong elements 2. Use colors that correspond to the Five Elements: Wood (green), Fire (red), Earth (yellow/brown), Metal (white/gold), Water (blue/black) 3. Include both traditional and modern design elements 4. Consider the user's Day Master element in the design 5. Return ONLY the JSON object, no other text or explanation";

        $response = $this->makeApiCall($prompt);
        $content = $response["output"]["choices"][0]["message"]["content"];
        $result = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Failed to decode wallpaper designs: " . json_last_error_msg() . "\nContent: " . $content);
        }

        if (!isset($result["designs"]) || !is_array($result["designs"])) {
            throw new Exception("Unexpected wallpaper designs format: " . json_encode($result));
        }

        return $result["designs"];
    }
}