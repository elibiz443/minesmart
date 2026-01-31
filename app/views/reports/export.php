<?php
require __DIR__ . '/../../helpers/online_connector.php';

$dataset = $_GET['dataset'] ?? '';
$format  = $_GET['format'] ?? 'csv';
$days    = isset($_GET['days']) ? (int)$_GET['days'] : 30;
$site_id = isset($_GET['site_id']) ? (int)$_GET['site_id'] : 0;
$event_id = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;
$id      = isset($_GET['id']) ? (int)$_GET['id'] : 0;

function dl_headers($filename, $mime) {
    header('Content-Type: ' . $mime);
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    header('X-Content-Type-Options: nosniff');
}

function as_csv($rows) {
    $out = fopen('php://output', 'w');
    if (!$rows || count($rows) === 0) {
        fputcsv($out, ['empty']);
        fclose($out);
        return;
    }
    fputcsv($out, array_keys($rows[0]));
    foreach ($rows as $r) fputcsv($out, $r);
    fclose($out);
}

function as_json($rows) {
    echo json_encode($rows, JSON_PRETTY_PRINT);
}

$site_filter = $site_id > 0 ? " AND site_id = :site_id " : "";

switch ($dataset) {

    case 'risk_events': {
        $sql = "SELECT * FROM risk_events WHERE started_at >= (NOW() - INTERVAL :days DAY) $site_filter ORDER BY started_at DESC";
        $st = $pdo->prepare($sql);
        $st->bindValue(':days', $days, PDO::PARAM_INT);
        if ($site_id > 0) $st->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $st->execute();
        $rows = $st->fetchAll(PDO::FETCH_ASSOC);

        if ($format === 'json') { dl_headers("risk_events_{$days}d.json", 'application/json'); return as_json($rows); }
        dl_headers("risk_events_{$days}d.csv", 'text/csv'); return as_csv($rows);
    }

    case 'event_factors': {
        if ($event_id <= 0) { http_response_code(400); exit('Missing event_id'); }
        $st = $pdo->prepare("SELECT * FROM risk_event_factors WHERE event_id = :event_id ORDER BY id ASC");
        $st->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $st->execute();
        $rows = $st->fetchAll(PDO::FETCH_ASSOC);

        dl_headers("event_{$event_id}_factors.csv", 'text/csv'); return as_csv($rows);
    }

    case 'satellite_observations': {
        $sql = "SELECT * FROM satellite_observations WHERE observed_at >= (NOW() - INTERVAL :days DAY) $site_filter ORDER BY observed_at DESC";
        $st = $pdo->prepare($sql);
        $st->bindValue(':days', $days, PDO::PARAM_INT);
        if ($site_id > 0) $st->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $st->execute();
        $rows = $st->fetchAll(PDO::FETCH_ASSOC);

        if ($format === 'json') { dl_headers("satellite_observations_{$days}d.json", 'application/json'); return as_json($rows); }
        dl_headers("satellite_observations_{$days}d.csv", 'text/csv'); return as_csv($rows);
    }

    case 'edge_observations': {
        $sql = "SELECT * FROM edge_observations WHERE observed_at >= (NOW() - INTERVAL :days DAY) $site_filter ORDER BY observed_at DESC";
        $st = $pdo->prepare($sql);
        $st->bindValue(':days', $days, PDO::PARAM_INT);
        if ($site_id > 0) $st->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $st->execute();
        $rows = $st->fetchAll(PDO::FETCH_ASSOC);

        if ($format === 'json') { dl_headers("edge_observations_{$days}d.json", 'application/json'); return as_json($rows); }
        dl_headers("edge_observations_{$days}d.csv", 'text/csv'); return as_csv($rows);
    }

    case 'site_runs': {
        $sql = "SELECT * FROM site_runs WHERE created_at >= (NOW() - INTERVAL :days DAY) $site_filter ORDER BY created_at DESC";
        $st = $pdo->prepare($sql);
        $st->bindValue(':days', $days, PDO::PARAM_INT);
        if ($site_id > 0) $st->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $st->execute();
        $rows = $st->fetchAll(PDO::FETCH_ASSOC);

        if ($format === 'json') { dl_headers("site_runs_{$days}d.json", 'application/json'); return as_json($rows); }
        dl_headers("site_runs_{$days}d.csv", 'text/csv'); return as_csv($rows);
    }

    case 'snapshots': {
        $sql = "SELECT * FROM site_risk_snapshots WHERE snapshot_at >= (NOW() - INTERVAL :days DAY) $site_filter ORDER BY snapshot_at DESC";
        $st = $pdo->prepare($sql);
        $st->bindValue(':days', $days, PDO::PARAM_INT);
        if ($site_id > 0) $st->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $st->execute();
        $rows = $st->fetchAll(PDO::FETCH_ASSOC);

        if ($format === 'json') { dl_headers("snapshots_{$days}d.json", 'application/json'); return as_json($rows); }
        dl_headers("snapshots_{$days}d.csv", 'text/csv'); return as_csv($rows);
    }

    case 'snapshot_row': {
        if ($id <= 0) { http_response_code(400); exit('Missing id'); }
        $st = $pdo->prepare("SELECT * FROM site_risk_snapshots WHERE id = :id LIMIT 1");
        $st->bindValue(':id', $id, PDO::PARAM_INT);
        $st->execute();
        $row = $st->fetch(PDO::FETCH_ASSOC);
        $rows = $row ? [$row] : [];

        if ($format === 'json') { dl_headers("snapshot_{$id}.json", 'application/json'); return as_json($row ?? new stdClass()); }
        dl_headers("snapshot_{$id}.csv", 'text/csv'); return as_csv($rows);
    }

    case 'alerts': {
        $sql = "SELECT * FROM alerts WHERE created_at >= (NOW() - INTERVAL :days DAY) " . ($site_id>0 ? " AND site_id=:site_id " : "") . " ORDER BY created_at DESC";
        $st = $pdo->prepare($sql);
        $st->bindValue(':days', $days, PDO::PARAM_INT);
        if ($site_id > 0) $st->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $st->execute();
        $rows = $st->fetchAll(PDO::FETCH_ASSOC);

        if ($format === 'json') { dl_headers("alerts_{$days}d.json", 'application/json'); return as_json($rows); }
        dl_headers("alerts_{$days}d.csv", 'text/csv'); return as_csv($rows);
    }

    case 'evidence_packs': {
        $sql = "SELECT * FROM evidence_packs WHERE created_at >= (NOW() - INTERVAL :days DAY) $site_filter ORDER BY created_at DESC";
        $st = $pdo->prepare($sql);
        $st->bindValue(':days', $days, PDO::PARAM_INT);
        if ($site_id > 0) $st->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $st->execute();
        $rows = $st->fetchAll(PDO::FETCH_ASSOC);

        dl_headers("evidence_packs_{$days}d.csv", 'text/csv'); return as_csv($rows);
    }

    case 'geojson_latest': {
        // expects sites.coords in {"lng":..,"lat":..}
        $sql = "SELECT id,name,coords FROM sites " . ($site_id>0 ? " WHERE id=:site_id " : "") . " ORDER BY name ASC";
        $st = $pdo->prepare($sql);
        if ($site_id>0) $st->bindValue(':site_id', $site_id, PDO::PARAM_INT);
        $st->execute();
        $sites = $st->fetchAll(PDO::FETCH_ASSOC);

        $features = [];
        foreach ($sites as $s) {
            $c = json_decode($s['coords'] ?? '', true);
            $lng = isset($c['lng']) ? (float)$c['lng'] : 0;
            $lat = isset($c['lat']) ? (float)$c['lat'] : 0;
            if ($lat === 0 && $lng === 0) continue;

            $features[] = [
                "type" => "Feature",
                "geometry" => ["type" => "Point", "coordinates" => [$lng, $lat]],
                "properties" => ["id" => (int)$s['id'], "name" => $s['name']]
            ];
        }

        dl_headers("sites_latest.geojson", 'application/geo+json');
        echo json_encode(["type"=>"FeatureCollection","features"=>$features], JSON_PRETTY_PRINT);
        exit;
    }

    case 'hash_manifest': {
        dl_headers("hash_manifest_{$days}d.txt", 'text/plain');
        echo "MineSmart Export Manifest\n";
        echo "Generated: ".gmdate('c')." UTC\n";
        echo "Window: last {$days} days\n";
        echo "Site filter: ".($site_id>0 ? $site_id : "ALL")."\n\n";
        echo "NOTE: Add SHA256 hashing after you generate files physically on disk.\n";
        exit;
    }

    default:
        http_response_code(400);
        echo "Unknown dataset";
        exit;
}
