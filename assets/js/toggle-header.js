const toggleButton = document.getElementById('toggle-header');
const header = document.getElementById('headerContent');
let headerVisible = true;

toggleButton.addEventListener('click', () => {
  headerVisible = !headerVisible;

  if (headerVisible) {
    header.classList.remove('-translate-y-full', 'opacity-0');
    header.classList.add('translate-y-0', 'opacity-100');
    toggleButton.querySelector('svg').style.transform = 'rotate(0deg)';
    toggleButton.classList.add('top-[1.8rem]');
    toggleButton.classList.remove('top-1');
  } else {
    header.classList.remove('translate-y-0', 'opacity-100');
    header.classList.add('-translate-y-full', 'opacity-0');
    toggleButton.querySelector('svg').style.transform = 'rotate(180deg)';
    toggleButton.classList.remove('top-[1.8rem]');
    toggleButton.classList.add('top-1');
  }
});
