<?php
  require __DIR__ . '/../../helpers/online_connector.php';
  require __DIR__ . '/../../helpers/risk_processor.php';

  $site_id = $_GET['id'] ?? 1;
  $riskData = getSiteRiskData($site_id, $pdo);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disaster Monitoring | MineSmart</title>

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
        <div class="flex items-baseline gap-4 mb-8">
          <h1 class="text-4xl font-black">DISASTER MONITORING</h1>
          <span class="text-rose-500 font-mono animate-pulse">● LIVE SENSING</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
          <div class="bg-slate-800/80 backdrop-blur-md p-6 rounded-2xl border-t-4 border-rose-500 shadow-xl">
            <h3 class="text-slate-400 text-xs uppercase font-bold tracking-widest">InSAR Deformation</h3>
            <div class="flex items-end gap-2 mt-2">
              <span class="text-3xl font-bold"><?= $riskData['satellite_risk_index'] ?? '0.0' ?></span>
              <span class="text-slate-500 text-sm mb-1">mm/month</span>
            </div>
            <div class="mt-4 h-2 bg-slate-700 rounded-full overflow-hidden">
              <div class="bg-rose-500 h-full" style="width: <?= min(($riskData['satellite_risk_index'] ?? 0) * 10, 100) ?>%"></div>
            </div>
            <p class="text-[10px] mt-2 text-rose-400">Threshold: 5mm/mo</p>
          </div>

          <div class="bg-slate-800/80 backdrop-blur-md p-6 rounded-2xl border-t-4 border-blue-500 shadow-xl">
            <h3 class="text-slate-400 text-xs uppercase font-bold tracking-widest">Rainfall Anomaly</h3>
            <div class="flex items-end gap-2 mt-2">
              <span class="text-3xl font-bold">162</span>
              <span class="text-slate-500 text-sm mb-1">% of avg</span>
            </div>
            <div class="mt-4 h-2 bg-slate-700 rounded-full overflow-hidden">
              <div class="bg-blue-500 h-full w-[70%]"></div>
            </div>
            <p class="text-[10px] mt-2 text-blue-400">Flood risk elevated</p>
          </div>

          <div class="bg-slate-800/80 backdrop-blur-md p-6 rounded-2xl border-t-4 border-teal-500 shadow-xl">
            <h3 class="text-slate-400 text-xs uppercase font-bold tracking-widest">Edge Humidity</h3>
            <div class="flex items-end gap-2 mt-2">
              <span class="text-3xl font-bold"><?= $riskData['edge_verification_index'] ?? '0' ?></span>
              <span class="text-slate-500 text-sm mb-1">% Relative</span>
            </div>
            <div class="mt-4 h-2 bg-slate-700 rounded-full overflow-hidden">
              <div class="bg-teal-500 h-full" style="width: <?= $riskData['edge_verification_index'] ?? 0 ?>%"></div>
            </div>
            <p class="text-[10px] mt-2 text-teal-400">Ground truth saturation</p>
          </div>
        </div>

        <div class="bg-slate-800/90 backdrop-blur-lg rounded-3xl border border-slate-700 overflow-hidden shadow-2xl">
          <div class="p-6 border-b border-slate-700 flex justify-between items-center">
            <h3 class="font-bold">Edge AI Vision Validation</h3>
            <span class="px-3 py-1 bg-slate-900 rounded-full text-xs font-mono">Model: Hailo-8L | Crack Detection</span>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
            <div class="aspect-video bg-slate-900 rounded-xl border border-slate-700 relative flex items-center justify-center overflow-hidden">
              <img src="<?php echo ROOT_URL; ?>/assets/images/edge-cam-sample.webp" class="object-cover w-full h-full opacity-60">
              <div class="absolute inset-0 border-2 border-dashed border-rose-500/50 m-10"></div>
              <div class="absolute bottom-4 left-4 bg-rose-600 text-white text-[10px] font-bold px-2 py-1">CRACK_DETECTED: 0.94 CONF</div>
            </div>
            <div class="flex flex-col justify-center">
              <h4 class="text-xl font-bold mb-4 text-emerald-400">Verification Intelligence</h4>
              <ul class="space-y-4">
                <li class="flex items-start gap-3">
                  <span class="w-6 h-6 bg-slate-700 rounded flex items-center justify-center text-xs font-bold text-white">01</span>
                  <p class="text-sm text-slate-300">Satellite Sentinel-1 flagged land deformation (>5mm).</p>
                </li>
                <li class="flex items-start gap-3">
                  <span class="w-6 h-6 bg-slate-700 rounded flex items-center justify-center text-xs font-bold text-white">02</span>
                  <p class="text-sm text-slate-300">Edge Node triggered event-based capture.</p>
                </li>
                <li class="flex items-start gap-3">
                  <span class="w-6 h-6 bg-slate-700 rounded flex items-center justify-center text-xs font-bold text-white">03</span>
                  <p class="text-sm text-slate-300">Hailo AI identified surface cracks and water pooling.</p>
                </li>
              </ul>
              <div class="mt-8 flex items-center gap-4 p-4 bg-slate-900/50 rounded-xl border border-slate-700">
                <div class="text-right">
                  <span class="text-xs text-slate-500 block uppercase">Fused Risk Score</span>
                  <span class="text-2xl font-black text-rose-500"><?= number_format($riskData['final_risk_score'] ?? 0, 1) ?></span>
                </div>
                <div class="h-10 w-[2px] bg-slate-700"></div>
                <div class="flex-grow">
                  <span class="text-xs text-slate-500 block uppercase">Decision</span>
                  <span class="text-sm font-bold text-slate-200"><?= $riskData['system_decision'] ?? 'Waiting for data...' ?></span>
                </div>
              </div>
              <button class="mt-6 py-3 bg-rose-600 hover:bg-rose-700 rounded-xl font-bold uppercase tracking-widest text-sm transition-all shadow-lg shadow-rose-900/20">Escalate Critical Event</button>
            </div>
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