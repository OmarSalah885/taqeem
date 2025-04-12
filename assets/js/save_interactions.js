function toggleSave(event, placeId) {
    event.preventDefault();

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "toggle_save.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        const icon = event.target.tagName === "I" ? event.target : event.target.querySelector("i");
                        icon.className = response.is_saved ? "fa-solid fa-bookmark" : "fa-regular fa-bookmark";
                    } else {
                        alert(response.message);
                    }
                } catch (e) {
                    console.error("Invalid JSON response:", xhr.responseText);
                    alert("An error occurred. Please try again.");
                }
            } else {
                console.error("AJAX request failed:", xhr.status, xhr.statusText);
                alert("An error occurred. Please try again.");
            }
        }
    };

    xhr.send("place_id=" + placeId);
}