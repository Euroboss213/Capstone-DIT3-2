// Wait for the DOM to fully load
document.addEventListener("DOMContentLoaded", function () {
  // Line Graph: Document Requests Comparison
  const docCtx = document.getElementById("documentGraph")?.getContext("2d");
  if (docCtx) {
    // Data fetched from the hidden span elements
    const recordCounts = {
      certresidency: parseInt(document.getElementById("certresidencyCount")?.innerText || "0"),
      permit: parseInt(document.getElementById("permitCount")?.innerText || "0"),
      good_moral: parseInt(document.getElementById("goodMoralCount")?.innerText || "0"),
      indigency: parseInt(document.getElementById("indigencyCount")?.innerText || "0")
    };

    new Chart(docCtx, {
      type: "line",
      data: {
        labels: ["Cert Residency", "Permit", "Good Moral", "Indigency"],
        datasets: [{
          label: "Number of Records",
          data: Object.values(recordCounts),
          borderColor: "#3b82f6",
          backgroundColor: "rgba(59, 130, 246, 0.2)",
          borderWidth: 2,
          fill: true,
          tension: 0.3 // Smooths the line
        }]
      },
    options: {
  responsive: true,
  plugins: {
    legend: {
      position: "top",
      labels: {
        font: {
          size: 14 // Legend font size
        }
      }
    },
    title: {
      display: true,
      text: "Document Requests Data",
      font: {
        size: 20 // Title font size
      }
    }
  },
  scales: {
    x: {
      ticks: {
        font: {
          size: 14 // X-axis labels font size
        }
      },
      title: {
        display: true,
        text: "Document Types",
        font: {
          size: 16 // X-axis title font size
        }
      }
    },
    y: {
      beginAtZero: true,
      ticks: {
        stepSize: 1,
        font: {
          size: 14 // Y-axis labels font size
        }
      },
      title: {
        display: true,
        text: "Number of Requests",
        font: {
          size: 16 // Y-axis title font size
        }
      }
    }
  }
}
    });
  }
});
