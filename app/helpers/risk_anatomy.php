<?php

function getRiskAnatomy($site_id, $pdo) {

  $q = $pdo->prepare("SELECT component, value, source FROM risk_components WHERE site_id=? ORDER BY created_at DESC LIMIT 20");
  $q->execute([$site_id]);
  $data = $q->fetchAll(PDO::FETCH_ASSOC);

  $anatomy = [
    'hazard' => 0,
    'trigger' => 0,
    'structure' => 0,
    'environment' => 0,
    'satellite' => 0,
    'edge' => 0,
    'trend' => rand(-10, 15),
    'confidence' => 0
  ];

  foreach ($data as $d) {
    switch ($d['component']) {
      case 'landslide': $anatomy['hazard'] += $d['value']; break;
      case 'rainfall': $anatomy['trigger'] += $d['value']; break;
      case 'deformation': $anatomy['structure'] += $d['value']; break;
      case 'ndvi': $anatomy['environment'] += $d['value']; break;
    }

    if ($d['source'] === 'satellite') $anatomy['satellite'] += $d['value'];
    if ($d['source'] === 'edge') $anatomy['edge'] += $d['value'];
  }

  $anatomy['hazard'] = min(100, $anatomy['hazard']);
  $anatomy['trigger'] = min(100, $anatomy['trigger']);
  $anatomy['structure'] = min(100, $anatomy['structure']);
  $anatomy['environment'] = min(100, $anatomy['environment']);

  $anatomy['confidence'] = round(($anatomy['satellite']*0.6 + $anatomy['edge']*0.4), 2);

  return $anatomy;
}
