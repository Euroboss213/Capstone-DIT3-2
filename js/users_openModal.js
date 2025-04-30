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
        document.getElementById('comment').readOnly = false;
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
function openModal(data) {
    document.getElementById('infoModal').style.display = 'block';

    // Fill in fields
    document.querySelector('input[name="last_name"]').value = data.last_name || '';
    document.querySelector('input[name="first_name"]').value = data.first_name || '';
    document.querySelector('input[name="middle_name"]').value = data.middle_name || '';
    document.querySelector('input[name="suffix"]').value = data.suffix || '';
    document.querySelector('textarea[name="purpose"]').value = data.purpose || '';
    document.querySelector('input[name="comment"]').value = data.comment || '';
    document.querySelector('input[name="id"]').value = data.id || '';
    

    // Determine if fields should be disabled
    const isReadOnly = data.status === 'For Pickup';

    document.querySelector('input[name="last_name"]').readOnly = isReadOnly;
    document.querySelector('input[name="first_name"]').readOnly = isReadOnly;
    document.querySelector('input[name="middle_name"]').readOnly = isReadOnly;
    document.querySelector('input[name="suffix"]').readOnly = isReadOnly;
    document.querySelector('textarea[name="purpose"]').readOnly = isReadOnly;
    document.querySelector('input[name="comment"]').readOnly = isReadOnly;
    document.querySelector('input[name="supporting_document"]').disabled = isReadOnly;
    

    // Optional: hide or disable the submit/update button if it's For Pickup
    const updateBtn = document.getElementById('updateBtn');
    if (updateBtn) {
        updateBtn.disabled = isReadOnly;
        updateBtn.style.display = isReadOnly ? 'none' : 'inline-block';
    }
}
