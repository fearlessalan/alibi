<?php
define('CURRENT_PAGE', 'alibis');
require_once __DIR__ . '/includes/header.php';
?>

<!-- Main Content Canvas -->
<main class="flex-grow max-w-container-max mx-auto w-full px-xl py-3xl">
    
    <!-- Header Band -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-3xl gap-xl">
        <div>
            <p class="font-display font-medium text-[14px] text-ink uppercase tracking-[1px] mb-xs">
                VOS ESQUIVES ENREGISTRÉES
            </p>
            <h1 class="font-display font-medium text-[40px] md:text-[48px] text-ink mb-xs">
                Archives du Crime Parfait
            </h1>
            <p class="text-[18px] text-body">
                Retrouvez et réutilisez vos meilleures esquives. Promis, on ne dira rien.
            </p>
        </div>
        
        <!-- Filter Tabs (badge-pill style) -->
        <div class="flex flex-wrap items-center gap-xs bg-canvas-soft p-1.5 rounded-pill border border-mute/30">
            <button data-filter="all" class="filter-btn active-filter px-lg py-xs rounded-pill text-[14px] font-semibold transition-all bg-primary text-on-primary shadow-sm">
                Tous
            </button>
            <button data-filter="Patron" class="filter-btn px-lg py-xs rounded-pill text-[14px] font-medium text-body hover:text-ink transition-all">
                Patron
            </button>
            <button data-filter="Conjoint" class="filter-btn px-lg py-xs rounded-pill text-[14px] font-medium text-body hover:text-ink transition-all">
                Conjoint
            </button>
            <button data-filter="Amis" class="filter-btn px-lg py-xs rounded-pill text-[14px] font-medium text-body hover:text-ink transition-all">
                Amis
            </button>
            <button data-filter="Professeur" class="filter-btn px-lg py-xs rounded-pill text-[14px] font-medium text-body hover:text-ink transition-all">
                Professeur
            </button>
        </div>
    </div>

    <!-- Alibi Grid Container -->
    <div id="alibiGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-xl">
        <!-- Rempli dynamiquement par JS -->
    </div>

</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let allAlibis = [];
    const alibiGrid = document.getElementById('alibiGrid');
    const filterBtns = document.querySelectorAll('.filter-btn');

    // Icônes par cible
    const targetIcons = {
        'Patron': 'work',
        'Conjoint': 'favorite',
        'Amis': 'groups',
        'Professeur': 'school'
    };

    async function loadAlibis() {
        try {
            const res = await fetch('api/alibis.php');
            const data = await res.json();
            if (data.success) {
                allAlibis = data.alibis;
                renderAlibis('all');
            }
        } catch (e) {
            console.error(e);
        }
    }

    function renderAlibis(filter = 'all') {
        alibiGrid.innerHTML = '';

        const filtered = filter === 'all' 
            ? allAlibis 
            : allAlibis.filter(a => a.target && a.target.toLowerCase().includes(filter.toLowerCase()));

        filtered.forEach(alibi => {
            const icon = targetIcons[alibi.target] || 'star';
            const card = document.createElement('div');
            // card-content (Zapier cream card): bg-canvas-soft, text-ink, padding xl (24px), rounded-md (12px)
            card.className = "bg-canvas-soft rounded-md p-xl flex flex-col border border-mute/30 hover:border-ink/40 transition-all duration-200 group shadow-sm";
            
            card.innerHTML = `
                <div class="flex justify-between items-start mb-md">
                    <div class="flex gap-xs items-center bg-canvas px-md py-xs rounded-pill text-[14px] font-medium text-ink border border-mute/30">
                        <span class="material-symbols-outlined text-[16px] text-primary">${icon}</span>
                        Cible : ${alibi.target}
                    </div>
                    <span class="text-[14px] text-body-mid">${alibi.date || 'Récents'}</span>
                </div>
                <h3 class="font-display font-medium text-[20px] text-ink mb-sm">${alibi.subject}</h3>
                <p class="text-[16px] leading-[24px] text-body mb-xl flex-grow italic">
                    "${alibi.text}"
                </p>
                <div class="flex justify-between items-center border-t border-mute/30 pt-md mt-auto">
                    <button class="delete-btn text-body hover:text-error p-xs rounded-sm transition-colors flex items-center justify-center" data-id="${alibi.id}">
                        <span class="material-symbols-outlined">delete</span>
                    </button>
                    <button class="copy-btn flex items-center gap-xs bg-ink text-on-primary hover:bg-ink-soft px-lg py-sm rounded-md font-semibold text-[14px] transition-colors" data-text="${alibi.text.replace(/"/g, '&quot;')}">
                        <span class="material-symbols-outlined text-[18px]">content_copy</span>
                        <span>Copier</span>
                    </button>
                </div>
            `;
            alibiGrid.appendChild(card);
        });

        // Ajouter la carte d'ajout "Besoin d'un nouveau mensonge ?"
        const addCard = document.createElement('a');
        addCard.href = "index.php";
        addCard.className = "bg-canvas border-2 border-dashed border-mute/60 rounded-md p-xl flex flex-col items-center justify-center text-center cursor-pointer hover:bg-canvas-soft hover:border-primary transition-all duration-200 min-h-[260px] group";
        addCard.innerHTML = `
            <div class="bg-canvas-soft p-md rounded-full text-primary mb-md group-hover:scale-105 transition-transform border border-mute/30">
                <span class="material-symbols-outlined text-[32px]">add_reaction</span>
            </div>
            <h3 class="font-display font-medium text-[20px] text-ink mb-xs">Besoin d'un nouveau mensonge ?</h3>
            <p class="text-[16px] text-body">Retournez au Labo du Chaos pour générer une nouvelle esquive magistrale.</p>
        `;
        alibiGrid.appendChild(addCard);

        // Attacher les écouteurs de copie et de suppression
        document.querySelectorAll('.copy-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const text = btn.getAttribute('data-text');
                navigator.clipboard.writeText(text);
                showToast("Alibi copié !");
                btn.innerHTML = `<span class="material-symbols-outlined text-[18px]">check_circle</span><span>Sécurisé !</span>`;
                setTimeout(() => {
                    btn.innerHTML = `<span class="material-symbols-outlined text-[18px]">content_copy</span><span>Copier</span>`;
                }, 2000);
            });
        });

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', async () => {
                const id = btn.getAttribute('data-id');
                if (confirm('Voulez-vous vraiment supprimer cet alibi ?')) {
                    try {
                        const res = await fetch('api/alibis.php', {
                            method: 'DELETE',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ id })
                        });
                        const resData = await res.json();
                        if (resData.success) {
                            showToast("Alibi supprimé");
                            loadAlibis();
                        }
                    } catch (err) {
                        showToast("Erreur de suppression", "error");
                    }
                }
            });
        });
    }

    // Gestion du filtre
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => {
                b.classList.remove('bg-primary', 'text-on-primary', 'shadow-sm', 'font-semibold');
                b.classList.add('text-body', 'font-medium');
            });
            btn.classList.add('bg-primary', 'text-on-primary', 'shadow-sm', 'font-semibold');
            btn.classList.remove('text-body', 'font-medium');
            renderAlibis(btn.getAttribute('data-filter'));
        });
    });

    loadAlibis();
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
