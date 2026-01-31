<?php

function detectDominoFailures($graph, $threshold = 70) {

  $failures = [];

  foreach ($graph as $node_id => $risk) {
    if ($risk >= $threshold) {
      $failures[] = [
        'node_id' => $node_id,
        'risk' => round($risk, 2)
      ];
    }
  }

  return $failures;
}
