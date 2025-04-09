// Initialize Leaflet Map
const map = L.map('map').setView([31.9539, 35.9106], 12); // Amman, Jordan

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// Marker with drag option
const marker = L.marker([40.7128, -74.0060], { draggable: true }).addTo(map);

// Update coordinates display
function updateCoordinates({ lat, lng }) {
    const coordsElement = document.getElementById('coordinates');
    if (coordsElement) {
        coordsElement.innerText = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
    }
}

// On marker drag end
marker.on('dragend', (e) => {
    updateCoordinates(e.target.getLatLng());
});

// On map click, move marker
map.on('click', (e) => {
    marker.setLatLng(e.latlng);
    updateCoordinates(e.latlng);
});

// Handle Drag & Drop Upload Areas
document.querySelectorAll('.drop-area').forEach(setupDropArea);

function setupDropArea(dropArea) {
    const fileInput = dropArea.querySelector('.file-input');
    const fileList = dropArea.querySelector('.file-list');

    if (!fileInput || !fileList) return;

    const highlight = () => dropArea.classList.add('highlight');
    const unhighlight = () => dropArea.classList.remove('highlight');

    // Prevent default behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(event =>
        dropArea.addEventListener(event, preventDefaults, false)
    );

    // Highlight when dragging
    ['dragenter', 'dragover'].forEach(event =>
        dropArea.addEventListener(event, highlight, false)
    );

    // Unhighlight on leave or drop
    ['dragleave', 'drop'].forEach(event =>
        dropArea.addEventListener(event, unhighlight, false)
    );

    // Handle file drop
    dropArea.addEventListener('drop', (e) => {
        const files = e.dataTransfer.files;
        displayFiles(files, fileList);
    });

    // Handle file selection
    fileInput.addEventListener('change', (e) => {
        const files = e.target.files;
        displayFiles(files, fileList);
    });
}

// Prevent default drag/drop behavior
function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

// Display file list
function displayFiles(files, fileListElement) {
    fileListElement.innerHTML = '';
    [...files].forEach(file => {
        const p = document.createElement('p');
        p.textContent = file.name;
        fileListElement.appendChild(p);
    });
}
