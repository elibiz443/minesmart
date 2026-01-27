<?php require __DIR__ . '/app/helpers/connector.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MineSmart Sentinel | Satellite & Edge-AI Fusion</title>
  <link href="<?php echo ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=JetBrains+Mono&display=swap" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL; ?>/assets/images/favicon.webp" />
  <style>
    .glass-card { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.1); }
    .gradient-text { background: linear-gradient(to right, #38bdf8, #fb923c); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    html { scroll-behavior: smooth; }
  </style>
</head>
<body class="bg-[#0b1120] text-slate-300 font-['Lato'] selection:bg-orange-500/30">

  <header class="fixed top-0 w-full z-50 border-b border-white/5 bg-[#0b1120]/80 backdrop-blur-md">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <div class="flex items-center gap-2">
        <img src="<?php echo ROOT_URL; ?>/assets/images/logo.webp" class="w-8 h-8">
        <p class="text-xl font-black tracking-tighter text-white">
          MINE<span class="text-orange-500">SMART</span> <span class="font-light text-slate-400">SENTINEL</span>
        </p>
      </div>
      <nav class="hidden md:flex gap-10 text-[11px] uppercase tracking-[0.2em] font-bold">
        <a href="#philosophy" class="hover:text-sky-400 transition">Philosophy</a>
        <a href="#architecture" class="hover:text-sky-400 transition">Architecture</a>
        <a href="#edge-ai" class="hover:text-sky-400 transition">Edge AI</a>
        <a href="<?php echo ROOT_URL; ?>/auth/login" class="text-orange-500 border border-orange-500/30 px-4 py-1 rounded-full hover:bg-orange-500 hover:text-white transition">Terminal Access</a>
      </nav>
    </div>
  </header>

  <section class="relative pt-44 pb-32 overflow-hidden">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full -z-10">
      <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-sky-500/10 blur-[120px] rounded-full"></div>
      <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-orange-500/10 blur-[120px] rounded-full"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center">
      <div>
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-500/10 border border-sky-500/20 mb-6">
          <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-sky-500"></span>
          </span>
          <span class="text-[10px] font-bold tracking-widest text-sky-400 uppercase">Copernicus Sentinel Integration Active</span>
        </div>
        <h1 class="text-6xl md:text-7xl font-black text-white leading-[0.95] mb-8">
          Orbital Data.<br/>
          <span class="gradient-text">Edge Verified.</span>
        </h1>
        <p class="text-lg text-slate-400 max-w-xl leading-relaxed mb-10">
          The world’s first "Satellite-First, Edge-Verified" control system. We fuse 48-hour macro-trends with on-site IoT truth to eliminate false positives and secure mining compliance.
        </p>
        <div class="flex flex-wrap gap-5">
          <a href="<?php echo ROOT_URL; ?>/auth/register" class="px-10 py-4 rounded-xl bg-orange-500 text-white font-extrabold hover:bg-orange-600 hover:scale-105 transition shadow-2xl shadow-orange-500/20">
            Get Started
          </a>
          <a href="#architecture" class="px-10 py-4 rounded-xl glass-card text-white font-extrabold hover:bg-white/10 transition">
            System Architecture
          </a>
        </div>
      </div>

      <div class="relative">
        <div class="absolute inset-0 bg-sky-500/20 blur-[100px] -z-10 animate-pulse"></div>
        <div class="glass-card rounded-[2rem] p-8 border-white/10 relative overflow-hidden">
          <div class="flex justify-between items-center mb-10">
            <div>
              <p class="text-[10px] font-bold text-slate-500 tracking-widest uppercase">System Decision Engine</p>
              <p class="text-xl font-bold text-white">Confirmed Event Status</p>
            </div>
            <div class="text-right">
              <span class="text-xs font-mono text-emerald-400 bg-emerald-500/10 px-2 py-1 rounded">V. 2.0.4</span>
            </div>
          </div>
          
          <div class="grid grid-cols-2 gap-4 mb-8">
            <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
              <p class="text-[10px] font-bold text-sky-400 uppercase">Sat-Prediction</p>
              <p class="text-2xl font-black text-white mt-1">High Risk</p>
              <p class="text-[9px] text-slate-500 mt-1 font-mono uppercase tracking-tighter">InSAR > 5.2mm/mo</p>
            </div>
            <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
              <p class="text-[10px] font-bold text-orange-400 uppercase">Edge-Verification</p>
              <p class="text-2xl font-black text-white mt-1">Positive</p>
              <p class="text-[9px] text-slate-500 mt-1 font-mono">Hailo AI logic</p>
            </div>
          </div>

          <div class="space-y-4">
            <div class="flex justify-between text-[10px] font-bold tracking-widest text-slate-500 uppercase">
              <span>Fusion Logic Weight</span>
              <span>Reliability: 99.4%</span>
            </div>
            <div class="h-1.5 w-full bg-slate-800 rounded-full overflow-hidden flex">
              <div class="h-full bg-sky-500" style="width: 60%"></div>
              <div class="h-full bg-orange-500" style="width: 40%"></div>
            </div>
            <div class="flex gap-4 text-[9px] font-mono text-slate-500">
              <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-sky-500"></span> 0.6 Satellite</span>
              <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-orange-500"></span> 0.4 Edge</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="philosophy" class="max-w-7xl mx-auto px-6 py-24">
    <div class="grid md:grid-cols-3 gap-12">
      <div class="md:col-span-1">
        <h2 class="text-xs font-bold text-orange-500 tracking-[0.3em] uppercase mb-4">Core Philosophy</h2>
        <p class="text-3xl font-black text-white leading-tight uppercase tracking-tighter">Predict Predicts.<br/>Edge Verifies.</p>
      </div>
      <div class="md:col-span-2 grid sm:grid-cols-2 gap-10">
        <div class="p-6 glass-card rounded-2xl">
          <h3 class="text-white font-bold mb-3 uppercase tracking-widest text-sm flex items-center gap-2">
            <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
            </svg>
            Geotechnical
          </h3>
          <p class="text-xs text-slate-400 leading-relaxed uppercase">Monitoring landslides, erosion, and slope instability through Sentinel-1 InSAR deformation mapping.</p>
        </div>
        <div class="p-6 glass-card rounded-2xl">
          <h3 class="text-white font-bold mb-3 uppercase tracking-widest text-sm flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
            </svg>
            Rehabilitation
          </h3>
          <p class="text-xs text-slate-400 leading-relaxed uppercase">Tracking vegetation recovery and compliance scoring using multi-spectral NDVI trends.</p>
        </div>
      </div>
    </div>
  </section>

  <section id="edge-ai" class="max-w-7xl mx-auto px-6 py-32 border-t border-white/5">
    <div class="grid lg:grid-cols-2 gap-20 items-center">
      <div class="order-2 lg:order-1">
        <div class="glass-card p-1 rounded-[2rem] overflow-hidden">
          <div class="bg-[#0b1120] rounded-[1.8rem] p-8">
            <div class="flex items-center justify-between mb-8">
              <div class="flex items-center gap-3">
                <div class="w-3 h-3 rounded-full bg-orange-500 animate-pulse"></div>
                <span class="text-[10px] font-mono font-bold text-slate-400 uppercase tracking-widest">Local Inference Active</span>
              </div>
              <span class="text-[10px] font-mono text-slate-600">NODE_ID: 0x992-Kwale</span>
            </div>
            
            <div class="space-y-6">
              <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl border border-white/5">
                <span class="text-xs font-bold text-white uppercase tracking-tight">AI Model Confidence</span>
                <span class="text-orange-400 font-mono font-bold">94.2%</span>
              </div>
              <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl border border-white/5">
                <span class="text-xs font-bold text-white uppercase tracking-tight">Processing Latency</span>
                <span class="text-sky-400 font-mono font-bold">12ms</span>
              </div>
              <div class="pt-4 border-t border-white/10">
                <p class="text-[9px] font-mono text-slate-500 uppercase mb-3">Live Log stream</p>
                <div class="bg-black/40 p-4 rounded-lg font-mono text-[10px] text-emerald-500/80 leading-relaxed">
                  [INFO] Loading Hailo-8 bitstream... OK<br/>
                  [AI] Detection: Surface Erosion Detected (Area 4C)<br/>
                  [SYNC] Comparing with Sentinel-2 48h trend...<br/>
                  [SUCCESS] Cross-layer match. Event Confirmed.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="order-1 lg:order-2">
        <h2 class="text-xs font-bold text-orange-500 tracking-[0.3em] uppercase mb-4">Ground Intelligence</h2>
        <h3 class="text-5xl font-black text-white mb-6 uppercase tracking-tighter">The Edge AI Layer</h3>
        <p class="text-slate-400 text-sm leading-relaxed mb-8 uppercase tracking-wide font-bold">
          Our Edge nodes serve as the localized "Truth Validators" for orbital predictions.
        </p>
        <p class="text-slate-500 text-sm leading-relaxed mb-10">
          Equipped with industrial Raspberry Pi 5 hardware and the Hailo-8 AI accelerator, these nodes process multispectral vision and vibration data locally. This eliminates the need for expensive high-bandwidth video streaming while providing real-time geotechnical confirmation.
        </p>
        <ul class="space-y-4">
          <li class="flex items-start gap-4">
            <svg class="w-5 h-5 text-orange-500 mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
              <h4 class="text-white font-bold text-xs uppercase tracking-widest">Verification Index</h4>
              <p class="text-xs text-slate-500 mt-1 uppercase">Local sensor fusion creates a 0.4 weighted truth index to confirm satellite anomalies.</p>
            </div>
          </li>
          <li class="flex items-start gap-4">
            <svg class="w-5 h-5 text-orange-500 mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
              <h4 class="text-white font-bold text-xs uppercase tracking-widest">Fail-Safe Logic</h4>
              <p class="text-xs text-slate-500 mt-1 uppercase">If satellite cloud cover exceeds 80%, the Edge Node takes over as the primary alert trigger.</p>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </section>

  <section id="architecture" class="bg-white/5 py-24 border-y border-white/5">
    <div class="max-w-7xl mx-auto px-6">
      <div class="text-center mb-20">
        <h2 class="text-4xl font-black text-white mb-4">The Dual-Layer Architecture</h2>
        <p class="text-slate-400 max-w-2xl mx-auto">Bridging the gap between orbital data and localized reality</p>
      </div>

      <div class="grid md:grid-cols-2 gap-8">
        <div class="glass-card p-10 rounded-3xl group hover:border-sky-500/90 overflow-hidden transition-all duration-500 ease-in-out">
          <svg class="absolute -right-4 -bottom-4 w-32 h-32 text-white/[0.02]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
          <div class="w-12 h-12 rounded-xl bg-sky-500/20 flex items-center justify-center mb-6 text-sky-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
          </div>
          <h3 class="text-2xl font-bold text-white mb-6 uppercase tracking-tight">Satellite Macro Layer</h3>
          <div class="space-y-4">
            <div class="flex items-center gap-3 text-[10px] font-mono font-bold text-slate-400 uppercase">
              <svg class="w-3 h-3 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
              </svg>
              Sentinel-1: InSAR Deformation
            </div>
            <div class="flex items-center gap-3 text-[10px] font-mono font-bold text-slate-400 uppercase">
              <svg class="w-3 h-3 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
              </svg>
              Sentinel-2: Vegetation Index
            </div>
            <div class="flex items-center gap-3 text-[10px] font-mono font-bold text-slate-400 uppercase">
              <svg class="w-3 h-3 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
              </svg>
              Sentinel-5P: Weather Indices
            </div>
          </div>
        </div>

        <div class="glass-card p-10 rounded-3xl group hover:border-orange-500/50 overflow-hidden transition-all duration-500 ease-in-out">
          <svg class="absolute -right-4 -bottom-4 w-32 h-32 text-white/[0.02]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
          </svg>
          <div class="w-12 h-12 rounded-xl bg-orange-500/20 flex items-center justify-center mb-6 text-orange-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-white mb-6 uppercase tracking-tight">Edge IoT Validation</h3>
          <div class="space-y-4">
            <div class="flex items-center gap-3 text-[10px] font-mono font-bold text-slate-400 uppercase">
              <svg class="w-3 h-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
              </svg>
              Raspberry Pi 5 Core
            </div>
            <div class="flex items-center gap-3 text-[10px] font-mono font-bold text-slate-400 uppercase">
              <svg class="w-3 h-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
              </svg>
              Hailo-8 AI Accelerator
            </div>
            <div class="flex items-center gap-3 text-[10px] font-mono font-bold text-slate-400 uppercase">
              <svg class="w-3 h-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
              </svg>
              Local Vision Inference
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="max-w-7xl mx-auto px-6 py-24 mb-32">
    <div class="glass-card rounded-[3rem] p-16 text-center relative overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-r from-sky-500/10 to-orange-500/10 -z-10"></div>
      <h2 class="text-5xl font-black text-white mb-6 italic">Audit-Grade Reports.</h2>
      <p class="text-slate-400 max-w-2xl mx-auto mb-12">
        Generate downloadable PDF, CSV, and GeoJSON datasets for management, regulators, and GIS platforms. Verifiable, time-stamped, and defensible.
      </p>
      <div class="flex flex-wrap justify-center gap-4">
        <span class="px-4 py-2 rounded-lg bg-white/5 text-[10px] font-mono text-slate-300">.PDF</span>
        <span class="px-4 py-2 rounded-lg bg-white/5 text-[10px] font-mono text-slate-300">.CSV</span>
        <span class="px-4 py-2 rounded-lg bg-white/5 text-[10px] font-mono text-slate-300">.GEOJSON</span>
      </div>
    </div>
  </section>

  <footer class="py-20 border-t border-white/5 bg-black/20">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-12 mb-16">
      <div class="col-span-2">
        <div class="flex items-center gap-2 mb-6">
          <img src="<?php echo ROOT_URL; ?>/assets/images/logo.webp" class="w-6 h-6">
          <p class="text-lg font-black text-white uppercase tracking-tighter">MineSmart Sentinel</p>
        </div>
        <p class="text-xs font-bold text-slate-600 max-w-sm uppercase tracking-widest leading-loose">
          The final word in environmental defense. Blending space intelligence with ground truth.
        </p>
      </div>
      <div>
        <h4 class="text-white font-bold mb-6 uppercase text-[10px] tracking-[0.2em] text-orange-500">System Logs</h4>
        <ul class="space-y-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest">
          <li>Satellite Engine</li>
          <li>Edge AI Node</li>
          <li>Fusion Matrix</li>
          <li>Compliance API</li>
        </ul>
      </div>
      <div>
        <h4 class="text-white font-bold mb-6 uppercase text-[10px] tracking-[0.2em] text-sky-500">Global Access</h4>
        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4 leading-relaxed">Secure your industrial rehabilitation bonds today.</p>
        <a href="<?php echo ROOT_URL; ?>/auth/register" class="text-white text-[10px] font-black uppercase tracking-widest border-b border-orange-500 pb-1 hover:text-orange-500 transition-colors">Request Demo</a>
      </div>
    </div>
    <div class="text-center text-[9px] font-mono text-slate-700 uppercase tracking-[0.5em]">
       Copyright &copy; <?php echo date('Y'); ?> MineSmart Sentinel | Baseline Alpha v.1.0.4
    </div>
  </footer>

</body>
</html>