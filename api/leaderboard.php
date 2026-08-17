<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../config.php';

if (!file_exists(LEADERBOARD_FILE)) {
    echo json_encode(['success' => true, 'leaderboard' => []], JSON_UNESCAPED_UNICODE);
    exit;
}

$leaderboard = json_decode(file_get_contents(LEADERBOARD_FILE), true);
echo json_encode(['success' => true, 'leaderboard' => $leaderboard], JSON_UNESCAPED_UNICODE);
