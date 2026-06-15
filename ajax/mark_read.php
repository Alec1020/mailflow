<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit;
}

require_once "../config/database.php";
require_once "../models/Mail.php";

$db = (new Database())->connect();

$mailObj = new Mail($db);

$id = intval($_POST['id'] ?? 0);

if ($id) {
    $mailObj->markAsRead($id);
}
