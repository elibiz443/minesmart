<?php require __DIR__ . '/app/helpers/connector.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MineSmart Flood Sentinel</title>

  <!-- CSS -->
  <link href="<?php echo ROOT_URL; ?>/assets/css/output.css" rel="stylesheet">

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lato&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">

  <!-- FAV and Icons -->
  <link rel="icon" type="image/x-icon" href="<?php echo ROOT_URL; ?>/assets/images/favicon.webp" />
</head>
<body class="bg-gradient-to-br from-sky-50 via-white to-orange-50 text-slate-800">

  <header class="sticky top-0 z-50 backdrop-blur bg-white/70 border-b border-slate-200">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
      <p class="text-xl font-extrabold flex items-center">
        <img
          src="<?php echo ROOT_URL; ?>/assets/images/logo.webp"
          class="w-[2.5rem] h-auto"
        >
        <span class="text-[#102f4c]">Mine</span>
        <span class="text-[#e8a24a] mr-1">Smart</span>
        Sentinel
      </p>

      <nav class="hidden md:flex gap-8 text-sm">
        <a href="#solution" class="hover:text-orange-500">Solution</a>
        <a href="#how" class="hover:text-orange-500">How it Works</a>
        <a href="#impact" class="hover:text-orange-500">Impact</a>
        <a href="#contact" class="hover:text-orange-500">Contact</a>
      </nav>
    </div>
  </header>

  <section class="relative overflow-hidden">
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-sky-200/40 via-transparent to-orange-200/40"></div>

    <div class="max-w-6xl mx-auto px-6 py-32 grid lg:grid-cols-2 gap-20 items-center">
      <div>
        <h1 class="text-5xl md:text-6xl font-extrabold leading-tight">
          Mine Risk<br />
          Rehabilitation <span class="text-orange-500">Simplified</span>
        </h1>

        <p class="mt-6 text-lg text-slate-600 max-w-xl">
          We reduce bond risk and inspection cost by producing audit-grade,
          time-stamped evidence packs and automated non-compliance alerts.
        </p>

        <div class="mt-10 flex gap-4">
          <a
            href="<?php echo ROOT_URL; ?>/auth/login"
            class="px-12 py-4 rounded-full bg-orange-500 text-white font-semibold shadow-lg hover:scale-105 transition"
          >
            Signin
          </a>
          <a
            href="<?php echo ROOT_URL; ?>/auth/register"
            class="px-12 py-4 rounded-full border border-slate-300 hover:bg-white transition"
          >
            Register
          </a>
        </div>
      </div>

      <div class="relative">
        <div class="rounded-3xl bg-white/70 backdrop-blur shadow-xl p-12">
          <div class="grid grid-cols-2 gap-6 text-center">
            <div class="p-6 rounded-2xl bg-sky-50">
              <p class="text-3xl font-bold text-sky-600">12</p>
              <p class="mt-2 text-sm">Sites Monitored</p>
            </div>

            <div class="p-6 rounded-2xl bg-orange-50">
              <p class="text-3xl font-bold text-orange-500">8</p>
              <p class="mt-2 text-sm">Open Alerts</p>
            </div>

            <div class="p-6 rounded-2xl bg-emerald-50">
              <p class="text-3xl font-bold text-emerald-600">518</p>
              <p class="mt-2 text-sm">Unrehabilitated (ha)</p>
            </div>

            <div class="p-6 rounded-2xl bg-violet-50">
              <p class="text-3xl font-bold text-violet-600">3</p>
              <p class="mt-2 text-sm">High-Risk Sites</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="solution" class="max-w-6xl mx-auto px-6 py-28">
    <h2 class="text-4xl font-bold text-center">Audit-Grade Compliance</h2>

    <p class="mt-6 text-center max-w-3xl mx-auto text-slate-600">
      Moving beyond manual inspections with satellite-driven insights to ensure
      transparency and cost-effective environmental management.
    </p>

    <div class="mt-20 grid md:grid-cols-3 gap-10">
      <div class="p-8 rounded-3xl bg-white shadow-lg hover:-translate-y-1 transition">
        <h3 class="font-semibold text-lg">Predictive Risk</h3>
        <p class="mt-3 text-slate-600">
          Identify high-risk sites early to prevent non-compliance and secure
          financial bonds.
        </p>
      </div>

      <div class="p-8 rounded-3xl bg-white shadow-lg hover:-translate-y-1 transition">
        <h3 class="font-semibold text-lg">Evidence Packs</h3>
        <p class="mt-3 text-slate-600">
          Generate time-stamped, audit-grade evidence for regulatory requirements
          automatically.
        </p>
      </div>

      <div class="p-8 rounded-3xl bg-white shadow-lg hover:-translate-y-1 transition">
        <h3 class="font-semibold text-lg">Cost Reduction</h3>
        <p class="mt-3 text-slate-600">
          Lower inspection costs through automated alerts and targeted field visits.
        </p>
      </div>
    </div>
  </section>

  <section id="how" class="bg-white/60 backdrop-blur">
    <div class="max-w-6xl mx-auto px-6 py-28">
      <h2 class="text-4xl font-bold text-center">Priority Inspection Queue</h2>

      <div class="mt-20 grid md:grid-cols-4 gap-10 text-center">
        <div>
          <div class="text-xl font-bold text-orange-500">Migori</div>
          <p class="mt-4 font-semibold">Gold Fields</p>
          <p class="text-xs text-red-600 font-bold uppercase mt-1">High Risk</p>
        </div>

        <div>
          <div class="text-xl font-bold text-orange-500">Marsabit</div>
          <p class="mt-4 font-semibold">Fluorite Site</p>
          <p class="text-xs text-red-600 font-bold uppercase mt-1">High Risk</p>
        </div>

        <div>
          <div class="text-xl font-bold text-orange-500">Kwale</div>
          <p class="mt-4 font-semibold">Titanium Mine</p>
          <p class="text-xs text-orange-600 font-bold uppercase mt-1">Medium Risk</p>
        </div>

        <div>
          <div class="text-xl font-bold text-orange-500">Kakamega</div>
          <p class="mt-4 font-semibold">Gold Reserve</p>
          <p class="text-xs text-red-600 font-bold uppercase mt-1">High Risk</p>
        </div>
      </div>
    </div>
  </section>

  <section id="impact" class="max-w-6xl mx-auto px-6 py-28">
    <h2 class="text-4xl font-bold text-center">Evidence-Based Monitoring</h2>

    <div class="mt-20 grid md:grid-cols-3 gap-10">
      <div class="p-8 rounded-3xl bg-gradient-to-br from-sky-100 to-white">
        <h3 class="font-semibold">Site Locations</h3>
        <p class="mt-3 text-slate-600">
          Monitoring 10 critical mining sites across Kenya with satellite precision.
        </p>
      </div>

      <div class="p-8 rounded-3xl bg-gradient-to-br from-orange-100 to-white">
        <h3 class="font-semibold">Compliance Alerts</h3>
        <p class="mt-3 text-slate-600">
          Automated non-compliance alerts delivered directly to environmental teams.
        </p>
      </div>

      <div class="p-8 rounded-3xl bg-gradient-to-br from-emerald-100 to-white">
        <h3 class="font-semibold">Rehabilitation (ha)</h3>
        <p class="mt-3 text-slate-600">
          Tracking over 500 hectares of unrehabilitated land for restoration.
        </p>
      </div>
    </div>
  </section>

  <section id="contact" class="relative">
    <div class="absolute inset-0 bg-gradient-to-r from-sky-400 to-orange-400"></div>

    <div class="relative max-w-6xl mx-auto px-6 py-24 text-center text-white">
      <h2 class="text-4xl font-bold">Secure Your Mining Bond</h2>
      <p class="mt-6 max-w-2xl mx-auto">
        Transition from manual reporting to automated satellite-grade compliance today.
      </p>
      <a
        href="#"
        class="inline-block mt-10 px-10 py-4 rounded-full bg-white text-slate-900 font-semibold shadow-xl hover:scale-105 transition"
      >
        Request a Demo
      </a>
    </div>
  </section>

  <footer class="py-10 text-center text-sm text-slate-500">
    © 2026 MineSmart Sentinel
  </footer>

</body>
</html>
