<div id="notificationModal" class="fixed inset-0 bg-black/70 z-[999999] hidden items-center justify-center px-4">
  <div class="notificationSection bg-white w-full max-w-5xl rounded-l-2xl overflow-hidden shadow-2xl border border-slate-300">
    
    <!-- Header -->
    <div class="flex items-center justify-between bg-slate-100 px-6 py-4 border-b">
      <div class="flex items-center gap-3">
        <div class="bg-teal-200 text-teal-800 p-2 rounded-full">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 512 512">
            <path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48L48 64zM0 176L0 384c0 35.3 28.7 64 64 64h384c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/>
          </svg>
        </div>
        <h3 id="notificationModalTitle" class="text-xl sm:text-2xl font-bold text-slate-800 break-words"></h3>
      </div>
      <button onclick="closeNotificationModal()" class="cursor-pointer text-slate-500 hover:text-red-600 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <!-- Meta info -->
    <div class="px-6 pt-4 text-sm text-slate-500 flex flex-wrap justify-between">
      <div class="flex items-center gap-2">
        <span class="font-medium text-slate-700">From:</span>
        <span id="notificationModalSource" class="break-all"></span>
      </div>
      <div class="mt-2 sm:mt-0">
        <span class="font-medium text-slate-700">Received:</span>
        <span id="notificationModalDate" class="ml-1"></span>
      </div>
    </div>

    <!-- Body -->
    <div class="px-10 pt-8 overflow-y-auto h-[14rem]">
      <div id="notificationModalContent" class="text-slate-800 text-[15px] leading-relaxed whitespace-pre-line break-words"></div>
    </div>

    <!-- Footer -->
    <div class="bg-slate-50 px-6 py-4 flex justify-end border-t">
      <button onclick="closeNotificationModal()" class="cursor-pointer bg-teal-600 hover:bg-teal-700 text-white font-semibold px-5 py-2 rounded-lg shadow-sm hover:shadow transition-all duration-300">
        Got it!
      </button>
    </div>
  </div>
</div>
