const mainHeader = document.getElementById('main-header');
const headerContainer = document.getElementById('header-container');
const headerLogo = document.getElementById('header-logo');

window.addEventListener('scroll', () => {
  if (window.scrollY > 20) {
    headerContainer.classList.remove('py-4');
    headerContainer.classList.remove('text-[0.7rem]');
    headerContainer.classList.add('py-2');
    headerContainer.classList.add('text-[0.6rem]');
    mainHeader.classList.add('shadow-xl', 'bg-[#0b1120]/95');
    headerLogo.classList.add('scale-70');
  } else {
    headerContainer.classList.remove('py-2');
    headerContainer.classList.remove('text-[0.6rem]');
    headerContainer.classList.add('py-4');
    headerContainer.classList.add('text-[0.7rem]');
    mainHeader.classList.remove('shadow-xl', 'bg-[#0b1120]/95');
    headerLogo.classList.remove('scale-70');
  }
});

const menuBtn = document.getElementById('mobile-menu-btn');
const closeBtn = document.getElementById('close-sidebar');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebar-overlay');
const sidebarLinks = document.querySelectorAll('.sidebar-link');

const toggleSidebar = () => {
  const isOpen = !sidebar.classList.contains('-translate-x-full');

  if (isOpen) {
    sidebar.classList.add('-translate-x-full');

    overlay.classList.add('opacity-0');
    overlay.classList.add('invisible');

    document.body.style.overflow = '';
  } else {
    sidebar.classList.remove('-translate-x-full');

    overlay.classList.remove('invisible');
    overlay.classList.remove('opacity-0');

    document.body.style.overflow = 'hidden';
  }
};

menuBtn.addEventListener('click', toggleSidebar);
closeBtn.addEventListener('click', toggleSidebar);
overlay.addEventListener('click', toggleSidebar);
sidebarLinks.forEach(link => link.addEventListener('click', toggleSidebar));
