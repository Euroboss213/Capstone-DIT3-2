document.addEventListener('DOMContentLoaded', () => {
  const reviewModal = document.getElementById('reviewModal');
  const reviewForm = document.getElementById('reviewForm');
  const fileInput = document.getElementById('supportingDocument');
  const fileLabelText = document.getElementById('fileLabelText');
  const fileLinkDiv = document.getElementById('existingFileLink');
  const previewDiv = document.getElementById('newFilePreview');
  const removeFileBtn = document.getElementById('removeFileBtn');
  const closeBtn = document.querySelector('.close');

  let originalPurpose = '';
  let originalReply = ''; // ✅ Added
  let originalFileChanged = false;
  let fileRemoved = false;

  function resetFilePreview() {
    fileInput.value = '';
    previewDiv.innerHTML = '';
    fileLinkDiv.innerHTML = '<span style="color:gray">No file uploaded.</span>';
    fileLabelText.textContent = 'Choose File';

    const removeInput = document.getElementById('removeFile');
    if (removeInput) removeInput.value = '1';
  }

  function openReviewModal(data) {
    reviewModal.style.display = 'block';

    document.getElementById('requestId').value = data.id;
    document.getElementById('userId').value = data.user_id;
    document.getElementById('fullName').value = `${data.first_name} ${data.middle_name ?? ''} ${data.last_name}${data.suffix ? ', ' + data.suffix : ''}`.trim();
    document.getElementById('documentType').value = data.document_type ?? '';
    document.getElementById('purpose').value = data.purpose ?? '';
    document.getElementById('dateRequested').value = data.date_requested ?? '';
    document.getElementById('status').value = data.status ?? '';
    document.getElementById('comment').value = data.comment ?? '';
    document.getElementById('reply').value = data.reply ?? ''; 

    // Track original values
    originalPurpose = data.purpose ?? '';
    originalFileChanged = false;
    fileRemoved = false;
    originalReply = data.reply ?? '';

    if (data.supporting_document) {
      const filename = data.supporting_document.split('/').pop();
      fileLinkDiv.innerHTML = `<a href="../php/${data.supporting_document}" target="_blank">View Uploaded File (${filename})</a>`;
      fileLabelText.textContent = 'Change File';
    } else {
      resetFilePreview();
    }

    fileInput.value = '';
    previewDiv.innerHTML = '';

    const replyInput = document.getElementById('reply');
    if (data.status === 'Returned') {
        replyInput.removeAttribute('disabled'); // in case it's disabled
    }
  }

  fileInput.addEventListener('change', function () {
    originalFileChanged = true;
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

      const removeInput = document.getElementById('removeFile');
      if (removeInput) removeInput.value = '0';
    }
  });

  removeFileBtn?.addEventListener('click', () => {
    fileRemoved = true;
    resetFilePreview();
  });

  reviewForm.onsubmit = function (e) {
    e.preventDefault();

    const currentPurpose = document.getElementById('purpose').value.trim();
    const currentReply = document.getElementById('reply').value.trim();

    const hasChanges =
      originalFileChanged ||
      fileRemoved ||
      currentPurpose !== originalPurpose ||
      currentReply !== originalReply;


    if (!hasChanges) {
      alert("You won't be able to submit if there are no changes.");
      return;
    }

    const formData = new FormData(reviewForm);

    fetch('../php/update_usersGoodMoral_request.php', {
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

  closeBtn.addEventListener('click', () => {
    reviewModal.style.display = 'none';
  });

  window.addEventListener('click', (e) => {
    if (e.target === reviewModal) {
      reviewModal.style.display = 'none';
    }
  });

  document.getElementById('deleteBtn')?.addEventListener('click', () => {
    if (confirm('Are you sure you want to cancel this request?')) {
      const id = document.getElementById('requestId').value;
      fetch('../php/admin_deleteGoodMoral.php', {
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
  });

  window.deleteFromRow = function (id) {
    if (confirm('Are you sure you want to cancel this request?')) {
      fetch('../php/admin_deleteGoodMoral.php', {
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

  window.openReviewModal = openReviewModal;
});
