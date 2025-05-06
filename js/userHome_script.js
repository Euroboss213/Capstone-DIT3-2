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

document.addEventListener('DOMContentLoaded', function () {
  const notifButton = document.getElementById('notifButton');
  const modal = document.getElementById('notificationModal');
  const closeModal = document.getElementById('closeModal');

  if (notifButton && modal && closeModal) {
    notifButton.addEventListener('click', () => {
      modal.classList.remove('hidden');
    });

    closeModal.addEventListener('click', () => {
      modal.classList.add('hidden');
    });

    window.addEventListener('click', function (e) {
      // Close only if clicking directly on the overlay (not inside modal-content)
      if (e.target === modal) {
        modal.classList.add('hidden');
      }
    });
  }
});

