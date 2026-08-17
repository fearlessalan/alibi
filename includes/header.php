<?php
if (!defined('CURRENT_PAGE')) {
    define('CURRENT_PAGE', 'home');
}
?>
<!DOCTYPE html>
<html lang="fr" class="light">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Alibi.com - L'art de l'esquive par IA</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="assets/logo min.svg"/>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin=""/>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@600&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet"/>
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "on-tertiary-container": "#fffbff",
                    "primary-fixed": "#e9ddff",
                    "primary-fixed-dim": "#d0bcff",
                    "on-secondary-fixed-variant": "#005236",
                    "on-primary-container": "#fffbff",
                    "secondary-fixed-dim": "#4edea3",
                    "surface": "#fcf8ff",
                    "surface-tint": "#6d3bd7",
                    "tertiary-container": "#c0488a",
                    "outline": "#7b7486",
                    "on-tertiary-fixed": "#3d0026",
                    "on-primary": "#ffffff",
                    "secondary": "#006c49",
                    "on-secondary-fixed": "#002113",
                    "surface-dim": "#dbd8e7",
                    "error-container": "#ffdad6",
                    "surface-variant": "#e3e1ef",
                    "surface-container": "#efecfb",
                    "on-tertiary-fixed-variant": "#85145a",
                    "tertiary": "#a12e70",
                    "tertiary-fixed": "#ffd8e7",
                    "secondary-container": "#6cf8bb",
                    "on-primary-fixed-variant": "#5516be",
                    "on-error-container": "#93000a",
                    "on-error": "#ffffff",
                    "on-secondary": "#ffffff",
                    "on-tertiary": "#ffffff",
                    "on-surface": "#1b1b25",
                    "error": "#ba1a1a",
                    "inverse-surface": "#302f3a",
                    "primary": "#6b38d4",
                    "secondary-fixed": "#6ffbbe",
                    "on-background": "#1b1b25",
                    "surface-container-low": "#f5f2ff",
                    "on-secondary-container": "#00714d",
                    "outline-variant": "#cbc3d7",
                    "surface-bright": "#fcf8ff",
                    "background": "#fcf8ff",
                    "surface-container-lowest": "#ffffff",
                    "surface-container-highest": "#e3e1ef",
                    "inverse-on-surface": "#f2effe",
                    "tertiary-fixed-dim": "#ffafd3",
                    "inverse-primary": "#d0bcff",
                    "on-primary-fixed": "#23005c",
                    "surface-container-high": "#e9e6f5",
                    "primary-container": "#8455ef",
                    "on-surface-variant": "#494454"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "lg": "40px",
                    "base": "4px",
                    "xl": "64px",
                    "md": "24px",
                    "sm": "16px",
                    "container-max": "1200px",
                    "xs": "8px",
                    "gutter": "20px"
            },
            "fontFamily": {
                    "display-lg-mobile": ["Plus Jakarta Sans"],
                    "headline-md": ["Plus Jakarta Sans"],
                    "display-lg": ["Plus Jakarta Sans"],
                    "label-caps": ["JetBrains Mono"],
                    "body-lg": ["Hanken Grotesk"],
                    "body-md": ["Hanken Grotesk"]
            },
            "fontSize": {
                    "display-lg-mobile": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "800"}],
                    "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "700"}],
                    "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "800"}],
                    "label-caps": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                    "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                    "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}]
            }
          }
        }
      }
    </script>
    <style>
        .material-symbols-outlined {
          font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .icon-fill {
          font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .typewriter {
            font-family: 'JetBrains Mono', monospace;
        }
        input[type=range] {
            -webkit-appearance: none;
            width: 100%;
            background: transparent;
        }
        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 24px;
            width: 24px;
            border-radius: 50%;
            background: #ffffff;
            cursor: pointer;
            margin-top: -8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 2px solid #6b38d4;
            transition: transform 0.15s ease;
        }
        input[type=range]::-webkit-slider-thumb:hover {
            transform: scale(1.15);
        }
        input[type=range]::-webkit-slider-runnable-track {
            width: 100%;
            height: 8px;
            cursor: pointer;
            background: linear-gradient(to right, #6cf8bb, #8455ef, #ffdad6);
            border-radius: 4px;
        }
        .bouncy-hover:hover {
            transform: translateY(-2px) rotate(-0.5deg);
            box-shadow: 0 10px 25px -5px rgba(107, 56, 212, 0.4);
        }
    </style>
</head>
<body class="bg-surface text-on-surface min-h-screen flex flex-col font-body-md antialiased overflow-x-hidden selection:bg-primary-fixed-dim selection:text-on-primary-fixed">

<!-- TopNavBar -->
<nav class="w-full top-0 sticky shadow-sm bg-surface/80 backdrop-blur-md z-50">
    <div class="flex justify-between items-center max-w-container-max mx-auto px-md py-sm">
        <!-- Brand -->
        <a href="index.php" class="flex items-center cursor-pointer active:scale-95 transition-transform">
            <img src="assets/logo.svg" alt="Alibi.com" class="h-10 w-auto object-contain" />
        </a>

        <!-- Nav Links (Desktop) -->
        <div class="hidden md:flex items-center gap-md">
            <a class="<?php echo CURRENT_PAGE === 'labo' ? 'text-primary font-bold border-b-2 border-primary pb-1' : 'text-on-surface-variant font-body-md hover:text-primary'; ?> hover:scale-105 transition-transform duration-200" href="index.php">Labo du Chaos</a>
            <a class="<?php echo CURRENT_PAGE === 'alibis' ? 'text-primary font-bold border-b-2 border-primary pb-1' : 'text-on-surface-variant font-body-md hover:text-primary'; ?> hover:scale-105 transition-transform duration-200" href="mes-alibis.php">Mes Alibis</a>
            <a class="<?php echo CURRENT_PAGE === 'classement' ? 'text-primary font-bold border-b-2 border-primary pb-1' : 'text-on-surface-variant font-body-md hover:text-primary'; ?> hover:scale-105 transition-transform duration-200" href="classement.php">Classement</a>
        </div>

        <!-- Action -->
        <button id="premiumBtn" class="hidden md:flex bg-primary text-on-primary px-sm py-xs rounded-lg font-bold hover:-translate-y-[2px] hover:shadow-[0px_10px_30px_rgba(139,92,246,0.2)] transition-all">
            Passer Premium
        </button>

        <!-- Mobile Menu Toggle -->
        <button id="mobileMenuToggle" class="md:hidden text-primary p-xs rounded-md hover:bg-surface-variant">
            <span class="material-symbols-outlined text-[28px]">menu</span>
        </button>
    </div>

    <!-- Mobile Dropdown Menu -->
    <div id="mobileMenu" class="hidden md:hidden bg-surface-container border-b border-outline-variant px-md py-sm flex flex-col gap-sm">
        <a class="text-on-surface py-2 font-bold flex items-center gap-2" href="index.php">
            <span class="material-symbols-outlined">science</span> Labo du Chaos
        </a>
        <a class="text-on-surface py-2 font-bold flex items-center gap-2" href="mes-alibis.php">
            <span class="material-symbols-outlined">bookmark</span> Mes Alibis
        </a>
        <a class="text-on-surface py-2 font-bold flex items-center gap-2" href="classement.php">
            <span class="material-symbols-outlined">leaderboard</span> Classement
        </a>
    </div>
</nav>
