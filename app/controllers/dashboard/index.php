<?php

require __DIR__ . '/../../helpers/online_connector.php';
require __DIR__ . '/../../helpers/risk_processor.php';

$stmt = $pdo->query("SELECT * FROM sites");
$sites = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stats = ms_get_network_stats($pdo);

$totalSites = $stats['total'];
$normal = $stats['normal'];
$warning = $stats['warning'];
$critical = $stats['critical'];
$avgRisk = $stats['avgRisk'];
$minRisk = $stats['minRisk'];
$maxRisk = $stats['maxRisk'];
$normalRate = $stats['normalRate'];
$warningRate = $stats['warningRate'];
$criticalRate = $stats['criticalRate'];

$totalSitesGrowth = 0;
$stabilityIndex = 99;

$topSites = ms_get_top_sites($pdo, 6);

$threatVelocity = $criticalRate;
$riskEntropy = round(($warningRate * 0.5) + ($criticalRate * 1.0), 1);
