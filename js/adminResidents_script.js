const modal = document.getElementById("infoModal");
const addModal = document.getElementById("addModal");
const accModal = document.getElementById("accModal");
const editAccModal = document.getElementById("editAccModal");

function openModalById(modalId, data) {
  const modalElement = document.getElementById(modalId);
  modalElement.style.display = "block";

  if (data) {
    for (const key in data) {
      const el = document.getElementById(key);
      if (el) {
        el.value = data[key];
      }
    }
  }

  togglePwdIdField();
}

function openModal(data) {
  openModalById("infoModal", data);
}

function openNewResidentModal() {
  document.getElementById("addResidentForm").reset();
  openModalById("addModal");
}

function openAccModal(data) {
  openModalById("accModal", data);
}

function openEditAccModal(data) {
  openModalById("editAccModal", data);
  
  // If needed, to be explicit:
  document.getElementById('account_id').value = data.id || '';
  document.getElementById('first_name').value = data.first_name || '';
  document.getElementById('middle_name').value = data.middle_name || '';
  document.getElementById('last_name').value = data.last_name || '';
  document.getElementById('suffix').value = data.suffix || '';
}

function closeModal() {
  modal.style.display = "none";
}

function closeAddModal() {
  addModal.style.display = "none";
}

function closeAccModal() {
  accModal.style.display = "none";
}

function closeEditAccModal() {
  editAccModal.style.display = "none";
}

// Merged window click event
window.addEventListener('click', (e) => {
  if (!profileButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
    dropdownMenu.classList.remove('show');
  }
  if (e.target === modal) {
    closeModal();
  }
  if (e.target === addModal) {
    closeAddModal();
  }
});

// Handle the form submission to save changes
document.getElementById('residentForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const formData = new FormData(this);

  fetch('../php/update_resident.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    console.log('Update response:', data);  // Debug log for backend response
    if (data.success) {
      alert('Resident information updated successfully.');
      closeModal();
      location.reload();
    } else {
      alert('Error updating information: ' + (data.message || 'Please try again.'));
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

  for (let i = 1; i < rows.length; i++) {
    const cells = rows[i].getElementsByTagName("td");
    let found = false;

    for (let j = 0; j < cells.length - 1; j++) {
      const cell = cells[j];
      if (cell.textContent.toLowerCase().includes(filter)) {
        found = true;
        break;
      }
    }

    rows[i].style.display = found ? "" : "none";
  }
}

document.getElementById('addResidentForm').addEventListener('submit', function(event) {
  event.preventDefault();
  
  const formData = new FormData(this);

  fetch('../php/add_resident.php', {
    method: 'POST',
    body: formData
  })
  .then(response => {
    return response.text().then(text => {
      try {
        return JSON.parse(text);
      } catch (err) {
        console.error("Raw response (not JSON):", text);
        throw new Error("Invalid JSON: " + err.message);
      }
    });
  })
  .then(data => {
    if (data.success) {
      alert('Resident added successfully!');
      closeAddModal();
      location.reload();
      document.getElementById('addResidentForm').reset();
    } else {
      alert('Error adding resident: ' + data.message);
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('An error occurred: ' + error.message);
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
        location.reload();
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

function togglePwdIdField() {
  const pwdSelect = document.getElementById("pwdSelect");
  const pwdIdField = document.getElementById("pwdIdField");
  const spSelect = document.getElementById("spSelect");
  const spIdField = document.getElementById("spIdField");

  const pwd = document.getElementById("pwd");
  const pwd_id_no = document.getElementById("pwd_id_no");
  const solo_parent = document.getElementById("solo_parent");
  const solo_parent_id_no = document.getElementById("solo_parent_id_no");

  // PWD Select
  const isPwdSelectYes = pwdSelect.value === "Yes";
  pwdIdField.disabled = !isPwdSelectYes;
  pwdIdField.required = isPwdSelectYes;
  if (!isPwdSelectYes && !pwdIdField.value) pwdIdField.value = "";

  // Solo Parent Select
  const isSpSelectYes = spSelect.value === "Yes";
  spIdField.disabled = !isSpSelectYes;
  spIdField.required = isSpSelectYes;
  if (!isSpSelectYes && !spIdField.value) spIdField.value = "";

  // PWD (Yes/No) Input
  const isPwdYes = pwd.value === "Yes";
  pwd_id_no.disabled = !isPwdYes;
  pwd_id_no.required = isPwdYes;
  if (!isPwdYes && !pwd_id_no.value) pwd_id_no.value = "";

  // Solo Parent (Yes/No) Input
  const isSoloYes = solo_parent.value === "Yes";
  solo_parent_id_no.disabled = !isSoloYes;
  solo_parent_id_no.required = isSoloYes;
  if (!isSoloYes && !solo_parent_id_no.value) solo_parent_id_no.value = "";
}


window.onload = togglePwdIdField;

window.addEventListener('DOMContentLoaded', () => {
  const birthDateInput = document.getElementById('birth_date');

  birthDateInput.addEventListener('change', () => {
    const inputDate = new Date(birthDateInput.value);
    const today = new Date();

    const eighteenYearsAgo = new Date();
    eighteenYearsAgo.setFullYear(today.getFullYear() - 18);

    birthDateInput.setCustomValidity("");

    if (isNaN(inputDate)) return;

    if (inputDate > today) {
      birthDateInput.setCustomValidity("Birth date cannot be in the future.");
    } else if (inputDate > eighteenYearsAgo) {
      birthDateInput.setCustomValidity("You must be at least 18 years old.");
    }

    birthDateInput.reportValidity();
  });

  const eighteenYearsAgo = new Date();
  eighteenYearsAgo.setFullYear((new Date()).getFullYear() - 18);
  birthDateInput.max = eighteenYearsAgo.toISOString().split('T')[0];
});
