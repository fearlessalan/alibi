<?php
// Configuration globale Alibi Genie

// Remplacez par votre clé API Gemini si disponible, ou via variable d'environnement GEMINI_API_KEY
define('GEMINI_API_KEY', getenv('GEMINI_API_KEY') ?: '');
define('GEMINI_MODEL', 'gemini-flash-lite-latest'); // Ou 'gemma-2-9b-it' via l'API Google AI

define('DATA_DIR', __DIR__ . '/data');
define('ALIBIS_FILE', DATA_DIR . '/alibis.json');
define('LEADERBOARD_FILE', DATA_DIR . '/leaderboard.json');

// S'assurer que le dossier data existe
if (!file_exists(DATA_DIR)) {
    mkdir(DATA_DIR, 0777, true);
}

// Initialiser les données d'alibis par défaut s'il n'y en a pas
if (!file_exists(ALIBIS_FILE)) {
    $defaultAlibis = [
        [
            "id" => "alibi_1",
            "subject" => "Retard au Bureau",
            "target" => "Patron",
            "vibe" => 75,
            "text" => "Mon chat a avalé mes clés de voiture en jouant, on est actuellement aux urgences vétérinaires pour une extraction d'urgence.",
            "date" => "Aujourd'hui",
            "timestamp" => time()
        ],
        [
            "id" => "alibi_2",
            "subject" => "Oubli Anniversaire",
            "target" => "Conjoint",
            "vibe" => 85,
            "text" => "Je préparais une surprise tellement énorme en coulisses que j'ai dû feindre l'oubli total pour ne pas éveiller tes soupçons. Surprise reportée pour des raisons logistiques.",
            "date" => "Hier",
            "timestamp" => time() - 86400
        ],
        [
            "id" => "alibi_3",
            "subject" => "Annulation Soirée",
            "target" => "Amis",
            "vibe" => 60,
            "text" => "Une fuite d'eau massive chez le voisin du dessus menace mon plafond, je dois rester écoper avec des casseroles en attendant le plombier.",
            "date" => "Lun. 12 Oct",
            "timestamp" => time() - 172800
        ],
        [
            "id" => "alibi_4",
            "subject" => "Devoir Non Rendu",
            "target" => "Professeur",
            "vibe" => 90,
            "text" => "Une mise à jour forcée de Windows a redémarré mon PC et corrompu le secteur de boot exactement au moment où j'allais cliquer sur 'Envoyer'.",
            "date" => "Semaine Dernière",
            "timestamp" => time() - 604800
        ]
    ];
    file_put_contents(ALIBIS_FILE, json_encode($defaultAlibis, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Initialiser le classement par défaut
if (!file_exists(LEADERBOARD_FILE)) {
    $defaultLeaderboard = [
        [
            "rank" => 1,
            "name" => "Chrs",
            "title" => "Légende",
            "score" => "9,850",
            "avatar" => "https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80"
        ],
        [
            "rank" => 2,
            "name" => "TDC",
            "title" => "Expert",
            "score" => "8,420",
            "avatar" => "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80"
        ],
        [
            "rank" => 3,
            "name" => "Moses",
            "title" => "Vétéran",
            "score" => "7,600",
            "avatar" => "https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=150&q=80"
        ],
        [
            "rank" => 4,
            "name" => "Doubtlesss",
            "title" => "Initié",
            "score" => "6,540",
            "initial" => "D"
        ],
        [
            "rank" => 5,
            "name" => "Cauchy",
            "title" => "Apprenti",
            "score" => "5,900",
            "initial" => "C"
        ]
    ];
    file_put_contents(LEADERBOARD_FILE, json_encode($defaultLeaderboard, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
