<?php

function ms_get_latest_snapshot(int $site_id, PDO $pdo): array
{
    $stmt = $pdo->prepare("
        SELECT *
        FROM v_site_latest_snapshot
        WHERE site_id = :site_id
        LIMIT 1
    ");
    $stmt->execute([':site_id' => $site_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ?: [
        'site_id' => $site_id,
        'snapshot_id' => null,
        'snapshot_at' => null,
        'satellite_risk_score' => 0,
        'edge_risk_score' => 0,
        'final_risk_score' => 0,
        'confidence_score' => 0,
        'system_decision' => 'Normal State',
        'event_id' => null
    ];
}

function ms_get_event_factors(?int $event_id, PDO $pdo, int $limit = 6): array
{
    if (!$event_id) {
        return [];
    }

    $stmt = $pdo->prepare("
        SELECT
            ref.layer,
            rt.code,
            rt.name,
            rt.unit,
            ref.raw_value,
            ref.normalized_score,
            ref.risk_level,
            ref.note
        FROM risk_event_factors ref
        JOIN risk_types rt ON rt.id = ref.risk_type_id
        WHERE ref.event_id = :event_id
        ORDER BY ref.normalized_score DESC
        LIMIT :lim
    ");
    $stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
    $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
}

function ms_get_site_risk_packet(int $site_id, PDO $pdo): array
{
    $snap = ms_get_latest_snapshot($site_id, $pdo);
    $factors = ms_get_event_factors($snap['event_id'] ? (int)$snap['event_id'] : null, $pdo);

    return [
        'snapshot' => $snap,
        'factors' => $factors
    ];
}

function ms_score_color(float $score): string
{
    if ($score > 70) return 'critical';
    if ($score > 40) return 'warning';
    return 'normal';
}

function ms_factor_badge_text(array $factor): string
{
    $code = $factor['code'] ?? '';
    $raw = $factor['raw_value'];
    $unit = $factor['unit'] ?? '';

    if ($raw === null) {
        return $code;
    }

    $raw_fmt = number_format((float)$raw, 1);
    return $unit ? ($code . ' ' . $raw_fmt . $unit) : ($code . ' ' . $raw_fmt);
}

function ms_get_top_sites(PDO $pdo, int $limit = 6): array
{
    $stmt = $pdo->prepare("
        SELECT s.id, s.name, v.final_risk_score
        FROM sites s
        LEFT JOIN v_site_latest_snapshot v ON v.site_id = s.id
        ORDER BY v.final_risk_score DESC
        LIMIT :lim
    ");
    $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    return array_map(function($r) {
        return [
            'id' => (int)$r['id'],
            'name' => $r['name'],
            'score' => (float)($r['final_risk_score'] ?? 0)
        ];
    }, $rows);
}

function ms_get_network_stats(PDO $pdo): array
{
    $stmt = $pdo->query("
        SELECT
            COUNT(*) AS total_sites,
            SUM(CASE WHEN v.final_risk_score < 40 THEN 1 ELSE 0 END) AS normal_sites,
            SUM(CASE WHEN v.final_risk_score >= 40 AND v.final_risk_score <= 70 THEN 1 ELSE 0 END) AS warning_sites,
            SUM(CASE WHEN v.final_risk_score > 70 THEN 1 ELSE 0 END) AS critical_sites,
            AVG(COALESCE(v.final_risk_score,0)) AS avg_risk,
            MIN(COALESCE(v.final_risk_score,0)) AS min_risk,
            MAX(COALESCE(v.final_risk_score,0)) AS max_risk
        FROM sites s
        LEFT JOIN v_site_latest_snapshot v ON v.site_id = s.id
    ");
    $r = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

    $total = (int)($r['total_sites'] ?? 0);
    $normal = (int)($r['normal_sites'] ?? 0);
    $warning = (int)($r['warning_sites'] ?? 0);
    $critical = (int)($r['critical_sites'] ?? 0);

    $normalRate = $total ? round(($normal / $total) * 100, 1) : 0;
    $warningRate = $total ? round(($warning / $total) * 100, 1) : 0;
    $criticalRate = $total ? round(($critical / $total) * 100, 1) : 0;

    return [
        'total' => $total,
        'normal' => $normal,
        'warning' => $warning,
        'critical' => $critical,
        'avgRisk' => round((float)($r['avg_risk'] ?? 0), 1),
        'minRisk' => (float)($r['min_risk'] ?? 0),
        'maxRisk' => (float)($r['max_risk'] ?? 0),
        'normalRate' => $normalRate,
        'warningRate' => $warningRate,
        'criticalRate' => $criticalRate
    ];
}
