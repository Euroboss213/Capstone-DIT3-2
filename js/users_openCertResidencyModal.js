document.addEventListener('DOMContentLoaded', () => {
    const reviewModal = document.getElementById('reviewModal');
    const reviewForm = document.getElementById('reviewResidencyForm');
    const fileInput = document.getElementById('supportingDocument');
    const fileLabelText = document.getElementById('fileLabelText');
    const fileLinkDiv = document.getElementById('existingFileLink');
    const previewDiv = document.getElementById('newFilePreview');
    const removeFileBtn = document.getElementById('removeFileBtn');
    const closeBtn = document.querySelector('.close');

    // Create hidden input for file removal
    const removeInput = document.createElement('input');
    removeInput.type = 'hidden';
    removeInput.name = 'remove_file';
    removeInput.id = 'removeFile';
    reviewForm.appendChild(removeInput);

    let originalContact = ''; 
    let originalPurpose = ''; 
    let originalReply = '';

    function resetFilePreview() {
        fileInput.value = '';
        previewDiv.innerHTML = '';
        fileLinkDiv.innerHTML = '<span style="color:gray">No file uploaded.</span>';
        fileLabelText.textContent = 'Choose File';
        removeInput.value = '1';  // Indicating file is removed
    }

    function openReviewModal(data) {
        reviewModal.style.display = 'block';

        // Set form values
        const fullName = `${data.first_name} ${data.middle_name ?? ''} ${data.last_name} ${data.suffix ?? ''}`.trim();
        document.getElementById('requestId').value = data.id;
        document.getElementById('userId').value = data.user_id;
        document.getElementById('fullName').value = fullName;
        document.getElementById('address').value = data.address;
        document.getElementById('contactNumber').value = data.contact_number;
        document.getElementById('purpose').value = data.purpose;
        document.getElementById('documentType').value = data.document_type;
        document.getElementById('dateRequested').value = data.date_requested;
        document.getElementById('status').value = data.status;
        document.getElementById('comment').value = data.comment ?? ''; 
        document.getElementById('reply').value = data.reply ?? ''; 

        // Store original values
        originalContact = data.contact_number; 
        originalPurpose = data.purpose; 
        originalReply = data.reply;

        if (data.supporting_document) {
            const filename = data.supporting_document.split('/').pop();
            fileLinkDiv.innerHTML = `<a href="../${data.supporting_document}" target="_blank">View Uploaded File (${filename})</a>`;
            fileLabelText.textContent = 'Change File';
            removeInput.value = '0';  // No removal needed

            // File input is not required if an existing file is present
            fileInput.removeAttribute('required');
        } else {
            resetFilePreview();

            // Make the file input required because there is no existing file
            fileInput.setAttribute('required', 'true');
        }

        fileInput.value = '';
        previewDiv.innerHTML = '';

        const replyInput = document.getElementById('reply');
        if (data.status === 'Returned') {
            replyInput.removeAttribute('disabled'); // in case it's disabled
        }
    }

    // Handle file removal
    removeFileBtn.addEventListener('click', () => {
        resetFilePreview();
        // Make the file input required again when file is removed
        fileInput.setAttribute('required', 'true');
    });

    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        previewDiv.innerHTML = '';

        if (file) {
            const fileName = file.name;
            const fileType = file.type;
            fileLabelText.textContent = 'Change File';

            let fileInfoHTML = `<p><strong>Selected File:</strong> ${fileName}</p>`;

            if (fileType.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    fileInfoHTML += `<img src="${e.target.result}" alt="Image Preview" style="max-width: 100%; max-height: 200px; margin-top: 5px;">`;
                    previewDiv.innerHTML = fileInfoHTML;
                };
                reader.readAsDataURL(file);
            } else if (fileType === 'application/pdf') {
                fileInfoHTML += `<p style="color:gray">(PDF will be uploaded.)</p>`;
                previewDiv.innerHTML = fileInfoHTML;
            } else {
                fileInfoHTML += `<p style="color:gray">(File will be uploaded.)</p>`;
                previewDiv.innerHTML = fileInfoHTML;
            }

            removeInput.value = '0';
        }
    });

    reviewForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const currentContact = document.getElementById('contactNumber').value.trim();
        const currentPurpose = document.getElementById('purpose').value.trim();
        const fileChanged = fileInput.files.length > 0;
        const fileRemoved = removeInput.value === '1';

        const currentReply = document.getElementById('reply').value.trim();

        const hasChanges =
            fileChanged || 
            fileRemoved ||
            currentContact !== originalContact ||
            currentPurpose !== originalPurpose ||
            currentReply !== originalReply;

        if (!hasChanges) {
            alert('You must make changes before submitting.');
            return;
        }

        const formData = new FormData(reviewForm);

        fetch('../php/update_usersCertResidency_request.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            originalContact = currentContact;
            originalPurpose = currentPurpose;
            originalReply = currentReply
            
            removeInput.value = '0';

            if (fileChanged) {
                const fileName = fileInput.files[0].name;
                fileLinkDiv.innerHTML = `<span style="color:gray">File ready to upload: ${fileName}</span>`;
                fileLabelText.textContent = 'Change File';
            } else {
                fileLinkDiv.innerHTML = '<span style="color:gray">No file uploaded.</span>';
                fileLabelText.textContent = 'Choose File';
            }

            fileInput.value = '';
            previewDiv.innerHTML = '';
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    });

    closeBtn.addEventListener('click', () => {
        reviewModal.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if (e.target === reviewModal) {
            reviewModal.style.display = 'none';
        }
    });

    document.getElementById('deleteBtn').onclick = function () {
        if (confirm('Are you sure you want to delete this request?')) {
            const id = document.getElementById('requestId').value;
            fetch('../php/admin_deleteCertResidency.php', {
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

    window.deleteFromRow = function (id) {
        if (confirm('Are you sure you want to cancel this request?')) {
            fetch('../php/admin_deleteCertResidency.php', {
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
