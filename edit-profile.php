<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();
include 'header.php';

$user_id = $_SESSION['user_id'] ?? 0;

$stmt = $conn->prepare("SELECT profile_image, first_name, last_name, gender, visibility, about_me, location FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>

<main class="edit-profile">
    <form class="edit-profile_info" method="POST" enctype="multipart/form-data" action="update_profile.php">
        <h2 class="edit-profile_title">PROFILE</h2>
        
        <div class="edit-profile_info--img">
            <p>Your Profile Photo <a href="#" onclick="document.getElementById('profile_image').click(); return false;">ADD/EDIT</a></p>
            <div class="edit-profile_img">
                <img src="<?php echo htmlspecialchars($user['profile_image'] ?? 'assets/images/profiles/pro_null.png'); ?>" alt="Profile Image">
            </div>
            <input type="file" name="profile_image" id="profile_image" style="display:none;" accept="image/*">

            
            <!-- Delete profile image option -->
            <?php if (!empty($user['profile_image']) && $user['profile_image'] !== 'assets/images/profiles/pro_null.png'): ?>
                <p><a href="#" id="deleteProfileImageLink">Delete profile image</a></p>
            <?php endif; ?>
            <input type="checkbox" name="delete_image" id="delete_image_checkbox" style="display:none;">
        </div>

        <input type="text" name="first_name" placeholder="FIRST NAME" class="edit-profile_input" value="<?php echo htmlspecialchars($user['first_name']); ?>">
        <input type="text" name="last_name" placeholder="LAST NAME" class="edit-profile_input" value="<?php echo htmlspecialchars($user['last_name']); ?>">
        <textarea name="about_me" placeholder="ABOUT ME ..." class="edit-profile_textarea"><?php echo htmlspecialchars($user['about_me']); ?></textarea>

        <!-- Gender -->
<label class="gender-select">Gender
    <label>
    <input type="radio" name="gender" value="male" <?php if (strtolower(trim($user['gender'])) === 'male') echo 'checked'; ?> required> Male
    </label>
    <label>
    <input type="radio" name="gender" value="female" <?php if (strtolower(trim($user['gender'])) === 'female') echo 'checked'; ?>> Female
    </label>
</label>

<!-- Visibility -->
<label class="gender-select">Public
    <label>
        <input type="radio" name="visibility" value="public" <?php if ($user['visibility'] === 'public') echo 'checked'; ?> required> Public
    </label>
    <label>
        <input type="radio" name="visibility" value="private" <?php if ($user['visibility'] === 'private') echo 'checked'; ?>> Private
    </label>
</label>


        <input type="text" name="location" placeholder="Location" class="edit-profile_input" value="<?php echo htmlspecialchars($user['location']); ?>">
        <button class="btn__red--l btn__red btn" type="submit">SAVE CHANGES</button>
    </form>

    <form action="change_password.php" method="POST" class="edit-profile_password">
    <?php if (isset($_SESSION['error'])): ?>
    <div class="error-message"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="success-message"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

        <h2 class="edit-profile_title">UPDATE YOUR PASSWORD</h2>
        <input type="password" name="current_password" placeholder="CURRENT PASSWORD" class="edit-profile_input" required>
        <input type="password" name="new_password" placeholder="NEW PASSWORD" class="edit-profile_input" required>
        <input type="password" name="confirm_password" placeholder="VERIFY NEW PASSWORD" class="edit-profile_input" required>
        <button class="btn__red--l btn__red btn" type="submit">CHANGES PASSWORD</button>
    </form>
</main>

<?php include 'footer.php'; ?>


<script>
    // Trigger form submission when a file is selected
    document.getElementById('profile_image').addEventListener('change', function() {
        document.querySelector('.edit-profile_info').submit();
    });

    // Handle profile image deletion
    document.getElementById('deleteProfileImageLink')?.addEventListener('click', function(event) {
        event.preventDefault();
        if (confirm("Are you sure you want to delete your profile image?")) {
            document.getElementById('delete_image_checkbox').checked = true;
            document.querySelector('.edit-profile_info').submit();
        }
    });

    document.querySelector('.edit-profile_info').addEventListener('submit', function(e) {
        const genderChecked = document.querySelector('input[name="gender"]:checked');
        const visibilityChecked = document.querySelector('input[name="visibility"]:checked');

        if (!genderChecked || !visibilityChecked) {
            e.preventDefault();
            alert('Please select your gender and visibility preference.');
        }
    });
</script>
