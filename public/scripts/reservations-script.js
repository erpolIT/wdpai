function toggleDetails(element) {
    const details = element.nextElementSibling;
    if (details.style.display === "block") {
        details.style.display = "none";
    } else {
        details.style.display = "block";
    }
}

function deleteReservation(id) {
    if (confirm('Are you sure you want to delete this reservation?')) {
        // Send request to delete reservation (implement this in your backend)
        fetch(`delete_reservation.php?id=${id}`, {
            method: 'GET'
        })
            .then(response => {
                if (response.ok) {
                    window.location.reload(); // Reload the page to see changes
                } else {
                    alert('Failed to delete reservation.');
                }
            })
            .catch(error => console.error('Error:', error));
    }
}
