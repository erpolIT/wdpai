function toggleForm() {
    const formContainer = document.getElementById('apartment-form-container');
    formContainer.style.display = formContainer.style.display === 'none' ? 'block' : 'none';
}

function displayApartments(apartments) {
    console.log(apartments);  // Dodaj to do debugowania danych
    const container = document.getElementById('apartmentsContainer');
    container.innerHTML = '';

    apartments.forEach(apartment => {
        const apartmentDiv = document.createElement('div');
        apartmentDiv.classList.add('apartment-container');
        const pricePerNight = parseFloat(apartment.price_per_night);
        const formattedPrice = isNaN(pricePerNight) ? 'N/A' : `$${pricePerNight.toFixed(2)}`;

        apartmentDiv.innerHTML = `
            <form action="/addReservation" method="get">
                <input type="hidden" name="apartmentId" value="${apartment.id}">
                <input type="hidden" name="startDate" value="${getQueryParam('pickupDate')}">
                <input type="hidden" name="endDate" value="${getQueryParam('returnDate')}">
                <h4>${apartment.name}</h4>
                <p><strong>Location:</strong> ${apartment.location}</p>
                <p><strong>Price per night:</strong> ${formattedPrice}</p>
                <p>${apartment.description}</p>
                <img src="${apartment.image_path}" alt="${apartment.name}" style="width: 100px; height: 100px;">
                <button type="submit">Confirm Reservation</button>
            </form>
        `;
        container.appendChild(apartmentDiv);
    });
}

function applySort() {
    const sortOrder = document.getElementById('sortOrder').value;

    let sortedApartments = [...apartments];

    if (sortOrder) {
        sortedApartments.sort((a, b) => {
            if (sortOrder === 'asc') {
                return a.price_per_night - b.price_per_night;
            } else if (sortOrder === 'desc') {
                return b.price_per_night - a.price_per_night;
            }
        });
    }

    displayApartments(sortedApartments);
}

function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param) || '';
}

