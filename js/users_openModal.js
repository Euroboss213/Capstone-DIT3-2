function openModal(data) {
    document.getElementById('infoModal').style.display = 'block';
    
    // Set fields with current data from the database
    document.querySelector('input[name="last_name"]').value = data.last_name || '';
    document.querySelector('input[name="first_name"]').value = data.first_name || '';
    document.querySelector('input[name="middle_name"]').value = data.middle_name || '';
    document.querySelector('input[name="suffix"]').value = data.suffix || '';
    document.querySelector('textarea[name="purpose"]').value = data.purpose || '';
    document.querySelector('input[name="comment"]').value = data.comment || '';
    
    // Set hidden ID field for the form submission
    document.querySelector('input[name="id"]').value = data.id || '';
}

function closeModal() {
    document.getElementById('infoModal').style.display = 'none';
}
