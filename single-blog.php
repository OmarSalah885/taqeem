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
                    <div class="navbar_container--menu-L"><a href="#">home</a><a
                            href="#">blog</a><a href="#">categories</a><a
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
                            href="#">add
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
                            place</a><a href="#">home</a><a href="#">blog</a><a
                            href="#">about us</a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="single-blog">
            <div class="single-blog_img">
                <img src="assets/images/blogimg (2).jpg" alt>
            </div>
            <div class="single-blog_tages">
                <a href="#">TRAVEL</a>
                <a href="#">CAR</a>
                <a href="#">AMMAN</a>
            </div>
            <h1 class="single-blog_title">this is the title of the blog</h1>
            <div class="single-blog_content">
                <div class="single-blog_content--paragraph">
                    <p> Amman, the capital city of Jordan, is a treasure trove
                        of historical wonders, cultural richness, and
                        contemporary vibrancy. Whether you’re a history
                        enthusiast, a food lover, or an adventurer at heart,
                        this fascinating city offers something for everyone.
                        Here’s a guide to experiencing the best of Amman.</p>
                </div>
                <div class="single-blog_content--paragraph">
                    <h2>A Walk Through History</h2>
                    <p>Amman’s history stretches back thousands of years, and
                        its ancient sites are a testament to its rich past.
                        Start your journey at the Citadel (Jabal al-Qal’a),
                        perched on one of the city’s seven hills. Here, you’ll
                        find the remains of the Temple of Hercules, a Byzantine
                        church, and the Umayyad Palace. The panoramic views of
                        the city from this vantage point are breathtaking.
                        Next, visit the Roman Theatre, a 2nd-century
                        amphitheater that still hosts cultural events today.
                        Nearby, you can explore the Jordan Folklore Museum and
                        the Jordan Museum of Popular Traditions, which showcase
                        artifacts and costumes from Jordan’s diverse
                        heritage.</p>
                </div>
                <div class="single-blog_content--paragraph">
                    <h2>Cultural Immersion</h2>
                    <p> For a taste of Jordanian culture, wander through the
                        bustling streets of Downtown Amman. The markets (or
                        souks) are a sensory delight, brimming with vibrant
                        textiles, fragrant spices, and intricate handicrafts.
                        Don’t forget to stop by the Al-Balad Theatre, which
                        often features local music, film screenings, and art
                        exhibitions.
                        A visit to the Royal Automobile Museum offers a unique
                        glimpse into the history of the Hashemite Kingdom
                        through an impressive collection of classic and luxury
                        cars.</p>
                </div>
                <div class="single-blog_content--paragraph">
                    <h2>Culinary Delights</h2>
                    <p> Amman is a paradise for food lovers. Start your culinary
                        adventure with a traditional Jordanian breakfast of
                        hummus, fatteh, and falafel at one of the city’s iconic
                        eateries, like Hashem Restaurant. For lunch, savor a
                        plate of mansaf, Jordan’s national dish, made with lamb
                        cooked in a tangy yogurt sauce and served with rice.
                        Craving sweets? Try kunafa, a cheese-filled pastry
                        soaked in syrup, at Habibah Sweets, a local favorite.
                        Pair it with a cup of Arabic coffee or mint tea for the
                        ultimate indulgence.</p>
                </div>
                <div class="single-blog_content--paragraph">
                    <h2>Day Trips from Amman</h2>
                    <p>Amman’s central location makes it an excellent base for
                        exploring Jordan’s other attractions. A short drive
                        away, you can visit the ancient city of Jerash, known
                        for its remarkably preserved Roman ruins. The Dead Sea,
                        famed for its mineral-rich waters and therapeutic mud,
                        is also within easy reach.
                        For those seeking adventure, a trip to Wadi Mujib offers
                        thrilling hiking trails through a stunning canyon.</p>
                </div>
                <div class="single-blog_content--paragraph">
                    <h2>Tips for Travelers</h2>
                    <ul>
                        <li>Dress Modestly: While Amman is a modern city, it’s
                            respectful to dress modestly, especially when
                            visiting religious or historical sites.</li>
                        <li>Learn Basic Arabic Phrases: Jordanians are warm and
                            hospitable, and a few Arabic words like “Marhaba”
                            (hello) and “Shukran” (thank you) can go a long
                            way.</li>
                        <li>Use Ride-Hailing Apps: Getting around Amm an is
                            convenient with apps like Careem and Uber.</li>
                        <li>Stay Hydrated: The city can get quite hot, so carry
                            water with you while exploring.</li>
                    </ul>
                </div>
                <div class="single-blog_content--paragraph">
                    <a href="#"><h2>Final Thoughts</h2></a>
                    <p>Amman is a city that effortlessly blends the old with the
                        new. Its historical landmarks, cultural experiences, and
                        modern attractions create a unique and unforgettable
                        travel experience. Whether it’s your first visit or your
                        tenth, Amman will always have more to discover and
                        admire. Pack your bags and get ready to explore this
                        enchanting city!</p>
                </div>
            </div>
            <div class="single-blog_comments">
                <div class="comments">
                    <h2 class="comments_counter">3 Comments</h2>
                    <div class="comments_container">
                        <div class="comments_container--single">
                            <div class="comment main-comment">
                                <div class="comment_img">
                                    <img src="assets/images/comment(1).jpg"
                                        alt="#">
                                </div>
                                <div class="comment_content">
                                    <h4 class="comment_content--name">Amira
                                        Zahra</h4>
                                    <p class="comment_content--date">2 days
                                        ago</p>
                                    <p class="comment_content--text">This blog
                                        perfectly captures the essence of Amman!
                                        I visited last year and absolutely loved
                                        exploring the Citadel and trying kunafa
                                        at Habibah Sweets. The mix of ancient
                                        history and modern charm is so unique.
                                        Rainbow Street was a highlight
                                        too\u2014the rooftop views and lively
                                        atmosphere were unforgettable.
                                        Can\u2019t wait to go back and visit
                                        more places like Wadi Mujib!</p>
                                    <a href="#"
                                        class="comment_content--replay">REPLY</a>
                                </div>
                            </div>
                            <div class="comment reply-comment">
                                <div class="comment_img">
                                    <img src="assets/images/comment(2).jpg"
                                        alt="#">
                                </div>
                                <div class="comment_content">
                                    <h4 class="comment_content--name">Noura
                                        Zahra</h4>
                                    <p class="comment_content--date">2 days
                                        ago</p>
                                    <p class="comment_content--text">Thank you
                                        for sharing your experience! The Citadel
                                        and Habibah Sweets are definitely
                                        must-visit spots in Amman. It\u2019s
                                        great to hear you enjoyed Rainbow Street
                                        too; it\u2019s such a vibrant area. If
                                        you loved Wadi Mujib, you might also
                                        enjoy exploring Jerash</p>
                                    <a href="#"
                                        class="comment_content--replay">REPLY</a>
                                </div>
                            </div>
                        </div>
                        <div class="comments_container--single">
                            <div class="comment main-comment">
                                <div class="comment_img">
                                    <img src="assets/images/comment(1).jpg"
                                        alt="#">
                                </div>
                                <div class="comment_content">
                                    <h4 class="comment_content--name">Amira
                                        Zahra</h4>
                                    <p class="comment_content--date">2 days
                                        ago</p>
                                    <p class="comment_content--text">This blog
                                        perfectly captures the essence of Amman!
                                        I visited last year and absolutely loved
                                        exploring the Citadel and trying kunafa
                                        at Habibah Sweets. The mix of ancient
                                        history and modern charm is so unique.
                                        Rainbow Street was a highlight
                                        too\u2014the rooftop views and lively
                                        atmosphere were unforgettable.
                                        Can\u2019t wait to go back and visit
                                        more places like Wadi Mujib!</p>
                                    <a href="#"
                                        class="comment_content--replay">REPLY</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form class="single-blog_thought">
                <h2 class="single-blog_thought--title">Leave your thought
                    here</h2>
                <textarea name="comment" id
                    placeholder="comment ..."></textarea>
                <a href="#" class="btn__red--l btn__red btn">submit</a>
            </form>
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