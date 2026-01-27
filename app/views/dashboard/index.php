<?php
  require __DIR__ . '/../../helpers/online_connector.php';
  require __DIR__ . '/../../helpers/risk_processor.php';
  require __DIR__ . '/../../controllers/dashboard/index.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MineSmart - Dashboard</title>
  <link href="<?= ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="relative bg-slate-900 text-slate-100 max-w-full overflow-x-hidden">
  <div class="absolute inset-0 bg-[url('../../assets/images/dashboard.webp')] bg-cover bg-center opacity-40 -z-10"></div>

  <?php include '../includes/sidebar.php'; ?>
  <?php require __DIR__ . '/../includes/message.php'; ?>

  <main id="mainContent" class="relative min-h-screen w-[calc(100%-12rem)] ml-auto flex flex-col overflow-hidden transition-all duration-500 ease-in-out">
    <?php include '../includes/header.php'; ?>

    <section class="overflow-y-auto p-8 flex-grow pt-18">

      <div class="flex justify-between items-center mb-10">
        <div>
          <h1 class="text-3xl font-black tracking-tight uppercase text-sky-500">MineSmart Dashboard</h1>
          <p class="text-slate-400 text-sm">Real-Time Geospatial Risk Intelligence</p>
        </div>
        <div class="bg-slate-800/80 backdrop-blur-sm p-3 rounded-xl border border-slate-700">
          <span class="text-[10px] text-slate-500 block uppercase font-bold">Network Status</span>
          <span class="text-sm font-mono text-emerald-400"><?= $totalSites ?> Active Sites</span>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-6 lg:grid-cols-6 gap-6 mb-10">
        <div class="md:col-span-4 bg-slate-900/40 p-8 rounded-3xl border border-slate-700/50 backdrop-blur-md relative overflow-hidden group">
          <div class="absolute top-1 right-2 opacity-30 group-hover:opacity-60 transition-opacity duration-700 ease-in-out">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="w-32 h-32 text-sky-500" fill="currentColor">
              <path d="M264.5 5.2c14.9-6.9 32.1-6.9 47 0l218.6 101c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 149.8C37.4 145.8 32 137.3 32 128s5.4-17.9 13.9-21.8L264.5 5.2zM476.9 209.6l53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 277.8C37.4 273.8 32 265.3 32 256s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0l152-70.2zm-152 198.2l152-70.2 53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 405.8C37.4 401.8 32 393.3 32 384s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0z"/>
            </svg>
          </div>
          
          <div class="relative z-10">
            <h3 class="text-slate-500 text-xs font-bold uppercase tracking-[0.25em]">Global Infrastructure Nodes</h3>
            <div class="flex items-end gap-6 mt-2">
              <p class="text-7xl font-black text-white tracking-tighter"><?= $totalSites ?></p>
              <div class="mb-3 px-3 py-1 rounded-full border <?= $totalSitesGrowth >= 0 ? 'text-emerald-400 border-emerald-500/30 bg-emerald-500/5' : 'text-rose-400 border-rose-500/30 bg-rose-500/5' ?> text-sm font-bold flex items-center gap-1">
                <span class="text-xs"><?= $totalSitesGrowth >= 0 ? '▲' : '▼' ?></span>
                <span><?= number_format(abs($totalSitesGrowth), 1) ?>%</span>
              </div>
            </div>

            <div class="mt-10">
              <div class="flex justify-between text-[10px] mb-3 font-bold tracking-widest text-slate-400">
                  <span class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-sky-500 animate-pulse"></span>
                    LIVE NETWORK DISTRIBUTION
                  </span>
                  <span class="font-mono text-slate-500"><?= $stabilityIndex ?>% AVG UPTIME</span>
              </div>
              <div class="w-full h-2 bg-slate-800/80 rounded-full overflow-hidden flex border border-slate-700/30">
                <div class="h-full bg-gradient-to-r from-emerald-600 to-emerald-400 transition-all duration-1000" style="width: <?= $normalRate ?>%"></div>
                <div class="h-full bg-gradient-to-r from-amber-600 to-amber-400 transition-all duration-1000" style="width: <?= $warningRate ?>%"></div>
                <div class="h-full bg-gradient-to-r from-rose-600 to-rose-400 transition-all duration-1000" style="width: <?= $criticalRate ?>%"></div>
              </div>
              <div class="flex gap-6 mt-4">
                <div class="flex items-center gap-2 text-[10px] text-slate-400 font-bold tracking-tight">
                  <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div> <?= $normal ?> NOMINAL
                </div>
                <div class="flex items-center gap-2 text-[10px] text-slate-400 font-bold tracking-tight">
                  <div class="w-1.5 h-1.5 rounded-full bg-amber-500"></div> <?= $warning ?> DEGRADED
                </div>
                <div class="flex items-center gap-2 text-[10px] text-slate-400 font-bold tracking-tight">
                  <div class="w-1.5 h-1.5 rounded-full bg-rose-500"></div> <?= $critical ?> CRITICAL
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="md:col-span-2 bg-gradient-to-br from-rose-500/20 via-slate-800/50 to-slate-800/50 p-8 rounded-3xl border border-rose-500/30 backdrop-blur-md flex flex-col justify-between group cursor-help">
          <div>
            <h3 class="text-rose-400/80 text-xs font-bold uppercase tracking-[0.2em]">High Risk Nodes</h3>
            <p class="text-7xl font-black mt-2 text-rose-500 drop-shadow-[0_0_15px_rgba(244,63,94,0.3)]">
              <?= str_pad($critical, 2, '0', STR_PAD_LEFT) ?>
            </p>
          </div>
          <div class="mt-8">
            <div class="flex items-center justify-between mb-2">
              <span class="text-[10px] text-rose-400 font-black uppercase">Incident Rate</span>
              <span class="text-xs font-mono text-rose-200"><?= $criticalRate ?>%</span>
            </div>
            <div class="w-full h-1 bg-rose-950 rounded-full overflow-hidden">
              <div class="h-full bg-rose-500" style="width: <?= $criticalRate ?>%"></div>
            </div>
            <p class="mt-4 text-[9px] text-rose-300/60 leading-relaxed font-medium uppercase tracking-tighter">
              Security protocol Alpha-6 engaged. Edge nodes require manual verification.
            </p>
          </div>
        </div>

        <div class="md:col-span-2 bg-slate-800/40 p-6 rounded-2xl border border-slate-700/50 hover:border-amber-500/30 transition-colors group">
          <div class="flex justify-between items-start">
            <h3 class="text-slate-500 text-xs font-bold uppercase tracking-widest">Warning Zone</h3>
            <div class="p-2 bg-amber-500/10 rounded-lg">
              <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
          </div>
          <p class="text-5xl font-black mt-4 text-amber-500"><?= $warning ?></p>
          <div class="mt-6 flex items-center justify-between border-t border-slate-700/50 pt-4">
            <div class="text-[10px] text-amber-400 font-black uppercase">Pending Review</div>
            <span class="text-xs text-slate-500 font-mono"><?= $warningRate ?>%</span>
          </div>
        </div>

        <div class="md:col-span-2 bg-slate-800/40 p-6 rounded-2xl border border-slate-700/50 hover:border-purple-500/30 transition-colors group">
          <div class="flex justify-between items-start">
            <div>
              <h3 class="text-slate-500 text-xs font-bold uppercase tracking-widest">Risk Index</h3>
              <p class="text-5xl font-black mt-4 text-purple-400"><?= $avgRisk ?></p>
            </div>
            <div class="relative w-16 h-16 flex items-center justify-center">
              <svg class="w-full h-full -rotate-90">
                <circle cx="32" cy="32" r="28" stroke="currentColor" stroke-width="4" fill="transparent" class="text-slate-700" />
                <circle cx="32" cy="32" r="28" stroke="currentColor" stroke-width="4" fill="transparent" class="text-purple-500" stroke-dasharray="175.9" stroke-dashoffset="<?= 175.9 - (175.9 * ($avgRisk / 100)) ?>" />
              </svg>
              <span class="absolute text-[10px] font-black text-purple-200"><?= $avgRisk ?></span>
            </div>
          </div>
          <div class="mt-4 flex items-center justify-between border-t border-slate-700/50 pt-4">
            <div class="text-[10px] text-purple-400 font-black uppercase">Standard Deviation</div>
            <div class="flex gap-1.5">
              <span class="w-1 h-3 bg-purple-500/20 rounded-full"></span>
              <span class="w-1 h-3 bg-purple-500/50 rounded-full"></span>
              <span class="w-1 h-3 bg-purple-500 rounded-full"></span>
            </div>
          </div>
        </div>

        <div class="md:col-span-2 bg-slate-800/40 p-6 rounded-2xl border border-slate-700/50 hover:border-cyan-500/30 transition-colors group">
          <div class="flex justify-between items-start">
            <h3 class="text-slate-500 text-xs font-bold uppercase tracking-widest">Stability</h3>
            <div class="p-2 bg-cyan-500/10 rounded-lg">
              <svg class="w-4 h-4 text-cyan-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
          </div>
          <p class="text-5xl font-black mt-4 text-cyan-400"><?= $stabilityIndex ?><span class="text-2xl opacity-50 ml-1">%</span></p>
          <div class="mt-6 flex items-center justify-between border-t border-slate-700/50 pt-4">
            <div class="text-[10px] text-cyan-400 font-black uppercase">System Nominal</div>
            <span class="w-2 h-2 rounded-full bg-cyan-500 shadow-[0_0_8px_rgba(34,211,238,0.8)]"></span>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        <div class="lg:col-span-2 bg-slate-800/80 rounded-3xl border border-slate-700 p-6 shadow-2xl flex flex-col">
          <h3 class="text-lg font-black mb-4 text-sky-400">Geospatial Risk Overview</h3>
          <p class="text-sm text-slate-400 mb-6">
            This map shows spatial concentration of operational risk across all monitored mining zones.
            Clusters represent systemic instability while dispersed markers indicate stable operations.
            For forensic site intelligence and operational diagnostics, navigate to the Sites Intelligence page.
          </p>
          <div class="relative flex-1 bg-slate-900 rounded-2xl border border-slate-700 overflow-hidden">
            <div id="map" class="w-full h-full"></div>
          </div>
        </div>

        <div class="space-y-6">
          <div class="bg-slate-800/80 rounded-3xl border border-slate-700 p-6 shadow-2xl">
            <h3 class="text-lg font-black mb-4 text-sky-400">System Intelligence</h3>
            <div class="space-y-3 text-sm">
              <div class="flex justify-between">
                <span class="text-slate-400">Threat Velocity</span>
                <span class="font-black text-rose-400"><?= $threatVelocity ?>%</span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-400">Risk Entropy</span>
                <span class="font-black text-amber-400"><?= $riskEntropy ?></span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-400">Risk Range</span>
                <span class="font-black text-sky-400"><?= round($minRisk, 1) ?> → <?= round($maxRisk, 1) ?></span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-400">Network Confidence</span>
                <span class="font-black text-emerald-400"><?= round(100 - $avgRisk, 1) ?>%</span>
              </div>
            </div>
          </div>

          <div class="bg-slate-800/80 rounded-3xl border border-slate-700 p-6 shadow-2xl">
            <h3 class="text-lg font-black mb-4 text-sky-400">Top Risk Sites</h3>
            <div class="space-y-3">
              <?php foreach ($topSites as $s): 
                $c = $s['score'] > 70 ? 'text-rose-500' : ($s['score'] > 40 ? 'text-amber-500' : 'text-emerald-500');
              ?>
              <div class="flex justify-between items-center text-sm">
                <span class="font-bold uppercase"><?= $s['name'] ?></span>
                <span class="font-black <?= $c ?>"><?= number_format($s['score'], 1) ?></span>
              </div>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="bg-gradient-to-br from-sky-600 to-indigo-700 p-6 rounded-3xl shadow-2xl">
            <h3 class="text-white font-black text-lg mb-2">Strategic Signal</h3>
            <p class="text-sky-100 text-sm mb-4">
              <?= $critical > 0 ? 'High-risk zones detected. Immediate operational intervention recommended.' : 'System operating within stable thresholds. No critical threats detected.' ?>
            </p>
            <a href="<?= ROOT_URL; ?>/sites" class="block text-center bg-white text-sky-700 font-black py-3 rounded-xl text-xs uppercase tracking-widest hover:bg-sky-50 transition-all">
              Open Sites Intelligence
            </a>
          </div>
        </div>

      </div>

    </section>
  </main>

  <?php include '../includes/footer.php'; ?>

  <script>
    window.SITES_DATA = <?= json_encode(array_map(function($site) use ($pdo) {
      $risk = getSiteRiskData($site['id'], $pdo);
      $coords = json_decode($site['coords'], true);
      return [
        'coords' => [$coords[1] ?? 0, $coords[0] ?? 0],
        'score' => $risk['final_risk_score'] ?? 0
      ];
    }, $sites)); ?>;
  </script>

  <script src="<?= ROOT_URL; ?>/assets/js/sidebar.js"></script>
  <script src="<?= ROOT_URL; ?>/assets/js/toggle-header.js"></script>
  <script src="<?= ROOT_URL; ?>/assets/js/message-modal.js"></script>
  <script src="<?= ROOT_URL; ?>/assets/js/dropdown.js"></script>
  <script src="<?= ROOT_URL; ?>/assets/js/scroll-to-top.js"></script>
  <script src="<?= ROOT_URL; ?>/assets/js/dashboard.js"></script>
</body>
</html>
