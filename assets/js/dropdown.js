const avatarButton = document.getElementById('avatarButton');
const dropdownMenu = document.getElementById('dropdownMenu');

avatarButton.addEventListener('click', (event) => {
  event.stopPropagation();
  dropdownMenu.classList.toggle('hidden');
  dropdownMenu.classList.toggle('opacity-0');
  dropdownMenu.classList.toggle('scale-95');
});

document.addEventListener('click', (event) => {
  if (!avatarButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
    dropdownMenu.classList.add('hidden');
    dropdownMenu.classList.add('opacity-0');
    dropdownMenu.classList.add('scale-95');
  }
});
