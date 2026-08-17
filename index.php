<?php
define('CURRENT_PAGE', 'labo');
require_once __DIR__ . '/includes/header.php';
?>

<!-- Canvas WebGL d'arrière-plan Shader -->
<canvas id="glcanvas" class="fixed inset-0 w-full h-full pointer-events-none z-0"></canvas>

<!-- Main Content Canvas -->
<main class="flex-grow flex flex-col items-center max-w-container-max mx-auto w-full px-xl py-3xl relative z-10">

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
