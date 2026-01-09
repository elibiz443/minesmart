<div id="delete-confirmation-modal" class="fixed z-[999999] text-sm inset-0 bg-black/70 flex items-center justify-center hidden">
  <div class="glass-bg-color2 p-6 lg:p-10 rounded-xl border border-gray-400 shadow-2xl shadow-gray-900 w-[90%] md:w-[60%] lg:w-[40%]">
    <h2 class="text-xl text-white font-semibold mb-4" id="delete-modal-title">Confirm Deletion</h2>
    <p class="text-gray-300 mb-6" id="delete-modal-message">Are you absolutely sure you want to delete this item? This action cannot be undone.</p>

    <div class="flex justify-end mt-4">
      <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 cursor-pointer mr-2 bg-gray-300 hover:bg-gray-700 hover:text-white rounded transition-all">Cancel</button>

      <!-- Converted from <a> to <button> -->
      <button id="confirm-delete-button" type="button" class="px-4 py-2 cursor-pointer bg-red-600 hover:bg-red-800 text-white rounded transition-all">
        Delete
      </button>
    </div>
  </div>
</div>
