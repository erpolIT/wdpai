<h1>Reservation List</h1>
<div class="reservations-container">
    <?php foreach ($reservations as $reservation): ?>
        <div class="reservation-card">
            <div class="reservation-header" onclick="toggleDetails(this)">
                <img src="<?php echo $reservation['image_path']; ?>" alt="Image of <?php echo htmlspecialchars($reservation['username']); ?>">
                <div class="reservation-summary">
                    <h2><?php echo htmlspecialchars($reservation['apartment_name']); ?></h2>
                    <p><?php echo htmlspecialchars($reservation['apartment_location']); ?></p>
                </div>
                <button class="delete-btn" onclick="deleteReservation(<?php echo $reservation['reservation_id']; ?>)">🗑️</button>
            </div>
            <div class="reservation-details">
                <p><strong>Total price:</strong> <?php echo calculateStayCost($reservation['start_date'], $reservation['end_date'], $reservation['flight_price'], $reservation['apartment_price_per_night']) ?></p>
                <p><strong>Flight Number:</strong> <?php echo htmlspecialchars($reservation['flight_number']); ?></p>
                <p><strong>Reservation Date:</strong> <?php echo htmlspecialchars($reservation['reservation_date']); ?></p>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($reservation['status']); ?></p>
                <p><strong>Departure Airport:</strong> <?php echo htmlspecialchars($reservation['departure_airport_name']); ?></p>
                <p><strong>Arrival Airport:</strong> <?php echo htmlspecialchars($reservation['arrival_airport_name']); ?></p>
                <p><strong>Departure Date:</strong> <?php echo htmlspecialchars($reservation['start_date']); ?></p>
                <p><strong>Arrival Date:</strong> <?php echo htmlspecialchars($reservation['end_date']); ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<?php
function calculateStayCost($start_date, $end_date, $flight_price, $price_per_night) {
    // Zamiana daty na obiekt typu DateTime
    $start = new DateTime($start_date);
    $end = new DateTime($end_date);

    // Obliczenie liczby dni pobytu
    $interval = $start->diff($end);
    $nights = $interval->days; // Liczba dni pomiędzy datami (zakładając, że noce są pełne)

    // Obliczenie kosztu noclegów
    $total_accommodation_cost = $nights * $price_per_night;

    // Obliczenie całkowitego kosztu pobytu (lot + noclegi)
    $total_cost = $flight_price + $total_accommodation_cost;

    return $total_cost;
}