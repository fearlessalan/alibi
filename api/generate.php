<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../config.php';

// Lire les paramètres envoyés en POST
$input = json_decode(file_get_contents('php://input'), true);

$subject = isset($input['subject']) && trim($input['subject']) !== '' ? trim($input['subject']) : 'Retard impromptu';
$target  = isset($input['target']) ? trim($input['target']) : 'Patron';
$vibe    = isset($input['vibe']) ? intval($input['vibe']) : 50;

// Description de la vibe
$vibeLabel = "Standard / Crédible";
if ($vibe < 35) {
    $vibeLabel = "Super Professionnel, très sobre et poli";
} elseif ($vibe > 70) {
    $vibeLabel = "Absurde, délirant et rocambolesque";
} else {
    $vibeLabel = "Équilibré avec une touche d'originalité et d'imprévu";
}

$generatedAlibi = "";

// 1. Tenter d'utiliser l'API Gemini / Gemma officielle si la clé est fournie
if (!empty(GEMINI_API_KEY)) {
    $apiKey = GEMINI_API_KEY;
    $url = "https://generativelanguage.googleapis.com/v1beta/models/" . GEMINI_MODEL . ":generateContent?key=" . $apiKey;

    $promptSystem = "Tu es 'Alibi.com', une IA spécialisée dans la génération d'excuses et d'alibis parfaits et hilarants en Français.
Génère une seule excuse courte, percutante et captivante (1 à 3 phrases max) sans préambule ni guillemets inutiles.
Sujet de l'excuse: '$subject'.
Destinataire (À qui on ment): '$target'.
Niveau de risque/Vibe (0=Sobre/Pro, 100=Délirant/Scandaleux, Actuel: $vibe/100 -> $vibeLabel).
Réponds uniquement avec le texte de l'alibi.";

    $payload = [
        "contents" => [
            [
                "parts" => [
                    ["text" => $promptSystem]
                ]
            ]
        ],
        "generationConfig" => [
            "temperature" => 0.85 + ($vibe / 200),
            "maxOutputTokens" => 200
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($httpCode === 200 && $response) {
        $resData = json_decode($response, true);
        if (isset($resData['candidates'][0]['content']['parts'][0]['text'])) {
            $generatedAlibi = trim($resData['candidates'][0]['content']['parts'][0]['text']);
        }
    }
}

$usedFallback = empty($generatedAlibi);

// 2. Si pas de clé API ou si l'API échoue, utiliser un générateur de fallback intelligent et dynamique basé sur Gemma/Gemini logic
if (empty($generatedAlibi)) {
    $fallbackTemplates = [
        "Patron" => [
            "Mon routeur Wi-Fi a capté les fréquences d'un sous-marin nucléaire, provoquant une réinitialisation d'urgence de tout mon quartier.",
            "J'ai voulu éviter une flaque d'eau sur le trottoir et je me suis retrouvé dans un canal de télé-réalité sur la survie en milieu urbain.",
            "Une colonie de pigeons géants a décidé de faire son nid sur mon capot de voiture, la Ligue de Protection des Oiseaux m'interdit de démarrer.",
            "Mon système domotique a verrouillé ma porte d'entrée persuadé qu'une invasion d'extraterrestres était imminente."
        ],
        "Conjoint" => [
            "Je préparais une surprise tellement énorme en coulisses que j'ai dû feindre l'oubli total pour ne pas éveiller tes soupçons.",
            "J'ai croisé un magicien de rue qui m'a hypnotisé pendant 3 heures pour me faire croire que j'étais un flamant rose.",
            "Mon GPS m'a indiqué un raccourci qui passait littéralement à travers une brocante de quartier où j'ai été retenu comme négociateur.",
            "Je suis parti acheter du pain et j'ai dû secourir un chaton coincé dans un distributeur de billets."
        ],
        "Amis" => [
            "Je ne peux pas venir, je suis actuellement en train de négocier un traité de paix diplomatique entre mon grille-pain et mon micro-ondes.",
            "Mon appartement s'est transformé en escape game improvisé parce que mon serrurier a perdu les clés de l'intérieur.",
            "Une fuite d'eau massive chez le voisin du dessus me force à effectuer une session d'aviron d'urgence dans mon salon.",
            "Mon chat a décidé de s'endormir sur mes jambes, la loi internationale m'interdit formellement de me lever."
        ],
        "Professeur" => [
            "Une mise à jour forcée du système d'exploitation a redémarré mon PC et corrompu le secteur de boot au moment exact où j'allais soumettre le projet.",
            "Mon imprimante s'est mise à imprimer le travail en hiéroglyphes égyptiens suite à un problème de pilote inexpliqué.",
            "Mon chien n'a pas mangé mon devoir, mais il l'a accidentellement envoyé dans la corbeille avant de vider celle-ci avec sa patte.",
            "Le Wi-Fi de ma résidence a été désactivé par sécurité suite à un signal suspect émanant d'une station spatiale."
        ]
    ];

    // Trouver le groupe le plus pertinent ou utiliser Amis par défaut
    $categoryKey = "Amis";
    foreach (array_keys($fallbackTemplates) as $key) {
        if (stripos($target, $key) !== false) {
            $categoryKey = $key;
            break;
        }
    }

    $list = $fallbackTemplates[$categoryKey];
    $baseText = $list[array_rand($list)];

    // Adapter légèrement selon le sujet si spécifié
    if ($subject !== 'Retard impromptu' && rand(0, 1) === 1) {
        $generatedAlibi = "Concernant \"$subject\" : " . mb_strtolower(mb_substr($baseText, 0, 1)) . mb_substr($baseText, 1);
    } else {
        $generatedAlibi = $baseText;
    }
}

// Répondre avec l'alibi généré ainsi que les détails de débogage pour comprendre l'intégration de l'API
echo json_encode([
    'success' => true,
    'alibi' => $generatedAlibi,
    'subject' => $subject,
    'target' => $target,
    'vibe' => $vibe,
    'debug_info' => [
        'api_key_provided' => !empty(GEMINI_API_KEY),
        'model_used' => GEMINI_MODEL,
        'used_fallback' => $usedFallback,
        'http_code' => isset($httpCode) ? $httpCode : null,
        'raw_api_response' => isset($response) ? json_decode($response, true) : null,
        'payload_sent' => isset($payload) ? $payload : null,
        'curl_error' => isset($curlError) ? $curlError : null
    ]
], JSON_UNESCAPED_UNICODE);
