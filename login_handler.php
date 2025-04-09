<?php
include 'config.php'; // Include session settings
session_start(); // Start the session

include 'db_connect.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate inputs
    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = 'Email and password are required.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Check if the email exists
    $stmt = $conn->prepare("SELECT id, first_name, last_name, profile_image, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Debugging: Display entered password and hashed password from DB
        echo "Debug: Entered Password: $password<br>";
        echo "Debug: Hashed Password from DB: " . $user['password'] . "<br>";

        // Check if the password is already hashed
        if (password_verify($password, $user['password'])) {
            echo "Debug: Password verification succeeded.<br>";

            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['profile_image'] = $user['profile_image'] ?? 'assets/images/user.jpg';
            $_SESSION['email'] = $email;

            unset($_SESSION['login_error']);
            header('Location: index.php'); // Redirect to the homepage
            exit;
        } else {
            // If password_verify() fails, check if the password is plain text
            // Rehash the password if it's plain text
            if ($user['password'] === $password) {
                // Rehash the plain text password
                $new_hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Update the database with the new hashed password
                $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $update_stmt->bind_param("si", $new_hashed_password, $user['id']);
                $update_stmt->execute();
                $update_stmt->close();

                echo "Debug: Password was plain text and has been rehashed.<br>";

                // Verify the rehashed password
                if (password_verify($password, $new_hashed_password)) {
                    // Set session variables
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['last_name'] = $user['last_name'];
                    $_SESSION['profile_image'] = $user['profile_image'] ?? 'assets/images/user.jpg';
                    $_SESSION['email'] = $email;

                    unset($_SESSION['login_error']);
                    header('Location: index.php'); // Redirect to the homepage
                    exit;
                }
            } else {
                echo "Debug: Password verification failed.<br>";
                echo "Debug: Entered password does not match the hashed password.<br>";
                $_SESSION['login_error'] = 'Invalid password.';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
        }
    } else {
        echo "Debug: No user found with the provided email.<br>";
        $_SESSION['login_error'] = 'Invalid email.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
?>