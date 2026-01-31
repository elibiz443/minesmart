<?php
  require __DIR__ . '/../../helpers/online_connector.php';

  $site_id = $_GET['site'] ?? 1;

  $factors = $pdo->prepare("SELECT * FROM risk_factors WHERE site_id=? ORDER BY score DESC");
  $factors->execute([$site_id]);
  $factors = $factors->fetchAll(PDO::FETCH_ASSOC);

  $anatomy = $pdo->prepare("SELECT * FROM risk_anatomy WHERE site_id=?");
  $anatomy->execute([$site_id]);
  $anatomy = $anatomy->fetchAll(PDO::FETCH_ASSOC);

  $decisions = $pdo->prepare("SELECT * FROM aris_decisions WHERE site_id=? ORDER BY created_at DESC LIMIT 5");
  $decisions->execute([$site_id]);
  $decisions = $decisions->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>MineSmart ARIS Command Center</title>
  <link href="<?= ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">
</head>
<body class="bg-slate-950 text-slate-100 p-8">

<div class="grid grid-cols-12 gap-6">

<div class="col-span-12 lg:col-span-4 bg-slate-900 border border-slate-800 rounded-2xl p-6">
  <h3 class="text-xs font-black text-slate-400 mb-4">Risk Factors</h3>
  <div class="space-y-2 text-xs">
    <?php foreach ($factors as $f): ?>
    <div class="flex justify-between">
      <span><?= strtoupper($f['factor_type']) ?></span>
      <span class="font-black text-rose-400"><?= round($f['score'],1) ?></span>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<div class="col-span-12 lg:col-span-4 bg-slate-900 border border-slate-800 rounded-2xl p-6">
  <h3 class="text-xs font-black text-slate-400 mb-4">Risk Anatomy</h3>
  <div class="space-y-2 text-xs">
    <?php foreach ($anatomy as $a): ?>
    <div class="flex justify-between">
      <span><?= strtoupper($a['risk_domain']) ?></span>
      <span class="font-black text-amber-400"><?= round($a['contribution'],1) ?></span>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<div class="col-span-12 lg:col-span-4 bg-slate-900 border border-slate-800 rounded-2xl p-6">
  <h3 class="text-xs font-black text-slate-400 mb-4">Autonomous Decisions</h3>
  <div class="space-y-2 text-xs">
    <?php foreach ($decisions as $d): ?>
    <div class="text-rose-400"><?= strtoupper($d['urgency']) ?> · <?= $d['action'] ?></div>
    <?php endforeach; ?>
  </div>
</div>

</div>

</body>
</html>
