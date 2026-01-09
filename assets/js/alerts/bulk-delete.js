function openDeleteModal() {
  const deleteModal = document.getElementById('delete-confirmation-modal');
  const deleteModalTitle = document.getElementById('delete-modal-title');
  const deleteModalMessage = document.getElementById('delete-modal-message');
  const confirmDeleteButton = document.getElementById('confirm-delete-button');

  deleteModalTitle.textContent = 'Confirm Deletion of Selected Alerts';
  deleteModalMessage.textContent = 'Are you sure you want to delete the selected alerts? This action cannot be undone.';
  confirmDeleteButton.textContent = 'Delete Selected';

  confirmDeleteButton.onclick = function () {
    document.getElementById('bulkDeleteForm').submit();
  };

  deleteModal.classList.remove('hidden');
}

function closeDeleteModal() {
  document.getElementById('delete-confirmation-modal').classList.add('hidden');
}

function toggleDeleteButtonState() {
  const checkboxes = document.querySelectorAll('input[type="checkbox"][name="selected_ids[]"]');
  const deleteBtn = document.getElementById('delete-trigger-button');
  const countSpan = document.getElementById('selected-count');

  const selectedCount = Array.from(checkboxes).filter(cb => cb.checked).length;

  deleteBtn.disabled = selectedCount === 0;
  countSpan.textContent = `(${selectedCount})`;
}

window.addEventListener('DOMContentLoaded', () => {
  const checkboxes = document.querySelectorAll('input[type="checkbox"][name="selected_ids[]"]');
  checkboxes.forEach(cb => cb.addEventListener('change', toggleDeleteButtonState));
  toggleDeleteButtonState();
});

document.addEventListener('DOMContentLoaded', () => {
  const selectAllCheckbox = document.getElementById('select-all-checkbox');
  const checkboxes = document.querySelectorAll('input[type="checkbox"][name="selected_ids[]"]');

  selectAllCheckbox.addEventListener('change', () => {
    checkboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
    toggleDeleteButtonState();
  });

  checkboxes.forEach(cb => {
    cb.addEventListener('change', () => {
      // Update select-all checkbox state
      const total = checkboxes.length;
      const checked = Array.from(checkboxes).filter(cb => cb.checked).length;

      selectAllCheckbox.checked = checked === total;
      selectAllCheckbox.indeterminate = checked > 0 && checked < total;

      toggleDeleteButtonState();
    });
  });
});
