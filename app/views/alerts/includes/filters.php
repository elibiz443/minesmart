<!-- Filters -->
<div id="filterContainer" class="flex space-x-4 items-center mb-4">
  <div class="pl-2 md:pl-6">
    <input type="checkbox" id="select-all-checkbox" class="checkbox bg-slate-700/70 appearance-none h-6 w-6 border-2 border-white rounded-md cursor-pointer checked:bg-teal-600 checked:border-teal-600 checked:ring-2 checked:ring-teal-600 checked:ring-offset-2 checked:shadow-lg checked:shadow-teal-500/50 transition-all duration-300 ease-in-out">
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2 text-sm w-full">
    <input type="text" id="filter-title" placeholder="Search title..." class="form-select bg-gradient-to-r from-yellow-100 to-teal-100/90 border-2 border-white text-teal-800 rounded-md text-sm px-4 py-2 shadow-lg shadow-slate-800 outline-none focus:border-teal-500 focus:ring-teal-500 placeholder-teal-800">
    
    <select id="filter-status" class="form-select bg-gradient-to-r from-yellow-100 to-teal-100/90 border-2 border-white text-teal-800 rounded-md text-sm px-4 py-2 shadow-lg shadow-slate-800 outline-none focus:border-teal-500 focus:ring-teal-500">
      <option value="">All Status</option>
      <option value="read">Read</option>
      <option value="unread">Unread</option>
    </select>
    
    <select id="filter-date" class="form-select bg-gradient-to-r from-yellow-100 to-teal-100/90 border-2 border-white text-teal-800 rounded-md text-sm px-4 py-2 shadow-lg shadow-slate-800 outline-none focus:border-teal-500 focus:ring-teal-500">
      <option value="newest">Newest First</option>
      <option value="oldest">Oldest First</option>
    </select>

    <button id="delete-trigger-button" onclick="openDeleteModal()" type="button" disabled class="cursor-pointer w-full px-4 py-2 rounded-lg text-sm bg-pink-200 hover:bg-red-200 text-pink-800 hover:text-red-800 flex items-center justify-center gap-2 shadow-lg shadow-slate-800 hover:shadow-none transition-all duration-500 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed">
      <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="14" height="14" viewBox="0 0 448 512">
        <path d="M135.2 17.7C138.8 7.4 148.5 0 159.3 0h129.4c10.8 0 20.5 7.4 24.1 17.7L328.5 32H432c8.8 0 16 7.2 16 16s-7.2 16-16 16H416l-21.2 372.6c-1.4 24.7-21.9 43.4-46.6 43.4H99.8c-24.7 0-45.2-18.7-46.6-43.4L32 64H16C7.2 64 0 56.8 0 48s7.2-16 16-16H119.5l15.7-14.3z"/>
      </svg>
      Delete Selected
      <span id="selected-count" class="ml-2 font-bold text-teal-900">(0)</span>
    </button>
  </div>

  <div>
    <button type="button" id="hideFilterBtn" class="group relative cursor-pointer size-7 flex items-center justify-center border-2 border-white rounded-full text-white shadow-lg shadow-slate-900 glass-bg-color3 hover:shadow-none transition-all duration-500 ease-in-out mt-1.5">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="14" height="14" fill="currentColor">
        <path d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 141.2 160 448c0 17.7 14.3 32 32 32s32-14.3 32-32l0-306.7L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z"/>
      </svg>
      <div class="hidden absolute -top-[2rem] right-[2rem] text-xs glass-bg-color px-2 py-1 rounded-full shadow-lg shadow-slate-600 group-hover:block transition-all duration-700 ease-in-out">
        Minimize Filter
      </div>
    </button>
  </div>
</div>

<div id="showFilterButtonContainer" class="hidden fixed z-[999] top-24 right-4 md:right-10 text-right">
  <button type="button" id="showFilterBtn" class="group relative cursor-pointer size-7 flex items-center justify-center border-2 border-white rounded-full text-white shadow-lg shadow-slate-900 glass-bg-color3 hover:shadow-none transition-all duration-500 ease-in-out">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="14" height="14" fill="currentColor">
      <path
        d="M169.4 470.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 370.8 224 64c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 306.7L54.6 265.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z" />
    </svg>
    <div
      class="hidden absolute top-0 -left-[5.4rem] text-xs glass-bg-color px-2 py-1 rounded-full shadow-lg shadow-slate-600 group-hover:block transition-all duration-700 ease-in-out">
      Show Filter
    </div>
  </button>
</div>
