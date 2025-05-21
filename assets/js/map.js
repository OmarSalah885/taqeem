let map;
let marker;

function initMap(lat = 31.9539, lng = 35.9106) {
    map = L.map('map').setView([lat, lng], 12); // Default to Amman, Jordan

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    marker = L.marker([lat, lng], { draggable: true }).addTo(map);

    updateCoordinates(lat, lng);

    marker.on('dragend', function (e) {
        const latlng = e.target.getLatLng();
        updateCoordinates(latlng.lat, latlng.lng);
        reverseGeocode(latlng.lat, latlng.lng);
        updateGoogleMapsLink(latlng.lat, latlng.lng);
    });

    map.on('click', function (e) {
        marker.setLatLng(e.latlng);
        updateCoordinates(e.latlng.lat, e.latlng.lng);
        reverseGeocode(e.latlng.lat, e.latlng.lng);
        updateGoogleMapsLink(e.latlng.lat, e.latlng.lng);
    });
}

function updateCoordinates(lat, lng) {
    const coordsSpan = document.getElementById('coordinates');
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    
    if (coordsSpan) {
        coordsSpan.innerText = lat.toFixed(6) + ", " + lng.toFixed(6);
    } else {
        console.warn('Coordinates span not found');
    }
    if (latInput) {
        latInput.value = lat.toFixed(6);
    } else {
        console.warn('Latitude input not found');
    }
    if (lngInput) {
        lngInput.value = lng.toFixed(6);
    } else {
        console.warn('Longitude input not found');
    }
}

function updateGoogleMapsLink(lat, lng) {
    const linkInput = document.getElementById('google_map_location');
    const link = `https://www.google.com/maps?q=${lat},${lng}`;
    if (linkInput) {
        linkInput.value = link;
        console.log('Google Maps link set to:', link);
    } else {
        console.warn('Google map location input not found');
    }
}

async function reverseGeocode(lat, lng) {
    const countryInput = document.getElementById('country');
    const cityInput = document.getElementById('city');
    const addressInput = document.getElementById('address');
    const addressDisplay = document.getElementById('address-display');
    const isDebug = true; // Set to false in production

    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json&zoom=18`, {
            headers: {
                'User-Agent': 'YourAppName/1.0 (your.email@example.com)'
            }
        });
        const data = await response.json();
        if (isDebug) {
            console.log('Nominatim response:', data);
        }

        if (data && data.address) {
            if (countryInput) {
                countryInput.value = data.address.country || '';
            } else {
                console.warn('Country input not found');
            }
            if (cityInput) {
                cityInput.value = data.address.city || data.address.town || data.address.village || '';
            } else {
                console.warn('City input not found');
            }

            // Construct a detailed address in the desired format
            const addressParts = [];
            let placeName = '';
            let placeType = '';

            // Define place types
            const placeTypes = {
                'amenity': {
                    'restaurant': 'Restaurant',
                    'cafe': 'Cafe',
                    'place_of_worship': data.address.religion === 'muslim' ? 'Mosque' : 'Place of Worship',
                    'school': 'School',
                    'hospital': 'Hospital'
                },
                'tourism': {
                    'hotel': 'Hotel',
                    'museum': 'Museum'
                },
                'shop': {
                    'default': 'Shop'
                },
                'default': ''
            };

            // Determine place type
            if (data.category && placeTypes[data.category]) {
                if (typeof placeTypes[data.category] === 'object') {
                    placeType = placeTypes[data.category][data.type] || placeTypes[data.category].default || '';
                } else {
                    placeType = placeTypes[data.category];
                }
            }

            // Get place name (e.g., hotel, restaurant, or fallback to name)
            if (data.address.hotel || data.address.restaurant || data.address.shop || data.address.amenity) {
                placeName = data.address.hotel || data.address.restaurant || data.address.shop || data.address.amenity || data.name || '';
                if (placeType && placeName) {
                    placeName = `${placeName} (${placeType})`;
                } else if (!placeType) {
                    placeName = data.name || '';
                }
            } else if (data.name) {
                placeName = data.name;
            }

            // Build address parts
            if (placeName) {
                addressParts.push(placeName);
            }
            if (data.address.house_number) {
                addressParts.push(`Building ${data.address.house_number}`);
            }
            if (data.address.road) {
                addressParts.push(data.address.road);
            }
            if (data.address.neighbourhood) {
                addressParts.push(data.address.neighbourhood);
            }
            if (data.address.suburb || data.address.quarter) {
                addressParts.push(data.address.suburb || data.address.quarter);
            }

            // Join parts with commas, fallback to display_name if empty
            const shortAddress = addressParts.length > 0 ? addressParts.join(', ') : data.display_name || '';

            // Update hidden address input and display
            if (addressInput) {
                addressInput.value = shortAddress.slice(0, 100); // Ensure max length of 100
            } else {
                console.warn('Address input not found');
            }
            if (addressDisplay) {
                addressDisplay.innerText = shortAddress.slice(0, 100); // Ensure max length of 100
            } else {
                console.warn('Address display span not found');
            }
        } else {
            console.warn('No address data returned');
            if (countryInput) countryInput.value = '';
            if (cityInput) cityInput.value = '';
            if (addressInput) addressInput.value = '';
            if (addressDisplay) addressDisplay.innerText = '';
        }
    } catch (error) {
        console.error('Geocoding error:', error);
        if (countryInput) countryInput.value = '';
        if (cityInput) cityInput.value = '';
        if (addressInput) addressInput.value = '';
        if (addressDisplay) addressDisplay.innerText = '';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const mapDiv = document.getElementById('map');
    if (mapDiv) {
        // Delay initMap to ensure DOM is fully loaded
        setTimeout(() => {
            initMap();
        }, 100);
    } else {
        console.error('Map div not found');
    }
});