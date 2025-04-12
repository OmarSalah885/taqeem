<?php
// Regenerate session ID to prevent fixation attacks
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} elseif (time() - $_SESSION['CREATED'] > 1800) { // Regenerate every 30 minutes
    session_regenerate_id(true); // Regenerate session ID and delete the old one
    $_SESSION['CREATED'] = time();
}

// Implement session timeout
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // Last activity was more than 30 minutes ago
    session_unset(); // Unset session variables
    session_destroy(); // Destroy the session
    header('Location: login.php?timeout=true'); // Redirect to login page
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time(); // Update last activity time

include 'db_connect.php';


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/main.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Tera:wght@100..900&display=swap" rel="stylesheet">
    <!-- Font Awesome Free CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <title>Taqeem</title>
</head>

<body>

    <nav>
        <nav class="navbar">
            <div class="navbar_container">
                <div class="navbar_container--menu-L">
                    <a href="./index.php">home</a>

                    <a href="blogs.php">blog</a>
                    <a href="listing.php">categories</a>
                    <a href="./index.php#aboutUs">about us</a>
                </div>
                <div class="navbar_container--logo">
                    <a href="index.php"><img src="assets/images/logo.png" alt="logo"></a>
                </div>
                <div class="navbar_container--menu-R">
    <a class="btn__red--m btn__red btn" id="search-btn" href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
    <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Show profile link when the user is logged in -->
        <a href="profile.php?user_id=<?php echo htmlspecialchars($_SESSION['user_id']); ?>" class="navbar_profile">
            <img src="<?php echo htmlspecialchars($_SESSION['profile_image']); ?>" alt="User Profile">
            <span><?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?></span>
        </a>
        <a class="navbar_container--menu-R_links" href="logout.php">Log Out</a>
    <?php else: ?>
        <!-- Show login and signup links when the user is not logged in -->
        <a class="navbar_container--menu-R_links" id="login-nav" href="#">Log In</a>
        <a class="navbar_container--menu-R_links" id="signup-nav" href="#">Sign Up</a>
    <?php endif; ?>
    <a class="btn__red--m btn__red btn" href="add-place.php">Add Place</a>
</div>

            </div>
        </nav>

        <nav class="navbar_mobile">
            <div class="navbar_mobile--logo">
                <a href="index.php"><img src="assets/images/logo.png" alt="logo"></a>
            </div>
            <div class="navbar_mobile--search">
                <input type="text" placeholder="search">
                <button><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <a class="navbar_mobile--menu" id="mobile_emnu-open" href="#"><i class="fa-solid fa-bars"></i></a>
        </nav>

        <div class="navbar_search--overlay" id="search-overlay">
            <a id="close-btn" href="#">X</a>
            <div class="navbar_search--overlay-content"><input type="text" placeholder="search"><button><i class="fa-solid fa-magnifying-glass"></i></button></div>
        </div>

        <div class="LogOverlay">
            <div class="LogOverlay__content">
                <div class="LogOverlay__content--links">
                    <div class="LogOverlay__content--links_logins">
                        <div class="active" id="login-overlay__div"><a id="login-overlay" href="#">Log in</a></div>
                        <div id="signup-overlay__div"><a id="signup-overlay" href="#">Sign Up</a></div>
                    </div>
                    <a class="LogOverlay__content--links_close" href="#">X</a>
                </div>

                <!-- Login Form -->
                <form class="LogOverlay__content--login" action="login_handler.php" method="POST">
                    <?php
                    $login_errors = $_SESSION['login_errors'] ?? [];
                    $login_data = $_SESSION['login_data'] ?? [];
                    unset($_SESSION['login_errors'], $_SESSION['login_data']);
                    ?>
                    <input type="hidden" name="redirect_url" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                    <input type="email" name="email" placeholder="EMAIL" value="<?php echo htmlspecialchars($login_data['email'] ?? ''); ?>" required>
                    <?php if (isset($login_errors['email'])): ?>
                        <p class="error"><?php echo $login_errors['email']; ?></p>
                    <?php endif; ?>

                    <input type="password" name="password" placeholder="PASSWORD" required>
                    <?php if (isset($login_errors['password'])): ?>
                        <p class="error"><?php echo $login_errors['password']; ?></p>
                    <?php endif; ?>

                    <p>Forgot your password? <a href="#">RESET PASSWORD.</a></p>
                    <button type="submit" class="btn__red--l btn__red btn">Sign In</button>
                </form>

                <!-- Signup Form -->
                <form action="signup_handler.php" method="POST" class="LogOverlay__content--signup">
                    <?php
                    $signup_errors = $_SESSION['signup_errors'] ?? [];
                    $signup_data = $_SESSION['signup_data'] ?? [];
                    unset($_SESSION['signup_errors'], $_SESSION['signup_data']);
                    ?>
                    <div class="LogOverlay__content--signup_name">
                        <input type="text" name="first_name" placeholder="FIRST NAME" value="<?php echo htmlspecialchars($signup_data['first_name'] ?? ''); ?>" required>
                        <?php if (isset($signup_errors['first_name'])): ?>
                            <p class="error"><?php echo $signup_errors['first_name']; ?></p>
                        <?php endif; ?>

                        <input type="text" name="last_name" placeholder="LAST NAME" value="<?php echo htmlspecialchars($signup_data['last_name'] ?? ''); ?>" required>
                        <?php if (isset($signup_errors['last_name'])): ?>
                            <p class="error"><?php echo $signup_errors['last_name']; ?></p>
                        <?php endif; ?>
                    </div>
                    <input type="email" name="email" placeholder="EMAIL" value="<?php echo htmlspecialchars($signup_data['email'] ?? ''); ?>" required>
                    <?php if (isset($signup_errors['email'])): ?>
                        <p class="error"><?php echo $signup_errors['email']; ?></p>
                    <?php endif; ?>

                    <input type="password" name="password" placeholder="PASSWORD" required>
                    <?php if (isset($signup_errors['password'])): ?>
                        <p class="error"><?php echo $signup_errors['password']; ?></p>
                    <?php endif; ?>

                    <input type="password" name="confirm_password" placeholder="CONFIRM PASSWORD" required>
                    <?php if (isset($signup_errors['confirm_password'])): ?>
                        <p class="error"><?php echo $signup_errors['confirm_password']; ?></p>
                    <?php endif; ?>

                    <button type="submit" class="btn__red--l btn__red btn">Sign up</button>
                    <?php if (isset($signup_errors['general'])): ?>
                        <p class="error"><?php echo $signup_errors['general']; ?></p>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="mobile_overlay" id="mobile_overlay">
            <div class="mobile_overlay--content">
                <a class="mobile_overlay--content-close" id="mobile_emnu-close" href="#">X</a>
                <div class="mobile_overlay--content_links">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Display user profile when logged in -->
                        <div class="mobile_user_profile">
                            <img src="<?php echo htmlspecialchars($_SESSION['profile_image'] ?? 'assets/images/profiles/pro_null.png'); ?>" alt="User Profile">
                            <span><?php echo htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']); ?></span>
                        </div>
                        <a href="logout.php">Log Out</a>
                        <a href="profile.php">Profile</a>
                    <?php else: ?>
                        <!-- Display login and signup links when not logged in -->
                        <a id="login-nav_m" href="#">log in</a>
                        <a id="signup-nav_m" href="#">sign up</a>
                    <?php endif; ?>
                    <a href="add-place.php">add place</a>
                    <a href="index.php">home</a>
                    <a href="blogs.php">blog</a>
                    <a href="listing.php">categories</a>
                    <a href="index.php#aboutUs">about us</a>
                </div>
            </div>
        </div>
    </nav>
</body>
</html>


