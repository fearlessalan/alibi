<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../config.php';

$method = $_SERVER['REQUEST_METHOD'];

// Helper pour lire le fichier JSON
function getAlibis() {
    if (!file_exists(ALIBIS_FILE)) return [];
    $data = json_decode(file_get_contents(ALIBIS_FILE), true);
    return is_array($data) ? $data : [];
}

// Helper pour écrire le fichier JSON
function saveAlibis($alibis) {
    file_put_contents(ALIBIS_FILE, json_encode(array_values($alibis), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

if ($method === 'GET') {
    // Lister les alibis
    $alibis = getAlibis();
    echo json_encode(['success' => true, 'alibis' => $alibis], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($method === 'POST') {
    // Ajouter un alibi
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (empty($input['text'])) {
        echo json_encode(['success' => false, 'message' => 'Le texte de l\'alibi est requis'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $alibis = getAlibis();
    
    $newAlibi = [
        'id' => 'alibi_' . uniqid(),
        'subject' => !empty($input['subject']) ? trim($input['subject']) : 'Excuse sans titre',
        'target' => !empty($input['target']) ? trim($input['target']) : 'Général',
        'vibe' => isset($input['vibe']) ? intval($input['vibe']) : 50,
        'text' => trim($input['text']),
        'date' => "Aujourd'hui",
        'timestamp' => time()
    ];

    array_unshift($alibis, $newAlibi); // Ajouter au début
    saveAlibis($alibis);

    echo json_encode(['success' => true, 'alibi' => $newAlibi], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($method === 'DELETE') {
    // Supprimer un alibi
    $input = json_decode(file_get_contents('php://input'), true);
    $id = isset($input['id']) ? $input['id'] : (isset($_GET['id']) ? $_GET['id'] : null);

    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'ID requis'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $alibis = getAlibis();
    $filtered = array_filter($alibis, function($item) use ($id) {
        return $item['id'] !== $id;
    });

    saveAlibis($filtered);

    echo json_encode(['success' => true, 'message' => 'Alibi supprimé'], JSON_UNESCAPED_UNICODE);
    exit;
}
