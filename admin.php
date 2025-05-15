<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

include 'header.php';
?>
<main class="profile admin_main">
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
            <a class="profile_sidebar--edit-btn" href="#"><i class="fa-solid fa-pen"></i>Edit profile</a>
            <a class="profile_sidebar--edit-btn" href="#"><i class="fa-solid fa-user"></i>Add photo</a>
        </div>
        <a href="#" class="btn__transparent--l btn__transparent btn">LOGOUT</a>
    </div>
    <div class="profile_main">
        <div class="profile_main_collection">
            <h2 class="profile_title">MY COLLECTIONS</h2>
            <div class="admin_container">
                <div class="admin_card admin_users">
                    <h1>USERS <span>3000</span></h1>
                    <a href="">view all users</a>
                </div>
                <div class="admin_card admin_places">
                    <h1>PLACES <span>3000</span></h1>
                    <a href="">view all places</a>
                </div>
                <div class="admin_card admin_reviews">
                    <h1>REVIEWS <span>3000</span></h1>
                    <a href="">view all reviews</a>
                </div>
                <div class="admin_card admin_blogs">
                    <h1>BLOGS <span>3000</span></h1>
                    <a href="">view all blogs</a>
                </div>

            </div>
        </div>
    </div>
    </div>
    </div>
</main>
<?php include 'footer.php'; ?>