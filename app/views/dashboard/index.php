<?php
  require __DIR__ . '/../../helpers/online_connector.php';
  // require __DIR__ . '/../../controllers/dashboard/view.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MineSmart - Dashboard</title>

    <!-- CSS -->
    <link href="<?php echo ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">

    <!-- CDNs -->
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- FAV and Icons -->
    <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL; ?>/assets/images/favicon.webp" />
  </head>

  <body class="bg-gray-100 text-gray-800 max-w-full overflow-x-hidden" style="background-image: url('<?php echo ROOT_URL; ?>/assets/images/9.webp');">
    <?php include '../includes/sidebar.php'; ?>
    <?php require __DIR__ . '/../includes/message.php'; ?>

    <main id="mainContent" class="min-h-screen w-[calc(100%-12rem)] ml-auto flex-1 flex flex-col overflow-hidden transition-all duration-500 ease-in-out">
      <?php include '../includes/header.php'; ?>

      <div class="overflow-y-auto p-8 flex-grow pt-18">
        <div class="mb-2">
          <h1 class="text-2xl font-bold text-slate-800">Overview</h1>
          <p class="text-slate-500 text-sm mt-1">We reduce bond risk and inspection cost by producing audit-grade, time-stamped evidence packs and automated non-compliance alerts.</p>
        </div>

        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mt-8">
          <div class="bg-white p-5 rounded-lg border border-gray-100 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Sites Monitored</p>
            <h2 class="text-3xl font-bold text-slate-800 mt-2">12</h2>
          </div>
          <div class="bg-white p-5 rounded-lg border border-gray-100 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Open Alerts</p>
            <h2 class="text-3xl font-bold text-slate-800 mt-2">8</h2>
          </div>
          <div class="bg-white p-5 rounded-lg border border-gray-100 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Unrehabilitated (ha)</p>
            <h2 class="text-3xl font-bold text-slate-800 mt-2">518</h2>
          </div>
          <div class="bg-white p-5 rounded-lg border border-gray-100 shadow-sm">
            <p class="text-sm font-medium text-slate-500">High-Risk Sites</p>
            <h2 class="text-3xl font-bold text-slate-800 mt-2">3</h2>
          </div>
          <div class="bg-white p-5 rounded-lg border border-gray-100 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Evidence Packs (30d)</p>
            <h2 class="text-3xl font-bold text-slate-800 mt-2">2</h2>
          </div>
        </section>

        <section class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-8">
          <div class="lg:col-span-7 bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
            <h3 class="text-lg font-bold text-slate-800 mb-6">Site Locations</h3>
            <div class="relative bg-slate-50 rounded-lg h-[400px] flex flex-col items-center justify-center border border-gray-100">
              <div class="flex flex-col items-center">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-md mb-4">
                  <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                  </svg>
                </div>
                <p class="text-slate-600 font-medium">10 sites across Kenya</p>
                <button class="cursor-pointer mt-4 px-6 py-2 bg-teal-500 hover:bg-teal-700 text-white font-semibold rounded-md transition-all duration-300 ease-in-out">
                  View Map
                </button>
              </div>
            </div>
          </div>

          <div class="lg:col-span-5 bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex flex-col">
            <h3 class="text-lg font-bold text-slate-800 mb-6">Priority Inspection Queue</h3>
            <div class="space-y-4 overflow-y-auto pr-2 max-h-[400px]">
              
              <div class="p-4 bg-slate-50 rounded-lg border border-gray-50 flex justify-between items-start">
                <div>
                  <h4 class="font-bold text-slate-800">Migori Gold Fields</h4>
                  <p class="text-sm text-slate-500 mt-1">Migori • Score: 46 • 2 alerts</p>
                </div>
                <span class="px-3 py-1 bg-red-100 text-red-600 text-xs font-bold rounded">High</span>
              </div>

              <div class="p-4 bg-slate-50 rounded-lg border border-gray-50 flex justify-between items-start">
                <div>
                  <h4 class="font-bold text-slate-800">Marsabit Fluorite</h4>
                  <p class="text-sm text-slate-500 mt-1">Marsabit • Score: 53 • 2 alerts</p>
                </div>
                <span class="px-3 py-1 bg-red-100 text-red-600 text-xs font-bold rounded">High</span>
              </div>

              <div class="p-4 bg-slate-50 rounded-lg border border-gray-50 flex justify-between items-start">
                <div>
                  <h4 class="font-bold text-slate-800">Kwale Titanium Mine</h4>
                  <p class="text-sm text-slate-500 mt-1">Kwale • Score: 77 • 1 alerts</p>
                </div>
                <span class="px-3 py-1 bg-orange-100 text-orange-600 text-xs font-bold rounded">Medium</span>
              </div>

              <div class="p-4 bg-slate-50 rounded-lg border border-gray-50 flex justify-between items-start">
                <div>
                  <h4 class="font-bold text-slate-800">Kakamega Gold Reserve</h4>
                  <p class="text-sm text-slate-500 mt-1">Kakamega • Score: 71 • 1 alerts</p>
                </div>
                <span class="px-3 py-1 bg-red-100 text-red-600 text-xs font-bold rounded">High</span>
              </div>

              <div class="p-4 bg-slate-50 rounded-lg border border-gray-50 flex justify-between items-start">
                <div>
                  <h4 class="font-bold text-slate-800">Turkana Mineral Sands</h4>
                  <p class="text-sm text-slate-500 mt-1">Turkana • Score: 82 • 0 alerts</p>
                </div>
                <span class="px-3 py-1 bg-orange-100 text-orange-600 text-xs font-bold rounded">Medium</span>
              </div>

            </div>
          </div>
        </section>
      </div>
    </main>

    <?php include '../includes/footer.php'; ?>

    <script>const ROOT_URL = "<?php echo ROOT_URL; ?>";</script>
    <script src="<?= ROOT_URL; ?>/assets/js/toggle-header.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/sidebar.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/message-modal.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/dropdown.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/scroll-to-top.js"></script>
  </body>
</html>
