<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/main.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com" rel="preconnect">
        <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Lexend+Tera:wght@100..900&display=swap"
            rel="stylesheet">
        <!-- Font Awesome Free CDN -->
        <link
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
            rel="stylesheet">
        <title>Taqeem</title>
    </head>
    <body>
        <nav>
            <nav class="navbar">
                <div class="navbar_container">
                    <div class="navbar_container--menu-L"><a
                            href="./index.html">home</a><a
                            href="./blogs.html">blog</a><a
                            href="#">categories</a><a
                            href="#">about us</a></div>
                    <div class="navbar_container--logo"><a href="#"><img
                                src="assets/images/logo.png"
                                alt="logo"></a></div>
                    <div class="navbar_container--menu-R"><a
                            class="btn__red--m btn__red btn" id="search-btn"
                            href="#"><i
                                class="fa-solid fa-magnifying-glass"></i></a><a
                            class="navbar_container--menu-R_links"
                            id="login-nav"
                            href="#">log in</a><a
                            class="navbar_container--menu-R_links"
                            id="signup-nav"
                            href="#">sign up</a><a
                            class="btn__red--m btn__red btn"
                            href="./add-place.html">add
                            place</a>
                    </div>
                </div>
            </nav>
            <nav class="navbar_mobile">
                <div class="navbar_mobile--logo"><a href="#"><img
                            src="assets/images/logo.png" alt="logo"></a></div>
                <div class="navbar_mobile--search"><input type="text"
                        placeholder="search"><button><i
                            class="fa-solid fa-magnifying-glass"></i></button></div>
                <a class="navbar_mobile--menu" id="mobile_emnu-open" href="#"><i
                        class="fa-solid fa-bars"></i></a>
            </nav>
            <div class="navbar_search--overlay" id="search-overlay">
                <a id="close-btn" href="#">X</a>
                <div class="navbar_search--overlay-content"><input type="text"
                        placeholder="search"><button><i
                            class="fa-solid fa-magnifying-glass"></i></button></div>
            </div>
            <div class="LogOverlay">
                <div class="LogOverlay__content">
                    <div class="LogOverlay__content--links">
                        <div class="LogOverlay__content--links_logins">
                            <div class="active" id="login-overlay__div"><a
                                    id="login-overlay" href="#">Log
                                    in</a>
                            </div>
                            <div id="signup-overlay__div"><a id="signup-overlay"
                                    href="#">Sign
                                    Up</a>
                            </div>
                        </div>
                        <a class="LogOverlay__content--links_close"
                            href="#">X</a>
                    </div>
                    <div class="LogOverlay__content--login">
                        <input type="email" placeholder="EMAIL"><input
                            type="password"
                            placeholder="PASSWORD">
                        <p>forgot your password ? <a href="#">RESET
                                PASSWORD.</a></p>
                        <button class="btn__red--l btn__red btn">Sing
                            in</button>
                    </div>
                    <div class="LogOverlay__content--signup">
                        <div class="LogOverlay__content--signup_role"><a
                                class="btn__red--l btn__red btn"
                                href="#">Guest</a><a
                                class="btn__transparent--l btn__transparent btn"
                                href="#">Owner</a></div>
                        <div class="LogOverlay__content--signup_name"><input
                                type="text" placeholder="FIRST NAME"><input
                                type="text"
                                placeholder="LAST NAME"></div>
                        <input type="text" placeholder="EMAIL"><input
                            type="text"
                            placeholder="PASSWORD"><button
                            class="btn__red--l btn__red btn">Sing
                            up</button>
                    </div>
                </div>
            </div>
            <div class="mobile_overlay" id="mobile_overlay">
                <div class="mobile_overlay--content">
                    <a class="mobile_overlay--content-close"
                        id="mobile_emnu-close"
                        href="#">X</a>
                    <div class="mobile_overlay--content_links"><a
                            id="login-nav_m"
                            href="#">log in</a><a id="signup-nav_m"
                            href="#">sign
                            up</a><a href="#">add
                            place</a><a href="./index.html">home</a><a
                            href="./blogs.html">blog</a><a
                            href="./add-place.html">about us</a>
                    </div>
                </div>
            </div>
        </nav>
        <main class="profile">
            <div class="profile_sidebar">
                <div class="profile_sidebar--img">
                    <img src="assets/images/user.jpg" alt="#">
                </div>
                <div class="profile_sidebar--info">
                    <h3 class="name">Abd Ulrhman alshafee</h3>
                    <a href="mailto:myemail@email.com">myemail@email.com</a>
                    <h2 class="location">AMMAN , JORDAN</h2>
                </div>
                <div class="profile_sidebar--edit">
                    <a class="profile_sidebar--edit-btn" href="#"><i
                            class="fa-solid fa-pen"></i>Edit profile</a>
                    <a class="profile_sidebar--edit-btn" href="#"><i
                            class="fa-solid fa-user"></i>Add photo</a>
                </div>
                <a href="#"
                    class="btn__transparent--l btn__transparent btn">LOGOUT</a>
            </div>
            <div class="profile_main">
                <div class="profile_main_myReviews">
                    <h2 class="profile_title">MY REVIEWS</h2>
                    <div class="profile_container">
                        <div class="activity_grid--item">
                            <div class="activity_grid--item_img">
                                <a class="activity_grid--item_img_user"
                                    href="#">
                                    <img src="assets/images/user.jpg" alt>
                                    <p>Abed Ulrhman Alshafee</p>
                                </a>
                                <a href="#"><img
                                        class="activity_grid--item_img_user-img"
                                        src="assets/images/rev.jpg" alt></a>
                                <a class="activity_grid--item_img_like" href><i
                                        class="fa-solid fa-heart"></i></a>
                            </div>
                            <div class="activity_grid--item_content">
                                <div class="activity_grid--item_content-info" ">
                                    <div
                                        class="activity_grid--item_content-info_name">
                                        <a href>
                                            <h3>Jebena Cafe</h3>
                                        </a>
                                        <div class="activity_stars"><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i></div>
                                    </div>
                                    <a
                                        class="activity_grid--item_content-info_link"
                                        href="#"><i
                                            class="fa-solid fa-mug-saucer"></i></a>
                                </div>
                                <p>recently
                                    visited Jebena Cafe,
                                    and it was an absolute delight ! The
                                    ambiance was
                                    warm and inviting,
                                    with soft lighting ...
                                </p>
                            </div>
                        </div>
                        <div class="activity_grid--item">
                            <div class="activity_grid--item_img">
                                <a class="activity_grid--item_img_user"
                                    href="#">
                                    <img src="assets/images/user.jpg" alt>
                                    <p>Abed Ulrhman Alshafee</p>
                                </a>
                                <a href="#"><img
                                        class="activity_grid--item_img_user-img"
                                        src="assets/images/rev.jpg" alt></a>
                                <a class="activity_grid--item_img_like" href><i
                                        class="fa-solid fa-heart"></i></a>
                            </div>
                            <div class="activity_grid--item_content">
                                <div class="activity_grid--item_content-info" ">
                                    <div
                                        class="activity_grid--item_content-info_name">
                                        <a href>
                                            <h3>Jebena Cafe</h3>
                                        </a>
                                        <div class="activity_stars"><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i></div>
                                    </div>
                                    <a
                                        class="activity_grid--item_content-info_link"
                                        href="#"><i
                                            class="fa-solid fa-mug-saucer"></i></a>
                                </div>
                                <p>recently
                                    visited Jebena Cafe,
                                    and it was an absolute delight ! The
                                    ambiance was
                                    warm and inviting,
                                    with soft lighting ...
                                </p>
                            </div>
                        </div>
                        <div class="activity_grid--item">
                            <div class="activity_grid--item_img">
                                <a class="activity_grid--item_img_user"
                                    href="#">
                                    <img src="assets/images/user.jpg" alt>
                                    <p>Abed Ulrhman Alshafee</p>
                                </a>
                                <a href="#"><img
                                        class="activity_grid--item_img_user-img"
                                        src="assets/images/rev.jpg" alt></a>
                                <a class="activity_grid--item_img_like" href><i
                                        class="fa-solid fa-heart"></i></a>
                            </div>
                            <div class="activity_grid--item_content">
                                <div class="activity_grid--item_content-info" ">
                                    <div
                                        class="activity_grid--item_content-info_name">
                                        <a href>
                                            <h3>Jebena Cafe</h3>
                                        </a>
                                        <div class="activity_stars"><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i></div>
                                    </div>
                                    <a
                                        class="activity_grid--item_content-info_link"
                                        href="#"><i
                                            class="fa-solid fa-mug-saucer"></i></a>
                                </div>
                                <p>recently
                                    visited Jebena Cafe,
                                    and it was an absolute delight ! The
                                    ambiance was
                                    warm and inviting,
                                    with soft lighting ...
                                </p>
                            </div>
                        </div>
                        <div class="activity_grid--item">
                            <div class="activity_grid--item_img">
                                <a class="activity_grid--item_img_user"
                                    href="#">
                                    <img src="assets/images/user.jpg" alt>
                                    <p>Abed Ulrhman Alshafee</p>
                                </a>
                                <a href="#"><img
                                        class="activity_grid--item_img_user-img"
                                        src="assets/images/rev.jpg" alt></a>
                                <a class="activity_grid--item_img_like" href><i
                                        class="fa-solid fa-heart"></i></a>
                            </div>
                            <div class="activity_grid--item_content">
                                <div class="activity_grid--item_content-info" ">
                                    <div
                                        class="activity_grid--item_content-info_name">
                                        <a href>
                                            <h3>Jebena Cafe</h3>
                                        </a>
                                        <div class="activity_stars"><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i></div>
                                    </div>
                                    <a
                                        class="activity_grid--item_content-info_link"
                                        href="#"><i
                                            class="fa-solid fa-mug-saucer"></i></a>
                                </div>
                                <p>recently
                                    visited Jebena Cafe,
                                    and it was an absolute delight ! The
                                    ambiance was
                                    warm and inviting,
                                    with soft lighting ...
                                </p>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="btn__red--l btn__red btn">see all</a>
                </div>
                <div class="profile_main_likeReviews">
                    <h2 class="profile_title">LIKED REVIEWS</h2>
                    <div class="profile_container">
                        <div class="activity_grid--item">
                            <div class="activity_grid--item_img">
                                <a class="activity_grid--item_img_user"
                                    href="#">
                                    <img src="assets/images/user.jpg" alt>
                                    <p>Abed Ulrhman Alshafee</p>
                                </a>
                                <a href="#"><img
                                        class="activity_grid--item_img_user-img"
                                        src="assets/images/rev.jpg" alt></a>
                                <a class="activity_grid--item_img_like" href><i
                                        class="fa-solid fa-heart"></i></a>
                            </div>
                            <div class="activity_grid--item_content">
                                <div class="activity_grid--item_content-info" ">
                                    <div
                                        class="activity_grid--item_content-info_name">
                                        <a href>
                                            <h3>Jebena Cafe</h3>
                                        </a>
                                        <div class="activity_stars"><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i></div>
                                    </div>
                                    <a
                                        class="activity_grid--item_content-info_link"
                                        href="#"><i
                                            class="fa-solid fa-mug-saucer"></i></a>
                                </div>
                                <p>recently
                                    visited Jebena Cafe,
                                    and it was an absolute delight ! The
                                    ambiance was
                                    warm and inviting,
                                    with soft lighting ...
                                </p>
                            </div>
                        </div>
                        <div class="activity_grid--item">
                            <div class="activity_grid--item_img">
                                <a class="activity_grid--item_img_user"
                                    href="#">
                                    <img src="assets/images/user.jpg" alt>
                                    <p>Abed Ulrhman Alshafee</p>
                                </a>
                                <a href="#"><img
                                        class="activity_grid--item_img_user-img"
                                        src="assets/images/rev.jpg" alt></a>
                                <a class="activity_grid--item_img_like" href><i
                                        class="fa-solid fa-heart"></i></a>
                            </div>
                            <div class="activity_grid--item_content">
                                <div class="activity_grid--item_content-info" ">
                                    <div
                                        class="activity_grid--item_content-info_name">
                                        <a href>
                                            <h3>Jebena Cafe</h3>
                                        </a>
                                        <div class="activity_stars"><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i></div>
                                    </div>
                                    <a
                                        class="activity_grid--item_content-info_link"
                                        href="#"><i
                                            class="fa-solid fa-mug-saucer"></i></a>
                                </div>
                                <p>recently
                                    visited Jebena Cafe,
                                    and it was an absolute delight ! The
                                    ambiance was
                                    warm and inviting,
                                    with soft lighting ...
                                </p>
                            </div>
                        </div>
                        <div class="activity_grid--item">
                            <div class="activity_grid--item_img">
                                <a class="activity_grid--item_img_user"
                                    href="#">
                                    <img src="assets/images/user.jpg" alt>
                                    <p>Abed Ulrhman Alshafee</p>
                                </a>
                                <a href="#"><img
                                        class="activity_grid--item_img_user-img"
                                        src="assets/images/rev.jpg" alt></a>
                                <a class="activity_grid--item_img_like" href><i
                                        class="fa-solid fa-heart"></i></a>
                            </div>
                            <div class="activity_grid--item_content">
                                <div class="activity_grid--item_content-info" ">
                                    <div
                                        class="activity_grid--item_content-info_name">
                                        <a href>
                                            <h3>Jebena Cafe</h3>
                                        </a>
                                        <div class="activity_stars"><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i></div>
                                    </div>
                                    <a
                                        class="activity_grid--item_content-info_link"
                                        href="#"><i
                                            class="fa-solid fa-mug-saucer"></i></a>
                                </div>
                                <p>recently
                                    visited Jebena Cafe,
                                    and it was an absolute delight ! The
                                    ambiance was
                                    warm and inviting,
                                    with soft lighting ...
                                </p>
                            </div>
                        </div>
                        <div class="activity_grid--item">
                            <div class="activity_grid--item_img">
                                <a class="activity_grid--item_img_user"
                                    href="#">
                                    <img src="assets/images/user.jpg" alt>
                                    <p>Abed Ulrhman Alshafee</p>
                                </a>
                                <a href="#"><img
                                        class="activity_grid--item_img_user-img"
                                        src="assets/images/rev.jpg" alt></a>
                                <a class="activity_grid--item_img_like" href><i
                                        class="fa-solid fa-heart"></i></a>
                            </div>
                            <div class="activity_grid--item_content">
                                <div class="activity_grid--item_content-info" ">
                                    <div
                                        class="activity_grid--item_content-info_name">
                                        <a href>
                                            <h3>Jebena Cafe</h3>
                                        </a>
                                        <div class="activity_stars"><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i></div>
                                    </div>
                                    <a
                                        class="activity_grid--item_content-info_link"
                                        href="#"><i
                                            class="fa-solid fa-mug-saucer"></i></a>
                                </div>
                                <p>recently
                                    visited Jebena Cafe,
                                    and it was an absolute delight ! The
                                    ambiance was
                                    warm and inviting,
                                    with soft lighting ...
                                </p>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="btn__red--l btn__red btn">see all</a>
                </div>
                <div class="profile_main_collection">
                    <h2 class="profile_title">MY COLLECTIONS</h2>
                    <div class="profile_container">
                        <div class="listing_grid--item">
                            <div class="listing_grid--item-img">
                                <a href="#" class="listing_grid--item-img_img">
                                    <img src="assets/images/listing.jpg"
                                        alt="#">
                                </a>
                                <a href="#"
                                    class="listing_grid--item-img_category"><i
                                        class="fa-solid fa-utensils"></i></a>
                                <a href="#"
                                    class="listing_grid--item-img_save"><i
                                        class="fa-solid fa-bookmark"></i></a>
                            </div>
                            <div class="listing_grid--item-content">
                                <div class="listing_grid--item-content_tages">
                                    <a href="#">Amman</a>
                                    <a href="#">Resturant</a>
                                    <a href="#">Seafood</a>
                                    <a href="#">Jordan</a>
                                </div>
                                <a class="listing_grid--item-content_name"
                                    href="#">The
                                    Hungry
                                    Fork</a>
                                <a href="#"
                                    class="listing_grid--item-content_location">
                                    <i class="fa-solid fa-location-dot"></i>
                                    Rainbow Street, Amman, Jordan
                                </a>
                                <div class="listing_grid--item-content_stars">
                                    <div
                                        class="listing_grid--item-content_stars-stars">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <h4
                                        class="listing_grid--item-content_stars-price">$$$</h4>
                                </div>
                            </div>
                        </div>
                        <div class="listing_grid--item">
                            <div class="listing_grid--item-img">
                                <a href="#" class="listing_grid--item-img_img">
                                    <img src="assets/images/listing.jpg"
                                        alt="#">
                                </a>
                                <a href="#"
                                    class="listing_grid--item-img_category"><i
                                        class="fa-solid fa-utensils"></i></a>
                                <a href="#"
                                    class="listing_grid--item-img_save"><i
                                        class="fa-solid fa-bookmark"></i></a>
                            </div>
                            <div class="listing_grid--item-content">
                                <div class="listing_grid--item-content_tages">
                                    <a href="#">Amman</a>
                                    <a href="#">Resturant</a>
                                    <a href="#">Seafood</a>
                                    <a href="#">Jordan</a>
                                </div>
                                <a class="listing_grid--item-content_name"
                                    href="#">The
                                    Hungry
                                    Fork</a>
                                <a href="#"
                                    class="listing_grid--item-content_location">
                                    <i class="fa-solid fa-location-dot"></i>
                                    Rainbow Street, Amman, Jordan
                                </a>
                                <div class="listing_grid--item-content_stars">
                                    <div
                                        class="listing_grid--item-content_stars-stars">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <h4
                                        class="listing_grid--item-content_stars-price">$$$</h4>
                                </div>
                            </div>
                        </div>
                        <div class="listing_grid--item">
                            <div class="listing_grid--item-img">
                                <a href="#" class="listing_grid--item-img_img">
                                    <img src="assets/images/listing.jpg"
                                        alt="#">
                                </a>
                                <a href="#"
                                    class="listing_grid--item-img_category"><i
                                        class="fa-solid fa-utensils"></i></a>
                                <a href="#"
                                    class="listing_grid--item-img_save"><i
                                        class="fa-solid fa-bookmark"></i></a>
                            </div>
                            <div class="listing_grid--item-content">
                                <div class="listing_grid--item-content_tages">
                                    <a href="#">Amman</a>
                                    <a href="#">Resturant</a>
                                    <a href="#">Seafood</a>
                                    <a href="#">Jordan</a>
                                </div>
                                <a class="listing_grid--item-content_name"
                                    href="#">The
                                    Hungry
                                    Fork</a>
                                <a href="#"
                                    class="listing_grid--item-content_location">
                                    <i class="fa-solid fa-location-dot"></i>
                                    Rainbow Street, Amman, Jordan
                                </a>
                                <div class="listing_grid--item-content_stars">
                                    <div
                                        class="listing_grid--item-content_stars-stars">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <h4
                                        class="listing_grid--item-content_stars-price">$$$</h4>
                                </div>
                            </div>
                        </div>
                        <div class="listing_grid--item">
                            <div class="listing_grid--item-img">
                                <a href="#" class="listing_grid--item-img_img">
                                    <img src="assets/images/listing.jpg"
                                        alt="#">
                                </a>
                                <a href="#"
                                    class="listing_grid--item-img_category"><i
                                        class="fa-solid fa-utensils"></i></a>
                                <a href="#"
                                    class="listing_grid--item-img_save"><i
                                        class="fa-solid fa-bookmark"></i></a>
                            </div>
                            <div class="listing_grid--item-content">
                                <div class="listing_grid--item-content_tages">
                                    <a href="#">Amman</a>
                                    <a href="#">Resturant</a>
                                    <a href="#">Seafood</a>
                                    <a href="#">Jordan</a>
                                </div>
                                <a class="listing_grid--item-content_name"
                                    href="#">The
                                    Hungry
                                    Fork</a>
                                <a href="#"
                                    class="listing_grid--item-content_location">
                                    <i class="fa-solid fa-location-dot"></i>
                                    Rainbow Street, Amman, Jordan
                                </a>
                                <div class="listing_grid--item-content_stars">
                                    <div
                                        class="listing_grid--item-content_stars-stars">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <h4
                                        class="listing_grid--item-content_stars-price">$$$</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="btn__red--l btn__red btn">see all</a>
                </div>
                <div class="profile_main_info">
                    <div class="profile_main_info--top">
                        <div class="info_top--item">
                            <h3>Name</h3>
                            <p>Abd Ulrhman alshafee</p>
                        </div>
                        <div class="info_top--item">
                            <h3>since</h3>
                            <p>January 2025</p>
                        </div>
                        <div class="info_top--item">
                            <h3>Email</h3>
                            <p>myemail@email.com</p>
                        </div>
                        <div class="info_top--item">
                            <h3>Gender</h3>
                            <p>Male</p>
                        </div>
                    </div>
                    <div class="profile_main_info--bottom">
                        <h3>About me</h3>
                        <p>Hi, I’m Abd Ulrhman! I love discovering great local
                            spots, whether it’s a cozy café, a hidden bookstore,
                            or a restaurant with the best food in town. I enjoy
                            sharing honest reviews to help others find amazing
                            experiences.
                            When I’m not trying new places, I’m usually working
                            on web development projects or exploring
                            tech-related topics. If you have any
                            recommendations, I’m always open to suggestions!</p>
                    </div>
                </div>
            </div>
        </main>
        <footer class="footer">
            <div class="footer_color">
                <div class="footer_top">
                    <div class="footer_top--logo">
                        <img src="assets/images/logo(2).png" alt="logo">
                        <p>Taqeem is the place to find every thing you are
                            looking
                            for</p>
                    </div>
                    <div class="footer_top--links">
                        <h4>About</h4>
                        <div>
                            <a href="#">link</a>
                            <a href="#">link</a>
                            <a href="#">link</a>
                        </div>
                    </div>
                    <div class="footer_top--links">
                        <h4>Discover</h4>
                        <div>
                            <a href="#">link</a>
                            <a href="#">link</a>
                            <a href="#">link</a>
                        </div>
                    </div>
                    <div class="footer_top--links">
                        <h4>Contact Us</h4>
                        <div>
                            <a href="mailto:email@example.com">Email :
                                support@domain.com</a>
                            <a href="tel:+05890000111">Phone : 1 (00) 832
                                2342</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer_rights">
                <h4>2025 © by the boys. All rights reserved. </h4>
            </div>
        </footer>
    </body>
    <script src="assets/js/script.js">

    </script>
</html>