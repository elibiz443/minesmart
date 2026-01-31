<?php
  require __DIR__ . '/../../helpers/online_connector.php';
  require __DIR__ . '/../../helpers/risk_brain.php';

  $zones = $pdo->query("SELECT * FROM twin_zones")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>MineSmart Digital Twin Risk Brain</title>
  <link href="<?= ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="bg-slate-950 text-slate-100 min-h-screen">

<div class="h-screen flex flex-col">

<div class="p-6 border-b border-slate-800 flex justify-between items-center">
  <div>
    <h1 class="text-2xl font-black text-purple-400">Digital Twin Risk Brain</h1>
    <p class="text-xs text-slate-500">MineSmart Cognitive Geospatial Intelligence</p>
  </div>
  <div class="text-xs font-bold text-emerald-400">
    System Status: ACTIVE
  </div>
</div>

<div class="grid grid-cols-12 gap-6 p-6 flex-1 overflow-hidden">

<div class="col-span-12 lg:col-span-3 space-y-6 overflow-y-auto">

<div class="bg-slate-900 border border-slate-800 rounded-2xl p-5">
  <h3 class="text-xs uppercase font-black text-slate-400 mb-4">Zone Risk Brain</h3>
  <div class="space-y-3 text-xs">
    <?php foreach ($zones as $z):
      $b = computeZoneRiskBrain($z['id'], $pdo);
      $c = $b['failure_probability'] > 70 ? 'text-rose-500' : ($b['failure_probability'] > 40 ? 'text-amber-500' : 'text-emerald-500');
    ?>
    <div class="flex justify-between">
      <span><?= strtoupper($z['zone_type']) ?> #<?= $z['id'] ?></span>
      <span class="<?= $c ?> font-black"><?= $b['failure_probability'] ?>%</span>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<div class="bg-slate-900 border border-slate-800 rounded-2xl p-5">
  <h3 class="text-xs uppercase font-black text-slate-400 mb-4">Cognitive Drivers</h3>
  <div class="space-y-2 text-xs">
    <div class="flex justify-between"><span>Hazard Weight</span><span class="text-rose-400">35%</span></div>
    <div class="flex justify-between"><span>Trigger Weight</span><span class="text-amber-400">25%</span></div>
    <div class="flex justify-between"><span>Structure Weight</span><span class="text-purple-400">20%</span></div>
    <div class="flex justify-between"><span>Environment Weight</span><span class="text-sky-400">10%</span></div>
    <div class="flex justify-between"><span>Trend Weight</span><span class="text-emerald-400">10%</span></div>
  </div>
</div>

</div>

<div class="col-span-12 lg:col-span-6 bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
  <div id="map" class="w-full h-full"></div>
</div>

<div class="col-span-12 lg:col-span-3 space-y-6 overflow-y-auto">

<div class="bg-slate-900 border border-slate-800 rounded-2xl p-5">
  <h3 class="text-xs uppercase font-black text-slate-400 mb-4">Failure Probability Timeline</h3>
  <div class="space-y-2 text-xs">
    <?php foreach ($zones as $z):
      $b = computeZoneRiskBrain($z['id'], $pdo);
    ?>
    <div class="flex justify-between">
      <span>Zone <?= $z['id'] ?></span>
      <span class="font-black"><?= $b['trend'] ?>%</span>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<div class="bg-slate-900 border border-slate-800 rounded-2xl p-5">
  <h3 class="text-xs uppercase font-black text-slate-400 mb-4">Decision Engine</h3>
  <div class="space-y-2 text-xs">
    <div class="text-emerald-400">Monitor Zones &gt; 40%</div>
    <div class="text-amber-400">Deploy Edge Sensors &gt; 60%</div>
    <div class="text-rose-400">Immediate Action &gt; 75%</div>
  </div>
</div>

</div>

</div>

</div>

<script>
  var map = L.map('map').setView([0,0], 2);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

  let zones = <?= json_encode(array_map(function($z) use ($pdo) {
    $b = computeZoneRiskBrain($z['id'], $pdo);
    $g = json_decode($z['geometry'], true);
    return [
      'id' => $z['id'],
      'coords' => $g,
      'risk' => $b['failure_probability']
    ];
  }, $zones)); ?>;

  zones.forEach(z => {
    let color = z.risk > 70 ? 'red' : (z.risk > 40 ? 'orange' : 'green');
    if (z.coords && z.coords.length) {
      L.polygon(z.coords, {color: color}).addTo(map)
        .bindPopup("Zone " + z.id + " | Failure Probability: " + z.risk + "%");
    }
  });
</script>

</body>
</html>
