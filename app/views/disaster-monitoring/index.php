<?php
  require __DIR__ . '/../../helpers/online_connector.php';
  require __DIR__ . '/../../helpers/risk_processor.php';

  $site_id = (int)($_GET['id'] ?? 1);

  $site_stmt = $pdo->prepare("SELECT * FROM sites WHERE id = ? LIMIT 1");
  $site_stmt->execute([$site_id]);
  $site = $site_stmt->fetch(PDO::FETCH_ASSOC);

  if(!$site) {
    $site_id = 1;
    $site_stmt = $pdo->prepare("SELECT * FROM sites WHERE id = ? LIMIT 1");
    $site_stmt->execute([$site_id]);
    $site = $site_stmt->fetch(PDO::FETCH_ASSOC);
  }

  $packet = ms_get_site_risk_packet($site_id, $pdo);
  $snap = $packet['snapshot'] ?? [];
  $factors = $packet['factors'] ?? [];
  $latest_sat = $packet['latest_satellite'] ?? [];
  $latest_edge = $packet['latest_edge'] ?? [];
  $event = $packet['event'] ?? [];

  $coords = json_decode($site['coords'] ?? '', true);
  $lat = 0.0;
  $lng = 0.0;

  if(is_array($coords)) {
    if(isset($coords['lat']) && isset($coords['lng'])) {
      $lat = (float)$coords['lat'];
      $lng = (float)$coords['lng'];
    } elseif(isset($coords[0]) && isset($coords[1])) {
      $lng = (float)$coords[0];
      $lat = (float)$coords[1];
    }
  }

  function ms_factor_code($f) {
    if(isset($f['code'])) return (string)$f['code'];
    if(isset($f['risk_type_code'])) return (string)$f['risk_type_code'];
    if(isset($f['risk_code'])) return (string)$f['risk_code'];
    if(isset($f['type_code'])) return (string)$f['type_code'];
    return '';
  }

  function ms_factor_name($f) {
    if(isset($f['name'])) return (string)$f['name'];
    if(isset($f['risk_type_name'])) return (string)$f['risk_type_name'];
    if(isset($f['type_name'])) return (string)$f['type_name'];
    return '';
  }

  function ms_factor_value($f) {
    if(isset($f['raw_value'])) return $f['raw_value'];
    if(isset($f['value'])) return $f['value'];
    return null;
  }

  function ms_factor_unit($f) {
    if(isset($f['unit'])) return (string)$f['unit'];
    if(isset($f['risk_unit'])) return (string)$f['risk_unit'];
    return '';
  }

  function ms_factor_score($f) {
    if(isset($f['normalized_score'])) return (float)$f['normalized_score'];
    if(isset($f['score'])) return (float)$f['score'];
    return 0.0;
  }

  function ms_factor_level($f) {
    if(isset($f['risk_level'])) return (string)$f['risk_level'];
    if(isset($f['level'])) return (string)$f['level'];
    return 'low';
  }

  function ms_level_color($lvl) {
    if($lvl === 'high') return 'text-rose-400';
    if($lvl === 'medium') return 'text-amber-400';
    return 'text-emerald-400';
  }

  function ms_level_bar($lvl) {
    if($lvl === 'high') return 'bg-rose-500';
    if($lvl === 'medium') return 'bg-amber-500';
    return 'bg-emerald-500';
  }

  function ms_find_factor($factors, $code) {
    foreach($factors as $f) {
      if(ms_factor_code($f) === $code) return $f;
    }
    return null;
  }

  function ms_percent_width($score) {
    $s = (float)$score;
    if($s < 0) $s = 0;
    if($s > 100) $s = 100;
    return $s;
  }

  $f_insar = ms_find_factor($factors, 'INSAR_DEFORMATION_MM_MO');
  $f_rain = ms_find_factor($factors, 'RAINFALL_ANOMALY_PCT');
  $f_soil = ms_find_factor($factors, 'SOIL_MOISTURE_PROXY_TREND');
  $f_ndvi = ms_find_factor($factors, 'NDVI_DROP_30D');
  $f_wet = ms_find_factor($factors, 'EDGE_WETNESS_PCT');
  $f_crk = ms_find_factor($factors, 'EDGE_CRACK_SCORE');

  $score_final = (float)($snap['final_risk_score'] ?? 0);
  $score_sat = (float)($snap['satellite_risk_score'] ?? 0);
  $score_edge = (float)($snap['edge_risk_score'] ?? 0);
  $score_conf = (float)($snap['confidence_score'] ?? 0);
  $decision = $snap['system_decision'] ?? 'Waiting for data...';

  $event_level = $event['level'] ?? ($snap['level'] ?? 'info');
  $event_status = $event['status'] ?? 'open';

  $badge_color = $score_final > 70 ? 'text-rose-500' : ($score_final > 40 ? 'text-amber-500' : 'text-emerald-500');
  $badge_border = $score_final > 70 ? 'border-rose-500/30' : ($score_final > 40 ? 'border-amber-500/30' : 'border-emerald-500/30');

  $img = $latest_edge['image_url'] ?? null;
  if(!$img) $img = $site['image_link'] ?? null;
  if(!$img) $img = ROOT_URL . '/assets/images/edge-cam-sample.webp';
  if(strpos($img, 'http') !== 0 && strpos($img, ROOT_URL) !== 0) $img = ROOT_URL . $img;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disaster Monitoring | MineSmart</title>

    <link href="<?php echo ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">

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
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-8">
          <div class="flex items-baseline gap-4">
            <h1 class="text-4xl font-black">DISASTER MONITORING</h1>
            <span class="text-rose-500 font-mono animate-pulse">● LIVE SENSING</span>
          </div>

          <div class="flex items-center gap-3 bg-slate-800/70 backdrop-blur-md px-4 py-3 rounded-2xl border <?= $badge_border ?>">
            <div>
              <div class="text-[10px] uppercase tracking-widest font-black text-slate-400">Site</div>
              <div class="text-sm font-black uppercase"><?= htmlspecialchars($site['name'] ?? ('Site #' . $site_id)) ?></div>
              <div class="text-[10px] font-mono text-slate-500"><?= number_format($lat, 4) ?>, <?= number_format($lng, 4) ?></div>
            </div>
            <div class="h-10 w-[2px] bg-slate-700"></div>
            <div class="text-right">
              <div class="text-[10px] uppercase tracking-widest font-black text-slate-400">Fused Score</div>
              <div class="text-3xl font-black <?= $badge_color ?>"><?= number_format($score_final, 1) ?></div>
              <div class="text-[10px] font-bold uppercase tracking-widest text-slate-500"><?= htmlspecialchars($decision) ?></div>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
          <div class="bg-slate-800/80 backdrop-blur-md p-6 rounded-2xl border border-slate-700 shadow-xl">
            <h3 class="text-slate-400 text-xs uppercase font-bold tracking-widest">Satellite Score</h3>
            <div class="flex items-end gap-2 mt-2">
              <span class="text-3xl font-black text-sky-400"><?= number_format($score_sat, 1) ?></span>
              <span class="text-slate-500 text-sm mb-1">/100</span>
            </div>
            <div class="mt-4 h-2 bg-slate-700 rounded-full overflow-hidden">
              <div class="bg-sky-500 h-full" style="width: <?= ms_percent_width($score_sat) ?>%"></div>
            </div>
            <p class="text-[10px] mt-2 text-slate-500 uppercase tracking-widest font-bold">Copernicus + InSAR + Indices</p>
          </div>

          <div class="bg-slate-800/80 backdrop-blur-md p-6 rounded-2xl border border-slate-700 shadow-xl">
            <h3 class="text-slate-400 text-xs uppercase font-bold tracking-widest">Edge Score</h3>
            <div class="flex items-end gap-2 mt-2">
              <span class="text-3xl font-black text-emerald-400"><?= number_format($score_edge, 1) ?></span>
              <span class="text-slate-500 text-sm mb-1">/100</span>
            </div>
            <div class="mt-4 h-2 bg-slate-700 rounded-full overflow-hidden">
              <div class="bg-emerald-500 h-full" style="width: <?= ms_percent_width($score_edge) ?>%"></div>
            </div>
            <p class="text-[10px] mt-2 text-slate-500 uppercase tracking-widest font-bold">Raspberry + Hailo Vision + Sensors</p>
          </div>

          <div class="bg-slate-800/80 backdrop-blur-md p-6 rounded-2xl border border-slate-700 shadow-xl">
            <h3 class="text-slate-400 text-xs uppercase font-bold tracking-widest">Confidence</h3>
            <div class="flex items-end gap-2 mt-2">
              <span class="text-3xl font-black text-purple-400"><?= number_format($score_conf, 1) ?></span>
              <span class="text-slate-500 text-sm mb-1">%</span>
            </div>
            <div class="mt-4 h-2 bg-slate-700 rounded-full overflow-hidden">
              <div class="bg-purple-500 h-full" style="width: <?= ms_percent_width($score_conf) ?>%"></div>
            </div>
            <p class="text-[10px] mt-2 text-slate-500 uppercase tracking-widest font-bold">Cross-layer agreement</p>
          </div>

          <div class="bg-slate-800/80 backdrop-blur-md p-6 rounded-2xl border border-slate-700 shadow-xl">
            <h3 class="text-slate-400 text-xs uppercase font-bold tracking-widest">Event State</h3>
            <div class="flex items-end gap-2 mt-2">
              <span class="text-2xl font-black text-slate-100 uppercase"><?= htmlspecialchars($event_status) ?></span>
            </div>
            <div class="mt-3 flex items-center gap-2">
              <span class="px-3 py-1 rounded-full text-[10px] uppercase tracking-widest font-black border border-slate-700 bg-slate-900/60 text-slate-200"><?= htmlspecialchars($event_level) ?></span>
              <span class="px-3 py-1 rounded-full text-[10px] uppercase tracking-widest font-black border border-slate-700 bg-slate-900/60 text-slate-200"><?= htmlspecialchars($decision) ?></span>
            </div>
            <p class="text-[10px] mt-3 text-slate-500 uppercase tracking-widest font-bold">Risk Event lifecycle</p>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
          <div class="lg:col-span-2 bg-slate-800/90 backdrop-blur-lg rounded-3xl border border-slate-700 overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-slate-700 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
              <h3 class="font-black uppercase tracking-widest text-sm text-slate-200">Factorized Drivers</h3>
              <span class="px-3 py-1 bg-slate-900 rounded-full text-xs font-mono border border-slate-700 text-slate-300">Event factors (satellite + edge) explain the score</span>
            </div>

            <div class="p-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php
                  $cards = [
                    ['f' => $f_insar, 'title' => 'InSAR Deformation', 'fallback_unit' => 'mm/month'],
                    ['f' => $f_rain, 'title' => 'Rainfall Anomaly', 'fallback_unit' => '%'],
                    ['f' => $f_soil, 'title' => 'Soil Moisture Trend', 'fallback_unit' => 'index'],
                    ['f' => $f_ndvi, 'title' => 'NDVI Drop (30d)', 'fallback_unit' => '%'],
                    ['f' => $f_wet, 'title' => 'Edge Wetness', 'fallback_unit' => '%'],
                    ['f' => $f_crk, 'title' => 'Edge Crack Score', 'fallback_unit' => 'score']
                  ];

                  foreach($cards as $c) {
                    $f = $c['f'];
                    $title = $c['title'];
                    $unit = $c['fallback_unit'];

                    $raw = null;
                    $score = 0.0;
                    $level = 'low';
                    $name = $title;

                    if($f) {
                      $raw = ms_factor_value($f);
                      $score = ms_factor_score($f);
                      $level = ms_factor_level($f);
                      $u = ms_factor_unit($f);
                      if(strlen($u)) $unit = $u;
                      $n = ms_factor_name($f);
                      if(strlen($n)) $name = $n;
                    }

                    $val_text = $raw === null ? '—' : (is_numeric($raw) ? number_format((float)$raw, 3) : (string)$raw);
                    $color = ms_level_color($level);
                    $bar = ms_level_bar($level);
                ?>
                <div class="bg-slate-900/50 rounded-2xl border border-slate-700 p-5">
                  <div class="flex justify-between items-start gap-4">
                    <div>
                      <div class="text-[10px] uppercase tracking-widest font-black text-slate-500"><?= htmlspecialchars($name) ?></div>
                      <div class="mt-2 flex items-end gap-2">
                        <div class="text-2xl font-black text-slate-100"><?= $val_text ?></div>
                        <div class="text-xs font-bold text-slate-500 mb-1"><?= htmlspecialchars($unit) ?></div>
                      </div>
                    </div>
                    <div class="text-right">
                      <div class="text-[10px] uppercase tracking-widest font-black text-slate-500">Score</div>
                      <div class="text-2xl font-black <?= $color ?>"><?= number_format($score, 1) ?></div>
                      <div class="text-[10px] uppercase tracking-widest font-black <?= $color ?>"><?= htmlspecialchars($level) ?></div>
                    </div>
                  </div>
                  <div class="mt-4 h-2 bg-slate-800 rounded-full overflow-hidden">
                    <div class="<?= $bar ?> h-full" style="width: <?= ms_percent_width($score) ?>%"></div>
                  </div>
                  <div class="mt-3 text-[10px] text-slate-500 font-mono"><?= htmlspecialchars(ms_factor_code($f ?? [])) ?></div>
                </div>
                <?php } ?>
              </div>

              <div class="mt-8 flex items-center gap-4 p-4 bg-slate-900/50 rounded-xl border border-slate-700">
                <div class="text-right">
                  <span class="text-xs text-slate-500 block uppercase tracking-widest font-black">Fused Risk Score</span>
                  <span class="text-2xl font-black <?= $badge_color ?>"><?= number_format($score_final, 1) ?></span>
                </div>
                <div class="h-10 w-[2px] bg-slate-700"></div>
                <div class="flex-grow">
                  <span class="text-xs text-slate-500 block uppercase tracking-widest font-black">Decision</span>
                  <span class="text-sm font-black text-slate-200 uppercase tracking-widest"><?= htmlspecialchars($decision) ?></span>
                </div>
                <a href="<?= ROOT_URL; ?>/sites/intelligence.php?site_id=<?= $site_id ?>" class="px-4 py-3 rounded-xl bg-sky-500/10 border border-sky-500/30 text-sky-300 font-black text-[0.625rem] uppercase tracking-widest hover:bg-sky-500/15 transition-all">
                  Open Site Intelligence
                </a>
              </div>
            </div>
          </div>

          <div class="bg-slate-800/90 backdrop-blur-lg rounded-3xl border border-slate-700 overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-slate-700 flex justify-between items-center">
              <h3 class="font-black uppercase tracking-widest text-sm text-slate-200">Edge Capture</h3>
              <span class="px-3 py-1 bg-slate-900 rounded-full text-xs font-mono border border-slate-700 text-slate-300">Vision + Sensors</span>
            </div>

            <div class="p-6">
              <div class="aspect-video bg-slate-900 rounded-2xl border border-slate-700 overflow-hidden relative">
                <img src="<?= $img ?>" class="object-cover w-full h-full opacity-70">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>
                <div class="absolute bottom-4 left-4 bg-slate-700/60 p-2 rounded-md">
                  <div class="text-[10px] font-black uppercase tracking-widest text-slate-200">Latest Edge Image</div>
                  <div class="text-[10px] font-mono text-slate-400"><?= htmlspecialchars($latest_edge['device_id'] ?? 'EDGE') ?></div>
                </div>
              </div>

              <div class="mt-6 space-y-3">
                <div class="flex justify-between text-xs">
                  <span class="text-slate-400 font-bold uppercase tracking-widest">Veg Cover</span>
                  <span class="font-black text-emerald-400"><?= isset($latest_edge['veg_cover_pct']) ? number_format((float)$latest_edge['veg_cover_pct'], 1) : '—' ?>%</span>
                </div>
                <div class="flex justify-between text-xs">
                  <span class="text-slate-400 font-bold uppercase tracking-widest">Erosion</span>
                  <span class="font-black text-amber-400"><?= isset($latest_edge['erosion_area_pct']) ? number_format((float)$latest_edge['erosion_area_pct'], 1) : '—' ?>%</span>
                </div>
                <div class="flex justify-between text-xs">
                  <span class="text-slate-400 font-bold uppercase tracking-widest">Cracks</span>
                  <span class="font-black text-rose-400"><?= isset($latest_edge['crack_score']) ? number_format((float)$latest_edge['crack_score'], 1) : '—' ?></span>
                </div>
                <div class="flex justify-between text-xs">
                  <span class="text-slate-400 font-bold uppercase tracking-widest">Wetness</span>
                  <span class="font-black text-sky-400"><?= isset($latest_edge['wetness_pct']) ? number_format((float)$latest_edge['wetness_pct'], 1) : '—' ?>%</span>
                </div>
                <div class="flex justify-between text-xs">
                  <span class="text-slate-400 font-bold uppercase tracking-widest">Humidity</span>
                  <span class="font-black text-purple-400"><?= isset($latest_edge['humidity_pct']) ? number_format((float)$latest_edge['humidity_pct'], 1) : '—' ?>%</span>
                </div>
              </div>

              <div class="mt-8">
                <a href="<?= ROOT_URL; ?>/alerts" class="block text-center py-3 bg-rose-600 hover:bg-rose-700 rounded-xl font-black uppercase tracking-widest text-[0.75rem] transition-all shadow-lg shadow-rose-900/20">
                  View Alerts
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-slate-800/90 backdrop-blur-lg rounded-3xl border border-slate-700 overflow-hidden shadow-2xl">
          <div class="p-6 border-b border-slate-700 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <h3 class="font-black uppercase tracking-widest text-sm text-slate-200">Operational Flow</h3>
            <div class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Satellite flag → Edge verify → Fuse decision</div>
          </div>

          <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-slate-900/50 rounded-2xl border border-slate-700 p-6">
              <div class="text-[10px] uppercase tracking-widest font-black text-slate-500">01</div>
              <div class="mt-2 text-sm font-black uppercase tracking-widest text-slate-200">Satellite Ingest</div>
              <div class="mt-3 text-xs text-slate-400 leading-relaxed">
                48h ingestion builds preliminary risk maps using NDVI/EVI, rainfall anomaly, soil moisture proxy, and InSAR deformation.
              </div>
            </div>

            <div class="bg-slate-900/50 rounded-2xl border border-slate-700 p-6">
              <div class="text-[10px] uppercase tracking-widest font-black text-slate-500">02</div>
              <div class="mt-2 text-sm font-black uppercase tracking-widest text-slate-200">Edge Verification</div>
              <div class="mt-3 text-xs text-slate-400 leading-relaxed">
                If satellite risk ≥ medium, edge node captures images and runs Hailo AI for cracks, erosion, vegetation cover, and water pooling.
              </div>
            </div>

            <div class="bg-slate-900/50 rounded-2xl border border-slate-700 p-6">
              <div class="text-[10px] uppercase tracking-widest font-black text-slate-500">03</div>
              <div class="mt-2 text-sm font-black uppercase tracking-widest text-slate-200">Fusion Decision</div>
              <div class="mt-3 text-xs text-slate-400 leading-relaxed">
                Satellite and edge scores are fused into a final score with confidence. The event is logged with factor evidence and alerts are generated.
              </div>
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
