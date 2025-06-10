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

// helpModals.js

function openHelpModal(id) {
  document.getElementById(id).style.display = "block";
}

function closeHelpModal(id) {
  document.getElementById(id).style.display = "none";
}

window.addEventListener("click", function(event) {
  const modals = document.querySelectorAll(".help-modal");
  modals.forEach(modal => {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });
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

document.addEventListener('DOMContentLoaded', () => {
  const body = document.body;
  const showInactive = body.getAttribute('data-inactive') === '1';
  if (showInactive) {
    document.getElementById('inactiveOverlay').style.display = 'flex';
  }
});

function closeOverlay() {
  document.getElementById('inactiveOverlay').style.display = 'none';
}

