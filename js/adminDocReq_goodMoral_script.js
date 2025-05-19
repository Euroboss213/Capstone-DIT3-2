let originalStatus = '';

function filterTable() {
    const input = document.getElementById("searchInput");
    const filter = input.value.toLowerCase();
    const table = document.querySelector(".good-moral-table");
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

    originalStatus = data.status;

    document.getElementById('requestId').value = data.id;
    document.getElementById('userId').value = data.user_id;
    document.getElementById('fullName').value = `${data.first_name} ${data.middle_name ?? ''} ${data.last_name} ${data.suffix ?? ''}`.trim();
    document.getElementById('purpose').value = data.purpose;
    document.getElementById('documentType').value = data.document_type;
    document.getElementById('dateRequested').value = data.date_requested;
    document.getElementById('status').value = data.status;
    document.getElementById('comment').value = data.comment ?? '';

    const fileName = data.supporting_document?.trim();
    const linkElement = document.getElementById('supportingDocumentLink');

    if (fileName) {
        const filePath = `../uploads/${fileName}`;
        const justFileName = fileName.split('/').pop();
        linkElement.href = filePath;
        linkElement.textContent = `View Document (${justFileName})`;
    } else {
        linkElement.href = "#";
        linkElement.textContent = "No file uploaded";
    }
}

// Close modal
document.querySelector('.close').onclick = function () {
    document.getElementById('reviewModal').style.display = 'none';
};

// Save changes
document.getElementById('reviewForm').onsubmit = function (e) {
    e.preventDefault();

    const newStatus = document.getElementById('status').value;

    if (newStatus === originalStatus) {
        alert('Please change the status before saving.');
        return;
    }

    const formData = new FormData(this);

    fetch('../php/admin_updateGoodMoral.php', {
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
document.getElementById('deleteBtn').onclick = function () {
    if (confirm('Are you sure you want to delete this request?')) {
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
};

  function generateAndViewPDF(requestId, type) {
    if (!requestId || !type) {
      alert('Missing request ID or document type.');
      return;
    }
  
    // Debugging logs (optional)
    // alert('Generating PDF for:\nID: ' + requestId + '\nType: ' + type);
  
    window.location.href = 'http://localhost/capstone/Capstone-DIT3-2/forPrints/template-pdf.php?id=' + requestId + "&type=" + type;
  }

  function printCompleteList() {
    // Redirect to the correct PHP script to generate the PDF
    window.location.href = 'http://localhost/capstone/Capstone-DIT3-2/forPrints/completeReqList.php?';
  }
