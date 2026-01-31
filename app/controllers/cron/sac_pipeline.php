<?php

require __DIR__ . '/../helpers/online_connector.php';
require __DIR__ . '/../helpers/sac_propagation_engine.php';
require __DIR__ . '/../helpers/sac_forecast_engine.php';
require __DIR__ . '/../helpers/sac_collapse_engine.php';
require __DIR__ . '/../helpers/sac_priority_engine.php';
require __DIR__ . '/../helpers/sac_decision_engine.php';

$states = propagateNationalRisk($pdo);

foreach ($states as $node_id => $risk) {

  $connectivity = rand(1, 10) / 10;
  $impact = rand(40, 90);

  $collapse = computeCollapseProbability($risk, $connectivity);
  $priority = computePriority($risk, $impact, $connectivity);

  $stmt = $pdo->prepare("INSERT INTO sac_systemic_risk (scope, scope_id, risk_score, instability_index, collapse_probability) VALUES ('site',?,?,?,?)");
  $stmt->execute([$node_id, $risk, $priority, $collapse]);

  $action = generateSovereignActions($node_id, $risk);

  if ($action) {
    $stmt = $pdo->prepare("INSERT INTO sac_actions (scope, scope_id, action_type, command, confidence) VALUES ('site',?,?,?,?,?)");
    $stmt->execute([$node_id, $action['action_type'], $action['command'], $action['confidence']]);
  }
}
