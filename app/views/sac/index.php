<?php
  require __DIR__ . '/../../helpers/online_connector.php';

  $systemic = $pdo->query("SELECT * FROM sac_systemic_risk ORDER BY risk_score DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
  $actions = $pdo->query("SELECT * FROM sac_actions ORDER BY created_at DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>MineSmart Sovereign AI Core</title>
  <link href="<?= ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen p-8">

<div class="mb-8">
  <h1 class="text-3xl font-black text-indigo-400">MineSmart Sovereign AI Core</h1>
  <p class="text-xs text-slate-500">National Risk Intelligence Command Layer</p>
</div>

<div class="grid grid-cols-12 gap-6">

<div class="col-span-12 lg:col-span-6 bg-slate-900 border border-slate-800 rounded-2xl p-6">
  <h3 class="text-xs font-black text-slate-400 mb-4">Systemic Risk Hotspots</h3>
  <div class="space-y-2 text-xs">
    <?php foreach ($systemic as $s): ?>
    <div class="flex justify-between">
      <span>ENTITY <?= $s['scope_id'] ?></span>
      <span class="font-black text-rose-400"><?= round($s['risk_score'],1) ?></span>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<div class="col-span-12 lg:col-span-6 bg-slate-900 border border-slate-800 rounded-2xl p-6">
  <h3 class="text-xs font-black text-slate-400 mb-4">Sovereign Actions</h3>
  <div class="space-y-2 text-xs">
    <?php foreach ($actions as $a): ?>
    <div class="text-amber-400"><?= strtoupper($a['action_type']) ?> · <?= $a['command'] ?></div>
    <?php endforeach; ?>
  </div>
</div>

<div class="col-span-12 bg-slate-900 border border-slate-800 rounded-2xl p-6">
  <h3 class="text-xs font-black text-slate-400 mb-4">Collapse Probability Matrix</h3>
  <div class="grid grid-cols-6 gap-3 text-xs">
    <?php foreach ($systemic as $s): ?>
    <div class="bg-slate-800 rounded-xl p-4 text-center">
      <div class="text-sky-400">ENTITY <?= $s['scope_id'] ?></div>
      <div class="text-rose-400 text-lg font-black"><?= round($s['collapse_probability'] * 100,1) ?>%</div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

</div>

</body>
</html>
