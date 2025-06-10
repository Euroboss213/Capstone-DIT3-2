function filterTable() {
    const input = document.getElementById("searchInput");
    const filter = input.value.toLowerCase();
    const table = document.querySelector(".user-table");
    const rows = table.getElementsByTagName("tr");
  
    for (let i = 1; i < rows.length; i++) { // start at 1 to skip the header
      const cells = rows[i].getElementsByTagName("td");
      let match = false;
  
      for (let j = 0; j < cells.length - 1; j++) { // don't include the action button
        const cell = cells[j];
        if (cell && cell.textContent.toLowerCase().includes(filter)) {
          match = true;
          break;
        }
      }
  
      rows[i].style.display = match ? "" : "none";
    }
  }

  document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll(".delete-btn");
  
    deleteButtons.forEach(button => {
      button.addEventListener("click", function () {
        const row = this.closest("tr");
        const fullName = row.children[0].textContent;
        const username = row.children[1].textContent;
  
        if (confirm(`Are you sure you want to delete the account of ${fullName}?`)) {
          fetch('../php/delete_user.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `username=${encodeURIComponent(username)}`
          })
          .then(response => response.text())
          .then(result => {
            if (result.trim() === "success") {
              row.remove(); // Remove the table row
              alert(`Account of ${fullName} has been deleted.`);
            } else {
              alert("Failed to delete account.");
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert("An error occurred.");
          });
        }
      });
    });
  });


  document.querySelectorAll('.acc-toggle').forEach(toggle => {
  toggle.addEventListener('change', function() {
    const userId = this.dataset.userId;
    const newStatus = this.checked ? 'active' : 'inactive';

    fetch('../php/update_acc_status.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `user_id=${userId}&acc_status=${newStatus}`
    })
    .then(response => response.text())
    .then(data => {
      console.log(data); // Optional: show message
    })
    .catch(error => console.error('Error:', error));
  });
});
  