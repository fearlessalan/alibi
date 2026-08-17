<?php
define('CURRENT_PAGE', 'labo');
require_once __DIR__ . '/includes/header.php';
?>

<!-- Main Content Canvas -->
<main class="flex-grow flex flex-col items-center px-gutter py-lg max-w-container-max mx-auto w-full">

    <!-- Hero Section -->
    <div class="text-center mb-xl w-full max-w-3xl">
        <h1 class="font-display-lg-mobile text-display-lg-mobile md:font-display-lg md:text-display-lg text-primary mb-4 leading-tight">
            Échappez à tout. Instantanément.
        </h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">
            Des mensonges générés par l'IA si crédibles que vous finirez par y croire. Promis, on ne juge pas.
        </p>
    </div>

    <!-- Generator Card -->
    <div class="w-full rounded-xl overflow-hidden flex flex-col md:flex-row relative z-10 bg-surface-container-lowest shadow-[0px_10px_30px_rgba(139,92,246,0.08)] border border-outline-variant/30">
        
        <!-- Left Side: Controls -->
        <div class="w-full md:w-5/12 p-8 md:p-10 border-b md:border-b-0 md:border-r border-outline-variant/30 flex flex-col gap-6 relative z-10 bg-surface-container-low/30">
            <h2 class="font-headline-md text-headline-md text-on-surface mb-2 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">tune</span>
                Paramétrer le Chaos
            </h2>

            <!-- Target Dropdown & Subject Input -->
            <div class="flex flex-col gap-2">
                <label for="subjectInput" class="font-label-caps text-label-caps text-on-surface-variant uppercase">LE SUJET DE L'EXCUSE</label>
                <input id="subjectInput" type="text" class="w-full bg-surface-container border-none text-on-surface py-3 px-4 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none font-body-md shadow-inner transition-shadow" placeholder="Ex: Retard en réunion, Oubli d'anniversaire, Devoir..."/>
            </div>

            <div class="flex flex-col gap-2">
                <label for="targetSelect" class="font-label-caps text-label-caps text-on-surface-variant uppercase">À QUI MENT-ON ?</label>
                <div class="relative">
                    <select id="targetSelect" class="w-full appearance-none bg-surface-container border-none text-on-surface py-3 px-4 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none font-body-md shadow-inner transition-shadow pr-10">
                        <option value="Patron">Patron (Crédibilité maximale requise)</option>
                        <option value="Conjoint">Conjoint (Nécessite tact & surprise)</option>
                        <option value="Amis">Amis (Refus amical mais ferme)</option>
                        <option value="Professeur">Professeur (Historique technique flou)</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-3 text-outline pointer-events-none">expand_more</span>
                </div>
            </div>

            <!-- Vibe Slider -->
            <div class="flex flex-col gap-4 mt-2">
                <div class="flex justify-between items-center">
                    <label for="vibeRange" class="font-label-caps text-label-caps text-on-surface-variant uppercase">L'AMBIANCE (NIVEAU DE RISQUE)</label>
                    <span id="vibeBadge" class="text-xs font-bold text-tertiary px-2 py-0.5 bg-tertiary-fixed rounded-md">Scandaleux (75%)</span>
                </div>
                <input id="vibeRange" type="range" min="1" max="100" value="75"/>
                <div class="flex justify-between text-xs text-outline-variant font-medium">
                    <span>Sobriété Pro</span>
                    <span>Équilibré</span>
                    <span>Délirant / Absurde</span>
                </div>
            </div>

            <!-- Generate Button -->
            <button id="generateBtn" class="mt-6 bg-primary text-on-primary py-4 px-6 rounded-xl font-headline-md text-[18px] font-bold bouncy-hover transition-all flex items-center justify-center gap-2 group w-full shadow-lg">
                <span id="magicIcon" class="material-symbols-outlined group-hover:rotate-180 transition-transform duration-500">magic_button</span>
                <span id="btnText">Invoquer l'Alibi</span>
            </button>
        </div>

        <!-- Right Side: Preview/Result -->
        <div class="w-full md:w-7/12 p-8 md:p-10 relative z-10 flex flex-col justify-between min-h-[420px] bg-surface-container-lowest">
            <div class="flex justify-between items-start mb-6">
                <span class="text-outline-variant material-symbols-outlined text-[36px]">format_quote</span>
            </div>

            <!-- Excuse Text Display -->
            <div class="flex-grow flex flex-col items-center justify-center py-6 px-2">
                <p id="alibiText" class="typewriter text-[20px] md:text-[26px] leading-relaxed text-on-surface font-medium italic text-center max-w-xl">
                    "Je ne peux pas venir, je suis actuellement en train de négocier un traité de paix diplomatique entre mon grille-pain et mon micro-ondes."
                </p>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4 mt-6 justify-center">
                <button id="copyAlibiBtn" class="flex-1 bg-surface-container hover:bg-surface-variant text-on-surface py-3 px-6 rounded-lg font-label-caps text-label-caps flex items-center justify-center gap-2 transition-all border border-outline-variant/50">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">content_copy</span>
                    <span>Copier l'Alibi</span>
                </button>
                <button id="saveAlibiBtn" class="flex-1 bg-primary-fixed hover:bg-primary-fixed-dim text-on-primary-fixed py-3 px-6 rounded-lg font-label-caps text-label-caps flex items-center justify-center gap-2 transition-all border border-primary/20">
                    <span class="material-symbols-outlined">bookmark_add</span>
                    <span>Sauvegarder</span>
                </button>
            </div>
        </div>

    </div>

</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const vibeRange = document.getElementById('vibeRange');
    const vibeBadge = document.getElementById('vibeBadge');
    const generateBtn = document.getElementById('generateBtn');
    const magicIcon = document.getElementById('magicIcon');
    const btnText = document.getElementById('btnText');
    const alibiText = document.getElementById('alibiText');
    const subjectInput = document.getElementById('subjectInput');
    const targetSelect = document.getElementById('targetSelect');
    const copyAlibiBtn = document.getElementById('copyAlibiBtn');
    const saveAlibiBtn = document.getElementById('saveAlibiBtn');

    let currentAlibiObj = {
        subject: "Absence imprévue",
        target: "Amis",
        vibe: 75,
        text: alibiText.innerText.replace(/^"|"$/g, '')
    };

    // Mise à jour de l'étiquette Vibe
    vibeRange.addEventListener('input', (e) => {
        const val = e.target.value;
        let label = "Équilibré";
        if (val < 35) label = "Sobre & Pro";
        else if (val > 70) label = "Scandaleux / Délirant";
        
        vibeBadge.innerText = `${label} (${val}%)`;
    });

    // Générer un Alibi via l'API Gemini / Gemma PHP
    generateBtn.addEventListener('click', async () => {
        // État de chargement
        magicIcon.classList.add('animate-spin');
        btnText.innerText = "Invoqueur en cours...";
        generateBtn.disabled = true;

        try {
            const res = await fetch('api/generate.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    subject: subjectInput.value,
                    target: targetSelect.value,
                    vibe: vibeRange.value
                })
            });

            const data = await res.json();
            console.log("=== [ALIBI GENIE API DEBUG LOGS] ===", data.debug_info);

            if (data.success && data.alibi) {
                alibiText.innerText = `"${data.alibi}"`;
                currentAlibiObj = {
                    subject: data.subject || subjectInput.value || "L'art de l'esquive",
                    target: data.target || targetSelect.value,
                    vibe: data.vibe || vibeRange.value,
                    text: data.alibi
                };
                showToast("Nouvel alibi généré avec succès !");
            }
        } catch (err) {
            console.error(err);
            showToast("Erreur lors de la génération de l'alibi", "error");
        } finally {
            magicIcon.classList.remove('animate-spin');
            btnText.innerText = "Invoquer l'Alibi";
            generateBtn.disabled = false;
        }
    });

    // Copier l'alibi dans le presse-papier
    copyAlibiBtn.addEventListener('click', () => {
        const textToCopy = alibiText.innerText.replace(/^"|"$/g, '');
        navigator.clipboard.writeText(textToCopy);
        
        const origContent = copyAlibiBtn.innerHTML;
        copyAlibiBtn.className = "flex-1 bg-secondary-container text-on-secondary-container py-3 px-6 rounded-lg font-label-caps text-label-caps flex items-center justify-center gap-2 transition-all border border-secondary shadow-md";
        copyAlibiBtn.innerHTML = `<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span><span>Sécurisé !</span>`;

        showToast("Alibi copié dans le presse-papier !");

        setTimeout(() => {
            copyAlibiBtn.className = "flex-1 bg-surface-container hover:bg-surface-variant text-on-surface py-3 px-6 rounded-lg font-label-caps text-label-caps flex items-center justify-center gap-2 transition-all border border-outline-variant/50";
            copyAlibiBtn.innerHTML = origContent;
        }, 2000);
    });

    // Sauvegarder dans "Mes Alibis"
    saveAlibiBtn.addEventListener('click', async () => {
        try {
            const res = await fetch('api/alibis.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(currentAlibiObj)
            });
            const data = await res.json();
            if (data.success) {
                showToast("Alibi archivé dans vos Alibis !");
            }
        } catch (err) {
            showToast("Erreur d'archivage", "error");
        }
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
