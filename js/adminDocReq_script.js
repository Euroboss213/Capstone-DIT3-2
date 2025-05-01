document.addEventListener("DOMContentLoaded", function() {
  // Get all rows in the table
  const rows = document.querySelectorAll(".indigency-table tbody tr");

  rows.forEach(row => {
    // Find the status cell (assuming it's in the 4th column, index 3)
    const statusCell = row.cells[2];

    // Get the status text
    const status = statusCell.textContent.trim().toLowerCase();

    // Apply color based on status
    if (status === "returned") {
      statusCell.style.color = "red";
    } else if (status === "for pickup") {
      statusCell.style.color = "green";
    } else if (status === "ongoing") {
      statusCell.style.color = "blue";
    }
  });
});

