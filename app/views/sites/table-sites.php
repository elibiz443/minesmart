<?php
  require __DIR__ . '/../../helpers/online_connector.php';
  require __DIR__ . '/../../controllers/sites/index.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sites - Dashboard</title>

    <!-- Custom CSS -->
    <link href="<?php echo ROOT_URL; ?>/assets/css/style.css" rel="stylesheet">
    <link href="<?php echo ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">

    <!-- FAV and Icons -->
    <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL; ?>/assets/images/favicon.webp" />
  </head>

  <body class="bg-gray-100 text-gray-800 max-w-full overflow-x-hidden" style="background-image: url('<?php echo ROOT_URL; ?>/assets/images/register.webp');">
    <?php include '../includes/sidebar.php'; ?>
    <?php require __DIR__ . '/../includes/message.php'; ?>

    <!-- Main Content -->
    <main id="mainContent" class="min-h-screen w-[calc(100%-12rem)] ml-auto flex-1 flex flex-col overflow-hidden transition-all duration-500 ease-in-out">
      <?php include '../includes/header.php'; ?>
      <?php require __DIR__ . '/../includes/navigation.php'; ?>

      <div class="overflow-y-auto flex-grow pt-[4rem]">
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
          <table class="w-[88%] mx-auto bg-white shadow-lg shadow-slate-900 rounded-lg overflow-hidden">
            <thead>
              <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-center">Site Details</th>
              </tr>
            </thead>
            <tbody class="text-sm">
              <?php if (!empty($sites) && count($sites) > 0): ?>
                <?php foreach ($sites as $site): ?>
                  <tr class="relative border-t border-gray-400">
                    <td class="p-6 text-left">
                      <div class="grid md:grid-cols-2 lg:grid-cols-4 divide-x divide-solid divide-gray-200">
                        <div class="p-3">
                          <span class="font-extrabold text-neutral-900 mr-2">Name: </span>
                          <span class="text-teal-600">
                            <?php echo htmlspecialchars($site['name'] ?? 'N/A'); ?>
                          </span>
                        </div>
                        <div class="p-3">
                          <span class="font-extrabold text-neutral-900 mr-2">Coords: </span>
                          <span class="underline text-sky-600">
                            <?php echo htmlspecialchars($site['coords'] ?? 'N/A'); ?>
                          </span>
                        </div>
                        <div class="p-3">
                          <span class="font-extrabold text-neutral-900 mr-2">Created By: </span>
                          <span class="underline text-sky-600">
                            <?php echo htmlspecialchars($pdo->query("SELECT full_name FROM users WHERE id = {$site['user_id']}")->fetchColumn() ?? 'N/A'); ?>
                          </span>
                        </div>
                      </div>
                    </td>
                    <?php require __DIR__ . '/includes/table_navigation.php'; ?>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="py-3 px-6 text-center">No site(s) Found.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </section>
      </div>
    </main>

    <?php require __DIR__ . '/../includes/pagination.php'; ?>
    <?php require __DIR__ . '/create.php'; ?>
    <?php include '../includes/footer.php'; ?>

    <script src="<?= ROOT_URL; ?>/assets/js/sidebar.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/form-modal.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/message-modal.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/dropdown.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/side-nav.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/scroll-to-top.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/toggle-header.js"></script>
  </body>
</html>
