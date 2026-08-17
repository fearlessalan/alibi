<?php
define('CURRENT_PAGE', 'alibis');
require_once __DIR__ . '/includes/header.php';
?>

<!-- Canvas WebGL d'arrière-plan Shader -->
<canvas id="glcanvas" class="fixed inset-0 w-full h-full pointer-events-none z-0"></canvas>

<!-- Main Content Canvas -->
<main class="flex-grow max-w-container-max mx-auto w-full px-xl py-3xl relative z-10">
    
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
                <div class="flex justify-between items-center pt-md mt-auto">
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
            <div class="p-md rounded-full text-primary mb-md scale-120 transition-transform">
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

<!-- Three.js CDN pour le shader Chroma Waves -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
  (function() {
    const config = {
      speed: 0.5,
      color: '#FFFFFF',
      backgroundColor: '#676060',
      waveFrequency: 0.2,
      waveAmplitude: 0.3,
      distortion: 1.5,
      chromaShift: 0.25,
      noiseLevel: 0.1,
      flatness: 1.0,
      opacity: 1.0,
      quality: 'high'
    };

    function hexToRgb(hex) {
      const match = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
      return match ? {
        r: parseInt(match[1], 16) / 255,
        g: parseInt(match[2], 16) / 255,
        b: parseInt(match[3], 16) / 255
      } : { r: 1, g: 1, b: 1 };
    }

    const canvas = document.getElementById('glcanvas');
    if (!canvas) return;

    const width = window.innerWidth;
    const height = window.innerHeight;

    const scene = new THREE.Scene();
    const camera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0, 1);

    const renderer = new THREE.WebGLRenderer({
      canvas: canvas,
      antialias: true,
      alpha: true,
      powerPreference: "high-performance"
    });
    renderer.setClearColor(0, 0);

    let qualityScale = 1;
    if (config.quality === 'low') qualityScale = 0.5;
    else if (config.quality === 'medium') qualityScale = 0.75;
    else if (config.quality === 'high') qualityScale = 1.0;

    const pixelRatio = Math.min(window.devicePixelRatio * qualityScale, 2);
    renderer.setSize(width, height, false);
    renderer.setPixelRatio(pixelRatio);

    const c1 = hexToRgb(config.color);
    const c2 = hexToRgb(config.backgroundColor);

    const uniforms = {
      iTime: { value: 0 },
      iResolution: { value: new THREE.Vector3(width * pixelRatio, height * pixelRatio, 1) },
      uColor: { value: new THREE.Vector3(c1.r, c1.g, c1.b) },
      uBackgroundColor: { value: new THREE.Vector3(c2.r, c2.g, c2.b) },
      uWaveFrequency: { value: Math.max(0.1, Math.min(10, config.waveFrequency)) },
      uWaveAmplitude: { value: Math.max(0.1, Math.min(5, config.waveAmplitude)) },
      uDistortion: { value: Math.max(0, Math.min(2, config.distortion)) },
      uChromaShift: { value: Math.max(0, Math.min(0.5, config.chromaShift)) },
      uNoiseLevel: { value: Math.max(0, Math.min(1, config.noiseLevel)) },
      uFlatness: { value: Math.max(0, Math.min(10, config.flatness)) },
      uOpacity: { value: Math.max(0, Math.min(1, config.opacity)) }
    };

    const vertexShader = `
      void main() {
        gl_Position = vec4(position, 1.0);
      }
    `;

    const fragmentShader = `
      precision mediump float;

      #define PI 3.1415926538

      uniform float iTime;
      uniform vec3 iResolution;
      uniform vec3 uColor;
      uniform vec3 uBackgroundColor;
      uniform float uWaveFrequency;
      uniform float uWaveAmplitude;
      uniform float uDistortion;
      uniform float uChromaShift;
      uniform float uNoiseLevel;
      uniform float uFlatness;
      uniform float uOpacity;

      vec4 permute(vec4 x) {
        return mod(((x * 34.0) + 1.0) * x, 289.0);
      }

      vec4 taylorInvSqrt(vec4 r) {
        return 1.79284291400159 - 0.85373472095314 * r;
      }

      vec3 fade(vec3 t) {
        return t * t * t * (t * (t * 6.0 - 15.0) + 10.0);
      }

      float cnoise(vec3 P) {
        vec3 Pi0 = floor(P);
        vec3 Pi1 = Pi0 + vec3(1.0);
        Pi0 = mod(Pi0, 289.0);
        Pi1 = mod(Pi1, 289.0);
        vec3 Pf0 = fract(P);
        vec3 Pf1 = Pf0 - vec3(1.0);
        vec4 ix = vec4(Pi0.x, Pi1.x, Pi0.x, Pi1.x);
        vec4 iy = vec4(Pi0.yy, Pi1.yy);
        vec4 iz0 = Pi0.zzzz;
        vec4 iz1 = Pi1.zzzz;

        vec4 ixy = permute(permute(ix) + iy);
        vec4 ixy0 = permute(ixy + iz0);
        vec4 ixy1 = permute(ixy + iz1);

        vec4 gx0 = ixy0 / 7.0;
        vec4 gy0 = fract(floor(gx0) / 7.0) - 0.5;
        gx0 = fract(gx0);
        vec4 gz0 = vec4(0.5) - abs(gx0) - abs(gy0);
        vec4 sz0 = step(gz0, vec4(0.0));
        gx0 -= sz0 * (step(0.0, gx0) - 0.5);
        gy0 -= sz0 * (step(0.0, gy0) - 0.5);

        vec4 gx1 = ixy1 / 7.0;
        vec4 gy1 = fract(floor(gx1) / 7.0) - 0.5;
        gx1 = fract(gx1);
        vec4 gz1 = vec4(0.5) - abs(gx1) - abs(gy1);
        vec4 sz1 = step(gz1, vec4(0.0));
        gx1 -= sz1 * (step(0.0, gx1) - 0.5);
        gy1 -= sz1 * (step(0.0, gy1) - 0.5);

        vec3 g000 = vec3(gx0.x, gy0.x, gz0.x);
        vec3 g100 = vec3(gx0.y, gy0.y, gz0.y);
        vec3 g010 = vec3(gx0.z, gy0.z, gz0.z);
        vec3 g110 = vec3(gx0.w, gy0.w, gz0.w);
        vec3 g001 = vec3(gx1.x, gy1.x, gz1.x);
        vec3 g101 = vec3(gx1.y, gy1.y, gz1.y);
        vec3 g011 = vec3(gx1.z, gy1.z, gz1.z);
        vec3 g111 = vec3(gx1.w, gy1.w, gz1.w);

        vec4 norm0 = taylorInvSqrt(vec4(dot(g000, g000), dot(g010, g010), dot(g100, g100), dot(g110, g110)));
        g000 *= norm0.x;
        g010 *= norm0.y;
        g100 *= norm0.z;
        g110 *= norm0.w;
        vec4 norm1 = taylorInvSqrt(vec4(dot(g001, g001), dot(g011, g011), dot(g101, g101), dot(g111, g111)));
        g001 *= norm1.x;
        g011 *= norm1.y;
        g101 *= norm1.z;
        g111 *= norm1.w;

        float n000 = dot(g000, Pf0);
        float n100 = dot(g100, vec3(Pf1.x, Pf0.yz));
        float n010 = dot(g010, vec3(Pf0.x, Pf1.y, Pf0.z));
        float n110 = dot(g110, vec3(Pf1.xy, Pf0.z));
        float n001 = dot(g001, vec3(Pf0.xy, Pf1.z));
        float n101 = dot(g101, vec3(Pf1.x, Pf0.y, Pf1.z));
        float n011 = dot(g011, vec3(Pf0.x, Pf1.yz));
        float n111 = dot(g111, Pf1);

        vec3 fade_xyz = fade(Pf0);
        vec4 n_z = mix(vec4(n000, n100, n010, n110), vec4(n001, n101, n011, n111), fade_xyz.z);
        vec2 n_yz = mix(n_z.xy, n_z.zw, fade_xyz.y);
        float n_xyz = mix(n_yz.x, n_yz.y, fade_xyz.x);
        return 2.2 * n_xyz;
      }

      float flatSin(float x, float b) {
        float num = 1.0 + b * b;
        float den = 1.0 + b * b * cos(x) * cos(x);
        float y = sqrt(num / den) * cos(x);
        return y * 0.5 + 0.5;
      }

      float rand(vec2 co) {
        return fract(sin(dot(co, vec2(12.9898, 78.233))) * 43758.5453);
      }

      void mainImage(out vec4 fragColor, in vec2 fragCoord) {
        vec2 uv = fragCoord / iResolution.xy;
        vec2 center = vec2(0.5);
        vec2 delta = uv - center;
        float dist = length(delta);

        float timeScale = 0.1;
        float timeDelay = uChromaShift * 0.08;
        float baseTime = iTime * timeScale;

        float bSquared = uFlatness * uFlatness;
        float num = 1.0 + bSquared;

        vec3 intensity;

        for (int i = 0; i < 3; i++) {
          float tOffset = float(i) * timeDelay;

          vec2 distortedUV = uv;
          float dx = cnoise(vec3(1.8 * uv, baseTime + tOffset)) * uDistortion;
          distortedUV.x += dx * 0.8;

          vec2 distortedDelta = distortedUV - center;
          float distortedDist = length(distortedDelta);
          float normalizedDist = 1.0 - distortedDist / 0.70710678;

          float x = uWaveFrequency * 100.0 * normalizedDist * uWaveAmplitude;
          float cosX = cos(x);
          float den = 1.0 + bSquared * cosX * cosX;
          float waveValue = sqrt(num / den) * cosX * 0.5 + 0.5;

          if (uNoiseLevel > 0.01) {
            float noise = rand(distortedUV * 1000.0);
            waveValue = waveValue * (1.0 - uNoiseLevel) + noise * uNoiseLevel;
          }

          intensity[i] = waveValue;
        }

        vec3 finalColor = mix(uBackgroundColor, uColor, intensity);
        float alpha = (intensity.r + intensity.g + intensity.b) * 0.333333 * uOpacity;

        fragColor = vec4(finalColor, alpha);
      }

      void main() {
        vec4 color = vec4(0.0);
        mainImage(color, gl_FragCoord.xy);
        gl_FragColor = color;
      }
    `;

    const material = new THREE.ShaderMaterial({
      uniforms,
      vertexShader,
      fragmentShader,
      transparent: true
    });

    const geometry = new THREE.PlaneGeometry(2, 2);
    const mesh = new THREE.Mesh(geometry, material);
    scene.add(mesh);

    let startTime = performance.now();
    let lastTime = startTime;

    function render(currentTime) {
      requestAnimationFrame(render);

      if (currentTime - lastTime < 16) return;
      lastTime = currentTime;

      const elapsed = (currentTime - startTime) * 0.001 * config.speed;
      uniforms.iTime.value = elapsed;

      renderer.render(scene, camera);
    }
    requestAnimationFrame(render);

    window.addEventListener('resize', () => {
      const w = window.innerWidth;
      const h = window.innerHeight;
      renderer.setSize(w, h, false);
      uniforms.iResolution.value.set(w * pixelRatio, h * pixelRatio, 1);
    });
  })();
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
