<?php
  require __DIR__ . '/../../helpers/online_connector.php';
  require __DIR__ . '/../../controllers/sites/view.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>View Site - Dashboard</title>
    <link href="<?php echo ROOT_URL; ?>/assets/css/style.css" rel="stylesheet">
    <link href="<?php echo ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.5.1/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.5.1/mapbox-gl.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.css" type="text/css">
    <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL; ?>/assets/images/favicon.webp" />
  </head>
  <body class="bg-gray-100 text-gray-800 max-w-full overflow-x-hidden" style="background-image: url('<?php echo ROOT_URL; ?>/assets/images/9.webp');">
    <?php include '../includes/sidebar.php'; ?>
    <?php require __DIR__ . '/../includes/message.php'; ?>
    <main id="mainContent" class="min-h-screen w-[calc(100%-12rem)] ml-auto flex-1 flex flex-col overflow-hidden transition-all duration-500 ease-in-out">
      <?php include '../includes/header.php'; ?>
      <?php require __DIR__ . '/includes/site_navigation.php'; ?>
      <div class="p-6 flex-grow pt-[6rem]">
        <section class="mb-12 overflow-hidden rounded-lg shadow-lg shadow-slate-900">
          <div class="grid md:grid-cols-2 gap-20 md:gap-4 bg-gradient-to-tr from-slate-400 via-slate-200 to-neutral-200 text-slate-800 xl:pb-10">
            <div class="p-4 lg:p-8 flex justify-center items-center">
              <img src="<?php echo htmlspecialchars(ROOT_URL . ($selected_site['image_link'] ?? '/assets/images/default.webp')); ?>" class="w-[80%] h-auto border-2 border-gray-400 rounded-lg cursor-pointer hover:scale-110 shadow-lg shadow-slate-900 transition-all duration-500 ease-in-out" onclick="openImageModal('<?php echo htmlspecialchars(ROOT_URL . ($selected_site['image_link'] ?? '/assets/images/default.webp')); ?>')">
            </div>
            <div class="md:border-l-2 border-slate-600">
              <div class="px-4 lg:px-10 py-6 lg:py-12">
                <h3 class="font-bold text-2xl underline mb-4">Location's Detail</h3>
                <p>
                  <span class="font-semibold mr-2">Name: </span>
                  <?php echo htmlspecialchars($selected_site['name'] ?? 'N/A'); ?>
                </p>
                <p>
                  <span class="font-semibold mr-2">Coords: </span>
                  <?php echo htmlspecialchars($selected_site['coords'] ?? 'N/A'); ?>
                </p>
                <p>
                  <span class="font-semibold mr-2">Site Admin: </span>
                  <?php echo htmlspecialchars($pdo->query("SELECT full_name FROM users WHERE id = " . intval($selected_site['admin_id']))->fetchColumn() ?? 'N/A'); ?>
                </p>
                <p>
                  <span class="font-semibold mr-2">Created By: </span>
                  <?php echo htmlspecialchars($pdo->query("SELECT full_name FROM users WHERE id = " . intval($selected_site['user_id']))->fetchColumn() ?? 'N/A'); ?>
                </p>
              </div>
            </div>
          </div>
        </section>
      </div>
    </main>
    <?php require __DIR__ . '/../includes/image_modal.php'; ?>
    <?php require __DIR__ . '/edit.php'; ?>
    <?php include '../includes/footer.php'; ?>
    <script>const ROOT_URL = "<?php echo ROOT_URL; ?>";</script>
    <script src="<?= ROOT_URL; ?>/assets/js/mapbox/editLocation.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/image-modal.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/sidebar.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/form-modal.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/message-modal.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/toggle-header.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/dropdown.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/side-nav.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/scroll-to-top.js"></script>
  </body>
</html>