<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

include 'header.php';
?>
<main class="users">
    <h1>User Management</h1>

    <div class="search-container">
        <input type="text" id="userSearch" placeholder="Search by name, email, or ID...">
        <button>Search</button>
    </div>

    <div class="table-container">
        <table id="userTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>About Me</th>
                    <th>Location</th>
                    <th>Role</th>
                    <th>Account Created</th>
                    <th>Visibility</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><img src="https://i.pravatar.cc/50?img=3" alt="User Image"></td>
                    <td>Abd</td>
                    <td>Ulrhman</td>
                    <td>abdul@example.com</td>
                    <td>Male</td>
                    <td>I enjoy exploring tech and reviewing places.</td>
                    <td>Amman, Jordan</td>
                    <td>Guest</td>
                    <td>2025-03-10</td>
                    <td><span class="badge public">Public</span></td>
                    <td class="actions">
                        <button class="btn-edit">Edit</button>
                        <button class="btn-delete">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td><img src="https://i.pravatar.cc/50?img=5" alt="User Image"></td>
                    <td>Sara</td>
                    <td>Yousef</td>
                    <td>sara@example.com</td>
                    <td>Female</td>
                    <td>Love cafés and travel blogging.</td>
                    <td>Riyadh, Saudi Arabia</td>
                    <td>Owner</td>
                    <td>2025-03-15</td>
                    <td><span class="badge private">Private</span></td>
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