<?php
define('CURRENT_PAGE', 'classement');
require_once __DIR__ . '/includes/header.php';
?>

<!-- Main Content Canvas -->
<main class="flex-grow max-w-container-max mx-auto w-full px-xl py-3xl">
    <!-- Hero Band -->
    <div class="text-center mb-3xl">
        <p class="font-display font-medium text-[14px] text-ink uppercase tracking-[1px] mb-xs">
            LEADERBOARD OFFICIEL
        </p>
        <h1 class="font-display font-medium text-[40px] md:text-[48px] text-ink mb-sm">
            Classement des Génies
        </h1>
        <p class="text-[18px] text-body max-w-2xl mx-auto">
            Découvrez les maîtres absolus de l'esquive. Ceux dont les alibis sont si improbables qu'ils en deviennent incontestables.
        </p>
    </div>

    <!-- Leaderboard Container (card-content: bg-canvas-soft, border 1px mute/30, rounded-md 12px) -->
    <div class="bg-canvas-soft rounded-md p-xl border border-mute/30 max-w-4xl mx-auto shadow-sm">
        <!-- Header Row (ex-data-table-cell: mono-caps eyebrow typography) -->
        <div class="flex items-center px-lg py-md border-b border-mute/30 font-display font-medium text-[14px] uppercase tracking-[1px] text-body-mid mb-sm hidden sm:flex">
            <div class="w-16 text-center">Rang</div>
            <div class="flex-grow pl-md">Génie de l'Esquive</div>
            <div class="w-48 text-right pr-sm">Score de Créativité</div>
        </div>

        <div id="leaderboardList" class="flex flex-col gap-sm">
            <!-- Injecté dynamiquement par JS -->
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    const leaderboardList = document.getElementById('leaderboardList');

    try {
        const res = await fetch('api/leaderboard.php');
        const data = await res.json();
        
        if (data.success && data.leaderboard) {
            leaderboardList.innerHTML = '';
            data.leaderboard.forEach(item => {
                const row = document.createElement('div');
                
                let isTop1 = item.rank === 1;
                let bgClass = isTop1 
                    ? "bg-canvas border border-primary/30 shadow-sm" 
                    : "bg-canvas/60 hover:bg-canvas border border-mute/20 transition-colors";
                let rankClass = isTop1 
                    ? "text-primary text-[28px] font-bold font-display" 
                    : (item.rank <= 3 ? "text-ink text-[22px] font-bold font-display" : "text-body-mid text-[18px] font-medium");

                let avatarHtml = '';
                if (item.avatar) {
                    avatarHtml = `<img class="w-full h-full object-cover" src="${item.avatar}" alt="${item.name}">`;
                } else {
                    avatarHtml = `<span class="text-ink text-sm font-semibold">${item.initial || item.name.charAt(0)}</span>`;
                }

                row.className = `flex items-center p-md rounded-md ${bgClass} transition-transform hover:-translate-y-0.5`;
                row.innerHTML = `
                    <div class="w-12 sm:w-16 text-center ${rankClass}">${item.rank}</div>
                    <div class="flex-grow flex items-center gap-md pl-xs sm:pl-md">
                        <div class="w-10 h-10 rounded-full bg-canvas-soft flex items-center justify-center font-bold overflow-hidden border border-mute/40">
                            ${avatarHtml}
                        </div>
                        <div>
                            <div class="font-semibold text-[18px] text-ink">${item.name}</div>
                            <div class="text-[14px] text-body flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] ${isTop1 ? 'text-primary' : 'text-body-mid'}">${isTop1 ? 'military_tech' : 'verified'}</span> ${item.title}
                            </div>
                        </div>
                    </div>
                    <div class="w-32 sm:w-48 text-right font-display text-[20px] ${isTop1 ? 'text-primary font-semibold' : 'text-ink font-semibold'} pr-sm">
                        ${item.score}
                    </div>
                `;
                leaderboardList.appendChild(row);
            });
        }
    } catch (e) {
        console.error(e);
    }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
