const profileButton = document.getElementById('profileButton');
const dropdownMenu = document.getElementById('dropdownMenu');

profileButton.addEventListener('click', (e) => {
    e.stopPropagation();
    dropdownMenu.classList.toggle('show');
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
  