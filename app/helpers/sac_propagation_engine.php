<?php

function propagateNationalRisk($pdo) {

  $nodes = $pdo->query("SELECT * FROM sac_nodes")->fetchAll(PDO::FETCH_ASSOC);
  $links = $pdo->query("SELECT * FROM sac_links")->fetchAll(PDO::FETCH_ASSOC);

  $states = [];

  foreach ($nodes as $n) {
    $states[$n['id']] = $n['risk_level'] * $n['confidence'];
  }

  foreach ($links as $l) {
    if (isset($states[$l['from_node']])) {
      $states[$l['to_node']] = ($states[$l['to_node']] ?? 0) + ($states[$l['from_node']] * $l['influence']);
    }
  }

  return $states;
}
