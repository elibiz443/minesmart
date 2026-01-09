const slideMapSidebar = document.getElementById('slideMapSidebar');
const hideMapSidebar = document.getElementById('hideMapSidebar');
const showMapSidebar = document.getElementById('showMapSidebar');

hideMapSidebar.addEventListener('click', function() {
  slideMapSidebar.classList.add('lg:-translate-x-[120%]');
  slideMapSidebar.classList.add('-translate-x-[120%]');

  slideMapSidebar.classList.remove('lg:translate-x-0');
  slideMapSidebar.classList.remove('translate-x-0');
});

showMapSidebar.addEventListener('click', function() {
  slideMapSidebar.classList.remove('lg:-translate-x-[120%]');
  slideMapSidebar.classList.remove('-translate-x-[120%]');

  slideMapSidebar.classList.add('lg:translate-x-0');
  slideMapSidebar.classList.add('translate-x-0');
});
