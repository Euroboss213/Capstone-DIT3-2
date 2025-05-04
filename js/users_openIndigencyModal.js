document.addEventListener('DOMContentLoaded', () => {
  const reviewModal = document.getElementById('reviewModal');
  const reviewForm = document.getElementById('reviewForm');
  const fileInput = document.getElementById('supportingDocument');
  const fileLabelText = document.getElementById('fileLabelText');
  const fileLinkDiv = document.getElementById('existingFileLink');
  const previewDiv = document.getElementById('newFilePreview');
  const removeFileBtn = document.getElementById('removeFileBtn');
  const closeBtn = document.querySelector('.close');

  function resetFilePreview() {
    fileInput.value = '';
    previewDiv.innerHTML = '';
    fileLinkDiv.innerHTML = '<span style="color:gray">No file uploaded.</span>';
    fileLabelText.textContent = 'Choose File';

    let removeInput = document.getElementById('removeFile');
    if (!removeInput) {
      removeInput = document.createElement('input');
      removeInput.type = 'hidden';
      removeInput.name = 'remove_file';
      removeInput.id = 'removeFile';
      reviewForm.appendChild(removeInput);
    }
    removeInput.value = '1';
  }

  function openReviewModal(data) {
    reviewModal.style.display = 'block';

    document.getElementById('requestId').value = data.id;
    document.getElementById('userId').value = data.user_id;
    document.getElementById('fullName').value = `${data.first_name} ${data.middle_name ?? ''} ${data.last_name} ${data.suffix ?? ''}`.trim();
    document.getElementById('purpose').value = data.purpose;
    document.getElementById('documentType').value = data.document_type;
    document.getElementById('dateRequested').value = data.date_requested;
    document.getElementById('status').value = data.status;
    document.getElementById('comment').value = data.comment ?? '';

    const isReadOnly = data.status === 'For Pickup' || data.status === 'Completed';
    document.getElementById('purpose').readOnly = isReadOnly;
    fileInput.disabled = isReadOnly;
    document.getElementById('documentType').readOnly = isReadOnly;
    document.getElementById('comment').readOnly = true;
    document.getElementById('saveBtn').disabled = isReadOnly;

    // Show existing file or fallback text
    if (data.supporting_document) {
      const filename = data.supporting_document.split('/').pop();
      fileLinkDiv.innerHTML = `<a href="../php/${data.supporting_document}" target="_blank">View Uploaded File (${filename})</a>`;
      fileLabelText.textContent = 'Change File';
    } else {
      resetFilePreview();
    }

    fileInput.value = ''; // Always reset input on open
  }

  // File input preview
  fileInput.addEventListener('change', function () {
    const file = this.files[0];
    previewDiv.innerHTML = '';

    if (file) {
      const fileName = file.name;
      const fileType = file.type;
      fileLabelText.textContent = 'Change File';

      const fileInfoHTML = `<p><strong>Selected File:</strong> ${fileName}</p>`;

      if (fileType.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (e) => {
          previewDiv.innerHTML = fileInfoHTML + `<img src="${e.target.result}" alt="Image Preview" style="max-width: 100%; max-height: 200px; margin-top: 5px;">`;
        };
        reader.readAsDataURL(file);
      } else if (fileType === 'application/pdf') {
        previewDiv.innerHTML = fileInfoHTML + `<p style="color:gray">(This PDF File will be uploaded.)</p>`;
      } else {
        previewDiv.innerHTML = fileInfoHTML + `<p style="color:gray">(This New File will be uploaded.)</p>`;
      }

      // If new file selected, remove `remove_file` flag
      const removeInput = document.getElementById('removeFile');
      if (removeInput) removeInput.value = '0';
    }
  });

  // Remove file
  removeFileBtn.addEventListener('click', () => {
    resetFilePreview();
  });

  // Form submission
  reviewForm.onsubmit = function (e) {
    e.preventDefault();
    const formData = new FormData(reviewForm);

    fetch('../php/update_usersIndigency_request.php', {
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

  // Close modal
  closeBtn.addEventListener('click', () => {
    reviewModal.style.display = 'none';
  });

  window.addEventListener('click', (e) => {
    if (e.target === reviewModal) {
      reviewModal.style.display = 'none';
    }
  });

  // Delete request via button
  document.getElementById('deleteBtn').onclick = function () {
    if (confirm('Are you sure you want to delete this request?')) {
      const id = document.getElementById('requestId').value;
      fetch('../php/admin_deleteIndigency.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
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

  // Row delete handler
  window.deleteFromRow = function (id) {
    if (confirm('Are you sure you want to cancel this request?')) {
      fetch('../php/admin_deleteIndigency.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
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

  // Expose the openReviewModal function to global scope
  window.openReviewModal = openReviewModal;
});