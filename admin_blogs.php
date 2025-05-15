<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

include 'header.php';
?>
<main class="admin_main">
    <h1>Blog Management</h1>

    <div class="search-container">
        <input type="text" id="blogSearch" placeholder="Search by title or tag...">
        <button>Search</button>
    </div>

    <div class="table-container">
        <a href="" class="btn__red--l btn__red btn">ADD BLOG</a>
        <table id="blogTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Tags</th>
                    <th>Content</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>001</td>
                    <td><img src="https://letsenhance.io/static/73136da51c245e80edc6ccfe44888a99/1015f/MainBefore.jpg"
                            alt="Blog 1"></td>
                    <td>Discovering the Best Coffee Shops</td>
                    <td>coffee, travel</td>
                    <td>Explore the coziest cafes in town with great ambiance and coffee...</td>
                    <td>2024-12-10</td>
                    <td class="actions">
                        <button class="btn-edit">Edit</button>
                        <button class="btn-delete">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</main>
<?php include 'footer.php'; ?>