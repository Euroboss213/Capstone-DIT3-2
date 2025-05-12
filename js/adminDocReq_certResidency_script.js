let originalStatus = '';

function filterTable() {
    const input = document.getElementById("searchInput");
    const filter = input.value.toLowerCase();
    const table = document.querySelector(".certresidency-table");
    const rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName("td");
        let match = false;

        for (let j = 0; j < cells.length - 1; j++) {
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
    document.getElementById('address').value = data.address;
    document.getElementById('contactNumber').value = data.contact_number ?? '';
    document.getElementById('purpose').value = data.purpose;
    document.getElementById('documentType').value = data.document_type;
    document.getElementById('dateRequested').value = data.date_requested;
    originalStatus = data.status;
    document.getElementById('status').value = data.status;
    document.getElementById('comment').value = data.comment ?? '';

    const fileName = data.supporting_document;
    const linkElement = document.getElementById('supportingDocumentLink');
    if (fileName) {
        const filePath = fileName.includes('uploads/') ? `../${fileName}` : `../uploads/${fileName}`;
        const justFileName = fileName.split('/').pop();
        linkElement.href = filePath;
        linkElement.textContent = `View Document (${justFileName})`;
    } else {
        linkElement.href = "#";
        linkElement.textContent = "No file uploaded";
    }
    
}

function closeResidencyModal() {
    document.getElementById('reviewModal').style.display = 'none';
}

document.getElementById('reviewResidencyForm').onsubmit = function (e) {
    e.preventDefault();

    const selectedStatus = document.getElementById('status').value;
    if (selectedStatus === originalStatus) {
        alert('Please change the status before saving.');
        return;
    }

    const formData = new FormData(this);

    fetch('../php/admin_updateCertResidency.php', {
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

document.getElementById('deleteBtn').onclick = function () {
    if (confirm('Are you sure you want to delete this certificate request?')) {
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
