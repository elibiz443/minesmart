<header id="main-header" class="fixed top-0 w-full z-[999] border-b border-white/5 bg-[#0b1120]/80 backdrop-blur-md transition-all duration-500 ease-in-out">
  <div id="header-container" class="max-w-[96%] mx-auto text-[0.7rem] py-4 flex justify-between items-center transition-all duration-500 ease-in-out">
    <div class="flex items-center gap-2">
      <img src="<?php echo ROOT_URL; ?>/assets/images/logo.webp" class="w-8 h-8 transition-all duration-500 ease-in-out" id="header-logo">
      <a href="<?php echo ROOT_URL; ?>" class="text-xl font-black tracking-tighter text-white uppercase hover:scale-110 transition-all duration-500 ease-in-out">
        Mine<span class="text-orange-500">Smart</span> <span class="font-light text-slate-400">Sentinel</span>
      </a>
    </div>

    <nav class="hidden md:flex items-center gap-10 uppercase tracking-[0.2em] font-bold">
      <a id="philosophyButton" class="cursor-pointer hover:text-sky-400 transition-all duration-300 ease-in-out">Philosophy</a>
      <a id="edgeButton" class="cursor-pointer hover:text-sky-400 transition-all duration-300 ease-in-out">Edge AI</a>
      <a id="architectureButton" class="cursor-pointer hover:text-sky-400 transition-all duration-300 ease-in-out">Architecture</a>
      <a href="<?php echo ROOT_URL; ?>/auth/login" class="cursor-pointer group flex items-center gap-2 text-orange-500 border border-orange-500/30 px-5 py-1.5 rounded-full hover:bg-orange-500 hover:text-white transition-all duration-500 ease-in-out">
        <span>Login</span>
        <svg class="w-3 h-3 group-hover:translate-x-2 transition-all duration-500 ease-in-out" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
        </svg>
      </a>
    </nav>

    <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none cursor-pointer hover:text-orange-500 transition">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    </button>
  </div>
</header>

<div id="sidebar-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[9999] opacity-0 invisible transition-all duration-500 ease-in-out"></div>

<aside id="sidebar" class="fixed z-[99999] top-0 left-0 h-full w-72 bg-[#0b1120] border-r border-white/10 -translate-x-full transition-all duration-700 ease-in-out shadow-2xl shadow-slate-800">
  <div class="p-6">
    <div class="flex justify-between items-center mb-10">
      <a href="<?php echo ROOT_URL; ?>" class="text-lg font-black tracking-tighter text-white uppercase hover:scale-110 transition-all duration-500 ease-in-out">
        Mine<span class="text-orange-500">Smart</span>
      </a>
      <button id="close-sidebar" class="text-slate-400 hover:text-white cursor-pointer transition-all duration-300 ease-in-out">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>
    <nav class="flex flex-col gap-6 text-xs uppercase tracking-[0.2em] font-bold">
      <a id="philosophyButton2" class="cursor-pointer sidebar-link py-2 hover:text-sky-400 transition">Philosophy</a>
      <a id="edgeButton2" class="cursor-pointer sidebar-link py-2 hover:text-sky-400 transition">Edge AI</a>
      <a id="architectureButton3" class="cursor-pointer sidebar-link py-2 hover:text-sky-400 transition">Architecture</a>
      <hr class="border-white/5 my-2">
      <a href="<?php echo ROOT_URL; ?>/auth/login" class="group relative text-center text-orange-500 border border-orange-500/30 px-4 py-3 rounded-xl overflow-hidden hover:text-white transition-all duration-500 ease-in-out">
        <span class="relative z-[999]">Login</span>
        <span class="absolute bg-orange-700 w-0 h-full inset-0 group-hover:w-full duration-700 ease-in-out"></span>
      </a>
    </nav>
  </div>
</aside>
