<?php

function getCausalGraph($zone_id, $pdo) {

  $nodes = $pdo->prepare("SELECT * FROM causal_nodes WHERE zone_id=?");
  $nodes->execute([$zone_id]);
  $nodes = $nodes->fetchAll(PDO::FETCH_ASSOC);

  $edges = $pdo->query("SELECT * FROM causal_edges")->fetchAll(PDO::FETCH_ASSOC);

  return [$nodes, $edges];
}

function propagateRisk($nodes, $edges) {

  $graph = [];
  foreach ($nodes as $n) {
    $graph[$n['id']] = $n['value'] * $n['confidence'];
  }

  foreach ($edges as $e) {
    if (isset($graph[$e['from_node']])) {
      $graph[$e['to_node']] = ($graph[$e['to_node']] ?? 0) + $graph[$e['from_node']] * $e['weight'];
    }
  }

  return $graph;
}

function simulateScenario($zone_id, $pdo, $shock_node_type, $shock_value) {

  $q = $pdo->prepare("SELECT * FROM causal_nodes WHERE zone_id=?");
  $q->execute([$zone_id]);
  $nodes = $q->fetchAll(PDO::FETCH_ASSOC);

  foreach ($nodes as &$n) {
    if ($n['node_type'] === $shock_node_type) {
      $n['value'] += $shock_value;
    }
  }

  $edges = $pdo->query("SELECT * FROM causal_edges")->fetchAll(PDO::FETCH_ASSOC);
  $result = propagateRisk($nodes, $edges);

  return $result;
}
