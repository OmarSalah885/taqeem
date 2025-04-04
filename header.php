<?php
session_start();
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
                <div class="navbar_container--menu-L"><a href="./index.php">home</a><a href="./blogs.php">blog</a><a
                        href="listing.php">categories</a><a href="./index.php#aboutUs">about us</a></div>
                <div class="navbar_container--logo"><a href="#"><img src="assets/images/logo.png" alt="logo"></a></div>
                <div class="navbar_container--menu-R"><a class="btn__red--m btn__red btn" id="search-btn" href="#"><i
                            class="fa-solid fa-magnifying-glass"></i></a><a class="navbar_container--menu-R_links"
                        id="login-nav" href="#">log in</a><a class="navbar_container--menu-R_links" id="signup-nav"
                        href="#">sign up</a><a class="btn__red--m btn__red btn" href="./add-place.php">add
                        place</a>
                </div>
            </div>
        </nav>
        <nav class="navbar_mobile">
            <div class="navbar_mobile--logo"><a href="#"><img src="assets/images/logo.png" alt="logo"></a></div>
            <div class="navbar_mobile--search"><input type="text" placeholder="search"><button><i
                        class="fa-solid fa-magnifying-glass"></i></button></div>
            <a class="navbar_mobile--menu" id="mobile_emnu-open" href="#"><i class="fa-solid fa-bars"></i></a>
        </nav>
        <div class="navbar_search--overlay" id="search-overlay">
            <a id="close-btn" href="#">X</a>
            <div class="navbar_search--overlay-content"><input type="text" placeholder="search"><button><i
                        class="fa-solid fa-magnifying-glass"></i></button></div>
        </div>
        <div class="LogOverlay">
            <div class="LogOverlay__content">
                <div class="LogOverlay__content--links">
                    <div class="LogOverlay__content--links_logins">
                        <div class="active" id="login-overlay__div"><a id="login-overlay" href="#">Log
                                in</a>
                        </div>
                        <div id="signup-overlay__div"><a id="signup-overlay" href="#">Sign
                                Up</a>
                        </div>
                    </div>
                    <a class="LogOverlay__content--links_close" href="#">X</a>
                </div>
                <div class="LogOverlay__content--login">
                    <input type="email" placeholder="EMAIL">
                    <input type="password" placeholder="PASSWORD">
                    <input type="password" placeholder="PASSWORD">
                    <p>forgot your password ? <a href="#">RESET
                            PASSWORD.</a></p>
                    <button class="btn__red--l btn__red btn">Sing
                        in</button>
                </div>
                <div class="LogOverlay__content--signup">

                    <div class="LogOverlay__content--signup_name"><input type="text" placeholder="FIRST NAME"><input
                            type="text" placeholder="LAST NAME"></div>
                    <input type="text" placeholder="EMAIL"><input type="text" placeholder="PASSWORD"><button
                        class="btn__red--l btn__red btn">Sing
                        up</button>
                </div>
            </div>
        </div>
        <div class="mobile_overlay" id="mobile_overlay">
            <div class="mobile_overlay--content">
                <a class="mobile_overlay--content-close" id="mobile_emnu-close" href="#">X</a>
                <div class="mobile_overlay--content_links"><a id="login-nav_m" href="#">log in</a><a id="signup-nav_m"
                        href="#">sign
                        up</a><a href="#">add
                        place</a><a href="./index.html">home</a><a href="./blogs.html">blog</a><a
                        href="./add-place.html">about us</a>
                </div>
            </div>
        </div>
    </nav>