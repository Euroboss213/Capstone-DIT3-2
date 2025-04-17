const profileButton = document.getElementById('profileButton');
const dropdownMenu = document.getElementById('dropdownMenu');
const modal = document.getElementById("infoModal");

profileButton.addEventListener('click', (e) => {
  e.stopPropagation();
  dropdownMenu.classList.toggle('show');
});

function openModal(data) {
  modal.style.display = "block";

  // Fill in the form
  for (const key in data) {
    const el = document.getElementById(key);
    if (el) {
      el.value = data[key];
    }
  }
}

function closeModal() {
  modal.style.display = "none";
}

// Merged window click event
window.addEventListener('click', (e) => {
  // Close dropdown if clicked outside
  if (!profileButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
    dropdownMenu.classList.remove('show');
  }

  // Close modal if clicked outside the modal content
  if (e.target === modal) {
    closeModal();
  }
});

// Handle the form submission to save changes
document.getElementById('residentForm').addEventListener('submit', function(e) {
  e.preventDefault(); // Prevent default form submission

  const formData = new FormData(this); // Collect form data

  // Use AJAX to send data to the PHP server
  fetch('../php/update_resident.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert('Resident information updated successfully.');
      closeModal(); // Close the modal after successful update
      location.reload(); // Reload the page to reflect changes
    } else {
      alert('Error updating information. Please try again.');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('There was an error processing your request.');
  });
});