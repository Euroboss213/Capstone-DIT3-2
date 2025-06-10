    document.addEventListener('DOMContentLoaded', function () {
    const openCsvModalBtn = document.getElementById('openCsvModalBtn');
    const uploadCsvModal = document.getElementById('uploadCsvModal');
    const closeBtn = uploadCsvModal.querySelector('.close'); // Select the close button inside the modal

    openCsvModalBtn.addEventListener('click', function () {
        uploadCsvModal.style.display = 'block';
    });

    closeBtn.addEventListener('click', function () {
        uploadCsvModal.style.display = 'none';
    });

    // Close the modal when clicking outside the modal-content
    window.addEventListener('click', function (event) {
        if (event.target === uploadCsvModal) {
            uploadCsvModal.style.display = 'none';
        }
    });
});

function closeUploadCsvModal() {
    document.getElementById('uploadCsvModal').style.display = 'none';
}
