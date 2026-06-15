<?php
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit;
}

require_once "../config/database.php";
require_once "../models/Mail.php";

$db = (new Database())->connect();

$mailObj = new Mail($db);

$parent_id = intval($_POST['parent_id'] ?? 0);
$body = trim($_POST['body'] ?? '');

$original = $mailObj->getById($parent_id);

if (!$original) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Mail not found'
    ]);
    exit;
}

$result = $mailObj->send(
    $_SESSION['user_id'],
    $original['sender_id'],
    "Re: ".$original['subject'],
    $body,
    $parent_id
);

echo json_encode([
    'status' => $result ? 'success' : 'error'
]);
