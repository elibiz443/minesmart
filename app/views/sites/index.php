<?php
  require __DIR__ . '/../../helpers/online_connector.php';
  require __DIR__ . '/../../controllers/sites/index.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MineSmart Sites - Dashboard</title>

    <!-- Custom CSS -->
    <link href="<?php echo ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">

    <!-- Mapbox CDN -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.5.1/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.5.1/mapbox-gl.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.css" type="text/css">

    <!-- FAV and Icons -->
    <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL; ?>/assets/images/favicon.webp" />
  </head>

  <body class="bg-gray-100 text-gray-800 max-w-full overflow-x-hidden" style="background-image: url('<?php echo ROOT_URL; ?>/assets/images/dashboard.webp');">
    <?php include '../includes/sidebar.php'; ?>
    <?php require __DIR__ . '/../includes/message.php'; ?>

    <!-- Main Content -->
    <main id="mainContent" class="min-h-screen w-[calc(100%-12rem)] ml-auto flex-1 flex flex-col overflow-hidden transition-all duration-500 ease-in-out">
      <?php include '../includes/header.php'; ?>
      <?php require __DIR__ . '/../includes/navigation.php'; ?>

      <div class="overflow-y-auto px-6 flex-grow pt-[4rem]">
        <div class="inline-flex space-x-4 mb-4 ml-10">
          <button onclick="location.href='<?php echo ROOT_URL; ?>/app/views/sites'" class="group relative z-[99] cursor-pointer rounded-lg shadow-lg shadow-slate-900 size-10 flex items-center justify-center border-2 border-white text-white hover:bg-slate-600 hover:shadow transition-all duration-500 ease-in-out">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="16" height="16" fill="currentColor">
              <path d="M408 120c0 54.6-73.1 151.9-105.2 192c-7.7 9.6-22 9.6-29.6 0C241.1 271.9 168 174.6 168 120C168 53.7 221.7 0 288 0s120 53.7 120 120zm8 80.4c3.5-6.9 6.7-13.8 9.6-20.6c.5-1.2 1-2.5 1.5-3.7l116-46.4C558.9 123.4 576 135 576 152l0 270.8c0 9.8-6 18.6-15.1 22.3L416 503l0-302.6zM137.6 138.3c2.4 14.1 7.2 28.3 12.8 41.5c2.9 6.8 6.1 13.7 9.6 20.6l0 251.4L32.9 502.7C17.1 509 0 497.4 0 480.4L0 209.6c0-9.8 6-18.6 15.1-22.3l122.6-49zM327.8 332c13.9-17.4 35.7-45.7 56.2-77l0 249.3L192 449.4 192 255c20.5 31.3 42.3 59.6 56.2 77c20.5 25.6 59.1 25.6 79.6 0zM288 152a40 40 0 1 0 0-80 40 40 0 1 0 0 80z"/>
            </svg>
            <span class="absolute w-[4rem] py-1.5 text-xs left-1/2 -translate-x-1/2 -bottom-8 bg-slate-900 rounded-md shadow-md shadow-slate-900 pointer-events-none opacity-0 group-hover:opacity-100 transition-all duration-900 ease-in-out">
              Map view
            </span>
          </button>
          <button onclick="location.href='<?php echo ROOT_URL; ?>/app/views/sites/table-sites.php'" class="group relative z-[99] cursor-pointer rounded-lg shadow-lg shadow-slate-900 size-10 flex items-center justify-center border-2 border-white text-white hover:bg-slate-600 hover:shadow transition-all duration-500 ease-in-out">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" fill="currentColor">
              <path d="M64 256l0-96 160 0 0 96L64 256zm0 64l160 0 0 96L64 416l0-96zm224 96l0-96 160 0 0 96-160 0zM448 256l-160 0 0-96 160 0 0 96zM64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32z"/>
            </svg>
            <span class="absolute w-[5rem] py-1.5 text-xs left-1/2 -translate-x-1/2 -bottom-8 bg-slate-900 text-white rounded-md shadow-md shadow-slate-900 pointer-events-none opacity-0 group-hover:opacity-100 transition-all duration-900 ease-in-out">
              View in table
            </span>
          </button>
        </div>

        <!-- Sites Section -->
        <section class="mb-12">
          <div class="relative h-[40rem]">
            <div class="absolute top-[2rem] left-12 lg:left-20 z-40">
              <button title="Show Navigation" type="button" id="showMapSidebar" class="cursor-pointer size-[38px] flex justify-center items-center text-sm font-semibold rounded-xl border border-gray-200 text-[#FFFFF0] shadow-lg shadow-slate-900 bg-gray-800 scale-90 hover:scale-110 transition-all duration-500 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="16" fill="currentColor">
                  <path d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/>
                </svg>
              </button>
            </div>
            <div class="-translate-x-[120%] lg:translate-x-0 bg-gradient-to-r from-slate-800 via-slate-500 to-slate-400/[.6] absolute z-50 border border-slate-600 rounded-l-xl w-[14rem] md:w-[21rem] h-full transition-all duration-500 ease-in-out" id="slideMapSidebar">
              <div class="absolute z-[60] w-[2.5rem] h-[2rem] -right-4.5 mt-[6.5rem]">
                <button title="Close Navigation" class="cursor-pointer bg-sky-100 text-sky-900 flex justify-center items-center w-full h-full rounded-r rounded-l-3xl shadow-md shadow-slate-900 hover:shadow-none hover:bg-sky-200 hover:-translate-x-1 transition-all duration-500 ease-in-out" id="hideMapSidebar">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" width="22" height="22" fill="currentColor" class="ml-2">
                    <path d="M9.4 278.6c-12.5-12.5-12.5-32.8 0-45.3l128-128c9.2-9.2 22.9-11.9 34.9-6.9s19.8 16.6 19.8 29.6l0 256c0 12.9-7.8 24.6-19.8 29.6s-25.7 2.2-34.9-6.9l-128-128z"/>
                  </svg>
                </button>
              </div>

              <div class="w-full h-full overflow-y-auto">
                <div class="mt-[4rem]">
                  <div class="p-4 bg-slate-200/[.5] rounded-xl mt-5 w-[95%] mx-auto">
                    <?php if (!empty($sites) && count($sites) > 0): ?>
                      <div class="mt-5 grid lg:grid-cols-2 gap-2">
                        <?php foreach ($sites as $site): ?>
                          <button title="Select Place" data-coords="<?php echo htmlspecialchars($site['coords'] ?? 'N/A'); ?>" data-zoom="16" class="location cursor-pointer h-[2rem] flex items-center pl-6 lg:pl-4 text-slate-700 text-xs font-semibold bg-slate-200 rounded-md shadow-md shadow-slate-900 border border-slate-400 hover:shadow-none transition-all duration-500 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="12" height="12" fill="currentColor" class="mr-2">
                              <path d="M384 192c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192z"/>
                            </svg>
                            <?php echo htmlspecialchars($site['name'] ?? 'N/A'); ?>
                          </button>
                        <?php endforeach; ?>
                      </div>
                    <?php else: ?>
                      <div class="text-slate-700 text-xs font-semibold bg-slate-200 rounded-md py-2 shadow-md shadow-slate-900 border border-slate-400 text-center">
                        No site(s) Found.
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="w-[98%] mx-auto h-[40rem] border border-slate-400 rounded-xl overflow-hidden">
              <div id='map' class="relative w-[calc(100%+12rem)] h-full">
                <div class="absolute left-0 top-0 w-full h-full bg-black/10 z-20"></div>
                <div id="drag-handle" class="absolute top-[2rem] right-[17rem] z-90 bg-gray-100 border-2 border-gray-300 rounded-full size-8 cursor-grab flex items-center justify-center shadow-md shadow-slate-900 hover:scale-110 hover:shadow-lg transition-all duration-500 ease-in-out">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="14" height="14" fill="currentColor">
                    <path d="M278.6 9.4c-12.5-12.5-32.8-12.5-45.3 0l-64 64c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8l32 0 0 96-96 0 0-32c0-12.9-7.8-24.6-19.8-29.6s-25.7-2.2-34.9 6.9l-64 64c-12.5 12.5-12.5 32.8 0 45.3l64 64c9.2 9.2 22.9 11.9 34.9 6.9s19.8-16.6 19.8-29.6l0-32 96 0 0 96-32 0c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l64 64c12.5 12.5 32.8 12.5 45.3 0l64-64c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8l-32 0 0-96 96 0 0 32c0 12.9 7.8 24.6 19.8 29.6s25.7 2.2 34.9-6.9l64-64c12.5-12.5 12.5-32.8 0-45.3l-64-64c-9.2-9.2-22.9-11.9-34.9-6.9s-19.8 16.6-19.8 29.6l0 32-96 0 0-96 32 0c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-64-64z"/>
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </main>

    <?php require __DIR__ . '/create.php'; ?>
    <?php include '../includes/footer.php'; ?>

    <script>const ROOT_URL = "<?php echo ROOT_URL; ?>";</script>
    <script src="<?= ROOT_URL; ?>/assets/js/mapbox/mapBox.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/mapbox/toggleSideBar.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/mapbox/addLocation.js"></script>

    <script src="<?= ROOT_URL; ?>/assets/js/sidebar.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/form-modal.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/message-modal.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/dropdown.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/side-nav.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/scroll-to-top.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/toggle-header.js"></script>
  </body>
</html>
