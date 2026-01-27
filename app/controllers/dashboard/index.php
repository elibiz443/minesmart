<?php
  $stmt = $pdo->query("SELECT * FROM sites");
  $sites = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $totalSites = count($sites);

  $prevStmt = $pdo->query("SELECT COUNT(*) FROM sites WHERE created_at <= DATE_SUB(NOW(), INTERVAL 1 MONTH)");
  $previousTotalSites = $prevStmt->fetchColumn() ?: 0;

  $totalSitesGrowth = 0;
  if ($previousTotalSites > 0) {
    $totalSitesGrowth = (($totalSites - $previousTotalSites) / $previousTotalSites) * 100;
  }

  $critical = 0;
  $warning = 0;
  $normal = 0;
  $totalRisk = 0;
  $maxRisk = 0;
  $minRisk = 100;
  $riskValues = [];
  $topSites = [];

  foreach ($sites as $site) {
    $risk = getSiteRiskData($site['id'], $pdo);
    $score = $risk['final_risk_score'] ?? 0;
    $totalRisk += $score;
    $riskValues[] = $score;
    
    if ($score > $maxRisk) $maxRisk = $score;
    if ($score < $minRisk) $minRisk = $score;

    if ($score > 70) {
      $critical++;
    } elseif ($score > 40) {
      $warning++;
    } else {
      $normal++;
    }

    $topSites[] = [
      'name' => $site['name'],
      'score' => $score,
      'decision' => $risk['system_decision'] ?? 'Normal State'
    ];
  }

  usort($topSites, fn($a, $b) => $b['score'] <=> $a['score']);
  $topSites = array_slice($topSites, 0, 5);

  $avgRisk = $totalSites ? round($totalRisk / $totalSites, 2) : 0;
  $criticalRate = $totalSites ? round(($critical / $totalSites) * 100, 1) : 0;
  $warningRate = $totalSites ? round(($warning / $totalSites) * 100, 1) : 0;
  $normalRate = $totalSites ? round(($normal / $totalSites) * 100, 1) : 0;

  $riskEntropy = 0;
  if ($totalSites > 0) {
    $variance = array_sum(array_map(fn($v) => pow($v - $avgRisk, 2), $riskValues)) / $totalSites;
    $riskEntropy = round(sqrt($variance), 2);
  }

  $stabilityIndex = round(100 - $criticalRate - ($warningRate / 2), 1);
  $stabilityIndex = max(0, min(100, $stabilityIndex));

  $threatVelocity = round((($critical + $warning) / max($totalSites, 1)) * 100, 1);
?>
