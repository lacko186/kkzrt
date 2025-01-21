<?php
session_start();
require_once 'config.php';

// Debug információ
error_log("Session tartalma: " . print_r($_SESSION, true));

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['user_id'])) {
    error_log("Nincs bejelentkezve, átirányítás a login.php-ra");
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaposvár Intelligens Közlekedés</title>

    <!-- Advanced styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" rel="stylesheet">
    <link href ="header.css" rel="stylesheet">
    <link href ="footer.css" rel="stylesheet"> 
     
    <!-- Google Maps API -->
    <script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArXtWdllsylygVw5t_k-22sXUJn-jMU8k&libraries=places&callback=initMap&loading=async">
    </script>

    <style>
        :root {
            --primary-color:linear-gradient(to right, #211717,#b30000);
            --accent-color: #7A7474;
            --text-light: #fbfbfb;
            --background-light: #f8f9fa;
            --transition: all 0.3s ease;
        }

        body{
            background: #e8e8e8;
        }
      
        /* Custom map and UI enhancements */
        #map {
            height: 650px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }
        .transit-mode-btn {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .transit-mode-btn.active {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        #route{
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-weight: bolder;
            font-style: italic;
            color: blue;
        }
        button {
            /* Variables */
            --button_radius: 0.75em;
            --button_color: #e8e8e8;
            --button_outline_color: #000000;
            font-size: 17px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            border-radius: var(--button_radius);
            background: var(--button_outline_color);
        }

        .button_top {
            display: block;
            box-sizing: border-box;
            border: 2px solid var(--button_outline_color);
            border-radius: var(--button_radius);
            padding: 0.75em 1.5em;
            background: var(--button_color);
            color: var(--button_outline_color);
            transform: translateY(-0.2em);
            transition: transform 0.1s ease;
        }

        button:hover .button_top {
            /* Pull the button upwards when hovered */
            transform: translateY(-0.33em);
        }

        button:active .button_top {
            /* Push the button downwards when pressed */
            transform: translateY(0);
        }

    </style>
</head>
    <div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-2xl rounded-3xl p-8">
    <h1 class="text-4xl font-bold text-center text-red-700 mb-8">
        <i class="fas fa-map-marked-alt mr-3"></i>Megálló Keresés
    </h1>

 <!-- Keresési szekció -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div>
        <label class="block text-gray-700 mb-2">Megálló keresése név alapján</label>
        <div class="relative">
            <i class="fas fa-bus-simple absolute left-4 top-4 text-blue-500"></i>
            <input
                id="stop-search"
                type="text"
                placeholder="pl. Kaposvár"
                class="w-full pl-12 pr-4 py-3 border-2 rounded-lg focus:ring-2 focus:ring-blue-500"
            >
        </div>
    </div>
    <div>
        <div class="relative">
          
        </div>
    </div>
</div>
<!-- Keresési gomb -->
<button id="search-button" class="w-full bg-red-600 text-white py-3 rounded-lg hover:bg-blue-700 transition mb-6">
    <i class="fas fa-search mr-2"></i>Keresés
</button>

    <!-- Map and Route Details Container -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            <div id="map" class="w-full rounded-2xl"></div>
        </div>

        <div class="md:col-span-1">
    <div id="route-info" class="bg-white rounded-2xl p-4 shadow-lg">
        <!-- Search results will appear here -->
    </div>
</div>

<a href="index.php"><button>
  <span style="font-weight:bold" class="button_top">Útvonaltervezés ➤</span>
</button>
</a>



    <script>
// Global variables
let map;
let markers = [];
let infoWindows = [];

// Make search functions global
window.searchByStopName = searchByStopName;
window.searchByRouteNumber = searchByRouteNumber;
window.focusStop = focusStop;

// Initialize map
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 46.359636, lng: 17.796839 }, // Kaposvár coordinates
        zoom: 13,
        styles: [
            {
                featureType: "transit.station",
                elementType: "all",
                stylers: [{ visibility: "on" }]
            }
        ]
    });

    // Initialize search functionality
    initializeSearch();
    
    // Test GTFS data access
    testGTFSDataAccess();
}

// Initialize search functionality
function initializeSearch() {
    const searchButton = document.getElementById('search-button');
    const stopSearch = document.getElementById('stop-search');
    const routeSearch = document.getElementById('route-search');

    if (searchButton) {
        searchButton.addEventListener('click', () => {
            const stopValue = stopSearch?.value.trim();
            const routeValue = routeSearch?.value.trim();
            
            if (stopValue) {
                searchByStopName(stopValue);
            } else if (routeValue) {
                searchByRouteNumber(routeValue);
            }
        });
    }

    // Add enter key listener to search inputs
    [stopSearch, routeSearch].forEach(input => {
        if (input) {
            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    searchButton?.click();
                }
            });
        }
    });
}

// Test GTFS data access
async function testGTFSDataAccess() {
    try {
        const response = await fetch('gtfs_data.json');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        console.log('GTFS Data loaded successfully:', {
            hasStops: Array.isArray(data['stops.txt']),
            stopsCount: data['stops.txt']?.length,
            hasStopTimes: Array.isArray(data['stop_times.txt']),
            hasTrips: Array.isArray(data['trips.txt'])
        });
    } catch (error) {
        console.error('Error testing GTFS data access:', error);
    }
}

// Search by stop name
async function searchByStopName(searchTerm) {
    try {
        const response = await fetch('gtfs_data.json');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        
        console.log('Searching for stop:', searchTerm);
        
        clearMapMarkers();

        const stops = data['stops.txt'];
        if (!stops) {
            throw new Error('Stops data is not available');
        }

        const searchTermLower = searchTerm.toLowerCase().trim();
        const matchingStops = stops.filter(stop => 
            stop && 
            stop.stop_name && 
            stop.stop_name.toLowerCase().includes(searchTermLower)
        );

        console.log('Found matching stops:', matchingStops.length);

        if (matchingStops.length > 0) {
            displayStopResults(matchingStops, data['stop_times.txt'], data['trips.txt']);
        } else {
            updateInfoPanel('Nem található megálló ezzel a névvel.');
        }
    } catch (error) {
        console.error('Error searching stops:', error);
        updateInfoPanel('Hiba történt a keresés során: ' + error.message);
    }
}

// Search by route number
async function searchByRouteNumber(routeNumber) {
    try {
        const response = await fetch('gtfs_data.json');
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        
        console.log('Searching for route:', routeNumber);
        
        clearMapMarkers();

        const routes = data['routes.txt'];
        if (!routes) {
            throw new Error('Routes data is not available');
        }

        const matchingRoute = routes.find(route => 
            route.route_id.toString() === routeNumber.toString()
        );

        if (!matchingRoute) {
            updateInfoPanel('Nem található járat ezzel a számmal.');
            return;
        }

        const trips = data['trips.txt'];
        const matchingTrips = trips.filter(trip => 
            trip.route_id.toString() === matchingRoute.route_id.toString()
        );

        if (matchingTrips.length > 0) {
            const stopTimes = data['stop_times.txt'];
            const tripIds = matchingTrips.map(trip => trip.trip_id);
            
            const relevantStopTimes = stopTimes.filter(st => 
                tripIds.includes(st.trip_id)
            );

            const stopIds = [...new Set(relevantStopTimes.map(st => st.stop_id))];
            const stops = data['stops.txt'];
            const routeStops = stops.filter(stop => 
                stopIds.includes(stop.stop_id)
            );

            if (routeStops.length > 0) {
                displayStopResults(routeStops, relevantStopTimes, matchingTrips);
            } else {
                updateInfoPanel('Nem található megálló ehhez a járatszámhoz.');
            }
        } else {
            updateInfoPanel('Nem található menetrendi információ ehhez a járathoz.');
        }
    } catch (error) {
        console.error('Error searching routes:', error);
        updateInfoPanel('Hiba történt a keresés során: ' + error.message);
    }
}

// Display results on map
function displayStopResults(stops, stopTimes, trips) {
    const bounds = new google.maps.LatLngBounds();
    let markersAdded = 0;

    stops.forEach(stop => {
        if (!stop.stop_lat || !stop.stop_lon) {
            console.warn('Invalid coordinates for stop:', stop);
            return;
        }

        const position = {
            lat: parseFloat(stop.stop_lat),
            lng: parseFloat(stop.stop_lon)
        };

        if (isNaN(position.lat) || isNaN(position.lng)) {
            console.warn('Invalid coordinates after parsing:', stop);
            return;
        }

        bounds.extend(position);
        markersAdded++;

        const marker = new google.maps.Marker({
            position: position,
            map: map,
            title: stop.stop_name,
            icon: {
                url: 'https://maps.gstatic.com/mapfiles/ms2/micons/pink-dot.png',
                scaledSize: new google.maps.Size(35, 35)
            }
        });

        let stopArrivals = [];
        if (stopTimes && trips) {
            stopArrivals = stopTimes
                .filter(st => st.stop_id === stop.stop_id)
                .map(st => {
                    const trip = trips.find(t => t.trip_id === st.trip_id);
                    return {
                        time: st.arrival_time,
                        headsign: trip ? trip.trip_headsign : null
                    };
                })
                .sort((a, b) => a.time.localeCompare(b.time))
                .slice(0, 5);
        }

        const infoWindow = new google.maps.InfoWindow({
            content: `
                <div class="p-4">
                    <h3 class="font-bold text-lg mb-2">${stop.stop_name}</h3>
                    <p class="text-sm mb-2">Megálló ID: ${stop.stop_id}</p>
                    ${stop.stop_desc ? `<p class="text-sm mb-2">${stop.stop_desc}</p>` : ''}
                    ${stopArrivals.length > 0 ? `
                        <div class="text-sm">
                        </div>
                    ` : ''}
                    <p class="text-xs mt-2">
                        Koordináták: ${position.lat.toFixed(6)}, ${position.lng.toFixed(6)}
                    </p>
                </div>
            `
        });

        marker.addListener('click', () => {
            infoWindows.forEach(w => w.close());
            infoWindow.open(map, marker);
        });

        markers.push(marker);
        infoWindows.push(infoWindow);
    });

    if (markersAdded > 0) {
        map.fitBounds(bounds);
        if (markersAdded === 1) {
            map.setZoom(15);
        }
    }

    updateInfoPanel(`
        <div class="bg-white p-4 rounded-lg shadow">
            <h4 class="font-bold text-lg mb-3">Találatok (${stops.length})</h4>
            <div class="max-h-96 overflow-y-auto">
                ${stops.map(stop => `
                    <div class="mb-3 p-3 bg-gray-50 rounded hover:bg-gray-100 cursor-pointer"
                         onclick="focusStop(${stop.stop_lat}, ${stop.stop_lon})">
                        <p class="font-bold">${stop.stop_name}</p>
                        <p class="text-sm text-gray-600">Megálló ID: ${stop.stop_id}</p>
                        ${stop.stop_desc ? `<p class="text-sm text-gray-500">${stop.stop_desc}</p>` : ''}
                    </div>
                `).join('')}
            </div>
        </div>
    `);
}

// Focus on a specific stop
function focusStop(lat, lng) {
    if (isNaN(lat) || isNaN(lng)) {
        console.error('Invalid coordinates:', { lat, lng });
        return;
    }
    map.setCenter({ lat: parseFloat(lat), lng: parseFloat(lng) });
    map.setZoom(16);
}

// Update info panel
function updateInfoPanel(content) {
    const infoPanel = document.getElementById('route-info');
    if (infoPanel) {
        infoPanel.innerHTML = content;
    }
}

// Clear existing markers
function clearMapMarkers() {
    markers.forEach(marker => marker.setMap(null));
    infoWindows.forEach(window => window.close());
    markers = [];
    infoWindows = [];
}

// Initialize everything when the page loads
document.addEventListener('DOMContentLoaded', () => {
    testGTFSDataAccess();
});
</script>

</body>
</html>