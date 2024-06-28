<h1>Reservation List</h1>
<div class="reservations-container">
    <?php foreach ($reservations as $reservation): ?>
        <div class="reservation-card">
            <div class="reservation-header" onclick="toggleDetails(this)">
                <img src="<?php echo $reservation['image_url']; ?>" alt="Image of <?php echo htmlspecialchars($reservation['username']); ?>">
                <div class="reservation-summary">
                    <h2><?php echo htmlspecialchars($reservation['username']); ?></h2>
                    <p><?php echo htmlspecialchars($reservation['location']); ?></p>
                </div>
                <button class="delete-btn" onclick="deleteReservation(<?php echo $reservation['reservation_id']; ?>)">🗑️</button>
            </div>
            <div class="reservation-details">
                <p><strong>Reservation ID:</strong> <?php echo htmlspecialchars($reservation['reservation_id']); ?></p>
                <p><strong>Flight Number:</strong> <?php echo htmlspecialchars($reservation['flight_number']); ?></p>
                <p><strong>Reservation Date:</strong> <?php echo htmlspecialchars($reservation['reservation_date']); ?></p>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($reservation['status']); ?></p>
                <p><strong>Departure Airport:</strong> <?php echo htmlspecialchars($reservation['departure_airport']); ?></p>
                <p><strong>Arrival Airport:</strong> <?php echo htmlspecialchars($reservation['arrival_airport']); ?></p>
                <p><strong>Departure Date:</strong> <?php echo htmlspecialchars($reservation['departure_time']); ?></p>
                <p><strong>Arrival Date:</strong> <?php echo htmlspecialchars($reservation['arrival_time']); ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>