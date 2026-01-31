<?php
    require __DIR__ . '/../../helpers/online_connector.php';
    require __DIR__ . '/../../helpers/risk_processor.php';

    $site_id = isset($_GET['site_id']) ? (int)$_GET['site_id'] : 0;
    $range = $_GET['range'] ?? '30d';
    $pack_site_id = isset($_GET['pack_site_id']) ? (int)$_GET['pack_site_id'] : 0;

    $range_map = [
        '7d' => 7,
        '14d' => 14,
        '30d' => 30,
        '90d' => 90
    ];
    $days = $range_map[$range] ?? 30;

    $sites_stmt = $pdo->query("SELECT id,name FROM sites ORDER BY name ASC");
    $sites = $sites_stmt->fetchAll(PDO::FETCH_ASSOC);

    $site_filter_sql = $site_id > 0 ? " AND re.site_id = :site_id " : "";
    $site_filter_sql2 = $site_id > 0 ? " AND s.site_id = :site_id " : "";
    $site_filter_sql3 = $site_id > 0 ? " AND ep.site_id = :site_id " : "";

    $events_sql = "
        SELECT
            re.id,
            re.site_id,
            si.name AS site_name,
            re.started_at,
            re.ended_at,
            re.status,
            re.level,
            re.system_decision,
            re.final_risk_score,
            re.satellite_risk_score,
            re.edge_risk_score,
            re.confidence_score,
            re.summary
        FROM risk_events re
        JOIN sites si ON si.id = re.site_id
        WHERE re.started_at >= (NOW() - INTERVAL :days DAY)
        $site_filter_sql
        ORDER BY re.started_at DESC
        LIMIT 60
    ";
    $events_stmt = $pdo->prepare($events_sql);
    $events_stmt->bindValue(':days', $days, PDO::PARAM_INT);
    if ($site_id > 0) {
        $events_stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
    }
    $events_stmt->execute();
    $events = $events_stmt->fetchAll(PDO::FETCH_ASSOC);

    $snap_sql = "
        SELECT
            s.id,
            s.site_id,
            si.name AS site_name,
            s.snapshot_at,
            s.final_risk_score,
            s.satellite_risk_score,
            s.edge_risk_score,
            s.confidence_score,
            s.system_decision,
            s.event_id
        FROM site_risk_snapshots s
        JOIN sites si ON si.id = s.site_id
        WHERE s.snapshot_at >= (NOW() - INTERVAL :days DAY)
        $site_filter_sql2
        ORDER BY s.snapshot_at DESC
        LIMIT 60
    ";
    $snap_stmt = $pdo->prepare($snap_sql);
    $snap_stmt->bindValue(':days', $days, PDO::PARAM_INT);
    if ($site_id > 0) {
        $snap_stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
    }
    $snap_stmt->execute();
    $snapshots = $snap_stmt->fetchAll(PDO::FETCH_ASSOC);

    $packs_sql = "
        SELECT
            ep.id,
            ep.site_id,
            si.name AS site_name,
            ep.event_id,
            ep.status,
            ep.pdf_url,
            ep.geojson_url,
            ep.csv_url,
            ep.images_zip_url,
            ep.created_at
        FROM evidence_packs ep
        JOIN sites si ON si.id = ep.site_id
        WHERE ep.created_at >= (NOW() - INTERVAL :days DAY)
        $site_filter_sql3
        ORDER BY ep.created_at DESC
        LIMIT 30
    ";
    $packs_stmt = $pdo->prepare($packs_sql);
    $packs_stmt->bindValue(':days', $days, PDO::PARAM_INT);
    if ($site_id > 0) {
        $packs_stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
    }
    $packs_stmt->execute();
    $packs = $packs_stmt->fetchAll(PDO::FETCH_ASSOC);

    $kpi_sql = "
        SELECT
            COUNT(*) AS total_events,
            SUM(CASE WHEN re.level='critical' THEN 1 ELSE 0 END) AS critical_events,
            SUM(CASE WHEN re.status='open' THEN 1 ELSE 0 END) AS open_events,
            AVG(re.final_risk_score) AS avg_risk,
            AVG(re.confidence_score) AS avg_conf
        FROM risk_events re
        WHERE re.started_at >= (NOW() - INTERVAL :days DAY)
        $site_filter_sql
    ";
    $kpi_stmt = $pdo->prepare($kpi_sql);
    $kpi_stmt->bindValue(':days', $days, PDO::PARAM_INT);
    if ($site_id > 0) {
        $kpi_stmt->bindValue(':site_id', $site_id, PDO::PARAM_INT);
    }
    $kpi_stmt->execute();
    $kpi = $kpi_stmt->fetch(PDO::FETCH_ASSOC);

    $avg_risk = isset($kpi['avg_risk']) ? (float)$kpi['avg_risk'] : 0.0;
    $avg_conf = isset($kpi['avg_conf']) ? (float)$kpi['avg_conf'] : 0.0;
    $total_events = (int)($kpi['total_events'] ?? 0);
    $critical_events = (int)($kpi['critical_events'] ?? 0);
    $open_events = (int)($kpi['open_events'] ?? 0);

    $level_color = function($level) {
        if ($level === 'critical') return 'text-rose-400';
        if ($level === 'warning') return 'text-amber-400';
        return 'text-emerald-400';
    };

    $status_chip = function($status) {
        if ($status === 'open') return 'bg-rose-500/10 border-rose-500/30 text-rose-300';
        if ($status === 'acknowledged') return 'bg-amber-500/10 border-amber-500/30 text-amber-300';
        return 'bg-emerald-500/10 border-emerald-500/30 text-emerald-300';
    };

    $pack_chip = function($status) {
        if ($status === 'ready') return 'bg-emerald-500/10 border-emerald-500/30 text-emerald-300';
        if ($status === 'building') return 'bg-amber-500/10 border-amber-500/30 text-amber-300';
        if ($status === 'failed') return 'bg-rose-500/10 border-rose-500/30 text-rose-300';
        return 'bg-slate-500/10 border-slate-500/30 text-slate-300';
    };
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reports & Analytics | MineSmart</title>
        <link href="<?php echo ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
        <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL; ?>/assets/images/favicon.webp" />
    </head>

    <body class="relative bg-slate-900 text-slate-100 max-w-full overflow-x-hidden">
        <div class="absolute inset-0 bg-[url('../../assets/images/dashboard.webp')] bg-cover bg-center opacity-40 -z-10"></div>
        <?php include '../includes/sidebar.php'; ?>
        <?php require __DIR__ . '/../includes/message.php'; ?>

        <main id="mainContent" class="relative min-h-screen w-[calc(100%-12rem)] ml-auto flex-1 flex flex-col overflow-hidden transition-all duration-500 ease-in-out">
            <?php include '../includes/header.php'; ?>
            <?php require __DIR__ . '/../includes/navigation.php'; ?>

            <section class="overflow-y-auto p-8 flex-grow pt-18">
                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-10">
                    <div>
                        <h1 class="text-4xl font-black text-sky-500">REPORTING CENTER</h1>
                        <p class="text-slate-400">Evidence Packs, Factorized Risk Exports, Chain-of-Custody Downloads</p>
                    </div>

                    <form method="GET" class="bg-slate-800/80 backdrop-blur-md p-4 rounded-2xl border border-slate-700 flex flex-col sm:flex-row gap-3 sm:items-end">
                        <div class="flex-1">
                            <label class="text-[0.625rem] text-slate-500 uppercase font-bold tracking-widest block mb-2">Site Filter</label>
                            <select name="site_id" class="w-full bg-slate-900/70 border border-slate-700 rounded-xl px-4 py-3 text-sm">
                                <option value="0">All Sites</option>
                                <?php foreach($sites as $s): ?>
                                    <option value="<?= (int)$s['id'] ?>" <?= $site_id === (int)$s['id'] ? 'selected' : '' ?>><?= htmlspecialchars($s['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="text-[0.625rem] text-slate-500 uppercase font-bold tracking-widest block mb-2">Time Range</label>
                            <select name="range" class="bg-slate-900/70 border border-slate-700 rounded-xl px-4 py-3 text-sm">
                                <option value="7d" <?= $range==='7d' ? 'selected' : '' ?>>Last 7 days</option>
                                <option value="14d" <?= $range==='14d' ? 'selected' : '' ?>>Last 14 days</option>
                                <option value="30d" <?= $range==='30d' ? 'selected' : '' ?>>Last 30 days</option>
                                <option value="90d" <?= $range==='90d' ? 'selected' : '' ?>>Last 90 days</option>
                            </select>
                        </div>
                        <div>
                            <button class="px-6 py-3 bg-sky-600 hover:bg-sky-500 rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-lg shadow-sky-900/20">Apply</button>
                        </div>
                    </form>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-10">
                    <div class="bg-slate-800/80 backdrop-blur-md p-6 rounded-3xl border border-slate-700 shadow-2xl">
                        <div class="text-[0.625rem] text-slate-500 uppercase font-bold tracking-widest">Events</div>
                        <div class="mt-3 flex items-end justify-between">
                            <div class="text-5xl font-black"><?= $total_events ?></div>
                            <div class="text-xs text-slate-400 font-mono"><?= $days ?>d window</div>
                        </div>
                        <div class="mt-4 flex items-center justify-between text-xs">
                            <span class="text-slate-400">Open</span>
                            <span class="text-rose-300 font-black"><?= $open_events ?></span>
                        </div>
                    </div>

                    <div class="bg-slate-800/80 backdrop-blur-md p-6 rounded-3xl border border-slate-700 shadow-2xl">
                        <div class="text-[0.625rem] text-slate-500 uppercase font-bold tracking-widest">Critical</div>
                        <div class="mt-3 flex items-end justify-between">
                            <div class="text-5xl font-black text-rose-400"><?= $critical_events ?></div>
                            <div class="text-xs text-slate-400 font-mono">triage</div>
                        </div>
                        <div class="mt-4 h-2 bg-slate-900 rounded-full overflow-hidden border border-slate-700">
                            <div class="h-full bg-rose-500" style="width: <?= $total_events > 0 ? min(100, ($critical_events / $total_events) * 100) : 0 ?>%"></div>
                        </div>
                    </div>

                    <div class="bg-slate-800/80 backdrop-blur-md p-6 rounded-3xl border border-slate-700 shadow-2xl">
                        <div class="text-[0.625rem] text-slate-500 uppercase font-bold tracking-widest">Average Risk</div>
                        <div class="mt-3 flex items-end justify-between">
                            <div class="text-5xl font-black text-purple-300"><?= number_format($avg_risk, 1) ?></div>
                            <div class="text-xs text-slate-400 font-mono">0-100</div>
                        </div>
                        <div class="mt-4 h-2 bg-slate-900 rounded-full overflow-hidden border border-slate-700">
                            <div class="h-full bg-purple-500" style="width: <?= min(100, max(0, $avg_risk)) ?>%"></div>
                        </div>
                    </div>

                    <div class="bg-slate-800/80 backdrop-blur-md p-6 rounded-3xl border border-slate-700 shadow-2xl">
                        <div class="text-[0.625rem] text-slate-500 uppercase font-bold tracking-widest">Average Confidence</div>
                        <div class="mt-3 flex items-end justify-between">
                            <div class="text-5xl font-black text-emerald-300"><?= number_format($avg_conf, 1) ?></div>
                            <div class="text-xs text-slate-400 font-mono">0-100</div>
                        </div>
                        <div class="mt-4 h-2 bg-slate-900 rounded-full overflow-hidden border border-slate-700">
                            <div class="h-full bg-emerald-500" style="width: <?= min(100, max(0, $avg_conf)) ?>%"></div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
                    <div class="lg:col-span-2 bg-slate-800/80 backdrop-blur-md p-6 rounded-3xl border border-slate-700 shadow-2xl">
                        <div class="flex items-center justify-between mb-5">
                            <h2 class="text-lg font-black text-sky-300">Event Ledger (Factorized)</h2>
                            <div class="flex gap-2">
                                <a href="<?= ROOT_URL; ?>/app/views/reports/export.php?dataset=risk_events&format=csv&days=<?= $days ?><?= $site_id>0 ? '&site_id='.$site_id : '' ?>" class="px-4 py-2 bg-slate-900/70 border border-slate-700 rounded-xl text-[0.625rem] uppercase tracking-widest font-black hover:border-sky-500 hover:text-sky-300 transition-all">Download CSV</a>
                                <a href="<?= ROOT_URL; ?>/app/views/reports/export.php?dataset=risk_events&format=json&days=<?= $days ?><?= $site_id>0 ? '&site_id='.$site_id : '' ?>" class="px-4 py-2 bg-slate-900/70 border border-slate-700 rounded-xl text-[0.625rem] uppercase tracking-widest font-black hover:border-sky-500 hover:text-sky-300 transition-all">Download JSON</a>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <?php if (count($events) === 0): ?>
                                <div class="p-6 bg-slate-900/60 rounded-2xl border border-slate-700 text-sm text-slate-400">No events in this window.</div>
                            <?php endif; ?>

                            <?php foreach($events as $e): ?>
                                <div class="p-5 bg-slate-900/60 rounded-2xl border border-slate-700 hover:border-sky-500/40 transition-all">
                                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                                        <div class="min-w-0">
                                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                                <span class="text-xs font-black uppercase tracking-widest <?= $level_color($e['level']) ?>"><?= htmlspecialchars($e['level']) ?></span>
                                                <span class="px-2.5 py-1 rounded-full border text-[0.625rem] font-black uppercase tracking-widest <?= $status_chip($e['status']) ?>"><?= htmlspecialchars($e['status']) ?></span>
                                                <span class="text-[0.625rem] text-slate-500 font-mono"><?= htmlspecialchars($e['started_at']) ?></span>
                                            </div>
                                            <div class="font-black text-base uppercase text-slate-100 truncate"><?= htmlspecialchars($e['site_name']) ?></div>
                                            <div class="text-xs text-slate-400 mt-1"><?= htmlspecialchars($e['summary'] ?? 'No summary') ?></div>
                                        </div>

                                        <div class="flex items-center gap-4 shrink-0">
                                            <div class="text-right">
                                                <div class="text-[0.625rem] text-slate-500 uppercase font-bold tracking-widest">Final</div>
                                                <div class="text-3xl font-black <?= $e['final_risk_score'] >= 70 ? 'text-rose-400' : ($e['final_risk_score'] >= 40 ? 'text-amber-400' : 'text-emerald-400') ?>"><?= number_format((float)$e['final_risk_score'], 1) ?></div>
                                            </div>
                                            <div class="w-px h-12 bg-slate-700"></div>
                                            <div class="text-right">
                                                <div class="text-[0.625rem] text-slate-500 uppercase font-bold tracking-widest">Decision</div>
                                                <div class="text-sm font-black text-slate-200"><?= htmlspecialchars($e['system_decision']) ?></div>
                                                <div class="text-[0.625rem] text-slate-500 font-mono mt-1">Conf <?= number_format((float)$e['confidence_score'], 1) ?></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-4">
                                        <div class="p-3 bg-slate-950/40 rounded-xl border border-slate-700">
                                            <div class="text-[0.625rem] uppercase tracking-widest text-slate-500 font-bold">Satellite</div>
                                            <div class="text-xl font-black text-sky-300 mt-1"><?= number_format((float)$e['satellite_risk_score'], 1) ?></div>
                                        </div>
                                        <div class="p-3 bg-slate-950/40 rounded-xl border border-slate-700">
                                            <div class="text-[0.625rem] uppercase tracking-widest text-slate-500 font-bold">Edge</div>
                                            <div class="text-xl font-black text-emerald-300 mt-1"><?= number_format((float)$e['edge_risk_score'], 1) ?></div>
                                        </div>
                                        <div class="p-3 bg-slate-950/40 rounded-xl border border-slate-700">
                                            <div class="text-[0.625rem] uppercase tracking-widest text-slate-500 font-bold">Factors</div>
                                            <a class="text-[0.625rem] font-black uppercase tracking-widest text-sky-400 hover:text-sky-300" href="<?= ROOT_URL; ?>/app/views/reports/export.php?dataset=event_factors&format=csv&event_id=<?= (int)$e['id'] ?>">Download CSV</a>
                                        </div>
                                        <div class="p-3 bg-slate-950/40 rounded-xl border border-slate-700">
                                            <div class="text-[0.625rem] uppercase tracking-widest text-slate-500 font-bold">Chain</div>
                                            <a class="text-[0.625rem] font-black uppercase tracking-widest text-sky-400 hover:text-sky-300" href="<?= ROOT_URL; ?>/app/views/reports/export.php?dataset=event_bundle&format=zip&event_id=<?= (int)$e['id'] ?>">Download ZIP</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="bg-slate-800/80 backdrop-blur-md p-6 rounded-3xl border border-slate-700 shadow-2xl">
                        <h2 class="text-lg font-black text-emerald-300 mb-5">Raw Data Exports</h2>

                        <form method="GET" action="<?= ROOT_URL; ?>/app/views/reports/export.php" class="space-y-4">
                            <input type="hidden" name="days" value="<?= $days ?>">
                            <?php if ($site_id > 0): ?>
                                <input type="hidden" name="site_id" value="<?= $site_id ?>">
                            <?php endif; ?>

                            <div>
                                <label class="text-[0.625rem] text-slate-500 uppercase font-bold tracking-widest block mb-2">Dataset</label>
                                <select name="dataset" class="w-full bg-slate-900/70 border border-slate-700 rounded-xl px-4 py-3 text-sm">
                                    <option value="satellite_observations">Satellite Observations</option>
                                    <option value="edge_observations">Edge Observations</option>
                                    <option value="site_runs">Site Runs</option>
                                    <option value="risk_events">Risk Events</option>
                                    <option value="snapshots">Risk Snapshots</option>
                                    <option value="alerts">Alerts</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-[0.625rem] text-slate-500 uppercase font-bold tracking-widest block mb-2">Format</label>
                                <select name="format" class="w-full bg-slate-900/70 border border-slate-700 rounded-xl px-4 py-3 text-sm">
                                    <option value="csv">CSV</option>
                                    <option value="json">JSON</option>
                                </select>
                            </div>

                            <button class="w-full py-3 bg-emerald-600 hover:bg-emerald-500 rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-lg shadow-emerald-900/20">Download Export</button>
                        </form>

                        <div class="mt-6 p-4 bg-slate-900/60 rounded-2xl border border-slate-700">
                            <div class="text-[0.625rem] text-slate-500 uppercase font-bold tracking-widest mb-2">One-click Bundles</div>
                            <div class="grid grid-cols-1 gap-2">
                                <a href="<?= ROOT_URL; ?>/app/views/reports/export.php?dataset=full_bundle&format=zip&days=<?= $days ?><?= $site_id>0 ? '&site_id='.$site_id : '' ?>" class="px-4 py-3 bg-slate-950/30 border border-slate-700 rounded-xl text-[0.625rem] uppercase tracking-widest font-black hover:border-emerald-500/50 hover:text-emerald-200 transition-all">Download Full Bundle ZIP</a>
                                <a href="<?= ROOT_URL; ?>/app/views/reports/export.php?dataset=geojson_latest&format=geojson<?= $site_id>0 ? '&site_id='.$site_id : '' ?>" class="px-4 py-3 bg-slate-950/30 border border-slate-700 rounded-xl text-[0.625rem] uppercase tracking-widest font-black hover:border-emerald-500/50 hover:text-emerald-200 transition-all">Download Latest GeoJSON</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
                    <div class="bg-slate-800/80 backdrop-blur-md p-6 rounded-3xl border border-slate-700 shadow-2xl">
                        <div class="flex items-center justify-between mb-5">
                            <h2 class="text-lg font-black text-sky-300">Evidence Packs</h2>
                            <a href="<?= ROOT_URL; ?>/app/views/reports/export.php?dataset=evidence_packs&format=csv&days=<?= $days ?><?= $site_id>0 ? '&site_id='.$site_id : '' ?>" class="px-4 py-2 bg-slate-900/70 border border-slate-700 rounded-xl text-[0.625rem] uppercase tracking-widest font-black hover:border-sky-500 hover:text-sky-300 transition-all">Download Ledger CSV</a>
                        </div>

                        <div class="space-y-3">
                            <?php if (count($packs) === 0): ?>
                                <div class="p-6 bg-slate-900/60 rounded-2xl border border-slate-700 text-sm text-slate-400">No evidence packs in this window.</div>
                            <?php endif; ?>

                            <?php foreach($packs as $p): ?>
                                <div class="p-5 bg-slate-900/60 rounded-2xl border border-slate-700 hover:border-sky-500/40 transition-all">
                                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                                        <div class="min-w-0">
                                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                                <span class="px-2.5 py-1 rounded-full border text-[0.625rem] font-black uppercase tracking-widest <?= $pack_chip($p['status']) ?>"><?= htmlspecialchars($p['status']) ?></span>
                                                <span class="text-[0.625rem] text-slate-500 font-mono"><?= htmlspecialchars($p['created_at']) ?></span>
                                            </div>
                                            <div class="font-black text-base uppercase text-slate-100 truncate"><?= htmlspecialchars($p['site_name']) ?></div>
                                            <div class="text-xs text-slate-400 mt-1">Pack ID <?= (int)$p['id'] ?><?= $p['event_id'] ? ' • Event '.$p['event_id'] : '' ?></div>
                                        </div>

                                        <div class="flex flex-wrap gap-2 shrink-0">
                                            <a href="<?= ROOT_URL; ?>/app/views/reports/download_pack.php?id=<?= (int)$p['id'] ?>&asset=pdf" class="px-4 py-2 bg-slate-900/70 border border-slate-700 rounded-xl text-[0.625rem] uppercase tracking-widest font-black hover:border-emerald-500/50 hover:text-emerald-200 transition-all">PDF</a>
                                            <a href="<?= ROOT_URL; ?>/app/views/reports/download_pack.php?id=<?= (int)$p['id'] ?>&asset=csv" class="px-4 py-2 bg-slate-900/70 border border-slate-700 rounded-xl text-[0.625rem] uppercase tracking-widest font-black hover:border-emerald-500/50 hover:text-emerald-200 transition-all">CSV</a>
                                            <a href="<?= ROOT_URL; ?>/app/views/reports/download_pack.php?id=<?= (int)$p['id'] ?>&asset=geojson" class="px-4 py-2 bg-slate-900/70 border border-slate-700 rounded-xl text-[0.625rem] uppercase tracking-widest font-black hover:border-emerald-500/50 hover:text-emerald-200 transition-all">GEOJSON</a>
                                            <a href="<?= ROOT_URL; ?>/app/views/reports/download_pack.php?id=<?= (int)$p['id'] ?>&asset=images_zip" class="px-4 py-2 bg-slate-900/70 border border-slate-700 rounded-xl text-[0.625rem] uppercase tracking-widest font-black hover:border-emerald-500/50 hover:text-emerald-200 transition-all">IMAGES</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="mt-6 p-5 bg-slate-900/60 rounded-2xl border border-slate-700">
                            <div class="text-[0.625rem] text-slate-500 uppercase font-bold tracking-widest mb-3">Download-ready Forms</div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <a class="px-4 py-3 bg-slate-950/30 border border-slate-700 rounded-xl text-[0.625rem] uppercase tracking-widest font-black hover:border-sky-500/40 hover:text-sky-200 transition-all" href="<?= ROOT_URL; ?>/app/views/reports/request_audit.php?type=custom_audit_request&format=pdf<?= $site_id>0 ? '&site_id='.$site_id : '' ?>">Download Custom Audit Request (PDF)</a>
                                <a class="px-4 py-3 bg-slate-950/30 border border-slate-700 rounded-xl text-[0.625rem] uppercase tracking-widest font-black hover:border-sky-500/40 hover:text-sky-200 transition-all" href="<?= ROOT_URL; ?>/app/views/reports/request_audit.php?type=incident_escalation&format=pdf<?= $site_id>0 ? '&site_id='.$site_id : '' ?>">Download Incident Escalation Form (PDF)</a>
                                <a class="px-4 py-3 bg-slate-950/30 border border-slate-700 rounded-xl text-[0.625rem] uppercase tracking-widest font-black hover:border-sky-500/40 hover:text-sky-200 transition-all" href="<?= ROOT_URL; ?>/app/views/reports/request_audit.php?type=rehabilitation_attestation&format=pdf<?= $site_id>0 ? '&site_id='.$site_id : '' ?>">Download Rehab Attestation (PDF)</a>
                                <a class="px-4 py-3 bg-slate-950/30 border border-slate-700 rounded-xl text-[0.625rem] uppercase tracking-widest font-black hover:border-sky-500/40 hover:text-sky-200 transition-all" href="<?= ROOT_URL; ?>/app/views/reports/request_audit.php?type=data_access_request&format=pdf<?= $site_id>0 ? '&site_id='.$site_id : '' ?>">Download Data Access Request (PDF)</a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-800/80 backdrop-blur-md p-6 rounded-3xl border border-slate-700 shadow-2xl">
                        <h2 class="text-lg font-black text-purple-300 mb-5">Snapshot Archive</h2>

                        <div class="flex gap-2 mb-4">
                            <a href="<?= ROOT_URL; ?>/app/views/reports/export.php?dataset=snapshots&format=csv&days=<?= $days ?><?= $site_id>0 ? '&site_id='.$site_id : '' ?>" class="px-4 py-2 bg-slate-900/70 border border-slate-700 rounded-xl text-[0.625rem] uppercase tracking-widest font-black hover:border-purple-500/50 hover:text-purple-200 transition-all">Download CSV</a>
                            <a href="<?= ROOT_URL; ?>/app/views/reports/export.php?dataset=snapshots&format=json&days=<?= $days ?><?= $site_id>0 ? '&site_id='.$site_id : '' ?>" class="px-4 py-2 bg-slate-900/70 border border-slate-700 rounded-xl text-[0.625rem] uppercase tracking-widest font-black hover:border-purple-500/50 hover:text-purple-200 transition-all">Download JSON</a>
                        </div>

                        <div class="space-y-3">
                            <?php if (count($snapshots) === 0): ?>
                                <div class="p-6 bg-slate-900/60 rounded-2xl border border-slate-700 text-sm text-slate-400">No snapshots in this window.</div>
                            <?php endif; ?>

                            <?php foreach($snapshots as $s): ?>
                                <div class="p-5 bg-slate-900/60 rounded-2xl border border-slate-700 hover:border-purple-500/40 transition-all">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="min-w-0">
                                            <div class="text-[0.625rem] text-slate-500 font-mono"><?= htmlspecialchars($s['snapshot_at']) ?></div>
                                                                                        <div class="font-black uppercase truncate mt-1"><?= htmlspecialchars($s['site_name']) ?></div>
                                            <div class="text-xs text-slate-400 mt-1">
                                                Decision: <span class="font-bold text-slate-200"><?= htmlspecialchars($s['system_decision']) ?></span>
                                                <?php if (!empty($s['event_id'])): ?>
                                                    <span class="text-slate-500"> • Event <?= (int)$s['event_id'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="text-right shrink-0">
                                            <div class="text-[0.625rem] text-slate-500 uppercase font-bold tracking-widest">Final</div>
                                            <div class="text-3xl font-black <?= (float)$s['final_risk_score'] >= 70 ? 'text-rose-400' : ((float)$s['final_risk_score'] >= 40 ? 'text-amber-400' : 'text-emerald-400') ?>">
                                                <?= number_format((float)$s['final_risk_score'], 1) ?>
                                            </div>
                                            <div class="text-[0.625rem] text-slate-500 font-mono mt-1">
                                                Conf <?= number_format((float)$s['confidence_score'], 1) ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-3 gap-2 mt-4">
                                        <div class="p-3 bg-slate-950/40 rounded-xl border border-slate-700">
                                            <div class="text-[0.625rem] uppercase tracking-widest text-slate-500 font-bold">Satellite</div>
                                            <div class="text-xl font-black text-sky-300 mt-1"><?= number_format((float)$s['satellite_risk_score'], 1) ?></div>
                                        </div>
                                        <div class="p-3 bg-slate-950/40 rounded-xl border border-slate-700">
                                            <div class="text-[0.625rem] uppercase tracking-widest text-slate-500 font-bold">Edge</div>
                                            <div class="text-xl font-black text-emerald-300 mt-1"><?= number_format((float)$s['edge_risk_score'], 1) ?></div>
                                        </div>
                                        <div class="p-3 bg-slate-950/40 rounded-xl border border-slate-700">
                                            <div class="text-[0.625rem] uppercase tracking-widest text-slate-500 font-bold">Exports</div>
                                            <div class="flex gap-2 mt-2">
                                                <a class="px-3 py-1 bg-slate-900/70 border border-slate-700 rounded-lg text-[0.625rem] font-black uppercase tracking-widest hover:border-purple-500/50 hover:text-purple-200 transition-all"
                                                   href="<?= ROOT_URL; ?>/app/views/reports/export.php?dataset=snapshot_row&format=json&id=<?= (int)$s['id'] ?>">
                                                   JSON
                                                </a>
                                                <a class="px-3 py-1 bg-slate-900/70 border border-slate-700 rounded-lg text-[0.625rem] font-black uppercase tracking-widest hover:border-purple-500/50 hover:text-purple-200 transition-all"
                                                   href="<?= ROOT_URL; ?>/app/views/reports/export.php?dataset=snapshot_row&format=csv&id=<?= (int)$s['id'] ?>">
                                                   CSV
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="mt-6 p-5 bg-slate-900/60 rounded-2xl border border-slate-700">
                            <div class="text-[0.625rem] text-slate-500 uppercase font-bold tracking-widest mb-2">Integrity & Chain-of-Custody</div>
                            <div class="text-xs text-slate-400 leading-relaxed">
                                Every snapshot export includes identifiers to link back to the originating <span class="text-slate-200 font-bold">run</span>,
                                any <span class="text-slate-200 font-bold">event</span>, and its <span class="text-slate-200 font-bold">factors</span>.
                                Use the ZIP bundle to produce audit-grade evidence trails.
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-4">
                                <a class="px-4 py-3 bg-slate-950/30 border border-slate-700 rounded-xl text-[0.625rem] uppercase tracking-widest font-black hover:border-purple-500/40 hover:text-purple-200 transition-all"
                                   href="<?= ROOT_URL; ?>/app/views/reports/export.php?dataset=snapshot_bundle&format=zip&days=<?= $days ?><?= $site_id>0 ? '&site_id='.$site_id : '' ?>">
                                    Download Snapshot Bundle ZIP
                                </a>
                                <a class="px-4 py-3 bg-slate-950/30 border border-slate-700 rounded-xl text-[0.625rem] uppercase tracking-widest font-black hover:border-purple-500/40 hover:text-purple-200 transition-all"
                                   href="<?= ROOT_URL; ?>/app/views/reports/export.php?dataset=hash_manifest&format=txt&days=<?= $days ?><?= $site_id>0 ? '&site_id='.$site_id : '' ?>">
                                    Download Hash Manifest (TXT)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800/80 backdrop-blur-md p-6 rounded-2xl border border-slate-700 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-sky-500/20 rounded-full flex items-center justify-center text-sky-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-slate-200">Compliance Transparency</p>
                            <p class="text-xs text-slate-400">Exports are generated server-side and delivered with correct download headers.</p>
                        </div>
                    </div>
                    <a href="<?= ROOT_URL; ?>/app/views/reports/request_audit.php?type=custom_audit_request&format=pdf<?= $site_id>0 ? '&site_id='.$site_id : '' ?>"
                       class="px-8 py-3 bg-sky-600 hover:bg-sky-500 rounded-xl font-bold text-sm transition-all shadow-lg shadow-sky-900/20">
                        DOWNLOAD CUSTOM AUDIT FORM (PDF)
                    </a>
                </div>

            </section>
        </main>

        <?php include '../includes/footer.php'; ?>

        <script src="<?= ROOT_URL; ?>/assets/js/toggle-header.js"></script>
        <script src="<?= ROOT_URL; ?>/assets/js/sidebar.js"></script>
        <script src="<?= ROOT_URL; ?>/assets/js/message-modal.js"></script>
        <script src="<?= ROOT_URL; ?>/assets/js/dropdown.js"></script>
        <script src="<?= ROOT_URL; ?>/assets/js/scroll-to-top.js"></script>
        <script src="<?= ROOT_URL; ?>/assets/js/side-nav.js"></script>
    </body>
</html>
