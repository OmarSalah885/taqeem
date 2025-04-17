<?php
include 'config.php'; // Include session settings
session_start(); // Start the session


include 'header.php';
?>

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
        <div class="add-place_main--item add-place_main--general" id="add-place-general">
            <h2 class="add-place_title">GENERAL</h2>
            <div class="side-by-side_inbut">
                <input type="text" placeholder="PLACE NAME" class="input--red">
                <select name="price" id="price" class="input--red">
                    <option value disabled selected class="selected-option">PRICE</option>
                    <option value="3">$$$</option>
                    <option value="2">$$</option>
                    <option value="1">$</option>
                </select>
            </div>
            <textarea name id placeholder="DESCRIPTION ..."></textarea>
            <select name="CATEGORY" id="CATEGORY" class="input--red">
                <option value disabled selected class="selected-option">CATEGORY</option>
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
        <div class="add-place_main--item add-place_main--highlight " id="add-place-highlight">
            <h2 class="add-place_title">HIGHLIGHTS</h2>
            <div class="highlight-Checkboxes">
                <label for="vehicle1">
                    <input type="checkbox" id="vehicle1" name="vehicle1" value="conditioner"> Air conditioner
                </label>
                <label for="vehicle2">
                    <input type="checkbox" id="vehicle2" name="vehicle2" value="conditioner"> Air conditioner
                </label>
                <label for="vehicle3">
                    <input type="checkbox" id="vehicle3" name="vehicle3" value="conditioner"> Air conditioner
                </label>
                <label for="vehicle4">
                    <input type="checkbox" id="vehicle4" name="vehicle4" value="conditioner"> Air conditioner
                </label>
                <label for="vehicle5">
                    <input type="checkbox" id="vehicle5" name="vehicle5" value="conditioner"> Air conditioner
                </label>
                <label for="vehicle6">
                    <input type="checkbox" id="vehicle6" name="vehicle6" value="conditioner"> Air conditioner
                </label>
                <label for="vehicle7">
                    <input type="checkbox" id="vehicle7" name="vehicle7" value="conditioner"> Air conditioner
                </label>
                <label for="vehicle8">
                    <input type="checkbox" id="vehicle8" name="vehicle8" value="conditioner"> Air conditioner
                </label>
                <label for="vehicle9">
                    <input type="checkbox" id="vehicle9" name="vehicle9" value="conditioner"> Air conditioner
                </label>
                <label for="vehicle10">
                    <input type="checkbox" id="vehicle10" name="vehicle10" value="conditioner"> Air conditioner
                </label>
            </div>
        </div>
        <div class="add-place_main--item add-place_main--location" id="add-place-location">
            <h2 class="add-place_title">LOCATION</h2>
            <div class="side-by-side_inbut">
                <input type="text" placeholder="COUNTRY" class="input--red">
                <input type="text" placeholder="CITY" class="input--red">
            </div>
            <input type="text" placeholder="PLACE ADDRESS FROM GOOGLE" class="input--red">
            <div class="location-map">
                <h3 class="location-map_title">SET LOCATION ON MAP</h3>
                <div id="map"></div>
                <p>Selected Coordinates: <span id="coordinates">None</span></p>
            </div>
        </div>
        <div class="add-place_main--item add-place_main--contact" id="add-place-contact">
            <h2 class="add-place_title">CONTACT INFO</h2>
            <input type="email" placeholder="EMAIL" class="input--red">
            <input type="email" placeholder="PHONE NUMBER 1" class="input--red">
            <input type="email" placeholder="PHONE NUMBER 2 (OPTIONAL)" class="input--red">
            <input type="url" placeholder="WEBSITE (OPTIONAL)" class="input--red">
        </div>
        <div class="add-place_main--item add-place_main--social" id="add-place-social">
            <h2 class="add-place_title">SOCIAL NETWORKS</h2>
            <input type="url" placeholder="FACEBOOK URL" class="input--red">
            <input type="url" placeholder="INSTAGRAM URL" class="input--red">
            <input type="url" placeholder="TWITTER URL" class="input--red">
        </div>
        <div class="add-place_main--item add-place_main--opening" id="add-place-opening">
            <h2 class="add-place_title">SOCIAL NETWORKS</h2>
            <div class="side-by-side_inbut">
                <input type="text" placeholder="Monday" value="Monday" class="input--red">
                <input type="text" placeholder="Time" value="9:00 AM - 5:00 PM" class="input--red">
            </div>
            <div class="side-by-side_inbut">
                <input type="text" placeholder="Tuesday" value="Tuesday" class="input--red">
                <input type="text" placeholder="Time" value="9:00 AM - 5:00 PM" class="input--red">
            </div>
            <div class="side-by-side_inbut">
                <input type="text" placeholder="Wednesday" value="Wednesday" class="input--red">
                <input type="text" placeholder="Time" value="9:00 AM - 5:00 PM" class="input--red">
            </div>
            <div class="side-by-side_inbut">
                <input type="text" placeholder="Thursday" value="Thursday" class="input--red">
                <input type="text" placeholder="Time" value="9:00 AM - 5:00 PM" class="input--red">
            </div>
            <div class="side-by-side_inbut">
                <input type="text" placeholder="Friday" value="Friday" class="input--red">
                <input type="text" placeholder="Time" value="9:00 AM - 5:00 PM" class="input--red">
            </div>
            <div class="side-by-side_inbut">
                <input type="text" placeholder="Saturday" value="Saturday" class="input--red">
                <input type="text" placeholder="Time" value="9:00 AM - 5:00 PM" class="input--red">
            </div>
            <div class="side-by-side_inbut">
                <input type="text" placeholder="Sunday" value="Sunday" class="input--red">
                <input type="text" placeholder="Time" value="9:00 AM - 5:00 PM" class="input--red">
            </div>
        </div>
        <div class="add-place_main--item add-place_main--media" id="add-place-media">
            <h2 class="add-place_title">MEDIA</h2>
            <div class="media-contanier">
                <div class="media-contanier_featured">
                    <p class="media-contanier_title">FEATURED IMAGE</p>
                    <div class="drop-area">
                        <p><i class="fa-solid fa-arrow-up"></i>
                            <label for="fileInput1" class="browse-btn"></label>
                        </p>
                        <input type="file" id="fileInput1" class="file-input" multiple hidden>
                        <div class="file-list"></div>
                    </div>
                </div>
                <div class="media-contanier_gallery">
                    <p class="media-contanier_title">GALLERY IMAGES</p>
                    <div class="drop-area">
                        <p><i class="fa-solid fa-arrow-up"></i> Drag &
                            Drop files here
                            <label for="fileInput2" class="browse-btn"></label>
                        </p>
                        <input type="file" id="fileInput2" class="file-input" multiple hidden>
                        <div class="file-list"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="add-place_main--item add-place_main--menu" id="add-place-menu">
            <h2 class="add-place_title">MEDIA</h2>
            <div class="add-menu_item">
                <div class="add-menu_item--img">
                    <p class="media-contanier_title">MENU ITEM IMAGE</p>
                    <div class="drop-area">
                        <p><i class="fa-solid fa-arrow-up"></i>
                            <label for="fileInput3" class="browse-btn"></label>
                        </p>
                        <input type="file" id="fileInput3" class="file-input" multiple hidden>
                        <div class="file-list"></div>
                    </div>
                </div>
                <div class="add-menu_item--info">
                    <div class="side-by-side_inbut">
                        <input type="text" placeholder="MENU ITEM IMAGE" class="input--red">
                        <input type="text" placeholder="MENU ITEM PRICE" class="input--red">
                    </div>
                    <input type="text" placeholder="MENU ITEM DESCRIPTION" class="input--red">
                </div>
            </div>
            <button class="btn__red--s btn__red btn">ADD MORE</button>
        </div>

        <div class="add-place_main--item add-place_main--faqs" id="add-place-faqs">
            <h2 class="add-place_title">FQAs</h2>
            <input type="text" placeholder="QUESTION" class="input--red">
            <input type="text" placeholder="ANSWER" class="input--red">
            <button class="btn__red--s btn__red btn">ADD MORE</button>
        </div>
        <button class="btn__red--l btn__red btn">ADD PLACE !</button>
    </div>
</main>
<?php include 'footer.php'; ?>