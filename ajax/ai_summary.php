<?php
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Unauthorized'
    ]);
    exit;
}

$body = trim($_POST['body'] ?? '');

if (empty($body)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'No email content'
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| OpenAI API Key
|--------------------------------------------------------------------------
*/
$apiKey = "YOUR_OPENAI_API_KEY";

$prompt = "
Summarize the following email in 3-5 concise bullet points.

Email:

$body
";

$data = [
    "model" => "gpt-4o-mini",
    "messages" => [
        [
            "role" => "system",
            "content" => "You are an email assistant."
        ],
        [
            "role" => "user",
            "content" => $prompt
        ]
    ],
    "temperature" => 0.3
];

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => "https://api.openai.com/v1/chat/completions",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer " . $apiKey
    ],
    CURLOPT_POSTFIELDS => json_encode($data)
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode([
        'status' => 'error',
        'message' => curl_error($ch)
    ]);
    exit;
}

curl_close($ch);

$result = json_decode($response, true);

$summary =
    $result['choices'][0]['message']['content']
    ?? 'Unable to generate summary';

echo json_encode([
    'status' => 'success',
    'summary' => $summary
]);