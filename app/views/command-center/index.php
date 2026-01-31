<?php
  require __DIR__ . '/../../helpers/online_connector.php';
  require __DIR__ . '/../../helpers/risk_engine.php';

  $stmt = $pdo->query("SELECT * FROM sites");
  $sites = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $global = [
    'landslide' => 0,
    'flood' => 0,
    'rehab' => 0,
    'structural' => 0,
    'confidence' => 0,
    'fused' => 0,
    'count' => 0
  ];

  foreach ($sites as $s) {
    $r = computeRiskSnapshot($s['id'], $pdo);
    $global['landslide'] += $r['landslide'];
    $global['flood'] += $r['flood'];
    $global['rehab'] += $r['rehab'];
    $global['fused'] += $r['fused'];
    $global['confidence'] += $r['confidence'];
    $global['count']++;
  }

  foreach ($global as $k => $v) {
    if ($k !== 'count') {
      $global[$k] = $global['count'] > 0 ? round($v / $global['count'], 2) : 0;
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MineSmart Command Center</title>
  <link href="<?= ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="bg-slate-950 text-slate-100 min-h-screen overflow-hidden">

<div class="flex h-screen">

<div class="w-64 bg-slate-900 border-r border-slate-800 flex flex-col">
  <div class="p-6 text-xl font-black text-sky-500 tracking-wide">
    MineSmart
  </div>
  <div class="flex-1 px-4 space-y-2 text-xs uppercase font-bold">
    <a href="#" class="block px-4 py-3 rounded-lg bg-sky-500/10 text-sky-400">Command Center</a>
    <a href="<?= ROOT_URL; ?>/sites" class="block px-4 py-3 rounded-lg hover:bg-slate-800">Sites Intelligence</a>
    <a href="<?= ROOT_URL; ?>/disaster-center.php" class="block px-4 py-3 rounded-lg hover:bg-slate-800">Disaster Center</a>
    <a href="<?= ROOT_URL; ?>/rehabilitation-center.php" class="block px-4 py-3 rounded-lg hover:bg-slate-800">Rehabilitation</a>
    <a href="<?= ROOT_URL; ?>/risk-forecast.php" class="block px-4 py-3 rounded-lg hover:bg-slate-800">Risk Forecast</a>
  </div>
</div>

<div class="flex-1 flex flex-col">

<div class="p-6 border-b border-slate-800 flex justify-between items-center">
  <div>
    <h1 class="text-2xl font-black text-sky-400">Command Center</h1>
    <p class="text-xs text-slate-500">Satellite-First · Edge-Verified · Decision-Driven</p>
  </div>
  <div class="flex gap-6 text-xs font-bold">
    <div class="text-emerald-400">Confidence <?= $global['confidence'] ?>%</div>
    <div class="text-amber-400">Global Risk <?= $global['fused'] ?></div>
  </div>
</div>

<div class="grid grid-cols-12 gap-6 p-6 flex-1 overflow-hidden">

<div class="col-span-12 lg:col-span-3 space-y-6 overflow-y-auto">

<div class="bg-slate-900 border border-slate-800 rounded-2xl p-5">
  <h3 class="text-xs uppercase font-black text-slate-400 mb-4">Global Risk Radar</h3>
  <div class="space-y-3 text-sm">
    <div class="flex justify-between">
      <span>Landslide</span>
      <span class="text-rose-500 font-black"><?= $global['landslide'] ?></span>
    </div>
    <div class="flex justify-between">
      <span>Flood</span>
      <span class="text-amber-500 font-black"><?= $global['flood'] ?></span>
    </div>
    <div class="flex justify-between">
      <span>Rehabilitation</span>
      <span class="text-sky-500 font-black"><?= $global['rehab'] ?></span>
    </div>
  </div>
</div>

<div class="bg-slate-900 border border-slate-800 rounded-2xl p-5">
  <h3 class="text-xs uppercase font-black text-slate-400 mb-4">Risk Vector Matrix</h3>
  <div class="grid grid-cols-2 gap-3 text-xs font-bold">
    <div class="bg-slate-800 rounded-lg p-3 text-rose-400">LS</div>
    <div class="bg-slate-800 rounded-lg p-3 text-amber-400">FL</div>
    <div class="bg-slate-800 rounded-lg p-3 text-sky-400">RH</div>
    <div class="bg-slate-800 rounded-lg p-3 text-purple-400">SF</div>
  </div>
</div>

<div class="bg-slate-900 border border-slate-800 rounded-2xl p-5">
  <h3 class="text-xs uppercase font-black text-slate-400 mb-4">Live Intelligence Feed</h3>
  <div class="space-y-3 text-xs">
    <?php foreach ($sites as $s): 
      $r = computeRiskSnapshot($s['id'], $pdo);
      $c = $r['fused'] > 70 ? 'text-rose-500' : ($r['fused'] > 40 ? 'text-amber-500' : 'text-emerald-500');
    ?>
    <div class="flex justify-between">
      <span><?= strtoupper($s['name']) ?></span>
      <span class="<?= $c ?> font-black"><?= number_format($r['fused'],1) ?></span>
    </div>
    <?php endforeach; ?>
  </div>
</div>

</div>

<div class="col-span-12 lg:col-span-6 bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden relative">
  <div id="map" class="w-full h-full"></div>
</div>

<div class="col-span-12 lg:col-span-3 space-y-6 overflow-y-auto">

<div class="bg-slate-900 border border-slate-800 rounded-2xl p-5">
  <h3 class="text-xs uppercase font-black text-slate-400 mb-4">Causal Risk Engine</h3>
  <div class="space-y-2 text-xs">
    <div class="flex justify-between"><span>Satellite Influence</span><span class="text-sky-400">60%</span></div>
    <div class="flex justify-between"><span>Edge Influence</span><span class="text-emerald-400">40%</span></div>
    <div class="flex justify-between"><span>Anomaly Index</span><span class="text-rose-400"><?= rand(10,80) ?></span></div>
  </div>
</div>

<div class="bg-slate-900 border border-slate-800 rounded-2xl p-5">
  <h3 class="text-xs uppercase font-black text-slate-400 mb-4">Risk Timeline</h3>
  <div class="space-y-2 text-xs">
    <?php foreach ($sites as $s):
      $r = computeRiskSnapshot($s['id'], $pdo);
    ?>
    <div class="flex justify-between">
      <span><?= strtoupper($s['name']) ?></span>
      <span class="font-black"><?= number_format($r['confidence'],1) ?>%</span>
    </div>
    <?php endforeach; ?>
  </div>
</div>

</div>

</div>

</div>

</div>

<script>
  var map = L.map('map').setView([0,0], 2);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

  window.SITES = <?= json_encode(array_map(function($s) use ($pdo) {
    $r = computeRiskSnapshot($s['id'], $pdo);
    $c = json_decode($s['coords'], true);
    return [
      'name' => $s['name'],
      'lat' => $c[1] ?? 0,
      'lng' => $c[0] ?? 0,
      'risk' => $r['fused']
    ];
  }, $sites)); ?>;

  SITES.forEach(s => {
    let color = s.risk > 70 ? 'red' : (s.risk > 40 ? 'orange' : 'green');
    L.circleMarker([s.lat, s.lng], {radius: 8, color: color}).addTo(map)
      .bindPopup(s.name + ' | Risk: ' + s.risk);
  });
</script>

</body>
</html>
