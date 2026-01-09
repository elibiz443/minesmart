const slidePanel = document.getElementById('slidePanel');
const showPanelBtn = document.getElementById('showPanelBtn');

function slideOutPanel() {
  // Slide it out to the right
  slidePanel.style.right = '-6rem'; // Slide far right (can adjust)
  slidePanel.style.opacity = '0';
  slidePanel.style.pointerEvents = 'none';
  showPanelBtn.classList.remove('hidden');
}

function slideInPanel() {
  // Slide it back in
  slidePanel.style.right = '-0.5rem';
  slidePanel.style.opacity = '1';
  slidePanel.style.pointerEvents = 'auto';
  showPanelBtn.classList.add('hidden');
}

document.addEventListener("DOMContentLoaded", function () {
  const currentPath = window.location.pathname;
  const sidebarButtons = document.querySelectorAll(".sidebar-btn");

  sidebarButtons.forEach(btn => {
    const path = btn.getAttribute("data-path");
    if (currentPath.includes(path)) {
      btn.classList.add('bg-teal-600', 'shadow-md', 'shadow-slate-800');
    } else {
      btn.classList.remove('bg-teal-600', 'shadow-md', 'shadow-slate-800');
    }
  });
});
