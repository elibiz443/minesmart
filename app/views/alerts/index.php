<?php
  require __DIR__ . '/../../helpers/online_connector.php';
  require __DIR__ . '/../../controllers/alerts/index.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MineSmart Alert - Dashboard</title>

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

  <body class="bg-gray-100 text-gray-800 max-w-full overflow-x-hidden" style="background-image: url('<?php echo ROOT_URL; ?>/assets/images/dashboard.webp');">
    <?php include '../includes/sidebar.php'; ?>
    <?php require __DIR__ . '/../includes/message.php'; ?>

    <!-- Main Content -->
    <main id="mainContent" class="min-h-screen w-[calc(100%-12rem)] ml-auto flex-1 flex flex-col overflow-hidden transition-all duration-500 ease-in-out">
      <?php include '../includes/header.php'; ?>
      <?php require __DIR__ . '/../includes/navigation.php'; ?>

      <div class="overflow-y-auto px-6 flex-grow">
        <section class="mb-12 mt-[4rem]">
          <div class="mb-4">
            <h2 class="text-3xl font-bold mb-2 text-white">Alerts</h2>
          </div>

          <form id="bulkDeleteForm" method="POST" action="<?= ROOT_URL ?>/app/controllers/alerts/delete.php">
            <?php require __DIR__ . '/includes/filters.php'; ?>
            <?php require __DIR__ . '/includes/widgets.php'; ?>
            <div id="pagination" class="flex justify-center mt-4"></div>
          </form>
        </section>
      </div>
    </main>

    <?php require __DIR__ . '/includes/view_modal.php'; ?>
    <?php require __DIR__ . '/includes/delete_modal.php'; ?>


    <?php include '../includes/footer.php'; ?>

    <script>const ROOT_URL = "<?php echo ROOT_URL; ?>";</script>
    <script src="<?= ROOT_URL; ?>/assets/js/sidebar.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/message-modal.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/dropdown.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/side-nav.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/scroll-to-top.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/toggle-header.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/minimize-filter.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/stick-filter-to-top.js"></script>

    <script src="<?= ROOT_URL; ?>/assets/js/alerts/alerts-modal.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/alerts/alerts-filter.js"></script>
    <script src="<?= ROOT_URL; ?>/assets/js/alerts/bulk-delete.js"></script>
  </body>
</html>
