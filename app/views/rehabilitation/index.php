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

  function ms_fmt_dt($s) {
    if(!$s) return '—';
    $t = strtotime($s);
    if(!$t) return '—';
    return date('M d, Y H:i', $t);
  }

  $f_ndvi = ms_find_factor($factors, 'NDVI_DROP_30D');
  $f_evi = ms_find_factor($factors, 'EVI_DROP_30D');
  $f_veg = ms_find_factor($factors, 'EDGE_VEG_COVER_PCT');
  $f_eros = ms_find_factor($factors, 'EDGE_EROSION_AREA_PCT');

  $score_final = (float)($snap['final_risk_score'] ?? 0);
  $score_conf = (float)($snap['confidence_score'] ?? 0);
  $decision = $snap['system_decision'] ?? 'Waiting for data...';

  $ndvi_drop = $f_ndvi ? ms_factor_value($f_ndvi) : ($latest_sat['ndvi_drop_30d_pct'] ?? null);
  $evi_drop = $f_evi ? ms_factor_value($f_evi) : ($latest_sat['evi_drop_30d_pct'] ?? null);

  $veg_cover = $f_veg ? ms_factor_value($f_veg) : ($latest_edge['veg_cover_pct'] ?? null);
  $erosion = $f_eros ? ms_factor_value($f_eros) : ($latest_edge['erosion_area_pct'] ?? null);

  $rehab_risk_score = $f_ndvi ? ms_factor_score($f_ndvi) : 0.0;
  $rehab_risk_level = $f_ndvi ? ms_factor_level($f_ndvi) : 'low';

  $rehab_status = 'REHABILITATION ON TRACK';
  $rehab_status_color = 'text-emerald-400';

  if($rehab_risk_level === 'high' || $rehab_risk_score >= 70) {
    $rehab_status = 'REHABILITATION AT RISK';
    $rehab_status_color = 'text-rose-400';
  } elseif($rehab_risk_level === 'medium' || $rehab_risk_score >= 40) {
    $rehab_status = 'REHABILITATION WATCHLIST';
    $rehab_status_color = 'text-amber-400';
  }

  $ndvi_unit = $f_ndvi ? ms_factor_unit($f_ndvi) : '%';
  if(!strlen($ndvi_unit)) $ndvi_unit = '%';

  $veg_unit = $f_veg ? ms_factor_unit($f_veg) : '%';
  if(!strlen($veg_unit)) $veg_unit = '%';

  $eros_unit = $f_eros ? ms_factor_unit($f_eros) : '%';
  if(!strlen($eros_unit)) $eros_unit = '%';

  $edge_image = $latest_edge['image_url'] ?? null;
  if(!$edge_image) $edge_image = $site['image_link'] ?? null;
  if(!$edge_image) $edge_image = ROOT_URL . '/assets/images/edge-cam-sample.webp';
  if(strpos($edge_image, 'http') !== 0 && strpos($edge_image, ROOT_URL) !== 0) $edge_image = ROOT_URL . $edge_image;

  $pack_stmt = $pdo->prepare("
    SELECT *
    FROM evidence_packs
    WHERE site_id = ?
    ORDER BY created_at DESC
    LIMIT 1
  ");
  $pack_stmt->execute([$site_id]);
  $latest_pack = $pack_stmt->fetch(PDO::FETCH_ASSOC) ?: [];

  $pack_status = $latest_pack['status'] ?? 'queued';
  $pack_pdf = $latest_pack['pdf_url'] ?? null;
  if($pack_pdf && strpos($pack_pdf, 'http') !== 0 && strpos($pack_pdf, ROOT_URL) !== 0) $pack_pdf = ROOT_URL . $pack_pdf;

  $pack_badge = 'text-slate-300';
  if($pack_status === 'ready') $pack_badge = 'text-emerald-400';
  if($pack_status === 'building') $pack_badge = 'text-amber-400';
  if($pack_status === 'failed') $pack_badge = 'text-rose-400';

  $obs_stmt = $pdo->prepare("
    SELECT observed_at, ndvi, evi
    FROM satellite_observations
    WHERE site_id = ?
    ORDER BY observed_at DESC
    LIMIT 12
  ");
  $obs_stmt->execute([$site_id]);
  $sat_points = array_reverse($obs_stmt->fetchAll(PDO::FETCH_ASSOC));

  $chart_labels = [];
  $chart_ndvi = [];
  $chart_evi = [];

  foreach($sat_points as $p) {
    $chart_labels[] = date('M d', strtotime($p['observed_at']));
    $chart_ndvi[] = isset($p['ndvi']) ? (float)$p['ndvi'] : null;
    $chart_evi[] = isset($p['evi']) ? (float)$p['evi'] : null;
  }

  $ndvi_now = isset($latest_sat['ndvi']) ? (float)$latest_sat['ndvi'] : null;
  $ndvi_now_txt = $ndvi_now === null ? '—' : number_format($ndvi_now, 3);

  $ndvi_drop_txt = $ndvi_drop === null ? '—' : (is_numeric($ndvi_drop) ? number_format((float)$ndvi_drop, 1) : (string)$ndvi_drop);
  $evi_drop_txt = $evi_drop === null ? '—' : (is_numeric($evi_drop) ? number_format((float)$evi_drop, 1) : (string)$evi_drop);

  $veg_txt = $veg_cover === null ? '—' : (is_numeric($veg_cover) ? number_format((float)$veg_cover, 1) : (string)$veg_cover);
  $eros_txt = $erosion === null ? '—' : (is_numeric($erosion) ? number_format((float)$erosion, 1) : (string)$erosion);

  $veg_pct = $veg_cover === null ? 0.0 : (float)$veg_cover;
  $eros_pct = $erosion === null ? 0.0 : (float)$erosion;

  if($veg_pct < 0) $veg_pct = 0;
  if($veg_pct > 100) $veg_pct = 100;
  if($eros_pct < 0) $eros_pct = 0;
  if($eros_pct > 100) $eros_pct = 100;

  $bare_soil = 100.0 - $veg_pct;
  if($bare_soil < 0) $bare_soil = 0;

  $comp = 100.0 - (0.65 * ms_percent_width($rehab_risk_score) + 0.35 * ms_percent_width($eros_pct));
  if($comp < 0) $comp = 0;
  if($comp > 100) $comp = 100;

  $comp_ring = 376.8;
  $comp_offset = $comp_ring - ($comp_ring * ($comp / 100.0));
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rehabilitation Tracking | MineSmart</title>

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
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-10">
          <div>
            <h1 class="text-4xl font-black text-emerald-500">REHABILITATION VERIFIER</h1>
            <p class="text-slate-400 text-sm">Factorized rehabilitation risk from satellite NDVI/EVI + edge vegetation/erosion verification.</p>
          </div>

          <div class="flex items-center gap-3 bg-slate-800/70 backdrop-blur-md px-4 py-3 rounded-2xl border border-slate-700">
            <div>
              <div class="text-[10px] uppercase tracking-widest font-black text-slate-500">Site</div>
              <div class="text-sm font-black uppercase"><?= htmlspecialchars($site['name'] ?? ('Site #' . $site_id)) ?></div>
              <div class="text-[10px] font-mono text-slate-500"><?= number_format($lat, 4) ?>, <?= number_format($lng, 4) ?></div>
            </div>
            <div class="h-10 w-[2px] bg-slate-700"></div>
            <div class="text-right">
              <div class="text-[10px] uppercase tracking-widest font-black text-slate-500">Decision</div>
              <div class="text-sm font-black uppercase text-slate-200"><?= htmlspecialchars($decision) ?></div>
              <div class="text-[10px] uppercase tracking-widest font-black text-slate-500">Confidence <?= number_format($score_conf, 1) ?>%</div>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
          <div class="lg:col-span-3 bg-slate-800/80 backdrop-blur-md p-8 rounded-3xl border border-slate-700 shadow-xl">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">
              <div>
                <h3 class="text-lg font-black uppercase tracking-widest text-emerald-300">Vegetation Recovery Trend</h3>
                <p class="text-xs text-slate-400 mt-1">Satellite time-series pulled from <span class="font-mono">satellite_observations</span>.</p>
              </div>
              <div class="text-right">
                <div class="text-[10px] uppercase tracking-widest font-black text-slate-500">Latest NDVI</div>
                <div class="text-2xl font-black text-slate-100"><?= $ndvi_now_txt ?></div>
                <div class="text-[10px] uppercase tracking-widest font-black text-slate-500">Last Satellite</div>
                <div class="text-xs font-mono text-slate-400"><?= ms_fmt_dt($latest_sat['observed_at'] ?? null) ?></div>
              </div>
            </div>

            <div class="bg-slate-900/60 rounded-2xl border border-slate-700 p-5">
              <div class="flex items-center justify-between mb-4">
                <div class="text-[10px] uppercase tracking-widest font-black text-slate-400">NDVI / EVI trend</div>
                <div class="text-[10px] font-mono text-slate-500">12 latest points</div>
              </div>

              <div class="grid grid-cols-12 gap-2 items-end h-40">
                <?php
                  $bars = count($chart_ndvi);
                  if($bars < 1) $bars = 12;

                  $ndvi_min = 1e9;
                  $ndvi_max = -1e9;

                  foreach($chart_ndvi as $v) {
                    if($v === null) continue;
                    if($v < $ndvi_min) $ndvi_min = $v;
                    if($v > $ndvi_max) $ndvi_max = $v;
                  }

                  if($ndvi_min === 1e9 || $ndvi_max === -1e9) {
                    $ndvi_min = 0.0;
                    $ndvi_max = 1.0;
                  }

                  $range = $ndvi_max - $ndvi_min;
                  if($range <= 0) $range = 1.0;

                  for($i=0; $i<12; $i++) {
                    $nd = $chart_ndvi[$i] ?? null;
                    $ev = $chart_evi[$i] ?? null;

                    $nd_h = 10;
                    $ev_h = 10;

                    if($nd !== null) $nd_h = (int)(10 + 90 * (($nd - $ndvi_min) / $range));
                    if($ev !== null) $ev_h = (int)(10 + 90 * (($ev - $ndvi_min) / $range));

                    $label = $chart_labels[$i] ?? '—';
                ?>
                <div class="flex flex-col items-center gap-2">
                  <div class="w-full flex items-end gap-1 h-28">
                    <div class="flex-1 bg-emerald-500/25 border-t-2 border-emerald-500 rounded-sm" style="height: <?= $nd_h ?>%"></div>
                    <div class="flex-1 bg-sky-500/20 border-t-2 border-sky-500 rounded-sm" style="height: <?= $ev_h ?>%"></div>
                  </div>
                  <div class="text-[9px] text-slate-500 font-mono"><?= htmlspecialchars($label) ?></div>
                </div>
                <?php } ?>
              </div>

              <div class="mt-4 flex items-center gap-6 text-[10px] font-black uppercase tracking-widest">
                <div class="flex items-center gap-2 text-slate-400">
                  <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                  NDVI
                </div>
                <div class="flex items-center gap-2 text-slate-400">
                  <span class="w-2 h-2 bg-sky-500 rounded-full"></span>
                  EVI
                </div>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
              <div class="bg-slate-900/50 rounded-2xl border border-slate-700 p-4">
                <div class="text-[10px] uppercase tracking-widest font-black text-slate-500">NDVI Drop 30d</div>
                <div class="mt-2 flex items-end gap-2">
                  <div class="text-xl font-black text-slate-100"><?= $ndvi_drop_txt ?></div>
                  <div class="text-xs font-bold text-slate-500 mb-1"><?= htmlspecialchars($ndvi_unit) ?></div>
                </div>
                <div class="mt-3 h-2 bg-slate-800 rounded-full overflow-hidden">
                  <div class="<?= ms_level_bar($rehab_risk_level) ?> h-full" style="width: <?= ms_percent_width($rehab_risk_score) ?>%"></div>
                </div>
                <div class="mt-2 text-[10px] uppercase tracking-widest font-black <?= ms_level_color($rehab_risk_level) ?>"><?= htmlspecialchars($rehab_risk_level) ?></div>
              </div>

              <div class="bg-slate-900/50 rounded-2xl border border-slate-700 p-4">
                <div class="text-[10px] uppercase tracking-widest font-black text-slate-500">EVI Drop 30d</div>
                <div class="mt-2 flex items-end gap-2">
                  <div class="text-xl font-black text-slate-100"><?= $evi_drop_txt ?></div>
                  <div class="text-xs font-bold text-slate-500 mb-1">%</div>
                </div>
                <div class="mt-3 h-2 bg-slate-800 rounded-full overflow-hidden">
                  <div class="bg-sky-500 h-full" style="width: <?= ms_percent_width($f_evi ? ms_factor_score($f_evi) : 0) ?>%"></div>
                </div>
                <div class="mt-2 text-[10px] uppercase tracking-widest font-black text-sky-400"><?= htmlspecialchars($f_evi ? ms_factor_level($f_evi) : 'low') ?></div>
              </div>

              <div class="bg-slate-900/50 rounded-2xl border border-slate-700 p-4">
                <div class="text-[10px] uppercase tracking-widest font-black text-slate-500">Edge Veg Cover</div>
                <div class="mt-2 flex items-end gap-2">
                  <div class="text-xl font-black text-slate-100"><?= $veg_txt ?></div>
                  <div class="text-xs font-bold text-slate-500 mb-1"><?= htmlspecialchars($veg_unit) ?></div>
                </div>
                <div class="mt-3 h-2 bg-slate-800 rounded-full overflow-hidden">
                  <div class="bg-emerald-500 h-full" style="width: <?= ms_percent_width($veg_pct) ?>%"></div>
                </div>
                <div class="mt-2 text-[10px] uppercase tracking-widest font-black text-emerald-400"><?= ms_fmt_dt($latest_edge['observed_at'] ?? null) ?></div>
              </div>

              <div class="bg-slate-900/50 rounded-2xl border border-slate-700 p-4">
                <div class="text-[10px] uppercase tracking-widest font-black text-slate-500">Edge Erosion</div>
                <div class="mt-2 flex items-end gap-2">
                  <div class="text-xl font-black text-slate-100"><?= $eros_txt ?></div>
                  <div class="text-xs font-bold text-slate-500 mb-1"><?= htmlspecialchars($eros_unit) ?></div>
                </div>
                <div class="mt-3 h-2 bg-slate-800 rounded-full overflow-hidden">
                  <div class="bg-rose-500 h-full" style="width: <?= ms_percent_width($eros_pct) ?>%"></div>
                </div>
                <div class="mt-2 text-[10px] uppercase tracking-widest font-black text-rose-400"><?= htmlspecialchars($eros_pct > 20 ? 'watchlist' : 'low') ?></div>
              </div>
            </div>
          </div>

          <div class="bg-slate-800/80 backdrop-blur-md p-8 rounded-3xl border border-slate-700 shadow-xl flex flex-col justify-center items-center text-center">
            <h3 class="text-xs font-black text-slate-500 uppercase mb-4 tracking-widest">Compliance Score</h3>
            <div class="relative w-32 h-32 flex items-center justify-center">
              <svg class="w-full h-full rotate-[-90deg]">
                <circle cx="64" cy="64" r="60" stroke="currentColor" stroke-width="8" fill="transparent" class="text-slate-700" />
                <circle cx="64" cy="64" r="60" stroke="currentColor" stroke-width="8" fill="transparent" stroke-dasharray="<?= $comp_ring ?>" stroke-dashoffset="<?= $comp_offset ?>" class="text-emerald-500" />
              </svg>
              <span class="absolute text-3xl font-black"><?= number_format($comp, 0) ?>%</span>
            </div>
            <p class="mt-4 text-xs font-black uppercase tracking-widest <?= $rehab_status_color ?>"><?= htmlspecialchars($rehab_status) ?></p>
            <p class="mt-2 text-[10px] text-slate-500 uppercase tracking-widest font-bold">Uses NDVI drop + edge erosion</p>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div class="bg-slate-800/80 backdrop-blur-md p-6 rounded-3xl border border-slate-700 shadow-xl">
            <div class="flex items-center justify-between mb-5">
              <h4 class="text-sm font-black uppercase tracking-widest text-slate-200">Edge AI Verification</h4>
              <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-slate-700 bg-slate-900/60 text-slate-300">Raspberry + Hailo</span>
            </div>

            <div class="aspect-video bg-slate-900 rounded-2xl border border-slate-700 overflow-hidden relative">
              <img src="<?= $edge_image ?>" class="object-cover w-full h-full opacity-70">
              <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>
              <div class="absolute bottom-4 left-4">
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-200">Latest Capture</div>
                <div class="text-[10px] font-mono text-slate-400"><?= htmlspecialchars($latest_edge['device_id'] ?? 'EDGE') ?></div>
              </div>
            </div>

            <div class="mt-6 space-y-4">
              <div class="flex justify-between text-xs font-black uppercase tracking-widest">
                <span class="text-slate-400">Vegetation cover</span>
                <span class="text-emerald-400"><?= number_format($veg_pct, 1) ?>%</span>
              </div>
              <div class="w-full bg-slate-700 h-1.5 rounded-full overflow-hidden">
                <div class="bg-emerald-500 h-full" style="width: <?= ms_percent_width($veg_pct) ?>%"></div>
              </div>

              <div class="flex justify-between text-xs font-black uppercase tracking-widest">
                <span class="text-slate-400">Erosion area</span>
                <span class="text-rose-400"><?= number_format($eros_pct, 1) ?>%</span>
              </div>
              <div class="w-full bg-slate-700 h-1.5 rounded-full overflow-hidden">
                <div class="bg-rose-500 h-full" style="width: <?= ms_percent_width($eros_pct) ?>%"></div>
              </div>

              <div class="flex justify-between text-xs font-black uppercase tracking-widest">
                <span class="text-slate-400">Bare soil estimate</span>
                <span class="text-amber-400"><?= number_format($bare_soil, 1) ?>%</span>
              </div>
              <div class="w-full bg-slate-700 h-1.5 rounded-full overflow-hidden">
                <div class="bg-amber-500 h-full" style="width: <?= ms_percent_width($bare_soil) ?>%"></div>
              </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
              <a href="<?= ROOT_URL; ?>/sites/intelligence.php?site_id=<?= $site_id ?>" class="flex-1 text-center py-3 rounded-xl bg-sky-500/10 border border-sky-500/30 text-sky-300 font-black text-[0.625rem] uppercase tracking-widest hover:bg-sky-500/15 transition-all">
                Open Site Intelligence
              </a>
              <a href="<?= ROOT_URL; ?>/disaster?id=<?= $site_id ?>" class="flex-1 text-center py-3 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-300 font-black text-[0.625rem] uppercase tracking-widest hover:bg-rose-500/15 transition-all">
                Disaster Monitoring
              </a>
            </div>
          </div>

          <div class="bg-slate-800/80 backdrop-blur-md p-6 rounded-3xl border border-slate-700 shadow-xl">
            <div class="flex items-center justify-between mb-5">
              <h4 class="text-sm font-black uppercase tracking-widest text-slate-200">Verification Audit Pack</h4>
              <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-slate-700 bg-slate-900/60 <?= $pack_badge ?>"><?= htmlspecialchars($pack_status) ?></span>
            </div>

            <p class="text-xs text-slate-400 mb-6">Evidence packs are stored in <span class="font-mono">evidence_packs</span> and can link to PDF/GeoJSON/CSV/images.</p>

            <div class="grid grid-cols-2 gap-4">
              <div class="bg-slate-900/50 rounded-2xl border border-slate-700 p-4">
                <div class="text-[10px] uppercase tracking-widest font-black text-slate-500">Latest pack</div>
                <div class="mt-2 text-sm font-black text-slate-200"><?= ms_fmt_dt($latest_pack['created_at'] ?? null) ?></div>
                <div class="mt-1 text-[10px] font-mono text-slate-500">Event <?= htmlspecialchars((string)($latest_pack['event_id'] ?? '—')) ?></div>
              </div>

              <div class="bg-slate-900/50 rounded-2xl border border-slate-700 p-4">
                <div class="text-[10px] uppercase tracking-widest font-black text-slate-500">Rehab driver</div>
                <div class="mt-2 text-sm font-black text-slate-200"><?= $ndvi_drop_txt ?><?= htmlspecialchars($ndvi_unit) ?></div>
                <div class="mt-1 text-[10px] font-mono text-slate-500">NDVI_DROP_30D</div>
              </div>
            </div>

            <div class="mt-6">
              <?php if($pack_pdf && $pack_status === 'ready'): ?>
              <a href="<?= htmlspecialchars($pack_pdf) ?>" class="block text-center py-3 bg-emerald-600 hover:bg-emerald-700 rounded-xl font-black uppercase tracking-widest text-[0.75rem] transition-all shadow-lg shadow-emerald-900/20">
                Download Audit Report (PDF)
              </a>
              <?php else: ?>
              <button class="w-full py-3 bg-slate-700/60 rounded-xl font-black uppercase tracking-widest text-[0.75rem] text-slate-300 cursor-not-allowed">
                Audit Report Unavailable
              </button>
              <?php endif; ?>
            </div>

            <div class="mt-6 bg-slate-900/50 rounded-2xl border border-slate-700 p-5">
              <div class="text-[10px] uppercase tracking-widest font-black text-slate-400 mb-3">What changed with the upgrade</div>
              <div class="space-y-2 text-[11px] text-slate-300 leading-relaxed">
                <div class="flex items-start gap-2">
                  <span class="w-5 h-5 bg-slate-700 rounded flex items-center justify-center text-[10px] font-black">01</span>
                  <div>Rehabilitation is no longer a single index. You see NDVI/EVI drop, plus edge vegetation + erosion confirmation.</div>
                </div>
                <div class="flex items-start gap-2">
                  <span class="w-5 h-5 bg-slate-700 rounded flex items-center justify-center text-[10px] font-black">02</span>
                  <div>Each factor has a normalized score + risk level, so you know exactly what is driving the rehabilitation outcome.</div>
                </div>
                <div class="flex items-start gap-2">
                  <span class="w-5 h-5 bg-slate-700 rounded flex items-center justify-center text-[10px] font-black">03</span>
                  <div>Evidence packs can link to the exact event and artifacts (PDF/GeoJSON/CSV/images).</div>
                </div>
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
