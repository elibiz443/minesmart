<?php

function getFeature($site_id, $name, $pdo) {
  $stmt = $pdo->prepare("
    SELECT feature_value
    FROM risk_features
    WHERE site_id = ? AND feature_name = ?
    ORDER BY created_at DESC
    LIMIT 1
  ");
  $stmt->execute([$site_id, $name]);
  return (float)($stmt->fetchColumn() ?? 0);
}

function avg($arr) {
  if (count($arr) === 0) return 0;
  return array_sum($arr) / count($arr);
}

function computeRiskSnapshot($site_id, $pdo) {
  $ndvi = getFeature($site_id, 'NDVI_DROP', $pdo);
  $deform = getFeature($site_id, 'SAR_DEFORMATION', $pdo);
  $rain = getFeature($site_id, 'RAIN_ANOMALY', $pdo);
  $soil = getFeature($site_id, 'SOIL_MOISTURE', $pdo);

  $erosion = getFeature($site_id, 'EDGE_EROSION', $pdo);
  $crack = getFeature($site_id, 'EDGE_CRACK', $pdo);
  $water = getFeature($site_id, 'EDGE_WATER', $pdo);
  $veg = getFeature($site_id, 'EDGE_VEGETATION_LOSS', $pdo);

  $satellite = avg([$ndvi, $deform, $rain, $soil]);
  $edge = avg([$erosion, $crack, $water, $veg]);

  $landslide = avg([$deform, $rain, $erosion]);
  $flood = avg([$rain, $soil, $water]);
  $rehab = avg([$ndvi, $veg]);

  $fused = (0.6 * $satellite) + (0.4 * $edge);
  $confidence = 100 - abs($satellite - $edge);

  $state = 'Normal State';
  if ($satellite >= 60 && $edge >= 60) $state = 'Confirmed Event';
  else if ($satellite >= 60 && $edge < 40) $state = 'Monitor/Re-scan';
  else if ($satellite < 40 && $edge >= 60) $state = 'Local Anomaly';

  $stmt = $pdo->prepare("
    INSERT INTO risk_snapshots
    (site_id, satellite_score, edge_score, fused_score, confidence_score, system_state)
    VALUES (?, ?, ?, ?, ?, ?)
  ");
  $stmt->execute([$site_id, $satellite, $edge, $fused, $confidence, $state]);

  return compact('satellite','edge','fused','confidence','landslide','flood','rehab','state');
}
