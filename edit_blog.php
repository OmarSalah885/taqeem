<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

$success = '';
$error = '';
$blog = null;

// 1) Get blog ID
$blog_id = $_GET['id'] ?? null;
if (!$blog_id) {
    die('No blog ID provided.');
}

// 2) Fetch existing blog data
$stmt = $conn->prepare("SELECT * FROM blogs WHERE id = ?");
$stmt->bind_param("i", $blog_id);
$stmt->execute();
$result = $stmt->get_result();
$blog = $result->fetch_assoc();
$stmt->close();

if (!$blog) {
    die("Blog not found.");
}

// 3) Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_title   = trim($_POST['title'] ?? '');
    $new_tags    = trim($_POST['tags'] ?? '');
    $new_content = trim($_POST['code'] ?? '');

    // Basic validation
    if ($new_title === '' || $new_content === '') {
        $error = 'Title and content are required.';
    } else {
        // Normalize helper
        function normalize($name) {
            return strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '_', $name)));
        }

        $old_title = $blog['title'];
        $old_image = $blog['image'];

        $old_folder = normalize($old_title);
        $new_folder = normalize($new_title);
        $base_path  = __DIR__ . "/assets/images/blogs";
        $old_dir    = "$base_path/$old_folder";
        $new_dir    = "$base_path/$new_folder";

        // Prevent duplicate titles
        $dup = $conn->prepare("SELECT id FROM blogs WHERE title = ? AND id != ?");
        $dup->bind_param("si", $new_title, $blog_id);
        $dup->execute();
        $dup->store_result();
        if ($dup->num_rows > 0) {
            $error = 'Another blog with this title already exists.';
        }
        $dup->close();

        if (!$error) {
            // 4) Rename or create folder
            if ($old_folder !== $new_folder) {
                if (is_dir($old_dir)) {
                    rename($old_dir, $new_dir);
                } else {
                    mkdir($new_dir, 0755, true);
                }
            }
            // If title unchanged, still ensure folder exists
            if (!is_dir($new_dir)) {
                mkdir($new_dir, 0755, true);
            }

            // 5) Handle image upload
            $final_image_path = $old_image;
            if (!empty($_FILES['image']['name'])) {
                $allowed = ['jpg','jpeg','png','webp'];
                $ext     = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

                if (in_array($ext, $allowed)) {
                    $image_name = uniqid('blog_', true) . ".$ext";
                    $dest_path  = "$new_dir/$image_name";
                    $rel_path   = "assets/images/blogs/$new_folder/$image_name";

                    // Move uploaded file
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $dest_path)) {
                        // Delete old image file
                        if (!empty($old_image)) {
                            $old_file = __DIR__ . '/' . $old_image;
                            if (file_exists($old_file)) {
                                unlink($old_file);
                            }
                        }
                        $final_image_path = $rel_path;
                    } else {
                        $error = "Failed to upload image.";
                    }
                } else {
                    $error = "Invalid image format.";
                }
            }

            // 6) Update database
            if (!$error) {
                $upd = $conn->prepare("
                    UPDATE blogs
                       SET title   = ?,
                           image   = ?,
                           tags    = ?,
                           content = ?
                     WHERE id = ?
                ");
                $upd->bind_param("ssssi", $new_title, $final_image_path, $new_tags, $new_content, $blog_id);
                if ($upd->execute()) {
                    $success = "Blog updated successfully.";
                    // Refresh $blog data for display
                    $blog['title']   = $new_title;
                    $blog['image']   = $final_image_path;
                    $blog['tags']    = $new_tags;
                    $blog['content'] = $new_content;
                } else {
                    $error = "Failed to update blog.";
                }
                $upd->close();
            }
        }
    }
}

include 'header.php';
?>

<main class="add_blog-container">
    <?php if ($success): ?>
        <div class="success-message"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="edit_blog.php?id=<?= $blog['id'] ?>" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="BLOG TITLE" required class="input"
               value="<?= htmlspecialchars($blog['title']) ?>">

        <!-- Image preview container -->
        <div class="add_blog-img" id="image-container">
            <img id="preview-img"
                 src="<?= htmlspecialchars($blog['image'] ?: '') ?>"
                 alt="">
            <h2 id="no-image-text"
                <?= $blog['image'] ? 'style="display:none;"' : '' ?>>
                NO IMAGE WAS ADDED
            </h2>
            <a href="#" id="remove-image-btn"
               onclick="clearImage();return false;"
               style="<?= $blog['image'] ? '' : 'display:none;' ?>">
                X
            </a>
        </div>

        <label class="custom-file-upload">
            <input type="file" id="image" name="image" class="img_input" accept="image/*" onchange="previewImage(event)">
            UPDATE BLOG IMAGE
        </label>

        <input type="text"
               name="tags"
               placeholder="BLOG TAGS"
               class="input"
               value="<?= htmlspecialchars($blog['tags']) ?>">

        <div class="add_blog-f">
            <h3>Please write your blog code in this format:</h3>
            <p>
                &lt;div class="single-blog_content--paragraph"&gt;<br>
                &nbsp;&nbsp;&lt;h2&gt;Title of Section&lt;/h2&gt;<br>
                &nbsp;&nbsp;&lt;p&gt;Your paragraph content goes here.&lt;/p&gt;<br>
                &nbsp;&nbsp;&lt;a href="#"&gt;&lt;h2&gt;your link goes here&lt;/h2&gt;&lt;/a&gt;<br>
                &lt;/div&gt;
            </p>
            <br>
            <p>
                &lt;div class="single-blog_content--paragraph"&gt;<br>
                &nbsp;&nbsp;&lt;h2&gt;Section Title&lt;/h2&gt;<br>
                &nbsp;&nbsp;&lt;p&gt;Your content here...&lt;/p&gt;<br>
                &nbsp;&nbsp;&lt;ul&gt;<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&lt;li&gt;List item 1&lt;/li&gt;<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&lt;li&gt;List item 2&lt;/li&gt;<br>
                &nbsp;&nbsp;&lt;/ul&gt;<br>
                &lt;/div&gt;
            </p>
        </div>

        <textarea id="code" name="code"><?= htmlspecialchars($blog['content']) ?></textarea>

        <button class="btn__red--l btn__red btn">SAVE CHANGES</button>
    </form>
</main>

<script>
    // CodeMirror init
    CodeMirror.fromTextArea(
      document.getElementById("code"),
      { lineNumbers: true, mode: "htmlmixed", theme: "3024-day", tabSize: 2 }
    );

    // Preview new image
    function previewImage(event) {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('no-image-text').style.display = 'none';
            document.getElementById('remove-image-btn').style.display = 'inline';
        };
        reader.readAsDataURL(file);
    }

    // Clear image selection
    function clearImage() {
        document.getElementById('image').value = '';
        document.getElementById('preview-img').src = '';
        document.getElementById('no-image-text').style.display = 'block';
        document.getElementById('remove-image-btn').style.display = 'none';
    }
</script>

<?php include 'footer.php'; ?>
