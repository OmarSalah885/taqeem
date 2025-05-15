<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

include 'header.php';
?>
<main class="admin_main">
    <h1>Reviews Management</h1>

    <div class="search-container">
        <input type="text" id="reviewSearch" placeholder="Search by user or place name...">
        <button>Search</button>
    </div>

    <div class="table-container">
        <table id="reviewTable">
            <thead>
                <tr>
                    <th>Review ID</th>
                    <th>User Image</th>
                    <th>User Name</th>
                    <th>Place Name</th>
                    <th>Rating</th>
                    <th>Review Text</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>001</td>
                    <td><img src="https://people.com/thmb/gzHtG_UnZBsUuHVJx9xjB5yAfIQ=/4000x0/filters:no_upscale():max_bytes(150000):strip_icc():focal(399x0:401x2)/people-headshot-nick-maslow-f21ef38676504bc89a091ec9a5c95e4b.jpg"
                            alt="User 1"></td>
                    <td>Abd Ulrhman</td>
                    <td>Cozy Café</td>
                    <td>4</td>
                    <td>Great atmosphere and friendly staff!</td>
                    <td>2024-12-02</td>
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