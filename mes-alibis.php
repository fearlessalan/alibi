<?php
define('CURRENT_PAGE', 'alibis');
require_once __DIR__ . '/includes/header.php';
?>

<!-- Main Content Canvas -->
<main class="flex-grow max-w-container-max mx-auto w-full px-gutter md:px-md py-xl">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-lg gap-sm">
        <div>
            <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-primary mb-xs">
                Archives du Crime Parfait
            </h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant">
                Retrouvez et réutilisez vos meilleures esquives. Promis, on ne dira rien.
            </p>
        </div>
        
        <!-- Filter Tabs -->
        <div class="flex flex-wrap items-center gap-xs bg-surface-container p-1 rounded-full border border-outline-variant/30">
            <button data-filter="all" class="filter-btn active-filter px-sm py-xs rounded-full text-xs font-bold transition-all bg-primary text-on-primary shadow-sm">
                Tous
            </button>
            <button data-filter="Patron" class="filter-btn px-sm py-xs rounded-full text-xs font-bold text-on-surface-variant hover:text-primary transition-all">
                Patron
            </button>
            <button data-filter="Conjoint" class="filter-btn px-sm py-xs rounded-full text-xs font-bold text-on-surface-variant hover:text-primary transition-all">
                Conjoint
            </button>
            <button data-filter="Amis" class="filter-btn px-sm py-xs rounded-full text-xs font-bold text-on-surface-variant hover:text-primary transition-all">
                Amis
            </button>
            <button data-filter="Professeur" class="filter-btn px-sm py-xs rounded-full text-xs font-bold text-on-surface-variant hover:text-primary transition-all">
                Professeur
            </button>
        </div>
    </div>

    <!-- Alibi Grid Container -->
    <div id="alibiGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-md">
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
            card.className = "bg-surface-container-lowest rounded-xl p-md flex flex-col shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 group border border-outline-variant/20";
            
            card.innerHTML = `
                <div class="flex justify-between items-start mb-sm">
                    <div class="flex gap-xs items-center bg-surface-variant px-2.5 py-1 rounded-md text-label-caps font-label-caps text-on-surface-variant">
                        <span class="material-symbols-outlined text-[16px]">${icon}</span>
                        Cible : ${alibi.target}
                    </div>
                    <span class="text-label-caps font-label-caps text-outline">${alibi.date || 'Récents'}</span>
                </div>
                <h3 class="font-headline-md text-[20px] font-bold text-on-surface mb-xs">${alibi.subject}</h3>
                <p class="font-body-lg text-body-lg text-on-surface mb-md flex-grow italic">
                    "${alibi.text}"
                </p>
                <div class="flex justify-between items-center border-t border-outline-variant/40 pt-sm mt-auto">
                    <button class="delete-btn text-error hover:bg-error-container p-2 rounded-full transition-colors flex items-center justify-center opacity-70 group-hover:opacity-100" data-id="${alibi.id}">
                        <span class="material-symbols-outlined">delete</span>
                    </button>
                    <button class="copy-btn flex items-center gap-xs bg-primary-fixed text-on-primary-fixed hover:bg-primary-fixed-dim px-sm py-2 rounded-lg font-bold transition-colors" data-text="${alibi.text.replace(/"/g, '&quot;')}">
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
        addCard.className = "bg-surface-container-low border-2 border-dashed border-outline-variant rounded-xl p-md flex flex-col items-center justify-center text-center cursor-pointer hover:bg-surface-container hover:border-primary transition-all duration-300 min-h-[260px] group";
        addCard.innerHTML = `
            <div class="bg-primary-fixed p-3 rounded-full text-on-primary-fixed mb-sm group-hover:scale-105 transition-transform">
                <span class="material-symbols-outlined text-[32px]">add_reaction</span>
            </div>
            <h3 class="font-headline-md text-[20px] font-bold text-primary mb-xs">Besoin d'un nouveau mensonge ?</h3>
            <p class="font-body-md text-body-md text-on-surface-variant">Retournez au Labo du Chaos pour générer une nouvelle esquive magistrale.</p>
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
                b.classList.remove('bg-primary', 'text-on-primary', 'shadow-sm');
                b.classList.add('text-on-surface-variant');
            });
            btn.classList.add('bg-primary', 'text-on-primary', 'shadow-sm');
            btn.classList.remove('text-on-surface-variant');
            renderAlibis(btn.getAttribute('data-filter'));
        });
    });

    loadAlibis();
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
