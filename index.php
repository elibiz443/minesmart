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

<!-- NAV -->
<header class="sticky top-0 z-50 backdrop-blur bg-white/70 border-b border-slate-200">
  <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
    <p class="text-xl font-extrabold flex items-center">
      <img src="<?php echo ROOT_URL; ?>/assets/images/logo.webp" class="w-[2.5rem] h-auto">
      <span class="text-[#102f4c]">Mine</span><span class="text-[#e8a24a]">Smart</span>
    </p>
    <nav class="hidden md:flex gap-8 text-sm">
      <a href="#solution" class="hover:text-orange-500">Solution</a>
      <a href="#how" class="hover:text-orange-500">How it Works</a>
      <a href="#impact" class="hover:text-orange-500">Impact</a>
      <a href="#contact" class="hover:text-orange-500">Contact</a>
    </nav>
  </div>
</header>

<!-- HERO -->
<section class="relative overflow-hidden">
  <div class="absolute inset-0 -z-10 bg-gradient-to-r from-sky-200/40 via-transparent to-orange-200/40"></div>
  <div class="max-w-6xl mx-auto px-6 py-32 grid lg:grid-cols-2 gap-20 items-center">
    <div>
      <h1 class="text-5xl md:text-6xl font-extrabold leading-tight">
        Early Warning<br />That <span class="text-orange-500">Saves Lives</span>
      </h1>
      <p class="mt-6 text-lg text-slate-600 max-w-xl">
        MineSmart Flood Sentinel uses AI and Copernicus satellite data to predict floods and mudslides early — and turn risk into clear action.
      </p>
      <div class="mt-10 flex gap-4">
        <a href="#contact" class="px-12 py-4 rounded-full bg-orange-500 text-white font-semibold shadow-lg hover:scale-105 transition">Signin</a>
        <a href="#solution" class="px-12 py-4 rounded-full border border-slate-300 hover:bg-white transition">Register</a>
      </div>
    </div>
    <div class="relative">
      <div class="rounded-3xl bg-white/70 backdrop-blur shadow-xl p-12">
        <div class="grid grid-cols-2 gap-6 text-center">
          <div class="p-6 rounded-2xl bg-sky-50">
            <p class="text-3xl font-bold text-sky-600">⏱</p>
            <p class="mt-2 text-sm">Earlier Alerts</p>
          </div>
          <div class="p-6 rounded-2xl bg-orange-50">
            <p class="text-3xl font-bold text-orange-500">🛰</p>
            <p class="mt-2 text-sm">Satellite Driven</p>
          </div>
          <div class="p-6 rounded-2xl bg-emerald-50">
            <p class="text-3xl font-bold text-emerald-600">📍</p>
            <p class="mt-2 text-sm">Hyper‑Local Risk</p>
          </div>
          <div class="p-6 rounded-2xl bg-violet-50">
            <p class="text-3xl font-bold text-violet-600">📣</p>
            <p class="mt-2 text-sm">Actionable Alerts</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SOLUTION -->
<section id="solution" class="max-w-6xl mx-auto px-6 py-28">
  <h2 class="text-4xl font-bold text-center">A Smarter Way to Prepare</h2>
  <p class="mt-6 text-center max-w-3xl mx-auto text-slate-600">
    We combine Earth observation, AI, and local context to deliver reliable flood and landslide intelligence — before disasters happen.
  </p>
  <div class="mt-20 grid md:grid-cols-3 gap-10">
    <div class="p-8 rounded-3xl bg-white shadow-lg hover:-translate-y-1 transition">
      <h3 class="font-semibold text-lg">Predictive AI</h3>
      <p class="mt-3 text-slate-600">Probabilistic flood & mudslide forecasts using rainfall, terrain, and soil saturation.</p>
    </div>
    <div class="p-8 rounded-3xl bg-white shadow-lg hover:-translate-y-1 transition">
      <h3 class="font-semibold text-lg">Copernicus Powered</h3>
      <p class="mt-3 text-slate-600">Built on Sentinel‑1, Sentinel‑2, DEMs, and hydrology services.</p>
    </div>
    <div class="p-8 rounded-3xl bg-white shadow-lg hover:-translate-y-1 transition">
      <h3 class="font-semibold text-lg">Decision‑First Design</h3>
      <p class="mt-3 text-slate-600">Not just maps — clear actions for governments, responders, and communities.</p>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section id="how" class="bg-white/60 backdrop-blur">
  <div class="max-w-6xl mx-auto px-6 py-28">
    <h2 class="text-4xl font-bold text-center">How It Works</h2>
    <div class="mt-20 grid md:grid-cols-4 gap-10 text-center">
      <div>
        <div class="text-4xl">🛰</div>
        <p class="mt-4 font-semibold">Ingest Data</p>
      </div>
      <div>
        <div class="text-4xl">🧠</div>
        <p class="mt-4 font-semibold">AI Analysis</p>
      </div>
      <div>
        <div class="text-4xl">🗺</div>
        <p class="mt-4 font-semibold">Risk Mapping</p>
      </div>
      <div>
        <div class="text-4xl">📲</div>
        <p class="mt-4 font-semibold">Send Alerts</p>
      </div>
    </div>
  </div>
</section>

<!-- IMPACT -->
<section id="impact" class="max-w-6xl mx-auto px-6 py-28">
  <h2 class="text-4xl font-bold text-center">Designed for Real‑World Impact</h2>
  <div class="mt-20 grid md:grid-cols-3 gap-10">
    <div class="p-8 rounded-3xl bg-gradient-to-br from-sky-100 to-white">
      <h3 class="font-semibold">Governments</h3>
      <p class="mt-3 text-slate-600">Stronger preparedness, fewer losses, better coordination.</p>
    </div>
    <div class="p-8 rounded-3xl bg-gradient-to-br from-orange-100 to-white">
      <h3 class="font-semibold">Communities</h3>
      <p class="mt-3 text-slate-600">Earlier warnings, clearer guidance, safer decisions.</p>
    </div>
    <div class="p-8 rounded-3xl bg-gradient-to-br from-emerald-100 to-white">
      <h3 class="font-semibold">Partners</h3>
      <p class="mt-3 text-slate-600">APIs and integrations for insurers, utilities, and NGOs.</p>
    </div>
  </div>
</section>

<!-- CTA -->
<section id="contact" class="relative">
  <div class="absolute inset-0 bg-gradient-to-r from-sky-400 to-orange-400"></div>
  <div class="relative max-w-6xl mx-auto px-6 py-24 text-center text-white">
    <h2 class="text-4xl font-bold">Let’s Prevent the Next Disaster</h2>
    <p class="mt-6 max-w-2xl mx-auto">Move from reactive response to proactive protection with MineSmart Flood Sentinel.</p>
    <a href="#" class="inline-block mt-10 px-10 py-4 rounded-full bg-white text-slate-900 font-semibold shadow-xl hover:scale-105 transition">Talk to Us</a>
  </div>
</section>

<footer class="py-10 text-center text-sm text-slate-500">
  © 2026 MineSmart Flood Sentinel
</footer>

</body>
</html>
