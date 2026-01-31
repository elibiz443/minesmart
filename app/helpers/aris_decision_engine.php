<?php

function generateDecisions($site_id, $pdo, $factors) {

  $decisions = [];

  foreach ($factors as $f) {
    if ($f['score'] > 70) {
      $decisions[] = [
        'type' => 'alert',
        'urgency' => 'critical',
        'action' => 'Immediate site inspection and evacuation readiness',
        'confidence' => $f['probability']
      ];
    }
  }

  return $decisions;
}
