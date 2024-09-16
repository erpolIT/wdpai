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
        fetch(`/reservations/${id}`, {
            method: 'DELETE'
        })
            .then(response => {
                if (response.ok) {
                    window.location.reload(); 
                } else {
                    alert('Failed to delete reservation.');
                }
            })
            .catch(error => console.error('Error:', error));
    }
}
