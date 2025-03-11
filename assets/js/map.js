let map = L.map('map').setView([31.9539, 35.9106], 12); // Amman, Jordan

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

let marker = L.marker([40.7128, -74.0060], { draggable: true }).addTo(map);

function updateCoordinates(lat, lng) {
    document.getElementById('coordinates').innerText = lat.toFixed(6) + ", " + lng.toFixed(6);
}

marker.on('dragend', function (e) {
    updateCoordinates(e.target.getLatLng().lat, e.target.getLatLng().lng);
});

map.on('click', function (e) {
    marker.setLatLng(e.latlng);
    updateCoordinates(e.latlng.lat, e.latlng.lng);
});


document.querySelectorAll('.drop-area').forEach(dropArea => {
    const fileInput = dropArea.querySelector('.file-input');
    const fileList = dropArea.querySelector('.file-list');

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Highlight drop area when file is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.add('highlight'), false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.remove('highlight'), false);
    });

    // Handle dropped files
    dropArea.addEventListener('drop', (e) => {
        let files = e.dataTransfer.files;
        handleFiles(files);
        console.log(files)
    });

    // Handle file input selection
    fileInput.addEventListener('change', (e) => {
        let files = e.target.files;
        handleFiles(files);
    });

    // Function to handle files
    function handleFiles(files) {
        fileList.innerHTML = "";
        [...files].forEach(file => {
            let listItem = document.createElement('p');
            listItem.textContent = file.name;
            fileList.appendChild(listItem);
        });
    }
});
