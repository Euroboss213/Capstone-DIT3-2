const profileButton = document.getElementById('profileButton');
const dropdownMenu = document.getElementById('dropdownMenu');
const modal = document.getElementById("infoModal");
const addModal = document.getElementById("addModal");

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

function filterTable() {
  const input = document.getElementById("searchInput");
  const filter = input.value.toLowerCase();
  const table = document.querySelector(".residents-table");
  const rows = table.getElementsByTagName("tr");

  // Start from 1 to skip the table header
  for (let i = 1; i < rows.length; i++) {
    const cells = rows[i].getElementsByTagName("td");
    let found = false;

    for (let j = 0; j < cells.length - 1; j++) { // exclude the "Action" column
      const cell = cells[j];
      if (cell.textContent.toLowerCase().includes(filter)) {
        found = true;
        break;
      }
    }

    rows[i].style.display = found ? "" : "none";
  }
}

// Show add modal
function openNewResidentModal() {
  document.getElementById("addResidentForm").reset();
  addModal.style.display = "block";
}

// Close add modal
function closeAddModal() {
  addModal.style.display = "none";
}

// Close modals if click outside
window.addEventListener("click", function (e) {
  if (e.target === addModal) closeAddModal();
});

document.getElementById('addResidentForm').addEventListener('submit', function(event) {
  event.preventDefault();  // Prevent the form from submitting the traditional way
  
  const formData = new FormData(this);  // Create a FormData object from the form

  fetch('../php/add_resident.php', {
    method: 'POST',
    body: formData
  })
  .then(response => {
    return response.text().then(text => {
      try {
        return JSON.parse(text);  // Attempt to parse the response as JSON
      } catch (err) {
        console.error("Raw response (not JSON):", text);
        throw new Error("Invalid JSON: " + err.message);
      }
    });
  })
  .then(data => {
    if (data.success) {
      alert('Resident added successfully!');
      closeAddModal();  // Close the modal after successful submission
      document.getElementById('addResidentForm').reset();  // Reset the form fields
    } else {
      alert('Error adding resident: ' + data.message);  // Show error message if not successful
    }
  })
  .catch(error => {
    console.error('Error:', error);  // Log any error that occurs during the fetch request
    alert('An error occurred: ' + error.message);  // Show an error message to the user
  });
});


function deleteResident() {
  const id = document.getElementById('id').value;
  if (!id) {
    alert("No resident selected.");
    return;
  }

  if (confirm("Are you sure you want to delete this resident?")) {
    fetch(`../php/delete_resident.php?id=${id}`, {
      method: 'GET'
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert("Resident deleted successfully.");
        closeModal();
        location.reload(); // Reload to update the table
      } else {
        alert("Failed to delete resident.");
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert("An error occurred while deleting the resident.");
    });
  }
}

