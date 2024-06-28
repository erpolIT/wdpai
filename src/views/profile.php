<div id="profile-container">
    <h2>Edit Profile</h2>
<form id="editProfileForm">
    <div class="profile-form-group">
        <label for="firstName">First Name</label>
        <input type="text" id="firstName" name="firstName" value="<?= htmlspecialchars($userDetails['first_name']) ?>">
    </div>
    <div class="profile-form-group">
        <label for="lastName">Last Name</label>
        <input type="text" id="lastName" name="lastName" value="<?= htmlspecialchars($userDetails['last_name']) ?>">
    </div>
    <div class="profile-form-group">
        <label for="birthdate">Birthdate</label>
        <input type="text" id="birthdate" name="birthdate"  value="<?= htmlspecialchars($userDetails['birthdate']) ?>">
    </div>
    <div class="profile-form-group">
        <label for="address">Address</label>
        <input type="text" id="address" name="address" value="<?= htmlspecialchars($userDetails['address']) ?>">
    </div>
    <button type="submit" class="small-button">Save Changes</button>
</form>
</div>

<script src="../../public/scripts/profile.js" defer></script>
<link rel="stylesheet" type="text/css" href="../../../public/css/profile.css">
