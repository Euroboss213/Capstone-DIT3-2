document.addEventListener("DOMContentLoaded", () => {
    const statusCells = document.querySelectorAll("td.status");
  
    statusCells.forEach(cell => {
      const status = cell.textContent.trim();
  
      switch (status) {
        case "Ongoing":
          cell.classList.add("status-ongoing");
          break;
        case "For Pickup":
          cell.classList.add("status-pickup");
          break;
        case "Returned":
          cell.classList.add("status-returned");
          break;
        case "Completed":
          cell.classList.add("status-completed");
          break;
      }
    });
  });

  function filterByStatus() {
    const filter = document.getElementById("statusFilter").value.toLowerCase();
    const table = document.querySelector(".indigency-table");
    const rows = table.querySelectorAll("tbody tr");
  
    rows.forEach(row => {
      const statusCell = row.querySelector(".status"); 
      const status = statusCell ? statusCell.textContent.toLowerCase() : "";
  
      if (filter === "" || status.includes(filter)) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  }