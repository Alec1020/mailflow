<?php
session_start();

require_once "../config/database.php";
require_once "../models/User.php";
require_once "../models/Mail.php";

$db = (new Database())->connect();
$userModel = new User($db);
$mailModel = new Mail($db);

$receiverEmail = trim($_POST['to'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$body = trim($_POST['body'] ?? '');

if (!$receiverEmail || !$subject || !$body) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
    exit;
}

$receiver = $userModel->findByEmail($receiverEmail);

if (!$receiver) {
    echo json_encode(['status' => 'error', 'message' => 'Recipient not found']);
    exit;
}

try {
    $result = $mailModel->send($_SESSION['user_id'], $receiver['id'], $subject, $body);
    echo json_encode(['status' => $result ? 'success' : 'error']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
