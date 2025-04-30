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
