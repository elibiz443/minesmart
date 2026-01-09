<div id="slidePanel" class="fixed z-[90] top-1/2 -right-[0.5rem] transform -translate-y-1/2 w-[3rem] md:w-[5.5rem] text-xs lg:text-sm space-y-[0.4rem] md:space-y-[0.6rem] transition-all duration-900 ease-in-out">
  <a href="<?php echo ROOT_URL; ?>/app/views/sites" class="relative z-[99] bg-yellow-400 text-yellow-900 font-semibold py-1.5 w-full rounded-l-full flex items-center justify-center border-l-2 border-y-2 border-yellow-900 shadow-lg shadow-slate-900 hover:w-[4rem] hover:-translate-x-[1rem] md:hover:w-[7rem] md:hover:-translate-x-[1.9rem] transition-all duration-700 ease-in-out" title="Go Back">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" width="16" height="16" fill="currentColor" class="mr-1">
      <path d="M9.4 278.6c-12.5-12.5-12.5-32.8 0-45.3l128-128c9.2-9.2 22.9-11.9 34.9-6.9s19.8 16.6 19.8 29.6l0 256c0 12.9-7.8 24.6-19.8 29.6s-25.7 2.2-34.9-6.9l-128-128z"/>
    </svg>
    <span class="hidden md:block">Back</span>
  </a>
  <button onclick="openModal()" class="relative z-[99] bg-teal-300 cursor-pointer text-teal-900 font-semibold py-1.5 w-full rounded-l-full flex items-center justify-center border-l-2 border-y-2 border-teal-900 shadow-lg shadow-slate-900 hover:w-[4rem] hover:-translate-x-[1rem] md:hover:w-[7rem] md:hover:-translate-x-[1.9rem] transition-all duration-700 ease-in-out" title="Add">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="16" height="16" fill="currentColor" class="mr-1">
      <path d="M0 64C0 28.7 28.7 0 64 0L224 0l0 128c0 17.7 14.3 32 32 32l128 0 0 125.7-86.8 86.8c-10.3 10.3-17.5 23.1-21 37.2l-18.7 74.9c-2.3 9.2-1.8 18.8 1.3 27.5L64 512c-35.3 0-64-28.7-64-64L0 64zm384 64l-128 0L256 0 384 128zM549.8 235.7l14.4 14.4c15.6 15.6 15.6 40.9 0 56.6l-29.4 29.4-71-71 29.4-29.4c15.6-15.6 40.9-15.6 56.6 0zM311.9 417L441.1 287.8l71 71L382.9 487.9c-4.1 4.1-9.2 7-14.9 8.4l-60.1 15c-5.5 1.4-11.2-.2-15.2-4.2s-5.6-9.7-4.2-15.2l15-60.1c1.4-5.6 4.3-10.8 8.4-14.9z"/>
    </svg>
    <span class="hidden md:block">Edit</span>
  </button>
  <a href="<?php echo ROOT_URL; ?>/app/controllers/sites/delete.php?id=<?php echo $selected_site['id']; ?>" onclick="return confirm('Are you sure?')" class="relative z-[99] bg-red-300 cursor-pointer text-red-900 font-semibold py-1.5 w-full rounded-l-full flex items-center justify-center border-l-2 border-y-2 border-red-900 shadow-lg shadow-slate-900 hover:w-[4rem] hover:-translate-x-[1rem] md:hover:w-[7rem] md:hover:-translate-x-[1.9rem] transition-all duration-700 ease-in-out" title="Add">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16" height="16" fill="currentColor" class="mr-1">
      <path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0L284.2 0c12.1 0 23.2 6.8 28.6 17.7L320 32l96 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 96C14.3 96 0 81.7 0 64S14.3 32 32 32l96 0 7.2-14.3zM32 128l384 0 0 320c0 35.3-28.7 64-64 64L96 512c-35.3 0-64-28.7-64-64l0-320zm96 64c-8.8 0-16 7.2-16 16l0 224c0 8.8 7.2 16 16 16s16-7.2 16-16l0-224c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16l0 224c0 8.8 7.2 16 16 16s16-7.2 16-16l0-224c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16l0 224c0 8.8 7.2 16 16 16s16-7.2 16-16l0-224c0-8.8-7.2-16-16-16z"/>
    </svg>
    <span class="hidden md:block">Delete</span>
  </a>

  <div class="bg-white absolute top-0 left-1/2 transform -translate-x-1/2 h-[9rem] md:h-[9.8rem] shadow-md shadow-slate-900 w-[0.6rem]">
    <button id="hidePanelBtn" onclick="slideOutPanel()" class="group cursor-pointer bg-white text-slate-800 shadow-lg shadow-slate-900 size-[1.6rem] absolute -bottom-2 left-1/2 transform -translate-x-1/2 rounded-lg flex items-center justify-center hover:scale-120 transition-all duration-500 ease-in-out">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="16" height="16" fill="currentColor">
        <path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/>
      </svg>
    </button>
  </div>
</div>

<!-- Toggle Button (Initially Hidden) -->
<button id="showPanelBtn" onclick="slideInPanel()" class="hidden cursor-pointer fixed top-1/2 -right-2 transform -translate-y-1/2 bg-white text-slate-800 size-[1.8rem] flex items-center justify-center rounded-lg shadow-lg shadow-slate-900 z-[91] hover:right-0 hover:scale-120 transition-all duration-900 ease-in-out">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="14" height="14" fill="currentColor">
    <path d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/>
  </svg>
</button>