<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

$error = '';
$blog = null;

// Get blog ID
$blog_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
if (!$blog_id) {
    die('No blog ID provided.');
}

// Fetch existing blog data
$stmt = $conn->prepare("SELECT * FROM blogs WHERE id = ?");
$stmt->bind_param("i", $blog_id);
$stmt->execute();
$result = $stmt->get_result();
$blog = $result->fetch_assoc();
$stmt->close();

if (!$blog) {
    die("Blog not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_title   = trim($_POST['title'] ?? '');
    $new_tags    = trim($_POST['tags'] ?? '');
    $new_content = trim($_POST['code'] ?? '');

    // Basic validation
    if (empty($new_title) || empty($new_content)) {
        $error = 'Title and content are required.';
    } else {
        // Normalize folder name
        function normalize($name) {
            return strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '_', $name)));
        }

        $old_title = $blog['title'];
        $old_image = $blog['image'];
        $new_folder = normalize($new_title);
        $base_path  = __DIR__ . "/assets/images/blogs";
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
            // Handle folder creation or renaming
            if ($old_title !== $new_title) {
                $old_folder = normalize($old_title);
                $old_dir = "$base_path/$old_folder";
                if (is_dir($old_dir)) {
                    if (!rename($old_dir, $new_dir)) {
                        $error = 'Failed to rename image directory.';
                    }
                } elseif (!mkdir($new_dir, 0755, true)) {
                    $error = 'Failed to create image directory.';
                }
            } elseif (!is_dir($new_dir)) {
                if (!mkdir($new_dir, 0755, true)) {
                    $error = 'Failed to create image directory.';
                }
            }

            // Handle image upload
            $final_image_path = $old_image;
            if (!$error && !empty($_FILES['image']['name'])) {
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

                if (!in_array($ext, $allowed)) {
                    $error = 'Invalid image format. Allowed types: jpg, jpeg, png, webp.';
                } elseif ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                    $error = 'Image upload error.';
                } else {
                    $image_name = uniqid('blog_', true) . ".$ext";
                    $dest_path = "$new_dir/$image_name";
                    $rel_path = "assets/images/blogs/$new_folder/$image_name";

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $dest_path)) {
                        // Delete old image file
                        if (!empty($old_image) && file_exists(__DIR__ . '/' . $old_image)) {
                            unlink(__DIR__ . '/' . $old_image);
                        }
                        $final_image_path = $rel_path;
                    } else {
                        $error = 'Failed to upload image.';
                    }
                }
            }

            // Update database
            if (!$error) {
                $upd = $conn->prepare("UPDATE blogs SET title = ?, image = ?, tags = ?, content = ? WHERE id = ?");
                $upd->bind_param("ssssi", $new_title, $final_image_path, $new_tags, $new_content, $blog_id);
                if ($upd->execute()) {
                    $upd->close();
                    header("Location: single-blog.php?id=" . $blog_id);
                    exit;
                } else {
                    $error = 'Failed to update blog.';
                    $upd->close();
                }
            }
        }
    }
}

include 'header.php';
?>

<main class="add_blog-container">
    <?php if ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="edit_blog.php?id=<?= $blog_id ?>" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="BLOG TITLE" required class="input"
               value="<?= htmlspecialchars($_POST['title'] ?? $blog['title']) ?>">

        <!-- Image preview container -->
        <div class="add_blog-img" id="image-container">
            <img id="preview-img" alt="Blog preview image"
                 style="<?= $blog['image'] ? 'display: block;' : 'display: none;' ?>"
                 <?= $blog['image'] ? 'src="' . htmlspecialchars($blog['image']) . '"' : '' ?>>
            <h2 id="no-image-text" style="<?= $blog['image'] ? 'display: none;' : 'display: block;' ?>">
                NO IMAGE WAS ADDED
            </h2>
            <a href="#" id="remove-image-btn" onclick="clearImage(); return false;"
               style="<?= $blog['image'] ? 'display: inline;' : 'display: none;' ?>">X</a>
        </div>

        <label class="custom-file-upload">
            <input type="file" id="image" name="image" class="img_input" accept="image/*" onchange="previewImage(event)">
            UPDATE BLOG IMAGE
        </label>

        <input type="text" name="tags" placeholder="BLOG TAGS (comma separated)" class="input"
               value="<?= htmlspecialchars($_POST['tags'] ?? $blog['tags']) ?>">

        <div class="add_blog-f">
            <h3>Format Your Blog Content Like This:</h3>
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
            <p><a href="https://www.w3schools.com/html/" target="_blank" class="comment_content--reply">New to HTML? Learn how to format your content here.</a></p>
        </div>

        <textarea id="code" name="code"><?= htmlspecialchars($_POST['code'] ?? $blog['content']) ?></textarea>

        <button class="btn__red--l btn__red btn">SAVE CHANGES</button>
    </form>
</main>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById('preview-img');
        img.src = e.target.result;
        img.style.display = 'block';
        document.getElementById('no-image-text').style.display = 'none';
        document.getElementById('remove-image-btn').style.display = 'inline';
    };
    reader.readAsDataURL(file);
}

function clearImage() {
    document.getElementById('image').value = '';
    const img = document.getElementById('preview-img');
    img.src = '';
    img.style.display = 'none';
    document.getElementById('no-image-text').style.display = 'block';
    document.getElementById('remove-image-btn').style.display = 'none';
}

// Initialize CodeMirror
const editor = CodeMirror.fromTextArea(document.getElementById('code'), {
    lineNumbers: true,
    mode: 'htmlmixed',
    theme: '3024-day',
    tabSize: 2
});
</script>

<?php include 'footer.php'; ?>