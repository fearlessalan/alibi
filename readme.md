# 🎭 Alibi Genie — Le Générateur d'Alibis Incontestables

![logo](assets/logo.svg)

**Alibi Genie** (Alibi.com) est une application web moderne et élégante permettant de générer des alibis sur-mesure, crédibles et loufoques pour esquiver n'importe quelle situation délicate (réunions ennuyeuses, repas de famille, retards au travail, etc.).

---

## 🎨 Design System & Direction Artistique (Zapier Specs)

L'interface s'appuie sur une palette de couleurs aux tons neutres et chauds, associée à une typographie soignée et un système de composants harmonieux.

### 1. Palette de Couleurs (`tailwind.config`)

- **Canvas Principal (`canvas`)** : `#fffefb` — Crème très léger (fond principal).
- **Canvas Soft (`canvas-soft`)** : `#f8f4f0` — Crème doux pour les cartes de contenu et conteneurs.
- **Coffee Ink (`ink`)** : `#201515` — Noir café profond pour les textes principaux, les titres et le header/footer.
- **Zapier Orange (`primary`)** : `#ff4f00` — Orange saturé réservé exclusivement aux cibles de conversion et boutons CTA principaux.
- **Échelle Neutre Chaude** : `body` (`#605d52`), `body-mid` (`#939084`), et `mute` (`#c5c0b1`).

### 2. Typographie à Deux Voix

- **Headlines / Display** : **Mona Sans** (`font-display`) à graisse medium/semibold avec tracking d'en-tête (eyebrow).
- **Textes Courants & UI** : **Inter** (`font-sans`) pour tout le reste (corps de texte, boutons, formulaires, filtres).

### 3. Formes & Composants

- **Border Radius Signature (`rounded-md`)** : `12px` appliqué universellement aux cartes (`card-content`), conteneurs et boutons (`button-primary`, `button-secondary`).
- **Badges & Filtres (`badge-pill`)** : Formes en pilule (`rounded-full`) pour la sélection et l'état des filtres d'archives.

---

## 🚀 Fonctionnalités Principales

1. **Le Labo du Chaos (`index.php`)** :
   - Générateur d'alibis instantanés par thématiques (Travail, Amour, Famille, Soirée, Retard).
   - Curseurs interactifs pour régler le **Niveau de Gravité** et le **Degré de Crédibilité**.
   - Option de génération d'**Éléments de Preuve** synthétiques (capture SMS, e-mail fictif, ticket de caisse).
   - Copie en un clic avec retour visuel dynamique et notification Toast Zapier.

2. **Archives des Alibis (`mes-alibis.php`)** :
   - Historique des alibis générés avec filtrage dynamique par catégorie.
   - Indication du niveau d'improbabilité et des preuves associées sous forme de cartes structurées (`card-content`).

3. **Leaderboard Officiel (`classement.php`)** :
   - Classement des "Maitres Génies de l'Esquive".
   - Affichage dynamique des scores de créativité sous forme de rangs épurés.

---

## 🛠️ Architecture du Projet

```text
alibi/
├── api/
│   ├── generate-alibi.php   # API de génération d'alibis
│   ├── get-alibis.php       # API de récupération de l'historique
│   └── leaderboard.php      # API du classement des génies
├── assets/
│   ├── logo.svg             # Logo principal aux couleurs Zapier (#ff4f00 / #201515)
│   └── logo min.svg         # Emblème SVG épuré
├── data/
│   └── leaderboard.json     # Données JSON des utilisateurs du classement
├── includes/
│   ├── header.php           # En-tête global, CDN Tailwind avec tokens Zapier & Fonts
│   └── footer.php           # Pied de page sombre Coffee-Ink et système Toast JS
├── index.php                # Page d'accueil / Générateur interactif
├── mes-alibis.php           # Page d'historique des alibis
├── classement.php           # Page du classement officiel
└── readme.md                # Documentation du projet
```

---

## ⚡ Installation & Utilisation Locale

1. **Prérequis** :
   - Un serveur Web avec support **PHP 7.4+** (ou supérieur), par exemple Apache / Nginx ou via un environnement local comme WampServer, XAMPP, Laragon, ou le serveur PHP intégré.

2. **Lancement via le serveur PHP intégré** :

   ```bash
   cd /chemin/vers/alibi
   php -S localhost:8000
   ```

3. **Accès Web** :
   Ouvrez votre navigateur sur `http://localhost:8000`.

---

## 📄 Licence

Projet développé à des fins de démonstration et d'exploration UX/UI. Tous droits réservés.
