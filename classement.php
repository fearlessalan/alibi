<?php
define('CURRENT_PAGE', 'classement');
require_once __DIR__ . '/includes/header.php';
?>

<!-- Main Content Canvas -->
<main class="flex-grow max-w-container-max mx-auto w-full px-gutter md:px-md py-xl">
    <div class="text-center mb-xl">
        <h1 class="font-display-lg text-display-lg text-primary mb-sm">Classement des Génies</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">
            Découvrez les maîtres absolus de l'esquive. Ceux dont les alibis sont si improbables qu'ils en deviennent incontestables.
        </p>
    </div>

    <!-- Leaderboard Container -->
    <div class="bg-surface-container-lowest rounded-xl p-md shadow-[0px_10px_30px_rgba(139,92,246,0.08)] border border-outline-variant/30 max-w-4xl mx-auto">
        <!-- Header Row -->
        <div class="flex items-center px-sm py-xs border-b border-surface-variant text-label-caps font-label-caps text-on-surface-variant mb-xs hidden sm:flex">
            <div class="w-16 text-center">Rang</div>
            <div class="flex-grow pl-md">Génie de l'Esquive</div>
            <div class="w-48 text-right pr-sm">Score de Créativité</div>
        </div>

        <div id="leaderboardList" class="flex flex-col gap-xs">
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
                
                let isTop3 = item.rank <= 3;
                let bgClass = isTop3 && item.rank === 1 ? "bg-surface-container-low border border-primary/20 shadow-sm" : "hover:bg-surface-container transition-colors";
                let rankClass = item.rank === 1 ? "text-primary text-[28px] font-extrabold" : (item.rank <= 3 ? "text-outline text-[24px] font-bold" : "text-outline-variant text-[18px]");

                let avatarHtml = '';
                if (item.avatar) {
                    avatarHtml = `<img class="w-full h-full object-cover" src="${item.avatar}" alt="${item.name}">`;
                } else {
                    avatarHtml = `<span class="text-on-surface-variant text-sm font-bold">${item.initial || item.name.charAt(0)}</span>`;
                }

                row.className = `flex items-center p-sm rounded-lg ${bgClass} transition-transform hover:-translate-y-0.5`;
                row.innerHTML = `
                    <div class="w-12 sm:w-16 text-center font-display-lg-mobile ${rankClass}">${item.rank}</div>
                    <div class="flex-grow flex items-center gap-sm pl-xs sm:pl-md">
                        <div class="w-10 h-10 rounded-full bg-surface-variant flex items-center justify-center font-bold overflow-hidden shadow-inner border border-outline-variant/30">
                            ${avatarHtml}
                        </div>
                        <div>
                            <div class="font-headline-md text-headline-md text-on-surface">${item.name}</div>
                            <div class="text-label-caps font-label-caps text-secondary flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">${item.rank === 1 ? 'military_tech' : 'verified'}</span> ${item.title}
                            </div>
                        </div>
                    </div>
                    <div class="w-32 sm:w-48 text-right font-headline-md text-headline-md ${item.rank === 1 ? 'text-primary font-black' : 'text-on-surface-variant'} pr-sm">
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
