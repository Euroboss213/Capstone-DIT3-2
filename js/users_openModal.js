function openReviewModal(data) {
    document.getElementById('reviewModal').style.display = 'block';

    document.getElementById('requestId').value = data.id;
    document.getElementById('userId').value = data.user_id;
    document.getElementById('fullName').value = `${data.first_name} ${data.middle_name ?? ''} ${data.last_name} ${data.suffix ?? ''}`;
    document.getElementById('purpose').value = data.purpose;
    document.getElementById('supportingDocument').value = '';  // Reset file input field
    document.getElementById('documentType').value = data.document_type;
    document.getElementById('dateRequested').value = data.date_requested;
    document.getElementById('status').value = data.status;
    document.getElementById('comment').value = data.comment ?? '';

    // Disable inputs if the status is 'For Pickup' or 'Complete'
    if (data.status === 'For Pickup' || data.status === 'Completed') {
        document.getElementById('purpose').readOnly = true;
        document.getElementById('supportingDocument').disabled = true;
        document.getElementById('documentType').readOnly = true;
        document.getElementById('comment').readOnly = true;
        document.getElementById('saveBtn').disabled = true; // Disable the save button
    } else {
        document.getElementById('purpose').readOnly = false;
        document.getElementById('supportingDocument').disabled = false;
        document.getElementById('documentType').readOnly = false;
        document.getElementById('comment').readOnly = true;
        document.getElementById('saveBtn').disabled = false; // Enable the save button
    }
}

// Close modal when 'x' button is clicked
document.querySelector('.close').addEventListener('click', () => {
    document.getElementById('reviewModal').style.display = 'none';
});

// Close modal when clicked outside the modal content
window.addEventListener('click', (event) => {
    if (event.target === document.getElementById('reviewModal')) {
        document.getElementById('reviewModal').style.display = 'none';
    }
});

// Handle the form submission
document.getElementById('reviewForm').onsubmit = function(e) {
    e.preventDefault();
  
    const formData = new FormData(this);
  
    fetch('../php/update_users_request.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(data => {
      alert(data);
      location.reload(); // Reload the page after the update
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
        location.reload(); // Reload after deletion
      })
      .catch(error => console.error('Error:', error));
    }
};

function deleteFromRow(id) {
  if (confirm('Are you sure you want to cancel this request?')) {
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
}
