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

$id = intval($_GET['id'] ?? 0);

$mail = $mailObj->getById($id);

echo json_encode($mail);
