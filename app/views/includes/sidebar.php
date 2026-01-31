<!-- Sidebar -->
<aside class="translate-x-0 fixed top-0 start-0 min-h-screen z-[99999] w-[12rem] bg-gradient-to-r from-slate-600 via-slate-700 to-gray-900 text-white text-sm shadow-xl shadow-slate-800 transition-all duration-500 ease-in-out" id="slideDiv">
  <div class="p-6 shadow-lg shadow-slate-900 flex justify-center bg-gray-300">
    <button onclick="location.href='<?php echo ROOT_URL; ?>/app/views/dashboard'" class="relative flex items-center justify-center cursor-pointer size-[4.5rem] hover:scale-110 transition-all duration-500 ease-in-out">
      <img class="relative z-20 w-[90%] h-auto" src="<?php echo ROOT_URL; ?>/assets/images/logo.webp" />
    </button>
  </div>
  <nav id="scrollable" class="max-h-[calc(100vh-9rem)] overflow-y-auto px-4 py-10">
    <ul class="space-y-2">
      <!-- Dashboard -->
      <li>
        <button data-path="/app/views/dashboard" onclick="location.href='<?php echo ROOT_URL; ?>/dashboard'" class="sidebar-btn cursor-pointer w-full flex items-center px-3 py-2 rounded-lg hover:bg-white hover:text-slate-800 transition-all duration-500 ease-in-out">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" fill="currentColor" class="mr-2">
            <path d="M0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM288 96a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zM256 416c35.3 0 64-28.7 64-64c0-17.4-6.9-33.1-18.1-44.6L366 161.7c5.3-12.1-.2-26.3-12.3-31.6s-26.3 .2-31.6 12.3L257.9 288c-.6 0-1.3 0-1.9 0c-35.3 0-64 28.7-64 64s28.7 64 64 64zM176 144a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zM96 288a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm352-32a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/>
          </svg>
          <span>Dashboard</span>
        </button>
      </li>

      <!-- Users -->
      <li class="relative group">
        <button data-path="/users" class="sidebar-btn cursor-pointer w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-white hover:text-slate-800 transition-all duration-500 ease-in-out toggle-submenu">
          <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="16" height="16" fill="currentColor" class="mr-2">
              <path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192l42.7 0c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0L21.3 320C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7l42.7 0C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3l-213.3 0zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352l117.3 0C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7l-330.7 0c-14.7 0-26.7-11.9-26.7-26.7z"/>
            </svg>
            Users
          </div>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" fill="currentColor" class="arrow-pointer w-4 h-4 ml-2 transform transition-all duration-500 ease-in-out">
            <path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/>
          </svg>
        </button>
        <ul class="absolute left-full top-0 ml-1 hidden min-w-max space-y-1 bg-teal-600 p-2 rounded-lg shadow-lg shadow-slate-900 submenu transition-all duration-700 ease-in-out">
          <li>
            <button onclick="location.href='<?php echo ROOT_URL; ?>/users'" class="cursor-pointer w-full text-left px-3 py-1.5 rounded-md flex items-center hover:bg-teal-900 transition-all duration-500 ease-in-out">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="16" height="16" fill="currentColor" class="mr-2">
                <path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192l42.7 0c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0L21.3 320C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7l42.7 0C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3l-213.3 0zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352l117.3 0C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7l-330.7 0c-14.7 0-26.7-11.9-26.7-26.7z"/>
              </svg>
              View Users
            </button>
          </li>
          <li>
            <button onclick="location.href='<?php echo ROOT_URL; ?>/user-performance'" class="cursor-pointer w-full text-left px-3 py-1.5 rounded-md flex items-center hover:bg-teal-900 transition-all duration-500 ease-in-out">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" fill="currentColor" class="mr-2">
                <path d="M64 64c0-17.7-14.3-32-32-32S0 46.3 0 64L0 400c0 44.2 35.8 80 80 80l400 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L80 416c-8.8 0-16-7.2-16-16L64 64zm406.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L320 210.7l-57.4-57.4c-12.5-12.5-32.8-12.5-45.3 0l-112 112c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L240 221.3l57.4 57.4c12.5 12.5 32.8 12.5 45.3 0l128-128z"/>
              </svg>
              Performance Analysis
            </button>
          </li>
        </ul>
      </li>

      <!-- disaster-monitoring -->
      <li>
        <button data-path="/app/views/disaster-monitoring" onclick="location.href='<?php echo ROOT_URL; ?>/disaster-monitoring'" class="sidebar-btn cursor-pointer w-full flex items-center px-3 py-2 rounded-lg hover:bg-white hover:text-slate-800 transition-all duration-500 ease-in-out">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" fill="currentColor" class="mr-2">
            <path d="M128 32l32 0c17.7 0 32 14.3 32 32l0 32L96 96l0-32c0-17.7 14.3-32 32-32zm64 96l0 320c0 17.7-14.3 32-32 32L32 480c-17.7 0-32-14.3-32-32l0-59.1c0-34.6 9.4-68.6 27.2-98.3C40.9 267.8 49.7 242.4 53 216L60.5 156c2-16 15.6-28 31.8-28l99.8 0zm227.8 0c16.1 0 29.8 12 31.8 28L459 216c3.3 26.4 12.1 51.8 25.8 74.6c17.8 29.7 27.2 63.7 27.2 98.3l0 59.1c0 17.7-14.3 32-32 32l-128 0c-17.7 0-32-14.3-32-32l0-320 99.8 0zM320 64c0-17.7 14.3-32 32-32l32 0c17.7 0 32 14.3 32 32l0 32-96 0 0-32zm-32 64l0 160-64 0 0-160 64 0z"/>
          </svg>
          <span>Monitoring</span>
        </button>
      </li>

      <!-- Sites -->
      <li>
        <button data-path="/app/views/sites" onclick="location.href='<?php echo ROOT_URL; ?>/sites'" class="sidebar-btn cursor-pointer w-full flex items-center px-3 py-2 rounded-lg hover:bg-white hover:text-slate-800 transition-all duration-500 ease-in-out">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="16" height="16" fill="currentColor" class="mr-2">
            <path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/>
          </svg>
          <span>Sites</span>
        </button>
      </li>

      <!-- rehabilitation -->
      <li>
        <button data-path="/app/views/rehabilitation" onclick="location.href='<?php echo ROOT_URL; ?>/rehabilitation'" class="sidebar-btn cursor-pointer w-full flex items-center px-3 py-2 rounded-lg hover:bg-white hover:text-slate-800 transition-all duration-500 ease-in-out">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" fill="currentColor" class="mr-2">
            <path d="M184 48l144 0c4.4 0 8 3.6 8 8l0 40L176 96l0-40c0-4.4 3.6-8 8-8zm-56 8l0 40L64 96C28.7 96 0 124.7 0 160L0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-256c0-35.3-28.7-64-64-64l-64 0 0-40c0-30.9-25.1-56-56-56L184 0c-30.9 0-56 25.1-56 56zm96 152c0-8.8 7.2-16 16-16l32 0c8.8 0 16 7.2 16 16l0 48 48 0c8.8 0 16 7.2 16 16l0 32c0 8.8-7.2 16-16 16l-48 0 0 48c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-48-48 0c-8.8 0-16-7.2-16-16l0-32c0-8.8 7.2-16 16-16l48 0 0-48z"/>
          </svg>
          <span>Rehabilitation</span>
        </button>
      </li>

      <!-- Alerts -->
      <li>
        <button onclick="location.href='<?php echo ROOT_URL; ?>/alerts'" class="sidebar-btn cursor-pointer w-full flex items-center px-3 py-2 rounded-lg hover:bg-white hover:text-slate-800 transition-all duration-500 ease-in-out">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" fill="currentColor" class="mr-2">
            <path d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480L40 480c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24l0 112c0 13.3 10.7 24 24 24s24-10.7 24-24l0-112c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/>
          </svg>
          <span>Alerts</span>
        </button>
      </li>

      <!-- Evidence Packs -->
      <li>
        <button onclick="location.href='<?php echo ROOT_URL; ?>/reports'" class="sidebar-btn cursor-pointer w-full flex items-center px-3 py-2 rounded-lg hover:bg-white hover:text-slate-800 transition-all duration-500 ease-in-out">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="16" height="16" fill="currentColor" class="mr-2">
            <path d="M64 464c-8.8 0-16-7.2-16-16L48 64c0-8.8 7.2-16 16-16l160 0 0 80c0 17.7 14.3 32 32 32l80 0 0 288c0 8.8-7.2 16-16 16L64 464zM64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-293.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5 0 229.5 0L64 0zm56 256c-13.3 0-24 10.7-24 24s10.7 24 24 24l144 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-144 0zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24l144 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-144 0z"/>
          </svg>
          Reports
        </button>
      </li>
    </ul>
  </nav>

  <div onclick="location.href='<?php echo ROOT_URL; ?>/dashboard'" class="fixed bottom-0 left-0 h-[2.7rem] w-full bg-slate-800 border-2 border-slate-400 rounded overflow-hidden flex items-center justify-center cursor-pointer group">
    <div class="absolute left-0 top-0 bottom-0 bg-slate-600 w-0 group-hover:w-full transition-all duration-900 ease-in-out"></div>
    <p class="relative z-[99999] dancing-script text-xl">MineSmart</p>
  </div>

  <button id="hideBtn" class="text-white cursor-pointer glass-bg-color w-[3rem] h-[2rem] flex justify-center items-center rounded-r rounded-l-full absolute -right-4 top-[2.2rem] border-2 border-white shadow-lg shadow-slate-900 hover:-translate-x-2 transition-all duration-500 ease-in-out">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" width="22" height="22" fill="currentColor">
      <path d="M9.4 278.6c-12.5-12.5-12.5-32.8 0-45.3l128-128c9.2-9.2 22.9-11.9 34.9-6.9s19.8 16.6 19.8 29.6l0 256c0 12.9-7.8 24.6-19.8 29.6s-25.7 2.2-34.9-6.9l-128-128z"/>
    </svg>
  </button>
</aside>
