<?php
require_once 'config.php';
require_once 'db_connect.php';


// Determine which user to edit
$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : ($_SESSION['user_id'] ?? 0);

// Security check: only admins can edit others
if ($user_id !== ($_SESSION['user_id'] ?? 0)) {
    if (empty($_SESSION['role']) || strtolower($_SESSION['role']) !== 'admin') {
        die('Access denied.');
    }
}

// Handle form submission for profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['first_name'])) {
    // Collect POST data safely
    $first_name = $_POST['first_name'] ?? '';
    $last_name  = $_POST['last_name'] ?? '';
    $about_me   = $_POST['about_me'] ?? '';
    $gender     = $_POST['gender'] ?? '';
    $visibility = $_POST['visibility'] ?? '';
    $location   = $_POST['location'] ?? '';
    $delete_image = isset($_POST['delete_image']);

    // Get current profile image to handle deletion/upload
    $stmt = $conn->prepare("SELECT profile_image FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user_data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $profile_image_path = $user_data['profile_image'] ?? 'assets/images/profiles/pro_null.png';

    // Handle image deletion
    if ($delete_image && $profile_image_path !== 'assets/images/profiles/pro_null.png') {
        if (file_exists($profile_image_path)) unlink($profile_image_path);
        $profile_image_path = 'assets/images/profiles/pro_null.png';
    }

    // Handle image upload
    if (!empty($_FILES['profile_image']['tmp_name'])) {
        $target_dir = 'assets/images/profiles/';
        $ext        = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $new_name   = uniqid() . '.' . $ext;
        $target_file= $target_dir . $new_name;
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
            // Delete old image if not default
            if ($profile_image_path !== 'assets/images/profiles/pro_null.png' && file_exists($profile_image_path)) {
                unlink($profile_image_path);
            }
            $profile_image_path = $target_file;
        }
    }

    // Prepare update query
    $stmt = $conn->prepare(
        "UPDATE users SET first_name=?, last_name=?, about_me=?, gender=?, visibility=?, location=?, profile_image=? WHERE id=?"
    );
    $stmt->bind_param(
        "sssssssi",
        $first_name,
        $last_name,
        $about_me,
        $gender,
        $visibility,
        $location,
        $profile_image_path,
        $user_id
    );
    $stmt->execute();
    $stmt->close();

    // Update session if user edits their own profile
    if ($user_id === ($_SESSION['user_id'] ?? 0)) {
        $_SESSION['first_name']    = $first_name;
        $_SESSION['last_name']     = $last_name;
        $_SESSION['profile_image'] = $profile_image_path;
    }

    // Redirect to avoid resubmission
    header("Location: edit-profile.php?user_id=$user_id");
    exit;
}

// Fetch user data for the form
$stmt = $conn->prepare(
    "SELECT profile_image, first_name, last_name, gender, visibility, about_me, location FROM users WHERE id = ?"
);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

include 'header.php';
?>

<main class="edit-profile">
    <form class="edit-profile_info" method="POST" enctype="multipart/form-data" action="">
        <h2 class="edit-profile_title">PROFILE</h2>

        <div class="edit-profile_info--img">
            <p>Your Profile Photo <a href="#" onclick="document.getElementById('profile_image').click(); return false;">ADD/EDIT</a></p>
            <div class="edit-profile_img">
                <img src="<?php echo htmlspecialchars($user['profile_image'] ?? 'assets/images/profiles/pro_null.png'); ?>" alt="Profile Image">
            </div>
            <input type="file" name="profile_image" id="profile_image" style="display:none;" accept="image/*">

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
            <label><input type="radio" name="gender" value="male" <?php if (strtolower(trim($user['gender'])) === 'male') echo 'checked'; ?> required> Male</label>
            <label><input type="radio" name="gender" value="female" <?php if (strtolower(trim($user['gender'])) === 'female') echo 'checked'; ?>> Female</label>
        </label>

        <!-- Visibility -->
        <label class="gender-select">Public
            <label><input type="radio" name="visibility" value="public" <?php if ($user['visibility'] === 'public') echo 'checked'; ?> required> Public</label>
            <label><input type="radio" name="visibility" value="private" <?php if ($user['visibility'] === 'private') echo 'checked'; ?>> Private</label>
        </label>

        <input type="text" name="location" placeholder="Location" class="edit-profile_input" value="<?php echo htmlspecialchars($user['location']); ?>">
        <button class="btn__red--l btn__red btn" type="submit">SAVE CHANGES</button>
    </form>

    <form action="change_password.php" method="POST" class="edit-profile_password">
        <?php
        $change_password_errors = $_SESSION['change_password_errors'] ?? [];
        $change_password_data = $_SESSION['change_password_data'] ?? [];
        ?>

        <h2 class="edit-profile_title">UPDATE YOUR PASSWORD</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <p class="success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></p>
        <?php endif; ?>

        <div class="form-group">
            <input type="password" name="current_password" placeholder="CURRENT PASSWORD" class="edit-profile_input" required>
            <?php if (isset($change_password_errors['current_password'])): ?>
                <p class="error"><?php echo htmlspecialchars($change_password_errors['current_password']); ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <input type="password" name="new_password" placeholder="NEW PASSWORD" class="edit-profile_input" required>
            <?php if (isset($change_password_errors['new_password'])): ?>
                <p class="error"><?php echo htmlspecialchars($change_password_errors['new_password']); ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <input type="password" name="confirm_password" placeholder="VERIFY NEW PASSWORD" class="edit-profile_input" required>
            <?php if (isset($change_password_errors['confirm_password'])): ?>
                <p class="error"><?php echo htmlspecialchars($change_password_errors['confirm_password']); ?></p>
            <?php endif; ?>
        </div>

        <?php if (isset($change_password_errors['general'])): ?>
            <p class="error"><?php echo htmlspecialchars($change_password_errors['general']); ?></p>
        <?php endif; ?>

        <button class="btn__red--l btn__red btn" type="submit">CHANGE PASSWORD</button>
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

    // Validate radio selections for profile form
    document.querySelector('.edit-profile_info').addEventListener('submit', function(e) {
        const genderChecked = document.querySelector('input[name="gender"]:checked');
        const visibilityChecked = document.querySelector('input[name="visibility"]:checked');
        if (!genderChecked || !visibilityChecked) {
            e.preventDefault();
            alert('Please select your gender and visibility preference.');
        }
    });

    // Scroll to password form on error
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof hasChangePasswordErrors !== 'undefined' && hasChangePasswordErrors) {
            const passwordForm = document.querySelector('.edit-profile_password');
            if (passwordForm) {
                passwordForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    });
</script>