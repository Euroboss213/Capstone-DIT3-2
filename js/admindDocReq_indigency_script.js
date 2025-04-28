function filterTable() {
    const input = document.getElementById("searchInput");
    const filter = input.value.toLowerCase();
    const table = document.querySelector(".indigency-table");
    const rows = table.getElementsByTagName("tr");
  
    for (let i = 1; i < rows.length; i++) { // start at 1 to skip the header
      const cells = rows[i].getElementsByTagName("td");
      let match = false;
  
      for (let j = 0; j < cells.length - 1; j++) { // don't include the action button
        const cell = cells[j];
        if (cell && cell.textContent.toLowerCase().includes(filter)) {
          match = true;
          break;
        }
      }
  
      rows[i].style.display = match ? "" : "none";
    }
  }

  function openReviewModal(data) {
    document.getElementById('reviewModal').style.display = 'block';
  
    document.getElementById('requestId').value = data.id;
    document.getElementById('userId').value = data.user_id;
    document.getElementById('fullName').value = `${data.first_name} ${data.middle_name ?? ''} ${data.last_name} ${data.suffix ?? ''}`;
    document.getElementById('purpose').value = data.purpose;
    document.getElementById('supportingDocument').value = data.supporting_document;
    document.getElementById('documentType').value = data.document_type;
    document.getElementById('dateRequested').value = data.date_requested;
    document.getElementById('status').value = data.status;
    document.getElementById('comment').value = data.comment ?? '';
  }
  
  // Close modal
  document.querySelector('.close').onclick = function() {
    document.getElementById('reviewModal').style.display = 'none';
  };
  
  // Save changes
  document.getElementById('reviewForm').onsubmit = function(e) {
    e.preventDefault();
  
    const formData = new FormData(this);
  
    fetch('../php/admin_updateIndigency.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(data => {
      alert(data);
      location.reload();
    })
    .catch(error => console.error('Error:', error));
  };
  
  // Delete request
  document.getElementById('deleteBtn').onclick = function() {
    if (confirm('Are you sure you want to delete this request?')) {
      const id = document.getElementById('requestId').value;
  
      fetch('../php/admin_deleteIndigency.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `id=${id}`
      })
      .then(response => response.text())
      .then(data => {
        alert(data);
        location.reload();
      })
      .catch(error => console.error('Error:', error));
    }
  };
  
  //Review Modal

  function openReviewModal(data) {
    document.getElementById('reviewModal').style.display = 'block';
  
    document.getElementById('requestId').value = data.id;
    document.getElementById('userId').value = data.user_id;
    document.getElementById('fullName').value = `${data.first_name} ${data.middle_name ?? ''} ${data.last_name} ${data.suffix ?? ''}`;
    document.getElementById('purpose').value = data.purpose;
    document.getElementById('documentType').value = data.document_type;
    document.getElementById('dateRequested').value = data.date_requested;
    document.getElementById('status').value = data.status;
    document.getElementById('comment').value = data.comment ?? '';
  
    const fileName = data.supporting_document;
    if (fileName) {
      const filePath = `../uploads/${fileName}`; // Adjust if uploads folder is different
      document.getElementById('supportingDocumentLink').href = filePath;
      document.getElementById('supportingDocumentLink').textContent = "View Document";
    } else {
      document.getElementById('supportingDocumentLink').href = "#";
      document.getElementById('supportingDocumentLink').textContent = "No file uploaded";
    }
  }
  
  