<section class="hero">
    <h1>Plan a trip with one click <br><span>Easily</span></h1>
</section>
<form action="/searchApartment" method="get">
    <section class="search-bar">
            <div class="search-field">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" placeholder="Choose your location">
            </div>
            <div class="search-field">
                <label for="destination">Destination</label>
                <input type="text" id="destination" name="destination" placeholder="Choose your destination">
            </div>
            <div class="search-field">
                <label for="pickupDate">Pickup date</label>
                <input type="date" id="pickupDate" name="pickupDate" placeholder="Tue 15 Feb, 09:00">
            </div>
            <div class="search-field">
                <label for="returnDate">Return date</label>
                <input type="date" id="returnDate" name="returnDate" placeholder="Thu 16 Feb, 11:00">
            </div>
            <button class="search-btn">Search</button>
    </section>
</form>
