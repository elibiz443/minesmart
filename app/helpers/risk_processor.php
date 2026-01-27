<?php
  function calculateFusedRisk($satelliteIndex, $edgeIndex) {
    $satelliteWeight = 0.6;
    $edgeWeight = 0.4;
    return ($satelliteIndex * $satelliteWeight) + ($edgeIndex * $edgeWeight);
  }

  function getSystemDecision($satRisk, $edgeRisk) {
    if ($satRisk >= 70 && $edgeRisk >= 70) return "Confirmed Event";
    if ($satRisk >= 70 && $edgeRisk < 70) return "Monitor/Re-scan";
    if ($satRisk < 70 && $edgeRisk >= 70) return "Local Anomaly";
    return "Normal State";
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['site_id'])) {
    $site_id = $_POST['site_id'];
    $sat_val = $_POST['satellite_risk'] ?? 0;
    $edge_val = $_POST['edge_risk'] ?? 0;

    $finalScore = calculateFusedRisk($sat_val, $edge_val);
    $decision = getSystemDecision($sat_val, $edge_val);

    $stmt = $pdo->prepare("INSERT INTO site_monitoring (site_id, satellite_risk_index, edge_verification_index, final_risk_score, system_decision) 
      VALUES (?, ?, ?, ?, ?) 
      ON DUPLICATE KEY UPDATE 
      satellite_risk_index = VALUES(satellite_risk_index), 
      edge_verification_index = VALUES(edge_verification_index), 
      final_risk_score = VALUES(final_risk_score), 
      system_decision = VALUES(system_decision)");
    
    $stmt->execute([$site_id, $sat_val, $edge_val, $finalScore, $decision]);

    if (!count(debug_backtrace())) {
      echo json_encode(["score" => $finalScore, "decision" => $decision]);
      exit;
    }
  }

  function getSiteRiskData($site_id, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM site_monitoring WHERE site_id = ?");
    $stmt->execute([$site_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
?>