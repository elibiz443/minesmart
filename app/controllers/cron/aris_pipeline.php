<?php

require __DIR__ . '/../helpers/online_connector.php';
require __DIR__ . '/../helpers/aris_signal_engine.php';
require __DIR__ . '/../helpers/aris_anatomy_engine.php';
require __DIR__ . '/../helpers/aris_decision_engine.php';

$sites = $pdo->query("SELECT id FROM sites")->fetchAll(PDO::FETCH_ASSOC);

foreach ($sites as $s) {

  $factors = processSignals($s['id'], $pdo);
  $anatomy = buildRiskAnatomy($s['id'], $pdo, $factors);
  $decisions = generateDecisions($s['id'], $pdo, $factors);

  foreach ($decisions as $d) {
    $stmt = $pdo->prepare("INSERT INTO aris_decisions (site_id, decision_type, urgency, action, confidence) VALUES (?,?,?,?,?)");
    $stmt->execute([$s['id'], $d['type'], $d['urgency'], $d['action'], $d['confidence']]);
  }
}
