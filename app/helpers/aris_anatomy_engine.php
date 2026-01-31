<?php

function buildRiskAnatomy($site_id, $pdo, $factors) {

  $domains = [
    'geotechnical' => 0,
    'hydrological' => 0,
    'environmental' => 0,
    'operational' => 0,
    'infrastructural' => 0
  ];

  foreach ($factors as $f) {
    if (in_array($f['type'], ['slope_instability','subsidence'])) {
      $domains['geotechnical'] += $f['score'];
    }
    if (in_array($f['type'], ['flooding','soil_saturation'])) {
      $domains['hydrological'] += $f['score'];
    }
    if (in_array($f['type'], ['vegetation_loss'])) {
      $domains['environmental'] += $f['score'];
    }
  }

  return $domains;
}
