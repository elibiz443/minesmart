<?php
  require __DIR__ . '/../../helpers/online_connector.php';
  require __DIR__ . '/../../helpers/risk_processor.php';

  $stmt = $pdo->query("SELECT * FROM sites LIMIT 20");
  $monitored_sites = $stmt->fetchAll(PDO::FETCH_ASSOC);

  function ms_coords_lat_lng($coords_raw) {
    $coords = json_decode($coords_raw ?? '', true);
    $lat = 0.0;
    $lng = 0.0;

    if(is_array($coords)) {
      if(isset($coords['lat']) && isset($coords['lng'])) {
        $lat = (float)$coords['lat'];
        $lng = (float)$coords['lng'];
      } elseif(isset($coords['latitude']) && isset($coords['longitude'])) {
        $lat = (float)$coords['latitude'];
        $lng = (float)$coords['longitude'];
      } elseif(isset($coords[0]) && isset($coords[1])) {
        $a = (float)$coords[0];
        $b = (float)$coords[1];

        $is_a_lat = abs($a) <= 90;
        $is_b_lat = abs($b) <= 90;

        if($is_a_lat && !$is_b_lat) {
          $lat = $a;
          $lng = $b;
        } elseif(!$is_a_lat && $is_b_lat) {
          $lat = $b;
          $lng = $a;
        } else {
          $lng = $a;
          $lat = $b;
        }
      }
    }

    return [$lat, $lng];
  }

  function ms_factor_code($f) {
    if(isset($f['code'])) return (string)$f['code'];
    if(isset($f['risk_type_code'])) return (string)$f['risk_type_code'];
    if(isset($f['risk_code'])) return (string)$f['risk_code'];
    if(isset($f['type_code'])) return (string)$f['type_code'];
    return '';
  }

  function ms_factor_score($f) {
    if(isset($f['normalized_score'])) return (float)$f['normalized_score'];
    if(isset($f['score'])) return (float)$f['score'];
    return 0.0;
  }

  function ms_category_breakdown($factors) {
    $ls = 0.0;
    $fl = 0.0;
    $rh = 0.0;
    $sf = 0.0;

    foreach($factors as $f) {
      $code = ms_factor_code($f);
      $score = ms_factor_score($f);

      if($code === '') continue;

      if(in_array($code, ['INSAR_DEFORMATION_MM_MO','EDGE_CRACK_SCORE'], true)) {
        if($score > $ls) $ls = $score;
      }

      if(in_array($code, ['RAINFALL_ANOMALY_PCT','SOIL_MOISTURE_PROXY_TREND','EDGE_WETNESS_PCT','EDGE_HUMIDITY_PCT'], true)) {
        if($score > $fl) $fl = $score;
      }

      if(in_array($code, ['NDVI_DROP_30D','EVI_DROP_30D','EDGE_VEG_COVER_PCT'], true)) {
        if($score > $rh) $rh = $score;
      }

      if(in_array($code, ['EDGE_EROSION_AREA_PCT','EDGE_CRACK_SCORE','INSAR_DEFORMATION_MM_MO'], true)) {
        if($score > $sf) $sf = $score;
      }
    }

    return [
      'ls' => min(100.0, max(0.0, $ls)),
      'fl' => min(100.0, max(0.0, $fl)),
      'rh' => min(100.0, max(0.0, $rh)),
      'sf' => min(100.0, max(0.0, $sf))
    ];
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mining Sites - MineSmart</title>

    <link href="<?php echo ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL; ?>/assets/images/favicon.webp" />
  </head>

  <body class="relative bg-slate-900 text-slate-100 max-w-full overflow-x-hidden">
    <div class="absolute inset-0 bg-[url('../../assets/images/dashboard.webp')] bg-cover bg-center opacity-40 -z-10"></div>
    <?php include '../includes/sidebar.php'; ?>
    <?php require __DIR__ . '/../includes/message.php'; ?>

    <main id="mainContent" class="min-h-screen w-[calc(100%-12rem)] ml-auto flex-1 flex flex-col overflow-hidden transition-all duration-500 ease-in-out">
      <?php include '../includes/header.php'; ?>
      <?php require __DIR__ . '/../includes/navigation.php'; ?>

      <section class="overflow-y-auto p-8 flex-grow pt-18">
        <div class="flex justify-between items-center mb-10">
          <div>
            <h1 class="text-3xl font-black tracking-tight text-sky-500 uppercase">SITES</h1>
            <p class="text-slate-400 text-sm">Satellite-First, Edge-Verified</p>
          </div>
          <div class="flex gap-4">
            <div class="bg-slate-800/80 backdrop-blur-sm p-3 rounded-xl border border-slate-700">
              <span class="text-[0.625rem] text-slate-500 block uppercase font-bold tracking-widest">Network Status</span>
              <span class="text-xs md:text-sm md:font-mono text-emerald-400"><?= count($monitored_sites) ?> Active Sites Deployed</span>
            </div>
          </div>
        </div>

        <div class="fixed z-[1001] top-[9rem] right-[7%] sm:right-[3rem]">
          <button id="toggleSites" class="cursor-pointer bg-orange-500 border border-white text-[0.625rem] px-1.5 py-1 font-bold text-white hover:scale-[106%] shadow-lg shadow-slate-800 rounded-full transition-all duration-500 ease-in-out">
            Hide Panel
          </button>
        </div>

        <div id="dashboardWrapper" class="relative flex gap-4 transition-all duration-700 ease-in-out">
          <div id="mapContainer" class="relative flex-1 bg-slate-800/80 rounded-3xl border border-slate-700 p-1 h-[37.5rem] shadow-2xl shadow-slate-900 overflow-hidden transition-all duration-700 ease-in-out">
            <div id="map" class="w-full h-full rounded-[1.4rem]"></div>

            <div class="absolute top-6 right-6 z-[1000] bg-slate-900/90 backdrop-blur-md p-4 rounded-xl border border-slate-700 shadow-2xl">
              <h4 class="text-[0.625rem] font-bold mb-3 uppercase tracking-widest text-slate-400">Decision Weights</h4>
              <div class="space-y-1">
                <div class="flex justify-between gap-4 text-[0.625rem]">
                  <span class="text-slate-500">Satellite (SAR/Optical)</span>
                  <span class="text-sky-400 font-mono">60%</span>
                </div>
                <div class="flex justify-between gap-4 text-[0.625rem]">
                  <span class="text-slate-500">Edge AI Verification</span>
                  <span class="text-emerald-400 font-mono">40%</span>
                </div>
              </div>
            </div>

            <div class="absolute bottom-6 left-6 z-[1000] bg-slate-900/90 backdrop-blur-md p-4 rounded-xl border border-slate-700 shadow-2xl">
              <h4 class="text-xs font-bold mb-3 uppercase tracking-widest text-slate-400">Risk Distribution</h4>
              <div class="space-y-2">
                <div class="flex items-center gap-3 text-[0.625rem] font-bold">
                  <span class="w-3 h-3 bg-rose-600 rounded-sm"></span> CRITICAL (&gt;70)
                </div>
                <div class="flex items-center gap-3 text-[0.625rem] font-bold">
                  <span class="w-3 h-3 bg-amber-500 rounded-sm"></span> MONITOR (40-70)
                </div>
                <div class="flex items-center gap-3 text-[0.625rem] font-bold">
                  <span class="w-3 h-3 bg-emerald-500 rounded-sm"></span> NORMAL (&lt;40)
                </div>
              </div>
            </div>
          </div>

          <div id="sitesPanel" class="w-[14rem] md:w-[20rem] h-[37.5rem] flex flex-col space-y-6 transition-all duration-500 ease-in-out">
            <div class="bg-slate-800/80 rounded-3xl border border-slate-700 p-6 shadow-2xl overflow-hidden flex flex-col flex-1">
              <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold flex items-center gap-2">
                  <span class="w-1 h-6 bg-sky-500 rounded-full"></span>
                  Site Risk Index
                </h3>
              </div>

              <div id="sitesList" class="space-y-3 overflow-y-auto flex-1 pr-2">
                <?php foreach($monitored_sites as $site):
                  $packet = ms_get_site_risk_packet((int)$site['id'], $pdo);
                  $snap = $packet['snapshot'] ?? [];
                  $factors = $packet['factors'] ?? [];

                  $score = (float)($snap['final_risk_score'] ?? 0);
                  $decision = $snap['system_decision'] ?? 'Normal State';

                  $ll = ms_coords_lat_lng($site['coords'] ?? '');
                  $lat = $ll[0];
                  $lng = $ll[1];

                  $text_color = $score > 70 ? 'text-rose-500' : ($score > 40 ? 'text-amber-500' : 'text-emerald-500');
                  $border_color = $score > 70 ? 'border-rose-500/30' : ($score > 40 ? 'border-amber-500/30' : 'border-emerald-500/30');

                  $cats = ms_category_breakdown($factors);
                ?>
                <div class="p-4 rounded-2xl border bg-slate-900/50 <?= $border_color ?> hover:bg-slate-900 transition-all cursor-pointer group" onclick="if(window.map){ map.flyTo([<?= $lat ?>, <?= $lng ?>], 12) }">
                  <div class="flex justify-between items-start">
                    <div>
                      <h4 class="font-bold text-sm group-hover:text-sky-400 transition-colors uppercase">
                        <?= $site['name'] ?>
                      </h4>
                      <span class="text-[0.625rem] font-mono text-slate-500"><?= number_format($lat, 4) ?>, <?= number_format($lng, 4) ?></span>
                    </div>
                    <div class="text-right">
                      <span class="text-xl font-black <?= $text_color ?>"><?= number_format($score, 1) ?></span>
                    </div>
                  </div>

                  <div class="mt-3 flex justify-between items-center text-[0.5625rem] font-bold uppercase tracking-tighter">
                    <span class="text-slate-600"><?= $decision ?></span>
                    <a href="<?= ROOT_URL; ?>/sites/intelligence.php?site_id=<?= (int)$site['id'] ?>" class="text-sky-500/70 hover:text-sky-400 transition-colors">Open</a>
                  </div>

                  <div class="mt-3 grid grid-cols-2 gap-2 text-[0.55rem] font-bold">
                    <span class="text-rose-400">LS <?= number_format($cats['ls'], 1) ?></span>
                    <span class="text-amber-400">FL <?= number_format($cats['fl'], 1) ?></span>
                    <span class="text-sky-400">RH <?= number_format($cats['rh'], 1) ?></span>
                    <span class="text-purple-400">SF <?= number_format($cats['sf'], 1) ?></span>
                  </div>
                </div>
                <?php endforeach; ?>
              </div>
            </div>

            <div class="bg-sky-600 p-6 rounded-3xl shadow-lg shadow-sky-900/20 shrink-0">
              <h4 class="text-white font-black text-sm uppercase mb-1">Audit Ready</h4>
              <p class="text-sky-100 text-xs opacity-80 mb-4">
                All fused risk indices are timestamped and immutable for reporting.
              </p>
              <button class="w-full py-3 bg-white text-sky-600 rounded-xl font-black text-[0.625rem] uppercase tracking-widest hover:bg-sky-50 transition-all">
                Generate Evidence Pack
              </button>
            </div>
          </div>
        </div>
      </section>
    </main>

    <?php require __DIR__ . '/create.php'; ?>
    <?php include '../includes/footer.php'; ?>

    <script>
      window.SITES_DATA = <?= json_encode(array_map(function($site) use ($pdo) {
        $packet = ms_get_site_risk_packet((int)$site['id'], $pdo);
        $snap = $packet['snapshot'] ?? [];
        $factors = $packet['factors'] ?? [];

        $coords = json_decode($site['coords'] ?? '', true);
        $lat = 0.0;
        $lng = 0.0;

        if(is_array($coords)) {
          if(isset($coords['lat']) && isset($coords['lng'])) {
            $lat = (float)$coords['lat'];
            $lng = (float)$coords['lng'];
          } elseif(isset($coords['latitude']) && isset($coords['longitude'])) {
            $lat = (float)$coords['latitude'];
            $lng = (float)$coords['longitude'];
          } elseif(isset($coords[0]) && isset($coords[1])) {
            $a = (float)$coords[0];
            $b = (float)$coords[1];

            $is_a_lat = abs($a) <= 90;
            $is_b_lat = abs($b) <= 90;

            if($is_a_lat && !$is_b_lat) {
              $lat = $a;
              $lng = $b;
            } elseif(!$is_a_lat && $is_b_lat) {
              $lat = $b;
              $lng = $a;
            } else {
              $lng = $a;
              $lat = $b;
            }
          }
        }

        $badges = [];
        if(function_exists('ms_factor_badge_text')) {
          $badges = array_slice(array_map(function($f) { return ms_factor_badge_text($f); }, $factors), 0, 3);
        }

        return [
          'id' => (int)$site['id'],
          'name' => $site['name'],
          'coords' => [(float)$lat, (float)$lng],
          'score' => (float)($snap['final_risk_score'] ?? 0),
          'decision' => $snap['system_decision'] ?? 'Normal State',
          'badges' => $badges
        ];
      }, $monitored_sites)); ?>;
    </script>

    <script src="<?= ROOT_URL; ?>/assets/js/sidebar.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/form-modal.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/message-modal.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/dropdown.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/side-nav.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/scroll-to-top.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/toggle-header.js"></script>

    <script src="<?= ROOT_URL; ?>/assets/js/map.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/panel.js"></script>
  </body>
</html>
