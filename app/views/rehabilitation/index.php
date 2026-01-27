<?php
  require __DIR__ . '/../../helpers/online_connector.php';
  require __DIR__ . '/../../helpers/risk_processor.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rehabilitation Tracking | MineSmart</title>

    <!-- CSS -->
    <link href="<?php echo ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">

    <!-- FAV and Icons -->
    <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL; ?>/assets/images/favicon.webp" />
  </head>

  <body class="relative bg-slate-900 text-slate-100 max-w-full overflow-x-hidden">
    <div class="absolute inset-0 bg-[url('../../assets/images/dashboard.webp')] bg-cover bg-center opacity-40 -z-10"></div>
    <?php include '../includes/sidebar.php'; ?>
    <?php require __DIR__ . '/../includes/message.php'; ?>

    <main id="mainContent" class="relative min-h-screen w-[calc(100%-12rem)] ml-auto flex-1 flex flex-col overflow-hidden transition-all duration-500 ease-in-out">
      <?php include '../includes/header.php'; ?>
      <?php require __DIR__ . '/../includes/navigation.php'; ?>

      <section class="overflow-y-auto p-8 flex-grow pt-18">
        <div class="mb-12">
          <h1 class="text-4xl font-black text-emerald-500">REHABILITATION VERIFIER</h1>
          <p class="text-slate-400">Automated Environmental Compliance Scoring</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
          <div class="lg:col-span-3 bg-slate-800 p-8 rounded-3xl border border-slate-700">
            <h3 class="text-lg font-bold mb-6">NDVI Vegetation Recovery Trend (Sentinel-2)</h3>
            <div class="h-64 flex items-end gap-2 px-4">
              <div class="flex-1 bg-emerald-500/20 border-t-2 border-emerald-500 h-[20%]"></div>
              <div class="flex-1 bg-emerald-500/20 border-t-2 border-emerald-500 h-[35%]"></div>
              <div class="flex-1 bg-emerald-500/20 border-t-2 border-emerald-500 h-[30%]"></div>
              <div class="flex-1 bg-emerald-500/20 border-t-2 border-emerald-500 h-[55%]"></div>
              <div class="flex-1 bg-emerald-500/20 border-t-2 border-emerald-500 h-[70%]"></div>
              <div class="flex-1 bg-emerald-500/20 border-t-2 border-emerald-500 h-[85%]"></div>
            </div>
            <div class="flex justify-between mt-4 text-[10px] text-slate-500 font-mono">
              <span>AUG 2025</span>
              <span>SEP 2025</span>
              <span>OCT 2025</span>
              <span>NOV 2025</span>
              <span>DEC 2025</span>
              <span>JAN 2026</span>
            </div>
          </div>
          
          <div class="bg-slate-800 p-8 rounded-3xl border border-slate-700 flex flex-col justify-center items-center text-center">
            <h3 class="text-xs font-bold text-slate-500 uppercase mb-4 tracking-tighter">AI Compliance Score</h3>
            <div class="relative w-32 h-32 flex items-center justify-center">
              <svg class="w-full h-full rotate-[-90deg]">
                <circle cx="64" cy="64" r="60" stroke="currentColor" stroke-width="8" fill="transparent" class="text-slate-700" />
                <circle cx="64" cy="64" r="60" stroke="currentColor" stroke-width="8" fill="transparent" stroke-dasharray="376.8" stroke-dashoffset="75.3" class="text-emerald-500" />
              </svg>
              <span class="absolute text-3xl font-black">82%</span>
            </div>
            <p class="mt-4 text-xs text-emerald-400 font-bold">REHABILITATION ON TRACK</p>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700">
            <h4 class="text-sm font-bold mb-4 flex items-center gap-2">
              <span class="w-2 h-2 bg-emerald-500 rounded-full"></span> 
              Edge AI Vision: % Vegetation Cover
            </h4>
            <div class="space-y-3">
              <div class="flex justify-between text-xs mb-1"><span>Native Grass</span><span>65%</span></div>
              <div class="w-full bg-slate-700 h-1.5 rounded-full"><div class="bg-emerald-500 h-full w-[65%]"></div></div>
              
              <div class="flex justify-between text-xs mb-1"><span>Shrubland</span><span>12%</span></div>
              <div class="w-full bg-slate-700 h-1.5 rounded-full"><div class="bg-teal-500 h-full w-[12%]"></div></div>
              
              <div class="flex justify-between text-xs mb-1"><span>Bare Soil</span><span>23%</span></div>
              <div class="w-full bg-slate-700 h-1.5 rounded-full"><div class="bg-rose-500 h-full w-[23%]"></div></div>
            </div>
          </div>
          
          <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700">
            <h4 class="text-sm font-bold mb-4">Verification Audit Pack</h4>
            <p class="text-xs text-slate-400 mb-6">Time-stamped evidence for regulatory submission.</p>
            <div class="grid grid-cols-4 gap-2">
              <div class="aspect-square bg-slate-900 rounded border border-slate-700"></div>
              <div class="aspect-square bg-slate-900 rounded border border-slate-700"></div>
              <div class="aspect-square bg-slate-900 rounded border border-slate-700"></div>
              <div class="aspect-square bg-slate-700 rounded border border-slate-700 flex items-center justify-center text-[10px] text-white font-bold">+14</div>
            </div>
            <button class="w-full mt-6 py-2 bg-emerald-600 hover:bg-emerald-700 rounded-lg text-xs font-bold uppercase tracking-widest transition-all">Download Audit Report (PDF)</button>
          </div>
        </div>
      </section>
    </main>

    <?php include '../includes/footer.php'; ?>

    <script src="<?= ROOT_URL; ?>/assets/js/toggle-header.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/sidebar.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/message-modal.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/dropdown.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/scroll-to-top.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/side-nav.js"></script>
  </body>
</html>