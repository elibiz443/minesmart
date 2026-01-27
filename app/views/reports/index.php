<?php
  require __DIR__ . '/../../helpers/online_connector.php';
  require __DIR__ . '/../../helpers/risk_processor.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & Analytics | MineSmart</title>

    <link href="<?php echo ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">

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
          <h1 class="text-4xl font-black text-sky-500">REPORTING CENTER</h1>
          <p class="text-slate-400">Audit-Grade Evidence Packs & Raw Data Export</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
          <div class="bg-slate-800 p-8 rounded-3xl border border-slate-700 shadow-2xl">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
              <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
              Generated Evidence Packs
            </h2>
            <div class="space-y-4">
              <div class="flex items-center justify-between p-4 bg-slate-900 rounded-xl border border-slate-700 hover:border-sky-500 transition-all cursor-pointer group">
                <div>
                  <h4 class="font-bold">Weekly Environmental Summary</h4>
                  <p class="text-xs text-slate-500">Contains Sat Findings, Edge IoT, & Fused Risk</p>
                </div>
                <div class="flex gap-2">
                  <button class="px-3 py-1 bg-slate-800 text-[10px] rounded border border-slate-700 hover:bg-sky-600 font-bold">PDF</button>
                  <button class="px-3 py-1 bg-slate-800 text-[10px] rounded border border-slate-700 hover:bg-sky-600 font-bold">CSV</button>
                </div>
              </div>

              <div class="flex items-center justify-between p-4 bg-slate-900/50 rounded-xl border border-rose-900/30">
                <div>
                  <h4 class="font-bold text-rose-400">Critical Event: InSAR Alert</h4>
                  <p class="text-xs text-slate-500">Deformation threshold exceeded - Migori Site</p>
                </div>
                <button class="px-3 py-1 bg-rose-600 text-[10px] rounded font-bold uppercase">Download</button>
              </div>
            </div>
          </div>

          <div class="bg-slate-800 p-8 rounded-3xl border border-slate-700">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
              <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
              Raw Data Access
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="p-4 bg-slate-900 rounded-2xl border border-slate-700">
                <span class="text-[10px] text-slate-500 uppercase font-bold">Satellite Layer</span>
                <h5 class="text-sm font-bold mt-1">GeoJSON Trend Map</h5>
                <button class="mt-3 w-full py-2 bg-slate-700 hover:bg-slate-600 rounded-lg text-[10px] font-bold transition-all">EXPORT</button>
              </div>
              <div class="p-4 bg-slate-900 rounded-2xl border border-slate-700">
                <span class="text-[10px] text-slate-500 uppercase font-bold">Edge IoT Layer</span>
                <h5 class="text-sm font-bold mt-1">Sensor Log (48h)</h5>
                <button class="mt-3 w-full py-2 bg-slate-700 hover:bg-slate-600 rounded-lg text-[10px] font-bold transition-all">EXPORT</button>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-slate-800/80 backdrop-blur-md p-6 rounded-2xl border border-slate-700 flex flex-col md:flex-row items-center justify-between gap-6">
          <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-sky-500/20 rounded-full flex items-center justify-center text-sky-500">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
              <p class="font-bold text-slate-200">Compliance Transparency</p>
              <p class="text-xs text-slate-400">All data is time-stamped and signed by the Edge AI Verification Engine.</p>
            </div>
          </div>
          <button class="px-8 py-3 bg-sky-600 hover:bg-sky-500 rounded-xl font-bold text-sm transition-all shadow-lg shadow-sky-900/20">REQUEST CUSTOM AUDIT</button>
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