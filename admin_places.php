<?php
require_once 'config.php';
require_once 'db_connect.php';
session_start();

include 'header.php';
?>
<main>
    <h1>Places Management</h1>

    <div class="search-container">
        <input type="text" id="placeSearch" placeholder="Search by name, tags, country, or city...">
        <button>Search</button>
    </div>

    <div class="table-container">
        <table id="placeTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Featured Image</th>
                    <th>Place Name</th>
                    <th>Tags</th>
                    <th>Description</th>
                    <th>Country</th>
                    <th>City</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#001</td>
                    <td><img src="https://media.istockphoto.com/id/1370772148/photo/track-and-mountains-in-valle-del-lago-somiedo-nature-park-asturias-spain.jpg?s=612x612&w=0&k=20&c=QJn62amhOddkJSbihcjWKHXShMAfcKM0hPN65aCloco="
                            alt="Place 1"></td>
                    <td>Cozy Café</td>
                    <td>Coffee, Quiet, WiFi</td>
                    <td>A small peaceful café great for remote work.</td>
                    <td>USA</td>
                    <td>New York</td>
                    <td>contact@cozycafe.com</td>
                    <td>2024-12-01</td>
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