<?php
include 'config.php'; // Include session settings
session_start(); // Start the session

// Redirect if the user is not logged in
include 'header.php';
?>

<main class="edit-profile">
    <form class="edit-profile_info">
        <h2 class="edit-profile_title">PROFILE</h2>
        <div class="edit-profile_info--img">
            <p>Your Profile Photo <a href="#">ADD/EDIT</a></p>
            <div class="edit-profile_img">
                <img src="assets/images/user.jpg" alt="#">
            </div>
            <p>
                <a href="">delete profile image</a>
            </p>
        </div>
        <input type="text" placeholder="FIRST NAME" class="edit-profile_input">
        <input type="text" placeholder="LAST NAME" class="edit-profile_input">
        <textarea name placeholder="ABOUT ME ..." class="edit-profile_textarea"></textarea>
        <label for="gender" class="gender-select">gender
            <label>
                <input type="radio" name="gender" value="male"> Male
            </label>
            <label>
                <input type="radio" name="gender" value="female"> Female
            </label>
        </label>
        <label for="gender" class="gender-select">gender
            <label>
                <input type="radio" name="gender" value="male"> Male
            </label>
            <label>
                <input type="radio" name="gender" value="female"> Female
            </label>
        </label>
        <input type="text" placeholder="location" class="edit-profile_input">
        <button class="btn__red--l btn__red btn">SAVE CHANGES</button>
    </form>
    <form action class="edit-profile_password">
        <h2 class="edit-profile_title">SET YOUR PASSWORD</h2>
        <input type="password" placeholder="NEW PASSWORD" class="edit-profile_input">
        <input type="password" placeholder="VARIFY NEW PASSWORD" class="edit-profile_input">
        <button class="btn__red--l btn__red btn">CREATE
            PASSWORD</button>
    </form>
</main>
<?php include 'footer.php'; ?>