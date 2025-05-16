document.getElementById('notifButton-unread').addEventListener('click', function () {
    fetch('../php/make_unread_notif_to_read.php')
        .then(response => response.text())
        .then(data => {
            console.log(data); // For debugging
            // Optionally hide the red dot here
            document.getElementById('notifDot').style.display = 'none';
        })
        .catch(error => {
            console.error("Error updating notifications:", error);
        });
});