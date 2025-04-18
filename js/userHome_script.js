const profileButton = document.getElementById('profileButton');
const accdropdownMenu = document.getElementById('acc-dropdownMenu');
const chatButton = document.getElementById('chatButton');
const chatdropdownMenu = document.getElementById('chat-dropdownMenu');

profileButton.addEventListener('click', (e) => {
  e.stopPropagation(); // Prevent this click from reaching window
  accdropdownMenu.classList.toggle('show');
});

window.addEventListener('click', (e) => {
  if (!profileButton.contains(e.target) && !accdropdownMenu.contains(e.target)) {
    accdropdownMenu.classList.remove('show');
  }
});

chatButton.addEventListener('click', (e) => {
  e.stopPropagation(); // Prevent this click from reaching window
  chatdropdownMenu.classList.toggle('show');
});

window.addEventListener('click', (e) => {
  if (!chatButton.contains(e.target) && !chatdropdownMenu.contains(e.target)) {
    chatdropdownMenu.classList.remove('show');
  }
});
