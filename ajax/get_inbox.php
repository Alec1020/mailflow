<?php
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([]);
    exit;
}

require_once "../config/database.php";
require_once "../models/Mail.php";

$db = (new Database())->connect();

$mailObj = new Mail($db);

$mails = $mailObj->getInbox($_SESSION['user_id']);

echo json_encode($mails);
