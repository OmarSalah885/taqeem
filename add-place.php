<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
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
        <link rel="stylesheet"
            href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
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
        <main class="add-place">
            <div class="add-place_sidebar">
                <a href="#add-place-general">GENERAL</a>
                <a href="#add-place-highlight">HIGHLIGHTS</a>
                <a href="#add-place-location">LOCATION</a>
                <a href="#add-place-contact">CONTACT INFO</a>
                <a href="#add-place-social">SOCIAL NETWORKS</a>
                <a href="#add-place-opening">OPENING HOURS</a>
                <a href="#add-place-media">MEDIA</a>
                <a href="#add-place-menu">MENU</a>
                <a href="#add-place-faqs">FAQs</a>
            </div>
            <div class="add-place_main">
                <div class="add-place_main--item add-place_main--general"
                    id="add-place-general">
                    <h2 class="add-place_title">GENERAL</h2>
                    <div class="side-by-side_inbut">
                        <input type="text" placeholder="PLACE NAME"
                            class="input--red">
                        <select name="price" id="price" class="input--red">
                            <option value disabled selected
                                class="selected-option">PRICE</option>
                            <option value="3">$$$</option>
                            <option value="2">$$</option>
                            <option value="1">$</option>
                        </select>
                    </div>
                    <textarea name id
                        placeholder="DESCRIPTION ..."></textarea>
                    <select name="CATEGORY" id="CATEGORY" class="input--red">
                        <option value disabled selected
                            class="selected-option">CATEGORY</option>
                        <option value="RESTURANTS">RESTURANTS</option>
                        <option value="SHOPPING">SHOPPING</option>
                        <option value="ACTIVE LIFE">ACTIVE LIFE</option>
                        <option value="HOME SERVICES">HOME SERVICES</option>
                        <option value="COFFEE">COFFEE</option>
                        <option value="PETS">PETS</option>
                        <option value="PLANTS SHOP">PLANTS SHOP</option>
                        <option value="ART">ART</option>
                        <option value="HOTELS">HOTELS</option>
                        <option value="EDUCATION">EDUCATION</option>
                        <option value="HEALTH">HEALTH</option>
                        <option value="WORKSPACE">WORKSPACE</option>
                    </select>
                </div>
                <div class="add-place_main--item add-place_main--highlight "
                    id="add-place-highlight">
                    <h2 class="add-place_title">HIGHLIGHTS</h2>
                    <div class="highlight-Checkboxes">
                        <label for="vehicle1">
                            <input type="checkbox" id="vehicle1" name="vehicle1"
                                value="conditioner"> Air conditioner
                        </label>
                        <label for="vehicle2">
                            <input type="checkbox" id="vehicle2" name="vehicle2"
                                value="conditioner"> Air conditioner
                        </label>
                        <label for="vehicle3">
                            <input type="checkbox" id="vehicle3" name="vehicle3"
                                value="conditioner"> Air conditioner
                        </label>
                        <label for="vehicle4">
                            <input type="checkbox" id="vehicle4" name="vehicle4"
                                value="conditioner"> Air conditioner
                        </label>
                        <label for="vehicle5">
                            <input type="checkbox" id="vehicle5" name="vehicle5"
                                value="conditioner"> Air conditioner
                        </label>
                        <label for="vehicle6">
                            <input type="checkbox" id="vehicle6" name="vehicle6"
                                value="conditioner"> Air conditioner
                        </label>
                        <label for="vehicle7">
                            <input type="checkbox" id="vehicle7" name="vehicle7"
                                value="conditioner"> Air conditioner
                        </label>
                        <label for="vehicle8">
                            <input type="checkbox" id="vehicle8" name="vehicle8"
                                value="conditioner"> Air conditioner
                        </label>
                        <label for="vehicle9">
                            <input type="checkbox" id="vehicle9" name="vehicle9"
                                value="conditioner"> Air conditioner
                        </label>
                        <label for="vehicle10">
                            <input type="checkbox" id="vehicle10"
                                name="vehicle10"
                                value="conditioner"> Air conditioner
                        </label>
                    </div>
                </div>
                <div class="add-place_main--item add-place_main--location"
                    id="add-place-location">
                    <h2 class="add-place_title">LOCATION</h2>
                    <div class="side-by-side_inbut">
                        <input type="text" placeholder="COUNTRY"
                            class="input--red">
                        <input type="text" placeholder="CITY"
                            class="input--red">
                    </div>
                    <input type="text" placeholder="PLACE ADDRESS FROM GOOGLE"
                        class="input--red">
                    <div class="location-map">
                        <h3 class="location-map_title">SET LOCATION ON MAP</h3>
                        <div id="map"></div>
                        <p>Selected Coordinates: <span
                                id="coordinates">None</span></p>
                    </div>
                </div>
                <div class="add-place_main--item add-place_main--contact"
                    id="add-place-contact">
                    <h2 class="add-place_title">CONTACT INFO</h2>
                    <input type="email" placeholder="EMAIL" class="input--red">
                    <input type="email" placeholder="PHONE NUMBER 1"
                        class="input--red">
                    <input type="email" placeholder="PHONE NUMBER 2 (OPTIONAL)"
                        class="input--red">
                    <input type="url" placeholder="WEBSITE (OPTIONAL)"
                        class="input--red">
                </div>
                <div class="add-place_main--item add-place_main--social"
                    id="add-place-social">
                    <h2 class="add-place_title">SOCIAL NETWORKS</h2>
                    <input type="url" placeholder="FACEBOOK URL"
                        class="input--red">
                    <input type="url" placeholder="INSTAGRAM URL"
                        class="input--red">
                    <input type="url" placeholder="TWITTER URL"
                        class="input--red">
                </div>
                <div class="add-place_main--item add-place_main--opening"
                    id="add-place-opening">
                    <h2 class="add-place_title">SOCIAL NETWORKS</h2>
                    <div class="side-by-side_inbut">
                        <input type="text" placeholder="Monday" value="Monday"
                            class="input--red">
                        <input type="text" placeholder="Time"
                            value="9:00 AM - 5:00 PM" class="input--red">
                    </div>
                    <div class="side-by-side_inbut">
                        <input type="text" placeholder="Tuesday"
                            value="Tuesday" class="input--red">
                        <input type="text" placeholder="Time"
                            value="9:00 AM - 5:00 PM" class="input--red">
                    </div>
                    <div class="side-by-side_inbut">
                        <input type="text" placeholder="Wednesday"
                            value="Wednesday" class="input--red">
                        <input type="text" placeholder="Time"
                            value="9:00 AM - 5:00 PM" class="input--red">
                    </div>
                    <div class="side-by-side_inbut">
                        <input type="text" placeholder="Thursday"
                            value="Thursday" class="input--red">
                        <input type="text" placeholder="Time"
                            value="9:00 AM - 5:00 PM" class="input--red">
                    </div>
                    <div class="side-by-side_inbut">
                        <input type="text" placeholder="Friday"
                            value="Friday" class="input--red">
                        <input type="text" placeholder="Time"
                            value="9:00 AM - 5:00 PM" class="input--red">
                    </div>
                    <div class="side-by-side_inbut">
                        <input type="text" placeholder="Saturday"
                            value="Saturday" class="input--red">
                        <input type="text" placeholder="Time"
                            value="9:00 AM - 5:00 PM" class="input--red">
                    </div>
                    <div class="side-by-side_inbut">
                        <input type="text" placeholder="Sunday"
                            value="Sunday" class="input--red">
                        <input type="text" placeholder="Time"
                            value="9:00 AM - 5:00 PM" class="input--red">
                    </div>
                </div>
                <div class="add-place_main--item add-place_main--media"
                    id="add-place-media">
                    <h2 class="add-place_title">MEDIA</h2>
                    <div class="media-contanier">
                        <div class="media-contanier_featured">
                            <p class="media-contanier_title">FEATURED IMAGE</p>
                            <div class="drop-area">
                                <p><i class="fa-solid fa-arrow-up"></i>
                                    <label for="fileInput1"
                                        class="browse-btn"></label>
                                </p>
                                <input type="file" id="fileInput1"
                                    class="file-input" multiple hidden>
                                <div class="file-list"></div>
                            </div>
                        </div>
                        <div class="media-contanier_gallery">
                            <p class="media-contanier_title">GALLERY IMAGES</p>
                            <div class="drop-area">
                                <p><i class="fa-solid fa-arrow-up"></i> Drag &
                                    Drop files here
                                    <label for="fileInput2"
                                        class="browse-btn"></label>
                                </p>
                                <input type="file" id="fileInput2"
                                    class="file-input" multiple hidden>
                                <div class="file-list"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="add-place_main--item add-place_main--menu"
                    id="add-place-menu">
                    <h2 class="add-place_title">MEDIA</h2>
                    <div class="add-menu_item">
                        <div class="add-menu_item--img">
                            <p class="media-contanier_title">MENU ITEM IMAGE</p>
                            <div class="drop-area">
                                <p><i class="fa-solid fa-arrow-up"></i>
                                    <label for="fileInput3"
                                        class="browse-btn"></label>
                                </p>
                                <input type="file" id="fileInput3"
                                    class="file-input" multiple hidden>
                                <div class="file-list"></div>
                            </div>
                        </div>
                        <div class="add-menu_item--info">
                            <div class="side-by-side_inbut">
                                <input type="text" placeholder="MENU ITEM IMAGE"
                                    class="input--red">
                                <input type="text" placeholder="MENU ITEM PRICE"
                                    class="input--red">
                            </div>
                            <input type="text"
                                placeholder="MENU ITEM DESCRIPTION"
                                class="input--red">
                        </div>
                    </div>
                    <button class="btn__red--s btn__red btn">ADD MORE</button>
                </div>

                <div class="add-place_main--item add-place_main--faqs"
                    id="add-place-faqs">
                    <h2 class="add-place_title">FQAs</h2>
                    <input type="text" placeholder="QUESTION"
                        class="input--red">
                    <input type="text" placeholder="ANSWER" class="input--red">
                    <button class="btn__red--s btn__red btn">ADD MORE</button>
                </div>
                <button class="btn__red--l btn__red btn">ADD PLACE !</button>
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
    <script src="assets/js/map.js"></script>
    <script src="assets/js/script.js">

    </script>
</html>