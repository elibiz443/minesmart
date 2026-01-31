<?php
  require __DIR__ . '/../../helpers/online_connector.php';
  require __DIR__ . '/../../helpers/risk_anatomy.php';

  $site_id = $_GET['site'] ?? 1;

  $site = $pdo->prepare("SELECT * FROM sites WHERE id=?");
  $site->execute([$site_id]);
  $site = $site->fetch(PDO::FETCH_ASSOC);

  $anatomy = getRiskAnatomy($site_id, $pdo);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>MineSmart Risk Anatomy</title>
  <link href="<?= ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen">

<div class="p-8 space-y-6">

<div class="flex justify-between items-center">
  <div>
    <h1 class="text-3xl font-black text-sky-400">Risk Anatomy</h1>
    <p class="text-xs text-slate-500"><?= strtoupper($site['name']) ?></p>
  </div>
  <div class="text-xs font-bold flex gap-6">
    <div class="text-emerald-400">Confidence <?= $anatomy['confidence'] ?>%</div>
    <div class="text-amber-400">Trend <?= $anatomy['trend'] ?>%</div>
  </div>
</div>

<div class="grid grid-cols-12 gap-6">

<div class="col-span-12 lg:col-span-4 bg-slate-900 border border-slate-800 rounded-2xl p-6">
  <h3 class="text-xs uppercase font-black text-slate-400 mb-4">Hazard Layer</h3>
  <div class="text-5xl font-black text-rose-500"><?= $anatomy['hazard'] ?></div>
  <div class="mt-3 text-xs text-slate-500">Probability of physical failure</div>
</div>

<div class="col-span-12 lg:col-span-4 bg-slate-900 border border-slate-800 rounded-2xl p-6">
  <h3 class="text-xs uppercase font-black text-slate-400 mb-4">Trigger Layer</h3>
  <div class="text-5xl font-black text-amber-500"><?= $anatomy['trigger'] ?></div>
  <div class="mt-3 text-xs text-slate-500">Events initiating risk</div>
</div>

<div class="col-span-12 lg:col-span-4 bg-slate-900 border border-slate-800 rounded-2xl p-6">
  <h3 class="text-xs uppercase font-black text-slate-400 mb-4">Structural Layer</h3>
  <div class="text-5xl font-black text-purple-500"><?= $anatomy['structure'] ?></div>
  <div class="mt-3 text-xs text-slate-500">Geotechnical vulnerability</div>
</div>

<div class="col-span-12 lg:col-span-6 bg-slate-900 border border-slate-800 rounded-2xl p-6">
  <h3 class="text-xs uppercase font-black text-slate-400 mb-4">Environmental Layer</h3>
  <div class="flex items-end gap-6">
    <div class="text-6xl font-black text-sky-400"><?= $anatomy['environment'] ?></div>
    <div class="text-xs text-slate-500 mb-2">Vegetation + moisture + weather impact</div>
  </div>
</div>

<div class="col-span-12 lg:col-span-6 bg-slate-900 border border-slate-800 rounded-2xl p-6">
  <h3 class="text-xs uppercase font-black text-slate-400 mb-4">Satellite vs Edge Influence</h3>
  <div class="grid grid-cols-2 gap-4">
    <div class="bg-slate-800 rounded-xl p-4">
      <div class="text-xs text-slate-400">Satellite</div>
      <div class="text-3xl font-black text-sky-500"><?= round($anatomy['satellite'],1) ?></div>
    </div>
    <div class="bg-slate-800 rounded-xl p-4">
      <div class="text-xs text-slate-400">Edge AI</div>
      <div class="text-3xl font-black text-emerald-500"><?= round($anatomy['edge'],1) ?></div>
    </div>
  </div>
</div>

<div class="col-span-12 bg-slate-900 border border-slate-800 rounded-2xl p-6">
  <h3 class="text-xs uppercase font-black text-slate-400 mb-4">Risk Decomposition Graph</h3>
  <div class="grid grid-cols-5 gap-4 text-center text-xs font-bold">
    <div class="bg-rose-500/20 rounded-xl p-4 text-rose-400">Hazard<br><?= $anatomy['hazard'] ?></div>
    <div class="bg-amber-500/20 rounded-xl p-4 text-amber-400">Trigger<br><?= $anatomy['trigger'] ?></div>
    <div class="bg-purple-500/20 rounded-xl p-4 text-purple-400">Structure<br><?= $anatomy['structure'] ?></div>
    <div class="bg-sky-500/20 rounded-xl p-4 text-sky-400">Environment<br><?= $anatomy['environment'] ?></div>
    <div class="bg-emerald-500/20 rounded-xl p-4 text-emerald-400">Confidence<br><?= $anatomy['confidence'] ?></div>
  </div>
</div>

</div>

</div>

</body>
</html>
