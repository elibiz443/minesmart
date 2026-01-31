<?php
  require __DIR__ . '/../../helpers/online_connector.php';
  require __DIR__ . '/../../helpers/causal_graph.php';
  require __DIR__ . '/../../helpers/domino_engine.php';

  $zone_id = $_GET['zone'] ?? 1;

  [$nodes, $edges] = getCausalGraph($zone_id, $pdo);
  $graph = propagateRisk($nodes, $edges);
  $domino = detectDominoFailures($graph);

  $simulation = simulateScenario($zone_id, $pdo, 'rainfall', 30);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>MineSmart Causal Graph AI Simulator</title>
  <link href="<?= ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">
</head>

<body class="bg-slate-950 text-slate-100 min-h-screen">

<div class="p-8 space-y-6">

<div class="flex justify-between items-center">
  <div>
    <h1 class="text-3xl font-black text-rose-400">Causal Graph AI Simulator</h1>
    <p class="text-xs text-slate-500">Zone <?= $zone_id ?> · Cognitive Risk Propagation Engine</p>
  </div>
  <div class="text-xs font-bold text-emerald-400">
    Nodes <?= count($nodes) ?> · Edges <?= count($edges) ?>
  </div>
</div>

<div class="grid grid-cols-12 gap-6">

<div class="col-span-12 lg:col-span-4 bg-slate-900 border border-slate-800 rounded-2xl p-6">
  <h3 class="text-xs uppercase font-black text-slate-400 mb-4">Causal Nodes</h3>
  <div class="space-y-2 text-xs">
    <?php foreach ($nodes as $n): ?>
    <div class="flex justify-between">
      <span><?= strtoupper($n['node_type']) ?></span>
      <span class="font-black"><?= round($graph[$n['id']] ?? 0,1) ?></span>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<div class="col-span-12 lg:col-span-4 bg-slate-900 border border-slate-800 rounded-2xl p-6">
  <h3 class="text-xs uppercase font-black text-slate-400 mb-4">Domino Failures</h3>
  <div class="space-y-2 text-xs">
    <?php if (!$domino): ?>
      <div class="text-emerald-400">No cascading failures detected</div>
    <?php else: foreach ($domino as $f): ?>
      <div class="text-rose-400">
        Node <?= $f['node_id'] ?> · <?= $f['risk'] ?>%
      </div>
    <?php endforeach; endif; ?>
  </div>
</div>

<div class="col-span-12 lg:col-span-4 bg-slate-900 border border-slate-800 rounded-2xl p-6">
  <h3 class="text-xs uppercase font-black text-slate-400 mb-4">What-If Simulation</h3>
  <div class="space-y-2 text-xs">
    <div class="text-slate-400 mb-2">Scenario: +30% Rainfall Shock</div>
    <?php foreach ($simulation as $node_id => $risk): ?>
    <div class="flex justify-between">
      <span>Node <?= $node_id ?></span>
      <span class="font-black text-amber-400"><?= round($risk,1) ?></span>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<div class="col-span-12 bg-slate-900 border border-slate-800 rounded-2xl p-6">
  <h3 class="text-xs uppercase font-black text-slate-400 mb-4">Causal Graph Matrix</h3>
  <div class="grid grid-cols-6 gap-3 text-xs text-center">
    <?php foreach ($edges as $e): ?>
      <div class="bg-slate-800 rounded-xl p-3">
        <div class="text-sky-400">Node <?= $e['from_node'] ?></div>
        <div class="text-slate-400">→</div>
        <div class="text-purple-400">Node <?= $e['to_node'] ?></div>
        <div class="text-xs text-amber-400 mt-1">Weight <?= $e['weight'] ?></div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

</div>

</div>

</body>
</html>
