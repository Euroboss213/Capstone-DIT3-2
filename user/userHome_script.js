const profileButton = document.getElementById('profileButton');
const dropdownMenu = document.getElementById('dropdownMenu');

profileButton.addEventListener('click', (e) => {
  e.stopPropagation(); // Prevent this click from reaching window
  dropdownMenu.classList.toggle('show');
});

window.addEventListener('click', (e) => {
  if (!profileButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
    dropdownMenu.classList.remove('show');
  }
});
