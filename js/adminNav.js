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

  function deleteNotification(notifId) {

    const formData = new FormData();
    formData.append('notif_id', notifId);

    fetch('../php/delete-notification.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const notifElement = document.getElementById('notif-' + notifId);
            if (notifElement) notifElement.remove();
        } else {
            alert('Failed to delete notification: ' + (data.error || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('An error occurred while deleting the notification.');
    });
}
  