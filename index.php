<?php
define('CURRENT_PAGE', 'labo');
require_once __DIR__ . '/includes/header.php';
?>

<!-- Main Content Canvas -->
<main class="flex-grow flex flex-col items-center max-w-container-max mx-auto w-full px-xl py-3xl">

    <!-- Hero Band -->
    <div class="text-center mb-3xl w-full max-w-3xl">
        <p class="font-display font-medium text-[14px] text-ink uppercase tracking-[1px] mb-md">
            GÉNÉRATEUR D'EXCUSES ET D'ALIBIS SUPRÊMES
        </p>
        <h1 class="font-display font-medium text-[40px] md:text-[56px] leading-[1.05] text-ink mb-lg">
            Échappez à tout. Instantanément.
        </h1>
        <p class="text-[20px] leading-[30px] text-body max-w-2xl mx-auto font-normal">
            Des mensonges générés par l'IA si crédibles que vous finirez par y croire. Promis, on ne juge pas.
        </p>
    </div>

    <!-- Generator Card (card-content: bg canvas-soft, text ink, rounded-md 12px, padding xl) -->
    <div class="w-full rounded-md overflow-hidden flex flex-col md:flex-row relative z-10 bg-canvas-soft border border-mute/30 shadow-sm">
        
        <!-- Left Side: Controls -->
        <div class="w-full md:w-5/12 p-xl md:p-3xl border-b md:border-b-0 md:border-r border-mute/30 flex flex-col gap-xl">
            <h2 class="font-display font-medium text-[24px] text-ink flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">tune</span>
                Paramétrer le Chaos
            </h2>

            <!-- Target Dropdown & Subject Input -->
            <div class="flex flex-col gap-2">
                <label for="subjectInput" class="font-display font-medium text-[14px] text-ink uppercase tracking-[1px]">LE SUJET DE L'EXCUSE</label>
                <!-- text-input -->
                <input id="subjectInput" type="text" class="w-full bg-canvas border border-ink text-ink py-md px-lg rounded-sm focus:ring-2 focus:ring-primary focus:outline-none text-[16px]" placeholder="Ex: Retard en réunion, Oubli d'anniversaire, Devoir..."/>
            </div>

            <div class="flex flex-col gap-2">
                <label for="targetSelect" class="font-display font-medium text-[14px] text-ink uppercase tracking-[1px]">À QUI MENT-ON ?</label>
                <div class="relative">
                    <select id="targetSelect" class="w-full appearance-none bg-canvas border border-ink text-ink py-md px-lg rounded-sm focus:ring-2 focus:ring-primary focus:outline-none text-[16px] pr-10">
                        <option value="Patron">Patron (Crédibilité maximale requise)</option>
                        <option value="Conjoint">Conjoint (Nécessite tact & surprise)</option>
                        <option value="Amis">Amis (Refus amical mais ferme)</option>
                        <option value="Professeur">Professeur (Historique technique flou)</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-3 text-body-mid pointer-events-none">expand_more</span>
                </div>
            </div>

            <!-- Vibe Slider -->
            <div class="flex flex-col gap-md mt-2">
                <div class="flex justify-between items-center">
                    <label for="vibeRange" class="font-display font-medium text-[14px] text-ink uppercase tracking-[1px]">L'AMBIANCE (NIVEAU DE RISQUE)</label>
                    <span id="vibeBadge" class="text-[14px] font-semibold text-ink px-md py-xs bg-canvas rounded-pill border border-mute/50">Scandaleux (75%)</span>
                </div>
                <input id="vibeRange" type="range" min="1" max="100" value="75"/>
                <div class="flex justify-between text-[14px] text-body-mid font-normal">
                    <span>Sobriété Pro</span>
                    <span>Équilibré</span>
                    <span>Délirant</span>
                </div>
            </div>

            <!-- button-primary (Zapier Orange, rounded-md 12px) -->
            <button id="generateBtn" class="mt-xl bg-primary text-on-primary py-md px-xl rounded-md font-semibold text-[18px] bouncy-hover transition-all flex items-center justify-center gap-2 group w-full shadow-sm hover:opacity-95">
                <span id="magicIcon" class="material-symbols-outlined group-hover:scale-110 transition-transform duration-300">magic_button</span>
                <span id="btnText">Invoquer l'Alibi</span>
            </button>
        </div>

        <!-- Right Side: Preview/Result -->
        <div class="w-full md:w-7/12 p-xl md:p-3xl relative z-10 flex flex-col justify-between min-h-[420px] bg-canvas">
            <div class="flex justify-between items-start mb-lg">
                <span class="text-mute material-symbols-outlined text-[40px]">format_quote</span>
                <span class="font-display font-medium text-[14px] text-ink tracking-[1px] uppercase bg-canvas-soft px-md py-xs rounded-pill border border-mute/30">Aperçu direct</span>
            </div>

            <!-- Excuse Text Display -->
            <div class="flex-grow flex flex-col items-center justify-center py-xl px-2">
                <p id="alibiText" class="text-[20px] md:text-[24px] leading-[32px] text-ink font-normal italic text-center max-w-xl">
                    "Je ne peux pas venir, je suis actuellement en train de négocier un traité de paix diplomatique entre mon grille-pain et mon micro-ondes."
                </p>
            </div>

            <!-- Actions (button-tertiary & button-secondary) -->
            <div class="flex flex-col sm:flex-row gap-xl mt-xl justify-center">
                <!-- button-tertiary -->
                <button id="copyAlibiBtn" class="flex-1 bg-canvas hover:bg-canvas-soft text-ink py-md px-xl rounded-md font-semibold text-[16px] flex items-center justify-center gap-2 transition-all border border-ink shadow-sm">
                    <span class="material-symbols-outlined">content_copy</span>
                    <span>Copier l'Alibi</span>
                </button>
                <!-- button-secondary -->
                <button id="saveAlibiBtn" class="flex-1 bg-ink hover:bg-ink-soft text-on-primary py-md px-xl rounded-md font-semibold text-[16px] flex items-center justify-center gap-2 transition-all border border-ink shadow-sm">
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
        copyAlibiBtn.className = "flex-1 bg-ink text-on-primary py-md px-xl rounded-md font-semibold text-[16px] flex items-center justify-center gap-2 transition-all shadow-sm";
        copyAlibiBtn.innerHTML = `<span class="material-symbols-outlined">check_circle</span><span>Sécurisé !</span>`;

        showToast("Alibi copié dans le presse-papier !");

        setTimeout(() => {
            copyAlibiBtn.className = "flex-1 bg-canvas hover:bg-canvas-soft text-ink py-md px-xl rounded-md font-semibold text-[16px] flex items-center justify-center gap-2 transition-all border border-ink shadow-sm";
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
