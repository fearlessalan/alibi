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

    <!-- Google Fonts: Inter & Mona Sans for Display substitute -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin=""/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Mona+Sans:wght@500;600;700&display=swap" rel="stylesheet"/>
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              primary: "#ff4f00", // Zapier Orange
              "on-primary": "#fffefb",
              canvas: "#fffefb", // Warm Off-White
              "canvas-soft": "#f8f4f0", // Cream-tinted soft surface
              ink: "#201515", // Deep Coffee Ink
              "ink-soft": "#2f2a26",
              "ink-mid": "#36342e",
              body: "#605d52",
              "body-mid": "#939084",
              mute: "#c5c0b1",
              error: "#dc2626",
            },
            borderRadius: {
              none: "0px",
              sm: "6px",
              md: "12px", // Brand Canonical Radius
              pill: "9999px",
              full: "9999px",
            },
            spacing: {
              xxs: "2px",
              xs: "4px",
              sm: "8px",
              md: "12px",
              lg: "16px",
              xl: "24px",
              "2xl": "32px",
              "3xl": "48px",
              "4xl": "64px",
              "container-max": "1280px",
            },
            fontFamily: {
              display: ["'Mona Sans'", "'Inter'", "sans-serif"],
              sans: ["'Inter'", "sans-serif"],
            },
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
            background: #ff4f00;
            cursor: pointer;
            margin-top: -8px;
            border: 2px solid #fffefb;
            box-shadow: 0 2px 4px rgba(32, 21, 21, 0.15);
            transition: transform 0.15s ease;
        }
        input[type=range]::-webkit-slider-thumb:hover {
            transform: scale(1.15);
        }
        input[type=range]::-webkit-slider-runnable-track {
            width: 100%;
            height: 8px;
            cursor: pointer;
            background: linear-gradient(to right, #c5c0b1, #ff4f00);
            border-radius: 6px;
        }
        .bouncy-hover {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .bouncy-hover:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-canvas text-ink min-h-screen flex flex-col font-sans antialiased selection:bg-primary selection:text-on-primary">

<!-- Nav-bar (sticky top nav: background canvas, text ink, padding md xl) -->
<nav class="w-full top-0 sticky bg-canvas/90 backdrop-blur-md z-50 border-b border-canvas-soft">
    <div class="flex justify-between items-center max-w-container-max mx-auto px-xl py-md">
        <!-- Brand -->
        <a href="index.php" class="flex items-center cursor-pointer active:scale-95 transition-transform gap-2">
            <img src="assets/logo.svg" alt="Alibi.com" class="h-9 w-auto object-contain" />
        </a>

        <!-- Nav Links (Desktop) -->
        <div class="hidden md:flex items-center gap-xl">
            <a class="<?php echo CURRENT_PAGE === 'labo' ? 'text-ink font-bold border-b-2 border-primary pb-1' : 'text-body hover:text-ink font-medium'; ?> transition-colors" href="index.php">Labo du Chaos</a>
            <a class="<?php echo CURRENT_PAGE === 'alibis' ? 'text-ink font-bold border-b-2 border-primary pb-1' : 'text-body hover:text-ink font-medium'; ?> transition-colors" href="mes-alibis.php">Mes Alibis</a>
            <a class="<?php echo CURRENT_PAGE === 'classement' ? 'text-ink font-bold border-b-2 border-primary pb-1' : 'text-body hover:text-ink font-medium'; ?> transition-colors" href="classement.php">Classement</a>
        </div>

        <!-- Mobile Menu Toggle -->
        <button id="mobileMenuToggle" class="md:hidden text-ink p-sm rounded-md hover:bg-canvas-soft">
            <span class="material-symbols-outlined text-[28px]">menu</span>
        </button>
    </div>

    <!-- Mobile Dropdown Menu -->
    <div id="mobileMenu" class="hidden md:hidden bg-canvas-soft border-b border-mute/30 px-xl py-lg flex flex-col gap-md">
        <a class="text-ink py-1 font-semibold flex items-center gap-2" href="index.php">
            <span class="material-symbols-outlined">science</span> Labo du Chaos
        </a>
        <a class="text-ink py-1 font-semibold flex items-center gap-2" href="mes-alibis.php">
            <span class="material-symbols-outlined">bookmark</span> Mes Alibis
        </a>
        <a class="text-ink py-1 font-semibold flex items-center gap-2" href="classement.php">
            <span class="material-symbols-outlined">leaderboard</span> Classement
        </a>
    </div>
</nav>
