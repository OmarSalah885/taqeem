<?php
include 'header.php';  // Ensure the database connection is established in header.php

// Get category_id from the URL
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Fetch places based on category or search
$places = [];

if (!empty($search)) {
    // Search by tag using LIKE instead of FIND_IN_SET
    $sql = "SELECT * FROM places WHERE tags LIKE ?";
    $searchPattern = "%$search%"; // Match any occurrence of the tag
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $searchPattern);
} elseif ($category_id > 0) {
    // Fetch places by category
    $sql = "SELECT * FROM places WHERE category_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
}

if (isset($stmt)) {
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $places[] = $row;
    }
}
?>

<main>
    <div class="listing">
        <div class="pageinfo">
            <div class="pageinfo_content">
                <h2>
                    <?php
                    $category_icon = ''; // Default empty icon

                    if (!empty($search)) {
                        echo "Search Results for: " . htmlspecialchars($search);
                    } elseif ($category_id > 0) {
                        // Fetch category name and icon from database
                        $sql = "SELECT name, icon FROM categories WHERE id = ?"; // Use 'icon' column
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $category_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $category = $result->fetch_assoc();

                        if ($category) {
                            echo htmlspecialchars($category['name']);
                            $category_icon = $category['icon']; // Assign icon from database
                        } else {
                            echo "Unknown Category";
                        }
                    } else {
                        echo "All Listings";
                    }
                    ?>
                </h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a><span>/</span></li>
                    <li class="breadcrumb-item active"><a href="listing.php">Category</a></li>
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
        <!-- Display Places -->
        <div class="listing_grid">
            <?php foreach ($places as $place): ?>
            <?php
            // Fetch category icon dynamically for each place based on category_id
            $category_icon = '';
            $category_sql = "SELECT icon FROM categories WHERE id = ?";
            $category_stmt = $conn->prepare($category_sql);
            $category_stmt->bind_param("i", $place['category_id']);
            $category_stmt->execute();
            $category_result = $category_stmt->get_result();
            $category_data = $category_result->fetch_assoc();
            if ($category_data) {
                $category_icon = $category_data['icon']; // Get the icon for each place's category
            }
            ?>

            <div class="listing_grid--item">
                <div class="listing_grid--item-img">
                    <a href="single-place.php?id=<?php echo $place['id']; ?>" class="listing_grid--item-img_img">
                        <img src="<?php echo $place['featured_image']; ?>" alt="<?php echo $place['name']; ?>">
                    </a>
                    <a href="listing.php?category_id=<?php echo $place['category_id']; ?>"
                        class="listing_grid--item-img_category">
                        <i class="<?php echo htmlspecialchars($category_icon); ?>"></i> <!-- Dynamic Icon -->
                    </a>
                    <a href="#" class="listing_grid--item-img_save"><i class="fa-solid fa-bookmark"></i></a>
                </div>
                <div class="listing_grid--item-content">
                    <div class="listing_grid--item-content_tages">
                        <?php 
                        $tags = explode(',', $place['tags']);
                        foreach ($tags as $tag): ?>
                        <a href="listing.php?search=<?php echo urlencode(trim($tag)); ?>">
                            <?php echo htmlspecialchars(trim($tag)); ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <a class="listing_grid--item-content_name" href="single-place.php?id=<?php echo $place['id']; ?>">
                        <?php echo $place['name']; ?>
                    </a>
                    <a href="#" class="listing_grid--item-content_location">
                        <i class="fa-solid fa-location-dot"></i> <?php echo $place['google_map_location']; ?>
                    </a>
                    <div class="listing_grid--item-content_stars">
                        <div class="listing_grid--item-content_stars-stars">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <h4 class="listing_grid--item-content_stars-price"><?php echo $place['price']; ?></h4>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="listing_indicator">
            <div class="listing_indicator">
                <li class="indicator_item"><a href="#"><i class="fa-solid fa-chevron-left"></i></a></li>
                <li class="indicator_item"><a href>1</a></li>
                <li class="indicator_item active"><a href>2</a></li>
            </div>
        </div>
    </div>

</main>

<?php
include 'footer.php';
?>