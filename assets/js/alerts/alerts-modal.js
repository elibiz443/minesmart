function openNotificationModal(title, content, id, date, mail_from) {
  const notificationModal = document.getElementById('notificationModal');
  const body = document.body;

  document.getElementById('notificationModalTitle').textContent = title;
  document.getElementById('notificationModalContent').innerHTML = content;
  document.getElementById('notificationModalDate').innerHTML = date;
  document.getElementById('notificationModalSource').innerHTML = mail_from;
  notificationModal.classList.remove('hidden');
  notificationModal.classList.add('flex');

  body.style.overflow = 'hidden';

  fetch(`${ROOT_URL}/app/controllers/alerts/mark-as-read.php`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'id=' + encodeURIComponent(id)
  }).then(response => {
    return response.json();
  }).then(data => {
    const card = document.querySelector(`.notification-card input[value="${id}"]`)?.closest('.notification-card');
    if (!card) return;

    const wasUnread = card.classList.contains('bg-teal-100');

    card.classList.remove('bg-teal-100');
    card.classList.add('bg-white');
    card.setAttribute('data-status', 'read');

    const statusParagraph = card.querySelector('.flex.items-center.gap-1');

    if (statusParagraph) {
      statusParagraph.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="10" height="10" fill="currentColor" class="text-sky-800">
          <path d="M64 208.1L256 65.9 448 208.1l0 47.4L289.5 373c-9.7 7.2-21.4 11-33.5 11s-23.8-3.9-33.5-11L64 255.5l0-47.4zM256 0c-12.1 0-23.8 3.9-33.5 11L25.9 156.7C9.6 168.8 0 187.8 0 208.1L0 448c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-239.9c0-20.3-9.6-39.4-25.9-51.4L289.5 11C279.8 3.9 268.1 0 256 0z"/>
        </svg>
        <span class="text-sky-800 font-semibold">Read</span>
      `;
    }

    if (wasUnread) {
      const unreadCountElement = document.querySelector('#headerContent .absolute.-top-1.-right-1');
      if (unreadCountElement) {
        let currentCount = parseInt(unreadCountElement.textContent);
        if (!isNaN(currentCount) && currentCount > 0) {
          currentCount--;
          unreadCountElement.textContent = currentCount;
          if (currentCount === 0) {
            unreadCountElement.style.display = 'none';
          }
        }
      }
    }
  }).catch(error => {
    console.error('Error marking notification as read:', error);
  });
}

function closeNotificationModal() {
  const notificationModal = document.getElementById('notificationModal');
  const body = document.body;

  notificationModal.classList.remove('flex');
  notificationModal.classList.add('hidden');

  body.style.overflow = '';
}

document.addEventListener('click', function(event) {
  const notificationModal = document.getElementById('notificationModal');
  const notificationModalSection = notificationModal.querySelector('.notificationSection');

  if (
    notificationModal.classList.contains('flex') &&
    notificationModalSection &&
    !notificationModalSection.contains(event.target) &&
    !event.target.closest('.notification-card')
  ) {
    closeNotificationModal();
  }
});
