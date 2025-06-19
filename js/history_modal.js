function openHistoryModal() {
  const requestId = document.getElementById('requestId').value;
  const documentType = document.getElementById('documentType').value;

  const modal = document.getElementById('historyModal');
  const content = document.getElementById('historyContent');

  modal.style.display = 'block';

  const xhr = new XMLHttpRequest();
  xhr.open('POST', '../php/fetch-request-history.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.onload = function () {
    if (xhr.status === 200) {
      content.innerHTML = xhr.responseText;
    } else {
      content.innerHTML = 'Failed to load history.';
    }
  };
  xhr.send(`request_id=${requestId}&document_type=${documentType}`);
}

function closeHistoryModal() {
  document.getElementById('historyModal').style.display = 'none';
}
