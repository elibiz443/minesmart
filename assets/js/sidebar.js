// Element references
const slideDiv = document.getElementById('slideDiv');
const hideBtn = document.getElementById('hideBtn');
const showBtn = document.getElementById('showBtn');
const mainContent = document.getElementById('mainContent');
const headerContent = document.getElementById('headerContent');
const welcomeMessage = document.getElementById('welcomeMessage');
const scrollableNav = document.getElementById('scrollable');
const paginationComponent = document.getElementById('paginationComponent');
const stickyNav = document.getElementById('stickyNav');

// Sidebar functions
function hideSidebar() {
  slideDiv.classList.remove('translate-x-0');
  slideDiv.classList.add('-translate-x-[200%]');

  mainContent.classList.remove('w-[calc(100%-12rem)]');
  mainContent.classList.add('w-full');

  headerContent.classList.remove('w-[calc(100%-12rem)]');
  headerContent.classList.add('w-full');

  paginationComponent?.classList.remove('w-[calc(100%-12rem)]');
  paginationComponent?.classList.add('w-full');

  stickyNav?.classList.remove('w-[calc(90%-12rem)]');
  stickyNav?.classList.add('w-[90%]');

  showBtn.classList.remove('hidden');
  welcomeMessage?.classList.add('pl-14');
}

function showSidebar() {
  slideDiv.classList.add('translate-x-0');
  slideDiv.classList.remove('-translate-x-[200%]');

  mainContent.classList.add('w-[calc(100%-12rem)]');
  mainContent.classList.remove('w-full');

  headerContent.classList.add('w-[calc(100%-12rem)]');
  headerContent.classList.remove('w-full');

  paginationComponent?.classList.add('w-[calc(100%-12rem)]');
  paginationComponent?.classList.remove('w-full');

  stickyNav?.classList.add('w-[calc(90%-12rem)]');
  stickyNav?.classList.remove('w-[90%]');

  showBtn.classList.add('hidden');
  welcomeMessage?.classList.remove('pl-14');
}

// Event bindings for sidebar toggle
hideBtn?.addEventListener('click', hideSidebar);
showBtn?.addEventListener('click', showSidebar);

// Responsive auto-toggle
document.addEventListener('DOMContentLoaded', () => {
  if (window.innerWidth < 1024) {
    hideSidebar();
  } else {
    showSidebar();
  }

  // Handle toggle-submenu clicks via delegation
  scrollableNav.addEventListener('click', (e) => {
    const btn = e.target.closest('.toggle-submenu');
    if (!btn) return;

    e.stopPropagation();

    const submenu = btn.nextElementSibling;
    const icon = btn.querySelector('.arrow-pointer');

    if (!submenu || !submenu.classList) return;

    const isOpen = !submenu.classList.contains('hidden');

    // Close all other submenus
    document.querySelectorAll('.submenu').forEach(menu => {
      if (menu !== submenu) menu.classList.add('hidden');
    });
    document.querySelectorAll('.arrow-pointer').forEach(i => {
      if (i !== icon) i.classList.remove('rotate-180');
    });

    // Toggle current submenu
    submenu.classList.toggle('hidden');
    icon?.classList.toggle('rotate-180');

    const anyOpen = Array.from(document.querySelectorAll('.submenu')).some(menu => !menu.classList.contains('hidden'));

    scrollableNav.classList.toggle('overflow-y-auto', !anyOpen);
    scrollableNav.classList.toggle('overflow-visible', anyOpen);
  });

  // Click outside: close submenus and restore scroll
  document.addEventListener('click', () => {
    document.querySelectorAll('.submenu').forEach(menu => menu.classList.add('hidden'));
    document.querySelectorAll('.arrow-pointer').forEach(icon => icon.classList.remove('rotate-180'));
    scrollableNav.classList.add('overflow-y-auto');
    scrollableNav.classList.remove('overflow-visible');
  });

  // On scroll: close submenus and restore scroll behavior
  let scrollTimeout;
  scrollableNav.addEventListener('scroll', () => {
    clearTimeout(scrollTimeout);
    scrollTimeout = setTimeout(() => {
      document.querySelectorAll('.submenu').forEach(menu => menu.classList.add('hidden'));
      document.querySelectorAll('.arrow-pointer').forEach(icon => icon.classList.remove('rotate-180'));
      scrollableNav.classList.add('overflow-y-auto');
      scrollableNav.classList.remove('overflow-visible');
    }, 50);
  });

  // Active button highlight
  document.querySelectorAll('aside button').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('aside button').forEach(b =>
        b.classList.remove('bg-teal-600', 'shadow-md', 'shadow-slate-800')
      );
      btn.classList.add('bg-teal-600', 'shadow-md', 'shadow-slate-800');
    });
  });
});

// Sidebar responsive toggle on resize
let previousWidth = window.innerWidth;
window.addEventListener('resize', () => {
  const currentWidth = window.innerWidth;
  const wasLarge = previousWidth >= 1024;
  const isNowLarge = currentWidth >= 1024;

  if (wasLarge !== isNowLarge) {
    isNowLarge ? showSidebar() : hideSidebar();
  }

  previousWidth = currentWidth;
});
