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
        <div class="listing">
            <div class="pageinfo">
                <div class="pageinfo_content">
                    <h2>RESTURANTS</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a
                                href="index.html">Home</a><span>/</span></li>
                        <li class="breadcrumb-item active"><a
                                href="category.html">RESTURANTS</a></li>
                    </ol>
                </div>
            </div>
            <div class="listing_filter">
                <div class="listing_filter-L">
                    <select class="custom-select">
                        <option value disabled selected>price</option>
                        <option value="1">$</option>
                        <option value="2">$$</option>
                        <option value="3">$$$</option>
                    </select>
                    <select class="custom-select">
                        <option value disabled selected>Categories</option>
                        <option value="1">RESTURANTS</option>
                        <option value="2">SHOPPING</option>
                        <option value="3">ACTIVE LIFE</option>
                        <option value="4">HOME SERVICES</option>
                        <option value="5">COFFEE</option>
                        <option value="6">PETS</option>
                        <option value="7">PLANTS SHOP</option>
                        <option value="8">ART</option>
                        <option value="9">HOTELS</option>
                        <option value="10">EDUCATION</option>
                        <option value="11">HEALTH</option>
                        <option value="12">WORKSPACE</option>
                    </select>
                    <select class="custom-select">
                        <option value disabled selected>stars</option>
                        <option value="1">1 and more</option>
                        <option value="2">2 and more</option>
                        <option value="3">3 and more</option>
                        <option value="4">4 and more</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <select class="custom-select">
                    <option value disabled selected>sort by</option>
                    <option value="1">stars</option>
                    <option value="2">newest</option>
                    <option value="3">price</option>
                </select>
            </div>
            <div class="listing_grid">
                <div class="listing_grid--item">
                    <div class="listing_grid--item-img">
                        <a href="./single-place.html"
                            class="listing_grid--item-img_img">
                            <img src="assets/images/listing.jpg" alt="#">
                        </a>
                        <a href="./listing.html"
                            class="listing_grid--item-img_category"><i
                                class="fa-solid fa-utensils"></i></a>
                        <a href="#" class="listing_grid--item-img_save"><i
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
                            href="./single-place.html">The
                            Hungry
                            Fork</a>
                        <a href="#"
                            class="listing_grid--item-content_location">
                            <i class="fa-solid fa-location-dot"></i>
                            Rainbow Street, Amman, Jordan
                        </a>
                        <div class="listing_grid--item-content_stars">
                            <div class="listing_grid--item-content_stars-stars">
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
                        <a href="./single-place.html"
                            class="listing_grid--item-img_img">
                            <img src="assets/images/listing.jpg" alt="#">
                        </a>
                        <a href="./listing.html"
                            class="listing_grid--item-img_category"><i
                                class="fa-solid fa-utensils"></i></a>
                        <a href="#" class="listing_grid--item-img_save"><i
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
                            href="./single-place.html">The
                            Hungry
                            Fork</a>
                        <a href="#"
                            class="listing_grid--item-content_location">
                            <i class="fa-solid fa-location-dot"></i>
                            Rainbow Street, Amman, Jordan
                        </a>
                        <div class="listing_grid--item-content_stars">
                            <div class="listing_grid--item-content_stars-stars">
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
                        <a href="./single-place.html"
                            class="listing_grid--item-img_img">
                            <img src="assets/images/listing.jpg" alt="#">
                        </a>
                        <a href="./listing.html"
                            class="listing_grid--item-img_category"><i
                                class="fa-solid fa-utensils"></i></a>
                        <a href="#" class="listing_grid--item-img_save"><i
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
                            href="./single-place.html">The
                            Hungry
                            Fork</a>
                        <a href="#"
                            class="listing_grid--item-content_location">
                            <i class="fa-solid fa-location-dot"></i>
                            Rainbow Street, Amman, Jordan
                        </a>
                        <div class="listing_grid--item-content_stars">
                            <div class="listing_grid--item-content_stars-stars">
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
                        <a href="./single-place.html"
                            class="listing_grid--item-img_img">
                            <img src="assets/images/listing.jpg" alt="#">
                        </a>
                        <a href="./listing.html"
                            class="listing_grid--item-img_category"><i
                                class="fa-solid fa-utensils"></i></a>
                        <a href="#" class="listing_grid--item-img_save"><i
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
                            href="./single-place.html">The
                            Hungry
                            Fork</a>
                        <a href="#"
                            class="listing_grid--item-content_location">
                            <i class="fa-solid fa-location-dot"></i>
                            Rainbow Street, Amman, Jordan
                        </a>
                        <div class="listing_grid--item-content_stars">
                            <div class="listing_grid--item-content_stars-stars">
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
                        <a href="./single-place.html"
                            class="listing_grid--item-img_img">
                            <img src="assets/images/listing.jpg" alt="#">
                        </a>
                        <a href="./listing.html"
                            class="listing_grid--item-img_category"><i
                                class="fa-solid fa-utensils"></i></a>
                        <a href="#" class="listing_grid--item-img_save"><i
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
                            href="./single-place.html">The
                            Hungry
                            Fork</a>
                        <a href="#"
                            class="listing_grid--item-content_location">
                            <i class="fa-solid fa-location-dot"></i>
                            Rainbow Street, Amman, Jordan
                        </a>
                        <div class="listing_grid--item-content_stars">
                            <div class="listing_grid--item-content_stars-stars">
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
                        <a href="./single-place.html"
                            class="listing_grid--item-img_img">
                            <img src="assets/images/listing.jpg" alt="#">
                        </a>
                        <a href="./listing.html"
                            class="listing_grid--item-img_category"><i
                                class="fa-solid fa-utensils"></i></a>
                        <a href="#" class="listing_grid--item-img_save"><i
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
                            href="./single-place.html">The
                            Hungry
                            Fork</a>
                        <a href="#"
                            class="listing_grid--item-content_location">
                            <i class="fa-solid fa-location-dot"></i>
                            Rainbow Street, Amman, Jordan
                        </a>
                        <div class="listing_grid--item-content_stars">
                            <div class="listing_grid--item-content_stars-stars">
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
                        <a href="./single-place.html"
                            class="listing_grid--item-img_img">
                            <img src="assets/images/listing.jpg" alt="#">
                        </a>
                        <a href="./listing.html"
                            class="listing_grid--item-img_category"><i
                                class="fa-solid fa-utensils"></i></a>
                        <a href="#" class="listing_grid--item-img_save"><i
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
                            href="./single-place.html">The
                            Hungry
                            Fork</a>
                        <a href="#"
                            class="listing_grid--item-content_location">
                            <i class="fa-solid fa-location-dot"></i>
                            Rainbow Street, Amman, Jordan
                        </a>
                        <div class="listing_grid--item-content_stars">
                            <div class="listing_grid--item-content_stars-stars">
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
                        <a href="./single-place.html"
                            class="listing_grid--item-img_img">
                            <img src="assets/images/listing.jpg" alt="#">
                        </a>
                        <a href="./listing.html"
                            class="listing_grid--item-img_category"><i
                                class="fa-solid fa-utensils"></i></a>
                        <a href="#" class="listing_grid--item-img_save"><i
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
                            href="./single-place.html">The
                            Hungry
                            Fork</a>
                        <a href="#"
                            class="listing_grid--item-content_location">
                            <i class="fa-solid fa-location-dot"></i>
                            Rainbow Street, Amman, Jordan
                        </a>
                        <div class="listing_grid--item-content_stars">
                            <div class="listing_grid--item-content_stars-stars">
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
                        <a href="./single-place.html"
                            class="listing_grid--item-img_img">
                            <img src="assets/images/listing.jpg" alt="#">
                        </a>
                        <a href="./listing.html"
                            class="listing_grid--item-img_category"><i
                                class="fa-solid fa-utensils"></i></a>
                        <a href="#" class="listing_grid--item-img_save"><i
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
                            href="./single-place.html">The
                            Hungry
                            Fork</a>
                        <a href="#"
                            class="listing_grid--item-content_location">
                            <i class="fa-solid fa-location-dot"></i>
                            Rainbow Street, Amman, Jordan
                        </a>
                        <div class="listing_grid--item-content_stars">
                            <div class="listing_grid--item-content_stars-stars">
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
                        <a href="./single-place.html"
                            class="listing_grid--item-img_img">
                            <img src="assets/images/listing.jpg" alt="#">
                        </a>
                        <a href="./listing.html"
                            class="listing_grid--item-img_category"><i
                                class="fa-solid fa-utensils"></i></a>
                        <a href="#" class="listing_grid--item-img_save"><i
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
                            href="./single-place.html">The
                            Hungry
                            Fork</a>
                        <a href="#"
                            class="listing_grid--item-content_location">
                            <i class="fa-solid fa-location-dot"></i>
                            Rainbow Street, Amman, Jordan
                        </a>
                        <div class="listing_grid--item-content_stars">
                            <div class="listing_grid--item-content_stars-stars">
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
                        <a href="./single-place.html"
                            class="listing_grid--item-img_img">
                            <img src="assets/images/listing.jpg" alt="#">
                        </a>
                        <a href="./listing.html"
                            class="listing_grid--item-img_category"><i
                                class="fa-solid fa-utensils"></i></a>
                        <a href="#" class="listing_grid--item-img_save"><i
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
                            href="./single-place.html">The
                            Hungry
                            Fork</a>
                        <a href="#"
                            class="listing_grid--item-content_location">
                            <i class="fa-solid fa-location-dot"></i>
                            Rainbow Street, Amman, Jordan
                        </a>
                        <div class="listing_grid--item-content_stars">
                            <div class="listing_grid--item-content_stars-stars">
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
                        <a href="./single-place.html"
                            class="listing_grid--item-img_img">
                            <img src="assets/images/listing.jpg" alt="#">
                        </a>
                        <a href="./listing.html"
                            class="listing_grid--item-img_category"><i
                                class="fa-solid fa-utensils"></i></a>
                        <a href="#" class="listing_grid--item-img_save"><i
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
                            href="./single-place.html">The
                            Hungry
                            Fork</a>
                        <a href="#"
                            class="listing_grid--item-content_location">
                            <i class="fa-solid fa-location-dot"></i>
                            Rainbow Street, Amman, Jordan
                        </a>
                        <div class="listing_grid--item-content_stars">
                            <div class="listing_grid--item-content_stars-stars">
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
                        <a href="./single-place.html"
                            class="listing_grid--item-img_img">
                            <img src="assets/images/listing.jpg" alt="#">
                        </a>
                        <a href="./listing.html"
                            class="listing_grid--item-img_category"><i
                                class="fa-solid fa-utensils"></i></a>
                        <a href="#" class="listing_grid--item-img_save"><i
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
                            href="./single-place.html">The
                            Hungry
                            Fork</a>
                        <a href="#"
                            class="listing_grid--item-content_location">
                            <i class="fa-solid fa-location-dot"></i>
                            Rainbow Street, Amman, Jordan
                        </a>
                        <div class="listing_grid--item-content_stars">
                            <div class="listing_grid--item-content_stars-stars">
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
                        <a href="./single-place.html"
                            class="listing_grid--item-img_img">
                            <img src="assets/images/listing.jpg" alt="#">
                        </a>
                        <a href="./listing.html"
                            class="listing_grid--item-img_category"><i
                                class="fa-solid fa-utensils"></i></a>
                        <a href="#" class="listing_grid--item-img_save"><i
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
                            href="./single-place.html">The
                            Hungry
                            Fork</a>
                        <a href="#"
                            class="listing_grid--item-content_location">
                            <i class="fa-solid fa-location-dot"></i>
                            Rainbow Street, Amman, Jordan
                        </a>
                        <div class="listing_grid--item-content_stars">
                            <div class="listing_grid--item-content_stars-stars">
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
                        <a href="./single-place.html"
                            class="listing_grid--item-img_img">
                            <img src="assets/images/listing.jpg" alt="#">
                        </a>
                        <a href="./listing.html"
                            class="listing_grid--item-img_category"><i
                                class="fa-solid fa-utensils"></i></a>
                        <a href="#" class="listing_grid--item-img_save"><i
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
                            href="./single-place.html">The
                            Hungry
                            Fork</a>
                        <a href="#"
                            class="listing_grid--item-content_location">
                            <i class="fa-solid fa-location-dot"></i>
                            Rainbow Street, Amman, Jordan
                        </a>
                        <div class="listing_grid--item-content_stars">
                            <div class="listing_grid--item-content_stars-stars">
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
            <div class="listing_indicator">
                <div class="listing_indicator">
                    <li class="indicator_item"><a href="#"><i
                                class="fa-solid fa-chevron-left"></i></a></li>
                    <li class="indicator_item"><a href>1</a></li>
                    <li class="indicator_item active"><a href>2</a></li>
                </div>
            </div>
        </div>
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