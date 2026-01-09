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

      <!-- Sites -->
      <li>
        <button data-path="/app/views/sites" onclick="location.href='<?php echo ROOT_URL; ?>/sites'" class="sidebar-btn cursor-pointer w-full flex items-center px-3 py-2 rounded-lg hover:bg-white hover:text-slate-800 transition-all duration-500 ease-in-out">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="16" height="16" fill="currentColor" class="mr-2">
            <path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/>
          </svg>
          <span>Sites</span>
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
        <button onclick="location.href='<?php echo ROOT_URL; ?>/evidence'" class="sidebar-btn cursor-pointer w-full flex items-center px-3 py-2 rounded-lg hover:bg-white hover:text-slate-800 transition-all duration-500 ease-in-out">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="16" height="16" fill="currentColor" class="mr-2">
            <path d="M64 464c-8.8 0-16-7.2-16-16L48 64c0-8.8 7.2-16 16-16l160 0 0 80c0 17.7 14.3 32 32 32l80 0 0 288c0 8.8-7.2 16-16 16L64 464zM64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-293.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5 0 229.5 0L64 0zm56 256c-13.3 0-24 10.7-24 24s10.7 24 24 24l144 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-144 0zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24l144 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-144 0z"/>
          </svg>
          Evidence Packs
        </button>
      </li>

      <!-- Inspector planner -->
      <li>
        <button onclick="location.href='<?php echo ROOT_URL; ?>/inspector'" class="sidebar-btn cursor-pointer w-full flex items-center px-3 py-2 rounded-lg hover:bg-white hover:text-slate-800 transition-all duration-500 ease-in-out">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="16" height="16" fill="currentColor" class="mr-2">
            <path d="M192 0c-41.8 0-77.4 26.7-90.5 64L64 64C28.7 64 0 92.7 0 128L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64l-37.5 0C269.4 26.7 233.8 0 192 0zm0 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM72 272a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zm104-16l128 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-128 0c-8.8 0-16-7.2-16-16s7.2-16 16-16zM72 368a24 24 0 1 1 48 0 24 24 0 1 1 -48 0zm88 0c0-8.8 7.2-16 16-16l128 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-128 0c-8.8 0-16-7.2-16-16z"/>
          </svg>
          <span>Inspector planner</span>
        </button>
      </li>

      <!-- Analytics -->
      <li>
        <button onclick="location.href='<?php echo ROOT_URL; ?>/analytics'" class="sidebar-btn cursor-pointer w-full flex items-center px-3 py-2 rounded-lg hover:bg-white hover:text-slate-800 transition-all duration-500 ease-in-out">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" fill="currentColor" class="mr-2">
            <path d="M32 32c17.7 0 32 14.3 32 32l0 336c0 8.8 7.2 16 16 16l400 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L80 480c-44.2 0-80-35.8-80-80L0 64C0 46.3 14.3 32 32 32zM160 224c17.7 0 32 14.3 32 32l0 64c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32zm128-64l0 160c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-160c0-17.7 14.3-32 32-32s32 14.3 32 32zm64 32c17.7 0 32 14.3 32 32l0 96c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-96c0-17.7 14.3-32 32-32zM480 96l0 224c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-224c0-17.7 14.3-32 32-32s32 14.3 32 32z"/>
          </svg>
          <span>Analytics</span>
        </button>
      </li>

      <!-- Settings -->
      <li>
        <button onclick="location.href='<?php echo ROOT_URL; ?>/settings'" class="sidebar-btn cursor-pointer w-full flex items-center px-3 py-2 rounded-lg hover:bg-white hover:text-slate-800 transition-all duration-500 ease-in-out">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16" height="16" fill="currentColor" class="mr-2">
            <path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/>
          </svg>
          <span>Settings</span>
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
