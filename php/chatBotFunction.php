<?php

$api_key = "AIzaSyAU9XgJqba2WCupiWj55TyaWqlYYZipe-E";
$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$api_key";

// Set headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Get JSON input
$input = json_decode(file_get_contents("php://input"), true);

if (!$input || !isset($input["message"])) {
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$user_message = trim($input["message"]);

$data = [
    "contents" => [
        [
            "parts" => [
                ["text" => $user_message]
            ]
        ]
    ]
];

// cURL request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json"
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(['error' => 'Curl error: ' . curl_error($ch)]);
    curl_close($ch);
    exit;
}

$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code !== 200) {
    echo json_encode(['error' => 'Google Gemini API error', 'details' => $response]);
    exit;
}

$response_data = json_decode($response, true);

if (!isset($response_data['candidates'][0]['content']['parts'][0]['text'])) {
    echo json_encode(['error' => 'Unexpected API response format', 'details' => $response_data]);
    exit;
}

$ai_response = trim($response_data['candidates'][0]['content']['parts'][0]['text']);
echo json_encode(['response' => $ai_response]);

?>
