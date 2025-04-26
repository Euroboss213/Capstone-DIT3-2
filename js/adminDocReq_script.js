function openModal(data) {
  document.getElementById('infoModal').style.display = 'block';

    document.getElementById('id').value = data.id;
    document.getElementById('first_name').value = data.first_name;
    document.getElementById('middle_name').value = data.middle_name;
    document.getElementById('last_name').value = data.last_name;
    document.getElementById('suffix').value = data.suffix;
    document.getElementById('status').value = data.status;
    document.getElementById('comment').value = data.comment;

    // Handle supporting document display
    const previewDiv = document.getElementById('supporting_document_preview');
    if (data.supporting_document) {
        const fileName = data.supporting_document.split('/').pop(); // Get only file name
        previewDiv.innerHTML = `<a href="${data.supporting_document}" target="_blank">${fileName}</a>`;
    } else {
        previewDiv.innerText = 'No document uploaded.';
    }
}

function closeModal() {
  document.getElementById('infoModal').style.display = 'none';
}

function deleteIndigency() {
  if (confirm("Are you sure you want to delete this record?")) {
    const id = document.getElementById('id').value;

    // Send a POST request to delete
    fetch('../php/delete_indigency.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `id=${id}`
    })
    .then(response => response.text())
    .then(data => {
      alert('Deleted successfully!');
      location.reload(); // Refresh page after delete
    })
    .catch(error => {
      console.error('Error:', error);
    });
  }
}

function deletePermit() {
  if (confirm("Are you sure you want to delete this record?")) {
    const id = document.getElementById('id').value;

    // Send a POST request to delete
    fetch('../php/delete_indigency.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `id=${id}`
    })
    .then(response => response.text())
    .then(data => {
      alert('Deleted successfully!');
      location.reload(); // Refresh page after delete
    })
    .catch(error => {
      console.error('Error:', error);
    });
  }
}

function filterTable() {
  const input = document.getElementById("searchInput");
  const filter = input.value.toLowerCase();
  const table = document.querySelector(".documents-table");
  const rows = table.getElementsByTagName("tr");

  let anyRowFound = false;

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

    if (found) {
      rows[i].style.display = "";
      anyRowFound = true;
    } else {
      rows[i].style.display = "none";
    }
  }

  // Hide the whole table if no rows match
  table.style.display = anyRowFound ? "" : "none";
}

function showTable(tableId) {
  const containers = document.querySelectorAll('.table-container');

  containers.forEach(container => {
    container.style.display = 'none'; // Hide all tables first
  });

  const selectedTable = document.getElementById(tableId);
  if (selectedTable) {
    selectedTable.style.display = 'block'; // Show the clicked one
  }
}


