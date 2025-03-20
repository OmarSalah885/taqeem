<?php
include 'header.php';  // Ensure the database connection is established in header.php
include 'navbar.php';

// Get category_id from the URL
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;

// If category_id is set, fetch places for that category from the database
$places = [];
if ($category_id > 0) {
    // Query to get the places for the selected category
    $sql = "SELECT * FROM places WHERE category_id = ?";
    $stmt = $conn->prepare($sql);  // Use the $conn variable already available from header.php
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the places and store them in an array
    while ($row = $result->fetch_assoc()) {
        $places[] = $row;
    }
}
?>

<main>
    <div class="listing">
        <div class="pageinfo">
            <div class="pageinfo_content">
                <h2><?php echo getCategoryName($category_id); ?></h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a><span>/</span></li>
                    <li class="breadcrumb-item active"><a href="listing.php">Category</a></li>
                </ol>
            </div>
        </div>

        <!-- Display Places -->
        <div class="listing_grid">
            <?php foreach ($places as $place): ?>
            <div class="listing_grid--item">
                <div class="listing_grid--item-img">
                    <a href="single-place.php?id=<?php echo $place['id']; ?>" class="listing_grid--item-img_img">
                        <img src="assets/images/<?php echo $place['featured_image']; ?>" alt="<?php echo $place['name']; ?>">
                    </a>
                    <a href="listing.php" class="listing_grid--item-img_category"><i class="fa-solid fa-utensils"></i></a>
                    <a href="#" class="listing_grid--item-img_save"><i class="fa-solid fa-bookmark"></i></a>
                </div>
                <div class="listing_grid--item-content">
                    <div class="listing_grid--item-content_tages">
                        <a href="#"><?php echo $place['city']; ?></a>
                        <a href="#"><?php echo getCategoryName($place['category_id']); ?></a>
                    </div>
                    <a class="listing_grid--item-content_name" href="single-place.php?id=<?php echo $place['id']; ?>">
                        <?php echo $place['name']; ?>
                    </a>
                    <a href="#" class="listing_grid--item-content_location">
                        <i class="fa-solid fa-location-dot"></i> <?php echo $place['google_map_location']; ?>
                    </a>
                    <div class="listing_grid--item-content_stars">
                        <div class="listing_grid--item-content_stars-stars">
                            <!-- Assuming a star rating system is in place -->
                            <?php 
                            // Example rating (in case you have a 'rating' column or calculation for it)
                            $rating = 4;  // Placeholder, replace it with actual data if available
                            for ($i = 0; $i < $rating; $i++): ?>
                                <i class="fa-solid fa-star"></i>
                            <?php endfor; ?>
                        </div>
                        <h4 class="listing_grid--item-content_stars-price"><?php echo $place['price']; ?></h4>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php
include 'footer.php';

// Function to get category name from category_id
function getCategoryName($category_id) {
    // Fetch category names from the database
    global $conn;
    $sql = "SELECT name FROM categories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();
    
    return $category ? $category['name'] : 'Unknown Category';
}
?>
