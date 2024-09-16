
<div class="search-results-container">
    <h1>Search Results</h1>
    <?php if (empty($matchingFlights)): ?>
    <p>No available flight found for the selected dates from <?= $location ?> to <?= $destination ?>.</p>
    <?php else: ?>
        <div class="flight-info">
            <h2> Flight info</h2>
            <p><label>Departure Time:</label> <?php echo htmlspecialchars($matchingFlights['departure_time']); ?></p>
            <p><label>Arrival Time:</label> <?php echo htmlspecialchars($matchingFlights['arrival_time']); ?></p>
            <p><label>Location:</label> <?php echo htmlspecialchars($matchingFlights['departure_airport']); ?></p>
            <p><label>Destination:</label> <?php echo htmlspecialchars($matchingFlights['arrival_airport']); ?></p>
            <p><label>Price:</label> <?php echo htmlspecialchars($matchingFlights['price']); ?></p>
        </div>
    <?php endif ?>

    <?php if (empty($availableApartments)): ?>
        <p>No available apartments found for the selected dates in <?= $location ?>.</p>
    <?php else: ?>
        <script>
            const apartments = <?php echo json_encode($availableApartments); ?>;
        </script>
        <div id="apartmentsContainer">
        <div class="filter-container">
            <h2>Filter Apartments</h2>
            <form id="filterForm">
                <div class="filter-form-group">
                    <label for="sortOrder">Sort by Price</label>
                    <select id="sortOrder" name="sortOrder">
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>
                <button type="button" onclick="applySort()">Sort</button>
            </form>

        </div>

            <?php foreach ($availableApartments as $apartment): ?>
            <form action="/addReservation" method="post">
                <div class="apartment-container">
                    <?php if (!empty($matchingFlights)): ?>
                    <input type="hidden" name="flightId" value="<?= $matchingFlights['id'] ?>">
                    <?php endif ?>
                    <input type="hidden" name="apartmentId" value="<?= $apartment['id'] ?>">
                    <input type="hidden" name="startDate" value="<?= $_GET['pickupDate'] ?>">
                    <input type="hidden" name="endDate" value="<?= $_GET['returnDate'] ?>">
                    <h4><?= $apartment['name'] ?></h4>
                    <p><strong>Price per night: </strong><?= $apartment['price_per_night']?></p>
                    <p><?= $apartment['description'] ?></p>
                    <img src="<?= $apartment['image_path'] ?>" alt="<?= $apartment['name'] ?>">
                    <button type="submit">Confirm Reservation</button>
                </div>
            </form>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
