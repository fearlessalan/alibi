<!-- Footer (dark coffee ink footer) -->
<footer class="w-full mt-auto bg-ink text-canvas-soft border-t border-ink-soft">
    <div class="flex flex-col md:flex-row justify-between items-center px-xl py-3xl max-w-container-max mx-auto gap-md">
        <div class="text-[14px] text-body-mid font-medium mb-sm md:mb-0">
            Coded with <span class="text-primary">❤️</span> by <a href="https://fearlessalan.vercel.app" target="_blank" class="text-canvas-soft font-semibold hover:text-primary transition-colors">Fearless</a>
        </div>
        <div class="flex gap-xl text-[14px]">
            <a class="text-body-mid hover:text-canvas-soft transition-colors" href="#">La Vérité Vraie</a>
            <a class="text-body-mid hover:text-canvas-soft transition-colors" href="#">Faille Juridique</a>
            <a class="text-body-mid hover:text-canvas-soft transition-colors" href="#">Confidentialité</a>
        </div>
    </div>
</footer>

<!-- Toast Container pour les confirmations -->
<div id="toastContainer" class="fixed bottom-20 md:bottom-8 right-6 z-50 flex flex-col gap-2 pointer-events-none"></div>

<!-- Mobile Bottom Navigation Bar -->
<nav class="md:hidden fixed bottom-0 w-full bg-canvas border-t border-canvas-soft flex justify-around py-sm px-xs z-40 shadow-lg">
    <a class="flex flex-col items-center <?php echo CURRENT_PAGE === 'labo' ? 'text-primary font-bold' : 'text-body'; ?>" href="index.php">
        <span class="material-symbols-outlined" <?php if(CURRENT_PAGE==='labo') echo 'style="font-variation-settings:\'FILL\' 1;"'; ?>>science</span>
        <span class="text-[11px] mt-0.5">Labo</span>
    </a>
    <a class="flex flex-col items-center <?php echo CURRENT_PAGE === 'alibis' ? 'text-primary font-bold' : 'text-body'; ?>" href="mes-alibis.php">
        <span class="material-symbols-outlined" <?php if(CURRENT_PAGE==='alibis') echo 'style="font-variation-settings:\'FILL\' 1;"'; ?>>bookmark</span>
        <span class="text-[11px] mt-0.5">Alibis</span>
    </a>
    <a class="flex flex-col items-center <?php echo CURRENT_PAGE === 'classement' ? 'text-primary font-bold' : 'text-body'; ?>" href="classement.php">
        <span class="material-symbols-outlined" <?php if(CURRENT_PAGE==='classement') echo 'style="font-variation-settings:\'FILL\' 1;"'; ?>>leaderboard</span>
        <span class="text-[11px] mt-0.5">Classement</span>
    </a>
</nav>

<script>
    // Menu mobile toggle
    const toggleBtn = document.getElementById('mobileMenuToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    if (toggleBtn && mobileMenu) {
        toggleBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Helper Toast (Zapier style toast)
    function showToast(message, type = 'success') {
        const container = document.getElementById('toastContainer');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = `pointer-events-auto px-xl py-md rounded-md shadow-xl font-medium text-[14px] flex items-center gap-sm transform transition-all duration-300 translate-y-4 opacity-0 ${
            type === 'success' ? 'bg-ink text-canvas border border-ink-soft' : 'bg-primary text-on-primary'
        }`;
        toast.innerHTML = `
            <span class="material-symbols-outlined text-[20px]">${type === 'success' ? 'check_circle' : 'info'}</span>
            <span>${message}</span>
        `;
        container.appendChild(toast);

        // Animer entrée
        setTimeout(() => {
            toast.classList.remove('translate-y-4', 'opacity-0');
        }, 10);

        // Retirer après 3s
        setTimeout(() => {
            toast.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
</script>
</body>
</html>
