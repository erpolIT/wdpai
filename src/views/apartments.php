<h1>Apartments</h1>
<div class="search-results-container">
    <?php foreach ($apartments as $apartment): ?>
        <div class="apartment-container">
            <?php if ($apartment['image_path']): ?>
                <img src="<?php echo htmlspecialchars($apartment['image_path']); ?>" alt="<?php echo htmlspecialchars($apartment['name']); ?>" class="apartment-image">
            <?php endif; ?>
            <h2><?php echo htmlspecialchars($apartment['name']); ?></h2>
            <p><?php echo htmlspecialchars($apartment['location']); ?></p>
            <p><?php echo htmlspecialchars($apartment['description']); ?></p>
            <p><strong>Price per night:</strong> $<?php echo htmlspecialchars($apartment['price_per_night']); ?></p>
        </div>
    <?php endforeach; ?>

    <button onclick="toggleForm()" class="toggle-form-btn">Add New Apartment</button>

    <div id="apartment-form-container" >
        <h2>Add New Apartment</h2>
        <form id="apartmentForm" action="apartments/create" enctype="multipart/form-data">
            <div class="apartment-form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location">
            </div>
            <div class="apartment-form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name">
            </div>
            <div class="apartment-form-group">
                <label for="pricePerNight">Price per night</label>
                <input type="number" step="0.01" id="pricePerNight" name="pricePerNight">
            </div>
            <div class="apartment-form-group">
                <label for="description">Description</label>
                <textarea id="description"  name="description"></textarea>
            </div>
            <div class="apartment-form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <button class="apartment-form-group" type="submit">Add Apartment</button>
        </form>
    </div>
</div>



