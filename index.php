<?php require __DIR__ . '/app/helpers/connector.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MineSmart Sentinel | Satellite & Edge-AI Fusion</title>
  <link href="<?php echo ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">

  <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL; ?>/assets/images/favicon.webp" />
</head>
<body class="bg-[#0b1120] text-slate-300 selection:bg-orange-500/30">

  <?php include './includes/header.php'; ?>
  <?php include './includes/hero.php'; ?>
  <?php include './includes/philosophy.php'; ?>
  <?php include './includes/edge.php'; ?>
  <?php include './includes/architecture.php'; ?>
  <?php include './includes/advert.php'; ?>
  <?php include './includes/footer.php'; ?>

  <script src="<?php echo ROOT_URL; ?>/assets/js/header.js"></script>
  <script src="<?php echo ROOT_URL; ?>/assets/js/architecture.js"></script>
  <script src="<?php echo ROOT_URL; ?>/assets/js/scroll-to-view.js"></script>
</body>
</html>
